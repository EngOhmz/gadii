@extends('layouts.master')

@push('plugin-styles')
<link href="{{asset('calendar/css/main.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('calendar/css/daygrid.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('calendar/css/timegrid.min.css')}}" rel="stylesheet" type="text/css">

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


<script src="{{asset('calendar/js/main.min.js')}}"></script>
<script src="{{asset('calendar/js/interaction.min.js')}}"></script>
<script src="{{asset('calendar/js/daygrid.min.js')}}"></script>
<script src="{{asset('calendar/js/timegrid.min.js')}}"></script>

<script>
    $(document).ready(function() {
        var calendarButton = document.getElementById('calendarButton');
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'timeGrid'],
            defaultView: 'dayGridMonth',

            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [
                @foreach($task as $t) {
                    title: ' {{ $t->task_name }}',
                    start: '{{ $t->due_date }}',
                    color: '#6082B6',
                    url: '{{ route('task.show',$t->id) }}'
                },
                @endforeach

                @foreach($mile as $m) {
                    title: ' {{ $m->name }}',
                    start: '{{ $m->end_date }}',
                    color: '#CD7F32'
                },
                @endforeach

                @foreach($inv as $in) {
                    title: ' {{ $in->reference_no }}',
                    start: '{{ $in->due_date }}',
                    color: '#53b567',
                    
                },
                @endforeach


                @foreach($pur as $p) {
                    title: ' {{ $p->reference_no }}',
                    start: '{{ $p->due_date }}',
                    color: 'rgba(160,29,171,1)',
                   
                },
                @endforeach

            ]
        });

        calendar.render();

        $('.cal').click(function() {
            calendar.render();
        });
    });
