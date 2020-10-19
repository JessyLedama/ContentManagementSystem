@extends('main')

@section('title', 'Reset Password | ' . config('app.name'))

@section('content')
    <section>
        <form action="{{ route('password.update') }}" method="post" class="auth-form">
            <h1 id="auth-title">Reset password</h1>

            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

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

            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password">

            <button type="submit">Reset password</button>
        </form>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection