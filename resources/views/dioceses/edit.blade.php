@extends('layout')

@section('content')
<div class="container">
    <h1>Edit Diocese</h1>
    <form action="{{ route('dioceses.update', $diocese) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Diocese Name</label>
            <input type="text" name="name" value="{{ $diocese->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Bishop</label>
            <input type="text" name="bishop" value="{{ $diocese->bishop }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Region</label>
            <input type="text" name="region" value="{{ $diocese->region }}" class="form-control">
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('dioceses.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
