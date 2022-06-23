<div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">{{__('farming.add')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="ibox d-none ibox-loading">
                    <div class="ibox-content">
                        <div class="sk-spinner sk-spinner-wave">
                            <div class="sk-rect1"></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                        <div style="height: 100px !important;"></div>
                    </div>
                </div>
        <form id="addSeedsForm" method="post" action="javascript:void(0)">
        @csrf
        <div class="modal-body">
        <div class="alert alert-danger d-none errors col-12" role="alert"> </div>

            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>{{__('farming.seeds_name')}}</label>
                        <input type="text" name="name" id="name"  class="form-control">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>{{__('farming.seed_age')}}</label>
                        <input type="number" name="age" id="age" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>{{__('farming.soil_type')}}</label>
                        <input type="text" name="soil_type" id="soil_type" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>{{__('farming.water_volume')}}</label>
                        <input type="number" name="water_volume" id="water_volume" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>{{__('farming.properties')}}</label>
                        <input type="text" name="properties" id="properties" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>{{__('farming.harvest_volume')}}</label>
                        <input type="number" name="harvest_volume" id="harvest_volume" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>{{__('farming.crop_name')}}</label>
                        <select name="crop_type" id="crop_type" class="form-control">
                            @if(!empty($crop_types))
                            @foreach($crop_types as $row)
                            <option value="{{$row->id}}">{{$row->crop_name}}
                            </option>
                            @endforeach
                            @endif
                        </select>
                       
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
            
            <input type="submit" value="Save" class="btn btn-primary" onclick="saveSeeds(this)">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </form>
</div>