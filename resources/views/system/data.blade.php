@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>System Settings</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2"
                                        role="tab" aria-controls="home" aria-selected="true">System Settings
                                        Details</a>
                                </li>
                                <!--
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif" id="profile-tab2"
                                        data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                        aria-selected="false">New System Settings</a>
                                </li>
    -->
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <!--
                                <div class="tab-pane fade @if (empty($id)) active show @endif" id="home2" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped" id="table-1">
                                           <thead>
                                                <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="width: 28.531px;">#</th>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 186.484px;">System Name</th>
                                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Email</th>
                                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Phone</th>
                                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Address</th>
                                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 126.484px;">VAT</th>
                                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 126.484px;">TIN</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 126.484px;">System Logo</th>
                                                   
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                @if (!@empty($system))
                                                @foreach ($system as $row)
    <tr class="gradeA even" role="row">
                                                    <th>{{ $loop->iteration }}</th>
                                                    <td>{{ $row->name }}</td>
                                                    <td>{{ $row->email }}</td>
                                                    <td>{{ $row->address }}</td>
                                                    <td>{{ $row->phone }}</td>
                                                    <td>{{ $row->vat }}</td>
                                                    <td>{{ $row->tin }}</td>
                                                    <td><img src="{{ url('public/assets/img/logo') }}/{{ $row->picture }}" alt="{{ $row->name }}" width="50"></td>

                                                  

                                                    <td>
                                                        <div class="form-inline">
                                                           
    <a class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')"   href="{{ route('system.edit', $row->id) }}"><i class="icon-pencil7"></i></a>
                                                            &nbsp
                                                         
                                                            
                                                                {!! Form::open(['route' => ['system.destroy', $row->id], 'method' => 'delete']) !!}
                                                             {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                           &nbsp
                                                         
                                                        </div>
                                                      

                                                 

                                                    </td>
                                                </tr>
    @endforeach

                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

    -->

                                <div class="tab-pane active" id="profile2" role="tabpanel"
                                    aria-labelledby="profile-tab2">

                                    <div class="card">

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if ($id > 0)
                                                        {{ Form::model($id, ['route' => ['system.update', $id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                                                    @else
                                                        {!! Form::open(['route' => 'system.store', 'enctype' => 'multipart/form-data']) !!}
                                                        @method('POST')
                                                    @endif


                                                    <h4>Company Details</h4>
                                                    <hr>

                                                    <br>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Company Name</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="name" required
                                                                value="{{ isset($data) ? $data->name : '' }}"
                                                                class="form-control">
                                                        </div>

                                                        <label class="col-lg-2 col-form-label">Address</label>
                                                        <div class="col-lg-4">
                                                            <textarea name="address" class="form-control" rows="3" required>
                                                            {{ isset($data) ? $data->address : '' }}
                                                            </textarea>
                                                        </div>



                                                    </div>



                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Email</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="email" required
                                                                value="{{ isset($data) ? $data->email : '' }}"
                                                                class="form-control">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Phone</label>
                                                        <div class="col-lg-4">
                                                            <input id="phone" type="phone"
                                                                class="form-control phone"
                                                                value="{{ isset($data) ? $data->phone : '' }}"
                                                                name="phone_number" required>

                                                            <div class="form-group col-12 row">
                                                                <div align="center">
                                                                    <p class="form-control-static errors23" id="errors"
                                                                        style="text-align:center;color:red;"></p>

                                                                    <span id="valid-msg" class="hide"></span>
                                                                    <span id="error-msg" class="hide"></span>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">TIN</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="tin"
                                                                value="{{ isset($data) ? $data->tin : '' }}"
                                                                class="form-control">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">VRN</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="vat"
                                                                value="{{ isset($data) ? $data->vat : '' }}"
                                                                class="form-control">
                                                        </div>


                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">System Logo</label>
                                                        <div class="col-lg-4">
                                                            @if (!empty($data->picture))

                                                                <input type="file" name="picture"
                                                                    value="{{ $data->picture }}" class="form-control"
                                                                    onchange="loadBigFile(event)"><br>

                                                                <img src="{{ url('public/assets/img/logo') }}/{{ $data->picture }}"
                                                                    alt="{{ $data->name }}" width="100"><br>
                                                            @else
                                                                <input type="file" name="picture" required
                                                                    class="form-control" onchange="loadBigFile(event)">
                                                            @endif

                                                            <br>
                                                            <img id="big_output" width="100">
                                                        </div>


                                                         <label class="col-lg-2 col-form-label">Signature</label>
                                                        <div class="col-lg-4">
                                                            @if (!empty($data->signature))

                                                                <input type="file" name="signature"
                                                                    value="{{ $data->signature }}" class="form-control"
                                                                    onchange="loadBigFile(event)"><br>

                                                                <img src="{{ url('public/assets/img/signature') }}/{{ $data->signature }}"
                                                                    alt="{{ $data->name }}" width="100"><br>
                                                            @else
                                                                <input type="file" name="signature" required
                                                                    class="form-control" onchange="loadBigFile(event)">
                                                            @endif

                                                            <br>
                                                            <img id="big_output" width="100">
                                                        </div>

                                                        <?php
                                                        $bfr = App\Models\JournalEntry::where('added_by', auth()->user()->added_by)->count();
                                                        ?>

                                                         <label class="col-lg-2 col-form-label">Stamp</label>
                                                        <div class="col-lg-4">
                                                            @if (!empty($data->stamp))

                                                                <input type="file" name="stamp"
                                                                    value="{{ $data->stamp }}" class="form-control"
                                                                    onchange="loadBigFile(event)"><br>

                                                                <img src="{{ url('public/assets/img/stamp') }}/{{ $data->stamp }}"
                                                                    alt="{{ $data->name }}" width="100"><br>
                                                            @else
                                                                <input type="file" name="stamp" required
                                                                    class="form-control" onchange="loadBigFile(event)">
                                                            @endif

                                                            <br>
                                                            <img id="big_output" width="100">
                                                        </div>


                                                        <label class="col-lg-2 col-form-label">Default Currency</label>
                                                        <div class="col-lg-4">

                                                            @if ($bfr == '0')
                                                                <select class="form-control m-b" id="currency"
                                                                    name="currency" required>
                                                                    <option value="">Select Currency</option>

                                                                    @foreach ($currency as $cur)
                                                                        <option value="{{ $cur->code }}"
                                                                            @if (isset($data)) @if ($data->currency == $cur->code) selected @endif
                                                                            @endif>{{ $cur->name }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            @else
                                                                <select class="form-control m-b" id="currency" disabled>
                                                                    <option value="">Select Currency</option>

                                                                    @foreach ($currency as $cur)
                                                                        <option value="{{ $cur->code }}"
                                                                            @if (isset($data)) @if ($data->currency == $cur->code) selected @endif
                                                                            @endif>{{ $cur->name }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>

                                                                <input type="hidden" name="currency"
                                                                    value="{{ isset($data) ? $data->currency : '' }}"
                                                                    class="form-control">

                                                                <br><small> You cannot change because you already have
                                                                    transactions</small>
                                                            @endif
                                                        </div>

                                                    </div>



                                                    <h4>Bank Details</h4>
                                                    <hr>

                                                    <br>


                                                    <button type="button" name="add"
                                                        class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add
                                                            Details</i></button><br><br>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                            <thead>
                                                                <tr>
                                                                    <th>Account Name</th>
                                                                    <th>Account Number</th>
                                                                    <th>Bank Name</th>
                                                                    <th>Branch Name</th>
                                                                    <th>Swift Code</th>
                                                                    <th>Currency</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                            </tbody>
                                                            <tfoot>
                                                                @if (!empty($id))
                                                                    @if (!empty($item))
                                                                        @foreach ($item as $i)
                                                                            <tr class="line_items">
                                                                                <td> <input type="text"
                                                                                        name="account_name[]"
                                                                                        value="{{ isset($i) ? $i->account_name : '' }}"
                                                                                        class="form-control" required>
                                                                                </td>
                                                                                <td> <input type="text"
                                                                                        name="account_number[]"
                                                                                        value="{{ isset($i) ? $i->account_number : '' }}"
                                                                                        class="form-control" required>
                                                                                </td>
                                                                                <td> <input type="text"
                                                                                        name="bank_name[]"
                                                                                        value="{{ isset($i) ? $i->bank_name : '' }}"
                                                                                        class="form-control" required>
                                                                                </td>
                                                                                <td> <input type="text"
                                                                                        name="branch_name[]"
                                                                                        value="{{ isset($i) ? $i->branch_name : '' }}"
                                                                                        class="form-control" required>
                                                                                </td>
                                                                                <td> <input type="text"
                                                                                        name="swift_code[]"
                                                                                        value="{{ isset($i) ? $i->swift_code : '' }}"
                                                                                        class="form-control" required>
                                                                                </td>
                                                                                <td><select name="exchange_code[]"
                                                                                        id="currency_code"
                                                                                        class="form-control  m-b" required>
                                                                                        <option
                                                                                            value="{{ old('currency_code') }}">
                                                                                            Choose option</option>
                                                                                        @if (isset($currency))
                                                                                            @foreach ($currency as $row)
                                                                                                <option
                                                                                                    @if (isset($i)) {{ $i->exchange_code == $row->code ? 'selected' : 'TZS' }} @endif
                                                                                                    value="{{ $row->code }}">
                                                                                                    {{ $row->name }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </select></td>
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


                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                    <br>
                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">

                                                            <button
                                                                class="btn btn-sm btn-primary float-right m-t-n-xs save"
                                                                type="submit" id="save">Save</button>

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



@endsection

@section('scripts')
    <script src="{{ asset('assets/intl/js/intlTelInput.min.js') }}"></script>

    <script>
        var loadBigFile = function(event) {
            var output = document.getElementById('big_output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "orderable": false,
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
    </script>


    <script type="text/javascript">
        $(document).ready(function() {


            var count = 0;

            $('.add').on("click", function(e) {

                count++;
                var html = '';
                html += '<tr class="line_items">';
                html += '<td><input type="text" name="account_name[]"  class="form-control" required></td>';
                html +=
                    '<td><input type="text" name="account_number[]"   class="form-control" required></td>';
                html += '<td><input type="text" name="bank_name[]"   class="form-control" required></td>';
                html += '<td><input type="text" name="branch_name[]"   class="form-control" required></td>';
                html += '<td><input type="text" name="swift_code[]"   class="form-control" required></td>';
                html +=
                    '<td><select name="exchange_code[]" id="currency_code" class="form-control  m-b" required><option value="{{ old('currency_code') }}"  >Choose option</option>@foreach ($currency as $row)<option value="{{ $row->code }}" >{{ $row->name }}</option> @endforeach</select></td>';
                html +=
                    '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

                $('tbody').append(html);

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
                $('tfoot').append(
                    '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                    btn_value + '"/>');
            });

        });
    </script>


    <script type="text/javascript">
        $(document).on("change", function() {

            var prefix = $('#prefix').val();
            console.log(prefix);
            var start = $('#start').val();

            var format = " " + prefix + "/CM/00" + start + " ";
            $('.format').val(format);




        });
    </script>

    <script>
        var input = document.querySelector("#phone"),
            errorMsg = document.querySelector("#error-msg"),
            validMsg = document.querySelector("#valid-msg");

        // Error messages based on the code returned from getValidationError
        var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];



        // Initialise plugin
        var intl = window.intlTelInput(input, {
            separateDialCode: true,
            initialCountry: "auto",
            hiddenInput: "phone",
            geoIpLookup: function(success, failure) {
                $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    success(countryCode);
                });
            },


            utilsScript: '{{ url('assets/intl/js/utils.js') }}'
        });

        var reset = function() {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
            validMsg.classList.add("hide");
        };

        // Validate on blur event
        input.addEventListener('blur', function() {
            reset();
            $('.save').attr("disabled", false);
            if (input.value.trim()) {
                if (intl.isValidNumber()) {
                    validMsg.classList.remove("hide");
                } else {
                    input.classList.add("error");
                    var errorCode = intl.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                    console.log(23);
                    $('.save').attr("disabled", true);
                }
            }
        });

        // Reset on keyup/change event
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    </script>
@endsection

