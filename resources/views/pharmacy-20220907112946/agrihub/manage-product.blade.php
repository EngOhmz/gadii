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
              
                <h4>Product List</h4>
                <div class="card-header-form">
                  
                    <div class="input-group">
                      <h4><button class="btn btn-primary"  data-toggle="modal" data-target="#product">Add new product<i class="fa fa-plus"></i></button></h4>
                    </div>
                  
                </div>
              
              
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-sm-12 col-lg-10 col-xl-10 col-md-10">
                  <div class="text text-danger" id="result">erro sana</div>
                  <div class="table-responsive">
                    @if(count($product)>0)
                        <table class="table table-striped table-md">
                          <tbody><tr>
                            <th>Product name</th>
                            <th>Code</th>
                            <th>Buy Price</th>
                            <th>Sell Price</th>
                            <th>Unit</th>
                            <th>Quantity Balance</th>
                            <th>Action</th>
                          </tr>
                          
                          @foreach($product as $product)
                             <tr>
                            <td>{{$product->name}}</td>
                            <td> {{$product->code}}</td>
                            <td>
                            {{$product->buyprice}}
                            </td>
                            <td>{{$product->sellprice}}</td>
                            <td>
                              {{$product->unit}}
                              </td>
                              <td>
                                {{$product->balance}}
                                </td>
                               
                            <td>
                              <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12">
                            
                              <a href="#"   data-toggle="modal" data-target="#product{{$product->id}}"><i class="fas fa-edit"></i></a>

                              <a href="#"  data-toggle="modal" data-target="#del{{$product->id}}"><i class="fas fa-trash-alt"></i></a>

                              
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
 
  @foreach($product2 as $product)
  <div class="modal fade" id="del{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete?
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" type="submit"  class="btn btn-danger"><a href="{{url('product/'.$product->id.'/delete')}}" style="color:white;font-weight:bold">Delete</a></button>
          <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
 @endforeach

<!-- end of the delete model -->

  <!--create product modal -->
  <div class="modal fade" id="product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new product</h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" action="{{url('product/save')}}">
        {{ csrf_field() }}
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="inputEmail4">Product Name</label>
                <input type="text" name='name' value="{{old('name')}}" class="form-control" id="inputEmail4" placeholder="">
                    @error('name')
                <div class="text-danger" value="{{$message}}" id="error">{{$message }}</div>
                @enderror
              </div>
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="inputEmail4">Code</label>
                <input type="text" name='code' value="{{old('code')}}" class="form-control" id="inputEmail4" placeholder="">
                    @error('code')
                <div class="text-danger" value="{{$message}}" id="error">{{$message }}</div>
                @enderror
              </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6 col-lg-6 col-xl-6">
              <label for="inputEmail4">Buying Price</label>
              <input type="text" name='buyprice' value="{{old('buyprice')}}" class="form-control" id="inputEmail4" placeholder="">
                  @error('buyprice')
              <div class="text-danger" value="{{$message}}" id="error">{{$message }}</div>
              @enderror
            </div>
            <div class="form-group col-md-6 col-lg-6 col-xl-6">
              <label for="inputEmail4">Selling Price</label>
              <input type="text" name='sellprice' value="{{old('sellprice')}}" class="form-control" id="inputEmail4" placeholder="">
                  @error('sellprice')
              <div class="text-danger" value="{{$message}}" id="error">{{$message }}</div>
              @enderror
            </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="inputEmail4">Unit</label>
               <input type="text" value="{{old('unit')}}"  name="unit" class="form-control">
    
                    @error('unit')
                <div class="text-danger" value="{{$message}}" id="error">{{$message }}</div>
                @enderror
              </div>
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="inputEmail4">Quantity Balance</label>
                <input type="text" name='balance' value="{{old('balance')}}" class="form-control" id="inputEmail4" placeholder="">
                    @error('balance')
                <div class="text-danger" value="{{$message}}" id="error">{{$message }}</div>
                @enderror
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
@foreach($product2 as $product)
<div class="modal fade" id="owner{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit farm asset</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form class="form" method="post" action="{{url('product/'.$product->id.'/edit')}}">
      {{ csrf_field() }}
        <div class="card-body">
          <div class="form-row">
            <div class="form-group col-md-6 col-lg-6 col-xl-6">
              <label for="inputEmail4">Product Name</label>
              <input type="text" value="{{$product->name}}" name='name' class="form-control" id="inputEmail4" placeholder="">
                  @error('name')
              <div class="text-danger">{{$message }}</div>
              @enderror
            </div>
            <div class="form-group col-md-6 col-lg-6 col-xl-6">
              <label for="inputEmail4">Code</label>
              <input type="text" name='code' value="{{$product->code}}" class="form-control" id="inputEmail4" placeholder="">
                  @error('address')
              <div class="text-danger">{{$message }}</div>
              @enderror
            </div>
          </div>
          <div class="form-row">
          <div class="form-group col-md-6 col-lg-6 col-xl-6">
            <label for="inputEmail4">Buy price</label>
            <input type="text" name='buyprice' value="{{$product->buyprice}}" class="form-control" id="inputEmail4" placeholder="">
                @error('buyprice')
            <div class="text-danger">{{$message }}</div>
            @enderror
          </div>
          
          <div class="form-group col-md-6 col-lg-6 col-xl-6">
            <label for="inputEmail4">Sell Price</label>
            <input type="text" name='sellprice' value="{{$product->sellprice}}" class="form-control" id="inputEmail4" placeholder="">
                @error('sellprice')
            <div class="text-danger">{{$message }}</div>
            @enderror
          </div>
          <div class="form-group col-md-6 col-lg-6 col-xl-6">
            <label for="inputEmail4">Unit</label>
           <input type="text" value="{{$product->unit}}" name="unit" class="form-control">

                @error('unit')
            <div class="text-danger">{{$message }}</div>
            @enderror
          </div>
          <div class="form-group col-md-6 col-lg-6 col-xl-6">
            <label for="inputEmail4">Balance</label>
            <input type="text" name='balance' value="{{$product->qbalance}}" class="form-control" id="inputEmail4" placeholder="">
                @error('balance')
            <div class="text-danger">{{$message }}</div>
            @enderror
          </div>
            </div>
           
          <div class="form-row">
             <div class="form-group col-md-12 col-lg-12">
  
              <input type="submit" value="Save edit" name="save" class="btn btn-block btn-primary">
            </div>
          </div>
        </div>
</form>
  </div>
</div>
</div>
<script>

  var error;
  error= document.getElementById('error').innerHTML;
  //error=getElementById("error").innerHTML;
  if((error.length)>0)
  {
    $(document).ready(function()
    {
      
    $("#product").modal("show");
    });
 
    
    //document.getElementById('result').innerHTML=error;
  }
 
 
  
</script>
@endforeach
<!-- end of the edit modal -->
@endsection