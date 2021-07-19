<template>
    <div class="sticky top-0 bg-white shadow-lg">
        <div class="container flex justify-between p-5 py-6 mx-auto text-gray-800">
            <router-link class="block text-xl font-semibold md:text-2xl md:font-bold" to="/">FreshCart</router-link>
            <div class="flex gap-3">
                <router-link to="/orders" class="ml-2">Orders</router-link>
                <router-link to="/cart"
                    >
                    <svg class="inline w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>({{ cartCount }})</span>
                </router-link>
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
