<div class="tab-pane fade @if($type =='post_harvest' || $type =='edit-post_harvest') active show  @endif"
    id="post_harvest" role="tabpanel" aria-labelledby="post_harvest">
    <div class="card">
        <div class="card-header">
            <h4>{{__('farming.post_harvest')}}</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if($type =='post_harvest')active show @endif" id="home-tab4" data-toggle="tab"
                        href="#home8" role="tab4" aria-controls="home8" onclick="{ $type = 'post_harvest'}"
                        aria-selected="true">{{__('farming.post_harvest')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($type =='edit-post_harvest') active show @endif" id="profile-tab4"
                        data-toggle="tab" href="#profile8" role="tab" aria-controls="profile"
                        onclick="{ $type = 'edit-post_harvest'}"
                        aria-selected="false">{{__('farming.new_post_harvest')}}</a>
                </li>

            </ul>
            <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade @if($type =='post_harvest') active show @endif" id="home8" role="tabpanel"
                    aria-labelledby="home-tab4">
                    <div class="table-responsive">
                        <table class="table table-striped col-lg-12 col-sm-12" id="table-1">
                            <thead>
                                <tr role="row">


                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">Category</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;"> Harvest Method</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">Harvest Date</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">Acre</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending"
                                        style="width: 141.219px;">Total Cost</th>

                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                        style="width: 98.1094px;">{{__('farming.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($post_harvest))
                                @foreach ($post_harvest as $row)
                                <tr class="gradeA even" role="row">
                                    <td>{{$row->category}}</td>
                                 <td>{{$row->harvest_method}}</td>
                                    <td>{{$row->harvest_date}}</td>
                                    <td>{{$row->acre}}</td>
                                  <td>{{number_format($row->total_cost,2)}}</td>
                                    



                                    <td>

                                        <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                            href="{{ route('editLifeCycle',['id'=> $row->id,'type'=>'post_harvest','seasson_id'=>$seasson_id])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4"
                                            href="{{ route('seasson.destroy', $row->id)}}">
                                            <i class="fa fa-trash"></i>
                                        </a>

                               
                               <a class="nav-link" title="Crop Monitor" data-toggle="modal" href=""  value="{{ $row->id}}" data-type="assign" data-target="#appFormModal" 
                            onclick="model({{ $row->id  }},'post_harvest')">Crop Monitor</a>


                                        <div class="btn-group">
                                            <button class="btn btn-xs btn-success dropdown-toggle"
                                                data-toggle="dropdown">Change<span class="caret"></span></button>
                                            <ul class="dropdown-menu animated zoomIn">
                                                <li class="nav-item"><a class="nav-link" title="quotation"
                                                        href="{{ route('seasson.show', $row->id)}}">
                                                        {{__('farming.crop_monitoring')}}</a></li>
                                            </ul>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach

                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade @if($type =='edit-post_harvest') active show @endif" id="profile8"
                    role="tabpanel" aria-labelledby="profile-tab4">

                    <div class="card">
                        <div class="card-header">
                            @if(!empty($id))
                            <h5>{{__('farming.post_harvest')}}</h5>
                            @else
                            <h5>{{__('farming.new_post_harvest')}}</h5>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 ">
                                    @if($type =='edit-post_harvest')
                                    {{ Form::model($id, array('route' => array('cropslifecycle.update', $id), 'method' => 'PUT')) }}
                                    @else
                                    {{ Form::open(['route' => 'cropslifecycle.store']) }}
                                    @method('POST')
                                    @endif

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="hidden" name="type" class="form-control" id="type"
                                                value="post_harvest" placeholder="">
                                            <input type="hidden" name="seasson_id" class="form-control" id="type"
                                                value="{{$seasson_id}}" placeholder="">

                                           <label  class="">Category</label> 
                                                   <select class="form-control" name="category" required
                                                        id="category1" onchange = "ShowHideDiv4()">
                                                        <option value="">Select</option>
                                                        
                                                        <option  value="Grain" {{(!empty($data)&&($data->category=='Grain'))? 'selected':''}}>Grain</option>
                                                 <option  value="Non Grain" {{(!empty($data)&&($data->category=='Non Grain'))? 'selected':''}}>Non Grain</option>

                                                      

                                                    </select>
                                        </div>

<script type="text/javascript">
                     function ShowHideDiv4() {
                  var ddlPassport = document.getElementById("category1");
                var dfPassport = document.getElementById("dry1");
             var dzPassport = document.getElementById("market1");
              var dbPassport = document.getElementById("water1");
              dfPassport.style.display = ddlPassport.value == "Grain" ? "block" : "none";
             dzPassport.style.display = ddlPassport.value == "Non Grain" ? "block" : "none";
          dbPassport.style.display = ddlPassport.value == "Non Grain" ? "block" : "none";
    }
             </script>
                                        <div class="form-group col-md-6 col-lg-6">
                                            <label for="date"> {{__('farming.harvest_method')}} </label>
                                         <select class="form-control" name="harvest_method" required
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                        
                                                        <option  value="Hand Harvesting" {{(!empty($data)&&($data->harvest_method=='Hand Harvesting'))? 'selected':''}}>Hand Harvesting</option>
                                                       <option  value="Harvesting with Hand Tool" {{(!empty($data)&&($data->harvest_method=='Harvesting with Hand Tool'))? 'selected':''}}>Harvesting with Hand Tool</option>
                                                       <option  value="Harvesting with Machinery" {{(!empty($data)&&($data->harvest_method=='Harvesting with Machinery'))? 'selected':''}}>Harvesting with Machinery</option>

                                                    </select>

                                        </div>



                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">

                                            <label for="inputEmail4">{{__('farming.maturity_index')}}</label>
                                            <input type="text" name="maturity_index" class="form-control" id="code_name"
                                                value=" {{ !empty($data) ? $data->maturity_index : ''}}" placeholder=""
                                                required>
                                        </div>

                                        <div class="form-group col-md-6 col-lg-6">
                                            <label for="date">Maturity Level</label>
                                            <input type="text" name="maturity_level" class="form-control" id="costing"
                                                value="{{ !empty($data) ? $data->maturity_level : ''}}" placeholder=""
                                                required>

                                        </div>




                                    </div>
                                    <div class="form-row">


                                        <div class="form-group col-md-6 col-lg-6">
                                            <label for="date"> Harvest Date</label>
                                            <input type="date" name="harvest_date" class="form-control date-picker" id="costing"
                                                value="{{ !empty($data) ? $data->harvest_date : ''}}" placeholder=""
                                                required>

                                        </div>

                             <div class="form-group col-md-6 col-lg-6">
                                            <label for="date"> Packing Type</label>
                                            <input type="text" name="packing_type" class="form-control" id="costing"
                                                value="{{ !empty($data) ? $data->packing_type : ''}}" placeholder=""
                                                required>

                                        </div>


                                    </div>

                <div class="form-row">

@if(!empty($data->drying_method))
<div class="form-group col-md-6 col-lg-6" id="dry1" >
                                            <label for="date"> Drying Method</label>
                                             <select class="form-control" name="drying_method" 
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                        
                                                        <option  value="Sun Drying" {{(!empty($data)&&($data->drying_method=='Sun Drying'))? 'selected':''}}>Sun Drying</option>
                                                       <option  value="Hot Air Drying" {{(!empty($data)&&($data->drying_method=='Hot Air Drying'))? 'selected':''}}>Hot Air Drying</option>
                                                      <option  value="Contact Drying" {{(!empty($data)&&($data->drying_method=='Contact Drying'))? 'selected':''}}>Contact Drying</option>
                                                <option  value="Infrared Drying" {{(!empty($data)&&($data->drying_method=='Infrared Drying'))? 'selected':''}}>Infrared Drying</option>
                                  <option  value="Freeze Drying" {{(!empty($data)&&($data->drying_method=='Freeze Drying'))? 'selected':''}}>Freeze Drying</option>
                               <option  value="Fluidized Bed Drying" {{(!empty($data)&&($data->drying_method=='Fluidized Bed Drying'))? 'selected':''}}>Fluidized Bed Drying</option>
                            <option  value="Dielectric Drying" {{(!empty($data)&&($data->drying_method=='Dielectric Drying'))? 'selected':''}}>Dielectric Drying</option>

                                                    </select>

                                        </div>

@else
                                        <div class="form-group col-md-6 col-lg-6" id="dry1" style="display:none;">
                                            <label for="date"> Drying Method</label>
                                             <select class="form-control" name="drying_method" 
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                        
                                                        <option  value="Sun Drying">Sun Drying</option>
                                                       <option  value="Hot Air Drying">Hot Air Drying</option>
                                                      <option  value="Contact Drying">Contact Drying</option>
                                                <option  value="Infrared Drying">Infrared Drying</option>
                                  <option  value="Freeze Drying">Freeze Drying</option>
                               <option  value="Fluidized Bed Drying">Fluidized Bed Drying</option>
                            <option  value="Dielectric Drying">Dielectric Drying</option>

                                                    </select>

                                        </div>
@endif


@if(!empty($data->market))
  <div class="form-group col-md-6 col-lg-6" id="market1">
                                            <label for="date"> Travel Distance to Market</label>
                                            <input type="text" name="market" class="form-control" id="costing"
                                                value="{{ !empty($data) ? $data->market : ''}}" placeholder=""
                                                >
 </div>
@else
                             <div class="form-group col-md-6 col-lg-6" id="market1" style="display:none;">
                                            <label for="date"> Travel Distance to Market</label>
                                            <input type="text" name="market" class="form-control" id="costing"
                                                value="{{ !empty($data) ? $data->market : ''}}" placeholder=""
                                                >

                                        </div>
@endif

                                    </div>

                <div class="form-row">

@if(!empty($data->water))
 <div class="form-group col-md-6 col-lg-6" id="water1" >
                                            <label for="date">Water Content</label>
                                            <input type="text" name="water" class="form-control date-picker" id="costing"
                                                value="{{ !empty($data) ? $data->water : ''}}" placeholder=""
                                               >

                                        </div>
@else
                                        <div class="form-group col-md-6 col-lg-6" id="water1" style="display:none;">
                                            <label for="date">Water Content</label>
                                            <input type="text" name="water" class="form-control date-picker" id="costing"
                                                value="{{ !empty($data) ? $data->water : ''}}" placeholder=""
                                               >

                                        </div>
@endif


                                    </div>

<?php $warehouse=App\Models\Warehouse::all(); ?>
<div class="form row">
                                       @if(!empty($data->warehouse_id))

<div class="form-group col-md-6 col-lg-6" id="warehouse" >
                                            <label for="date">Warehouse</label>
                                             <select class="form-control" name="warehouse_id" 
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                          @if(!empty($warehouse))
                                                                @foreach($warehouse as $row)
                                                      <option @if(isset($data))
                                                                    {{  $data->warehouse_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->warehouse_name}} </option>

                                                                @endforeach
                                                                @endif

                                                    </select>

                                        </div>

@else
                                        <div class="form-group col-md-6 col-lg-6"  id="warehouse" style="display:none;">
                                           <label for="date">Warehouse</label>
                                             <select class="form-control" name="warehouse_id" 
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                       @if(!empty($warehouse))
                                                                @foreach($warehouse as $row)
                                                      <option value="{{ $row->id}}">{{$row->warehouse_name}} </option>

                                                                @endforeach
                                                                @endif
                                                    </select>

                                        </div>
@endif
                                        </div>

                         <div class="form row">
                                        <div class="form-group col-md-6 col-lg-6" >
                                         <label class=""> Cost per acre</label>
                                                   <input type="number" name="cost" id="cost7"
                                                            value="{{ isset($data) ? $data->cost : ''}}"
                                                            class="form-control" required onkeyup="calculateDiscount7();">

                                     

                                        </div>
                                     
                               
                                                   <div class="form-group col-md-6">
                                                          <label for="date">{{__('farming.nh')}}</label>
                                            <input type="number" name="acre" class="form-control" id="acre7"
                                                value="{{ !empty($data) ? $data->acre : ''}}" placeholder=""
                                                required  onkeyup="calculateDiscount7();">
                                                    </div>
                                                </div>

                                <div class="form row">
                                                   <div class="form-group col-md-6" id="total">
                                                    <label class="">Total Cost</label>
                                                   <input type="number" name="total_cost" id="total_cost7"
                                                            value="{{ isset($data) ? $data->total_cost : ''}}"
                                                            class="form-control" required readonly>
                                                    </div>
                                                </div>
  <div class="form row">
                                        <div class="form-group col-md-6 col-lg-6" >
                                         <label class=""> Harvest Amount per acre</label>
                                                   <input type="number" name="harvest_amount" id="harvest7"
                                                            value="{{ isset($data) ? $data->harvest_amount : ''}}"
                                                            class="form-control" required  onkeyup="calculateDiscount7();">

                                      </div>
                                     <div class="form-group col-md-6">
                                                               <label class="">Total Harvest</label>
                                                         <input type="number" name="total_harvest" id="total_harvest7"
                                                            value="{{ isset($data) ? $data->total_harvest : ''}}"
                                                            class="form-control" required readonly>

                                                    </div>
                                        </div>
                                     
                               
                                                 
                                    <div class="form-group row">
                                        <div class="col-lg-offset-2 col-lg-12">
                                            @if($type =='edit-pre_harvest')
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
function calculateDiscount7() {

$('#cost7,#acre7').on('input',function() {
var price7= parseInt($('#cost7').val());
var qty7 = parseFloat($('#acre7').val());
console.log(price7);
$('#total_cost7').val(( price7 * qty7 ?  price7 * qty7 : 0).toFixed(2));
});
$('#harvest7,#acre7').on('input',function() {
var h7= parseInt($('#harvest7').val());
var qty7 = parseFloat($('#acre7').val());
console.log(h7);
$('#total_harvest7').val(( h7 * qty7 ?  h7 * qty7 : 0).toFixed(2));
});
}
    
    </script>
    <script>
    $(document).ready(function() {

        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('change', '.item_name', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('sub_category_id');
            $.ajax({
                url: '/courier/public/findPrice/',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.item_price' + sub_category_id).val(data[0]["price"]);
                    $(".item_unit" + sub_category_id).val(data[0]["unit"]);
                    $(".item_saved" + sub_category_id).val(data[0]["id"]);
                }

            });

        });


    });
    </script>



    <script type="text/javascript">
    <!--
    $(document).ready(function() {


        var count = 0;


        function autoCalcSetup() {
            $('table#cart').jAutoCalc('destroy');
            $('table#cart tr.line_items').jAutoCalc({
                keyEventsFire: true,
                decimalPlaces: 2,
                emptyAsZero: true
            });
            $('table#cart').jAutoCalc({
                decimalPlaces: 2
            });
        }
        autoCalcSetup();

        $('.add').on("click", function(e) {

            count++;
            var html = '';
            html += '<tr class="line_items">';
            html +=
                '<td><div class="col"><div class="input-group"><select name="item_name[]" class="form-control item_name" required  data-sub_category_id="' +
                count +
                '"><option value="">Choose Cost Type</option>@if(isset($name))@foreach($name as $n) <option value="{{ $n->id}}">{{$n->cost_name}}</option>@endforeach @endif</select></div><div class="input-group-append"><button class="btn btn-primary" type="button" data-toggle="modal" onclick="model()" value="" data-target="#appFormModal"><i class="fa fa-plus-circle"></i></button></div></td>';
            html +=
                '<td><input type="text" name="quantity[]" class="form-control item_quantity" data-category_id="' +
                count + '"placeholder ="quantity" id ="quantity" required /></td>';
            html += '<td><input type="text" name="price[]" class="form-control item_price' + count +
                '" placeholder ="price" required  value=""/></td>';

            html += '<td><select name="tax_rate[]" class="form-control item_tax' + count +
                '" required ><option value="0">Select Tax Rate</option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
            html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax' +
                count +
                '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   />';
            html += '<input type="hidden" name="saved_items_id[]" class="form-control item_saved' +
                count +
                '"  required   />';
            html += '<td><input type="text" name="total_cost[]" class="form-control item_total' +
                count +
                '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
            html +=
                '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

            $('tbody').append(html);
            autoCalcSetup();
        });

        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
            autoCalcSetup();
        });


        $(document).on('click', '.rem', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
            $('tfoot').append(
                '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');
            autoCalcSetup();
        });

    });
    //
    -->



    </script>
</div>