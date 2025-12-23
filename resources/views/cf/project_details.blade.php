@extends('layouts.master')

@push('plugin-styles')


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
        .body > .line_items{
     border:1px solid #ddd;
 }
 .p-md {
    padding: 12px !important;
}

.bg-items {
    background: #303252;
    color: #ffffff;
}
.ml-13 {
    margin-left: -13px !important;
}
    </style>
@endpush



@section('content')

    <section class="section">
        <div class="section-body">

            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header header-elements-sm-inline">
                            <h4>{{ $data->project_name }} - {{ $data->reff_no }}</h4>

                            <div class="header-elements">
                                {{--                       
                                   <a href="{{route('cf.index')}}" class="list-icons-item text-info">
                                         <i class="icon-circle-left2"></i> Back
                                                     </a>&nbsp&nbsp&nbsp&nbsp
--}}
                                <a href="{{ route('cf.edit', $data->id) }}" class="list-icons-item text-primary">
                                    <i class="icon-pencil7"></i> Edit 
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-lg-flex">
                                <ul
                                    class="nav nav-tabs nav-tabs-vertical flex-column mr-lg-8 wmin-lg-200 mb-lg-0 border-bottom-0">
                                    <li class="nav-item"><a href="#vertical-left-tab1"
                                            class="nav-link @if ($type == 'details' || $type == 'edit-details') active @endif"
                                            data-toggle="tab">  Details</a></li>
                                    <li class="nav-item"><a href="#vertical-left-tab12" class="nav-link @if ($type == 'quotation' || $type == 'edit-quotation') active @endif"
                                            data-toggle="tab"> Quotation   
                                            <span class="badge bg-teal rounded-pill float-right ms-2">{{ $qcount }}</span></a></li>
                                    <li class="nav-item"><a href="#vertical-left-tab2"
                                            class="nav-link @if ($type == 'comments' || $type == 'edit-comments') active @endif"
                                            data-toggle="tab"> Discussion
                                            <span
                                                class="badge bg-teal rounded-pill float-right ms-2">{{ $ccount }}</span></a>
                                    </li>
                                    <li class="nav-item"><a href="#vertical-left-tab3"
                                            class="nav-link @if ($type == 'attachment' || $type == 'edit-attachment') active @endif"
                                            data-toggle="tab"> Attachment
                                            <span
                                                class="badge bg-teal rounded-pill float-right ms-2">{{ $attcount }}</span></a>
                                    </li>
                                    <li class="nav-item"><a href="#vertical-left-tab11"
                                            class="nav-link @if ($type == 'milestone' || $type == 'edit-milestone') active @endif"
                                            data-toggle="tab"> Milestone
                                            <span
                                                class="badge bg-teal rounded-pill float-right ms-2">{{ $mcount }}</span></a>
                                    </li>
                                    <li class="nav-item"><a href="#vertical-left-tab4"
                                            class="nav-link @if ($type == 'tasks' || $type == 'edit-tasks') active @endif"
                                            data-toggle="tab"> Tasks
                                            <span
                                                class="badge bg-teal rounded-pill float-right ms-2">{{ $tcount }}</span></a>
                                    </li>
                                    <li class="nav-item"><a href="#vertical-left-tab5"
                                            class="nav-link @if ($type == 'notes' || $type == 'edit-notes') active @endif"
                                            data-toggle="tab"> Notes
                                            <span
                                                class="badge bg-teal rounded-pill float-right ms-2">{{ $ncount }}</span></a>
                                    </li>
                                  
                           
                                    <li class="nav-item"><a href="#vertical-left-cargo" class="nav-link @if ($type == 'cargo' || $type == 'edit-cargoType') active @endif" data-toggle="tab"> 
                                    Cargo <span class="badge bg-teal rounded-pill float-right ms-2">{{ $ctypecount }}</span></a>
                                    </li>

                                    {{-- <li class="nav-item"><a href="#vertical-left-cargoActivity" class="nav-link @if ($type == 'cargoActivity' || $type == 'edit-cargoActivity') active @endif" data-toggle="tab"> 
                                      Cargo Activity <span class="badge bg-teal rounded-pill float-right ms-2">{{ $cargoActivitycount }}</span></a>
                                    </li> --}}
                                   
                                    <li class="nav-item"><a href="#vertical-left-tab6" class="nav-link @if ($type == 'invoice' || $type == 'edit-invoice' || $type == 'approve-invoice') active @endif" data-toggle="tab"> 
                                    Invoice
                                    <span class="badge bg-teal rounded-pill float-right ms-2">{{ $invcount }}</span></a>
                                    </li>
                                    <li class="nav-item">
                                    <a href="#vertical-left-logistic" class="nav-link @if ($type == 'logistic' || $type == 'edit-logistic') active @endif" data-toggle="tab"> Customer Duty Tax
                                    <span class="badge bg-teal rounded-pill float-right ms-2">{{ $logcount }}</span></a>
                                    </li>
                                    
                                    <li class="nav-item"><a href="#vertical-left-tab8" class="nav-link @if ($type == 'expenses' || $type == 'edit-expenses') active  @endif" data-toggle="tab"> Expenses
                                    <span class="badge bg-teal rounded-pill float-right ms-2">{{$expcount}}</span></a></li>
                                   
                                    
                                </ul>
                                <div class="tab-content flex-lg-fill">

                                    <div class="tab-pane fade @if ($type == 'details' || $type == 'edit-details') show active @endif "
                                        id="vertical-left-tab1">

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                        <th>Name</th><td>{{ $data->project_name }}</td>
                                                        <th>Reference No</th><td>{{ $data->reff_no }}</td>
                                                           
                                                        </tr>
                                                        <tr>
                                                             <th>Category</th><td>{{ $data->category->category_name }}</td>
                                                            <th>Status</th>

                                                            <td>
                                                                <div class="form-inline">
                                                                    @if ($data->status == 'Cancelled')
                                                                        <div class="badge badge-danger badge-shadow">
                                                                            {{ $data->status }}</div>
                                                                    @elseif($data->status == 'In Progress')
                                                                        <div class="badge badge-info badge-shadow">
                                                                            {{ $data->status }}</div>
                                                                    @elseif($data->status == 'Completed')
                                                                        <span
                                                                            class="badge badge-success badge-shadow">{{ $data->status }}</span>
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
                                                                                href="{{ route('cf.change_status', ['id' => $data->id, 'status' => 'Started']) }}">Started</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $data->id }}"
                                                                                href="{{ route('cf.change_status', ['id' => $data->id, 'status' => 'In Progress']) }}">In
                                                                                Progress</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $data->id }}"
                                                                                href="{{ route('cf.change_status', ['id' => $data->id, 'status' => 'On Hold']) }}">On
                                                                                Hold</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $data->id }}"
                                                                                href="{{ route('cf.change_status', ['id' => $data->id, 'status' => 'Cancelled']) }}">Cancelled</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $data->id }}"
                                                                                href="{{ route('cf.change_status', ['id' => $data->id, 'status' => 'Completed']) }}">Completed</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                           

                                                            <th>Start Date</th>
                                                            <td>{{ Carbon\Carbon::parse($data->start_date)->format('d/m/Y') }}</td>
                                                            <th>Assigned to </th>

                                                            <td>
                                                                <div class="form-inline">
                                                                    <a class="" href=""
                                                                        data-toggle="modal" value="{{ $data->id }}"
                                                                        data-type="view" data-target="#app2FormModal"
                                                                        onclick="model({{ $data->id }},'view')">View</a>&nbsp&nbsp
                                                                    <a class="" href=""
                                                                        data-toggle="modal" value="{{ $data->id }}"
                                                                        data-type="assign" data-target="#app2FormModal"
                                                                        onclick="model({{ $data->id }},'assign')"><i
                                                                            class="icon-plus-circle2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                         @php $cl= App\Models\Client::find($data->client_id); $dep = App\Models\Departments::find($data->department_id); @endphp
                                                     
                                                    <th>Client</th>@if(!empty($cl))<td>{{$cl->name}}</td>@else <td>-</td> @endif</td>
                                                    <th>Department</th>@if(!empty($dep))<td>{{$dep->name}}</td> @else <td>-</td> @endif</td>
                                                        </tr>
                                                       

                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade @if ($type == 'quotation' || $type == 'edit-quotation') show active @endif"
                                        id="vertical-left-tab12">
                                        @include('cf.sales.quotation')
                                    </div>


                                    <div class="tab-pane fade @if ($type == 'comments' || $type == 'edit-comments') show active @endif"
                                        id="vertical-left-tab2">
                                        @include('cf.comments')
                                    </div>

                                    <div class="tab-pane fade @if ($type == 'attachment' || $type == 'edit-attachment') show active @endif"
                                        id="vertical-left-tab3">
                                        @include('cf.attachment')
                                    </div>

                                    <div class="tab-pane fade @if ($type == 'milestone' || $type == 'edit-milestone') show active @endif"
                                        id="vertical-left-tab11">
                                        @include('cf.milestone')
                                    </div>
                                    <div class="tab-pane fade @if ($type == 'tasks' || $type == 'edit-tasks') show active @endif"
                                        id="vertical-left-tab4">
                                        @include('cf.tasks')
                                    </div>
                                    <div class="tab-pane fade @if ($type == 'cargo' || $type == 'edit-cargoType') show active @endif"
                                        id="vertical-left-cargo">
                                        @include('cf.CargoType');
                                    </div>

                                    <div class="tab-pane fade @if ($type == 'cargoActivity' || $type == 'edit-cargoActivity') show active @endif"
                                        id="vertical-left-cargoActivity">
                                        @include('cf.cargo_activity');
                                    </div>

                                    <div class="tab-pane fade @if ($type == 'notes' || $type == 'edit-notes') show active @endif"
                                        id="vertical-left-tab5">
                                        @include('cf.notes')
                                    </div>

                             
    
                                    <div class="tab-pane fade @if ($type == 'invoice' || $type == 'edit-invoice' || $type == 'approve-invoice') show active @endif"
                                        id="vertical-left-tab6">
                                        @include('cf.sales.invoice')
                                    </div>
                                    
                                     <div class="tab-pane fade @if ($type == 'logistic' || $type == 'edit-logistic') show active @endif"
                                        id="vertical-left-logistic">
                                        @include('cf.logistic')
                                    </div>


                                    <div class="tab-pane fade @if ($type == 'expenses' || $type == 'edit-expenses') show active @endif"
                                        id="vertical-left-tab8">
                                        @include('cf.expenses')
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


        <div class="modal fade show" data-backdrop="" id="betaFormModal" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog">
              
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formModal">Add Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="addCategoryForm" method="post" action="javascript:void(0)">
                            @csrf
                            <div class="modal-body">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 ">

                                            <div class="form-group row"><label class="col-lg-2 col-form-label">Name</label>

                                                <div class="col-lg-10">
                                                    <input type="text" name="name" id="cat_name"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group row"><label class="col-lg-2 col-form-label">Description</label>

                                                <div class="col-lg-10">
                                                    <textarea name="description" id="cat_description"
                                                        class="form-control"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer bg-whitesmoke br">
            <button class="btn btn-primary"  type="submit" id="save" onclick="saveCategory(this)" data-dismiss="modal"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
            

                            </div>


                        </form>

                    </div>
                </div>
            </div>
       


    
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/sortable.min.js') }}"></script>
    <script src="{{ asset('assets/js/uploader_bootstrap.js') }}"></script>
    <script>
