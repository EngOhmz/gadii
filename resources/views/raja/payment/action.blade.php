@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">

            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>School Fees Collection</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a
                                    class="nav-link  active show " href="#home2"
                                    data-toggle="tab">Collection of School Fees</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered">
                             <div class="tab-pane active show " id="home2">
                    {{ Form::open(['route' => 'student.store_payment','role'=>'form','enctype'=>'multipart/form-data']) }}
                                                @method('POST')
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Student Details and School Fees Payment </h5>
                                    </div>
                                    <div class="card-body">

                                   <div class="table-responsive" >
                    <table class="table table-striped ">
                       
                        <?php
                          if (!empty( $students)):
                   $dis_fee=App\Models\School\SchoolPayment::where('type','Discount Fees')->where('fee_id',$students->fee_id)->where('student_id',$students->student_id)->where('year',$students->year)->sum('paid');
                        ?>
                         <tr>
                            <th>Full Name</th>
                            <td><strong>{{ $students->student->student_name}}</strong></td>
                        </tr>
                          <tr>
                            <th>School Level</th>
                            <td><strong>{{ $students->student->level}}</strong></td>
                        </tr>
                           <tr>
                            <th>Class</th>
                            <td><strong>{{ $students->student->class}}</strong></td>
                        </tr>
                         <tr>
                            <th>Type</th>
                            <td><strong>{{ $students->student->type}}</strong></td>
                        </tr>
                          <tr>
                            <th>School Fee Price</th>
                            <td><strong>{{ number_format($students->fee,2) }}</strong></td>
                        </tr>
                          
                             <tr>
                            <th>Discount</th>
                            <td><strong>{{ number_format($dis_fee,2) }}</strong></td>
                        </tr>
                             <tr>
                            <th>Paid Amount</th>
                            <td><strong>{{ number_format(($students->fee - $dis_fee) - $students->due_fee,2) }}</strong></td>
                        </tr>
                            <tr>
                            <th>Due Amount</th>
                            <td><strong>{{ number_format($students->due_fee,2) }}</strong></td>
                        </tr>
                        <?php endif; ?>
<input type="hidden" name="payment_id" id="payment_id" value="{{$id}}"  class="form-control ">
<input type="hidden" name="student_id" value="{{$students->student_id}}"  class="form-control ">
                    </table>
                </div>
 <br>  
