    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Manage Logistic {{$data->project_name}} -  {{$data->project_no}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

 <!--logistic model  -->
               
                <div class="modal-body">
                <div class="row">
                <div class="col-sm-12 ">
                {{ Form::open(['route' => 'update_det']) }}
                @method('POST')
                <input type="hidden" name="cf_id" value="{{ $data->id}}">
                <input type="hidden" name="cargoType_id" value="{{ $id}}">
                <input type="hidden" name="type" value="logistic">
                <div class="form-group row">
                <div class="col-lg-12">
                <select name="logistic_con" id="cf_servece_id" class="form-control m-b" required>
                <option value="">Select Here</option>
                <option value='no'>Not Involve Logistic</a></option>
                <option value='yes'>Involve Logistic</a></option>
                </select>

                </div>
                </div>


                <div class="form-group row">
                <div class="col-lg-offset-2 col-lg-12">
                <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                type="submit">Save</button>
                    </div>
                </div>
                {!! Form::close() !!}
                    </div>

                </div>

                </div>
              
    </div>

@yield('scripts')




