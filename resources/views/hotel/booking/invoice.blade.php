@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Bookings </h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                             @if(empty($booking))
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Booking List</a>
                                </li>
                               
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Booking</a>
                                </li>
                               
                                
                          
                                @else
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Booking</a>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                            <thead>
                                                <tr>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 126.484px;">Ref No</th>
                                                         <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 136.484px;">Booking Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Client</th>
                                                   
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;"> Amount</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Property</th>
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
                                                @if (!@empty($invoices))
                                                    @foreach ($invoices as $row)
                                                        

                                                        <tr class="gradeA even" role="row">

                                        <td><a class="nav-link" id="profile-tab2" href="{{ route('booking.show', $row->id) }}" role="tab" aria-selected="false">{{ $row->reference_no }}</a></td>
                                                    <td>{{Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y')}} </td>
                                                            <td>{{ $row->client->name }}</td>
                                                            <td>{{ number_format($row->invoice_amount + $row->invoice_tax, 2) }}
                                                                {{ $row->exchange_code }}</td>
                                                            <td>@if (!empty($row->store->name)){{ $row->store->name }}@endif</td>
                                                            <td>
                                                                @if ($row->status == 0)
                                                                    <div class="badge badge-danger badge-shadow">Not
                                                                        Approved</div>
                                                                @elseif($row->status == 1)
                                                                    <div class="badge badge-warning badge-shadow">Approved
                                                                    </div>
                                                                @elseif($row->status == 2)
                                                                    <div class="badge badge-info badge-shadow">Partially
                                                                        Paid</div>
                                                                @elseif($row->status == 3)
                                                                    <span class="badge badge-success badge-shadow">Fully
                                                                        Paid</span>
                                                                @elseif($row->status == 4)
                                                                    <span
                                                                        class="badge badge-danger badge-shadow">Cancelled</span>
                                                                @endif
                                                            </td>

                                           @php  $check=App\Models\Hotel\Booked::where('invoice_id',$row->id)->whereIn('status', [0,1])->first(); @endphp
                                           
                                                            <td>
                                                                <div class="form-inline">
                                                                   
                                                                    &nbsp

                                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

                                                                        <div class="dropdown-menu">
                                                                        

                                @if($row->status == 0)
                             <a class="nav-link"  onclick="return confirm('Are you sure?')"   href="{{ route('booking.approve', $row->id)}}"  title="" > Approve Booking</a> 
                 
                                @endif
                              
                
                    
                               @if($row->status == 2 || $row->status == 1)                      
                                <a class="nav-link" data-placement="top"  href="{{ route('booking.pay',$row->id)}}"  title="Add Payment"> Pay invoice  </a>    
                           @endif  
                
                                @if($row->status == 2 || $row->status == 3)
                                @if(!empty($check))
                                  <a class="nav-link"  data-toggle="modal"  onclick="model({{$row->id}},'cancel')" data-target="#appFormModal" data-id="{{$row->id}}"  href=""  title="" > Cancel Booking </a>
                                @endif
                                 @endif

                             
                                 @if($row->status == 0 || $row->status == 1)
                             <a class="nav-link"  onclick="return confirm('Are you sure?')"   href="{{ route('booking.cancel', $row->id)}}"  title="" > Cancel Booking </a> 
                            
                                @endif
                                                                            

                            <a class="nav-link" id="profile-tab2" href="{{ route('booking_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}">Download PDF</a>
                            
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
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (empty($id))
                                                <h5>Create Invoice</h5>
                                            @else
                                                <h5>Edit Invoice</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                {{ Form::model($id, array('route' => array('booking.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data", 'id' => 'invform')) }}
                                                        
                                                    @else
                                                        {!! Form::open(array('route' => 'booking.store',"enctype"=>"multipart/form-data", 'id' => 'invform')) !!}
                                                        @method('POST')
                                                    @endif


                                                    <input type="hidden" name="type" class="form-control name_list"
                                                        value="{{ $type }}" />
                                                         <input type="hidden" name="inv_id" class="form-control inv_id"
                                                        value="{{ isset($data) ? $id : '' }}" />

                                                    <div class="form-group row">
                                                    
                                                     <label class="col-lg-2 col-form-label">Check In Date <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                <input name="start_date" id="date1" type="date" class="form-control date1" onkeydown="return false" required value="<?php echo date('Y-m-d'); ?>" required>
                                                        </div>

                                                        <label class="col-lg-2 col-form-label">Client Name <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                                <select class="form-control m-b client_id"
                                                                    name="client_id" id="client_id" required>
                                                                    <option value="">Select Client Name</option>
                                                                    @if (!empty($client))
                                                                        @foreach ($client as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->client_id == $row->id ? 'selected' : '' }} @endif
                                                                                value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif

                                                                </select>
                                                        </div>
                                                        
                                                        
                                                
                                                        </div>

                                                 
                                                    

                                                    <div class="form-group row">
                                                    
                                                    <label class="col-lg-2 col-form-label">Property <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                   
                    <select name="hotel_id" class="form-control m-b location" id="location_id" required>
                        <option value="">Select Property</option>
                        @if(!empty($location))
                       
                        @foreach($location as $br)
                        <option value="{{$br->id}}" @if(isset($data)){{  $data->hotel_id == $br->id  ? 'selected' : ''}} @endif>{{$br->name}}</option>
                        @endforeach
                      
                        @endif
                    </select>
                    
                </div>

                                                        
                                                        
                                                        <label class="col-lg-2 col-form-label">Branch</label>
                                                            <div class="form-group col-md-4">
                                                                <select class="form-control m-b" name="branch_id">
                                                                    <option>Select Branch</option>
                                                                    @if (!empty($branch))
                                                                        @foreach ($branch as $row)
                                                                            <option value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                    </div>
                                                    
                                                    <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Sales Agent <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            @if (!empty($data->user_agent))

                                                                <select class="form-control m-b" name="user_agent"
                                                                    id="user_agent" required>
                                                                    <option value="{{ old('user_agent') }}" disabled
                                                                        selected>Select User</option>
                                                                    @if (isset($user))
                                                                        @foreach ($user as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->user_agent == $row->id ? 'selected' : 'TZS' }} @endif
                                                                                value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            @else
                                                                <select class="form-control m-b" name="user_agent"
                                                                    id="user_agent" required>
                                                                    <option value="{{ old('user_agent') }}" disabled
                                                                        selected>Select User</option>
                                                                    @if (isset($user))
                                                                        @foreach ($user as $row)
                                                                            @if ($row->id == auth()->user()->id)
                                                                                <option value="{{ $row->id }}"
                                                                                    selected>{{ $row->name }}</option>
                                                                            @else
                                                                                <option value="{{ $row->id }}">
                                                                                    {{ $row->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>


                                                            @endif
                                                        </div>
                                                        <label class="col-lg-2 col-form-label" for="gender">Sales Type <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <select class="form-control m-b sales" name="sales_type"
                                                                id="sales" required>
                                                                <option value="">Select Sales Type</option>
                                                                <option value="Cash Sales"
                                                                    @if (isset($data)) {{ $data->sales_type == 'Cash Sales' ? 'selected' : '' }} @endif>
                                                                    Cash Sales</option>
                                                                <option value="Credit Sales"
                                                                    @if (isset($data)) {{ $data->sales_type == 'Credit Sales' ? 'selected' : '' }} @endif>
                                                                    Credit Sales</option>
                                                            </select>
                                                           
                                                           
                                                        </div>
                                                        </div>
                                                        
                                                        
                                                            <div class="form-group row">
                                                        @if (!empty($data->bank_id))
                                                            <label for="stall_no" class="col-lg-2 col-form-label bank1"
                                                                style="display:block;">Bank/Cash Account <span class="required"> * </span></label>
                                                            <div class="col-lg-4 bank2" style="display:block;">
                                                                <select class="form-control m-b" name="bank_id" id="bank_id">
                                                                    <option value="">Select Payment Account</option>
                                                                    @foreach ($bank_accounts as $bank)
                                                                        <option value="{{ $bank->id }}"
                                                                            @if (isset($data)) @if ($data->bank_id == $bank->id) selected @endif
                                                                            @endif
                                                                            >{{ $bank->account_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @else
                                                            <label for="stall_no" class="col-lg-2 col-form-label bank1"
                                                                style="display:none;">Bank/Cash Account <span class="required"> * </span></label>
                                                            <div class="col-lg-4 bank2" style="display:none;">
                                                                <select class="form-control m-b" name="bank_id" id="bank_id">
                                                                    <option value="">Select Payment Account</option>
                                                                    @foreach ($bank_accounts as $bank)
                                                                        <option value="{{ $bank->id }}"
                                                                            @if (isset($data)) @if ($data->bank_id == $bank->id) selected @endif
                                                                            @endif
                                                                            >{{ $bank->account_name }}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        @endif
                                                        
                                                         
                                                    </div>


                                                    


                                                    <br>
                                                    <h4 align="center">Enter Item Details</h4>
                                                    <hr>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Currency <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                         @php $def=App\Models\System::where('added_by',auth()->user()->added_by)->first(); @endphp
                                                            @if (!empty($data->exchange_code))

                                                                <select class="form-control m-b" name="exchange_code"
                                                                    id="currency_code" required>
                                                                    <option value="{{ old('currency_code') }}" disabled
                                                                        selected>Choose option</option>
                                                                    @if (isset($currency))
                                                                        @foreach ($currency as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->exchange_code == $row->code ? 'selected' : 'TZS' }} @endif
                                                                                value="{{ $row->code }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            @else
                                                                <select class="form-control m-b" name="exchange_code"
                                                                    id="currency_code" required>
                                                                    <option value="{{ old('currency_code') }}" disabled>
                                                                        Choose option</option>
                                                                    @if (isset($currency))
                                                                        @foreach ($currency as $row)
                                                                            @if ($row->code == $def->currency)
                                                                                <option value="{{ $row->code }}"
                                                                                    selected>{{ $row->name }}</option>
                                                                            @else
                                                                                <option value="{{ $row->code }}">
                                                                                    {{ $row->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>


                                                            @endif
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Exchange Rate <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <input type="number" name="exchange_rate"
                                                                placeholder="1 if TZSH"
                                                                value="{{ isset($data) ? $data->exchange_rate : '1.00' }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <button type="button" name="add"
                                                        class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add Rooms</i></button><br>
                                                    <br>
                                                    
                                                     <div class=""> <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p>   </div>
                                                      
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                            <thead>
                                                                <tr>
                                                                    <th>Check Out Date <span class="required"> * </span></th>
                                                                    <th>Room Type<span class="required"> * </span></th>
                                                                    <th>Room Name <span class="required"> * </span></th>
                                                                    <th>Checkout time </th>
                                                                    <th>Price <span class="required"> * </span></th>
                                                                    <th>Total <span class="required"> * </span></th>
                                                                    <th>Action </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                            </tbody>
                                                            <tfoot>
                                                                @if (!empty($id))
                                                                    @if (!empty($items))
                                                                        @foreach ($items as $i)
                                                                            <tr class="line_items">
                                                                                <td>
                                                                                    <div class="input-group mb-3"><select
                                                                                            name="item_name[]"
                                                                                            class="form-control  m-b item_name"
                                                                                            required
                                                                                            data-sub_category_id="{{ $i->id }}_edit">
                                                                                            <option value="">Select
                                                                                                Item</option>
                                                                                            @foreach ($name as $n)
                                                                                                <option
                                                                                                    value="{{ $n->id }}"
                                                                                                    @if (isset($i)) @if ($n->id == $i->item_name)
                                        selected @endif
                                                                                                    @endif
                                                                                                    >{{ $n->name }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select></div>
                                                                                    <textarea name="description[]" class="form-control desc" placeholder="Description" cols="30">{{ isset($i) ? $i->description : '' }}</textarea>
                                                                                </td>
                                                                                <td><input type="number"
                                                                                        name="quantity[]"
                                                                                        class="form-control item_quantity"
                                                                                        data-category_id="{{ $i->id }}_edit"
                                                                                        placeholder="quantity"
                                                                                        id="quantity"
                                                                                        value="{{ isset($i) ? $i->due_quantity : '' }}"
                                                                                        required />
                                                                                    <div class="">
                                                                                        <p class="form-control-static errors{{ $i->id }}_edit"
                                                                                            id="errors"
                                                                                            style="text-align:center;color:red;">
                                                                                        </p>
                                                                                    </div>
                                                                                </td>
                                                                                <td><input type="text" name="price[]"
                                                                                        class="form-control item_price{{ $i->id }}_edit"
                                                                                        placeholder="price" required
                                                                                        value="{{ isset($i) ? $i->price : '' }}" />
                                                                                </td>
                                                                                <input type="hidden" name="unit[]"
                                                                                    class="form-control item_unit{{ $i->id }}_edit"
                                                                                    placeholder="unit" required
                                                                                    value="{{ isset($i) ? $i->unit : '' }}" />
                                                                                <input type="hidden" name="tax_rate[]"
                                                                                    class="form-control item_tax{{ $i->id }}_edit"
                                                                                    value="{{ isset($i) ? $i->tax_rate : '' }}"
                                                                                    required>
                                                                                <td><input type="text"
                                                                                        name="total_tax[]"
                                                                                        class="form-control item_total_tax{{ $i->id }}_edit"
                                                                                        placeholder="total" required
                                                                                        value="{{ isset($i) ? $i->total_tax : '' }}"
                                                                                        readonly
                                                                                        jAutoCalc="{quantity} * {price} * {tax_rate}" />
                                                                                </td>
                                                                                <input type="hidden"
                                                                                    name="saved_items_id[]"
                                                                                    class="form-control item_saved{{ $i->id }}_edit"
                                                                                    value="{{ isset($i) ? $i->id : '' }}"
                                                                                    required />
                                                                                <td><input type="text"
                                                                                        name="total_cost[]"
                                                                                        class="form-control item_total{{ $i->id }}_edit"
                                                                                        placeholder="total" required
                                                                                        value="{{ isset($i) ? $i->total_cost : '' }}"
                                                                                        readonly
                                                                                        jAutoCalc="{quantity} * {price}" />
                                                                                </td>
                                                                                <input type="hidden" id="item_id"
                                                                                    class="form-control item_id{{ $i->id }}_edit"
                                                                                    value="{{ $i->items_id }}" />
                                                                                <input type="hidden" name="items_id[]"
                                                                                    class="form-control name_list"
                                                                                    value="{{ isset($i) ? $i->id : '' }}" />
                                                                                <td><button type="button" name="remove"
                                                                                        class="btn btn-danger btn-xs rem"
                                                                                        value="{{ isset($i) ? $i->id : '' }}"><i
                                                                                            class="icon-trash"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                @endif


                                                                <tr class="line_items">
                                                                    <td colspan="4"></td>
                                                                    <td><span class="bold">Total </span>: </td>
                                                                    <td><input type="text" name="subtotal[]"
                                                                            class="form-control total"
                                                                            value="{{ isset($data) ? '' : '0.00' }}"
                                                                            required jAutoCalc="SUM({total_cost})"
                                                                            readonly></td>
                                                                </tr>
                                                              
                                                               
                                                              
                                                            </tfoot>
                                                        </table>
                                                    </div>


                                                    <br>
                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))

                                                                <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                    href="{{ route('booking.index') }}">
                                                                    Cancel
                                                                </a>
                                                                
                                                            @else
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            order: [
                [2, 'desc']
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": [3]
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
    
    $(document).ready(function() { //DISABLED PAST DATES IN APPOINTMENT DATE
  var dateToday = new Date();
  var month = dateToday.getMonth() + 1;
  var day = dateToday.getDate();
  var year = dateToday.getFullYear();

  if (month < 10)
    month = '0' + month.toString();
  if (day < 10)
    day = '0' + day.toString();

  var maxDate = year + '-' + month + '-' + day;

  $('#date1').attr('min', maxDate);
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
                
                html +='<td class="rdate_' +count + '"><input type="date" name="end_date[]" class="form-control date2" id="date2_' +count + '" data-category_id="' +count +'" onkeydown="return false"/></td>';
                html +='<td class="rtype_' +count + '"><select name="room_type[]" class="form-control m-b item_type" data-sub_category_id="' +count +'" required><option value="">Select Type</option></select></td>';
                html += '<td class="rname_' +count + '"><select name="room_name[]" class="form-control m-b item_name"   data-sub_category_id="' +count + '"  required><option value="">Select Room</option></select></div></td>';
                html += '<td><input name="checkout_time[]" type="time" class="form-control time' + count +'"  value=""/></td>';
                html += '<td class="rtotal_' +count + '"><input type="text" name="price[]" class="form-control item_total" data-category_id="' +count +'" required  /></td>';
                 html += '<input type="hidden" name="nights[]" class="form-control item_nights' +count +'" placeholder ="total"   required /></td>';
                html += '<td><input type="text" name="total_cost[]" class="form-control item_price' +count +'" placeholder ="total"  jAutoCalc="{price} * {nights}"  readonly required /></td>';
                
                html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

                $('#cart > tbody').append(html);
                autoCalcSetup();
                
                
                /*
                 * Multiple drop down select
                 */
                $('.m-b').select2({});
                
                
 var dateToday = new Date();
  var month = dateToday.getMonth() + 1;
  var day = dateToday.getDate();
  var year = dateToday.getFullYear();

  if (month < 10)
    month = '0' + month.toString();
  if (day < 10)
    day = '0' + day.toString();

  var maxDate = year + '-' + month + '-' + day;

  $('#date2_'+count).attr('min', maxDate);

 



            });

          

            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
                autoCalcSetup();
            });


            $(document).on('click', '.rem', function() {
                var btn_value = $(this).attr("value");
                $(this).closest('tr').remove();
                $('#cart > tfoot').append(
                    '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                    btn_value + '"/>');
                autoCalcSetup();
            });

        });
    </script>
    
    
    
   
       <script>
$(document).ready(function() {
    
    $(document).on('change', '.date1', function() {
     $(".date2").change();

    });
    
    $(document).on('change', '.location', function() {
     $(".date2").change();

    });
    
    $(document).on('change', '.date2', function() {
        var id = $(this).val();
        var location= $('.location').val();
         var date= $('.date1').val();
          var sub_category_id = $(this).data('category_id');
          console.log(id);
        $.ajax({
            url: '{{url("hotel/showType")}}',
            type: "GET",
            data: {
                id: id,
                 location: location,
                 date:date,
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                
            var s = new Date(date);
            var e = new Date(id);
            var timeDiff = Math.abs(e.getTime() - s.getTime());
            var nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
            
                
                $('.item_nights' + sub_category_id).empty();
                $('.item_nights' + sub_category_id).val(nights);
                
                 $(".item_total").change();
               $('.rtype_'+sub_category_id).find('.item_type').empty();
               $('.rname_'+sub_category_id).find('.item_name').empty();
                $('.rname_'+sub_category_id).find('.item_name').append('<option value="">Select Room Name</option>');
               $('.rtotal_'+sub_category_id).find('.item_total').val(0);
                $('.item_price' + sub_category_id).val(0);
                $('.rtype_'+sub_category_id).find('.item_type').append('<option value="">Select Room Type</option>');
                $.each(data,function(key, value)
                {

           $('.rtype_'+sub_category_id).find('.item_type').append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                   
                });              
               
            }

        });

    });
    
    
    
    $(document).on('change', '.item_type', function() {
        var id = $(this).val();
         var sub_category_id = $(this).data('sub_category_id');
        var location= $('.location').val();
         var sdate= $('.date1').val();
         var edate= $('.rdate_'+sub_category_id).find('.date2').val();
         
          console.log(sub_category_id);
        $.ajax({
            url: '{{url("hotel/showName")}}',
            type: "GET",
            data: {
                id: id,
                 location: location,
                 sdate:sdate,
                 edate:edate,
            },
            dataType: "json",
            success: function(data) {
                console.log(data);

                  $(".item_total").change();
                  
               $('.rname_'+sub_category_id).find('.item_name').empty();
               $('.rtotal_'+sub_category_id).find('.item_total').val(0);
                $('.item_price' + sub_category_id).val(0);
                $('.rname_'+sub_category_id).find('.item_name').append('<option value="">Select Room Name</option>');
                $.each(data,function(key, value)
                {

           $('.rname_'+sub_category_id).find('.item_name').append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                   
                });              
               
            }

        });

    });
     
    
    $(document).on('change', '.item_name', function() {
            var id = $(this).val();
           
            var sub_category_id = $(this).data('sub_category_id');
             console.log(sub_category_id);
            $.ajax({
            url: '{{url("hotel/findPrice")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('.rtotal_'+sub_category_id).find('.item_total').val(data[0]["price"]);
                $('.item_price' + sub_category_id).val(data[0]["price"]);
            }

        });

    });


    
   
   
   
}); 
    </script>
    

<script>
    $(document).ready(function() {
    
      
         $(document).on('click', '.save', function(event) {
   
         $('.errors').empty();
        
          if ( $('#cart tbody tr').length == 0 ) {
               event.preventDefault(); 
    $('.errors').append('Please Select Rooms.');
}
         
         else{
            
         
          
         }
        
    });
    
    
    
    });
    </script>
 


    <script type="text/javascript">
        function model(id, type) {


            $.ajax({
                type: 'GET',
                url: '{{ url('hotel/discountModal') }}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('#appFormModal > .modal-dialog').html(data);
                    
                },
                error: function(error) {
                    $('#appFormModal').modal('toggle');

                }
            });

        }

        function saveClient(e) {

            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/save_client') }}',
                data: $('#addClientForm').serialize(),
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    var id = response.id;
                    var name = response.name;

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";

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


                if (id == 'Cash Sales') {
                    $('.bank1').show();
                    $('.bank2').show();
                    $("#bank_id").prop('required',true);

                } else {
                    $('.bank1').hide();
                    $('.bank2').hide();
                     $("#bank_id").prop('required',false);

                }

            });



        });
    </script>
    
    
    
    <script type="text/javascript">
       


        function saveClient(e) {

            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/save_client') }}',
                data: $('.addClientForm').serialize(),
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    var id = response.id;
                    var name = response.name;

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";

                    $('#client_id').append(option);
                    $('#appFormModal').hide();



                }
            });
        }
        
        
    </script>
    
         

@endsection
