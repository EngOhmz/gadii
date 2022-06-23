<div class="tab-pane fade @if($type =='weeding' || $type =='edit-weeding') active show  @endif" id="weeding"
    role="tabpanel" aria-labelledby="weeding">
    <div class="card">
        <div class="card-header">
            <h4>{{__('farming.weeding')}}</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if($type =='weeding')active show @endif" id="home-tab7" data-toggle="tab"
                        href="#home7" role="tab" aria-controls="home" onclick="{ $type = 'weeding'}"
                        aria-selected="true">{{__('farming.weeding')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($type =='edit-sowing') active show @endif" id="profile-tab7"
                        data-toggle="tab" href="#profile7" role="tab" aria-controls="profile"
                        onclick="{ $type = 'edit-weeding'}" aria-selected="false">{{__('farming.new_weeding')}}</a>
                </li>

            </ul>
            <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade @if($type =='weeding') active show @endif" id="home7" role="tabpanel"
                    aria-labelledby="home-tab7">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr role="row">


                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">Weeding Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">GAP</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">Weed Control Method</th>
                                       <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">Chemical Status</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">Acre</th>                            
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">{{__('farming.preparation_cost')}}</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                        style="width: 98.1094px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!@empty($weeding))
                                @foreach ($weeding as $row)
                                <tr class="gradeA even" role="row">
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->farm_gap->process_name}}</td>
                                    <td>{{$row->method}}</td>
                                    <td>{{$row->chemical_status}}</td>
                                    <td>{{$row->acre}}</td>
                                    <td>{{number_format($row->total_cost,2)}}</td>


                                    <td>

                                        <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                            href="{{ route('editLifeCycle',['id'=> $row->id,'type'=>'weeding','seasson_id'=>$seasson_id])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4" onclick="return confirm('are you sure')"
                                            href="{{ route('deleteLifeCycle',['id'=> $row->id,'type'=>'weeding','seasson_id'=>$seasson_id])}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                 
                               <a class="nav-link" title="Crop Monitor" data-toggle="modal" href=""  value="{{ $row->id}}" data-type="assign" data-target="#appFormModal" 
                            onclick="model({{ $row->id  }},''weeding')">Crop Monitor</a>

                                    </td>
                                </tr>
                                @endforeach

                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade @if($type =='edit-weeding') active show @endif" id="profile7" role="tabpanel"
                    aria-labelledby="profile-tab7">

                    <div class="card">
                        <div class="card-header">
                            @if(!empty($id))
                            <h5>{{__('farming.weeding')}}</h5>
                            @else
                            <h5>{{__('farming.new_weeding')}}</h5>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 ">
                                @if($type =='edit-weeding')
                                    {{ Form::model($id, array('route' => array('cropslifecycle.update', $id), 'method' => 'PUT')) }}
                                    @else
                                    {{ Form::open(['route' => 'cropslifecycle.store']) }}
                                    @method('POST')
                                    @endif

                                    <div class="form-row">

                                      <div class="form-group col-md-6 col-lg-6">
                   <label class="">Weeding Name</label>
                                                           <input type="text" name="name"
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                               
                                                <div class="form-group col-md-6 col-lg-6">
                                              <?php $gap= App\Models\Farming_process::all();  ?>
                                          <label  class="">GAP</label>
                                                   <select class="form-control" name="process" required
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                        @if(!empty($gap))
                                                                @foreach($gap as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->process == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->process_name}} </option>

                                                                @endforeach
                                                                @endif
                                                     
                                                    </select>
                                                        
                                                    </div>
                                                </div>

                                 <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="hidden" name="type" class="form-control" id="type"
                                                value="weeding" placeholder="">
                                                <input type="hidden" name="seasson_id" class="form-control" id="type"
                                                value="{{$seasson_id}}" placeholder="">

                                            <label for="inputEmail4">Weed Control Method</label>
                                            <select class="form-control crop" name="method" required>
                                     <option value="" >Select </option>
                                                <option value="Preventative Weed Control" {{(!empty($data)&&($data->method=='Preventative Weed Control'))? 'selected':''}}>Preventative Weed Control</option>
                                      <option value="Culture Weed Control" {{(!empty($data)&&($data->method=='Culture Weed Control'))? 'selected':''}}>Culture Weed Control</option>
                                  <option value="Mechanical Weed Control" {{(!empty($data)&&($data->method=='Mechanical Weed Control'))? 'selected':''}}>Mechanical Weed Control</option>
                              <option value="Biological Weed Control" {{(!empty($data)&&($data->method=='Biological Weed Control'))? 'selected':''}}>Biological Weed Control</option>
                          <option value="Chemical Weed Control" {{(!empty($data)&&($data->method=='Chemical Weed Control'))? 'selected':''}}>Chemical Weed Control</option>
                                            </select>
                                        </div>

                                     
                                      <div class="form-group col-md-6 col-lg-6">
                                           <label for="date">Effect Course to Plant</label>                                          
                                   <textarea name="effect" class="form-control crop">{{ isset($data) ? $data->effect : ''}}</textarea>

                                        </div>
 </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">

                                            <label for="inputEmail4">Is Chemical Used</label>
                                             <select class="form-control crop" name="chemical_status" id="chemical_status" required onchange = "ShowHideDiv()">
                                     <option value="" >Select </option>
                                                <option value="Yes" {{(!empty($data)&&($data->chemical_status=='Yes'))? 'selected':''}}>Yes</option>
                                      <option value="No" {{(!empty($data)&&($data->chemical_status =='No'))? 'selected':''}}>No</option>
                                            </select>
                                        </div>
 </div>

