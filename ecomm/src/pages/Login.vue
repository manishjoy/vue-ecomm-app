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
            <h3>Login</h3>
        </div>
        <div class="container">
            <div class="login-form-container">
                <form @submit="sendData">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" ref="email" class="form-control" required placeholder="Enter email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" ref="pwd" class="form-control" required placeholder="Enter password" id="pwd">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="form-group">
                        Don't have an account? <router-link :to="{name : 'signup'}">Sign up</router-link>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</template>
<script>
import axios from "axios"
export default {
    name: 'Login',
    data() {
        return {
            loading: false,
            error: null
        }
    },
    methods: {
        createEmptyCart(token) {
            var cart = {'id': 'cart_' + token, items: []};
            localStorage.setItem('cart', JSON.stringify(cart));
        },
        async sendData(e) {
            e.preventDefault();
            this.error = null
            this.loading = true
            try {
                var url = process.env.VUE_APP_DB_API_URL + '/customer/login.php'
                var response = await axios.post(url, { 
                    email: this.$refs.email.value, 
                    password: this.$refs.pwd.value
                })
                if (!response.data.success) {
                    this.error = {
                        title: "Error",
                        message: response.data.msg,
                    }
                } else {
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('user_data', JSON.stringify(response.data.user_data));
                    this.createEmptyCart(response.data.token);
                    this.$router.push('/');
                }
                console.log(response.data);
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
    }
}
</script>
<style scoped>
.login-form-container {
    max-width: 400px;
    margin: 10px auto 60px;
}
.btn-primary, .btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle {
    color: #fff;
    background-color: #FF6600;
    border-color: #FF6600;
}
</style>