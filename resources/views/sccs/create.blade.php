@extends('layout')

@section('content')
<div class="container">
    <h1>Add SCC</h1>

    <form action="{{ route('sccs.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="name">SCC Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="parish_id">Select Parish</label>
            <select name="parish_id" class="form-control" required>
                <option value="">-- Select Parish --</option>
                @foreach ($parishes as $parish)
                    <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save SCC</button>
    </form>
</div>
@endsection
