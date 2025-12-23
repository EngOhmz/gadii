    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">
  
                New Goal Tracking
                      
</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
              <form id="addClientForm" method="post" action="javascript:void(0)">
                @csrf
        <div class="modal-body">

                        <div class="row">
                        <div class="col-sm-12">
                        
                        <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Subject<span class="text-danger">
                                                            *</span></label>
                                                    <div class="col-lg-10">
                                                        <input type="text" name="subject" class="form-control"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Goal
                                                        Type<span class="text-danger"> *</span></label>
                                                    <div class="col-lg-10">
                                                        <input type="text" name="goal_type" class="form-control"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Target
                                                        Amount<span class="text-danger"> *</span></label>
                                                    <div class="col-lg-10">
                                                        <input type="number" name="target_amount" class="form-control"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Target
                                                        Achievement<span class="text-danger"> *</span></label>
                                                    <div class="col-lg-10">
                                                        <select class="m-b form-control" id="user_id"
                                                            name="achievement_id" required>
                                                            <option value="">Select </option>
                                                            @foreach ($achv as $row)
                                                                <option value="{{ $row->id }}">
                                                                    {{ $row->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                 <input type="hidden" name="user_id" value="{{ $user_id }}">
                                                
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Start
                                                        Date<span class="text-danger"> *</span></label>
                                                    <div class="col-lg-10">
                                                        <input type="date" name="start_date" class="form-control"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">End
                                                        Date<span class="text-danger"> *</span></label>
                                                    <div class="col-lg-10">
                                                        <input type="date" name="end_date" class="form-control"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Description<span
                                                            class="text-danger"> *</span></label>
                                                    <div class="col-lg-10">
                                                        <textarea class="form-control" name="description"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label
                                                      
                                                            <label class="col-lg-2 col-form-label">Assigned To</label>
                                                            <div class="col-lg-8">
                                                                @if (!empty($user))
                                                                    <input type="checkbox" name="select_all"
                                                                        id="example-select-all"> Select All <br>
                                                                    @foreach ($user as $row)
                                                                        <input name="trans_id[]" type="checkbox"
                                                                            class="checks" value="{{ $row->id }}">
                                                                        {{ $row->name }} &nbsp;
                                                                    @endforeach
                                                                @endif

                                                            </div>
                                                        </div>
                                                    
        
</div>
        </div>
        </div>
        
         <input type="hidden" id="category" value="{{$id}}">
        
        <div class="modal-footer ">
             <button class="btn btn-primary"  type="submit" id="save" onclick="saveGoal(this)"><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        </form>
    </div>

@yield('scripts')


    <script>

$("#example-select-all").click(function() {
  $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});

$("input[type=checkbox]").click(function() {
  if (!$(this).prop("checked")) {
    $("#example-select-all").prop("checked", false);
  }
});


</script>




