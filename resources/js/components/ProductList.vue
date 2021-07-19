<template>
    <div class="container mx-auto">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-3">
            <product-card
                v-for="product in products"
                :product="product"
                :key="product.id"
            ></product-card>
        </div>

        <button v-if="nextPage" class="w-full p-4 mt-5 text-center bg-blue-100 md:bg-white md:underline" @click="fetchNextPage">Load more</button>
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
