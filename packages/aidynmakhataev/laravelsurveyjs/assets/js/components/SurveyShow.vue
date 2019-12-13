<template>
  <div>
    <survey :survey="survey"></survey>
  </div>
</template>

<script>
import * as SurveyVue from "survey-vue";

const Survey = SurveyVue.Survey;
SurveyVue.StylesManager.applyTheme(SurveyConfig.theme);
console.log("Hey there");

import * as widgets from "surveyjs-widgets";

Object.filter = (obj, predicate) =>
  Object.keys(obj)
    .filter(key => predicate(obj[key]))
    .reduce((res, key) => Object.assign(res, { [key]: obj[key] }), {});

const widgetsList = Object.filter(
  SurveyConfig.widgets,
  widget => widget === true
);

Object.keys(widgetsList).forEach(function(widget) {
  widgets[widget](SurveyVue);
});

export default {
  components: {
    Survey
  },
  props: ["surveyData"],
  data() {
    return {
      survey: {},
      respondent: "",
      agent: ""
    };
  },
  created() {
    this.survey = new SurveyVue.Model(this.surveyData.json);
    this.respondent = this.surveyData[0];
    this.agent = this.surveyData[1];
  },
  mounted() {
    this.survey.onComplete.add(result => {
      let url = `/survey/${this.surveyData.id}/result`;
      axios
        .post(url, {
          json: result.data,
          respondent: this.respondent,
          agent: this.agent
        })
        .then(response => {
          console.log(response);
        });
    });
  }
};
</script>
