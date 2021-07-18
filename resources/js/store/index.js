import Vuex from 'vuex';

import user from './modules/user';
import products from './modules/products';
import cart from './modules/cart';
import orders from './modules/orders';
import address from './modules/address';

export default new Vuex.Store({
    modules: {
        user,
        products,
        cart,
        orders,
        address,
    }
})