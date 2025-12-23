

                                                     
                                                        @if(!empty($items))
                                                        @foreach ($items as $i)
                                                        <tr class="line_items">
                                                            <td><select name="item_name[]"
                                                                    class="form-control  m-b item_name" required
                                                                   disabled>
                                                                    <option value="">Select Item</option>@foreach($name
                                                                    as $n) <option value="{{ $n->id}}"
                                                                        @if(isset($i))@if($n->id == $i->item_name)
                                                                        selected @endif @endif >{{$n->name}}</option>
                                                                    @endforeach
                                                                </select></td>
                                                            <td><input type="number" name="quantity[]"
                                                                    class="form-control item_quantity"
                                                                    placeholder="quantity" id="quantity"   data-sub_category_id={{$i->order_no}}
                                                                    value="{{ isset($i) ? $i->due_quantity : ''}}"
                                                                    required />
                                                                   <div class=""> <p class="form-control-static errors{{$i->order_no}}" id="errors" style="text-align:center;color:red;"></p>   </div> 
                                                                           </td>
                                                            <td><input type="text" name="price[]"
                                                                    class="form-control item_price{{$i->order_no}}"
                                                                    placeholder="price" required
                                                                    value="{{ isset($i) ? $i->price : ''}}" readonly/></td>
                                                            <td><input type="text" name="unit[]"
                                                                    class="form-control item_unit{{$i->order_no}}"
                                                                    placeholder="unit" required
                                                                    value="{{ isset($i) ? $i->unit : ''}}" readonly/>
                                                            <td><select name="tax_rate[]"
                                                                    class="form-control  m-b item_tax'+count{{$i->order_no}}"
                                                                    required disabled>
                                                                    <option value="0">Select Tax Rate</option>
                                                                    <option value="0" @if(isset($i))@if('0'==$i->
                                                                        tax_rate) selected @endif @endif>No tax</option>
                                                                    <option value="0.18" @if(isset($i))@if('0.18'==$i->
                                                                        tax_rate) selected @endif @endif>18%</option>
                                                                </select></td>
                                                            <input type="hidden" name="total_tax[]"
                                                                class="form-control item_total_tax{{$i->order_no}}'"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_tax : ''}}" readonly
                                                                jAutoCalc="{quantity} * {price} * {tax_rate}" />
                                                          
                                                            <td><input type="text" name="total_cost[]"
                                                                    class="form-control item_total{{$i->order_no}}"
                                                                    placeholder="total" required
                                                                    value="{{ isset($i) ? $i->total_cost : ''}}"
                                                                    readonly jAutoCalc="{quantity} * {price}" /></td>
                                                            <input type="hidden" name="items_id[]"
                                                                class="form-control name_list"
                                                                value="{{ isset($i) ? $i->items_id : ''}}" />
                                                         <input type="hidden" name="id[]" id="item"
                                                                class="form-control id{{$i->order_no}}"
                                                                value="{{ isset($i) ? $i->id : ''}}" />
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-xs rem"
                                                                    value="{{ isset($i) ? $i->id : ''}}"><i class="icon-trash"></i></button></td>
                                                        </tr>

                                                        @endforeach
                                                        @endif

                      <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <td><span class="bold">Sub Total </span>: </td>
                                                            <td><input type="text" name="subtotal[]"
                                                                    class="form-control item_total"
                                                                    placeholder="subtotal" required
                                                                    jAutoCalc="SUM({total_cost})" readonly></td>
                                                        </tr>
                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <td><span class="bold">Tax </span>: </td>
                                                            <td><input type="text" name="tax[]"
                                                                    class="form-control item_total" placeholder="tax"
                                                                    required jAutoCalc="SUM({total_tax})" readonly>
                                                            </td>
                                                        </tr>
                                                    
                                                  <tr class="line_items">
                                            <td colspan="4"></td>
                                                            <td><span class="bold">Total</span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total" placeholder="total"
                                                                    required jAutoCalc="{subtotal} + {tax}" readonly>
                                                            </td>
                                                            
                                                        </tr>
                                                       

     @yield('scripts')
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
                                                                              
                                        