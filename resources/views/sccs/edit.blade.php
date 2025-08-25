@extends('layout')

@section('content')
<div class="container">
    <h1>Edit SCC</h1>

    <form action="{{ route('sccs.update', $scc) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">SCC Name</label>
            <input type="text" name="name" class="form-control" value="{{ $scc->name }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="parish_id">Select Parish</label>
            <select name="parish_id" class="form-control" required>
                @foreach ($parishes as $parish)
                    <option value="{{ $parish->id }}" {{ $scc->parish_id == $parish->id ? 'selected' : '' }}>
                        {{ $parish->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update SCC</button>
    </form>
</div>
@endsection
