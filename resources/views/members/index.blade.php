@extends('layout')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="m-0">Wanachama</h5>
  <a href="{{ route('members.create') }}" class="btn btn-primary">+ Sajili Mwanachama</a>
</div>
<form method="GET" class="row g-2 mb-3">
  <div class="col-md-3"><input class="form-control" name="name" placeholder="Tafuta jina..." value="{{ request('name') }}"></div>
  <div class="col-md-2"><select class="form-select" name="gender"><option value="">Jinsia</option><option value="male" @selected(request('gender')==='male')>Male</option><option value="female" @selected(request('gender')==='female')>Female</option></select></div>
  <div class="col-md-2"><select class="form-select" name="status"><option value="">Hali</option><option value="active" @selected(request('status')==='active')>Active</option><option value="inactive" @selected(request('status')==='inactive')>Inactive</option></select></div>
  <div class="col-md-2"><select class="form-select" name="diocese_id"><option value="">Jimbo</option>@foreach($dioceses as $d)<option value="{{ $d->id }}" @selected(request('diocese_id')==$d->id)>{{ $d->name }}</option>@endforeach</select></div>
  <div class="col-md-2"><select class="form-select" name="parish_id"><option value="">Parokia</option>@foreach($parishes as $p)<option value="{{ $p->id }}" @selected(request('parish_id')==$p->id)>{{ $p->name }}</option>@endforeach</select></div>
  <div class="col-md-2"><select class="form-select" name="scc_id"><option value="">Kigango</option>@foreach($sccs as $s)<option value="{{ $s->id }}" @selected(request('scc_id')==$s->id)>{{ $s->name }}</option>@endforeach</select></div>
  <div class="col-md-1"><button class="btn btn-outline-secondary w-100">Tafuta</button></div>
</form>
<table class="table table-striped table-bordered align-middle">
  <thead class="table-light"><tr><th>#</th><th>Jina</th><th>Jinsia</th><th>Hali</th><th>Kigango</th><th>Parokia</th><th>Jimbo</th><th></th></tr></thead>
  <tbody>
    @foreach($members as $m)
    <tr>
      <td>{{ $m->id }}</td>
      <td>{{ $m->full_name }}</td>
      <td class="text-capitalize">{{ $m->gender }}</td>
      <td class="text-capitalize">{{ $m->status }}</td>
      <td>{{ $m->scc->name ?? '-' }}</td>
      <td>{{ $m->parish->name ?? '-' }}</td>
      <td>{{ $m->diocese->name ?? '-' }}</td>
      <td class="text-end">
        <a href="{{ route('members.edit',$m) }}" class="btn btn-sm btn-warning">Edit</a>
        <form method="POST" action="{{ route('members.destroy',$m) }}" class="d-inline">@csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Futa?')">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $members->links() }}
@endsection
