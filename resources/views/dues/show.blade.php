@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5>Due Payment Details</h5>
    <div>
        <a href="{{ route('dues.edit', $duesPayment) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('dues.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Member:</strong> {{ $duesPayment->member->full_name }}</p>
                <p><strong>Category:</strong> {{ $duesPayment->category->name }}</p>
                <p><strong>Required Amount:</strong> TZS {{ number_format($duesPayment->category->due_amount, 2) }}</p>
                <p><strong>Paid Amount:</strong> TZS {{ number_format($duesPayment->paid_amount, 2) }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $duesPayment->status == 'amemaliza' ? 'success' : ($duesPayment->status == 'hajamaliza' ? 'warning' : 'secondary') }}">
                        {{ ucfirst($duesPayment->status) }}
                    </span>
                </p>
                <p><strong>Remaining Amount:</strong> TZS {{ number_format($duesPayment->remaining_amount, 2) }}</p>
                <p><strong>Exceeded Amount:</strong> TZS {{ number_format($duesPayment->exceeded_amount, 2) }}</p>
                <p><strong>Payment Date:</strong> {{ $duesPayment->paid_at->format('M d, Y') }}</p>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <p><strong>Reference:</strong> {{ $duesPayment->reference ?? 'N/A' }}</p>
                <p><strong>Recorded By:</strong> {{ $duesPayment->recordedBy->name }}</p>
                <p><strong>Created At:</strong> {{ $duesPayment->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div class="col-md-6">
                @if($duesPayment->updated_by)
                    <p><strong>Last Updated By:</strong> {{ $duesPayment->updatedBy->name }}</p>
                    <p><strong>Last Updated:</strong> {{ $duesPayment->updated_at->format('M d, Y H:i') }}</p>
                @endif
                <p><strong>Notes:</strong> {{ $duesPayment->notes ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection