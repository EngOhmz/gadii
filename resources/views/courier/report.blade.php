@extends('layouts.master')


@section('content')

   
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
              <div class="card-header">
                        <h4>Management Report</h4>
                    </div>
                    <div class="card-body">
                    
                    <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                
                        <form id="addFormAppForm" method="post" action="javascript:void(0)">
                            @csrf

                               
                             <div class="form-group row">
                                 <div class="col-lg-4">
                                        <label class="col-form-label" for="">From</label>
                                        <select class="form-control m-b from" name="from" id="from">
                                            <option value="">Select Region</option>
                                            @if(!empty($region))
                                            @foreach($region as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                               
                                    <div class="col-lg-4">
                                        <label class="col-form-label" for="">To</label>
                                        <select class="form-control m-b to" name="to" id="to">
                                            <option value="">Select Region</option>
                                            @if(!empty($region))
                                            @foreach($region as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="col-form-label" for="">Status</label>
                                        <select class="form-control m-b status" name="status" id="status">
                                           <option value="">Select Status</option>
                                          <option value="2">Picked</option>
                                            <option value="3">Packaged</option>
                                            <option value="4">Freighted</option>
                                            <option value="5">Commissioned</option>
                                            <option value="6">Delivered</option>


                                        </select>
                                    </div>

                                </div>
                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Client</label>
                                        <select name="location_id" class="form-control m-b client" id="client_id">
                                         
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
                      <br><button type="submit" class="btn btn-primary search" id="btnFiterSubmitSearch">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div> 
                            </div>
                        </form>
                        
                        
                        
<br><br>
                     <div class="table-responsive">
                         <table class="table table-striped" id="appFormDatatable">
                            <thead>
                                <tr role="row">

                                    <th class="" rowspan="1" colspan="1" style="width: 28.531px;">#</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 126.484px;">Date</th>
                                      <th class="" rowspan="1" colspan="1" style="width: 106.484px;">Ref No </th>
                                     <th class="" rowspan="1" colspan="1" style="width: 106.484px;">WB No </th>
                                    <th class="" rowspan="1" colspan="1" style="width: 136.484px;">Client </th>
                              <th class="" rowspan="1" colspan="1" style="width: 181.219px;">Location</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 181.219px;">Tariff </th>

                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" style="width: 101.219px;">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
</div>
                    </div>
                </div>
            </div>
        </div>
</div>
    </div>
</section>


@endsection

@section('scripts')

 
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
$(function() {
    let urlcontract = "{{ route('courier.report') }}";
    $('#appFormDatatable').DataTable({
        processing: true,
        serverSide: true,
        lengthChange: false,
        searching: false,
           dom: 'Bfrtip',
        buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ],
        type: 'GET',
        ajax: {
            url: urlcontract,
            data: function(d) {
                d.start_date = $('#date1').val();
                d.end_date = $('#date2').val();
                d.from = $('#from').val();
                d.to = $('#to').val();
                d.status = $('#status').val();
              d.client_id = $('#client_id').val();

            }
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'pacel_number',
                name: 'pacel_number'
            },
          {
                data: 'wb',
                name: 'wb'
            },
            {
                data: 'client',
                name: 'client'
            },
            {
                data: 'from_to',
                name: 'from_to'
            },
              {
                data: 'zone',
                name: 'zone'
            },


          
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: true
            },

        ]
    })
});

$('#btnFiterSubmitSearch').click(function() {
    $('#appFormDatatable').DataTable().draw(true);
});
</script>


 <script>
        $(document).ready(function(){
            /*
                         * Multiple drop down select
                         */
            $('.m-b').select2({});



        });
    </script>
@endsection