</script>
@endpush

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header header-elements-sm-inline">
                        <h4>{{$data->project_name}} - {{$data->project_no}}</h4>

                        <div class="header-elements">
                            {{--
                                   <a href="{{route('project.index')}}" class="list-icons-item text-info">
                            <i class="icon-circle-left2"></i> Back
                            </a>&nbsp&nbsp&nbsp&nbsp
                            --}}
                            <a href="{{ route("project.edit",$data->id)}}" class="list-icons-item text-primary">
                                <i class="icon-pencil7"></i> Edit Project
                            </a>

                        </div>
                    </div>



                    <div class="card-body">
                        <div class="d-lg-flex">
                            <ul class="nav nav-tabs nav-tabs-vertical flex-column mr-lg-8 wmin-lg-200 mb-lg-0 border-bottom-0">
                                <li class="nav-item"><a href="#vertical-left-tab1" class="nav-link @if($type == 'details' || $type == 'edit-details') active  @endif" data-toggle="tab"> Project Details</a></li>
                                <li class="nav-item"><a href="#vertical-left-tab12" class="nav-link cal @if($type == 'calendar' || $type == 'edit-calendar') active  @endif" data-toggle="tab" id="calendarButton"> Calendar</a></li>
                                <li class="nav-item"><a href="#vertical-left-tab2" class="nav-link @if($type == 'comments' || $type == 'edit-comments') active  @endif" data-toggle="tab"> Discussion
                                        <span class="badge bg-teal rounded-pill float-right ms-2">{{$ccount}}</span></a></li>
                                <li class="nav-item"><a href="#vertical-left-tab3" class="nav-link @if($type == 'attachment' || $type == 'edit-attachment') active  @endif" data-toggle="tab"> Attachment
                                        <span class="badge bg-teal rounded-pill float-right ms-2">{{$attcount}}</span></a></li>
                                <li class="nav-item"><a href="#vertical-left-tab11" class="nav-link @if($type == 'milestone' || $type == 'edit-milestone') active  @endif" data-toggle="tab"> Milestone
                                        <span class="badge bg-teal rounded-pill float-right ms-2">{{$mcount}}</span></a></li>
                                <li class="nav-item"><a href="#vertical-left-tab4" class="nav-link @if($type == 'tasks' || $type == 'edit-tasks') active  @endif" data-toggle="tab"> Tasks
                                        <span class="badge bg-teal rounded-pill float-right ms-2">{{$tcount}}</span></a></li>
                                <li class="nav-item"><a href="#vertical-left-tab5" class="nav-link @if($type == 'notes' || $type == 'edit-notes') active  @endif" data-toggle="tab"> Notes
                                        <span class="badge bg-teal rounded-pill float-right ms-2">{{$ncount}}</span></a></li>
                                <li class="nav-item"><a href="#vertical-left-tab13" class="nav-link @if($type == 'purchase' || $type == 'edit-purchase' || $type == 'purchase-good-receive') active  @endif" data-toggle="tab"> Purchases
                                        <span class="badge bg-teal rounded-pill float-right ms-2">{{$purcount}}</span></a></li>
                                <li class="nav-item"><a href="#vertical-left-tab14" class="nav-link @if($type == 'debit' || $type == 'edit-debit' || $type == 'debit-good-receive') active  @endif" data-toggle="tab"> Debit Note
                                        <span class="badge bg-teal rounded-pill float-right ms-2">{{$dncount}}</span></a></li>
                                <li class="nav-item"><a href="#vertical-left-tab9" class="nav-link @if($type == 'estimate' || $type == 'edit-estimate' || $type == 'estimate-good-receive') active  @endif" data-toggle="tab"> Proforma Invoice
                                        <span class="badge bg-teal rounded-pill float-right ms-2">{{$pcount}}</span></a></li>
                                <li class="nav-item"><a href="#vertical-left-tab6" class="nav-link @if($type == 'invoice' || $type == 'edit-invoice' || $type == 'good-receive') active  @endif" data-toggle="tab"> Invoice
                                        <span class="badge bg-teal rounded-pill float-right ms-2">{{$invcount}}</span></a></li>
                                <li class="nav-item"><a href="#vertical-left-tab7" class="nav-link @if($type == 'credit' || $type == 'edit-credit' || $type == 'credit-good-receive') active  @endif" data-toggle="tab"> Credit Note
                                        <span class="badge bg-teal rounded-pill float-right ms-2">{{$crdcount}}</span></a></li>
                                <li class="nav-item"><a href="#vertical-left-tab8" class="nav-link @if($type == 'expenses' || $type == 'edit-expenses') active  @endif" data-toggle="tab"> Expenses
                                        <span class="badge bg-teal rounded-pill float-right ms-2">{{$expcount}}</span></a></li>
                                <li class="nav-item"><a href="#vertical-left-tab10" class="nav-link @if($type == 'activities' || $type == 'edit-activities') active  @endif" data-toggle="tab"> Activities
                                        <span class="badge bg-teal rounded-pill float-right ms-2">{{$actcount}}</span></a></li>

                            </ul>


                            <div class="tab-content flex-lg-fill">

                                <div class="tab-pane fade @if($type == 'details' || $type == 'edit-details') show active  @endif " id="vertical-left-tab1">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table datatable-basic table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th>Project No</th>
                                                        <td>{{$data->project_no}}</td>
                                                        <th>Category</th>
                                                        <td>{{$data->category->category_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Project Name</th>
                                                        <td>{{$data->project_name}}</td>
                                                        @if(!empty($data->department_id))<th>Department</th>
                                                        <td> {{$data->department->name}}</td> @endif
                                                        @if(!empty($data->client_id))<th>Client</th>
                                                        <td> {{$data->client->name}}</td> @endif
                                                    </tr>
                                                    <tr>
                                                        <th>Status</th>

                                                        <td>
                                                            <div class="form-inline">
                                                                @if($data->status == 'Cancelled')
                                                                <div class="badge badge-danger badge-shadow">{{$data->status}}</div>
                                                                @elseif($data->status == 'In Progress')
                                                                <div class="badge badge-info badge-shadow">{{$data->status}}</div>
                                                                @elseif($data->status == 'Completed')
                                                                <span class="badge badge-success badge-shadow">{{$data->status}}</span>
                                                                @else
                                                                <div class="badge badge-warning badge-shadow">{{$data->status}}</div>
                                                                @endif


                                                                <div class="dropdown">&nbsp;
                                                                    <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"></a>
                                                                    <div class="dropdown-menu">
                                                                        <a class="nav-link change_status" data-id="{{$data->id}}" href="{{route('project.change_status',['id'=>$data->id,'status'=>'Started'])}}">Started</a>
                                                                        <a class="nav-link change_status" data-id="{{$data->id}}" href="{{route('project.change_status',['id'=>$data->id,'status'=>'In Progress'])}}">In Progress</a>
                                                                        <a class="nav-link change_status" data-id="{{$data->id}}" href="{{route('project.change_status',['id'=>$data->id,'status'=>'On Hold'])}}">On Hold</a>
                                                                        <a class="nav-link change_status" data-id="{{$data->id}}" href="{{route('project.change_status',['id'=>$data->id,'status'=>'Cancelled'])}}">Cancelled</a>
                                                                        <a class="nav-link change_status" data-id="{{$data->id}}" href="{{route('project.change_status',['id'=>$data->id,'status'=>'Completed'])}}">Completed</a>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <th>Start Date</th>
                                                        <td>{{Carbon\Carbon::parse($data->start_date)->format('d/m/Y')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Billing Type</th>
                                                        <td>Invoiced</td>
                                                        <th>Fixed Price</th>
                                                        <td>{{number_format($fixed,2)}} TZS</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Expenses</th>
                                                        <td>{{number_format($total_exp,2)}} TZS</td>
                                                        <th>Assigned to </th>
                                                        <td>
                                                            <div class="form-inline">
                                                                <a class="nav-link" href="" data-toggle="modal" value="{{ $data->id}}" data-type="view" data-target="#app2FormModal" onclick="model({{$data->id }},'view')">View</a>
                                                                <a class="nav-link" href="" data-toggle="modal" value="{{ $data->id}}" data-type="assign" data-target="#app2FormModal" onclick="model({{$data->id }},'assign')"><i class="icon-plus-circle2"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade @if($type == 'calendar' || $type == 'edit-calendar') show active  @endif" id="vertical-left-tab12">
                                    <div class="card-body">
                                        <div class="col-lg-6"></div>
                                        <div class="col-lg-6">
                                            <span style="color: #6082B6">■ </span> - Task
                                            <span style="color: #CD7F32">■ </span> - Milestone
                                            <span style="color: rgba(160,29,171,1)">■ </span> - Purchases
                                            <span style="color: #53b567">■ </span> - Invoice

                                        </div>
                                        <br>
                                        <div class="fullcalendar-selectable" id="calendar"></div>
                                    </div>
                                </div>


                                <div class="tab-pane fade @if($type == 'comments' || $type == 'edit-comments') show active  @endif" id="vertical-left-tab2">
                                    @include('project.comments')
                                </div>

                                <div class="tab-pane fade @if($type == 'attachment' || $type == 'edit-attachment') show active  @endif" id="vertical-left-tab3">
                                    @include('project.attachment')
                                </div>

                                <div class="tab-pane fade @if($type == 'milestone' || $type == 'edit-milestone') show active  @endif" id="vertical-left-tab11">
                                    @include('project.milestone')
                                </div>
                                <div class="tab-pane fade @if($type == 'tasks' || $type == 'edit-tasks') show active  @endif" id="vertical-left-tab4">
                                    @include('project.tasks')
                                </div>

                                <div class="tab-pane fade @if($type == 'notes' || $type == 'edit-notes') show active  @endif" id="vertical-left-tab5">
                                    @include('project.notes')
                                </div>

                                <div class="tab-pane fade @if($type == 'purchase' || $type == 'edit-purchase' || $type == 'purchase-good-receive') show active  @endif" id="vertical-left-tab13">
                                    @include('project.purchases.index')
                                </div>

                                <div class="tab-pane fade @if($type == 'debit' || $type == 'edit-debit' || $type == 'debit-good-receive') show active  @endif" id="vertical-left-tab14">

                                    @if($type == 'edit-debit' || $type == 'debit-good-receive')
                                    @include('project.purchases.edit_return')
                                    @else
                                    @include('project.purchases.return')
                                    @endif

                                </div>

                                <div class="tab-pane fade @if($type == 'estimate' || $type == 'edit-estimate' || $type == 'estimate-good-receive') show active  @endif" id="vertical-left-tab9">
                                    @include('project.sales.profoma_invoice')
                                </div>

                                <div class="tab-pane fade @if($type == 'invoice' || $type == 'edit-invoice' || $type == 'good-receive') show active  @endif" id="vertical-left-tab6">
                                    @include('project.sales.invoice')
                                </div>

                                <div class="tab-pane fade @if($type == 'credit' || $type == 'edit-credit' || $type == 'credit-good-receive') show active  @endif" id="vertical-left-tab7">
                                    @if($type == 'edit-credit' || $type == 'credit-good-receive')
                                    @include('project.sales.edit_return')
                                    @else
                                    @include('project.sales.return')
                                    @endif
                                </div>

                                <div class="tab-pane fade @if($type == 'expenses' || $type == 'edit-expenses') show active  @endif" id="vertical-left-tab8">
                                    @include('project.expenses')
                                </div>


                                <div class="tab-pane fade @if($type == 'activities' || $type == 'edit-activities') show active  @endif" id="vertical-left-tab10">
                                    <div class="card-header"> <strong></strong> </div>
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
                                                        <td><?php echo  $row->module; ?></td>
                                                        <td><?php echo  $row->activity; ?></td>
                                                        <td><?php echo  $row->user->name; ?></td>
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

    </div>
</section>

<div class="modal fade" id="app2FormModal" tabindex="-1" role="dialog" aria-hidden="true">
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

                                    <div class="form-group row"><label
                                            class="col-lg-2 col-form-label">Category Name</label>

                                        <div class="col-lg-10">
                                            <input type="text" name="name" id="name"
                                                class="form-control" required>
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
                        <button type="submit" class="btn btn-primary" id="save" onclick="saveCategory(this)" data-dismiss="modal">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{asset('assets/js/fileinput.min.js')}}"></script>
<script src="{{asset('assets/js/sortable.min.js')}}"></script>
<script src="{{asset('assets/js/uploader_bootstrap.js')}}"></script>




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

    $('.datatable-mile').DataTable({
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


    $('.datatable-pur').DataTable({
        autoWidth: false,
        order: [
            [2, 'desc']
        ],
        "columnDefs": [{
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

    $('.datatable-dn').DataTable({
        autoWidth: false,
        "columnDefs": [{
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



    $('.datatable-est').DataTable({
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

<script>
    $(document).ready(function() {

        $(document).on('click', '.pur-remove', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('change', '.pur_item_name', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('sub_pcategory_id');
            $.ajax({
                url: '{{url("pos/purchases/findInvPrice")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.pur_item_price' + sub_category_id).val(data[0]["cost_price"]);
                    $(".pur_item_unit" + sub_category_id).val(data[0]["unit"]);
                    $(".pur_item_tax" + sub_category_id).val(data[0]["tax_rate"]);

                }
            });
        });
    });
</script>



<script type="text/javascript">
    $(document).ready(function() {


        var count = 0;


        function autoCalcSetup() {
            $('table#pur_cart').jAutoCalc('destroy');
            $('table#pur_cart tr.line_items').jAutoCalc({
                keyEventsFire: true,
                decimalPlaces: 2,
                emptyAsZero: true
            });
            $('table#pur_cart').jAutoCalc({
                decimalPlaces: 2
            });
        }
        autoCalcSetup();

        $('.pur_add').on("click", function(e) {

            count++;
            var html = '';
            html += '<tr class="line_items">';
            html += '<td> <div class="input-group mb-3"><select name="item_name[]" class="form-control append-button-single-field pur_item_name"  id="pur_item_name' + count + '" data-sub_pcategory_id="' + count + '" required><option value="">Select Item Name</option>@foreach($name as $n) <option value="{{ $n->id}}">{{$n->name}}</option>@endforeach</select>&nbsp<a href="#"  class="list-icon text-outline-primary items"  data-toggle="modal"  data-sub_category_id="' + count + '" data-target="#app2FormModal" data-toggle = "tooltip" title = "New Item"><i class="icon-plus-circle2"></i></a></div><textarea name="description[]"  class="form-control desc" placeholder="Description"  cols="30" ></textarea></td>';
            html += '<td><input type="number" name="quantity[]" class="form-control pur_item_quantity" data-category_id="' + count + '"placeholder ="quantity" id ="quantity" required /></td>';
            html += '<td><input type="text" name="price[]" class="form-control pur_item_price' + count + '" placeholder ="price" required  value=""/></td>';
            html += '<input type="hidden" name="unit[]" class="form-control pur_item_unit' + count + '" placeholder ="unit" required />';
            html += '<input type="hidden" name="tax_rate[]" class="form-control pur_item_tax' + count + '" placeholder ="total" required />';
            html += '<td><input type="text" name="total_tax[]" class="form-control pur_item_total_tax' + count + '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   readonly/></td>';
            html += '<td><input type="text" name="total_cost[]" class="form-control pur_item_total' + count + '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs pur-remove"><i class="icon-trash"></i></button></td>';

            $('#pur_cart >tbody').append(html);
            autoCalcSetup();

            $('.append-button-single-field').select2({
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            });

        });



        $(document).on('click', '.pur-remove', function() {
            $(this).closest('tr').remove();
            autoCalcSetup();
        });


        $(document).on('click', '.pur-rem', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
            $('#pur_cart >tfoot').append(
                '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');
            autoCalcSetup();
        });



        $(document).on('click', '.items', function() {
            var type = 'item';
            var id = $(this).data('sub_category_id');
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '{{url("project/projectModal")}}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);

                    $(".pur_item_name").select2("close");
                    $('.modal-dialog').html(data);
                },
                error: function(error) {
                    $('#app2FormModal').modal('toggle');

                }
            });
        });



        $(document).on('click', '.edit_form', function(e) {
            e.preventDefault();
            var x = $("#cost_price").val();
            var sub = $("#select_id").val();
            console.log(sub);

            $.ajax({
                data: $('#addItemForm').serialize(),
                type: 'GET',
                url: '{{url("pos/purchases/save_item")}}',
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    var id = response.id;
                    var name = response.name;
                    var price = response.cost_price;
                    var unit = response.unit;
                    var tax = response.tax_rate;

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";
                    $('select[data-sub_pcategory_id="' + sub + '"]').append(option);
                    $('.pur_item_price' + sub).val(price);
                    $(".pur_item_unit" + sub).val(unit);
                    $(".pur_item_tax" + sub).val(tax);
                    $('#app2FormModal').hide();

                }
            })
        });
    });
</script>

<script type="text/javascript">
    function saveSupplier(e) {

        $.ajax({
            type: 'GET',
            url: '{{url("pos/purchases/save_supplier")}}',
            data: $('#addClientForm').serialize(),
            dataType: "json",
            success: function(response) {
                console.log(response);

                var id = response.id;
                var name = response.name;

                var option = "<option value='" + id + "'  selected>" + name + " </option>";

                $('#supplier_id').append(option);
                $('#app2FormModal').hide();
            }
        });
    }
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '.est-remove', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('change', '.est_item_name', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('sub_category_id');
            $.ajax({
                url: '{{url("pos/sales/findInvPrice")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.est_item_price' + sub_category_id).val(data[0]["sales_price"]);
                    $(".est_item_unit" + sub_category_id).val(data[0]["unit"]);
                    $(".est_item_tax" + sub_category_id).val(data[0]["tax_rate"]);
                    $('.est_item_id' + sub_category_id).val(id);
                }

            });

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
            html += '<td><div class="input-group mb-3"><select name="item_name[]" class="form-control  m-b est_item_name" required  data-sub_category_id="' + count +
                '"><option value="">Select Item Name</option>@foreach($bname as $n) <option value="{{ $n->id}}">{{$n->name}}</option>@endforeach</select></div><textarea name="description[]"  class="form-control desc" placeholder="Description"  cols="30" ></textarea></td>';
            html += '<td><input type="number" name="quantity[]" class="form-control est_item_quantity" data-category_id="' + count + '"placeholder ="quantity" id ="quantity" required /><div class=""> <p class="form-control-static est_errors' + count + '" id="errors" style="text-align:center;color:red;"></p>   </div></td>';
            html += '<td><input type="text" name="price[]" class="form-control est_item_price' + count + '" placeholder ="price" required  value=""/></td>';
            html += '<input type="hidden" name="unit[]" class="form-control est_item_unit' + count + '" placeholder ="unit" required />';
            html += '<input type="hidden" name="tax_rate[]" class="form-control est_item_tax' + count + '" placeholder ="total" required />';
            html += '<td><input type="text" name="total_tax[]" class="form-control est_item_total_tax' + count + '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   readonly/></td>';
            html += '<input type="hidden" id="item_id"  class="form-control est_item_id' + count + '" value="" />';
            html += '<td><input type="text" name="total_cost[]" class="form-control est_item_total' + count + '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs est-remove"><i class="icon-trash"></i></button></td>';

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
            var type = $('.name_type').val();

            console.log(location);
            $.ajax({
                url: '{{url("pos/sales/findInvQuantity")}}',
                type: "GET",
                data: {
                    id: id,
                    item: item,
                    location: location,
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (type == '1') {
                        $('.est_errors' + sub_category_id).empty();
                        $("#est_save").attr("disabled", false);
                        if (data != '') {
                            $('.est_errors' + sub_category_id).append(data);
                            $("#est_save").attr("disabled", true);
                        } else {

                        }
                    }

                }

            });

        });
    });
</script>


<script type="text/javascript">
    function saveClient(e) {
        var s = $('.modal_tab').val();
        console.log(s)
        $.ajax({
            type: 'GET',
            url: '{{url("pos/sales/save_client")}}',
            data: $('#addClientForm').serialize(),
            dataType: "json",
            success: function(response) {
                console.log(response);

                var id = response.id;
                var name = response.name;

                var option = "<option value='" + id + "'  selected>" + name + " </option>";

                if (s == 'client') {
                    $('#est_client_id').append(option);
                } else if (s == 'inv-client') {
                    $('#client_id2').append(option);
                }
                $('#app2FormModal').hide();
            }
        });
    }
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
                url: '{{url("pos/sales/findInvPrice")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.inv_item_price' + sub_category_id).val(data[0]["sales_price"]);
                    $(".inv_item_unit" + sub_category_id).val(data[0]["unit"]);
                    $(".inv_item_tax" + sub_category_id).val(data[0]["tax_rate"]);
                    $('.inv_item_id' + sub_category_id).val(id);
                }

            });

        });
    });
