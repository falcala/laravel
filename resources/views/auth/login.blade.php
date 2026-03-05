@extends('layouts/blankLayout')

@section('title', 'Ingresar')

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Login card -->
            <div class="card px-sm-6 px-0">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <span class="app-brand-logo">@include('_partials.macros')</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <form id="formAuthentication" class="mb-6" action="{{ route('login') }}" method="POST">
                        @csrf
                        <!-- Error message -->
                        @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif
                        <div class="mb-6">
                            <label for="email" class="form-label">Correo:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Ingresa tu correo" required autofocus />
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-6 form-password-toggle">
                            <label class="form-label" for="password">Contraseña</label>
							<div class="input-group input-group-merge">
								<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required autocomplete="new-password">
								<span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                            </div>
							@error('password')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
                        </div>
                        <div class="mb-8">
                            <div class="d-flex justify-content-between">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Recuerdame </label>
                                </div>
                                <a href="{{ url('forgot-password') }}">
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
                        <a href="{{ url('register') }}">
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
