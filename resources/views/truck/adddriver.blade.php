
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Assign Driver</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           {{ Form::open(['url' => url('logistic_truck/save_driver')]) }}
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


        
       <div class="modal-footer ">
             <button class="btn btn-primary"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>


       </form>


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
