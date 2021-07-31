import Vue from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from 'vuetify'
import 'leaflet/dist/leaflet.css'
import '../styles/font-awesome.min.css'
import VueModalTor from "vue-modaltor/dist/vue-modaltor.common";
import "vue-modaltor/dist/vue-modaltor.css";



Vue.use(VueModalTor, {
    bgPanel: "#7957d5"
  });


Vue.config.productionTip = false

new Vue({
    router,
    vuetify,
    render: h => h(App)
}).$mount('#app')
