const orders = {
    namespaced: true,
    state: () => ({
        orders: [],
    }),
    mutations: {},
    actions: {
        placeOrder({ commit }, data) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/orders", data)
                    .then((res) => {
                        resolve(res);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
    getters: {},
};

export default orders;
