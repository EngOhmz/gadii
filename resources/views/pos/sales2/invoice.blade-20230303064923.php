@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Invoice </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Invoice
                                     List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Invoice</a>
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
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Client Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 136.484px;">Invoice Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Due Amount</th>
                                                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Location</th>
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
                                                            href="{{ route('invoice.show',$row->id)}}" role="tab"
                                                            aria-selected="false">{{$row->reference_no}}</a>
                                                </td>
                                                <td>
                                                      {{$row->client->name }}
                                                </td>
                                                
                                                <td>{{$row->invoice_date}}</td>

                                                <td>{{number_format($row->due_amount,2)}} {{$row->exchange_code}}</td>
                                     <td>@if(!empty($row->store->name)) {{$row->store->name}} @endif</td>
                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Not Approved</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-warning badge-shadow">Approved</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    @elseif($row->status == 3)
                                                    <span class="badge badge-success badge-shadow">Fully Paid</span>
                                                    @elseif($row->status == 4)
                                                    <span class="badge badge-danger badge-shadow">Cancelled</span>

                                                    @endif
                                                </td>
                                               
                                                 @if($row->status != 4 && $row->status != 3)
                                                <td>
                                            <div class="form-inline">
                                                    @if($row->good_receive == 0)
                                                    <a class="list-icons-item text-primary"
                                                        title="Edit" onclick="return confirm('Are you sure?')"
                                                        href="{{ route('invoice.edit', $row->id)}}"><i
                                                            class="icon-pencil7"></i></a>&nbsp
                                                           

                                                    {!! Form::open(['route' => ['invoice.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                 {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit','style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
 @endif
                                 &nbsp

                                                <div class="dropdown">
							                		<a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

													<div class="dropdown-menu">

                                                            @if($row->status == 0 && $row->status != 4 && $row->status != 3 && $row->good_receive == 0)
                                                            <li> <a class="nav-link" id="profile-tab2"
                                                                    href="{{ route('invoice.receive',$row->id)}}"
                                                                    role="tab"
                                                                    aria-selected="false">Approve Invoice</a>
                                                            </li>
                                                            @endif
                                                             @if($row->status != 0 && $row->status != 4 && $row->status != 3 && $row->good_receive == 1)
                                                            <li> <a class="nav-link" id="profile-tab2"
                                                                    href="{{ route('pos_invoice.pay',$row->id)}}"
                                                                    role="tab"
                                                                    aria-selected="false">Make Payments</a>
                                                            </li>
                                                            @endif
                                                             @if($row->good_receive == 0)
                                                            <li class="nav-item"><a class="nav-link" title="Cancel"
                                                                    onclick="return confirm('Are you sure?')"
                                                                    href="{{ route('invoice.cancel', $row->id)}}">Cancel
                                                                  Invoice</a></li>
                                        @endif
                                             <a class="nav-link" id="profile-tab2" href="{{ route('pos_invoice_pdfview',['download'=>'pdf','id'=>$row->id]) }}"
                                            role="tab"  aria-selected="false">Download PDF</a>
													</div>
					                			</div>
                                                   
                                                </div>
                                                </td>
                                                @else
                                                <td></td>
                                                @endif
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
                                        <h5>Create Invoice</h5>
                                        @else
                                        <h5>Edit Invoice</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('invoice.update', $id), 'method' => 'PUT')) }}
                                              
                                                @else
                                                {{ Form::open(['route' => 'invoice.store']) }}
                                                @method('POST')
                                                @endif


                                                <input type="hidden" name="type"
                                                class="form-control name_list"
                                                value="{{$type}}" />

                                                <div class="form-group row">
                                                 
                                                    <label class="col-lg-2 col-form-label">Client Name</label>
                                                    <div class="col-lg-4">
                                                        <div class="input-group mb-3">
                                                            <select class="form-control append-button-single-field client_id" name="client_id"  id="client_id" required>
                                                                <option value="">Select Client Name</option>
                                                                @if(!empty($client))
                                                                @foreach($client as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->client_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>&nbsp

                                                            <button class="btn btn-outline-secondary" type="button"
                                                                    data-toggle="modal" value="" onclick="model('1','client')"
                                                                    data-target="#appFormModal"  href="app2FormModal"><i class="icon-plus-circle2"></i></button>
                                                        </div>
                                                    </div>
                                            <label class="col-lg-2 col-form-label">Location</label>
                                                    <div class="col-lg-4">
                                                          <select class="form-control m-b location" name="location" required
                                                        id="location">
                                                        <option value="">Select Location</option>
                                                        @if(!empty($location))
                                                        @foreach($location as $loc)

                                                        <option @if(isset($data))
                                                            {{  $data->location == $loc->id  ? 'selected' : ''}}
                                                            @endif value="{{ $loc->id}}">{{$loc->name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Invoice Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="invoice_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->invoice_date : date('Y-m-d')}}"
                                                            class="form-control">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Due Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="due_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->due_date : strftime(date('Y-m-d', strtotime("+10 days")))}}"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                      <div class="form-group row">
                    <label class="col-lg-2 col-form-label"  for="gender">Sales Type  </label>
                         <div class="col-lg-4">
                   <select class="form-control m-b sales" name="sales_type" id="sales" required  >                                     
                      <option value="">Select Sales Type</option>
                        <option value="Cash Sales" @if(isset($data)){{$data->sales_type == 'Cash Sales'  ? 'selected' : ''}} @endif>Cash Sales</option>
                             <option value="Credit Sales" @if(isset($data)){{$data->sales_type == 'Credit Sales'  ? 'selected' : ''}} @endif>Credit Sales</option>                                                              
                    </select>
                
                </div>

               @if(!empty($data->bank_id))
               <label for="stall_no" class="col-lg-2 col-form-label bank1"  style="display:block;">Bank/Cash Account</label>
                         <div class="col-lg-4 bank2"  style="display:block;">
                     <select class="form-control m-b" name="bank_id" >
                                    <option value="">Select Payment Account</option> 
                                          @foreach ($bank_accounts as $bank)                                                             
                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->bank_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                               @endforeach
                                              </select>
                  </div>
               
                @else
                   <label for="stall_no" class="col-lg-2 col-form-label bank1"  style="display:none;">Bank/Cash Account</label>
                         <div class="col-lg-4 bank2"  style="display:none;">
                     <select class="form-control m-b" name="bank_id" >
                                    <option value="">Select Payment Account</option> 
                                          @foreach ($bank_accounts as $bank)                                                             
                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->bank_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                               @endforeach
                                              </select>
                
                </div>
                   @endif
</div>

                               
                                  


                                                <br>
                                                <h4 align="center">Enter Item Details</h4>
                                                <hr>
                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Currency</label>
                                                    <div class="col-lg-4">
                                                       @if(!empty($data->exchange_code))

                              <select class="form-control m-b" name="exchange_code" id="currency_code" required >
                            <option value="{{ old('currency_code')}}" disabled selected>Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)
                            <option  @if(isset($data)) {{$data->exchange_code == $row->code ? 'selected' : 'TZS' }} @endif  value="{{ $row->code }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>

                         @else
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
                            @endif
                        </select>


                     @endif
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Exchange Rate</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="exchange_rate"
                                                            placeholder="1 if TZSH"
                                                            value="{{ isset($data) ? $data->exchange_rate : '1.00'}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <hr>
                                                <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                        class="fas fa-plus"> Add item</i></button><br>
                                                <br>
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
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


                                                    </tbody>
                                                    <tfoot>
                                                        @if(!empty($id))
                                                        @if(!empty($items))
                                                        @foreach ($items as $i)
                                                        <tr class="line_items">
                            <td><div class="input-group mb-3"><select name="item_name[]"
                                    class="form-control  m-b item_name" required
                                    data-sub_category_id="{{$i->id}}_edit">
                                    <option value="">Select Item</option>@foreach($name
                                    as $n) <option value="{{ $n->id}}"
                                        @if(isset($i))@if($n->id == $i->item_name)
                                        selected @endif @endif >{{$n->name}}</option>
                                    @endforeach
                                </select></div><textarea name="description[]"  class="form-control desc" placeholder="Description"  cols="30" >{{ isset($i) ? $i->description : ''}}</textarea></td>
                            <td><input type="number" name="quantity[]"
                                   class="form-control item_quantity" data-category_id="{{$i->id}}_edit"
                                    placeholder="quantity" id="quantity"
                                    value="{{ isset($i) ? $i->quantity : ''}}"
                                    required /><div class=""> <p class="form-control-static errors{{$i->id}}_edit" id="errors" style="text-align:center;color:red;"></p>   </div></td>
                            <td><input type="text" name="price[]"
                                    class="form-control item_price{{$i->id}}_edit"
                                    placeholder="price" required
                                    value="{{ isset($i) ? $i->price : ''}}" /></td>
                            <input type="hidden" name="unit[]"
                                    class="form-control item_unit{{$i->id}}_edit"
                                    placeholder="unit" required
                                    value="{{ isset($i) ? $i->unit : ''}}" />
                            <input type="hidden" name="tax_rate[]"
                                    class="form-control item_tax{{$i->id}}_edit"  value="{{ isset($i) ? $i->tax_rate : ''}}" 
                                    required>                                                                    
                            <td><input type="text" name="total_tax[]"
                                class="form-control item_total_tax{{$i->id}}_edit"
                                placeholder="total" required
                                value="{{ isset($i) ? $i->total_tax : ''}}" readonly
                                jAutoCalc="{quantity} * {price} * {tax_rate}" /></td>
                            <input type="hidden" name="saved_items_id[]"
                                class="form-control item_saved{{$i->id}}_edit"
                                value="{{ isset($i) ? $i->id : ''}}"
                                required />
                            <td><input type="text" name="total_cost[]"
                                    class="form-control item_total{{$i->id}}_edit"
                                    placeholder="total" required
                                    value="{{ isset($i) ? $i->total_cost : ''}}"
                                    readonly jAutoCalc="{quantity} * {price}" /></td>
                               <input type="hidden" id="item_id"  class="form-control item_id{{$i->id}}_edit" value="{{$i->items_id}}" />
                            <input type="hidden" name="items_id[]"
                                class="form-control name_list"
                                value="{{ isset($i) ? $i->id : ''}}" />
                            <td><button type="button" name="remove"
                                    class="btn btn-danger btn-xs rem"
                                    value="{{ isset($i) ? $i->id : ''}}"><i class="icon-trash"></i></button></td>
                        </tr>

                                                        @endforeach
                                                        @endif
                                                        @endif

                                                        
                                                        <tr class="line_items">
                                                            <td colspan="3"></td>
                                                            <td><span class="bold">Sub Total (+)</span>: </td>
                                                            <td><input type="text" name="subtotal[]"
                                                                    class="form-control item_total"
                                                                     value="{{ isset($data) ? '': '0.00'}}"  required
                                                                    jAutoCalc="SUM({total_cost})" readonly></td>
                                                        </tr>
                                                        <tr class="line_items">
                                                            <td colspan="3"></td>
                                                            <td><span class="bold">Tax (+)</span>: </td>
                                                            <td><input type="text" name="tax[]"
                                                                    class="form-control item_total"  value="{{ isset($data) ? '': '0.00'}}"
                                                                    required jAutoCalc="SUM({total_tax})" readonly>
                                                            </td>
                                                        </tr>
                                                        <tr class="line_items">
                                                            <td colspan="3"></td>
                                                            <td><span class="bold">Shipping Cost (+)</span>: </td>
                                                            <td><input type="text" name="shipping_cost[]"
                                                                    class="form-control item_shipping"
                                                                    placeholder="shipping_cost" required
                                                                    value="{{ isset($data) ? $data->shipping_cost : '0.00'}}"
                                                                    ></td>
                                                        </tr>
                                                         <tr class="line_items">
                                                            <td colspan="3"></td>
                                                            <td><span class="bold">Discount (-)</span>: </td>
                                                            <td><input type="text" name="discount[]"
                                                                    class="form-control item_discount"
                                                                    placeholder="discount" required
                                                                    value="{{ isset($data) ? $data->discount : '0.00'}}"
                                                                    ></td>
                                                        </tr>

                                                        <tr class="line_items">
                                                            <td colspan="3"></td>
                                                            <td><span class="bold">Total</span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total"  value="{{ isset($data) ? '': '0.00'}}"
                                                                    required jAutoCalc="{subtotal} + {tax} + {shipping_cost} - {discount}"
                                                                    readonly></td>
                                                    </tfoot>
                                                </table>
                                            </div>


                                                <br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="{{ route('invoice.index')}}">
                                                            Cancel
                                                        </a>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit" id="save">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save">Save</button>
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
<div class="modal fade" data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        
    </div>
</div>



@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
          order: [[2, 'desc']],
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
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
$(document).ready(function() {

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
    });

    $(document).on('change', '.item_name', function() {
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("pos/sales/findInvPrice")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('.item_price' + sub_category_id).val(data[0]["sales_price"]);
                $(".item_unit" + sub_category_id).val(data[0]["unit"]);
                  $(".item_tax" + sub_category_id).val(data[0]["tax_rate"]);
                 $('.item_id' + sub_category_id).val(id);
            }

        });

    });


});
</script>

