@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5>Contribution Details</h5>
    <div>
        <a href="{{ route('contributions.edit', $contribution) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('contributions.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Member:</strong> {{ $contribution->member->full_name }}</p>
                <p><strong>Category:</strong> {{ $contribution->category->name }}</p>
                <p><strong>Required Amount:</strong> TZS {{ number_format($contribution->category->contribution_amount, 2) }}</p>
                <p><strong>Paid Amount:</strong> TZS {{ number_format($contribution->paid_amount, 2) }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $contribution->status == 'amemaliza' ? 'success' : ($contribution->status == 'hajamaliza' ? 'warning' : 'secondary') }}">
                        {{ ucfirst($contribution->status) }}
                    </span>
                </p>
                <p><strong>Remaining Amount:</strong> TZS {{ number_format($contribution->remaining_amount, 2) }}</p>
                <p><strong>Exceeded Amount:</strong> TZS {{ number_format($contribution->exceeded_amount, 2) }}</p>
                <p><strong>Contribution Date:</strong> {{ $contribution->contributed_at->format('M d, Y') }}</p>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <p><strong>Reference:</strong> {{ $contribution->reference ?? 'N/A' }}</p>
                <p><strong>Recorded By:</strong> {{ $contribution->recordedBy->name }}</p>
                <p><strong>Created At:</strong> {{ $contribution->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div class="col-md-6">
                @if($contribution->updated_by)
                    <p><strong>Last Updated By:</strong> {{ $contribution->updatedBy->name }}</p>
                    <p><strong>Last Updated:</strong> {{ $contribution->updated_at->format('M d, Y H:i') }}</p>
                @endif
                <p><strong>Notes:</strong> {{ $contribution->notes ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection