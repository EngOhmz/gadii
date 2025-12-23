@extends('layouts.master')

@push('plugin-styles')
 


<style>

    .border-bottom-0 a {
      font-size: 15px;
        color: #444;
    }

.nav-tabs-vertical .nav-item.show .nav-link, .nav-tabs-vertical .nav-link.active {
        color: #3F51B5;
      font-weight:bold;
}

 .ms-2 {
        color: white;
    }
    
   
    </style>

@endpush

@section('content')
<section class="section">
    <div class="section-body">

                       <div class="row">
						  <div class="col-12 col-sm-6 col-lg-12">
							<div class="card">
								<div class="card-header header-elements-sm-inline">
			                                       <h4>{{$data->task_name}}</h4><hr>
								</div>

								<div class="card-body">
									<div class="d-lg-flex">
										<ul class="nav nav-tabs nav-tabs-vertical flex-column mr-lg-8 wmin-lg-200 mb-lg-0 border-bottom-0">
<li class="nav-item"><a href="#vertical-left-tab1" class="nav-link @if($type == 'details' || $type == 'edit-details') active  @endif" data-toggle="tab"> Task Details</a></li>
<li class="nav-item"><a href="#vertical-left-tab2" class="nav-link @if($type == 'comments' || $type == 'edit-comments') active  @endif" data-toggle="tab"> Discussion 
    <span class="badge bg-teal rounded-pill float-right ms-2">{{$ccount}}</span></a></li>
<li class="nav-item"><a href="#vertical-left-tab3" class="nav-link @if($type == 'attachment' || $type == 'edit-attachment') active  @endif" data-toggle="tab"> Attachment
  <span class="badge bg-teal rounded-pill float-right ms-2">{{$attcount}}</span></a></li>
<li class="nav-item"><a href="#vertical-left-tab4" class="nav-link @if($type == 'tasks' || $type == 'edit-tasks') active  @endif" data-toggle="tab"> Sub Tasks
    <span class="badge bg-teal rounded-pill float-right ms-2">{{$tcount}}</span></a></li>
<li class="nav-item"><a href="#vertical-left-tab5" class="nav-link @if($type == 'notes' || $type == 'edit-notes') active  @endif" data-toggle="tab"> Notes
    <span class="badge bg-teal rounded-pill float-right ms-2">{{$ncount}}</span></a></li>
<li class="nav-item"><a href="#vertical-left-tab10" class="nav-link @if($type == 'activities' || $type == 'edit-activities') active  @endif" data-toggle="tab"> Activities
    <span class="badge bg-teal rounded-pill float-right ms-2">{{$actcount}}</span></a></li>
										
										</ul>

                                                                              
			<div class="tab-content flex-lg-fill">

		<div class="tab-pane fade @if($type == 'details' || $type == 'edit-details') show active  @endif " id="vertical-left-tab1">
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
                                   <th>Task Status</th>
                                   
                                   <td>
                                       <div class="form-inline">
                                                       @if($data->task_status == 'Deferred')
                                                    <div class="badge badge-danger badge-shadow">{{$data->task_status}}</div>
                                                    @elseif($data->task_status == 'In Progress')
                                                    <div class="badge badge-info badge-shadow">{{$data->task_status}}</div>
                                                    @elseif($data->task_status == 'Completed')
                                                    <span class="badge badge-success badge-shadow">{{$data->task_status}}</span>
                                                    @elseif($data->task_status == 'Started')
                                                    <span class="badge badge-primary badge-shadow">{{$data->task_status}}</span>
                                                    @else
                                                    <div class="badge badge-warning badge-shadow">{{$data->task_status}}</div>
                                                @endif


             <div class="dropdown" >&nbsp;
              <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"></a>
                <div class="dropdown-menu">            
              <a class="nav-link change_status" data-id="{{$data->id}}"  href="{{route('task.change_status',['id'=>$data->id,'status'=>'Started'])}}">Started</a>
            <a class="nav-link change_status" data-id="{{$data->id}}"  href="{{route('task.change_status',['id'=>$data->id,'status'=>'In Progress'])}}">In Progress</a>
          <a class="nav-link change_status" data-id="{{$data->id}}"  href="{{route('task.change_status',['id'=>$data->id,'status'=>'Deferred'])}}">Deferred</a>
     <a class="nav-link change_status" data-id="{{$data->id}}"  href="{{route('task.change_status',['id'=>$data->id,'status'=>'Waiting For Someone'])}}">Waiting For Someone</a>
   <a class="nav-link change_status" data-id="{{$data->id}}"  href="{{route('task.change_status',['id'=>$data->id,'status'=>'Completed'])}}">Completed</a>

                            
                </div>
            </div>
