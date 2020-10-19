@extends('main')

@section('content')
    <div id="first-page-preloader">
        <img src="{{ asset('images/dms.png') }}" alt="{{ config('app.name') }}">

        <div id="line-preloader"></div>
    </div>

    <template>
        <div>
            <section>
                <h3 class="section-title clearfix">
                    <span class="pull-left">
                        Top deals
                    </span>
                </h3>
                
                <div class="products-container clearfix">
                    <product-item v-for='product in featuredProducts' key="product.id" :product="product"></product-item>
                </div>

                <div class="category-container" v-for="(category, index) in categories" :key="index">
                    <h3 class="section-title clearfix">
                        <span class="pull-left">
                            @{{ category.name }}
                        </span>
                        <a :href="category.url" class="pull-right">
                            View all
                        </a>
                    </h3>

                    <div class="products-container clearfix">
                        <product-item v-for='product in products.filter(product => product.categoryId == category.id)' :key="product.id" :product="product"></product-item>
                    </div>

                    {{-- <div class="banners-container clearfix" v-if="category.id == 1">
                        <img src="images/banner-custom.jpg" alt="banner" class="banner pull-left">
                        <img src="images/banner-location.jpg" alt="banner" class="banner pull-right">
                    </div> --}}
                </div>
            </section>
    
            {{-- <social-media></social-media> --}}
        
            {{-- <h4 class="clearfix" id="map-img-title">
                <span class="pull-left">
                    Our location
                </span>
                <a href="https://www.google.com/maps/place/Baby+Cot+Kenya/@-1.2568881,36.8738981,15z/data=!4m5!3m4!1s0x0:0x3e557008a3279e0e!8m2!3d-1.2568881!4d36.8738981" class="pull-right">
                    <i class="lni-map-marker" target="_blank"></i>
                    view on google maps
                </a>
            </h4>
            
            <a href="https://www.google.com/maps/place/Baby+Cot+Kenya/@-1.2568881,36.8738981,15z/data=!4m5!3m4!1s0x0:0x3e557008a3279e0e!8m2!3d-1.2568881!4d36.8738981" target="_blank" id="map-img">
                <img src="/images/baby-cot-kenya-map.jpg" alt="Alami Home Fashions Location" id="map-img">
            </a> --}}
        </div>
    </template>

    @include('customer.partial.product-item')

    <template id="social-media-template">
        <div id="instagramFeed">

            <a href="https://www.instagram.com/babycotkenya/" target="_blank" id="instagram-feed-title">
                <i class="lni-instagram-original"></i>
                {{ config('app.name') }} on Instagram
            </a>
            
            <div id="instagram-feed-container">
                <carousel :autoplay="true" :pagination-enabled="false" :per-page-custom="[[768, 3], [1024, 4]]" :navigation-enabled="true" :navigation-next-label="sliderNav.next" :navigation-prev-label="sliderNav.previous" :autoplay-timeout="3000">
                    <slide v-for="(feed, index) in igFeed" :key="index">
                        <a :href="feed.link" class="instagram-post" target="_blank">
                            <div class="instagram-post-summary">
                                <h4 class="clearfix">
                                    <span class="pull-left">
                                        <i class="lni-heart"></i>
                                        @{{ feed.likes.count }}
                                    </span>
                                    <span class="pull-right">
                                        <i class="lni-bubble"></i>
                                        @{{ feed.comments.count }}
                                    </span>
                                </h4>
                                <p class="instagram-feed-caption">
                                    @{{ feed.caption.text }}
                                </p>
                            </div>
                            <img :src="feed.images.standard_resolution.url" alt="alami fashions instagram feed" class="instagram-feed-img">
                        </a>
                    </slide>
                </carousel>
            </div>
            <div class="clearfix" id="social-media-links">
                <div class="pull-left" id="social-media-text">
                    <h4>Follow us on social media</h4>
                </div>
                <div class="pull-left" id="social-media-icons">
                    <a href="https://www.facebook.com/BabyCotKenya/" target="_blank">
                        <i class="lni-facebook-filled"></i>
                    </a>
                    <a href="https://www.instagram.com/babycotkenya/" target="_blank">
                        <i class="lni-instagram-original"></i>
                    </a>
                    <a href="https://twitter.com/BabyCotKenya" target="_blank">
                        <i class="lni-twitter-filled"></i>
                    </a>
                </div>
            </div>
        </div>
    </template>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product/item.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <style>
        @keyframes scroll {
            50% {
                background-size: 80%;
            }
            100% {
                background-position: 125% 0;
            }
        }
        #first-page-preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            display: block;
            text-align: center;
            padding-top: 20%;
            z-index: 3024;
        }
        #first-page-preloader img {
            width: 150px;
        }
        #line-preloader {
            margin: 20px auto;
            width: 200px;
            height: 4px;
            background: linear-gradient(to right, #5c2094, #5c2094);
            background-color: #ccc;
            border-radius: 4px;
            background-size: 20%;
            background-repeat: repeat-y;
            background-position: -25% 0;
            animation: scroll 1.2s ease-in-out infinite;
        }
        #instagram-feed-title {
            font-size: 25px;
            font-weight: 500;
            color: #5c2094;
            margin-bottom: 21px;
            display: block;
            border-bottom: 1px solid #dadada;
            padding: 0 5% 10px;
            background: #f6f4ee;
        }
        #instagram-feed-title:hover {
            color: #c82088;
        }
        #instagram-feed-title i {
            font-size: 21px;
            font-weight: bold;
        }
        #instagram-feed-container {
            background: #fff;
            padding-top: 15px;
        }
        #instagram-feed-container .VueCarousel > .VueCarousel-navigation {
            position: absolute !important;
            top: -65px;
            right: 15%;
        }
        #instagram-feed-container button.VueCarousel-navigation-button i {
            font-size: 33px !important;
            color: #5c2094 !important;
        }
        #instagram-feed-container button.VueCarousel-navigation-button:not(.VueCarousel-navigation--disabled):hover i {
            color: #c82088 !important;
        }
        .VueCarousel-slide {
            flex-basis: inherit;
            margin: 0 5px;
        }
        .instagram-post {
            position: relative;
            display: block;
        }
        .instagram-post-summary {
            position: absolute;
            top: 0;
            left: 0;
            width: 80%;
            height: 80%;
            background: rgba(0, 0, 0, .5);
            color: #fff;
            padding: 10%;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .instagram-post:hover .instagram-post-summary {
            opacity: 1;
        }
        .instagram-post-summary > h4 {
            width: 50%;
            margin: auto;
        }
        .instagram-post-summary > h4 span {
            font-size: 20px;
            font-weight: 500;
        }
        .instagram-post-summary > h4 span i {
            font-weight: bold;
            font-size: 16px;
        }
        .instagram-feed-caption {
            font-size: 12px;
            text-align: center;
            margin: 20px 0 0;
        }
        .instagram-feed-img {
            width: 100%;
        }
        #social-media-links {
            padding: 40px 5%;
            background: #fff;
            display: flex;
            align-items: center;
        }
        #social-media-text {
            margin-right: 20px;
        }
        #social-media-icons a {
            display: inline-block;
            padding: 15px;
            margin: 0 5px;
            background: #5c2094;
        }
        #social-media-icons a i {
            font-size: 1.5em;
            font-weight: bold;
            color: #fff;
        }
        #social-media-icons a:hover {
            background: #c82088;
        }
        #social-media-text h4 {
            font-size: 1.4em;
            font-weight: 600;
            color: #5c2094;
        }

        @media (max-width: 767px) {
            #first-page-preloader {
                padding-top: 52%;
            }
            #first-page-preloader img {
                width: 100px;
            }
            #line-preloader {
                width: 140px;
            }
            #instagram-feed-title {
                display: flex;
                align-items: center;
                font-size: 12px;
                margin: 0;
            }
            #instagram-feed-title i {
                margin-right: 5px;
            }
            #instagram-feed-container .VueCarousel > .VueCarousel-navigation {
                top: -35px;
            }
            #instagram-feed-container button.VueCarousel-navigation-button i {
                font-size: 20px !important;
            }
            #social-media-text {
                margin-right: 9px;
            }
            #social-media-text h4 {
                font-size: 13px;
            }
            #social-media-icons a {
                padding: 7px;
                margin: 0 2px;
            }
            #social-media-icons a i {
                font-size: 15px;
            }
        }
    </style>
