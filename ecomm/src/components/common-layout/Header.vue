<template>
  <header class="justify-center flex">
    <img class="magento-logo" alt="magento-logo" src="../../assets/m2-logo.svg" width="32" />
    <span class="ml-2 text-lg font-bold">
      Vue Commerce
    </span>
  </header>
</template>
<script>
export default {
    name: 'Header'
}
</script>
<style scoped>
header {
    color: #ff6600;
    border-bottom: 1px solid #ff6600;
    font-weight: 600;
    font-size: 2.4rem;
    padding: 15px;
}
.magento-logo {
    width: 38px;
}
</style>