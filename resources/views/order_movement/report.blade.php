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
                                        <select class="form-control m-b" name="from" id="from">
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
                                        <select class="form-control m-b" name="to" id="to">
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
                                        <select class="form-control m-b" name="status" id="status">
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
                                    <th class="" rowspan="1" colspan="1" style="width: 106.484px;">Date</th>
                                 <th class="" rowspan="1" colspan="1" style="width: 126.484px;">Ref No</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 156.484px;">Client </th>                             
                                    <th class="" rowspan="1" colspan="1" style="width: 200.219px;">Route </th>
                              <th class="" rowspan="1" colspan="1" style="width: 106.484px;">Truck</th>
                              <th class="" rowspan="1" colspan="1" style="width: 101.219px;">Driver</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 91.219px;">Qty</th>
                                       <th class=""  rowspan="1"  colspan="1" style="width: 91.219px;">Status</th>

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
</section>


@endsection

@section('scripts')
<script>
$(function() {
    let urlcontract = "{{ route('order.report') }}";
    $('#appFormDatatable').DataTable({
        processing: true,
        serverSide: true,
        lengthChange: false,
        searching: false,
        type: 'GET',
        ajax: {
            url: urlcontract,
            data: function(d) {
                d.start_date = $('#date1').val();
                d.end_date = $('#date2').val();
                d.from = $('#from').val();
                d.to = $('#to').val();
                d.status = $('#status').val();


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
                data: 'receiver',
                name: 'receiver'
            },
            {
                data: 'from_to',
                name: 'from_to'
            },
            {
                data: 'truck',
                name: 'truck'
            },
            {
                data: 'driver',
                name: 'driver'
            },
            {
                data: 'weight',
                name: 'weight'
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


<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection