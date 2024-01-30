<!-- resources/views/admin/contact_us/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Contact Us Message - Details</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Email: {{ $message->sender_email }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">Title: {{ $message->title }}</h6>
                <p class="card-text">Body: {{ $message->body }}</p>

                <form action="{{ route('contact_us.admin_toggle_status', $message->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $message->status === 'open' ? 'btn-info' : 'btn-success' }}">
                        {{ $message->status === 'open' ? 'Close Message' : 'Reopen Message' }}
                    </button>
                </form>

                <a href="{{ route('contact_us.admin_index') }}" class="btn btn-danger mt-3">Back to Messages</a>
            </div>
        </div>
    </div>
@endsection
