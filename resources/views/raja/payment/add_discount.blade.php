<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal" >Discount For {{$students->student->student_name}} in the year {{$students->year}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    
<form id="form" role="form" enctype="multipart/form-data" action="{{route('student.store_discount')}}"  method="post" >
    @csrf 

<div class="modal-body">
<p><strong>Make sure you enter valid information</strong> .</p>



            <div class="form-group">
                <label class="col-lg-6 col-form-label">Total Amount</label>

                <div class="col-lg-12">
                    <input type="text"   value="{{ isset($school_fees) ? ($school_fees->amount - $discount) - $amount : ''}}"  class="form-control old" readonly id="old">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-6 col-form-label">Discount</label>
                <div class="col-lg-12">
                    <input type="number" min="0" name="discount[]" id="discount" value="" class="form-control discount" required onkeyup=" calculateDiscount();">
                       <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p> 
                </div>
            </div>

             <div class="form-group">
                <label class="col-lg-6 col-form-label">New Amount</label>
                <div class="col-lg-12">
                    <input type="text" name="amount" value="" class="form-control total" id="total"  readonly>
                </div>
            </div>

        <input type="hidden" name="payment_id" id="payment_id" value="{{$id}}"  class="form-control ">
<input type="hidden" name="student_id" value="{{$students->student_id}}"  class="form-control ">
<input type="hidden" name="year" value="{{$students->year}}"  class="form-control ">
<input type="hidden" name="fee_id[]" value="{{$students->fee_id}}"  class="form-control ">   



        </div>

        <div class="modal-footer bg-whitesmoke br">    
<button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>     
                 </div>

 </form>
        </div>
      

    </div>
</div>


@yield('scripts')
<script>
       $('.datatable-modal').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [3]}
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

<script type="text/javascript">
 function calculateDiscount() {

      $('.discount').on('input',function() {
    var price= parseInt($('.discount').val());
    var qty = parseFloat($('.old').val());
console.log(price);
    $('#total').val((qty -price ? qty - price : 0).toFixed(2));
});

    }

</script>


<script>
$(document).ready(function() {

 
    $(document).on('change', '.discount', function() {
        var price = $(this).val();
        var qty=$('.old').val();
        console.log(price);
    $('.total').val((qty -price ? qty - price : 0).toFixed(2));


    });


});
</script>



<script>
$(document).ready(function() {

 
    $(document).on('change', '.discount', function() {
        var id = $(this).val();
        var total=$('#old').val();
        $.ajax({
            url: '{{url("school/findFeeDiscount")}}',
            type: "GET",
            data: {
                id: id,
                total: total,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
             $('.errors').empty();
            $("#save").attr("disabled", false);
             if (data != '') {
           $('.errors').append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });


});
</script>