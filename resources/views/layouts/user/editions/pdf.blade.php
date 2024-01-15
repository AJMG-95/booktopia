{{-- resources/views/layouts/user/editions/pdf.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <embed src="{{ asset('storage/' . $filename) }}" type="application/pdf" width="100%" height="700vh" class="mt-4"/>
    </div>
@endsection
