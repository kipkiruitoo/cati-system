require("./base");

import SurveyShow from "./components/SurveyShow.vue";
import Vuetify from "vuetify";

window.Vue = require("vue");

Vue.component("survey-show", SurveyShow);

new Vue({
    el: "#surveyElement"
});

// Vue.use(Vuetify);
