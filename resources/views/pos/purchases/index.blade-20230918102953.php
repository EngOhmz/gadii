@extends('layouts.master')


@section('content')

@php $def=App\Models\System::where('added_by',auth()->user()->added_by)->first(); @endphp
 
<div id="invoice_state_report_div">    
<div id="state_report" style="display: ">


                <div class="row">

         
              <div class="col-sm-12 col-xl-4">
							<div class="card card-body">
								<div class="d-flex align-items-center">
								

									<div class="flex-fill text-center">
										<h4 class="mb-0">{{number_format($pos_purchase,2)}} {{$def->currency}}</h4>
										<span class="text-primary m0">Total Invoice Amount</span>
									</div>
								</div>
							</div>
						</div>
						
						
						  <div class="col-sm-6 col-xl-4">
							<div class="card card-body">
								<div class="d-flex align-items-center">
								

									<div class="flex-fill text-center">
										<h4 class="mb-0">{{number_format($pos_purchase - $pos_due,2)}} {{$def->currency}}</h4>
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
                            <h4>Purchase </h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Purchase
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Purchase</a>
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
                                                        style="width: 156.484px;">Ref No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 186.484px;">Supplier Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 136.484px;">Purchase Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 161.219px;">Due Amount</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Location</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 101.219px;">Status</th>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 168.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($purchases))
                                                    @foreach ($purchases as $row)
                                                        <tr class="gradeA even" role="row">

                                                            <td>
                                                                <a class="nav-link" id="profile-tab2"
                                                                    href="{{ route('purchase.show', $row->id) }}"
                                                                    role="tab"
                                                                    aria-selected="false">{{ $row->reference_no }}</a>
                                                            </td>
                                                            <td>
                                                                {{ $row->supplier->name }}
                                                            </td>

                                                            <td>{{Carbon\Carbon::parse($row->purchase_date)->format('d/m/Y')}} </td>

                                                            <td>{{ number_format($row->due_amount, 2) }}
                                                                {{ $row->exchange_code }}</td>

                                                            <td>
                                                                @php
                                                                    $loc = App\Models\Location::where('id', $row->location)->get();
                                                                @endphp
                                                                @foreach ($loc as $l)
                                                                    {{ $l->name }}
                                                                @endforeach
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

                                                            @php
                                                                $due = App\Models\POS\PurchaseHistory::where('purchase_id', $row->id)
                                                                    ->where('type', 'Purchases')
                                                                    ->where('added_by', auth()->user()->added_by)
                                                                    ->first();
                                                            @endphp
                                                            <td>
                                                                <div class="form-inline">
                                                                    @if ($row->status == 0)
                                                                        <a class="list-icons-item text-primary"
                                                                            title="Edit"
                                                                            onclick="return confirm('Are you sure?')"
                                                                            href="{{ route('purchase.edit', $row->id) }}"><i
                                                                                class="icon-pencil7"></i></a>&nbsp


                                                                        {!! Form::open(['route' => ['purchase.destroy', $row->id], 'method' => 'delete']) !!}
                                                                        {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                                        {{ Form::close() }}
                                                                        &nbsp
                                                                    @endif
                                                                    <div class="dropdown">
                                                                        <a href="#"
                                                                            class="list-icons-item dropdown-toggle text-teal"
                                                                            data-toggle="dropdown"><i
                                                                                class="icon-cog6"></i></a>
                                                                        <div class="dropdown-menu">
                                                                            @if ($row->status == 0)
                                                                                <a class="nav-link" id="profile-tab2"
                                                                                    href="{{ route('purchase.receive', $row->id) }}"
                                                                                    role="tab" aria-selected="false"
                                                                                    onclick="return confirm('Are you sure?')">Approve
                                                                                    Purchase</a>
                                                                            @endif
                                                                            @if ($row->status != 0 && $row->good_receive == 0)
                                                                                <a class="nav-link" id="profile-tab2"
                                                                                    data-id="{{ $row->id }}"
                                                                                    data-type="receive"
                                                                                    onclick="model({{ $row->id }},'receive')"
                                                                                    href="" data-toggle="modal"
                                                                                    data-target="#appFormModal"
                                                                                    role="tab"
                                                                                    aria-selected="false">Good Receive</a>

                                                                                @if (!empty($due))
                                                                                    <a class="nav-link" id="profile-tab2"
                                                                                        href="{{ route('purchase.issue', $row->id) }}"
                                                                                        role="tab"
                                                                                        aria-selected="false"
                                                                                        onclick="return confirm('Are you sure?')">Issue
                                                                                        Supplier</a>
                                                                                @endif
                                                                            @endif
                                                                            @if ($row->status != 0 && $row->status != 4 && $row->status != 3)
                                                                                <a class="nav-link" id="profile-tab2"
                                                                                    href="{{ route('purchase.pay', $row->id) }}"
                                                                                    role="tab"
                                                                                    aria-selected="false">Make Payments</a>
                                                                            @endif
                                                                            @if ($row->status == 0)
                                                                                <a class="nav-link" title="Cancel"
                                                                                    onclick="return confirm('Are you sure?')"
                                                                                    href="{{ route('purchase.cancel', $row->id) }}">Cancel
                                                                                    Purchase</a>
                                                                            @endif
                                                                            <a class="nav-link" id="profile-tab2"
                                                                                href="{{ route('purchase_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}"
                                                                                role="tab"
                                                                                aria-selected="false">Download PDF</a>

                                                                            @if ($row->good_receive == 1)
                                                                                <a class="nav-link" id="profile-tab2"
                                                                                    href="{{ route('purchase_issue_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}"
                                                                                    role="tab"
                                                                                    aria-selected="false">Download Supplier
                                                                                    Issue</a>
                                                                            @endif

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
                                                <h5>Create Purchase</h5>
                                            @else
                                                <h5>Edit Purchase</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['purchase.update', $id], 'method' => 'PUT']) }}
                                                    @else
                                                        {{ Form::open(['route' => 'purchase.store']) }}
                                                        @method('POST')
                                                    @endif


                                                    <input type="hidden" name="edit_type" class="form-control name_list"
                                                        value="{{ $type }}" />

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Location</label>
                                                        <div class="col-lg-4">
                                                            <select class="form-control m-b" name="location"
                                                                id="location" required>
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
                                                        <label class="col-lg-2 col-form-label">Supplier Name</label>
                                                        <div class="col-lg-4">
                                                            <div class="input-group mb-3">
                                                                <select
                                                                    class="form-control append-button-single-field supplier_id"
                                                                    name="supplier_id" id="supplier_id" required>
                                                                    <option value="">Select Supplier Name</option>
                                                                    @if (!empty($supplier))
                                                                        @foreach ($supplier as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->supplier_id == $row->id ? 'selected' : '' }} @endif
                                                                                value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif

                                                                </select>&nbsp

                                                                <button class="btn btn-outline-secondary" type="button"
                                                                    data-toggle="modal" value=""
                                                                    onclick="model('1','supplier')"
                                                                    data-target="#appFormModal" href="appFormModal"><i
                                                                        class="icon-plus-circle2"></i></button>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Purchase Date</label>
                                                        <div class="col-lg-4">
                                                            <input type="date" name="purchase_date"
                                                                placeholder="0 if does not exist"
                                                                value="{{ isset($data) ? $data->purchase_date : date('Y-m-d') }}"
                                                                class="form-control">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Due Date</label>
                                                        <div class="col-lg-4">
                                                            <input type="date" name="due_date"
                                                                placeholder="0 if does not exist"
                                                                value="{{ isset($data) ? $data->due_date : strftime(date('Y-m-d', strtotime('+10 days'))) }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Purchase Agent</label>
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
                                                        @php $def=App\Models\System::where('added_by',auth()->user()->added_by)->first(); @endphp
                                                            @if (!empty($data->exchange_code))

                                                                <select class="form-control m-b" name="exchange_code"
                                                                    id="currency_code" required>
                                                                    <option value="{{ old('currency_code') }}" disabled
                                                                        selected>Choose option</option>
                                                                    @if (isset($currency))
                                                                        @foreach ($currency as $row)
                                            <option value="{{ $row->code }}"  @if (isset($data)) {{ $data->exchange_code == $row->code ? 'selected' : 'TZS' }} @endif>{{ $row->name }}</option>
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
                                                        <label class="col-lg-2 col-form-label">Exchange Rate</label>
                                                        <div class="col-lg-4">
                                                            <input type="number" name="exchange_rate"
                                                                placeholder="1 if TZSH"
                                                                value="{{ isset($data) ? $data->exchange_rate : '1.00' }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <button type="button" name="add"
                                                        class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add
                                                            item</i></button><br>
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
                                                                @if (!empty($id))
                                                                    @if (!empty($items))
                                                                        @foreach ($items as $i)
                                                                            <tr class="line_items">
                                                                                <td>
                                                                                    <div class="input-group mb-3">
                                                                <select name="item_name[]"
                                                                    class="form-control append-button-single-field item_name"
                                                                    id="item_name{{ $i->id }}_edit"
                                                                    data-sub_category_id="{{ $i->id }}_edit"
                                                                    required>
                                                                    <option value="">Select
                                                                        Item Name</option>
                                                                    @foreach ($name as $n)
                                                                        <option
                                                                            value="{{ $n->id }}"
                                                                            @if (isset($i)) @if ($n->id == $i->item_name) selected @endif
                                                                            @endif
                                                                            >{{ $n->name }}  @if(!empty($n->color)) - {{$n->c->name}} @endif   @if(!empty($n->size)) - {{$n->s->name}} @endif
                                                                        </option>
                                                                    @endforeach
                                                                </select>&nbsp
                                                                <a href="#"
                                                                    class="list-icon text-outline-primary items"
                                                                    data-toggle="modal"
                                                                    data-sub_category_id="{{ $i->id }}_edit"
                                                                    data-target="#appFormModal"
                                                                    data-toggle="tooltip"
                                                                    title="New Item"><i
                                                                        class="icon-plus-circle2"></i></a>
                                                            </div>
                                                            <textarea name="description[]" class="form-control desc{{ $i->id }}_edit" placeholder="Description" cols="30">{{ isset($i) ? $i->description : '' }}</textarea>
                                                        </td>
                                                                                <td><input type="number"
                                                                                        name="quantity[]" step="0.01" min="0.01"
                                                                                        class="form-control item_quantity{{ $i->id }}_edit"
                                                                                        placeholder="quantity"
                                                                                        id="quantity"
                                                                                        value="{{ isset($i) ? $i->quantity : '' }}"
                                                                                        required /></td>
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
                                                                            value="{{ isset($data) ? $data->shipping_cost : '0.00' }}">
                                                                    </td>
                                                                </tr>
                                                                <tr class="line_items">
                                                                    <td colspan="3"></td>
                                                                    <td><span class="bold">Discount (-)</span>: </td>
                                                                    <td><input type="text" name="discount[]"
                                                                            class="form-control item_discount"
                                                                            placeholder="discount" required
                                                                            value="{{ isset($data) ? $data->discount : '0.00' }}">
                                                                    </td>
                                                                </tr>

                                                                <tr class="line_items">
                                                                    <td colspan="3"></td>
                                                                    <td><span class="bold">Total</span>: </td>
                                                                    <td><input type="text" name="amount[]"
                                                                            class="form-control item_total"
                                                                            value="{{ isset($data) ? '' : '0.00' }}"
                                                                            required
                                                                            jAutoCalc="{subtotal} + {tax} + {shipping_cost} - {discount}"
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
                                                                    href="{{ route('purchase.index') }}">
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
    <div class="modal fade " data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">

        </div>
    </div>


    




