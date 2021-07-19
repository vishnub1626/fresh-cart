<template>
    <div>
        <div class="grid grid-cols-1 gap-5 md:grid-cols-6">
            <div v-for="product in cart.products" :key="product.id">
                <div>
                    <h2 class="text-2xl">
                        {{ product.name }}
                    </h2>
                    <p class="text-lg font-bold">₹{{ product.price }}</p>
                </div>
            </div>
        </div>
        <div
            class="
                py-4
                mt-4
                text-2xl
                font-bold
                border-t border-b border-gray-400
            "
        >
            Total: ₹{{ cart.total }}
        </div>

        <div class="mt-8">
            <h1>
                <RadioGroup v-model="type" class="flex">
                    <RadioGroupOption v-slot="{ checked }" value="delivery">
                        <div
                            @click="hideNewAddressForm()"
                            :class="
                                checked
                                    ? 'bg-green-400 text-white font-bold'
                                    : ' text-gray-500 bg-gray-200'
                            "
                            class="px-3 py-1 rounded-full cursor-pointer"
                        >
                            Delivery
                        </div>
                    </RadioGroupOption>
                    <RadioGroupOption v-slot="{ checked }" value="pickup">
                        <div
                            @click="hideNewAddressForm()"
                            :class="
                                checked
                                    ? 'bg-green-400 text-white font-bold'
                                    : ' text-gray-500 bg-gray-200'
                            "
                            class="px-3 py-1 ml-4 rounded-full cursor-pointer"
                        >
                            Pickup
                        </div>
                    </RadioGroupOption>
                </RadioGroup>
            </h1>
            <div>
                <div class="flex flex-wrap">
                    <RadioGroup
                        v-model="address"
                        class="w-full md:w-1/3"
                        v-for="addr in addresses"
                        :key="addr.id"
                    >
                        <RadioGroupOption
                            v-slot="{ checked }"
                            :value="addr"
                            @click="hideNewAddressForm()"
                            class="p-3"
                        >
                            <div
                                class="
                                    p-5
                                    border border-gray-300
                                    rounded-md
                                    cursor-pointer
                                "
                                :class="
                                    checked
                                        ? 'border-blue-600 text-gray-800 shadow-xl font-semibold'
                                        : 'bg-gray-200 text-gray-400'
                                "
                            >
                                <p>{{ addr.address_one }}</p>
                                <p>{{ addr.address_two }}</p>
                                <p>{{ addr.city }}, {{ addr.state }}</p>
                                <p>{{ addr.pincode }}</p>
                            </div>
                        </RadioGroupOption>
                    </RadioGroup>
                </div>

                <div class="p-3 mt-4">
                    <div
                        class="p-2 border border-gray-300 cursor-pointer"
                        @click="showNewAddressForm()"
                    >
                        + Add new address
                    </div>
                    <form
                        v-if="showAddressForm"
                        class="
                            p-2
                            mt-4
                            border border-gray-200
                            rounded-md
                            shadow-lg
                        "
                    >
                        <div class="p-2">
                            <label for="address-one">House</label>
                            <input
                                class="block p-2 mt-2 border border-gray-200"
                                type="text"
                                id="address-one"
                                v-model="address.address_one"
                            />
                        </div>
                        <div class="p-2">
                            <label for="address-two">Street</label>
                            <input
                                class="block p-2 mt-2 border border-gray-200"
                                type="text"
                                id="address-two"
                                v-model="address.address_two"
                            />
                        </div>
                        <div class="p-2">
                            <label for="city">City</label>
                            <input
                                class="block p-2 mt-2 border border-gray-200"
                                type="text"
                                id="city"
                                v-model="address.city"
                            />
                        </div>
                        <div class="p-2">
                            <label for="state">State</label>
                            <input
                                class="block p-2 mt-2 border border-gray-200"
                                type="text"
                                id="state"
                                v-model="address.state"
                            />
                        </div>
                        <div class="p-2">
                            <label for="pincode">Pincode</label>
                            <input
                                class="block p-2 mt-2 border border-gray-200"
                                type="text"
                                id="pincode"
                                v-model="address.pincode"
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <button
            type="submit"
            @click.prevent.once="placeOrder"
            class="
                float-right
                p-2
                mt-4
                text-lg
                font-bold
                text-white
                bg-blue-700
            "
        >
            Place Order
        </button>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from "@headlessui/vue";

const addressObj = {
    address_one: "",
    address_two: "",
    city: "",
    state: "",
    pincode: "",
};

export default {
    components: { RadioGroup, RadioGroupLabel, RadioGroupOption },

    data() {
        return {
            showAddressForm: false,
            type: "delivery",
            validationErrors: null,
            address: {
                address_one: "",
                address_two: "",
                city: "",
                state: "",
                pincode: "",
            },
        };
    },

    created() {
        this.$store.dispatch("address/getAddresses");
    },

    computed: {
        addresses() {
            if (this.type == "pickup") {
                return this.$store.getters["address/pickupAddresses"];
            }
            return this.$store.getters["address/deliveryAddresses"];
        },
        ...mapState({
            cart: (state) => state.cart.cart,
        }),
    },

    methods: {
        showNewAddressForm() {
            this.address = addressObj;
            this.showAddressForm = true;
        },

        hideNewAddressForm() {
            this.showAddressForm = false;
        },

        placeOrder() {
            this.$store
                .dispatch("orders/placeOrder", {
                    cart_id: this.cart.id,
                    type: this.type,
                    address: this.address,
                })
                .then((res) => {
                    this.$store.dispatch("cart/getCart");
                    this.$router.push("/orders/" + res.data.data.id);
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
