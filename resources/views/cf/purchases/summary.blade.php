@extends('layouts.master')


@section('content')
<div class="row">
    <div class="col-sm-12" >
        <div class="card">
            <!-- *********     Employee Search Panel ***************** -->
            <div class="card-header">
                <h4>POS Activity</h4>
            </div>

            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal form-groups-bordered', 'name' => 'form')) !!}  
                {{csrf_field()}}
                <div class="card-body">
                      <div class="form-group offset-3">
                        <label  for="field-1" class="col-sm-3 control-label">Search Type <span
                                class="required"> *</span></label>

                        <div class="col-sm-5">
                            <select required name="search_type" id="search_type" class="form-control m-b search" required  onchange = "ShowHideDiv()">
                                <option value="">Select Search Type</option>
                                <option value="employee" <?php if (!empty($search_type)) {
                                    echo $search_type == 'employee' ? 'selected' : '';
                                } ?>>By Employee</option>


                                <option value="period" <?php if (!empty($search_type)) {
                                    echo $search_type == 'period' ? 'selected' : '';
                                } ?>>By Period</option>

                                <option value="activities" <?php if (!empty($search_type)) {
                                    echo $search_type == 'activities' ? 'selected' : '';
                                } ?>>All Activities</option>

                            </select>
                        </div>
                    </div>

                <script type="text/javascript">
                     function ShowHideDiv() {
                  var ddlPassport = document.getElementById("search_type");
                var dfPassport = document.getElementById("employee");
             var dzPassport = document.getElementById("period");
              dfPassport.style.display = ddlPassport.value == "employee" ? "block" : "none";
             dzPassport.style.display = ddlPassport.value == "period" ? "block" : "none";
    }
             </script>

                    <div class="by_employee" id="employee"
                         style="display: <?= !empty($search_type) && $search_type == 'employee' ? 'block' : 'none' ?>">
                         <div class="form-group offset-3">
                            <label for="field-1"
                                   class="col-sm-3 control-label">Employee Name
                                <span
                                    class="required"> *</span></label>

                            <div class="col-sm-5">
                                <select class="by_employee form-control m-b select_box" style="width: 100%" name="user_id">
                                    <option value="">Select Employee</option>
                                    <?php
                                    if (!empty($all_employee)): ?>
                                        <?php foreach ($all_employee as $v_employee) : ?>
                                                    <option value="<?php echo $v_employee->id; ?>"
                                                        <?php
                                                        if (!empty($user_id)) {
                                                            echo $v_employee->id == $user_id ? 'selected' : '';
                                                        }
                                                        ?>><?php echo $v_employee->name  ?></option>
                                               
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    

                    <div class="by_period" id="period"
                         style="display: <?= !empty($search_type) && $search_type == 'period' ? 'block' : 'none' ?>">
                        <div class="form-group offset-3">
                            <label class="col-sm-3 control-label">Start Date<span
                                    class="required"> *</span></label>
                            <div class="col-sm-5">
                               
                                    <input type="date" value="<?php
                                    if (!empty($start_date)) {
                                        echo $start_date;
                                    }
                                    ?>" class="by_period form-control" name="start_date"
                                           data-format="yyyy/mm/dd">

                                  
                                </div>
                            </div>
                      
                       <div class="form-group offset-3">
                            <label class="col-sm-3 control-label">End Date <span
                                    class="required"> *</span></label>
                            <div class="col-sm-5">
                             
                                    <input type="date" value="<?php
                                    if (!empty($end_date)) {
                                        echo $end_date;
                                    }
                                    ?>" class="by_period form-control" name="end_date"
                                           data-format="yyyy/mm/dd">

                                 
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="form-group offset-3" id="border-none">
                        <label for="field-1" class="col-sm-3 control-label"></label>
                        <div class="col-sm-5">
                            <button id="submit" type="submit" name="flag" value="1"
                                    class="btn btn-primary btn-block">Go
                            </button>
                        </div>
                    </div>
                </div>
  </div>
            </form>
        </div><!-- ******************** Employee Search Panel Ends ******************** -->
        

<!-- ******************** Employee Search Result ******************** -->



<?php if (!empty($search_type)) {
if ($search_type == 'period') {
    $by = 'From ' . date('d/m/Y', strtotime($start_date)) . ' to ' . date('d/m/Y', strtotime($end_date));
}

elseif ($search_type == 'employee') {
  $user_info = App\Models\User::where('id', $user_id)->first();
    $by = 'For ' . $user_info->name;
}
elseif ($search_type == 'activities') {

    $by = '';
}
?>
 
  <div class="card">
                            <!-- Default panel contents -->
                             <div class="card-header"><strong>POS Summary <?php echo $by ?></strong> </div>
                            <div class="card-body">  
   <!-- Table -->
                   <div class="table-responsive">
                <table class="table datatable-basic table-striped" id="table-1">
                        <thead>
                        <tr>
                          <th>#</th>
                            <th>Activity Date</th>
                          <th>Module</th>
                            <th>Activity</th>
                           <th>Performed by</th>
                        </tr>
                        </thead>
                        <tbody>
                      
                          @if (!empty($check_existing_payment))
                        @foreach ($check_existing_payment as $row)
                        <tr>
                             <td> <?php echo $loop->iteration; ?></td>
                            <td><?php echo date('d/m/ Y', strtotime($row->date)); ?>  </td>
                              <td><?php echo  $row->module ;?></td>
                            <td><?php echo  $row->activity ;?></td>
                                 <td><?php echo  $row->user->name ;?></td> 
                       
                        </tr>
                       
                         @endforeach
                           @endif
                        </tbody>
                    </table>
                </div>
</div>
</div>
 <?php } ?>


<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>

@endsection



@section('scripts')
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



@endsection