<script>
    $(document).ready(function() {
    
       $(document).on('change', '.item_quantity', function() {
            var id = $(this).val();
              var sub_category_id = $(this).data('category_id');
             var item= $('.item_id' + sub_category_id).val();
           var location= $('.location').val();

    console.log(location);
            $.ajax({
                url: '{{url("pos/sales/findInvQuantity")}}',
                type: "GET",
                data: {
                    id: id,
                  item: item,
                 location: location,
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
            '<td><div class="input-group mb-3"><select name="item_name[]" class="form-control  m-b item_name" required  data-sub_category_id="' +
            count +
            '"><option value="">Select Item Name</option>@foreach($name as $n) <option value="{{ $n->id}}">{{$n->name}}</option>@endforeach</select></div><textarea name="description[]"  class="form-control desc" placeholder="Description"  cols="30" ></textarea></td>';
       html +=
            '<td><input type="number" name="quantity[]" class="form-control item_quantity" data-category_id="' +
            count + '"placeholder ="quantity" id ="quantity" required /><div class=""> <p class="form-control-static errors'+count+'" id="errors" style="text-align:center;color:red;"></p>   </div></td>';
        html += '<td><input type="text" name="price[]" class="form-control item_price' + count +
            '" placeholder ="price" required  value=""/></td>';
        html += '<input type="hidden" name="unit[]" class="form-control item_unit' + count +
            '" placeholder ="unit" required />';
           html += '<input type="hidden" name="tax_rate[]" class="form-control item_tax' + count +
            '" placeholder ="total" required />';
        html += '<td><input type="text" name="total_tax[]" class="form-control item_total_tax' + count +
            '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   readonly/></td>';
         html +='<input type="hidden" id="item_id"  class="form-control item_id' +count+'" value="" />';
        html += '<td><input type="text" name="total_cost[]" class="form-control item_total' + count +
            '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('tbody').append(html);
        autoCalcSetup();

/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
          
 

    
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
        url: '{{url("pos/sales/invModal")}}',
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

function saveClient(e) {
     
     $.ajax({
            type: 'GET',
            url: '{{url("pos/sales/save_client")}}',
         data:  $('#addClientForm').serialize(),
                dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.name;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#client_id').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
        });
}
</script>

<script>
$(document).ready(function() {

    $(document).on('change', '.sales', function() {
        var id = $(this).val();
  console.log(id);


 if (id == 'Cash Sales'){
     $('.bank1').show(); 
     $('.bank2').show();    

}


else{
   $('.bank1').hide(); 
     $('.bank2').hide();   

}

  });



});

</script>

@endsection