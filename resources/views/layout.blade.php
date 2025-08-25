<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name','VIWAWA') }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light border-bottom mb-3">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/dashboard">VIWAWA</a>
    @auth
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item"><a class="nav-link" href="/members">Wanachama</a></li>
      <li class="nav-item"><a class="nav-link" href="/dues">Ada</a></li>
      <li class="nav-item"><a class="nav-link" href="/contributions">Michango</a></li>
      <li class="nav-item"><a class="nav-link" href="/contribution-categories">Aina za Michango</a></li>
      <li class="nav-item"><a class="nav-link" href="/expenses">Matumizi</a></li>
      <li class="nav-item"><a class="nav-link" href="/reports">Ripoti</a></li>
    </ul>
    <form method="POST" action="{{ route('logout') }}">@csrf <button class="btn btn-outline-danger">Logout</button></form>
    @endauth
  </div>
</nav>
<div class="container"> @if(session('ok'))<div class="alert alert-success">{{ session('ok') }}</div>@endif @yield('content') </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>