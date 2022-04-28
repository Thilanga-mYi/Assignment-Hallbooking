@extends('layouts.app')

@section('content')
    <div class="app-content h-100">
        <div class="content-wrapper  ">
            <div class="content-body ">
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <div class="card border-grey border-lighten-3 m-0">
                            <div class="card-header border-0">
                                <div class="card-title text-center">
                                    <div class="p-1"><img class="w-50"
                                            src="{{ asset('assets/app-assets/images/logo/logo.png') }}"
                                            alt="branding logo"></div>
                                </div>
                                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-s"><span>Timetable Management</span></h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for=""><small>Username</small></label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for=""><small>Password</small></label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-md-12">
                                            <div class="form-check ml-0">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    <small>{{ __('Remember Me') }}</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary w-100">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-md-12 mt-2" style="text-align: center;">

                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    <small>{{ __('Forgot Your Password?') }}</small>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="col-md-12" style="text-align: center;">
                                            <a class="btn btn-link" href="/register">
                                                <small>No account yet, Register today !</small>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.scripts')



@endsection
