@extends('layout')

@section('content')
<div class="container">
    <h1>Parish Details</h1>

    <p><strong>Name:</strong> {{ $parish->name }}</p>
    <p><strong>Diocese:</strong> {{ $parish->diocese->name ?? 'N/A' }}</p>

    <a href="{{ route('parishes.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
