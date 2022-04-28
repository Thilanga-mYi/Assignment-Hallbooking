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
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for=""><small>{{ __('Name') }}</small></label>
                                            <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}"
                                                required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for="nic"><small>National Identity Card Number</small></label>
                                            <input id="nic" name="nic" type="text" class="form-control" value="{{ old('nic') }}"
                                                required>
                                            @error('nic')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for="mobile"><small>Mobile Number</small></label>
                                            <input id="mobile" name="mobile" type="text" class="form-control"
                                                value="{{ old('mobile') }}" required>
                                            @error('mobile')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for=""><small>Email Address</small></label>
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
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for=""><small>Confirm Password</small></label>
                                            <input id="password-confirm" type="password"
                                                class="form-control @error('password-confirm') is-invalid @enderror"
                                                name="password-confirm" required autocomplete="current-password">
                                            @error('password-confirm')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary w-100">
                                                Register
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-md-12" style="text-align: center;">
                                            <a class="btn btn-link" href="/login">
                                                <small>Already have an account, Login.</small>
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
