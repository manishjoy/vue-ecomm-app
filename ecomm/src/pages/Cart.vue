<template>
    <div class="cart-page">
        <div class="container-fluid">
            <div class="row"  v-if="cartItemCount > 0">
                <aside class="col-lg-9">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-borderless table-shopping-cart">
                                <thead class="text-muted">
                                    <tr class="small text-uppercase">
                                        <th scope="col">Product</th>
                                        <th scope="col" width="120">Quantity</th>
                                        <th scope="col" width="120">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <cart-item v-for="(item, index) in cartItems" :key="index" :item-data="item" :currency-symbol="currencySymbol" />
                                </tbody>
                            </table>
                        </div>
                    </div>
                </aside>
                <aside class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <dl class="dlist-align">
                                <dt>Cart Total:</dt>
                                <dd class="text-right text-dark b ml-3"><strong>{{currencySymbol}} {{cartTotal}}</strong></dd>
                            </dl>
                            <hr> <router-link :to="{name: 'checkout'}" class="btn btn-out btn-primary btn-square btn-main" data-abc="true"> Checkout </router-link> 
                            <router-link :to="{name: 'home'}" class="btn btn-out btn-success btn-square btn-main mt-2" data-abc="true">Continue Shopping</router-link>
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
import CartItem from './../components/CartItem'
export default {
    name: 'Cart',
    components: {CartItem},
    data() {
        return {
            cartItemCount: 0,
            cartTotal: 0.00,
            currencySymbol: process.env.VUE_APP_CURRENCY_SYMBOL,
            cartItems: []
        }
    },
    mounted() {
        var cart = JSON.parse(localStorage.getItem('cart'));
        this.cartItemCount = cart.items.length;
        this.cartItems = cart.items;
        for (var index = 0; index < this.cartItems.length; index++) {
            this.cartTotal += parseFloat(this.cartItems[index].price);
        }
    }
}
</script>