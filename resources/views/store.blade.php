@prepend('script')
    <script>
        function initUser() {
            const user = @json(Auth::check() ? Auth::user() : null);
            return !user ? null: user;
        }
    
        function loadCart() {
            const cart = localStorage.getItem('cart');
            return !cart ? [] : JSON.parse(cart);
        }
    
        function loadWishList() {
            const wishList = @json(Auth::check() ? Auth::user()->wishlist->modelKeys() : null);
            return !wishList ? [] : wishList;
        }
    
        var store = new Vuex.Store({
            state: {
                user: initUser(),
                cart: loadCart(),
                wishList: loadWishList()
            },
            getters: {
                currentUser: (state) => state.user,
                shoppingCart: (state) => state.cart,
                savedItems: (state) => state.wishList
            },
            mutations: {
                logout(state) {
                    localStorage.removeItem('user');
                    state.user = null;
                },
                addToCart(state, product) {
                    state.cart.unshift({
                        id: product,
                        quantity: 1
                    });
                    localStorage.setItem('cart', JSON.stringify(state.cart));
                },
                updateCart(state, product) {
                    const index = state.cart.findIndex(item => item.id == product.id);
                    state.cart[index].quantity = product.quantity;
                    localStorage.setItem('cart', JSON.stringify(state.cart));
                },
                removeFromCart(state, product) {
                    const index = state.cart.findIndex(item => item.id == product.id);
                    state.cart.splice(index, 1);
                    localStorage.setItem('cart', JSON.stringify(state.cart));
                },
                clearCart(state) {
                    localStorage.removeItem('cart');
                    state.cart = [];
                },
                addToWishList(state, id) {
                    state.wishList.unshift(id);
                },
                removeFromWishList(state, id) {
                    state.wishList = state.wishList.filter(item => item != id);
                }
            }
        });
    
        jQuery(document).ready(function ($) {
            // Initialize application
            new Vue().$mount('#app');
        });
    </script>
@endprepend