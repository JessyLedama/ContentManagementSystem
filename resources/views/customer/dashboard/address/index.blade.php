@extends('main')

@section('title', 'Address Book | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('customer.dashboard.menu')

        <article class="card pull-right">
            <div id="address-book">
                <h4 class="clearfix desktop">
                    <strong class="pull-left">
                        Address Book

                        @if (session()->has('success'))
                            <span class="alert alert-success">
                                {{ session()->get('success') }}
                            </span>
                        @endif
                    </strong>
                    <a href="{{ route('customer.address.create') }}" class="pull-right">
                        Add address
                    </a>
                </h4>

                <div class="mobile" id="card-header">
                    <h4>
                        <a href="{{ route('customer.profile.menu') }}" id="back-to-menu">
                            <i class="lnr lnr-arrow-left"></i>
                        </a>

                        Address Book
                    </h4>

                    <a href="{{ route('customer.address.create') }}" class="add-address">
                        <i class="lnr lnr-file-add"></i>
                        Add address
                    </a>

                    @if (session()->has('success'))
                        <span class="alert alert-success">
                            {{ session()->get('success') }}
                        </span>
                    @endif
                </div>

                @foreach($addressBook as $address)
                    <div class="address">
                        {{ $address->phone }} &nbsp;
                        {{ $address->town }} &nbsp;
                        {{ $address->county }} &nbsp;
                        {{ $address->street }}
                        <div class="manage-address">
                            <span onclick="confirm('Are you sure you want to delete') ? document.getElementById('delete-address-{{ $address->id }}').submit() : NaN">
                                <i class="lni-trash"></i>
                                Delete
                            </span>

                            <form id="delete-address-{{ $address->id }}" action="{{ route('customer.address.destroy', $address->id) }}" method="post">
                                @csrf

                                @method('DELETE')
                            </form>

                            <a href="{{ route('customer.address.edit', $address) }}">
                                <i class="lni-pencil-alt"></i>
                                Edit
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </article>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/customer/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/address/index.css') }}">
@endsection