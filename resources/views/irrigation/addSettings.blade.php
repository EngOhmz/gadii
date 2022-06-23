<div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">{{__('farming.irrigation_setting')}}</h5>
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

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <input type="hidden" name="type2" id="type" value="setting" class="form-control">
                <div class="form-group">
                    <label>{{__('farming.irrigation_type')}}</label>
                    <select name="irrigation_type" id="irrigation_type" class="form-control" required onchange = "ShowHideDiv()" >
                         <option value="">Select</option>
                                                <option value="Rainfall" >Rainfall</option>
                                                <option value="Irrigation">Irrigation</option>
                       
                    </select>
                </div>
            </div>

 <script type="text/javascript">
                     function ShowHideDiv() {
                  var ddlPassport = document.getElementById("irrigation_type");
                var dfPassport = document.getElementById("method");

              dfPassport.style.display = ddlPassport.value == "Irrigation" ? "block" : "none";
    }
             </script>

            <div class="col-lg-6 col-sm-12"  id="method"  style="display:none;">
                <div class="form-group">
                    <label>Method of Irrigation</label>
  <select name="method" class="form-control">
                         <option value="">Select</option>
                                                <option value="Drip Irrigation System">Drip Irrigation System</option>
                                                <option value="Splinker Irrigation">Splinker Irrigation</option>
                                          <option value="Centre Pivot Irrigation">Centre Pivot Irrigation</option>
                                                <option value="Furrow Irrigation Systems">Furrow Irrigation Systems</option>
                                                <option value="Terraced Irrigation">Terraced Irrigation</option>
                       
                    </select>
                </div>
            </div>
        </div>

  <br>
                                              <h5 align="center">Cost of Implementation</h5>
                                            <hr>


<button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add item</i></button><br>
                                              <br>
 <div class="table-responsive">
<table class="table table-bordered" id="cart">
            <thead>
              <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Cost</th>
                <th>Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                                    
</tbody>

<tfoot>

 <tr class="line_items">
<td colspan="2"></td>
<td><span class="bold">Total </span>: </td><td><input type="text" name="total_cost[]" class="form-control item_total" placeholder ="total" required   jAutoCalc="SUM({cost})" readonly></td>   
</tr>


</tfoot>
          </table>
  </div>


        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="form-group">
                    <label>{{__('farming.number_of_hk')}}</label>
                    <input type="number" name="item_name" id="number_of_hk" class="form-control">
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="form-group">
                    <label>{{__('farming.power_source')}}</label>
                    <input type="number" name="power_source" id="power_source" class="form-control">
                </div>
            </div>
 <div class="col-lg-4 col-sm-12">
                <div class="form-group">
                    <label>{{__('farming.pump_cost')}}</label>
                    <input type="text" name="cost" id="pump_cost" class="form-control">
                </div>
            </div>
        </div>
    

    </div>
    <div class="modal-footer bg-whitesmoke br">
    <input type="hidden" name="type" value="irrigation">

        <input type="submit" value="Save" class="btn btn-primary" onclick="saveIrrigation(this)">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
    {!! Form::close() !!}
</div>


