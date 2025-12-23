<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">Edit Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

             <form class="addEditForm">
         {{ csrf_field() }}
         
    <div class="modal-body">



          <div id="cart3">
         <div class="row body">
         
       <div class="col-lg-6 line_items" id="tdlst{{$order}}"> <br>
       <div class="input-group mb-3"><select name="checked_item_name[]" class="form-control m-m item_name"  id="item_namelst{{$order}}" data-sub_category_id="lst{{$order}}" required>
       <option value="">Select Item Name</option>
       @foreach ($item as $n) 
       <option value="{{ $n->id }}" @if (isset($name)) @if ($n->id == $name) selected @endif @endif>{{ $n->name }} @if(!empty($n->color)) - {{$n->c->name}} @endif   @if(!empty($n->size)) - {{$n->s->name}} @endif</option>@endforeach
       </select>&nbsp</div><textarea name="checked_description[]"  class="form-control desclst{{$order}}" placeholder="Description"  cols="30" >{{ isset($desc) ? $desc : '' }}</textarea><br>
       </div>
       
    <div class="col-lg-6 line_items" id="tdlst{{$order}}">
    <br> Quantity <input type="number" name="checked_quantity[]" step="0.01" min="0.01"  value="{{ isset($qty) ? $qty : '' }}" class="form-control item_quantity" data-category_id="lst{{$order}}" placeholder ="quantity" id ="quantitylst{{$order}}" required />
    <div class=""> <p class="form-control-static errorslst{{$order}}" id="errors" style="text-align:center;color:red;"></p> </div>
     <br> Price <input type="text" name="checked_price[]"  value="{{ isset($price) ? number_format($price,2) : '' }}" class="form-control item_pricelst{{$order}}" id="item_price" placeholder ="price" required >
      <br>Tax 
     <select name="checked_tax_rate[]" class="form-control m-m item_tax" id="item_tax{{$order}}" required >
     <option value="">Select Tax</option>
     <option value="0"  @if (isset($rate)) @if ('0' == $rate) selected @endif @endif>Inclusive</option>
     <option value="0.18"  @if (isset($rate)) @if ('0.18' == $rate) selected @endif @endif>Exclusive</option>
     </select><br>
     <br> Total Cost <input type="text" name="checked_total_cost[]" value="{{ isset($cost) ? $cost : '' }}" class="form-control item_totallst{{$order}}" placeholder ="total" required readonly jAutoCalc="{checked_quantity} * {checked_price}" />
    <br><input type="hidden" name="checked_unit[]" value="{{ isset($unit) ? $unit : '' }}" class="form-control item_unitlst{{$order}}" placeholder ="unit" required />
    <input type="hidden" name="checked_tax_rate[]" value="{{ isset($rate) ? $rate : '' }}" class="form-control item_taxlst{{$order}}" placeholder ="total" required />
    <input type="hidden" name="checked_no[]" value="{{ isset($order) ? $order : '' }}" class="form-control item_orderlst{{$order}}" placeholder ="total" required />
    <input type="hidden" name="saved_items_id[]" value="{{ isset($saved) ? $saved : '' }}" class="form-control item_savedlst{{$order}}" placeholder ="total" required />
     <input type="hidden"  class="form-control item_idlst{{$order}}" id="item_id "  value="{{$name}}"  />
    <input type="hidden" name="type" value="edit" required />
    
    <div class=""> <p class="form-control-static item2_errors" id="errors" style="text-align:center;color:red;"></p>   </div>
    </div>


       </div></div>



    </div> 
    <div class="modal-footer">
        <button class="btn btn-primary add_edit_form"  type="submit" id="save3" data-button_id="{{$order}}" data-dismiss="modal"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
        <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
    </div>
    </form>

</div>

@yield('scripts')

<script type="text/javascript">
        $(document).ready(function() {

            function autoCalcSetup3() {
                $('div#cart3').jAutoCalc('destroy');
                $('div#cart3 div.line_items').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true
                });
                $('div#cart3').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup3();
            
          $(document).on('change', '.item_name', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('sub_category_id');
            $.ajax({
                url: '{{ url('pos/sales/findInvPrice') }}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.item_price' + sub_category_id).val(numberWithCommas(data[0]["sales_price"]));
                    $(".item_unit" + sub_category_id).val(data[0]["unit"]);
                    //$(".item_tax" + sub_category_id).val(data[0]["tax_rate"]);
                    $(".desc" + sub_category_id).val(data[0]["description"]);
                    $('.item_id' + sub_category_id).val(id);
                    
                     var tax=data[0]["tax_rate"];
                   $('div#td' + sub_category_id +'.col-lg-6.line_items > .item_tax').find('option:selected').removeAttr("selected");
                   if(tax == '0.00'){
                   $('div#td' + sub_category_id +'.col-lg-6.line_items > .item_tax').find('option[value="0"]').attr("selected", true); 
                    $('div#td' + sub_category_id +'.col-lg-6.line_items > .item_tax').find('option[value="0"]').trigger('change');
                   }
                   else{
                     $('div#td' + sub_category_id +'.col-lg-6.line_items > .item_tax').find('option[value="' + tax + '"]').attr("selected", true); 
                    $('div#td' + sub_category_id +'.col-lg-6.line_items > .item_tax').find('option[value="' + tax + '"]').trigger('change');  
                   }
                    
                      autoCalcSetup3();
                }

            });

        });
        
                    $(document).on('change', '#item_price', function() {  
                var id = $(this).val();
                $.ajax({
                url: '{{ url('format_number') }}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                 console.log(data);
               $('#item_price').val(data);
                   
                    }

                });

            });
            

            
            
            
        });
    </script>
            

   

<script>
        $(document).ready(function(){
            /*
                         * Multiple drop down select
                         */
            $('.m-m').select2({dropdownParent: $('#appFormModal'), });



        });
    </script>