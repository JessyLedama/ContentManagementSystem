@extends('main')

@section('title', 'Add Member | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('dashboard.menu')

        <article class="card pull-right">
            <form action="{{ route('product.store') }}" method="post" id="form" enctype="multipart/form-data">

                @if (session()->has('success'))
                    <span class="alert alert-success">
                        {{ session()->get('success') }}
                    </span>
                @endif

                @if (session()->has('failed'))
                    <span class="alert alert-error">
                        {{ session()->get('failed') }}
                    </span>
                @endif


                @csrf

                <h4 class="mobile">
                    <a href="{{ route('dashboard.menu') }}" id="back-to-menu">
                        <i class="lnr lnr-arrow-left"></i>
                    </a>
    
                    Add Member
                </h4>

                <div class="input-group clearfix">
                    <div class="pull-left">
                        <h4>Name</h4>

                        <input type="text" placeholder="Name" value="{{ old('name') }}" name="name" required>
        
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="pull-right">
                        <h4>Slug</h4>

                        <input type="text" placeholder="Slug" value="{{ old('slug') }}" name="slug" required>
        
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="pull-left">
                        <h4>Phone Number</h4>

                        <input type="text" placeholder="Phone Number" value="{{ old('phone_number') }}" name="phone_number" required>
        
                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                
                <h4>Select subcategory</h4>

                <select name="subCategoryId" required>
                    @foreach ($subCategories as $subCategory)
                        <option value="{{ $subCategory->id }}" {{ $subCategory->id == old('subCategoryId') ? 'selected' : ''}}>
                                {{ ucwords($subCategory->category->name) }} - {{ ucwords($subCategory->name) }}
                        </option>
                    @endforeach
                </select>

                <h4>Photo</h4>

                <input type="file" name="cover" accept="image/*" required>

                @error('cover')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

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
            CKEDITOR.replace('shortDescription');
        });
    </script>
@endpush