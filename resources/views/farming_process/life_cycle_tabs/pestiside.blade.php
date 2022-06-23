<div class="tab-pane fade @if($type =='pestiside' || $type =='edit-pestiside') active show  @endif" id="pestiside"
    role="tabpanel" aria-labelledby="pestiside">
    <div class="card">
        <div class="card-header">
            <h4>{{__('farming.pestiside')}}</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if($type =='pestiside')active show @endif" id="home-tab4" data-toggle="tab"
                        href="#home11" role="tab4" aria-controls="home11" onclick="{ $type = 'pestiside'}"
                        aria-selected="true">{{__('farming.pestiside')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($type =='edit-pestiside') active show @endif" id="profile-tab4"
                        data-toggle="tab" href="#profile11" role="tab" aria-controls="profile"
                        onclick="{ $type = 'edit-pestiside'}" aria-selected="false">{{__('farming.new_pestiside')}}</a>
                </li>

            </ul>
            <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade @if($type =='pestiside') active show @endif" id="home11" role="tabpanel"
                    aria-labelledby="home-tab4">
                    <div class="table-responsive">
                        <table class="table table-striped col-lg-12 col-sm-12" id="table-1">
                            <thead>
                                <tr role="row">


                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">{{__('farming.pestiside_type')}}</th>
                                   <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">{{__('farming.farming_process')}}</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">{{__('farming.pestiside_amount')}}</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">{{__('farming.no_hector')}}</th>
                                   
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">{{__('farming.pestiside_price')}}</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                        style="width: 98.1094px;">{{__('farming.total_costing')}}</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                        style="width: 98.1094px;">{{__('farming.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!@empty($pestiside))
                                @foreach ($pestiside as $row)
                                <tr class="gradeA even" role="row">
                                    <td>{{$row->pestiside_type}}</td>
                                 <td>{{$row->pesticide->name}}</td>
                                    <td>{{$row->farming_processes->process_name}}</td>
                                    <td>{{$row->pestiside_amount}}</td>
                                    <td>{{$row->no_hector}}</td>
                                    <td>{{number_format($row->pestiside_price,2)}}</td>
                                    <td>{{number_format($row->total_cost,2)}}</td>

                                    <td>

                                        <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                            href="{{ route('editLifeCycle',['id'=> $row->id,'type'=>'pestiside','seasson_id'=>$seasson_id])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4"
                                            href="{{ route('seasson.destroy', $row->id)}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                           
                               <a class="nav-link" title="Crop Monitor" data-toggle="modal" href=""  value="{{ $row->id}}" data-type="assign" data-target="#appFormModal" 
                            onclick="model({{ $row->id  }},'pestiside')">Crop Monitor</a>

                                      

                                    </td>
                                </tr>
                                @endforeach

                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade @if($type =='edit-pestiside') active show @endif" id="profile11" role="tabpanel"
                    aria-labelledby="profile-tab4">

                    <div class="card">
                        <div class="card-header">
                            @if(!empty($id))
                            <h5>{{__('farming.pestiside')}}</h5>
                            @else
                            <h5>{{__('farming.new_pestiside')}}</h5>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 ">
                                @if($type =='edit-pestiside')
                                    {{ Form::model($id, array('route' => array('cropslifecycle.update', $id), 'method' => 'PUT')) }}
                                    @else
                                    {{ Form::open(['route' => 'cropslifecycle.store']) }}
                                    @method('POST')
                                    @endif

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="hidden" name="type" class="form-control" id="type"
                                                value="pestiside" placeholder="">
                                                <input type="hidden" name="seasson_id" class="form-control" id="type"
                                                value="{{$seasson_id}}" placeholder="">
                                            <label for="inputEmail4">{{__('farming.pestiside_type')}}</label>
                                            <select class="form-control type" name="pestiside_type" required>
                                             <option value="">Select</option>

                                                         <option value="Insect"  {{(!empty($data)&&($data->pestiside_type=='Insect'))? 'selected':''}}>Insect </option>
                                                <option value="Plants" {{(!empty($data)&&($data->pestiside_type=='Plants'))? 'selected':''}}>Plants</option>
                                                <option value="Batercides" {{(!empty($data)&&($data->pestiside_type=='Batercides'))? 'selected':''}}>Batercides</option>
                                                <option value="Fungicides" {{(!empty($data)&&($data->pestiside_type=='Fungicides'))? 'selected':''}}>Fungicides</option>
                                                <option value="Lavercides" {{(!empty($data)&&($data->pestiside_type=='Lavercides'))? 'selected':''}}>Lavercides </option>
                                                <option value="Rodenticides" {{(!empty($data)&&($data->pestiside_type=='Rodenticides'))? 'selected':''}}>Rodenticides </option>
                                                     
                                            </select>
                                        </div>

                           @if(!empty($data))
                                      <div class="form-group col-md-6 col-lg-6">
                                           <label for="date">Pesticide Name</label>                                          
                                            <select class="form-control" name="pesticide_name" id="pesticide" required>
                                  <option value="" >Select </option>
                                            @if(!empty($seeds_type))
                                                @foreach($seeds_type as $row)
                                                <option value="{{$row->id}}" {{(!empty($data)&&($data->pesticide_name==$row->id))? 'selected':''}}>{{$row->name}} </option>
                                            @endforeach
                                            @endif

                                            </select>

                                        </div>
                                        @else

                                      <div class="form-group col-md-6 col-lg-6">
                                           <label for="date">Pesticide Name</label>                                            
                                            <select class="form-control" name="pesticide_name" id="pesticide" required>
                                  <option value="" >Select </option>
                                         
                                            </select>

                                        </div>
                                   @endif

                                        </div>

                                    <div class="form-row">
                                     <div class="form-group col-md-6 col-lg-6">
                                            <label for="date">{{__('farming.farming_process')}}</label>
                                            <?php
                                           $farming = App\Models\Farming_process::all();
                                            ?>
                                            <select class="form-control" name="farming_process" required>
                                            <option value="">Select</option>
                                                @if(!empty($farming))
                                                @foreach($farming as $row)
                                                <option value="{{$row->id}}" {{(!empty($data)&&($data->farming_process==$row->id))? 'selected':''}}>{{$row->process_name}} </option>
                                                @endforeach
                                                @endif
                                            </select>
</div>
                                        <div class="form-group col-md-6">

                                            <label for="inputEmail4">{{__('farming.pestiside_amount')}}</label>
                                            <input type="text" name="pestiside_amount" class="form-control" id="weight9"
                                                value=" {{ !empty($data) ? $data->pestiside_amount : ''}}" placeholder="" required onkeyup="calculateDiscount9();">
                                        </div>
            </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6 col-lg-6">
                                            <label for="date">{{__('farming.pestiside_price')}}</label>
                                            <input type="number" name="pestiside_price" class="form-control" id="cost9"
                                                value="{{ !empty($data) ? $data->pestiside_price : ''}}" placeholder=""
                                                required  onkeyup="calculateDiscount9();">

                                        </div>
                                     
                                          <div class="form-group col-md-6 col-lg-6">
                                            <label for="date">{{__('farming.no_hector')}} </label>
                                            <input type="number" name="no_hector" class="form-control" id="acre9"
                                                value="{{ !empty($data) ? $data->no_hector : ''}}" placeholder=""
                                                required  onkeyup="calculateDiscount9();">

</div>
                                    </div>

                                    <div class="form-row">
                  
                 <div class="form-group col-md-6 col-lg-6">
                                                    <label class="">Total Cost</label>
                                                   <input type="number" name="total_cost" id="total_cost9"
                                                            value="{{ isset($data) ? $data->total_cost : ''}}"
                                                            class="form-control" required readonly>
                                                    </div>

                                        </div>

                                  
                                 

                                    <div class="form-group row">
                                        <div class="col-lg-offset-2 col-lg-12">
                                        @if($type =='edit-pestiside')
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
    $(document).ready(function() {

        $(document).on('change', '.type', function() {
            var id = $(this).val();
            $.ajax({
               url: '{{url("findPesticide")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                 console.log(data);
                     $("#pesticide").empty();
                $("#pesticide").append('<option value="">Select </option>');
                $.each(data,function(key, value)
                {
                 
                    $("#pesticide").append('<option value=' + value.id+ '>' + value.name + '</option>');

                });            

                }

            });

        });


    });
    </script>

<script>
function calculateDiscount9() {

$('#cost9,#acre9,#weight9').on('input',function() {
var price9= parseInt($('#cost9').val());
var qty9 = parseFloat($('#acre9').val());
var weight9 = parseFloat($('#weight9').val());
console.log(price9);
$('#total_cost9').val((weight9* price9 * qty9 ? weight9* price9 * qty9 : 0).toFixed(2));
});

}
    
    </script>
</div>