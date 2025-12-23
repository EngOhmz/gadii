@extends('layouts.master')


@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
  <script>
    jQuery(document).ready(function($) {
      $('#example').DataTable(
        {
        dom: 'Bfrtip',
        buttons: [
                   { extend: 'copy', footer: true, messageTop: '    Student Fee Report.' },
                    
                    { extend: 'excel', footer: true, messageTop: '   Student Fee  Report.' },
                    
                    { extend: 'csv', footer: true, messageTop: '     Student Fee  Report.' },
                    
                    { extend: 'pdf', footer: true, messageTop: '     Student Fee  Report. ' },
                   
                    { extend: 'print', footer: true, messageTop: '<center><b>Student Fee  Report.</b></center>' }
                ],
        }
      );
     
    } );
    </script>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Student Fee Report</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Student Fee Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
@php
$center=App\Models\School\Student::where('id',$name)->first();

@endphp

        <div class="panel-heading">
            <h6 class="panel-title">
    
                @if(!empty($name))
                {{ strtoupper($center->student_name) }}  Fee Report for the Year {{$year}}</b>
                @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                <div class="col-md-4">
                  <label class="">Class</label>
                    {!! Form::select('class',$schools,$class, array('class' => 'm-b class','id'=>'class','placeholder'=>'Select','style'=>'width:100%','required'=>'required')) !!}

                </div>
                <div class="col-md-4">
                   <label class="">Student List</label>
                     @if(!empty($name))
                      <select name="name" class="form-control m-b student" required > 
                          <option value="">Select Student </option>
                            @foreach($list as $row)
                         <option @if(isset($name))   {{  $name == $row->id  ? 'selected' : ''}}  @endif value="{{ $row->id}}">{{$row->student_name}}</option>
                       @endforeach  
                         </select>
                     @else  
                 <select name="name" class="form-control m-b student" required > <option value="">Select Student </option></select>   
                      @endif
                      
                </div>

                <div class="col-md-4">
                    <label class="">Year</label>
                    <input type="text" name="year" class="form-control" id="datepicker"  required  value="{{ isset($year) ? $year : date('Y')}}">                
                </div>

 <div class="col-md-12">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                         @if(!empty($name))
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle "
                                    data-toggle="dropdown">Download Report
                                <span class="caret"></span></button>
                            <div class="dropdown-menu">
                              
                                    <li class="nav-item"><a class="nav-link" href="{{ route('student_report',['name'=>isset($name)? $name : '','year'=>isset($year)? $year : '' ,'type'=>'print_pdf']) }}">
                                       <i   class="icon-file-pdf"></i>  Download PDF </a>                                             
                                   </li>
                                
                                    <li class="nav-item"><a class="nav-link" href="{{route('student_report.excel',['name'=>$name,'year'=>$year])}}">
                                     <i   class="icon-file-excel"></i> Download Excel </a>                                              
                                    </li>
                                
                            </div>
                        </div>
                        @endif

                </div>  

  
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br> <br>
@if(!empty($name))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

<?php
$total_amount=0;
$total_paid=0;

?>


    
                   <table class="table table-striped"  style="width:49.8%;display: inline-table;">
                        <thead>
                        <tr>
                           
                            <th> Particulars</th>
                            <th> Amount</th>
                      
                        </tr>
                        </thead>
                        <tbody>


                        @foreach($data as $key)
                        
                            <tr>
                             
                      <td>{{$key->name->account_name}}</td>                      
                     <td>{{number_format($key->amount,2)}} </td>                                                   
                            </tr>
                        
                        <?php
$total_amount+=$key->amount;

?>
                        @endforeach

                   <tr>
                      <td>Discount Fee</td>
                      
                     <td>{{number_format($student->discount,2)}} </td>
                                                    
                            </tr>
                        </tbody>
                        <tfoot>
 <tr>
                                
                      <td>Total</td>
                     <td>{{number_format($total_amount -$student->discount,2)}}</td>                     
                       
                                                                        
                            </tr>
                        
</tfoot>
                    </table>





<table class="table table-striped"  style="width:49.8%;display: inline-table;">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th> Particulars</th>
                            <th> Amount</th>
                      
                        </tr>
                        </thead>
                        <tbody>


                        @foreach($payments as $key)
                          <?php
                    
                        ?>
                            <tr>
                                <td>{{Carbon\Carbon::parse($key->date)->format('d/m/Y')}}</td>
                      <td>{{$key->type}}</td>
                      
                     <td>{{number_format($key->paid,2)}} </td>
                                                         
                            </tr>
                        
                        <?php
$total_paid+=$key->paid;

?>
                        @endforeach

                  
                        </tbody>
                        <tfoot>
 <tr>
                                <td></td>
                      <td>Total</td>
                     <td>{{number_format($total_paid,2)}}</td>                     
                                                                     
                            </tr>

<tr>
                                <td></td>
                      <td><strong>Balance</strong></td>
                     <td><strong>{{number_format(($total_amount -$student->discount)-$total_paid,2)}}<strong></td>                     
                                                                     
                            </tr>
                        
</tfoot>
                    </table>
                  
                </div>
            </div>
            <!-- /.panel-body -->
             </div>
    @endif              

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



@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [3]}
            ],
           dom: '<"datatable-scroll"t>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>

<script src="{{url('assets/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
 $(document).ready(function(){
  $("#datepicker").datepicker({
     format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true
  });   
})

 </script>


<script>
$(document).ready(function() {

    $(document).on('change', '.class', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("school/findStudent")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $('.student').empty();
                $('.student').append('<option value="">Select Student</option>');
                $.each(response,function(key, value)
                {
                 
                   $('.student').append('<option value=' + value.id+ '>' + value.student_name + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>
@endsection