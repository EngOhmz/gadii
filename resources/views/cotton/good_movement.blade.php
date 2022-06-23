@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Stock Movement</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Stock Movement
                                    List</a>
                            </li>
                            @can('edit-cotton-movement')
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Stock Movement</a>
                            </li>
                            
                                   <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab3"
                                    data-toggle="tab" href="#profile3" role="tab" aria-controls="profile"
                                    aria-selected="false">Purchase</a>
                            </li>
                            @endcan

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                        <table border="0" cellspacing="15" cellpadding="20">
        <tbody>

<tr>
                 <td></td><td></td><td></td>
        <td><b>Date Filter</b></td><td></td><td><b>Minimum date:</b></td>
            <td><input type="text" id="min" name="min"   class="form-control "></td>
       
            <td><b>Maximum date:</b></td>
            <td><input type="text" id="max" name="max"   class="form-control "></td>
        </tr>
    </tbody></table>

                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 208.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Quantity</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Source Center</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Destination Center</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Status</th>
                                                   
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($movement))
                                            @foreach ($movement as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{Carbon\Carbon::parse($row->date)->format('M d, Y')}}</td>
                             <td><a  class="nav-link" title="Edit" data-toggle="modal" class="discount"  href="" onclick="model({{ $row->id }},'quantity')" value="{{ $row->id}}" data-target="#itemsFormModal" >{{$row->quantity}}</a></td>
                                                
                                                @if($row->status2 != 2)
                                                <td>  {{$row->source->name}}  </td>
                                                @else
                                                <td>  {{App\Models\AccountCodes::find($row->source_location)->account_name}}  </td>
                                                @endif
                                                
                                                <td>  {{$row->destination->name}}  </td>
                                                   <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-info badge-shadow">Pending</div>
                                                    @elseif($row->status == 1)
                                            <div class="badge badge-success badge-shadow">Approved</span>
                                                    @endif
                                                </td>
                                                      <td>
                                                   @if($row->status == 0)
                                                            <a  class="nav-link" title="Confirm Payment" onclick="return confirm('Are you sure? you want to confirm')"  href="{{ route('movement.approve', $row->id)}}">Confirm Movement</a></li>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                <div class="tab-pane fade" id="profile3" role="tabpanel"
                                aria-labelledby="profile-tab3">

                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Stock Control</h5>
                                        @else
                                        <h5>Edit Stock Control </h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('purchase_cotton.update', $id), 'method' => 'PUT')) }}
                                              
                                                @else
                                                {{ Form::open(['route' => 'purchase_cotton.store']) }}
                                                @method('POST')
                                                @endif


                                                <input type="hidden" name="type"
                                                class="form-control name_list"
                                                value="creditor" />

                                              
                                                       <div class="form-group row">
                                                    


                     @if(!empty($data))
                      <label
                                                        class="col-lg-2 col-form-label">Collection Center</label>
                                                    <div class="col-lg-4">
                                                       <select class="center " name="location" id="account_id"  required>
                                                    <option value="">Select Collection Center</option> 
                                                        @foreach ($center as $c)                                                             
                                                            <option value="{{$c->id}}" @if(isset($data))@if($data->location == $c->id) selected @endif @endif >{{$c->name}}</option>
                                                               @endforeach
                                                              </select>
                                                    </div>
                 @else
                                 <label
                                                        class="col-lg-2 col-form-label">Creditor Name</label>
                                                    <div class="col-lg-4">
                                                       <select class=" center" name="location" id="account_id"  required>
                                                    <option value="">Select Collection Center</option> 
                                                    @if(!empty($all_center))
                                                    @foreach ($all_center as $c)                                                             
                                                    <option value="{{$c->id}}" @if(isset($data))@if($data->location == $c->id) selected @endif @endif >{{$c->account_name}}</option>
                                                       @endforeach
                                                      
                                                              </select>
                                                    </div>
  @endif
  @endif
         </div>                                      <br>

                                                <div class="form-group row">

                                                    
                                                        <label class="col-lg-2 col-form-label">Purchase Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->date : date("Y-m-d")}}" {{Auth::user()->can('edit-date') ? '' : 'readonly'}}
                                                            class="form-control">
                                                    </div>
                                                    
                                                    <label class="col-lg-2 col-form-label">Reference</label>
                                                    <div class="col-lg-4">
                                                       <input type="text" name="reference"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->weight : ''}}"
                                                            class="form-control" required>
                                                    </div> 
                                                    
                                                </div>
                                              <div class="form-group row">
                                                  <!--  <label class="col-lg-2 col-form-label">Due Date</label> -->
                                                    <div class="col-lg-4">
                                                        <input type="hidden" name="due_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->due_date : date("Y-m-d")}}"  readonly
                                                            class="form-control">
                                                    </div>                                                   
                                                </div>

                                                <br>
 <div class=""> <p class="form-control-static" id="errors" style="text-align:center;color:red;"></p>   </div> 
                                                <h4 align="center">Enter Item Details</h4>
                                                <hr>
                                               
                                               
                                                
                                                <br>
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                            <th>Unit</th>
                                                           <th>Tax Rate</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                           <tr class="line_items">

            <td><select name="item_id" class="form-control item_name" required ><option value="">Select Item</option>@foreach($name as $n)<option value="{{ $n->id}}">{{$n->name}}</option>@endforeach </select></td>      
            <td><input type="number" name="quantity" class="form-control item_quantity" placeholder ="quantity" id ="quantity" required /></td>
        <td><input type="text" name="price" class="form-control item_price" placeholder ="price" required  value=""/></td>
      <td><input type="text" name="unit" class="form-control item_unit" placeholder ="unit" required /></td>
       <td><select name="tax_rate" class="form-control item_tax" required ><option value="0">Select Tax Rate</option><option value="0">No tax</option><option value="0.18">18%</option></select></td>
            
