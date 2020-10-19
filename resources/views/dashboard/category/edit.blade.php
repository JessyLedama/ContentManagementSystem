@extends('main')

@section('title', 'Edit Category | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('dashboard.menu')

        <article class="card pull-right">
            <form action="{{ route('category.update', $category) }}" method="post" id="form">

                @if (session()->has('success'))
                    <span class="alert alert-success">
                        {{ session()->get('success') }}
                    </span>
                @endif

                @csrf
        
                @method('PUT')

                <div class="input-group">
                    <div class="pull-left">
                        <h4>Name</h4>

                        <div class="input-group" id="name-group">
                            <input type="text" placeholder="Name" value="{{ old('name', $category->name) }}" name="name" required>
                        </div>
                    </div>

                    <div class="pull-right">
                        <h4>Slug</h4>

                        <input type="text" placeholder="Slug" value="{{ old('slug', $category->slug) }}" name="slug" required>
                    </div>
                </div>

                <h4>Description</h4>

                <textarea id="description" placeholder="Description" name="description">{{ old('description', $category->description) }}</textarea>

                @include('dashboard.seo', [

                    'title' => $category->seo->title ?? '',
                    'keywords' => $category->seo->keywords ?? '',
                    'description' => $category->seo->description ?? ''
                ])

                <button type="submit">Update</button>
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