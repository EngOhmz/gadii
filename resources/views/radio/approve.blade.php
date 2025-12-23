<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Do List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              <form id="addAssignForm" role="form" enctype="multipart/form-data" action="{{route('radio.approve')}}"  method="post" >
            @csrf
            
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            
                                            <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                        class="fas fa-plus"> </i> Add item  </button><br>
                                                        
                                                         <hr>

      <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                  <thead>
                                                                <tr>
                                                                    <th>Do List</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                 
               
              </div>
</div>
                                                    </div>
                                                    
                                                      <input type="hidden" name="id"
                                                class="form-control list"
                                                value="{{ $id}}" />


        </div>
        <div class="modal-footer bg-whitesmoke br">
         <button class="btn btn-primary"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>


       </form>

            </div>
        </div>
        
        
        
        @yield('scripts')


 <script>
        $(document).ready(function() {

        var i = 0;

           $('.add').on("click", function(e) {
               
                i++;
                
                var html = '';
                html += '<tr class="line_transmission">';
                html +='<td><textarea name="due_list[]" class="form-control tracking" data-sub_category_id="' +i + '" required /></textarea></td>';
                html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td></tr>';
                    
                 $('#cart > tbody').append(html);
                 
            });
            
             $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();

    });


        });
        
        </script>



  
</script>