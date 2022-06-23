 <!--Withdraw model -->
              
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Withdraw Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="form" method="post" action="{{url('withdraw/save')}}">
                    {{ csrf_field() }}
                      <div class="card-body">
                          <!-- intput for capture warehouseid hidden-->
                          <input type="hidden" value="{{$warehouse_id}}" name='warehouseid' >
                          <input type="hidden" value="{{$id}}" name='account_id' >
                        <div class="form-group col-md-12 col-lg-12 col-xl-12">
                           <label for="withquantity">Quantity in Kilogram(Kg)</label>
                            <input type="text" name='withquantity' class="form-control" id="deposityquantityid" placeholder="Enter Quantity in Kilogram(Kg)">
                                @error('deposityquantity')
                            <div class="text-danger">{{$message }}</div>
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
      
<!-- end of withdraw model -->