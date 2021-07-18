<template>
    <navigation v-if="showNavigation"></navigation>
    <router-view></router-view>
</template>

<script>
import Navigation from "./Navigation";

export default {
    components: {
        'navigation' : Navigation
    },
    computed: {
        showNavigation () {
            return this.$route.name != 'login' && this.$route.name != 'register';
        }
    }
};
</script>
