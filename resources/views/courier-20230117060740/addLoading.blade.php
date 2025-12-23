
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Courier Freight</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      {{ Form::model($id, array('route' => array('courier_movement.update', $id), 'method' => 'PUT')) }}
        <div class="modal-body">
        
            <p><strong>Make sure the delivered order is the same as the order confirmed</strong> .</p>
              
           
              <div class="form-group">
                <label class="col-lg-6 col-form-label">Freight Method</label>

                <div class="col-lg-12">
                   <select class="form-control m-b method" name="method" required >
                                                    <option value="">Select Freight Method</option>                                                          
                                                            <option value="Truck Freight" >Truck Freight</option>
                                                              <option value="Air Freight" >Air Freight</option>
                                                              </select>
</div>
            </div>


            <div class="form-group">
                <label class="col-lg-6 col-form-label">Description</label>

                <div class="col-lg-12">
                    <input type="text" name="notes" value="" required class="form-control">
                    
                </div>
            </div>

             <div class="form-group truck" style="display:none;">
                <label class="col-lg-6 col-form-label">Vehicle Reg No</label>

                <div class="col-lg-12">
                 <input type="text" class="form-control truck_id" name="truck_id" id="truck" >
                </div>
            </div>

        
      <div class="form-group awb" style="display:none;">
                <label class="col-lg-6 col-form-label">AWB Number</label>

                <div class="col-lg-12">
                      <input type="text" class="form-control awb" name="awb" id="awb" >
                </div>
            </div>
          
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Loading Date</label>

                <div class="col-lg-12">
                    <input type="date" name="collection_date" value="<?php echo date('Y-m-d');  ?>" required class="form-control">
                    <input type="hidden" name="type" value="loading" required class="form-control">
                </div>
            </div>

        <div class="form-group">
                <label class="col-lg-6 col-form-label">Loading Cost</label>

                <div class="col-lg-12">
                 <input type="number" name="costs"   value="" class="form-control" >
                                          

</div>
            </div>


   <div class="form-group">
                <label class="col-lg-6 col-form-label">Payment</label>

                <div class="col-lg-12">
                   <select class="form-control m-b" name="bank_id" >
                                                    <option value="">Select Payment Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
</div>
            </div>
        </div>

       <div class="modal-footer ">
             <button class="btn btn-primary"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        {!! Form::close() !!}
    </div>


@yield('scripts')
<script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>