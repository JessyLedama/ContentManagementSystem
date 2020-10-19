@extends('main')

@section('title', 'Forgot Password | ' . config('app.name'))

@section('content')
    <section>
        <form action="{{ route('password.email') }}" method="post" id="reset-email-form" class="auth-form">
            <h1 id="auth-title">Forgot password</h1>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @csrf

            <input type="email" name="email" id="email" placeholder="E-mail address">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <button type="submit">Send password reset link</button>
        </form>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection