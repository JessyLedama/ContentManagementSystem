@extends('main')

@section('title', ucfirst(request()->query('term')) . ' | Search | ' . config('app.name'))

@section('content')
    <search></search>
@endsection

@section('components')
    <template id="search-template">
        <section>
            <h3 class="section-title clearfix">
                Search result
                <small>
                    ({{ number_format($count) }} products found)
                </small>
            </h3>
    
            <div class="products-container clearfix" v-if="products.length > 0">
                <product-item v-for='product in products' :key="product.id" :product="product"></product-item>
            </div>

            <div v-else id="no-products">
                <h4>No products found</h4>
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
        Vue.component('search', {
            template: '#search-template',
            components: {
                PulseLoader: VueSpinner.PulseLoader
            },
            data: () => ({
                products: @json($products->items()),
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

                    axios.get("{{ route('search') }}", {

                        params: {
                            page: nextPage,
                            term: search.get('term') || '',
                            category: search.get('category') || '',
                            minPrice: search.get('minPrice') || '',
                            maxPrice: search.get('maxPrice') || ''
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
                }
            }
        });
    </script>
@endpush