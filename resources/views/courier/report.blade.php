@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        @include('layouts.alerts.message')
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
              <div class="card-header">
                        <h4>Uplift Report</h4>
                    </div>
                    <div class="card-body">
                        <form id="addFormAppForm" method="post" action="javascript:void(0)">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="order_id">From</label>
                                        <select class="form-control" name="from" id="from">
                                            <option value="">Select Region</option>
                                            @if(!empty($region))
                                            @foreach($region as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="status">To</label>
                                        <select class="form-control" name="to" id="to">
                                            <option value="">Select Region</option>
                                            @if(!empty($region))
                                            @foreach($region as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="customer">Status</label>
                                        <select class="form-control" name="status" id="status">
                                           <option value="">Select Status</option>
                                            <option value="3">Collected</option>
                                            <option value="4">On Transit</option>
                                            <option value="5">Off Loaded</option>
                                            <option value="6">Delivered</option>


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="date_added">Start Date</label>
                                        
                                           <input
                                                id="date1" type="date" class="form-control" name="from">
                                        
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="date_modified">End Date</label>
                                      
                                           <input
                                                id="date2" type="date" class="form-control" name="to">
                                       
                                    </div>
                                </div>
                                 <div class="col-md-6">
                      <br><button type="submit" class="btn btn-primary search">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div> 
                            </div>
                        </form>
<br><br>
                     <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr role="row">

                                    <th class="" rowspan="1" colspan="1" style="width: 208.531px;">#</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 186.484px;">Date</th>
                           <th class="" rowspan="1" colspan="1" style="width: 186.484px;">REF NO <br>Shipment Name</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 186.484px;">Client <br>Receiver</th>
                               
                                    <th class="" rowspan="1" colspan="1" style="width: 141.219px;">Route
                                       
                                    </th>
                              <th class="" rowspan="1" colspan="1" style="width: 186.484px;">Truck</th>
                              <th class="" rowspan="1" colspan="1" style="width: 141.219px;">Driver</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 141.219px;">Weight</th>
                                    

                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" style="width: 141.219px;">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                 @if(!@empty($report))
                                            @foreach ($report as $row)
                                            <tr class="gradeA even" role="row">

                                                <td> {{$loop->iteration}}</td>
                                                <td>{{Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}}</td>
                                                <td>{{$row->pacel_number}} <br>{{$row->pacel_name}}</td>
                                                    <td>-{{$row->client->name}} <br>-{{$row->receiver_name}}</td>                                              
                                                <td>From {{$row->region_s->name}} to {{$row->region_e->name}}</td>
                                            <td>{{$row->truck_id}}</td> 
                                             <td>{{$row->driver_id}}</td>   
                                            <td>{{$row->weight}} kgs</td>
                                                          
                                                
<td>
                                                    @if($row->status == 3)
                                                    <div class="badge badge-success badge-shadow">Collected</div>
                                                       @elseif($row->status == 4)
                                                    <div class="badge badge-info badge-shadow">On Transit</div>
                                                       @elseif($row->status == 5)
                                                    <div class="badge badge-primary badge-shadow">Arrived</div>
                                                      @elseif($row->status == 6)
                                                    <div class="badge badge-primary  badge-shadow">Delivered</div>
                                                    @endif
                                                </td>

                                              

                                            </tr>
                                            @endforeach
                                      
                                            @endif
                            </tbody>
                        </table>
</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        searching: false,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },
    
            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});
</script>
<script>
$(document).ready(function() {

  

    $(document).on('click', '.search', function() {
        var start_date = $('#date1').val();
               var end_date = $('#date2').val();
                var from = $('#from').val();
                var to = $('#to').val();
                var status = $('#status').val();

        $.ajax({
            url: '{{url("findCourierReport")}}',
            type: "GET",
            data: {
               start_date: start_date,
                end_date: end_date,
               from: from,
                to: to,
               status:  status,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
               $('table').html("");
        $.each(data, function (key, value) { 
      
        $('table').append(data.html);
						})

         
               
            }

        });

    });


});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection