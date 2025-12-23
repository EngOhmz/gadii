<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">Edit Entry</h5>
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
       <div><select name="checked_type[]" class="form-control m-m type"  id="typelst{{$order}}" data-category_id="lst{{$order}}" required>
       <option value="">Select Type</option>
        <option value="Client" @if(isset($type))@if('Client' == $type) selected @endif @endif>Client </option> 
       <option value="Supplier" @if(isset($type))@if('Supplier' == $type) selected @endif @endif>Supplier</option> 
        <option value="User" @if(isset($type))@if('User' == $type) selected @endif @endif>Staff</option> 
        <option value="Others" @if(isset($type))@if('Others' == $type) selected @endif @endif>Others</option> 
       </select>&nbsp</div>
       
       <div class="item_clientlst{{$order}}"  id="client" style=" display: @if(!empty($client_id)){{ 'Client' == $type ? 'block' : 'none'  }} @else none @endif;">
       <select class="form control m-m client_id" id="client_idlst{{$order}}" name="checked_client_id[]">
       <option value="">Select Client</option> @foreach ($client as $c) 
       <option value="{{$c->id}}" @if(isset($client_id))@if('Client' == $type)@if($client_id == $c->id) selected @endif @endif @endif >{{$c->name}}</option>@endforeach</select></div>
       
       
       <div class="item_supplierlst{{$order}}"  id="supplier" style=" display: @if(!empty($supplier_id)){{ 'Supplier' == $type ? 'block' : 'none'  }} @else none @endif;">
       <select class="form control m-m supplier_id" id="supplier_idlst{{$order}}" name="checked_supplier_id[]">
       <option value="">Select Supplier</option> @foreach ($supplier as $m) 
       <option value="{{$m->id}}"  @if(isset($supplier_id))@if('Supplier' == $type)@if($supplier_id == $m->id) selected @endif @endif @endif>{{$m->name}}</option>@endforeach</select></div>
       
       <div class="item_userlst{{$order}}"  id="user"style=" display: @if(!empty($user_id)){{ 'User' == $type ? 'block' : 'none'  }} @else none @endif;">
       <select class="form control m-m user_id" id="user_idlst{{$order}}" name="checked_user_id[]">
       <option value="">Select Staff</option> @foreach($user as $u)
       <option value="{{$u->id}}" @if(isset($user_id))@if('User' == $type)@if($user_id == $u->id) selected @endif @endif @endif>{{$u->name}}</option>@endforeach</select></div>
       
       
       <br>
       </div>
       
    <div class="col-lg-6 line_items" id="tdlst{{$order}}">
    <br>Account <select class="form control m-m account" id="account_idlst{{$order}}" name="checked_account_id[]" required>
    <option value="">Select Account</option> 
    @foreach($chart_of_accounts as $group => $ch)
    <optgroup label="{{$group}}"> @foreach($ch as $chart)
    <option value="{{$chart->id}}"  @if (isset($acc)) @if ($chart->id == $acc) selected @endif @endif>{{$chart->account_name}}</option>@endforeach</optgroup> @endforeach</select><br>
    
<br> Debit <input type="text" name="checked_debit[]" class="form-control item_debit" id="debitlst{{$order}}"  data-category_id="lst{{$order}}" value="{{ isset($debit) ? number_format($debit,2) : '0' }}"/>
    <br> Credit  <input type="text" name="checked_credit[]" class="form-control item_credit" id="creditlst{{$order}}"   data-category_id="lst{{$order}}" value="{{ isset($credit) ? number_format($credit,2) : '0' }}" />
    <br> Notes <textarea name="checked_notes[]" placeholder="" class="form-control">{{ isset($notes) ? $notes : '' }}</textarea>
    <input type="hidden" name="checked_no[]" value="{{ isset($order) ? $order : '' }}" class="form-control item_orderlst{{$order}}" placeholder ="total" required />
    <input type="hidden" name="saved_items_id[]" value="{{ isset($saved) ? $saved : '' }}" class="form-control item_savedlst{{$order}}" placeholder ="total" required />
    <input type="hidden" name="modal_type" value="edit" required />
    
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

           $('.item_debit').keyup(function(event) {   
// skip for arrow keys
  if(event.which >= 37 && event.which <= 40){
   //event.preventDefault();
  }

  $(this).val(function(index, value) {
      
      value = value.replace(/[^0-9\.]/g, ""); // remove commas from existing input
      return numberWithCommas(value); // add commas back in
      
  });
});                 
          

$('.item_credit').keyup(function(event) {   
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
    </script>
            

<script>
        $(document).ready(function(){
            /*
                         * Multiple drop down select
                         */
            $('.m-m').select2({dropdownParent: $('#appFormModal'), });



        });
    </script>