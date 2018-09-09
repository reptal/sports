
require('./bootstrap');
import router from "./routes";
import Vue from "vue";
import AppComponent from "./components/AppComponent.vue";
Vue.component(
    'pagination-component',
    require('./components/shared/PaginationComponent.vue')
);
Vue.component(
    'form-error',
    require('./components/shared/FormErrorComponent.vue')
);
const app = new Vue({
    el: '#app',
    components: {AppComponent},
    router
});
