@extends('layouts.master')
@section('title') Order List @endsection
@section('content')

            <section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Order List</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Order
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Order</a>
                            </li>

                        </ul>
                        <br>
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
                                                        style="width: 126.484px;">Reference</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 126.484px;">Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Client</th>
                                                       <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 126.484px;">Location</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Total Amount</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 108.484px;">Status</th>

                                                    <th class=" sorting text-center" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 120.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!@empty($index))
                                                @foreach ($index as $row)
                                                <tr class="gradeA even" role="row">

                                                    <td> <a class="list-icons-item text-primary"  title="Show Details" href="{{ route('orders.show', $row->id)}}"> {{ $row->reference_no }}</a></td>
                                                    
                                                    <td>{{Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y')}}</td>
                                                   <td>@if(!empty($row->client->name)){{$row->client->name}}@endif</td>
                                                     <td>@if(!empty($row->store->name)){{$row->store->name}}@endif</td>



                                                    <td>{{number_format(($row->invoice_amount + $row->invoice_tax) - $row->discount ,2)}}</td>


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
                                                    @if($row->good_receive == 0)
                                                    <a class="list-icons-item text-primary"
                                                        title="Edit" onclick="return confirm('Are you sure?')"
                                                        href="{{ route('orders.edit', $row->id)}}"><i
                                                            class="icon-pencil7"></i></a>&nbsp
                                                           

                                                    {!! Form::open(['route' => ['orders.destroy',$row->id],
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
                                                                    href="{{ route('orders.receive',$row->id)}}"
                                                                    role="tab"
                                                                    aria-selected="false">Deliver Order</a>
                                                            </li>
                                                            @endif
                                                          
                                                             @if($row->good_receive == 0)
                                                            <li class="nav-item"><a class="nav-link" title="Cancel"
                                                                    onclick="return confirm('Are you sure?')"
                                                                    href="{{ route('orders.cancel', $row->id)}}">Cancel
                                                                 Order</a></li>
                                        @endif

                                        <a class="nav-link" id="profile-tab2" href="{{ route('orders_pdfview',['download'=>'pdf','id'=>$row->id]) }}"
                                            role="tab"  aria-selected="false">Download PDF</a>
                                            <a class="nav-link" id="profile-tab2" href="{{ route('orders_receipt',['download'=>'pdf','id'=>$row->id]) }}"
                                            role="tab"  aria-selected="false">Download Receipt</a>  
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
                                            <h5>Create Menu Item</h5>
                                            @else
                                            <h5>Edit Menu Item</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">

                                                    @if(isset($id))
                                                    {{ Form::model($id, array('route' => array('orders.update', $id), 'method' => 'PUT')) }}
                                                    @else
                                                    {{ Form::open(['route' => 'orders.store']) }}
                                                    @method('POST')
                                                    @endif

                                                 <input type="hidden" name="edit_type"
                                                class="form-control name_list"
                                                value="{{$type}}" />

                                                    <div class="form-group row">
                                                       
                                                        <label class="col-lg-2 col-form-label"> Client</label>
                                                            <div class="col-lg-4">
                                                         <div class="input-group mb-3">
                                                            <select class="form-control append-button-single-field client_id" name="client_id"  id="client_id">
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
                                                                    data-target="#appFormModal"  href="appFormModal"><i class="icon-plus-circle2"></i></button>
                                                        </div>
                                                    </div>
                                                       <label class="col-lg-2 col-form-label">Date <span class=""
                                                                style="color:red;">*</span></label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="invoice_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->invoice_date : date('Y-m-d')}}"
                                                            class="form-control">
                                                    </div> 
                                                    </div>


                                                  <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Location <span class=""
                                                                style="color:red;">*</span></label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control m-b location" name="location" 
                                                                id="location" required>
                                                        <option value="">Select Location</option>
                                                        @if(!empty($location))
                                                        @foreach($location as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->location == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                    </div>


                                            <label  class="col-lg-2 col-form-label">Bank/Cash Account <span class=""
                                                                style="color:red;">*</span></label>

                                                    <div class="col-lg-4">
                                                       <select class="form-control m-b" name="account_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->account_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
                                                    </div>
                                                </div>

                                    <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Sales Agent <span class=""
                                                                style="color:red;">*</span></label>
                                                    <div class="col-lg-4">
                                                       @if(!empty($data->user_agent))

                              <select class="form-control m-b" name="user_agent" id="user_agent" required >
                            <option value="{{ old('user_agent')}}" disabled selected>Select User</option>
                            @if(isset($user))
                            @foreach($user as $row)
                            <option  @if(isset($data)) {{$data->user_agent == $row->id ? 'selected' : 'TZS' }} @endif  value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>

                         @else
                       <select class="form-control m-b" name="user_agent" id="user_agent" required >
                            <option value="{{ old('user_agent')}}" disabled selected>Select User</option>
                            @if(isset($user))
                            @foreach($user as $row)

                           @if($row->id == auth()->user()->id)
                            <option value="{{ $row->id }}" selected>{{ $row->name }}</option>
                           @else
                          <option value="{{ $row->id }}" >{{ $row->name }}</option>
                           @endif

                            @endforeach
                            @endif
                        </select>


                     @endif
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

                                                 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Currency <span class=""
                                                                style="color:red;">*</span></label>
                                                    <div class="col-lg-4">
                                                     @php $def=App\Models\System::where('added_by',auth()->user()->added_by)->first(); @endphp
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

                           @if($row->code == $def->currency)
                            <option value="{{ $row->code }}" selected>{{ $row->name }}</option>
                           @else
                          <option value="{{ $row->code }}" >{{ $row->name }}</option>
                           @endif

                            @endforeach
                            @endif
                        </select>


                     @endif
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Exchange Rate <span class=""
                                                                style="color:red;">*</span></label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="exchange_rate"
                                                            placeholder="1 if TZSH"
                                                            value="{{ isset($data) ? $data->exchange_rate : '1.00'}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>



                                           <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Notes</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="notes" placeholder="" class="form-control"
                                                            rows="2">{{ isset($data) ? $data->notes: ''}}</textarea>
                                                    </div>
                                                </div>



                                                <h4 align="center">Enter Menu Items</h4>
                                                    <hr>
                                                    <button type="button" name="add"
                                                        class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add
                                                            Menu Items</i></button><br>
                                                    <br>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                            <thead>
                                                                <tr>
                                                                    <th>Type <span class=""
                                                                style="color:red;">*</span></th>
                                                                    <th>Name <span class=""
                                                                style="color:red;">*</span></th>
                                                                    <th>Quantity <span class=""
                                                                style="color:red;">*</span></th>
                                                                    <th>Price <span class=""
                                                                style="color:red;">*</span></th>
                                                                <th>Tax <span class=""
                                                                style="color:red;">*</span></th>
                                                                    <th>Total <span class=""
                                                                style="color:red;">*</span></th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                            </tbody>
                                                            <tfoot>
                                                                @if(!empty($id))
                                                                @if(!@empty($items))
                                                                @foreach ($items as $i)
                                                                <tr class="line_items">
                                                                  <td><select name="type[]" class="form-control m-b item_type"  data-sub_category_id="{{$i->order_no}}_edit" required>
                                                                         <option value="">Select Type</option><option value="Bar" @if(isset($i))@if('Bar' == $i->type) selected @endif @endif>Drinks</option>
                                                                                <option value="Kitchen" @if(isset($i))@if('Kitchen' == $i->type) selected @endif @endif>Food</option></select></td>
                                                                         <?php
                                                                             if($i->type == 'Bar'){
                                                                               $name=App\Models\POS\Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->where('bar','1')->where('disabled','0')->get();
                                                                               }

                                                                              else if($i->type == 'Kitchen'){
                                                                                $name=App\Models\Restaurant\POS\Menu::where('status','1')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get(); 
                                                                                }
                                                                         ?>
                                                                    <td><select name="item_name[]"
                                                                            class="form-control m-b item_name" id="item_name_{$i->order_no}}" 
                                                                            data-sub_category_id="{{$i->order_no}}_edit" required>
                                                                            <option value="">Select</option>
                                                                            @foreach($name as $n) <option
                                                                                value="{{ $n->id}}"
                                                                                @if(isset($i))@if($n->id ==
                                                                                $i->item_name) selected @endif @endif
                                                                                >{{$n->name}}</option>@endforeach
                                                                        </select></td>
                                                                    <td><input type="number"  name="quantity[]"
                                                                            class="form-control item_quantity" data-category_id="{{$i->order_no}}_edit"
                                                                            placeholder="quantity" id="quantity"
                                                                            value="{{ isset($i) ? $i->quantity : ''}}"
                                                                            required ><div class=""><p class="form-control-static errors{{$i->order_no}}_edit" id="errors" style="text-align:center;color:red;"></p></div></td>
                                                          <td><input type="number" step="0.01" name="price[]" class="form-control item_price{{$i->order_no}}_edit"   value="{{ isset($i) ? $i->price : ''}}"  placeholder ="price" required  value=""/> </td>                                                                 
                                                                     <input type="hidden" name="tax_rate[]"
                                                                            class="form-control item_tax{{$i->order_no}}_edit"
                                                                            placeholder="price" required
                                                                            value="{{ isset($i) ? $i->tax_rate : ''}}" />
                                                                    <td><input type="text" name="total_tax[]"
                                                                        class="form-control item_total_tax{{$i->order_no}}_edit"
                                                                        placeholder="total" required
                                                                        value="{{ isset($i) ? $i->total_tax : ''}}"
                                                                        readonly
                                                                        jAutoCalc="{quantity} * {price} * {tax_rate}" /></td>
                                                                    
                                                                    <input type="hidden" name="items_id[]"
                                                                        class="form-control item_saved{{$i->order_no}}_edit"
                                                                        value="{{ isset($i) ? $i->items_id : ''}}"
                                                                        required />
                                                          <input type="hidden" name="items_id[]"
                                                                        class="form-control item_saved{{$i->order_no}}_edit"
                                                                        value="{{ isset($i) ? $i->items_id : ''}}"
                                                                        required />
                                                                    <td><input type="text" name="total_cost[]"
                                                                            class="form-control item_total{{$i->order_no}}_edit"
                                                                            placeholder="total" required
                                                                            value="{{ isset($i) ? $i->total_cost : ''}}"
                                                                            readonly jAutoCalc="{quantity} * {price}" />
                                                                    </td>
                                                                    <input type="hidden" name="saved_items_id[]"
                                                                        class="form-control name_list"
                                                                        value="{{ isset($i) ? $i->id : ''}}" />
                                                                       <input type="hidden" id="item_id"  class="form-control item_id{{$i->order_no}}_edit" value="{{$i->item_name}}" />
                                                                      <input type="hidden" id="type_id"  class="form-control type_id{{$i->order_no}}_edit" value="{{$i->type}}" />                                   
                                                                    <td><button type="button" name="remove"
                                                                            class="btn btn-danger btn-xs rem"
                                                                            value="{{ isset($i) ? $i->id : ''}}"><i
                                                                                class="icon-trash"></i></button></td>
                                                                </tr>

                                                                @endforeach
                                                                @endif
                                                                @endif

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
                                                                            class="form-control item_total"
                                                                            placeholder="tax" required
                                                                            jAutoCalc="SUM({total_tax})" readonly>
                                                                    </td>
                                                                </tr>
                                                                   <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <td><span class="bold">Discount </span>: </td>
                                                            <td><input type="text" name="discount[]"
                                                                    class="form-control item_discount"
                                                                    placeholder="discount" required
                                                                    value="{{ isset($data) ? $data->discount : '0.00'}}"
                                                                    ></td>
                                                        </tr>
                                                                <tr class="line_items">
                                                                    <td colspan="4"></td>

                                                                    <td><span class="bold">Total</span>: </td>
                                                                    <td><input type="text" name="amount[]"
                                                                            class="form-control item_total"
                                                                            placeholder="total" required
                                                                            jAutoCalc="{subtotal} + {tax}  - {discount}" readonly>
                                                                    </td>

                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>


                                                    <br>


                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if(!@empty($id))

                                                            <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                href="{{ route('orders.index')}}">
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
            </div>
        </div>
    </div>
</div>

 <!-- discount Modal -->
            <div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                </div>
            </div>

@endsection
@section('scripts')

 <script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            ordering:false,
            "columnDefs": [
                {"orderable": false, "targets": [1]}
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
    $(document).on('change', '.item_type', function() {
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("restaurant/showType")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('.type_id' + sub_category_id).val(id);

               $('#item_name_'+sub_category_id).empty();
                 $('#item_name_'+sub_category_id).append('<option value="">Select </option>');
                $.each(data,function(key, value)
                {
                   
                  
           $('#item_name_'+sub_category_id).append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                   
                });              
               
            }

        });

    });


 $(document).on('change', '.item_name', function() {
                    var id = $(this).val();
                    var sub_category_id = $(this).data('sub_category_id');
              var type= $('.type_id' + sub_category_id).val();
                    $.ajax({
            url: '{{url("restaurant/findPrice")}}',
            type: "GET",
            data: {
                id: id,
                 type: type,
            },
            dataType: "json",
            success: function(data) {
                console.log(data);

                  if(type == 'Bar'){
                $('.item_price' + sub_category_id).val(data[0]["unit_price"]);
                 }
               else if(type == 'Kitchen'){
                 $('.item_price' + sub_category_id).val(data[0]["price"]);
                 }
                $('.item_id' + sub_category_id).val(id);
                 $(".item_tax" + sub_category_id).val(data[0]["tax_rate"]);
            }

        });

    });


   
});
</script>

            <script>
            $(document).ready(function() {
 $(document).ready(function() {
     
     
      $(document).on('change', '.location', function() {
     $(".item_quantity").change();

    });
    
       $(document).on('change', '.item_quantity', function() {
            var id = $(this).val();
              var sub_category_id = $(this).data('category_id');
             var item= $('.item_id' + sub_category_id).val();
                var type= $('.type_id' + sub_category_id).val();
             var location= $('.location').val();

    console.log(item);
            $.ajax({
                url: '{{url("restaurant/findQuantity")}}',
                type: "GET",
                data: {
                    id: id,
                  item: item,
                   type: type,
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
                    html +='<td><select name="type[]" class="form-control m-b item_type"  data-sub_category_id="' +count +'" required><option value="">Select Type</option><option value="Bar">Drinks</option><option value="Kitchen">Food</option></select></td>';
                    html +='<td><select name="item_name[]" class="form-control m-b item_name" id="item_name_' +count + '"  data-sub_category_id="' +count + '"  required><option value="">Select Item</option></select></td>';
                    html +='<td><input type="number"  name="quantity[]" class="form-control item_quantity" data-category_id="' +count + '"placeholder ="quantity" id ="quantity" required /><div class=""><p class="form-control-static errors'+count+'" id="errors" style="text-align:center;color:red;"></p></div></td>';
                    html += '<td><input type="number" step="0.01" name="price[]" class="form-control item_price' +count + '" placeholder ="price" required  value=""/><div class=""></td>';
                    html += '<input name="tax_rate[]" class="form-control item_tax' + count +'" required type="hidden">';
                    html +='<td><input type="text" name="total_tax[]" class="form-control item_total_tax' +count +'" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   /></td>';
                     html +='<input type="hidden" id="item_id"  class="form-control item_id' +count+'" value="" />';
                     html +='<input type="hidden" id="type_id"  class="form-control type_id' +count+'" value="" />';
                    html +='<td><input type="text" name="total_cost[]" class="form-control item_total' +count +'" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
                    html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

                    $('#cart > tbody').append(html);

            $('.m-b').select2({
                            });
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
         data:  $('.addClientForm').serialize(),
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




@endsection