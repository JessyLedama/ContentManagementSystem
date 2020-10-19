@extends('main')

@section('title', 'Add Category | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('dashboard.menu')

        <article class="card pull-right">
            <form action="{{ route('category.store') }}" method="post" id="form">

                <h4 class="mobile">
                    <a href="{{ route('dashboard.menu') }}" id="back-to-menu">
                        <i class="lnr lnr-arrow-left"></i>
                    </a>
    
                    Add category
                </h4>

                @csrf

                <div class="input-group clearfix">

                   <div class="pull-left">
                        <h4>Name</h4>

                        <input type="text" placeholder="Name" value="{{ old('name', '') }}" name="name" required>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                   </div>

                   <div class="pull-right">
                        <h4>Slug</h4>

                        <input type="text" placeholder="Slug" value="{{ old('slug', '') }}" name="slug" required>

                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                   </div>

                </div>

                <h4>Description</h4>
                
                <textarea id="description" placeholder="Description" name="description">{{ old('description', '') }}</textarea>

                @include('dashboard.seo')

                <button type="submit">Save</button>
            </form>
        </article>
    </section> 
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/form.css') }}">
@endsection

@push('script')
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

    <script>
        jQuery(document).ready(function () {
            CKEDITOR.replace('description');
        });
    </script>
@endpush