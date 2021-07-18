<template>
    <div class="flex w-1/2">
        <img :src="product.image" :alt="product.name" class="w-72" />
        <div class="ml-3">
            <h2 class="text-2xl font-bold">
                {{ product.name }}
            </h2>
            <p class="text-lg font-bold">₹{{ product.price }}</p>
            <p class="overflow-hidden overflow-ellipsis">{{ product.description }}</p>

            <div>
                <button class="p-2 text-white bg-blue-700">Add to cart</button>
                <button class="p-2 text-white bg-red-800">Remove from cart</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["product"],
};
</script>
