
<div class=""><p class="form-control-static item_errors" id="errors" style="text-align:center;color:red;"></p>   </div>
  
  <h4 align="center">Item Details</h4>
 
 <div class="table-responsive" id="cart">
                                               
                                                <div class="row body">
                                           @if(!empty($items))
                                         @foreach ($items as $i)     
                                                                                                                                          
                                     <div class="col-lg-4 line_items" id="td{{$i->id}}"><br>
                                    <select name="item_name[]" class="form-control  m-b item_name" required="" disabled="">
                                    <option value="">Select Item</option>
                                    @foreach($name as $n) 
                                    <option value="{{ $n->id}}"
                            @if(isset($i))@if($n->id == $i->item_name) selected @endif @endif >{{$n->name}} @if(!empty($n->color)) - {{$n->c->name}} @endif   @if(!empty($n->size)) - {{$n->s->name}} @endif</option>
                                        @endforeach
                                                                    </select>
                                    <br> </div>
                                     
                          <?php
                                                 $due=App\Models\POS\InvoiceHistory::where('invoice_id',$invoice_id)->where('item_id',$i->item_name)->where('type', 'Sales')->sum('quantity');
                                             $return=App\Models\POS\InvoiceHistory::where('invoice_id',$invoice_id)->where('item_id',$i->item_name)->where('type', 'Credit Note')->sum('quantity');
                                              $qty=$due-$return;
                                                  ?>
                                                                            
                              <div class="col-lg-6 line_items" id="td{{$i->id}}"><br>
                         Quantity 
                    <input type="number" name="quantity[]" class="form-control item_quantity" step="0.01" min="0.01" placeholder="quantity" id="quantity" data-sub_category_id="{{$i->id}}" value="{{ isset($i) ? $qty : ''}}" required="">
                     <div class=""> <span class="form-control-static errors{{$i->id}}" id="errors" style="text-align:center;color:red;"></span>   </div> 
                               <br>
                Price <input type="number" step="0.01" min="0.01" name="price[]" class="form-control item_price{{$i->id}}" placeholder="price" required="" value="{{ isset($i) ? $i->price : ''}}" readonly=""><br>
               <input type="hidden" name="unit[]" class="form-control item_unit{{$i->id}}" placeholder="unit" required="" value="{{ isset($i) ? $i->unit : ''}}" readonly="">
               <input type="hidden" name="tax_rate[]" class="form-control  item_tax{{$i->id}}t" value="{{ isset($i) ? $i->tax_rate : ''}}" required="">
                Tax <input type="text" name="total_tax[]" class="form-control item_total_tax{{$i->id}}'" placeholder="total" required="" value="{{ isset($i) ? $i->total_tax : ''}}" readonly="readonly" jautocalc="{quantity} * {price} * {tax_rate}" ><br>
               Total <input type="text" name="total_cost[]" class="form-control item_total{{$i->id}}" placeholder="total" required="" value="{{ isset($i) ? $i->total_cost : ''}}" readonly="readonly" jautocalc="{quantity} * {price}" ><br>
                <input type="hidden" name="items_id[]" class="form-control name_list" value="{{ isset($i) ? $i->items_id : ''}}">
             <input type="hidden" name="id[]" id="item" class="form-control id{{$i->id}}" value="{{$i->id}}">

                              </div>
                              
                      <div class="col-lg-2 text-center line_items" id="td{{$i->id}}"><br>
                      <button type="button" name="remove" class="btn btn-danger btn-xs remove" value="{{$i->id}}" data-button_id="{{$i->id}}"><i class="icon-trash"></i></button><br></div>
                      
                                                                 
                    
                     
                      @endforeach
            @endif
                     </div>                 
                                     
                                                 <br> <br>
                                                  <div class="row">
                                                 
                                                   <div class="col-lg-2"></div><label class="col-lg-2 col-form-label"> Sub Total (+):</label>
                    <div class="col-lg-6 line_items">
                    <input type="text" name="subtotal[]" class="form-control item_total" placeholder="subtotal" required="" jautocalc="SUM({total_cost})" readonly="readonly" ><br> 
                     </div><div class="col-lg-2"></div>
                     
                      <div class="col-lg-2"></div><label class="col-lg-2 col-form-label">Tax (+):</label>
                     <div class="col-lg-6 line_items">
                  <input type="text" name="tax[]" class="form-control item_total" placeholder="tax" required="" jautocalc="SUM({total_tax})" readonly="readonly" ><br> 
                     </div><div class="col-lg-2"></div>
                     
                     
                     
                     <div class="col-lg-2"></div><label class="col-lg-2 col-form-label"> Total:</label>
                     <div class="col-lg-6 line_items">
                     <input type="text" name="amount[]" class="form-control item_total" placeholder="total" required="" jautocalc="{subtotal} + {tax}" readonly="readonly" ><br> 
                     </div><div class="col-lg-2"></div>
                                                 
                                                 
                                            </div>


</div>
                                                <br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
 
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs save" type="submit" id="save">Save</button>
                                                       
                                                    </div>
                                                </div>



  @yield('scripts')
<script type="text/javascript">
$(document).ready(function() {


    function autoCalcSetup() {
        $('div#cart').jAutoCalc('destroy');
        $('div#cart div.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('div#cart').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();


    $(document).on('click', '.remove', function() {
        var button_id = $(this).data('button_id');
        var contentToRemove = document.querySelectorAll('#td' + button_id);
        $(contentToRemove).remove(); 
        autoCalcSetup();
    });



});
</script>

<script>
$(document).ready(function() {

   $(document).on('change', '.item_quantity', function() {
        var id = $(this).val();
          var sub_category_id = $(this).data('sub_category_id');
         var item= $('.id' + sub_category_id).val();
console.log(id);
        $.ajax({
            url: '{{url("pos/sales/findinvQty")}}',
            type: "GET",
            data: {
                id: id,
              item: item,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
             $('.errors' + sub_category_id).empty();
            $("#save").attr("disabled", false);
             if (data != '') {
            $('.errors' + sub_category_id).append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });



});
</script>


<script>
    $(document).ready(function() {
    
      
         $(document).on('click', '.save', function(event) {
   
         $('.item_errors').empty();
        
          if ( $('#cart > .body .line_items').length == 0 ) {
               event.preventDefault(); 
    $('.item_errors').append('Please Add Items.');
}
         
         else{
            
         
          
         }
        
    });
    
    
    
    });
    </script>
                                        