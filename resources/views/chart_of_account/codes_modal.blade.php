<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Account Codes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form id="addCodesForm" class="addCodesForm">
             {{ csrf_field() }}
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
   <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Account Name</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="account_name" required placeholder="" value=""
                                                            class="form-control">
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Account Group</label>

                                                    <div class="col-lg-8">
                                                     <div class="input-group mb-2">
                                                    <select class="form-control m-m group" id="account_group" name="account_group" required>
                                                    <option value="">Select Account Group</option>  
                                                      
                                                      @foreach($group_account as $group)
                                                      <option value="{{$group->id}}">{{$group->name}}</option>
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
         <button class="btn btn-primary add_codes"  type="submit" id="save" data-dismiss="modal"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
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
