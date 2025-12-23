@extends('layouts.master')


@push('plugin-styles')

<style>
    .details-menu {
        background: #ffffff;
        box-shadow: 0 3px 12px 0 rgb(0 0 0 / 15%);
        margin-top: 10px !important;  
        padding-left: 0;
        list-style: none;
    }
    .details-menu a {
        border-bottom: 1px solid #cfdbe2;
    list-style: none;
      font-size: 13px;
        border-left: 3px solid transparent;
        border-top: 0;
        color: #444;
      padding: 6px 10px !important;
    }
    
   
    </style>

@endpush

@section('content')


<!-- Main Body Starts -->
<div class="layout-px-spacing">
    <div class="layout-top-spacing mb-2">
        <div class="col-md-12">

 
 
 
            <div class="row mt-lg">
                
                <div class="col-sm-2">
                
                                <div class="nav flex-column nav-pills mb-sm-0 mb-3 text-center mx-auto details-menu"
                                role="tablist" aria-orientation="vertical">
                                <a class="nav-link @if($type == 'details' || $type == 'edit-details') active  @endif" data-toggle="pill" href="#details" role="tab"
                                    aria-controls="v-border-pills-home"
                                    aria-selected="true">{{__('Task Details')}}</a>
                                <a class="nav-link  text-center @if($type == 'calls' || $type == 'edit-calls') active  @endif" data-toggle="pill" href="#calls"
                                    role="tab" aria-controls="v-border-pills-profile"
                                    aria-selected="false">{{__('Calls')}}</a>
                                <a class="nav-link  text-center @if($type == 'meetings' || $type == 'edit-meetings') active  @endif" data-toggle="pill" href="#meetings"
                                    role="tab" aria-controls="v-border-pills-messages"
                                    aria-selected="false">{{__('Meetings')}}</a>
                                <a class="nav-link  text-center @if($type == 'comments' || $type == 'edit-comments') active  @endif" data-toggle="pill" href="#comments"
                                    role="tab" aria-controls="v-border-pills-messages"
                                    aria-selected="false">{{__('Comments')}}</a>
                                <a class="nav-link  text-center @if($type == 'attachment' || $type == 'edit-attachment') active  @endif" data-toggle="pill" href="#attachment"
                                    role="tab" aria-controls="v-border-pills-messages"
                                    aria-selected="false">{{__('Attachment')}}</a>
                                <a class="nav-link  text-center @if($type == 'tasks' || $type == 'edit-tasks') active  @endif" data-toggle="pill" href="#tasks"
                                    role="tab" aria-controls="v-border-pills-messages"
                                    aria-selected="false">{{__('Tasks')}}</a>
                                <a class="nav-link  text-center @if($type == 'proposal' || $type == 'edit-proposal') active  @endif" data-toggle="pill" href="#proposal"
                                    role="tab" aria-controls="v-border-pills-messages"
                                    aria-selected="false">{{__('Proposal')}}</a>
                                    <a class="nav-link  text-center @if($type == 'reminder' || $type == 'edit-reminder') active  @endif" data-toggle="pill" href="#reminder"
                                    role="tab" aria-controls="v-border-pills-messages"
                                    aria-selected="false">{{__('Reminder')}}</a>
                                 <a class="nav-link  text-center @if($type == 'notes' || $type == 'edit-notes') active  @endif" data-toggle="pill" href="#notes"
                                    role="tab" aria-controls="v-border-pills-messages"
                                    aria-selected="false">{{__('Notes')}}</a>
                               <a class="nav-link  text-center @if($type == 'activities' || $type == 'edit-activities') active  @endif" data-toggle="pill" href="#activities"
                                    role="tab" aria-controls="v-border-pills-messages"
                                    aria-selected="false">{{__('Activities')}}</a>
                                
                            </div>
                        </div>
                 
      

 <!-- Table -->

 
 <div class="col-sm-10">

         <div class="card">
            
                            <!-- Default panel contents -->                          
                               
                                <div class="tab-content" id="v-border-pills-tabContent">

                                    <div class="tab-pane @if($type == 'details' || $type == 'edit-details') active  @endif" id="details" role="tabpanel"
                                        aria-labelledby="v-border-pills-home-tab">
                                        <div class="card-header"> <strong>Task Details</strong> </div>
                                        <div class="card-body">
                                        <div class="table-responsive">
                       <table class="table datatable-basic table-striped">

                            <tbody>
                                <tr >
                                   <th>Task Name</th> <td>{{$data->task_name}}</td>
                                   @php $category = App\Models\Project\TaskCategory::find($data->category_id);  @endphp
                             <th>Task Category</th>  <td>{{$category->name}}</td>
                                  
                             </tr>
                                <tr>
                                 <th>Related To</th><td>{{$data->goal_tracking_id}}</td>
                                   <th>Task Status</th>  <td>{{$data->task_status}}</td>
                                  
                                   
                                    </tr>
                                       <tr>
                                       @php $project = App\Models\Project\Project::find($data->project_id);  @endphp
                                       @if(!empty($project))
                                       <th>Project</th>  <td>{{$project->name}}</td>
                                       @else
                                       <th>Project</th>  <td></td>
                                       @endif
                                       
                                       @php $milestone = App\Models\Project\Milestone::find($data->milestone_id);  @endphp
                                       @if(!empty($milestone))
                                       <th>Milestone</th>  <td>{{$milestone->name}}</td>
                                       @else
                                       <th>Milestone</th>  <td></td>
                                       @endif
                               
                                    </tr>

                                    <tr>
                                       @php $leads = App\Models\Leads\Leads::find($data->leads_id);  @endphp
                                       @if(!empty($leads))
                                       <th>Leads</th>  <td>{{$leads->lead_name}}</td>
                                       @else
                                       <th>Leads</th>  <td></td>
                                       @endif
                                       
                                       @php $user = App\Models\User::find($data->assigned_to);  @endphp
                                       @if(!empty($user))
                                       <th>Assigned To</th>  <td>{{$user->name}}</td>
                                       @else
                                       <th>Assigned To</th>  <td></td>
                                       @endif
                             </tr>
                                <tr>
                                    <th>Start Date</th>  <td> {{$data->task_start_date}}</td>
                                    <th>Due Date</th><td> {{$data->due_date}}</td>
                                    </tr>
                                       <tr>
                                    <th>Task Description</th>   <td> {{$data->task_description}} </td>
                                    </tr>
                                  
                            </tbody>
                            

                        </table>
                    </div>
                </div>
                                  
                                    </div>

                                    
                                    <div class="tab-pane @if($type == 'calls' || $type == 'edit-calls') active  @endif" id="calls" role="tabpanel"
                                        aria-labelledby="v-border-pills-messages-tab">
                                        <div class="card">
                                            <div class="card-header"> <strong>Calls</strong> </div>
                                                
                                            <div class="card-body">



                                            </div>
                                    </div>
                                    </div>


                            <div class="tab-pane @if($type == 'meetings' || $type == 'edit-meetings') active  @endif" id="meetings" role="tabpanel"
                                        aria-labelledby="v-border-pills-messages-tab">
                                        <div class="card">
                                            <div class="card-header"> <strong>Meetings</strong> </div>
                                                
                                            <div class="card-body">

                                                

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


        
   
<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>


       
<!-- Main Body Ends -->
@endsection


@section('scripts')

<script src = "https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>  
<script src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script> 

<script type="text/javascript">
 $(document).ready(function(){
  $("#timepicker1,#timepicker2").datetimepicker({
   format: 'LT' 
  });   
})

 </script>


<script>
       $('.datatable-call').DataTable({
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


     $('.datatable-meetings').DataTable({
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







@endsection