

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">Add Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <form id="addAssignForm" role="form" enctype="multipart/form-data" action="{{ route('items2.update_quantity') }}"
        method="post">
        @csrf
        
        <div class="modal-body" id="modal_body">
            <div class="form-group">
                <label class="col-lg-6 col-form-label">Unit</label>

                <div class="col-lg-12">
                    <input type="text" name="unit" value="" required class="form-control">

                </div>
            </div>
        </div>
        
        <div class="modal-footer ">
            <button class="btn btn-primary" type="submit" id="save"><i
                    class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>
                Close</button>
        </div>
        {!! Form::close() !!}
</div>


@yield('scripts')

