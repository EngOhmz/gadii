<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form class="addItemForm">
             {{ csrf_field() }}
             
          

        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

      <div class="form-group row"><label class="col-lg-2 col-form-label">Item Type</label>
                                                   <div class="col-lg-10">
                                                   <select class="form-control type m-m" name="type"  required>
                                                <option value="">Select</option>
                                                
                                                 @can('view-items')
                                                    <option value="1">Inventory</option>
                                                        @endcan
                                                        
                                                         @can('view-restaurant-items')
                                                        <option value="Drinks">Drinks</option>
                                                        <option value="Kitchen">Kitchen</option>
                                                         @endcan
                                                         
                                                   </select>
                                                          
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Item Name</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="name" id="name"
                                                            class="form-control name" required>
                                                    </div>
                                                </div>
                                                
                                                 <div class="">
                                                                <p class="form-control-static errors2" id="errors"
                                                                    style="text-align:center;color:red;"></p>
                                                            </div>
                                               
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Cost Price</label>

                                                    <div class="col-lg-10">
                                                        <input type="number" name="cost_price" id="cost_price" value=""
                                                            class="form-control cost_price" required>
                                                    </div>
                                                </div>
                                                
                                    <div class="form-group row sales_p" style="display:none;">
                                    <label class="col-lg-2 col-form-label"> Sales Price</label>

                                                    <div class="col-lg-10">
                                                        <input type="number" name="sales_price" id="sales_price"
                                                            value=""
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                 <div class="form-group row unit_p" style="display:none;"><label
                                                        class="col-lg-2 col-form-label"> Unit Price</label>

                                                    <div class="col-lg-10">
                                                        <input type="number" name="unit_price"
                                                            value=""
                                                            class="form-control">
                                                    </div>
                                                </div>

                                 <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Tax Rate</label>

                                                    <div class="col-lg-10">
                                                        <select name="tax_rate" class="form-control m-m item_tax" required>
                                                                    <option value="0">Select Tax Rate</option>
                                                                    <option value="0">No tax</option>
                                                                    <option value="0.18">18%</option>
                                                                </select>
                                                    </div>
                                                </div>
                                                
                                                 <div class="form-group row category" style="display:none;"><label
                                                        class="col-lg-2 col-form-label"> Category</label>

                                                    <div class="col-lg-10">
                                                        <select class="form-control m-m" name="category_id"  id="location" >
                                                                <option value="">Select Category</option>
                                                                @if (!empty($category))
                                                                    @foreach ($category as $loc)
                                                                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                    </div>
                                                </div>
                                                
                                                
                                                 <div class="form-group row size" style="display:none;">
                                                 <label class="col-lg-2 col-form-label">Size</label>
                                                        <div class="col-lg-10">
                                                            <select class="form-control m-m" name="size" id="size1" >
                                                                <option value="">Select Size</option>
                                                                @if (!empty($size))
                                                                    @foreach ($size as $s)
                                                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                    </div>
                                                </div>

                                         <div class="form-group row color" style="display:none;"> 
                                         <label class="col-lg-2 col-form-label">Color</label>
                                                        <div class="col-lg-10">
                                                            <select class="form-control m-m" name="color" id="color1" >
                                                                <option value="">Select Color</option>
                                                                @if (!empty($color))
                                                                    @foreach ($color as $c)
                                                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                    </div>
                                                </div>
                                                   
                                         <div class="form-group row bott" style="display:none;"><label
                                                    class="col-lg-2 col-form-label"> No of Bottles</label>

                                                <div class="col-lg-10">
                                                    <input type="number" name="bottle"
                                                        value=""
                                                        class="form-control">
                                                </div>
                                            </div>
                                     
                                                
                                              
                                                
                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Unit</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="unit" id="unit"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                   <div class="form-group row">
                                        <label class="col-form-label col-lg-2">Desription</label>
                                        <div class="col-lg-10">
                                            <textarea name="description" id="description"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>


  <input type="hidden" value="{{ isset($id) ? $id: ''}}" id="select_id" class="form-control">
                 
               
              </div>
</div>
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
         <button class="btn btn-primary edit_form"  type="submit" id="save2" data-dismiss="modal"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>


       {!! Form::close() !!}

            </div>
        </div>

 @yield('scripts')


<script>
        $(document).ready(function(){
            /*
                         * Multiple drop down select
                         */
            $('.m-m').select2({dropdownParent: $('#appFormModal'), });



        });
    </script>
    
    
    <script>
$(document).ready(function() {

    var msg='The Item already exists. Please Create another one.';

    $(document).on('change', '.name', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("pos/purchases/findItem")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $('.errors2').empty();
            $('.edit_form').attr("disabled", false);
             if (data != '') {
          $('.errors2').append(msg);
            $('.edit_form').attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });

});
</script>


<script>
$(document).ready(function() {

    $(document).on('change', '.type', function() {
        var id = $(this).val();
  console.log(id);

 if (id == 'Drinks'){
 $('.sales_p').hide();
 $('.unit_p').show();
 $('.bott').show(); 
 $('.category').hide();
 $('.color').hide();
 $('.size').hide();
   
}


else if (id == '1'){
$('.unit_p').hide();
$('.bott').hide(); 
$('.sales_p').show();
$('.category').show(); 
$('.color').show(); 
$('.size').show(); 

}

else{
 $('.sales_p').hide();  
 $('.unit_p').hide();
 $('.bott').hide(); 
 $('.category').hide();
 $('.color').hide();
 $('.size').hide();

}
     

    });
    
    
    
    


});

</script>



