@extends('layouts.master')

@section('content')
<style>
.month-menu {
    background: #ffffff;
    box-shadow: 0 3px 12px 0 rgb(0 0 0 / 15%);
  

    margin-bottom: 0;
    padding-left: 0;
    list-style: none;
}
.month-menu li {
    border-bottom: 1px solid #cfdbe2;
list-style: none;
  font-size: 17px;
}

.month-menu > li > a {
    border-left: 3px solid transparent;
    border-radius: 0;
    border-top: 0;
    color: #444;
  padding: 6px 20px !important;
}

.month-menu> li > a.active {
    background-color: #1797be !important;
 color: #fff;
}


</style>
    <!-- ************ Expense Report List start ************-->

    <div class="row">
        <div class="col-sm-12">
 <div class="card">
  <div class="card-header">
                <h4>Advance Salary</h4>
            </div>
            <form id="form" role="form" enctype="multipart/form-data" action="{{route('advance_salary.store')}}"  method="post" >
                {{csrf_field()}}
                  <div class="card-body">
  <div class="form-group row">
<div class="col-sm-3"></div>
                <label for="" class="control-label"><strong>Year </strong></label>                      
                <div class="col-sm-5">
                 <input type="text" name="year" class="form-control" id="datepicker" value="<?php
                                if (!empty($year)) {
                                    echo $year;
                                }
                                ?>">
                </div>
               <div class="col-sm-3">
                <button type="submit" id="submit" title="Search"
                        class="btn btn-purple">
                    <i class="icon-search4"></i></button>
</div>
</div>
</div>
            </form>
</div>
        </div>
  
        

    </div>
    <div id="advance_salary">
       
        <div class="row">
            <div class="col-md-2 hidden-print"><!-- ************ Expense Report Month Start ************-->
<div class="card">
             <ul class="month-menu active show">
                    <?php
                    foreach ($advance_salary_info as $key => $v_advance_salary):
                        $month_name = date('F', strtotime($year . '-' . $key)); // get full name of month by date query
                        ?>
                        <li class="nav-item">
                            <a class="nav-link @if($current_month == $key) active show @endif" aria-selected="<?php
                            if ($current_month == $key) {
                                echo 'true';
                            } else {
                                echo 'false';
                            }
                            ?>" data-toggle="tab" role="tab" href="#<?php echo $month_name ?>" >
                                <i class="icon-calendar2"></i> {{$month_name}} </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
</div>
            </div><!-- ************ Expense Report Month End ************-->

            <div class="col-md-10"><!-- ************ Expense Report Content Start ************-->
  <div class="card">


<!--aprrove user data-->
@can('approve-payment')
<div class="tab-content pl0">
                    <?php
                    foreach ($advance_salary_info as $key => $v_advance_salary):
                        $month_name = date('F', strtotime($year . '-' . $key)); // get full name of month by date query
                        ?>
                        <div id="<?php echo $month_name ?>" role="tabpanel" class="tab-pane fade <?php
                        if ($current_month == $key) {
                            echo 'active show';
                        }
                        ?>">
      
<?php
$id=0;
?>                      
                                  <div class="card-header header-elements-sm-inline">
<strong><i class="icon-calendar2"></i> &nbsp<?php echo $month_name . ' ' . $year; ?></strong> 
 
      
<div class="header-elements">
               <a href="" class="text-danger pull-right" data-toggle="modal"
               data-placement="top" data-target="#appFormModal"  data-id="{{ $id }}" data-type="advance"   onclick="model({{ $id }},'advance')">
             <i class="icon-plus3 ">  </i> New Advance Salary</a>
          
        
 </div>  