<script type="text/javascript">
                     function ShowHideDiv() {
                  var ddlPassport = document.getElementById("chemical_status");
                var dfPassport = document.getElementById("chem");
             var dzPassport = document.getElementById("cost");
              var dbPassport = document.getElementById("weed");
              dfPassport.style.display = ddlPassport.value == "Yes" ? "block" : "none";
             dzPassport.style.display = ddlPassport.value == "Yes" ? "inline" : "none";
          dbPassport.style.display = ddlPassport.value == "No" ? "block" : "none";
    }
             </script>

@if(!empty($data->chemical))
 <div class="form-row"  id="chem">
                                        <div class="form-group col-md-6">

                                            <label for="inputEmail4"> Chemical Kg/Acre</label>
                                       <input type="number" name="chemical" class="form-control" id="chem4"
                                                value="{{ !empty($data) ? $data->chemical : ''}}" placeholder=""
                                               >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="date">{{__('farming.cost')}} per Kg</label>
                                            <input type="number" name="cost" class="form-control" id="cost4"
                                                value="{{ !empty($data) ? $data->cost : ''}}" placeholder=""
                                              >

                                        </div>
 </div>

@else
 <div class="form-row"  id="chem"  style="display:none;">
                                        <div class="form-group col-md-6">

                                            <label for="inputEmail4"> Chemical Kg/Acre</label>
                                       <input type="number" name="chemical" class="form-control" id="chem4"
                                                value="{{ !empty($data) ? $data->chemical : ''}}" placeholder=""
                                               >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="date">{{__('farming.cost')}} per Kg</label>
                                            <input type="number" name="cost" class="form-control" id="cost4"
                                                value="{{ !empty($data) ? $data->cost : ''}}" placeholder=""
                                              >

                                        </div>
 </div>

@endif

  <div class="form-row">
@if(!empty($data->weed_cost))
   <div class="form-group col-md-6 col-lg-6" id="weed">
                                            <label for="date">Weed Control Cost/Acre</label>
                                            <input type="number" name="weed_cost" class="form-control" id="weed4"
                                                value="{{ !empty($data) ? $data->weed_cost : ''}}" placeholder=""
                                                 >

                                        </div>

@else

   <div class="form-group col-md-6 col-lg-6" id="weed" style="display:none;">
                                            <label for="date">Weed Control Cost/Acre</label>
                                            <input type="number" name="weed_cost" class="form-control" id="weed4"
                                                value="{{ !empty($data) ? $data->weed_cost : ''}}" placeholder=""
                                                 >

                                        </div>
                                     
@endif

                                        <div class="form-group col-md-6 col-lg-6" id="acre">
                                            <label for="date">{{__('farming.nh')}}</label>
                                            <input type="number" name="acre" class="form-control" id="acre4"
                                                value="{{ !empty($data) ? $data->acre : ''}}" placeholder=""
                                                required  >

                                        </div>
                                     
                                    </div>

                         <div class="form-group row">
                               
                                                   <div class="form-group col-md-6" id="total">
                                                    <label class="">Total Cost</label>
                                                   <input type="number" name="total_cost" id="total_cost4"
                                                            value="{{ isset($data) ? $data->total_cost : ''}}"
                                                            class="form-control" required readonly>
                                                    </div>
                                                </div>

                                    <div class="form-group row">
                                        <div class="col-lg-offset-2 col-lg-12">
                                        @if($type =='edit-weeding')
                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                data-toggle="modal" data-target="#myModal" type="submit">Update</button>
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
$('#chemical_status').change(function(){
  if($(this).val() == 'Yes'){ 
$('#acre4').val('');
$('#weed4').val('');
$('#total_cost4').val('');
    $('#cost4,#acre4,#chem4').on('input',function() {
var price4= parseInt($('#cost4').val());
var qty4 = parseFloat($('#acre4').val());
var w4 = parseFloat($('#chem4').val());
console.log(price4);
$('#total_cost4').val((w4 * price4 * qty4 ?w4 * price4 * qty4 : 0).toFixed(2));
  
});
}

  else if($(this).val() == 'No'){
$('#cost4').val('');
$('#acre4').val('');
$('#chem4').val('');
$('#total_cost4').val('');

   $('#weed4,#acre4').on('input',function() {
var price4= parseInt($('#weed4').val());
var qty4 = parseFloat($('#acre4').val());
console.log(price4);
$('#total_cost4').val(( price4 * qty4 ? price4 * qty4 : 0).toFixed(2));
  
});
}

});

       
  



    
    </script>

  
</div>