<template>
  <div>
    <div class="container-fluid">
      <div class="row">
        <div class="form-group ml-5 mt-1">
          <button class="btn btn-dark" @click="getcsv()">
            <i class="fa fa-industry" aria-hidden="true"></i> Generate Csv Structure
          </button>
          <br />
          <small>Please note that this feature is under development and might not be accurate if your survey consists of complex panels</small>
          <br />
          <small>
            Contact the developer:
            <a href="mailto:daviskipkiruitoo@gmail.com">Davis Too</a> for any enquiries
          </small>
        </div>
      </div>
      <hr />
    </div>
    <div id="surveyEditorContainer"></div>
  </div>
</template>

<script>
import * as SurveyEditor from "survey-creator";
import "survey-creator/survey-creator.css";
import * as swahiliStrings from "../swahili";
import * as SurveyKo from "survey-knockout";
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
  widgets[widget](SurveyKo);
});
export default {
  name: "survey-builder",
  props: ["json", "id"],
  data() {
    return {
      surveyData: this.json,
      surveyId: this.id,
      structure: {}
    };
  },
  methods: {
    getcsv() {
      //   this.surveyData.subscribe(data =>{
      //         let json =
      //   })
      var questions = this.getjson();
      var finalArray = [];
      finalArray.push(questions);
      axios.post("/getcsvstring", { finalArray: finalArray }).then(result => {
        // console.log(result.data);
        let csvContent = "data:text/csv;charset=utf-8," + result.data;
        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "test.csv");
        document.body.appendChild(link); // Required for FF
        link.click();
        // let self = this;
      });
    },
    getjson() {
      let json = JSON.stringify(this.surveyData);
      json = JSON.parse(json);
      //   console.log(json);
      var pages = json.pages;
      //   console.log(pages);
      var questions = {};
      pages.forEach(element => {
        console.log(element);
        let elements = element.elements;
        // console.log(elements);
        elements.forEach(el => {
          // console.log(el)
          //   if (el.type === "dropdown") {
          //     let question = {};
          //     let name = el.name;
          //     let choices = el.choices;
          //     //   console.log(el.choices);
          //     choices.forEach(element => {
          //       // console.log(choices.indexOf(element));
          //       question[choices.indexOf(element)] = "answer";
          //     });
          //     questions[name] = question;
          //   } else
          if (el.type === "checkbox") {
            let question = [];
            let name = el.name;
            let rows = el.choices;
            rows.forEach(row => {
              //   console.log(row)
              question[rows.indexOf(row)] = "";
            });
            questions[name] = question;
          } else if (el.type === "") {
            let question = {};
            let name = el.name;
            let rows = el.rows;
            rows.forEach(row => {
              //   console.log(row)
              question[rows.indexOf(row)] = "";
            });
            questions[name] = question;
          } else {
            let name = el.name;
            //   let question = `${name} : null`;
            //   questions.push(question);
            questions[name] = "";
            // console.log(questions)
          }
        });
        //   console.log(questions);
      });
      // console.log(questions);
      // console.log(jsonArray);
      //   var finalArray = [];
      //   finalArray.push(questions);
      //   console.log(finalArray);
      //   this.structure = JSON.stringify(questions);
      //   this.structure = JSON.parse(this.structure);
      //   console.log(this.structure);
      return questions;
    }
  },
  mounted() {
    let editorOptions = SurveyConfig.builder;
    SurveyEditor.StylesManager.applyTheme("orange");
    SurveyEditor.editorLocalization.locales["bg"] = swahiliStrings;
    // SurveyEditor.editorLocalization.localeNames["bg"] = "Swahili";
    this.editor = new SurveyEditor.SurveyEditor(
      "surveyEditorContainer",
      editorOptions
    );
    let structure = this.getjson();
    this.editor.text = JSON.stringify(this.surveyData);
    let self = this;
    this.editor.saveSurveyFunc = function() {
      axios
        .put("/survey/" + self.id, {
          json: JSON.parse(this.text),
          structure: structure
        })
        .then(response => {
          self.editor.text = JSON.stringify(response.data.data.json);
          this.surveyData = response.data.data;
          self.$root.snackbar = true;
          self.$root.snackbarMsg = response.data.message;
        })
        .catch(error => {
          console.error(error.response);
        });
    };
  }
};
</script>

<style>
.btn-primary {
  background-color: #253e57 !important;
}
</style>