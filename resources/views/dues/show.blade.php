@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5>Contribution Details</h5>
    <div>
        <a href="{{ route('dues.edit', $contribution) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('dues.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Member:</strong> {{ $contribution->member->full_name }}</p>
                <p><strong>Category:</strong> {{ $contribution->category->name }}</p>
                <p><strong>Amount:</strong> TZS {{ number_format($contribution->amount, 2) }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Date:</strong> {{ $contribution->date->format('M d, Y') }}</p>
                <p><strong>Received By:</strong> {{ $contribution->receivedBy->name }}</p>
                <p><strong>Recorded On:</strong> {{ $contribution->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
        
        @if($contribution->description)
        <div class="row mt-3">
            <div class="col-12">
                <p><strong>Description:</strong></p>
                <p>{{ $contribution->description }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection