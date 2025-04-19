@extends('layouts.master')
@php
    if (!isset($url)) {
        header("Location: " . url('/selectrole'));
        exit();
    }
@endphp

@section('title', 'Login')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="login">


                    <div class="card-header">
                        <h1>{{ isset($url) ? ucwords($url) : ' ' }} {{ __('Login') }}</h1>
                    </div>

                    <div class="card-body">
                        @isset($url)
                            <form method="POST" action="{{ url("$url/login") }}" class="form login-form">
                        @endisset

                            @csrf

                            <label for="email" class="form-label">{{ __('Email Address') }}</label>

                            <div class="form-group">
                                <svg class="form-icon-left" width="14" height="14" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 448 512">
                                    <path
                                        d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                </svg>
                                <input id="email" type="text" class="form-input @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" placeholder="Email" required
                                    autocomplete="email" autofocus>
                            </div>
                            <div class="msg error">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>



                            <label for="password" class="form-label">{{ __('Password') }}</label>

                            <div class="form-group mar-bot-5">
                                <svg class="form-icon-left" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 448 512">
                                    <path
                                        d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
                                </svg>
                                <input id="password" type="password"
                                    class="form-input @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password" placeholder="Password">
                            </div>
                            <div class="msg error">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="msg error">
                                @if ($errors->has('error'))
                                    <div class="invalid-feedback" role="alert">
                                        {{ $errors->first('error') }}
                                    </div>
                                @endif
                            </div>

                            <br>



                            <button type="submit" class="btn blue">
                                {{ __('Login') }}
                            </button>

                            <p class="register-link">Don't have an account? <a href="{{ url($url . '/register') }}"
                                    class="form-link">Register</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection