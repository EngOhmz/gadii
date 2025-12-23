@extends('layouts.master')

@push('plugin-styles')
 <style>
 .body > .line_items{
     border:1px solid #ddd;
 }

 </style>

@endpush
@section('content')

 @php $def=App\Models\System::where('added_by',auth()->user()->added_by)->first(); @endphp
 
<div id="invoice_state_report_div">    
<div id="state_report" style="display: ">


                <div class="row">

         
              <div class="col-sm-6 col-xl-4">
							<div class="card card-body">
								<div class="d-flex align-items-center">
								

									<div class="flex-fill text-center">
										<h4 class="mb-0">{{number_format($pos_invoice,2)}} {{$def->currency}}</h4>
										<span class="text-primary m0">Total Invoice Amount</span>
									</div>
								</div>
							</div>
						</div>
						
						
						  <div class="col-sm-6 col-xl-4">
							<div class="card card-body">
								<div class="d-flex align-items-center">
								

									<div class="flex-fill text-center">
										<h4 class="mb-0">{{number_format($pos_invoice - $pos_due,2)}} {{$def->currency}}</h4>
										<span class="text-success m0">Paid Invoice</span>
									</div>
								</div>
							</div>
						</div>
           
            
            <div class="col-sm-6 col-xl-4">
							<div class="card card-body">
								<div class="d-flex align-items-center">
								

									<div class="flex-fill text-center">
										<h4 class="mb-0">{{number_format($pos_due,2)}} {{$def->currency}}</h4>
										<span class="text-warning m0">Total Outstanding Invoice</span>
									</div>
								</div>
							</div>
						</div>


                          @if($total == '0')
                          
                            <div class="col-sm-6 col-xl-4">
							<div class="card card-body">
								<div class="d-flex align-items-center">
								

									<div class="flex-fill text-center">
									
									
									
									<div class="mb-3">
						                <div class="d-flex align-items-center mb-1">Unpaid 
						                 <div class="col-md-6"></div>  <div class="col-md-6"><span class="text-muted ms-auto"> 0</span></div></div>
										<div class="progress" style="height: 0.375rem;">
											<div class="progress-bar bg-danger" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
						
						
						  <div class="col-sm-6 col-xl-4">
							<div class="card card-body">
								<div class="d-flex align-items-center">
								

									<div class="flex-fill text-center">
										<div class="mb-3">
						                <div class="d-flex align-items-center mb-1">Partially Paid 
						                 <div class="col-md-4"></div>  <div class="col-md-4"><span class="text-muted ms-auto">0</span></div></div>
										<div class="progress" style="height: 0.375rem;">
											<div class="progress-bar bg-primary" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										</div>
									</div>
								</div>
							</div>
						</div>
           
            
            <div class="col-sm-6 col-xl-4">
							<div class="card card-body">
								<div class="d-flex align-items-center">
								

									<div class="flex-fill text-center">
										<div class="mb-3">
						                <div class="d-flex align-items-center mb-1">Paid  
						              <div class="col-md-6"></div>  <div class="col-md-6"><span class="text-muted ms-auto">0</span></div></div>
										<div class="progress" style="height: 0.375rem;">
											<div class="progress-bar bg-success" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
                          
                          
                          @else
                          
                            <div class="col-sm-6 col-xl-4">
							<div class="card card-body">
								<div class="d-flex align-items-center">
								

									<div class="flex-fill text-center">
									
									
									
									<div class="mb-3">
						                <div class="d-flex align-items-center mb-1">Unpaid 
						                 <div class="col-md-6"></div>  <div class="col-md-6"><span class="text-muted ms-auto"> {{$unpaid}} / {{$total}}</span></div></div>
										<div class="progress" style="height: 0.375rem;">
											<div class="progress-bar bg-danger" style="width: {{($unpaid/$total) * 100  }}%" aria-valuenow="{{($unpaid/$total) * 100  }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
						
						
						  <div class="col-sm-6 col-xl-4">
							<div class="card card-body">
								<div class="d-flex align-items-center">
								

									<div class="flex-fill text-center">
										<div class="mb-3">
						                <div class="d-flex align-items-center mb-1">Partially Paid 
						                 <div class="col-md-4"></div>  <div class="col-md-4"><span class="text-muted ms-auto">{{$part}} / {{$total}}</span></div></div>
										<div class="progress" style="height: 0.375rem;">
											<div class="progress-bar bg-primary" style="width: {{($part/$total) * 100  }}%" aria-valuenow="{{($part/$total) * 100  }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										</div>
									</div>
								</div>
							</div>
						</div>
           
            
            <div class="col-sm-6 col-xl-4">
							<div class="card card-body">
								<div class="d-flex align-items-center">
								

									<div class="flex-fill text-center">
										<div class="mb-3">
						                <div class="d-flex align-items-center mb-1">Paid  
						              <div class="col-md-6"></div>  <div class="col-md-6"><span class="text-muted ms-auto">{{$paid}} / {{$total}}</span></div></div>
										<div class="progress" style="height: 0.375rem;">
											<div class="progress-bar bg-success" style="width: {{($paid/$total) * 100  }}%" aria-valuenow="{{($paid/$total) * 100  }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
                          
                          @endif

				       	
            
            

               
            </div>
            </div>

</div>



    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Invoice </h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Invoice
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Invoice</a>
                                </li>

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
                                                        style="width: 106.484px;">Ref No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 186.484px;">Client Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 126.484px;">Invoice Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Amount</th>
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
                                                @if (!@empty($invoices))
                                                    @foreach ($invoices as $row)
                                                        @php
                                                            $rn = App\Models\ReturnInvoice::where('invoice_id', $row->id)
                                                                ->where('added_by', auth()->user()->added_by)
                                                                ->first();
                                                                
                                                        @endphp

                                                        <tr class="gradeA even" role="row">

                                                            <td>
                                                            <a href="{{ route('inventory_invoice.show', $row->id) }}">{{ $row->reference_no }}</a>
                                                            </td>
                                                            <td>
                                                                {{ $row->client->name }}
                                                            </td>

                                                            <td>{{ Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y') }}</td>

                                                            <td>{{ number_format(($row->invoice_amount + $row->invoice_tax +  $row->shipping_cost)  - $row->discount, 2) }}
                                                                {{ $row->exchange_code }}</td>
                                                            <td>
                                                                @if (!empty($row->store->name))
                                                                    {{ $row->store->name }}
                                                                @endif
                                                            </td>
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


                                                            <td>
                                                             <?php
                                                   $today = date('Y-m-d');
                                                   $next= date('Y-m-d', strtotime("+1 month", strtotime($row->created_at))) ;
                                                   ?>
                                                   
                                                    <div class="form-inline">
                                                        @if ($today < $next)
                                                        
                                                        @can('approve-inventory-edit')
                                                        @if (empty($rn))
                                                        <a class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')" href="{{ route('inventory_invoice.edit', $row->id) }}">
                                                        <i class="icon-pencil7"></i></a>&nbsp
                                                        @endif
                                                        @endcan
                                                       
                                                                
                                                        @can('delete-inventory-sales')
                                                         @if (empty($rn))
                                                        {!! Form::open(['route' => ['inventory_invoice.destroy', $row->id], 'method' => 'delete']) !!}
                                                        {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                           {{ Form::close() }}  
                                                           &nbsp
                                                           @endif
                                                            @endcan
                                                            
                                                            @endif

                                                        <div class="dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

                                                            <div class="dropdown-menu">

                                        @if ($row->status != 0 && $row->status != 4 && $row->status != 3 && $row->good_receive == 1)
                                          <li> <a class="nav-link" id="profile-tab2" href="{{ route('inventory_invoice.pay', $row->id) }}">Make Payments</a></li>
                                        @endif
                                                                            
                   
                                                                               

                            <a class="nav-link" id="profile-tab2" href="{{ route('inventory_invoice_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}">Download PDF</a>
                             <a class="nav-link" id="profile-tab2" href="{{ route('inventory_invoice_receipt', ['download' => 'pdf', 'id' => $row->id]) }}">Download Receipt</a>
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
                                                {{ Form::model($id, array('route' => array('inventory_invoice.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data", 'id' => 'invform')) }}
                                                        
                                                    @else
                                                        {!! Form::open(array('route' => 'inventory_invoice.store',"enctype"=>"multipart/form-data", 'id' => 'invform')) !!}
                                                        @method('POST')
                                                    @endif


                                                    <input type="hidden" name="edit_type" class="form-control name_list"
                                                        value="{{ $type }}" />
                                                         <input type="hidden" name="inv_id" class="form-control inv_id"
                                                        value="{{ isset($data) ? $id : '' }}" />

                                                    <div class="form-group row">

                                                        <label class="col-lg-2 col-form-label">Client Name <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <div class="input-group mb-3">
                                                    <select
                                                        class="form-control append-button-single-field client_id"
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

                                                    </select>&nbsp

                                                    <button class="btn btn-outline-secondary" type="button"
                                                        data-toggle="modal" value=""
                                                        onclick="model('1','client')"
                                                        data-target="#appFormModal" href="app2FormModal"><i
                                                            class="icon-plus-circle2"></i></button>
                                                </div>
                                            </div>
                                                        <label class="col-lg-2 col-form-label">Location <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <select class="form-control m-b location" name="location"
                                                                required id="location">
                                                                <option value="">Select Location</option>
                                                                @if (!empty($location))
                                                                    @foreach ($location as $loc)
                                                                        <option
                                                                            @if (isset($data)) {{ $data->location == $loc->id ? 'selected' : '' }} @endif
                                                                            value="{{ $loc->id }}">
                                                                            {{ $loc->name }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Invoice Date <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <input type="date" name="invoice_date"
                                                                placeholder="0 if does not exist"
                                                                value="{{ isset($data) ? $data->invoice_date : date('Y-m-d') }}"
                                                                class="form-control">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Due Date <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <input type="date" name="due_date"
                                                                placeholder="0 if does not exist"
                                                                value="{{ isset($data) ? $data->due_date : strftime(date('Y-m-d', strtotime('+10 days'))) }}"
                                                                class="form-control">
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
                                                    
                                                     <div class="form-group row">
                                                     <label class="col-lg-2 col-form-label">Notes</label>

                                                        <div class="col-lg-10">
                                                    <textarea name="notes" class="form-control" rows="4">{{ isset($data) ? $data->notes : '' }}</textarea>
                                                        </div>
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
                                                    
                                                   <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add Item </i></button><br>
                                                    <br>
                                                    
                                                    <div class=""> <p class="form-control-static save_errors" id="errors" style="text-align:center;color:red;"></p>   </div>
                                                    
                                                   
                                                     <div class="row">
                                                    <div class="table-responsive">
                                                     
                                                     
                                                   
                                                    <div id="cart">
                                                    <div class="row body">
                                                     
                                                    </div></div>
                                                    
                                                    <br>
                                                     <div  id="cart1">
                                                     
                                                     <div class="row body1">
                                                      <div class="table-responsive">
                                                      
                                                     <br><table class="table" id="table1">
                                                     <thead style="display: @if(!empty($items))  @else none @endif ;">
                                                    <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Total Cost</th>
                                                     <th scope="col">Tax Rate</th>
                                                    <th scope="col">Total Tax</th>
                                                     <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                     <tbody>
                                                     @if (!empty($id))
                                                    @if (!empty($items))
                                                    @foreach ($items as $i)
                                                    
                                                    @php
                                                     $it=App\Models\InventoryList::where('id',$i->item_name)->first();
                                                      $og=App\Models\Inventory::where('id',$it->brand_id)->first();
                                                        $a =  $og->name.' - '.$it->serial_no; 
                                                            
                                                      if($i->tax_rate == '0'){
                                                          $r='0%';
                                                      }
                                                     else if($i->tax_rate == '0.18'){
                                                          $r='18%';
                                                      }   
                                                    @endphp
                                                    
                                                    <tr class="trlst{{$i->id}}_edit">
                                                      <td>{{$a}}</td>
                                                      <td>{{ isset($i) ? number_format($i->price,2) : '' }}</td>
                                                      <td>{{ isset($i) ? number_format($i->total_cost,2) : '' }}</td>
                                                       <td>{{$r}}</td>
                                                      <td>{{ isset($i) ? number_format($i->total_tax,2) : '' }}</td>
  <td>
<a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="{{$i->id}}_edit"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp;&nbsp;
<a class="list-icons-item text-danger rem" title="Delete" href="javascript:void(0)" data-button_id="{{$i->id}}_edit" value="{{$i->id}}"><i class="icon-trash" style="font-size:18px;"></i></a>
</td>
                                                    </tr>
                                                     
                                                     
                                                     @endforeach
                                                    @endif
                                                    @endif
                                                      </tbody>
                                                     </table>
                                                     
                                                     @if (!empty($id))
                                                    @if (!empty($items))
                                                    @foreach ($items as $i)
                                                    
                                                    <div class="line_items" id="lst{{$i->id}}_edit">
  <input type="hidden" name="item_name[]" class="form-control item_name" id="name lst{{$i->id}}_edit" value="{{ isset($i) ? $i->item_name : '' }}" required="">
  <input type="hidden" name="description[]" class="form-control item_desc" id="desc lst{{$i->id}}_edit" value="{{ isset($i) ? $i->description : '' }}">
  <input type="hidden" name="quantity[]" class="form-control item_qty" id="qty lst{{$i->id}}_edit" value="{{ isset($i) ? $i->quantity : '' }}" required="">
  <input type="hidden" name="price[]" class="form-control item_price" id="price lst{{$i->id}}_edit" value="{{ isset($i) ? $i->price : '' }}" required="">
  <input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst{{$i->id}}_edit" value="{{ isset($i) ? $i->tax_rate : '' }}" required="">
  <input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst{{$i->id}}_edit" value="{{ isset($i) ? $i->total_cost : '' }}" required="">
  <input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst{{$i->id}}_edit" value="{{ isset($i) ? $i->total_tax : '' }}" required="">
  <input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst{{$i->id}}_edit" value="{{ isset($i) ? $i->unit : '' }}">
  <input type="hidden" name="type" class="form-control item_type" id="type lst{{$i->id}}_edit" value="edit">
  <input type="hidden" name="loc" class="form-control item_loc" id="loc lst{{$i->id}}_edit"  value="{{ isset($data) ? $data->location : '' }}"  />
  <input type="hidden" name="no[]" class="form-control item_type" id="no lst{{$i->id}}_edit" value="{{$i->id}}_edit">
  <input type="hidden" name="saved_items_id[]" class="form-control item_savedlst{{$i->id}}_edit" value="{{$i->id}}">
  <input type="hidden" id="item_id" class="form-control item_idlst{{$i->id}}_edit" value="{{ isset($i) ? $i->item_name : '' }}">
</div>
                                                     @endforeach
                                                    @endif
                                                    @endif
                                                     
                                                     
                                                     
                                                    </div></div>
                                                    
                                                    <br><br>
                                                     
                                                       <div class="row body2">
                                                     
                                                     <div class="col-lg-1"></div>
                                                    <label class="col-lg-2 col-form-label"><span class="bold">Sub Total (+)</span>:</label>
                                                    <div class="col-lg-6 line-items">
                                                     <input type="text" name="subtotal[]" class="form-control item_total" value="{{ isset($data) ? '' : '0.00' }}"
                                                    required jAutoCalc="SUM({total_cost})" readonly><br>
                                                        </div> 
                                                         <div class="col-lg-3"></div>
                                                         
                                                   <div class="col-lg-1"></div>
                                                    <label class="col-lg-2 col-form-label"><span class="bold">Tax (+)</span>:</label>
                                                    <div class="col-lg-6 line-items">
                                                   <input type="text" name="tax[]" class="form-control item_total" value="{{ isset($data) ? '' : '0.00' }}"
                                                    required jAutoCalc="SUM({total_tax})" readonly><br>
                                                        </div> 
                                                         <div class="col-lg-3"></div>
                                                         
                                                    <div class="col-lg-1"></div>
                                                    <label class="col-lg-2 col-form-label"><span class="bold">Shipping Cost (+)</span>:</label>
                                                    <div class="col-lg-6 line-items">
                                                    <input type="text" name="shipping_cost[]" min="0" class="form-control item_shipping" required
                                                     value="{{ isset($data) ? $data->shipping_cost : '0.00' }}"><br>
                                                        </div> 
                                                         <div class="col-lg-3"></div>
                                                         
                                                    <div class="col-lg-1"></div>
                                                    <label class="col-lg-2 col-form-label"><span class="bold">Discount (-)</span>:</label>
                                                    <div class="col-lg-6 line-items">
                                                    <input type="text" name="discount[]" min="0" class="form-control item_discount"
                                                     required value="{{ isset($data) ? $data->discount : '0.00' }}"><br>
                                                        </div> 
                                                         <div class="col-lg-3"></div>
                                                         
                                                    <div class="col-lg-1"></div>
                                                    <label class="col-lg-2 col-form-label"><span class="bold">Total</span>:</label>
                                                    <div class="col-lg-6 line-items">
                                                    <input type="text" name="amount[]" class="form-control item_total" value="{{ isset($data) ? '' : '0.00' }}" required
                                                     jAutoCalc="{subtotal} + {tax} + {shipping_cost} - {discount}" readonly><br>
                                                        </div> 
                                                    <div class="col-lg-3"></div>
                                                       
                                                   </div>
                                                     
                                                     
                                                     
                                                    </div>
                                                    
                                                    
                                                    
                                                       
                                                    </div></div>



                                                <br>
                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))

                                                                <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                    href="{{ route('inventory_invoice.index') }}">
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
    
    
        <!-- supplier Modal -->
    <div class="modal fade" data-backdrop="" id="app2FormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">

        </div>
    </div>
    
   
@endsection

@section('scripts')
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            "ordering": false,
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
  

<script type="text/javascript">
        $(document).ready(function() {

            var count = 0;


            function autoCalcSetup() {
                $('div#cart').jAutoCalc('destroy');
                $('div#cart div.line_items').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true,

                });
                $('div#cart').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup();

            $('.add').on("click", function(e) {

                count++;
                var html = '';
                html +=
                    '<div class="col-lg-3 line_items" id="td' + count + '"> <br><div class="input-group mb-3"><select name="checked_item_name[]" class="form-control m-b item_name" id="item_name' +count + '" required  data-sub_category_id="' +count +'"><option value="">Select Item</option></select></div><div><br><textarea name="checked_description[]"  class="form-control desc' + count +'" placeholder="Description"  cols="30" ></textarea></div><br></div>';
                html +=
                    '<div class="col-lg-6 line_items" id="td' + count + '"><br><input type="hidden" name="checked_quantity[]"  value="1" class="form-control item_quantity" data-category_id="' +count + '" placeholder ="quantity" id ="quantity'+ count +'" required /> Price <input type="text" name="checked_price[]"  class="form-control item_price' + count +'" id="item_price" placeholder ="price"  required  value=""/><br> Tax Rate <select name="checked_tax_rate[]" class="form-control m-b item_tax' + count +'" id="item_tax' + count +'" required ><option value="">Select Tax Rate</option><option value="0">No tax</option><option value="0.18">18%</option></select><br><br>Total Cost <input type="text" name="checked_total_cost[]" class="form-control item_total' + count +'" placeholder ="total" required readonly jAutoCalc="{checked_quantity} * {checked_price}" /><br>Total Tax <input type="text" name="checked_total_tax[]" class="form-control item_total_tax' +count +'" placeholder ="tax" required readonly jAutoCalc="{checked_quantity} * {checked_price} * {checked_tax_rate}"   readonly/><br><input type="hidden" name="checked_unit[]" class="form-control item_unit' + count +'" placeholder ="unit" required /><input type="hidden" name="checked_no[]" class="form-control item_check' + count +'" value="' + count +'" placeholder ="total" required />';
                html += '<input type="hidden" id="item_id"  class="form-control item_id' + count +'" value="" /></div>';
                html +='<div class="col-lg-3 line_items text-center" id="td' + count + '"><br><a class="list-icons-item text-info add1" title="Check" href="javascript:void(0)" data-button_id="' + count +'"><i class="icon-check2" style="font-size:30px;font-weight:bold;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove" title="Delete" href="javascript:void(0)" data-button_id="' +count + '"><i class="icon-trash" style="font-size:18px;"></i></a><br><div class=""> <p class="form-control-static item_errors'+count+'" id="errors" style="text-align:center;color:red;"></p>   </div></div>';
                 
                 if ( $('#cart > .body .line_items').length < 3 ) {
                $('#cart > .body').append(html);
                autoCalcSetup();
                
                       var id = $('.location').val();
            $.ajax({
                url: '{{url("inventory/findInvItem")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                console.log(data);
               $('#td'+count).find('.item_name').empty();
                $('#td'+count).find('.item_name').append('<option value="">Select Item</option>');
                $.each(data,function(key, value)
                {
                 
                    $('#td'+count).find('.item_name').append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });
                }
    
            });
                
                
                
                 }
                 
                  $('.m-b').select2({});
                
                $(document).on('change', '#item_price', function() {
                var id = $(this).val();
                $.ajax({
                url: '{{ url('format_number') }}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                 console.log(data);
                $('.item_price' + count).val(data);
                   
                    }

                });

            });
                          
                              
                             
                       


            });



            $(document).on('click', '.remove', function() {
            var button_id = $(this).data('button_id');
               document.querySelectorAll('#td' + button_id).forEach(el => el.remove());
               
                autoCalcSetup();
            });
            
            
             $(document).on('change', '.item_name', function() {
                var id = $(this).val();
                var sub_category_id = $(this).data('sub_category_id');
                $.ajax({
                    url: '{{ url('inventory/inventory_findInvPrice') }}',
                    type: "GET",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $(".item_unit" + sub_category_id).val(data.unit);
                        $(".desc" + sub_category_id).val(data.description);
                        $('.item_id' + sub_category_id).val(id);
                        autoCalcSetup();
                    }

                });

            });
            
            
        

        });
    </script>
    
    
        <script type="text/javascript">
        $(document).ready(function() {


            function autoCalcSetup1() {
                $('div#cart1').jAutoCalc('destroy');
                $('div#cart1 div.line_items').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true
                });
                $('div#cart1').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup1();

           $(document).on('click', '.add1', function() {
               
               var button_id = $(this).data('button_id');
                console.log(button_id);
                
                  var location = $('.location').val();
                
                 $('.item_errors'+ button_id).empty();
                
                var a = $('#item_name'+ button_id + '.item_name').val();
                var b = $('.item_price'+ button_id + '#item_price').val();
                var d = $('.item_tax'+ button_id).val();
                console.log(b);
                  
                  if( a == '' ||  b == '' || d == ''){
              $('.item_errors'+ button_id).append('Please Fill the Required Fields.');
              event.preventDefault(); 
         }
         
         else{
                
                $.ajax({
                    data: $('#cart > .body').find('input,select,textarea').serialize()+"&location="+location,
                    type: 'GET',
                    url: '{{ url('inventory/add_sales_inventory_item') }}',
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                         $('#cart1 > .body1 table thead').show();
                        $('#cart1 > .body1 table tbody').append(response['list']);
                         $('#cart1 > .body1').append(response['list1']);
                         autoCalcSetup1(); 
                         
                         
               document.querySelectorAll('#td' + button_id).forEach(el => el.remove());
                       

                    }
                })

         }    

            });



            $(document).on('click', '.remove1', function() {
            var button_id = $(this).data('button_id');
               document.querySelectorAll('#lst' + button_id).forEach(el => el.remove());
                $(this).closest('tr').remove();
                autoCalcSetup1();
            });
            
            
        
                  $(document).on('click', '.edit1', function() {
                 var button_id = $(this).data('button_id');
                  console.log(button_id);
                $.ajax({
                    data: $('#cart1 > .body1 #lst'+ button_id).find('input,select,textarea').serialize(),
                    type: 'GET',
                    url: '{{ url('inventory/salesModal') }}',
                     cache: false,
                async: true,
                success: function(response) {
                    //alert(data);
                     console.log(444);
                    $('#appFormModal > .modal-dialog').html(response);
                },
                error: function(error) {
                     console.log(111);
                    $('#appFormModal').modal('toggle');

                }

               
                });


            });
            
            
            $(document).on('click', '.edit_item', function(e) {
               e.preventDefault();
               var button_id = $(this).data('button_id');
                console.log(button_id);
                
                
                 $('.item2_errors').empty();
                
                var a = $('#item_namelst'+ button_id + '.item_name').val();
                var b = $('.item_pricelst'+ button_id + '#item_price').val();
                 var d = $('.item_taxlst'+ button_id).val();
                console.log(b);
                  
                  if( a == '' || b == '' || d == ''){
              $('.item2_errors').append('Please Fill the Required Fields.');
              
              return false; 
              
         }
         
         else{
                
                $.ajax({
                   data: $('.addEditForm').serialize(),
                    type: 'GET',
                    url: '{{ url('inventory/add_sales_inventory_item') }}',
                    dataType: "json",
                    success: function(response) {
                    console.log(response);
                    $('#cart1 > .body1 table tbody').find('.trlst'+button_id).html(response['list']);
                   $('#cart1 > .body1').find('#lst'+button_id).html(response['list1']);
                         autoCalcSetup1(); 
                          $('#appFormModal').modal().hide();
                         
                         
                       

                    }
                })

         }

            });
        
        
             $(document).on('click', '.rem', function() {
            var button_id = $(this).data('button_id');
            var btn_value = $(this).attr("value");
               document.querySelectorAll('#lst' + button_id).forEach(el => el.remove());
                $(this).closest('tr').remove();
                $('#cart1 > .body1').append('<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +btn_value + '"/>');
                autoCalcSetup1();
            });

           

        });
    </script>
    

    
    

 
    
    

    <script>
        $(document).ready(function() {
            

$(document).on('change', '.location', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{url("inventory/findInvItem")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                console.log(data);
                $('.item_name').empty();
               $('.item_name').append('<option value="">Select Item Name</option>');
                $.each(data,function(key, value)
                {
                 
                    $('.item_name').append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });
                }
    
            });
    
        });
    

        });
    </script>


    

 

    <script type="text/javascript">
        function model(id, type) {


            $.ajax({
                type: 'GET',
                url: '{{ url('inventory/salesModal') }}',
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
    
    
    
   
    
    
     
    

@endsection
