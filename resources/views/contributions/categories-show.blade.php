@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5>Category Details: {{ $contributionCategory->name }}</h5>
    <a href="{{ route('contribution-categories.index') }}" class="btn btn-secondary">Back to Categories</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Category Name:</strong> {{ $contributionCategory->name }}</p>
                <p><strong>Contribution Amount:</strong> TZS {{ number_format($contributionCategory->contribution_amount, 2) }}</p>
                <p><strong>Description:</strong> {{ $contributionCategory->description ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Created By:</strong> {{ $contributionCategory->creator->name ?? 'N/A' }}</p>
                <p><strong>Created At:</strong> {{ $contributionCategory->created_at->format('M d, Y H:i') }}</p>
                <p><strong>Last Updated By:</strong> {{ $contributionCategory->updater->name ?? 'N/A' }}</p>
                <p><strong>Last Updated:</strong> {{ $contributionCategory->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection