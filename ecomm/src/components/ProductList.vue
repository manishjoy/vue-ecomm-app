<template>
    <div>
        <div class="row">
            <category-filter :categories="categories" @selectedCategory="handleCategoryFilter" />
        </div>
        <div class="row">
            <Product v-for="(product, index) in products" :key="index" :product-data="product"/>
        </div>
    </div>
</template>
<script>
import CategoryFilter from './CategoryFilter.vue'
import Product from './Product.vue'
export default {
    components: { Product, CategoryFilter },
    props: {
        products: {
            default: []
        },
        categories: {
            default: []
        }
    },
    name: "ProductList",
    methods: {
        handleCategoryFilter(filterData) {
            this.$emit('selectedCategory', filterData)
            // console.log(filterData);
        }
    }
}
</script>