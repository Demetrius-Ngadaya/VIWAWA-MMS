@extends('layout')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-header fw-bold">Login</div>
      <div class="card-body">
        <form method="POST" action="{{ route('login.post') }}"> @csrf
          <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required></div>
          <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
          <button class="btn btn-primary w-100">Ingia</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection