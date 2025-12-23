 <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> Cash Deposits(Subscription) from {{$data->users->name}} - {{$data->roles->slug}} <h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


 <form id="form" role="form" enctype="multipart/form-data" action="{{route('subscription.save_deposit')}}"  method="post" >
                   
                @csrf
        <div class="modal-body">
           
          
            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
          <div class="form-group row">
         <label class="col-lg-2 col-form-label">Date <span class="required"> * </span></label>
                                                    <div class="col-lg-8">
                                                    <input type="date" name="date" required value="{{ isset($data) ? $data->date: date('Y-m-d')}}" class="form-control">
                                                    </div>
                                                    </div>
                                                    
                                                    <div class="form-group row"> <label class="col-lg-2 col-form-label">Amount <span class="required"> * </span></label>

                                                    <div class="col-lg-8">
                                                        <input type="text" name="amount" value="{{ isset($data) ? $data->amount : ''}}" class="form-control amount" required>
                                                    </div>
                                                    </div>
                                                    
                                                    
                                                  <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Bank/Cash Account <span class="required"> * </span></label>
                                                    <div class="col-lg-8">
                                                       <select class="m-b" id="bank_id" name="bank_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->bank_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
                                                    </div>
                                                </div>
                                                
                                                 <div class=""> <p class="form-control-static errors_bal" id="errors" style="text-align:center;color:red;"></p></div>
                                                    
                                                    
                                                  
                                                    
                                                  

                                                    <input type="hidden" name="id"  class="form-control" value="{{$id}}" required>
                                                     <input type="hidden" name="client_id"  class="form-control client_id" value="{{$data->user_id}}" required>
                                                   <input type="hidden" name="role_id"  class="form-control role" value="{{$data->role_id}}" required>
                                                    <input type="hidden" name="start_date"  class="form-control" value="{{$start_date}}" required>
                                                   <input type="hidden" name="end_date"  class="form-control" value="{{$end_date}}" required>
                                                    <input type="hidden" name="type"  class="form-control" value="subscription" required>
 
                 
               
              </div>
</div>
                                                    </div>                                      
                                                
                                                

        </div>
        <div class="modal-footer bg-whitesmoke br">
           <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
         </form>
    </div>
</div>


@yield('scripts')
 <script type="text/javascript">
$(document).ready(function() {
$('.amount').keyup(function(event) {   
if(event.which >= 37 && event.which <= 40) return;

$(this).val(function(index,value){
return value
.replace(/\D/g,"")
.replace(/\B(?=(\d{3})+(?!\d))/g,",");
   
});

});


});
</script>


<script>
    $(document).ready(function() {
    
       $(document).on('change', '.amount', function() {
            var id = $(this).val();
             var role= $('.role').val();
             var user= $('.client_id').val();

           console.log(id);
            $.ajax({
                url: '{{url("findMinimum")}}',
                type: "GET",
                data: {
                    id: id,
                  role:role,
                  user:user
                },
                dataType: "json",
                success: function(data) {
                  console.log(data);
                 $('.errors_bal').empty();
                $("#save").show();
                 if (data != '') {
                $('.errors_bal').append(data);
               $("#save").hide();
    } else {
      
    }
                
           
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
            $('.m-b').select2({ width: '100%', });



        });
    </script>
