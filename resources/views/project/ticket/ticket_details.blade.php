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
                                <h4>Ticket</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <ul
                                        class="nav nav-tabs nav-tabs-vertical flex-column mr-lg-8 wmin-lg-200 mb-lg-0 border-bottom-0">

                                        <li class="nav-item"><a href="#vertical-left-tab0"
                                                class="nav-link @if ($type == 'details' || $type == 'edit-details') active @endif"
                                                data-toggle="tab">
                                                Ticket Details</a></li>
                                        <li class="nav-item"><a href="#vertical-left-tab1"
                                                class="nav-link @if ($type == 'comments' || $type == 'edit-comments') active @endif"
                                                data-toggle="tab">
                                                Discussion</a></li>

                                    </ul>
                                    <div class="tab-content flex-lg-fill">
                                        <div class="tab-pane fade @if ($type == 'details' || $type == 'edit-details') show active @endif"
                                            id="vertical-left-tab0">
                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th>Ticket No</th>
                                                                <td>{{ $data->ticket_code }}</td>
                                                                <th>Subject</th>
                                                                <td>{{ $data->subject }}</td>
                                                            </tr>
                                                            <tr>
                                                                @if (!empty($data->tags))
                                                                    <th>Tags</th>
                                                                    <td> {{ $data->tags }}</td>
                                                                @endif
                                                               
                                                                @php $reporter = App\Models\User::find($data->reporter);  @endphp
                                                                @if (!empty($data->reporter))
                                                                    <th>Reporter</th>
                                                                    <td> {{ $reporter->name }}</td>
                                                                @endif
                                                            </tr>
                                                             <tr>

                                                                @if (!empty($data->priority))
                                                                    <th>Priority</th>
                                                                    <td> {{ $data->priority }}</td>
                                                                @endif
                                                                @php $department = App\Models\Departments::find($data->departments_id);  @endphp
                                                                @if (!empty($data->departments_id))
                                                                    <th>Department</th>
                                                                    <td> {{ $department->name }}</td>
                                                                @endif
                                                            </tr>
                                                            <tr>
                                                                <th>Status</th>

                                                                <td>
                                                                        <div class="form-inline">
                                                                    @if ($data->status == 'Open')
                                                                        <div class="badge badge-danger badge-shadow">
                                                                            {{ $data->status }}</div>
                                                                    @elseif($data->status == 'In Progress')
                                                                        <div class="badge badge-info badge-shadow"> {{ $data->status }}</div>
                                                                     @elseif($data->status == 'Answered')
                                                                        <div class="badge badge-info badge-shadow"> {{ $data->status }}</div>
                                                                    @elseif($data->status == 'Closed')
                                                                        <span class="badge badge-success badge-shadow">{{ $data->status }}</span>
                                                                    @else
                                                                        <div class="badge badge-warning badge-shadow">
                                                                            {{ $data->status }}</div>
                                                                    @endif


                                                                    <div class="dropdown">&nbsp;
                                                                        <a href="#"
                                                                            class="list-icons-item dropdown-toggle text-teal"
                                                                            data-toggle="dropdown"></a>
                                                                        <div class="dropdown-menu">
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $data->id }}"
                                                                                href="{{ route('ticket.change_status', ['id' => $data->id, 'status' => 'Open']) }}">Open</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $data->id }}"
                                                                                href="{{ route('ticket.change_status', ['id' => $data->id, 'status' => 'In Progress']) }}">In Progress</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $data->id }}"
                                                                                href="{{ route('ticket.change_status', ['id' => $data->id, 'status' => 'Closed']) }}">Closed</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $data->id }}"
                                                                                href="{{ route('ticket.change_status', ['id' => $data->id, 'status' => 'Answered']) }}">Answered</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $data->id }}"
                                                                                href="{{ route('ticket.change_status', ['id' => $data->id, 'status' => 'Completed']) }}">Completed</a>


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </td>

                                                                <th>Start Date</th>
                                                                <td>{{ Carbon\Carbon::parse($data->start_date)->format('d/m/Y') }}
                                                                </td>
                                                            </tr>
                                                            
                                                            

                                                        </tbody>

                                                    </table>
                                                </div>

                                                <br>


                                            </div>
                                        </div>
                                        <div class="tab-pane fade @if ($type == 'comments' || $type == 'edit-comments') show active @endif"
                                            id="vertical-left-tab1">
                                                @include('project.ticket.comment')
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
    @endsection
