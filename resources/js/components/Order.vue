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
    components: {
        "google-map": Map,
    },
    created() {
        const orderId = this.$route.params.id;

        if (this.$store.state.orders.interval) {
            clearInterval(this.$store.state.orders.interval);
            this.$store.commit('orders/newInterval', null);
        }

        this.$store.dispatch("orders/getOrder", orderId);
        const interval = setInterval(() => {
            this.$store.dispatch("orders/getOrder", orderId);
        }, 5000);

        this.$store.commit('orders/newInterval', interval);
    },

    computed: {
        ...mapState({
            order: (state) => state.orders.order,
            interval: (state) => state.orders.interval,
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
                this.$store.commit('orders/newInterval', null);
            }
        },
    },
};
</script>
