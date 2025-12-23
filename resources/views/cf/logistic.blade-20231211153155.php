<div class="card-header">
    <strong></strong>
</div>
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
                href="#logistic-home2" role="tab" aria-controls="home" aria-selected="true">Quotation
                List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($type == 'edit-logistic') active @endif" id="profile-tab2" data-toggle="tab"
                href="#logistic-profile2" role="tab" aria-controls="profile" aria-selected="false">New Quotation
            </a>
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
                $type == 'charge' ||
                $type == 'stock') active show @endif " id="logistic-home2"
            role="tabpanel" aria-labelledby="home-tab2">
            <div class="table-responsive">
                <table class="table datatable-attachcf table-striped" id="table-logistic">
                    <thead>
                        <tr>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 26.484px;">#</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 126.484px;">Date</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 106.484px;">Reference No</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 141.219px;">Shipment Name</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 146.484px;">Client Name</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 141.219px;">Due Amount</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 81.219px;">Status</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                style="width: 158.1094px;">Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if (!@empty($logistic))
                            @foreach ($logistic as $row)
                                <tr class="gradeA even" role="row">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->date }}</td>
                                    <td>{{ $row->pacel_number }}</td>
                                    <td>{{ $row->pacel_name }}</td>
                                    <td>{{ $row->due_date }}</td>
                                    <td>{{ $row->due_date }}</td>
                                    <td>{{ $row->status }}</td>
                                    <td>
                                        <div class="form-inline">
                                            <a class="list-icons-item text-primary" title="Edit"
                                                href="{{ route('edit.cf_details', ['type' => 'edit-cargo', 'type_id' => $row->id]) }}"><i
                                                    class="icon-pencil7"></i></a>&nbsp

                                            <a class="list-icons-item text-danger" title="Edit"
                                                href="{{ route('delete.cf_details', ['type' => 'delete-cargo', 'type_id' => $row->id]) }}"
                                                onclick="return confirm('Are you sure, you want to delete?')"><i
                                                    class="icon-trash"></i></a>&nbsp

                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item dropdown-toggle text-teal"
                                                    data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                <div class="dropdown-menu">
                                                    <a class="nav-link" data-toggle="modal"
                                                        data-target="#exampleModal">
                                                        Storage
                                                    </a>
                                                    <a class="nav-link" data-toggle="modal" data-target="#charge">
                                                        Charge
                                                    </a>
                                                    <a class="nav-link" href="" data-toggle="modal"
                                                        value="{{ $data->id }}" data-type="cargotype"
                                                        data-target="#app2FormModal"
                                                        onclick="model({{ $row->id }},'cargotype')">Logistic</a>
                                                </div>

                                            </div>

                                        </div>
                                    </td>
                                <tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade  @if ($type == 'edit-logistic') active show @endif" id="logistic-profile2"
            role="tabpanel" aria-labelledby="profile-tab2">
            <br>
            <div class="card">
                <div class="card-header">
                    @if ($type == 'edit-quotation')
                        <h5>Edit Quotation</h5>
                    @else
                        <h5>Add New Quotation</h5>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 ">
                            @if ($type == 'edit-quotation')
                                {{ Form::model($id, ['route' => ['pacel_cf.store', $id], 'method' => 'PUT']) }}
                            @else
                                {{ Form::open(['route' => 'pacel_cf.store']) }}
                                @method('POST')
                            @endif

                            <input type="hidden" name="type" value="" class="form-control" required>
                            <input type="hidden" name="cf_id" value="{{ $id }}" class="form-control"
                                required>
                            <div class="form-group row"><label class="col-lg-2 col-form-label">Cargo Name</label>
                                @if (!empty($tbl_ctype))
                                    @php $c = $tbl_ctype->name_id; @endphp
                                @else
                                    @php $c = " "; @endphp
                                @endif
                                @php $cargo_name = App\Models\CF\Cargo::find($c); @endphp
                                <div class="col-lg-10">
                                    <input type="text" name="pacel_name"
                                        value=" @if (!empty($tbl_ctype)) {{ $cargo_name->name }} @endif "
                                        class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-group row"><label class="col-lg-2 col-form-label">Cargo Weight</label>
                                <div class="col-lg-10">
                                    <input type="text" name="weight"
                                        value=" @if (!empty($tbl_ctype)) {{ $cargo_name->cargo_weight }} @endif "
                                        class="form-control" required readonly>
                                </div>
                            </div>

                            <div class="form-group row"><label class="col-lg-2 col-form-label">Client Name</label>
                                @if (!empty($pro_det->client_id))
                                    @php $cname = $pro_det->client_id; @endphp
                                @else
                                    @php $cname = " "; @endphp
                                @endif
                                <div class="col-lg-10">
                                    @php $clientName= App\Models\Client::find($cname); @endphp
                                    <input type="text" name=""
                                        value=" @if (!empty($pro_det->client_id)) {{ $clientName->name }} @endif "
                                        class="form-control" required readonly>
                                    <input type="hidden" name="owner_id"
                                        value=" @if (!empty($clientName)) {{ $clientName->id }} @endif "
                                        class="form-control" required readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Date</label>
                                <div class="col-lg-10">
                                    <input type="date" name="date" placeholder="0 if does not exist"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Due Date</label>
                                <div class="col-lg-10">
                                    <input type="date" name="due_date" placeholder="0 if does not exist"
                                        value="{{ isset($data) ? $data->due_date : strftime(date('Y-m-d', strtotime('+10 days'))) }}"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group row"><label class="col-lg-2 col-form-label">Instructions</label>
                                <div class="col-lg-10">
                                    <textarea name="instructions" class="form-control">{{ isset($data) ? $data->instructions : '' }}</textarea>
                                </div>
                            </div>

                            <br>
                            <h4 align="center">Enter Item Details</h4>
                            <hr>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Currency</label>
                                <div class="col-lg-4">
                                    @if (!empty($data->currency_code))

                                        <select class="form-control m-b" name="currency_code" id="currency_code"
                                            required>
                                            <option value="{{ old('currency_code') }}" disabled selected>Choose option
                                            </option>
                                            @if (isset($currency))
                                                @foreach ($currency as $row)
                                                    <option
                                                        @if (isset($data)) {{ $data->currency_code == $row->code ? 'selected' : 'TZS' }} @endif
                                                        value="{{ $row->code }}">{{ $row->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    @else
                                        <select class="form-control m-b" name="currency_code" id="currency_code"
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
                                        value="{{ isset($data) ? $data->exchange_rate : '1.00' }}"
                                        class="form-control" required>
                                </div>
                            </div>
                            <hr>
                            <button type="button" name="add" class="btn btn-success btn-xs add-quo"><i
                                    class="icon-plus-circle2"> </i> Add item</button><br>

                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table_quo">
                                    <thead>
                                        <tr>
                                            <th>Route Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Charge Type</th>
                                            <th>Tax</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                    <tfoot>
                                        @if (!empty($id))
                                            @if (!@empty($items))
                                                @foreach ($items as $i)
                                                    <tr class="line_items ">
                                                        <td><select name="item_name[]"
                                                                class="form-control m-b item_name" required
                                                                data-sub_category_id={{ $i->order_no }}>
                                                                <option value="">Select Route</option>
                                                                @foreach ($route as $n)
                                                                    <option value="{{ $n->id }}"
                                                                        @if (isset($i)) @if ($n->id == $i->item_name) selected @endif
                                                                        @endif
                                                                        >{{ $n->from }} - {{ $n->to }}
                                                                    </option>
                                                                @endforeach
                                                            </select></td>
                                                        <td><input type="text" name="quantity[]"
                                                                class="form-control item_quantity{{ $i->order_no }}"
                                                                placeholder="quantity" id="quantity"
                                                                value="{{ isset($i) ? $i->quantity : '' }}"
                                                                required /></td>
                                                        <td><input type="text" name="price[]"
                                                                class="form-control item_price{{ $i->order_no }}"
                                                                placeholder="price" required
                                                                value="{{ isset($i) ? $i->price : '' }}" /></td>
                                                        <td><select name="charge[]"
                                                                class="form-control m-b item_charge'+count{{ $i->order_no }}"
                                                                required>
                                                                <option value="0">Select Charge</option>
                                                                <option value="1"
                                                                    @if (isset($i)) @if ('Flat' == $i->charge_type) selected @endif
                                                                    @endif>Flat</option>
                                                                <option value="{{ $i->distance }}" name="one"
                                                                    @if (isset($i)) @if ('Distance' == $i->charge_type) selected @endif
                                                                    @endif>Distance per ton
                                                                </option>
                                                                <option value="{{ $data->weight }}" name="two"
                                                                    @if (isset($i)) @if ('Rate' == $i->charge_type)  selected @endif
                                                                    @endif>Rate per weight</option>
                                                            </select>
                                                        </td>
                                                        <td><select name="tax_rate[]"
                                                                class="form-control m-b item_tax'+count{{ $i->order_no }}"
                                                                required>
                                                                <option value="0">Select Tax </option>
                                                                <option value="0"
                                                                    @if (isset($i)) @if ($i->tax_rate) selected @endif
                                                                    @endif>No tax</option>
                                                                <option value="0.18"
                                                                    @if (isset($i)) @if ('0.18' == $i->tax_rate) selected @endif
                                                                    @endif>18%</option>
                                                            </select>
                                                        </td>
                                                        <input type="hidden" name="total_tax[]"
                                                            class="form-control item_total_tax{{ $i->order_no }}'"
                                                            placeholder="total" required
                                                            value="{{ isset($i) ? $i->total_tax : '' }}" readonly
                                                            jAutoCalc="{quantity} * {price} * {charge} * {tax_rate}" />
                                                        <input type="hidden" name="items_id[]"
                                                            class="form-control item_saved{{ $i->order_no }}"
                                                            value="{{ isset($i) ? $i->items_id : '' }}" required />
                                                        <input type="hidden" name="distance[]"
                                                            class="form-control item_distance{{ $i->order_no }}"
                                                            required value="{{ isset($i) ? $i->distance : '' }}" />
                                                        <td><input type="text" name="total_cost[]"
                                                                class="form-control item_total{{ $i->order_no }}"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_cost : '' }}" readonly
                                                                jAutoCalc="{quantity} * {price} * {charge} " /></td>
                                                        <input type="hidden" name="pacel_item_id[]"
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
                                            <td colspan="4"></td>
                                            <td><span class="bold">Sub Total </span>: </td>
                                            <td><input type="text" name="subtotal[]" class="form-control total"
                                                    placeholder="subtotal" required jAutoCalc="SUM({total_cost})"
                                                    readonly>
                                            </td>
                                        </tr>
                                        <tr class="line_items">
                                            <td colspan="4"></td>
                                            <td><span class="bold">Tax </span>: </td>
                                            <td><input type="text" name="tax[]" class="form-control tax_total"
                                                    placeholder="tax" required jAutoCalc="SUM({total_tax})" readonly>

                                            </td>
                                        </tr>
                                        @if (!@empty($data->discount > 0))
                                            <tr class="line_items">
                                                <td colspan="4"></td>
                                                <td><span class="bold">Discount</span>: </td>
                                                <td><input type="text" name="discount[]"
                                                        class="form-control item_discount" placeholder="total"
                                                        required value="{{ isset($data) ? $data->discount : '' }}"
                                                        readonly>
                                                </td>
                                            </tr>
                                        @endif

                                        <tr class="line_items">
                                            <td colspan="4"></td>
                                            @if (!@empty($data->discount > 0))
                                                <td><span class="bold">Total</span>: </td>
                                                <td><input type="text" name="amount[]"
                                                        class="form-control item_total" placeholder="total" required
                                                        jAutoCalc="{subtotal} + {tax} - {discount}" readonly></td>
                                            @else
                                                <td><span class="bold">Total</span>: </td>
                                                <td><input type="text" name="amount[]"
                                                        class="form-control t_total" placeholder="total" required
                                                        jAutoCalc="{subtotal} + {tax}" readonly>

                                                </td>
                                            @endif
                                        </tr>
                                    </tfoot>
                                </table>
                                <br>
                                <div class="form-group row">
                                    <div class="col-lg-offset-2 col-lg-12">
                                        @if (!@empty($id))
                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                type="submit">Save</button>
                                        @else
                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                data-toggle="modal" data-target="#myModal"
                                                type="submit">Update</button>
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


 


