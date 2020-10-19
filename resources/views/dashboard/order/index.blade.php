@extends('main')

@section('title', 'Orders | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('dashboard.menu')

        <article class="card pull-right">
            <div id="orders">
                <h4 class="desktop">
                    Orders
                </h4>

                <h4 class="mobile" id="card-header">
                    <a href="{{ route('dashboard.menu') }}" id="back-to-menu">
                        <i class="lnr lnr-arrow-left"></i>
                    </a>

                    Orders
                </h4>

                @foreach ($orders as $order)
                    <div class="order clearfix">
                        <div class="pull-left">
                            Order No: {{ $order->ordNo }} <br>
                            Status: {{ $order->status }} <br>
                            Amount: Ksh. {{ number_format($order->total + $order->shippingCost) }}
                        </div>
                        <div class="manage-order pull-right">
                            <a href="{{ route('order.edit', $order) }}">
                                <i class="lni-eye"></i>
                                View
                            </a>
                        </div>
                    </div>
                @endforeach

                <div id="pagination">
                    {{ $orders->links() }}
                </div>
            </div>
        </article>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/order/index.css') }}">
@endsection