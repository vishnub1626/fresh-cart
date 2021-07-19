<template>
    <router-link
        :to="orderPath"
        class="block p-3 border border-gray-300 shadow-lg cursor-pointer"
    >
        <p class="w-full p-3 -ml-3 text-lg font-bold">Order #{{ order.id }}</p>
        <div class="grid grid-cols-1 gap-5 -ml-3 border bg-gray-50 border-gray-50 md:grid-cols-4">
            <div v-for="product in order.products" :key="product.id">
                <div class="p-3">
                    <span class="font-semibold">{{ product.name }}</span>
                    <span class="ml-2">₹{{ product.price }}</span>
                </div>
            </div>
        </div>
        <div class="flex justify-between flex-grow-0 mt-4 bg-gray-100">
            <button class="px-3 py-1 border border-blue-600 rounded-full">
                {{ order.status }}
            </button>
            <p class="w-full p-3 text-lg font-bold text-right ">Order total: ₹{{ order.total }}</p>
        </div>
    </router-link>
</template>

<script>
export default {
    props: ["order"],

    computed: {
        orderPath() {
            return "/orders/" + this.order.id;
        },
    },
};
</script>
