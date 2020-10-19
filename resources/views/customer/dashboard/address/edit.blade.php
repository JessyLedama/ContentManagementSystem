@extends('main')

@section('title', 'Edit | Address Book | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('customer.dashboard.menu')

        <article class="card pull-right">
            <form action="{{ route('customer.address.update', $address) }}" method="post" id="address-form">

                <a href="{{ route('customer.address') }}">
                    <i class="lni-arrow-left"></i>
                    Back to address book
                </a>
        
                @if (session()->has('success'))
                    <span class="alert alert-success">
                        {{ session()->get('success') }}
                    </span>
                @endif
        
                @csrf
        
                @method('PUT')
        
                <div class="clearfix">
                    <div class="input-group pull-left">
                        <label for="phone">Mobile phone number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $address->phone) }}">
                    </div>
        
                    <div class="input-group pull-left">
                        <label for="county">Region/County</label>
                        <input type="text" name="county" id="county" value="{{ old('county', $address->county) }}">
                    </div>
        
                    <div class="input-group pull-left">
                        <label for="town">City/town</label>
                        <input type="text" name="town" id="town" value="{{ old('town',  $address->town) }}">
                    </div>
        
                    <div class="input-group pull-left">
                        <label for="street">Street/Apartment</label>
                        <input type="text" name="street" id="street" value="{{ old('street', $address->street) }}">
                    </div>
                </div>
        
                <button type="submit">Update address</button>
            </form>
        </article>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/customer/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/address/form.css') }}">
@endsection