</script>




{{-- <script type="text/javascript">
    $(document).ready(function() {
        var count = 0;
        function autoCalcSetup() {
            $('table#inv_cart').jAutoCalc('destroy');
            $('table#inv_cart tr.line_items').jAutoCalc({
                keyEventsFire: true,
                decimalPlaces: 2,
                emptyAsZero: true
            });
            $('table#inv_cart').jAutoCalc({
                decimalPlaces: 2
            });
        }
        autoCalcSetup();

        $('.inv_add').on("click", function(e) {

            count++;
            var html = '';
            html += '<tr class="line_items">';
            html +=
                '<td><div class="input-group mb-3"><select name="item_name[]" class="form-control  m-b inv_item_name" required  data-sub_category_id="' + count + '"><option value="">Select Item Name</option>@foreach($bname as $n) <option value="{{ $n->id}}">{{$n->name}}</option>@endforeach</select></div><textarea name="description[]"  class="form-control desc" placeholder="Description"  cols="30" ></textarea></td>';
            html +=
                '<td><input type="number" name="quantity[]" class="form-control  inv_item_quantity" data-category_id="' +
                count + '"placeholder ="quantity" id ="quantity" required /><div class=""> <p class="form-control-static  inv_errors' + count + '" id="errors" style="text-align:center;color:red;"></p>   </div></td>';
            html += '<td><input type="text" name="price[]" class="form-control inv_item_price' + count +
                '" placeholder ="price" required  value=""/></td>';
            html += '<input type="hidden" name="unit[]" class="form-control inv_item_unit' + count + '" placeholder ="unit" required />';
            html += '<input type="hidden" name="tax_rate[]" class="form-control inv_item_tax' + count + '"  value="{{ isset($i) ? $i->tax_rate : '
            '}}" required>';
            html += '<td><input type="text" name="total_tax[]" class="form-control inv_item_total_tax' + count + '" required readonly  jAutoCalc="{quantity} * {price} * {tax_rate}"></td>';
            html += '<input type="hidden" id="item_id"  class="form-control inv_item_id' + count + '" value="" />';
            html += '<td><input type="text" name="total_cost[]" class="form-control item_total' + count +
                '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
            html +=
                '<td><button type="button" name="remove" class="btn btn-danger btn-xs inv-remove"><i class="icon-trash"></i></button></td>';

            $('#inv_cart >tbody').append(html);
            autoCalcSetup();

            /*
             * Multiple drop down select
             */
            $('.m-b').select2({});
        });

        $(document).on('click', '.inv-remove', function() {
            $(this).closest('tr').remove();
            autoCalcSetup();
        });


        $(document).on('click', '.inv-rem', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
            $('#inv_cart > tfoot').append(
                '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');
            autoCalcSetup();
        });

    });
</script> --}}


