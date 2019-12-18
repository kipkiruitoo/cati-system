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
Survey.cssType = "darkblue";

import * as widgets from "surveyjs-widgets";

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
      count: 0
    };
  },
  created() {
    this.survey = new SurveyVue.Model(this.surveyData.json);
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
          if (this.count == 1) {
            this.survey.clear();
            toastr.success(
              "The first interview has been successfully saved",
              "Success"
            );
            this.survey.render();
          } else {
            toastr.success(
              "Both interviews  have been successfully saved",
              "Success"
            );
            window.history.back();
          }
        });
    });
  }
};
</script>
