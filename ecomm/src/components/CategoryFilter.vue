<template>
    <div class="form-group">
        <label for="category-filter-label">Filter</label>
        <select class="form-control" id="category-filter" @change="handleFilterChange">
            <option value="">Select Category</option>
            <option v-for="(category, index) in categories" :key="index" :value="category">{{category | userReadableformat}}</option>
        </select>
    </div>
</template>
<script>
export default {
    name: "CategoryFilter",
    props: [
        'categories'
    ],
    filters: {
        userReadableformat(categoryName) {
            return categoryName[0].toUpperCase() + categoryName.substring(1);
        }
    },
    methods: {
        handleFilterChange(event) {
            this.$emit('selectedCategory', event.target.value)
        }
    }
}
</script>