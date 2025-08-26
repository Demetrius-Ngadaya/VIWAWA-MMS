@extends('layout')

@section('content')
<h5>{{ isset($contribution) ? 'Edit' : 'Record New' }} Contribution</h5>

<form method="POST" action="{{ isset($contribution) ? route('dues.update', $contribution) : route('dues.store') }}" class="row g-3">
    @csrf
    @if(isset($contribution)) @method('PUT') @endif

    <div class="col-md-6">
        <label class="form-label">Member *</label>
        <select name="member_id" class="form-select" required>
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
        <select name="contribution_category_id" class="form-select" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('contribution_category_id', $contribution->contribution_category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Amount *</label>
        <input type="number" name="amount" step="0.01" class="form-control" value="{{ old('amount', $contribution->amount ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Date *</label>
        <input type="date" name="date" class="form-control" value="{{ old('date', $contribution->date ?? date('Y-m-d')) }}" required>
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $contribution->description ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">{{ isset($contribution) ? 'Update' : 'Save' }} Contribution</button>
        <a href="{{ route('dues.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection