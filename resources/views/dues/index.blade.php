@extends('layout')
@section('content')
<div class="container">
<h1 class="mb-4">Member Dues</h1>
<div class="mb-3">
<a href="{{ route('dues.create') }}" class="btn btn-primary">Add New Due</a>
</div>
<form method="GET" action="{{ route('dues.index') }}" class="mb-3">
<div class="row">
<div class="col-md-4">
<input type="text" name="search" class="form-control" placeholder="Search by Member Name" value="{{ request('search') }}">
</div>
<div class="col-md-2">
<button type="submit" class="btn btn-secondary">Filter</button>
</div>
</div>
</form>
<table class="table table-bordered">
<thead>
<tr>
<th>#</th>
<th>Member</th>
<th>Amount</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@foreach ($dues as $due)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $due->member->name }}</td>
<td>{{ $due->amount }}</td>
<td>{{ $due->created_at->format('Y-m-d') }}</td>
<td>
<a href="{{ route('dues.edit', $due->id) }}" class="btn btn-sm btn-warning">Edit</a>
<form action="{{ route('dues.destroy', $due->id) }}" method="POST" style="display:inline-block;">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $dues->links() }}
</div>
@endsection

