
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Add <?php echo ucfirst($type);?> Location</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           <form id="addRouteForm" method="post" action="javascript:void(0)">
            @csrf
        <div class="modal-body">
                       

         
                     <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <label class="control-label">Location<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control location" name="location" id="location" value="" required>
                         <input type="hidden"  class="form-control" name="type" id="type" value="{{$type}}" required>
                    </div>
                         <div class=""> <p class="form-control-static" id="errors" style="text-align:center;color:red;"></p>   </div>
                    </div>

        </div>
          <div class="modal-footer ">
             <button class="btn btn-primary"  type="submit" id="save" onclick="saveLocation(this)" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
       


       </form>


    
</div>

<script>    

</script> 