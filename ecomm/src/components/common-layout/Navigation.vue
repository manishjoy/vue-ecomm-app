<template>
  <div class="navigation">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
              <li class="nav-item">
                <router-link to="/" class="nav-link">Home</router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{name: 'about'}" class="nav-link">About</router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{name : 'contact'}" class="nav-link">Contact</router-link>
              </li>
              <li class="nav-item" v-if="isLoggedIn">
                <router-link :to="{name : 'cart'}" class="nav-link">Cart ({{cartNum}})</router-link>
              </li>
              <li class="nav-item" v-if="isLoggedIn">
                <a @click="logout" href="#" class="nav-link">Logout</a>
              </li>
            </ul>
          </div>
      </nav>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'Navigation',
  data() {
    return {
      isLoggedIn: false,
    }
  },
  computed: {
    ...mapGetters({
      cartNum: 'getCartCount'
    })
  },
  watch: {
    '$store.state.isLoggedIn': function() {
      this.isLoggedIn = this.$store.state.isLoggedIn;
    }
  },
  methods: {
    logout(e) {
      e.preventDefault();
      localStorage.clear();
      // this.isLoggedIn = false;
      this.$store.state.isLoggedIn = false;
      // window.location.href = window.location.origin + '/login';
      this.$router.push('/login');
    }
  },
  mounted() {
    if (!(localStorage.getItem('token') == null || !localStorage.getItem('token').length || localStorage.getItem('token') == "null")) {
      this.$store.state.isLoggedIn = true;
      var cart = JSON.parse(localStorage.getItem('cart'));
      for (var index = 0; index < cart.items.length; index++) {
        this.$store.state.cartNum += parseInt(cart.items[index].qty);
      }
      this.$store.state.cartNum = 0;
    }
  }
}
</script>
<style scoped>
#navbar {
    align-items: center;
    justify-content: center;
}
</style>