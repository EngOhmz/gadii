@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
            
                                
                <div class="card">
                    <div class="card-header">
                        <h4> Cash Deposits(Subscription) </h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content tab-bordered" id="myTab3Content">

                            <div class="tab-pane fade active show " id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                       
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                    
                                                {{ Form::open(['route' => 'subscription.save_deposit']) }}
                                                @method('POST')
                                                
                                                 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date <span class="required"> * </span></label>
                                                    <div class="col-lg-8">
                                                    <input type="date" name="date" required value="{{ isset($data) ? $data->date: date('Y-m-d')}}" class="form-control">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row" id="client" ><label
                                                        class="col-lg-2 col-form-label">User <span class="required"> * </span></label>
                                                    <div class="col-lg-8">
                                                <select class="m-b client_id" id="client_id" name="client_id" >
                                                    <option value="">Select User</option>                                                    
                                                            @foreach ($client as $m)                                                             
                                                            <option value="{{$m->id}}" @if(isset($data))@if($data->client_id == $m->id) selected @endif @endif >
                                                            {{$m->name}} -  {{$m->phone}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                                </div>
                                             
                                                
                                                  <div class="form-group row">
                                                   <label class="col-lg-2 col-form-label">Role <span class="required"> * </span></label>
                                                    <div class="col-lg-8">
                                                            <select name="role_id" id="role_id" class="form-control m-b role" required>
                                                            <option value="">Select Role</option>
                                                                @foreach ($roles as $r)                                                             
                                                            <option value="{{$r->id}}">{{$r->slug}}</option>
                                                               @endforeach
                                                            </select>
                                                    </div>
                                                    
                                                </div>
                                                
                                                
                                               
                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Amount <span class="required"> * </span></label>

                                                    <div class="col-lg-8">
                                                        <input type="text" name="amount" value="{{ isset($data) ? $data->amount : ''}}" class="form-control amount" required>
                                                    </div>
                                                </div>
                                               
                                                    


                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Bank/Cash Account <span class="required"> * </span></label>
                                                    <div class="col-lg-8">
                                                       <select class="m-b" id="bank_id" name="bank_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->bank_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                                               @endforeach
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
             var user= $('.client_id').val();

           console.log(id);
            $.ajax({
                url: '{{url("findMinimum")}}',
                type: "GET",
                data: {
                    id: id,
                  role:role,
                  user:user
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