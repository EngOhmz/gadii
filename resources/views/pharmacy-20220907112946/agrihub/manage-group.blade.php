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
              
                <h4>Group List</h4>
                <div class="card-header-form">
                  
                    <div class="input-group">
                      <h4><button class="btn btn-primary"  data-toggle="modal" data-target="#newgroup">Add new Group <i class="fa fa-plus"></i></button></h4>
                    </div>
                  
                </div>
              
              
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-sm-12 col-lg-10 col-xl-10 col-md-10">
                  <div class="table-responsive">
                    @if(count($group)>0)
                        <table class="table table-striped table-md">
                          <tbody><tr>
                            <th>Group Name</th>
                            <th>Number of members</th>
                            <th>Action</th>
                          </tr>
                          
                          @foreach($group as $glist)
                             <tr>
                            <td>{{$glist->name}}</td>
                            <td> {{$glist->total}}</td>
                            <td>
                              <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12">
                              <a href="" ><i class="fas fa-tv"></i></a>
                              <a href="#"   data-toggle="modal" data-target="#modal{{$glist->id}}"><i class="fas fa-edit"></i></a>
                              <a href="#"  data-toggle="modal" data-target="#del{{$glist->id}}"><i class="fas fa-trash-alt"></i></a>
                              
                                </div>
                            </td>
                             </tr>
                          @endforeach
                          @endif
                          

                        </tbody>
                        No data available
                      </table>
                      </div>
                      <div class="card-footer text-right">
                        <nav class="d-inline-block">
                          <ul class="pagination mb-0">
                            <li class="page-item disabled">
                              <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                            <li class="page-item">
                              <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                              <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                            </li>
                          </ul>
                        </nav>
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
  @foreach($group as $gdelmodal)
    <div class="modal fade" id="del{{$gdelmodal->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
        <button type="button" type="submit"  class="btn btn-danger"><a href="group/{{$gdelmodal->id ?? ''}}/delete" style="color:white;font-weight:bold">Delete</a></button>
        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  @endforeach
  
<!-- end of the delete model -->
<!-- edit group modal -->
@foreach($group as $gmodal)
  <div class="modal fade" id="modal{{$gmodal->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
      <form class="form" method="post" action="group/{{$gmodal->id}}/update">
        {{ csrf_field() }}
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-12 col-lg-12 col-xl-12">
                <label for="inputEmail4">Group Name</label>
                <input type="text" name='name' value="{{$gmodal->name}}" class="form-control" id="inputEmail4" placeholder="" required>
                    @error('name')
                <div class="text-danger">{{$message }}</div>
                @enderror
              </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-6 col-lg-6">
    
                <input type="submit" value="Update" name="update" class="btn btn-lg btn-primary">
              </div>
            </div>
          </div>
  </form>
    </div>
    
  </div>
</div>
</div>
@endforeach
  


<!-- end of edit group model -->
  <!--create new group modal -->
  <div class="modal fade" id="newgroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" action="group/save">
        {{ csrf_field() }}
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-12 col-lg-12 col-xl-12">
                <label for="inputEmail4">Group Name</label>
                <input type="text" name='name' class="form-control" id="inputEmail4" placeholder="">
                    @error('name')
                <div class="text-danger">{{$message }}</div>
                @enderror
              </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-6 col-lg-6">
    
                <input type="submit" value="Add" name="save" class="btn btn-lg btn-primary">
              </div>
            </div>
          </div>
  </form>
    </div>
  </div>
</div>
<!-- end of the create group model -->
@endsection