<template id="product-saved-item-template">
    <div class="product clearfix">

        <a :href="product.url" class="product-cover-link pull-left">
            <div class="before">
                <i class="fas fa-baby"></i>
            </div>

            <img :src="product.coverUrl" :alt="product.name" class="product-cover">
        </a>

        <div class="pull-left product-info">
            <h4 class="product-name">@{{ product.name }}</h4>

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

        <div class="pull-right manage-product">
            <span @click="remove">

                <i class="lnr lnr-trash"></i> Remove

            </span>
        </div>

    </div>
</template>
    
@push('script')
    <script> 
        Vue.component('product-saved-item', {
            template: '#product-saved-item-template',
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
                },
                remove() {
                    this.$emit('remove', this.product.id);
                }
            }
        })
    </script>
@endpush