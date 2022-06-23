<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Solutions</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
     
        <div class="modal-body">
        
            <div class="form-group">
                <label class="col-lg-6 col-form-label">Action Taken</label>

                <div class="col-lg-12">
                    <input type="text" name="action" value="{{$data->action}}" disabled required class="form-control">
                    
                     <input type="hidden" name="type" value="solution" class="form-control">
                     
                     
                    
                </div>
            </div>
          
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Chemical Applied </label>

                <div class="col-lg-12">
                    <input type="text" name="chemical" value="{{$data->chemical}}" disabled class="form-control">
                    
                </div>
            </div>
                    <div class="form-group">
                <label class="col-lg-6 col-form-label">Results</label>

                <div class="col-lg-12">
                    <input type="text" name="result" value="{{$data->result}}" disabled class="form-control">
                    
                </div>
            </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
           <!-- <button type="submit" class="btn btn-primary">Save</button> -->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
       
    </div>
</div>