<template>
    <div class="cart-page">
        <div class="loader" v-show="loading">
            <div class="loader-text">Loading...</div>
        </div>
        <!-- Start of error alert -->
        <div class="error-container" v-if="error">
            <div class="error-text">
                <h3>
                    {{ error.title }}
                </h3>
                <p>{{ error.message }}</p>
            </div>
        </div>
        <!-- End of error alert -->
        <div class="container-fluid">
            <div class="row"  v-if="cartItemCount > 0">
                <aside class="col-lg-9">
                    <div class="card checkout-card">
                        <form @submit="placeOrder">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" ref="name" class="form-control" :value="userData.name" required id="name" disabled="true">
                            </div>
                            <div class="form-group">
                                <label for="email">email:</label>
                                <input type="email" ref="email" class="form-control" :value="userData.email" required id="email" disabled="true">
                            </div>
                            <div class="form-group">
                                <label for="shipping_address">Address:</label>
                                <textarea style="overflow:auto;resize:none" class="form-control" ref="shipping_address" rows="3" id="shipping_address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="shipping_method">Shipping Method:</label>
                                <div class="radio">
                                    <label><input type="radio" value="Fedex" v-model="shippingMethod" name="shipping_method" checked>Fedex</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" value="DTDC" v-model="shippingMethod" name="shipping_method">DTDC</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="payment_method">Payment Method:</label>
                                <div class="radio">
                                    <label><input type="radio" value="COD" v-model="paymentMethod" name="payment_method" checked>COD</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" value="Money Transfer" v-model="paymentMethod" name="payment_method">Money Transfer</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Place Order</button>
                            </div>
                        </form>
                    </div>
                </aside>
                <aside class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="items">
                                <CheckoutItem v-for="(item, index) in cartItems" :key="index" :item-data="item" :currency-symbol="currencySymbol" />
                            </div>
                            <dl class="dlist-align">
                                <dt>Total:</dt>
                                <dd class="text-right text-dark b ml-3"><strong>{{currencySymbol}} {{cartTotal}}</strong></dd>
                            </dl>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="row" v-else>
                <div class="col-lg-12">
                    <h6>No items found in cart. <router-link :to="{name: 'home'}">Keep Shopping</router-link></h6>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import '../assets/css/cart.css'
import CheckoutItem from './../components/CheckoutItem'
import axios from "axios"
export default {
    name: 'Checkout',
    components: {CheckoutItem},
    data() {
        return {
            cartItemCount: 0,
            cartTotal: 0.00,
            currencySymbol: process.env.VUE_APP_CURRENCY_SYMBOL,
            userData: null,
            userToken: null,
            cartItems: [],
            shippingMethod: 'Fedex',
            paymentMethod: 'COD',
            loading: false,
            error: null
        }
    },
    methods: {
        async placeOrder(e) {
            e.preventDefault();
            this.error = null
            this.loading = true
            try {
                var url = process.env.VUE_APP_DB_API_URL + '/checkout/submit.php';
                var headers = {
                    'authorization': this.userToken
                };

                var response = await axios.post(url, { 
                    product_details: this.cartItems, 
                    order_total: this.cartTotal, 
                    shipping_address: this.$refs.shipping_address.value, 
                    shipping_method: this.shippingMethod, 
                    payment_method: this.paymentMethod, 
                }, {
                    headers: headers
                })
                if (!response.data.success) {
                    this.error = {
                        title: "Error",
                        message: response.data.msg,
                    }
                } else {
                    var cart = {'id': 'cart_' + this.userToken, items: []};
                    localStorage.setItem('cart', JSON.stringify(cart));
                    this.$store.state.cartNum = 0;
                    this.$router.push({ path: `/order-success/orderid/${response.data.order_id}` });
                }
            } catch (err) {
                if (err.response) {
                    // client received an error response (5xx, 4xx)
                    this.error = {
                        title: "Server Response",
                        message: err.message,
                    }
                } else if (err.request) {
                    // client never received a response, or request never left
                    this.error = {
                        title: "Unable to Reach Server",
                        message: err.message,
                    }
                } else {
                    // There's probably an error in your code
                    this.error = {
                        title: "Application Error",
                        message: err.message,
                    }
                }
            }
            this.loading = false
            setTimeout(() => {
                this.error = null;
            }, 1000);
        },
    },
    mounted() {
        var cart = JSON.parse(localStorage.getItem('cart'));
        this.userData = JSON.parse(localStorage.getItem('user_data'));
        this.userToken = JSON.parse(localStorage.getItem('token'));
        this.cartItemCount = cart.items.length;
        if (this.cartItemCount < 1) {
            this.$router.push('cart');
        }
        this.cartItems = cart.items;
        for (var index = 0; index < this.cartItems.length; index++) {
            this.cartTotal += parseFloat(this.cartItems[index].price);
        }
    }
}
</script>