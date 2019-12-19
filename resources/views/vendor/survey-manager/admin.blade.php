<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Survey Manager</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
     <script src="https://unpkg.com/jquery"></script>
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/survey-manager/css/survey.css') }}" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet"/>
</head>
<body>

<div id="survey-manager">
</div>

<script>
    window.SurveyConfig = {!! json_encode(config('survey-manager')) !!};
</script>

<script src="{{ asset('vendor/survey-manager/js/survey-manager.js') }}"></script>

</body>

</html>
