@extends('layouts.app')
@section('content')
<div class="container">
<h1 class="mb-4">Contributions</h1>
<div class="mb-3">
<a href="{{ route('contributions.create') }}" class="btn btn-primary">Add New Contribution</a>
</div>
<table class="table table-bordered">
<thead>
<tr>
<th>#</th>
<th>Contributor</th>
<th>Amount</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@foreach ($contributions as $contribution)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $contribution->member->name }}</td>
<td>{{ $contribution->amount }}</td>
<td>{{ $contribution->created_at->format('Y-m-d') }}</td>
<td>
<a href="{{ route('contributions.edit', $contribution->id) }}" class="btn btn-sm btn-warning">Edit</a>
<form action="{{ route('contributions.destroy', $contribution->id) }}" method="POST" style="display:inline-block;">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $contributions->links() }}
</div>
@endsection