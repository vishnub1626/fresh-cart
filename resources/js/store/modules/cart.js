const cart = {
    namespaced: true,
    state: () => ({
        cart: {},
    }),
    mutations: {
        setCart(state, cart) {
            state.cart = cart;
        },
    },
    actions: {
        addProduct({ commit }, product) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/carts/products", {
                        product_id: product.id,
                    })
                    .then((res) => {
                        commit("setCart", res.data.data);
                        resolve(res);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },

        removeProduct({ commit }, product) {
            return new Promise((resolve, reject) => {
                axios
                    .delete("/api/carts/products/" + product.id)
                    .then((res) => {
                        commit("setCart", res.data.data);
                        resolve(res);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
    getters: {
        productsCount: (state) => {
            if (
                (Object.keys(state.cart).length === 0 &&
                    state.cart.constructor === Object) ||
                state.cart.length == 0
            ) {
                return 0;
            }

            return state.cart.products.length;
        },

        isInCart: (state) => (product) => {
            if (
                (Object.keys(state.cart).length === 0 &&
                    state.cart.constructor === Object) ||
                state.cart.length == 0
            ) {
                return false;
            }

            if (
                state.cart.products.filter((p) => p.id === product.id).length >
                0
            ) {
                return true;
            }

            return false;
        },
    },
};

export default cart;
