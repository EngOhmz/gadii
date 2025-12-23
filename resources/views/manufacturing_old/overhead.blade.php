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
                           <label class="col-lg-2 col-form-label">Reference2</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="ref" 
                                                            value="{{ isset($data) ? $data->ref : ''}}"
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
                                                       <select class="form-control m-b " id="bank2_id" name="bank_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->bank_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                                               @endforeach
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



   <div class="modal-footer ">
   <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
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
        html += '<td><br><select name="account_id[]" class="m-b form-control item_name" required  data-sub_category_id="' +count +'"><option value="">Select Expense Account</option>@foreach ($chart_of_accounts as $chart) <option value="{{$chart->id}}">{{$chart->account_name}}</option>@endforeach</select></td>';
        html +='<td><br><input type="number" name="amount[]" class="form-control item_quantity' + count +'"  id ="quantity" value="" required /></td>';
        html += '<td><br><textarea name="notes[]" class="form-control" rows="2"></textarea></td>';
        html +='<td><br><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('#cart > tbody').append(html);
      

/*
             * Multiple drop down select
             */
            $(".m-b").select2({
                            });
          


      
    });

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
        
    });


   

});
</script>