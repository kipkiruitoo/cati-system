<template>
  <div>
    <div class="form-group">
      <label for="date">Pick the date</label>
      <input type="date" id="date" class="form-control" name="date" v-model="date" />
    </div>
    <survey :survey="survey"></survey>
  </div>
</template>

<script>
import * as SurveyVue from "survey-vue";

const Survey = SurveyVue.Survey;
Survey.cssType = "material";

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
      agent: "",
      date: "",
      project: "",
      sid: "",
      count: 0,
      nit: 1
    };
  },
  created() {
    this.survey = new SurveyVue.Model(this.surveyData.json);
    this.nit = this.surveyData.num;
    this.agent = this.surveyData[1];
    this.project = this.surveyData.project;
    this.sid = this.surveyData.id;
    this.respondent = this.surveyData[0];
    localStorage.setItem("count", this.count);
  },
  mounted() {
    this.survey.onComplete.add(result => {
      let url = `/survey/${this.surveyData.id}/result`;
      axios
        .post(url, {
          json: result.data,
          agent: this.agent,
          respondent: this.respondent,
          survey: this.sid,
          project: this.surveyData.project,
          date: this.date
        })
        .then(response => {
          console.log(response);
          this.count++;
          localStorage.setItem("count", this.count);
          console.log(this.count);
          if (this.count == this.nit) {
            toastr.success(
              "Both interviews  have been successfully saved",
              "Success"
            );
            window.history.back();
          } else {
            this.survey.clear();
            toastr.success(
              "The  interview has been successfully saved",
              "Success"
            );
            this.survey.render();
          }
        });
    });
  }
};
</script>
