@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5>Category Details: {{ $dueCategory->name }}</h5>
    <a href="{{ route('due-categories.index') }}" class="btn btn-secondary">Back to Categories</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Category Name:</strong> {{ $dueCategory->name }}</p>
                <p><strong>Due Amount:</strong> TZS {{ number_format($dueCategory->due_amount, 2) }}</p>
                <p><strong>Description:</strong> {{ $dueCategory->description ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Created By:</strong> {{ $dueCategory->creator->name ?? 'N/A' }}</p>
                <p><strong>Created At:</strong> {{ $dueCategory->created_at->format('M d, Y H:i') }}</p>
                <p><strong>Last Updated By:</strong> {{ $dueCategory->updater->name ?? 'N/A' }}</p>
                <p><strong>Last Updated:</strong> {{ $dueCategory->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection