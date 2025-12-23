 @extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Debit Note </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Debit Note
                                     List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Debit Note</a>
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
                                                    style="width: 156.484px;">Ref No</th>
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Purchase No</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Supplier Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 136.484px;">Return Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Due Amount</th>
                                                  
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 168.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($invoices))
                                            @foreach ($invoices as $row)
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    <a class="nav-link" id="profile-tab2"
                                                            href="{{ route('credit_note.show',$row->id)}}" role="tab"
                                                            aria-selected="false">{{$row->reference_no}}</a>
                                                </td>
                                                     <td> {{$row->invoice->reference_no }}</td>
                                                <td>
                                                      {{$row->client->name }}
                                                </td>
                                                
                                                <td>{{$row->return_date}}</td>

                                                <td>{{number_format($row->due_amount,2)}} {{$row->exchange_code}}</td>
                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Not Approved</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-warning badge-shadow">Not Paid</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    @elseif($row->status == 3)
                                                    <span class="badge badge-success badge-shadow">Fully Paid</span>
                                                    @elseif($row->status == 4)
                                                    <span class="badge badge-danger badge-shadow">Cancelled</span>

                                                    @endif
                                                </td>
                                               
                                                <td>
                                                    <div class="form-inline">
                                                            @if($row->status== 0)
                                                            <a class="list-icons-item text-primary"
                                                                title="Edit" onclick="return confirm('Are you sure?')"
                                                                href="{{ route('restaurant_debit_note.edit', $row->id)}}"><i
                                                                    class="icon-pencil7"></i></a>&nbsp
                                                                    
        
                                                            {!! Form::open(['route' => ['restaurant_debit_note.destroy',$row->id],
                                                            'method' => 'delete']) !!}
                                         {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit','style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                            {{ Form::close() }}
                                         &nbsp
                                         @endif
                                                        <div class="dropdown">
                                                  <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
        
                                               <div class="dropdown-menu">
                 
                                                                           @if($row->status == 0 && $row->status != 4 && $row->status != 3 && $row->good_receive == 0)
                                                                    <li> <a class="nav-link" id="profile-tab2"
                                                                            href="{{ route('restaurant_debit_note.receive',$row->id)}}"
                                                                            role="tab"
                                                                            aria-selected="false">Approve Credit Note</a>
                                                                    </li>
                                                                    @endif
                                                                     @if($row->status != 0 && $row->status != 4 && $row->status != 3 && $row->good_receive == 1)
                                                                    <li> <a class="nav-link" id="profile-tab2"
                                                                            href="{{ route('restaurant_debit_note.pay',$row->id)}}"
                                                                            role="tab"
                                                                            aria-selected="false">Make Payments</a>
                                                                    </li>
                                                                    @endif
                                                                        @if($row->good_receive == 0)
                                                                    <li class="nav-item"><a class="nav-link" title="Cancel"
                                                                            onclick="return confirm('Are you sure?')"
                                                                            href="{{ route('restaurant_debit_note.cancel', $row->id)}}">Cancel
                                                                          Credit Note</a></li>
                                                @endif
                                                <a class="nav-link" id="profile-tab2" href="{{ route('restaurant_debit_note_pdfview',['download'=>'pdf','id'=>$row->id]) }}"
                                                    role="tab"  aria-selected="false">Download PDF</a>
                                               </div>
                                               </div>
                                                           
                                                        </div>
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
                                        <h5>Create Credit Note</h5>
                                        @else
                                        <h5>Edit Credit Note</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('restaurant_debit_note.update', $id), 'method' => 'PUT')) }}
                                              
                                                @else
                                                {{ Form::open(['route' => 'restaurant_debit_note.store']) }}
                                                @method('POST')
                                                @endif


                                                <input type="hidden" name="type"
                                                class="form-control name_list"
                                                value="{{$type}}" />

                                                <div class="form-group row">
                                                 
                                                    <label class="col-lg-2 col-form-label">Supplier Name</label>
                                                    <div class="col-lg-4">
                                                   
                                                        <select class="form-control m-b client" name="supplier_id" required
                                                        id="supplier_id">
                                                        <option value="">Select Supplier Name</option>
                                                                @if(!empty($client))
                                                                @foreach($client as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->supplier_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                                                    </div>
                                                 @if(!empty($data))
                                                     <label class="col-lg-2 col-form-label">Purchases </label>
                                                    <div class="col-lg-4">
                                                   
                                                        <select class="form-control m-b invoice" name="purchase_id" required
                                                        id="invoice_id">
                                                                <option value="">Select Purchases</option>
                                                               @if(!empty($invoice))
                                                                @foreach($invoice as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->purchase_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->reference_no}}</option>

                                                                @endforeach
                                                                @endif
 
                                                            </select>
                                                    </div>
                                                     @else
                                                   <label class="col-lg-2 col-form-label">Purchases </label>
                                                    <div class="col-lg-4">
                                                   
                                                        <select class="form-control m-b invoice" name="purchase_id" required
                                                        id="invoice_id">
                                                                <option value="">Select Purchases </option>
                                                              

                                                            </select>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Return Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="return_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->return_date : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Due Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="due_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->due_date : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>


                                                <br>