@endsection

@push('script')
    <script src="{{ asset('js/vue-carousel.min.js') }}"></script>

    <script>
        jQuery(document).ready(function ($) {
            // Remove preloader after 2 seconds
            setTimeout(() => $('#first-page-preloader').css('display', 'none'), 2000);
        });
    </script>

    <script>
        Vue.use(VueCarousel);

        Vue.component('social-media', {
            template: '#social-media-template',
            components: {
                carousel: VueCarousel.Carousel, slide: VueCarousel.Slide
            },
            data: () => ({
                igFeed: []
            }),
            computed: {
                sliderNav() {
                    return {
                        previous: '<i class="lni-arrow-left"></i>',
                        next: '<i class="lni-arrow-right"></i>'
                    };
                }
            },
            created() {
                this.getFeed();
            },
            methods: {
                getFeed() {
                    axios.get(
                        'https://api.instagram.com/v1/users/self/media/recent?access_token=557353290.1677ed0.37bfac5e2eab45708c608a43af6bf66d'
                    )
                    .then(response => this.igFeed = response.data['data'])
                    .catch(console.error);
                }
            }
        });

        Vue.component('home', {
            template: '#home-template',
            data: () => ({
                products: []
            }),
            computed: {
                categories() {
                    return @json($categories).filter(category => [1,2,3,5,12].includes(category.id));
                },
                featuredProducts() {
                    return this.products.filter(product => product.topDeal == true);
                }
            },
            created() {
                this.products = this.products.concat(

                    @json($featuredProducts).map(product => {

                        product.topDeal = true;
                        return product;

                    })
                    .concat(

                        this.categories.map(category => category.products.map(product => {

                            product.categoryId = category.id;
                            return product;

                        })).reduce((carry, next) => {
                            
                            carry = carry.concat(next);

                            return carry;
                        }, [])
                    )
                );
            }
        });
    </script>
@endpush