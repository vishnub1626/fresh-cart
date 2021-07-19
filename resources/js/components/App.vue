<template>
    <navigation v-if="showNavigation"></navigation>

    <div class="container p-5 mx-auto">
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
