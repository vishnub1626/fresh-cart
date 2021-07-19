<template>
    <div class="flex flex-col border border-gray-300 rounded-md shadow-md" >
        <div class="w-full h-64 overflow-hidden bg-center bg-cover" :style="{ backgroundImage: 'url(' + product.image + ')' }"> 
        </div>
        <div class="px-3 -mt-4 text-right">
            <button class="p-2 text-white bg-white border border-gray-300 rounded-full shadow-lg" @click.once="addToCart(product)" v-if="!isInCart(product)">
                <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </button>
            <button class="p-2 text-white bg-white border border-gray-300 rounded-full shadow-lg" @click.once="removeFromCart(product)" v-if="isInCart(product)">
                <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </button>
        </div>
        <!-- <img :src="product.image" :alt="product.name" class="w-72" /> -->
        <div class="px-4 pt-2 pb-4">
            <h2 class="text-2xl font-bold">
                {{ product.name }}
            </h2>
            <p class="mt-1 text-xl font-bold">₹{{ product.price }}</p>
            <p class="mt-1 overflow-hidden text-sm text-gray-600 overflow-ellipsis">{{ product.description }}</p>

        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
export default {
    props: ["product"],

    computed: {
        ...mapGetters({
            isInCart: 'cart/isInCart'
        })
    },

    methods: {
        ...mapActions({
            addToCart: 'cart/addProduct',
            removeFromCart: 'cart/removeProduct',
        })
    }
};
</script>