</div>

  <div class="card-body">  
                                <!-- Table -->
                                <div class="table-responsive">
                <table class="table datatable-basic table-striped" id="table-1">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Deduct Month</th>
                                        <th>Request Date</th>
                                        <th>Status</th>
                                        
                                            <th>Action</th>
                                       
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $total_amount = 0;
                                    if (!empty($v_advance_salary)): foreach ($v_advance_salary as $advance_salary) : ?>
                                        <tr>
                                            <td><?php echo $advance_salary->user->name ?></td>
                                            <td><?php echo number_format($advance_salary->advance_amount, 2);
                                                $total_amount += $advance_salary->advance_amount;
                                                ?></td>
                                            <td><?php echo date('Y M', strtotime($advance_salary->deduct_month)) ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($advance_salary->request_date)) ?></td>

                                            <td>
                                               @if ($advance_salary->status == '0') 
                                                    <span class="badge badge-warning badge-shadow">Pending </span>
                                                @elseif ($advance_salary->status == '1') 
                                                    <span class="badge badge-success badge-shadow">Accepted </span>
                                                @elseif ($advance_salary->status == '2') 
                                                   <span class="badge badge-danger badge-shadow">Rejected </span>
                                                @else
                                                  <span class="badge badge-info badge-shadow">Paid </span>
                                                 @endif
                                               </td>
                                            
                                                <td>
                                                  @if ($advance_salary->status == '0' || $advance_salary->status == '1') 
                                                 <div class="form-inline">
                                                  <a class="list-icons-item text-primary"
                                                        title="Edit" data-id="{{ $advance_salary->id  }}" data-type="advance"   onclick="model({{ $advance_salary->id  }},'advance')"
                                                       data-toggle="modal" data-target="#appFormModal"><i
                                                            class="icon-pencil7"></i></a>&nbsp
                                                     @endif
                                                  @if ($advance_salary->status == '0') 
                                                      @can('approve-payment')
                                                    <a href="{{ route('advance.approve',$advance_salary->id)}}" class="list-icons-item text-success" onclick="return confirm('Are you sure you want to Approve?')"><i class="icon-thumbs-up3"></i> Approve</a >   
                                                    <a href="{{ route('advance.reject',$advance_salary->id)}}" class="list-icons-item text-danger" onclick="return confirm('Are you sure you want to Reject?')"><i class="icon-cross3"></i> Reject</a >   
                                                      @endcan                                                                                                 
                                                   @endif
                                                 </div>
                                   
                                                </td>
                                           
                                        </tr>
                                        <?php
                                        $key++;
                                    endforeach;
                                        ?>
                                       <?php endif; ?>
                                     </tbody>
                                   <tfoot>
                                     <tr class="total_amount">
                                            <td colspan="" style="text-align: right;">
                                                <strong>Total Amount : </strong></td>
                                            <td colspan="2" style="padding-left: 8px;">
                                                <strong><?php echo number_format($total_amount, 2); ?></strong>
                                            </td>
                                       <td colspan="3" ></td>
                                        </tr>
                                   
                                    </tfoot>
                                </table>
</div>
    </div>
                      
                        </div>
                    <?php endforeach; ?>
                </div>

<!--normal user data -->
@else


<div class="tab-content pl0">
                    <?php
                    foreach ($user_advance_salary_info as $key => $v_user_advance_salary):
                        $month_name = date('F', strtotime($year . '-' . $key)); // get full name of month by date query
                        ?>
                      <div id="<?php echo $month_name ?>" role="tabpanel" class="tab-pane fade <?php
                        if ($current_month == $key) {
                            echo 'active show';
                        }
                        ?>">
      
<?php
$id=0;
?>                      
     

  <div class="card-header header-elements-sm-inline">

<strong><i class="icon-calendar2"></i> &nbsp<?php echo $month_name . ' ' . $year; ?></strong> 
   <div class="header-elements">
               <a href="" class="text-danger pull-right" data-toggle="modal"
               data-placement="top" data-target="#appFormModal"  data-id="{{ $id }}" data-type="advance"   onclick="model({{ $id }},'advance')">
             <i class="icon-plus3 ">  </i> Request Advance Salary</a>
          
        
 </div>  
