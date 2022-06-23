@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Farm Program</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Farm Program
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Farm Program</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 208.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Program Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">GAP</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Cost per acre</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Acre</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Total Cost</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Distributor</th>
                                              
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($price))
                                            @foreach ($price as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->name }}</td>
                                                  <td>{{$row-> farm_gap->process_name }}</td>
                                                <td>{{number_format($row->cost,2)}}</td>
                                                <td>{{$row->acre }}</td>
                                                 <td>{{number_format($row->total_cost,2)}}</td>
                                                 <td>{{$row->distributor }}</td>
                                                <td>
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="{{ route("farm_program.edit", $row->id)}}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4"
                                                        href="{{ route("farm_program.destroy", $row->id)}}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>


                                                </td>
                                            </tr>
                                      
                                        @php
                                $total=0;
                                   $total+=$row->total_cost;
                                       @endphp
                                            @endforeach

                                            @endif

                                        </tbody>
                                  <tfoot>
<tr>
<td ></td><td ></td><td ></td><td ></td>
<td ><b>Total</b></td>
<td><b>{{number_format($total,2)}}</b></td>
</tr>
</tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(!empty($id))
                                        <h5>Edit Farm Program</h5>
                                        @else
                                        <h5>Add New Farm Program</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('farm_program.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'farm_program.store']) }}
                                                @method('POST')
                                                @endif
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Program Name</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="name"
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">GAP</label>

                                                    <div class="col-lg-10">
                                                   <select class="form-control" name="gap" required
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                        @if(!empty($gap))
                                                                @foreach($gap as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->gap == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->process_name}} </option>

                                                                @endforeach
                                                                @endif
                                                     
                                                    </select>
                                                        
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Cost per acre</label>

                                                    <div class="col-lg-10">
                                                    <input type="number" name="cost" id="cost"
                                                            value="{{ isset($data) ? $data->cost : ''}}"
                                                            class="form-control" required  onkeyup="calculateDiscount();">
                                                        
                                                    </div>
                                                </div>

                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Acre</label>
                                                       
                                                    <div class="col-lg-10">
                                                   <input type="number" name="acre" id="acre"
                                                            value="{{ isset($data) ? $data->acre : ''}}"
                                                            class="form-control" required  onkeyup="calculateDiscount();">
                                                    </div>
                                                </div>

                                              <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Total Cost</label>
                                                       
                                                    <div class="col-lg-10">
                                                   <input type="number" name="total_cost" id="total_cost"
                                                            value="{{ isset($data) ? $data->total_cost : ''}}"
                                                            class="form-control" required readonly>
                                                    </div>
                                                </div>

                                                 <div class="form-group row"><label class="col-lg-2 col-form-label">Distributor</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="distributor"
                                                            value="{{ isset($data) ? $data->distributor : ''}}"
                                                            class="form-control">
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


$('.demo4').click(function() {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function() {
        swal("Deleted!", "Your imaginary file has been deleted.", "success");
    });
});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
function calculateDiscount() {

$('#cost,#acre').on('input',function() {
var price= parseInt($('#cost').val());
var qty = parseFloat($('#acre').val());
console.log(price);
$('#total_cost').val((qty* price ? qty * price : 0).toFixed(2));
});

}
    
    </script>
@endsection