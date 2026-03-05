@extends('layouts/blankLayout')

@section('title', 'Ingresar')

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card px-sm-6 px-0">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <span class="app-brand-logo">@include('_partials.macros')</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <form id="formAuthentication" class="mb-6" action="{{ url('/') }}" method="GET">
                        <div class="mb-6">
                            <label for="email" class="form-label">Correo:</label>
                            <input type="text" class="form-control" id="email" name="email-username" placeholder="Ingresa tu correo" autofocus />
                        </div>
                        <div class="mb-6 form-password-toggle">
                            <label class="form-label" for="password">Contraseña</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-8">
                            <div class="d-flex justify-content-between">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Recuerdame </label>
                                </div>
                                <a href="{{ url('auth/forgot-password-basic') }}">
                                    <span>Olvide mi contraseña?</span>
                                </a>
                            </div>
                        </div>
                        <div class="mb-6">
                            <button class="btn btn-primary d-grid w-100" type="submit">Ingresar</button>
                        </div>
                    </form>

                    <p class="text-center">
                        <span>Nuevo por aqui?</span>
                        <a href="{{ url('auth/register-basic') }}">
                            <span>Crear cuenta</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>
@endsection
