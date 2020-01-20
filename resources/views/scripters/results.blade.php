
   <meta name="csrf-token" content="{{csrf_token()}}">
    <script src="https://unpkg.com/jquery"></script>



    <div id="results">
    <download-csv
    class   = "btn btn-default"
    :data   = "JSON.parse(JSON.stringify({{$new_array}}))"
    name    = "{{time()}}.csv">

    Download CSV (This is a slot)

</download-csv>
<spreadsheet></spreadsheet>


    </div>


<script src="{{ asset('js/app.js')}}"></script>







