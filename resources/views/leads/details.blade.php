@extends('layouts.master')



@section('content')


    <section class="section">
        <div class="section-body">

            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $data->lead_name }}</h4>
                            <hr>
                        </div>

                        <div class="card-body">
                            <div class="d-lg-flex">
                                <ul
                                    class="nav nav-tabs nav-tabs-vertical flex-column mr-lg-8 wmin-lg-200 mb-lg-0 border-bottom-0">
                                    <li class="nav-item"><a
                                            class="nav-link text-center @if ($type == 'details' || $type == 'edit-details') active @endif"
                                            data-toggle="pill" href="#details" role="tab">{{ __('Lead Details') }}</a>
                                    </li>
                                    <li class="nav-item"><a
                                            class="nav-link  text-center @if ($type == 'calls' || $type == 'edit-calls') active @endif"
                                            data-toggle="pill" href="#calls" role="tab">{{ __('Calls') }}</a></li>
                                    <li class="nav-item"><a
                                            class="nav-link  text-center @if ($type == 'meetings' || $type == 'edit-meetings') active @endif"
                                            data-toggle="pill" href="#meetings" role="tab">{{ __('Meetings') }}</a></li>
                                    <li class="nav-item"><a
                                            class="nav-link  text-center @if ($type == 'comments' || $type == 'edit-comments') active @endif"
                                            data-toggle="pill" href="#comments">{{ __('Discussion') }}</a></li>
                                    <li class="nav-item"><a
                                            class="nav-link  text-center @if ($type == 'attachment' || $type == 'edit-attachment') active @endif"
                                            data-toggle="pill" href="#attachment">{{ __('Attachment') }}</a></li>
                                    <li class="nav-item"><a
                                            class="nav-link  text-center @if ($type == 'tasks' || $type == 'edit-tasks') active @endif"
                                            data-toggle="pill" href="#tasks">{{ __('Tasks') }}</a></li>
                                    <li class="nav-item"><a
                                            class="nav-link  text-center @if ($type == 'notes' || $type == 'edit-notes') active @endif"
                                            data-toggle="pill" href="#notes">{{ __('Notes') }}</a></li>
                                    <li class="nav-item"><a
                                            class="nav-link  text-center @if ($type == 'proposal' || $type == 'edit-proposal') active @endif"
                                            data-toggle="pill" href="#proposal">{{ __('Proposal') }}</a></li>
                                    <li class="nav-item"><a
                                            class="nav-link  text-center @if ($type == 'reminder' || $type == 'edit-reminder') active @endif"
                                            data-toggle="pill" href="#reminder">{{ __('Reminder') }}</a></li>
                                    <li class="nav-item"><a
                                            class="nav-link  text-center @if ($type == 'activities' || $type == 'edit-activities') active @endif"
                                            data-toggle="pill" href="#activities">{{ __('Activities') }}</a></li>


                                </ul>


                                <!-- Main Body Starts -->
                                <div class="tab-content flex-lg-fill">


                                    <div class="tab-pane @if ($type == 'details' || $type == 'edit-details') active @endif" id="details"
                                        role="tabpanel" aria-labelledby="v-border-pills-home-tab">
                                        <div class="card-header"> <strong>Lead Details</strong> </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table datatable-basic table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th>Title</th>
                                                            <td>{{ $data->lead_name }}</td>
                                                            <th>Organization</th>
                                                            <td>{{ $data->organization }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Lead Source</th>
                                                            <td>{{ $data->source->lead_source }}</td>
                                                            <th>Lead Status</th>
                                                            <td>{{ $data->status->lead_status }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phone Number</th>
                                                            <td>{{ $data->phone }}</td>
                                                            <th>Email</th>
                                                            <td>{{ $data->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Address</th>
                                                            <td>{{ $data->address }}</td>
                                                            <th>Country</th>
                                                            <td>
                                                                @if (!empty($data->country_id))
                                                                    {{ $data->country->value }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Language</th>
                                                            <td>
                                                                @if (!empty($data->language_id))
                                                                    <?php $lang_name = App\Models\Language::where('code', $data->language_id)->first()->name;
                                                                    echo ucfirst($lang_name); ?>
                                                                @endif
                                                            </td>
                                                            <th>Facebook URL</th>
                                                            <td> {{ $data->facebook }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Skype ID</th>
                                                            <td> {{ $data->skype }} </td>
                                                            <th>Twitter URL</th>
                                                            <td>{{ $data->twitter }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Assigned to </th>
                                                            <td> {{ $data->assign->name }} </td>
                                                            <th> </th>
                                                            <td> </td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane @if ($type == 'calls' || $type == 'edit-calls') active @endif" id="calls"
                                        role="tabpanel" aria-labelledby="v-border-pills-messages-tab">
                                        @include('leads.calls')
                                    </div>

                                    <div class="tab-pane @if ($type == 'meetings' || $type == 'edit-meetings') active @endif" id="meetings"
                                        role="tabpanel" aria-labelledby="v-border-pills-messages-tab">
                                        @include('leads.meetings')
                                    </div>




                                    <div class="tab-pane fade @if ($type == 'comments' || $type == 'edit-comments') show active @endif"
                                        id="comments" role="tabpanel" aria-labelledby="v-border-pills-messages-tab">
                                        @include('leads.comments')
                                    </div>

                                    <div class="tab-pane fade @if ($type == 'attachment' || $type == 'edit-attachment') show active @endif"
                                        id="attachment" role="tabpanel" aria-labelledby="v-border-pills-messages-tab">
                                        @include('leads.attachment')
                                    </div>

                                    <div class="tab-pane fade @if ($type == 'tasks' || $type == 'edit-tasks') show active @endif"
                                        id="tasks" role="tabpanel" aria-labelledby="v-border-pills-messages-tab">
                                        @include('leads.tasks')
                                    </div>

                                    <div class="tab-pane fade @if ($type == 'notes' || $type == 'edit-notes') show active @endif"
                                        id="notes" role="tabpanel" aria-labelledby="v-border-pills-messages-tab">
                                        @include('leads.notes')
                                    </div>

                                    <div class="tab-pane fade @if ($type == 'proposal' || $type == 'edit-proposal') show active @endif"
                                        id="proposal" role="tabpanel" aria-labelledby="v-border-pills-messages-tab">
                                        @include('leads.proposal')
                                    </div>


                                    <div class="tab-pane fade @if ($type == 'reminder' || $type == 'edit-reminder') show active @endif"
                                        id="reminder" role="tabpanel" aria-labelledby="v-border-pills-messages-tab">
                                        @include('leads.reminder')
                                    </div>


                                    <div class="tab-pane fade @if ($type == 'activities' || $type == 'edit-activities') show active @endif"
                                        id="activities" role="tabpanel" aria-labelledby="v-border-pills-messages-tab">
                                        <div class="card-header"> <strong>Activities</strong> </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table datatable-activity table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Activity Date</th>
                                                            <th>Module</th>
                                                            <th>Activity</th>
                                                            <th>Performed by</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @if (!empty($activity))
                                                            @foreach ($activity as $row)
                                                                <tr>
                                                                    <td> <?php echo $loop->iteration; ?></td>
                                                                    <td><?php echo date('d/m/Y', strtotime($row->date)); ?> </td>
                                                                    <td><?php echo $row->module; ?></td>
                                                                    <td><?php echo $row->activity; ?></td>
                                                                    <td><?php echo $row->user->name; ?></td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>

                                                </table>
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
        </div>
    </section>



    <!-- discount Modal -->
    <div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        </div>
    </div>

    <div id="attachFormModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">File Preview</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>


    <!-- category Modal -->
    <div class="modal fade show" data-backdrop="" id="betaFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModal">Add Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addClientForm" method="post" action="javascript:void(0)">
                        @csrf
                        <div class="modal-body">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 ">

                                        <div class="form-group row"><label class="col-lg-2 col-form-label">Category
                                                Name</label>

                                            <div class="col-lg-10">
                                                <input type="text" name="name" id="name" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row"><label
                                                class="col-lg-2 col-form-label">Description</label>

                                            <div class="col-lg-10">
                                                <input type="text" name="description" id="description"
                                                    class="form-control">
                                            </div>
                                        </div>




                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="submit" class="btn btn-primary" id="save" onclick="saveCategory(this)"
                                data-dismiss="modal">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>



    <!-- Main Body Ends -->
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#timepicker1,#timepicker2").datetimepicker({
                format: 'LT'
            });
        })
    </script>


    <script>
        $('.datatable-call').DataTable({
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


        $('.datatable-meetings').DataTable({
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
    </script>


    <script>
        $('.datatable-attach').DataTable({
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

        $('.datatable-task').DataTable({
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


        $('.datatable-notes').DataTable({
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

        $('.datatable-activity').DataTable({
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




        $('.datatable-proposal').DataTable({
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

        $('.datatable-inv').DataTable({
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

        $('.datatable-credit').DataTable({
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

        $('.datatable-exp').DataTable({
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
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $(".reply__").hide();
            $("button.reply").on("click", function() {
                var id = $(this).attr("id");
                var sectionId = id.replace("reply__", "reply_");
                $(".reply__").hide();
                $("div#" + sectionId).fadeIn("fast");
                $("div#" + sectionId).css("margin-top", "10" + "px");
            });


        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {

            $("button.remove").on("click", function() {
                var category_id = $(this).data('category_id');
                console.log(category_id);
                $("div > #reply_" + category_id).css("display", "none");
            });



        });
    </script>



    <script type="text/javascript">
        $(document).ready(function() {


            var count = 0;


            function autoCalcSetup() {
                $('table#est_cart').jAutoCalc('destroy');
                $('table#est_cart tr.line_items').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true
                });
                $('table#est_cart').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup();

            $('.est_add').on("click", function(e) {

                count++;
                var html = '';
                html += '<tr class="line_items">';
                html +=
                    '<td><select name="item_name[]" class="form-control  m-b est_item_name" required  data-sub_category_id="' +
                    count +
                    '"><option value="">Select Item Name</option>@foreach ($name as $n) <option value="{{ $n->id }}">{{ $n->name }}</option>@endforeach</select></td>';
                html +=
                    '<td><input type="number" name="quantity[]" class="form-control est_item_quantity" data-category_id="' +
                    count +
                    '"placeholder ="quantity" id ="quantity" required /><div class=""> <p class="form-control-static est_errors' +
                    count + '" id="errors" style="text-align:center;color:red;"></p>   </div></td>';
                html += '<td><input type="text" name="price[]" class="form-control est_item_price' + count +
                    '" placeholder ="price" required  value=""/></td>';
                html += '<input type="hidden" name="unit[]" class="form-control est_item_unit' + count +
                    '" placeholder ="unit" required />';
                html += '<td><select name="tax_rate[]" class="form-control m-b item_tax' + count +
                    '" required ><option value="0">Select Tax Rate</option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
                html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax' +
                    count +
                    '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   />';
                html += '<input type="hidden" id="item_id"  class="form-control est_item_id' + count +
                    '" value="" />';
                html += '<td><input type="text" name="total_cost[]" class="form-control item_total' +
                    count +
                    '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
                html +=
                    '<td><button type="button" name="remove" class="btn btn-danger btn-xs est-remove"><i class="icon-trash"></i></button></td>';

                $('#est_cart >tbody').append(html);
                autoCalcSetup();

                /*
                 * Multiple drop down select
                 */
                $('.m-b').select2({});




            });

            $(document).on('click', '.est-remove', function() {
                $(this).closest('tr').remove();
                autoCalcSetup();
            });


            $(document).on('click', '.est-rem', function() {
                var btn_value = $(this).attr("value");
                $(this).closest('tr').remove();
                $('#est_cart > tfoot').append(
                    '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                    btn_value + '"/>');
                autoCalcSetup();
            });

        });
    </script>

    <script>
        $("#example-select-all").click(function() {
            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        });

        $("input[type=checkbox]").click(function() {
            if (!$(this).prop("checked")) {
                $("#example-select-all").prop("checked", false);
            }
        });
    </script>


    <script>
        $(document).ready(function() {

            $(document).on('change', '.est_item_quantity', function() {
                var id = $(this).val();
                var sub_category_id = $(this).data('category_id');
                var item = $('.est_item_id' + sub_category_id).val();
                var location = $('.est_location').val();

                console.log(location);
                $.ajax({
                    url: '{{ url('pos/sales/findInvQuantity') }}',
                    type: "GET",
                    data: {
                        id: id,
                        item: item,
                        location: location,
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('.est_errors' + sub_category_id).empty();
                        $("#est_save").attr("disabled", false);
                        if (data != '') {
                            $('.est_errors' + sub_category_id).append(data);
                            $("#est_save").attr("disabled", true);
                        } else {

                        }


                    }

                });

            });



        });
    </script>


    <script>
        $(document).ready(function() {

            $(document).on('click', '.inv-remove', function() {
                $(this).closest('tr').remove();
            });

            $(document).on('change', '.inv_item_name', function() {
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
                        console.log(data);
                        $('.inv_item_price' + sub_category_id).val(data[0]["sales_price"]);
                        $(".inv_item_unit" + sub_category_id).val(data[0]["unit"]);
                        $('.inv_item_id' + sub_category_id).val(id);
                    }

                });

            });


        });
    </script>







    <script>
        $("#example-select-all").click(function() {
            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        });

        $("input[type=checkbox]").click(function() {
            if (!$(this).prop("checked")) {
                $("#example-select-all").prop("checked", false);
            }
        });
    </script>

    <script type="text/javascript">
        function model2(id, type) {

            $.ajax({
                type: 'GET',
                url: '{{ url('project/taskModal') }}',
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
                    $('#app2FormModal').modal('toggle');

                }
            });

        }
    </script>



    <script>
        function model(id, type) {

            let url = '{{ route('leads_file.preview') }}';


            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    'type': type,
                    'id': id,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('.modal-body').html(data);
                },
                error: function(error) {
                    $('#attachFormModal').modal('toggle');

                }
            });

        }



        function saveCategory(e) {

            var name = $('#name').val();
            var description = $('#description').val();

            $.ajax({
                type: 'GET',
                url: '{{ url('project/addCategory') }}',
                data: {
                    'name': name,
                    'description': description,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    var id = response.id;
                    var name = response.name;

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";

                    $('#category_id').append(option);
                    $('#betaFormModal').hide();



                }
            });
        }
    </script>



    <script type="text/javascript">
        $(document).ready(function() {


            var count = 0;


            $('.add').on("click", function(e) {

                count++;
                var html = '';
                html += '<tr class="line_items">';
                html +=
                    '<td><select class="form-control m-b" name=" attendee[]" required  id=" attendee"><option value="">Select </option>@foreach ($staff as $row)<option value="{{ $row->id }}">{{ $row->name }}</option>  @endforeach</select></td>';
                html +=
                    '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

                $("#cart > tbody ").append(html);

                $('.m-b').select2({});

            });

            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();

            });


            $(document).on('click', '.rem', function() {
                var btn_value = $(this).attr("value");
                $(this).closest('tr').remove();
                $("#cart > tbody ").append(
                    '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                    btn_value + '"/>');

            });

        });
    </script>
@endsection
