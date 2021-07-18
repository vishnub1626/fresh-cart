import Vuex from 'vuex';

import user from './modules/user';
import products from './modules/products';

export default new Vuex.Store({
    modules: {
        user,
        products
    }
})