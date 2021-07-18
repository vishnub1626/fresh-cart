<template>
    <div class="py-3 bg-green-800">
        <div class="container flex justify-between mx-auto text-white">
            <router-link class="block" to="/">FreshCart</router-link>
            <div>
                <router-link to="/cart"
                    >Cart
                    <span>({{ cartCount }})</span>
                </router-link>
                <router-link to="/order" class="ml-2">Orders</router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    created() {
        this.$store.dispatch("cart/getCart");
    },
    computed: {
        cartCount() {
            return this.$store.getters["cart/productsCount"];
        },
    },
};
</script>
