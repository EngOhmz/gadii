@extends('layouts.master')

@push('plugin-styles')
 <style>
 .table-scroll {
	position:relative;
	
	overflow:hidden;
	 display: flex; /* Allow buttons and table side-by-side */
}
.table-wrap {
	width:100%;
	overflow:auto;
	 white-space: nowrap; /* Prevent content wrapping */
}
.table-scroll table {
	width:100%;
	margin:auto;
	border-collapse:separate;
	border-spacing:0;
	
}
.table-scroll th, .table-scroll td {
	padding:5px 10px;
	white-space:nowrap;
	vertical-align:top;
}


.fixed-side {

	background:white;
	visibility:visible;
	 position: sticky; /* Fix first column during scroll */
  left: 0; /* Maintain left position */
  background-color: white; /* Optional background color */
  
}

.main-table thead, .main-table tfoot{background:transparent;}




.arrow {
 position: fixed; /* Make buttons positioned within table */
  top: 80%; /* Center vertically */
  transform: translateY(-50%); /* Offset position for centering */
  padding: 5px 10px;
  border: 1px solid #ccc;
  cursor: pointer;
  z-index: 1; /* Ensure buttons appear above table content */
}

.arrow.left {
  left: 600px; /* Position left arrow */
}

.arrow.right {
  right: 30px; /* Position right arrow */
}


.item_period{
    width:150px;
}


 </style>

@endpush


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Budgets</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Budget
                                    List</a>
                            </li>
                             @can('add-budgeting')
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Budget</a>
                            </li>
                            @endcan
                             

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
                                                    style="width: 151.219px;">Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Fiscal Year</th>
                                               

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($issue))
                                            @foreach ($issue as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                               
                                                <td>
                                                <a class="" href="{{ route("budgets.show", $row->id)}}" target="_blank">{{ $row->name }}</a></td>
                                                
                                                 <td>{{ Carbon\Carbon::parse($row->year->start)->format('M Y') }} - {{ Carbon\Carbon::parse($row->year->end)->format('M Y') }}</td>

                                                <td>
                                                 <div class="form-inline">
                                               {{--  
                                                 
                                                <div class = "input-group"> 
                                              <a class="list-icons-item text-primary"
                                                        href="{{ route("budgets.edit", $row->id)}}">Edit
                                                    </a>
                                        </div>&nbsp
                                        
                              
                                  <div class = "input-group"> 
         {!! Form::open(['route' => ['budgets.destroy',$row->id], 'method' => 'delete']) !!}
            {{ Form::button('Change Status', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'onclick' => "return confirm('Are you sure?')"]) }}
            {{ Form::close() }}
            --}}
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
                                    @if(!empty($id))
                                            <h5>Edit Budget</h5>
                                            @else
                                            <h5>Add New Budget</h5>
                                            @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            @if(isset($id))
                                                    {{ Form::model($id, array('route' => array('budgets.update', $id), 'method' => 'PUT')) }}
                                                    @else
                                                    {{ Form::open(['route' => 'budgets.store']) }}
                                                    @method('POST')
                                                    @endif

                                                    <div class="form-group row">
                                                    
                                                     <label class="col-lg-2 col-form-label">Name <span class="required"> * </span></label>
                                                    <div class="col-lg-4">
                                                     <input type="text" name="name" value="{{ isset($data) ? $data->name : '' }}"
                                                                class="form-control" required>
                                                        </div>

                                                <label class="col-lg-2 col-form-label">Fiscal Year <span class="required"> * </span></label>
                                                <div class="col-lg-4">
                                                    <div class="input-group mb-3">
                                                        <select
                                                            class="form-control append-button-single-field year_id"
                                                            name="year_id" id="year_id" required>
                                                            <option value="">Select Fiscal Year</option>
                                                            @if (!empty($year))
                                                            @foreach ($year as $row)
                                                            <option @if (isset($data)) {{ $data->year_id == $row->id ? 'selected' : '' }} @endif
                                                            value="{{ $row->id }}">
                                                        {{ Carbon\Carbon::parse($row->start)->format('M Y') }} - {{ Carbon\Carbon::parse($row->end)->format('M Y') }}</option>
                                                            @endforeach
                                                            @endif

                                                        </select>&nbsp

                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-toggle="modal" value=""
                                                            onclick="model('1','year')"
                                                            data-target="#appFormModal" href="app2FormModal"><i
                                                                class="icon-plus-circle2"></i></button>
                                                    </div>
                                                </div>
                                               
                                            </div>

                                                   
                                                    

                                                    <div class="form-group row">
                                          
                                                        
                                                        <label class="col-lg-2 col-form-label">Branch</label>
                                                            <div class="col-lg-4">
                                                                <select class="form-control m-b" name="branch_id">
                                                                    <option>Select Branch</option>
                                                                    @if (!empty($branch))
                                                                        @foreach ($branch as $row)
                                                                            <option value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                    </div>
                                                    
                       
                       <br>
                       
                        <div class=""> <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p>   </div>
                        
                         <div class="account"  style="display:none;">
          
            <div id="table-scroll" class="table-scroll">
            
  <div class="table-wrap">
                    <table id="data-table" class="table table-striped table-condensed table-hover main-table">
                                       <thead>
                                            <tr>
                                                <th class="fixed-side" style="position:sticky;top: 0;">Account</th>
                                                <th class="1" style="position:sticky;top: 0;"></th>
                                                <th class="2" style="position:sticky;top: 0;"></th>
                                                <th class="3" style="position:sticky;top: 0;"></th>
                                                <th class="4"></th>
                                                <th class="5"></th>
                                                <th class="6"></th>
                                                <th class="7"></th>
                                                <th class="8"></th>
                                                <th class="9"></th>
                                                <th class="10"></th>
                                                <th class="11"></th>
                                                <th class="12"></th>
                                              
                                            </tr>
                                        </thead>
                     <tbody>

   @if(!@empty($type))
                                            @foreach ($type as $account_type)
                                                 <?php  $e=0;   ?>
                                            <tr class="gradeA even" role="row">
                                                 <td colspan="13" style="text-align:"><b>{{ $loop->iteration }} . {{ $account_type->type  }} </b></td>
                                                      
                    </tr>
    @foreach($account_type->classAccount->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group)
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code)
 @if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)' && $account_code->account_codes != '31101')
