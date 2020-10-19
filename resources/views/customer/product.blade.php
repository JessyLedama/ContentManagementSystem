@extends('main')

@section('title', ucfirst($product->seo->title ?? $product->name) . ' | ' . config('app.name'))

@section('seo')
    <meta name="keywords" content='{{ ucfirst($product->seo->keywords ?? "$product->name, config('app.name')") }}'>
    <meta name="description" content='{{ ucfirst($product->seo->description ?? $product->name) }}'>
@endsection

@section('content')
    <product-page></product-page>
@endsection

@section('components')
    <template id="product-template">
        <section>
            <div id="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                &nbsp; &rsaquo; &nbsp;
                <a :href="product.sub_category.category.url">@{{ product.sub_category.category.name }}</a>
                &nbsp; &rsaquo; &nbsp;
                <a :href="product.sub_category.url">@{{ product.sub_category.name }}</a>
                &nbsp; &rsaquo; &nbsp;
                <span>@{{ product.name }}</span>
            </div>

            <div id="product-summary" class="clearfix">
                <div id="product-media" class="pull-left">
                    <div id="product-gallery">
                        <img :src="product.coverUrl" id="product-cover" @click="cover = product.cover">
                        <img v-for="(image, index) in gallery" :key="index" :src="image.url" @click="cover = image.url">
                    </div>
                    <img :src="cover" :alt="product.name" id="product-cover">
                </div>
                <div id="product-info" class="pull-right">
                    <h2 id="product-name">@{{ product.name }}</h2>
                    <div id="product-likes">
                        <i class="lni-heart"></i>
                        <span>@{{ product.totalLikes }} Loving it</span>
                    </div>
                    <div id="product-social-share">
                        <span>Share:</span>
                        <a target="blank" :href="`https://www.facebook.com/sharer/sharer.php?u=${product.url}`">
                            <i class="lni-facebook-filled"></i>
                        </a>
                        <a target="blank" :href="`https://twitter.com/intent/tweet?text=${product.name}&url=${product.url}`">
                            <i class="lni-twitter-filled"></i>
                        </a>
                        <a class="whatsapp" target="blank" :href="`whatsapp://send?text=${product.url}`">
                            <i class="lni-whatsapp"></i>
                        </a>
                    </div>

                    @auth
                        @if (Auth::user()->role == 'admin')

                            <a href="{{ route('product.edit', $product) }}">
                                Edit product
                            </a>
                            
                        @endif
                    @endauth

                    <div id="product-short-description" v-html="product.shortDescription"></div>
                    <div id="product-purchase" class="clearfix">
                        <div class="pull-left">
                            <span id="product-price">Ksh. {{ number_format($product->price) }}</span>
                            <span id="product-regular-price">Ksh. {{ number_format($product->regular_price) }}</span>
                        </div>
                        <div class="pull-right" id="cart-wishlist">
                            <a href="{{ route('customer.wishlist') }}" v-if="savedItems.some(item => item == product.id)" id="view-saved-item">
                                View saved items
                            </a>

                            <template v-if="savedItems.some(item => item == product.id)" id="view-saved-item">
                                <a @click="saveToWishList" v-else id="save-item-btn">
                                    <i class="lni-add-file"></i>
                                    Save for later
                                </a>

                                <a onclick='window.location.href = "{{ route('cart.page') }}"' v-if="cart.some(item => item.id == product.id)" id="view-cart-btn">
                                    View cart
                                </a>
                            </template>

                            <a id="cart-btn" @click="buy" v-else>Buy now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="product-tabs">
                <div id="tabs-title">
                    <h3 class="tabs-title active" data-target="product-reviews" @click="toggleTabs(1)">Reviews</h3>
                    <h3 class="tabs-title" data-target="product-description" @click="toggleTabs(2)">Description</h3>
                    <h3 class="tabs-title" data-target="product-delivery" @click="toggleTabs(3)">Delivery</h3>
                </div>
                <div class="tabs-content active" id="product-reviews">
                    <div class="clearfix" id="reviews-summary" v-if="product.reviews.length > 0">
                        <div class="pull-left clearfix">
                            <div class="review-star-average">
                                <span class="review-star-count">
                                    5 stars
                                </span>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <span class="review-count">
                                    (@{{ product.reviews.filter(review => review.rating == 5).length }})
                                </span>
                            </div>
                            <div class="review-star-average">
                                <span class="review-star-count">
                                    4 stars
                                </span>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star"></i>
                                <span class="review-count">
                                    (@{{ product.reviews.filter(review => review.rating == 4).length }})
                                </span>
                            </div>
                            <div class="review-star-average">
                                <span class="review-star-count">
                                    3 stars
                                </span>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star"></i>
                                <i class="lni-star"></i>
                                <span class="review-count">
                                    (@{{ product.reviews.filter(review => review.rating == 3).length }})
                                </span>
                            </div>
                            <div class="review-star-average">
                                <span class="review-star-count">
                                    2 stars
                                </span>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star"></i>
                                <i class="lni-star"></i>
                                <i class="lni-star"></i>
                                <span class="review-count">
                                    (@{{ product.reviews.filter(review => review.rating == 2).length }})
                                </span>
                            </div>
                            <div class="review-star-average">
                                <span class="review-star-count">
                                    1 star
                                </span>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star"></i>
                                <i class="lni-star"></i>
                                <i class="lni-star"></i>
                                <i class="lni-star"></i>
                                <span class="review-count">
                                    (@{{ product.reviews.filter(review => review.rating == 1).length }})
                                </span>
                            </div>
                        </div>
                        <div class="pull-left">
                            <div id="reviews-average">
                                <h4>
                                    @{{ parseInt(product.reviews.reduce((carrier, next) => carrier + next.rating, 0) / product.reviews.length) }}
                                </h4>
                                <small>out of 5</small>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star-filled"></i>
                                <i class="lni-star"></i>
                            </div>
                            <div id="reviews-total">
                                @{{ product.reviews.length }} reviews
                            </div>
                        </div>
                        <div class="pull-left">
                            <div id="reviews-commentary">
                                <h4>
                                    @{{ parseInt(product.reviews.filter(review => review.recommend).length / product.reviews.length * 100)  }}&#37;
                                </h4>
                                <small>Would recommend this product to friend</small>
                            </div>
                        </div>
                    </div>
                    <h3 id="no-reviews" v-else>
                        Be the first to leave a review
                    </h3>
                    <div id="review-form">
                        <form @submit.prevent="postReview" method="post" id="post-review-form" class="clearfix">
                        <img :src="cover" :alt="product.name" class="pull-left">
                        <div class="pull-right">
                            <span id="close-review" @click="closeReviewForm">
                                Close x
                            </span>
                            <h4>Leave your review</h4>
                            <div class="input-group" id="star-rating">
                                <label>Overall rating</label>
                                <input type="hidden" name="rating" value="1">
                                <i class="lni-star" v-for="(i, index) in Array(5)" :key="index" @click="rate(index + 1)"></i>
                            </div>
                            <input type="text" name="title" placeholder="Review title" required>
                            <textarea name="comment" placeholder="Your review"></textarea>
                            <div id="review-policy">
                                When writing a review please refrain from:
                                <ul>
                                    <li>Directly naming other companies or products good or bad.</li>
                                    <li>Using inappropriate or profane language.</li>
                                    <li>Disclosing personally identifiable information.</li>
                                </ul>
                            </div>
                            <div id="recommendation">
                                <label>Would you recommend this product to a friend?</label>
                                <div class="input-group">
                                    <input type="radio" name="recommend" value="true"> <span>Yes</span>
                                    <input type="radio" name="recommend" value="false"> <span>No</span>
                                </div>
                            </div>
                            <div class="input-group" id="review-user-info">
                                <label>Your name</label>
                                <input type="text" name="name" placeholder="Full name" required>
                            </div>
                            <button type="submit">Submit</button>
                        </div>
                        </form>
                        <button type="button" @click="showReviewForm">
                            <span>Write a review</span>
                        </button>
                    </div>
                    <div id="reviews">
                        <div class="clearfix review" v-for="(review, index) in product.reviews" :key="index">
                            <div class="pull-left">
                                <h5 class="review-user">@{{ review.name }}</h5>
                                <small class="review-date">
                                    @{{ review.posted }}
                                </small>
                            </div>
                            <div class="pull-left">
                                <h4 class="review-title">@{{ review.title }}</h4>
                                <p class="review-desc">
                                    @{{ review.comment }}
                                </p>
                            </div>
                            <div class="pull-right">
                                <div class="review-rating">
                                    <i class="lni-star-filled" v-for="i in Array(review.rating)" :key="i"></i>
                                    <i class="lni-star" v-for="i in Array(5 - review.rating)" :key="i"></i>
                                    <span>
                                        <sup>@{{ review.rating }}</sup>/<sub>5</sub>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tabs-content" id="product-description" v-html="product.description"></div>
                <div class="tabs-content" id="product-delivery">
                    <p>
                        Ksh 2000 for delivery within Nairobi. Ksh. 3000 for delivery outside Nairobi.
                    </p>
                </div>
            </div>

            <div id="related-products" v-if="relatedProducts.length > 0">
                <h3>You may also like</h3>
                <div class="products-container clearfix">
                    <product-item v-for="product in relatedProducts" :key="product.id" :product="product"></product-item>
                </div>
            </div>
        </section>
    </template>

    @include('customer.partial.product-item')
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product/item.css') }}">

    <style>
        #related-products .products-container > .product {
            width: calc(20% - 22px);
            margin: 10px;
            padding: 5px;
            border: 1px solid;
            border-color: transparent;
            flex: 0 0 auto;
            max-width: calc(20% - 22px);
        }

        @media (max-width: 767px) {
            #related-products .products-container > .product {
                width: calc(100% - 22px);
                max-width: calc(60% - 22px);
            }
        }
    </style>
