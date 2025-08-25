@extends('layout')

@section('content')
<div class="container">
    <h1>Add Parish</h1>

    <form action="{{ route('parishes.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Parish Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="diocese_id">Select Diocese</label>
            <select name="diocese_id" class="form-control" required>
                <option value="">-- Select Diocese --</option>
                @foreach ($dioceses as $diocese)
                    <option value="{{ $diocese->id }}">{{ $diocese->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Parish</button>
    </form>
</div>
@endsection
