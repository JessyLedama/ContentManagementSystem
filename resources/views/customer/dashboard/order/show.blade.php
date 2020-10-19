@extends('main')

@section('title', 'View Order | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('customer.dashboard.menu')
        
        <article class="card pull-right">
            <a href="{{ route('customer.order') }}">
                <i class="lni-arrow-left"></i>
                Back to orders
            </a>
            <div class="clearfix">
                <div class="pull-left" id="order-details">
                    <h3>Order details</h3>
                    <span>
                        Order No: {{ $order->ordNo }}
                    </span>
                    <span>
                        Status: {{ $order->status }}
                    </span>
                    <span>
                        Delivery Cost: Ksh {{ $order->shippingCost }}
                    </span>
                    <span>
                        Total: Ksh {{ number_format($order->total) }}
                    </span>
                    <span>
                        Amount: Ksh {{ number_format($order->total + $order->shippingCost) }}
                    </span>
                    <span>
                        Date: {{ $order->created_at->format('F j, Y') }}
                    </span>
                </div>
                <div class="pull-right" id="address">
                    <h3>Delivery address</h3>
                    <span>
                        Phone: {{ $order->address->phone ?? '-' }}
                    </span>
                    <span>
                        County: {{ $order->address->county ?? '-' }}
                    </span>
                    <span>
                        Town: {{ $order->address->town ?? '-' }}
                    </span>
                    <span>
                        Street: {{ $order->address->street ?? '-' }}
                    </span>
                </div>
            </div>
            <div id="catalogue">
                <h3>Products ({{ count($order->catalogue) }} in total)</h3>
                <div class="clearfix">
                    @foreach ($order->catalogue as $product)
                        <div class="product pull-left">
                            <img src="{{ $product->coverUrl }}" class="product-cover">
                            <h4 class="product-name">
                                {{ $product->name }}
                            </h4>
                            <h5 class="product-sale-price">
                                Ksh. {{ number_format($product->price) }}
                            </h5>
                            <small class="product-quantity">
                                {{ $product->pivot->quantity }} in quantity
                            </small>
                        </div>
                    @endforeach
                </div>
            </div>
        </article>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/customer/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/order/show.css') }}">
@endsection