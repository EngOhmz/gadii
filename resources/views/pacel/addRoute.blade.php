<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Add Route</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           <form id="addRouteForm" method="post" action="javascript:void(0)">
            @csrf
        <div class="modal-body">
                        <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <label class="control-label">Starting Point<span class="text-danger"> *</span></label>
                    <select class="form-control" name="from" required
                                                                id="from">
                                                                <option value="">Select</option>
                                                                @if(!empty($region))
                                                                @foreach($region as $row)

                                                                <option value="{{ $row->name}}">{{$row->name}} </option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                    </div>
                   
                       
                </div>
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <label class="control-label">Destination Point <span class="text-danger">*</span></label>
                      <select class="form-control" name="to" required
                                                                id="to">
                                                                <option value="">Select</option>
                                                                @if(!empty($region))
                                                                @foreach($region as $row)

                                                                <option value="{{ $row->name}}">{{$row->name}} </option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                    </div>
                   
                </div>
         
                     <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <label class="control-label">Distance <span class="text-danger">*</span></label>
                        <input type="number"  step="0.001" class="form-control" name="distance" id="distance" required>
                        @error('distance')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>
                
                    </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save" onclick="saveRoute(this)" data-dismiss="modal">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>


    </div>
</div>

<script>    

</script> 