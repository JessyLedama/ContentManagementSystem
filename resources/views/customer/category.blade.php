@extends('main')

@section('title', ucfirst($category->seo->title ?? $category->name) . ' | ' . config('app.name'))

@section('seo')
    <meta name="keywords" content='{{ ucfirst($category->seo->keywords ?? "$category->name, config('app.name')") }}'>
    <meta name="description" content='{{ ucfirst($category->seo->description ?? $category->name) }}'>
@endsection

@section('content')
    <product-catalogue></product-catalogue>

    @unless (empty($category->description))
        <div id="seo-copy">
            {!! $category->description !!}
        </div>
    @endunless
@endsection

@section('components')
    <template id="catalogue-template">
        <section>
            <h3 class="section-title clearfix">
                {{ $category->name }}
                <small>
                    ({{ number_format($count) }} members found)
                </small>
            </h3>
    
            <div class="products-container clearfix" v-if="products.length > 0">
                <product-item v-for='product in products' :key="product.id" :product="product"></product-item>
            </div>

            <div v-else id="no-products">
                <h4>No members found</h4>
            </div>

            <div id="loading">
                <pulse-loader :loading="true" :color="'#c82088'" :size="'12px'" :margin="'6px'"></pulse-loader>
            </div>
        </section>
    </template>

    @include('customer.partial.product-item')
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product/item.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product/catalogue.css') }}">
@endsection

@push('script')
    <script src="{{ asset('js/vue-spinner.min.js') }}"></script>

    <script>
        Vue.component('product-catalogue', {
            template: '#catalogue-template',
            components: {
                PulseLoader: VueSpinner.PulseLoader
            },
            data: () => ({
                products: @json($products->items()),
                subcategories: @json($category->subCategories),
                currentPage: {{ $products->currentPage() }},
                lastPage: {{ $products->lastPage() }}
            }),
            created() {

                jQuery(window).on('scroll', () => {

                    const parentWindow = jQuery(window);
                    const productsContainer = jQuery('section .products-container');
                    
                    if (parentWindow.scrollTop() >= productsContainer.offset().top + productsContainer.outerHeight() - parentWindow.innerHeight() && this.currentPage < this.lastPage && jQuery('#loading').css('display') == 'none') {

                        jQuery('#loading').css('display', 'block');

                        this.lazyLoadProducts();
                    }
                });
            },
            methods: {
                lazyLoadProducts() {

                    const nextPage =  this.currentPage + 1;
                    const search = new URL(window.location.href).searchParams;

                    axios.get("{{ $category->url }}", {

                        params: {
                            page: nextPage,
                            minPrice: search.get('minPrice') || '',
                            maxPrice: search.get('maxPrice') || '',
                            order: search.get('order') || ''
                        },

                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(({data}) => {

                        this.products = this.products.concat(data);
                        this.currentPage = nextPage;

                        jQuery('#loading').css('display', 'none');
                    })
                    .catch(console.error);
                },
                viewSubcategory() {

                    window.location.href = this.subcategories.find(subcategory => subcategory.slug == jQuery('#subcategory').val()).url;
                },
                sortProducts() {

                    document.getElementById('filter-products').submit();
                }
            }
        });
    </script>
@endpush