<script type="text/javascript">
    $(document).ready(function() {
        var count = 0;
        function autoCalcSetup() {
            $('table#inv_cart').jAutoCalc('destroy');
            $('table#inv_cart tr.line_items').jAutoCalc({
                keyEventsFire: true,
                decimalPlaces: 2,
                emptyAsZero: true
            });
            $('table#inv_cart').jAutoCalc({
                decimalPlaces: 2
            });
        }
        autoCalcSetup();

        $(document).on('click', '.inv_add', function(e) {
            count++;
            var html = '';
            html += '<tr class="line_items">';
            html += '<td><div class="input-group mb-3"><select name="item_name[]" class="form-control m-b inv_item_name" required data-sub_category_id="' + count + '"><option value="">Select Item Name</option>@foreach($bname as $n) <option value="{{ $n->id}}">{{$n->name}}</option>@endforeach</select></div><textarea name="description[]" class="form-control desc" placeholder="Description" cols="30"></textarea></td>';
            html += '<td><input type="number" name="quantity[]" class="form-control inv_item_quantity" data-category_id="' + count + '" placeholder="quantity" id="quantity" required /><div class=""><p class="form-control-static inv_errors' + count + '" id="errors" style="text-align:center;color:red;"></p></div></td>';
            html += '<td><input type="text" name="price[]" class="form-control inv_item_price' + count + '" placeholder="price" required value=""/></td>';
            html += '<input type="hidden" name="unit[]" class="form-control inv_item_unit' + count + '" placeholder="unit" required />';
            html += '<input type="hidden" name="tax_rate[]" class="form-control inv_item_tax' + count + '" value="{{ isset($i) ? $i->tax_rate : '' }}" required>';
            html += '<td><input type="text" name="total_tax[]" class="form-control inv_item_total_tax' + count + '" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"></td>';
            html += '<input type="hidden" id="item_id" class="form-control inv_item_id' + count + '" value="" />';
            html += '<td><input type="text" name="total_cost[]" class="form-control item_total' + count + '" placeholder="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs inv-remove"><i class="icon-trash"></i></button></td>';
            $('#inv_cart > tbody').append(html);
            autoCalcSetup();
            $('.m-b').select2({});
        });

        $(document).on('click', '.inv-remove', function() {
            $(this).closest('tr').remove();
            autoCalcSetup();
        });

        $(document).on('click', '.inv-rem', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
            $('#inv_cart > tfoot').append(
                '<input type="hidden" name="removed_id[]" class="form-control name_list" value="' +
                btn_value + '"/>');
            autoCalcSetup();
        });
    });
