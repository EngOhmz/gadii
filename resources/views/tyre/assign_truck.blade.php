@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Truck</h4>
                    </div>
                    <div class="card-body">
                       
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
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 86.484px;">Truck Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Reg No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Truck Type</th>
                                                 
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Tire</th>                                          
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Assigned By</th>
                                                   
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($truck))
                                            @foreach ($truck as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->truck->truck_name }}</td>
                                                <td>{{$row->truck->reg_no}}</td>
                                                <td>{{$row->truck->truck_type}}</td>                                                
                                                <td>  
                                           @if($row->status == '1' || $row->status == '2' )   
                                             <a title="Assign"
                                                    data-toggle="modal" href=""  value="{{ $row->truck_id}}" data-type="list" data-target="#appFormModal"
                                                    onclick="model({{ $row->truck_id }},'list')">View Tire List
                                                        </a> 
                                              @else
                                    
                                             @endif                                               
                                             </td>
                                               @if(!empty($row->staff ))
                                                 <td>{{$row->mechanical->name}}</td>
                                                @else
                                                     <td></td>
                                                @endif

                                                @if($row->status == '0' || $row->status == '1' )
                                                <td> <a  title="Assign"
                                                    data-toggle="modal" href=""  value="{{ $row->truck_id}}" data-type="assign" data-target="#appFormModal"
                                                    onclick="model({{ $row->truck_id }},'assign')">Assign
                                                        </a> 
                                                </td>
                                                @else
                                                <td><div class="badge badge-success badge-shadow">Assigned </div></td>
                                                @endif
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
    <div class="modal-dialog modal-lg">
    </div>
</div>


@endsection

@section('scripts')


<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [3]}
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
    function model(id,type) {

$.ajax({
    type: 'GET',
     url: '{{url("tyre/tyreModal")}}',
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


<script type="text/javascript">
$(document).ready(function() {

    $(document).on('click', '.remove_1', function() {
        $(this).closest('tr').remove();
       
    });
  $(document).on('click', '.remove_2', function() {
        $(this).closest('tr').remove();
       
    });

  $(document).on('click', '.remove_3', function() {
        $(this).closest('tr').remove();
       
    });
     $(document).on('click', '.remove_4', function() {
        $(this).closest('tr').remove();
       
    });
     $(document).on('click', '.remove_5', function() {
        $(this).closest('tr').remove();
       
    });
     $(document).on('click', '.remove_6', function() {
        $(this).closest('tr').remove();
       
    });

  
});
</script>

@endsection