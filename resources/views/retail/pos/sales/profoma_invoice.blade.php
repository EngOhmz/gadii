@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Proforma Invoice </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id) &&empty($serial)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true"> Proforma Invoice
                                     List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Proforma Invoice</a>
                            </li>
                   
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id) &&empty($serial)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                  <table class="table datatable-basic table-striped">
                                        <thead>
                                             <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Ref No</th>
                                          
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
                                                   @if($row->type == 'Batch')
                                                    <a class="nav-link" id="profile-tab2"
                                                            href="{{ route('retail_proforma_invoice.show',$row->id)}}" role="tab"
                                                            aria-selected="false">{{$row->reference_no}}</a>
                                                       @else
                                                    <a class="nav-link" id="profile-tab2"
                                                            href="{{ route('retail_serial_invoice.show',$row->id)}}" role="tab"
                                                            aria-selected="false">{{$row->reference_no}}</a>
                                                    @endif
                                                    
                                                </td>
                                            
                                                <td>
                                                      {{$row->client->name }}
                                                </td>
                                                
                                                <td>{{$row->invoice_date}}</td>

                                                <td>{{number_format($row->due_amount,2)}} {{$row->exchange_code}}</td>
                                                <td>{{$row->store->name}}</td>
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
                                                    
                                                    @elseif($row->status == 5)
                                                    <span class="badge badge-info badge-shadow">Received</span>
                                                    
                                                    @elseif($row->status == 6)
                                                    <span class="badge badge-success badge-shadow">Scanned</span>
                                                    
                                                    @elseif($row->status == 7)
                                                    <span class="badge badge-success badge-shadow">Paid</span>

                                                    @endif
                                                </td>
                                               
                                               
                                                <td>
                                       
                                            <div class="form-inline">
                                                   @if($row->invoice_status == 0)
                                                    <a class="list-icons-item text-primary"
                                                        title="Edit" onclick="return confirm('Are you sure?')"
                                                        href="{{ route('retail_proforma_invoice.edit', $row->id)}}"><i
                                                            class="icon-pencil7"></i></a>&nbsp
                                                          

                                                    {!! Form::open(['route' => ['retail_proforma_invoice.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                 {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit','style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
                                 &nbsp

                                                <div class="dropdown">
							                		<a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

													<div class="dropdown-menu">
                                                            
                                                       <a  class="nav-link" onclick="return confirm('Are you sure?')"   href="{{ route('retail_invoice.convert_to_invoice', $row->id)}}"  title="" > Convert To Invoice </a>   

                                                              <a class="nav-link" title="PDF"
                                                                   href="{{ route('retail_proforma_invoice_pdfview',['download'=>'pdf','id'=>$row->id]) }}">Download PDF</a>

                                                        
													</div>
					                			</div>
                                                   
                                                </div>

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
                                        <h5>Create Proforma Invoice</h5>
                                        @else
                                        <h5>Edit Proforma Invoice</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('retail_proforma_invoice.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data")) }}
                                              
                                                @else
                                                   {!! Form::open(array('route' => 'retail_proforma_invoice.store',"enctype"=>"multipart/form-data")) !!}
                                                @method('POST')
                                                @endif


                                                <input type="hidden" name="item_type"
                                                class="form-control name_list"
                                                value="{{$item_type}}" />

                                                <div class="form-group row">
                                                 
                                                    <label class="col-lg-2 col-form-label">Client Name</label>
                                                    <div class="col-lg-4">
                                                        <div class="input-group">
                                                            <select class="form-control m-b" name="client_id" required
                                                                id="client_id">
                                                                <option value="">Select Client Name</option>
                                                                @if(!empty($client))
                                                                @foreach($client as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->client_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary" type="button"
                                                                    data-toggle="modal" value=""
                                                                    data-target="#clientFormModal"  href="clientFormModal"><i class="icon-plus-circle2"></i></button>
                                                            </div>
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
                                                    <label class="col-lg-2 col-form-label">Region</label>
                                                    <div class="col-lg-4">

                                                          <select class="form-control m-b" name="region"  id="region" required >                                                       
                                                        <option value="">Select Region</option>
                                                        @if(!empty($region))
                                                        @foreach($region as $r)

                                                        <option @if(isset($data))
                                                            {{  $data->region == $r->id  ? 'selected' : ''}}
                                                            @endif value="{{ $r->id}}">{{$r->name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                    </div>
                                                

<label class="col-lg-2 col-form-label">Notes</label>
                                                    <div class="col-lg-4">
                   <textarea class="form-control" name="notes">{{isset($data)? $data->notes : ''}}</textarea>
                    
                  </div>
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
                                                        <th>List</th>
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
                                                            <td><select name="type[]"
                                                                    class="form-control  m-b item_name" required
                                                                    data-sub_category_id="{{$i->order_no}}_e">
                                                                    <option value="">Select Item</option>@foreach($name
                                                                    as $n) <option value="{{ $n->id}}"
                                                                        @if(isset($i))@if($n->id == $i->type)
                                                                        selected @endif @endif >{{$n->name}}</option>
                                                                    @endforeach
                                                                </select></td>
                                                            <td>

                                                             <?php
                                                              if($i->category == 'Batch'){
                                                               $date = today()->format('Y-m-d');                                                               
           $batch_list=App\Models\Retail\PurchaseHistory::where('item_id',$i->type)->where('due_quantity','>','0')->where('expire_date', '>', $date)->where('added_by',auth()->user()->added_by)->orderBy('expire_date', 'ASC')->get();
                                                              $max=App\Models\Retail\PurchaseHistory::where('id', $i->purchase_history)->first();  
                                                              $due=$max->due_quantity;
                                                               }

                                                      else if($i->category == 'Serial'){
                                                            $batch_list=App\Models\Retail\PurchaseSerialList::where('status',0)->where('added_by',auth()->user()->added_by)->get();  
                                                              $due=1; 
                                                            }
                                                              ?>

                                                        <select name="item_name[]" class="form-control m-b item_batch_number{{$i->order_no}}_e"  id="batch"  "
                                                                    data-sub_category_id="{{$i->order_no}}_e" required>
                                                                    <option value="">Select List</option>@foreach($batch_list
                                                                    as $b) <option value="{{ $b->id}}"
                                                                        @if(isset($i))@if($b->id== $i->item_name)
                                                                        selected @endif @endif >{{$b->serial_no}}</option>
                                                                    @endforeach
                                                                </select>
                                                               </td>

                                                      
                                                              
                                                                       
                                                            <td>
                                                                    @if($i->category == 'Serial')
                                                                   <input type="number" name="quantity[]"
                                                                    class="form-control item_quantity{{$i->order_no}}_e"
                                                                    placeholder="quantity" id="quantity"  min="1" max="{{$due}}"
                                                                    value="{{ isset($i) ? $i->quantity : ''}}"
                                                                    required  readonly/>  
                                                                        @else
                                                                        <input type="number" name="quantity[]"
                                                                    class="form-control item_quantity{{$i->order_no}}_e"
                                                                    placeholder="quantity" id="quantity"  min="1" max="{{$due}}"
                                                                    value="{{ isset($i) ? $i->quantity : ''}}"
                                                                    required /> 
                                                                           @endif
                                                                                 </td>       
                                                            <td><input type="text" name="price[]"
                                                                    class="form-control item_price{{$i->order_no}}_e"
                                                                    placeholder="price" required
                                                                    value="{{ isset($i) ? $i->price : ''}}" /></td>
                                                            <td><select name="tax_rate[]"
                                                                    class="form-control  m-b item_tax'+count{{$i->order_no}}_e"
                                                                    required>
                                                                    <option value="0">Select Tax Rate</option>
                                                                    <option value="0" @if(isset($i))@if('0'==$i->
                                                                        tax_rate) selected @endif @endif>No tax</option>
                                                                    <option value="0.18" @if(isset($i))@if('0.18'==$i->
                                                                        tax_rate) selected @endif @endif>18%</option>
                                                                </select></td>
                                                              <input type="hidden" name="category[]" class="form-control category{{$i->order_no}}_e" placeholder ="total"  value= "{{$i->category}}" required    />
                                                            <input type="hidden"  class="form-control batch_no{{$i->order_no}}_e" placeholder ="total"  value= "{{$i->item_name}}"" required    />
                                                            <input type="hidden" name="total_tax[]"
                                                                class="form-control item_total_tax{{$i->order_no}}_e"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_tax : ''}}" readonly
                                                                jAutoCalc="{quantity} * {price} * {tax_rate}" />
                                                            <input type="hidden" name="saved_items_id[]"
                                                                class="form-control item_saved{{$i->order_no}}_e"
                                                                value="{{ isset($i) ? $i->id : ''}}"
                                                                required />
                                                            <td><input type="text" name="total_cost[]"
                                                                    class="form-control item_total{{$i->order_no}}_e"
                                                                    placeholder="total" required
                                                                    value="{{ isset($i) ? $i->total_cost : ''}}"
                                                                    readonly jAutoCalc="{quantity} * {price}" /></td>
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
                                                            <td><span class="bold">Shipping Cost</span>: </td>
                                                            <td><input type="text" name="shipping_cost[]"    value="{{ isset($data) ? $data->shipping_cost : '0'}}"
                                                                    class="form-control item_total" placeholder="shipping_cost"
                                                                    required>
                                                            </td>
                                                        </tr>
                                                        @if(!@empty($data->discount > 0))
                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <td><span class="bold">Discount</span>: </td>
                                                            <td><input type="text" name="discount[]"
                                                                    class="form-control item_discount"
                                                                    placeholder="total" required
                                                                    value="{{ isset($data) ? $data->discount : ''}}"
                                                                    readonly></td>
                                                        </tr>
                                                        @endif
                                                      
                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            @if(!@empty($data->discount > 0))
                                                            <td><span class="bold">Total</span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total" placeholder="total"
                                                                    required jAutoCalc="{subtotal} + {tax} + {shipping_cost} - {discount}"
                                                                    readonly></td>
                                                            @else
                                                            <td><span class="bold">Total</span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total" placeholder="total"
                                                                    required jAutoCalc="{subtotal} + {tax} + {shipping_cost} " readonly>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>


                                                <br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="{{ route('retail_proforma_invoice.index')}}">
                                                            Cancel
                                                        </a> 
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit"  id="save">Save</button>
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
<div class="modal fade" id="clientFormModal" tabindex="-1" role="dialog" aria-hidden="true">
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

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        
    </div>
</div>


@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
             order: [[3, 'desc']],
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
            url: '{{url("pos/retail_sales/retail_findInvPrice")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('.item_price' + sub_category_id).val(data[0]["sales_price"]);
                $(".item_unit" + sub_category_id).val(data[0]["unit"]);
                $(".category" + sub_category_id).val(data[0]["category"]);

           if(data[0]["category"] == 'Serial'){
          $(".item_quantity" + sub_category_id).val(1);
        $(".item_quantity" + sub_category_id).attr("readonly", true);
         }

     else{
  $(".item_quantity" + sub_category_id).attr("readonly",false);
   $(".item_quantity" + sub_category_id).val('');
}      
            }

        });

    });

});
</script>


<script>
$(document).ready(function() {
    $(document).on('change', '.item_name', function() {
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
      var item= $('.category' + sub_category_id).val();
        var location= $('.location').val();
        $.ajax({
            url: '{{url("pos/retail_sales/findBatch")}}',
            type: "GET",
            data: {
               id: id,
           location: location,
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
              
                 $(".item_batch_number" +sub_category_id).empty();
                 $(".item_batch_number" +sub_category_id).append('<option value="">Select List</option>');
                $.each(data,function(key, value)
                {
                   
                  
           $(".item_batch_number" +sub_category_id).append('<option value=' + value.id+ '>' + value.serial_no + '</option>');
                   
                   
                });              
               
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
            '<td><select name="type[]" class="form-control  m-b item_name" required  data-sub_category_id="' +
            count +
            '"><option value="">Select Item Name</option>@foreach($name as $n) <option value="{{ $n->id}}">{{$n->name}}</option>@endforeach</select></td>';
       html +=  '<td><select name="item_name[]" class="form-control m-b item_batch_number' + count +'"  id="batch"  data-sub_category_id="' +count + '" required ><option value="">Select List</option></td>';
        html +=
            '<td><input type="number" name="quantity[]"  class="form-control item_quantity' + count +'"   placeholder ="quantity" min=1" max="1" required /> <div class=""> </td>';
        html += '<td><input type="text" name="price[]" class="form-control item_price' + count +'" placeholder ="price" required  value=""/></td>';
        html += '<td><select name="tax_rate[]" class="form-control  m-b item_tax' + count +
            '" required ><option value="0">Select Tax Rate</option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
        html += '<input type="hidden" name="category[]" class="form-control category' +count +'" placeholder ="total"  value= "" required    />';
         html += '<input type="hidden"  class="form-control batch_no' + count +'" placeholder ="total"  value= "" required    />';
        html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax' + count +
            '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   />';
          
        html += '<td><input type="text" name="total_cost[]" class="form-control item_total' + count +
            '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';
        html +='</tr>';    
            

         $('#cart >tbody').append(html);
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
        $('#cart >tfoot').append(
            '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
            btn_value + '"/>');
        autoCalcSetup();
    });

});
</script>

<script>
$(document).ready(function() {

$(document).on('change', '#batch', function() {
  var sub_category_id = $(this).data('sub_category_id');;   
  var item= $('.category' + sub_category_id).val();
var id = $(this).val();   
console.log(item);
$('.batch_no'+sub_category_id).val(id);;           
  
$.ajax({
            url: '{{url("pos/retail_sales/retail_findQty")}}',
            type: "GET",
            data: {
                id: id,
               item: item,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
               $('.item_quantity'+sub_category_id).attr("max", data);;           
            
       
            }

        });          
       

});

});
</script>

<script>
$(document).ready(function() {

$(document).on('change', '#quantity', function() {
 var id = $(this).val();   
  var sub_category_id = $(this).data('sub_category_id');;   
  var item= $('.batch_no' + sub_category_id).val();
 console.log(sub_category_id);
  $.ajax({
            url: '{{url("pos/retail_sales/retail_findQty")}}',
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



<script type="text/javascript">
function model(id, type) {

    $.ajax({
        type: 'GET',
        url: '{{url("pos/retail_sales/retail_invModal")}}',
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
            url: '{{url("tyre/addSupp")}}',
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




<script>
$(document).ready(function() {

    $(document).on('change', '.sales', function() {
        var id = $(this).val();
  console.log(id);


 if (id == 'Cash Sales'){
     $("#bank_id").css("display", "block");   

}


else{
  $("#bank_id").css("display", "none");   

}

  });



});

</script>



@endsection