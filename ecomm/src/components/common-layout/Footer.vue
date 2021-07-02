<template>
  <footer
    class="text-center">
    <span class="text-sm">Copyright &COPY; {{year}} Vinove</span>
  </footer>
</template>
<script>
export default {
    name: 'Footer',
    computed: {
        year() {
            return new Date().getFullYear();
        }
    }
}
</script>
<style scoped>
footer {
    background: #ff6600;
    color: #fff;
    /* position: fixed; */
    bottom: 0;
    width: 100%;
    padding: 15px;
}
</style>