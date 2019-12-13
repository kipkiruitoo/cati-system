require("./base")

window.Vue = require("vue")
import SurveyShow from "./components/SurveyShow.vue";

Vue.component("survey-show", SurveyShow);

new Vue({
    el: "#surveyElement"
})
