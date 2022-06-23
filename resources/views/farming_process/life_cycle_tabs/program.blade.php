  <div class="tab-pane fade @if($type =='program' || $type =='edit-program') active show  @endif" id="program"
    role="tabpanel" aria-labelledby="program">
    <div class="card">
        <div class="card-header">
            <h4>Farm Program</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if($type =='program')active show @endif" id="home-tab3" data-toggle="tab"
                        href="#home20" role="tab" aria-controls="home" onclick="{ $type = 'program'}"
                        aria-selected="true">Farm Program List
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($type =='edit-program') active show @endif" id="profile-tab3"
                        data-toggle="tab" href="#profile20" role="tab" aria-controls="profile"
                        onclick="{ $type = 'edit-program'}" aria-selected="false">New Farm Program</a>
                </li>

            </ul>
            <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade @if($type =='program') active show @endif" id="home20" role="tabpanel"
                    aria-labelledby="home-tab3">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr role="row">



                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Program Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">GAP</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Cost per acre</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Acre</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Total Cost</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Distributor</th>
                                              
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!@empty($program))
                                @foreach ($program as $row)
                                <tr class="gradeA even" role="row">
                                    <td>{{$row->name }}</td>
                                                  <td>{{$row-> farm_gap->process_name }}</td>
                                                <td>{{number_format($row->cost,2)}}</td>
                                                <td>{{$row->acre }}</td>
                                                 <td>{{number_format($row->total_cost,2)}}</td>
                                                 <td>{{$row->distributor }}</td>


                                    <td>

                                        <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                            href="{{ route('editLifeCycle',['id'=> $row->id,'type'=>'program','seasson_id'=>$seasson_id])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4" onclick="return confirm('are you sure')"
                                            href="{{ route('deleteLifeCycle',['id'=> $row->id,'type'=>'program','seasson_id'=>$seasson_id])}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                            <a class="nav-link" title="Crop Monitor" data-toggle="modal" href=""  value="{{ $row->id}}" data-type="assign" data-target="#appFormModal" 
                            onclick="model({{ $row->id  }},'program')">Crop Monitor</a>

                                    </td>
                                </tr>
                                @endforeach

                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade @if($type =='edit-program') active show @endif" id="profile20" role="tabpanel"
                    aria-labelledby="profile-tab3">

                    <div class="card">
                        <div class="card-header">
                            @if(!empty($id))
                            <h5>Edit Farm Program</h5>
                            @else
                            <h5>New Farm Program</h5>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 ">
                                @if($type =='edit-program')
                                    {{ Form::model($id, array('route' => array('cropslifecycle.update', $id), 'method' => 'PUT')) }}
                                    @else
                                    {{ Form::open(['route' => 'cropslifecycle.store']) }}
                                    @method('POST')
                                    @endif

                                   <div class="form-group row"><label class="col-lg-2 col-form-label">Program Name</label>
                                                   <div class="col-lg-10">
                                                    
                                                           <input type="text" name="name"
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                         <input type="hidden" name="type" class="form-control" id="type"
                                                value="program" placeholder="">
                                                <input type="hidden" name="seasson_id" class="form-control" id="type"
                                                value="{{$seasson_id}}" placeholder="">

                                          <?php $gap= App\Models\Farming_process::all();  ?>
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">GAP</label>

                                                    <div class="col-lg-10">
                                                   <select class="form-control" name="gap" required
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                        @if(!empty($gap))
                                                                @foreach($gap as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->gap == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->process_name}} </option>

                                                                @endforeach
                                                                @endif
                                                     
                                                    </select>
                                                        
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Cost per acre</label>

                                                    <div class="col-lg-10">
                                                    <input type="number" name="cost" id="cost6"
                                                            value="{{ isset($data) ? $data->cost : ''}}"
                                                            class="form-control" required  onkeyup="calculateDiscount6();">
                                                        
                                                    </div>
                                                </div>

                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Acre</label>
                                                       
                                                    <div class="col-lg-10">
                                                   <input type="number" name="acre" id="acre6"
                                                            value="{{ isset($data) ? $data->acre : ''}}"
                                                            class="form-control" required  onkeyup="calculateDiscount6();">
                                                    </div>
                                                </div>

                                              <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Total Cost</label>
                                                       
                                                    <div class="col-lg-10">
                                                   <input type="number" name="total_cost" id="total_cost6"
                                                            value="{{ isset($data) ? $data->total_cost : ''}}"
                                                            class="form-control" required readonly>
                                                    </div>
                                                </div>

                                                 <div class="form-group row"><label class="col-lg-2 col-form-label">Distributor</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="distributor"
                                                            value="{{ isset($data) ? $data->distributor : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if($type =='edit-program')
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

<script>
function calculateDiscount6() {

$('#cost6,#acre6').on('input',function() {
var price6= parseInt($('#cost6').val());
var qty6 = parseFloat($('#acre6').val());
console.log(price6);
$('#total_cost6').val((qty6* price6 ? qty6 * price6 : 0).toFixed(2));
});

}
    
    </script>

  
</div>