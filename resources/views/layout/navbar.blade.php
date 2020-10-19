<template id="nav-bar-template">
    <header>

        <nav class="desktop">
            <div id="top-bar" class="clearfix">

                <a href="{{ route('home') }}" id="logo" class="pull-left">
                    <img src="{{ asset('images/dms.png') }}" alt="{{ config('app.name') }}">
                </a>

                <div id="menu" class="pull-right">
                    @auth
                        <a id="toggle-account-drop-down">
                            <i class="lnr lnr-user"></i>

                            <span>
                                Hi @{{ user.name.split(' ')[0] }}
                            </span>

                            <ul class="account-dropdown" id="account-dropdown-desktop">
                                <li>
                                    <span onclick="window.location.href = `{{ route(Auth::user()->role == 'customer' ? 'customer.profile.edit' : 'dashboard') }}`">
                                        <i class="lnr lnr-user"></i>

                                        My Account
                                    </span>
                                </li>
                                
                                <li>
                                    <span onclick="document.getElementById('logout-form').submit()">
                                        Logout
                                    </span>
                                </li>
                            </ul>
                        </a>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}">
                            <i class="lnr lnr-user"></i>

                            <span>Login &vert; Sign up</span>
                        </a>
                    @endguest

                </div>
            </div>

            <!-- <ul id="categories">
                <li v-for="(category, index) in categories" :key="index" @click="toggleNavDropDown(category.id)"  @mouseenter="toggleNavDropDown(category.id)" @mouseleave="toggleSubCategory = null">

                    <a :href="category.url">
                        @{{ category.name }}
                        <i class="lnr lnr-chevron-down"></i>
                    </a>

                    <ul class="sub-categories" v-show="toggleSubCategory == category.id">
                        <li v-for="(subCategory, index) in category.sub_categories" :key="index">
                            <a :href="subCategory.url">
                                @{{ subCategory.name }}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul> -->
        </nav>

        <nav class="mobile">
            <div id="top-bar" class="clearfix">
                <a href="{{ route('home') }}" id="logo" class="pull-left">
                    <img src="{{ asset('images/JGPMC.png') }}" alt="{{ config('app.name') }}">
                </a>

                <div id="menu" class="pull-right">
                    @auth
                        <a href="{{ route(Auth::user()->role == 'customer' ? 'customer.profile.menu' : 'dashboard.menu') }}">
                            
                            <i class="lnr lnr-user"></i>

                            <span>
                                Hi @{{ user.name.split(' ')[0] }}
                            </span>
                        </a>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}">
                            <i class="lnr lnr-user"></i>

                            <span>Login &vert; Sign up</span>
                        </a>
                    @endguest

                </div>
            </div>

            <!-- <ul id="categories">
                <li v-for="(category, index) in categories" :key="index">

                    <a :href="category.url">
                        @{{ category.name }}
                    </a>

                </li>
            </ul> -->
        </nav>

        <!--logout form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf

        </form>

    </header>
</template>

@push('script')
    <script>
        jQuery(document).ready(function ($) {

            // Listen for desktop mouse hover on account link
            $('#toggle-account-drop-down').hover(function () {

                // Show or close account drop down
                jQuery('#account-dropdown-desktop').toggleClass('show');
            });
        });
    </script>

    <script>
        Vue.component('nav-bar', {
            template: '#nav-bar-template',
            data: () => ({
                toggleSubCategory: null,
                searchTerm: '',
                autocompleteProducts: @json(App\Product::latest()->get()->pluck('name')),
                suggestions: [],
                categories: @json(App\Category::with('subCategories')->get())
            }),
            computed: {
                user() {
                    return store.getters.currentUser;
                },
                cart() {
                    return store.getters.shoppingCart;
                }
            },
            watch: {
                searchTerm(value) {
                    this.suggestions = this.autocompleteProducts.filter(product => product.toLowerCase().split(' ').some(name => value.includes(name)));
                }
            },
            created() {
                // set navigation position on window scroll
                jQuery(window).scroll(function(){
                    if (jQuery(this).scrollTop() > 92) {
                        jQuery('#categories, #logo, .sub-categories').addClass('fix');
                    } else {
                        jQuery('#categories, #logo, .sub-categories').removeClass('fix');
                    }
                });
                
                jQuery('.sub-categories').css('top', jQuery('header').height());
            },
            methods: {
                toggleNavDropDown(id) {
                    this.toggleSubCategory = this.toggleSubCategory == id ? null : id;
                },
                toggleAccountDropDown(viewport) {
                    console.log('show on', viewport)
                    jQuery('#account-dropdown-' + viewport).toggleClass('show');
                }
            }
        });
    </script>
@endpush