@extends('main')

@section('title', 'Saved Items | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        @include('customer.dashboard.menu')

        <wishlist-catalogue></wishlist-catalogue>
    </section>
@endsection

@section('components')
    <template id="wishlist-template">
        <article class="card pull-right">

            <h3 class="section-title desktop">
                My saved items
            </h3>

            <h3 class="mobile section-title" id="card-header">
                <a href="{{ route('customer.profile.menu') }}" id="back-to-menu">
                    <i class="lnr lnr-arrow-left"></i>
                </a>

                My saved items
            </h3>
    
            <div id="products-container" v-if="products.length > 0">
                <product-saved-item v-for='product in products' :key="product.id" :product="product" @remove="removeFromWishlist"></product-saved-item>
            </div>

            <div v-else id="no-products">
                <h4>No products in saved items</h4>
            </div>

            <div id="loading">
                <pulse-loader :loading="true" :color="'#c82088'" :size="'12px'" :margin="'6px'"></pulse-loader>
            </div>

        </article>
    </template>

    @include('customer.partial.product-saved-item')
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/customer/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/wishlist.css') }}">
@endsection

@push('script')
    <script src="{{ asset('js/vue-spinner.min.js') }}"></script>

    <script>
        Vue.component('wishlist-catalogue', {
            template: '#wishlist-template',
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

                    axios.get("{{ route('customer.wishlist') }}", {

                        params: {
                            page: nextPage
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
                removeFromWishlist(id) {

                    if (confirm('Are you sure to remove product from saved items')) {

                        let url = "{{ route('customer.wishlist.destroy', ':id') }}";

                        axios.delete(url.replace(':id', id), {

                            data: {id}
                        })
                        .then(() => {

                            alert('Product has been removed from saved items');

                            store.commit('removeFromWishList', id);

                            this.products = this.products.filter(product => product.id != id);
                        })
                        .catch(console.error);
                    }
                }
            }
        });
    </script>
@endpush