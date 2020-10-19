@extends('main')

@section('title', 'Checkout | ' . config('app.name'))

@section('content')
    <checkout></checkout>
@endsection

@section('components')
    <template id="checkout-template">
        <section>
            <div class="clearfix" id="checkout-content">
                <div id="shipping-payment" class="pull-left">
                    <div id="shipping-address" v-if="!addressId">
                        <h4 id="shipping-address-title">Shipping address</h4>
                        <form @submit.prevent="addAddress" method="post" class="card" id="shipping-address-form">
                            <div class="input-group addressBook" v-for="(address, index) in addressBook" :key="index">
                                <input type="radio" name="addressId" @click="addressId = address.id">
                                @{{ address.phone }} &nbsp;
                                @{{ address.town }} &nbsp;
                                @{{ address.county }} &nbsp;
                                @{{ address.street }}
                            </div>
                            <div class="input-group">
                                <label for="firstName">First name</label>
                                <input type="text" name="firstName" id="firstName" :value="user.firstName" readonly>
                            </div>
                            <div class="input-group">
                                <label for="lastName">Last name</label>
                                <input type="text" name="lastName" id="lastName" :value="user.lastName" readonly>
                            </div>
                            <div class="input-group">
                                <label for="phone">Mobile phone number</label>
                                <input type="text" name="phone" id="phone">
                            </div>
                            <div class="input-group">
                                <label for="county">Region/County</label>
                                <input type="text" name="county" id="county">
                            </div>
                            <div class="input-group">
                                <label for="town">City/town</label>
                                <input type="text" name="town" id="town">
                            </div>
                            <div class="input-group">
                                <label for="street">Street/Apartment</label>
                                <input type="text" name="street" id="street">
                            </div>
                            <button type="submit" id="save-address-btn">Save and continue</button>
                        </form>
                    </div>
                    <div id="payment-methods" v-if="addressId">
                        <h4 id="payment-methods-title">Payment method</h4>
                        <div class="card">
                            <p id="selected-address-details">
                                <b>My Address</b>
                                @{{ selectedAddress.phone }} &nbsp;
                                @{{ selectedAddress.town }} &nbsp;
                                @{{ selectedAddress.county }} &nbsp;
                                @{{ selectedAddress.street }}
                            </p>
                            <p id="payment-steps">
                                <b>Lipa na M-Pesa</b>
                                <ol>
                                    <li>1. Got to Safaricom M-Pesa</li>
                                    <li>2. Within M-Pesa menu, choose the option "Send money"</li>
                                    <li>3. Insert the number "0712676157"</li>
                                    <li>4. Insert the amount Ksh @{{ total }}</li>
                                    <li>5. Insert your PIN and confirm</li>
                                    <li>6. You will receive an SMS from M-PESA confirming the transation</li>
                                    <li>7. Enter the M-Pesa transaction no. and click on "place order" button</li>
                                </ol>
                            </p>
                        </div>
                    </div>
                </div>
                <div id="order-summary" class="pull-right">
                    <h4 id="order-summary-title">
                        Order Summary
                    </h4>
                    <div class="card" v-if="products">
                        <div class="order-totals clearfix">
                            <span class="pull-left">
                                Sub-total :
                            </span>
                            <span class="pull-right">
                                Ksh @{{ subTotal }}
                            </span>
                        </div>
                        <div class="order-totals clearfix">
                            <span class="pull-left">
                                Shipping :
                            </span>
                            <span class="pull-right">
                                @{{ shippingCost == 0 ? 'Not yet included' : 'Ksh ' + shippingCost }}
                            </span>
                        </div>
                        <div class="order-totals clearfix">
                            <span class="pull-left">
                                VAT :
                            </span>
                            <span class="pull-right">
                                Ksh 0
                            </span>
                        </div>
                        <div class="order-totals clearfix">
                            <span class="pull-left">
                                Total :
                            </span>
                            <span class="pull-right">
                                Ksh @{{ total }}
                            </span>
                        </div>
                    </div>
                    <form action="{{ route('customer.order.store') }}" method="post" id="place-order-form" v-if="addressId">

                        @csrf

                        <input type="text" name="transactionNo" id="order-transaction-input" placeholder="Enter transaction no." required>

                        <input type="hidden" name="catalogue" :value="cart.map(item => item.id + ':' + item.quantity).join(',')">

                        <input type="hidden" name="addressId" :value="addressId">

                        <input type="hidden" name="shippingCost" :value="shippingCost">

                        <input type="hidden" name="total" :value="total">

                        <button type="button" id="place-order-btn" @click="placeOrder">
                            Place order
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </template>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endsection

@push('script')
    <script>
        Vue.component('checkout', {
            template: '#checkout-template',
            data: () => ({
                products: [],
                addressBook: @json(Auth::user()->addressBook),
                addressId: null,
                shippingCost: 0,
                transactionNo: null
            }),
            computed: {
                cart() {
                    return store.getters.shoppingCart;
                },
                subTotal() {
                    return this.catalogue.reduce((carrier, next) => carrier + (next.price * next.quantity), 0);
                },
                total() {
                    return this.subTotal + this.shippingCost;
                },
                catalogue () {
                    return this.products.length > 0 ? this.products.map(product => {
                        product.quantity = this.cart.find(item => item.id == product.id).quantity;
                        return product;
                    }) : [];
                },
                user() {
                    return store.getters.currentUser;
                },
                selectedAddress() {
                    return this.addressId == null ? {} : this.addressBook.find(address => address.id == this.addressId);
                }
            },
            watch: {
                addressId(value) {
                    this.shippingCost = this.addressBook.find(address => address.id == value).county.toLowerCase() == 'nairobi' ? 2000 : 3000;
                }
            },
            created() {
                this.getProducts();
            },
            methods: {
                getProducts() {
                    axios.get("{{ route('cart.products') }}", {
                        params: {
                            products: this.cart.map(item => item.id).join(',')
                        }
                    })
                    .then(({data}) => this.products = data)
                    .catch(console.error);
                },
                addAddress() {
                    axios.post("{{ route('customer.address.store') }}", new FormData(
                        jQuery('#shipping-address-form')[0]
                    ), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(({data}) =>  {
                        this.addressBook.unshift(data);
                        this.addressId = data.id;
                    })
                    .catch(console.error);
                },
                placeOrder() {
                    store.commit('clearCart');
                    jQuery('#place-order-form')[0].submit();
                }
            }
        });
    </script>
@endpush