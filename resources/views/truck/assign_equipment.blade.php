<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">
Assign</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<form id="addAssignForm" role="form" enctype="multipart/form-data" action="{{route('equipment.approve')}}"  method="post" >
            @csrf
    <div class="modal-body">

                                    <div class="form-group row">

                                                <label class="col-lg-2 col-form-label">Date</label>
                                                <div class="col-lg-4">
                                                    <input type="date" name="date" value="" class="form-control" required>
                                                </div>
                                                <label class="col-lg-2 col-form-label">Truck</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control m-b truck_id" name="truck_id" id="location_id" required>
                                                        <option value="">Select Truck</option>
                                                        @if (!empty($truck))
                                                            @foreach ($truck as $row)
                                                    <option  value="{{ $row->id }}">{{ $row->truck_name }} -  {{ $row->reg_no }}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                        </div>
                                                    </div>  
                                                    
                                                    
                                                    
                                                    <div class="form-group row">
                                                        
                                                        <label class="col-lg-2 col-form-label">Staff</label>
                                                        <div class="col-lg-4">
                                                            <select class="form-control m-b staff" name="staff" id="staff" required>
                                                                <option value="">Select </option>
                                                                @if (!empty($staff))
                                                                    @foreach ($staff as $row)
                                                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                                    @endforeach
                                                                @endif


                                                            </select>
                                                        </div>
                                                         <label class="col-lg-2 col-form-label">Cost</label>
                                                         <div class="form-group col-md-4">
                                                        <input type="number" name="cost" min="0" class="form-control item_quantity" step="0.01" id="quantity" value="" required />
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Description</label>
                                                        <div class="col-lg-4">
                                                            <textarea name="description" class="form-control"></textarea>
                                                        </div>
                                                        
                                                    </div>

                                                <input type="hidden" name="item_id" value="{{ $id}}" required class="form-control" id="collection">
                                                        

    </div>
   <div class="modal-footer ">
    <button class="btn btn-primary"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
     <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
    </div>
     {!! Form::close() !!}
</div>
</div>

@yield('scripts')
<script>
    $('.datatable-modal').DataTable({
         autoWidth: false,
         "columnDefs": [
             {"targets": [1]}
         ],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
         "language": {
            search: '<span>Filter:</span> _INPUT_',
             searchPlaceholder: 'Type to filter...',
             lengthMenu: '<span>Show:</span> _MENU_',
          paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
         },
     
     });
 </script>
 
 
 <script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>