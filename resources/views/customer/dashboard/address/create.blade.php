@extends('main')

@section('title', 'Create | Address Book | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('customer.dashboard.menu')

        <article class="card pull-right">
            <form action="{{ route('customer.address.store') }}" method="post" id="address-form">

                <a href="{{ route('customer.address') }}">
                    <i class="lni-arrow-left"></i>
                    Back to address book
                </a>

                @csrf

                <div class="clearfix">
                    <div class="input-group pull-left">
                        <label for="phone">Mobile phone number</label>
                        <input type="text" name="phone" id="phone">
                    </div>

                    <div class="input-group pull-left">
                        <label for="county">Region/County</label>
                        <input type="text" name="county" id="county">
                    </div>

                    <div class="input-group pull-left">
                        <label for="town">City/town</label>
                        <input type="text" name="town" id="town">
                    </div>

                    <div class="input-group pull-left">
                        <label for="street">Street/Apartment</label>
                        <input type="text" name="street" id="street">
                    </div>
                </div>

                <button type="submit">Save address</button>
            </form>
        </article>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/customer/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/address/form.css') }}">
@endsection