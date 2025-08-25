@extends('layouts.app')
@section('content')
<div class="container">
<h1 class="mb-4">Reports</h1>
<div class="row">
<div class="col-md-4">
<div class="card">
<div class="card-body">
<h5>Total Members</h5>
<p>{{ $totalMembers }}</p>
</div>
</div>
</div>
<div class="col-md-4">
<div class="card">
<div class="card-body">
<h5>Total Contributions</h5>
<p>{{ $totalContributions }}</p>
</div>
</div>
</div>
<div class="col-md-4">
<div class="card">
<div class="card-body">
<h5>Total Expenses</h5>
<p>{{ $totalExpenses }}</p>
</div>
</div>
</div>
</div>
<div class="mt-4">
<h3>Balance: {{ $balance }}</h3>
</div>
</div>
@endsection