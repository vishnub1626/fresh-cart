import Vuex from 'vuex';

import user from './modules/user';
import products from './modules/products';
import cart from './modules/cart';

export default new Vuex.Store({
    modules: {
        user,
        products,
        cart,
    }
})