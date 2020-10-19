@extends('main')

@section('title', 'Edit Order | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('dashboard.menu')
        <article class="card pull-right">
            <a href="{{ route('order.index') }}">
                <i class="lni-arrow-left"></i>
                Back to orders
            </a>

            @if (session()->has('success'))
                <span class="alert alert-success">
                    {{ session('success') }}
                </span>
            @endif

            <div class="clearfix">
                <div class="pull-left" id="order-details">
                    <h3>Order details</h3>
                    <span>
                        Order No: {{ $order->ordNo }}
                    </span>
                    <span>
                        Status:
                        <form action="{{ route('order.update', $order) }}" method="post">

                            @csrf

                            @method('PUT')

                            <select name="status">
                                <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="in transit" {{ old('status', $order->status) == 'in transit' ? 'selected' : '' }}>
                                    In transit
                                </option>
                                <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                                <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                            </select>

                            <button type="submit">Update</button>
                        </form>
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
    <link rel="stylesheet" href="{{ asset('css/dashboard/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/order/edit.css') }}">
@endsection