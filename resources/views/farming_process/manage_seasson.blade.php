@extends('layouts.master')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('farming.seasson')}}</h4>
                    </div>
                    <div class="card-body">

                               <ul class="nav nav-tabs" id="myTab2" role="tablist">
                             <li class="nav-item">
                                        @can('view-manage_seasson')
                                        <a class="nav-link @if(empty($id)) active  @endif" id="#tab1" data-toggle="tab"
                                            href="#tab1" role="tab" aria-controls="home"
                                            aria-selected="true">{{__('farming.seasson')}}</a>
                                    </li>
                                    @endcan
                                    @can('add-manage_seasson')
                                    <li class="nav-item">
                                        <a class="nav-link @if(!empty($id)) active  @endif" id="#tab2" data-toggle="tab"
                                            href="#tab2" role="tab" aria-controls="profile"
                                            aria-selected="false">{{__('farming.new_seasson')}}</a>
                                    </li>
                                    @endcan

                        </ul>
                               

                                <div class="tab-content tab-bordered"  id="myTab2Content">
                                    <div class="tab-pane fade @if(empty($id)) active show  @endif" id="tab1"
                                        role="tabpanel" aria-labelledby="tab1">
                                        @can('view-manage_seasson')
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr role="row">

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="width: 208.531px;">#</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="width: 208.531px;">Farmer</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="width: 208.531px;">Farm</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">{{__('farming.seasson_name')}}</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">{{__('farming.start_date')}}</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">{{__('farming.crop_name')}}</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">{{__('farming.harvest_date')}}</th>



                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!@empty($seasson))
                                                @foreach ($seasson as $row)
                                                <tr class="gradeA even" role="row">
                                                    <th>{{ $loop->iteration }}</th>
                                                    <td>{{$row->farmer->firstname}} {{$row->farmer->lastname}}</td>
                                                    <td>{{$row->farm->reg_no}}:{{$row->farm->location}}</td>
                                                    <td>{{$row->seasson_name}}</td>
                                                    <td>{{$row->start_date}}</td>
                                                     <td>{{$row->crop->crop_name}}</td>
                                                    <td>{{$row->harvest_date}}</td>
                                                    <td>
                                                        @can('edit-manage_seasson')
                                                        <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                            href="{{ route('seasson.edit',$row->id )}}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        @endcan
                                                        @can('delete-manage_seasson')
                                                        <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4"
                                                            href="{{ route('seasson.destroy',$row->id,['id'=>$row->id,'type'=>'tool'])}}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                        @endcan
                                                        @can('edit-manage_seasson')
                                                        <div class="btn-group">
                                                            <button class="btn btn-xs btn-success dropdown-toggle"
                                                                data-toggle="dropdown">Change<span
                                                                    class="caret"></span></button>
                                                            <ul class="dropdown-menu animated zoomIn">
                                                                <li class="nav-item"><a class="nav-link"
                                                                        title="quotation"
                                                                        href="{{ route('seasson.show', $row->id)}}">
                                                                        {{__('farming.seasson_details')}}</a></li>
                                                            </ul>
                                                        </div>
                                                        @endcan



                                                    </td>
                                                </tr>
                                                @endforeach

                                                @endif

                                            </tbody>
                                        </table>
                                        @endcan
                                    </div>
                                    <div class="tab-pane fade @if(!empty($id)) active show  @endif" id="tab2"
                                        role="tabpanel" aria-labelledby="tbb2">
                                        <div class="card">
                                            <div class="card-header">
                                                @if(!empty($id))
                                                <h5>{{__('farming.edit')}} {{__('farming.seasson')}}</h5>
                                                @else
                                                <h5>Add {{__('farming.seasson')}}</h5>
                                                @endif
                                            </div>
                                            <div class="card-body p-0">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('seasson.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'seasson.store']) }}
                                                @method('POST')
                                                @endif
                                                <div class="card-body">
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Farmer Name</label>

                                                        <div class="col-lg-10">
                                                            <div class="input-group">
                                                                <select class="form-control farmer_id" id="farmer_id"
                                                                    name="farmer_id" required>
                                                                  <option ="">Select</option>
                                                                    @if(!empty($farmer))
                                                                    @foreach($farmer as $row)
                                                                    <option value="{{$row->id}}"
                                                                        @if(isset($data))@if($data->farmer_id ==
                                                                        $row->id)
                                                                        selected @endif @endif >{{$row->firstname}} {{$row->lastname}}
                                                                    </option>

                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                                <div class="input-group-append">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                     @if(!empty($data))
                            <div class="form-group row"><label
                                 class="col-lg-2 col-form-label">Farm</label>
                                  <div class="col-lg-10">
                                                            <div class="input-group">
                                  <select class="form-control m-b" name="farm_id"  id="farm_id" required>                                                               
                                                              <option ="">Select</option>
                                    
                                    @if(!empty($farm))
                                                        @foreach($farm as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->farm_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->reg_no}} : {{$row->location}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                 <div class="input-group-append">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
@else
                         <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Farm</label>

                                                        <div class="col-lg-10">
                                                            <div class="input-group">
                                                                <select class="form-control m-b" name="farm_id"
                                                                    id="farm_id" required>
                                                              <option ="">Select</option>
                                                                </select>
                                                                <div class="input-group-append">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
 @endif
                              
                                                    
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <input type="hidden" name="type" class="form-control"
                                                                id="type" value="tool" placeholder="">
                                                            <label
                                                                for="inputEmail4">{{__('farming.seasson_name')}}</label>
                                                            <input type="text" name="seasson_name" class="form-control"
                                                                id="code_name"
                                                                value=" {{ !empty($data) ? $data->seasson_name : ''}}"
                                                                placeholder="" required>
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="date">{{__('farming.start_date')}}</label>
                                                            <input type="date" name="start_date" class="form-control"
                                                                id="costing"
                                                                value="{{ !empty($data) ? $data->start_date : ''}}"
                                                                placeholder="" required>

                                                        </div>


                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <input type="hidden" name="type" class="form-control"
                                                                id="type" value="tool" placeholder="">
                                                            <label for="inputEmail4">{{__('farming.crop_name')}}</label>
                                                            <select class="form-control" name="crop_name" required
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                        @if(!empty($crop))
                                                                @foreach($crop as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->crop_name == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->crop_name}} </option>

                                                                @endforeach
                                                                @endif
                                                     
                                                    </select>
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="date">{{__('farming.harvest_date')}}</label>
                                                            <input type="date" name="harvest_date" class="form-control"
                                                                id="costing"
                                                                value="{{ !empty($data) ? $data->harvest_date : ''}}"
                                                                placeholder="" required>

                                                        </div>


                                                    </div>



                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 col-lg-6">
                                                        </div>

                                                        <div class="form-group col-md-6 col-lg-6">

                                                            @if(isset($id)) <input type="submit" value="update"
                                                                name="save" class="btn btn-lg btn-primary form-control">
                                                            @else
                                                            <input type="submit" value="save" name="save"
                                                                class="btn btn-lg btn-primary form-control">
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

