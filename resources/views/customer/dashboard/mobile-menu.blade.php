@extends('main')

@section('title', 'My Account Links')

@section('content')
    <section>
        <ul class="card">
            <li>
                <a href="{{ route('customer.profile.edit') }}">
                    <i class="lnr lnr-user"></i>
                    My Account
                </a>
            </li>
            <li>
                <a href="{{ route('customer.address') }}">
                    <i class="lnr lnr-book"></i>
                    Address Book
                </a>
            </li>
            <!-- <li>
                <a href="{{ route('customer.order') }}">
                    <i class="lni-package"></i>
                    Orders
                </a>
            </li>
            <li>
                <a href="{{ route('customer.wishlist') }}">
                    <i class="lnr lnr-inbox"></i>
                    <span>Saved items</span>
                </a>
            </li> -->
            <li id="dashboard-sign-out">
                <a onclick="document.getElementById('customer-logout-form').submit()">
                    Sign out
                </a>
            </li>
        </ul>

        <!--logout form -->
        <form id="customer-logout-form" action="{{ route('logout') }}" method="POST">

            @csrf

        </form>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/customer/mobile-menu.css') }}">
@endsection