<div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-sm-3">Name</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                            <th>Unit</th>
                                                            <th>Tax</th>
                                                            <th class="col-sm-2">Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

 <tbody>
                                                        @if(!empty($id))
                                                        @if(!empty($items))
                                                        @foreach ($items as $i)
                                                         <tr class="line_items">
                                                            <td><select name="item_name[]"
                                                                    class="form-control  m-b item_name" required
                                                                   disabled>
                                                                    <option value="">Select Item</option>@foreach($name
                                                                    as $n) <option value="{{ $n->id}}"
                                                                        @if(isset($i))@if($n->id == $i->item_name)
                                                                        selected @endif @endif >{{$n->name}}</option>
                                                                    @endforeach
                                                                </select></td>
                                                            <td><input type="number" name="quantity[]"
                                                                    class="form-control item_quantity" min="1"
                                                                    placeholder="quantity" id="quantity"   data-sub_category_id={{$i->order_no}}_qty
                                                                    value="{{ isset($i) ? $i->quantity : ''}}"
                                                                    required />
                                                                   <div class=""> <p class="form-control-static errors{{$i->order_no}}_qty" id="errors" style="text-align:center;color:red;"></p>   </div> 
                                                                           </td>
                                                            <td><input type="text" name="price[]"
                                                                    class="form-control item_price{{$i->order_no}}"
                                                                    placeholder="price" required
                                                                    value="{{ isset($i) ? $i->price : ''}}" readonly/></td>
                                                            <td><input type="text" name="unit[]"
                                                                    class="form-control item_unit{{$i->order_no}}"
                                                                    placeholder="unit" required
                                                                    value="{{ isset($i) ? $i->unit : ''}}" readonly/>
                                                            <td><select name="tax_rate[]"
                                                                    class="form-control  m-b item_tax'+count{{$i->order_no}}"
                                                                    required disabled>
                                                                    <option value="0">Select Tax Rate</option>
                                                                    <option value="0" @if(isset($i))@if('0'==$i->
                                                                        tax_rate) selected @endif @endif>No tax</option>
                                                                    <option value="0.18" @if(isset($i))@if('0.18'==$i->
                                                                        tax_rate) selected @endif @endif>18%</option>
                                                                </select></td>
                                                            <input type="hidden" name="total_tax[]"
                                                                class="form-control item_total_tax{{$i->order_no}}'"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_tax : ''}}" readonly
                                                                jAutoCalc="{quantity} * {price} * {tax_rate}" />
                                                          
                                                            <td><input type="text" name="total_cost[]"
                                                                    class="form-control item_total{{$i->order_no}}"
                                                                    placeholder="total" required
                                                                    value="{{ isset($i) ? $i->total_cost : ''}}"
                                                                    readonly jAutoCalc="{quantity} * {price}" /></td>
                                                            <input type="hidden" name="items_id[]"
                                                                class="form-control name_list"
                                                                value="{{ isset($i) ? $i->items_id : ''}}" />
                                                         <input type="hidden" name="id[]" id="item"
                                                                class="form-control id{{$i->order_no}}_qty"
                                                                value="{{ isset($i) ? $i->return_item : ''}}" />
                                                              <input type="hidden" name="item_id[]" id="item_id"
                                                                class="form-control id{{$i->order_no}}"
                                                                value="{{ isset($i) ? $i->id : ''}}" />
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-xs remove"
                                                                    value="{{ isset($i) ? $i->id : ''}}"><i class="icon-trash"></i></button></td>
                                                        </tr>

                                                        @endforeach
                                                        @endif
                                                        @endif
   </tbody>
<tfoot>
                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <td><span class="bold">Sub Total </span>: </td>
                                                            <td><input type="text" name="subtotal[]"
                                                                    class="form-control item_total"
                                                                    placeholder="subtotal" required
                                                                    jAutoCalc="SUM({total_cost})" readonly></td>
                                                        </tr>
                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <td><span class="bold">Tax </span>: </td>
                                                            <td><input type="text" name="tax[]"
                                                                    class="form-control item_total" placeholder="tax"
                                                                    required jAutoCalc="SUM({total_tax})" readonly>
                                                            </td>
                                                        </tr>
                                                    
                                                  <tr class="line_items">
                                            <td colspan="4"></td>
                                                            <td><span class="bold">Total</span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total" placeholder="total"
                                                                    required jAutoCalc="{subtotal} + {tax}" readonly>
                                                            </td>
                                                            
                                                        </tr>
                                                 </tfoot>
 </table>
                                            </div>
                                         
<br>
 <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
 
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save">Save</button>
                                                       
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
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'preevious': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
$(document).ready(function() {

    $(document).on('change', '.client', function() {
        var id = $(this).val();
console.log(id);
        $.ajax({
            url: '{{url("restaurant/purchases/findinvoice")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#invoice_id").empty();
                  $("#data").empty();
                $("#invoice_id").append('<option value="">Select Purchases</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#invoice_id").append('<option value=' + value.id+ '>' + value.reference_no + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>

<script>
$(document).ready(function() {

 $(document).on('change', '.invoice', function() {
        var id = $(this).val();
console.log(id);
        $.ajax({
            url: '{{url("restaurant/purchases/editshowInvoice")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#cart > tfoot").empty();
               
                $.each(response,function(key, value)
                {
                 
                     $('#cart > tfoot').append(response.html);
                    

                });                      
               
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


    $(document).on('click', '.remove', function() {
         var btn_value = $(this).attr("value");
        $(this).closest('tr').remove();
        $('#cart >tbody').append(
            '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
            btn_value + '"/>');
        autoCalcSetup();
    });

$(document).on('click', '.rem', function() {
        $(this).closest('tr').remove();
        autoCalcSetup();
    });

});
</script>

<script>
$(document).ready(function() {

   $(document).on('change', '.item_quantity', function() {
        var id = $(this).val();
          var sub_category_id = $(this).data('sub_category_id');
         var item= $('.id' + sub_category_id).val();
console.log(id);
        $.ajax({
            url: '{{url("restaurant/purchases/findinvQty")}}',
            type: "GET",
            data: {
                id: id,
              item: item,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
           $('.errors' + sub_category_id).empty();
            $("#save").attr("disabled", false);
             if (data != '') {
            $('.errors' + sub_category_id).append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });



});
</script>
               


@endsection