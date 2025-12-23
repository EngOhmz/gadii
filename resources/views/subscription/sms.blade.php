 <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> Send SMS to {{$data->users->name}} - {{$data->roles->slug}} <h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


 <form id="form" role="form" enctype="multipart/form-data" action="{{route('subscription.send_sms')}}"  method="post" >
                   
                @csrf
        <div class="modal-body">
           
          
            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
          <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Message</label>

                                                        <div class="col-lg-10">
                                                            <textarea name="message" class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                  

                                                    <input type="hidden" name="id"  class="form-control" value="{{$data->users->id}}" required>
                                                     <input type="hidden" name="phone"  class="form-control" value="{{$data->users->phone}}" required>
 
                 
               
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
    
$('.year').keyup(function(event) {   
if(event.which >= 37 && event.which <= 40) return;

$(this).val(function(index,value){
return value
.replace(/\D/g,"")
.replace(/\B(?=(\d{3})+(?!\d))/g,",");
   
});

});

$('.month').keyup(function(event) {   
if(event.which >= 37 && event.which <= 40) return;

$(this).val(function(index,value){
return value
.replace(/\D/g,"")
.replace(/\B(?=(\d{3})+(?!\d))/g,",");
   
});

});


$('.day').keyup(function(event) {   
if(event.which >= 37 && event.which <= 40) return;

$(this).val(function(index,value){
return value
.replace(/\D/g,"")
.replace(/\B(?=(\d{3})+(?!\d))/g,",");
   
});

});

});
</script>