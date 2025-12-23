@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Payment List</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                         
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Payment
                                    List</a>
                            </li>
                           
                           
                           

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                               
                                    <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 36.484px;">#</th>
                                              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 128.484px;">Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 116.484px;">Courier</th>
                                                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 116.484px;">Supplier</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Total Amount</th>
                                         <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Due Amount</th>
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Payment Type</th>
                                              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($fuel))
                                            @foreach ($fuel as $row)
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                           <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}} </td>
                                                <td>{{$row->pacel->confirmation_number}}</td>
                                                 <td>{{$row->owner->driver_name}} - {{$row->type}}</td>
                                            <td>{{number_format($row->total_cost,2)}} TZS</td>
                                           <td>{{number_format($row->due_cost,2)}} TZS</td>
                                               <td> On {{$row->payment_type}} </td>
                                                   <td> 
                                        @if($row->status == 0)
                                        <div class="badge badge-warning badge-shadow">Not Paid</div>
                                        @elseif($row->status == 1)
                                        <div class="badge badge-info badge-shadow">Partially Paid</div>
                                        @elseif($row->status== 2)
                                        <span class="badge badge-success badge-shadow">Fully Paid</span>
                                       
                                        @endif
                                       
                                    </td>

                                                <td>
                                                   @if( $row->status !=2)                    
                                                       
                                                            <a class="nav-link" title="Make Payments"
                                                                href="{{ route('courier_cost.pay', $row->id)}}" 
                                                              >Pay
                                                                    </a>                        
                                                                    @endif
                                                        
                                                   

                                                </td>
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
                                   
                                </div>

                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Fuel</h5>
                                        @else
                                        <h5>Edit Fuel</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('fuel.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'fuel.store']) }}
                                                @method('POST')
                                                @endif




                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Truck</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="truck_id" required
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                        @if(!empty($truck))
                                                        @foreach($truck as $row)

                                                        <option @if(isset($data))
                                                            {{  $data->truck_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{ $row->id}}">{{$row->truck_name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Route</label>
                                                    <div class="col-lg-4">
                                                        <div class="input-group">
                                                            <select class="form-control" name="route_id" required
                                                                id="route">
                                                                <option value="">Select</option>
                                                                @if(!empty($route))
                                                                @foreach($route as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->route_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">From {{$row->from}} to  {{$row->to}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary" type="button"
                                                                    data-toggle="modal" href="routeModal"  
                                                                    data-target="#routeModal"><i
                                                                        class="fa fa-plus-circle"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Fuel Rate</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" step="0.001" name="fuel_rate"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->fuel_rate : ''}}"
                                                            class="form-control">
                                                    </div>
                                                   
                                                </div>


                                                
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="{{ route('fuel.index')}}">
                                                           Cancel
                                                        </a>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit">Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>



<!-- route Modal -->
<div class="modal fade" id="routeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Route</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
  <form id="addRouteForm" method="post" action="javascript:void(0)">
            @csrf
                <div class="modal-body">
                    <p><strong>Make sure you enter valid information</strong> .</p>

                    
                  
                    <div class="form-group row"><label class="col-lg-2 col-form-label">From</label>

                        <div class="col-lg-10">
                            <input type="text" name="from" id="from" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row"><label class="col-lg-2 col-form-label">To</label>

                        <div class="col-lg-10">
                            <input type="text" name="to" id="to" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Distance(km)</label>

                        <div class="col-lg-10">
                            <input type="number"  step="0.001" name="distance" id="distance" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="modal-footer ">
                    <button type="submit" class="btn btn-primary route" onclick="saveRoute(this)">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

                 </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [3]}
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


<script type="text/javascript">

    function saveRoute(e){
     
     
     var to = $('#to').val();
     var distance = $('#distance').val();
     var from = $('#from').val();

     
          $.ajax({
            type: 'GET',
            url: '{{url("addRoute")}}',
             data: {
                 'to':to,
                 'distance':distance,
                 'from':from,
             },
          dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var arrival_point = response.from;
                              var destination_point = response.to;

                             var option = "<option value='"+id+"'  selected>From "+arrival_point+" to "+destination_point+"</option>"; 

                             $('#route').append(option);
                              $('#routeModal').hide();
                   
                               
               
            }
          
        });
}



    function model(id,type) {

$.ajax({
    type: 'GET',
    url: '{{url("discountModal")}}',
    data: {
        'id': id,
        'type':type,
    },
    cache: false,
    async: true,
    success: function(data) {
        //alert(data);
        $('.modal-dialog').html(data);
    },
    error: function(error) {
        $('#appFormModal').modal('toggle');

    }
});

}

 function ShowDiv() {
                  var ddlPassport = document.getElementById("type");
                var dfPassport = document.getElementById("account");
              dfPassport.style.display = ddlPassport.value == "cash" ? "block" : "none";
    }

function calculateCost() {
    
    $('#price,#litres').on('input',function() {
    var price= parseInt($('#price').val());
    var qty = parseFloat($('#litres').val());
    console.log(qty);
    $('#total_c').val((10* 2 ? 10* 2 : 0).toFixed(2));
    });
    
    }



                    


             </script>




@endsection