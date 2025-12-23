                                                     
                                                        @if(!empty($items))
                                                        @foreach ($items as $i)
                                                        
                                                        
                                                        
                                                        <div class="col-lg-4 line_items" id="td{{$i->id}}"><br>
                                                        <select name="item_name[]" class="form-control  m-b item_name" required
                                                                   disabled>
                                                                    <option value="">Select Item</option>@foreach($name
                                                                    as $n) <option value="{{ $n->id}}"
                                                                        @if(isset($i))@if($n->id == $i->item_name)
                                                                        selected @endif @endif >{{$n->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                 <br> </div>
                                                                
                                                      <?php
                                                     $due=App\Models\InventoryHistory::where('purchase_id',$purchase_id)->where('item_id',$i->item_name)->where('type', 'Purchases')->sum('quantity');
                                                 $return=App\Models\InventoryHistory::where('purchase_id',$purchase_id)->where('item_id',$i->item_name)->where('type', 'Debit Note')->sum('quantity');
                                                  $qty=$due-$return;
                                                      ?>
                                                      
                                                      
                                                      
                                                            <div class="col-lg-6 line_items" id="td{{$i->id}}"><br>
                         Quantity <input type="number" min="1" name="quantity[]" class="form-control item_quantity" data-sub_category_id={{$i->order_no}} value="{{ isset($i) ? $qty : ''}}" required />
                            <div class=""> <p class="form-control-static errors{{$i->order_no}}" id="errors" style="text-align:center;color:red;"></p>   </div> 
                                                                             <br>
                                                                             
                                                           
                                                           Price <input type="text" name="price[]"class="form-control item_price{{$i->order_no}}" required
                                                                    value="{{ isset($i) ? $i->price : ''}}" readonly/><br>
                                                                    
                                                                    
                                                           <input type="hidden" name="unit[]"
                                                                    class="form-control item_unit{{$i->order_no}}"
                                                                    placeholder="unit" required
                                                                    value="{{ isset($i) ? $i->unit : ''}}" readonly/>
                                                           <input type="hidden" name="tax_rate[]"
                                                                    class="form-control  item_tax'+count{{$i->order_no}}" value="{{ isset($i) ? $i->tax_rate : ''}}"
                                                                    required>
                                                                   
                                                             Tax <input type="text" name="total_tax[]"
                                                                class="form-control item_total_tax{{$i->order_no}}'"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_tax : ''}}" readonly
                                                                jAutoCalc="{quantity} * {price} * {tax_rate}" /><br>
                                                          
                                                            Total <input type="text" name="total_cost[]"
                                                                    class="form-control item_total{{$i->order_no}}"
                                                                    placeholder="total" required
                                                                    value="{{ isset($i) ? $i->total_cost : ''}}"
                                                                    readonly jAutoCalc="{quantity} * {price}" /><br>
                                                                    
                                                            <input type="hidden" name="items_id[]"
                                                                class="form-control name_list"
                                                                value="{{ isset($i) ? $i->items_id : ''}}" />
                                                         <input type="hidden" name="id[]" id="item"
                                                                class="form-control id{{$i->order_no}}"
                                                                value="{{ isset($i) ? $i->id : ''}}" />
                                                                
                                                                 </div>
                                                                
                                                        <div class="col-lg-2 text-center line_items" id="td{{$i->id}}"><br>
                      <button type="button" name="remove" class="btn btn-danger btn-xs remove" value="{{$i->id}}" data-button_id="{{$i->id}}"><i class="icon-trash"></i></button><br></div>        
                                                                
                                                           
                                                      

                                                        @endforeach
                                                        @endif

                    
                                                       

     @yield('scripts')
<script type="text/javascript">
$(document).ready(function() {


    function autoCalcSetup() {
        $('div#dn-cart').jAutoCalc('destroy');
        $('div#dn-cart div.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('div#dn-cart').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();


    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
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
            url: '{{url("inventory/findinvQty")}}',
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
                                                                              
                                        