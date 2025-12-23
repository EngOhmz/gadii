    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Create WBN</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           
              <form id="addAssignForm" role="form" enctype="multipart/form-data" action="{{route('courier.save_wbn')}}"  method="post" >
            @csrf
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

      <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Quantity</label>

                                                        <div class="col-lg-10">
                                                           <input type="number" name="wbn" class="form-control" required>
                                                        </div>
                                                    </div>

                                                      <input type="hidden" name="id"
                                                                class="form-control" value="{{$id}}"> 

                 
               
              </div>
</div>
                                                    </div>


        </div>
         <div class="modal-footer ">
             <button class="btn btn-primary"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
   


       </form>


    </div>


@yield('scripts')
<script>
            $('.m-b').select2({
                            });

  
</script>
