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
        <!-- End of error alert -->
        <div class="jumbotron text-center">
            <h3>Hello {{username}}</h3>
        </div>

        <div class="container">
            <div class="product-row">
                <product-list :products="products" :categories="categories" @selectedCategory="handleCategoryFilter" />
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios"
import ProductList from './ProductList.vue';
export default {
    components: { ProductList },
    name: "MainContent",
    data() {
        return {
            products: [],
            categories: [],
            error: null,
            loading: true,
            username: 'User',
            categoryFilter: null
        }
    },
    methods: {
        handleCategoryFilter(filterData) {
            this.categoryFilter = filterData
            this.getProducts()
        },
        async getProducts() {
            try {
                this.error = null
                this.loading = true
                var url = process.env.VUE_APP_ECOMM_API_URL + '/products'
                if (this.categoryFilter && this.categoryFilter.length) {
                    url += '/category/'+ this.categoryFilter
                }
                var response = await axios.get(url)
                console.log(response.data);
                this.products = response.data
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
        async getCategories() {
            try {
                var url = process.env.VUE_APP_ECOMM_API_URL + '/products/categories'
                var response = await axios.get(url)
                this.categories = response.data
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
        if (localStorage.getItem('token') == null || !localStorage.getItem('token').length || localStorage.getItem('token') == "null") {
            console.log('Redirect to login');
            this.$router.push('login');
        } else {
            var userData = JSON.parse(localStorage.getItem('user_data'));
            this.username = userData.name;
        }
        this.getProducts();
        this.getCategories();
    }
};
</script>
<style>
.error-container:before,
.loader:before {
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
    height: 100%;
    content: '';
    background: rgba(0, 0, 0, 0.3);
    z-index: 5;
}
.error-text,
.loader-text {
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    font-size: 3.2rem;
    color: #FFF;
    text-shadow: 2px 2px #2c3e50;
    text-align: center;
    z-index: 7;
}
.error-text {
    color: #f00;
    padding: 25px;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 5px;
}
</style>