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
       <option value="{{ $n->id }}" @if (isset($name)) @if ($n->id == $name) selected @endif @endif>{{ $n->name }}</option>@endforeach
       </select>&nbsp</div><textarea name="checked_description[]"  class="form-control desclst{{$order}}" placeholder="Description"  cols="30" >{{ isset($desc) ? $desc : '' }}</textarea><br>
       </div>
       
    <div class="col-lg-6 line_items" id="tdlst{{$order}}">
    <br> Quantity <input type="number" name="checked_quantity[]" step="0.01" min="0.01"  value="{{ isset($qty) ? $qty : '' }}" class="form-control item_quantity" data-category_id="lst{{$order}}" placeholder ="quantity" id ="quantitylst{{$order}}" required />
     <br> Price <input type="text" name="checked_price[]"  value="{{ isset($price) ? number_format($price,2) : '' }}" class="form-control item_pricelst{{$order}}" id="item_price" placeholder ="price" required >
     <br> Total Cost <input type="text" name="checked_total_cost[]" value="{{ isset($cost) ? $cost : '' }}" class="form-control item_totallst{{$order}}" placeholder ="total" required readonly jAutoCalc="{checked_quantity} * {checked_price}" />
    <br> Tax <input type="text" name="checked_total_tax[]" value="{{ isset($tax) ? $tax  : '' }}" class="form-control item_total_taxlst{{$order}}" placeholder ="tax" required readonly jAutoCalc="{checked_quantity} * {checked_price} * {checked_tax_rate}"   readonly/>
    <br><input type="hidden" name="checked_unit[]" value="{{ isset($unit) ? $unit : '' }}" class="form-control item_unitlst{{$order}}" placeholder ="unit" required />
    <input type="hidden" name="checked_tax_rate[]" value="{{ isset($rate) ? $rate : '' }}" class="form-control item_taxlst{{$order}}" placeholder ="total" required />
    <input type="hidden" name="checked_no[]" value="{{ isset($order) ? $order : '' }}" class="form-control item_orderlst{{$order}}" placeholder ="total" required />
    <input type="hidden" name="saved_items_id[]" value="{{ isset($saved) ? $saved : '' }}" class="form-control item_savedlst{{$order}}" placeholder ="total" required />
     <input type="hidden"  class="form-control item_idlst{{$order}}" id="item_id "  value="{{$name}}"  />
    <input type="hidden" name="modal_type" value="edit" required />
    
    <div class=""> <p class="form-control-static item2_errors" id="errors" style="text-align:center;color:red;"></p>   </div>
    </div>


       </div></div>



    </div> 
    <div class="modal-footer">
        <button class="btn btn-primary qadd_edit_form"  type="submit" id="save3" data-button_id="{{$order}}" data-dismiss="modal"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
        <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
    </div>
    </form>

</div>

@yield('scripts')

<script type="text/javascript">
        $(document).ready(function() {

            function autoCalcSetup7() {
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
            autoCalcSetup7();
            
          $(document).on('change', '.item_name', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('sub_category_id');
            $.ajax({
                url: '{{ url('cf/findService') }}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.item_price' + sub_category_id).val(numberWithCommas(data[0]["amount"]));
                    $(".item_unit" + sub_category_id).val(data[0]["unit"]);
                    $(".item_tax" + sub_category_id).val(data[0]["tax_rate"]);
                    $(".desc" + sub_category_id).val(data[0]["description"]);
                    $('.item_id' + sub_category_id).val(id);
                      autoCalcSetup7();
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
            $('.m-m').select2({dropdownParent: $('#app2FormModal'), });



        });
    </script>