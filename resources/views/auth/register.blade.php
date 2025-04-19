@extends('layouts.master')

@section('page-specific-css')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="register">
                <div class="card-header">
                    <h1>{{isset($url) ? ucwords($url) : " "}} {{ __('Register') }}</h1>
                </div>

                <div class="card-body">
                    @isset($url)
                        <form method="POST" action="{{ url("$url/register") }}" class="form login-form">
                    @endisset
                        @csrf


                        <label for="name" class="form-label">{{ __('Name') }}</label>

                        <div class="form-group">
                            <svg class="form-icon-left" width="14" height="14" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512">
                                <path
                                    d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                            </svg>
                            <input id="name" type="text" class="form-input @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" placeholder="Name" required autocomplete="name" autofocus>


                        </div>
                        <div class="msg error">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>


                        <label for="email" class="form-label">{{ __('Email Address') }}</label>

                        <div class="form-group">
                            <svg class="form-icon-left" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                viewBox="0 0 512 512">
                                <path
                                    d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
                            </svg>
                            <input id="email" type="text" class="form-input @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">


                        </div>
                        <div class="msg error">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                            @enderror
                        </div>


                        <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>

                        <div class="form-group">
                            <svg class="form-icon-left" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                viewBox="0 0 512 512">
                                <path
                                    d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z" />
                            </svg>
                            <input id="phone_number" type="tel"
                                class="form-input @error('phone_number') is-invalid @enderror" name="phone_number"
                                placeholder="Phone Number" value="{{ old('phone_number') }}" required autocomplete="tel">



                        </div>
                        <div class="msg error">
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>


                        <label for="password" class="form-label">{{ __('Password') }}</label>

                        <div class="form-group">
                            <svg class="form-icon-left" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                viewBox="0 0 448 512">
                                <path
                                    d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
                            </svg>
                            <input id="password" type="password" class="form-input @error('password') is-invalid @enderror"
                                name="password" placeholder="Password" required autocomplete="new-password">

                        </div>
                        <div class="msg error">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <label for="password-confirm" class="form-label ">{{ __('Confirm Password') }}</label>

                        <div class="form-group">
                            <svg class="form-icon-left" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                viewBox="0 0 448 512">
                                <path
                                    d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z" />
                            </svg>
                            <input id="password-confirm" type="password"
                                class="form-input @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" placeholder="Re-enter Password" required
                                autocomplete="new-password">

                        </div>

                        @if(isset($url) && $url == 'organization')

                            <label for="address" class="form-label">{{ __('Address') }}</label>

                            <div class="form-group">
                                <svg class="form-icon-left" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 384 512">
                                    <path
                                        d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
                                </svg>
                                <input id="address" type="text" class="form-input @error('address') is-invalid @enderror"
                                    name="address" placeholder="Address" required autocomplete="address">


                            </div>
                            <div class="msg error">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $errors->first('address') }}
                                    </span>
                                @enderror
                            </div>

                            <label for="details" class="form-label">{{ __('Details') }}</label>

                            <div class="form-group">
                                <textarea id="details" class="form-input @error('details') is-invalid @enderror" name="details"
                                    required autocomplete="details" rows="4">{{ old('details') }}</textarea>

                            </div>
                            <div class="msg error">
                                @error('details')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $errors->first('details') }}
                                    </span>
                                @enderror
                            </div>
                        @endif



                        <br>
                        <button type="submit" class="btn blue">
                            {{ __('Register') }}
                        </button>

                        <p class="register-link">Already have an account? <a href="{{ url($url . '/login') }}"
                                class="form-link">Login</a></p>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection