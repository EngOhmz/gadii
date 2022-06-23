 <!--Deposity model -->
        
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deposity Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="form" method="post" action="{{url('deposity/save')}}">
                    {{ csrf_field() }}
                      <div class="card-body">
                       <!-- intput for capture warehouseid hidden-->
                  <input type="hidden" value="{{$warehouse_id}}" name='warehouseid' >
                  <input type="hidden" value="{{$id}}" name='account_id' >
                        <div class="form-group col-md-12 col-lg-12 col-xl-12">
                           <label for="deposityquantity">Quantity in Kilogram(Kg)</label>
                            <input type="number"  name='deposityquantity' class="form-control" id="deposityquantityid" placeholder="Enter Quantity in Kilogram(Kg)">
                                @error('deposityquantity')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                         <div class="form-group col-md-12 col-lg-12 col-xl-12">
                           <label for="deposityprice">Deposity Cost</label>
                            <input type="number" name='deposityprice' class="form-control" id="depositypriceid" placeholder="Enter Deposity Cost in Tsh">
                                @error('deposityprice')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-row">
                           <div class="form-group col-md-12 col-lg-12">
                
                            <input type="submit" value="Add" name="save" class="btn btn-block btn-primary">
                          </div>
                        </div>
                      </div>
              </form>
                </div>
              </div>
  
            <!-- end of Deposity model -->