$('.datatable-attachcf').DataTable({
             autoWidth: false,
            "columnDefs": [
                {"targets": [1]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        });
        
        

        $('.datatable-milestonecf').DataTable({
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

        $('.datatable-logistic').DataTable({
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
        
        
          $('.datatable-notecf').DataTable({
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
        
         $('.datatable-stock').DataTable({
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
        
         $('.datatable-storage').DataTable({
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
        
         $('.datatable-charge').DataTable({
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
                "targets": [0]
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

    $(document).on('change', '.exp_account_id', function() {
        var id = $(this).val();
  console.log(id);
      
 $.ajax({
            url: '{{url("gl_setup/findSupplier")}}',
            type: "GET",
            data: {
                id: id,
            },
 dataType: "json",
            success: function(data) {
              console.log(data); 
          $("#exp_supplier").hide();
         if (data == 'OK') {
           $("#exp_supplier").show();   
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
        html += '<td><div><select name="account_id[]" class="m-b form-control exp_item_name" required  data-sub_category_id="' +count +'"><option value="">Select Expense Account</option>@foreach($chart_of_accounts as $group => $ch)<optgroup label="{{$group}}"> @foreach($ch as $chart)<option value="{{$chart->id}}">{{$chart->account_name}}</option>@endforeach</optgroup> @endforeach</select></div><br><div class="exp_item_supplier' + count +'"  id="supplier" style="display:none;"><select class="form-control m-b exp_supplier_id" id="exp_supplier_id' + count +'" name="supplier_id[]"><option value="">Select Supplier</option> @foreach ($supplier as $m) <option value="{{$m->id}}" >{{$m->name}}</option>@endforeach</select></div></td>';
        html +='<td><br><input type="text" name="amount[]" class="form-control exp_item_amount"  id ="amount' + count +'" value="" required /></td>';
        html += '<td><br><textarea name="notes[]" class="form-control" rows="2"></textarea></td>';
        html +='<td><br><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('#exp_cart > tbody').append(html);
      

/*
             * Multiple drop down select
             */
            $(".m-b").select2({
                            });
                            
            $('.exp_item_amount').keyup(function(event) {   
        // skip for arrow keys
          if(event.which >= 37 && event.which <= 40){
           //event.preventDefault();
          }
        
          $(this).val(function(index, value) {
              
              value = value.replace(/[^0-9\.]/g, ""); // remove commas from existing input
              return numberWithCommas(value); // add commas back in
              
          });
        });   
          


      
    });

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
        
    });


   

});
</script>


<script>
$(document).ready(function() {


    $(document).on('change', '.exp_item_name', function() {
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("gl_setup/findSupplier")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('.exp_item_supplier' + sub_category_id).css("display", "none");

          if (data == 'OK') {
           $('.exp_item_supplier' + sub_category_id).css("display", "block");   
}
     
              
               
            }

        });

    });
    
    
        $(document).on('click', '.exp_save', function(event) {
   
         $('.exp_errors').empty();
        
          if ( $('#exp_cart tbody tr').length == 0 ) {
               event.preventDefault(); 
    $('.exp_errors').append('Please Enter Items.');
}
         
         else{
            
         
          
         }
        
    });
    
    
     $('.exp_amount').keyup(function(event) {   
        // skip for arrow keys
          if(event.which >= 37 && event.which <= 40){
           //event.preventDefault();
          }
        
          $(this).val(function(index, value) {
              
              value = value.replace(/[^0-9\.]/g, ""); // remove commas from existing input
              return numberWithCommas(value); // add commas back in
              
          });
        });   
    


});
</script>


<script type="text/javascript">


function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

</script>

    <script>
        $(document).ready(function() {

            $(document).on('change', '.sales', function() {
                var id = $(this).val();
                console.log(id);


                if (id == 'Cash Sales') {
                    $("div > #bank_id").css("display", "block");

                } else {
                    $("div> #bank_id").css("display", "none");

                }

            });



        });
    </script>






   


    <script>
       function attach_model(id, type) {

    let url = '{{ route("cf_file.preview") }}';


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
            console.log(data);
            $('#attachFormModal > .modal-body').html(data);
        },
        error: function(error) {
            $('#attachFormModal').modal('toggle');

        }
    });

}

        


        function saveCategory(e) {

            var name = $('#cat_name').val();
            var description = $('#cat_description').val();

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
 
        function model(id, type) {

            $.ajax({
                type: 'GET',
                url: '{{ url('cf/cfModal') }}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('#app2FormModal > .modal-dialog').html(data);
                },
                error: function(error) {
                    $('#app2FormModal').modal('toggle');

                }
            });

        }
   
        function modelStock(id, type, storage_id) {

            $.ajax({
                type: 'GET',
                url: '{{ url('cf/stockModal') }}',
                data: {
                    'id': id,
                    'type': type,
                    'storage_id' : storage_id,
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


        function saveClient(e) {

            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/save_client') }}',
                data: $('.addClientForm').serialize(),
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    var id = response.id;
                    var name = response.name;

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";

                    $('#client_id').append(option);
                    $('#appFormModal').hide();



                }
            });
        }
        
        
         function model2(id, type) {


            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/invModal') }}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('#app2FormModal > .modal-dialog').html(data);
                      
                    
                },
                error: function(error) {
                    $('#app2FormModal').modal('toggle');

                }
            });

        }
        
        
      
    </script>
       


    
@endsection
