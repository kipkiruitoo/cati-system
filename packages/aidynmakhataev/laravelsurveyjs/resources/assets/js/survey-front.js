require("./base");
import SurveyShow from "./components/SurveyShow.vue";
// import Vuetify from "vuetify";
import "vuetify/dist/vuetify.css";
import VueToastr from "vue-toastr";
window.Vue = require("vue");
window.Vuetify = require("vuetify");
Vue.use(Vuetify);
Vue.use(VueToastr);
Vue.component("survey-show", SurveyShow);

new Vue({
    el: "#surveyElement"
});
