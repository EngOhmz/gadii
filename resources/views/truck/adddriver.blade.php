<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Assign Driver</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           {{ Form::open(['url' => url('save_driver')]) }}
       @method('POST')
            @csrf
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">


                                             
 
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Driver </label>
                                                   
            
                                                <div class="col-lg-8">
                                                    <select class="form-control m-b" name="driver" required>
                                                        <option value="">Select
                                                        </option>
                                                        @if(!empty($driver))
                                                        @foreach($driver as $row)
                                                        <option value="{{$row->id}}" >{{$row->driver_name}} </option>

                                                        @endforeach
                                                        @endif
                                                    </select>
            
                                                </div>
                                            </div>

                       
                   <input type="hidden" name="id" required
                                                            placeholder=""
                                                            value="{{$id}}"
                                                            class="form-control">
               
              </div>
</div>
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>


    </div>
</div>


