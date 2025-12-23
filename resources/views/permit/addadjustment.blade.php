<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Permit Adjustment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('permit_payment.update', $id), 'method' => 'PUT')) }}
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>

             <?php
                $name='';
             ?>

                @foreach($type as $t)
              @if(!empty($t))

                          <?php
                     if($t->type =='Road Toll'){
                           $name='road_toll';
                            $type_id='road_id';
                       }else if($t->type =='Toll Gate'){
                           $name='toll_gate';
                          $type_id='toll_id';
                        }else if($t->type =='Council'){
                           $name='council';
                             $type_id='council_id';
                           }else if($t->type =='Consultant'){
                           $name='consultant';
                            $type_id='consultant_id';
                        }
                       ?>

                  <div class="form-group">
                <label class="col-lg-6 col-form-label">{{$t->type}} Amount Adjustment (TZS)</label>

                <div class="col-lg-12">
                    <input type="number" name="{{$name}}"   step="0.001" value="{{ isset($t) ? $t->adjustment : ''}}"  class="form-control">
                   <input type="hidden" name="{{$type_id}}"   value="{{ isset($t) ? $t->id : ''}}"  class="form-control">
                    
                </div>
            </div>


 

                   @else  
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Permit Amount Adjustment (TZS)</label>

                <div class="col-lg-12">
                    <input type="number" name="fuel_adjustment"   step="0.001" value="{{ isset($data) ? $data->permit_adjustment : ''}}"  class="form-control">

                    <input type="hidden" name="type" value="adjustment" required class="form-control">
                </div>
            </div>
            @endif
                @endforeach

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Reason for Adjustment</label>

                <div class="col-lg-12">
                    <textarea name="reason" required class="form-control">{{ isset($data) ? $data->reason : ''}}</textarea>
                    
                </div>
            </div>
           
<input type="hidden" name="type" value="adjustment" required class="form-control">

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>