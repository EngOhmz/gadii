<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Courier Collection</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('courier_movement.update', $id), 'method' => 'PUT')) }}
        <div class="modal-body" id="modal_body">

          
     <div class="form-group">
                <label class="col-lg-6 col-form-label">Vehicle/Bike Reg No</label>

                <div class="col-lg-12">
                 <input type="text" class="form-control truck_id" name="truck_id" id="truck" required>
                </div>
            </div>

        
      <div class="form-group">
                <label class="col-lg-6 col-form-label">Driver Name</label>

                <div class="col-lg-12">
                      <input type="text" class="form-control driver_id" name="driver_id" id="driver" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Description</label>

                <div class="col-lg-12">
                    <input type="text" name="notes" value="" required class="form-control">
                    
                </div>
            </div>
          
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Collection Date</label>

                <div class="col-lg-12">
                    <input type="date" name="collection_date" value="" required class="form-control">
                    <input type="hidden" name="type" value="collection" required class="form-control">
                    <input type="hidden" name="id" value="{{ $id}}" required class="form-control" id="collection">
</div>
            </div>


   <div class="form-group">
                <label class="col-lg-6 col-form-label">Pickup Cost</label>

                <div class="col-lg-12">
                 <input type="number" name="costs"   value="" class="form-control" required>
                                          

</div>
            </div>


   <div class="form-group">
                <label class="col-lg-6 col-form-label">Payment</label>

                <div class="col-lg-12">
                   <select class="form-control m-b" name="bank_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
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