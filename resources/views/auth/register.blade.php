@extends('main')

@section('title', 'Register | ' . config('app.name'))

@section('content')
    <section>
        <form action="{{ route('register') }}" method="post" class="auth-form">
            <h1 id="auth-title">Register</h1>

            @csrf

            <input type="email" name="email" id="email" placeholder="E-mail address">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <input type="text" name="firstName" id="firstName" placeholder="First name" required>

            <input type="text" name="lastName" id="lastName" placeholder="Last name" required>

            <input type="password" name="password" id="password" placeholder="Password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password">

            <button type="submit">Register</button>

            <a href="{{ route('login') }}" id="login-signup-link">
                Login
            </a>

            <h5 id="social-separator">
                <span>Or</span>
            </h5>
            
            @include('auth.social', ['title' => 'Register'])
        </form>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection
