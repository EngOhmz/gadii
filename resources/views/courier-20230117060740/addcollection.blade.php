
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Courier Pickup</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('courier_movement.update', $id), 'method' => 'PUT')) }}
        <div class="modal-body" id="modal_body">

          
    

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Description</label>

                <div class="col-lg-12">
                    <input type="text" name="notes" value="" required class="form-control">
                    
                </div>
            </div>
          
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Collection Date</label>

                <div class="col-lg-12">
                    <input type="date" name="collection_date" value="<?php echo date('Y-m-d');  ?>"  required class="form-control">
                                     
                                                
                    <input type="hidden" name="type" value="collection" required class="form-control">
                    <input type="hidden" name="id" value="{{ $id}}" required class="form-control" id="collection">
</div>
            </div>


   <div class="form-group">
                <label class="col-lg-6 col-form-label">Pickup Cost</label>

                <div class="col-lg-12">
                 <input type="number" name="costs"   value="0" class="form-control" required>
                                          

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