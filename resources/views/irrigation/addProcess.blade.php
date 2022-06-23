<div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">{{__('farming.irrigation_process')}}</h5>
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
                @if(!empty($id))
    {{ Form::model($id, array('route' => array('irrigation.update', $id), 'method' => 'PUT')) }}
    @else
    {{ Form::open(['route' => 'irrigation.store']) }}
    @method('POST')
    @endif
    @csrf
        <div class="modal-body">
        <div class="alert alert-danger d-none errors col-12" role="alert"> </div>
        <input type="hidden" name="type2" value="process" class="form-control">
        <input type="hidden" name="type" value="irrigation">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>{{__('farming.irrigation_date')}}</label>
                        <input type="date" name="irrigation_date" id="irrigation_date" class="form-control">
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
                        <label>{{__('farming.next_date')}}</label>
                        <input type="date" name="next_date" id="next_date" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>{{__('farming.cost_per_heck')}}</label>
                        <input type="number" name="cost_per_heck" id="cost_per_heck" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>{{__('farming.no_of_heck')}}</label>
                        <input type="number" name="no_of_heck" id="no_of_heck" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>{{__('farming.total_volume')}}</label>
                        <input type="number" name="total_volume" id="total_volume" class="form-control">
                    </div>
                </div>
            </div>
   
       
           
        </div>
        <div class="modal-footer bg-whitesmoke br">
       
            <input type="submit" value="Save" class="btn btn-primary" onclick="saveProcess(this)">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
</div>