<!-- here test div nimeondoa 3-->

@yield('scripts')
<script>
    $(document).ready(function() {

        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('change', '.item_name', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('sub_category_id');
            var weight = $('.weight').val();
            $.ajax({
                url: '{{ url('findPacelPrice') }}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.item_distance' + sub_category_id).val(data[0]["distance"]);
                    $('.item_charge' + sub_category_id).find('option[name="one"]').val(data[
                        0]["distance"]);
                    $('.item_charge' + sub_category_id).find('option[name="two"]').val(
                        weight);
                }

            });


        });

        $(document).on('change', '.item_tax_rate', function() {
            var sub_category_id = $(this).data('sub_category_id');;
            console.log(sub_category_id);

            var data = $(this).val();
            $('.item_tax' + sub_category_id).val(data);

        })

    });
</script>

<script>
    $(document).ready(function() {

    });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        var count = 0;

        function autoCalcSetup() {
            $('table#table_quo').jAutoCalc('destroy');
            $('table#table_quo tr.line_items').jAutoCalc({
                keyEventsFire: true,
                decimalPlaces: 2,
                emptyAsZero: true
            });
            $('table#table_quo').jAutoCalc({
                decimalPlaces: 2
            });
        }
        autoCalcSetup();

        $('.add-quo').on("click", function(e) {

            count++;
            var html = '';
            html += '<tr class="line_items">';
            html +=
                '<td><select name="item_name[]" class="form-control m-b item_name" required  data-sub_category_id="' +
                count +
                '"><option value="">Select Item</option>@foreach ($route as $n) <option value="{{ $n->id }}"> {{ $n->from }} - {{ $n->to }} </option>@endforeach</select></td>';
            html +=
                '<td><input type="text" name="quantity[]" class="form-control item_quantity" data-category_id="' +
                count + '" placeholder ="quantity" id ="quantity" required /></td>';
            html += '<td><input type="text" name="price[]" class="form-control item_price' + count +
                '" placeholder ="price" required  value=""/></td>';
            html += '<td><select name="charge[]" class="form-control m-b item_charge' + count +
                '" required   data-sub_category_id="' + count +
                '" ><option value="0">Select Charge </option><option value="1">Flat</option><option value="" name="one">Distance per ton</option><option value="" name="two">Rate per weight</option></select></td>';
            html += '<td><select name="tax_rate[]" class="form-control m-b item_tax' + count +
                '" required ><option value="0">Select Tax </option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
            html += '<input type="hidden" name="tax_rate[]" class="form-control item_tax' + count +
                '"  value="0" required   />';
            html += '<input type="hidden" name="items_id[]" class="form-control item_saved' + count +
                '"  required   />';
            html += '<input type="hidden"  name="distance[]" class="form-control item_distance' +
                count + '"  required  value="" />';
            html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax' +
                count +
                '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {charge} * {tax_rate}"   />';
            html += '<td><input type="text" name="total_cost[]" class="form-control item_total' +
                count +
                '" placeholder ="total"  jAutoCalc="{quantity} * {price}  * {charge}" required readonly  />';
            html +=
                '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

            $('#table_quo>tbody').append(html);
            autoCalcSetup();
            /*
             * Multiple drop down select
             */
            $('.m-b').select2({});

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
    function saveRoute(e) {

        var to = $('#to').val();
        var distance = $('#distance').val();
        var from = $('#from').val();
        $.ajax({
            type: 'GET',
            url: '{{ url('addRoute') }}',
            data: {
                'to': to,
                'distance': distance,
                'from': from,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);

                var id = response.id;
                var arrival_point = response.from;
                var destination_point = response.to;

                var option = "<option value='" + id + "'  selected>From " + arrival_point + " to " +
                    destination_point + "</option>";

                $('#route').append(option);
                $('#app2FormModal').hide();



            }

        });
    }
</script>
