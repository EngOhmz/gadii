    $(document).ready(function(){
      
      $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
      });

 $(document).on('change', '.item_name', function(){
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        var weight=$('.weight').val();
        $.ajax({
            url: '{{url("findPacelPrice")}}',
                    type: "GET",
          data:{id:id},
             dataType: "json",
          success:function(data)
          {
 console.log(data);
                     $('.item_distance'+sub_category_id).val(data[0]["distance"]);
                 $('.item_charge'+sub_category_id).find('option[name="one"]').val(data[0]["distance"]);
                 $('.item_charge'+sub_category_id).find('option[name="two"]').val(weight);      
          }

        });


});

$(document).on('change', '.item_tax_rate', function(){
  var sub_category_id = $(this).data('sub_category_id');;      
console.log(sub_category_id);

var data=$(this).val();
   $('.item_tax'+sub_category_id).val(data); 

}) 

    });



     $(document).ready(function(){
     




    });

        
          $(document).ready(function(){

      
      var count = 0;


            function autoCalcSetup() {
                $('table#table_quo').jAutoCalc('destroy');
                $('table#table_quo tr.line_items').jAutoCalc({keyEventsFire: true, decimalPlaces: 2, emptyAsZero: true});
                $('table#table_quo').jAutoCalc({decimalPlaces: 2});
            }
            autoCalcSetup();

    $('.add-quo').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html += '<td><select name="item_name[]" class="form-control m-b item_name" required  data-sub_category_id="'+count+'"><?php  foreach ($route as $n): ?><option value="">Select Route</option>@foreach($route as $n)<option value="{{ $n->id}}" @if(isset($i))@if($n->id == $i->item_name) selected @endif @endif >{{$n->from}} - {{$n->to}} </option>@endforeach</select></td>';
        html += '<td><input type="text" name="quantity[]" class="form-control item_quantity" data-category_id="'+count+'" placeholder ="quantity" id ="quantity" required /></td>';
       html += '<td><input type="text" name="price[]" class="form-control item_price'+count+'" placeholder ="price" required  value=""/></td>';
            html += '<td><select name="charge[]" class="form-control m-b item_charge'+count+'" required   data-sub_category_id="'+count+'" ><option value="0">Select Charge </option><option value="1">Flat</option><option value="" name="one">Distance per ton</option><option value="" name="two">Rate per weight</option></select></td>';
       html += '<td><select name="tax_rate[]" class="form-control m-b item_tax'+count+'" required ><option value="0">Select Tax </option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
 html += '<input type="hidden" name="tax_rate[]" class="form-control item_tax'+count+'"  value="0" required   />';
 html += '<input type="hidden" name="items_id[]" class="form-control item_saved'+count+'"  required   />';
 html += '<input type="hidden"  name="distance[]" class="form-control item_distance'+count+'"  required  value="" />';
 html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax'+count+'" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {charge} * {tax_rate}"   />';
       html += '<td><input type="text" name="total_cost[]" class="form-control item_total'+count+'" placeholder ="total"  jAutoCalc="{quantity} * {price}  * {charge}" required readonly  />';           
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('#table_quo>tbody').append(html);
autoCalcSetup();
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });

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
        


    function saveRoute(e){
     
     
     var to = $('#to').val();
     var distance = $('#distance').val();
     var from = $('#from').val();

     
          $.ajax({
            type: 'GET',
            url: '{{url("addRoute")}}',
             data: {
                 'to':to,
                 'distance':distance,
                 'from':from,
             },
          dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var arrival_point = response.from;
                              var destination_point = response.to;

                             var option = "<option value='"+id+"'  selected>From "+arrival_point+" to "+destination_point+"</option>"; 

                             $('#route').append(option);
                              $('#app2FormModal').hide();
                   
                               
               
            }
          
        });
}
    

