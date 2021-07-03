<template>
    <div>
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
        <div class="product-details" v-if="productData">
            <div class="container bootdey">
                <div class="col-md-12">
                    <section class="panel">
                        <div class="panel-body row">
                            <div class="col-md-6">
                                <div class="pro-img-details">
                                    <img :src="productData.image" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="pro-d-title">
                                    {{productData.title}}
                                </h4>
                                <div class="product_meta">
                                    <span class="posted_in"> <strong>Category:</strong> {{productData.category}}</span>
                                </div>
                                <div class="m-bot15"> <strong>Price : </strong><span class="pro-price">{{currenySymbol}} {{productData.price}}</span></div>
                                <form class="addtocart-form" @submit="addToCart">
                                    <!-- <input type="hidden" ref="productid" name="productid" :value="productData.id">
                                    <input type="hidden" ref="product_name" name="product_name" :value="productData.title">
                                    <input type="hidden" ref="product_image" name="product_image" :value="productData.image">
                                    <input type="hidden" ref="price" name="price" :value="productData.price"> -->
                                    <div class="form-group">
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" ref="quantity" value="1" min="1" class="form-control quantity" required placeholder="" id="quantity">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </div>
                                </form>
                                <div>
                                    {{productData.description}}
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios"
import '../assets/css/pdp.css';
export default {
    name: 'Pdp',
    data() {
        return {
            id: this.$route.params.id,
            error: null,
            productData: null,
            loading: true,
            currenySymbol: process.env.VUE_APP_CURRENCY_SYMBOL
        }
    },
    methods: {
        addToCart(e) {
            e.preventDefault();
            var cart = JSON.parse(localStorage.getItem('cart'));
            var checkItem = this.in_array(this.productData.id, cart.items);
            if (checkItem.exists) {
                cart.items[checkItem.index].qty = parseInt(cart.items[checkItem.index].qty) + parseInt(this.$refs.quantity.value);
                cart.items[checkItem.index].price = parseFloat(cart.items[checkItem.index].price) + parseFloat(this.productData.price) * parseInt(this.$refs.quantity.value);
            } else {
                var cartData = {'id': this.productData.id, 'name': this.productData.title, 'image': this.productData.image, 'price': parseFloat(this.productData.price) * parseInt(this.$refs.quantity.value), 'qty': this.$refs.quantity.value };
                cart.items.push(cartData);
            }
            this.$store.state.cartNum = parseInt(this.$store.state.cartNum) + 1;
            localStorage.setItem('cart', JSON.stringify(cart));
        },
        in_array(id, array) {
            for(var i=0;i<array.length;i++) {
                if ((array[i].id === id)) {
                    return {'exists': true, 'index': i};
                }
            }
            return {'exists': false, 'index': null};

        },
        async getProduct() {
            try {
                var url = process.env.VUE_APP_ECOMM_API_URL + '/products/' + this.id
                var response = await axios.get(url)
                this.productData = response.data
                console.log(this.productData);
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
        },
    },
    mounted() {
        this.getProduct()
        console.log(this.id);
    }
}
</script>
<style scoped>

</style>