</tr>
                                                    </tbody>
                                                   
                                                       
                                                        
                                                </table>
                                            </div>


                                                <br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="{{ route('purchase_cotton.index')}}">
                                                            cancel
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
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(!empty($id))
                                        <h5>Edit Stock Movement</h5>
                                        @else
                                        <h5>Add New Stock Movement</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('cotton_movement.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'cotton_movement.store']) }}
                                                @method('POST')
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="date" id="date" 
                                                           
                                                            value="{{ isset($data) ? $data->date : date("y-m-d") }}" {{Auth::user()->can('edit-date') ? '' : 'readonly'}}
                                                            class="form-control" required>
                                                    </div>
                                              <label class="col-lg-2 col-form-label">Source Center</label>
                                                    <div class="col-lg-4">
                                                     <select class="source select_center" style="width: 100%"  
                                                         id="source" name="source">
                                                 <option value="">Select 
                                                    @if(!empty($center))
                                                    @foreach($center as $c)

                                                    <option @if(isset($data))
                                                        {{ $data->source_location == $c->id  ? 'selected' : ''}}
                                                        @endif value="{{$c->id}}">{{$c->name}}</option>

                                                    @endforeach
                                                    @endif                                              
 
                                             </select>
                                                   
                                                </div>

                                            </div> 

                                                 <div class="form-group row">

                                            </div>

                                            
                                             
                                             
                                                

                                        <br>
 <div id="data"> 
                                                
                                          </div>
<!--end of data table-->

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
<section>
    
                    <div class="modal inmodal show " id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    </div>
</div  
</section>

 <!-- discount Modal -->
  <div class="modal inmodal show " id="itemsFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    </div>
</div></div>
  </div>

@endsection

@section('scripts')
<script>
var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date( data[1] );
 
        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);



</script>

<script>
$(document).ready(function() {
       new TomSelect("#account_id",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    
    new TomSelect(".select_center",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
   // Create date inputs
    minDate = new DateTime($('#min'), {
        format: 'YYYY-MM-DD'
    });
    maxDate = new DateTime($('#max'), {
         format: 'YYYY-MM-DD'
    });

    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
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

  var table = $('#table-1').DataTable();
 
    // Refilter the table
    $('#min, #max').on('change', function () {
        table.draw();
    });

});


$('.demo4').click(function() {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function() {
        swal("Deleted!", "Your imaginary file has been deleted.", "success");
    });
});
</script>

<script type="text/javascript">
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '{{url("itemsModal")}}',
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
                $('#itemsFormModal').modal('toggle');

            }
        });

    }
    </script>

<script>
$(document).ready(function() {


    $(document).on('change', '.type', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findQuantity")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
              $(".item_price").val(data.price);
                $(".item_quantity").val(data.due_quantity);
               $(".item_history").val(data.id);
                   $(".item_id").val(data.items_id);
               $(".item_name").val('Cotton');
            }

        });

    });






});
</script>


<script type="text/javascript">
$(document).ready(function() {



    function autoCalcSetup() {
        $('table#cart').jAutoCalc('destroy');
        $('table#cart tr.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('table#cart').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();

   

});
</script>



<script type="text/javascript">
$(document).ready(function() {


    var count = 0;


    function autoCalcSetup() {
        $('table#cart').jAutoCalc('destroy');
        $('table#cart tr.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('table#cart').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();

    $('.add').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +=
            '<td><select name="levy_id[]" class="form-control item_name" required  data-sub_category_id="' +
            count +
            '"><option value="">Select Item</option>@foreach($levy as $n) <option value="{{ $n->id}}">{{$n->account_name}}</option>@endforeach</select></td>';      
       
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

        $('#levy').append(html);
        autoCalcSetup();
    });

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
        autoCalcSetup();
    });


    $(document).on('click', '.rem', function() {
        var btn_value = $(this).attr("value");
        $(this).closest('tr').remove();
        $('tfoot').append(
            '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
            btn_value + '"/>');
        autoCalcSetup();
    });

});
</script>

<script>
$(document).ready(function() {

    $(document).on('change', '.source', function() {
        var id = $(this).val();
       var total = $('#qty').val();
        $.ajax({
            url: '{{url("findPurchase")}}',
            type: "GET",
            data: {
                id: id,
            total: total,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#data").empty();
                $.each(response,function(key, value)
                {
                 
                    $('#data').html(response.html);
                  
                });                      
               
            }

        });

    });





});
</script>

<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection