
<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SzW</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/survey-manager/css/survey.css') }}" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>

<div id="survey-manager">
</div>

<script>
    window.SurveyConfig = {!! json_encode(config('survey-manager')) !!};
</script>

<script src="{{ asset('vendor/survey-manager/js/survey-manager.js') }}"></script>
@if(Auth::user()->role_id == 6)
    <div class="container">
        <div class="row">
            <div class="well">
                <h2>Quality Control Form</h2>
            </div>
        </div>
        <div class="row">
            <form action="">
                <div class="form-group">
                    <label for="extension">Extension</label>
                    
                        <input type="text" id="extension" name="extension" class="form-control">
                    
                </div>
                 <div class="form-group">
                        <label for="scompliance">Script Compliance</label>
                        <input type="checkbox" id="scompliance" name="scompliance" class="form-control">
                    
                </div>
            </form>
        </div>
    </div>



    @endif
</body>
</html>