</script>


<script>
    $(document).ready(function() {

        $(document).on('change', '.inv_item_quantity', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('category_id');
            var item = $('.inv_item_id' + sub_category_id).val();
            var location = $('.inv_location').val();

            console.log(location);
            $.ajax({
                url: '{{url("pos/sales/findInvQuantity")}}',
                type: "GET",
                data: {
                    id: id,
                    item: item,
                    location: location,
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.inv_errors' + sub_category_id).empty();
                    $("#inv_save").attr("disabled", false);
                    if (data != '') {
                        $('.inv_errors' + sub_category_id).append(data);
                        $("#inv_save").attr("disabled", true);
                    } else {

                    }


                }

            });

        });

    });
</script>


<script type="text/javascript">
    $(document).ready(function() {

        var count = 0;
        $('.exp_add').on("click", function(e) {

            count++;
            var html = '';
            html += '<tr class="line_items">';
            html += '<td><br><select name="account_id[]" class="m-b form-control item_name" required  data-sub_category_id="' + count + '"><option value="">Select Expense Account</option>@foreach ($chart_of_accounts as $chart) <option value="{{$chart->id}}">{{$chart->account_name}}</option>@endforeach</select></td>';
            html += '<td><br><input type="number" name="amount[]" class="form-control item_quantity' + count + '"  id ="quantity" value="" required /></td>';
            html += '<td><br><textarea name="notes[]" class="form-control" rows="2"></textarea></td>';
            html += '<td><br><button type="button" name="remove" class="btn btn-danger btn-xs exp-remove"><i class="icon-trash"></i></button></td>';

            $('#exp_cart > tbody').append(html);


            /*
             * Multiple drop down select
             */
            $(".m-b").select2({});

        });

        $(document).on('click', '.exp-remove', function() {
            $(this).closest('tr').remove();

        });
    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('change', '.sales', function() {
            var id = $(this).val();
            console.log(id);


            if (id == 'Cash Sales') {
                $('.bank1').show();
                $('.bank2').show();

            } else {
                $('.bank1').hide();
                $('.bank2').hide();

            }

        });



    });
