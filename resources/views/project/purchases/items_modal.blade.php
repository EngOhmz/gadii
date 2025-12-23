<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form id="addItemForm" class="addItemForm">
             {{ csrf_field() }}

        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

      <div class="form-group row"><label class="col-lg-2 col-form-label">Item Type</label>
                                                   <div class="col-lg-10">
                                                   <select class="form-control m-b" name="type"  required>
                                                <option value="">Select</option>
                                                    <option value="1">Inventory</option>
                                                        <option value="4">Service</option>
                                        
                                                   </select>
                                                          
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Item Name</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="name" id="name"
                                                            class="form-control name" required>
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Cost Price</label>

                                                    <div class="col-lg-10">
                                                        <input type="number" name="cost_price" id="cost_price" value=""
                                                            class="form-control cost_price">
                                                    </div>
                                                </div>
                                    <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Sales Price</label>

                                                    <div class="col-lg-10">
                                                        <input type="number" name="sales_price" id="sales_price"
                                                            value=""
                                                            class="form-control">
                                                    </div>
                                                </div>

                                 <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Tax Rate</label>

                                                    <div class="col-lg-10">
                                                        <select name="tax_rate" class="form-control m-b item_tax" required>
                                                                    <option value="0">Select Tax Rate</option>
                                                                    <option value="0">No tax</option>
                                                                    <option value="0.18">18%</option>
                                                                </select>
                                                    </div>
                                                </div>

                                                     @can('manage-restaurant')
                                         <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label"> No of Bottles</label>

                                                <div class="col-lg-10">
                                                    <input type="number" name="bottle"
                                                        value=""
                                                        class="form-control">
                                                </div>
                                            </div>
                                      <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Unit Price</label>

                                                    <div class="col-lg-10">
                                                        <input type="number" name="unit_price"
                                                            value=""
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                              @endcan
                                                
                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Unit</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="unit" id="unit"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                   <div class="form-group row">
                                        <label class="col-form-label col-lg-2">Desription</label>
                                        <div class="col-lg-10">
                                            <textarea name="description" id="description"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>


  <input type="hidden" value="{{ isset($id) ? $id: ''}}" id="select_id" class="form-control">
                 
               
              </div>
</div>
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
         <button class="btn btn-primary edit_form"  type="submit" id="save" data-dismiss="modal"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
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
            $('.m-b').select2({ width: '100%', });



        });
    </script>



