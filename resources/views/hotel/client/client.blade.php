@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Client</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Client
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Client</a>
                            </li>
                            
                             

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                      <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 38.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Phone</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                       rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Nationality</th> 
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 161.219px;">Address</th>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 108.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($client))
                                            @foreach ($client as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->name}} @if(!empty($row->member_id)) - <span class="badge badge-info badge-shadow">Subscribed</span> @endif</td>
                                                <td>{{$row->phone}}</td>
                                              <td> @if(!empty($row->nationality)){{$row->nation->name}} @endif</td>
                                           <td> {{$row->address}}</td>                         


                                                <td>
                                                 <div class="form-inline">
                                                 
                                                <div class = "input-group"> 
                                              <a class="list-icons-item text-primary"
                                                        href="{{ route("visitor.edit", $row->id)}}"><i
                                                            class="icon-pencil7"></i>
                                                    </a>
                                        </div>&nbsp
                                  <div class = "input-group"> 
         {!! Form::open(['route' => ['visitor.destroy',$row->id], 'method' => 'delete']) !!}
                                                            {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                            {{ Form::close() }}
                             </div>
                             </div>
                                                 
                                                 

                                                </td>
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                    @if(!empty($id))
                                            <h5>Edit Client</h5>
                                            @else
                                            <h5>Add New Client</h5>
                                            @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            @if(isset($id))
                                                    {{ Form::model($id, array('route' => array('visitor.update', $id), 'method' => 'PUT')) }}
                                                    @else
                                                    {{ Form::open(['route' => 'visitor.store']) }}
                                                    @method('POST')
                                                    @endif

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Name</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="name"
                                                                value="{{ isset($data) ? $data->name : ''}}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Phone</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="phone"
                                                                value="{{ isset($data) ? $data->phone : ''}}"
                                                                class="form-control"  placeholder="+255713000000">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Email</label>

                                                        <div class="col-lg-10">
                                                            <input type="email" name="email"
                                                                value="{{ isset($data) ? $data->email : ''}}"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Address</label>

                                                        <div class="col-lg-10">
                                                            <textarea name="address"  class="form-control">  {{ isset($data) ? $data->address : ''}} </textarea>
                                                                                                                    

</div>
                                                    </div>
                                                 

                                                        <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Nationality</label>

                                                        <div class="col-lg-10">
                                                         <select class="form-control m-b" name="nationality"  required>
                                                                    <option value="">Select Nationality</option>
                                                                    @if (!empty($nation))
                                                                    @foreach ($nation as $row)
                                                        <option @if (isset($data)) {{ $data->nationality == $row->id ? 'selected' : '' }} @endif value="{{ $row->id }}">{{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif

                                                                </select>
                                                                
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Place of Birth</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="place_of_birth"
                                                                value="{{ isset($data) ? $data->place_of_birth : ''}}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Occupation</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="occupation"
                                                                value="{{ isset($data) ? $data->occupation : ''}}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Identity Type</label>
                                                       <div class="col-lg-10">
                                                       <select class="form-control m-b related_class" name="identity_type" required  
                                                                    id="identity_type">
                                                                    <option >Select Type </option>
                                                                    <option value="Passport" @if(isset($data))@if($data->identity_type == 'Passport') selected @endif @endif >Passport</option>
                                                                    <option value="National ID(NIDA)" @if(isset($data))@if($data->identity_type == 'National ID(NIDA)') selected @endif @endif >National ID(NIDA)</option>
                                                                    <option value="National Voter ID(KURA)" @if(isset($data))@if($data->identity_type == 'National Voter ID(KURA)') selected @endif @endif >National Voter ID(KURA)</option>
                                                                
                                                                 </select>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                     <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Identity number</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="identity_no"
                                                                value="{{ isset($data) ? $data->identity_no : ''}}"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Date of Birth</label>

                                                        <div class="col-lg-10">
                                                            <input type="date" name="dob"
                                                                value="{{ isset($data) ? $data->dob : ''}}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Tribe</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="tribe"
                                                                value="{{ isset($data) ? $data->tribe : ''}}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
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
</section>


@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [3]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection