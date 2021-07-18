<template>
    <div class="container py-4 mx-auto">
        <div class="flex flex-wrap gap-4">
            <product-card
                v-for="product in products"
                :product="product"
                :key="product.id"
            ></product-card>
        </div>

        <button v-if="nextPage" class="p-2" @click="fetchNextPage">Load more</button>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import ProductCard from "./ProductCard";

export default {
    components: {
        "product-card": ProductCard,
    },

    created() {
        this.$store.dispatch("products/fetchProducts");
    },

    computed: {
        ...mapState({
            products: (state) => state.products.all,
            nextPage: (state) => state.products.nextPage,
        }),
    },

    methods: {
        ...mapActions({
            fetchNextPage: 'products/fetchNextPage' 
        })
    }
};
</script>
