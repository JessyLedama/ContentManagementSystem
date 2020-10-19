@extends('main')

@section('title', 'Edit Member Details | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('dashboard.menu')

        <article class="card pull-right">
            <form action="{{ route('product.update', $product) }}" method="post" id="form" enctype="multipart/form-data">

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

                @method('PUT')

                <h4>Name</h4>

                <input type="text" placeholder="Name" value="{{ old('name', $product->name) }}" name="name" required>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <h4>Phone Number</h4>

                <input type="text" placeholder="Phone Number" value="{{ old('phone_number', $product->phone_number) }}" name="phone_number" required>

                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <h4>Slug</h4>

                <input type="text" placeholder="Slug" value="{{ old('slug', $product->slug) }}" name="slug" required>

                @error('slug')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror




                <h4>Select subcategory</h4>

                <select name="subcategoryId" required>
                    @foreach ($subCategories as $subCategory)
                        <option value="{{ $subCategory->id }}" {{ $subCategory->id == old('subcategoryId', $product->subcategoryId) ? 'selected' : ''}}>
                            {{ ucwords($subCategory->name) }} - {{ ucwords($subCategory->category->name) }}
                        </option>
                    @endforeach
                </select>

                <h4>Change photo</h4>

                <input type="file" name="cover" accept="image/*">

                <img src="{{ $product->coverUrl }}" width="150">

                @error('cover')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <button type="submit">Update</button>
            </form>
        </article>
    </section>
@endsection

@section('components')
    <template id="product-gallery-template">
        <div>
            <h4>Gallery</h4>

            <input type="file" name="gallery[]" accept="image/*" multiple>

            <div class="gallery-image" v-for="(image, index) in gallery" :key="index">

                <img :src="image.url" width="150">
    
                <a @click="deleteFromGallery(image.id)">
                    Delete
                </a>
    
            </div>
        </div>
    </template>
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

    <script>
        Vue.component('product-gallery', {
            template: '#product-gallery-template',
            data: () => ({
                gallery: @json($product->images)
            }),
            methods: {
                deleteFromGallery(id) {

                    if (confirm('Are you sure to delete this image')) {

                        axios.delete(`{{ route('product.destroy.gallery', $product) }}`, {

                            data: {
                                index: id,
                                _method: 'DELETE'
                            }
                        })
                        .then(() => {
                            alert('Image has been removed from gallery');

                            this.gallery = this.gallery.filter(image => image.id != id);
                        })
                        .catch(console.error);
                    }
                }
            }
        });
    </script>
@endpush