<hr>

                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                
                                               
                                               
                                        <div class="table-responsive">
                                    <table class="table table-striped" >
                                        <thead>
                                            <tr>
                                                <th>Fee Type</th>
                                                <th> Total Amount</th>
                                                <th> Due Amount</th>
                                                <th>Payment Month/Year</th>
                                                <th class="col-sm-3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                              @if(!empty($details))
                                                   @foreach ($details as $dtls)                                          
                                                <tr class="gradeA even" role="row">
                                                   
                                            <?php

                                         $due=App\Models\School\SchoolPayment::where('type_id',$dtls->type)->where('fee_id',$students->fee_id)->where('student_id',$students->student_id)->where('year',$students->year)->sum('paid');
                                 
                                  if($dtls->name->account_name == 'School Fees'){
                                    $discount=App\Models\School\SchoolPayment::where('type','Discount Fees')->where('fee_id',$students->fee_id)->where('student_id',$students->student_id)->where('year',$students->year)->sum('paid');
                                 }
                                 else{
                                 $discount=0;
                                }
                                $balance=$dtls->amount - $discount;

                                            ?>

                            <td> {{$dtls->name->account_name}}<input type="hidden" name="type[]" value="{{$students->fee_id}}"  class="form-control ">
                            <input type="hidden" name="type_id[]" value="{{$dtls->type}}"  class="form-control type_id "></td>
                                 <td>{{number_format($dtls->amount,2)}}</td>
                                    <td>{{number_format($balance - $due,2)}}</td>

                            <input type="hidden"  value="{{$balance - $due}}"  class="form-control due{{$dtls->order_no}}">
                           <td><input type="hidden" name="year" value="{{$students->year}}"  class="form-control ">{{$students->year}}</td>
                                                                  
                <td>
                @if($balance - $due > 0)
                <input type="number" class="form-control amount" min="1" data-parsley-type="number" name="paid[]" data-category_id="{{$dtls->order_no}}"  placeholder="Enter  price paid by student" >
                 <div class=""> <p class="form-control-static errors{{$dtls->order_no}}" id="errors" style="text-align:center;color:red;"></p>
                 @else
                  <span class="badge badge-success badge-shadow">Payment of Fee Completed</span>
                 @endif
                                
                                
                                  </div>

                                           </td>                                                                     
                                      </tr>
                                      @endforeach
                                    @endif

                        <tr class="gradeA even" role="row">
                                   <td>  Include Transport  &nbsp<input type="radio" name="transport" value="No"  class="type" >No <input type="radio" name="transport" value="Yes"  class="type" > Yes </td>
                                        <td></td><td></td>
                                     <td><br><input required type="hidden"  class="form-control transport" name="transport_duration" placeholder="Enter Number of Months for the payment"><br>
                                            <input required type="hidden"  class="form-control transport" name="transport_start_month" id="datepicker" placeholder="Starting Month"><br></td>
                                   <td>  <input type="hidden"  min="1" data-parsley-type="number"   name="transport_paid" required placeholder="Enter fee price paid by student"  class="form-control transport"></td>
                           </tr>
                              
                                 <tr class="gradeA even" role="row">
                                   <td>  Include Hostel &nbsp<input type="radio" name="hostel" value="No"  class="type_h" >No <input type="radio" name="hostel" value="Yes"  class="type_h" > Yes   </td>
                                <td></td><td></td>
                                    <td><br><input required type="hidden"  class="form-control hostel" name="hostel_duration" placeholder="Enter Number of Months for the payment"><br>
                                            <input required type="hidden"  class="form-control hostel" name="hostel_start_month"  id="datepicker2" placeholder="Starting Month"><br></td>
                                   <td>  <input type="hidden"  min="1" data-parsley-type="number"   name="hostel_paid" required placeholder="Enter fee price paid by student"  class="form-control hostel"></td>
                           </tr>

                                        </div>
                                        </div>
                                        </td>      
                                                               
                                      </tr>
                                   
                                   </tbody>

                                    </table>
                                </div>

 <div class="form-group row"><label class="col-lg-2 col-form-label">Payment Date</label>

                                    <div class="col-lg-4">
                                        <input type="date" name="date" value="{{ isset($data) ? $data->date : date('d/m/y')}}"
                                            class="form-control" required>
                                    </div>

  <label class="col-lg-2 col-form-label">Payment
                                        Method</label>

                                    <div class="col-lg-4">
                                        <select class="form-control m-b" name="payment_method" required>
                                            <option value="">Select
                                            </option>
                                            @if(!empty($payment_method))
                                            @foreach($payment_method as $row)
                                            <option value="{{$row->id}}" @if(isset($data))@if($data->
                                                manager_id == $row->id) selected @endif @endif >From
                                                {{$row->name}}
                                            </option>

                                            @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-2 col-form-label">Reference</label>

                                    <div class="col-lg-4">
                                        <textarea name="reference" 
                                            class="form-control" required></textarea>
                                    </div>

                        <label  class="col-lg-2 col-form-label">Bank/Cash Account</label>

                                                    <div class="col-lg-4">
                                                       <select class="form-control m-b" name="bank_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->account_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
                                                    </div>
                                                </div>

                               
  <br>                                              
 <div class="btn-bottom-toolbar text-right">
                                      <button type="submit"
                                         class="btn btn-sm btn-primary" id="save">Save Details</button>
                                                              
                                    </div>
                                                
                                            
                                            </div>
                                        </div>
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
</section>
<!-- discount Modal -->
<div class="modal fade " id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>

@endsection

@section('scripts')

 <script src="{{url('assets/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
 $(document).ready(function(){
  $("#datepicker,#datepicker2").datepicker({
     format: "mm",
     viewMode: "months", 
     minViewMode: "months",
     autoclose:true
  });   
})
</script>

<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("school.show", ":id") }}';
        url = url.replace(':id', id)

        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }
    </script>


<script>
    $(document).ready(function(){
   

 $(document).on('change', '.type', function(){
var id=$(this).val() ;
console.log(id);
         if($(this).val() == 'Yes') {
          $('.transport').attr("type", "number");;
         $('.transport_month').attr("type", "month");;
        }
   else  {
          $('.transport').attr("type", "hidden");;
          $('.transport_month').attr("type", "hidden");;
        } 
});

 $(document).on('change', '.type_h', function(){
var id=$(this).val() ;
console.log(id);
         if($(this).val() == 'Yes') {
          $('.hostel').attr("type", "number");;
      $('.hostel_month').attr("type", "month");;
        }
   else  {
          $('.hostel').attr("type", "hidden");;
           $('.hostel_month').attr("type", "hidden");;
        } 
});


});
</script>

<script>
$(document).ready(function() {

 
    $(document).on('change', '.amount', function() {
        var id = $(this).val();
        var payment=$('#payment_id').val();
         var sub_category_id = $(this).data('category_id');
             var due= $('.due' + sub_category_id).val();
        $.ajax({
            url: '{{url("school/findFeeAmount")}}',
            type: "GET",
            data: {
                id: id,
                  payment: payment,
                due: due,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
             $('.errors' + sub_category_id).empty();
            $("#save").attr("disabled", false);
             if (data != '') {
           $('.errors' + sub_category_id).append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });


});
</script>


@endsection