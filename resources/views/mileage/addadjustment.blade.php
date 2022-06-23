<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Mileage Adjustment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('mileage_payment.update', $id), 'method' => 'PUT')) }}
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Mileage Amoount Adjustment (TZS)</label>

                <div class="col-lg-12">
                    <input type="number" name="fuel_adjustment"   step="0.001" value="{{ isset($data) ? $data->fuel_adjustment : ''}}" required class="form-control">

                    <input type="hidden" name="type" value="adjustment" required class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Reason for Adjustment</label>

                <div class="col-lg-12">
                    <textarea name="reason" required class="form-control">{{ isset($data) ? $data->reason : ''}}</textarea>
                    
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