@if(!empty($purchases))



<?php $a=0; ?>

                                                                   
                                            <div class="form-group row">
                                                    

                                              <label class="col-lg-2 col-form-label">Total Quantity</label>
                                                    <div class="col-lg-4">
                                              <input type="text"   value="" name="quantity"  id="qty"
                                                            class="form-control qty" required>
                                                   
                                                      
                                                </div>

                                            </div> 
 <br>
                                                <h4 align="center">Enter Levy Details</h4>
                                                <hr>
<button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                        class="fas fa-plus"> Add Levy</i></button><br>
                                                <br>

                                                  
                                                                              <div class="table-responsive">
                                                <table class="table table-bordered" >
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>                                                          
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="levy">


                                                    </tbody>
                                                    <tfoot>
                                                      
                                                </table>
                                            </div>
                          


 <br><br>
                                                <h4 align="center">Enter Transport Cost</h4>
                                                <hr> 
<div class="form-group row">
                                              <label class="col-lg-2 col-form-label">Transport Cost</label>
                                                    <div class="col-lg-4">
                                                  
                                              <input type="text" name="transport"   value=""
                                                            class="form-control" required>
                                                   
                                                </div>
                                            </div>




                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save" disabled>Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!} 



@else

<h2>NO DATA FOUND</h2>


@endif

@yield('scripts')

<script>
$(document).on("change", function () {
      var id=0;
    var count = 0;

        var qty = parseInt($('#qty').val());
     console.log(qty);

  $("#quantity").change(function (e) {  
    id+=+parseInt($(this).val());
console.log(id);
});

    $('#due_quantity').val((qty - id ? qty - id : 0).toFixed(2));
        

   
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
                $('#appFormModal').modal('toggle');

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


  

    $('.add').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +=
            '<td><select name="levy_id[]" class="form-control item_levy" required "><option value="">Select Item</option>@foreach($levy as $n) <option value="{{ $n->id}}">{{$n->account_name}}</option>@endforeach</select></td>';      
       
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

        $('#levy').append(html);
   
    });

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
       
    });



});
</script>
