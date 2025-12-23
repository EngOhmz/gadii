@extends('layouts.master')

@section('content')

  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <!-- alert -->
          @if(Session::get('messagev'))
          <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
              {{Session::get('messagev')}}
            </div>
          </div>
          @endif
          @if(Session::get('messager')))
          <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
              {{Session::get('messager')}}
            </div>
          </div>
           @endif

          <!-- end of alert -->
          <div class="card">
            <div class="card-header">
              <h4>{{__('farmer.manage_farmer')}}</h4>
            </div>
            <div class="card-body">

                  <ul class="nav nav-tabs" id="myTab4" role="tablist">
                     <li class="nav-item">
                      <a class="nav-link @if(empty($id)) active show @endif" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="true">Farmer List</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link @if(!empty($id)) active show @endif" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="false">Register Farmer </a>
                    </li>
                   
                 
                  </ul>
                
 <div class="tab-content tab-bordered" id="myTab3Content">
                 <div class="tab-pane fade @if(empty($id)) active show @endif"  id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                    <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                             <thead>
                                            <tr role="row">

                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 208.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Phone</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Email</th> 
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Location</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                              <tbody>
                          
                              
                              @foreach($farm as $flist)
                                  <tr class="gradeA even" role="row">
                           <td>{{ $loop->iteration }}</td>
                                   <td>{{$flist->firstname}} {{$flist->lastname}}</td>
                                <td>{{$flist->phone}}</td>
                                <td>{{$flist->email}}</td>

                                <td>{{$flist->ward->name}}, {{$flist->district->name}},{{$flist->region->name}}</td>
                                <td>
                                  <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                  <a href="farmer/{{$flist->id}}/show" ><i class="fas fa-tv"></i></a>
                                  <a href="farmer/{{$flist->id}}/edit"><i class="fas fa-edit"></i></a>
                                  <a href="#"  data-toggle="modal" data-target="#basicModal"><i class="fas fa-trash-alt"></i></a>
                                  
                                    </div>
                                </td>
                                 </tr>
                              @endforeach
                            
                              

                            </tbody>
         
                  
                            
                          </table>
                      
                          </div>
                          
                    </div>
             

                    <div class="tab-pane fade @if(!empty($id)) active show @endif"  id="home4" role="tabpanel" aria-labelledby="home-tab4">
                      <div class="card">
                        <div class="card-header">
                         @if(!empty($id))
                                            <h5>Edit Farmer</h5>
                                            @else
                                            <h5>Add New Farmer</h5>
                                            @endif

                        </div>
                        <div class="card-body ">
                           <div class="row">
                                            <div class="col-sm-12 ">
                                             @if(isset($id))
                                                   <form class="form" method="post" action="{{url('farmer/update',$farmer->id)}}">
                                                 {{ csrf_field() }}
                                                    @else
                                                  <form class="form" method="post" action="{{url('farmer/save')}}">
                                                  {{ csrf_field() }}
                                                    @endif
                         

                                <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">FirstName</label>
                                  <input type="text" name='firstname' class="form-control" id="inputEmail4" placeholder="" value="{{ isset($farmer) ? $farmer->firstname : ' ' }}">
                                      @error('firstname')
                                <div class="text-danger">{{$message }}</div>
                            @enderror
                                </div>
                          
                                <div class="form-group col-md-6">
                                  <label for="inputPassword4">LastName</label>
                                  <input type="text" name='lastname' class="form-control" id="inputPassword4" placeholder="" value="{{ isset($farmer) ? $farmer->lastname : ''}}">
                                   @error('lastname')
                                <div class="text text-danger">{{$message }}</div>
                            @enderror
                                </div>
                            
                                </div>

                                <div class="form-row">
                                 <div class="form-group col-md-6 col-lg-6">
                                  <label for="inputAddress">Phone number</label>
                                  <input type="text" name='phone' class="form-control" id="inputAddress" placeholder="" value="{{isset($farmer) ? $farmer->phone : ''}}">
                                  @error('phone')
                                  <div class="text text-danger">{{$message }}</div>
                              @enderror 
                                </div>
                                  <div class="form-group col-md-6 col-lg-6">
                                  <label for="inputAddress">Email</label>
                                  <input type="email" name='email' class="form-control" id="inputAddress" placeholder="example@example.com (optional)" value="{{isset($farmer) ? $farmer->email : ''}}">
                                  </div>
                                </div>

                                <div class="form-row">
                                  <div class="form-group col-md-4">
                                    <label for="inputState">Region</label>
                                    <select  id="selectRegionid" name="region_id" class="form-control region">
                                      <option ="">Select region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($farmer))
                                                            {{ $farmer->region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>

                     @if(!empty($farmer))
                      <div class="form-group col-md-4">
                                    <label for="inputState">District</label>
                                    <select id="selectDistrictid" name="district_id" class="form-control district">
                                      <option>Select district</option>
                                    @if(!empty($district))
                                                        @foreach($district as $row)

                                                        <option @if(isset($farmer))
                                                            {{ $farmer->district_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
                 @else
              <div class="form-group col-md-4">
                                    <label for="inputState">District</label>
                                    <select id="selectDistrictid" name="district_id" class="form-control district">
                                      <option selected="">Select district</option>
                                    
                                    </select>
                                  </div>
  @endif
                            
            
 @if(!empty($farmer))
                      <div class="form-group col-md-4">
                                    <label for="inputState">Ward</label>
                                    <select id="selectWardid" name="ward_id" class="form-control">
                                      <option>Select ward</option>
                                    @if(!empty($ward))
                                                        @foreach($ward as $row)

                                                        <option @if(isset($farmer))
                                                            {{ $farmer->ward_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
                 @else
              <div class="form-group col-md-4">
                                   <label for="inputState">Ward</label>
                                    <select id="selectWardid" name="ward_id" class="form-control">
                                      <option>Select ward</option>
                                    
                                    </select>
                                  </div>
  @endif
                             </div>
            

    <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputCity">Physical Address</label>
                                    <input type="text" name="address" class="form-control" id="inputCity" value="{{isset($farmer) ? $farmer->address : ''}}">
                                    @error('address')
                                    <div class="text text-danger">{{$message }}</div>
                                @enderror
                                  </div>
                               
                                  <div class="form-group col-md-6">
                                    <label for="inputState">Group</label>
                                    <select id="inputState" name="group_id" class="form-control">
                                      <option value="0" selected="">Select group</option>
                                    @if(isset($group))
                                    @foreach($group as $group)
                                      <option  @if(isset($data))
                                                            {{ $farmer->group_id == $group->id ? 'selected' : ''}}
                                                            @endif  value="{{$group->id}}">{{$group->name}}</option>
                                    @endforeach
                                    @endif
                                    </select>
                                  </div>
                                  </div>
                                <!--
                                <div class="form-row">
                                  <div class="form-group col-md-6 col-lg-6">
                                  <label for="inputState">Region</label>
                                  <select id="inputState" class="form-control">
                                  <option selected="">Choose...</option>
                                  <option>...</option>
                                  </select>
                                  </div>
                                  <div class="form-group col-md-6 col-lg-6">
                                  <label for="inputCity">Physical Address</label>
                                  <input type="text" class="form-control" id="inputCity">
                                  </div>
                                </div>
                              -->
                               <div class="form-row">
                                 <div class="col-lg-offset-2 col-lg-12">
                         @if(!@empty($id))
                                                        <input type="submit" value="Update" name="save" class="btn btn-lg btn-info">
                                                        @else
                                                        <input type="submit" value="Save" name="save" class="btn btn-lg btn-primary">
                                                        @endif
                                
                               </div>
                                </div>
                              </div>
                      </form>
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
  <!-- delete modal -->
  <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete?
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" type="submit"  class="btn btn-danger"><a href="farmer/{{$flist->id ?? ''}}/delete" style="color:white;font-weight:bold">Delete</a></button>
        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- end of the delete model -->

<script>
$(document).ready(function() {

    $(document).on('change', '.region', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findRegion")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#selectDistrictid").empty();
                $("#selectDistrictid").append('<option value="">Select district</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#selectDistrictid").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });


 $(document).on('change', '.district', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findDistrict")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#selectWardid").empty();
                $("#selectWardid").append('<option value="">Select ward</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#selectWardid").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });



});
</script>
@endsection