<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Group Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form id="addGroupForm" class="addGroupForm">
             {{ csrf_field() }}
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Name</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="name" required
                                                            placeholder=""
                                                            value=""
                                                            class="form-control">
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Class Account</label>

                                                    <div class="col-lg-8">
                                                    <select class="form-control m-m" id="group_account_id" name="class" required>
                                                 <option value="">Select Class Account</option>
                                                  @foreach($class_account as $class)
                                                       <option value="{{$class->id}}" >{{$class->class_name}}</option>
                                                       @endforeach
                                                      
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="id" required  value="{{ isset($id) ? $id : ''}}" class="form-control">
                 
               
              </div>
</div>
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
         <button class="btn btn-primary add_group"  type="submit" id="save" data-dismiss="modal"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>


       </form>

            </div>
        </div>
        
        @yield('scripts')
         <script>
        $(document).ready(function(){
            /*
                         * Multiple drop down select
                         */
            $('.m-m').select2({dropdownParent: $('#appFormModal'), });



        });
    </script>
