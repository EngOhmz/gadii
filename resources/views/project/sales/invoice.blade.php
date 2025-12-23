<div class="card-header"> <strong></strong> </div>

<div class="card-body">
    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if (
                $type == 'credit' ||
                    $type == 'details' ||
                    $type == 'calendar' ||
                    $type == 'purchase' ||
                    $type == 'invoice' ||
                    $type == 'comments' ||
                    $type == 'attachment' ||
                    $type == 'milestone' ||
                    $type == 'tasks' ||
                    $type == 'expenses' ||
                    $type == 'estimate' ||
                    $type == 'notes' ||
                    $type == 'activities') active @endif" id="home-tab2" data-toggle="tab"
                href="#invoice-home2" role="tab" aria-controls="home" aria-selected="true">Invoice
                List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($type == 'edit-invoice' || $type == 'good-receive') active @endif" id="profile-tab2" data-toggle="tab"
                href="#invoice-profile2" role="tab" aria-controls="profile" aria-selected="false">New Invoice</a>
        </li>

    </ul>
    <br>
    <div class="tab-content tab-bordered" id="myTab3Content">
        <div class="tab-pane fade @if (
            $type == 'credit' ||
                $type == 'details' ||
                $type == 'calendar' ||
                $type == 'purchase' ||
                $type == 'invoice' ||
                $type == 'comments' ||
                $type == 'attachment' ||
                $type == 'milestone' ||
                $type == 'tasks' ||
                $type == 'expenses' ||
                $type == 'estimate' ||
                $type == 'notes' ||
                $type == 'activities') active show @endif " id="invoice-home2"
            role="tabpanel" aria-labelledby="home-tab2">
            <div class="table-responsive">
                <table class="table datatable-inv table-striped">
                    <thead>
                        <tr role="row">

                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 126.484px;">Ref No</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 126.484px;">Client Name</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 126.484px;">Invoice Date</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 141.219px;">Due Amount</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Status</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                style="width: 128.1094px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (!empty($inv))
                            @foreach ($inv as $row)
                                @php
                                    $rn = App\Models\POS\ReturnInvoice::where('invoice_id', $row->id)
                                        ->where('added_by', auth()->user()->added_by)
                                        ->first();
                                @endphp
                                <tr class="gradeA even" role="row">
                                    <td>
                                        <a class="nav-link" id="profile-tab2"
                                            href="{{ route('invoice.show', $row->id) }}" role="tab"
                                            aria-selected="false">{{ $row->reference_no }}</a>
                                    </td>
                                    <td> {{ $row->client->name }} </td>

                                    <td>{{ $row->invoice_date }}</td>

                                    <td>{{ number_format($row->due_amount, 2) }} {{ $row->exchange_code }}</td>

                                    <td>
                                        @if ($row->status == 0)
                                            <div class="badge badge-danger badge-shadow">Waiting Final Approval</div>
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
                                    <td>
                                        <div class="form-inline">
                                            @can('approve-edit')
                                                @if ($row->status == 1 && empty($rn))
                                                    <a class="list-icons-item text-primary" title="Edit"
                                                        href="{{ route('edit.project_details', ['type' => 'edit-invoice', 'type_id' => $row->id]) }}"><i
                                                            class="icon-pencil7"></i></a>&nbsp
                                                @endif
                                            @endcan

                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item dropdown-toggle text-teal"
                                                    data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                <div class="dropdown-menu">

                                                    <a class="nav-link" id="profile-tab2"
                                                        href="{{ route('pos_invoice_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}"
                                                        role="tab" aria-selected="false">Download PDF</a>
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
        <div class="tab-pane fade  @if ($type == 'edit-invoice' || $type == 'good-receive') active show @endif" id="invoice-profile2"
            role="tabpanel" aria-labelledby="profile-tab2">
            <br>
            <div class="card">
                <div class="card-header">
                    @if ($type == 'edit-invoice' || $type == 'good-receive')
                        <h5>Edit Invoice</h5>
                    @else
                        <h5>Add New Invoice</h5>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 ">
                            @if ($type == 'edit-invoice' || $type == 'good-receive')

                                {!! Form::open(['route' => 'update.project_details', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="id" value="{{ $type_id }}">
                            @else
                                {!! Form::open(['route' => 'save.project_details', 'enctype' => 'multipart/form-data']) !!}
                                @method('POST')
                            @endif


                            <input type="hidden" name="project_id" value="{{ $id }}">
                            <input type="hidden" name="type" class="form-control tab" value="invoice">

                            <input type="hidden" name="receive" value="{{ isset($receive) ? $receive : '' }}">

                            <div class="form-group row">

                                <label class="col-lg-2 col-form-label">Client Name <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">

                                    <div class="input-group mb-3">
                                        <select class="form-control append-button-single-field client_id"
                                            name="client_id" id="client_id2" required>
                                            <option value="">Select Client Name</option>
                                            @if (!empty($client))
                                                @foreach ($client as $row)
                                                    <option
                                                        @if (isset($edit_data)) {{ $edit_data->client_id == $row->id ? 'selected' : '' }} @endif
                                                        value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                        &nbsp

                                        <button class="btn btn-outline-secondary" type="button" data-toggle="modal"
                                            value="" onclick="model('1','inv-client')"
                                            data-target="#app2FormModal" href="app2FormModal"><i
                                                class="icon-plus-circle2"></i></button>
                                    </div>
                                </div>


                                <label class="col-lg-2 col-form-label">Location <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control m-b  inv_location" name="location" required
                                        id="location2">
                                        <option value="">Select Location</option>
                                        @if (!empty($location))
                                            @foreach ($location as $loc)
                                                <option
                                                    @if (isset($edit_data)) {{ $edit_data->location == $loc->id ? 'selected' : '' }} @endif
                                                    value="{{ $loc->id }}">{{ $loc->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>

                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Invoice Date <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="date" name="invoice_date" required placeholder=""
                                        value="{{ isset($edit_data) ? $edit_data->invoice_date : date('Y-m-d') }}"
                                        class="form-control">
                                </div>
                                <label class="col-lg-2 col-form-label">End Date<span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="date" name="due_date" required placeholder=""
                                        value="{{ isset($edit_data) ? $edit_data->due_date : strftime(date('Y-m-d', strtotime('+10 days'))) }}"
                                        class="form-control">
                                </div>


                            </div>



                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="gender">Sales Type </label>
                                <div class="col-lg-4">
                                    <select class="form-control m-b sales" name="sales_type" id="sales" required>
                                        <option value="">Select Sales Type</option>
                                        <option value="Cash Sales"
                                            @if (isset($edit_data)) {{ $edit_data->sales_type == 'Cash Sales' ? 'selected' : '' }} @endif>
                                            Cash Sales</option>
                                        <option value="Credit Sales"
                                            @if (isset($edit_data)) {{ $edit_data->sales_type == 'Credit Sales' ? 'selected' : '' }} @endif>
                                            Credit Sales</option>
                                    </select>
                                    
                                </div>

                                @if (!empty($edit_data->bank_id))
                                    <label for="stall_no" class="col-lg-2 col-form-label bank1"
                                        style="display:block;">Bank/Cash Account</label>
                                    <div class="col-lg-4 bank2" style="display:block;">
                                        <select class="form-control m-b" name="bank_id">
                                            <option value="">Select Payment Account</option>
                                            @foreach ($bank_accounts as $bank)
                                                <option value="{{ $bank->id }}"
                                                    @if (isset($edit_data)) @if ($edit_data->bank_id == $bank->id) selected @endif
                                                    @endif >{{ $bank->account_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <label for="stall_no" class="col-lg-2 col-form-label bank1"
                                        style="display:none;">Bank/Cash Account</label>
                                    <div class="col-lg-4 bank2" style="display:none;">
                                        <select class="form-control m-b" name="bank_id">
                                            <option value="">Select Payment Account</option>
                                            @foreach ($bank_accounts as $bank)
                                                <option value="{{ $bank->id }}"
                                                    @if (isset($edit_data)) @if ($edit_data->bank_id == $bank->id) selected @endif
                                                    @endif >{{ $bank->account_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                @endif
                            </div>


                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Sales Agent</label>
                                <div class="col-lg-4">
                                    @if (!empty($edit_data->user_agent))

                                        <select class="form-control m-b" name="user_agent" id="user_agent2" required>
                                            <option value="{{ old('user_agent') }}" disabled selected>Select User
                                            </option>
                                            @if (isset($users))
                                                @foreach ($users as $row)
                                                    <option
                                                        @if (isset($edit_data)) {{ $edit_data->user_agent == $row->id ? 'selected' : '' }} @endif
                                                        value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    @else
                                        <select class="form-control m-b" name="user_agent" id="user_agent2" required>
                                            <option value="{{ old('user_agent') }}" disabled selected>Select User
                                            </option>
                                            @if (isset($users))
                                                @foreach ($users as $row)
                                                    @if ($row->id == auth()->user()->id)
                                                        <option value="{{ $row->id }}" selected>
                                                            {{ $row->name }}</option>
                                                    @else
                                                        <option value="{{ $row->id }}">{{ $row->name }}
                                                        </option>
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
                                    @if (!empty($edit_data->exchange_code))

                                        <select class="form-control m-b" name="exchange_code" id="currency_code2"
                                            required>
                                            <option value="{{ old('currency_code') }}" disabled selected>Choose option
                                            </option>
                                            @if (isset($currency))
                                                @foreach ($currency as $row)
                                                    <option
                                                        @if (isset($edit_data)) {{ $edit_data->exchange_code == $row->code ? 'selected' : 'TZS' }} @endif
                                                        value="{{ $row->code }}">{{ $row->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    @else
                                        <select class="form-control m-b" name="exchange_code" id="currency_code2"
                                            required>
                                            <option value="{{ old('currency_code') }}" disabled>Choose option</option>
                                            @if (isset($currency))
                                                @foreach ($currency as $row)
                                                    @if ($row->code == 'TZS')
                                                        <option value="{{ $row->code }}" selected>
                                                            {{ $row->name }}</option>
                                                    @else
                                                        <option value="{{ $row->code }}">{{ $row->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    @endif
                                </div>
                                <label class="col-lg-2 col-form-label">Exchange Rate</label>
                                <div class="col-lg-4">
                                    <input type="number" name="exchange_rate" placeholder="1 if TZSH"
                                        value="{{ isset($edit_data) ? $edit_data->exchange_rate : '1.00' }}"
                                        class="form-control" required>
                                </div>
                            </div>
                            <hr>
                            <button type="button" name="add" class="btn btn-success btn-xs inv_add"><i
                                    class="fas fa-plus"> Add item</i></button><br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="inv_cart">
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
                                        @if (!empty($type_id))
                                            @if (!empty($items))
                                                @foreach ($items as $i)
                                                    <tr class="line_items">
                                                        <td>
                                                            <div class="input-group mb-3"><select name="item_name[]"
                                                                    class="form-control  m-b inv_item_name" required
                                                                    data-sub_category_id={{ $i->order_no }}>
                                                                    <option value="">Select Item</option>
                                                                    @if (!empty($name))
                                                                        @foreach ($name as $n)
                                                                            <option value="{{ $n->id }}"
                                                                                @if (isset($i)) @if ($n->id == $i->item_name)
                            selected @endif
                                                                                @endif
                                                                                >{{ $n->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select></div>
                                                            <textarea name="description[]" class="form-control desc" placeholder="Description" cols="30">{{ isset($i) ? $i->description : '' }}</textarea>
                                                        </td>
                                                        <td><input type="number" name="quantity[]"
                                                                class="form-control  inv_item_quantity"
                                                                data-category_id="{{ $i->order_no }}"
                                                                placeholder="quantity" id="quantity"
                                                                value="{{ isset($i) ? $i->quantity : '' }}"
                                                                required />
                                                            <div class="">
                                                                <p class="form-control-static  inv_errors{{ $i->order_no }}"
                                                                    id="errors"
                                                                    style="text-align:center;color:red;"></p>
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="price[]"
                                                                class="form-control inv_item_price{{ $i->order_no }}"
                                                                placeholder="price" required
                                                                value="{{ isset($i) ? $i->price : '' }}" /></td>
                                                        <input type="hidden" name="unit[]"
                                                            class="form-control inv_item_unit{{ $i->order_no }}"
                                                            placeholder="unit" required
                                                            value="{{ isset($i) ? $i->unit : '' }}" />
                                                        <input type="hidden" name="tax_rate[]"
                                                            class="form-control inv_item_tax{{ $i->id }}"
                                                            value="{{ isset($i) ? $i->tax_rate : '' }}" required>
                                                        <td><input type="text" name="total_tax[]"
                                                                class="form-control inv_item_total_tax{{ $i->order_no }}'"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_tax : '' }}" readonly
                                                                jAutoCalc="{quantity} * {price} * {tax_rate}" /></td>

                                                        <input type="hidden" name="saved_items_id[]"
                                                            class="form-control item_saved{{ $i->order_no }}"
                                                            value="{{ isset($i) ? $i->id : '' }}" required />
                                                        <td><input type="text" name="total_cost[]"
                                                                class="form-control item_total{{ $i->order_no }}"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_cost : '' }}" readonly
                                                                jAutoCalc="{quantity} * {price}" /></td>
                                                        <input type="hidden" id="item_id"
                                                            class="form-control inv_item_id{{ $i->order_no }}"
                                                            value="{{ $i->items_id }}" />
                                                        <input type="hidden" name="items_id[]"
                                                            class="form-control name_list"
                                                            value="{{ isset($i) ? $i->id : '' }}" />
                                                        <td><button type="button" name="remove"
                                                                class="btn btn-danger btn-xs inv-rem"
                                                                value="{{ isset($i) ? $i->id : '' }}"><i
                                                                    class="icon-trash"></i></button></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endif

                                        <tr class="line_items">
                                            <td colspan="3"></td>
                                            <td><span class="bold">Sub Total (+)</span>: </td>
                                            <td><input type="text" name="subtotal[]"
                                                    class="form-control item_total"
                                                    value="{{ isset($edit_data) ? '' : '0.00' }}" required
                                                    jAutoCalc="SUM({total_cost})" readonly></td>
                                        </tr>
                                        <tr class="line_items">
                                            <td colspan="3"></td>
                                            <td><span class="bold">Tax (+)</span>: </td>
                                            <td><input type="text" name="tax[]" class="form-control item_total"
                                                    value="{{ isset($edit_data) ? '' : '0.00' }}" required
                                                    jAutoCalc="SUM({total_tax})" readonly>
                                            </td>
                                        </tr>
                                        <tr class="line_items">
                                            <td colspan="3"></td>
                                            <td><span class="bold">Shipping Cost (+)</span>: </td>
                                            <td><input type="text" name="shipping_cost[]"
                                                    class="form-control item_shipping" placeholder="shipping_cost"
                                                    required
                                                    value="{{ isset($edit_data) ? $edit_data->shipping_cost : '0.00' }}">
                                            </td>
                                        </tr>
                                        <tr class="line_items">
                                            <td colspan="3"></td>
                                            <td><span class="bold">Discount (-)</span>: </td>
                                            <td><input type="text" name="discount[]"
                                                    class="form-control item_discount" placeholder="discount" required
                                                    value="{{ isset($edit_data) ? $edit_data->discount : '0.00' }}">
                                            </td>
                                        </tr>

                                        <tr class="line_items">
                                            <td colspan="3"></td>
                                            <td><span class="bold">Total</span>: </td>
                                            <td><input type="text" name="amount[]" class="form-control item_total"
                                                    value="{{ isset($edit_data) ? '' : '0.00' }}" required
                                                    jAutoCalc="{subtotal} + {tax} + {shipping_cost} - {discount}"
                                                    readonly></td>
                                    </tfoot>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-offset-2 col-lg-12">
                                    @if ($type == 'edit-invoice' || $type == 'good-receive')
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                            data-toggle="modal" data-target="#myModal" type="submit"
                                            id="inv_save">Update</button>
                                    @else
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"
                                            id="inv_save">Save</button>
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
