<template>
    <router-link to="" class="block cursor-pointer">
        <google-map :location="order.location" v-if="showMap"></google-map>
        <div class="ml-3">
            <h2 class="text-2xl font-bold">
                {{ order.status }}
            </h2>
            <p class="text-lg font-bold">₹{{ order.total }}</p>
        </div>
        <div v-for="product in order.products" :key="product.id">
            <div class="ml-3">
                <h2 class="text-2xl font-bold">
                    {{ product.name }}
                </h2>
                <p class="text-lg font-bold">₹{{ product.price }}</p>
            </div>
        </div>
    </router-link>
</template>

<script>
import { mapState } from "vuex";
import Map from "./Map";

export default {
    data() {
        return {
            interval: null,
        };
    },

    components: {
        "google-map": Map,
    },
    created() {
        const orderId = this.$route.params.id;

        this.$store.dispatch("orders/getOrder", orderId);
        this.interval = setInterval(() => {
            this.$store.dispatch("orders/getOrder", orderId);
        }, 5000);
    },

    computed: {
        ...mapState({
            order: (state) => state.orders.order,
        }),

        showMap() {
            return (
                this.order.status == "in_transit" &&
                Object.keys(this.order.location).length > 0
            );
        },
    },

    watch: {
        order(order) {
            if (order.status == "delivered" || order.status == "cancelled") {
                clearInterval(this.interval);
            }
        },
    },
};
</script>
