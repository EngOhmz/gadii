@if(!empty($purchases))



<?php $a=0; ?>

                                                                   
                                            <div class="form-group row">
                                                    

                                              <label class="col-lg-2 col-form-label">Total Quantity</label>
                                                    <div class="col-lg-4">
                                              <input type="text"   value="" name="quantity"  id="qty"
                                                            class="form-control qty" required>
                                                   
                                                      
                                                </div>

                                        <label class="col-lg-2 col-form-label">Truck</label>
                                                    <div class="col-lg-4">
                                                     <select class="select_truck  select2" style="width: 100%"  
                                                         id="truck_id" name="truck_id">
                                                 <option value="">Select 
                                                    @if(!empty($truck))
                                                    @foreach($truck as $c)

                                                    <option  value="{{$c->id}}">{{$c->reg_no}} - {{$c->truck_name}}</option>

                                                    @endforeach
                                                    @endif                                              
 
                                             </select>
                                                   
                                                </div>


                                            </div> 

 <br><br>
                                                <h4 align="center">Enter Transport Cost</h4>
                                                <hr> 
<div class="form-group row">
                                              <label class="col-lg-2 col-form-label">Rate per distance</label>
                                                    <div class="col-lg-2">
                                                  
                                              <input type="text" name="rate"  id="rate" value=""
                                                            class="form-control" required>
                                                   
                                                </div>
  <label class="col-lg-2 col-form-label">Distance in KM</label>
                                                    <div class="col-lg-2">
                                                  
                                              <input type="text" name="distance"  id="distance"  value=""
                                                            class="form-control" required>
                                                   
                                                </div>
  <label class="col-lg-2 col-form-label">Transport Cost</label>
                                                    <div class="col-lg-2">
                                                  
                                              <input type="text" name="transport"  id="transport"  value=""
                                                            class="form-control" readonly required>
                                                   
                                                </div>

                                            </div>

   @if(!@empty($reqlevy))
@foreach($reqlevy as $req)
<input type="hidden" name="levy_req_id[]"   value="{{$req->id}}" class="form-control" required>
    @endforeach                                                        
@endif


                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save" >Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!} 



@else

<h2>NO DATA FOUND</h2>


@endif

{{-- @yield('scripts') --}}


<script>
$(document).on("change", function () {
 var price= parseInt($('#rate').val());
    var qty = parseFloat($('#distance').val());
console.log(price);
    $('#transport').val((price * qty ? price * qty : 0).toFixed(2));;


        
    });
</script>

<script type='text/javascript'>
$(qty).on("change", function () {
    
    let quantity = document.getElementById("qty").value; 
        let source = document.getElementById("source").value; 
            let date = document.getElementById("date").value; 
    
             $.ajax({
            type: 'GET',
            url: '{{route("movement.chekBalance")}}',
            data: {
                'quantity': quantity,
                'date': date,
                'source': source,
                
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
            
                 $("#appFormModal").modal('toggle');
                 $('.modal-dialog').html(data);
            
            },
            error: function(error) {
                //$('#appFormModal').modal('toggle');

            }
        });
});

$(document).on("change", function () {
      


 $(function () {  
       $('input:checkbox').click(function (e) {  
         calculateSum(2);  
       });  
     function calculateSum(colidx) {
     
  var qty= 0; 

       $("tr:has(:checkbox:checked) td:nth-child(" + colidx + ") input").each(function () {  

         qty += parseFloat($(this).val());
        console.log(qty);
         });  
         $('#total_quantity').val(qty.toFixed(2));  
       }  
     }); 


 $(function () {  
       $('input:checkbox').click(function (e) {  
         calculateTotalSum(4);  
       });  
     function calculateTotalSum(colidx) {
     
  var total= 0; 

       $("tr:has(:checkbox:checked) td:nth-child(" + colidx + ") input").each(function () {  
      a=$(this).val().replace(/\,/g,''); // 1125, but a string, so convert it to number

        total += parseInt(a,10); 
        console.log(total);
         });  
         $('#amount').val(total.toFixed(2));  
       }  
     }); 


$('input:checkbox').click(function() {
  var sub_category_id = $(this).data('sub_category_id');;      
console.log(sub_category_id);
  if($(this).is(':checked')){   
          $('.item_quantity'+sub_category_id).attr("name", "checked_quantity[]");;
  $('.item_price'+sub_category_id).attr("name", "checked_price[]");;
  $('.item_cost'+sub_category_id).attr("name", "checked_total_cost[]");;
  $('.item_purchase'+sub_category_id).attr("name", "checked_purchase_id[]");;
   $(this).attr("name", "checked_item_id[]");; 
  }
else{
  $('.item_quantity'+sub_category_id).attr("name", "quantity[]");;
$('.item_price'+sub_category_id).attr("name", "price[]");;
  $('.item_cost'+sub_category_id).attr("name", "total_cost[]");;
  $('.item_purchase'+sub_category_id).attr("name", "purchase_id[]");;
   $(this).attr("name", "item_id[]");; 
}

})



});
</script>







<script>
$('input:checkbox').click(function() {
 if ($(this).is(':checked')) {
 $('#save').prop("disabled", false);
 } else {
 if ($('.checks').filter(':checked').length < 1){
 $('#save').prop("disabled", true);

}
 }
});

         </script>

<script type="text/javascript">
$(document).ready(function() {



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

   

});
</script>



<script type="text/javascript">
$(document).ready(function() {


    var count = 0;


  new TomSelect(".select_truck",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });

    $('.add').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +=
            '<td><select name="levy_id[]" class="form-control item_levy" required "><option value="">Select Item</option>@foreach($levy as $n) <option value="{{ $n->id}}">{{$n->name}}</option>@endforeach</select></td>';      
       
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

        $('#levy').append(html);
   
    });

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
       
    });



});
</script>
