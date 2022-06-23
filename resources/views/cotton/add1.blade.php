<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Balance Cheking</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::open(['route' => 'purchase_cotton.store']) }}
        <div class="modal-body">
        
            <p><strong>Insuficient Stock Balance From {{$centre}}  Collection Centre</strong> . </p><br>
            <p><strong>Do You Want To Add Stock First Before Proceeding </strong> </p><br>
            <p><strong>IF YES Press OK otherwise Press Cancel </strong> .</p><br>
            

            <div class="form-group">
                

                <div class="col-lg-12">
                <input type="hidden" name="from" id="from" value="movement" required class="form-control">
                    <input type="hidden" name="location" id="location" value="{{$source}}" required class="form-control">
                    <input type="hidden" name="purchase_date" id="purchase_date" value="{{$date}}" required class="form-control">
                    <input type="hidden" name="quantity" id="quantity" value="{{$quantity}}" required class="form-control">
                       <input type="hidden" name="reference" id="referece" value="AUTO-{{$date}}" required class="form-control">
                    
                    <input type="hidden" name="supplier_id" id="supplier_id" value="1" required class="form-control">
                    <input type="hidden" name="due_date" id="due_date" value="{{$date}}" required class="form-control">
                    <input type="hidden" name="item_id" id="item_id" value="1" required class="form-control">
                    <input type="hidden" name="price" id="price" value="{{$price}}" required class="form-control">
                    <input type="hidden" name="tax_rate" id="tax_rate" value="0" required class="form-control">
                    <input type="hidden" name="unit" id="unit" value="Kg" required class="form-control">
                    
                </div>
            </div>



        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="savePurchase">OK</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
       {!! Form::close() !!}
    </div>
    
    <script type='text/javascript'>
$(savePurchase1).on("click", function () {
       
    
    let location = document.getElementById("location").value; 
    let purchase_date = document.getElementById("purchase_date").value;
    let quantity = document.getElementById("quantity").value;
    let supplier_id = document.getElementById("supplier_id").value;
    let due_date = document.getElementById("due_date").value;
    let item_id = document.getElementById("item_id").value;
    let price = document.getElementById("price").value;
    let tax_rate = document.getElementById("tax_rate").value;
    let unit = document.getElementById("unit").value;
   
    
             $.ajax({
            type: 'GET',
            url: '{{route("purchase_cotton.store")}}',
            data: {
                'location': location,
                'purchase_date': purchase_date,
                'quantity': quantity,
                'supplier_id': supplier_id,
                'due_date': due_date,
                'item_id': item_id,
                'price': price,
                'tax_rate': tax_rate,
                'unit': unit,
                
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
               // $('#appFormModal').modal('hide');
                 $("#appFormModal").modal('toggle');
                 $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });
});

</script>
</div>