@extends('layouts.master')

@section('content')
<style>
.month-menu {
    background: #ffffff;
    box-shadow: 0 3px 12px 0 rgb(0 0 0 / 15%);
    margin-top: 10px !important;

    margin-bottom: 0;
    padding-left: 0;
    list-style: none;
}
.month-menu li {
    border-bottom: 1px solid #cfdbe2;
list-style: none;
  font-size: 13px;
}

.month-menu > li > a {
    border-left: 3px solid transparent;
    border-radius: 0;
    border-top: 0;
    color: #444;
  padding: 6px 10px !important;
}

.month-menu> li.active {
    background-color: #1797be !important;

}

.month-menu >li.active>a {
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
                    <i class="fa fa-search"></i></button>
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
                        <li class="<?php
                        if ($current_month == $key) {
                            echo 'active';
                        }
                        ?>">
                            <a aria-expanded="<?php
                            if ($current_month == $key) {
                                echo 'true';
                            } else {
                                echo 'false';
                            }
                            ?>" data-toggle="tab" href="#<?php echo $month_name ?>">
                                <i class="fa fa-calendar fa-fw"></i> <?php echo $month_name; ?> </a>
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
                        <div id="<?php echo $month_name ?>" class="tab-pane <?php
                        if ($current_month == $key) {
                            echo 'active';
                        }
                        ?>">
      
<?php
$id=0;
?>                      
                               <div class="card-header">
<strong><i class="fa fa-calendar"></i> &nbsp<?php echo $month_name . ' ' . $year; ?></strong> 
      <div class="col-sm-10 mt">   
      
               <a href="" class="text-danger pull-right" data-toggle="modal"
               data-placement="top" data-target="#appFormModal"  data-id="{{ $id }}" data-type="advance"   onclick="model({{ $id }},'advance')">
            <span class="fa fa-plus "> New Advance Salary
            </span></a>
          
        </div>
   
</div>

  <div class="card-body">  
                                <!-- Table -->
                                <div class="table-responsive">
                <table class="table table-striped "id="table-1">
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
                                                  @if ($advance_salary->status == '0') 
                                                    <a href=""
                                                       class="btn btn-info btn-xs" title="View" data-id="{{ $advance_salary->id  }}" data-type="advance"   onclick="model({{ $advance_salary->id  }},'advance')"
                                                       data-toggle="modal" data-target="#appFormModal"> <i  class="fa fa-edit"></i></a> 
                                                      @can('approve-payment')
                                                    <a href="{{ route('advance.approve',$advance_salary->id)}}" class="btn btn-success mr" onclick="return confirm('Are you sure you want to Approve?')"><i class="fa fa-thumbs-up"></i> Approve</a >   
                                                    <a href="{{ route('advance.reject',$advance_salary->id)}}" class="btn btn-danger mr" nclick="return confirm('Are you sure you want to Reject?')"><i class="fa fa-times"></i> Reject</a >   
                                                      @endcan                                                                                                 
                                                 @endif

                                   
                                                </td>
                                           
                                        </tr>
                                        <?php
                                        $key++;
                                    endforeach;
                                        ?>
                                     <tr class="total_amount">
                                            <td colspan="" style="text-align: right;">
                                                <strong>Total Amount : </strong></td>
                                            <td colspan="2" style="padding-left: 8px;">
                                                <strong><?php echo number_format($total_amount, 2); ?></strong>
                                            </td>
                                        </tr>
                                    <?php else : ?>
                                        <td colspan="6">
                                            <strong>Nothing to Display</strong>
                                        </td>
                                    <?php endif; ?>
                                    </tbody>
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
                        <div id="<?php echo $month_name ?>" class="tab-pane <?php
                        if ($current_month == $key) {
                            echo 'active';
                        }
                        ?>">
      
<?php
$id=0;
?>                      
                               <div class="card-header">
<strong><i class="fa fa-calendar"></i> &nbsp<?php echo $month_name . ' ' . $year; ?></strong> 
      <div class="col-sm-10 mt">   
      
               <a href="" class="text-danger pull-right" data-toggle="modal"
               data-placement="top" data-target="#appFormModal"  data-id="{{ $id }}" data-type="advance"   onclick="model({{ $id }},'advance')">
            <span class="fa fa-plus "> Request Advance Salary
            </span></a>
          
        </div>
   
</div>

  <div class="card-body">  
                                <!-- Table -->
                                <div class="table-responsive">
                <table class="table table-striped "id="table-1">
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
                                                  @if ($user_advance_salary->status == '0') 
                                                    <a href=""
                                                       class="btn btn-info btn-xs" title="View" data-id="{{ $user_advance_salary->id  }}" data-type="advance"   onclick="model({{ $user_advance_salary->id  }},'advance')"
                                                       data-toggle="modal" data-target="#appFormModal"> <i  class="fa fa-edit"></i></a> 
                                                      @can('approve-payment')
                                                    <a href="{{ route('advance.approve',$user_advance_salary->id)}}" class="btn btn-success mr" onclick="return confirm('Are you sure you want to Approve?')"><i class="fa fa-thumbs-up"></i> Approve</a >   
                                                    <a href="{{ route('advance.reject',$user_advance_salary->id)}}" class="btn btn-danger mr" nclick="return confirm('Are you sure you want to Reject?')"><i class="fa fa-times"></i> Reject</a >   
                                                      @endcan                                                                                                 
                                                 @endif

                                   
                                                </td>
                                           
                                        </tr>
                                        <?php
                                        $key++;
                                    endforeach;
                                        ?>
                                     <tr class="total_amount">
                                            <td colspan="" style="text-align: right;">
                                                <strong>Total Amount : </strong></td>
                                            <td colspan="2" style="padding-left: 8px;">
                                                <strong><?php echo number_format($user_total_amount, 2); ?></strong>
                                            </td>
                                        </tr>
                                    <?php else : ?>
                                        <td colspan="6">
                                            <strong>Nothing to Display</strong>
                                        </td>
                                    <?php endif; ?>
                                    </tbody>
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
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>
</div>
</div>
@endsection



@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
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

@endsection