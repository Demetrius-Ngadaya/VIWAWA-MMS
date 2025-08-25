@extends('layout')

@section('content')
<div class="container">
    <h1>Dioceses</h1>
    <a href="{{ route('dioceses.create') }}" class="btn btn-primary mb-3">Add Diocese</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Diocese Name</th>
                <th>Bishop</th>
                <th>Region</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dioceses as $diocese)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $diocese->name }}</td>
                <td>{{ $diocese->bishop }}</td>
                <td>{{ $diocese->region }}</td>
                <td>
                    <a href="{{ route('dioceses.show', $diocese) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('dioceses.edit', $diocese) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('dioceses.destroy', $diocese) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this Diocese?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">No Dioceses Found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
