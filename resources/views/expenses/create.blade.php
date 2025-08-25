@extends('layout') 
@section('content')
<div class="container">
    <h1>Add New Expense</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf

        <div>
            <label for="category">Category</label><br>
            <input type="text" name="category" id="category" value="{{ old('category') }}" required>
        </div><br>

        <div>
            <label for="amount">Amount</label><br>
            <input type="number" name="amount" id="amount" step="0.01" value="{{ old('amount') }}" required>
        </div><br>

        <div>
            <label for="spent_at">Date Spent</label><br>
            <input type="date" name="spent_at" id="spent_at" value="{{ old('spent_at', now()->toDateString()) }}" required>
        </div><br>

        <div>
            <label for="description">Description (optional)</label><br>
            <textarea name="description" id="description">{{ old('description') }}</textarea>
        </div><br>

        <button type="submit">Save Expense</button>
    </form>
</div>
@endsection
