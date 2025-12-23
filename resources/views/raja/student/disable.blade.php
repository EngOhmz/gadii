
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="formModal" >Disable {{$data->student_name}}</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

<br>
    
 <form id="form" role="form" enctype="multipart/form-data" action="{{route('student.disable')}}"  method="post" >   
@csrf

<div class="modal-body">

  <div class="form-group row">
                <label class="col-lg-2 col-form-label">Reason</label>

                <div class="col-lg-8">
                     <textarea name="reason" rows="4" class="form-control" id="field-1"
                          placeholder="Enter Your Reason"></textarea>
                    
                </div>
            </div>
          
                    <input type="hidden" name="id" value="{{$id}}" required class="form-control">
         
</div>
         <div class="modal-footer">
            <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        </form>
      
    </div>