</script>


<script>
    $(document).ready(function() {

        $(document).on('change', '.crd-client', function() {
            var id = $(this).val();
            var project = $('.crd-project').val();
            console.log(id);
            $.ajax({
                url: '{{url("pos/sales/findinvoice2")}}',
                type: "GET",
                data: {
                    id: id,
                    project: project,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $("#crd-invoice_id").empty();
                    $("#crd-data").empty();
                    $("#crd-invoice_id").append('<option value="">Select Invoice</option>');
                    $.each(response, function(key, value) {

                        $("#crd-invoice_id").append('<option value=' + value.id + '>' + value.reference_no + '</option>');

                    });

                }

            });

        });

    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('change', '.crd-invoice', function() {
            var id = $(this).val();
            console.log(id);
            $.ajax({
                url: '{{url("pos/sales/showInvoice")}}',
                type: "GET",
                data: {
                    id: id,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $("#crd-data").empty();

                    $.each(response, function(key, value) {

                        $('#crd-data').append(response.html);


                    });

                }

            });
        });

    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('change', '.ecrd-client', function() {
            var id = $(this).val();
            var project = $('.crd-project').val();
            console.log(id);
            $.ajax({
                url: '{{url("pos/sales/findinvoice2")}}',
                type: "GET",
                data: {
                    id: id,
                    project: project,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $("#ecrd-invoice_id").empty();
                    $("#ecrd-data").empty();
                    $("#ecrd-invoice_id").append('<option value="">Select Invoice</option>');
                    $.each(response, function(key, value) {

                        $("#ecrd-invoice_id").append('<option value=' + value.id + '>' + value.reference_no + '</option>');

                    });

                }

            });

        });

    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('change', '.ecrd-invoice', function() {
            var id = $(this).val();
            console.log(id);
            $.ajax({
                url: '{{url("pos/sales/editshowInvoice")}}',
                type: "GET",
                data: {
                    id: id,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $("#crd-cart > tfoot").empty();

                    $.each(response, function(key, value) {

                        $('#crd-cart > tfoot').append(response.html);


                    });

                }

            });
        });

    });
