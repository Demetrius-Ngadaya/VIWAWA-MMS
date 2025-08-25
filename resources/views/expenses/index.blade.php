@extends('layout')
@section('content')
<div class="container">
<h1 class="mb-4">Expenses</h1>
<div class="mb-3">
<a href="{{ route('expenses.create') }}" class="btn btn-primary">Add New Expense</a>
</div>
<table class="table table-bordered">
<thead>
<tr>
<th>#</th>
<th>Description</th>
<th>Amount</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@foreach ($expenses as $expense)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $expense->description }}</td>
<td>{{ $expense->amount }}</td>
<td>{{ $expense->created_at->format('Y-m-d') }}</td>
<td>
<a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-warning">Edit</a>
<form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline-block;">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $expenses->links() }}
</div>
@endsection