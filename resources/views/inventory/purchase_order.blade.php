
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Create Purchase Order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    
     <form id="form" role="form" enctype="multipart/form-data" action="{{route('service.save_purchase')}}"  method="post" >
                                        @csrf
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
                     <div class="row">
                                            <div class="col-sm-12 ">
                                               
                                               
                                              
                                         

                                               

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Location</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control m-b " name="location" required
                                                        id="location">
                                                        <option value="">Select Location</option>
                                                        @if(!empty($location))
                                                        @foreach($location as $loc)

                                                        <option value="{{ $loc->id}}">{{$loc->name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                        
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Supplier Name</label>
                                                        <div class="col-lg-4">
                                                           
                                                                <select
                                                                    class="form-control m-b supplier_id"
                                                                    name="supplier_id" id="supplier_id" required>
                                                                    <option value="">Select Supplier Name</option>
                                                                    @if (!empty($supplier))
                                                                        @foreach ($supplier as $row)
                                                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif

                                                                </select>
                                                        </div>
                                                    </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Purchase Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="purchase_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ date('Y-m-d')}}"
                                                            class="form-control">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Due Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="due_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{  strftime(date('Y-m-d', strtotime("+10 days")))}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                 <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Purchase Agent</label>
                                                        <div class="col-lg-4">
                                                           
                                                                <select class="form-control m-b" name="user_agent" id="user_agent" required>
                                                                    <option value="{{ old('user_agent') }}" disabled
                                                                        selected>Select User</option>
                                                                    @if (isset($user))
                                                                        @foreach ($user as $row)
                                                                            @if ($row->id == auth()->user()->id)
                                                                                <option value="{{ $row->id }}" selected>{{ $row->name }}</option>
                                                                            @else
                                                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>


                                                           
                                                        </div>
                                                        
                                                        <label class="col-lg-2 col-form-label">Branch</label>
                                                         <div class="form-group col-md-4">
                                                            <select  class="form-control m-b" name="branch_id">
                                                                <option>Select Branch</option>
                                                                @if (!empty($branch))
                                                                    @foreach ($branch as $row)
                                                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>



                                                <br>
                                                <h4 align="center">Enter Item Details</h4>
                                                <hr>
                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Currency</label>
                                                    <div class="col-lg-4">
                                                      
                       <select class="form-control m-b" name="exchange_code" id="currency_code" required >
                            <option value="{{ old('currency_code')}}" disabled >Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)

                           @if($row->code == 'TZS')
                            <option value="{{ $row->code }}" selected>{{ $row->name }}</option>
                           @else
                          <option value="{{ $row->code }}" >{{ $row->name }}</option>
                           @endif

                            @endforeach
                           
                        </select>


                     @endif
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Exchange Rate</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="exchange_rate"
                                                            placeholder="1 if TZSH"
                                                            value="{{ 1.00}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                
                                                <br>
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="pur">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                            <th>Tax</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                  @if(!empty($id))
                                                        @if(!empty($items))
                                                        @foreach ($items as $i)
                                                        
                                                        @php $item_name = App\Models\Inventory::find($i->item_name); @endphp
                                                        <tr class="line_items">
                                                            <td>
                                                            <select class="form-control m-b item_name"  data-sub_category_id="{{$i->order_no}}" disabled>
                                                                    <option value="">Select Item</option>@foreach($name
                                                                    as $n) <option value="{{ $n->id}}"
                                                                        @if(isset($i))@if($n->id == $i->item_name)
                                                                        selected @endif @endif >{{$n->name}}</option>
                                                                    @endforeach
                                                                </select></td>
                                                            <td><input type="number" name="quantity[]" min="1"
                                                                    class="form-control item_quantity{{$i->order_no}}"
                                                                    placeholder="quantity" id="quantity"
                                                                    value="{{ isset($i) ? $i->quantity : ''}}"
                                                                    required /></td>
                                                            <td><input type="text" name="price[]"
                                                                    class="form-control item_price{{$i->order_no}}"
                                                                    placeholder="price" required
                                                                    value="{{ isset($i) ? $item_name->price : ''}}" /></td>
                                                            <input type="hidden" name="unit[]"
                                                                    class="form-control item_unit{{$i->order_no}}"
                                                                    placeholder="unit"
                                                                    value="{{ isset($i) ? $item_name->unit : ''}}" />
                                                            <td><select name="tax_rate[]"
                                                                    class="form-control m-b item_tax'+count{{$i->order_no}}"
                                                                    required>
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
                                                            <input type="hidden" name="item_name[]"
                                                                class="form-control item_saved{{$i->order_no}}"
                                                                value="{{ isset($i) ? $i->item_name : ''}}"
                                                                required />
                                                            <td><input type="text" name="total_cost[]"
                                                                    class="form-control item_total{{$i->order_no}}"
                                                                    placeholder="total" required
                                                                    value="{{ isset($i) ? $i->total_cost : ''}}"
                                                                    readonly jAutoCalc="{quantity} * {price}" /></td>
                                                            <input type="hidden" name="items_id[]"
                                                                class="form-control name_list"
                                                                value="{{ isset($i) ? $i->id : ''}}" />
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-xs rem"
                                                                    value="{{ isset($i) ? $i->id : ''}}"><i
                                                                        class="icon-trash"></i></button></td>
                                                        </tr>

                                                        @endforeach
                                                        @endif
                                                        @endif

                                                    </tbody>
                                                    <tfoot>
                                                       

                                                        <tr class="line_items">
                                                                    <td colspan="3"></td>
                                                                    <td><span class="bold">Sub Total (+)</span>: </td>
                                                                    <td><input type="text" name="subtotal[]"
                                                                            class="form-control item_total"
                                                                            value="{{ isset($data) ? '' : '0.00' }}"
                                                                            required jAutoCalc="SUM({total_cost})"
                                                                            readonly></td>
                                                                </tr>
                                                                <tr class="line_items">
                                                                    <td colspan="3"></td>
                                                                    <td><span class="bold">Tax (+)</span>: </td>
                                                                    <td><input type="text" name="tax[]"
                                                                            class="form-control item_total"
                                                                            value="{{ isset($data) ? '' : '0.00' }}"
                                                                            required jAutoCalc="SUM({total_tax})" readonly>
                                                                    </td>
                                                                </tr>
                                                                <tr class="line_items">
                                                                    <td colspan="3"></td>
                                                                    <td><span class="bold">Shipping Cost (+)</span>:
                                                                    </td>
                                                                    <td><input type="text" name="shipping_cost[]"
                                                                            class="form-control item_shipping"
                                                                            placeholder="shipping_cost" required
                                                                            value="0.00">
                                                                    </td>
                                                                </tr>
                                                                <tr class="line_items">
                                                                    <td colspan="3"></td>
                                                                    <td><span class="bold">Discount (-)</span>: </td>
                                                                    <td><input type="text" name="discount[]"
                                                                            class="form-control item_discount"
                                                                            placeholder="discount" required
                                                                            value="0.00">
                                                                    </td>
                                                                </tr>

                                                                <tr class="line_items">
                                                                    <td colspan="3"></td>
                                                                    <td><span class="bold">Total</span>: </td>
                                                                    <td><input type="text" name="amount[]"
                                                                            class="form-control item_total"
                                                                          
                                                                            required
                                                                            jAutoCalc="{subtotal} + {tax} + {shipping_cost} - {discount}"
                                                                            readonly></td>

                                                                </tr>
                                                    </tfoot>
                                                </table>
                                            </div>


                                             
                                           

                                        
                                    </div>
                                </div>
           
                                               
                                                            

        </div>
       <div class="modal-footer ">
          <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>


@yield('scripts')

 <script>
        $('.datatable-b').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "targets": [0]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },

        });
    </script>
    
    <script>
        $('.datatable-modal').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "targets": [0]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },

        });
    </script>
    
    
<script type="text/javascript">
$(document).ready(function() {


    function autoCalcSetup() {
        $('table#pur').jAutoCalc('destroy');
        $('table#pur tr.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('table#pur').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();


$('.m-b').select2({});



    $(document).on('click', '.rem', function() {
        var btn_value = $(this).attr("value");
        $(this).closest('tr').remove();
        $('#pur > tfoot').append('<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +btn_value + '"/>');
        autoCalcSetup();
    });

});
</script>