<template>
    <router-link to="" class="block cursor-pointer">
        <p class="w-full p-3 -ml-3 text-2xl font-bold">Order #{{ order.id }}</p>
        <google-map
            :location="order.location"
            v-if="showMap"
            class="mt-4 mb-4 border border-gray-300 shadow-xl"
        ></google-map>
        <div class="mt-4">
            <h2 class="text-xl font-bold">
                Status: <span class="text-sm">{{ orderStatus }}</span>
            </h2>
        </div>
        <div
            class="grid grid-cols-1 gap-4 p-3 mt-4 border border-gray-500 md:grid-cols-4"
        >
            <div v-for="product in order.products" :key="product.id">
                <div class="flex gap-4 ml-3">
                    <h2>
                        {{ product.name }}
                    </h2>
                    <p>₹{{ product.price }}</p>
                </div>
            </div>
        </div>
        <p class="py-3 mt-4 text-lg font-bold">
            Order total: ₹{{ order.total }}
        </p>
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

        orderStatus() {
            const statusMap = {
                in_transit: "Out for delivery",
                pending: "Waiting for confirmation",
                delivered: "Delivered",
                cancelled: "Cancelled",
            };

            return statusMap[this.order.status];
        },

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
