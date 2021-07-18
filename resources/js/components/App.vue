<template>
    <navigation v-if="showNavigation"></navigation>

    <div class="container mx-auto">
        <router-view></router-view>
    </div>
</template>

<script>
import Navigation from "./Navigation";

export default {
    components: {
        navigation: Navigation,
    },
    computed: {
        showNavigation() {
            return (
                this.$route.name != "login" && this.$route.name != "register"
            );
        },
    },
};
</script>