@endsection

@push('script')
    <script>
        Vue.component('product-page', {
            template: '#product-template',
            data: () => ({
                product: @json($product),
                cover: null
            }),
            computed: {
                cart() {
                    return store.getters.shoppingCart;
                },
                gallery() {
                    return this.product.images;
                },
                relatedProducts() {
                    return this.product.sub_category.category.products;
                },
                user() {
                    return store.getters.currentUser;
                },
                savedItems() {
                    return store.getters.savedItems;
                }
            },
            created() {
                this.cover = this.product.coverUrl;
            },
            methods: {
                buy() {
                    store.commit('addToCart', this.product.id);
                    alert('Product has been added to cart');
                },
                postReview() {
                    const {
                        title: {value: title},
                        rating: {value: rating},
                        name: {value: name},
                        comment: {value: comment},
                        recommend: {value: recommend}
                    } = jQuery('#post-review-form')[0];

                    axios.post("{{ route('product.review') }}", {
                        title,
                        rating: parseInt(rating),
                        name, comment,
                        productId: this.product.id,
                        recommend: recommend == "true"
                    })
                    .then(({data}) => {
                        this.product.reviews.unshift(data);

                        alert('Thank you for reviewing this product');

                        jQuery('#post-review-form')[0].reset();
                        jQuery('#star-rating i').removeClass('lni-star').removeClass('lni-star-filled').addClass('lni-star');
                    })
                    .catch(console.log);
                },
                saveToWishList() {
                    if (this.user) {
                        axios.post("{{ route('customer.wishlist.store') }}", {
                            id: this.product.id
                        })
                        .then(() => {
                            store.commit('addToWishList', this.product.id);
                            alert('Product has been added to saved items');
                        })
                        .catch(console.error);
                    }
                    else window.location.href = "{{ route('login') }}";
                },
                rate(value) {
                    jQuery('input[name="rating"]').val(value);
                    jQuery('#star-rating i').removeClass('lni-star').removeClass('lni-star-filled').addClass('lni-star');
                    jQuery('#star-rating i').slice(0, value).removeClass('lni-star').addClass('lni-star-filled');
                },
                showReviewForm() {
                    jQuery('#post-review-form').css('display', 'block');
                },
                closeReviewForm() {
                    jQuery('#post-review-form').css('display', 'none');
                },
                toggleTabs(id) {
                    const tab = jQuery(`#product-tabs .tabs-title:nth-child(${id})`);

                    jQuery('#product-tabs .tabs-title').removeClass('active');
                    tab.addClass('active');

                    jQuery('#product-tabs .tabs-content').removeClass('active');
                    jQuery('#' + tab.attr('data-target')).addClass('active');
                }
            }
        });
    </script>
@endpush