<tr>
<th class="fixed-side">{{$account_code->account_codes  }} - {{$account_code->account_name }}</th>
<input type="hidden" name="account_id[]" class="form-control item_account" id="account" value="{{ isset($i) ? $i->account_id : $account_code->id }}">
<td class="a1"><input type="text" name="period1[]" class="item_period" id="period1" value="{{ isset($i) ? $i->period1 : '0' }}" required></td>
<td class="a2"><input type="text" name="period2[]" class="item_period" id="period2" value="{{ isset($i) ? $i->period2 : '0' }}" required></td>
<td class="a3"><input type="text" name="period3[]" class="item_period" id="period3" value="{{ isset($i) ? $i->period3 : '0' }}" required></td>
<td class="a4"><input type="text" name="period4[]" class="item_period" id="period4" value="{{ isset($i) ? $i->period4 : '0' }}" required></td>
<td class="a5"><input type="text" name="period5[]" class="item_period" id="period5" value="{{ isset($i) ? $i->period5 : '0' }}" required></td>
<td class="a6"><input type="text" name="period6[]" class="item_period" id="period6" value="{{ isset($i) ? $i->period6 : '0' }}" required></td>
<td class="a7"><input type="text" name="period7[]" class="item_period" id="period7" value="{{ isset($i) ? $i->period7 : '0' }}" required></td>
<td class="a8"><input type="text" name="period8[]" class="item_period" id="period8" value="{{ isset($i) ? $i->period8 : '0' }}" required></td>
<td class="a9"><input type="text" name="period9[]" class="item_period" id="period9" value="{{ isset($i) ? $i->period9 : '0' }}" required></td>
<td class="a10"><input type="text" name="period10[]" class="item_period" id="period10" value="{{ isset($i) ? $i->period10 : '0' }}" required></td>
<td class="a11"><input type="text" name="period11[]" class="item_period" id="period11" value="{{ isset($i) ? $i->period11 : '0' }}" required></td>
<td class="a12"><input type="text" name="period12[]" class="item_period" id="period12" value="{{ isset($i) ? $i->period12 : '0' }}" required></td>
</tr>
@endif
   @endforeach              
  @endforeach
  @endforeach
   @endforeach
 @endif
 
                    </tbody>

 <tfoot>
                    <tr>
                           <td><b>Total</b></td>
                        <td></td>
                          <td></td>
                        <td><b></b></td>
                        <td><b></b></td>
                        
                    </tr>
                    </tfoot>
                  
               
                    <button class="arrow left">&lt;</button>
  <button class="arrow right">&gt;</button>
                </table>
                
            </div>
            
        </div>

            
            </div>                                        
                                                  
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                            
                                                             <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                    href="{{ route('budgets.index') }}">
                                                                    Cancel
                                                                </a>
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
 <div class="modal fade " data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">

        </div>
    </div>

