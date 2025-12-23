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
          @if(Session::get('messager'))
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
                      <h4><button class="btn btn-primary"  data-toggle="modal" data-target="#owner">Add Land to user<i class="fa fa-plus"></i></button></h4>
                    </div>
                  
                </div>
              
              
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-sm-12 col-lg-10 col-xl-10 col-md-10">
                  <div class="table-responsive">
                    @if(count($farmer)>0)
                        <table class="table table-striped table-md">
                          <tbody><tr>
                            <th>Land Owner</th>
                            <th>Land</th>
                            <th>Size</th>
                            <th>Ownership</th>
                            <th>Action</th>
                          </tr>
                          
                          @foreach($farmer as $farmer)
                             <tr>
                            <td>{{$farmer->farmer->firstname}} {{$farmer->farmer->lastname}}</td>
                            <td> {{$farmer->regno}}</td>
                            <td>
                            {{$farmer->size}}
                            </td>
                            <td>{{$farmer->ownership}}</td>
                            <td>
                              <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12">
                            
                              <a href="#"   data-toggle="modal" data-target="#owner{{$farmer->id}}"><i class="fas fa-edit"></i></a>

                              <a href="#"  data-toggle="modal" data-target="#del{{$farmer->id}}"><i class="fas fa-trash-alt"></i></a>

                              
                                </div>
                            </td>
                             </tr>
                            
                          @endforeach
                          @else
                          No data available
                          @endif
                          
                        </tbody>
                        
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
 
  @foreach($farmer2 as $farmer)
  <div class="modal fade" id="del{{$farmer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
          <button type="button" type="submit"  class="btn btn-danger"><a href="{{url('land/'.$farmer->id.'/delete')}}" style="color:white;font-weight:bold">Delete</a></button>
          <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
 @endforeach

<!-- end of the delete model -->


  <!--create owner modal -->
  <div class="modal fade" id="owner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" action="{{url('land/save')}}">
        {{ csrf_field() }}
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="inputEmail4">Farm registration</label>
                <input type="text" name='registration' class="form-control" id="inputEmail4" placeholder="">
                    @error('registration')
                <div class="text-danger">{{$message }}</div>
                @enderror
              </div>
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="inputEmail4">Farm Size</label>
                <input type="text" name='size' class="form-control" id="inputEmail4" placeholder="">
                    @error('size')
                <div class="text-danger">{{$message }}</div>
                @enderror
              </div>
            </div>
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
              <label for="inputEmail4">Farm Location</label>
              <input type="text" name='location' class="form-control" id="inputEmail4" placeholder="">
                  @error('location')
              <div class="text-danger">{{$message }}</div>
              @enderror
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-lg-6 col-xl-6">
                  <label for="inputEmail4">Select owner</label>
                  <select name="id" class="form-control">
                   
                        @foreach($owner as $owner)
                            <option value='{{$owner->id}}'>{{$owner->firstname}} {{$owner->lastname}}</option>
                        @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6 col-lg-6 col-xl-6">
                  <label for="inputEmail4">Type of ownership</label>
                  <select name="ownership" class="form-control">
                      <option value='private'>Private</option>
                      <option value="hired">Hired</option>
                  </select>
                </div>
              </div>
             
            <div class="form-row">
               <div class="form-group col-md-12 col-lg-12">
    
                <input type="submit" value="Add" name="save" class="btn btn-block btn-primary">
              </div>
            </div>
          </div>
  </form>
    </div>
  </div>
</div>
<!-- end of the owner model -->
<!-- edit modal -->
@foreach($farmer3 as $farmer)
<div class="modal fade" id="owner{{$farmer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit farm asset</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form class="form" method="post" action="{{url('land/'.$farmer->id.'/edit')}}">
      {{ csrf_field() }}
        <div class="card-body">
          <div class="form-row">
            <div class="form-group col-md-6 col-lg-6 col-xl-6">
              <label for="inputEmail4">Farm registration</label>
              <input type="text" value="{{$farmer->regno}}" name='registration' class="form-control" id="inputEmail4" placeholder="">
                  @error('registration')
              <div class="text-danger">{{$message }}</div>
              @enderror
            </div>
            <div class="form-group col-md-6 col-lg-6 col-xl-6">
              <label for="inputEmail4">Farm Size</label>
              <input type="text" name='size' value="{{$farmer->size}}" class="form-control" id="inputEmail4" placeholder="">
                  @error('size')
              <div class="text-danger">{{$message }}</div>
              @enderror
            </div>
          </div>
          <div class="form-row">
          <div class="form-group col-md-6 col-lg-6 col-xl-6">
            <label for="inputEmail4">Farm Location</label>
            <input type="text" name='location' value="{{$farmer->location}}" class="form-control" id="inputEmail4" placeholder="">
                @error('location')
            <div class="text-danger">{{$message }}</div>
            @enderror
          </div>
          
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="inputEmail4">Type of ownership</label>
                <select name="ownership" class="form-control">
                    <option @if($farmer->ownership=='private')
                    selected
                    @endif
                    value='private'>Private</option>

                    <option @if($farmer->ownership=='hired')
                      selected
                      @endif value="hired">Hired</option>
                </select>
              </div>
            </div>
           
          <div class="form-row">
             <div class="form-group col-md-12 col-lg-12">
  
              <input type="submit" value="Add" name="save" class="btn btn-block btn-primary">
            </div>
          </div>
        </div>
</form>
  </div>
</div>
</div>
@endforeach
<!-- end of the edit modal -->
@endsection