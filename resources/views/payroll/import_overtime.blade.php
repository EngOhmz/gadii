    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">
               
               Import Overtime

<br><br>
<form action="{{ route('overtime.sample') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <button class="btn btn-success">Download Sample</button>
                                        </form>
                   
</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

          
<br><br>
                    <form action="{{ route('overtime.import') }}" method="POST" enctype="multipart/form-data">
                   @csrf
        <div class="modal-body">

     
               <div class="form-group">
  
                <div class="col-lg-12">
                   <input type="file" name="file" class="form-control" id="customFile" required>
                </div>
            </div>
           
<br><br>
 <div class="modal-footer">
            <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Import Overtime</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        </form>
    
</div>

@yield('scripts')
<script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>