@endsection

@section('scripts')
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            order: [
                [2, 'desc']
            ],
            "columnDefs": [{
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
        $(document).ready(function() {

            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
            });

            $(document).on('change', '.item_name', function() {
                var id = $(this).val();
                var sub_category_id = $(this).data('sub_category_id');
                $.ajax({
                    url: '{{ url('pos/purchases/findInvPrice') }}',
                    type: "GET",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('.item_price' + sub_category_id).val(data[0]["cost_price"]);
                        $(".item_unit" + sub_category_id).val(data[0]["unit"]);
                        $(".item_tax" + sub_category_id).val(data[0]["tax_rate"]);
                        $(".desc" + sub_category_id).val(data[0]["description"]);

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
                    '<td> <div class="input-group mb-3"><select name="item_name[]" class="form-control append-button-single-field item_name"  id="item_name' +
                    count + '" data-sub_category_id="' + count +
                    '" required><option value="">Select Item Name</option>@foreach ($name as $n) <option value="{{ $n->id }}">{{ $n->name }} @if(!empty($n->color)) - {{$n->c->name}} @endif   @if(!empty($n->size)) - {{$n->s->name}} @endif</option>@endforeach</select>&nbsp<a href="#"  class="list-icon text-outline-primary items"  data-toggle="modal"  data-sub_category_id="' +
                    count +'" data-target="#appFormModal" data-toggle = "tooltip" title = "New Item"><i class="icon-plus-circle2"></i></a></div><textarea name="description[]"  class="form-control desc' + count +'" placeholder="Description"  cols="30" ></textarea></td>';
                html +=
                    '<td><input type="number" name="quantity[]" step="0.01" min="0.01" class="form-control item_quantity" data-category_id="' +
                    count + '"placeholder ="quantity" id ="quantity" required /></td>';
                html += '<td><input type="text" name="price[]" class="form-control item_price' + count +
                    '" placeholder ="price" required  value=""/></td>';
                html += '<input type="hidden" name="unit[]" class="form-control item_unit' + count +
                    '" placeholder ="unit" required />';
                html += '<input type="hidden" name="tax_rate[]" class="form-control item_tax' + count +
                    '" placeholder ="total" required />';
                html += '<td><input type="text" name="total_tax[]" class="form-control item_total_tax' +
                    count +
                    '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   readonly/></td>';
                html += '<td><input type="text" name="total_cost[]" class="form-control item_total' +
                    count +
                    '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
                html +=
                    '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

                $('tbody').append(html);
                autoCalcSetup();

                $('.append-button-single-field').select2({
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass(
                        'w-100') ? '100%' : 'style',
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

    <script>
        $(document).ready(function() {

            $(document).on('click', '.items', function() {
                var type = 'item';
                var id = $(this).data('sub_category_id');
                console.log(id);
                $.ajax({
                    type: 'GET',
                    url: '{{ url('pos/purchases/invModal') }}',
                    data: {
                        'id': id,
                        'type': type,
                    },
                    cache: false,
                    async: true,
                    success: function(data) {
                        //alert(data);

                        $(".item_name").select2("close");
                        $('#appFormModal > .modal-dialog').html(data);
                    },
                    error: function(error) {
                        $('#appFormModal').modal('toggle');

                    }


                });


            });

            $(document).on('click', '.edit_form', function(e) {
                e.preventDefault();
                var x = $("#cost_price").val();
                var sub = $("#select_id").val();
                console.log(sub);
                
                $.ajax({
                    data: $('.addItemForm').serialize(),
                    type: 'GET',
                    url: '{{ url('pos/purchases/save_item') }}',
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        
                        $.each(response,function(key, value)
                {

                        var id = value.id;
                        var name = value.name;
                        var price = value.cost_price;
                        var unit = value.unit;
                        var tax = value.tax_rate;
                        var desc = value.description;

                        var option = "<option value='" + id + "'  selected>" + name +
                            " </option>";
                        $('select[data-sub_category_id="' + sub + '"]').append(option);
                        $('.item_price' + sub).val(price);
                        $(".item_unit" + sub).val(unit);
                        $(".item_tax" + sub).val(tax);
                        $(".desc" + sub).val(desc);
                        $('#appFormModal').hide();
                        
                });

                    }
                })
            });


        });
    </script>





    <script type="text/javascript">
        function model(id, type) {

            $.ajax({
                type: 'GET',
                url: '{{ url('pos/purchases/invModal') }}',
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

            $.ajax({
                type: 'GET',
                url: '{{ url('pos/purchases/save_supplier') }}',
                data: $('.addClientForm').serialize(),
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    var id = response.id;
                    var name = response.name;

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";

                    $('#supplier_id').append(option);
                    $('#appFormModal').hide();



                }
            });
        }
    </script>
@endsection
