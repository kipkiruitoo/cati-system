<template>
  <div>
    <survey :survey="survey"></survey>
  </div>
</template>
<script>
//In your VueJS App.vue or yourComponent.vue file add these lines to import
// import SurveyCreator from './components/SurveyCreator'
import * as SurveyVue from "survey-vue";
// import 'bootstrap/dist/css/bootstrap.css';

var Survey = SurveyVue.Survey;
Survey.cssType = "bootstrap";

//If you want to add custom widgets package
//Add these imports
import * as widgets from "surveyjs-widgets";
import "inputmask/dist/inputmask/phone-codes/phone.js";
//And initialize widgets you are want ti use
widgets.icheck(SurveyVue);
widgets.select2(SurveyVue);
widgets.inputmask(SurveyVue);
widgets.jquerybarrating(SurveyVue);
widgets.jqueryuidatepicker(SurveyVue);
widgets.nouislider(SurveyVue);
widgets.select2tagbox(SurveyVue);
widgets.signaturepad(SurveyVue);
widgets.sortablejs(SurveyVue);
widgets.ckeditor(SurveyVue);
widgets.autocomplete(SurveyVue);
widgets.bootstrapslider(SurveyVue);

export default {
  name: "survey-result",
  components: {
    Survey,
  },
  data() {
    //Define Survey JSON
    //Here is the simplest Survey with one text question
    var json = {
      elements: [
        {
          type: "text",
          name: "customerName",
          title: "What is your name?",
          isRequired: true,
        },
      ],
    };

    var url = window.location.href.split("/");
    console.log(url);

    //Create the model and pass it into VueSJ Survey component
    // var model = new SurveyVue.Model(json);
    //You may set model properties
    // model.mode="display"

    return {
      survey: {},
      results: [],
      id: url[4],
      interview: url.pop(),
    };
  },
  mounted() {
    this.getResults(this.id, this.interview);
  },
  watch: {
    page() {
      this.getResults();
      this.survey.data = this.results.json;
    },
  },
  methods: {
    getResults(id = this.id, interview = this.interview) {
      axios
        .get("/api/survey/" + id + "/result/" + interview)
        .then((response) => {
          this.results = response.data.result;
          this.survey = new SurveyVue.Model(response.data.survey.json);
          console.log(response.data.result);
          this.survey.mode = "display";
          this.survey.data = this.results;
        })
        .catch((error) => {
        //   console.info(error.response);
          this.loading = false;
        });
    },
  },
};
</script>
