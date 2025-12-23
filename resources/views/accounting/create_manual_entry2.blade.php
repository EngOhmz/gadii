@extends('layouts.master')
@push('plugin-styles')
 <style>
 .body > .line_items{
     border:1px solid #ddd;
 }
 </style>

@endpush

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Journal Entry</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                           
                            <li class="nav-item">
                                <a class="nav-link " id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Journal Entry</a>
                            </li>
                         

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            
                            <div class="tab-pane active show" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        <h5>Create Journal Entry</h5>
                                     
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            
                                                {{ Form::open(['url' => url('accounting/manual_entry/store')]) }}
                                                @method('POST')
                                            

                                              
                                        
                                           <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date <span class="required"> * </span> </label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="date" required {{Auth::user()->can('edit-date') ? '' : ''}}
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->date : date("Y-m-d")}}"
                                                           
                                                            class="form-control date-picker">
                                                    </div>
                                                </div>
                                               
                                        
                                                 <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Branch</label>
                                                   <div class="col-lg-8">
                                                    <select class="form-control m-b" name="branch_id" id="branch_id" >
                                                    <option value="" selected>Select Branch</option>
                                                    @if(isset($branch))
                                                    @foreach($branch as $row)
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                    </div>
                                                </div>
                                              
                                                  


                                            
                                                
                                                <hr>
                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> </i> Add item</button><br>
                                             
                                             <div class=""> <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p>   </div>
                        
                                              <br>
                                              
                                       <div class="row">
                                                    <div class="table-responsive">
                                                     
                                                     
                                                   
                                                    <div id="cart">
                                                    <div class="row body">
                                                     
                                                    </div></div>
                                                    
                                                    <br>
                                                     <div  id="cart1">
                                                     
                                                     <div class="row body1">       
                                              
                                              
                                    <div class="table-responsive">
                                <br><table class="table" id="table1" style="display: @if(!empty($items))  @else none @endif ;">
                                <thead >
              <tr>
                <th>Type </th>
                <th>Account </th>
                 <th>Debit Amount</th>
                 <th>Credit Amount</th>
                <th>Notes</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                                    

</tbody>

<tfoot >
  <tr>
  <td></td>
<td><span class="bold">Total</span> </td>
<td class="total_debit" id="total"></td>
 <td class="total_credit" id="total"></td>
 <td colspan="3"></td>
</tr>
 <tr>
  <td></td>
<td><span class="bold">Difference</span> </td>
<td class="total_diff" colspan="5"></td>
</tr>
                                                       
        </tfoot>

</table>
</div></div></div>
<br>


                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                         @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right save"
                                                            type="submit" id="save">Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                           

                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

    <!-- supplier Modal -->
    <div class="modal fade" data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">

        </div>
    </div>


@endsection

@section('scripts')
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">

    <script src="{{ asset('assets/datatables/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.print.min.js') }}"></script>
    
    
    
</script>


<script>
$(function() {
    let urlcontract = "{{ route('journal.manual') }}";
    $('#itemsDatatable').DataTable({
        processing: true,
        serverSide: false,
        searching: true,
       "dom": 'lBfrtip',
       
       type: 'GET',
                ajax: {
                    url: urlcontract,
                    data: function(d) {
                        d.start_date = $('#date1').val();
                        d.end_date = $('#date2').val();
                        d.from = $('#from').val();
                        d.to = $('#to').val();
                        d.status = $('#status').val();

                    }
                },

        buttons: [{
                        extend: 'copyHtml5',
                        title: 'JOURNAL ENTRY LIST ',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                      
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'JOURNAL ENTRY LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                       
                        footer: true
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'JOURNAL ENTRY LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'JOURNAL ENTRY LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)',
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        title: 'JOURNAL ENTRY LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    }

                ],
        
        
       
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'account_code',
                name: 'account_code'
            },
            {
                data: 'account_name',
                name: 'account_name'
            },
            {
                data: 'debit',
                name: 'debit'
            },
            {
                data: 'credit',
                name: 'credit'
            },
            {
                data: 'date',
                name: 'date'
            },

           
          
      

        ]
    })
});

</script>


<script>
$(document).ready(function() {

    $(document).on('change', '.type', function() {
        var id = $(this).val();
  console.log(id);
var sub_category_id = $(this).data('category_id');

 if (id == 'Supplier'){
      $('.item_supplier' + sub_category_id).show();
   $('.item_client' + sub_category_id).hide(); 
    $('.item_user' + sub_category_id).hide();
     

}

else if(id == 'Client'){
        $('.item_client' + sub_category_id).show();   
     $('.item_supplier' + sub_category_id).hide(); 
      $('.item_user' + sub_category_id).hide();
      
}
else if(id == 'User'){
        $('.item_user' + sub_category_id).show(); 
        $('.item_client' + sub_category_id).hide(); 
     $('.item_supplier' + sub_category_id).hide(); 
      
}



else{
    
  $('.item_client' + sub_category_id).hide();    
     $('.item_supplier' + sub_category_id).hide(); 
      $('.item_user' + sub_category_id).hide();

}


     

    });



});

