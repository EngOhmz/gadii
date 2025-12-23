 <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> Adjust {{$data->users->name}} - {{$data->roles->slug}}  Details<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


 <form id="form" role="form" enctype="multipart/form-data" action="{{route('subscription.adjust')}}"  method="post" >
                   
                @csrf
        <div class="modal-body">
           
          
            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
          <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Yearly Price</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="year" id="year"
                                                                value="{{ isset($data) ? number_format($data->year) : '0'}}"
                                                                class="form-control year" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Monthly Price</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="month" id="month"
                                                                value="{{ isset($data) ? number_format($data->month) : '0'}}"
                                                                class="form-control month" required>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Daily Price</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="day" id="day"
                                                                value="{{ isset($data) ? number_format($data->day) : '0'}}"
                                                                class="form-control day"  required>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Expire Date</label>

                                                        <div class="col-lg-10">
                                                            <input type="date" name="due_date"  class="form-control datepicker" value="{{ isset($data) ? $data->due_date : '' }}" required>
                                                        </div>
                                                    </div>
                                                    
                                                  

                                                    <input type="hidden" name="id"  class="form-control" value="{{$id}}" required>
                                                     <input type="hidden" name="start_date"  class="form-control" value="{{$start_date}}" required>
                                                   <input type="hidden" name="end_date"  class="form-control" value="{{$end_date}}" required>
 
                 
               
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