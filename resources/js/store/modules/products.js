import axios from "axios";

const products = {
    namespaced: true,
    state: () => ({
        all: [],
        nextPage: null
    }),
    mutations: {
        addProducts (state, products) {
            state.all = state.all.concat(products);
        },
        setNextPage (state, nextPage) {
            state.nextPage = nextPage;
        }
    },
    actions: {
        fetchProducts ({commit}) {
            return new Promise((resolve, reject) => {
                axios.get('/api/products')
                    .then(res => {
                        commit('addProducts', res.data.data);
                        commit('setNextPage', res.data.links.next);
                        resolve(res);
                    }).catch(err => {
                        reject(err);
                    })
            })
        },
        fetchNextPage ({commit, state}) {
            return new Promise((resolve, reject) => {
                axios.get(state.nextPage)
                    .then(res => {
                        commit('addProducts', res.data.data);
                        commit('setNextPage', res.data.links.next);
                        resolve(res);
                    }).catch(err => {
                        reject(err);
                    })
            })
        }
    },
    getters: {},
};

export default products;
