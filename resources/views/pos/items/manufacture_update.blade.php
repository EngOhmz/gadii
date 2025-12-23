    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Update Quantity</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

       <form id="addAssignForm" role="form" enctype="multipart/form-data" action="{{route('items2.update_quantity')}}"  method="post" >
            @csrf
        <div class="modal-body" id="modal_body">

          

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Quantity</label>

                <div class="col-lg-12">
                    <input type="number" step="any" name="quantity"  value="" required class="form-control">
                    
                </div>
            </div>

  <div class="form-group">
                <label class="col-lg-6 col-form-label">Location</label>

                <div class="col-lg-12">
                  <select class="form-control m-m" name="location"  id="location" required>
                       <option value="">Select Location</option>
                            @if(!empty($location))
                             @foreach($location as $loc)
                         <option value="{{ $loc->id}}">{{$loc->name}}</option>
                                                        @endforeach
                                                        @endif

                                                    </select>
                    
                </div>
            </div>
            
             <div class="form-group">
                <label class="col-lg-6 col-form-label">Branch</label>

                <div class="col-lg-12">
                   <select class="form-control m-m" name="branch_id" id="branch_id" >
                    <option value="" >Select Branch</option>
                        @if (isset($branch))
                        @foreach ($branch as $row)
                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                        @endforeach
                        @endif
                        </select>
                    
                </div>
            </div>
          
          
                 <div class="form-group">
                <label class="col-lg-6 col-form-label"> Date</label>

                <div class="col-lg-12">
                    <input type="date" name="purchase_date" value="<?php echo date('Y-m-d');  ?>"  required class="form-control">
                                     
                                                
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

           ('.m-m').select2({dropdownParent: $('#appFormModal'), });
</script>