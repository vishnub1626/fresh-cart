<template>
    <div class="container mx-auto">
        <product-list></product-list>
    </div>
</template>

<script>
import ProductList from "./ProductList.vue";

export default {
    components: {
        "product-list": ProductList,
    },
};
</script>
