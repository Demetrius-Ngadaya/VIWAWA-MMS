@extends('layout')
@section('content')
<h5>Sajili Mwanachama</h5>
<form method="POST" action="{{ route('members.store') }}" class="row g-3">
  @csrf
  <div class="col-md-4"><label class="form-label">Jina la Kwanza</label><input name="first_name" class="form-control" required></div>
  <div class="col-md-4"><label class="form-label">Jina la Kati</label><input name="middle_name" class="form-control"></div>
  <div class="col-md-4"><label class="form-label">Jina la Mwisho</label><input name="last_name" class="form-control" required></div>
  <div class="col-md-3"><label class="form-label">Jinsia</label><select name="gender" class="form-select" required><option value="male">Male</option><option value="female">Female</option></select></div>
  <div class="col-md-3"><label class="form-label">Tarehe ya Kuzaliwa</label><input type="date" name="birthdate" class="form-control"></div>
  <div class="col-md-3"><label class="form-label">Hali</label><select name="status" class="form-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
  <div class="col-md-4"><label class="form-label">Jimbo</label><select name="diocese_id" class="form-select" required>@foreach($dioceses as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach</select></div>
  <div class="col-md-4"><label class="form-label">Parokia</label><select name="parish_id" class="form-select" required>@foreach($parishes as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select></div>
  <div class="col-md-4"><label class="form-label">Kigango</label><select name="scc_id" class="form-select" required>@foreach($sccs as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach</select></div>
  <div class="col-md-4"><label class="form-label">Cheo (ndani ya VIWAWA)</label><input name="position" class="form-control"></div>
  <div class="col-md-4"><label class="form-label">Barua Pepe (kwa login)</label><input type="email" name="email" class="form-control" required></div>
  <div class="col-md-4"><label class="form-label">Nenosiri la Mwanachama</label><input type="password" name="password" class="form-control" required></div>
  <div class="col-12"><button class="btn btn-primary">Hifadhi</button></div>
</form>
@endsection