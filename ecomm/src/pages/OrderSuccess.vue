<template>
    <div class="order-success">
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
        <div class="jumbotron text-center">
            <h1>Thank You</h1>
            <p>Order #{{orderId}}</p> 
        </div>
        
        <div class="container order-details">
            <div class="row item-container">
                <div class="col-sm-12">
                    <h3 class="text-center">Order Details</h3>
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <cart-item v-for="(orderItem, index) in orderItems" :key="index" :item-data="orderItem" :currency-symbol="currencySymbol" />
                            <td colspan="2" class="text-right"><strong>Order Total</strong></td>
                            <td><div class="price-wrap"> <var class="price">{{currencySymbol}} {{orderTotal}}</var></div></td>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row address-container">
                <div class="col-sm-12">
                    <h6><strong>Address:</strong></h6>
                    <address>{{shippingAddress}}</address>
                </div>
            </div>
            <div class="row method-container">
                <div class="col-sm-6">
                    <h6><strong>Shipping Method:</strong></h6>
                    <address>{{shippingMethod}}</address>
                </div>
                <div class="col-sm-6">
                    <h6><strong>Payment Method:</strong></h6>
                    <address>{{paymentMethod}}</address>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios"
import CartItem from './../components/CartItem'
export default {
    name: 'OrderSuccess',
    components: {CartItem},
    data() {
        return {
            orderId: this.$route.params.orderid,
            orderItems: null,
            orderTotal: 0,
            shippingAddress: null,
            shippingMethod: null,
            paymentMethod: null,
            error: null,
            loading: true,
            currencySymbol: process.env.VUE_APP_CURRENCY_SYMBOL
        }
    },
    methods: {
        async getOrderData() {
            try {
                var url = process.env.VUE_APP_DB_API_URL + '/checkout/order.php?orderid=' + this.orderId
                var response = await axios.get(url)
                if (!response.data.success) {
                    this.error = {
                        title: "Error",
                        message: response.data.msg,
                    }
                } else {
                    this.orderItems = JSON.parse(response.data.order_data.product_details);
                    this.orderTotal = response.data.order_data.order_total;
                    this.shippingAddress = response.data.order_data.shipping_address;
                    this.shippingMethod = response.data.order_data.shipping_method;
                    this.paymentMethod = response.data.order_data.payment_method;
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
        }
    },
    mounted() {
        this.getOrderData();
        console.log(this.$route.params);
    }
}
</script>
<style scoped>
.order-success {
    margin-bottom: 30px;
}
thead, .item-container, .address-container {
    border-bottom: 1px solid rgba(0, 0, 0, .125);
    margin-bottom: 15px;
}
</style>