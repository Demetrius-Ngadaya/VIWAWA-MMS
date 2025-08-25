@extends('layouts.app')
@section('content')
<div class="container">
<h1 class="mb-4">VIWAWA Leadership Hierarchy</h1>
<ul class="list-group">
@foreach ($leaders as $leader)
<li class="list-group-item">
<strong>{{ $leader->position }}:</strong> {{ $leader->name }}
</li>
@endforeach
</ul>
</div>
@endsection