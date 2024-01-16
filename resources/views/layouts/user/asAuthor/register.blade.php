<!-- resources/views/layouts/user/asAuthor/register.blade.php -->
<form method="POST" action="{{ route('author.register') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group row mt-3">
        <label for="nickname" class="col-md-4 col-form-label text-md-right">{{ __('Nickname como autor') }}  <i class="bi bi-pencil-square"></i></label>
        <div class="col-md-6 row">
            <input id="nickname" type="text"  class="form-control " name="nickname"
                value="{{ Auth::user()->nickname }}" required autofocus>

        </div>
    </div>

    <div class="form-group row mt-3">
        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }} <i class="bi bi-slash-square"></i></label>
        <div class="col-md-6">
            <input id="name" type="text" readonly class="form-control" name="name"
                value="{{ Auth::user()->name }}" required>

        </div>
    </div>

    <div class="form-group row mt-3">
        <label for="surnames" class="col-md-4 col-form-label text-md-right">{{ __('Apellidos') }}  <i class="bi bi-slash-square"></i></label>
        <div class="col-md-6">
            <input id="surnames" type="text" readonly class="form-control" name="surnames"
                value="{{ Auth::user()->surnames }}" required>

        </div>
    </div>

    <div class="form-group row mt-3">
        <label for="birth_at" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de nacimiento') }} <i class="bi bi-slash-square"></i></label>
        <div class="col-md-6">
            <input id="birth_at" type="date" class="form-control" name="birth_at"
                value="{{ old('birth_at', \Carbon\Carbon::parse(Auth::user()->birth_date)->format('Y-m-d')) }}"
                required>

        </div>
    </div>

    <div class="form-group row mt-3">

        <label for="country_id" class="col-md-4 col-form-label text-md-right">{{ __('Pais') }}  <i class="bi bi-slash-square"></i></label>
        <div class="col-md-6">
            <input id="country_id" type="text" readonly value="{{ Auth::user()->country->country_name }}"
                class="form-control">
            </div>
    </div>

    <div class="form-group row mt-3">
        <label for="biography" class="col-md-4 col-form-label text-md-right">{{ __('Biografía') }} <i class="bi bi-pencil-square"></i></label>
        <div class="col-md-6">
            <textarea id="biography" class="form-control" name="biography" required>{{ old('biography') }}</textarea>
        </div>
    </div>

    <div class="form-group row mt-3">
        <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Foto') }} <i class="bi bi-pencil-square"></i></label>
        <div class="col-md-6">
            <input id="photo" type="file" class="form-control" name="photo">
        </div>
    </div>

    <div class="form-group row mt-3 mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Register as Author') }}
            </button>
        </div>
    </div>
</form>
