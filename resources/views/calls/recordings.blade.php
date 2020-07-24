<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel 5.8 - Individual Column Search in Datatables using Ajax</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </head>
 <body>
  <div class="container">
     <br />
     <h3 align="center">Recordings</h3>
     <br />
            <br />
            <div class="row">
                <div class="col-md-4"></div>

                <div class="col-md-4"></div>
            </div>
            <br />
<div class="table-responsive">
    <table id="customer_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            {{-- <th>Session Id</th> --}}
                            <th>Agent</th>
                            <th>Phone Called</th>
                            <th>Recording</th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                </table>
   </div>
            <br />
            <br />
  </div>
 </body>
</html>

<script>
$(document).ready(function(){

    fill_datatable();

    function fill_datatable(filter_phone = '', filter_agent = '')
    {
        var dataTable = $('#customer_data').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "{{ route('recordings') }}",
                data:{filter_phone:filter_phone, filter_agent:filter_agent}
            },
            columns: [
                {
                    data:'agent',
                    name:'Agent'
                },
             {
                    data:'phonecalled',
                    name:'Phone Called'
                },
                 {
                    data:'recording_link',
                    name:'Recording'
                },
                {
                    data:'created_at',
                    name:'Date and Time'
                }
            ]
        });
    }

    $('#filter').click(function(){
        var filter_gender = $('#filter_gender').val();
        var filter_country = $('#filter_country').val();

        if(filter_agent != '' &&  filter_phone != '')
        {
            $('#customer_data').DataTable().destroy();
            fill_datatable(filter_agent, filter_phone);
        }
        else
        {
            alert('Select Both filter option');
        }
    });

    $('#reset').click(function(){
        $('#filter_agent').val('');
        $('#filter_phone').val('');
        $('#customer_data').DataTable().destroy();
        fill_datatable();
    });

});
</script>
