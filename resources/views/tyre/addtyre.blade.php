    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Assign Truck</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('purchase_tyre.save'), 'method' => 'POST')) }}
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
              

                <input type="hidden" name="id" value="{{$id}}"  class="form-control" required>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Mechanical</label>
                                                    <div class="col-lg-4">
                                   <select name="staff"  class="form-control m-m" id="staff" required>                   
                    <option value="">Select</option>
                    @foreach($staff as $s) 
                    <option value="{{ $s->id}}">{{$s->name}}</option>
                    @endforeach
                </select>
                      
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">km reading</label>
                                                    <div class="col-lg-4">
                                                     <input type="text" name="reading" value=""   class="form-control"  required>
               
                                                    </div>
                                                </div>

        
                                            <div class="table-responsive">
                                                <br>
                                              <h4 align="center">Choose Tyre</h4>
                                            <hr>



                                      @if(!empty($truck->due_1 >0 ))
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                        <th>Tyre</th>
                                                          <th>Tyre Position</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                              <?php   
                                    for($i = 0; $i < $truck->due_1 ; $i++){
                                       ?>
                                   <tr>
                                 <td> 
                        <select name="tyre_1[]"  class="form-control m-m" required>                   
                        <option value="">Select Item</option>
                        @foreach($name as $n) 
                    <option value="{{ $n->id}}">{{$n->serial_no}}</option>
                    @endforeach
                </select></td>
                    <td>  <input type="text" name="position_1[]" value="Position 1"   class="form-control"  required readonly></td>
                 <td><button type="button" name="remove" class="btn btn-danger btn-xs remove_1"><i class="icon-trash"></i></button></td>
  <?php  }    ?>

                                                </tbody>
                                               
                                            </table>
                                            @endif

                                      @if(!empty($truck->due_2 >0 ))
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                        <th>Tyre</th>
                                                          <th>Tyre Position</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                              <?php   
                                    for($i = 0; $i < $truck->due_2 ; $i++){
                                       ?>
                                   <tr>
                                 <td> 
                        <select name="tyre_2[]"  class="form-control m-m"  required>                   
                        <option value="">Select Item</option>
                        @foreach($name as $n) 
                    <option value="{{ $n->id}}">{{$n->serial_no}}</option>
                    @endforeach
                </select></td>
                    <td>  <input type="text" name="position_2[]" value="Position 2"   class="form-control"  required readonly></td>
                 <td><button type="button" name="remove" class="btn btn-danger btn-xs remove_2"><i class="icon-trash"></i></button></td>
  <?php  }    ?>

                                                </tbody>
                                               
                                            </table>
                                            @endif
                                   


                                      @if(!empty($truck->due_3 >0 ))
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                        <th>Tyre</th>
                                                          <th>Tyre Position</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                              <?php   
                                    for($i = 0; $i < $truck->due_3 ; $i++){
                                       ?>
                                   <tr>
                                 <td> 
                        <select name="tyre_3[]"  class="form-control m-m"  required>                   
                        <option value="">Select Item</option>
                        @foreach($name as $n) 
                    <option value="{{ $n->id}}">{{$n->serial_no}}</option>
                    @endforeach
                </select></td>
                    <td>  <input type="text" name="position_3[]" value="Position 3"   class="form-control"  required readonly></td>
                 <td><button type="button" name="remove" class="btn btn-danger btn-xs remove_3"><i class="icon-trash"></i></button></td>
  <?php  }    ?>

                                                </tbody>
                                               
                                            </table>
                                            @endif
                                            
                                            
                                                              @if(!empty($truck->due_4 >0 ))
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                        <th>Tyre</th>
                                                          <th>Tyre Position</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                              <?php   
                                    for($i = 0; $i < $truck->due_4 ; $i++){
                                       ?>
                                   <tr>
                                 <td> 
                        <select name="tyre_4[]"  class="form-control m-m"  required>                   
                        <option value="">Select Item</option>
                        @foreach($name as $n) 
                    <option value="{{ $n->id}}">{{$n->serial_no}}</option>
                    @endforeach
                </select></td>
                    <td>  <input type="text" name="position_4[]" value="Position 4"   class="form-control"  required readonly></td>
                 <td><button type="button" name="remove" class="btn btn-danger btn-xs remove_4"><i class="icon-trash"></i></button></td>
  <?php  }    ?>

                                                </tbody>
                                               
                                            </table>
                                            @endif
                                            
                                            
                                                              @if(!empty($truck->due_5 >0 ))
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                        <th>Tyre</th>
                                                          <th>Tyre Position</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                              <?php   
                                    for($i = 0; $i < $truck->due_5 ; $i++){
                                       ?>
                                   <tr>
                                 <td> 
                        <select name="tyre_5[]"  class="form-control m-m"  required>                   
                        <option value="">Select Item</option>
                        @foreach($name as $n) 
                    <option value="{{ $n->id}}">{{$n->serial_no}}</option>
                    @endforeach
                </select></td>
                    <td>  <input type="text" name="position_5[]" value="Position 5"   class="form-control"  required readonly></td>
                 <td><button type="button" name="remove" class="btn btn-danger btn-xs remove_5"><i class="icon-trash"></i></button></td>
  <?php  }    ?>

                                                </tbody>
                                               
                                            </table>
                                            @endif
                                            
                                            
                                            
                                            
                                            
                                            
                                                              @if(!empty($truck->due_6 >0 ))
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                        <th>Tyre</th>
                                                          <th>Tyre Position</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                              <?php   
                                    for($i = 0; $i < $truck->due_6 ; $i++){
                                       ?>
                                   <tr>
                                 <td> 
                        <select name="tyre_6[]"  class="form-control m-m"  required>                   
                        <option value="">Select Item</option>
                        @foreach($name as $n) 
                    <option value="{{ $n->id}}">{{$n->serial_no}}</option>
                    @endforeach
                </select></td>
                    <td>  <input type="text" name="position_6[]" value="Position 6"   class="form-control"  required readonly></td>
                 <td><button type="button" name="remove" class="btn btn-danger btn-xs remove_6"><i class="icon-trash"></i></button></td>
  <?php  }    ?>

                                                </tbody>
                                               
                                            </table>
                                            @endif
                                    

        </div>

</div>
      <div class="modal-footer ">
             <button class="btn btn-primary"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        {!! Form::close() !!}
    </div>

@yield('scripts')
<script>

//$('.m-m').select2({dropdownParent: $('#appFormModal'), });
$('.m-m').select2({ });
</script>
