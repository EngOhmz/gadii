
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Invoice Commission -  {{$data->reference_no}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                {!! Form::open(array('route' => 'save.commission','method'=>'POST', 'class' => 'frm-example' , 'name' => 'frm-example')) !!}
               
            @csrf
        <div class="modal-body">
        
          Invoice Balance :  {{$data->invoice_amount}} {{$data->exchange_code}}<br>

            <div class="card-body">
            
                   <div class="form-group row">
                                             <label for="stall_no" class="col-lg-4 col-form-label">Bank/Cash Account <span class="required"> * </span></label>
                                                <div class="col-lg-8">
                                                    <select class="form-control m-b" name="bank_id" id="bank" required>
                                                        <option value="">Select Payment Account</option>
                                                        @foreach ($bank_accounts as $bank)
                                    <option value="{{ $bank->id }}" @if (isset($data)) @if ($data->commission_bank == $bank->id) selected @endif @endif>{{ $bank->account_name }}</option>
                                                        @endforeach
                                                    </select>
                                        
                                                </div>
                                          
                                             
                                        </div>
                                        
                                        <div class=""> <p class="form-control-static loc" id="errors" style="text-align:center;color:red;"></p>   </div>
            
             <button type="button" name="add" class="btn btn-success btn-xs cadd"><i class="fas fa-plus"> Add </i></button><br>
             
                                             

                                                    
                                                    <br><div class="table-responsive">
                                                        <table class="table table-bordered" id="ccart">
                                                        
                                                         <input type="hidden" name="id" value="{{ isset($id) ? $id : '' }}" class="form-control inv" required />
                                                
                                                            <thead>
                                                                <tr>
                                                                <th>Item <span class="required"> * </span></th>
                                                                    <th>Cost<span class="required"> * </span></th>
                                                                    <th>User <span class="required"> * </span></th>
                                                                    <th>Commission<span class="required"> * </span></th>
                                                                   
                                                                    <th>Action </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                             
                                                        @if (!empty($items))
                                                            @foreach ($items as $i)
                                                                <tr class="line_items">
                                                                
                                                                
                                                                <td>
                                        <select name="item_name[]" class="form-control m-b item_n" required data-sub_category_id="{{ $i->id }}_edit">
                                        <option value="">Select Item</option>
                                        @foreach ($name as $na)
                                        <option value="{{ $na->id }}" @if (isset($i)) @if ($na->id == $i->item_name) selected @endif @endif>{{ $na->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                           
                                                </td>
                                                <td>
                                <input type="number" name="total_cost[]" class="form-control item_c{{ $i->id }}_edit"  min="0" id="quantity" value="{{ isset($i) ? $i->total_cost : '' }}" required readonly/>
                                           </td>
                                                                
                                                    <td>
                                        <select name="user_id[]" class="form-control m-b user" required data-sub_category_id="{{ $i->id }}_edit">
                                        <option value="">Select User</option>
                                        @foreach ($user as $n)
                                        <option value="{{ $n->id }}" @if (isset($i)) @if ($n->id == $i->user_id) selected @endif @endif>{{ $n->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                           
                                                </td>
                                                <td>
                                        <input type="number" name="amount[]" class="form-control item_q"  min="0" id="quantity" value="{{ isset($i) ? $i->amount : '' }}" required />
                                           </td>
                                                            
                                            <input type="hidden" name="saved_items_id[]" class="form-control item_saved{{ $i->id }}_edit"
                                                value="{{ isset($i) ? $i->id : '' }}" required />

                                            <td><button type="button" name="remove" class="btn btn-danger btn-xs crem"
                                                    value="{{ isset($i) ? $i->id : '' }}"><i
                                                        class="icon-trash"></i></button>
                                            </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                               

                                                            </tbody>
                                                            <tfoot>
                                                               
                                                                <tr class="line_items">
                                                                    <td colspan="2"> </td>
                                                                    <td><span class="bold">Total</span>: </td>
                                                                    <td><input type="text" name="subtotal[]" value="{{ isset($data) ? $data->commission : '' }}"
                                                                            class="form-control item_tl" id="total"
                                                                           
                                                                            required 
                                                                            readonly></td>
                                                                </tr>
                                                              
                                                                            
                                                                            
                                                                           
                                                            </tfoot>
                                                        </table>
                                                    </div>
            
            
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
         <button class="btn btn-primary" type="submit"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>


       </form>

            
        </div>
        
        @yield('scripts')
        <script type="text/javascript">
        $(document).ready(function() {


            var count = 0;


            function autoCalcSetup() {
                $('table#ccart').jAutoCalc('destroy');
                $('table#ccart tr.line_items').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true
                });
                $('table#ccart').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup();

            $('.cadd').on("click", function(e) {
                

                count++;
                var html = '';
                html += '<tr class="line_items">';
                html +='<td><select name="item_name[]" class="form-control m-b item_n" required  data-sub_category_id="' +count +'"><option value="">Select Item</option> @foreach ($name as $na)<option value="{{ $na->id }}">{{ $na->name }}</option>@endforeach</select></td>';
                 html +='<td><input type="number" name="total_cost[]" class="form-control item_c' +count +'"  min="0" id="quantity" value="" required readonly/></td>';
                html +='<td><select name="user_id[]" class="form-control m-b user" required  data-sub_category_id="' +count +'"><option value="">Select User</option>@foreach ($user as $n) <option value="{{ $n->id }}">{{ $n->name }}</option>@endforeach</select></td>';
                html +='<td><input type="number" name="amount[]" class="form-control item_q" min="0" required /><div class=""></td>';
                html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs cremove"><i class="icon-trash"></i></button></td>';

                $('#ccart > tbody').append(html);
                autoCalcSetup();

                /*
                 * Multiple drop down select
                 */
                $('.m-b').select2({});




            });

            $(document).on('click', '.cremove', function() {
                $(this).closest('tr').remove();
                autoCalcSetup();
            });


            $(document).on('click', '.crem', function() {
                var btn_value = $(this).attr("value");
                $(this).closest('tr').remove();
                $('#ccart > tfoot').append(
                    '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                    btn_value + '"/>');
                autoCalcSetup();
            });

        });
    </script>
    
    
    <script type='text/javascript'>
$(document).ready(function() {
  
      
 var total= 0; 
 
   $(".item_q").change();

  $(document).on('change', '.item_q', function() {
         
      a=$(this).val().replace(/\,/g,''); // 1125, but a string, so convert it to number
      
      console.log(a);

        total += parseInt(a,10); 
        console.log(total);
           
         
          var d=addCommas(total.toFixed(2));
         $('.item_tl').val(d); 
        
     

});


$(document).on('change', '.item_n', function() {
     $(".item_q").change();
    
                var id = $(this).val();
                  var invoice =$('.inv').val();
                var sub_category_id = $(this).data('sub_category_id');
                $.ajax({
                    url: '{{ url('pos/sales/findInvItem') }}',
                    type: "GET",
                    data: {
                        id: id,
                        invoice: invoice
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('.item_c' + sub_category_id).val(data.total_cost);
                    }

                });

            });



});
</script>

<script>
    $(document).ready(function() {
    
      $(".item_q").change();
      
         $(document).on('click', '.save', function(event) {
   
         $('.loc').empty();
        
          if ( $('#ccart tbody tr').length == 0 ) {
               event.preventDefault(); 
    $('.loc').append('Please Select User.');
}
         
         else{
            
         
          
         }
        
    });
    
    
    
    });
    </script>


    
<script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>



<script>
    
    function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

  </script>


    

        