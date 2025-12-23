@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
             
                            
                                 

                                <div class="bootstrap-growl alert alert-success gl" style="display:none; position:absolute;margin:0px;z-index:9999; top:20px;width:250px;right:20px" >
                                
                                   <a class="close" data-dismiss="alert" href="#">&times;</a>
                                                Created Successfully.
                                   </div>
                                   
                                  

                <div class="card">
                   <div class="card-header header-elements-sm-inline">
                        <h4>Chart of Accounts</h4>
                         <div class="header-elements">                           
                        
                       
                <a href="{{route('addShortCut.index')}}" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown">
                   <i class="icon-plus-circle2"></i>
                    <span class="d-none d-lg-inline-block ml-2"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-150">
                    
                   <div class="dropdown-content-body p-2">
                        <ul class="media-list">
                         @can('view-class_account')
                        <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" value="" onclick="model('2','class')"data-target="#appFormModal" href="appFormModal">Add Class Account </a>
                        </li>
                        @endcan
                        @can('view-group_account')
                        <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" value="" onclick="model('2','group')"data-target="#appFormModal" href="appFormModal">Add Group Account </a>
                        </li>
                        @endcan
                        @can('view-account_codes')
                        <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" value="" onclick="model('2','codes')"data-target="#appFormModal" href="appFormModal">Add  Account Codes </a>
                        </li>
                        @endcan
                    
                        </ul>
                    </div>

                    
                </div>
           
                    

   </div>
                    </div>
                    <div class="card-body">
                       
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
     @foreach($account_type->classAccount->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_class)
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
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group)
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
       
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code)
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

<div class="modal fade" data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">

        </div>
    </div>



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

 <script type="text/javascript">
        function model(id, type) {

            $.ajax({
                type: 'GET',
                url: '{{ url('gl_setup/glModal') }}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('#appFormModal > .modal-dialog').html(data);
                },
                error: function(error) {
                    $('#appFormModal').modal('toggle');

                }
            });

        }



    </script>
    
    
     <script>
        $(document).ready(function() {

            $(document).on('click', '.add_class', function(e) {
                e.preventDefault();
                console.log(1);
                $.ajax({
                type: 'GET',
                url: '{{ url('gl_setup/save_class') }}',
                data: $('.addClassForm').serialize(),
                dataType: "json",
                success: function(response) {
                    window.location ='{{ url('gl_setup/chart_of_account')}}';
                      $('.gl').show();


                }
            });
                
                
            });
            
            
        
         $(document).on('click', '.add_group', function(e) {
            e.preventDefault();
            console.log(1);
            $.ajax({
            type: 'GET',
            url: '{{ url('gl_setup/save_group') }}',
            data: $('.addGroupForm').serialize(),
            dataType: "json",
            success: function(response) {
                console.log(response);

                window.location ='{{ url('gl_setup/chart_of_account')}}';
                    $('.gl').show();


            }
        });
            
            
        });
        
        
        $(document).on('click', '.add_codes', function(e) {
            e.preventDefault();
            console.log(1);
            $.ajax({
            type: 'GET',
            url: '{{ url('gl_setup/save_codes') }}',
            data: $('.addCodesForm').serialize(),
            dataType: "json",
            success: function(response) {
                console.log(response);

                window.location ='{{ url('gl_setup/chart_of_account')}}';
                   $('.gl').show();


            }
        });
            
            
        });


        });
    </script>

@endsection