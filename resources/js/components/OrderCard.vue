<template>
    <router-link :to="orderPath" class="block cursor-pointer">
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
export default {
    props: ["order"],

    computed: {
        orderPath() {
            return '/orders/' + this.order.id;
        }
    }
};
</script>
