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
                    $type == 'debit' ||
                    $type == 'comments' ||
                    $type == 'attachment' ||
                    $type == 'milestone' ||
                    $type == 'tasks' ||
                    $type == 'expenses' ||
                    $type == 'estimate' ||
                    $type == 'notes' ||
                    $type == 'activities') active @endif" id="home-tab2" data-toggle="tab"
                href="#purchase-home2" role="tab" aria-controls="home" aria-selected="true">Purchase
                List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($type == 'edit-purchase' || $type == 'purchase-good-receive') active @endif" id="profile-tab2" data-toggle="tab"
                href="#purchase-profile2" role="tab" aria-controls="profile" aria-selected="false">New Purchase</a>
        </li>

    </ul>
    <br>

    <div class="tab-content tab-bordered" id="myTab3Content">
        <div class="tab-pane fade @if (
            $type == 'credit' ||
                $type == 'details' ||
                $type == 'calendar' ||
                $type == 'purchase' ||
                $type == 'debit' ||
                $type == 'invoice' ||
                $type == 'comments' ||
                $type == 'attachment' ||
                $type == 'milestone' ||
                $type == 'tasks' ||
                $type == 'expenses' ||
                $type == 'estimate' ||
                $type == 'notes' ||
                $type == 'activities') active show @endif " id="purchase-home2"
            role="tabpanel" aria-labelledby="home-tab2">
            <div class="table-responsive">
                <table class="table datatable-pur table-striped">
                    <thead>
                        <tr>

                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 126.484px;">Ref No</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">Supplier Name</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 136.484px;">Purchase Date</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 161.219px;">Due Amount</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 101.219px;">Status</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                style="width: 128.1094px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!@empty($pur))
                            @foreach ($pur as $row)
                                <tr class="gradeA even" role="row">

                                    <td>
                                        <a class="nav-link" id="profile-tab2"
                                            href="{{ route('purchase.show', $row->id) }}" role="tab"
                                            aria-selected="false">{{ $row->reference_no }}</a>
                                    </td>
                                    <td>
                                        {{ $row->supplier->name }}
                                    </td>

                                    <td>{{ $row->purchase_date }}</td>

                                    <td>{{ number_format($row->due_amount, 2) }} {{ $row->exchange_code }}</td>


                                    <td>
                                        @if ($row->status == 0)
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

                                    @php
                                        $due = App\Models\POS\PurchaseHistory::where('purchase_id', $row->id)
                                            ->where('type', 'Purchases')
                                            ->where('added_by', auth()->user()->added_by)
                                            ->first();
                                    @endphp
                                    <td>
                                        <div class="form-inline">
                                            @if ($row->status == 0)
                                                <a class="list-icons-item text-primary" title="Edit"
                                                    href="{{ route('edit.project_details', ['type' => 'edit-purchase', 'type_id' => $row->id]) }}"><i
                                                        class="icon-pencil7"></i></a>&nbsp
                                                <a class="list-icons-item text-danger" title="Edit"
                                                    href="{{ route('delete.project_details', ['type' => 'delete-purchase', 'type_id' => $row->id]) }}"
                                                    onclick="return confirm('Are you sure, you want to delete?')"><i
                                                        class="icon-trash"></i></a>&nbsp
                                            @endif
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item dropdown-toggle text-teal"
                                                    data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                <div class="dropdown-menu">
                                                    @if ($row->status == 0)
                                                        <a class="nav-link" id="profile-tab2"
                                                            href="{{ route('edit.project_details', ['type' => 'purchase-good-receive', 'type_id' => $row->id]) }}"
                                                            onclick="return confirm('Are you sure?')">Approve
                                                            Purchase</a>
                                                    @endif
                                                    @if ($row->status == 1 && $row->good_receive == 0)
                                                        <a class="nav-link" id="profile-tab2"
                                                            data-id="{{ $row->id }}" data-type="receive"
                                                            onclick="model({{ $row->id }},'receive')"
                                                            href="" data-toggle="modal"
                                                            data-target="#app2FormModal" role="tab"
                                                            aria-selected="false">Good Receive</a>
                                                    @endif
                                                    @if (!empty($due))
                                                        <a class="nav-link" id="profile-tab2"
                                                            href="{{ route('project.purchase_issue', $row->id) }}"
                                                            role="tab" aria-selected="false"
                                                            onclick="return confirm('Are you sure?')">Issue
                                                            Supplier</a>
                                                    @endif

                                                    <a class="nav-link" id="profile-tab2"
                                                        href="{{ route('purchase_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}"
                                                        role="tab" aria-selected="false">Download PDF</a>
                                                    @if ($row->good_receive == 1)
                                                        <a class="nav-link"
                                                            id="profile-tab2"href="{{ route('purchase_issue_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}"
                                                            role="tab" aria-selected="false">Download Supplier
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

        <div class="tab-pane fade  @if ($type == 'edit-purchase' || $type == 'purchase-good-receive') active show @endif" id="purchase-profile2"
            role="tabpanel" aria-labelledby="profile-tab2">

            <br>
            <div class="card">
                <div class="card-header">
                    @if ($type == 'edit-purchase' || $type == 'purchase-good-receive')
                        <h5>Edit Purchase</h5>
                    @else
                        <h5>Add New Purchase</h5>
                    @endif
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 ">

                            @if ($type == 'edit-purchase' || $type == 'purchase-good-receive')

                                {!! Form::open(['route' => 'update.project_details', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="id" value="{{ $type_id }}">
                            @else
                                {!! Form::open(['route' => 'save.project_details', 'enctype' => 'multipart/form-data']) !!}
                                @method('POST')
                            @endif


                            <input type="hidden" name="project_id" value="{{ $id }}">
                            <input type="hidden" name="type" value="purchase">

                            <input type="hidden" name="receive" value="{{ isset($receive) ? $receive : '' }}">

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Location <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control m-b  pur_location" name="location" required
                                        id="location3">
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
                                <label class="col-lg-2 col-form-label">Supplier <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <div class="input-group mb-3">
                                        <select class="form-control append-button-single-field supplier_id"
                                            name="supplier_id" id="supplier_id" required>
                                            <option value="">Select Supplier Name</option>
                                            @if (!empty($supplier))
                                                @foreach ($supplier as $row)
                                                    <option
                                                        @if (isset($edit_data)) {{ $edit_data->supplier_id == $row->id ? 'selected' : '' }} @endif
                                                        value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            @endif

                                        </select>&nbsp

                                        <button class="btn btn-outline-secondary" type="button" data-toggle="modal"
                                            value="" onclick="model('1','supplier')"
                                            data-target="#app2FormModal" href="app2FormModal"><i
                                                class="icon-plus-circle2"></i></button>

                                    </div>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Purchase Date <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="date" name="purchase_date" placeholder="0 if does not exist"
                                        value="{{ isset($edit_data) ? $edit_data->purchase_date : date('Y-m-d') }}"
                                        class="form-control" required>
                                </div>
                                <label class="col-lg-2 col-form-label">Due Date <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="date" name="due_date" placeholder="0 if does not exist"
                                        value="{{ isset($edit_data) ? $edit_data->due_date : strftime(date('Y-m-d', strtotime('+10 days'))) }}"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Purchase Agent</label>
                                <div class="col-lg-4">
                                    @if (!empty($edit_data->user_agent))

                                        <select class="form-control m-b" name="user_agent" id="user_agent" required>
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
                                        <select class="form-control m-b" name="user_agent" id="user_agent" required>
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
                            <button type="button" name="add" class="btn btn-success btn-xs pur_add"><i
                                    class="fas fa-plus"> Add item</i></button><br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="pur_cart">
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
                                                            <div class="input-group mb-3">
                                                                <select name="item_name[]"
                                                                    class="form-control append-button-single-field item_name"
                                                                    id="item_name{{ $i->id }}_edit"
                                                                    data-sub_pcategory_id="{{ $i->id }}_edit"
                                                                    required>
                                                                    <option value="">Select Item Name</option>
                                                                    @foreach ($name as $n)
                                                                        <option value="{{ $n->id }}"
                                                                            @if (isset($i)) @if ($n->id == $i->item_name) selected @endif
                                                                            @endif
                                                                            >{{ $n->name }}</option>
                                                                    @endforeach
                                                                </select>&nbsp
                                                                <a href="#"
                                                                    class="list-icon text-outline-primary items"
                                                                    data-toggle="modal"
                                                                    data-sub_category_id="{{ $i->id }}_edit"
                                                                    data-target="#app2FormModal" data-toggle="tooltip"
                                                                    title="New Item">
                                                                    <i class="icon-plus-circle2">
                                                                    </i></a>
                                                            </div>
                                                            <textarea name="description[]" class="form-control desc" placeholder="Description" cols="30">{{ isset($i) ? $i->description : '' }}</textarea>
                                                        </td>
                                                        <td><input type="number" name="quantity[]"
                                                                class="form-control item_quantity{{ $i->id }}_edit"
                                                                placeholder="quantity" id="quantity"
                                                                value="{{ isset($i) ? $i->quantity : '' }}"
                                                                required /></td>
                                                        <td><input type="text" name="price[]"
                                                                class="form-control item_price{{ $i->id }}_edit"
                                                                placeholder="price" required
                                                                value="{{ isset($i) ? $i->price : '' }}" /></td>
                                                        <input type="hidden" name="unit[]"
                                                            class="form-control item_unit{{ $i->id }}_edit"
                                                            placeholder="unit" required
                                                            value="{{ isset($i) ? $i->unit : '' }}" />
                                                        <input type="hidden" name="tax_rate[]"
                                                            class="form-control item_tax{{ $i->id }}_edit"
                                                            value="{{ isset($i) ? $i->tax_rate : '' }}" required>
                                                        <td><input type="text" name="total_tax[]"
                                                                class="form-control item_total_tax{{ $i->id }}_edit"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_tax : '' }}" readonly
                                                                jAutoCalc="{quantity} * {price} * {tax_rate}" /></td>
                                                        <input type="hidden" name="saved_items_id[]"
                                                            class="form-control item_saved{{ $i->id }}_edit"
                                                            value="{{ isset($i) ? $i->id : '' }}" required />
                                                        <td><input type="text" name="total_cost[]"
                                                                class="form-control item_total{{ $i->id }}_edit"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_cost : '' }}" readonly
                                                                jAutoCalc="{quantity} * {price}" /></td>
                                                        <input type="hidden" name="items_id[]"
                                                            class="form-control name_list"
                                                            value="{{ isset($i) ? $i->id : '' }}" />
                                                        <td><button type="button" name="remove"
                                                                class="btn btn-danger btn-xs rem"
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

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>


                            <br>
                            <div class="form-group row">
                                <div class="col-lg-offset-2 col-lg-12">
                                    @if ($type == 'edit-purchase' || $type == 'purchase-good-receive')
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                            data-toggle="modal" data-target="#myModal" type="submit"
                                            id="pur_save">Update</button>
                                    @else
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"
                                            id="pur_save">Save</button>
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
