<template>
    <div>
        <div class="flex" v-for="product in cart.products" :key="product.id">
            <div class="ml-3">
                <h2 class="text-2xl font-bold">
                    {{ product.name }}
                </h2>
                <p class="text-lg font-bold">₹{{ product.price }}</p>
            </div>
        </div>
        <div>Total: ₹{{ cart.total }}</div>

        <div>
            <h1>
                <RadioGroup v-model="type" class="flex">
                    <RadioGroupOption v-slot="{ checked }" value="delivery">
                        <span :class="checked ? 'bg-blue-200' : ''"
                            >Delivery</span
                        >
                    </RadioGroupOption>
                    <RadioGroupOption v-slot="{ checked }" value="pickup">
                        <span :class="checked ? 'bg-blue-200' : ''"
                            >Pickup</span
                        >
                    </RadioGroupOption>
                </RadioGroup>
            </h1>
            <div>
                <h1>Address</h1>
                <div>
                    <RadioGroup
                        v-model="address"
                        class="flex"
                        v-for="addr in addresses"
                        :key="addr.id"
                    >
                        <RadioGroupOption v-slot="{ checked }" :value="addr" @click="hideNewAddressForm()">
                            <div
                                class="p-2 cursor-pointer"
                                :class="checked ? 'bg-blue-200' : ''"
                            >
                                <p>{{ addr.address_one }}</p>
                                <p>{{ addr.address_two }}</p>
                                <p>{{ addr.city }}, {{ addr.state }}</p>
                                <p>{{ addr.pincode }}</p>
                            </div>
                        </RadioGroupOption>
                    </RadioGroup>

                    <div
                        class="p-2 cursor-pointer"
                        @click="showNewAddressForm()"
                    >
                        Add new address
                    </div>
                </div>
                <form v-if="showAddressForm">
                    <div class="p-2">
                        <label for="address-one">House</label>
                        <input
                            class="block border"
                            type="text"
                            id="address-one"
                            v-model="address.address_one"
                        />
                    </div>
                    <div class="p-2">
                        <label for="address-two">Street</label>
                        <input
                            class="block border"
                            type="text"
                            id="address-two"
                            v-model="address.address_two"
                        />
                    </div>
                    <div class="p-2">
                        <label for="city">City</label>
                        <input
                            class="block border"
                            type="text"
                            id="city"
                            v-model="address.city"
                        />
                    </div>
                    <div class="p-2">
                        <label for="state">State</label>
                        <input
                            class="block border"
                            type="text"
                            id="state"
                            v-model="address.state"
                        />
                    </div>
                    <div class="p-2">
                        <label for="pincode">Pincode</label>
                        <input
                            class="block border"
                            type="text"
                            id="pincode"
                            v-model="address.pincode"
                        />
                    </div>
                </form>
            </div>
        </div>

        <button type="submit" @click.prevent.once="placeOrder">
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
