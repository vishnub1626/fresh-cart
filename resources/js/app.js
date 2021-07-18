require("./bootstrap");

import { createApp } from "vue";
import App from "./components/App.vue";
import router from "./router";
import store from "./store";

import ValidationError from "./components/ui/ValidationError";

const token = localStorage.getItem("token");
if (token) {
    axios.defaults.headers.common["Authorization"] = "Bearer ".token;
}

const app = createApp(App);
app.use(store).use(router).mount("#app");
app.component("validation-error", ValidationError);
