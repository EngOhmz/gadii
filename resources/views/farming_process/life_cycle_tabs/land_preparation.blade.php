<div class="tab-pane fade @if($type =='preparation' || $type =='edit-preparation') active show  @endif" id="tab1"
    role="tabpanel" aria-labelledby="tab1">
    <div class="card">
        <div class="card-header">
            <h4>{{__('farming.land')}}</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if($type =='preparation')active show @endif" id="home-tab2"
                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                        aria-selected="true">{{__('farming.preparation_list')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($type =='edit-preparation') active show @endif" id="profile-tab2"
                        data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                        aria-selected="false">{{__('farming.new_preparation')}}</a>
                </li>

            </ul>
            <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade @if($type =='preparation') active show @endif" id="home2" role="tabpanel"
                    aria-labelledby="home-tab2">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr role="row">


                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">{{__('farming.preparation_type')}}</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">{{__('farming.soil_salt')}}</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">{{__('farming.acid_level')}} (PH) </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">{{__('farming.moisture_level')}}</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">{{__('farming.preparation_cost')}}</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                        style="width: 98.1094px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!@empty($preparationDetails))
                                @foreach ($preparationDetails as $row)
                                <tr class="gradeA even" role="row">
                                    <td>{{$row->preparation_type}}</td>
                                    <td>{{$row->soil_salt}}</td>
                                    <td>{{$row->acid_level}}</td>

                                    <td>{{$row->moisture_level}}</td>
                                    <td>{{number_format($row->total_cost,2)}}</td>


                                    <td>

                                        <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                            href="{{ route('editLifeCycle',['id'=> $row->id,'type'=>'preparation','seasson_id'=>$seasson_id])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4" onclick="return confirm('are you sure')"
                                            href="{{ route('deleteLifeCycle',['id'=> $row->id,'type'=>'preparation','seasson_id'=>$seasson_id])}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                   <a class="nav-link" title="Crop Monitor" data-toggle="modal" href=""  value="{{ $row->id}}" data-type="assign" data-target="#appFormModal" 
                            onclick="model({{ $row->id  }},'preparation')">Crop Monitor</a>

                                    </td>
                                </tr>
                            

                                            @endforeach

                                            @endif

                                        </tbody>
                                 
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade @if($type =='edit-preparation') active show @endif" id="profile2"
                    role="tabpanel" aria-labelledby="profile-tab2">

                    <div class="card">
                        <div class="card-header">
                            @if($type =='edit-preparation')
                            <h5>{{__('farming.edit_preparation')}}</h5>
                            @else
                            <h5>{{__('farming.add_preparation')}}</h5>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 ">
                                    @if($type =='edit-preparation')
                                    {{ Form::model($id, array('route' => array('cropslifecycle.update', $id), 'method' => 'PUT')) }}
                                    @else
                                    {{ Form::open(['route' => 'cropslifecycle.store']) }}
                                    @method('POST')
                                    @endif

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="hidden" name="type" class="form-control" id="type"
                                                value="preparation" placeholder="">
                                            <input type="hidden" name="seasson_id" class="form-control" id="type"
                                                value="{{$seasson_id}}" placeholder="">
                                            <label for="inputEmail4">{{__('farming.preparation_type')}}</label>
                                            <select class="form-control" name="preparation_type" required>
                                               <option value="">Select</option>
                                                <option @if(isset($data))
                                                  {{  $data->preparation_type == 'Clearing and weeding the field'  ? 'selected' : ''}}  @endif value="Clearing and weeding the field">Clearing and weeding the field </option>
                                                <option @if(isset($data))
                                                  {{  $data->preparation_type == 'Pre-irrigation'  ? 'selected' : ''}}  @endif value="Pre-irrigation">Pre-irrigation </option>
                                                <option @if(isset($data))
                                                  {{  $data->soil_salt == 'First ploghing or filling'  ? 'selected' : ''}}  @endif  value="First ploghing or filling">First ploghing or filling </option>
                                                <option @if(isset($data))
                                                  {{  $data->preparation_type == 'Harrowing'  ? 'selected' : ''}}  @endif value="Harrowing">Harrowing</option>
                                                <option @if(isset($data))
                                                  {{  $data->preparation_type == 'Flooding'  ? 'selected' : ''}}  @endif value="Flooding">Flooding</option>
                                                <option @if(isset($data))
                                                  {{  $data->preparation_type == 'Levelling'  ? 'selected' : ''}}  @endif value="Levelling">Levelling</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-6">
                                            <label for="date">{{__('farming.soil_salt')}}</label>
                                            <select class="form-control soil" name="soil_salt" id="soil"  required>
                                              <option value="">Select</option>
                                                <option @if(isset($data))
                                                  {{  $data->soil_salt == 'Lime'  ? 'selected' : ''}}  @endif value="Lime">Acidic </option>                                                                  
                                                <option @if(isset($data))
                                                  {{  $data->soil_salt == 'Salt'  ? 'selected' : ''}}  @endif value="Salt">Salt</option>

                                            </select>

                                        </div>
                                    </div>

                                   <div class="form-row">

                                 @if(!empty($data))
                                        <div class="form-group col-md-7">
                                            <label for="inputEmail4">Lime/Base Control Type (PH)</label>
                                           <select class="form-control" name="lime_control"  id="lime"  required>
                                                        <option value="">Select</option>
                                                        @if(!empty($lime))
                                                                @foreach($lime as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->lime_control== $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}} </option>

                                                                @endforeach
                                                                @endif
                                                     
                                                    </select>
                                        </div>
                                        @else
 <div class="form-group col-md-7">
                                        <label for="inputEmail4">Lime/Base Control Type (PH)</label>
                                             <select class="form-control" name="lime_control"  id="lime"  required>
                                                        <option value="">Select</option>
                                                      
                                                    </select>
                                        </div>

                                   @endif

  </div>

                                     <div class="form-row">
                                        <div class="form-group col-md-6">

                                           <label for="inputEmail4">{{__('farming.acid_level')}} (PH)</label>
                                            <input type="text" name="acid_level" class="form-control"
                                                value=" {{ !empty($data) ? $data->acid_level : ''}}" placeholder=""
                                                required>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-6">
                                            <label for="date">{{__('farming.moisture_level')}}</label>
                                            <input type="number" name="moisture_level" class="form-control" id="costing"
                                                value="{{ !empty($data) ? $data->moisture_level : ''}}" placeholder=""
                                                required>

                                        </div>
                                       </div>

                           <div class="form-group row">                                                                                                                                     
                                                   <div class="form-group col-md-6">
                                                  <label  class="">Cost for preparation per acre</label>
                                                    <input type="number" name="cost" id="cost"
                                                            value="{{ isset($data) ? $data->cost : ''}}"
                                                            class="form-control" required  onkeyup="calculateDiscount();">
                                                    </div>

    <div class="form-group col-md-6">
                 <label class="">Acre</label>
                                                   <input type="number" name="acre" id="acre"
                                                            value="{{ isset($data) ? $data->acre : ''}}"
                                                            class="form-control" required  onkeyup="calculateDiscount();">
                                                        
                                                    </div>
                                                </div>

                                                   <div class="form-group row">
                               
                                             

                                             
                                                   <div class="form-group col-md-6">
                                                    <label class="">Total Cost</label>
                                                   <input type="number" name="total_cost" id="total_cost"
                                                            value="{{ isset($data) ? $data->total_cost : ''}}"
                                                            class="form-control" required readonly>
                                                    </div>
                                                </div>

                                             
                                 

                                    <div class="form-group row">
                                        <div class="col-lg-offset-2 col-lg-12">
                                            @if($type =='edit-preparation')
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

        $(document).on('change', '.soil', function() {
            var id = $(this).val();
            $.ajax({
                 url: '{{url("findLime")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                     $("#lime").empty();
                $("#lime").append('<option value="">Select </option>');
                $.each(data,function(key, value)
                {
                 
                    $("#lime").append('<option value=' + value.id+ '>' + value.name + '</option>');

                });            
          
                }

            });

        });


    });
    </script>
