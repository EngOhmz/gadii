<div class="card-header"> <strong></strong> </div>

<div class="card-body">
    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if (
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
                    $type == 'activities' ||
                    $type == 'logistic' ||
                    $type == 'cargo' ||
                    $type == 'storage' ||
                    $type == 'charge') active @endif" id="home-tab2" data-toggle="tab"
                href="#debit-home2" role="tab" aria-controls="home" aria-selected="true">Debit Note
                List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($type == 'edit-debit' || $type == 'debit-good-receive') active @endif" id="profile-tab2" data-toggle="tab"
                href="#debit-profile2" role="tab" aria-controls="profile" aria-selected="false">New Debit Note</a>
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
                $type == 'activities' ||
                $type == 'logistic' ||
                $type == 'cargo' ||
                $type == 'storage' ||
                $type == 'charge') active show @endif " id="debit-home2"
            role="tabpanel" aria-labelledby="home-tab2">
            <div class="table-responsive">
                <table class="table datatable-attachcf table-striped" style="width:100%">
                    <thead>
                        <tr role="row">

                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 126.484px;">Ref No</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 126.484px;">Purchase No</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 186.484px;">Supplier Name</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 136.484px;">Return Date</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 161.219px;">Due Amount</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Status</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                style="width: 168.1094px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (!empty($dn))
                            @foreach ($dn as $row)
                                <tr class="gradeA even" role="row">
                                    <td>
                                        <a class="nav-link" id="profile-tab2"
                                            href="{{ route('debit_note.show', $row->id) }}" role="tab"
                                            aria-selected="false">{{ $row->reference_no }}</a>
                                    </td>

                                    <td> {{ $row->purchase->reference_no }}</td>
                                    <td>
                                        {{ $row->supplier->name }}
                                    </td>

                                    <td>{{ $row->return_date }}</td>

                                    <td>{{ number_format($row->due_amount, 2) }} {{ $row->exchange_code }}</td>
                                    <td>
                                        @if ($row->status == 0)
                                            <div class="badge badge-danger badge-shadow">Not Approved</div>
                                        @elseif($row->status == 1)
                                            <div class="badge badge-success badge-shadow">Approved</div>
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
                                            @if ($row->status == 0)
                                                <a class="list-icons-item text-primary" title="Edit"
                                                    href="{{ route('edit.project_details', ['type' => 'edit-debit', 'type_id' => $row->id]) }}"><i
                                                        class="icon-pencil7"></i></a>&nbsp
                                                <a class="list-icons-item text-danger" title="Edit"
                                                    href="{{ route('delete.project_details', ['type' => 'delete-debit', 'type_id' => $row->id]) }}"
                                                    onclick="return confirm('Are you sure, you want to delete?')"><i
                                                        class="icon-trash"></i></a>&nbsp
                                            @endif
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item dropdown-toggle text-teal"
                                                    data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                <div class="dropdown-menu">
                                                    @if ($row->status == 0)
                                                        <a class="nav-link" id="profile-tab2"
                                                            href="{{ route('edit.project_details', ['type' => 'debit-good-receive', 'type_id' => $row->id]) }}">Approve
                                                            Debit Note</a>
                                                    @endif
                                                    <a class="nav-link" id="profile-tab2"
                                                        href="{{ route('debit_note_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}"
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
        <div class="tab-pane fade  @if ($type == 'edit-debit' || $type == 'debit-good-receive') active show @endif" id="debit-profile2"
            role="tabpanel" aria-labelledby="profile-tab2">
            <br>
            <div class="card">
                <div class="card-header">
                    @if ($type == 'edit-debit' || $type == 'debit-good-receive')
                        <h5>Edit Debit Note</h5>
                    @else
                        <h5>Add New Debit Note</h5>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 ">
                            @if ($type == 'edit-debit' || $type == 'debit-good-receive')

                                {!! Form::open(['route' => 'update.project_details', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="id" value="{{ $type_id }}">
                            @else
                                {!! Form::open(['route' => 'save.project_details', 'enctype' => 'multipart/form-data']) !!}
                                @method('POST')
                            @endif


                            <input type="hidden" name="project_id" value="{{ $id }}"
                                class="form-control dn-project">
                            <input type="hidden" name="type" value="debit">

                            <input type="hidden" name="receive" value="{{ isset($receive) ? $receive : '' }}">

                            <div class="form-group row">

                                <label class="col-lg-2 col-form-label">Supplier Name <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">

                                    <select class="form-control m-b edn-client" name="supplier_id" required
                                        id="edn-supplier_id">
                                        <option value="">Select Supplier Name</option>
                                        @if (!empty($supplier))
                                            @foreach ($supplier as $row)
                                                <option
                                                    @if (isset($edit_data)) {{ $edit_data->supplier_id == $row->id ? 'selected' : '' }} @endif
                                                    value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>


                                <label class="col-lg-2 col-form-label">Purchases<span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">

                                    @if (!empty($edit_data))
                                        <select class="form-control m-b edn-invoice" name="purchase_id" required
                                            id="edn-invoice_id">
                                            <option value="">Select Purchases</option>
                                            @if (!empty($invoice))
                                                @foreach ($invoice as $row)
                                                    <option
                                                        @if (isset($edit_data)) {{ $edit_data->purchase_id == $row->id ? 'selected' : '' }} @endif
                                                        value="{{ $row->id }}">{{ $row->reference_no }}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    @else
                                        <select class="form-control m-b edn-invoice" name="purchase_id" required
                                            id="edn-invoice_id">
                                            <option value="">Select Purchases</option>


                                        </select>
                                    @endif

                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Return Date <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="date" name="return_date" required placeholder=""
                                        value="{{ isset($edit_data) ? $edit_data->return_date : date('Y-m-d') }}"
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


                            <div class="table-responsive">
                                <table class="table table-bordered" id="dn-cart">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-3">Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Tax</th>
                                            <th class="col-sm-2">Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if (!empty($id))
                                            @if (!empty($items))
                                                @foreach ($items as $i)
                                                    <tr class="line_items">
                                                        <td><select name="item_name[]"
                                                                class="form-control  m-b item_name" required disabled>
                                                                <option value="">Select Item</option>
                                                                @foreach ($name as $n)
                                                                    <option value="{{ $n->id }}"
                                                                        @if (isset($i)) @if ($n->id == $i->item_name)
                                                                        selected @endif
                                                                        @endif
                                                                        >{{ $n->name }}</option>
                                                                @endforeach
                                                            </select></td>
                                                        <td><input type="number" name="quantity[]"
                                                                class="form-control dn-item_quantity"
                                                                placeholder="quantity" id="quantity"
                                                                data-sub_category_id="{{ $i->order_no }}_qty"
                                                                value="{{ isset($i) ? $i->quantity : '' }}"
                                                                required />
                                                            <div class="">
                                                                <p class="form-control-static dn-errors{{ $i->order_no }}_qty"
                                                                    id="errors"
                                                                    style="text-align:center;color:red;"></p>
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="price[]"
                                                                class="form-control item_price{{ $i->order_no }}"
                                                                placeholder="price" required
                                                                value="{{ isset($i) ? $i->price : '' }}" readonly />
                                                        </td>
                                                        <input type="hidden" name="unit[]"
                                                            class="form-control item_unit{{ $i->order_no }}"
                                                            placeholder="unit" required
                                                            value="{{ isset($i) ? $i->unit : '' }}" readonly />
                                                        <td><select name="tax_rate[]"
                                                                class="form-control  m-b item_tax'+count{{ $i->order_no }}"
                                                                required disabled>
                                                                <option value="0">Select Tax Rate</option>
                                                                <option value="0"
                                                                    @if (isset($i)) @if ('0' == $i->tax_rate) selected @endif
                                                                    @endif>No tax</option>
                                                                <option value="0.18"
                                                                    @if (isset($i)) @if ('0.18' == $i->tax_rate) selected @endif
                                                                    @endif>18%</option>
                                                            </select></td>
                                                        <input type="hidden" name="total_tax[]"
                                                            class="form-control item_total_tax{{ $i->order_no }}'"
                                                            placeholder="total" required
                                                            value="{{ isset($i) ? $i->total_tax : '' }}" readonly
                                                            jAutoCalc="{quantity} * {price} * {tax_rate}" />

                                                        <td><input type="text" name="total_cost[]"
                                                                class="form-control item_total{{ $i->order_no }}"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_cost : '' }}" readonly
                                                                jAutoCalc="{quantity} * {price}" /></td>
                                                        <input type="hidden" name="items_id[]"
                                                            class="form-control name_list"
                                                            value="{{ isset($i) ? $i->items_id : '' }}" />
                                                        <input type="hidden" name="return_item[]" id="item"
                                                            class="form-control id{{ $i->order_no }}_qty"
                                                            value="{{ isset($i) ? $i->return_item : '' }}" />
                                                        <input type="hidden" name="item_id[]" id="item_id"
                                                            class="form-control id{{ $i->order_no }}"
                                                            value="{{ isset($i) ? $i->id : '' }}" />
                                                        <td><button type="button" name="remove"
                                                                class="btn btn-danger btn-xs edn-remove"
                                                                value="{{ isset($i) ? $i->id : '' }}"><i
                                                                    class="icon-trash"></i></button></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr class="line_items">
                                            <td colspan="3"></td>
                                            <td><span class="bold">Sub Total </span>: </td>
                                            <td><input type="text" name="subtotal[]"
                                                    class="form-control item_total" placeholder="subtotal" required
                                                    jAutoCalc="SUM({total_cost})" readonly></td>
                                        </tr>
                                        <tr class="line_items">
                                            <td colspan="3"></td>
                                            <td><span class="bold">Tax </span>: </td>
                                            <td><input type="text" name="tax[]" class="form-control item_total"
                                                    placeholder="tax" required jAutoCalc="SUM({total_tax})" readonly>
                                            </td>
                                        </tr>

                                        <tr class="line_items">
                                            <td colspan="3"></td>
                                            <td><span class="bold">Total</span>: </td>
                                            <td><input type="text" name="amount[]" class="form-control item_total"
                                                    placeholder="total" required jAutoCalc="{subtotal} + {tax}"
                                                    readonly>
                                            </td>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <br>
                            <div class="form-group row">
                                <div class="col-lg-offset-2 col-lg-12">

                                    <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"
                                        id="dn-save">Save</button>

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
@section('scripts')
    <script src="{{ asset('assets/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/sortable.min.js') }}"></script>
    <script src="{{ asset('assets/js/uploader_bootstrap.js') }}"></script>
    <script>
        $('.datatable-table').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "targets": [1]
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
@endsection
