@extends('main')

@section('title', 'My Account | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('customer.dashboard.menu')

        <article class="card pull-right">

            <form action="{{ route('customer.profile.update') }}" method="post" id="edit-profile-form">

                <h4 class="mobile">
                    <a href="{{ route('customer.profile.menu') }}" id="back-to-menu">
                        <i class="lnr lnr-arrow-left"></i>
                    </a>
    
                    My account
                </h4>

                @if (session()->has('success'))
                    <span class="alert alert-success">
                        {{ session()->get('success') }}
                    </span>
                @endif

                @csrf
        
                @method('PUT')

                <h4>Full name</h4>

                <div class="input-group clearfix" id="name-group">
                    <input type="text" placeholder="First name" value="{{ old('firstName', $user->firstName) }}" name="firstName" class="pull-left" required>
                    <input type="text" placeholder="Last name" value="{{ old('lastName', $user->lastName) }}" name="lastName" class="pull-right" required>
                </div>

                <h4>E-mail Address</h4>

                <input type="text" placeholder="E-mail address" value="{{ old('email', $user->email) }}" name="email" id="email-input" required>

                <h4>Change password</h4>

                <div class="input-group clearfix" id="password-group">
                    <input type="password" placeholder="Password" name="password" class="pull-left">
                    <input type="password" placeholder="Confirm Password" name="password_confirmation" class="pull-right">
                </div>

                <button type="submit">Update Account</button>
            </form>
        </article>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/customer/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/profile.css') }}">
@endsection