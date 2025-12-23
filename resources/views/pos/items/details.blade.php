    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Item Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body" id="modal_body">
            <div class="col-lg-12">
            <div class="table-responsive">

              <table class="table datatable-basic table-borderless">

                <tr><td><strong>Category </strong></td><td @if(!empty($data->category_id))  {{$data->cat->name}} @endif </td></tr>
                @if($data->type == 1)
                <tr><td><strong>Size  </strong></td><td> @if(!empty($data->size)) {{$data->s->name}} @endif </td> </tr>                                     
                <tr><td><strong>Color </strong></td><td> @if(!empty($data->color)) {{$data->c->name}} @endif </td> </tr>  
                @endif
                <tr><td><strong>Description  </strong></td><td>{{$data->description}}</td> </tr>                                       
                                   
                            </table>

            
                   </div>
                    
                </div>
           

  


        </div>
      <div class="modal-footer ">
            
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
       
    </div>


@yield('scripts')
<script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>