</script>

<script type="text/javascript">
$(document).ready(function() {


    var count = 0;
    
 

    $('.add').on("click", function(e) {

        count++;
        
         var html = '';
        html +='<div class="col-lg-3 line_items" id="td' + count + '"><br><div><select class="form-control m-b type" id="type' +count + '" name="checked_type[]" data-category_id="' +count + '" required><option value="">Select Type</option><option value="Client">Client</option><option value="Supplier">Supplier</option> <option value="User">Staff</option><option value="Others">Others</option></select></div><br><div class="item_client' + count +'"  id="client" style="display:none;"><select class="form control m-b client_id" id="client_id' + count +'" name="checked_client_id[]"><option value="">Select Client</option> @foreach ($client as $c) <option value="{{$c->id}}" >{{$c->name}}</option>@endforeach</select></div><div class="item_supplier' + count +'"  id="supplier" style="display:none;"><select class="form control m-b supplier_id" id="supplier_id' + count +'" name="checked_supplier_id[]"><option value="">Select Supplier</option> @foreach ($supplier as $m) <option value="{{$m->id}}" >{{$m->name}}</option>@endforeach</select></div><div class="item_user' + count +'"  id="user" style="display:none;"><select class="form control m-b user_id" id="user_id' + count +'" name="checked_user_id[]"><option value="">Select Staff</option> @foreach($user as $u)<option value="{{$u->id}}">{{$u->name}}</option>@endforeach</select></div></div>';
        html +='<div class="col-lg-6 line_items" id="td' + count + '"><br>Account <select class="form control m-b account" id="account_id' + count +'" name="checked_account_id[]" required><option value="">Select Account</option> @foreach($chart_of_accounts as $group => $ch)<optgroup label="{{$group}}"> @foreach($ch as $chart)<option value="{{$chart->id}}">{{$chart->account_name}}</option>@endforeach</optgroup> @endforeach</select><br>';
        html +='<br>Debit Amount <input type="text" name="checked_debit[]" class="form-control item_debit" id="debit' + count +'"  data-category_id="' +count + '" value=""/><br>';
        html +='Credit Amount <input type="text" name="checked_credit[]" class="form-control item_credit" id="credit' + count +'"   data-category_id="' +count + '" value="" /></br>';
        html +='Notes <textarea name="checked_notes[]" placeholder="" class="form-control" rows="2"></textarea></br>';
        html +='<input type="hidden" name="checked_no[]" class="form-control item_check' + count +'" value="' + count +'" placeholder ="total" required /></br></div>';
        html +='<div class="col-lg-3 line_items text-center" id="td' + count + '"><br><a class="list-icons-item text-info add1" title="Check" href="javascript:void(0)" data-button_id="' + count +'"><i class="icon-check2" style="font-size:30px;font-weight:bold;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove" title="Delete" href="javascript:void(0)" data-button_id="' +count + '"><i class="icon-trash" style="font-size:18px;"></i></a><br><div class=""> <p class="form-control-static item_errors'+count+'" id="errors" style="text-align:center;color:red;"></p>   </div></div>';
        
        if ( $('#cart > .body .line_items').length < 3 ) {
        $('#cart > .body').append(html);
        }
        $(".m-b").select2({});
                            
                            
                            
           $('.item_debit').keyup(function(event) {   
// skip for arrow keys
  if(event.which >= 37 && event.which <= 40){
   //event.preventDefault();
  }

  $(this).val(function(index, value) {
      
      value = value.replace(/[^0-9\.]/g, ""); // remove commas from existing input
      return numberWithCommas(value); // add commas back in
      
  });
});                 
          

$('.item_credit').keyup(function(event) {   
// skip for arrow keys
 if(event.which >= 37 && event.which <= 40){
   //event.preventDefault();
  }

  $(this).val(function(index, value) {
      value = value.replace(/[^0-9\.]/g, ""); // remove commas from existing input
      return numberWithCommas(value); // add commas back in
  });
});    


      
    });
    
    
     $(document).on('click', '.remove', function() {
            var button_id = $(this).data('button_id');
               document.querySelectorAll('#td' + button_id).forEach(el => el.remove());
            });
            
    
    
    
 
});
</script>


        <script type="text/javascript">
        $(document).ready(function() {


           $(document).on('click', '.add1', function() {
               
               var button_id = $(this).data('button_id');
                console.log(button_id);
                
                 $('.item_errors'+ button_id).empty();
                
                var a = $('#type'+ button_id + '.type').val();
                var b = $('#account_id'+ button_id + '.account').val();
                var c = $('#debit'+ button_id + '.item_debit').val();
                 var d = $('#credit'+ button_id + '.item_credit').val();
                console.log(c);
                  
                  if( a == '' || c == '' || b == '' || d == '' ){
              $('.item_errors'+ button_id).append('Please Fill the Required Fields.');
              event.preventDefault(); 
         }
         
         else{
                
                $.ajax({
                    data: $('#cart > .body').find('input,select,textarea').serialize(),
                    type: 'GET',
                    url: '{{ url('accounting/add_journal_item') }}',
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                         $('#cart1 > .body1 table').show();
                        $('#cart1 > .body1 table tbody').append(response['list']);
                         $('#cart1 > .body1').append(response['list1']);
                         $(".debit").trigger('change');
                          $(".credit").trigger('change');
                         
                         
               document.querySelectorAll('#td' + button_id).forEach(el => el.remove());
                       

                    }
                })

         }    

            });



       
            
        
                  $(document).on('click', '.edit1', function() {
                 var button_id = $(this).data('button_id');
                  console.log(button_id);
                $.ajax({
                    data: $('#cart1 > .body1 #lst'+ button_id).find('input,select,textarea').serialize(),
                    type: 'GET',
                    url: '{{ url('accounting/journal_modal') }}',
                     cache: false,
                async: true,
                success: function(response) {
                    //alert(data);
                     console.log(444);
                    $('#appFormModal > .modal-dialog').html(response);
                    
                },
                error: function(error) {
                     console.log(111);
                    $('#appFormModal').modal('toggle');

                }

               
                });


            });
            
            
            $(document).on('click', '.edit_item', function(e) {
               e.preventDefault();
               var button_id = $(this).data('button_id');
                console.log(button_id);
                
                
                 $('.item2_errors').empty();
                 
                   var a = $('#typelst'+ button_id + '.type').val();
                var b = $('#account_idlst'+ button_id + '.account').val();
                var c = $('#debitlst'+ button_id + '.item_debit').val();
                 var d = $('#creditlst'+ button_id + '.item_credit').val();
                console.log(c);
                  
                  if( a == '' || c == '' || b == '' || d == '' ){
 
                  
              $('.item2_errors').append('Please Fill the Required Fields.');
              
              return false; 
              
         }
         
         else{
                
                $.ajax({
                   data: $('.addEditForm').serialize(),
                    type: 'GET',
                    url: '{{ url('accounting/add_journal_item') }}',
                    dataType: "json",
                    success: function(response) {
                    console.log(response);
                    $('#cart1 > .body1 table tbody').find('.trlst'+button_id).html(response['list']);
                   $('#cart1 > .body1').find('#lst'+button_id).html(response['list1']);
                   $(".debit").trigger('change');
                    $(".credit").trigger('change');
                          $('#appFormModal').modal().hide();
                         
                         
                       

                    }
                })

         }

            });
        
        
             $(document).on('click', '.rem', function() {
            var button_id = $(this).data('button_id');
            var btn_value = $(this).attr("value");
               document.querySelectorAll('#lst' + button_id).forEach(el => el.remove());
                $(this).closest('tr').remove();
               
            });

           

        });
    </script>




