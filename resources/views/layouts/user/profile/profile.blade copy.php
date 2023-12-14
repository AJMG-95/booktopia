@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header row">
                        <p class="col-11">{{ $user->nickname ? $user->nickname : 'Mi Perfil' }}</p>
                        <p class="col-1 text-right">{{ $user->strikes ? "Strikes: " . $user->strikes : '' }}</p>
                    </div>

                    <div class="card-body">

                        <div class="text-center mb-4">
                            <img src="{{ asset('images/profile/' . $user->profile_img) }}" alt="Profile Image"
                                class="img-fluid rounded-circle" style="max-width: 150px;">
                        </div>

                        <h2 class="text-center mb-3">{{ $user->name }} {{ $user->surnames }}</h2>

                        <div class="mb-3">
                            <strong>Email:</strong>
                            <input type="text" id="email" class="form-control" value="{{ $user->email }}" readonly>
                            <button class="btn btn-secondary editBtn" data-target="email">Editar</button>
                            <button class="btn btn-success saveBtn" data-target="email" style="display: none;">Guardar</button>
                            <button class="btn btn-danger cancelBtn" data-target="email" style="display: none;">Cancelar</button>
                        </div>

                        <div class="mb-3">
                            <strong>Nickname:</strong>
                            <input type="text" id="nickname" class="form-control" value="{{ $user->nickname }}" readonly>
                            <button class="btn btn-secondary editBtn" data-target="nickname">Editar</button>
                            <button class="btn btn-success saveBtn" data-target="nickname" style="display: none;">Guardar</button>
                            <button class="btn btn-danger cancelBtn" data-target="nickname" style="display: none;">Cancelar</button>
                        </div>

                        <div class="mb-3">
                            <strong>Biografía:</strong>
                            <textarea id="biography" class="form-control" readonly>{{ $user->biography ?? 'N/A' }}</textarea>
                            <button class="btn btn-secondary editBtn" data-target="biography">Editar</button>
                            <button class="btn btn-success saveBtn" data-target="biography" style="display: none;">Guardar</button>
                            <button class="btn btn-danger cancelBtn" data-target="biography" style="display: none;">Cancelar</button>
                        </div>

                        <div class="mb-3">
                            <strong>Fecha de Nacimiento:</strong>
                            <input type="text" id="birth_date" class="form-control" value="{{ $user->birth_date ?? 'N/A' }}" readonly>
                            <button class="btn btn-secondary editBtn" data-target="birth_date">Editar</button>
                            <button class="btn btn-success saveBtn" data-target="birth_date" style="display: none;">Guardar</button>
                            <button class="btn btn-danger cancelBtn" data-target="birth_date" style="display: none;">Cancelar</button>
                        </div>

                        <div class="mb-3">
                            <strong>País:</strong>
                            <input type="text" id="country" class="form-control" value="{{ $user->country->name ?? 'N/A' }}" readonly>
                            <button class="btn btn-secondary editBtn" data-target="country">Editar</button>
                            <button class="btn btn-success saveBtn" data-target="country" style="display: none;">Guardar</button>
                            <button class="btn btn-danger cancelBtn" data-target="country" style="display: none;">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Agregamos el script JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Configurar eventos para cada campo
            document.querySelectorAll('.editBtn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const target = this.getAttribute('data-target');
                    const inputField = document.getElementById(target);
                    const saveBtn = document.querySelector(`.saveBtn[data-target="${target}"]`);
                    const cancelBtn = document.querySelector(`.cancelBtn[data-target="${target}"]`);

                    // Activar edición
                    inputField.removeAttribute('readonly');
                    saveBtn.style.display = 'inline-block';
                    cancelBtn.style.display = 'inline-block';
                    this.style.display = 'none';
                });
            });

            // Configurar eventos para botones de guardar y cancelar
            document.querySelectorAll('.saveBtn, .cancelBtn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const target = this.getAttribute('data-target');
                    const inputField = document.getElementById(target);
                    const editBtn = document.querySelector(`.editBtn[data-target="${target}"]`);
                    const saveBtn = document.querySelector(`.saveBtn[data-target="${target}"]`);
                    const cancelBtn = document.querySelector(`.cancelBtn[data-target="${target}"]`);

                    if (this.classList.contains('saveBtn')) {
                        // Guardar cambios en la base de datos (puedes implementar la lógica aquí)
                        // ...

                        // Desactivar edición
                        inputField.setAttribute('readonly', true);
                        editBtn.style.display = 'inline-block';
                    } else {
                        // Cancelar edición
                        inputField.setAttribute('readonly', true);
                        editBtn.style.display = 'inline-block';
                    }

                    // Ocultar botones de guardar y cancelar
                    saveBtn.style.display = 'none';
                    cancelBtn.style.display = 'none';
                });
            });
        });
    </script>
@endsection

