
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Scan Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form id="addScanForm" class="addScanForm" method="post" action="javascript:void(0)">
            @csrf
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

      <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Barcode</label>

                                                        <div class="col-lg-10">
                                                         <div class="input-group mb-3">
                                                            <input type="text" name="barcode"  id="barcode2"                                                                
                                                                class="form-control barcode2" required>
                                                                
                                                                 
                                                                &nbsp

                                                                <button class="btn btn-outline-secondary scan2" type="button"><i class="icon-barcode2"> </i> Scan</button>

                                                            </div>
                                                            <div class="">
                                                                <p class="form-control-static bar_errors" id="bar_errors"
                                                                    style="text-align:center;color:red;"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                   <input type="hidden" value="{{ isset($id) ? $id: ''}}" id="select_id" name="order_no" class="form-control">
                 
               
              </div>
</div>
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
         <button class="btn btn-primary check_item" type="submit" id="save2"  data-dismiss="modal" disabled><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>


       </form>

            
        </div>
        
        @yield('scripts')
        
        
          <script>
        $(document).ready(function() {

            var msg = 'The Barcode Not Found.';

            $(document).on('change', '.barcode2', function(event) {
                var id = $(this).val();
                console.log(id);
                $.ajax({
                    url: '{{ url('pos/purchases/findCode') }}',
                    type: "GET",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $(".bar_errors").empty();
                        $(".check_item").attr("disabled", false);
                        if (data == '') {
                            $(".bar_errors").append(msg);
                            $(".check_item").attr("disabled", true);
                            event.preventDefault(); 
                        } else {
                            event.preventDefault(); 
                        }


                    }

                });

            });
            
            
     
$(document).on('click', '.scan2', function(e) {
               
    $('.barcode2').val('');  // Input field should be empty on page load
    $('.barcode2').focus();  // Input field should be focused on page load 
e.preventDefault(); 
            });
                   
            

        });
    </script>