<script type="text/javascript"> 
$(document).on("change", function () {
var total_dr=0;
var total_cr=0;
var sum=0;

 $(".debit").each(function () {
         total_dr += +$(this).val().replace(/,/ig, '');
    $(".total_debit").html(numberWithCommas(total_dr));
        });

  $(".credit").each(function () {
         total_cr += +$(this).val().replace(/,/ig, '');
    $(".total_credit").html(numberWithCommas(total_cr));
        });
        
    sum=total_dr-total_cr; 
    var x=Math.abs(sum);
    $(".total_diff").html(numberWithCommas(x));
    
     
        $('.remove1').on("click", function(e) {  
            
           var button_id = $(this).data('button_id');
               document.querySelectorAll('#lst' + button_id).forEach(el => el.remove());
                $(this).closest('tr').remove();
             
             $(".debit").trigger('change');
            $(".credit").trigger('change');
             $(".total_diff").html(numberWithCommas(x)).change();
        
    });
   

});
</script>

<script>
    $(document).ready(function() {
    
       $(document).on('change', '.item_debit', function() {
        var category_id = $(this).data('category_id');
        
        console.log(category_id);
        $('#credit' + category_id).val(0);
    
        });
        
         $(document).on('change', '.item_credit', function() {
        var category_id = $(this).data('category_id');
        console.log(category_id);
        $('#debit' + category_id).val(0);
    
        });
        
         
        
         $(document).on('click', '.save', function(event) {
         var x=$(".total_diff").html();
         
         $('.errors').empty();
         
         if ( $('#cart1 > .body1 table tbody tr').length == 0 ) {
        event.preventDefault(); 
        $('.errors').append('Please Add Entry.');
         }
         
         else{
         if(x == '0'){
          
             
         }
         
         else{
             event.preventDefault(); 
          $('.errors').append('The Journal must balance (Debits equal to Credits).');
          
         }
         
         } 
    });
    
    
    
    });
    </script>
    
    


<script type="text/javascript">


function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

</script>





@endsection