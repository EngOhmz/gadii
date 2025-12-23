    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">  
                New Project Category
                      
</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
              <form id="addCategoryForm" method="post" action="javascript:void(0)">
                @csrf
        <div class="modal-body">

                                               
                                                <div class="row">
                                                 <div class="col-sm-12 ">

                                                     <div class="form-group row">
                                                                    <label class="col-lg-3 col-form-label">Category Name<span class="required"> *</span></label>
                                                                          <div class="col-lg-8">
                                                                    <input type="text" name="category_name"   class="form-control" required>                                                                               
                                                                </div></div>
                                                              
     

        

        </div></div>

</div>
        <div class="modal-footer ">
             <button class="btn btn-primary"  type="submit" id="save" onclick="saveCategory(this)"><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        </form>
    </div>
