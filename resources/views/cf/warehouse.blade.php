@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Warehouse</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#cf1" role="tab" aria-controls="home"
                                        aria-selected="true">Warehouse
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#cf2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Warehouse </a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="cf1" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Storage Charge</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Storage Start Due</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Due Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Charge Start Due Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 108.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($warehouse))
                                                    @foreach ($warehouse as $row)
                                                        <tr class="gradeA even" role="row">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $row->store_charge }}</td>
                                                            <td>{{ $row->store_start_date }}</td>
                                                            <td>{{ $row->due_date }}</td>
                                                            <td>{{ $row->charge_start }}</td>
                                                            
                                                            <td>
                                                                <div class="form-inline">

                                                                    <a type="button" class="list-icons-item text-primary" title="Edit"
                                                                        href="{{ route('edit_warehouse', ['id' => $row->id]) }}"><i class="icon-pencil7"></i></a>&nbsp
                                                                        
                                                                        
                                                               
                                                                 <a class="button" href="{{ $row->id }}" data-toggle="modal" value="{{ $row->id }}" title="show_warehouse"
                                                                    data-type="show_warehouse" data-target="#app2FormModal" onclick="model({{ $row->id }},'show_warehouse')">Show</a>&nbsp
                                                                        
                                                                     <a class="list-icons-item text-danger" title="Delete"  href="{{route('cf_delete_details',['type'=>'delete-warehouse','type_id'=>$row->id])}}"
                                                                     onclick= "return confirm('Are you sure, you want to delete?')"><i class="icon-trash"></i></a>&nbsp


                                                                </div>
                                                            </td>
                                                        </tr>
                                                     @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="cf2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (!empty($id))
                                                <h5>Edit Warehouse</h5>
                                            @else
                                                <h5>Add New Warehouse</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (!empty($id))
                                                     {!! Form::open(array('route' => 'update_det',"enctype"=>"multipart/form-data")) !!}
                                                     <input type="hidden" name="type" value="warehouse">
                                                     <input type="hidden" name="id" value="{{ $id}}">
                                                    @method('POST')
                                                    @else
                                                   {{ Form::open(['route' => 'save.storage_details']) }}
                                                    @method('POST')
                                                    @endif

                                                    <input type="hidden" name="type" value="warehouse">
                                                    <div class="form-group row"><label
                                                            class="col-lg-3 col-form-label">Storage Charge</label>
                                                        <div class="col-lg-9">
                                                            <input type="number" name="store_charge"
                                                                class="form-control" value="{{ isset($data) ? $data->store_charge : '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-3 col-form-label">Storage Start Due</label>
                                                        <div class="col-lg-9">
                                                            <input type="date" name="store_start_date"
                                                                class="form-control" value="{{ isset($data) ? $data->store_start_date : '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label class="col-lg-3 col-form-label">Due
                                                            Date</label>
                                                        <div class="col-lg-9">
                                                            <input type="date" name="due_date" class="form-control"
                                                               value="{{ isset($data) ? $data->due_date : '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-3 col-form-label">Charge Start of Due
                                                            Date</label>
                                                        <div class="col-lg-9">
                                                            <input type="number" name="charge_start"
                                                                class="form-control" value="{{ isset($data) ? $data->charge_start : '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                    data-toggle="modal" data-target="#myModal"
                                                                    type="submit">Update</button>
                                                            @else
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs"
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
           <!--here-->
        <div class="modal fade" id="app2FormModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            </div>
        </div>

        <div id="appFormModal" class="modal fade" tabindex="-1">
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
    </section>
    
    <script type="text/javascript">
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
                    $('.modal-dialog').html(data);
                },
                error: function(error) {
                    $('#app2FormModal').modal('toggle');

                }
            });

        }
    </script>  
@endsection
