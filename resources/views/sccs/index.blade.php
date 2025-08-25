@extends('layout')

@section('content')
<div class="container">
    <h1>Small Christian Communities (SCCs)</h1>

    <a href="{{ route('sccs.create') }}" class="btn btn-primary mb-3">Add SCC</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>SCC Name</th>
                <th>Parish</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sccs as $scc)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $scc->name }}</td>
                    <td>{{ $scc->parish->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('sccs.show', $scc) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('sccs.edit', $scc) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('sccs.destroy', $scc) }}" method="POST" style="display:inline-block;">
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
