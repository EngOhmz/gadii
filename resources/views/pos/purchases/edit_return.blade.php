 @extends('layouts.master')

 @push('plugin-styles')
 <style>
 .body > .line_items{
     border:1px solid #ddd;
 }
 </style>

@endpush

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
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
                                                                href="{{ route('debit_note.edit', $row->id)}}"><i
                                                                    class="icon-pencil7"></i></a>&nbsp
                                                                    
        
                                                            {!! Form::open(['route' => ['debit_note.destroy',$row->id],
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
                                                                            href="{{ route('debit_note.receive',$row->id)}}"
                                                                            role="tab"
                                                                            aria-selected="false">Approve Credit Note</a>
                                                                    </li>
                                                                    @endif
                                                                     @if($row->status != 0 && $row->status != 4 && $row->status != 3 && $row->good_receive == 1)
                                                                    <li> <a class="nav-link" id="profile-tab2"
                                                                            href="{{ route('debit_note.pay',$row->id)}}"
                                                                            role="tab"
                                                                            aria-selected="false">Make Payments</a>
                                                                    </li>
                                                                    @endif
                                                                        @if($row->good_receive == 0)
                                                                    <li class="nav-item"><a class="nav-link" title="Cancel"
                                                                            onclick="return confirm('Are you sure?')"
                                                                            href="{{ route('debit_note.cancel', $row->id)}}">Cancel
                                                                          Credit Note</a></li>
                                                @endif
                                                <a class="nav-link" id="profile-tab2" href="{{ route('debit_note_pdfview',['download'=>'pdf','id'=>$row->id]) }}"
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
                                        <h5>Create Debit Note</h5>
                                        @else
                                        <h5>Edit Debit Note</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('debit_note.update', $id), 'method' => 'PUT')) }}
                                              
                                                @else
                                                {{ Form::open(['route' => 'debit_note.store']) }}
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
                                                
                                                <div class="form-group row">
                                                            <label for="stall_no" class="col-lg-2 col-form-label bank1"
                                                                style="display:block;">Payment Account to Deduct</label>
                                                            <div class="col-lg-4 bank2">
                                                                <select class="form-control m-b" name="bank_id" required>
                                                                    <option value="">Select Payment Account</option>
                                                                    @foreach ($bank_accounts as $bank)
                                                                        <option value="{{ $bank->id }}"
                                                                            @if (isset($data)) @if ($data->bank_id == $bank->id) selected @endif
                                                                            @endif
                                                                            >{{ $bank->account_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            
                                                            
                                                              <label class="col-lg-2 col-form-label">Notes</label>

                                                        <div class="col-lg-4">
                                                    <textarea name="notes" class="form-control" rows="4">{{ isset($data) ? $data->notes : '' }}</textarea>
                                                        </div>

                                                    </div>


                                                <br>
                                                <div class=""><p class="form-control-static item_errors" id="errors" style="text-align:center;color:red;"></p>   </div>
  
                                              <h4 align="center">Item Details</h4>
                                            <div class="table-responsive" id="dn-cart">
                                            
                                             <div class="row body">
                                           @if(!empty($items))
                                         @foreach ($items as $i)     
                                                                                                                                          
                                     <div class="col-lg-4 line_items" id="td{{$i->id}}_qty"><br>
                                    <select name="item_name[]" class="form-control  m-b item_name" required="" disabled="">
                                    <option value="">Select Item</option>
                                    @foreach($name as $n) 
                                    <option value="{{ $n->id}}"
                            @if(isset($i))@if($n->id == $i->item_name) selected @endif @endif >{{$n->name}} @if(!empty($n->color)) - {{$n->c->name}} @endif   @if(!empty($n->size)) - {{$n->s->name}} @endif</option>
                                        @endforeach
                                                                    </select>
                                    <br> </div>
                              
                                                                            
                              <div class="col-lg-6 line_items" id="td{{$i->id}}_qty"><br>
                         Quantity 
                    <input type="number" name="quantity[]" class="form-control item_quantity" step="0.01" min="0.01" placeholder="quantity" id="quantity" data-sub_category_id="{{$i->id}}_qty" value="{{ isset($i) ? $i->quantity : ''}}" required="">
                     <div class=""> <span class="form-control-static errors{{$i->id}}_qty" id="errors" style="text-align:center;color:red;"></span>   </div> 
                               <br>
                Price <input type="number" step="0.01" min="0.01" name="price[]" class="form-control item_price{{$i->id}}_qty" placeholder="price" required="" value="{{ isset($i) ? $i->price : ''}}" readonly=""><br>
               <input type="hidden" name="unit[]" class="form-control item_unit{{$i->id}}_qty" placeholder="unit" required="" value="{{ isset($i) ? $i->unit : ''}}" readonly="">
               <input type="hidden" name="tax_rate[]" class="form-control  item_tax{{$i->id}}_qty" value="{{ isset($i) ? $i->tax_rate : ''}}" required="">
                Tax <input type="text" name="total_tax[]" class="form-control item_total_tax{{$i->id}}_qty'" placeholder="total" required="" value="{{ isset($i) ? $i->total_tax : ''}}" readonly="readonly" jautocalc="{quantity} * {price} * {tax_rate}" ><br>
               Total <input type="text" name="total_cost[]" class="form-control item_total{{$i->id}}_qty" placeholder="total" required="" value="{{ isset($i) ? $i->total_cost : ''}}" readonly="readonly" jautocalc="{quantity} * {price}" ><br>
                <input type="hidden" name="items_id[]" class="form-control name_list" value="{{ isset($i) ? $i->items_id : ''}}">
             <input type="hidden" name="id[]" id="item" class="form-control id{{$i->id}}_qty" value="{{ isset($i) ? $i->return_item : ''}}}">
              <input type="hidden" name="item_id[]" id="item_id" class="form-control id{{$i->id}}_qty" value="{ isset($i) ? $i->id : ''}}">

                              </div>
                              
                      <div class="col-lg-2 text-center line_items" id="td{{$i->id}}_qty"><br>
                      <button type="button" name="remove" class="btn btn-danger btn-xs rem" value="{{$i->id}}" data-button_id="{{$i->id}}_qty"><i class="icon-trash"></i></button><br></div>
                      
                                                                 
                    
                     
                      @endforeach
            @endif
                     </div>       
                     
                     <br> <br>
                                                  <div class="row">
                                                 
                                                   <div class="col-lg-2"></div><label class="col-lg-2 col-form-label"> Sub Total (+):</label>
                    <div class="col-lg-6 line_items">
                    <input type="text" name="subtotal[]" class="form-control item_total" placeholder="subtotal" required="" jautocalc="SUM({total_cost})" readonly="readonly" ><br> 
                     </div><div class="col-lg-2"></div>
                     
                      <div class="col-lg-2"></div><label class="col-lg-2 col-form-label">Tax (+):</label>
                     <div class="col-lg-6 line_items">
                  <input type="text" name="tax[]" class="form-control item_total" placeholder="tax" required="" jautocalc="SUM({total_tax})" readonly="readonly" ><br> 
                     </div><div class="col-lg-2"></div>
                     
                     
                     
                     <div class="col-lg-2"></div><label class="col-lg-2 col-form-label"> Total:</label>
                     <div class="col-lg-6 line_items">
                     <input type="text" name="amount[]" class="form-control item_total" placeholder="total" required="" jautocalc="{subtotal} + {tax}" readonly="readonly" ><br> 
                     </div><div class="col-lg-2"></div>
                                                 
                                                 
                                            </div>
                                     
                                                
                                            </div>
                                         
<br>
 <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
 
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
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
            url: '{{url("pos/purchases/findinvoice")}}',
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
            url: '{{url("pos/purchases/editshowInvoice")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#dn-cart > .body").empty();
              
                $.each(response,function(key, value)
                {
                 
                     $('#dn-cart > .body').append(response.html);
                    

                });                      
               
            }

        });
  });  

});
</script>




<script type="text/javascript">
$(document).ready(function() {


    function autoCalcSetup() {
        $('div#dn-cart').jAutoCalc('destroy');
        $('div#dn-cart div.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('div#dn-cart').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();


    $(document).on('click', '.rem', function() {
         var btn_value = $(this).attr("value");
        var button_id = $(this).data('button_id');
        var contentToRemove = document.querySelectorAll('#td' + button_id);
        $(contentToRemove).remove(); 
        $('#dn-cart > .body').append(
            '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
            btn_value + '"/>');
        autoCalcSetup();
    });

 $(document).on('click', '.remove', function() {
        var button_id = $(this).data('button_id');
        var contentToRemove = document.querySelectorAll('#td' + button_id);
        $(contentToRemove).remove(); 
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
            url: '{{url("pos/purchases/findinvQty")}}',
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

<script>
    $(document).ready(function() {
    
      
         $(document).on('click', '.save', function(event) {
   
         $('.errors').empty();
        
          if ( $('#dn-cart > .body .line_items').length == 0 ) {
               event.preventDefault(); 
    $('.item_errors').append('Please Add Items.');
}
         
         else{
            
         
          
         }
        
    });
    
    
    
    });
    </script>
               


@endsection