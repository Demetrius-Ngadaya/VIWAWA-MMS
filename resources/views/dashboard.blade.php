@extends('layout')
@section('content')
<div class="row g-3">
  <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Jumla ya Wanachama</div><div class="fs-3 fw-bold">{{ $members }}</div></div></div></div>
  <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Ada (Mwezi huu)</div><div class="fs-3 fw-bold">{{ number_format($contributionsThisMonth,0) }}</div></div></div></div>
  <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Michango (Mwezi huu)</div><div class="fs-3 fw-bold">{{ number_format($contribThisMonth,0) }}</div></div></div></div>
  <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Matumizi (Mwezi huu)</div><div class="fs-3 fw-bold">{{ number_format($expensesThisMonth,0) }}</div></div></div></div>
</div>
@endsection