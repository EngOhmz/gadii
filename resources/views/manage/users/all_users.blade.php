@extends('layouts.master')

@section('title')
    <h2><i class="fas fa-th-large pr-2 text-info"></i>User Management</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <strong>Home</strong>
        </li>
        <li class="breadcrumb-item active">
            <strong>Users</strong>
        </li>
    </ol>
@endsection

@section('content')
    
    
<section class="section">
    <div class="section-body">
        
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                   <div class="card-header header-elements-sm-inline">
                        <h4 class="card-title">Manage Users</h4>
                 
                  <div class="header-elements">                           
                       

   </div></div>

                        </ul>
                          <div class="card-body">
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                   <table class="table table-striped" id="example">
                                    <thead>
                                    <tr>
                        <th>S/N</th>
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Username</th>
                         <th>Company</th>
                         <th>Role</th>
                         <th>Due Date</th>
                         <th>Last Login</th>
                         <th>Status</th>
                        <th class="always-visible">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                     <?php $x=0;?>
                    @if(isset($users))
                    @foreach($users as $user)
                    @php $role = "";  @endphp
                    @foreach($user->roles as $value2)
                    @php $role = $value2->id  @endphp
                    @endforeach
                     @php $cp_name_list = App\Models\System::where('added_by', $user->added_by)->get()  @endphp
                     
                 
                     <?php   $x++;  ?>
                        <tr>
                            <th> {{$x }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                             @if(!empty($cp_name_list))
                            @foreach($cp_name_list as $cp_name)
                            {{ $cp_name->name }}&nbsp;
                            @endforeach
                            </td>
                            @endif
                            </td>
                            <td>
                            @foreach($user->roles as $value2)
                                {{ $value2->slug }}
                            @endforeach
                            </td>
                            
                            <td>{{Carbon\Carbon::parse($user->due_date)->format('d/m/Y')}}</td>
                            <td>@if(!empty($user->last_login)) {{Carbon\Carbon::parse($user->last_login)->format('d/m/Y')}} @endif</td>

                            <td>
                            @if($user->disabled == 1)
                            <div class="badge badge-danger badge-shadow">Disabled</div>
                            @else
                            <div class="badge badge-success badge-shadow">Available</span>
                            @endif
                                                </td>
                            {{-- <td>
                         <div class="form-inline">
                        @if($user->disabled == 0)
                      
                    <a class="list-icons-item text-danger"  title="Disable" onclick="return confirm('Are you sure? you want to disable the user')"  href="{{ route('user.disable', $user->id)}}"><i class="icon-user-cancel"></i></a>&nbsp                               
                                
                                              @endif

                                
                            </div>
                            </td> --}}

                            <td>
                              <div class="form-inline">
                                  @if($user->disabled == 0)
                                      <a class="list-icons-item text-danger" title="Disable" onclick="return confirm('Are you sure? you want to disable the user')" href="{{ route('user.disable', $user->id)}}"><i class="icon-user-cancel"></i></a>&nbsp
                                      <a class="list-icons-item text-primary" title="Update Access Date" href="#" data-toggle="modal" data-target="#updateDateModal{{$user->id}}"><i class="icon-calendar"></i></a>
                                  @endif

                                  <!-- Modal for date selection -->
                                  <div class="modal fade" id="updateDateModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="updateDateModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="updateDateModalLabel">Update Access Date.</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <form id="updateDateForm{{$user->id}}" action="{{ route('user.update.access', $user->id) }}" method="POST">
                                                      @csrf
                                                      <div class="form-group">
                                                          <label for="due_date">Select New Due Date</label>
                                                          <br>
                                                          <input type="date" class="form-control" id="due_date" name="due_date" required>
                                                      </div>
                                                      <br>
                                                      <button type="submit" class="btn btn-primary">Save</button>
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </td>

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
</section>



@endsection

@section('scripts')


<link rel="stylesheet" href="{{ asset('assets/datatables/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">

<script src="{{asset('assets/datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/datatables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/datatables/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/buttons.print.min.js')}}"></script>

<script>
      $('#example').DataTable(
        {
        dom: 'lBfrtip',

        buttons: [
          {extend: 'copyHtml5',title: 'USER LIST ', exportOptions:{columns: ':visible :not(.always-visible)'},footer: true},
           {extend: 'excelHtml5',title: 'USER LIST' , exportOptions:{columns: ':visible :not(.always-visible)'},footer: true},
           {extend: 'csvHtml5',title: 'USER LIST' , exportOptions:{columns: ':visible :not(.always-visible)'}, footer: true},
            {extend: 'pdfHtml5',title: 'USER LIST', exportOptions:{ columns: ':visible :not(.always-visible)', },footer: true},
            {extend: 'print',title: 'USER LIST' , exportOptions:{columns: ':visible :not(.always-visible)'},footer: true}

                ],
        }
      );
     
    </script>
    
<script>
        $(document).on('click', '.edit_user_btn', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var slug = $(this).data('slug');
            var module = $(this).data('module');
            $('#id').val(id);
            $('#p-name_').val(name);
            $('#p-slug_').val(slug);
            $('#p-module_').val(module);
            $('#editPermissionModal').modal('show');
        });
    </script>
    
    
   
@endsection
