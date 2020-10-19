@extends('main')

@section('title', 'Edit Subcategory | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('dashboard.menu')

        <article class="card pull-right">
            <form action="{{ route('subcategory.update', $subCategory) }}" method="post" id="form">

                @if (session()->has('success'))
                    <span class="alert alert-success">
                        {{ session('success') }}
                    </span>
                @endif

                @csrf

                @method('PUT')

                <div class="input-group clearfix">
                    <div class="pull-left">
                        <h4>Name</h4>

                        <input type="text" placeholder="Name" value="{{ old('name', $subCategory->name) }}" name="name" required>
        
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="pull-right">
                        <h4>Slug</h4>

                        <input type="text" placeholder="Slug" value="{{ old('slug', $subCategory->slug) }}" name="slug" required>
        
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <h4>Select category</h4>

                <select name="categoryId" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == old('subcategory', $subCategory->categoryId) ? 'selected' : ''}}>
                            {{ ucwords($category->name) }}
                        </option>
                    @endforeach
                </select>

                <h4>Description</h4>
                
                <textarea id="description" placeholder="Description" name="description">{{ old('description', $subCategory->description) }}</textarea>

                @include('dashboard.seo', [

                    'title' => $subCategory->seo->title ?? '',
                    'keywords' => $subCategory->seo->keywords ?? '',
                    'description' => $subCategory->seo->description ?? ''
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