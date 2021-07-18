<template>
    <div class="container mx-auto">
        <form class="w-2/3 mx-auto">
            <div class="p-2">
                <label for="name">Name</label>
                <input class="block border" type="text" id="name" v-model="name">
                <validation-error :error="validationErrors?.name"></validation-error>
            </div>
            <div class="p-2">
                <label for="email">Email</label>
                <input class="block border" type="text" id="email" v-model="email">
                <validation-error :error="validationErrors?.email"></validation-error>
            </div>
            <div class="p-2">
                <label for="password">Password</label>
                <input class="block border" type="password" id="password" v-model="password">
                <validation-error :error="validationErrors?.password"></validation-error>
            </div>
            <button type="submit" class="p-2 mt-4 border" @click.prevent="submit">Register</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                email: '',
                password: '',
                validationErrors: null,
            }
        },

        methods: {
            submit() {
                this.$store.dispatch('user/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                }).then(res => {
                    this.$router.push('/login');
                }).catch(err => {
                    if (err.response.status === 422) {
                        this.validationErrors = err.response.data.errors;
                    }
                })
            }
        }
        
    }
</script>
