@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Inventory List</h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Serial No</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Inventory</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Location</th>
                                               <!-- <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Truck</th>-->
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                   style="width: 141.219px;">Status</th>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($tyre))
                                            @foreach ($tyre as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                @if($row->assign_reference == '0')
                                                <td>{{ $row->serial_no }}  </td>                                                                                                     
                                                @else
                                                <td>{{ $row->reference }} </td>
                                                @endif
                                                <td>{{$row->brand->name}}</td>
                                                <td>{{$row->tyre_location->name}}</td>
                                                
                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-primary badge-shadow">Available</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-warning badge-shadow">Returned</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-info badge-shadow">Sold</div>
                                                    @elseif($row->status == 3)
                                                   <div class="badge badge-success badge-shadow">Issued to  {{$row->truck->truck_name}} - {{$row->truck->reg_no}} </div>
                                                   @elseif($row->status == 4)
                                                    <div class="badge badge-danger badge-shadow">Disposed</div>
                                                     @elseif($row->status == 5)
                                                    <div class="badge badge-warning badge-shadow">Expired</div>

                                                    @endif
                                                </td>
                                        
                                                <td> 
                                                 @if($row->status == '0')
                                                <a data-toggle="modal" href=""  value="{{ $row->id}}" data-type="assign" data-target="#appFormModal"
                                                    onclick="model({{ $row->id }},'reference')">Update Serial No </a>    
                                                    @endif
                                                </td>
                                               
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
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
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>

@endsection

@section('scripts')


<script type="text/javascript">
    function model(id,type) {

$.ajax({
    type: 'GET',
     url: '{{url("inventory/invModal")}}',
    data: {
        'id': id,
        'type':type,
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

    </script>
@endsection