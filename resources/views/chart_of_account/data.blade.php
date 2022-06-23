@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Chart of Accounts</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Chart of Accounts
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                               <div class="table-responsive">
                    <table id="data-table" class="table table-striped table-condensed table-hover">
                                       <thead>
                                            <tr>
                                                <th>Account Type</th>
                                                <th>Account Class</th>
                                                 <th>Account Group</th>
                                                <th>Code Name</th>
                                                    <th>Account Code</th>
                                              
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($data))
                                            @foreach ($data as $account_type)
                                                 <?php  $e=0;   ?>
                                            <tr class="gradeA even" role="row">
                                                 <td colspan="5" style="text-align:"><b>{{ $loop->iteration }} . {{ $account_type->type  }} </b></td>
                                                      
                    </tr>
     @foreach($account_type->classAccount as $account_class)
<?php    $e++ ;  ?>
                          <tr>
                          <td></td>
                        <td  style="text-align: "><b>{{ $e }} . {{ $account_class->class_name  }}</b></td>
                        <td></td>
                         <td></td>
                        <td></td>
                    </tr>

   <?php     
$d=0;
?>
               
  @foreach($account_class->groupAccount  as $group)
                             <?php $d++ ; 
                      //  $values = explode(",",  $account_group->holidays);


?>
                               
                        
                         <tr>
                          <td></td>
                           <td></td>
                           
                          <td style="text-align:r"><b>{{ $d }} . {{ $group->name   }}</b></td>
                           <td></td>
                           <td></td>
                   
                      
                 
              
                   </tr>
       
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td></td>
  <td></td>
  <td>{{$account_code->account_name }}</td>
 <td style="text-align:center">{{$account_code->account_codes  }}</td>
</tr>
   @endforeach              
  @endforeach
  @endforeach
   @endforeach
 @endif
                                        </tbody>
                                    </table>
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



@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },

            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection