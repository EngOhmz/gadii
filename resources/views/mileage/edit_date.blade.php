<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Date Adjustment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('mileage_payment.update', $id), 'method' => 'PUT')) }}
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Date</label>

                <div class="col-lg-12">
                    <input type="date" name="date"    value="{{ isset($data) ? $data->date : date('Y-m-d')}}"  required class="form-control">

                    <input type="hidden" name="type" value="date" required class="form-control">
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