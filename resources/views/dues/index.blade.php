@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5>Manage Due Payments</h5>
    <a href="{{ route('dues.create') }}" class="btn btn-primary">Record New Due Payment</a>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Member</label>
                <select name="member_id" class="form-select">
                    <option value="">All Members</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ request('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="hajamaliza" {{ request('status') == 'hajamaliza' ? 'selected' : '' }}>Hajamaliza</option>
                    <option value="amemaliza" {{ request('status') == 'amemaliza' ? 'selected' : '' }}>Amemaliza</option>
                    <option value="incomplete" {{ request('status') == 'incomplete' ? 'selected' : '' }}>Incomplete</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">From Date</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">To Date</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Due Payments Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Member</th>
                        <th>Category</th>
                        <th>Paid Amount</th>
                        <th>Status</th>
                        <th>Remaining</th>
                        <th>Exceeded</th>
                        <th>Recorded By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($duesPayments as $payment)
                    <tr>
                        <td>{{ $payment->paid_at->format('M d, Y') }}</td>
                        <td>{{ $payment->member->full_name }}</td>
                        <td>{{ $payment->category->name }}</td>
                        <td>TZS {{ number_format($payment->paid_amount, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $payment->status == 'amemaliza' ? 'success' : ($payment->status == 'hajamaliza' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>TZS {{ number_format($payment->remaining_amount, 2) }}</td>
                        <td>TZS {{ number_format($payment->exceeded_amount, 2) }}</td>
                        <td>{{ $payment->recordedBy->name }}</td>
                        <td>
                            <a href="{{ route('dues.show', $payment) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('dues.edit', $payment) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('dues.destroy', $payment) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $duesPayments->links() }}
    </div>
</div>
@endsection