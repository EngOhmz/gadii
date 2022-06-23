<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal"><?php echo ucfirst($type);?> Mechanical Report </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      {{ Form::open(['route' => 'maintainance.report']) }}
             @method('POST')
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
            <div class="form-group row">
    <label class="col-lg-2 col-form-label">Date</label>
    <div class="col-lg-8">
        <input type="date" name="date"
            placeholder="0 if does not exist"
            value=""
            class="form-control" required>
    </div>                                                          
 </div> 

                                            <br>
                                            <div class="table-responsive">
                                                <br>
                                              <h4 align="center">Enter Service Type</h4>
                                  <a href="javascript:void(0);" id="add_more" class="addService"><i  class="fa fa-plus"></i>&nbsp;Add  Item</a><br>
                                            <hr>
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                        <th>Service Type</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >


                                                </tbody>
                                               

                                            </table>

                                    

                                         <h4 align="center">Enter Recommedation</h4>
                          <a href="javascript:void(0);" id="add_more" class="addRecommedation"><i  class="fa fa-plus"></i>&nbsp;Add  Item</a><br>
                               <table class="table table-bordered" id="recommedation">
                                                <thead>
                                                    <tr>
                                                        <th>Recommedation</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >


                                                </tbody>
                                               

                                            </table>
</div>
 <input type="hidden" name="module_id"    value="{{ $id }}"     required />
      <input type="hidden" name="module"    value="{{ $type }}"     required />                                                           
                                                             
                                                            

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>