@extends('main')

@section('title', 'Login | ' . config('app.name'))

@section('content')
    <section>
        <form action="{{ route('login') }}" method="post" class="auth-form">
            <h1 id="auth-title">Login</h1>

            @csrf

            <input type="email" name="email" id="email" placeholder="E-mail address">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <input type="password" name="password" id="password" placeholder="Password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div class="clearfix">
                <div class="pull-left" id="remember-me">
                    <input type="checkbox" name="remember" checked> Remember me
                </div>
                <a href="{{ route('password.request') }}" class="pull-right" id="forgot-password">
                    Forgot password
                </a>
            </div>

            <button type="submit">Login</button>
            
            <a href="{{ route('register') }}" id="login-signup-link">
                Create account
            </a>

            <h5 id="social-separator">
                <span>Or</span>
            </h5>

            @include('auth.social', ['title' => 'Login'])
        </form>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection
