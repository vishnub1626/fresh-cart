<template>
    <div class="container py-4 mx-auto">
        <div class="flex flex-wrap gap-4">
            <order-card
                v-for="order in orders"
                :order="order"
                :key="order.id"
            ></order-card>
        </div>

        <button v-if="nextPage" class="p-2" @click="fetchNextPage">
            Load more
        </button>
    </div>
</template>

<script>
import { mapActions, mapState, mapGetters } from "vuex";
import OrderCard from "./OrderCard";

export default {
    components: {
        "order-card": OrderCard,
    },

    created() {
        this.$store.dispatch("orders/getOrders", true);
    },

    computed: {
        ...mapState({
            orders: (state) => state.orders.all,
            nextPage: (state) => state.orders.nextPage,
        }),
    },

    methods: {
        ...mapActions({
            fetchNextPage: "orders/fetchNextPage",
        }),
    },
};
</script>
