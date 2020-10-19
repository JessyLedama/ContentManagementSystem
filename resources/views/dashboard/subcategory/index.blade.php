@extends('main')

@section('title', 'Subcategories | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('dashboard.menu')

        <article class="card pull-right">
            <div id="subcategory-list">
                <h4 class="clearfix desktop">
                    <span class="pull-left">
                        Subcategories
                    </span>
                    <a href="{{ route('subcategory.create') }}" class="pull-right">
                        Add subcategory
                    </a>
                </h4>

                <div class="clearfix mobile">
                    <h4>
                        <a href="{{ route('dashboard.menu') }}" id="back-to-menu">
                            <i class="lnr lnr-arrow-left"></i>
                        </a>
                        
                        Subcategories
                    </h4>

                    <a href="{{ route('category.create') }}">
                        <i class="lnr lnr-file-add"></i>
                        Add subcategory
                    </a>
                </div>

                @if (session()->has('success'))
                    <span class="alert alert-success">
                        {{ session('success') }}
                    </span>
                @endif

                @foreach ($subCategories as $subCategory)
                    <div class="subcategory clearfix">
                        <div class="pull-left">
                            {{ ucwords($subCategory->name) }} - {{ ucwords($subCategory->category->name) }}
                        </div>

                        <div class="manage-subcategory pull-right">
                            <a href="{{ route('subcategory.edit', $subCategory) }}">
                                <i class="lni-pencil-alt"></i>
                                Edit
                            </a>

                            <a onclick="confirm('Are you sure to delete this subcategory') ? document.getElementById('delete-form-{{ $subCategory->id }}').submit() : NaN">
                                <i class="lni-pencil-alt"></i>
                                Delete
                            </a>

                            <form id="delete-form-{{ $subCategory->id }}" action="{{ route('subcategory.destroy', $subCategory) }}" method="post">

                                @csrf

                                @method('DELETE')

                            </form>
                        </div>
                    </div>
                @endforeach

                <div id="pagination">
                    {{ $subCategories->links() }}
                </div>
            </div>
        </article>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/subcategories.css') }}">
@endsection