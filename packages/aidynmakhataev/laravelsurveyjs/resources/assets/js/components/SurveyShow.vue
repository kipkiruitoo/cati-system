<template>
  <div>
    <v-menu v-if="requiredate">
      <v-text-field
        slot="activator"
        :value="date"
        label="Pick a date"
        prepend-icon="date_range"
        readonly
        max-width="290"
      ></v-text-field>
      <v-date-picker
        v-model="date"
        color="green lighten-1"
        @change="checkdate"
        id="date"
        :max="new Date().toISOString().substr(0, 10)"
      ></v-date-picker>
    </v-menu>
    <survey v-show="showsurvey" :survey="survey"></survey>
  </div>
</template>

<script>
import * as SurveyVue from "survey-vue";

const Survey = SurveyVue.Survey;
Survey.cssType = "material";

import format from "date-fns/format";

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
      requiredate: false,
      showsurvey: false,
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
  methods: {
    checkdate() {
      let url = `/check-date`;

      axios
        .post(url, {
          date: this.date,
          respondent: this.respondent.respondent
        })
        .then(response => {
          console.log(response.data.exists);
          if (response.data.exists) {
            this.showsurvey = false;
          } else {
            this.showsurvey = true;
          }
        });
    }
  },
  computed: {
    formattedDate() {
      return this.date ? format(this.date, "dddd, MMMM Do YYYY") : "";
    }
  },
  mounted() {
    if (this.project == 24) {
      this.requiredate = true;
      //   this.showsurvey = true;
    } else {
      this.showsurvey = true;
    }
    this.survey.onComplete.add(result => {
      let url = `/survey/${this.surveyData.id}/result`;
      axios
        .post(url, {
          json: result.data,
          agent: this.agent,
          respondent: this.respondent.respondent,
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
            window.history.back()
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
