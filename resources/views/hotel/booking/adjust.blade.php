
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Adjust </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(array('route' => 'booking.adjust',"enctype"=>"multipart/form-data", 'id' => 'adjform')) !!}
                                                        @method('POST')
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

      <div class="form-group row"><label
                                                            class="col-lg-3 col-form-label">Checkout time</label>

                                                        <div class="col-lg-8">
                                                            <input name="checkout_time" type="time" class="form-control time"   value="{{ isset($data) ? $data->checkout_time : '' }}"/>
                                                        </div>
                                                    </div>
                                                   <input name="id" type="hidden" class="form-control "  value="{{$id}}"/>
               
              </div>
</div>
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
         <button class="btn btn-primary"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>


       </form>

            </div>
        