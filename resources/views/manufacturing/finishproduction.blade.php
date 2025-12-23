<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">
Finish Production </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

 {!! Form::open(['route' => ['work_order.finish',$id], 'method' => 'POST']) !!}
                                                                 @csrf
                                                                 @method('PUT')
    <div class="modal-body">
            
            <div class="form-group">
                <input type="hidden" name="workID" value="{{$id}}" class="form-control workID">
                    
                     <input type="hidden" name="withdraw_quantity" value="{{$purchase->due_quantity}}"  class="form-control  withdraw_check">
                     
                <label class="col-lg-6 col-form-label">Incomplete</label>

                <div class="col-lg-12">
                     <div class="table-responsive">
                      <table class="table table-bordered" id="cart">
                      
                      <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity(Incomplete)</th>
                            </tr>
                       </thead>
                       
                       <tbody>
                       
                       @if(!@empty($wrk_items))
                            @foreach ($wrk_items as $row)
                            <tr class="gradeA even" role="row">
                                <td>
                                 {{$row->item_name }}
                                 <input type="hidden" name="item_idinc[]" value="{{$row->items_id}}" class="form-control">
                                </td>
                                
                                <td>
                                 <input type="number" name="quantity_inc[]"
                                    class="form-control" value="{{$row->rem_quantity}}"
                                     id="quantityc" readonly
                                     />
                                </td> 
                                
                            </tr>    
                            @endforeach
                            
                        @endif


                        </tbody>
                                                    
                      </table>
                      </div>
                    
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-6 col-form-label">Reject</label>

                <div class="col-lg-12">
                     <div class="table-responsive">
                      <table class="table table-bordered" id="cart">
                      
                      <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity(Reject)</th>
                            </tr>
                       </thead>
                       
                       <tbody>
                        
                        
                        @if(!@empty($inv_items))
                            @foreach ($inv_items as $row)
                            <tr class="gradeA even" role="row">
                                <td>
                                 {{$row->item_name }}
                                 <input type="hidden" name="item_id[]" value="{{$row->items_id}}" class="form-control item_id{{$row->id}}_edit">
                                </td>
                                
                                <td>
                                 <input type="number" name="quantity_rj[]" step="any"
                                    class="form-control  item_check" data-category_id="{{$row->id}}_edit"
                                    placeholder="Rejected quantity" id="quantityrj"
                                     />
                                     <div class=""> <p class="form-control-static errors23{{$row->id}}_edit" id="errors" style="text-align:center;color:red;"></p> </div>
                                </td> 
                                
                            </tr>    
                            @endforeach
                            
                        @endif


                        </tbody>
                                                    
                      </table>
                      </div>
                    
                </div>
            </div>


   <div class="modal-footer ">
   <button class="btn btn-primary"  type="submit" id="saveProduce"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
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
 
 
      <script>
    $(document).ready(function() {
    
       $(document).on('change', '.item_check', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('category_id');
            var workID= $('.workID').val();
             var item_id= $('.item_id' + sub_category_id).val();;
             var withdraw_check= $('.withdraw_check').val();

    console.log(item_id);
            $.ajax({
                url: '{{url("manufacturing/findInvWrkQuantity")}}',
                type: "GET",
                data: {
                    id: id,
                    item_id: item_id,
                    workID: workID,
                    withdraw_check: withdraw_check,
                },
                dataType: "json",
                success: function(data) {
                  console.log(data);
                 $('.errors23' + sub_category_id).empty();
                $("#saveProduce").attr("disabled", false);
                 if (data != '') {
                $('.errors23' + sub_category_id).append(data);
               $("#saveProduce").attr("disabled", true);
    } else {
      
    }
                
           
                }
    
            });
    
        });
    
    
    
    });
    </script> 
    