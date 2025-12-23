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
                <label class="col-lg-6 col-form-label">Finish Goods Quantity</label>

                <div class="col-lg-12">
                    <input type="hidden" name="workID" value="{{$id}}" class="form-control workID">
                    
                     <input type="number" name="withdraw_quantity" placeholder="Quantity to Be Produced" min="1" class="form-control  withdraw_check" required>
                    
                </div>
            </div>
            
            <div class="form-group row"> <div class="col-lg-10"> <p class="form-control-static errors2" id="errors" style="text-align:center;color:red;"></p> </div>  </div>
            
            
        <!--    <div class="form-group">
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
                       
                       @if(!@empty($inv_items))
                            @foreach ($inv_items as $row)
                            <tr class="gradeA even" role="row">
                                <td>
                                 {{$row->item_name }}
                                 <input type="hidden" name="item_id" value="{{$row->items_id}}" class="form-control item_id{{$row->id}}_edit">
                                </td>
                                
                                <td>
                                 <input type="number" name="quantity_inc[]"
                                    class="form-control  item_check" data-category_id="{{$row->id}}_edit"
                                    placeholder="Incomplete quantity" id="quantityc"
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
                                </td>
                                
                                <td>>
                                 <input type="number" name="quantity_rj[]"
                                   class="form-control" 
                                    placeholder="Rejected quantity" id="quantityrj"
                                     />
                                </td> 
                                
                            </tr>    
                            @endforeach
                            
                        @endif


                        </tbody>
                                                    
                      </table>
                      </div>
                    
                </div>
            </div>  -->


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
    
       $(document).on('change', '.withdraw_check', function() {
            var id = $(this).val();
             var workID= $('.workID').val();

    console.log(id);
            $.ajax({
                url: '{{url("manufacturing/findWrkQuantity")}}',
                type: "GET",
                data: {
                    id: id,
                    workID: workID,
                },
                dataType: "json",
                success: function(data) {
                  console.log(data);
                 $('.errors2').empty();
                $("#saveProduce").attr("disabled", false);
                 if (data != '') {
                $('.errors2').append(data);
               $("#saveProduce").attr("disabled", true);
    } else {
      
    }
                
           
                }
    
            });
    
        });
    
    
    
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
    