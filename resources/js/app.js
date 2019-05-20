require('./bootstrap');
import store from './store.js';
import VueSweetalert2 from 'vue-sweetalert2';
import VueInternationalization from 'vue-i18n';
import Locale from './i18n/vue-i18n-locales.generated';

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('products' , require('./components/products/Products.vue').default);
Vue.component('products-row' , require('./components/products/ProductsRow.vue').default)
Vue.component('product-option' , require('./components/product/Option.vue').default)
Vue.component('product-promotion' ,require('./components/product/Promotion.vue').default)
Vue.component('product-review' ,require('./components/product/ReviewModal.vue').default)
Vue.component('characters' , require('./components/characters/Characters.vue').default)
Vue.component('categories' , require('./components/categories/Categories.vue').default)
Vue.component('brands' , require('./components/brands/Brands.vue').default)
Vue.component('cart-dropdown', require('./components/cart/CartDropDown.vue').default);
Vue.component('checkout-my-cart', require('./components/checkout/MyCart.vue').default);
Vue.component('orders' , require('./components/orders/Orders.vue').default)
Vue.component('wishlist' , require('./components/wishlist/Wish.vue').default)
Vue.component('giftcard' , require('./components/giftcard/giftcard.vue').default)


Vue.use(VueInternationalization);

const lang = document.documentElement.lang.substr(0, 2);
// or however you determine your current app locale

const i18n = new VueInternationalization({
    locale: lang,
    messages: Locale
});
new Vue({
    el: '#app',
    store: new Vuex.Store(store),
    strict: true,
    i18n
});
Vue.use(VueSweetalert2);