</div>

  <div class="card-body">  
                                <!-- Table -->
                                <div class="table-responsive">
                <table class="table datatable-basic table-striped" id="table-1">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Deduct Month</th>
                                        <th>Request Date</th>
                                        <th>Status</th>
                                        
                                            <th>Action</th>
                                       
                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                    $user_total_amount = 0;
                                    if (!empty($v_user_advance_salary)): foreach ($v_user_advance_salary as $user_advance_salary) : ?>
                                        <tr>
                                            <td><?php echo $user_advance_salary->user->name ?></td>
                                            <td><?php echo number_format($user_advance_salary->advance_amount, 2);
                                                $user_total_amount += $user_advance_salary->advance_amount;
                                                ?></td>
                                            <td><?php echo date('Y M', strtotime($user_advance_salary->deduct_month)) ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($user_advance_salary->request_date)) ?></td>

                                            <td>
                                               @if ($user_advance_salary->status == '0') 
                                                    <span class="badge badge-warning badge-shadow">Pending </span>
                                                @elseif ($user_advance_salary->status == '1') 
                                                    <span class="badge badge-success badge-shadow">Accepted </span>
                                                @elseif ($user_advance_salary->status == '2') 
                                                   <span class="badge badge-danger badge-shadow">Rejected </span>
                                                @else
                                                  <span class="badge badge-info badge-shadow">Paid </span>
                                                 @endif
                                               </td>
                                            
                                                <td>
                                        <div class="form-inline">
                                                  @if ($user_advance_salary->status == '0') 
                                                        <a class="list-icons-item text-primary"
                                                        title="Edit" data-id="{{ $advance_salary->id  }}" data-type="advance"   onclick="model({{ $user_advance_salary->id  }},'advance')"
                                                       data-toggle="modal" data-target="#appFormModal"><i
                                                            class="icon-pencil7"></i></a>&nbsp
                                                      @can('approve-payment')
                                       <a href="{{ route('advance.approve',$advance_salary->id)}}" class="list-icons-item text-success" onclick="return confirm('Are you sure you want to Approve?')"><i class="icon-thumbs-up3"></i> Approve</a >   
                                                    <a href="{{ route('advance.reject',$advance_salary->id)}}" class="list-icons-item text-danger" onclick="return confirm('Are you sure you want to Reject?')"><i class="icon-cross3"></i> Reject</a >
                                                      @endcan                                                                                                 
                                                 @endif

                                   </div>
                                                </td>
                                           
                                        </tr>
                                        <?php
                                        $key++;
                                        endforeach;
                                        ?>
                                       <?php endif; ?>
                                     </tbody>
                                   <tfoot>
                                     <tr class="total_amount">
                                            <td colspan="" style="text-align: right;">
                                                <strong>Total Amount : </strong></td>
                                            <td colspan="2" style="padding-left: 8px;">
                                                <strong><?php echo number_format($user_total_amount, 2); ?></strong>
                                            </td>
                                       <td colspan="3" ></td>
                                        </tr>
                                   
                                    </tfoot>
                                </table>
</div>
    </div>
                      
                        </div>
                    <?php endforeach; ?>
                </div>

@endcan






            </div><!-- ************ Expense Report Content Start ************-->
        </div><!-- ************ Expense Report List End ************-->
    </div>
</div></div>

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>

@endsection



@section('scripts')
<script src="{{ asset('assets2/js/bootstrap-datepicker.min.js') }}"></script>
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [3]}
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
 $(document).ready(function(){
  $("#datepicker").datepicker({
     format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true
  });   
})

 </script>
 
 <script type="text/javascript">
 $(document).ready(function () {
    $('.month-menu li a').click(function(e) {
        console.log(1);
        

        $('.month-menu li a.active').removeClass('active');
        var $parent = $(this).parent();
        $parent.addClass('active');
        
        
        
        e.preventDefault();
    });
});

 
 </script>

<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("salary_template.show", ":id") }}';
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
$(document).ready(function() {

  

    $(document).on('change', '.amount', function() {
        var id = $(this).val();
        var user=$('#user_id').val();
        $.ajax({
            url: '{{url("payroll/findAmount")}}',
            type: "GET",
            data: {
                id: id,
                  user: user,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#errors").empty();
            $("#save").attr("disabled", false);
             if (data != '') {
           $("#errors").append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });



$(document).on('change', '.monthyear', function() {
        var id = $(this).val();
    var user=$('#user_id').val();
        $.ajax({
            url: '{{url("payroll/findMonth")}}',
            type: "GET",
            data: {
                id: id,
                  user: user,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#month_errors").empty();
            $("#save").attr("disabled", false);
             if (data != '') {
           $("#month_errors").append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });
  });


});
</script>

<script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>
@endsection