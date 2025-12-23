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
       <select name="checked_item_name[]" class="form-control m-m item_name"  id="item_namelst{{$order}}" data-sub_category_id="lst{{$order}}" required>
       <option value="">Select Item Name</option>
       @foreach ($item as $n) 
       <option value="{{ $n->id }}" @if (isset($name)) @if ($n->id == $name) selected @endif @endif>{{ $n->brand }}</option>@endforeach
       </select>&nbsp<br>
       </div>
       
    <div class="col-lg-6 line_items" id="tdlst{{$order}}">
<br> Quantity <input type="number" name="checked_quantity[]"  min="1"  value="{{ isset($qty) ? $qty : '' }}" class="form-control item_quantity" data-category_id="lst{{$order}}" placeholder ="quantity" id ="quantitylst{{$order}}" required />
    <br> Price <input type="text" name="checked_price[]"  value="{{ isset($price) ? number_format($price,2) : '' }}" class="form-control item_pricelst{{$order}}" id="item_price" placeholder ="price" required >
     <br>Tax Rate 
     <select name="checked_tax_rate[]" class="form-control m-b item_tax" id="item_tax{{$order}}" required >
     <option value="">Select Tax Rate</option>
     <option value="0"  @if (isset($rate)) @if ('0' == $rate) selected @endif @endif>No tax</option>
     <option value="0.18"  @if (isset($rate)) @if ('0.18' == $rate) selected @endif @endif>18%</option>
     </select>
    
    <br> Total Cost <input type="text" name="checked_total_cost[]" value="{{ isset($cost) ? $cost : '' }}" class="form-control item_totallst{{$order}}" placeholder ="total" required readonly jAutoCalc="{checked_quantity} * {checked_price}" />
    <br>Total Tax <input type="text" name="checked_total_tax[]" value="{{ isset($tax) ? $tax  : '' }}" class="form-control item_total_taxlst{{$order}}" placeholder ="tax" required readonly jAutoCalc="{checked_quantity} * {checked_price} * {checked_tax_rate}"   readonly/>
    <br><input type="hidden" name="checked_unit[]" value="{{ isset($unit) ? $unit : '' }}" class="form-control item_unitlst{{$order}}" placeholder ="unit" required />
    <input type="hidden" name="checked_no[]" value="{{ isset($order) ? $order : '' }}" class="form-control item_orderlst{{$order}}" placeholder ="total" required />
    <input type="hidden" name="saved_items_id[]" value="{{ isset($saved) ? $saved : '' }}" class="form-control item_savedlst{{$order}}" placeholder ="total" required />
    <input type="hidden" name="type" value="edit" required />
    
    <div class=""> <p class="form-control-static item2_errors" id="errors" style="text-align:center;color:red;"></p>   </div>
    </div>


       </div></div>



    </div> 
    <div class="modal-footer">
        <button class="btn btn-primary edit_item"  type="submit" id="save3" data-button_id="{{$order}}" data-dismiss="static"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
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
                     url: '{{url("tyre/findTyrePrice")}}',
                    type: "GET",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('.item_price' + sub_category_id).val(numberWithCommas(data[0]["price"]));
                        $(".item_unit" + sub_category_id).val(data[0]["unit"]);
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