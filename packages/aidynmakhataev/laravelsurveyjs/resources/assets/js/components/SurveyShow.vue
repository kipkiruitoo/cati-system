<template>
    <div>
        <div class="form-group">
            <label for="date">Pick the date</label>
            <input
                type="date"
                id="date"
                class="form-control"
                name="date"
                v-model="date"
            />
        </div>

        <survey :survey="survey"></survey>
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
            count: 0
        };
    },
    created() {
        this.survey = new SurveyVue.Model(this.surveyData.json);
        this.agent = this.surveyData[1];
        this.respondent = this.surveyData[0];
    },
    mounted() {
        this.survey.onComplete.add(result => {
            let url = `/survey/${this.surveyData.id}/result`;
            axios
                .post(url, {
                    json: result.data,
                    agent: this.agent,
                    respondent: this.respondent,
                    date: this.date
                })
                .then(response => {
                    console.log(response);
                    this.count++;
                    console.log(this.count);
                    if (this.count == 1) {
                        this.survey.clear();
                        this.survey.render();
                    } else {
                        window.history.back();
                    }
                });
        });
    }
};
</script>
