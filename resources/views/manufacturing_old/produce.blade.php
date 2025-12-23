<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">
Produced Quantity </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

 {!! Form::open(['route' => ['work_order.produce',$id], 'method' => 'POST']) !!}
                                                                 @csrf
                                                                 @method('PUT')
    <div class="modal-body">

  
<div class="form-group">
                <label class="col-lg-6 col-form-label">Quantity</label>

                <div class="col-lg-12">
                     <input type="number" name="withdraw_quantity" placeholder="Quantity to Be Produced" min="1" class="form-control user" required>
                    
                </div>
            </div>


   <div class="modal-footer ">
   <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
    </div>
   
   {{ Form::close() }}

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