<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">Manage Logistic {{ $data->project_name }} - {{ $data->project_no }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>


    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12 ">

                {!! Form::open(['route' => 'save.cf_details', 'enctype' => 'multipart/form-data']) !!}
                @method('POST')

                <input type="hidden" name="project_id" value="{{ $id }}">
                <input type="hidden" name="storage_id" value="{{ $storage_id }}">
                <input type="hidden" name="type" value="stock">
                <input type="hidden" name="status" value="activeWarehouse">
                <div class="form-group row">
                    <label class="col-lg-2 col-form-label">Source Location</label>
                    <div class="col-lg-4">
                        <select class="form-control m-b start" name="start" required id="start">
                            <option value="">Select Source Location</option>
                            @if (!empty($location))
                                @foreach ($location as $row)
                                    <option
                                        @if (isset($data)) {{ $data->source_store == $row->id ? 'selected' : '' }} @endif
                                        value="{{ $row->id }}">
                                        {{ $row->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <label class="col-lg-2 col-form-label">Destination Location</label>
                    <div class="col-lg-4">
                        <select class="form-control m-b" name="location" required id="supplier_id">
                            <option value="">Select Destination Location</option>
                            @if (!empty($location))
                                @foreach ($location as $row)
                                    <option
                                        @if (isset($data)) {{ $data->destination_store == $row->id ? 'selected' : '' }} @endif
                                        value="{{ $row->id }}">
                                        {{ $row->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>



                <div class="form-group row">
                    <label class="col-lg-2 col-form-label">Date</label>
                    <div class="col-lg-4">
                        <input type="date" name="date" placeholder="0 if does not exist"
                            value="{{ isset($data) ? $data->movement_date : date('Y-m-d') }}" class="form-control"
                            required>
                    </div>
                    <label class="col-lg-2 col-form-label">Staff</label>
                    <div class="col-lg-4">
                        <select class="form-control m-b staff" name="staff" id="staff" required>
                            <option value="">Select </option>
                            @if (!empty($staff))
                                @foreach ($staff as $row)
                                    <option
                                        @if (isset($data)) {{ $data->staff == $row->id ? 'selected' : '' }} @endif
                                        value="{{ $row->id }}">
                                        {{ $row->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-2 col-form-label">Reference</label>
                    <div class="col-lg-4">
                        <input type="text" name="name" placeholder=""
                            value="{{ isset($data) ? $data->name : '' }}" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-2 col-form-label" for="gender">Transport
                        Cost </label>
                    <div class="col-lg-4">
                        <input type="number" name="costs" value="{{ isset($data) ? $data->costs : '' }}"
                            class="form-control costs">

                    </div>

                    @if (!empty($data->account_id))
                        <label for="stall_no" class="col-lg-2 col-form-label bank1" style="display:block;">Payment
                            Account</label>
                        <div class="col-lg-4 bank2" style="display:block;">
                            <select class="form-control m-b" name="account_id">
                                <option value="">Select Payment Account</option>
                                @foreach ($bank_accounts as $bank)
                                    <option value="{{ $bank->id }}"
                                        @if (isset($data)) @if ($data->account_id == $bank->id) selected @endif
                                        @endif
                                        >{{ $bank->account_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <label for="stall_no" class="col-lg-2 col-form-label bank1" style="display:none;">Payment
                            Account</label>
                        <div class="col-lg-4 bank2" style="display:none;">
                            <select class="form-control m-b" name="account_id">
                                <option value="">Select Payment Account</option>
                                @foreach ($bank_accounts as $bank)
                                    <option value="{{ $bank->id }}"
                                        @if (isset($data)) @if ($data->account_id == $bank->id) selected @endif
                                        @endif
                                        >{{ $bank->account_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <br>
                <h4 align="center">Enter Details</h4>
                <hr>
                <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add
                        item</i></button><br>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered" id="cart">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
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
                                            <td><select name="item_id[]" class="form-control m-b item_name"
                                                    data-sub_category_id="{{ $i->order_no }}" required>
                                                    <option value="">Select Item
                                                    </option>
                                                    @foreach ($inventory as $n)
                                                        <option value="{{ $n->id }}"
                                                            @if (isset($i)) @if ($n->id == $i->item_id)
                                                                    selected @endif
                                                            @endif
                                                            >{{ $n->name }}
                                                        </option>
                                                    @endforeach
                                                </select></td>
                                            <td><input type="number" name="quantity[]"
                                                    class="form-control item_quantity"
                                                    data-category_id="{{ $i->order_no }}" placeholder="quantity"
                                                    id="quantity" value="{{ isset($i) ? $i->quantity : '' }}"
                                                    required />
                                                <div class="">
                                                    <p class="form-control-static errors{{ $i->order_no }}"
                                                        id="errors" style="text-align:center;color:red;">
                                                    </p>
                                                </div>
                                            </td>
                                            <input type="hidden" id="item_id"
                                                class="form-control item_id{{ $i->order_no }}"
                                                value="{{ $i->item_id }}" />

                                            <input type="hidden" name="saved_id[]"
                                                class="form-control item_saved{{ $i->order_no }}"
                                                value="{{ isset($i) ? $i->id : '' }}" required />
                                            <td><button type="button" name="remove"
                                                    class="btn btn-danger btn-xs rem"
                                                    value="{{ isset($i) ? $i->id : '' }}"><i
                                                        class="icon-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endif
                        </tfoot>
                    </table>
                </div>
                <br>
                <div class="form-group row">
                    <div class="col-lg-offset-2 col-lg-12">
                      
                            <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit">Save</button>
                       
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@yield('scripts')

<script type="text/javascript">
    $(document).ready(function() {


        var count = 0;


        $('.add').on("click", function(e) {

            count++;
            var html = '';
            html += '<tr class="line_items">';

            html +=
                '<td><select name="item_id[]" class="form-control m-b item_name" required  data-sub_category_id="' +
                count +
                '"><option value="">Select Item</option>@foreach ($inventory as $n) <option value="{{ $n->id }}">{{ $n->name }}</option>@endforeach</select></td>';
            html +=
                '<td><input type="number" name="quantity[]" class="form-control item_quantity" data-category_id="' +
                count +
                '"placeholder ="quantity" id ="quantity" value= "" required /> <div class=""> <p class="form-control-static errors' +
                count + '" id="errors" style="text-align:center;color:red;"></p>   </div></td>';
            html += '<input type="hidden" id="item_id"  class="form-control item_id' + count +
                '" value="" />';
            html +=
                '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

            $('#cart > tbody').append(html);

            /*
             * Multiple drop down select
             */
            $('.m-b').select2({});
        });

        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();

        });


        $(document).on('click', '.rem', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
            $('tbody').append(
                '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');

        });

    });
</script>