</script>


<script>
    $(document).ready(function() {

        $(document).on('change', '.crd-item_quantity', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('sub_category_id');
            var item = $('.id' + sub_category_id).val();
            console.log(id);
            $.ajax({
                url: '{{url("pos/sales/findinvQty")}}',
                type: "GET",
                data: {
                    id: id,
                    item: item,
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.crd-errors' + sub_category_id).empty();
                    $("#crd-save").attr("disabled", false);
                    if (data != '') {
                        $('.crd-errors' + sub_category_id).append(data);
                        $("#crd-save").attr("disabled", true);
                    } else {

                    }


                }

            });

        });

    });
</script>




<script type="text/javascript">
    $(document).ready(function() {


        function autoCalcSetup() {
            $('table#crd-cart').jAutoCalc('destroy');
            $('table#crd-cart tr.line_items').jAutoCalc({
                keyEventsFire: true,
                decimalPlaces: 2,
                emptyAsZero: true
            });
            $('table#crd-cart').jAutoCalc({
                decimalPlaces: 2
            });
        }
        autoCalcSetup();


        $(document).on('click', '.ecd-remove', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
            $('#crd-cart >tbody').append(
                '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');
            autoCalcSetup();
        });

        $(document).on('click', '.rem', function() {
            $(this).closest('tr').remove();
            autoCalcSetup();
        });

    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('change', '.dn-client', function() {
            var id = $(this).val();
            var project = $('.dn-project').val();
            console.log(id);
            $.ajax({
                url: '{{url("pos/purchases/findinvoice2")}}',
                type: "GET",
                data: {
                    id: id,
                    project: project,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $("#dn-invoice_id").empty();
                    $("#dn-data").empty();
                    $("#dn-invoice_id").append('<option value="">Select Purchases</option>');
                    $.each(response, function(key, value) {

                        $("#dn-invoice_id").append('<option value=' + value.id + '>' + value.reference_no + '</option>');

                    });

                }

            });

        });

    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('change', '.dn-invoice', function() {
            var id = $(this).val();
            console.log(id);
            $.ajax({
                url: '{{url("pos/purchases/showInvoice")}}',
                type: "GET",
                data: {
                    id: id,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $("#dn-data").empty();

                    $.each(response, function(key, value) {

                        $('#dn-data').append(response.html);


                    });

                }

            });
        });

    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('change', '.edn-client', function() {
            var id = $(this).val();
            var project = $('.dn-project').val();
            console.log(id);
            $.ajax({
                url: '{{url("pos/purchases/findinvoice2")}}',
                type: "GET",
                data: {
                    id: id,
                    project: project,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $("#edn-invoice_id").empty();
                    $("#edn-data").empty();
                    $("#edn-invoice_id").append('<option value="">Select Purchases</option>');
                    $.each(response, function(key, value) {

                        $("#edn-invoice_id").append('<option value=' + value.id + '>' + value.reference_no + '</option>');

                    });

                }

            });

        });

    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('change', '.edn-invoice', function() {
            var id = $(this).val();
            console.log(id);
            $.ajax({
                url: '{{url("pos/purchases/editshowInvoice")}}',
                type: "GET",
                data: {
                    id: id,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $("#dn-cart > tfoot").empty();

                    $.each(response, function(key, value) {

                        $('#dn-cart > tfoot').append(response.html);


                    });

                }

            });
        });

    });
