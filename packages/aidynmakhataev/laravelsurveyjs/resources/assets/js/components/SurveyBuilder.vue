<template>

  <div>
    <div id="surveyEditorContainer"></div>
  </div>
</template>

<script>
import * as SurveyCreator from "survey-creator";
import "survey-creator/survey-creator.css";

import * as SurveyKo from "survey-knockout";
import * as widgets from "surveyjs-widgets";

widgets.icheck(SurveyKo);
widgets.select2(SurveyKo);
widgets.inputmask(SurveyKo);
widgets.jquerybarrating(SurveyKo);
widgets.jqueryuidatepicker(SurveyKo);
widgets.nouislider(SurveyKo);
widgets.select2tagbox(SurveyKo);
widgets.signaturepad(SurveyKo);
widgets.sortablejs(SurveyKo);
widgets.ckeditor(SurveyKo);
widgets.autocomplete(SurveyKo);
widgets.bootstrapslider(SurveyKo);

export default {
  name: "survey-builder",
  props: ["json", "id"],
  data() {
    return {
      surveyData: this.json,
      surveyId: this.id
    };
  },
  mounted() {
    let editorOptions =  {showLogicTab: true, showState: true, haveCommercialLicense: true, showPropertyGrid:true,showEmbededSurveyTab:true};;
    SurveyCreator.StylesManager.applyTheme("orange");

    this.editor = new SurveyCreator.SurveyCreator(
      "surveyEditorContainer",
      editorOptions
    );
    this.editor.text = JSON.stringify(this.surveyData);
    let self = this;

    this.editor.saveSurveyFunc = function() {
      axios
        .put("/survey/" + self.id, { json: JSON.parse(this.text) })
        .then(response => {
          self.editor.text = JSON.stringify(response.data.data.json);
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

<!-- Add "scoped" attribute to limit CSS to this component only -->
