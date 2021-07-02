<template>
    <div class="col-sm-3 product-container text-center">
        <router-link :to="{name: 'product', params: { id: productData.id }}">
            <div class="product-img">
                <img :src="productData.image" :alt="productData.title" class="img-rounded">
            </div>
            <h6 class="product-title">{{productData.title}}</h6>
            <p class="product-price">{{currenySymbol}} {{productData.price}}</p>
            <p class="product-description">{{productData.description}}</p>
        </router-link>
        
    </div>
</template>
<script>
export default {
    name: 'Product',
    props: {
        productData : {
            default: {}
        }
    },
    data() {
        return {
            currenySymbol: process.env.VUE_APP_CURRENCY_SYMBOL
        }
    }
}
</script>
<style scoped>
.product-container {
    margin-bottom: 25px;
    cursor: pointer;
}
.product-container:hover {
    border: 1px solid rgba(0,0,0,0.25);
    box-shadow: 5px 5px 10px -2px rgba(0,0,0,0.48);
    -webkit-box-shadow: 5px 5px 10px -2px rgba(0,0,0,0.48);
    -moz-box-shadow: 5px 5px 10px -2px rgba(0,0,0,0.48);
}
.product-container * {
    color: #2c3e50;
    text-decoration: none;
}
.product-title {
    margin-top: 15px;
    font-weight: 600;
}
.product-img img {
    max-width: 100%;
}
.product-description {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    font-size: 14px;
}
</style>