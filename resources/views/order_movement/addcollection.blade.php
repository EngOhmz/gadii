
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Order Collection</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('order_movement.update', $id), 'method' => 'PUT')) }}
        <div class="modal-body" id="modal_body">

              <div class="form-group">
                <label class="col-lg-6 col-form-label">Transport Type </label>

                <div class="col-lg-12">
                    <select class="form-control m-b type" name="owner_type" id="type" required>
                                                   <option value="">Select</option>
                                            <option @if(isset($data))
                                                   {{$data->type == 'owned'  ? 'selected' : ''}}
                                                   @endif value="owned">From Company</option>
                                                   <option @if(isset($data))
                                                   {{$data->type == 'non_owned'  ? 'selected' : ''}}
                                                   @endif value="non_owned">From Third Party Company</option>

                                                 </select>
                </div>
            </div>
<div class="" id="test">
     <div class="form-group">
                <label class="col-lg-6 col-form-label">Truck </label>

                <div class="col-lg-12">
                    <select class="form-control m-b truck_id" name="truck_id"  id="truck" required>
                                                      
                                                        <option value="">Select Truck</option>
                                                     

                                                    </select>
                </div>
  <p class"errors" id="errors" style="color:red;"></p>
            </div>
</div>
        
      <div class="form-group">
                <label class="col-lg-6 col-form-label">Driver</label>

                <div class="col-lg-12">
           <input type="text"  id="driver"  value="" required class="form-control driver" readonly>
                 
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg-6 col-form-label">Arrival Address/Location</label>

                <div class="col-lg-12">
           <input type="text" name="end" id=""  value=""  class="form-control ">
                 
                </div>
            </div>

                   <div class="form-group">
                <label class="col-lg-6 col-form-label">Receipt</label>

                <div class="col-lg-12">
           <input type="text" name="receipt" id=""  value=""  class="form-control ">
                 
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
                     <input type="hidden"  name ="driver_id" id="driver_id"   value="" required class="form-control driver_id">
</div>
            </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save" disabled="">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
