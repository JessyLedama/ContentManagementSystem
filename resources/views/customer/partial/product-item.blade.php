<template id="product-item-template">
    <div class="product pull-left">
        <a :href="product.url" class="product-cover-link">
            <div class="before">
                <i class="fas fa-baby"></i>
            </div>
            <img :src="product.coverUrl" :alt="product.name" class="product-cover">
        </a>
        <h4 class="product-name">
            @{{ product.name }}
        </h4>
        <p class="product-price">
            <small class="regular-price">
                Ksh.@{{ parseInt(product.regular_price) }}
            </small>
            <span class="sale-price">
                Ksh.@{{ parseInt(product.price) }}
            </span>
        </p>
        <div class="product-additions clearfix">
            <a class="product-likes pull-left">
                <i :class="favourite ? 'lni-heart-filled' : 'lni-heart'" @click="likeProduct"></i>
                <span :class="'count' + (favourite ? ' liked' : '')">@{{ likes }} Loving it</span>
            </a>
            <a class="view-product pull-right" :href="product.url">
                View
            </a>
        </div>
    </div>
</template>
    
@push('script')
    <script> 
        Vue.component('product-item', {
            template: '#product-item-template',
            props: ['product'],
            computed: {
                likes() {
                    return this.product.totalLikes;
                },
                user() {
                    return store.getters.currentUser;
                },
                favourite() {
                    return this.product.customerFavourite;
                }
            },
            methods: {
                likeProduct() {

                    if (this.user) {
                        
                        if (this.favourite) {
                            axios.delete("{{ route('product.unlike') }}", {
                                data: {
                                    id: this.product.id
                                }
                            })
                            .then(() => {
                                this.product.totalLikes = this.product.totalLikes - 1;
                                this.product.customerFavourite = false;
                            })
                            .catch(console.error);
                        }
                        else {
                            axios.post("{{ route('product.like') }}", {
                                id: this.product.id
                            })
                            .then(() => {
                                alert('Thank you for liking this product');
                                this.product.totalLikes = this.product.totalLikes + 1;
                                this.product.customerFavourite = true;
                            })
                            .catch(console.error);
                        }
                        
                    }
                    else window.location.href = "{{ route('login') }}";
                }
            }
        })
    </script>
@endpush