@extends('main')

@section('title', 'Members | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('dashboard.menu')

        <article class="card pull-right">
            <div id="products">
                <h4 class="clearfix desktop">
                    <span class="pull-left">
                            Members ( {{$count}} )
                    </span>
                    <a href="{{ route('product.create') }}" class="pull-right">
                        Add member
                    </a>
                </h4>

                <div class="clearfix mobile">
                    <h4>
                        <a href="{{ route('dashboard.menu') }}" id="back-to-menu">
                            <i class="lnr lnr-arrow-left"></i>
                        </a>
                        
                        Members ( {{$count}} )
                    </h4>

                    <a href="{{ route('category.create') }}">
                        <i class="lnr lnr-file-add"></i>
                        Add member
                    </a>
                </div>

                @if (session()->has('success'))
                    <span class="alert alert-success">
                        {{ session('success') }}
                    </span>
                @endif

                @foreach ($products as $product)
                    <div class="product clearfix">
                        <div class="pull-left">
                            {{ ucwords($product->name) }}

                        </div>
                        <br />
                        <div>
                            {{ ucwords($product->phone_number) }}
                        </div>

                        <div class="manage-product pull-right">
                            <a href="{{ route('product.edit', $product) }}">
                                <i class="lni-pencil-alt"></i>
                                Edit
                            </a>

                            <a onclick="confirm('Are you sure to delete this product') ? document.getElementById('delete-form-{{ $product->id }}').submit() : NaN">
                                <i class="lni-pencil-alt"></i>
                                Delete
                            </a>

                            <form id="delete-form-{{ $product->id }}" action="{{ route('product.destroy', $product) }}" method="post">

                                @csrf

                                @method('DELETE')

                            </form>
                        </div>
                    </div>
                @endforeach

                <div id="pagination">
                    {{ $products->links() }}
                </div>
            </div>
        </article>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/products.css') }}">
@endsection