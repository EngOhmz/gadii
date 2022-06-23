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
                <h4>Social Security (NSSF)</h4>
            </div>
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}  
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
                    foreach ($nssf_salary_info as $key => $v_nssf_salary):
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
                    foreach ($nssf_salary_info as $key => $v_nssf_salary):
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
     
   
</div>

  <div class="card-body">  
                                <!-- Table -->
                                <div class="table-responsive">
                <table class="table table-striped "id="table-1">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Payment Date</th>
                                        <th>Amount</th>
                                        <th>Employer Contribution</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $total_amount = 0;
                                    if (!empty($v_nssf_salary)): foreach ($v_nssf_salary as $nssf_salary) : ?>
                                        <tr>
                                            <td><?php echo $nssf_salary->user->name ?></td>
                                             <td><?php echo date('d/m/Y', strtotime($nssf_salary->date)) ?></td>
                                            <td><?php echo number_format($nssf_salary->debit, 2);
                                                $total_amount += $nssf_salary->debit;
                                                ?></td>
                                            <td><?php echo number_format($nssf_salary->debit, 2);?></td>
                                           

                                           
                                        </tr>
                                        <?php
                                        $key++;
                                    endforeach;
                                        ?>
                                     <tr class="total_amount">
                                            <td colspan="2" style="text-align: right;">
                                                <strong>Total Amount : </strong></td>
                                            <td colspan="">
                                                <strong><?php echo number_format($total_amount, 2); ?></strong>
                                            </td>
                                 <td colspan="" >
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
                    foreach ($user_nssf_salary_info as $key => $v_user_nssf_salary):
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
     
   
</div>

  <div class="card-body">  
                                <!-- Table -->
                                <div class="table-responsive">
                <table class="table table-striped "id="table-1">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Payment Date</th>
                                        <th>Amount</th>
                                        <th>Employer Contribution</th>
                                       
                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                    $user_total_amount = 0;
                                    if (!empty($v_user_nssf_salary)): foreach ($v_user_nssf_salary as $user_nssf_salary) : ?>
                                                   <tr>
                                            <td><?php echo $user_nssf_salary->user->name ?></td>
                                             <td><?php echo date('d/m/Y', strtotime($user_nssf_salary->date)) ?></td>
                                            <td><?php echo number_format($user_nssf_salary->debit, 2);
                                                $user_total_amount += $user_nssf_salary->debit;
                                                ?></td>
                                            <td><?php echo number_format($user_nssf_salary->debit, 2);?></td>
                                           

                                           
                                        </tr>
                                        <?php
                                        $key++;
                                    endforeach;
                                        ?>
                                     <tr class="total_amount">
                                            <td colspan="2" style="text-align: right;">
                                                <strong>Total Amount : </strong></td>
                                            <td colspan="">
                                                <strong><?php echo number_format($user_total_amount, 2); ?></strong>
                                            </td>
                                 <td colspan="" >
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
            url: '{{url("payroll/findLoan")}}',
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