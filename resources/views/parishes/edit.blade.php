@extends('layout')

@section('content')
<div class="container">
    <h1>Edit Parish</h1>

    <form action="{{ route('parishes.update', $parish) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Parish Name</label>
            <input type="text" name="name" class="form-control" value="{{ $parish->name }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="diocese_id">Select Diocese</label>
            <select name="diocese_id" class="form-control" required>
                @foreach ($dioceses as $diocese)
                    <option value="{{ $diocese->id }}" {{ $parish->diocese_id == $diocese->id ? 'selected' : '' }}>
                        {{ $diocese->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Parish</button>
    </form>
</div>
@endsection
