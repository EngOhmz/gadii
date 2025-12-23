
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">
                  @if($id > 0)
                Edit Overtime
                    @else
                New Overtime
                      @endif
</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
          @if($id > 0)
             {{ Form::model($id, array('route' => array('overtime.update', $id), 'method' => 'PUT')) }}              
                    @else
                <form id="form" role="form" enctype="multipart/form-data" action="{{route('overtime.store')}}"  method="post" >
                      @endif
      
                @csrf
        <div class="modal-body">

   

     

         @can('approve-payment')
               <div class="form-group">
                <label class="col-lg-6 col-form-label">Employee <span class="required">*</span></label>

                <div class="col-lg-12">
                   <select name="user_id" style="width: 100%" id="user_id" class="form-control m-b select_box">
                            <option value="">Select Employee</option>
                            <?php if (!empty($all_employee)): ?>
                                <?php foreach ($all_employee as  $v_employee) : ?>
                                            <option value="<?php echo $v_employee->id; ?>"
                                                <?php
                                                if (!empty($overtime->user_id)) {
                                                    $user_id = $overtime->user_id;
                                                } 
                                                if (!empty($user_id)) {
                                                    echo $v_employee->id == $user_id ? 'selected' : '';
                                                }
                                                ?>><?php echo $v_employee->name  ?></option>
                                     
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                </div>
            </div>
             @else
            <input type="hidden"   id="user_id" name="user_id"  class="form-control user"  value="<?php echo auth()->user()->id ?>">
            @endcan


                    <div class="form-group">
                <label class="col-lg-6 col-form-label">Amount <span class="required">*</span></label>

                <div class="col-lg-12">
                   <input type="number" step="0.01"  name="overtime_amount"  required class="form-control amount "  value="<?php
                        if (!empty($overtime->overtime_amount)) {
                            echo $overtime->overtime_amount;
                        } 
               
                        ?>">
                </div>
           <div class=""> <p class="form-control-static" id="errors" style="text-align:center;color:red;"></p>   </div>                    
                        
                   
            </div>

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Date <span class="required">*</span></label>

                <div class="col-lg-12">
                     <input required type="date"  class="form-control year" name="overtime_date" data-format="yyyy/mm/dd"  
                    value="<?php
                        if (!empty($overtime->overtime_date)) {
                            echo $overtime->overtime_date;
                        } 
                        ?>"
                     >
                    
                </div>
               <div class=""> <p class="form-control-static" id="month_errors" style="text-align:center;color:red;"></p>   </div>        
            </div>
          
                  <div class="form-group">
                <label class="col-lg-6 col-form-label">Reason</label>

                <div class="col-lg-12">
                     <textarea name="reason" rows="4" class="form-control" id="field-1"
                          placeholder="Enter Your Reason"><?php
                    if (!empty($overtime->reason)) {
                        echo $overtime->reason;
                    }
                    ?></textarea>
                    
                </div>
            </div>
          
                    <input type="hidden" name="type" value="add" required class="form-control">
             @can('approve-payment')
                <input type="hidden" name="approve" value="yes"  class="form-control">
            @endcan


        


 <div class="modal-footer">
            <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        </form>
    
</div>

@yield('scripts')
<script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>