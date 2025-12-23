@extends('layouts.master')
@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">
    <style>
        .body > .line_items{
            border:1px solid #ddd;
        }
        .c261b1ca9 {
            width: 100%;
            display: flex;
            flex-direction: row;
            text-transform: uppercase;
            border: none;
            font-size: 12px;
            font-weight: 500;
            margin: 0;
            padding: 24px 0 0;
            padding: var(--spacing-3) 0 0 0;
        }

        .c261b1ca9:after, .c261b1ca9:before {
            content: "";
            border-bottom: 1px solid #c2c8d0;
            flex: 1 0 auto;
            height: 0.5em;
            margin: 0;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4>Proforma Invoice</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                   data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                   aria-selected="true">Invoice List</a>
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
                                                style="width: 106.484px;">Subject</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Platform(s): activate to sort column ascending"
                                                style="width: 186.484px;">Client Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Platform(s): activate to sort column ascending"
                                                style="width: 126.484px;">P/Invoice Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending"
                                                style="width: 161.219px;">Amount</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending"
                                                style="width: 141.219px;">Location</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending"
                                                style="width: 141.219px;">Branch</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending"
                                                style="width: 121.219px;">Status</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending"
                                                style="width: 121.219px;">Validity</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending"
                                                style="width: 141.219px;">Attachment</th>
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
                                                    <td>
                                                        <a href="{{ route('profoma_invoice.show', $row->id) }}">{{ $row->reference_no }}</a>
                                                    </td>
                                                    <td>
                                                        {{ $row->heading }}
                                                    </td>
                                                    <td>
                                                        {{ $row->client->name }}
                                                    </td>
                                                    <td>{{ Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y') }}</td>
                                                    <td>{{ number_format($row->due_amount, 2) }}
                                                        {{ $row->exchange_code }}</td>
                                                    <td>
                                                        @if (!empty($row->store->name))
                                                            {{ $row->store->name }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $row->branch_id ? App\Models\Branch::find($row->branch_id)->name : 'No Branch selected' }}
                                                    </td>
                                                    <td>
                                                       @if ($row->status === null)
                                                            <div class="badge badge-danger badge-shadow">DRAFT</div>
                                                        @elseif ($row->status === 0)
                                                            <div class="badge badge-danger badge-shadow">Proforma Invoice</div>
                                                        @elseif ($row->status === 1)
                                                            <div class="badge badge-warning badge-shadow">Not Paid</div>
                                                        @elseif ($row->status === 2)
                                                            <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                        @elseif ($row->status === 3)
                                                            <span class="badge badge-success badge-shadow">Fully Paid</span>
                                                        @elseif ($row->status === 4)
                                                            <span class="badge badge-danger badge-shadow">Cancelled</span>
                                                        @endif

                                                    </td>
                                                    <td>

                                                      @if (!isset($row->validity) || $row->validity == 0)
                                                            <span class="badge bg-success text-white">Open</span>
                                                        @elseif ($row->validity == 1)
                                                            <span class="badge bg-danger text-white">Closed</span>
                                                        @else
                                                            <span class="badge bg-secondary text-white">Unknown</span>
                                                        @endif






                                                    </td>
                                                    <td>
                                                        @if (!empty($row->profoma_attachment))
                                                            <a href="{{ asset($row->profoma_attachment) }}" target="_blank"
                                                               class="btn btn-sm btn-outline-primary">
                                                                <i class="fa fa-paperclip"></i> View
                                                            </a>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    @if ($row->status == 0)
                                                        <td>
                                                            <div class="form-inline">
                                                                @if ($row->good_receive == 0)
                                                                    <a class="list-icons-item text-primary"
                                                                       title="Edit"
                                                                       onclick="return confirm('Are you sure?')"
                                                                       href="{{ route('profoma_invoice.edit', $row->id) }}"><i
                                                                                class="icon-pencil7"></i></a>&nbsp
                                                                @endif
                                                                {!! Form::open(['route' => ['profoma_invoice.destroy', $row->id], 'method' => 'delete']) !!}
                                                                {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                                {{ Form::close() }}
                                                                &nbsp
                                                                <div class="dropdown">
                                                                    <a href="#"
                                                                       class="list-icons-item dropdown-toggle text-teal"
                                                                       data-toggle="dropdown"><i
                                                                                class="icon-cog6"></i></a>
                                                                    <div class="dropdown-menu">
                                                                        @if ($row->invoice_status == null)
                                                                            <a class="nav-link"
                                                                               onclick="return confirm('Are you sure?')"
                                                                               href="{{ route('profoma.profoma_approve', $row->id) }}"
                                                                               title="">Approve Profoma</a>
                                                                        @endif
                                                                        @if ($row->validity == null || $row->validity == 0)
                                                                            <a class="nav-link"
                                                                               onclick="return confirm('Are you sure?')"
                                                                               href="{{ route('profoma.close_profoma', $row->id) }}"
                                                                               title="">Close Profoma</a>
                                                                        @endif
                                                                        @if ($row->invoice_status == 0)
                                                                            <a class="nav-link"
                                                                               onclick="return confirm('Are you sure?')"
                                                                               href="{{ route('invoice.convert_to_invoice', $row->id) }}"
                                                                               title="">Convert To Invoice</a>
                                                                        @endif
                                                                        @if ($row->status != 0 && $row->status != 4 && $row->status != 3 && $row->good_receive == 0)
                                                                            <a class="nav-link" id="profile-tab2"
                                                                               href="{{ route('invoice.receive', $row->id) }}"
                                                                               role="tab"
                                                                               aria-selected="false">Good Receive</a>
                                                                        @endif
                                                                        @if ($row->status != 0 && $row->status != 4 && $row->status != 3 && $row->good_receive == 1)
                                                                            <a class="nav-link" id="profile-tab2"
                                                                               href="{{ route('invoice.pay', $row->id) }}"
                                                                               role="tab"
                                                                               aria-selected="false">Make Payments</a>
                                                                        @endif
                                                                        @if ($row->good_receive == 0)
                                                                            <a class="nav-link" title="Cancel"
                                                                               onclick="return confirm('Are you sure?')"
                                                                               href="{{ route('invoice.cancel', $row->id) }}">Cancel Invoice</a>
                                                                        @endif
                                                                        <a class="nav-link" id="profile-tab2"
                                                                           href="{{ route('pos_profoma_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}"
                                                                           role="tab"
                                                                           aria-selected="false">Download PDF</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <a class="nav-link" id="profile-tab2"
                                                               href="{{ route('pos_profoma_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}"
                                                               role="tab"
                                                               aria-selected="false">Download PDF</a>
                                                        </td>
                                                    @endif
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
                                            <div class="col-sm-12">
                                                @if (isset($id))
                                                    {{ Form::model($id, ['route' => ['profoma_invoice.update', $id], 'method' => 'PUT', 'files' => true]) }}
                                                @else
                                                    {{ Form::open(['route' => 'profoma_invoice.store', 'files' => true]) }}
                                                    @method('POST')
                                                @endif
                                                <input type="hidden" name="edit_type" class="form-control name_type"
                                                       value="{{ $type }}" />
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Client Reference<span class="required"> * </span></label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="supplier_reference"
                                                               placeholder="Client Reference"
                                                               value="{{ isset($data) ? $data->supplier_reference : '' }}"
                                                               class="form-control">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Heading<span class="required"> * </span></label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="heading"
                                                               placeholder="Heading"
                                                               value="{{ isset($data) ? $data->heading : '' }}"
                                                               class="form-control">
                                                    </div>
                                                </div>
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
                                                            <option value="" disabled>Select Location</option>
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
                                                    <label class="col-lg-2 col-form-label">Bank Details</label>
                                                    <div class="form-group col-md-4">
                                                        <select class="form-control m-b" name="bank_details_id">
                                                            <option>Select Bank Details</option>
                                                            @if (!empty($bank_details))
                                                                @foreach ($bank_details as $row)
                                                                    <option value="{{ $row->id }}">
                                                                        {{ $row->account_name }} - {{ $row->branch_name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Delivery Date <span class="required"> * </span></label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="delivery_date"
                                                               placeholder="0 if does not exist"
                                                               value="{{ isset($data) ? $data->delivery_date : strftime(date('Y-m-d', strtotime('+10 days'))) }}"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Payment Condition<span class="required"> * </span></label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="payment_condition"
                                                               placeholder="Payment Condition"
                                                               value="{{ isset($data) ? $data->payment_condition : '' }}"
                                                               class="form-control">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Delivery Terms<span class="required"> * </span></label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="delivery_terms"
                                                               placeholder="Delivery Terms"
                                                               value="{{ isset($data) ? $data->delivery_terms : '' }}"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Attachment</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" name="profoma_attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                                        @if(isset($data) && !empty($data->profoma_attachment))
                                                            <a href="{{ asset($data->profoma_attachment) }}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                                                View Current Attachment
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Terms and Condition</label>
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
                                                        <input type="number" name="exchange_rate" step="0.0001"
                                                               placeholder="1 if TZSH"
                                                               value="{{ isset($data) ? $data->exchange_rate : '1.0000' }}"
                                                               class="form-control" required>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="">
                                                    <p class="form-control-static item_errors" id="errors" style="text-align:center;color:red;"></p>
                                                </div>
                                                <button type="button" name="add"
                                                        class="btn btn-success btn-xs add"><i class="fas fa-plus"></i> Add item</button><br>
                                                <br>
                                                <div class="table-responsive">
                                                    <div class="cart" id="cart">
                                                        <div class="row body">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="cart1" id="cart1">
                                                        <div class="row body1">
                                                            <div class="table-responsive">
                                                                <br>
                                                                <table class="table" id="table1">
                                                                    <thead style="display: @if(!empty($items))  @else none @endif;">
                                                                    <tr>
                                                                        <th scope="col">Name</th>
                                                                        <th scope="col">Sale Type</th>
                                                                        <th scope="col">Quantity</th>
                                                                        <th scope="col">Price</th>
                                                                        <th scope="col">Tax</th>
                                                                        <th scope="col">Total Tax</th>
                                                                        <th scope="col">Total Cost</th>
                                                                        <th scope="col">Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @if (!empty($id))
                                                                        @if (!empty($items))
                                                                            @foreach ($items as $i)
                                                                                @php
                                                                                    $it=App\Models\POS\Items::where('id',$i->item_name)->first();
                                                                                       $c = App\Models\POS\Color::find($it->color);
                                                                                       $s = App\Models\POS\Size::find($it->size);

                                                                                      if(!empty($c) && empty($s)){
                                                                                        $a = $it->name .' - '.$c->name;
                                                                                      }
                                                                                      elseif(empty($c) && !empty($s)){
                                                                                        $a =  $it->name .' - '.$s->name;
                                                                                      }
                                                                                      elseif(!empty($c) && !empty($s)){
                                                                                        $a =  $it->name .' - '.$c->name . ' - '.$s->name;
                                                                                      }
                                                                                      else{
                                                                                           $a =  $it->name ;
                                                                                      }
                                                                                      if($i->tax_rate == '0'){
                                                                                         $r='No Tax';
                                                                                     }
                                                                                     elseif($i->tax_rate == '0.16'){
                                                                                         $r='Exclusive 16%';
                                                                                     }
                                                                                     elseif($i->tax_rate == '0.18'){
                                                                                         $r='Exclusive 18%';
                                                                                     }
                                                                                     if ($i->sale_type == 'qty') {
                                                                                       $z = 'Quantity';
                                                                                   }
                                                                                   elseif ($i->sale_type == 'crate') {
                                                                                       $z = 'Crate/Dozen';
                                                                                   }
                                                                                @endphp
                                                                                <tr class="trlst{{$i->id}}_edit">
                                                                                    <td>{{ $a }}</td>
                                                                                    <td>{{ $z }}</td>
                                                                                    <td>{{ isset($i) ? number_format($i->quantity,2) : '' }}
                                                                                        <div class="">
                                                                                            <span class="form-control-static errorslst{{$i->id}}_edit" id="errors" style="text-align:center;color:red;"></span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>{{ isset($i) ? number_format($i->price,2) : '' }}</td>
                                                                                    <td>{{ $r }}</td>
                                                                                    <td>{{ isset($i) ? number_format($i->total_tax,2) : '' }}</td>
                                                                                    <td>{{ isset($i) ? number_format($i->total_cost,2) : '' }}</td>
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
                                                            </div>
                                                            @if (!empty($id))
                                                                @if (!empty($items))
                                                                    @foreach ($items as $i)
                                                                        <div class="line_items" id="lst{{$i->id}}_edit">
                                                                            <input type="hidden" name="item_name[]" class="form-control item_name" id="name lst{{$i->id}}_edit" value="{{ isset($i) ? $i->item_name : '' }}" required="">
                                                                            <input type="hidden" name="description[]" class="form-control item_desc" id="desc lst{{$i->id}}_edit" value="{{ isset($i) ? $i->description : '' }}">
                                                                            <input type="hidden" name="quantity[]" class="form-control item_quantity" id="qty lst{{$i->id}}_edit" data-category_id="lst{{$i->id}}_edit" value="{{ isset($i) ? $i->quantity : '' }}" required="">
                                                                            <input type="hidden" name="price[]" class="form-control item_price" id="price lst{{$i->id}}_edit" value="{{ isset($i) ? $i->price : '' }}" required="">
                                                                            <input type="hidden" name="sub[]" class="form-control item_sub" id="sub lst{{$i->id}}_edit" value="{{ isset($i) ? $i->total_cost : '' }}" required="">
                                                                            <input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst{{$i->id}}_edit" value="{{ isset($i) ? $i->tax_rate : '' }}" required="">
                                                                            <input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst{{$i->id}}_edit" value="{{ isset($i) ? $i->total_cost : '' }}" required="">
                                                                            <input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst{{$i->id}}_edit" value="{{ isset($i) ? $i->total_tax : '' }}" required="">
                                                                            <input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst{{$i->id}}_edit" value="{{ isset($i) ? $i->unit : '' }}">
                                                                            <input type="hidden" name="type" class="form-control item_type" id="type lst{{$i->id}}_edit" value="edit">
                                                                            <input type="hidden" name="no[]" class="form-control item_type" id="no lst{{$i->id}}_edit" value="{{$i->id}}_edit">
                                                                            <input type="hidden" name="saved_items_id[]" class="form-control item_savedlst{{$i->id}}_edit" value="{{$i->id}}">
                                                                            <input type="hidden" id="item_id" class="form-control item_idlst{{$i->id}}_edit" value="{{ isset($i) ? $i->item_name : '' }}">
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <br><br>
                                                        <div class="row">
                                                            <div class="col-lg-1"></div>
                                                            <label class="col-lg-3 col-form-label">Sub Total (+):</label>
                                                            <div class="col-lg-6 line_items">
                                                                <input type="text" name="subtotal[]"
                                                                       class="form-control item_total"
                                                                       value="{{ isset($data) ? '' : '0.00' }}"
                                                                       required="" jAutoCalc="SUM({sub})"
                                                                       readonly=""> <br>
                                                            </div>
                                                            <div class="col-lg-2"></div>
                                                            <div class="col-lg-1"></div>
                                                            <label class="col-lg-3 col-form-label">Tax (+):</label>
                                                            <div class="col-lg-6 line_items">
                                                                <input type="text" name="tax[]"
                                                                       class="form-control item_total"
                                                                       value="{{ isset($data) ? '' : '0.00' }}"
                                                                       required="" jAutoCalc="SUM({total_tax})"
                                                                       readonly=""> <br>
                                                            </div>
                                                            <div class="col-lg-2"></div>
                                                            <div class="col-lg-1" style="display: none;"></div>
                                                            <label class="col-lg-3 col-form-label" style="display: none;">Shipping Cost (+):</label>
                                                            <div class="col-lg-6 line_items" style="display: none;">
                                                                <input type="number" name="shipping_cost[]"
                                                                       class="form-control item_shipping" required=""
                                                                       value="{{ isset($data) ? $data->shipping_cost : '0.00' }}">
                                                                <br>
                                                            </div>
                                                            <div class="col-lg-2" style="display: none;"></div>
                                                            <div class="col-lg-1" style="display: none;"></div>
                                                            <label class="col-lg-3 col-form-label" style="display: none;">Discount (-):</label>
                                                            <div class="col-lg-6 line_items" style="display: none;">
                                                                <input type="number" name="discount[]"
                                                                       class="form-control item_discount" required=""
                                                                       value="{{ isset($data) ? $data->discount : '0.00' }}"><br>
                                                            </div>
                                                            <div class="col-lg-2" style="display: none;"></div>
                                                            <div class="col-lg-1"></div>
                                                            <label class="col-lg-3 col-form-label">Total Before Adjustment:</label>
                                                            <div class="col-lg-6 line_items">
                                                                <input type="text" name="before[]"
                                                                       class="form-control item_total"
                                                                       value="{{ isset($data) ? '' : '0.00' }}"
                                                                       required=""
                                                                       jAutoCalc="{subtotal} + {tax} + {shipping_cost} - {discount}"
                                                                       readonly="readonly"><br>
                                                            </div>
                                                            <div class="col-lg-2"></div>
                                                            <div class="col-lg-1"></div>
                                                            <label class="col-lg-3 col-form-label">Adjustment:</label>
                                                            <div class="col-lg-6 line_items">
                                                                <input type="number" name="adjustment[]"
                                                                       step="0.01" class="form-control item_total"
                                                                       value="{{ isset($data) ? $data->adjustment : '0.00' }}"><br>
                                                            </div>
                                                            <div class="col-lg-2"></div>
                                                            <div class="col-lg-1"></div>
                                                            <label class="col-lg-3 col-form-label">Total:</label>
                                                            <div class="col-lg-6 line_items">
                                                                <input type="text" name="amount[]"
                                                                       class="form-control item_total"
                                                                       value="{{ isset($data) ? '' : '0.00' }}"
                                                                       required="" jAutoCalc="{before} + {adjustment}"
                                                                       readonly="readonly"><br>
                                                            </div>
                                                            <div class="col-lg-2"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if (!@empty($id))
                                                            <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                               href="{{ route('profoma_invoice.index') }}">
                                                                cancel
                                                            </a>
                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
                                                                    type="submit" id="save">Update</button>
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
    </section>
    <!-- supplier Modal -->
    <div class="modal fade" data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.print.min.js') }}"></script>
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            ordering: false,
            order: [
                [2, 'desc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [3]
            }],
            dom: 'B<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            buttons: [
                {
                    extend: 'print',
                    text: 'Print',
                    title: 'Proforma Invoice',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    },
                    customize: function(win) {
                        $(win.document.body).find('table th').eq(0).text('PI No');
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    title: 'Proforma Invoice',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        format: {
                            header: function(data, columnIdx) {
                                if (columnIdx === 0) {
                                    return 'PI No';
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    title: 'Proforma Invoice',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    },
                    orientation: 'landscape',
                    pageSize: 'A4',
                    customize: function(doc) {
                        if (doc.content && doc.content.length > 1 && doc.content[1].table && doc.content[1].table.body && doc.content[1].table.body.length) {
                            doc.content[1].table.body[0][0].text = 'PI No';
                        }
                    }
                }
            ],
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    first: 'First',
                    last: 'Last',
                    next: $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    previous: $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Debounce function to limit AJAX calls
            function debounce(func, wait) {
                var timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            $(document).on('change', '.location', function() {
                $(".item_quantity").trigger('change');
            });

            $(document).on('change', '.item_quantity', debounce(function() {
                var id = $(this).val();
                var type = $('.name_type').val();
                var sub_category_id = $(this).data('category_id');
                var item = $('.item_id' + sub_category_id).val();
                var location = $('.location').val();
                console.log('Checking quantity for item:', item, 'location:', location);
                $.ajax({
                    url: '{{ url('pos/sales/findInvQuantity') }}',
                    type: "GET",
                    data: {
                        id: id,
                        item: item,
                        location: location,
                    },
                    dataType: "json",
                    timeout: 5000, // 5-second timeout
                    success: function(data) {
                        console.log('Quantity check response:', data);
                        if (type == 'receive') {
                            $('.errors' + sub_category_id).empty();
                            $("#save").attr("disabled", false);
                            $(".add_edit_form").attr("disabled", false);
                            if (data != '') {
                                $('.errors' + sub_category_id).append(data);
                                $("#save").attr("disabled", true);
                                $(".add_edit_form").attr("disabled", true);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Quantity check failed:', status, error);
                        $('.errors' + sub_category_id).html('Failed to check quantity. Please try again.');
                    }
                });
            }, 500));
        });
    </script>
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            var count = 0;
            function autoCalcSetup() {
                try {
                    $('div#cart').jAutoCalc('destroy');
                    $('div#cart div.line_items').jAutoCalc({
                        keyEventsFire: true,
                        decimalPlaces: 2,
                        emptyAsZero: true
                    });
                    $('div#cart').jAutoCalc({
                        decimalPlaces: 2
                    });
                    console.log('jAutoCalc initialized successfully');
                } catch (e) {
                    console.error('jAutoCalc setup failed:', e);
                }
            }
            autoCalcSetup();
            $('.add').on("click", function(e) {
                console.log('Add item button clicked');
                try {
                    count++;
                    var html = '';
                    html += '<div class="col-lg-3 line_items" id="td' + count + '"><br><div class="input-group mb-3"><select name="checked_item_name[]" class="form-control m-b append-button-single-field item_name" id="item_name' +
                        count + '" data-sub_category_id="' + count + '" required><option value="">Select Item Name</option>@foreach ($name as $n) <option value="{{ $n->id }}">{{ $n->name }} @if(!empty($n->color)) - {{$n->c->name}} @endif @if(!empty($n->size)) - {{$n->s->name}} @endif</option>@endforeach</select>&nbsp<button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-sub_category_id="' +
                        count + '" data-target="#appFormModal" onclick="model(' + count + ',\'item\')" title="New Item"><i class="icon-plus-circle2"></i></button></div>@if($type == "receive")<br><div id="upd' + count + '" style="display:none;"><a href="#" class="col-lg-12 btn btn-outline-info text-center update" data-toggle="modal" data-target="#appFormModal" data-sub_category_id="' + count + '">Update Quantity</a></div>@endif<br><textarea name="checked_description[]" class="form-control desc' + count + '" placeholder="Description"></textarea><br></div>';
                    html += '<div class="col-lg-6 line_items" id="td' + count + '"><br>Sale Type <select name="checked_sale_type[]" class="form-control m-b sale_type" id="sale_type' + count + '" required><option value="">Select Type</option><option value="qty">Quantity</option><option value="crate">Crate/Dozen</option></select><br><br>Quantity <input type="number" name="checked_quantity[]" class="form-control item_quantity" min="0.01" step="0.01" data-category_id="' + count + '" placeholder="quantity" id="quantity" required /><div class=""><p class="form-control-static errors' + count + '" id="errors" style="text-align:center;color:red;"></p></div><br>Price <input type="text" name="checked_price[]" class="form-control item_price' + count + '" placeholder="price" id="price td' + count + '" required value=""/><br>Tax <select name="checked_tax_rate[]" class="form-control m-b item_tax" id="item_tax' + count + '" required><option value="">Select Tax</option><option value="0">No Tax</option><option value="0.16">Exclusive 16%</option><option value="0.18">Exclusive 18%</option></select><br><br>Total Cost <input type="text" name="checked_total_cost[]" class="form-control item_total' +
                        count + '" placeholder="total" id="total td' + count + '" required readonly jAutoCalc="{checked_quantity} * {checked_price}" /><br>';
                    html += '<input type="hidden" name="checked_no[]" class="form-control item_no' + count + '" id="no td' + count + '" value="' + count + '" required />';
                    html += '<input type="hidden" name="checked_unit[]" class="form-control item_unit' + count + '" id="unit td' + count + '" placeholder="unit" required />';
                    html += '<input type="hidden" id="item_id" class="form-control item_id' + count + '" value="" /></div>';
                    html += '<div class="col-lg-3 text-center line_items" id="td' + count + '"><br><a class="list-icons-item text-info add1" title="Check" href="javascript:void(0)" data-save_id="' + count + '"><i class="icon-check2" style="font-size:30px;font-weight:bold;"></i></a>&nbsp;&nbsp;<a class="list-icons-item text-danger remove" title="Delete" href="javascript:void(0)" data-button_id="' + count + '"><i class="icon-trash" style="font-size:18px;"></i></a><br><div class=""><p class="form-control-static body_errors' + count + '" id="errors" style="text-align:center;color:red;"></p></div></div>';
                    if ($('#cart > .body div').length == 0) {
                        $('#cart > .body').append(html);
                        try {
                            $('.append-button-single-field').select2({
                                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                            });
                            console.log('Select2 initialized for item row ' + count);
                            autoCalcSetup();
                        } catch (e) {
                            console.error('Select2 initialization failed:', e);
                        }
                    } else {
                        console.warn('Cart body already contains items, skipping append');
                    }
                } catch (e) {
                    console.error('Add item failed:', e);
                    $('.item_errors').html('Failed to add item row. Please try again.');
                }
            });
            $(document).on('change', '.item_name', function() {
                var id = $(this).val();
                var sub_category_id = $(this).data('sub_category_id');
                console.log('Item selected:', id, 'sub_category_id:', sub_category_id);
                $.ajax({
                    url: '{{ url('pos/sales/findInvPrice') }}',
                    type: "GET",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    timeout: 5000,
                    success: function(data) {
                        console.log('Price fetch response:', data);
                        if (data != '') {
                            $('.item_price' + sub_category_id).val(numberWithCommas(data[0]["sales_price"]));
                            $(".item_unit" + sub_category_id).val(data[0]["unit"]);
                            $(".desc" + sub_category_id).val(data[0]["description"]);
                            $('.item_id' + sub_category_id).val(id);
                            var tax = data[0]["tax_rate"];
                            $('div#td' + sub_category_id + '.col-lg-6.line_items > .item_tax').find('option:selected').removeAttr("selected");
                            if (tax == '0.00') {
                                $('div#td' + sub_category_id + '.col-lg-6.line_items > .item_tax').find('option[value="0"]').attr("selected", true);
                                $('div#td' + sub_category_id + '.col-lg-6.line_items > .item_tax').find('option[value="0"]').trigger('change');
                            } else {
                                $('div#td' + sub_category_id + '.col-lg-6.line_items > .item_tax').find('option[value="' + tax + '"]').attr("selected", true);
                                $('div#td' + sub_category_id + '.col-lg-6.line_items > .item_tax').find('option[value="' + tax + '"]').trigger('change');
                            }
                            $('div#upd' + sub_category_id).show();
                            autoCalcSetup();
                        } else {
                            $('.item_price' + sub_category_id).val('');
                            $(".item_unit" + sub_category_id).val('');
                            $(".desc" + sub_category_id).val('');
                            $('.item_id' + sub_category_id).val('');
                            $('div#td' + sub_category_id + '.col-lg-6.line_items > .item_tax').find('option:selected').removeAttr("selected");
                            $('div#td' + sub_category_id + '.col-lg-6.line_items > .item_tax').trigger('change');
                            $('div#upd' + sub_category_id).hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Price fetch failed:', status, error);
                        $('.errors' + sub_category_id).html('Failed to fetch item price. Please try again.');
                    }
                });
            });
            $(document).on('change', '.item_price', function() {
                var id = $(this).val();
                var sub_category_id = $(this).attr('id').replace('price td', '');
                console.log('Price changed for sub_category_id:', sub_category_id, 'value:', id);
                $.ajax({
                    url: '{{ url('format_number') }}',
                    type: "GET",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    timeout: 5000,
                    success: function(data) {
                        console.log('Format number response:', data);
                        $('.item_price' + sub_category_id).val(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Format number failed:', status, error);
                        $('.errors' + sub_category_id).html('Failed to format price. Please try again.');
                    }
                });
            });
            $(document).on('click', '.edit_form', function(e) {
                e.preventDefault();
                var sub = $("#select_id").val();
                console.log('Saving item for sub_category_id:', sub);
                $.ajax({
                    data: $('.addItemForm').serialize(),
                    type: 'GET',
                    url: '{{ url('pos/sales/save_item') }}',
                    dataType: "json",
                    timeout: 5000,
                    success: function(response) {
                        console.log('Save item response:', response);
                        var id = response.id;
                        var name = response.name;
                        var price = response.sales_price;
                        var unit = response.unit;
                        var tax = response.tax_rate;
                        var desc = response.description;
                        var option = "<option value='" + id + "' selected>" + name + "</option>";
                        $('select[data-sub_category_id="' + sub + '"]').append(option);
                        $('.item_price' + sub).val(numberWithCommas(price));
                        $(".item_unit" + sub).val(unit);
                        $(".desc" + sub).val(desc);
                        $('.item_id' + sub).val(id);
                        $('div#td' + sub + '.col-lg-6.line_items > .item_tax').find('option:selected').removeAttr("selected");
                        if (tax == '0.00') {
                            $('div#td' + sub + '.col-lg-6.line_items > .item_tax').find('option[value="0"]').attr("selected", true);
                            $('div#td' + sub + '.col-lg-6.line_items > .item_tax').find('option[value="0"]').trigger('change');
                        } else {
                            $('div#td' + sub + '.col-lg-6.line_items > .item_tax').find('option[value="' + tax + '"]').attr("selected", true);
                            $('div#td' + sub + '.col-lg-6.line_items > .item_tax').find('option[value="' + tax + '"]').trigger('change');
                        }
                        $('#appFormModal').modal('hide');
                        autoCalcSetup();
                    },
                    error: function(xhr, status, error) {
                        console.error('Save item failed:', status, error);
                        $('.item_errors').html('Failed to save item. Please try again.');
                    }
                });
            });
        });
    </script> --}}


        <!-- ================== START SCRIPT ================== -->
    <script type="text/javascript">
        $(document).ready(function() {

            var count = 0;

            function autoCalcSetup() {
                $('div#cart').jAutoCalc('destroy');
                $('div#cart div.line_items').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true
                });
                $('div#cart').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup();

            // Add button click
            $('.add').on("click", function(e) {
                count++;
                var html = '';

                // ---------- ITEM SELECTION ----------
                html += '<div class="col-lg-3 line_items" id="td' + count + '">' +
                    '<br><div class="input-group mb-3">' +
                    '<select name="checked_item_name[]" class="form-control m-b item_name" id="item_name' +
                    count + '" data-sub_category_id="' + count + '" required>' +
                    '<option value="">Select Item Name</option>' +
                    '@foreach ($name as $n) ' +
                    '<option value="{{ $n->id }}">{{ $n->name }} @if (!empty($n->color)) - {{ $n->c->name }} @endif @if (!empty($n->size)) - {{ $n->s->name }} @endif</option>' +
                    '@endforeach' +
                    '</select></div>' +

                    // ---------- ADD NEW ITEM BUTTON ----------
                    '<div class="mt-2">' +
                    '<a href="#" class="btn btn-outline-primary text-center add-new-item" data-toggle="modal" data-target="#newItemModal">' +
                    '<i class="icon-plus-circle2"></i> Add New Item</a>' +
                    '</div>' +

                    '<div class="c261b1ca9 c26517808"><span>or</span></div>' +
                    '<div><a href="#" class="col-lg-12 btn btn-outline-secondary text-center scan" data-toggle="modal" data-target="#appFormModal" data-sub_category_id="' +
                    count + '">' +
                    '<i class="icon-barcode2"> </i> Scan</a></div><br>' +
                    '<div id="upd' + count +
                    '" style="display:none;"><a href="#" class="col-lg-12 btn btn-outline-info text-center update" data-toggle="modal" data-target="#appFormModal" data-sub_category_id="' +
                    count + '">Update Quantity</a></div>' +
                    '<br><textarea name="checked_description[]" class="form-control desc' + count +
                    '" placeholder="Description"></textarea><br></div>';

                // ---------- SALES INFO ----------
                html += '<div class="col-lg-6 line_items" id="td' + count + '">' +
                    '<br>Sale Type <select name="checked_sale_type[]" class="form-control m-b sale_type" id="sale_type' +
                    count + '" required>' +
                    '<option value="">Select Type</option><option value="qty">Quantity</option><option value="crate">Wholesale</option></select><br><br>' +
                    'Quantity <input type="number" name="checked_quantity[]" class="form-control item_quantity" min="0.01" step="0.01" data-category_id="' +
                    count + '" placeholder="quantity" id="quantity" required />' +
                    '<div class=""><p class="form-control-static errors' + count +
                    '" id="errors" style="text-align:center;color:red;"></p></div><br>' +
                    'Price <input type="text" name="checked_price[]" class="form-control item_price' +
                    count + '" placeholder="price" id="price td' + count + '" required value=""/><br>' +
                    'Tax <select name="checked_tax_rate[]" class="form-control m-b item_tax" id="item_tax' +
                    count + '" required>' +
                    '<option value="">Select Tax</option><option value="0">No Tax</option><option value="0.18">Exclusive (18%)</option><option value="0.16">Exclusive (16%)</option></select><br><br>' +
                    'Total Cost <input type="text" name="checked_total_cost[]" class="form-control item_total' +
                    count + '" placeholder="total" id="total td' + count +
                    '" required readonly jAutoCalc="{checked_quantity} * {checked_price}" /><br>';

                // ---------- HIDDEN FIELDS ----------
                html += '<input type="hidden" name="checked_no[]" class="form-control item_no' + count +
                    '" id="no td' + count + '" value="' + count + '" required />' +
                    '<input type="hidden" name="checked_unit[]" class="form-control item_unit' + count +
                    '" id="unit td' + count + '" placeholder="unit" required />' +
                    '<input type="hidden" id="item_id" class="form-control item_id' + count +
                    '" value="" /></div>';

                // ---------- ACTION BUTTONS ----------
                html += '<div class="col-lg-3 text-center line_items" id="td' + count + '">' +
                    '<br><a class="list-icons-item text-info add1" title="Check" href="javascript:void(0)" data-save_id="' +
                    count + '">' +
                    '<i class="icon-check2" style="font-size:30px;font-weight:bold;"></i></a>&nbsp;&nbsp;' +
                    '<a class="list-icons-item text-danger remove" title="Delete" href="javascript:void(0)" data-button_id="' +
                    count + '">' +
                    '<i class="icon-trash" style="font-size:18px;"></i></a><br>' +
                    '<div class=""><p class="form-control-static body_errors' + count +
                    '" id="errors" style="text-align:center;color:red;"></p></div></div>';

                if ($('#cart > .body div').length == 0) {
                    $('#cart > .body').append(html);
                    autoCalcSetup();
                }

                $('.m-b').select2({});

            });

            // =============== ON ITEM SELECT LOAD PRICE ===============
            $(document).on('change', '.item_name', function() {
                var id = $(this).val();
                var sub_category_id = $(this).data('sub_category_id');
                $.ajax({
                    url: '{{ url('pos/sales/findInvPrice') }}',
                    type: "GET",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data != '') {
                            $('.item_price' + sub_category_id).val(numberWithCommas(data[0][
                                "sales_price"
                            ]));
                            $(".item_unit" + sub_category_id).val(data[0]["unit"]);
                            $(".desc" + sub_category_id).val(data[0]["description"]);
                            $('.item_id' + sub_category_id).val(id);

                            var tax = data[0]["tax_rate"];
                            $('div#td' + sub_category_id + '.col-lg-6.line_items > .item_tax')
                                .find('option:selected').removeAttr("selected");
                            $('div#td' + sub_category_id + '.col-lg-6.line_items > .item_tax')
                                .find('option[value="' + tax + '"]').attr("selected", true)
                                .trigger('change');

                            $('div#upd' + sub_category_id).show();
                            autoCalcSetup();

                        } else {
                            $('.item_price' + sub_category_id).val('');
                            $(".item_unit" + sub_category_id).val('');
                            $(".desc" + sub_category_id).val('');
                            $('.item_id' + sub_category_id).empty();
                            $('div#td' + sub_category_id + '.col-lg-6.line_items > .item_tax')
                                .find('option:selected').removeAttr("selected").trigger(
                                    'change');
                            $('div#upd' + sub_category_id).hide();
                        }
                    }
                });
            });

            // =============== REMOVE ITEM ROW ===============
            $(document).on('click', '.remove', function() {
                var button_id = $(this).data('button_id');
                var contentToRemove = document.querySelectorAll('#td' + button_id);
                $(contentToRemove).remove();
                autoCalcSetup();
            });

            // =============== SAVE NEW ITEM ===============
            $(document).on('submit', '#newItemForm', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('pos.sales.ProfomAaddNewItem') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $('#itemName').val(),
                        cost_price: $('#itemCostPrice').val(),
                        sales_price: $('#itemSalesPrice').val(),
                        unit: $('#itemUnit').val(),
                        tax_rate: $('#itemTax').val()
                    },
                    success: function(response) {
                        $('#newItemModal').modal('hide');
                        $('#newItemForm')[0].reset();
                        $('.item_name').append('<option value="' + response.id + '">' + response
                            .name + '</option>');
                        alert('Item "' + response.name + '" added successfully.');
                    },
                    error: function(xhr) {
                        let err = xhr.responseJSON;
                        if (err && err.errors) {
                            alert(Object.values(err.errors).join("\n"));
                        } else {
                            alert("Error saving item.");
                        }
                    }
                });
            });

        });
    </script>

    <!-- ================== MODAL ================== -->
    <div class="modal fade" id="newItemModal" tabindex="-1" role="dialog" aria-labelledby="newItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newItemForm">
                        @csrf
                        <input type="hidden" name="type" value="1">
                        <div class="form-group">
                            <label>Item Name</label>
                            <input type="text" id="itemName" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Cost Price</label>
                            <input type="number" id="itemCostPrice" name="cost_price" class="form-control"
                                step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Sales Price</label>
                            <input type="number" id="itemSalesPrice" name="sales_price" class="form-control"
                                step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Unit</label>
                            <input type="text" id="itemUnit" name="unit" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tax Rate</label>
                            <select id="itemTax" name="tax_rate" class="form-control">
                                <option value="0">No Tax</option>
                                <option value="0.18">Exclusive (18%)</option>
                                <option value="0.16">Exclusive (16%)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Save Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ================== END MODAL ================== -->


    <script type="text/javascript">
        $(document).ready(function() {
            function autoCalcSetup1() {
                try {
                    $('div#cart1').jAutoCalc('destroy');
                    $('div#cart1 div.line_items').jAutoCalc({
                        keyEventsFire: true,
                        decimalPlaces: 2,
                        emptyAsZero: true
                    });
                    $('div#cart1').jAutoCalc({
                        decimalPlaces: 2
                    });
                    console.log('jAutoCalc initialized for cart1');
                } catch (e) {
                    console.error('jAutoCalc setup for cart1 failed:', e);
                }
            }
            autoCalcSetup1();
            $(document).on('click', '.add1', function() {
                console.log('Add1 button clicked');
                var button_id = $(this).data('save_id');
                $('.body_errors' + button_id).empty();
                var b = $('#td' + button_id).find('.item_name').val();
                var z = $('#td' + button_id).find('.sale_type').val();
                var c = $('div#td' + button_id + '.col-lg-6.line_items').find('.item_quantity').val();
                var d = $('.item_price' + button_id).val();
                var e = $('div#td' + button_id + '.col-lg-6.line_items').find('.item_tax').val();
                if (b == '' || c == '' || d == '' || e == '') {
                    $('.body_errors' + button_id).append('Please Fill Required Fields.');
                } else {
                    $.ajax({
                        type: 'GET',
                        url: '{{ url('pos/sales/add_inv_item') }}',
                        data: $('#cart > .body').find('select, textarea, input').serialize(),
                        cache: false,
                        async: true,
                        timeout: 5000,
                        success: function(data) {
                            console.log('Add inv item response:', data);
                            $('#cart1 > .body1 table thead').show();
                            $('#cart1 > .body1 table tbody').append(data['list']);
                            $('#cart1 > .body1').append(data['list1']);
                            autoCalcSetup1();
                        },
                        error: function(xhr, status, error) {
                            console.error('Add inv item failed:', status, error);
                            $('.body_errors' + button_id).html('Failed to add item to table. Please try again.');
                        }
                    });
                    var contentToRemove = document.querySelectorAll('#td' + button_id);
                    $(contentToRemove).remove();
                }
            });
            $(document).on('click', '.remove1', function() {
                var button_id = $(this).data('button_id');
                var contentToRemove = document.querySelectorAll('#lst' + button_id);
                $(contentToRemove).remove();
                $(this).closest('tr').remove();
                $(".item_quantity").trigger('change');
                autoCalcSetup1();
            });
            $(document).on('click', '.rem', function() {
                var button_id = $(this).data('button_id');
                var btn_value = $(this).attr("value");
                var contentToRemove = document.querySelectorAll('#lst' + button_id);
                $(contentToRemove).remove();
                $(this).closest('tr').remove();
                $('#cart1 > .body1').append('<input type="hidden" name="removed_id[]" class="form-control name_list" value="' + btn_value + '"/>');
                $(".item_quantity").trigger('change');
                autoCalcSetup1();
            });
            $(document).on('click', '.edit1', function() {
                var button_id = $(this).data('button_id');
                console.log('Edit1 clicked for button_id:', button_id);
                $.ajax({
                    type: 'GET',
                    url: '{{ url('pos/sales/invModal') }}',
                    data: $('#cart1 > .body1 #lst' + button_id).find('select, textarea, input').serialize(),
                    cache: false,
                    async: true,
                    timeout: 5000,
                    success: function(data) {
                        console.log('Edit modal loaded');
                        $('#appFormModal > .modal-dialog').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Edit modal load failed:', status, error);
                        $('#appFormModal').modal('hide');
                        $('.item_errors').html('Failed to load edit modal. Please try again.');
                    }
                });
            });
            $(document).on('click', '.add_edit_form', function(e) {
                e.preventDefault();
                var sub = $(this).data('button_id');
                console.log('Add edit form for button_id:', sub);
                $.ajax({
                    data: $('.addEditForm').serialize(),
                    type: 'GET',
                    url: '{{ url('pos/sales/add_inv_item') }}',
                    dataType: "json",
                    timeout: 5000,
                    success: function(data) {
                        console.log('Add edit item response:', data);
                        $('#cart1 > .body1 table tbody').find('.trlst' + sub).html(data['list']);
                        $('#cart1 > .body1').find('#lst' + sub).html(data['list1']);
                        $(".item_quantity").trigger('change');
                        autoCalcSetup1();
                    },
                    error: function(xhr, status, error) {
                        console.error('Add edit item failed:', status, error);
                        $('.item_errors').html('Failed to update item. Please try again.');
                    }
                });
            });
            $(document).on('click', '.scan', function() {
                var type = 'scan';
                var id = $(this).data('sub_category_id');
                console.log('Scan clicked for sub_category_id:', id);
                $.ajax({
                    type: 'GET',
                    url: '{{ url('pos/sales/invModal') }}',
                    data: {
                        'id': id,
                        'type': type,
                    },
                    cache: false,
                    async: true,
                    timeout: 5000,
                    success: function(data) {
                        console.log('Scan modal loaded');
                        $('#appFormModal').find('.modal-dialog').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Scan modal load failed:', status, error);
                        $('#appFormModal').modal('hide');
                        $('.item_errors').html('Failed to load scan modal. Please try again.');
                    }
                });
            });
            $(document).on('click', '.check_item', function(e) {
                e.preventDefault();
                var sub = $("#select_id").val();
                console.log('Check item for sub_category_id:', sub);
                $.ajax({
                    data: $('.addScanForm').serialize(),
                    type: 'GET',
                    url: '{{ url('pos/sales/check_item') }}',
                    dataType: "json",
                    timeout: 5000,
                    success: function(data) {
                        console.log('Check item response:', data);
                        $('#cart1 > .body1 table thead').show();
                        $('#cart1 > .body1 table tbody').append(data['list']);
                        $('#cart1 > .body1').append(data['list1']);
                        autoCalcSetup1();
                        var contentToRemove = document.querySelectorAll('#td' + sub);
                        $(contentToRemove).remove();
                    },
                    error: function(xhr, status, error) {
                        console.error('Check item failed:', status, error);
                        $('.item_errors').html('Failed to check item. Please try again.');
                    }
                });
            });
            $(document).on('click', '.update', function() {
                var type = 'update';
                var id = $(this).data('sub_category_id');
                var item = $('.item_id' + id).val();
                var location = $('.location').val();
                console.log('Update quantity for sub_category_id:', id);
                $.ajax({
                    type: 'GET',
                    url: '{{ url('pos/sales/invModal') }}',
                    data: {
                        'id': id,
                        'type': type,
                        'item': item,
                        'location': location,
                    },
                    cache: false,
                    async: true,
                    timeout: 5000,
                    success: function(data) {
                        console.log('Update modal loaded');
                        $('#appFormModal').find('.modal-dialog').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Update modal load failed:', status, error);
                        $('#appFormModal').modal('hide');
                        $('.item_errors').html('Failed to load update modal. Please try again.');
                    }
                });
            });
            $(document).on('click', '.upd_qty', function(e) {
                e.preventDefault();
                var sub = $("#select_id2").val();
                console.log('Update quantity for sub_category_id:', sub);
                $.ajax({
                    data: $('.addUpdateForm').serialize(),
                    type: 'GET',
                    url: '{{ url('pos/sales/update_item') }}',
                    dataType: "json",
                    timeout: 5000,
                    success: function(data) {
                        console.log('Update item response:', data);
                        $(".item_quantity").trigger('change');
                        $('#appFormModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error('Update item failed:', status, error);
                        $('.item_errors').html('Failed to update item quantity. Please try again.');
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        function model(id, type) {
            console.log('Opening modal for id:', id, 'type:', type);
            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/invModal') }}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                timeout: 5000,
                beforeSend: function() {
                    $('#appFormModal').modal('show');
                    $('#appFormModal > .modal-dialog').html('<div class="modal-content"><div class="modal-body">Loading...</div></div>');
                },
                success: function(data) {
                    console.log('Modal content loaded');
                    $('#appFormModal > .modal-dialog').html(data);
                },
                error: function(xhr, status, error) {
                    console.error('Modal load failed:', status, error);
                    $('#appFormModal > .modal-dialog').html('<div class="modal-content"><div class="modal-body">Failed to load modal. Please try again.</div></div>');
                }
            });
        }
        function saveClient(e) {
            console.log('Saving client');
            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/save_client') }}',
                data: $('.addClientForm').serialize(),
                dataType: "json",
                timeout: 5000,
                success: function(response) {
                    console.log('Save client response:', response);
                    var id = response.id;
                    var name = response.name;
                    var option = "<option value='" + id + "' selected>" + name + "</option>";
                    $('#client_id').append(option);
                    $('#appFormModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error('Save client failed:', status, error);
                    $('.item_errors').html('Failed to save client. Please try again.');
                }
            });
        }
        function saveItem(e) {
            console.log('Saving item');
            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/save_item') }}',
                data: $('.addItemForm').serialize(),
                dataType: "json",
                timeout: 5000,
                success: function(response) {
                    console.log('Save item response:', response);
                    var id = response.id;
                    var name = response.name;
                    var price = response.sales_price;
                    var unit = response.unit;
                    var tax = response.tax_rate;
                    var desc = response.description;
                    var sub = $("#select_id").val();
                    var option = "<option value='" + id + "' selected>" + name + "</option>";
                    $('select[data-sub_category_id="' + sub + '"]').append(option);
                    $('.item_price' + sub).val(numberWithCommas(price));
                    $(".item_unit" + sub).val(unit);
                    $(".desc" + sub).val(desc);
                    $('.item_id' + sub).val(id);
                    $('div#td' + sub + '.col-lg-6.line_items > .item_tax').find('option:selected').removeAttr("selected");
                    if (tax == '0.00') {
                        $('div#td' + sub + '.col-lg-6.line_items > .item_tax').find('option[value="0"]').attr("selected", true);
                        $('div#td' + sub + '.col-lg-6.line_items > .item_tax').find('option[value="0"]').trigger('change');
                    } else {
                        $('div#td' + sub + '.col-lg-6.line_items > .item_tax').find('option[value="' + tax + '"]').attr("selected", true);
                        $('div#td' + sub + '.col-lg-6.line_items > .item_tax').find('option[value="' + tax + '"]').trigger('change');
                    }
                    $('#appFormModal').modal('hide');
                    autoCalcSetup();
                },
                error: function(xhr, status, error) {
                    console.error('Save item failed:', status, error);
                    $('.item_errors').html('Failed to save item. Please try again.');
                }
            });
        }
        function model2(id, type) {
            console.log('Opening modal2 for id:', id, 'type:', type);
            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/invModal') }}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                timeout: 5000,
                success: function(data) {
                    console.log('Modal2 content loaded');
                    $('#app2FormModal > .modal-dialog').html(data);
                },
                error: function(xhr, status, error) {
                    console.error('Modal2 load failed:', status, error);
                    $('#app2FormModal').modal('hide');
                    $('.item_errors').html('Failed to load modal. Please try again.');
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('change', '.sales', function() {
                var id = $(this).val();
                console.log('Sales type changed:', id);
                if (id == 'Cash Sales') {
                    $('.bank1').show();
                    $('.bank2').show();
                    $("#bank_id").prop('required', true);
                } else {
                    $('.bank1').hide();
                    $('.bank2').hide();
                    $("#bank_id").prop('required', false);
                }
            });
        });
    </script>
    <script type="text/javascript">
        function attach_model(id, type) {
            console.log('Opening attach modal for id:', id, 'type:', type);
            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/attachModal') }}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                timeout: 5000,
                success: function(data) {
                    console.log('Attach modal loaded');
                    $('.table-img').html(data);
                    $('#invoice_id').val(id);
                },
                error: function(xhr, status, error) {
                    console.error('Attach modal load failed:', status, error);
                    $('#attachFormModal').modal('hide');
                    $('.item_errors').html('Failed to load attach modal. Please try again.');
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $(".item_quantity").trigger('change');
            $(document).on('click', '.save', function(event) {
                $('.item_errors').empty();
                if ($('#cart1 > .body1 .line_items').length == 0) {
                    event.preventDefault();
                    $('.item_errors').append('Please Add Items.');
                }
            });
        });
    </script>
    <script type="text/javascript">
        function numberWithCommas(x) {
            try {
                var parts = x.toString().split(".");
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return parts.join(".");
            } catch (e) {
                console.error('Number formatting failed:', e);
                return x;
            }
        }
    </script>
@endsection
