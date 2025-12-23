<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Invoice Issue</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           {{ Form::open(['url' => url('save_issue')]) }}
       @method('POST')
        <div class="modal-body">
        <p><strong>Make sure you enter valid information</strong> .</p>

            <div class="form-group">
                <label class="col-lg-6 col-form-label"> Date</label>

                <div class="col-lg-12">
                    <input type="date" name="date"   required class="form-control" value="<?php
                if (!empty($data->issue_date)) {
                    echo $data->issue_date;
                } else {
                    echo date('Y-m-d');
                }
                ?>">
                  
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Employee</label>
                <div class="col-lg-12">
                    <select name="staff" id="staff" class="form-control m-b select_box" required>
                            <option value="">Select Employee</option>
                            <?php if (!empty($user)): ?>
                                <?php foreach ($user as  $v_employee) : ?>
                                            <option value="<?php echo $v_employee->id; ?>"
                                                <?php
                                                if (!empty($data->issued_by)) {
                                                    $user_id = $data->issued_by;
                                                } 
                                                if (!empty($user_id)) {
                                                    echo $v_employee->id == $user_id ? 'selected' : '';
                                                }
                                                ?>><?php echo $v_employee->name  ?></option>
                                     
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>


                      <input type="hidden" name="id" value="{{$id}}" required class="form-control">
                </div>
            </div>

          

        </div>
        <div class="modal-footer bg-whitesmoke br">
        <button class="btn btn-primary"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>


        {!! Form::close() !!}


    </div>
</div>

@yield('scripts')
<script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>