<!-- resources/views/admin/management/users/userList.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User Management</h2>

    <!-- Mostrar mensajes de éxito o error aquí -->

    <div class="mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-success">Create User</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{-- <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a> --}}
                        <a href="{{ route('users.promote', $user->id) }}" class="btn btn-info">Promote to Subadmin</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
