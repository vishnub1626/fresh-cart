<template>
    <div class="container flex h-screen">
        <form class="p-5 m-auto border border-gray-300 shadow-lg">
            <div class="pb-5 text-xl font-bold border-b">FreshCart</div>
            <div class="p-2">
                <label for="name" class="text-sm font-semibold">Name</label>
                <input
                    class="block p-2 mt-2 border border-gray-200"
                    type="text"
                    id="name"
                    v-model="name"
                />
                <validation-error
                    :error="validationErrors?.name"
                ></validation-error>
            </div>
            <div class="p-2">
                <label for="email" class="text-sm font-semibold">Email</label>
                <input
                    class="block p-2 mt-2 border border-gray-200"
                    type="text"
                    id="email"
                    v-model="email"
                />
                <validation-error
                    :error="validationErrors?.email"
                ></validation-error>
            </div>
            <div class="p-2">
                <label for="password" class="text-sm font-semibold"
                    >Password</label
                >
                <input
                    class="block p-2 mt-2 border border-gray-200"
                    type="password"
                    id="password"
                    v-model="password"
                />
                <validation-error
                    :error="validationErrors?.password"
                ></validation-error>
            </div>
            <div class="flex justify-end gap-3">
                <button
                    type="submit"
                    class="px-3 py-2 mt-4 text-sm text-white bg-blue-600 rounded-full"
                    @click.prevent="submit"
                >
                    Register
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            validationErrors: null,
        };
    },

    methods: {
        submit() {
            this.$store
                .dispatch("user/register", {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                })
                .then((res) => {
                    this.$router.push("/login");
                })
                .catch((err) => {
                    if (err.response.status === 422) {
                        this.validationErrors = err.response.data.errors;
                    }
                });
        },
    },
};
</script>
