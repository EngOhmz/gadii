@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Stock Control</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Stock Control List</a>
                            </li>
                            @can('view-cotton-purchase')
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Stock Control</a>
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
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Reference</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Operator</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Purchase Date</th>
                                              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Quantity</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Due Amount</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Collection Center</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($purchases))
                                            @foreach ($purchases as $row)
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    <a class="nav-link" id="profile-tab2"
                                                            href="{{ route('purchase_cotton.show',$row->id)}}" role="tab"
                                                            aria-selected="false">{{$row->reference}}</a>
                                                </td>
                                                <td> {{$row->supplier->name}}</td>
                                                <td>{{$row->purchase_date}}</td>
                                                <td>{{$row->quantity}}</td>
                                                <td>{{number_format($row->due_amount,2)}} {{$row->exchange_code}}</td>
                                                <td>   {{$row->location_id->name}} </td>
                                                 
                                                
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
                                                value="{{$type}}" />

                                              
                                                       <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Operator</label>
                                                    <div class="col-lg-4">
                                                       <select class="form-control operator select2" style="width: 100%" name="supplier_id" id="user_id" required>
                                                    <option value="">Select Operator</option> 
                                                          @foreach ($operator as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->supplier_id == $bank->id) selected @endif @endif >{{$bank->name}}</option>
                                                               @endforeach
                                                              </select>
                                                    </div>


                     @if(!empty($data))
                      <label
                                                        class="col-lg-2 col-form-label">Collection Center</label>
                                                    <div class="col-lg-4">
                                                       <select class="form-control center center_class select2" style="width: 100%" name="location" id="account_id"  required>
                                                    <option value="">Select Collection Center</option> 
                                                        @foreach ($center as $c)                                                             
                                                            <option value="{{$c->id}}" @if(isset($data))@if($data->location == $c->id) selected @endif @endif >{{$c->name}}</option>
                                                               @endforeach
                                                              </select>
                                                    </div>
                 @else
                                 <label
                                                        class="col-lg-2 col-form-label">Collection Center</label>
                                                    <div class="col-lg-4">
                                                       <select class="form-control center center_class select2" style="width: 100%"  name="location" id="account_id"  required>
                                                    <option value="">Select Collection Center</option> 
                                                    @foreach ($all_center as $c)                                                             
                                                    <option value="{{$c->id}}" @if(isset($data))@if($data->location == $c->id) selected @endif @endif >{{$c->name}}</option>
                                                       @endforeach
                                                      
                                                              </select>
                                                    </div>
  @endif
         </div>                                      

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Purchase Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="purchase_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->purchase_date : date("Y-m-d")}}" {{Auth::user()->can('edit-date') ? '' : 'readonly'}}
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

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- supplier Modal -->
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form id="addClientForm" method="post" action="javascript:void(0)">
            @csrf
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

      <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Name</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="name"  id="name"                                                                
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Phone</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="phone" id="phone"
                                                                class="form-control"  placeholder="+255713000000" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Email</label>
                                                        <div class="col-lg-10">
                                                            <input type="email" name="email" id="email"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>

                                                <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Address</label>

                                                        <div class="col-lg-10">
                                                            <textarea name="address" id="address" class="form-control" required>  </textarea>
                                                                                                                    

</div>
                                                    </div>

  <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">TIN</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="TIN"  id="TIN"
                                                                value="{{ isset($data) ? $data->TIN : ''}}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>

                 
               
              </div>
</div>
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save" onclick="saveSupplier(this)" data-dismiss="modal">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>

            </div>
        </div>
    </div>
</div>
</div>
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
        var date = new Date( data[2] );
 
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

    var collection_centers = {!! json_encode($all_center->toArray(), JSON_HEX_TAG) !!};//get data from controller
    selectCenterElement = document.getElementById("account_id");
        //  function called when selecting oparato
        $(document).on('change', '#user_id', function() {
        //ajax for get all page data 
        const filtered_center  = collection_centers.filter(data => data.operator_id == $('#user_id').val());
      
    
            selectCenterElement.length = 1; // remove all options bar first

            if (this.selectedIndex < 1){//if select in selection index 0 |first selection
                $(".center_class").empty();
            $(".center_class").append('<option value="">Select</option>');
                $.each(collection_centers,function(key,center){
                $('.center_class').append('<option value="'+center.id+'">\
                                        '+center.name+'\
                                        </option>');
                });
                    return;} // done
                    
            $(".center_class").empty();
            $(".center_class").append('<option value="">Select Collection Center</option>');
                $.each(filtered_center,function(key,center){
                    console.log(filtered_center);
                $('.center_class').append('<option value="'+center.id+'">\
                                        '+center.name+'\
                                        </option>');
                });
            } ); 

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
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>


<script>
$(document).ready(function() {


    $(document).on('change', '.center', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findStock")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#errors").empty();
        
             if (data != '') {
           $("#errors").append(data);
        
} else {
  
}
            
       
            }

        });

    });






});
</script>

<script>
$(document).ready(function() {

    // $(document).on('change', '.operator', function() {
    //     var id = $(this).val();
    //     $.ajax({
    //         url: '{{url("findCenterName")}}',
    //         type: "GET",
    //         data: {
    //             id: id
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             console.log(response);
    //             $("#account_id").empty();
    //             $("#account_id").append('<option value="">Select Collection Center</option>');
    //             $.each(response,function(key, value)
    //             {
                 
    //                 $("#account_id").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
    //             });                      
               
    //         }

    //     });

    // });





});
</script>

<script>
$(document).ready(function() {

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
    });

    $(document).on('change', '.item_name', function() {
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("findCottonPrice")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('.item_price').val(data[0]["price"]);
                $(".item_unit").val(data[0]["unit"]);
               
            }

        });

    });


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
            '<td><select name="item_name[]" class="form-control item_name" required  data-sub_category_id="' +
            count +
            '"><option value="">Select Item</option>@foreach($name as $n) <option value="{{ $n->id}}">{{$n->name}}</option>@endforeach</select></td>';
        html +=
            '<td><input type="number" name="quantity[]" class="form-control item_quantity" data-category_id="' +
            count + '"placeholder ="quantity" id ="quantity" required /></td>';
        html += '<td><input type="text" name="price[]" class="form-control item_price' + count +
            '" placeholder ="price" required  value=""/></td>';
        html += '<td><input type="text" name="unit[]" class="form-control item_unit' + count +
            '" placeholder ="unit" required /></td>';
        html += '<td><select name="tax_rate[]" class="form-control item_tax' + count +
            '" required ><option value="0">Select Tax Rate</option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
        html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax' + count +
            '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   />';
       
        html += '<td><input type="text" name="total_cost[]" class="form-control item_total' + count +
            '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

        $('tbody').append(html);
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



<script type="text/javascript">
function model(id, type) {

    $.ajax({
        type: 'GET',
        url: '/courier/public/discountModal/',
        data: {
            'id': id,
            'type': type,
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

function saveSupplier(e) {
     
     var name = $('#name').val();
     var phone = $('#phone').val();
     var email = $('#email').val();
     var address = $('#address').val();
   var TIN= $('#TIN').val();

     
          $.ajax({
            type: 'GET',
            url: '{{url("addSupp")}}',
             data: {
                 'name':name,
                 'phone':phone,
                 'email':email,
                 'address':address,
                  'TIN':TIN,
             },
                dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.name;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#supplier_id').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
        });
}
</script>

@endsection