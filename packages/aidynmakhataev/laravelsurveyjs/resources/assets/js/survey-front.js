require("./base")

import SurveyShow from './components/SurveyShow.vue'

window.Vue = require("vue")

Vue.component('survey-show', SurveyShow)

new Vue({
    el: "#surveyElement"
})
