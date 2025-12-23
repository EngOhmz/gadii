<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">
Overhead Cost</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

 {{ Form::open(['route' => 'expenses.store']) }}
                                                @method('POST')
    <div class="modal-body">
 
  <input type="hidden" name="type" value="overhead"   class="form-control">
<input type="hidden" name="work" value="{{$id}}"   class="form-control">

 <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Reference</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="name" 
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                

                                              
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="date" required
                                                            placeholder=""
                                                           value="{{ isset($data) ? $data->date : date('Y-m-d')}}" 
                                                            class="form-control">
                                                    </div>
                                                </div>
                                              

                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Payment Account</label>
                                                    <div class="col-lg-8">
                                                       <select class="form-control m-m" id="bank2_id" name="bank_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->bank_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="form-group row">
                                                                            <label class="col-lg-2 col-form-label"> Agent</label>
                                                                            <div class="col-lg-8">
                                                                              
                                               <select class="form-control m-m" name="user_id" id="user_agent2" required >
                                                    <option value="{{ old('user_agent')}}" disabled selected>Select User</option>
                                                    @if(isset($users))
                                                    @foreach($users as $row)
                                
                                                   @if($row->id == auth()->user()->id)
                                                    <option value="{{ $row->id }}" selected>{{ $row->name }}</option>
                                                   @else
                                                  <option value="{{ $row->id }}" >{{ $row->name }}</option>
                                                   @endif
                                
                                                    @endforeach
                                                    @endif
                                                </select>
                                
                                
                                            
                                                                            </div>
                                                                            </div>
                                                
                                                  <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Branch</label>
                                                   <div class="col-lg-8">
                                                    <select class="form-control m-m" name="branch_id" id="branch_id">
                            <option value="" selected>Select Branch</option>
                            @if(isset($branch))
                            @foreach($branch as $row)
                            <option  value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>
                                                    </div>
                                                </div>
                                               
                                                
                                            <hr>
                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add item</i></button><br>
                        
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="cart">
            <thead>
              <tr>
                <th>Expense Account</th>
                <th>Amount</th>
                <th>Notes</th>                
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                                    

</tbody>
</table>
</div>
</div>


   <div class="modal-footer ">
   <button class="btn btn-primary save2"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
    </div>
   
   {{ Form::close() }}

</div>
</div>

@yield('scripts')
<script type="text/javascript">
$(document).ready(function() {


    var count = 0;


    


    $('.add').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html += '<td><br><div><select name="account_id[]" class="m-m form-control item_name" required  data-sub_category_id="' +count +'"><option value="">Select Expense Account</option>@foreach ($chart_of_accounts as $chart) <option value="{{$chart->id}}">{{$chart->account_name}}</option>@endforeach</select></div><br><div class="item_supplier' + count +'"  id="supplier" style="display:none;"><select class="form-control m-m supplier_id" id="supplier_id' + count +'" name="supplier_id[]"><option value="">Select Supplier</option> @foreach ($client as $m) <option value="{{$m->id}}" >{{$m->name}}</option>@endforeach</select></div></td>';
        html +='<td><br><input type="text" name="amount[]" class="form-control item_amount"  id ="amount' + count +'"  id ="quantity" value="" required /></td>';
        html += '<td><br><textarea name="notes[]" class="form-control" rows="2"></textarea></td>';
        html +='<td><br><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('#cart > tbody').append(html);
      

            $(".m-m").select2({
                            });
                            
                            
                             $('.item_amount').keyup(function(event) {   
        // skip for arrow keys
          if(event.which >= 37 && event.which <= 40){
           //event.preventDefault();
          }
        
          $(this).val(function(index, value) {
              
              value = value.replace(/[^0-9\.]/g, ""); // remove commas from existing input
              return numberWithCommas(value); // add commas back in
              
          });
        });   
          
          


      
    });

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
        
    });


   

});
</script>


<script>
$(document).ready(function() {


    $(document).on('change', '.item_name', function() {
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("gl_setup/findSupplier")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('.item_supplier' + sub_category_id).css("display", "none");

          if (data == 'OK') {
           $('.item_supplier' + sub_category_id).css("display", "block");   
}
     
              
               
            }

        });

    });
    
    
        $(document).on('click', '.save2', function(event) {
   
         $('.errors').empty();
        
          if ( $('#cart tbody tr').length == 0 ) {
               event.preventDefault(); 
    $('.errors').append('Please Enter Items.');
}
         
         else{
            
         
          
         }
        
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
    
    
    <script type="text/javascript">


function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

</script>
