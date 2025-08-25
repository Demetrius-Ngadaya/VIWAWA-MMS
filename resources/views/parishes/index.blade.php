@extends('layout')

@section('content')
<div class="container">
    <h1>Parishes</h1>

    <a href="{{ route('parishes.create') }}" class="btn btn-primary mb-3">Add Parish</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Parish Name</th>
                <th>Diocese</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parishes as $parish)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $parish->name }}</td>
                    <td>{{ $parish->diocese->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('parishes.show', $parish) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('parishes.edit', $parish) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('parishes.destroy', $parish) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
