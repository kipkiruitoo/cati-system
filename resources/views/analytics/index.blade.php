<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=div#, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
        <script src="https://unpkg.com/jquery"></script>
        <script src="https://surveyjs.azureedge.net/1.5.12/survey.jquery.js"></script>
        <link href="https://surveyjs.azureedge.net/1.5.12/modern.css" type="text/css" rel="stylesheet"/>
        <link rel="stylesheet" href="./index.css">


          <script src="../node_modules/datatables.net/js/jquery.dataTables.js"></script>
    <script src="../node_modules/datatables.net-dt/js/dataTables.dataTables.js"></script>
    <script src="../node_modules/datatables.net-buttons/js/dataTables.buttons.js"></script>
    <script src="../node_modules/datatables.net-buttons/js/buttons.print.js"></script>
    <script src="../node_modules/datatables.net-buttons/js/buttons.html5.js"></script>
    <script src="../node_modules/datatables.net-colreorder/js/dataTables.colReorder.js"></script>
    <script src="../node_modules/datatables.net-responsive/js/dataTables.responsive.js"></script>
    <script src="../node_modules/datatables.net-rowgroup/js/dataTables.rowGroup.js"></script>
    <script src="../node_modules/datatables.net-select/js/dataTables.select.js"></script>

    <script src="../node_modules/datatables.net-buttons-dt/js/buttons.dataTables.js"></script>
    <script src="../node_modules/datatables.net-colreorder-dt/js/colReorder.dataTables.js"></script>
    <script src="../node_modules/datatables.net-responsive-dt/js/responsive.dataTables.js"></script>
    <script src="../node_modules/datatables.net-rowgroup-dt/js/rowGroup.dataTables.js"></script>
    <script src="../node_modules/datatables.net-select-dt/js/select.dataTables.js"></script>

        <link href="https://surveyjs.azureedge.net/1.5.12/survey.analytics.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://cdn.rawgit.com/inexorabletash/polyfill/master/typedarray.js"></script>

        <script src="https://polyfill.io/v3/polyfill.min.js"></script>

        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

        <script src="https://unpkg.com/wordcloud@1.1.0/src/wordcloud2.js"></script>

        <script src="https://surveyjs.azureedge.net/1.5.12/survey.analytics.js"></script>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Data Table</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Summary</a>
  </li>
 
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <div id="surveyElement" style="display:inline-block;width:100%;"></div>
        <div id="summaryContainer"></div>
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><div id="dataTablesContainer"></div></div>
</div>
   
     


<script>


    
Survey
    .StylesManager
    .applyTheme("modern");

var json =JSON.stringify({!! json_encode($survey[0]) !!}) ;

window.survey = new Survey.Model(json);
window.onload = function () {
        var surveyResultNode = document.getElementById("summaryContainer");
        surveyResultNode.innerHTML = "";
        console.log(@json($results)) 
       var data = @json($results);
         var normalizedData = data
                .map(function (item) {
                    survey
                        .getAllQuestions()
                        .forEach(function (q) {
                            if (item[q.name] === undefined) {
                                item[q.name] = "";
                            }
                        });
                    return item;
                });

            var visPanel = new SurveyAnalytics.VisualizationPanel(surveyResultNode, survey.getAllQuestions(), normalizedData);
            visPanel.render();
            var surveyAnalyticsDataTables = new SurveyAnalytics.DataTables(
  document.getElementById("dataTablesContainer"),
  survey,
  normalizedData
);

surveyAnalyticsDataTables.render();
        
    };
// survey
//     .onComplete
//     .add(function (result) {
//         document
//             .querySelector('#surveyResult')
//             .textContent = "Result JSON:\n" + JSON.stringify(result.data, null, 3);
//     });

// $("#summaryContainer").Survey({model: survey});

// survey
//     .onComplete
//     .add();
</script>
</body>
</html>