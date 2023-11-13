<div class="container-fluid">
    <section class="">
        <!-- Footer -->
        <footer class="text-center text-white" style="background-color: #0a4275;">
            <div class="container p-4 ">
                <section class="">
                    <p class="d-flex justify-content-center align-items-center">
                        @guest
                        <article class="row d-flex flex-row justify-content-around align-content-center">
                            <div class="col-4">
                                <img src="{{ asset('images/logos/your_logo.png') }}" alt="Logo" >
                            </div>

                            <div class="col-4 d-flex flex-column justify-center align-content-center">
                                <span class="col-4 me-3">Register</span>
                                <a href="{{ route('register') }}" class="btn btn-outline-light btn-rounded">Sign up!</a>
                            </div>
                            <div class="col-4 d-flex flex-column justify-center align-content-center">
                                <span class=" col-4 me-3">Login</span>
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-rounded">Sign up!</a>
                            </div>

                        </article>
                    @else
                        @if (!auth()->user()->subscribed)
                            <article class="row d-flex flex-row justify-content-center align-content-center">
                                <div class="col-6 d-flex flex-col justify-content-center align-content-center">
                                    <img src="{{ asset('images/logos/your_logo.png') }}" alt="Logo">
                                </div>
                                <div class="col-6 d-flex flex-col justify-content-center align-content-center">
                                    <span class="me-3">Subscribe now</span>
                                    <a href="{{-- {{ route('subscribe') }} --}}"
                                        class="btn btn-outline-light btn-rounded">Subscribe</a>
                                </div>
                            </article>
                        @else
                            <!-- Mostrar el logo si el usuario está autenticado y suscrito -->
                            <article class="row d-flex flex-row justify-content-center align-content-center">
                                <img src="{{ asset('images/logos/your_logo.png') }}" alt="Logo">
                            </article>
                        @endif
                    @endguest
                    </p>
                </section>
            </div>
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                © {{ date('Y') }} Copyright:
                <a class="text-white">Booktopia</a>
            </div>
        </footer>
    </section>
</div>
