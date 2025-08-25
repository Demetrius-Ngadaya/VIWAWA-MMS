@extends('layout')

@section('content')
<div class="container">
    <h1>SCC Details</h1>

    <p><strong>Name:</strong> {{ $scc->name }}</p>
    <p><strong>Parish:</strong> {{ $scc->parish->name ?? 'N/A' }}</p>

    <a href="{{ route('sccs.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
