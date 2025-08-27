@extends('layout')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="m-0">Taarifa za Mwanachama: {{ $member->full_name }}</h5>
  <div>
    <a href="{{ route('members.edit', $member) }}" class="btn btn-warning">Hariri</a>
    <a href="{{ route('members.index') }}" class="btn btn-secondary">← Rudi</a>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <h6>Taarifa za Msingi</h6>
        <table class="table table-sm">
          <tr>
            <th width="40%">Jina Kamili:</th>
            <td>{{ $member->full_name }}</td>
          </tr>
          <tr>
            <th>Jinsia:</th>
            <td class="text-capitalize">{{ $member->gender }}</td>
          </tr>
          <tr>
            <th>Tarehe ya Kuzaliwa:</th>
            <td>{{ $member->birthdate ? $member->birthdate->format('d/m/Y') : 'Haijawekwa' }}</td>
          </tr>
          <tr>
            <th>Umri:</th>
            <td>{{ $member->birthdate ? $member->birthdate->age . ' years' : 'Haijawekwa' }}</td>
          </tr>
          <tr>
            <th>Hali:</th>
            <td class="text-capitalize">{{ $member->status }}</td>
          </tr>
          <tr>
            <th>Cheo:</th>
            <td>{{ $member->position ?? 'Haijawekwa' }}</td>
          </tr>
        </table>
      </div>
      
      <div class="col-md-6">
        <h6>Eneo la Huduma</h6>
        <table class="table table-sm">
          <tr>
            <th width="40%">Kigango (SCC):</th>
            <td>{{ $member->scc->name ?? 'Haijawekwa' }}</td>
          </tr>
          <tr>
            <th>Parokia:</th>
            <td>{{ $member->parish->name ?? 'Haijawekwa' }}</td>
          </tr>
          <tr>
            <th>Jimbo:</th>
            <td>{{ $member->diocese->name ?? 'Haijawekwa' }}</td>
          </tr>
          <tr>
            <th>Barua Pepe:</th>
            <td>{{ $member->user->email ?? 'Haijawekwa' }}</td>
          </tr>
          <tr>
            <th>Imeundwa:</th>
            <td>{{ $member->created_at->format('d/m/Y H:i') }}</td>
          </tr>
          <tr>
            <th>Imesasishwa:</th>
            <td>{{ $member->updated_at->format('d/m/Y H:i') }}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Delete Button -->
<div class="mt-3 text-end">
  <form method="POST" action="{{ route('members.destroy', $member) }}" class="d-inline">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger" onclick="return confirm('Una uhakika unataka kumfuta mwanachama huyu? Hatua hii haiwezi kutenduliwa.')">
      Futa Mwanachama
    </button>
  </form>
</div>
@endsection