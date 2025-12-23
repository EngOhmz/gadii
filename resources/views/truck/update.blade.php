    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Update Quantity</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

       <form id="addAssignForm" role="form" enctype="multipart/form-data" action="{{route('equipment.update')}}"  method="post" >
            @csrf
        <div class="modal-body" id="modal_body">

          

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Quantity</label>

                <div class="col-lg-12">
                    <input type="number" name="quantity"  required class="form-control">
                    
                </div>
            </div>

 
          
                 <div class="form-group">
                <label class="col-lg-6 col-form-label"> Date</label>

                <div class="col-lg-12">
                    <input type="date" name="date" value="<?php echo date('Y-m-d');  ?>"  required class="form-control">
                                     
                                                
                    <input type="hidden" name="id" value="{{ $id}}" required class="form-control" id="collection">
</div>
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
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>