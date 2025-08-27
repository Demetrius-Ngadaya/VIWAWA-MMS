@extends('layout')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="m-0">Hariri Mwanachama: {{ $member->full_name }}</h5>
  <a href="{{ route('members.index') }}" class="btn btn-secondary">← Rudi</a>
</div>

@if($errors->any())
<div class="alert alert-danger">
  <ul class="mb-0">
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<form method="POST" action="{{ route('members.update', $member) }}" class="row g-3">
  @csrf
  @method('PUT')
  
  <div class="col-md-4">
    <label class="form-label">Jina la Kwanza *</label>
    <input name="first_name" class="form-control" value="{{ old('first_name', $member->first_name) }}" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Jina la Kati</label>
    <input name="middle_name" class="form-control" value="{{ old('middle_name', $member->middle_name) }}">
  </div>
  <div class="col-md-4">
    <label class="form-label">Jina la Mwisho *</label>
    <input name="last_name" class="form-control" value="{{ old('last_name', $member->last_name) }}" required>
  </div>
  
  <div class="col-md-3">
    <label class="form-label">Jinsia *</label>
    <select name="gender" class="form-select" required>
      <option value="">Chagua jinsia</option>
      <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Male</option>
      <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Female</option>
    </select>
  </div>
  
  <div class="col-md-3">
    <label class="form-label">Tarehe ya Kuzaliwa</label>
    <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $member->birthdate ? $member->birthdate->format('Y-m-d') : '') }}">
  </div>
  
  <div class="col-md-3">
    <label class="form-label">Hali *</label>
    <select name="status" class="form-select" required>
      <option value="">Chagua hali</option>
      <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Active</option>
      <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
  </div>
  
  <div class="col-md-3">
    <label class="form-label">Cheo (ndani ya VIWAWA)</label>
    <input name="position" class="form-control" value="{{ old('position', $member->position) }}">
  </div>
  
  <div class="col-md-4">
    <label class="form-label">Jimbo *</label>
    <select name="diocese_id" class="form-select" required>
      <option value="">Chagua jimbo</option>
      @foreach($dioceses as $d)
        <option value="{{ $d->id }}" {{ old('diocese_id', $member->diocese_id) == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
      @endforeach
    </select>
  </div>
  
  <div class="col-md-4">
    <label class="form-label">Parokia *</label>
    <select name="parish_id" class="form-select" required>
      <option value="">Chagua parokia</option>
      @foreach($parishes as $p)
        <option value="{{ $p->id }}" {{ old('parish_id', $member->parish_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
      @endforeach
    </select>
  </div>
  
  <div class="col-md-4">
    <label class="form-label">Kigango *</label>
    <select name="scc_id" class="form-select" required>
      <option value="">Chagua kigango</option>
      @foreach($sccs as $s)
        <option value="{{ $s->id }}" {{ old('scc_id', $member->scc_id) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
      @endforeach
    </select>
  </div>
  
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Hifadhi Mabadiliko</button>
    <a href="{{ route('members.index') }}" class="btn btn-secondary">Ghairi</a>
  </div>
</form>
@endsection