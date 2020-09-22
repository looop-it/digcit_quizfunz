
require('./bootstrap');
require('./vendor');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('competition', require('./components/competition/Start.vue'));
Vue.component('competition-result', require('./components/competition/Result.vue'));

Vue.component('competition-mobile', require('./components/competition/mobile/Start.vue'));
Vue.component('competition-mobile-result', require('./components/competition/mobile/Result.vue'));

const app = new Vue({
    el: '#app'
});
