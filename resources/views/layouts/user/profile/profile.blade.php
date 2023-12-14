<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    @extends('layouts.app')

    @section('content')
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header row">
                            <p class="col-11">{{ $user->nickname ? $user->nickname : 'Mi Perfil' }}</p>
                            <p class="col-1 text-right">{{ $user->strikes ? 'Strikes: ' . $user->strikes : 'pepe    ' }}</p>
                        </div>

                        <div class="card-body">
                            <div class="text-center mb-4">
                                @if (isset($editing) && $editing && $field == 'profile_img')
                                    <input type="file" name="profile_img" accept="image/*" class="form-control" required>
                                @else
                                    <img src="{{ asset('images/profile/' . $user->profile_img) }}" alt="Profile Image"
                                        class="img-fluid rounded-circle" style="max-width: 150px;">
                                @endif

                                @if (!isset($editing) || !$editing || $field != 'profile_img')
                                    <a href="{{ route('user.edit', ['field' => 'profile_img']) }}"
                                        class="btn btn-link">Editar
                                        Imagen de Perfil</a>
                                @else
                                    <button type="submit" class="btn btn-primary"
                                        form="editForm-{{ $field }}">Guardar</button>
                                    <a href="{{ route('user.show') }}" class="btn btn-secondary btn-cancel"
                                        data-field="profile_img">Cancelar</a>
                                @endif
                            </div>

                            <h2 class="text-center mb-3">{{ $user->name }} {{ $user->surnames }}</h2>

                            <div class="mb-3">
                                <strong>Email:</strong>
                                @if (isset($editing) && $editing && $field == 'email')
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                                        required>
                                @else
                                    {{ $user->email }}
                                @endif
                                @if (!isset($editing) || !$editing || $field != 'email')
                                    <a href="{{ route('user.edit', ['field' => 'email']) }}" class="btn btn-link">Editar
                                        Email</a>
                                @else
                                    <button type="submit" class="btn btn-primary"
                                        form="editForm-{{ $field }}">Guardar</button>
                                    <a href="{{ route('user.show') }}" class="btn btn-secondary btn-cancel"
                                        data-field="email">Cancelar</a>
                                @endif
                            </div>

                            <div class="mb-3">
                                <strong>Nickname:</strong>
                                @if (isset($editing) && $editing && $field == 'nickname')
                                    <input type="text" name="nickname" value="{{ $user->nickname }}"
                                        class="form-control" required>
                                @else
                                    {{ $user->nickname }}
                                @endif
                                @if (!isset($editing) || !$editing || $field != 'nickname')
                                    <a href="{{ route('user.edit', ['field' => 'nickname']) }}" class="btn btn-link">Editar
                                        Nickname</a>
                                @else
                                    <button type="submit" class="btn btn-primary"
                                        form="editForm-{{ $field }}">Guardar</button>
                                    <a href="{{ route('user.show') }}" class="btn btn-secondary btn-cancel"
                                        data-field="nickname">Cancelar</a>
                                @endif
                            </div>

                            <div class="mb-3">
                                <strong>Biografía:</strong>
                                @if (isset($editing) && $editing && $field == 'biography')
                                    <textarea name="biography" class="form-control" required>{{ $user->biography }}</textarea>
                                @else
                                    {{ $user->biography ?? 'N/A' }}
                                @endif
                                @if (!isset($editing) || !$editing || $field != 'biography')
                                    <a href="{{ route('user.edit', ['field' => 'biography']) }}"
                                        class="btn btn-link">Editar
                                        Biografía</a>
                                @else
                                    <button type="submit" class="btn btn-primary"
                                        form="editForm-{{ $field }}">Guardar</button>
                                    <a href="{{ route('user.show') }}" class="btn btn-secondary btn-cancel"
                                        data-field="biography">Cancelar</a>
                                @endif
                            </div>

                            <div class="mb-3">
                                <strong>Fecha de Nacimiento:</strong> {{ $user->birth_date ?? 'N/A' }}
                            </div>

                            <div class="mb-3">
                                <strong>País:</strong>
                                @if (isset($editing) && $editing && $field == 'country')
                                    <input type="text" name="country" value="{{ $user->country->name ?? 'N/A' }}"
                                        class="form-control" required>
                                @else
                                    {{ $user->country->name ?? 'N/A' }}
                                @endif
                                @if (!isset($editing) || !$editing || $field != 'country')
                                    <a href="{{ route('user.edit', ['field' => 'country']) }}" class="btn btn-link">Editar
                                        País</a>
                                @else
                                    <button type="submit" class="btn btn-primary"
                                        form="editForm-{{ $field }}">Guardar</button>
                                    <a href="{{ route('user.show') }}" class="btn btn-secondary btn-cancel"
                                        data-field="country">Cancelar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
</body>

</html>
