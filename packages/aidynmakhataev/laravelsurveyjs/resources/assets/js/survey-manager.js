require("./base")

window.Vue = require("vue")

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import VueRouter from 'vue-router'
import App from './App'
import router from './router'
import SurveyShow from './components/SurveyShow.vue'
import SurveyResult from './components/SurveyResult'

Vue.use(VueRouter)
Vue.use(Vuetify)

Vue.component('survey-show', SurveyShow)
Vue.component('survey-results', SurveyResult)

new Vue({
    router,
    data () {
        return {
            snackbar: false,
            snackbarMsg: ''
        }
    },
    render: h => h(App)
}).$mount('#survey-manager')
