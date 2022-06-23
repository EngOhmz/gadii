<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Add Discount</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           {{ Form::open(['url' => url('newdiscount')]) }}
       @method('POST')
        <div class="modal-body">
        <p><strong>Make sure you enter valid information</strong> .</p>

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Total Amount</label>

                <div class="col-lg-12">
                    <input type="text"   value="{{ isset($old) ? $old->amount : ''}}" required class="form-control" readonly id="old">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-6 col-form-label">Discount</label>
                <div class="col-lg-12">
                    <input type="text" name="discount" id="discount" value="" class="form-control discount" required onkeyup=" calculateDiscount();">
                      <input type="hidden" name="id" value="{{$id}}" required class="form-control">
                </div>
            </div>

             <div class="form-group">
                <label class="col-lg-6 col-form-label">New Amount</label>
                <div class="col-lg-12">
                    <input type="text" name="amount" value="" class="form-control" id="total" required readonly>
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

