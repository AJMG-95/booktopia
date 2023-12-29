{{-- resources/views/layouts/user/editions/pdf.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid pdf-container">
        <embed src="{{ asset('assets/editions/' . $filename) }}" type="application/pdf" width="100%" height="700vh" class="mt-4"/>
    </div>
@endsection