</div>
</td>
                                   
                                   
                                  
                                   
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
                                       
                                       <th>Assigned To</th>  
                                       <td> 
                                         <div class="form-inline">
                                            <a class="nav-link"  href=""  data-toggle="modal" value="{{ $data->id}}" data-type="view" data-target="#app2FormModal" onclick="model2({{$data->id }},'view')">View</a>
                                            <a class="nav-link"  href=""  data-toggle="modal" value="{{ $data->id}}" data-type="assign" data-target="#app2FormModal" onclick="model2({{$data->id }},'assign')"><i class="icon-plus-circle2"></i></a>
                                         </div> 
                                       </td>

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



				<div class="tab-pane fade @if($type == 'comments' || $type == 'edit-comments') show active  @endif" id="vertical-left-tab2">
                                                      @include('project.task.comments')													                                          
											</div>

			<div class="tab-pane fade @if($type == 'attachment' || $type == 'edit-attachment') show active  @endif" id="vertical-left-tab3">
						 @include('project.task.attachment')						                                           
											</div>

						<div class="tab-pane fade @if($type == 'tasks' || $type == 'edit-tasks') show active  @endif" id="vertical-left-tab4">
                                                                    @include('project.task.tasks')     
											</div>

				<div class="tab-pane fade @if($type == 'notes' || $type == 'edit-notes') show active  @endif" id="vertical-left-tab5">
                                                       @include('project.task.notes')
											</div>
											
											
                                   <div class="tab-pane fade @if($type == 'activities' || $type == 'edit-activities') show active  @endif" id="vertical-left-tab10">
						<div class="card-header"> <strong>Activities</strong> </div>
                                        <div class="card-body">
                                        <div class="table-responsive">
                       <table class="table datatable-activity table-striped">
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
                      
                          @if (!empty($activity))
                        @foreach ($activity as $row)
                        <tr>
                             <td> <?php echo $loop->iteration; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row->date)); ?>  </td>
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

<div class="modal fade" id="app2FormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>

<div id="appFormModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">File Preview</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                   
                </div>

            </div>
        </div>
    </div>


<div class="modal fade show" data-backdrop="" id="betaFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form id="addClientForm" method="post" action="javascript:void(0)">
                  @csrf
                                 <div class="modal-body">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Category Name</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="name"  id="name"                                                                
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Description</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="description" id="description"
                                                                class="form-control" >
                                                        </div>
                                                    </div>

                                                    
                 
               
                                             </div>
                                       </div>
                                    </div>


                                 </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save" onclick="saveCategory(this)" data-dismiss="modal">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{asset('assets/js/fileinput.min.js')}}"></script>
<script src="{{asset('assets/js/sortable.min.js')}}"></script>
<script src="{{asset('assets/js/uploader_bootstrap.js')}}"></script>


<script>
       $('.datatable-attach').DataTable({
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

 $('.datatable-task').DataTable({
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


  $('.datatable-notes').DataTable({
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

 $('.datatable-activity').DataTable({
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

 


$('.datatable-est').DataTable({
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

$('.datatable-inv').DataTable({
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

$('.datatable-credit').DataTable({
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

$('.datatable-exp').DataTable({
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
    $(document).ready(function () {
        $(".reply__").hide();
        $("button.reply").on("click", function(){
            var id = $(this).attr("id");
            var sectionId = id.replace("reply__", "reply_");
            $(".reply__").hide();
            $("div#" + sectionId).fadeIn("fast");
            $("div#" + sectionId).css("margin-top", "10" + "px");
        });


    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
      
   $("button.remove").on("click", function(){
  var category_id = $(this).data('category_id');
console.log(category_id);
    $("div > #reply_" + category_id).css("display", "none");   
    });



    });
</script>





<script type="text/javascript">
    function model2(id,type) {

    $.ajax({
        type: 'GET',
         url: '{{url("project/taskModal")}}',
        data: {
            'id': id,
            'type':type,
        },
        cache: false,
        async: true,
        success: function(data) {
            //alert(data);
            $('.modal-dialog').html(data);
        },
        error: function(error) {
            $('#app2FormModal').modal('toggle');
    
        }
    });
    
    }

    </script>



<script>

function model(id, type) {

    let url = '{{ route("task_file.preview") }}';


    $.ajax({
        type: 'GET',
        url: url,
        data: {
            'type': type,
            'id': id,
        },
        cache: false,
        async: true,
        success: function(data) {
            //alert(data);
            $('.modal-body').html(data);
        },
        error: function(error) {
            $('#appFormModal').modal('toggle');

        }
    });

}



function saveCategory(e) {
     
     var name = $('#name').val();
     var description = $('#description').val();
     
          $.ajax({
            type: 'GET',
            url: '{{url("project/addCategory")}}',
             data: {
                 'name':name,
                 'description':description,
             },
                dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.name;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#category_id').append(option);
                              $('#betaFormModal').hide();
                   
                               
               
            }
        });
}
</script>


@endsection