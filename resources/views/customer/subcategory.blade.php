@extends('main')

@section('title', ucfirst($subCategory->seo->title ?? $subCategory->name) . ' | ' . config('app.name'))

@section('seo')
    <meta name="keywords" content='{{ ucfirst($subCategory->seo->keywords ?? "$subCategory->name, config('app.name')") }}'>
    <meta name="description" content='{{ ucfirst($subCategory->seo->description ?? $subCategory->name) }}'>
@endsection

@section('content')
    <catalogue></catalogue>
@endsection

@section('components')
    <template id="catalogue-template">
        <section>
            <h3 class="section-title clearfix">
                {{ $subCategory->name }} {{ $subCategory->category->name }}
                <small>
                    ({{ number_format($count) }} products found)
                </small>
            </h3>
    
            <form id="filter-products" action="" method="get" class="clearfix">
                <div class="pull-left">
                    <div class="input-group">
                        <label for="subcategory">Select subcategory</label>
        
                        <select id="subcategory" @change="viewSubcategory">
                            <option value="{{ $subCategory->category->slug }}">All products</option>
                            
                            <option value="{{ $subCategory->slug }}" selected>
                                {{ $subCategory->name }}
                            </option>

                            <option v-for="(subcategory, index) in subcategories" :key="index" :value="subcategory.slug">
                                @{{ subcategory.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="pull-left">
                    <div class="input-group">
                        <label for="minPrice">Price</label>
        
                        <input type="number" name="minPrice" id="minPrice" value="{{ request()->query('minPrice') }}" placeholder="Min Price">

                        <span>&nbsp; - &nbsp;</span>

                        <input type="number" name="maxPrice" id="maxPrice" value="{{ request()->query('maxPrice') }}" placeholder="Max Price">
                    </div>

                    <button type="submit">Filter</button>
                </div>

                <div class="pull-right">
                    <div class="input-group">
                        <label for="sort-products">Sort by</label>
        
                        <select id="sort-products" name="order" @change="sortProducts">
                            <option value="latest" {{ request()->query('order') == 'latest' ? 'selected' : ''}}>
                                Latest
                            </option>
                            <option value="lowestPrice" {{ request()->query('order') == 'lowestPrice' ? 'selected' : ''}}>
                                Lowest price
                            </option>
                            <option value="highestPrice" {{ request()->query('order') == 'highestPrice' ? 'selected' : ''}}>
                                Highest price
                            </option>
                        </select>
                    </div>
                </div>
            </form>
    
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
        Vue.component('catalogue', {
            template: '#catalogue-template',
            components: {
                PulseLoader: VueSpinner.PulseLoader
            },
            data: () => ({
                products: @json($products->items()),
                currentPage: {{ $products->currentPage() }},
                lastPage: {{ $products->lastPage() }},
                subcategories: @json($subCategory->category->subCategories)
            }),
            created() {

                // Set current subcategory on select subcategory filter
                // jQuery('#subcategory').val('{{ $subCategory->slug }}');

                // Listen for scrolling down window event to load more content
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

                    axios.get("{{ $subCategory->url }}", {

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
                    
                    const slug = jQuery('#subcategory').val();
                    
                    // Check if 'All Products' and go to parent category page
                    if ('{{ $subCategory->category->slug }}' == slug)
                    
                        window.location.href = '{{ $subCategory->category->url }}';

                    else
                        // Go to subcategory page
                        window.location.href = this.subcategories.find(subcategory => subcategory.slug == slug).url;
                },
                sortProducts() {

                    document.getElementById('filter-products').submit();
                }
            }
        });
    </script>
@endpush