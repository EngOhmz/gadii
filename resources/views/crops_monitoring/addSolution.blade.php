<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Solutions</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('crops_monitoring.update', $id), 'method' => 'PUT')) }}
        <div class="modal-body">
        
            <div class="form-group">
                <label class="col-lg-6 col-form-label">Action Taken</label>

                <div class="col-lg-12">
                    <input type="text" name="action" value="" required class="form-control">
                    
                     <input type="hidden" name="type" value="solution" class="form-control">
                    
                </div>
            </div>
          
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Chemical Applied </label>

                <div class="col-lg-12">
                    <input type="text" name="chemical" value="" required class="form-control">
                    
                </div>
            </div>
                    <div class="form-group">
                <label class="col-lg-6 col-form-label">Results</label>

                <div class="col-lg-12">
                    <input type="text" name="result" value="" required class="form-control">
                    
                </div>
            </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>