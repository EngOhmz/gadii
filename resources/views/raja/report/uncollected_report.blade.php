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
                   { extend: 'copy', footer: true, messageTop: '    Uncollected School Fees Report.' },
                    
                    { extend: 'excel', footer: true, messageTop: '   Uncollected School Fees Report.' },
                    
                    { extend: 'csv', footer: true, messageTop: '     Uncollected School Fees Report.' },
                    
                   
                    { extend: 'print', footer: true, messageTop: '<center><b>Uncollected School Fees Report.</b></center>' }
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
                        <h4>Uncollected School Fees Report</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Uncollected School Fees
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>


        <div class="panel-heading">
            <h6 class="panel-title">
    
                @if(!empty($class))
                {{ strtoupper($class) }}  Uncollected School Fees Report for the Year {{$year}}</b>
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
                    <label class="">Year</label>
                    <input type="text" name="year" class="form-control" id="datepicker"  required  value="{{ isset($year) ? $year : date('Y')}}">                
                </div>

 <div class="col-md-12">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                         @if(!empty($class))
                     <a class="btn btn-primary" href="{{ route('class_report',['class'=>isset($class)? $class : '','year'=>isset($year)? $year : '' ,'type'=>'print_pdf']) }}" title=""> Download PDF </a>
                        
                        @endif

                </div>  

  
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br> <br>
@if(!empty($class))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

<?php
$total_amount=0;
$total_discount=0;
$total_due=0;

?>


    
                   <table class="table table-striped"  id="example">
                        <thead>
                        <tr>
                           
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 38.1094px;">#</th>
                                               <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 168.1094px;">Name</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Fee Price</th>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Discount</th>
                                        
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Due Amount</th>
                                                
                      
                        </tr>
                        </thead>
                        <tbody>


                        @foreach($data as $row)
                        
                            <tr>
                    <td>{{ $loop->iteration }}</td>
                      <td>{{$row->student_name}} </td>
                        <td>{{number_format($row->fee,2)}} </td>
                        <td>{{number_format($row->discount,2)}} </td>
                          <td>{{number_format($row->due_fee,2)}} </td>
                                                  
                                                                                          
                            </tr>
                        
                        <?php
$total_amount+=$row->fee;
$total_discount+=$row->discount;
$total_due+=$row->due_fee;
?>
                        @endforeach

                 
                        </tbody>
                        <tfoot>
 <tr>
                                
                      <td></td><td>Total</td>
                     <td>{{number_format($total_amount,2)}}</td>
                       <td>{{number_format($total_discount,2)}}</td>
                     <td>{{number_format($total_due,2)}}</td>                     
                       
                                                                        
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