    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Edit Refill </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('fuel.update', $id), 'method' => 'PUT')) }}
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>

                <div class="form-group">
              <label class="col-lg-6 col-form-label"> Date</label>
                                                    <div class="col-lg-12">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->date : date('Y-m-d')}}" 
                                                            class="form-control">
                                                    </div>
                                                  </div>

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Total Cost</label>

                <div class="col-lg-12">
                    <input type="number" name="price" id="price"  value="{{ isset($data) ? $data->total_cost : ''}}"  class="form-control" required  >
                    
                </div>
            </div>
          
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Volume Refill</label>

                <div class="col-lg-12">
                    <input type="number"  step="0.001" name="litres"  id="litres"  value="{{ isset($data) ? $data->litres : ''}}" class="form-control"  required  >
                    <input type="hidden" name="type" value="edit_refill" >
                </div>
            </div>

                   <div class="form-group row"><label  class="col-lg-6 col-form-label">Supplier</label>

                <div class="col-lg-12">
                   <select class="form-control m-b" name="supplier"  id="supplier" required >
                <option value="">Select Supplier</option>                                                            
                      @foreach ($supplier as $supp)                                                             
                        <option value="{{$supp->id}}" @if(isset($data))@if($data->supplier == $supp->id) selected @endif @endif >{{$supp->name}}</option>
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
</div>


@yield('scripts')
<script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>