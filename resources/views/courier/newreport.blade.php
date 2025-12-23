@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
              <div class="card-header">
                        <h4>Management Report</h4>
                    </div>
                    <div class="card-body">
                        <form id="addFormAppForm" method="post" action="javascript:void(0)">
                            @csrf

                                
                             <div class="form-group row">
                                 <div class="col-lg-4">
                                        <label class="col-form-label" for="order_id">From</label>
                                        <select class="form-control m-b" name="from" id="from">
                                            <option value="">Select Region</option>
                                            @if(!empty($region))
                                            @foreach($region as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                               
                                    <div class="col-lg-4">
                                        <label class="col-form-label" for="status">To</label>
                                        <select class="form-control m-b" name="to" id="to">
                                            <option value="">Select Region</option>
                                            @if(!empty($region))
                                            @foreach($region as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
<!--
                                    <div class="col-lg-4">
                                        <label class="col-form-label" for="customer">Status</label>
                                        <select class="form-control m-b" name="status" id="status">
                                           <option value="">Select Status</option>
                                            <option value="3">Picked</option>
                                            <option value="4">Freighted</option>
                                            <option value="5">Commissioned</option>
                                            <option value="6">Delivered</option>


                                        </select>
                                    </div>
-->
                                </div>

                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="client_id">Client</label>
                                         <select class="form-control m-b" name="client_id" id="client_id">
                                            <option value="">Select Client</option>
                                            @if(!empty($client))
                                            @foreach($client as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

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
                         <table class="table datatable-basic table-striped">
                            <thead>
                                <tr role="row">

                                    <th class="" rowspan="1" colspan="1" style="width: 28.531px;">#</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 126.484px;">Date</th>
                                      <th class="" rowspan="1" colspan="1" style="width: 106.484px;">Ref No </th>
                                    <th class="" rowspan="1" colspan="1" style="width: 186.484px;">Client </th>
                                    <th class="" rowspan="1" colspan="1" style="width: 181.219px;">Tariff </th>
                                    <th class="" rowspan="1" colspan="1" style="width: 101.219px;">Weight</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" style="width: 101.219px;">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                 @if(!@empty($report))
                                            @foreach ($report as $row)
                                            <tr class="gradeA even" role="row">

                                                <td> {{$loop->iteration}}</td>
                                                <td>{{Carbon\Carbon::parse($row->collection_date)->format('d/m/Y')}}</td>
                                                <td>{{$row->pacel_number}}</td>
                                                    <td>{{$row->client->name}} </td>                                              
                                                <td>From {{$row->region_s->name}} to {{$row->region_e->name}}</td> 
 
                                            <td>{{$row->weight}} kgs</td>
                                                          
                                                
<td>
                                                    @if($row->status == 3)
                                                    <div class="badge badge-success badge-shadow">Picked</div>
                                                       @elseif($row->status == 4)
                                                    <div class="badge badge-info badge-shadow">Freighted</div>
                                                       @elseif($row->status == 5)
                                                    <div class="badge badge-primary badge-shadow">Commissioned</div>
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
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [3]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
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
              var client_id = $('#client_id').val();

        $.ajax({
            url: '{{url("courier/findNewCourierReport")}}',
            type: "GET",
            data: {
               start_date: start_date,
                end_date: end_date,
               from: from,
                to: to,
               status:  status,
           client_id:  client_id,
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