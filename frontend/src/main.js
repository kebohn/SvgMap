import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import router from '@/router.js'
import axios from 'axios'
import panzoom from 'panzoom'
import Buefy from 'buefy'
import '@/assets/css/spacing.scss'
import '@/assets/css/main.scss'
import { library } from '@fortawesome/fontawesome-svg-core';
// internal icons
import { faCheck, faCheckCircle, faInfoCircle, faExclamationTriangle, faExclamationCircle,
    faArrowUp, faAngleRight, faAngleLeft, faAngleDown, faEye, faEyeSlash, faCaretDown,
    faCaretUp, faUpload, faTimes, faTrash, faFolder, faSyncAlt, faChevronLeft, faChevronRight,
    faPlus, faMinus, faExpandAlt, faFile, faEdit} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faCheck, faCheckCircle, faInfoCircle, faExclamationTriangle, faExclamationCircle,
    faArrowUp, faAngleRight, faAngleLeft, faAngleDown, faEye, faEyeSlash, faCaretDown, faCaretUp,
    faUpload, faTimes, faTrash, faFolder, faSyncAlt, faChevronLeft, faChevronRight, faPlus, faMinus,
    faExpandAlt, faFile, faEdit);
Vue.component('vue-fontawesome', FontAwesomeIcon);

Vue.use(Buefy, {
  defaultIconComponent: 'vue-fontawesome',
  defaultIconPack: 'fas',
})
Vue.use(VueRouter)

Vue.prototype.$http = axios

Vue.prototype.$eventBus = new Vue()

Vue.prototype.$panzoom = panzoom

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
