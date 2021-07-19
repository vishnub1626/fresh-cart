<template>
    <div>
        <div
            class="flex py-5"
            v-for="product in cart.products"
            :key="product.id"
        >
            <img :src="product.image" :alt="product.name" class="w-24" />
            <div class="flex flex-col justify-between ml-3">
                <div class="">
                    <h2 class="text-2xl font-bold">
                        {{ product.name }}
                    </h2>
                    <p class="text-lg font-bold">₹{{ product.price }}</p>
                </div>
                <div>
                    <button
                        class="p-1 text-xs text-red-600 bg-white border rounded-full "
                        @click.once="removeFromCart(product)"
                    >
                        Remove
                    </button>
                </div>
            </div>
        </div>
        <div v-if="cart.products?.length > 0">
            <div class="w-full py-4 text-2xl text-right">
                Total: ₹{{ cart.total }}
            </div>

            <div class="w-full py-4 text-right">
                <router-link
                    to="/checkout"
                    class="p-2 text-white bg-blue-600 border rounded-md"
                    >Checkout</router-link
                >
            </div>
        </div>
        <div v-else>
            There is nothing in your cart.
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
    props: ["product"],

    computed: {
        ...mapState({
            cart: (state) => state.cart.cart,
        }),
    },

    methods: {
        ...mapActions({
            addToCart: "cart/addProduct",
            removeFromCart: "cart/removeProduct",
        }),
    },
};
</script>
