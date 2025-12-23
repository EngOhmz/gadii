<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">
            New Lead Status
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="addStatusForm" method="post" action="javascript:void(0)">
        @csrf
        <div class="modal-body">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Lead Status
                                <span class="required">
                                    *</span></label>
                            <div class="col-lg-10">
                                <input type="text" required name="lead_status" value="" class="form-control" required
                                    placeholder="Lead Status">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label ">Leads Type</label>
                            <div class="col-lg-10">
                                <select name="lead_type" class="form-control m-b">
                                    <option value="">None</option>
                                    <option value="close">Close</option>
                                    <option value="open">Open</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button class="btn btn-primary" type="submit" id="save" onclick="saveStatus(this)"><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
                    <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                </div>
    </form>
</div>



@yield('scripts')
<script>
    $('.m-b').select2({});
</script>