<script type="text/javascript">

		  $(document).ready(function(){

      
      var count = 0;


			function autoCalcSetup() {
				$('table#cart').jAutoCalc('destroy');
				$('table#cart tr.line_items').jAutoCalc({keyEventsFire: true, decimalPlaces: 2, emptyAsZero: true});
				$('table#cart').jAutoCalc({decimalPlaces: 2});
			}
			autoCalcSetup();

	$('.add').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html += '<td><input type="text" name="item_name[]" class="form-control item_quantity" data-category_id="'+count+'"placeholder ="quantity" id ="quantity" required /></td>';
        html += '<td><select name="status[]" class="form-control item_name" required  data-sub_category_id="'+count+'"><option value="">Select Item</option><option value="Available">Available</option><option value="Unavailable">Available</option></select></td>';       
       html += '<td><input type="text" name="cost[]" class="form-control item_price'+count+'" placeholder ="price"  value=""/></td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

        $('tbody').append(html);
autoCalcSetup();
      });

  $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
autoCalcSetup();
      });
      

 $(document).on('click', '.rem', function(){  
      var btn_value = $(this).attr("value");   
               $(this).closest('tr').remove();  
            $('tfoot').append('<input type="hidden" name="removed_id[]"  class="form-control name_list" value="'+btn_value+'"/>');  
         autoCalcSetup();
           });  

		});
	


	</script>
<script>
function calculateDiscount() {

$('#cost,#acre').on('input',function() {
var price= parseInt($('#cost').val());
var qty = parseFloat($('#acre').val());
console.log(price);
$('#total_cost').val(( price * qty ?  price * qty : 0).toFixed(2));
});

}
    
    </script>

 

</div>