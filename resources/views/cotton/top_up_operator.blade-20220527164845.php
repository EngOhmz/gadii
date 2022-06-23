@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Top Up Operator</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Top Up
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Top Up</a>
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
                                                    style="width: 186.484px;">Reference No</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Operator</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Date</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($transfer))
                                            @foreach ($transfer as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                               
                                                <td>{{$row->reference_no}}</td>
                                                <td>{{$row->chart_to->name}}</td>                                     
                                                  <td>{{number_format($row->due_amount,2)}} {{$row->exchange_code}}</td>
                                                   <td>{{$row->date}}</td>
                                                  <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-info badge-shadow">Pending</div>
                                                    @elseif($row->status == 1)
                                            <div class="badge badge-success badge-shadow">Approved</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="row">
                                                       
                                                        <div class="col-lg-4">
<a class="btn btn-icon btn-info" title="Edit" onclick="return confirm('Are you sure?')"   href="{{ route("top_up_operator.edit", $row->id)}}"><i class="fa fa-edit"></i></a>
                                                        </div>
                                                     
                                                        <div class="col-lg-4">
                                                            {!! Form::open(['route' => ['top_up_operator.destroy',$row->id], 'method' => 'delete']) !!}
                                                            {{ Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-icon btn-danger', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                            {{ Form::close() }}
                                                        </div>
                                                     
                                                    </div>
                                                  

                                                    <div class="btn-group">
                                                        <button class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown">Change<span class="caret"></span></button>
                                                        <ul class="dropdown-menu animated zoomIn">
                                                            <a  class="nav-link" title="Confirm Payment" onclick="return confirm('Are you sure? you want to confirm')"  href="{{ route('operator.approve', $row->id)}}">Confirm Payment</a></li>
                                                                          </ul></div>
                                                
                                                 
                                                    @endif
 @if($row->status == 1)


                              <div class="btn-group">
                                                        <button class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown">Change<span class="caret"></span></button>
                                                        <ul class="dropdown-menu animated zoomIn">
 @if($row->reversed == 0)
                   <li class="nav-item"><a  class="nav-link" title="Edit" data-toggle="modal" class="discount"  href="" onclick="model({{ $row->id }},'operator')" value="{{ $row->id}}" data-target="#appFormModal" >Reverse Top Up</a></li>
@endif
          <li class="nav-item"><a  class="nav-link"  onclick="return confirm('Are you sure? you want to  mark as complete ')"  href="{{ route('operator.complete', $row->id)}}">Mark as Complete</a></li>
                                                                          </ul></div>
                      @endif

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
                                        <h5>Create Top Up</h5>
                                        @else
                                        <h5>Edit Top Up</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('top_up_operator.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'top_up_operator.store']) }}
                                                @method('POST')
                                                @endif


                                       
                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Operator</label>
                                                    <div class="col-lg-8">
                                                       <select class="operator" name="to_account_id" id="user_id" required>
                                                    <option value="">Select Operator</option> 
                                                          @foreach ($operator as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->to_account_id == $bank->id) selected @endif @endif >{{$bank->name}}</option>
                                                               @endforeach
                                                              </select>
                                                    </div>
                                                </div>
                                              
                                                    <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Reference No</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="reference_no" required
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->reference_no : ''}}"
                                                            class="form-control ">
                                                    </div>
                                          
                                                </div>
                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Amount</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" name="amount" required
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->amount : ''}}"
                                                            class="form-control amount">
                                                    </div>
                                           <div class=""> <p class="form-control-static" id="errors" style="text-align:center;color:red;"></p>   </div> 
                                                </div>
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="date" required
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->date: date("Y-m-d")}}" 
                                                            class="form-control">
                                                    </div>
                                                </div>
                                               
                                                     <div class="form-group row"><label class="col-lg-2 col-form-label">Bank Account
                                                    </label>
            
                                                <div class="col-lg-8">
                                                    <select class="m-b" name="from_account_id" id="select-account" required>
                                                        <option value="">Select
                                                        </option>
                                                        @if(!empty($banks))
                                                        @foreach($banks as $row)
                                                        <option value="{{$row->id}}" @if(isset($data))@if($data->
                                                            from_account_id == $row->id) selected @endif @endif >From
                                                            {{$row->account_name}}
                                                        </option>
            
                                                        @endforeach
                                                        @endif
                                                    </select>
            
                                                </div>
                                            </div>
 
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment
                                                    Method</label>
            
                                                <div class="col-lg-8">
                                                    <select class="m-b" name="payment_method" id="select-bank" required>
                                                        <option value="">Select
                                                        </option>
                                                        @if(!empty($payment_method))
                                                        @foreach($payment_method as $row)
                                                        <option value="{{$row->id}}" @if(isset($data))@if($data->
                                                            payment_method == $row->id) selected @endif @endif >From
                                                            {{$row->name}}
                                                        </option>
            
                                                        @endforeach
                                                        @endif
                                                    </select>
            
                                                </div>
                                            </div>

                                               

                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit" id="save">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save">Save</button>
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

 <!-- discount Modal -->
  <div class="modal inmodal show " id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    </div>
</div></div>
  </div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    
    new TomSelect("#user_id",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    new TomSelect("#select-bank",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
   
    new TomSelect("#select-account",{
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




<script type="text/javascript">
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '{{url("reverseOperatorModal")}}',
            data: {
                'id': id,
                'type':type,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }

</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection