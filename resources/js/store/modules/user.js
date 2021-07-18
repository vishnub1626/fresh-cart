const user = {
    namespaced: true,
    state: () => ({
        token: localStorage.getItem("token") || "",
    }),
    mutations: {
        setToken(state, token) {
            state.token = token;
        },
    },
    actions: {
        register({ commit }, data) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/users", data)
                    .then((res) => {
                        resolve(res);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },

        login({ commit }, user) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/login", user)
                    .then((res) => {
                        const token = res.data.data.token;
                        localStorage.setItem("token", token);
                        axios.defaults.headers.common["Authorization"] =
                            "Bearer ".token;
                        commit("setToken", token);
                        resolve(res);
                    })
                    .catch((err) => {
                        localStorage.removeItem("token");
                        reject(err);
                    });
            });
        },
    },
    getters: {
        isAuthenticated: (state) => !!state.token,
    },
};

export default user;
