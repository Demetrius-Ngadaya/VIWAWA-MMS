@extends('layout')

@section('content')
<h5>{{ isset($contribution) ? 'Edit' : 'Record New' }} Contribution</h5>

<form method="POST" action="{{ isset($contribution) ? route('contributions.update', $contribution) : route('contributions.store') }}" class="row g-3">
    @csrf
    @if(isset($contribution)) @method('PUT') @endif

    <div class="col-md-6">
        <label class="form-label">Member *</label>
        <select name="member_id" id="member_id" class="form-select" required>
            <option value="">Select Member</option>
            @foreach($members as $member)
                <option value="{{ $member->id }}" {{ old('member_id', $contribution->member_id ?? '') == $member->id ? 'selected' : '' }}>
                    {{ $member->full_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Category *</label>
        <select name="contribution_category_id" id="category_id" class="form-select" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" data-amount="{{ $category->contribution_amount }}" 
                    {{ old('contribution_category_id', $contribution->contribution_category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }} (TZS {{ number_format($category->contribution_amount, 2) }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Required Amount</label>
        <input type="text" id="required_amount" class="form-control" readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">Paid Amount *</label>
        <input type="number" name="paid_amount" id="paid_amount" step="0.01" class="form-control" 
               value="{{ old('paid_amount', $contribution->paid_amount ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Status</label>
        <input type="text" id="payment_status" class="form-control" readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">Contribution Date *</label>
        <input type="date" name="contributed_at" class="form-control" 
               value="{{ old('contributed_at', $contribution->contributed_at ?? date('Y-m-d')) }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Reference Number</label>
        <input type="text" name="reference" class="form-control" 
               value="{{ old('reference', $contribution->reference ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Total Paid (This Member)</label>
        <input type="text" id="total_paid" class="form-control" readonly>
    </div>

    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $contribution->notes ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">{{ isset($contribution) ? 'Update' : 'Save' }} Contribution</button>
        <a href="{{ route('contributions.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const memberSelect = document.getElementById('member_id');
    const categorySelect = document.getElementById('category_id');
    const paidAmountInput = document.getElementById('paid_amount');
    const requiredAmountInput = document.getElementById('required_amount');
    const paymentStatusInput = document.getElementById('payment_status');
    const totalPaidInput = document.getElementById('total_paid');

    function updatePaymentInfo() {
        const memberId = memberSelect.value;
        const categoryId = categorySelect.value;
        const paidAmount = parseFloat(paidAmountInput.value) || 0;
        
        if (categoryId) {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const requiredAmount = parseFloat(selectedOption.getAttribute('data-amount'));
            requiredAmountInput.value = 'TZS ' + requiredAmount.toLocaleString();
            
            if (paidAmount > 0) {
                if (paidAmount < requiredAmount) {
                    paymentStatusInput.value = 'Hajamaliza (Incomplete)';
                    paymentStatusInput.className = 'form-control bg-warning text-white';
                } else if (paidAmount > requiredAmount) {
                    paymentStatusInput.value = 'Amemaliza (Exceeded)';
                    paymentStatusInput.className = 'form-control bg-success text-white';
                } else {
                    paymentStatusInput.value = 'Amemaliza (Complete)';
                    paymentStatusInput.className = 'form-control bg-success text-white';
                }
            } else {
                paymentStatusInput.value = '';
                paymentStatusInput.className = 'form-control';
            }
        } else {
            requiredAmountInput.value = '';
            paymentStatusInput.value = '';
            paymentStatusInput.className = 'form-control';
        }

        // Fetch total paid amount for this member and category
        if (memberId && categoryId) {
            fetch(`/contributions/member-summary/${memberId}/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    totalPaidInput.value = 'TZS ' + data.total_paid.toLocaleString();
                });
        } else {
            totalPaidInput.value = '';
        }
    }

    memberSelect.addEventListener('change', updatePaymentInfo);
    categorySelect.addEventListener('change', updatePaymentInfo);
    paidAmountInput.addEventListener('input', updatePaymentInfo);

    // Initial update
    updatePaymentInfo();
});
</script>
@endsection