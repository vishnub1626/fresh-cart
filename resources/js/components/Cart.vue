<template>
    <div>
        <div class="flex" v-for="product in cart.products" :key="product.id">
            <img :src="product.image" :alt="product.name" class="w-40" />
            <div class="ml-3">
                <h2 class="text-2xl font-bold">
                    {{ product.name }}
                </h2>
                <p class="text-lg font-bold">₹{{ product.price }}</p>
                <div>
                    <button
                        class="p-2 text-white bg-red-800"
                        @click.once="removeFromCart(product)"
                    >
                        Remove from cart
                    </button>
                </div>
            </div>
        </div>
        <div>
            Total: ₹{{ cart.total }}
        </div>

        <router-link to="/checkout" class="p-2 border">Checkout</router-link>
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
