<template>
  <div>
    <div class="container">
      <div class="row">
        <survey :survey="surveyData"></survey>
      </div>
      <hr />
      <hr />
      <div class="row">
        <h2>Feedback</h2>
        <form>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input
              type="text"
              class="form-control"
              id="exampleInputPassword1"
              placeholder="Password"
            />
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import * as SurveyVue from "survey-vue";

const Survey = SurveyVue.Survey;
SurveyVue.StylesManager.applyTheme(SurveyConfig.theme);

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
  name: "survey-result",
  components: {
    Survey
  },
  data() {
    return {
      results: [],
      loading: false,
      survey: {},
      dialog: false,
      surveyData: {},
      surveyId: this.$route.params.id,
      interview: this.$route.params.interview,
      page: 1,
      pageLength: 1
    };
  },
  mounted() {
    this.getSurveyResults(this.$route.params.id, this.$route.params.interview);
  },
  watch: {
    page() {
      this.getSurveyResults();
      this.surveyData.data = this.results.json;
    }
  },
  methods: {
    getSurveyResults(id = this.surveyId, interview = this.interview) {
      this.loading = true;
      axios
        .get("/survey/" + id + "/result/" + interview + "?page=" + this.page)

        .then(response => {
          this.results = response.data.data;
          console.log(response.data.data);
          this.survey = response.data.meta.survey;
          this.pageLength = Math.ceil(
            response.data.meta.total / response.data.meta.per_page
          );
          this.loading = false;
          this.surveyData = new SurveyVue.Model(response.data[0].json);
        //   this.surveyData.mode = "display";
          this.surveyData.data = this.results[0].json;
        //   console.log(this.surveyData.data);
        })
        .catch(error => {
          console.info(error.response);
          this.loading = false;
        });
    },
    showSurvey(result) {
      this.dialog = true;
      this.surveyData.data = result.json;
    }
  }
};
</script>