</script>


<script>
    $(document).ready(function() {

        $(document).on('change', '.dn-item_quantity', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('sub_category_id');
            var item = $('.id' + sub_category_id).val();
            console.log(id);
            $.ajax({
                url: '{{url("pos/purchases/findinvQty")}}',
                type: "GET",
                data: {
                    id: id,
                    item: item,
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.dn-errors' + sub_category_id).empty();
                    $("#dn-save").attr("disabled", false);
                    if (data != '') {
                        $('.dn-errors' + sub_category_id).append(data);
                        $("#dn-save").attr("disabled", true);
                    } else {

                    }
                }

            });

        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {


        function autoCalcSetup() {
            $('table#dn-cart').jAutoCalc('destroy');
            $('table#dn-cart tr.line_items').jAutoCalc({
                keyEventsFire: true,
                decimalPlaces: 2,
                emptyAsZero: true
            });
            $('table#dn-cart').jAutoCalc({
                decimalPlaces: 2
            });
        }
        autoCalcSetup();


        $(document).on('click', '.edn-remove', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
            $('#dn-cart >tbody').append(
                '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');
            autoCalcSetup();
        });

        $(document).on('click', '.rem', function() {
            $(this).closest('tr').remove();
            autoCalcSetup();
        });

    });
</script>


<script>
    function attach_model(id, type) {

        let url = '{{ route("project_file.preview") }}';


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
            url: '{{url("project/addCategory")}}',
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
    function model(id, type) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            url: '{{url("project/findInvoice")}}',
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


<script type="text/javascript">
    function model(id, type) {

        $.ajax({
            type: 'GET',
            url: '{{url("project/projectModal")}}',
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

@endsection