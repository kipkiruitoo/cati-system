require("./base")
import SurveyShow from "./components/SurveyShow.vue";
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

window.Vue = require("vue")
Vue.use(Vuetify)
Vue.component("survey-show", SurveyShow);

new Vue({
    el: "#surveyElement"
})
