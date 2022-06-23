@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>DAILY CASH & STOCK CONTROL</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">DAILY CASH & STOCK CONTROL
                                    </a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
@php
$center=App\Models\Cotton\CollectionCenter::where('id',$account_id)->first();
@endphp

        <div class="panel-heading">
            <h6 class="panel-title" align-centre>
              DAILY CASH & STOCK CONTROL
                @if(!empty($start_date))
                    for the period: <b>{{$start_date}} to {{$end_date}}</b>
                @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

               
                <!-- <div class="col-md-4">
                    <label class="">District</label>
                    <select id="selectDistrictid" name="district_id" class="form-control district" required>
                                      <option>Select district</option>
                                    @if(!empty($district))
                                                        @foreach($district as $row)

                                                        <option @if(isset($data2))
                                                            {{ $data->district_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                </div> -->

                  <div class="col-md-4">
                    <label class="">Start Date</label>
                   <input  name="start_date" id="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                <div class="col-md-4">
                    <label class="">End Date</label>
                     <input  name="end_date" id="end_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($end_date)) {
                    echo $end_date;
                } else {
                    echo date('Y-m-d');
                }
                ?>">
                </div>

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br> <br>
@if(!empty($start_date))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

                    <table class="table table-striped table-condensed table-hover" id="tableExport" style="width:100%;">
                        <thead>
                        <tr>
                            <th>SR</th>
                            <th> DISTRICT</th>
                            <th> TOTAL CASH ISSUED</th>
                            <th>T/Stock villages</th>
                            <th>VALUE OF STOCK KIJIJINI</th>
                            <th>T/KG RCVD</th>
                             <th>VALUE OF KG RCVD</th>
                             <th>CASH REFUND</th>
                             <th>BALANCE KIJIJINI</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                         $cr = 0;
                        $dr = 0;
                        ?>
                        @foreach($district as $row)
                        <?php
                        $total_dr = 0;
                        $total_cr = 0;
                        $total_stock_kijijini = 0;
                        $total_value_of_stock_kijijini = 0;
                        $total_kg_received = 0;
                        $total_value_kg_received = 0;
                        
                            $data=App\Models\Cotton\CollectionCenter::where('district_id', $row->id)->get();
                        ?>
                        
                        @foreach($data as $key)
                          <?php
                        $cr = 0;
                        $dr = 0;
                   
          
                            
                         $dr = \App\Models\Cotton\TopUpCenter::where('to_account_id', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->sum('amount');
                        
                      
                            
                          $cr = \App\Models\Cotton\ReverseTopUpCenter::where('to_account_id', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->sum('amount');
                            
                          $total_dr +=$dr;
                          $total_cr +=$cr;
                          
                             $kg_received = \App\Models\Cotton\CottonMovement ::where('source_location', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->sum('quantity'); 
                          $total_kg_received +=$kg_received;
                          
                          $stock_kijijini = \App\Models\Cotton\PurchaseCotton::where('location', $key->id)->whereBetween('purchase_date',
                            [$start_date, $end_date])->sum('quantity') - $kg_received; 
                          $total_stock_kijijini +=$stock_kijijini;
                          
                           $value_kg_received = \App\Models\Cotton\CottonMovement ::where('source_location', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->sum('amount'); 
                           $total_value_kg_received +=$value_kg_received;
                          
                          $value_of_stock_kijijini = \App\Models\Cotton\PurchaseCotton::where('location', $key->id)->whereBetween('purchase_date',
                            [$start_date, $end_date])->sum('purchase_amount') - $value_kg_received; 
                          $total_value_of_stock_kijijini +=$value_of_stock_kijijini;
                          
                      
                          
                          
                        ?>
                        @endforeach
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><button class="btn desplay_district_report" value='{{$row->id}}' data-toggle="modal"  data-target="#createOrder" href="#" style=" border: none,background-color: inherit,padding: 14px 28px,font-size: 16px,cursor: pointer,display: inline-block"><a href="#">{{$row->name}}</a></button></td>
                                  <td>{{number_format(  $total_dr,2) }}</td>
                                    <td>{{$total_stock_kijijini}}</td>
                                <td>{{$total_value_of_stock_kijijini}}</td>                                
                             <td>{{$total_kg_received}}</td>
                             <td>{{number_format( $total_value_kg_received,2)}}</td>
                             <td>{{number_format( $total_cr,2) }}</td>
                             <td>{{number_format( $total_dr-$total_value_kg_received-$total_cr,2)}}</td>
                                
                            </tr>
                        
                        
                        @endforeach
                        </tbody>
                        <tfoot>
                          <!--  <tr class="custom-color-with-td">
                                   <td></td>  <td></td>  
                                <td ><b>Total</b></td>
                                <td><b>{{ number_format($dr,2) }}</b></td>
                                    <td></td>
                                     <td><b>{{ number_format($cr,2) }}</b></td>
    
                            </tr> -->
                        </tfoot>
                    </table>
                  
                </div>
            </div>
            <!-- /.panel-body -->
             </div>
    @endif              

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
        {{-- model of district data stating --}}
        <div class="modal inmodal" id="createOrder" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="padding-right: 17px;">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="myLargeModalLabel">DAILY CASH & STOCK CONTROL</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <hr>
                  <div class="table-responsive">
                    <input type="hidden" id="hidden_order_id" name="hidden_order" class="form-control item_total_tax"/>
                  <table class="table table-bordered" id="general_raport_table_id">
                    <thead>
                        <tr>
                            <th> BUYING POST</th>
                            <th> TOTAL CASH ISSUED</th>
                            <th>T/Stock villages</th>
                            <th>VALUE OF STOCK KIJIJINI</th>
                            <th>T/KG RCVD</th>
                             <th>VALUE OF KG RCVD</th>
                             <th>CASH REFUND</th>
                             <th>BALANCE KIJIJINI</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                         
                        </tfoot>
                    </table>
                     
              </div>
              <hr>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
              </div>
                 
                </div>
              </div>
            </div>
          </div>
        {{-- model of district data end --}}
</section>



@endsection

@section('scripts')
<script>
$(document).ready(function() {

    var general_raport_table=$('#general_raport_table_id').DataTable();
        var distict_report_id;
     
        //function of get data when order button clickes
    $(document).on("click",'.desplay_district_report', function(e) {
        general_raport_table.clear().draw();
        distict_report_id = $(this).val();
        console.log(distict_report_id);
        getPopUpTableData();
    });

function getPopUpTableData(){
      let url = '{{ route("general_report_table.show", ":id") }}';
      url = url.replace(':id', distict_report_id)

       //setting the x-csrf-token in ajax request
       $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      //ajax for get account data
      $.ajax({
        type:"GET",
        url:url,
        data:{"start_date":$('#start_date').val(),"end_date":$('#end_date').val()},
        dataType:"json",
        cache: false,
        async: true,
        success: function(response) {
          //adding row to the report table
          $columnNo = 0;
          $.each(response.all_data,function(key,datas){
            $columnNo++;
            general_raport_table.row.add([
                datas.name,
                datas.debit,
                datas.stock_kijijini,
                datas.value_of_stock_kijijini,
                datas.kg_received,
                datas.value_kg_received,
                datas.credit,
                datas.debit-datas.value_kg_received-datas.credit,
                
            ]).draw();
              });
            console.log(response);
        },
        error: function(response) {
            console.log(response);
        }
    });
 }  



    $(document).on('change', '.region', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findCenterDistrict")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#selectDistrictid").empty();
                $("#selectDistrictid").append('<option value="">Select district</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#selectDistrictid").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });


 $(document).on('change', '.district', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findCenterRegion")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#selectWardid").empty();
                $("#selectWardid").append('<option value="">Select ward</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#selectWardid").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });



});
</script>
<script>
$(document).ready(function() {
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