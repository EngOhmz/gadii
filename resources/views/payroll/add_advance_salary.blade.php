<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">
                  @if($id > 0)
                Edit Advance Salary
                    @else
                New Advance Salary
                      @endif
</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
          @if($id > 0)
             {{ Form::model($id, array('route' => array('advance_salary.update', $id), 'method' => 'PUT')) }}              
                    @else
                <form id="form" role="form" enctype="multipart/form-data" action="{{route('advance_salary.store')}}"  method="post" >
                      @endif
      
                @csrf
        <div class="modal-body">

   

     

         @can('approve-payment')
               <div class="form-group">
                <label class="col-lg-6 col-form-label">Employee <span class="required">*</span></label>

                <div class="col-lg-12">
                   <select name="user_id" style="width: 100%" id="user_id" class="form-control select_box">
                            <option value="">Select Employee</option>
                            <?php if (!empty($all_employee)): ?>
                                <?php foreach ($all_employee as  $v_employee) : ?>
                                            <option value="<?php echo $v_employee->id; ?>"
                                                <?php
                                                if (!empty($advance_salary->user_id)) {
                                                    $user_id = $advance_salary->user_id;
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
                   <input type="number" step="0.01"  name="advance_amount"  required class="form-control amount"  value="<?php
                        if (!empty($advance_salary->advance_amount)) {
                            echo $advance_salary->advance_amount;
                        } 
               
                        ?>">
                </div>
           <div class=""> <p class="form-control-static" id="errors" style="text-align:center;color:red;"></p>   </div>                    
                        
                   
            </div>

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Deduct Month <span class="required">*</span></label>

                <div class="col-lg-12">
                     <input required type="month"  class="form-control monthyear" name="deduct_month" data-format="yyyy/mm/dd"  
                    value="<?php
                        if (!empty($advance_salary->deduct_month)) {
                            echo $advance_salary->deduct_month;
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
                    if (!empty($advance_salary->reason)) {
                        echo $advance_salary->reason;
                    }
                    ?></textarea>
                    
                </div>
            </div>
          
                    <input type="hidden" name="type" value="add" required class="form-control">
             @can('approve-payment')
                <input type="hidden" name="approve" value="yes"  class="form-control">
            @endcan


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </form>
    </div>
</div>