</section>

<script>
$(document).ready(function() {

    $(document).on('change', '.farmer_id', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findFarm")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#farm_id").empty();
                $("#farm_id").append('<option value="">Select </option>');
                $.each(response,function(key, value)
                {
                 
                    $("#farm_id").append('<option value=' + value.id+ '>' + value.reg_no  + ' : '+value.location+'</option>');

                });                      
               
            }

        });

    });


});
</script>
<script>
$(function() {
    $('#farmer').trigger('change');

})

$('#farmer').change(function() {

    let id = $(this).val()
 
    $.ajax({
        type: 'GET',
        url: '{{url("getFarm")}}',
        data: {
            'id': id,
        },
        cache: false,
        async: true,
        success: function(response) {
  
            var len = 0;
            if (response.data != null) {
                len = response.data.length;
            }
            $('#farm_id').html("");
            if (len > 0) {
                $('#farm_id').html("");
                for (var i = 0; i < len; i++) {
                 
                    var id = response.data[i].id;
                    var reg_no = response.data[i].reg_no;
                    var location = response.data[i].location;

                    var option = "<option value='" + id + "'>" + reg_no + ":" + location +"</option>";
                     var option = "<option value='"+id+"'>From "+arrival_point+" to "+destination_point+"</option>"; 
                    $("#farm_id").append(option);
                   
                }
            }
        },
        error: function(error) {
            $('#appFormModal').modal('toggle');

        }
    });
});
</script>

@endsection