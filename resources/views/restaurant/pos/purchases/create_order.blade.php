    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">
               Create Order
                      
</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
 
<br>
                <form id="form" role="form" enctype="multipart/form-data" action="{{route('restaurant_purchase.save_order')}}"  method="post" >    
                @csrf

        <div class="modal-body">

   
            <input type="hidden"   id="purchase_id" name="purchase_id"  class="form-control user"  value="<?php echo $id ?>">

         <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label">Location</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control m-b" name="location" required
                                                        id="location">
                                                        <option value="">Select Location</option>
                                                        @if(!empty($location))
                                                        @foreach($location as $loc)

                                                        <option value="{{ $loc->id}}">{{$loc->name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                        
                                                    </div> </div>

                                                      <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label">Supplier Name</label>
                                                    <div class="col-lg-6">
                                                       
                                                            <select class="form-control m-b" name="supplier_id" required
                                                                id="supplier_id">
                                                                <option value="">Select Supplier Name</option>
                                                                @if(!empty($supplier))
                                                                @foreach($supplier as $row)

                                                                <option  value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                                                            
                                                        
                                                    </div>
                                                </div>
            



         </div>
<br>
        <div class="modal-footer">
            <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        </form>
    
</div>

@yield('scripts')


<script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>