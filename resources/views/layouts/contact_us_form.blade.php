<!-- resources/views/layouts/contact_us_form.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-3 py-3 mt-2 ">
        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh"
                    class="img-fluid">
                <ins>
                    Contacte con nosotros
                </ins>
            </h1>
        </div>

        <div class="w-100 d-flex justify-content-center">
            <form action="{{ route('contact_us.store') }}" method="post"
                class="w-50 p-4 border border-black rounded bg-white">
                @csrf
                <div class="mb-3">
                    <label for="sender_email" class="form-label">Email:</label>
                    <input type="email" class="form-control border border-black rounded" name="sender_email" required>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" class="form-control border border-black rounded" name="title" required>
                </div>

                <div class="">
                    <label for="body" class="form-label">Body:</label>
                    <textarea class="form-control border border-black rounded" name="body" rows="4" required></textarea>
                </div>


                <div class="form-group row mb-3 ms-0 me-0 text-center">
                    <div class="col-md-6 text-center">
                        <button type="submit" class="btn btn-primary mt-3">{{ __('Enviar') }}</button>
                    </div>
                    <div class="col-md-6 text-center">
                        <a href="{{ route('welcome') }}" class="btn btn-danger mt-3">
                            {{ __('Cancelar') }}
                        </a>
                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection
