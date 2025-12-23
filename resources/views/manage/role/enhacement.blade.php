@extends('layouts.master')

@section('content')
    <section class="section">
            <div class="row">
            
                <div class="col-12">
                <div class="card">
                 <div class="card-body">
                    <center>
                        <h1>Role In Enhacement</h1>
                        <div class="row">
                            <div class="col-sm-12 ">
                                                {{ Form::open(['route' => 'azampesa.store']) }}
                                                @method('POST')
                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Phone Number <span class="required"> * </span></label>
                                                   <div class="col-lg-10">
                                                <input type="text" name="accountNumber" class="form-control" required>
                                                    </div>
                                                </div>
                                                
                                                  <div class="form-group row">
                                                   <label class="col-lg-2 col-form-label">Role <span class="required"> * </span></label>
                                                    <div class="col-lg-10">
                                                            <select name="role_id" id="role_id" class="form-control m-b role" required>
                                                            <option value="">Select Role</option>
                                                                @foreach ($roles as $r)                                                             
                                                            <option value="{{$r->id}}">{{$r->slug}}</option>
                                                               @endforeach
                                                            </select>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <input type="hidden" name="type"  value = "1">
                                                
                                                
                                               
                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Amount <span class="required"> * </span></label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="amount" class="form-control amount" required>
                                                    </div>
                                                </div>
                                               
                                                   <div class="form-group row">
                                                   <label class="col-lg-2 col-form-label">Provider <span class="required"> * </span></label>
                                                    <div class="col-lg-10">
                                                            <select name="provider" id="provider" class="form-control m-b" required>
                                                            <option value="">Select Provider</option>
                                                                <option value="Airtel">Airtel</option>
                                                                <option value="Tigo">Tigo</option>
                                                                <option value="Halopesa">Halopesa</option>
                                                                <option value="Azampesa">Azampesa</option>
                                                            </select>
                                                    </div>
                                                </div>
                                                
                                                 <div class=""> <p class="form-control-static errors_bal" id="errors" style="text-align:center;color:red;"></p></div>
                                                 
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                      
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save" >Save</button>
                                                       
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                            </div>
                        </div>
                    </center>
                </div>
            </div>
           </div>
            
        </div>
    </section>
@endsection