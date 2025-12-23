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
                <h4>Health Contribution</h4>
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
                    foreach ($nssf_salary_info as $key => $v_nssf_salary):
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
                    foreach ($nssf_salary_info as $key => $v_nssf_salary):
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
                               <div class="card-header">
<div class="form-inline">
<strong><i class="icon-calendar2"></i> &nbsp<?php echo $month_name . ' ' . $year; ?></strong> 
     
          
        </div>
   
</div>

  <div class="card-body">  
                                <!-- Table -->
                                <div class="table-responsive">
               <table class="table datatable-basic table-striped" id="table-1">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Payment Date</th>
                                        <th>Contribution</th>
                                       
                                    </tr>
                                    </thead>
                                    <tbody>
                                     <?php
                                    $total_amount = 0;
                                    if (!empty($v_nssf_salary)): foreach ($v_nssf_salary as $nssf_salary) : ?>
                                        <tr>
                                            <td><?php echo $nssf_salary->user->name ?></td>
                                             <td><?php echo date('d/m/Y', strtotime($nssf_salary->date)) ?></td>
                                            <td><?php echo number_format($nssf_salary->credit, 2);
                                                $total_amount += $nssf_salary->credit ;
                                                ?></td>

                                           

                                           
                                        </tr>
                                        <?php
                                        $key++;
                                    endforeach;
                                        ?>
                                  <?php endif; ?>
                                     </tbody>
                                   <tfoot>
                                      <tr class="total_amount">
                                            <td colspan="2" style="text-align: right;">
                                                <strong>Total Amount : </strong></td>
                                            <td colspan="">
                                                <strong><?php echo number_format($total_amount, 2); ?></strong>
                                            </td>
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
                    foreach ($user_nssf_salary_info as $key => $v_user_nssf_salary):
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
                               <div class="card-header">
<div class="form-inline">
<strong><i class="icon-calendar2"></i> &nbsp<?php echo $month_name . ' ' . $year; ?></strong> 
     
          
        </div>
   
</div>

  <div class="card-body">  
                                <!-- Table -->
                                <div class="table-responsive">
                <table class="table datatable-basic table-striped "id="table-1">
                                    <thead>
                                    <tr>
                                       <th>Name</th>
                                        <th>Payment Date</th>
                                        <th> Contribution</th>
                                       
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $user_total_amount = 0;
                                    if (!empty($v_user_nssf_salary)): foreach ($v_user_nssf_salary as $user_nssf_salary) : ?>
                                                   <tr>
                                            <td><?php echo $user_nssf_salary->user->name ?></td>
                                             <td><?php echo date('d/m/Y', strtotime($user_nssf_salary->date)) ?></td>
                                           <td><?php echo number_format($user_nssf_salary->credit, 2);
                                                $user_total_amount += $user_nssf_salary->credit;
                                                ?></td>
                                           

                                           
                                        </tr>
                                        <?php
                                        $key++;
                                    endforeach;
                                        ?>
                           <?php endif; ?>
                                     </tbody>
                                   <tfoot>
                                     <tr class="total_amount">
                                             <td colspan="2" style="text-align: right;">
                                                <strong>Total Amount : </strong></td>
                                            <td colspan="">
                                                <strong><?php echo number_format($user_total_amount, 2); ?></strong>
                                            </td>

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
                {"targets": [1]}
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