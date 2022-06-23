@extends('layouts.master')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Crops Monitoring</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link @if(empty($id)) active  @endif" id="#tab1"
                                            data-toggle="tab" href="#tab1" role="tab" aria-controls="home"
                                            aria-selected="true">Crops Monitoring</a>
                                    </li>
                                    @can('add-crop-monitoring')
                                    <li class="nav-item">
                                        <a class="nav-link @if(!empty($id)) active  @endif" id="#tab2"
                                            data-toggle="tab" href="#tab2" role="tab" aria-controls="profile"
                                            aria-selected="false">New New Monitoring</a>
                                    </li>
                                    @endcan
                           
                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <div class="tab-pane fade @if(empty($id)) active show  @endif"
                                        id="tab1" role="tabpanel" aria-labelledby="tab1">
                                        @can('view-crop-monitoring')
                                        <table class="table table-striped table-md">
                                            <thead>
                                                <tr role="row">

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="width: 208.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Type</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Farm</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Course</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Symptoms</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Attachment</th>
                                                        
                                                         <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Status</th>
                                                   
                                                    

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!@empty($monitoring))
                                                $@foreach ($monitoring as $row)
                                                <tr class="gradeA even" role="row">
                                                    <th>{{ $loop->iteration }}</th>
                                                    <td>{{$row->name}}</td>
                                                    <td>{{$row->type}}</td>
                                                    <td>{{$row->farm->reg_no}} :: {{$row->farm->location}}</td>
                                                    <td>{{$row->course}}</td>
                                                     <td>{{$row->symptoms}}</td>
                                                     <td>
                                                     @if($row->attachment)
                                                     <a href="{{ route('download',['download'=>'pdf','id'=>$row->id]) }}">Download</a>
                                                     @else
                                                     0 pdf
                                                     @endif
                                                     
                                                     </td>
                                                        <td>
                                                     @if($row->status == 1)
                                                    
                                                       <a class=" btn-outline-info text-lowercase" data-toggle="modal" data-target="#appFormModal" data-id="{{ $row->id }}" data-type="show"
                                                        onclick="model({{ $row->id }},'show')"
                                                            href="#">
                                                            has solution
                                                        </a>
                                                     @else
                                                      <a class=" btn-outline-warning text-lowercase"
                                                            href="#">
                                                            no solution
                                                        </a>
                                                     @endif
                                                     
                                                     </td>
                                                      
                                                    <td>
                                                    @can('edit-crop-monitoring')
                                                        <a class="btn-outline-success"
                                                            href="{{ route('crops_monitoring.edit',$row->id )}}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @endcan
                                                        @can('delete-crop-monitoring')
                                                        <a class="btn-outline-danger"
                                                            href="{{ route('crops_monitoring.destroy',$row->id,['id'=>$row->id,'type'=>'tool'])}}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                        @endcan
                                                        @can('edit-crop-monitoring')
                                                         <a class=" btn-outline-info text-lowercase" data-toggle="modal" data-target="#appFormModal" data-id="{{ $row->id }}" data-type="show"
                                                        onclick="model({{ $row->id }},'add')"
                                                            href="#">
                                                            <i class="fas fa-eye">solution</i>
                                                        </a>
                                                        @endcan


                                                    </td>
                                                </tr>
                                                @endforeach

                                                @endif

                                            </tbody>
                                        </table>
                                        @endcan
                                    </div>
                                    <div class="tab-pane fade @if(!empty($id)) active show  @endif"
                                        id="tab2" role="tabpanel" aria-labelledby="tbb2">
                                        <div class="card">
                                            <div class="card-header">
                                                @if(!empty($id))
                                                <h5>Edit Monitoring</h5>
                                                @else
                                                <h5>New Monitoring</h5>
                                                @endif
                                            </div>
                                            <div class="card-body p-0">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('crops_monitoring.update', $id), 'method' => 'PUT','enctype'=>'multipart/form-data')) }}
                                                @else
                                                {{ Form::open(['route' => 'crops_monitoring.store','enctype'=>'multipart/form-data']) }}
                                                @method('POST')
                                                @endif
                                                <div class="card-body">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                         
                                                            <label for="inputEmail4">Name Of Monitoring</label>
                                                            <input type="text" name="name" class="form-control"
                                                                id="name"
                                                                value=" {{ !empty($data) ? $data->name : ''}}"
                                                                placeholder="" required>
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="inputAddress">Types</label>
                                                              <select class="form-control m-b" id="type"
                                                                name="type" required>
                                                                @if(!empty($type))
                                                                @foreach($type as $row)
                                                                <option value="{{$row->name}}"
                                                                    @if(isset($data))@if($data->type == $row->name)
                                                                    selected @endif @endif >{{$row->name}}</option>

                                                                @endforeach
                                                                @endif
                                                            </select>

                                                        </div>
                                  

                                                    </div>
                                                       <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                           
                                                            <label for="inputEmail4">Course</label>
                                                            <input type="text" name="course" class="form-control"
                                                                id="name"
                                                                value=" {{ !empty($data) ? $data->course : ''}}"
                                                                placeholder="" required>
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="inputAddress">Syptoms</label>
                                                            <input type="text" name="symptoms" class="form-control"
                                                                id="costing"
                                                                value="{{ !empty($data) ? $data->symptoms : ''}}"
                                                                placeholder="" required>

                                                        </div>
                                  

                                                    </div>
                                                       <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                           
                                                            <label for="inputEmail4">Attachment</label>
                                                            <input type="file" name="attachment" class="form-control"
                                                                id="attachment"
                                                                value=" {{ !empty($data) ? $data->attachment : ''}}"
                                                                placeholder="">
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="inputAddress">Farm</label>
                                                             <select class="form-control m-b" id="farm_id"
                                                                name="farm_id" required>
                                                                @if(!empty($farm))
                                                                @foreach($farm as $row)
                                                                <option value="{{$row->id}}"
                                                                    @if(isset($data))@if($data->farm_id == $row->id)
                                                                    selected @endif @endif >{{$row->reg_no}}::{{$row->location}}</option>

                                                                @endforeach
                                                                @endif
                                                            </select>

                                                        </div>
                                  

                                                    </div>
                                                  


                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 col-lg-6">
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6 text-right">

                                                             @if(isset($id)) <input type="submit" value="update"
                                                                name="save" class="btn btn-lg btn-primary">
                                                                @else
                                                                <input type="submit" value="save" name="save"
                                                                    class="btn btn-lg btn-primary">
                                                                @endif
                                                        </div>
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
    
        <script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("crops_monitoring.show", ":id") }}';
        url = url.replace(':id', id)

        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }
    </script>

</section>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">

    <div class="row">
        <div class="col-lg-12">

            <div class="tabs-container">
                <ul class="nav nav-tabs">

                </ul>
                <div class="tab-content">

                    <div class="modal inmodal" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection