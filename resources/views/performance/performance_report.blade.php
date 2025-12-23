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
                <h4>Performance Report</h4>
            </div>
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
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

               <a href="{{route('appraisal')}}" class="text-danger pull-right">
             <i class="icon-plus3 ">  </i> Give Appraisal</a>
          
        
 </div>  
</div>

  <div class="card-body">  
                                <!-- Table -->
                                <div class="table-responsive">
                <table class="table datatable-basic table-striped" id="table-1">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Remarks</th>
                                            <th>Action</th>
                                       
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                   
                                    if (!empty($v_advance_salary)): foreach ($v_advance_salary as $advance_salary) : ?>
                                        <tr>
                                            <td><?php echo $advance_salary->assign->name ?></td>
                                            @php $dep=App\Models\Departments::find($advance_salary->assign->department_id); @endphp
                                            <td>{{$dep->name}}</td>
                                            <td>{{$advance_salary->remarks}}</td>
                                           
                                                <td>
                                                 <div class="form-inline">
                                                    <a class="list-icons-item text-primary" href="{{ route("edit_appraisal", $advance_salary->id)}}"> Edit </a>&nbsp&nbsp&nbsp&nbsp
                                        <a class="list-icons-item text-success" href="#" data-toggle="modal" data-target="#appFormModal" onclick="model({{ $advance_salary->id }},'view-performance')"> Show </a>&nbsp
                                                   
                                                 </div>
                                   
                                                </td>
                                           
                                        </tr>
                                        <?php
                                        $key++;
                                    endforeach;
                                        ?>
                                       <?php endif; ?>
                                     </tbody>
                                  
                                </table>
</div>
    </div>
                      
                        </div>
                    <?php endforeach; ?>
                </div>








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


        $.ajax({
            type: 'GET',
            url: '{{url("performance/performanceModal")}}',
            data: {
                'id': id,
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
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>
@endsection