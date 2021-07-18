<template>
    <div class="container mx-auto">
        <form class="w-2/3 mx-auto">
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
            <button type="submit" class="p-2 mt-4 border" @click.prevent="submit">Login</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: '',
                password: '',
                validationErrors: '',
            }
        },

        methods: {
            submit() {
                this.$store.dispatch('user/login', {
                    email: this.email,
                    password: this.password,
                }).then(res => {
                    this.$router.push('/');
                }).catch(err => {
                    if (err.response.status === 422) {
                        this.validationErrors = err.response.data.errors;
                    }
                })
            }
        }
        
    }
</script>
