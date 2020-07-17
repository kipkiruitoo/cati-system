<template>
  <div>
    <v-menu v-if="requiredate">
      <v-text-field
        slot="activator"
        :value="date"
        label="Date of Consumption"
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
    <div class="form-group">
      <label for="locale">Select Survey Language</label>
      <select v-model="slocale" @change="onlocaleChange" id="locale" class="form-control">
        <option value="en">English</option>
        <option value="bg">Swahili</option>
        <option value="it" >Vernacular</option>
        <option value="de">Maasai</option>
        <option value="pl">Somali</option>
      </select>
    </div>

    <survey v-show="showsurvey" :survey="survey"></survey>
  </div>
</template>

<script>
import * as SurveyVue from "survey-vue";
import * as swahiliStrings from "../swahili";
var Survey = SurveyVue.Survey;
Survey.cssType = "material";
Survey.sendResultOnPageNext = true;

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
  props: ["surveyData", "selectedphone", "callSession", "jsonData"],

  data() {
    return {
      survey: {},
      respondent: "",
      agent: "",
      date: "",
      jsondata: "",
      project: "",
      phonenumber: 0,
      sid: "",
      count: 0,
      starttime: "",
      endtime: "",
      sessionId: "",
      slocale: "en",
      requiredate: false,
      showsurvey: false,
      nit: 1
    };
  },
  created() {
    this.survey = new SurveyVue.Model(this.surveyData.json);
    this.survey.sendResultOnPageNext = true;
    this.nit = this.surveyData.num;
    this.agent = this.surveyData[1];
    this.project = this.surveyData.project;
    this.sid = this.surveyData.id;
    this.respondent = this.surveyData[0];
    this.jsondata = JSON.stringify(this.jsonData);
    this.phonenumber = this.selectedphone;
    // this.sessionId = this.callSession;
    localStorage.setItem("count", this.count);
    localStorage.setItem("phone", this.phonenumber);
    // let today = new Date();
    this.starttime = this.gettime();

    console.log(this.starttime);

    // console.log(this.jsondata);
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
            this.$toastr.i(
              "An  Interview Already Exists for this Respondent for that Date"
            );
            this.showsurvey = false;
          } else {
            this.showsurvey = true;
          }
        });
    },
    loadResults() {
      console.log(this.jsondata);
      this.survey.data = JSON.parse(this.jsondata);
      if (this.jsondata != "null") {
        // alert("An incomplete Interview Exists for this user");
        this.$toastr.i("An Unfinished Interview Exists for this Respondent");
      }
    },
    onlocaleChange() {
      this.survey.locale = this.slocale;
      console.log(this.slocale);
      this.survey.render();
    },
    gettime() {
      var today = new Date();
      var date =
        today.getFullYear() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getDate();
      var time =
        today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
      var dateTime = date + " " + time;

      return dateTime;
    }
  },
  computed: {
    formattedDate() {
      return this.date ? format(this.date, "dddd, MMMM Do YYYY") : "";
    }
  },
  watch: {
    page() {
      this.loadResults();
      this.survey.sendResultOnPageNext = true;
      this.survey.data = this.jsondata;
      // console.log(this.survey.data);
    }
  },
  mounted() {
    this.survey.sendResultOnPageNext = true;
    this.loadResults();
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
          json: this.survey.data,
          agent: this.agent,
          respondent: this.respondent.respondent,
          survey: this.sid,
          start_time: this.starttime,
          end_time: this.gettime(),
          callsession: window.CallSession,
          phonenumber: this.phonenumber,
          project: this.surveyData.project,
          date: this.date
        })
        .then(response => {
          console.log(response);
          this.count++;
          localStorage.setItem("count", this.count);
          console.log(this.count);
          if (this.count == this.nit) {
            this.$toastr.s("Interview Successfully Finished");
            window.history.back();
          } else {
            this.survey.clear();
            this.$toastr.i(
              "The  interview has been successfully saved",
              "Success"
            );
            this.survey.render();
          }
        });
    });
    this.survey.onPartialSend.add(result => {
      let url = "/incomplete";
      var resultAsString = JSON.stringify(this.survey.getPlainData);
      // alert(resultAsString); //send Ajax request to your web server.
      axios
        .post(url, {
          json: result.data,
          agent: this.agent,
          respondent: this.respondent.respondent,
          survey: this.sid,
          // phonenumber: this.phonenumber,
          project: this.surveyData.project
          // date: this.date
        })
        .then(result => {
          console.log(result);
          if (result.data.message === "Success") {
            this.$toastr.i("Progress Successfully Saved");
          }
        })
        .catch(error => {
          console.log(error);
        });
    });
  }
};
</script>
<style lang="scss">
.sv_q_description span {
  color: red;
  font-size: large;
}
</style>
