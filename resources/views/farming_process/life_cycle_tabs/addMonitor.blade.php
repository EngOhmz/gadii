<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Crops Monitoring</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('monitor.save'), 'method' => 'POST')) }}
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
 <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                         
                                                            <label for="inputEmail4">Name Of Monitoring</label>
                                                            <input type="text" name="name" class="form-control"
                                                                id="name"
                                                                value=" "
                                                                placeholder="" required>
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="inputAddress">Types</label>
                                                              <select class="form-control m-b" id="type"
                                                                name="type" required>
                                                         <option value="">Select</option>
                                                                @if(!empty($mtype))
                                                                @foreach($mtype as $row)
                                                                <option value="{{$row->name}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif
                                                            </select>

                                                        </div>
                                  

                                                    </div>
                                                       <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                           
                                                            <label for="inputEmail4">Course</label>
                                                            <input type="text" name="course" class="form-control"
                                                                id="name"
                                                                value=" "
                                                                placeholder="" required>
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="inputAddress">Syptoms</label>
                                                            <input type="text" name="symptoms" class="form-control"
                                                                id="costing"
                                                                value=""
                                                                placeholder="" required>

                                                        </div>
                                  

                                                    </div>
                                                       <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                           
                                                            <label for="inputEmail4">Attachment</label>
                                                            <input type="file" name="attachment" class="form-control"
                                                                id="attachment"
                                                                value=" "
                                                                placeholder="">
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="inputAddress">Farm</label>
                                                             <select class="form-control m-b" id="farm_id"
                                                                name="farm_id" required>
                                                              <option value="">Select</option>
                                                                @if(!empty($farm))
                                                                @foreach($farm as $row)
                                                                <option value="{{$row->id}}">{{$row->reg_no}}::{{$row->location}}</option>

                                                                @endforeach
                                                                @endif
                                                            </select>

                                                        </div>
                                  

                                                    </div>

                <input type="hidden" name="module_id" value="{{$id}}" required class="form-control">
<input type="hidden" name="module" value="{{$type}}" required class="form-control">
<input type="hidden" name="season_id" value="{{$season_id}}" required class="form-control">


           


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>