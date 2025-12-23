@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Assets</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Assets
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Asset</a>
                                </li>

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                            <thead>
                                                <tr role="row">

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="width: 20.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Asset Name</th>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Serial Number</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Value</th>


                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Quantity</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 170.1094px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($assets))
                                                    @foreach ($assets as $row)
                                                        <tr class="gradeA even" role="row">
                                                            <th>{{ $loop->iteration }}</th>
                                                            <td>{{ $row->driver_name }}</td>
                                                            <td>{{ $row->mobile_no }}</td>
                                                            <td>
    {{ is_numeric($row->licence) ? number_format((float) $row->licence) : $row->licence }}
</td>




                                                            <td>
                                                                {{ $row->address }}
                                                                
                                                            </td>
                                                            <td>
                                                                {{ $row->driver_status }}
                                                                
                                                            </td>
                                                            <td>
                                                                <div class="form-inline">


                                                                    <a class="list-icons-item text-primary"
                                                                        href="{{ route('assets.edit', $row->id) }}">
                                                                        <i class="icon-pencil7"></i>
                                                                    </a>&nbsp

                                                                    {!! Form::open(['route' => ['assets.destroy', $row->id], 'method' => 'delete']) !!}
                                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                                    {{ Form::close() }}
                                                                    &nbsp




                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (!empty($id))
                                                <h5>Edit Asset</h5>
                                            @else
                                                <h5>Add New Asset</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['assets.update', $id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                                                    @else
                                                        {!! Form::open(['route' => 'assets.store', 'enctype' => 'multipart/form-data']) !!}
                                                        @method('POST')
                                                    @endif

                                                    <div class="form-group row"><label class="col-lg-2 col-form-label">Asset
                                                            Name</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="driver_name"
                                                                value="{{ isset($data) ? $data->driver_name : '' }}"
                                                                class="form-control" required>
                                                        </div>

                                                        <label class="col-lg-2 col-form-label">Serial Number</label>

                                                        <div class="col-lg-4">
                                                            <input type="text" name="mobile_no"
                                                                value="{{ isset($data) ? $data->mobile_no : '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label"> Value</label>

                                                        <div class="col-lg-4">
                                                            <input type="text" name="licence"
                                                                value="{{ isset($data) ? $data->licence : '' }}"
                                                                class="form-control" required>
                                                        </div>

                                                        <label class="col-lg-2 col-form-label">Quantity</label>

                                                        <div class="col-lg-4">
                                                            <input type="text" name="address"
                                                                value="{{ isset($data) ? $data->address : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Description</label>

                                                        <div class="col-lg-4">
                                                            <input type="text" name="TIN"
                                                                value="{{ isset($data) ? $data->TIN : '' }}"
                                                                class="form-control" required>
                                                        </div>

                                                        <label class="col-lg-2 col-form-label">Status</label>

                                                        <div class="col-lg-4">
                                                            <select class="form-control m-b" style="width: 100%"
                                                                name="driver_status">
                                                                <option value="">Select Status</option>
                                                                <option
                                                                    @if (isset($data)) {{ $data->driver_status == 'Active' ? 'selected' : '' }} @endif
                                                                    value="Active">Active</option>
                                                                <option
                                                                    @if (isset($data)) {{ $data->driver_status == 'Inactive' ? 'selected' : '' }} @endif
                                                                    value="Inactive">Inactive</option>
                                                            </select>
                                                        </div>

                                                        </div>


                                                       
                                                    

                                                    

                                                    
                                                      

                                                        

  
                                                
                                                        


                                                            <div class="form-group row">
                                                            <label
                                                                class="col-lg-2 col-form-label">Profile Picture</label>

                                                            <div class="col-lg-10">
                                                                @if (!@empty($data->profile))
                                                                    <input type="file" name="profile"
                                                                        value="{{ $data->profile }}" class="form-control"
                                                                        onchange="loadBigFile(event)">
                                                                    <br><img
                                                                        src="{{ url('assets/img/driver') }}/{{ $data->profile }}"
                                                                        alt="{{ $data->driver_name }}" width="100">
                                                                @else
                                                                    <input type="file" name="profile"
                                                                        class="form-control"
                                                                        onchange="loadBigFile(event)">
                                                                @endif

                                                                <br>
                                                                <img id="big_output" width="100">



                                                            </div>
                                                        </div>
                                                            
                                                        </div>
                                                  
                                                        <div class="form-group row">
                                                            <div class="col-lg-offset-2 col-lg-12">
                                                                @if (!@empty($id))
                                                                    <button
                                                                        class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                        data-toggle="modal" data-target="#myModal"
                                                                        type="submit">Update</button>
                                                                @else
                                                                    <button
                                                                        class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                        type="submit">Save</button>
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

    <script>
        var loadBigFile = function(event) {
            var output = document.getElementById('big_output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
    <script>
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'ExampleFile'
                    },
                    {
                        extend: 'pdf',
                        title: 'ExampleFile'
                    },

                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]

            });

        });


        $('.demo4').click(function() {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function() {
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
            });
        });
    </script>
    <script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection

