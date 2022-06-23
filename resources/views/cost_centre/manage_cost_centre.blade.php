@extends('layouts.master')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Cost Centres</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link @if(empty($id)) active  @endif" id="#tab1"
                                            data-toggle="tab" href="#tab1" role="tab" aria-controls="home"
                                            aria-selected="true">Cost Centres</a>
                                    </li>
                                    @can('add-cost-centre')
                                    <li class="nav-item">
                                        <a class="nav-link @if(!empty($id)) active  @endif" id="#tab2"
                                            data-toggle="tab" href="#tab2" role="tab" aria-controls="profile"
                                            aria-selected="false">New Cost Centres</a>
                                    </li>
                                    @endcan
                           
                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <div class="tab-pane fade @if(empty($id)) active show  @endif"
                                        id="tab1" role="tabpanel" aria-labelledby="tab1">
                                        @can('view-cost-centre')
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr role="row">

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="width: 208.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">cost_name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">costing</th>
                                                   
                                                    

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!@empty($cost))
                                                @foreach ($cost as $row)
                                                <tr class="gradeA even" role="row">
                                                    <th>{{ $loop->iteration }}</th>
                                                    <td>{{$row->code_name}}</td>
                                                    <td>{{$row->costing}}</td>
                                                    <td>
                                                    @can('edit-cost-centre')
                                                        <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                            href="{{ route('cost_centre.edit',$row->id )}}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        @endcan
                                                        @can('delete-cost-centre')
                                                        <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4"
                                                            href="{{ route('cost_centre.destroy',$row->id,['id'=>$row->id,'type'=>'tool'])}}">
                                                            <i class="fa fa-trash"></i>
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
                                                <h5>Edit Cost_centre</h5>
                                                @else
                                                <h5>Add Cost_centre</h5>
                                                @endif
                                            </div>
                                            <div class="card-body p-0">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('cost_centre.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'cost_centre.store']) }}
                                                @method('POST')
                                                @endif
                                                <div class="card-body">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <input type="hidden" name="type" class="form-control"
                                                                id="type" value="tool" placeholder="">
                                                            <label for="inputEmail4">cost_name</label>
                                                            <input type="text" name="code_name" class="form-control"
                                                                id="code_name"
                                                                value=" {{ !empty($data) ? $data->code_name : ''}}"
                                                                placeholder="" required>
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="inputAddress">Costing</label>
                                                            <input type="number" name="costing" class="form-control"
                                                                id="costing"
                                                                value="{{ !empty($data) ? $data->costing : ''}}"
                                                                placeholder="" required>

                                                        </div>
                                  

                                                    </div>
                                                  


                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 col-lg-6">
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">

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

</section>

@endsection