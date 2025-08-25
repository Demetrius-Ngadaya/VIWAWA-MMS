@extends('layout')

@section('content')
<div class="container">
    <h1>Add Diocese</h1>
    <form action="{{ route('dioceses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Diocese Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Bishop</label>
            <input type="text" name="bishop" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Region</label>
            <input type="text" name="region" class="form-control">
        </div>
        <button class="btn btn-success">Save</button>
        <a href="{{ route('dioceses.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
