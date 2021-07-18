const address = {
    namespaced: true,
    state: () => ({
        all: [],
    }),
    mutations: {
        setAddresses(state, addresses) {
            state.all = addresses;
        },
    },
    actions: {
        getAddresses({ commit }) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/addresses")
                    .then((res) => {
                        commit("setAddresses", res.data.data);
                        resolve(res);
                    })
                    .catch((err) => {
                        commit("setAddresses", []);
                        reject(err);
                    });
            });
        }
    },
    getters: {
        pickupAddresses: (state) => {
            return state.all.filter(address => address.type === 'pickup');
        },
        deliveryAddresses: (state) => {
            return state.all.filter(address => address.type === 'delivery');
        },
    },
};

export default address;
