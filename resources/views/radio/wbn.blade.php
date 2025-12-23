    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Create Transmission</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           
              <form id="addAssignForm" role="form" enctype="multipart/form-data" action="{{route('radio.save_program')}}"  method="post" >
            @csrf
        <div class="modal-body">
        <h5> No of days : {{ $diff + 1}}</h5>

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            
                                           

      <div class="form-group row"><label
                                                            class="col-lg-4 col-form-label">No of Transmission per Day</label>

                                                        <div class="col-lg-8">
                                                           <input type="number" name="transmission" class="form-control trans" id="trans" min="1" required>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    @if($old->program_type == 'Commercial')
                                                    <div class="form-group row"><label
                                                            class="col-lg-4 col-form-label">Amount(inclusive TAX)</label>

                                                        <div class="col-lg-8">
                                                           <input type="number" name="amount" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    
                                                    @else
                                                    
                                                     <div class="form-group row"><label
                                                            class="col-lg-4 col-form-label">Guest Name</label>

                                                        <div class="col-lg-8">
                                                           <input type="text" name="guest" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                     <div class="form-group row"><label
                                                            class="col-lg-4 col-form-label">Institution Name</label>

                                                        <div class="col-lg-8">
                                                           <input type="text" name="institution" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    @endif
                                                    
                                                  
                                                     <div class="form-group row"><label
                                                            class="col-lg-4 col-form-label">Transmission Schedule</label>

                                                        <div class="col-lg-8">
                                                    
                                                    <select name="type" class="form-control m-b"  required>
                                                    <option value="">Select </option>
                                                    <option value="Daily">Daily</option>
                                                    <option value="Weekday">Weekday</option>
                                                    <option value="Weekend">Weekend</option>
                                                    </select>
                                                     </div>
                                                    </div>
                                                   
                                                    
                                                     <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                  <thead>
                                                                <tr>
                                                                    
                                                                    <th>Category</th>
                                                                    <th>Duration</th>
                                                                    <th>Air Time</th>
                                                                     <th>Program</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>




                                                      <input type="hidden" name="id"
                                                                class="form-control" value="{{$id}}"> 
                                                                
                                                                 

                 
               
              </div>
</div>
                                                    </div>


        </div>
         <div class="modal-footer ">
             <button class="btn btn-primary"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
   


       </form>


    </div>


@yield('scripts')

<script src="{{asset('assets/js/time/timepicker.min.js')}}"></script>
<script>
 $(document).ready(function(){
            $('.timepicker3').timepicker({
                minuteStep: 1,
                secondStep: 1,
                showSeconds: true,
                showMeridian:false,
                maxHours: 1,
                defaultTime: false
                
            });
  });
</script>

 <script>
        $(document).ready(function() {


            $(document).on('change', '.trans', function() {
                var id = $(this).val();
                var i;
                
                $('#cart > tbody').empty();
                
                for(i = 0; i < id; i++){
                    
                var html = '';
                html += '<tr class="line_transmission">';
                html +='<input type="hidden" name="tracking_id[]" class="form-control tracking" data-sub_category_id="' +i + '" required value="{{$old->confirmation_number}}"/>';
                 html +='<td><select name="category[]" class="form-control m-b category" required  data-sub_category_id="' +i +'"><option value="">Select Category</option><option value="Spot">Spot</option><option value="Program">Program</option><option value="Sponspor">Sponspor</option><option value="Mentions">Mentions</option></select></td>';
                html +='<td><input name="duration[]" type="text"  class="form-control timepicker3" id="duration'+i +'" required /></td>';
                html +='<td><input name="air_time[]" type="time" class="form-control time" required></td>';
                html +='<td><input type="text" name="program[]" class="form-control program" required /></td>';
                    
                 $('#cart > tbody').append(html);
                 
                 
                 $('.timepicker3').timepicker({
                minuteStep: 1,
                secondStep: 1,
                showSeconds: true,
                showMeridian:false,
                maxHours: 1,
                defaultTime: '0:00:00'
                
            });
                  
                   $('.m-b').select2({});
                }

            });


        });
        
        </script>


<script>
            $('.m-b').select2({
                            });

  
</script>
