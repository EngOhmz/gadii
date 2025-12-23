@extends('layouts.master')



@section('content')
<section class="section">
    <div class="section-body">
        @include('layouts.alerts.message')
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                 <div class="card-header header-elements-sm-inline">
								<h4 class="card-title"> Import User</h4>
								<div class="header-elements">
								   
                             
                     <a href="{{route('users.index')}}" class="btn btn-secondary btn-xs px-4">
                                <i class="fa fa-arrow-alt-circle-left"></i>
                                Back
                            </a>
									
				                	</div>
			                	
							</div>

                  
                    <div class="card-body">
                   
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                               <div class="card">
                                <div class="card-header">
                                     <form action="{{ route('user.sample') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <button class="btn btn-success">Download Sample</button>
                                        </form>
                                 
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <div class="container mt-5 text-center">
                                                <h4 class="mb-4">
                                                 Import Excel & CSV File   
                                                </h4>
                                                <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
                                            
                                                    @csrf
                                                    <div class="form-group mb-4">
                                                        <div class="custom-file text-left">
                                                            <input type="hidden" name="id" value="5" class="form-control" id="customFile" required>
                                                            <input type="file" name="file" class="form-control" id="customFile" required>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">Import User</button>
                                          
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

    </div>
</section>


@endsection

@section('scripts')

@endsection