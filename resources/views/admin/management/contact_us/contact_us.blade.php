<!-- resources/views/admin/contact_us/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Contact Us Messages - Admin View</h2>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Email</th>
                    <th>Asunto</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                    <tr>
                        <td class="text-center">{{ $message->id }}</td>
                        <td>{{ $message->sender_email }}</td>
                        <td>{{ $message->title }}</td>
                        <td>
                            <a href="{{ route('contact_us.admin_show', $message->id) }}" class="btn btn-primary">View</a>
                            <form action="{{ route('contact_us.admin_toggle_status', $message->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $message->status === 'open' ? 'btn-info' : 'btn-success' }}">
                                    {{ $message->status === 'open' ? 'Close Message' : 'Reopen Message' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
