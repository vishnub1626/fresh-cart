<template>
    <p class="mt-1 text-xs text-red-800" v-if="error">{{ error[0] }}</p>
</template>

<script>
export default {
    props: ["error"],
};
</script>
