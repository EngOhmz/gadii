@extends('layouts.master23')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
            
            @if(!empty(Session::get('success')))
                            
                                   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


                                   <div class="bootstrap-growl alert alert-primary " style="position:absolute;margin:0px;z-index:9999; top:20px;width:250px;right:20px">
                                
                                   <a class="close" data-dismiss="alert" href="#">&times;</a>
                                                 Please Logout from the System after confirming your payment
                                   </div>
                                   
                                  



                                 @endif
                                 <script>
                                $(".alert").delay(60000).slideUp(200, function() {
                                $(this).alert(close);
                                });
                                </script>
                                
                <div class="card">
                    <div class="card-header">
                        <h4> Deposits(Subscription) </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Deposit List
                                    </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Deposit</a>
                            </li>
                          

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                     <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 181.219px;">Reference No</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Amount</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 156.219px;">Role</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($items))
                                            @foreach ($items as $row)
                                            @php $role=App\Models\Role::find($row->role_id); @endphp
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                 <td>{{$row->reference_no}}</td>
                                                   <td>{{number_format($row->amount,2)}}</td>
                                                <td>@if(!empty($role)){{$role->slug}}@endif</td>
                                             
                                                <td>
                                                @if($row->status == 1)
                                               
                                                <div class="badge badge-info badge-shadow"> In Process</div>
                                                @elseif($row->status == 2)
                                                
                                                <div class="badge badge-success badge-shadow"> Success</div>
                                                @elseif($row->status == 3)
                                                
                                                <div class="badge badge-danger badge-shadow"> Transaction Failed</div>
                                                @endif
                                                </td>
                                                <td>{{  Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}} </td>
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
                                        @if(!empty($id))
                                        <h5>Edit</h5>
                                        @else
                                        <h5>Deposit</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('azampesa.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'azampesa.store']) }}
                                                @method('POST')
                                                @endif
                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Phone Number <span class="required"> * </span></label>
                                                   <div class="col-lg-10">
                                                <input type="text" name="accountNumber" value="{{ isset($data) ? $data->accountNumber : ''}}" class="form-control" required>
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
                                                
                                                
                                                <input type="hidden" name="type" value="0" class="form-control" >  
                                                
                                                
                                               
                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Amount <span class="required"> * </span></label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="amount" value="{{ isset($data) ? $data->amount : ''}}" class="form-control amount" required>
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
                                                                <option value="Mpesa">Mpesa</option>
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
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [1]}
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
$(document).ready(function() {
$('.amount').keyup(function(event) {   
if(event.which >= 37 && event.which <= 40) return;

$(this).val(function(index,value){
return value
.replace(/\D/g,"")
.replace(/\B(?=(\d{3})+(?!\d))/g,",");
   
});

});


});
</script>


<script>
    $(document).ready(function() {
    
       $(document).on('change', '.amount', function() {
            var id = $(this).val();
             var role= $('.role').val();

           console.log(id);
            $.ajax({
                url: '{{url("findMinimum")}}',
                type: "GET",
                data: {
                    id: id,
                  role:role,
                },
                dataType: "json",
                success: function(data) {
                  console.log(data);
                 $('.errors_bal').empty();
                $("#save").show();
                 if (data != '') {
                $('.errors_bal').append(data);
               $("#save").hide();
    } else {
      
    }
                
           
                }
    
            });
    
        });
    
    
    
    });
    </script>



@endsection