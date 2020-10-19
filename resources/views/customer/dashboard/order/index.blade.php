@extends('main')

@section('title', 'Orders | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('customer.dashboard.menu')

        <article class="card pull-right">
            <div id="orders">
                <h4 class="desktop">
                    My Orders
                </h4>

                <h4 class="mobile" id="card-header">
                    <a href="{{ route('customer.profile.menu') }}" id="back-to-menu">
                        <i class="lnr lnr-arrow-left"></i>
                    </a>

                    My Orders
                </h4>
                
                @foreach ($orders as $order)
                    <div class="order clearfix">
                        <div class="pull-left">
                            Order No: {{ $order->ordNo }} <br>
                            Status: {{ $order->status }} <br>
                            Amount: Ksh. {{ number_format($order->total + $order->shippingCost) }}
                        </div>
                        <div class="manage-order pull-right">
                            <a href="{{ route('customer.order.show', $order) }}">
                                <i class="lni-eye"></i>
                                View
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
    <link rel="stylesheet" href="{{ asset('css/customer/order/index.css') }}">
@endsection