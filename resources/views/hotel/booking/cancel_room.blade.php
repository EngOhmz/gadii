
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Cancel Room </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(array('route' => 'booking.cancel_room',"enctype"=>"multipart/form-data", 'id' => 'adjform')) !!}
                                                        @method('POST')
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

                                                <div class="form-group row"><label class="col-lg-3 col-form-label">Reason For Cancellation</label>

                                                        <div class="col-lg-8">
                                                            <textarea name="cancel_reason" class="form-control desc" placeholder=""rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                 <div class="form-group row"><label class="col-lg-3 col-form-label">Cancellation Percent </label>

                                                        <div class="col-lg-8">
                                                            <input name="cancel_percent" type="number" class="form-control"  min="0" required/>
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
        