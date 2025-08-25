@extends('layout')

@section('content')
<div class="container">
    <h1>Diocese Details</h1>
    <p><strong>Name:</strong> {{ $diocese->name }}</p>
    <p><strong>Bishop:</strong> {{ $diocese->bishop }}</p>
    <p><strong>Region:</strong> {{ $diocese->region }}</p>

    <a href="{{ route('dioceses.index') }}" class="btn btn-secondary">Back</a>
    <a href="{{ route('dioceses.edit', $diocese) }}" class="btn btn-warning">Edit</a>
</div>
@endsection
