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
                        <h4>Budgets Details</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                   
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">


                                                  
          
            <div id="table-scroll" class="table-scroll">
            
  <div class="table-wrap">
                    <table id="data-table" class="table table-striped table-condensed table-hover main-table">
                                       <thead>
                                            <tr>
                                                <th class="fixed-side" style="position:sticky;top: 0;">Account</th>
                                                <th class="1" style="position:sticky;top: 0;">{{Carbon\Carbon::parse($data->year->start)->format('M Y')}}</th>
                                                <th class="2" style="position:sticky;top: 0;">{{Carbon\Carbon::parse($data->year->start)->addMonths(1)->format('M Y')}}</th>
                                                <th class="3" style="position:sticky;top: 0;">{{Carbon\Carbon::parse($data->year->start)->addMonths(2)->format('M Y')}}</th>
                                                <th class="4">{{Carbon\Carbon::parse($data->year->start)->addMonths(3)->format('M Y')}}</th>
                                                <th class="5">{{Carbon\Carbon::parse($data->year->start)->addMonths(4)->format('M Y')}}</th>
                                                <th class="6">{{Carbon\Carbon::parse($data->year->start)->addMonths(5)->format('M Y')}}</th>
                                                <th class="7">{{Carbon\Carbon::parse($data->year->start)->addMonths(6)->format('M Y')}}</th>
                                                <th class="8">{{Carbon\Carbon::parse($data->year->start)->addMonths(7)->format('M Y')}}</th>
                                                <th class="9">{{Carbon\Carbon::parse($data->year->start)->addMonths(8)->format('M Y')}}</th>
                                                <th class="10">{{Carbon\Carbon::parse($data->year->start)->addMonths(9)->format('M Y')}}</th>
                                                <th class="11">{{Carbon\Carbon::parse($data->year->start)->addMonths(10)->format('M Y')}}</th>
                                                <th class="12">{{Carbon\Carbon::parse($data->year->start)->addMonths(11)->format('M Y')}}</th>
                                              
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
 @php $i=App\Models\Budget\BudgetItem::where('account_id',$account_code->id)->where('budget_id',$id)->first(); @endphp
<tr>
<th class="fixed-side">{{$account_code->account_codes  }} - {{$account_code->account_name }}</th>
<td class="a1">{{ isset($i) ? number_format($i->period1,2) : '0' }}</td>
<td class="a2">{{ isset($i) ?  number_format($i->period2,2) : '0' }}</td>
<td class="a3">{{ isset($i) ?  number_format($i->period3,2) : '0' }}</td>
<td class="a4">{{ isset($i) ?  number_format($i->period4,2) : '0' }}</td>
<td class="a5">{{ isset($i) ?  number_format($i->period5,2) : '0' }}</td>
<td class="a6">{{ isset($i) ?  number_format($i->period6,2) : '0' }}</td>
<td class="a7">{{ isset($i) ?  number_format($i->period7,2) : '0' }}</td>
<td class="a8">{{ isset($i) ?  number_format($i->period8,2) : '0' }}</td>
<td class="a9">{{ isset($i) ?  number_format($i->period9,2) : '0' }}</td>
<td class="a10">{{ isset($i) ?  number_format($i->period10,2) : '0' }}</td>
<td class="a11">{{ isset($i) ?  number_format($i->period11,2) : '0' }}</td>
<td class="a12">{{ isset($i) ?  number_format($i->period12,2) : '0' }}</td>
</tr>
@endif
   @endforeach              
  @endforeach
  @endforeach
   @endforeach
 @endif
 
                    </tbody>


                  
               
                    <button class="arrow left">&lt;</button>
  <button class="arrow right">&gt;</button>
                </table>
                
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

    </div>
</section>


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
@endsection