@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Student Registraion</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a
                                    class="nav-link @if(empty($id)) active show @endif" href="#home2"
                                    data-toggle="tab">Update Student</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered">
                            <!-- ************** general *************-->
                           
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Edit Template</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                
                                            {{ Form::model($school, array('route' => array('school.update', $school->id),'role'=>'form','enctype'=>'multipart/form-data' ,'method' => 'PUT')) }}
                                               

                                                <div class="row">
                                                    <div
                                                        class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 offset-lg-3">
                                                        <div class="card">

                                                            <div class="card-body">
                                                                <div class="">    
                                                                <div class="form-group row">
                                                                        <label class=""> School Level/ Name  <span class="required"> </span></label>  
                                                                <div class="col-lg-9">                               
                                                                <select name="level" class="form-control select_box col-md-6" required>
                                                                <option value="">{{  $school->level }}</option>
                                                                <option value="Nursery or Kindergarten">Nursery or Kindergarten</option>
                                                                <option value="Primary School">Primary School</option>
                                                                <option value="Secondary School">Secondary School</option>
                                                                </select>
                                                                </div>
                                                
                                                                </div>
                                                                </div>
                                                                <?php
                                                                    $i = 0;
                                                                ?>
                                                                     @foreach ($rows as $row)
                                                                     <div class="">
                                                                    <input type="text"
                                                                        style="margin:5px 0px;height: 28px;width: 56%;"
                                                                        class="form-control" name="feeType[]"
                                                                        value="<?php echo $row->feeType; ?>"
                                                                        class="">
                                                                    <input type="text" data-parsley-type="number" 
                                                                        name="price[]"
                                                                        value="<?php echo $row->price; ?>"
                                                                        class="form-control ">

                                                                    <input type="hidden" name="id[]"
                                                                        value="<?php echo $school->id; ?>"
                                                                        class="form-control">

                                                                    </div>
                                                                     <?php $i += $school->id ?>
                                                                    @endforeach
                                                                <br>
                                                                <div id="add_new_deduc">
                                                                </div>
                                                                <div class="margin">
                                                                    <strong><a href="javascript:void(0);"
                                                                            id="add_more_deduc" class="addCF "><i
                                                                                class="fa fa-plus"></i>&nbsp;Add
                                                                            More</a></strong>
                                                                </div>




                                                                <div class="btn-bottom-toolbar text-right">
                                                                 
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-primary">Updates</button>
                                                                        <button type="button" onclick="history.back()"
                                                                        class="btn btn-sm btn-danger">Cancel</button>
                                                              
                                                                </div>
                                                               

                                                            </div>
                                                        </div>
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
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>
</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("school.show", ":id") }}';
        url = url.replace(':id', id)

        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
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


<script type="text/javascript">
 $(document).ready(function () {
        var maxAppend = 0;
        $("#add_more_deduc").click(function () {
            var add_new = $('<div class="row">\n\
    <div class="col-sm-12"><input type="text" name="feeType[]" style="margin:5px 0px;height: 28px;width: 56%;" class="form-control" placeholder="Enter School Fee Type" required></div>\n\
<div class="col-sm-9"><input  type="text" data-parsley-type="number" name="price[]" placeholder="Enter School Fee Price" required   class="form-control"></div>\n\
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