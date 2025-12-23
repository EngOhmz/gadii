@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">

            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>DRIVER CHECK LIST REPORT</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs within a box -->
                        
                        <div class="tab-content tab-bordered">
                            <!-- ************** general *************-->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2">
                            
                            <div class="col-lg-6">
                            <a class="btn btn-primary" href="{{ route('driver_checklist_report_pdf', $cargo->id) }}"  title="" > Download PDF </a>      
                            </div>
                            <br>

                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped " id="table-2" style="width:100%">
                                       <tbody>
                                            
                                               <tr>

                                                <th>Driver Name:</th>
                                                <td>{{$cargo->driver->driver_name}}</td>
                                                <th>License No:</th>
                                                <td>{{$cargo->driver->licence}}</td>

                                                </tr>

                                                <tr>

                                                <th>Horse No:</th>
                                                <td>{{$cargo->truck->reg_no}}</td>

                                                <th>Trailer No:</th>
                                                <td>{{$cargo->truck->connect_trailer}}</td>

                                                </tr>


                                                <tr>

                                                <th>Route Fuel Loaded:</th>
                                                @php $route_fuel  = App\Models\Route::where('id', $cargo->route_id)->first(); @endphp
                                                @if(!empty($route_fuel))
                                                <td>{{$route_fuel->loaded_fuel}}</td>
                                                @else
                                                <td>No used Route Fuel Loaded</td>
                                                @endif

                                                <th >Route Fuel Empty:</th>
                                                @php $fuel2  = App\Models\Route::where('id', $cargo->route_id)->first(); @endphp
                                                @if(!empty($fuel2))
                                                <td>{{$fuel2->empty_fuel}}</td>
                                                @else
                                                <td>No used Fuel</td>
                                                @endif

                                                </tr>


                                                <tr>

                                                <th>Total Fuel:</th>
                                                <td>{{$cargo->return_fuel}}</td>
                                                
                                                <th></th>
                                                <td></td>

                                                </tr>


                                                <tr>

                                                <th>Loaded Date:</th>
                                                <td>{{Carbon\Carbon::parse($cargo->collection_date)->format('d/m/Y')}}</td>

                                                <th >Cargo Type:</th>
                                                <td>{{$cargo->pacel_name}}</td>

                                                </tr>


                                                <tr>

                                                <th>Fuel Volume:</th>
                                                @php $fuel  = App\Models\Fuel\Fuel::where('movement_id', $cargo->id)->first(); @endphp
                                                @if(!empty($fuel))
                                                <td>{{$fuel->fuel_used}}</td>
                                                @else
                                                <td>No used Fuel</td>
                                                @endif

                                                <th >Mileage Amount:</th>
                                                @php $mileage  = App\Models\Mileage::where('movement_id', $cargo->id)->first(); @endphp
                                                @if(!empty($mileage))
                                                <td>{{$mileage->total_mileage}}</td>
                                                @else
                                                <td>No Mileage found</td>
                                                @endif

                                                </tr>


                                          <tr>                                               
                                                <td></td>
                                                <th></th>
                                                <td></td>
                                                <th></th>
                                                    </tr>
                                                     
                                                       <tr>
                                                     <td></td>
                                                        <th></th>
                                                            <td></td>
                                                        <th></th>
                                                </tr>

                                                 
                                                <tr>                                               
                                                <td>Driver Signature</td>
                                                <th>______________________________________</th>
                                                <td>Supervisor Signature</td>
                                                <th>______________________________________</th>
                                                    </tr>
                                                     
                                                       <tr>
                                                     <td>Accountant Signature</td>
                                                        <th>______________________________________</th>
                                                            <td></td>
                                                        <th></th>
                                                </tr>


                                                </tbody>
                                       
                                    </table>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            <!--end -->
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>

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

<script>
$(document).ready(function() {
    
     $(document).on('change', '.cardLocation', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("manage_card/findcardLocation")}}',
            type: "GET",
            data: {
                id: location_id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#selectMeterid").empty();
                $("#selectMeterid").append('<option value="">Select Meter Name</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#selectMeterid").append('<option value=' + value.regNo+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });
    
});
</script>   



<script type="text/javascript">
 $(document).ready(function () {
        var maxAppend = 0;
        $("#add_more_deduc").click(function () {
            var add_new = $('<div class="row">\n\
    <div class="col-sm-12"><input type="text" name="deduction_label[]" style="margin:5px 0px;height: 28px;width: 56%;" class="form-control" placeholder="Enter Deductions Label" required></div>\n\
<div class="col-sm-9"><input  type="text" data-parsley-type="number" name="deduction_value[]" placeholder="Enter Deductions Value" required  value=""  class="deduction form-control"></div>\n\
<div class="col-sm-3"><strong><a href="javascript:void(0);" class="remCF_deduc"><i class="fa fa-times"></i>&nbsp;Remove</a></strong></div></div>');
            maxAppend++;
            $("#add_new_deduc").append(add_new);

        });

        $("#add_new_deduc").on('click', '.remCF_deduc', function () {
            $(this).parent().parent().parent().remove();
        });
    });
</script>
<script type="text/javascript">
 $(document).on("change", function () {
        var sum = 0;
        var basic_salary= 0;
        var deduc = 0;

        $(".salary").each(function () {
            sum += +$(this).val();
         console.log(sum);
        });
         $(".basic_salary").each(function () {
            basic_salary += +$(this).val();
        });
        
        var provident_fund = ((basic_salary * 10 / 100 )).toFixed(2);
        $(".NSSF").val(provident_fund);
        
              
        

      var sub_total=sum- provident_fund ;


        var total_tax = tax_deduction_rule(sub_total);

        $(".PAYE").val(total_tax);

    

        $(".deduction").each(function () {
            deduc += +$(this).val();
        });
        
        var ctc = $("#ctc").val();
        $("#total").val(sum.toFixed(2));

        $("#deduc").val(deduc.toFixed(2));
        var net_salary = 0;
        net_salary = (sum - deduc).toFixed(2);
        $("#net_salary").val(net_salary);
    });

    function tax_deduction_rule(tax) {
        if (tax < 270000) {
            return "0";
        }
        else if (tax >= 270000 && tax < 520000) {
            return (0.08 * (tax - 270000)).toFixed(2);
        }
        else if (tax >= 520000 && tax < 760000) {
            var tr = (tax - 520000);
            var ttotal = ( tr * 20 / 100 );
            return ((20000 + ttotal)).toFixed(2);
        }
        else if (tax >= 760000 && tax < 1000000) {
            var tr = (tax - 760000);
            var ttotal = ( tr * 25 / 100 );
            return ((68000 + ttotal)).toFixed(2);
        } else if (tax >= 1000000) {
            var tr = (tax - 1000000);
            var ttotal = ( tr * 30 / 100 );
            return ((128000 + ttotal)).toFixed(2);
        }
    }


</script>
@endsection