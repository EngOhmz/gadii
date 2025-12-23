@switch($type)
    @case('shortcut_supplier')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Add Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{route('save.shortCut_details')}}">
                @csrf
                <div class="modal-body">

                    <div class="row">

                        <div class="col-sm-12 ">

                            <div class="form-group row"><label class="col-lg-2 col-form-label">Name</label>

                                <div class="col-lg-10">
                                    <input type="text" name="name" id="name" class="form-control" required>
                                    <input type="hidden" name="type" value="supplier" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group row"><label class="col-lg-2 col-form-label">Phone</label>

                                <div class="col-lg-10">
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        placeholder="+255713000000" required>
                                </div>
                            </div>

                            <div class="form-group row"><label class="col-lg-2 col-form-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group row"><label class="col-lg-2 col-form-label">Address</label>

                                <div class="col-lg-10">
                                    <textarea name="address" id="address" class="form-control" required>  </textarea>


                                </div>
                            </div>

                            <div class="form-group row"><label class="col-lg-2 col-form-label">TIN</label>

                                <div class="col-lg-10">
                                    <input type="text" name="TIN" id="TIN"
                                        value="{{ isset($data) ? $data->TIN : '' }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row"><label class="col-lg-2 col-form-label">VAT</label>

                                <div class="col-lg-10">
                                    <input type="text" name="VAT" id="VAT"
                                        value="{{ isset($data) ? $data->VAT : '' }}" class="form-control">
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
               <div class="modal-footer ">
                <button class="btn btn-primary" type="submit" id="save"><i
                        class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
                <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>
                    Close</button>
                </div>


            </form>

        </div>
    @break

    @case('shortcut_client')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Add Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

             <form method="post" action="{{route('save.shortCut_details')}}">
                @csrf
            <div class="modal-body" id="modal_body">

                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="form-group row"><label class="col-lg-2 col-form-label">Name</label>

                            <div class="col-lg-10">
                                <input type="text" name="name" class="form-control" required>
                                <input type="hidden" name="type"  value="client" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-2 col-form-label">Phone</label>

                            <div class="col-lg-10">
                                <input type="text" name="phone" value="{{ isset($data) ? $data->phone : '' }}"
                                    class="form-control" placeholder="+255713000000" required>
                            </div>
                        </div>

                        <div class="form-group row"><label class="col-lg-2 col-form-label">Email</label>

                            <div class="col-lg-10">
                                <input type="email" name="email" value="{{ isset($data) ? $data->email : '' }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="form-group row"><label class="col-lg-2 col-form-label">Address</label>

                            <div class="col-lg-10">
                                <textarea name="address" class="form-control">  {{ isset($data) ? $data->address : '' }} </textarea>


                            </div>
                        </div>

                        <div class="form-group row"><label class="col-lg-2 col-form-label">TIN</label>
                            <div class="col-lg-10">
                                <input type="text" name="TIN" value="{{ isset($data) ? $data->TIN : '' }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="form-group row"><label class="col-lg-2 col-form-label">VRN</label>

                            <div class="col-lg-10">
                                <input type="text" name="VRN" value="{{ isset($data) ? $data->VRN : '' }}"
                                    class="form-control">
                            </div>
                        </div>
                     
                    </div>

                </div>
            </div>
            <div class="modal-footer ">
                <button class="btn btn-primary" type="submit" id="save"><i
                        class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
                <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>
                    Close</button>
            </div>
               </form>
        </div>
    @break

    @case('purchase')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Add Purchases</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="modal_body">

                <div class="row">
                    <div class="col-sm-12 ">


                        <input type="hidden" name="type" class="form-control name_list" value="{{ $type }}" />

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Location</label>
                            <div class="col-lg-4">
                                <select class="form-control m-b" name="location" id="location" required>
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
                                    <select class="form-control append-button-single-field supplier_id" name="supplier_id"
                                        id="supplier_id" required>
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

                                    <button class="btn btn-outline-secondary" type="button" data-toggle="modal"
                                        value="" onclick="model('1','supplier')" data-target="#appFormModal"
                                        href="app2FormModal"><i class="icon-plus-circle2"></i></button>

                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Purchase Date</label>
                            <div class="col-lg-4">
                                <input type="date" name="purchase_date" placeholder="0 if does not exist"
                                    value="{{ isset($data) ? $data->purchase_date : date('Y-m-d') }}" class="form-control">
                            </div>
                            <label class="col-lg-2 col-form-label">Due Date</label>
                            <div class="col-lg-4">
                                <input type="date" name="due_date" placeholder="0 if does not exist"
                                    value="{{ isset($data) ? $data->due_date : strftime(date('Y-m-d', strtotime('+10 days'))) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Purchase Agent</label>
                            <div class="col-lg-4">
                                @if (!empty($data->user_agent))

                                    <select class="form-control m-b" name="user_agent" id="user_agent" required>
                                        <option value="{{ old('user_agent') }}" disabled selected>
                                            Select User</option>
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
                                    <select class="form-control m-b" name="user_agent" id="user_agent" required>
                                        <option value="{{ old('user_agent') }}" disabled selected>
                                            Select User</option>
                                        @if (isset($user))
                                            @foreach ($user as $row)
                                                @if ($row->id == auth()->user()->id)
                                                    <option value="{{ $row->id }}" selected>
                                                        {{ $row->name }}</option>
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


                        <br>
                        <h4 align="center">Enter Item Details</h4>
                        <hr>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Currency</label>
                            <div class="col-lg-4">
                                @if (!empty($data->exchange_code))

                                    <select class="form-control m-b" name="exchange_code" id="currency_code" required>
                                        <option value="{{ old('currency_code') }}" disabled selected>
                                            Choose option</option>
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
                                    <select class="form-control m-b" name="exchange_code" id="currency_code" required>
                                        <option value="{{ old('currency_code') }}" disabled>
                                            Choose option</option>
                                        @if (isset($currency))
                                            @foreach ($currency as $row)
                                                @if ($row->code == 'TZS')
                                                    <option value="{{ $row->code }}" selected>
                                                        {{ $row->name }}</option>
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
                                <input type="number" name="exchange_rate" placeholder="1 if TZSH"
                                    value="{{ isset($data) ? $data->exchange_rate : '1.00' }}" class="form-control" required>
                            </div>
                        </div>
                        <hr>
                        <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add
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
                                                                data-sub_category_id="{{ $i->id }}_edit" required>
                                                                <option value="">Select
                                                                    Item Name</option>
                                                                @foreach ($name as $n)
                                                                    <option value="{{ $n->id }}"
                                                                        @if (isset($i)) @if ($n->id == $i->item_name) selected @endif
                                                                        @endif
                                                                        >{{ $n->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>&nbsp
                                                            <a href="#" class="list-icon text-outline-primary items"
                                                                data-toggle="modal"
                                                                data-sub_category_id="{{ $i->id }}_edit"
                                                                data-target="#appFormModal" data-toggle="tooltip"
                                                                title="New Item"><i class="icon-plus-circle2"></i></a>
                                                        </div>
                                                        <textarea name="description[]" class="form-control desc" placeholder="Description" cols="30">{{ isset($i) ? $i->description : '' }}</textarea>
                                                    </td>
                                                    <td><input type="number" name="quantity[]"
                                                            class="form-control item_quantity{{ $i->id }}_edit"
                                                            placeholder="quantity" id="quantity"
                                                            value="{{ isset($i) ? $i->quantity : '' }}" required /></td>
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
                                                        value="{{ isset($i) ? $i->tax_rate : '' }}" required>
                                                    <td><input type="text" name="total_tax[]"
                                                            class="form-control item_total_tax{{ $i->id }}_edit"
                                                            placeholder="total" required
                                                            value="{{ isset($i) ? $i->total_tax : '' }}" readonly
                                                            jAutoCalc="{quantity} * {price} * {tax_rate}" />
                                                    </td>
                                                    <input type="hidden" name="saved_items_id[]"
                                                        class="form-control item_saved{{ $i->id }}_edit"
                                                        value="{{ isset($i) ? $i->id : '' }}" required />
                                                    <td><input type="text" name="total_cost[]"
                                                            class="form-control item_total{{ $i->id }}_edit"
                                                            placeholder="total" required
                                                            value="{{ isset($i) ? $i->total_cost : '' }}" readonly
                                                            jAutoCalc="{quantity} * {price}" />
                                                    </td>
                                                    <input type="hidden" name="items_id[]" class="form-control name_list"
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
                                        <td><input type="text" name="subtotal[]" class="form-control item_total"
                                                value="{{ isset($data) ? '' : '0.00' }}" required
                                                jAutoCalc="SUM({total_cost})" readonly></td>
                                    </tr>
                                    <tr class="line_items">
                                        <td colspan="3"></td>
                                        <td><span class="bold">Tax (+)</span>: </td>
                                        <td><input type="text" name="tax[]" class="form-control item_total"
                                                value="{{ isset($data) ? '' : '0.00' }}" required
                                                jAutoCalc="SUM({total_tax})" readonly>
                                        </td>
                                    </tr>
                                    <tr class="line_items">
                                        <td colspan="3"></td>
                                        <td><span class="bold">Shipping Cost (+)</span>:
                                        </td>
                                        <td><input type="text" name="shipping_cost[]" class="form-control item_shipping"
                                                placeholder="shipping_cost" required
                                                value="{{ isset($data) ? $data->shipping_cost : '0.00' }}">
                                        </td>
                                    </tr>
                                    <tr class="line_items">
                                        <td colspan="3"></td>
                                        <td><span class="bold">Discount (-)</span>: </td>
                                        <td><input type="text" name="discount[]" class="form-control item_discount"
                                                placeholder="discount" required
                                                value="{{ isset($data) ? $data->discount : '0.00' }}">
                                        </td>
                                    </tr>

                                    <tr class="line_items">
                                        <td colspan="3"></td>
                                        <td><span class="bold">Total</span>: </td>
                                        <td><input type="text" name="amount[]" class="form-control item_total"
                                                value="{{ isset($data) ? '' : '0.00' }}" required
                                                jAutoCalc="{subtotal} + {tax} + {shipping_cost} - {discount}" readonly></td>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                        <br>

                        {!! Form::close() !!}
                    </div>

                </div>

            </div>
            <div class="modal-footer ">
                <button class="btn btn-primary" type="submit" id="save"><i
                        class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
                <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>
                    Close</button>
            </div>

        </div>
    @break

    @case('invoice')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Add Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body" id="modal_body">

                <div class="row">
                    <div class="col-sm-12 ">
                        <input type="hidden" name="type" class="form-control name_list" value="{{ $type }}" />
                        <input type="hidden" name="inv_id" class="form-control inv_id"
                            value="{{ isset($data) ? $id : '' }}" />

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Client Name <span class="required"> * </span></label>
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <select class="form-control append-button-single-field client_id" name="client_id"
                                        id="client_id" required>
                                        <option value="">Select Client Name</option>
                                        @if (!empty($client))
                                            @foreach ($client as $row)
                                                <option value="{{ $row->id }}">
                                                    {{ $row->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>&nbsp

                                    <button class="btn btn-outline-secondary" type="button" data-toggle="modal"
                                        value="" onclick="model('1','client')" data-target="#appFormModal"
                                        href="app2FormModal"><i class="icon-plus-circle2"></i></button>
                                </div>
                            </div>
                            <label class="col-lg-2 col-form-label">Location <span class="required"> * </span></label>
                            <div class="col-lg-4">
                                <select class="form-control m-b location" name="location" required id="location">
                                    <option value="">Select Location</option>
                                    @if (!empty($location))
                                        @foreach ($location as $loc)
                                            <option value="{{ $loc->id }}">
                                                {{ $loc->name }}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Invoice Date <span class="required"> * </span></label>
                            <div class="col-lg-4">
                                <input type="date" name="invoice_date" placeholder="0 if does not exist" value=""
                                    class="form-control">
                            </div>
                            <label class="col-lg-2 col-form-label">Due Date <span class="required"> * </span></label>
                            <div class="col-lg-4">
                                <input type="date" name="due_date" placeholder="0 if does not exist" value=""
                                    class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Sales Agent <span class="required"> * </span></label>
                            <div class="col-lg-4">
                                @if (!empty($data->user_agent))

                                    <select class="form-control m-b" name="user_agent" id="user_agent" required>
                                        <option value="{{ old('user_agent') }}" disabled selected>Select User</option>
                                        @if (isset($user))
                                            @foreach ($user as $row)
                                                <option value="{{ $row->id }}">
                                                    {{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                @else
                                    <select class="form-control m-b" name="user_agent" id="user_agent" required>
                                        <option value="{{ old('user_agent') }}" disabled selected>Select User</option>
                                        @if (isset($user))
                                            @foreach ($user as $row)
                                                @if ($row->id == auth()->user()->id)
                                                    <option value="{{ $row->id }}" selected>{{ $row->name }}</option>
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
                            <label class="col-lg-2 col-form-label" for="gender">Sales Type
                                <span class="required"> * </span></label>
                            <div class="col-lg-4">
                                <select class="form-control m-b sales" name="sales_type" id="sales" required>
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
                                <label for="stall_no" class="col-lg-2 col-form-label bank1" style="display:block;">Bank/Cash
                                    Account <span class="required"> * </span></label>
                                <div class="col-lg-4 bank2" style="display:block;">
                                    <select class="form-control m-b" name="bank_id">
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
                                <label for="stall_no" class="col-lg-2 col-form-label bank1" style="display:none;">Bank/Cash
                                    Account <span class="required"> * </span></label>
                                <div class="col-lg-4 bank2" style="display:none;">
                                    <select class="form-control m-b" name="bank_id">
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
                            <label class="col-lg-2 col-form-label">Attachment <br><small> You
                                    can upload a maximum of 10 files</small></label>
                            <div class="col-lg-8">
                                <div class="needsclick dropzone" id="document-dropzone"></div>
                            </div>
                        </div>
                        <br>
                        <h4 align="center">Enter Item Details</h4>
                        <hr>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Currency <span class="required"> * </span></label>
                            <div class="col-lg-4">
                                @if (!empty($data->exchange_code))

                                    <select class="form-control m-b" name="exchange_code" id="currency_code" required>
                                        <option value="{{ old('currency_code') }}" disabled selected>Choose option</option>
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
                                    <select class="form-control m-b" name="exchange_code" id="currency_code" required>
                                        <option value="{{ old('currency_code') }}" disabled>
                                            Choose option</option>
                                        @if (isset($currency))
                                            @foreach ($currency as $row)
                                                @if ($row->code == 'TZS')
                                                    <option value="{{ $row->code }}" selected>{{ $row->name }}</option>
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
                                <input type="number" name="exchange_rate" placeholder="1 if TZSH"
                                    value="{{ isset($data) ? $data->exchange_rate : '1.00' }}" class="form-control" required>
                            </div>
                        </div>
                        <hr>
                        <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add
                                item</i></button><br>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="cart">
                                <thead>
                                    <tr>
                                        <th>Name <span class="required"> * </span></th>
                                        <th>Quantity <span class="required"> * </span></th>
                                        <th>Price <span class="required"> * </span></th>
                                        <th>Tax <span class="required"> * </span></th>
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
                                                        <div class="input-group mb-3"><select name="item_name[]"
                                                                class="form-control  m-b item_name" required
                                                                data-sub_category_id="{{ $i->id }}_edit">
                                                                <option value="">Select
                                                                    Item</option>
                                                                @foreach ($name as $n)
                                                                    <option value="{{ $n->id }}"
                                                                        @if (isset($i)) @if ($n->id == $i->item_name)
                                        selected @endif
                                                                        @endif
                                                                        >{{ $n->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select></div>
                                                        <textarea name="description[]" class="form-control desc" placeholder="Description" cols="30">{{ isset($i) ? $i->description : '' }}</textarea>
                                                    </td>
                                                    <td><input type="number" name="quantity[]"
                                                            class="form-control item_quantity"
                                                            data-category_id="{{ $i->id }}_edit"
                                                            placeholder="quantity" id="quantity"
                                                            value="{{ isset($i) ? $i->due_quantity : '' }}" required />
                                                        <div class="">
                                                            <p class="form-control-static errors{{ $i->id }}_edit"
                                                                id="errors" style="text-align:center;color:red;">
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
                                                        value="{{ isset($i) ? $i->tax_rate : '' }}" required>
                                                    <td><input type="text" name="total_tax[]"
                                                            class="form-control item_total_tax{{ $i->id }}_edit"
                                                            placeholder="total" required
                                                            value="{{ isset($i) ? $i->total_tax : '' }}" readonly
                                                            jAutoCalc="{quantity} * {price} * {tax_rate}" />
                                                    </td>
                                                    <input type="hidden" name="saved_items_id[]"
                                                        class="form-control item_saved{{ $i->id }}_edit"
                                                        value="{{ isset($i) ? $i->id : '' }}" required />
                                                    <td><input type="text" name="total_cost[]"
                                                            class="form-control item_total{{ $i->id }}_edit"
                                                            placeholder="total" required
                                                            value="{{ isset($i) ? $i->total_cost : '' }}" readonly
                                                            jAutoCalc="{quantity} * {price}" />
                                                    </td>
                                                    <input type="hidden" id="item_id"
                                                        class="form-control item_id{{ $i->id }}_edit"
                                                        value="{{ $i->items_id }}" />
                                                    <input type="hidden" name="items_id[]" class="form-control name_list"
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
                                        <td><input type="text" name="subtotal[]" class="form-control item_total"
                                                value="{{ isset($data) ? '' : '0.00' }}" required
                                                jAutoCalc="SUM({total_cost})" readonly></td>
                                    </tr>
                                    <tr class="line_items">
                                        <td colspan="3"></td>
                                        <td><span class="bold">Tax (+)</span>: </td>
                                        <td><input type="text" name="tax[]" class="form-control item_total"
                                                value="{{ isset($data) ? '' : '0.00' }}" required
                                                jAutoCalc="SUM({total_tax})" readonly>
                                        </td>
                                    </tr>
                                    <tr class="line_items">
                                        <td colspan="3"></td>
                                        <td><span class="bold">Shipping Cost (+)</span>:
                                        </td>
                                        <td><input type="text" name="shipping_cost[]" class="form-control item_shipping"
                                                placeholder="shipping_cost" required
                                                value="{{ isset($data) ? $data->shipping_cost : '0.00' }}">
                                        </td>
                                    </tr>
                                    <tr class="line_items">
                                        <td colspan="3"></td>
                                        <td><span class="bold">Discount (-)</span>: </td>
                                        <td><input type="text" name="discount[]" class="form-control item_discount"
                                                placeholder="discount" required
                                                value="{{ isset($data) ? $data->discount : '0.00' }}">
                                        </td>
                                    </tr>

                                    <tr class="line_items">
                                        <td colspan="3"></td>
                                        <td><span class="bold">Total</span>: </td>
                                        <td><input type="text" name="amount[]" class="form-control item_total"
                                                value="{{ isset($data) ? '' : '0.00' }}" required
                                                jAutoCalc="{subtotal} + {tax} + {shipping_cost} - {discount}" readonly></td>
                                </tfoot>
                            </table>
                        </div>


                        <br>

                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
            <div class="modal-footer ">
                <button class="btn btn-primary" type="submit" id="save"><i
                        class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
                <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>
                    Close</button>
            </div>

        </div>
    @break

@endswitch
