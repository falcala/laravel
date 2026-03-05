@extends('layouts/blankLayout')

@section('title', 'Registrarse')

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register Card -->
            <div class="card px-sm-6 px-0">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-6">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">@include('_partials.macros')</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <!--form id="formAuthentication" class="mb-6" action="{{ url('/') }}" method="POST" -->
					<form id="formAuthentication" class="mb-6" action="{{ route('register') }}" method="POST">
						@csrf
                        <div class="mb-6">
                            <label for="username" class="form-label">Nombre</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Ingresa tu nombre" required autofocus autocomplete="name" value="{{ old('name') }}">
							@error('name')
								<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
							@enderror
                        </div>
                        <div class="mb-6">
                            <label for="email" class="form-label">Correo</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo" required autocomplete="email" value="{{ old('email') }}">
							@error('email')
								<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
							@enderror
                        </div>
                        <div class="form-password-toggle">
                            <label class="form-label" for="password">Contraseña</label>
							<div class="input-group input-group-merge">
								<input type="password" class="form-control" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required autocomplete="new-password">
								<span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                            </div>
							@error('password')
								<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
							@enderror
                        </div>
						<div class="mb-3 form-password-toggle">
							<label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
							<div class="input-group input-group-merge">
								<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required autocomplete="new-password">
								<span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
							</div>
						</div>
                        <div class="my-7">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                                <label class="form-check-label" for="terms-conditions">
                                    Estoy de acuerdo con 
                                    <a href="javascript:void(0);">Terminos y Condiciones y Politicas de Privacidad</a>
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100">Registrarme</button>
                    </form>

                    <p class="text-center">
                        <span>Ya tienes cuenta?</span>
                        <a href="{{ url('login') }}">
                            <span>Ingresar</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- Register Card -->
        </div>
    </div>
</div>
@endsection