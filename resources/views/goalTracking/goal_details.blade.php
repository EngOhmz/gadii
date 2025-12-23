@extends('layouts.master')
@push('plugin-styles')
    <link href="{{ asset('calendar/css/main.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('calendar/css/daygrid.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('calendar/css/timegrid.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        .border-bottom-0 a {
            font-size: 15px;
            color: #444;
        }

        .nav-tabs-vertical .nav-item.show .nav-link,
        .nav-tabs-vertical .nav-link.active {
            color: #3F51B5;
            font-weight: bold;
        }

        .ms-2 {
            color: white;
        }
    </style>

@endpush

@push('plugin-scripts')
    @section('content')
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Goal Tracking</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <ul
                                        class="nav nav-tabs nav-tabs-vertical flex-column mr-lg-8 wmin-lg-200 mb-lg-0 border-bottom-0">

                                        <li class="nav-item"><a href="#vertical-left-tab0"
                                                class="nav-link @if ($type == 'details' || $type == 'edit-details') active @endif"
                                                data-toggle="tab">
                                                Goals Details</a></li>
                                        <li class="nav-item"><a href="#vertical-left-tab1"
                                                class="nav-link @if ($type == 'comments' || $type == 'edit-comments') active @endif"
                                                data-toggle="tab">
                                                Discussion</a></li>
                                        <li class="nav-item"><a href="#vertical-left-tab2"
                                                class="nav-link @if ($type == 'task' || $type == 'edit-task') active @endif"
                                                data-toggle="tab">
                                                Task</a></li>
                                        <li class="nav-item"><a href="#vertical-left-tab3"
                                                class="nav-link @if ($type == 'milestone' || $type == 'edit-milestone') active @endif"
                                                data-toggle="tab">
                                                Milestone</a></li>
                                    </ul>
                                    <div class="tab-content flex-lg-fill">
                                        <div class="tab-pane fade @if ($type == 'details' || $type == 'edit-details') show active @endif"
                                            id="vertical-left-tab0">
                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table class="table  table-striped">
                                                     <tr><th>Subject</th> <td>{{ $data->subject }}</td><th>Type</th> <td>{{ $data->goal_type }}</td></tr>
                                                     <tr> <th>Start Date</th> <td>{{ $data->start_date }}</td><th>End Date</th><td>{{ $data->end_date }}</td></tr>
                                                            <tr>
                                                            <th>Completed Achievement<td><h5><strong> {{ number_format($totol,2, '.', '') }} %</strong><h5></td></th>
                                                            <th>Target Achievement</th> 
                                                            @php $target = App\Models\Goal_Tracking\ Achievement::find($data->achievement_id)->name; @endphp
                                                                <td>{{$target}}</td>
                                                                </tr>
                                                                
                                                              <tr>  
                                                            <th>Status</th><td><span class="badge bg-warning">{{ $data->status }}</span></td>
                                                            <th></th><td></td>
                                                            </tr>
                                                       
                                                    </table>
                                                </div>
                                                
                                                <br>
                                                <div class="row">
                                                    <div class="col-lg-10">

                                                    <div class="chart-container">
                                                    <div id="donut-chart" class="chart has-fixed-height"></div>
                                                   
                                                   
                                                   </div>
                                                </div></div>

                                                <div class="col-xs-12 text-center">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade @if ($type == 'comments' || $type == 'edit-comments') show active @endif"
                                            id="vertical-left-tab1">
                                            @include('goalTracking.comment')
                                        </div>

                                        <div class="tab-pane fade @if ($type == 'task' || $type == 'edit-task') show active @endif"
                                            id="vertical-left-tab2">
                                            @include('goalTracking.task')
                                        </div>

                                        <div class="tab-pane fade @if ($type == 'milestone' || $type == 'edit-milestone') show active @endif"
                                            id="vertical-left-tab3">
                                            @include('goalTracking.milestone')
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
        <script>
            $('.datatable-basic').DataTable({
                autoWidth: false,
                "columnDefs": [{
                    "orderable": false,
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
        <script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('change', '.related_class', function() {
                    var id = $(this).attr('id');

                    if (id == 'Clients') {
                        $('#ClientsDiv').show();

                    } else {
                        $('#ClientsDiv').hide();
                    }
                });
            });
        </script>

        <script>
            var chart = bb.generate({
                data: {
                    columns: [
                        ["Blue", 2],
                        ["orange", 4],
                        ["green", 3],
                    ],
                    type: "donut",
                    onclick: function(d, i) {
                        console.log("onclick", d, i);
                    },
                    onover: function(d, i) {
                        console.log("onover", d, i);
                    },
                    onout: function(d, i) {
                        console.log("onout", d, i);
                    },
                },
                donut: {
                    title: "Progress",
                },
                
                bindto: "#donut-chart",
            });
        </script>
    @endsection