@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [3]}
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


<script>
$(document).ready(function() {
  $('.arrow.left').click(function(e) {
       e.preventDefault();
    $('.table-wrap').scrollLeft($('.table-wrap').scrollLeft() - 120); // Scroll left by 100px
  });

  $('.arrow.right').click(function(e) {
       e.preventDefault();
    $('.table-wrap').scrollLeft($('.table-wrap').scrollLeft() + 120); // Scroll right by 100px
  });
  
  
  
    $('.item_period').keyup(function(event) {   
        // skip for arrow keys
          if(event.which >= 37 && event.which <= 40){
           //event.preventDefault();
          }
        
          $(this).val(function(index, value) {
              
              value = value.replace(/[^0-9\.]/g, ""); // remove commas from existing input
              return numberWithCommas(value); // add commas back in
              
          });
        });
        
        
        $(document).on('change', '.year_id', function() {
        var id = $(this).val();
       console.log(id);
      
            $.ajax({
            url: '{{url("accounting/findMonth")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
               $('.errors').empty();
               $('.account').css("display", "none");
              if(data['error'] != ''){
                $('.errors').append(data['error']);
              }
            
            else if(data['error'] == ''){ 
          $(".1").html(data['period1']);
          $(".2").html(data['period2']);
          $(".3").html(data['period3']);
          $(".4").html(data['period4']);
          $(".5").html(data['period5']);
          $(".6").html(data['period6']);
          $(".7").html(data['period7']);
          $(".8").html(data['period8']);
          $(".9").html(data['period9']);
          $(".10").html(data['period10']);
          $(".11").html(data['period11']);
          $(".12").html(data['period12']);
           $('.account').css("display", "block"); 
            }
     

 }

        });

    });

        
        
        
});

</script>
<script type="text/javascript">


function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

</script>


 <script type="text/javascript">
        function model(id, type) {


            $.ajax({
                type: 'GET',
                url: '{{ url('accounting/discountModal') }}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('#appFormModal > .modal-dialog').html(data);
                     
                    
                },
                error: function(error) {
                    $('#appFormModal').modal('toggle');

                }
            });

        }

        function saveClient(e) {

            $.ajax({
                type: 'GET',
                url: '{{ url('accounting/save_year') }}',
                data: $('.addClientForm').serialize(),
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    var id = response['id'];
                    var start = response['start'];
                    var end = response['end'];

                    var option = "<option value='" + id + "'  selected>" + start + " - "+end+"</option>";

                    $('#year_id').append(option);
                    $('#appFormModal').hide();



                }
            });
        }
        
        
        
    </script>


@endsection