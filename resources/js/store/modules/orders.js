const orders = {
    namespaced: true,
    state: () => ({
        all: [],
        nextPage: null,
        order: {},
        interval: null,
    }),
    mutations: {
        newInterval(state, interval) {
            state.interval = interval;
        },
        setOrdersOnPageload(state, orders) {
            state.all = orders;
        },
        setOrders(state, orders) {
            state.all = state.all.concat(orders);
        },
        setNextPage(state, nextPage) {
            state.nextPage = nextPage;
        },
        setOrder(state, order) {
            state.order = order;
        },
    },
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
        getOrders({ commit }, loadingPage) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/orders")
                    .then((res) => {
                        if (loadingPage) {
                            commit("setOrdersOnPageload", res.data.data);
                        } else {
                            commit("setOrders", res.data.data);
                        }
                        commit("setNextPage", res.data.links.next);
                        resolve(res);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
        fetchNextPage({ commit, state }) {
            return new Promise((resolve, reject) => {
                axios
                    .get(state.nextPage)
                    .then((res) => {
                        commit("setOrders", res.data.data);
                        commit("setNextPage", res.data.links.next);
                        resolve(res);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
        getOrder({ commit }, id) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/orders/" + id)
                    .then((res) => {
                        commit("setOrder", res.data.data);
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
