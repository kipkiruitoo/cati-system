<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description"
    content="JSON viewer web-based tool to view JSON content in table and treeview format. The tool visually converts JSON to table and tree for easy navigation, analyze and validate JSON.">
  <meta name="author" content="">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link href="{{asset('viewer.css')}}" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <title>{{$survey->name}}</title>
    <style>
.float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	right:40px;
	background-color:#0C9;
	color:#FFF;
	border-radius:50px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}

.my-float{
    margin-top:10px;
    font-size: 16px;
}
    </style>
  <!-- Bootstrap -->
  <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div class="container-fluid" id="container">
<nav>
{{$survey->name}}
</nav>
      <div id="table_pnl">
          <div class="top_size"></div>
          <div id="inner_tbl"></div>
    </div>

    <button onclick ="downloaddocx()" href="#" class="float">
        <i class="fa fa-download my-float"></i><br>
         
</button>
</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <script src="http://jquery.jcubic.pl/js/jquery.splitter-0.14.0.js"></script>
  <link href="http://jquery.jcubic.pl/css/jquery.splitter.css" rel="stylesheet" />

  <script type="text/javascript">var switchTo5x = true;</script>
  <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
  <script
    type="text/javascript">stLight.options({ publisher: "ur-b8756614-8756-d77-785e-7018db6c35ac", doNotHash: true, doNotCopy: true, hashAddressBar: false });</script>

  <script src="{{asset('viewer.js')}}"></script>
     <script src="{{asset('html-docx.js')}}"></script>
    <script>
        var json = @json($survey->json);
        console.log(json)

        processJson(json);


        function downloaddocx(){
            // html-docx.js
            let content = document.documentElement.innerHTML;
            var converted = htmlDocx.asBlob(content, {orientation: 'landscape', margins: {top: 720}});
            saveAs(converted, '{{$survey->name}}.docx');

            alert('Please enable editing in word to view the document properly')
        }
    </script>
    <!-- session_create_id -->
  <!-- <script src="data.js"></script>
  <script src="app.js"></script> -->
</body>

</html>