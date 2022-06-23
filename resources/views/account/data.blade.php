@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Bank & Cash</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Account
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Account</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                       <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 208.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Account Number</th>
                                              
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                    
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($account))
                                            @foreach ($account as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                   
                                                <td>{{$row->chart->account_name}}</td>
                                                  
                                                <td>{{$row->account_number}}</td>                                           
                                                  <td>{{number_format($row->balance,2)}} {{$row->exchange_code}}</td>

                                                <td>
                                                  
                                                    <div class="row">
                                                       
                                                        <div class="col-lg-6">
<a class="btn btn-icon btn-info" title="Edit" onclick="return confirm('Are you sure?')"   href="{{ route("account.edit", $row->id)}}"><i class="fa fa-edit"></i></a>
                                                        </div>
                                                     
                                                        <div class="col-lg-6">
                                                            {!! Form::open(['route' => ['account.destroy',$row->id], 'method' => 'delete']) !!}
                                                            {{ Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-icon btn-danger', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                            {{ Form::close() }}
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
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Account</h5>
                                        @else
                                        <h5>Edit Account</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('account.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'account.store']) }}
                                                @method('POST')
                                                @endif


                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Account Name <span class="required" style="color:red;"> * </span></label>
                                                    <div class="col-lg-8">
                                                       <select class="m-b" name="account_id"  id="account_id" required>
                                                    <option value="">Select  Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option readonly value="{{$bank->id}}" @if(isset($data))@if($data->account_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
                                                    </div>
                                                </div>
                         <script>
      if ($('#account_id').val()){
$('option:not(:selected)').prop('disabled', true);
}
</script>
                                               
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Description</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="description"
                                                            placeholder=""
                                                            class="form-control" rows="2">{{ isset($data) ? $data->description : ''}}</textarea>
                                                    </div>
                                                </div>

                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Balance <span class="required" style="color:red;"> *</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" name="balance" required
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->balance : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Account Number</label>
                                                    <div class="col-lg-8">
                                                        <input  type="text" data-parsley-type="number" name="account_number" 
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->account_number: ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Contact Person</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="contact_person"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->contact_person: ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Phone</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="contact_phone" 
                                                            placeholder="+255713100200"
                                                            value="{{ isset($data) ? $data->contact_phone: ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                               
                                              

                                                   

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Currency <span class="required" style="color:red;"> *</label>
                                                    <div class="col-lg-8">
                                                        <select class="m-b" name="exchange_code"
                                                            id="currency_code" required>
                                                            <option value="{{ old('currency_code')}}" disabled selected>
                                                                Choose option</option>                                                
                                                            @if(isset($currency))
                                                            @foreach($currency as $row)
                                                            <option @if(isset($data))
                                                            {{$data->exchange_code == $row->code  ? 'selected' : ''}}
                                                            @endif value="{{ $row->code }}">{{$row->name}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        @error('address')
                                                        <p class="text-danger">. {{$message}}</p>
                                                        @enderror
                                                    </div> </div>

                                                   
                                              
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Bank Details</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="bank_details"
                                                            placeholder=""
                                                            class="form-control" rows="2">{{ isset($data) ? $data->bank_details : ''}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit">Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
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
<script>
$(document).ready(function() {
    new TomSelect("#account_id",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    new TomSelect("#currency_code",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },

            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection