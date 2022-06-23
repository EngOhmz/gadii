@extends('layouts.master')


@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Collection</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Collection
                                    List</a>
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
                                                    style="width: 186.484px;">Shipment Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Shipment Number</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">From</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">To</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Wheight</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Receiver naame</th>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($pacel))
                                            @foreach ($pacel as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->pacel_name}}</td>
                                                <td>{{$row->pacel_number}}</td>

                                                <td>{{$row->from}}</td>
                                                <td>{{$row->to}}</td>
                                                <td>{{$row->weight}}kg</td>
                                                <td>{{$row->amount}}TSh</td>
                                                <td>{{$row->receiver_name}}</td>


                                                <td>
                                                    @if($row->status == 1)

                                                    <div class="badge badge-info badge-shadow">Not Invoiced</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-success badge-shadow">Invoiced</div>
                                                    @elseif($row->status == 3)
                                                    <span class="badge badge-danger badge-shadow">Canceled</span>
                                                    @elseif($row->status == 4)
                                                    <span class="badge badge-success badge-shadow">Collected</span>
                                                    @elseif($row->status == 5)
                                                    <span class="badge badge-success badge-shadow">Loadded</span>
                                                    @elseif($row->status == 6)
                                                    <span class="badge badge-success badge-shadow">OffLoadded</span>
                                                    @elseif($row->status == 7)
                                                    <span class="badge badge-success badge-shadow">Derivered</span>
                                                    @endif
                                                </td>

                                                <td>
                                                                @if($row->status == 2  )
                                                                @can('edit-collection')
                                                                <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                                    id="delete-confirm"
                                                                    onclick="return confirm('are you sure?')"
                                                                    href="{{ route("collection.show", $row->id)}}">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                @endcan
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


@endsection

@section('scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
$('.delete-confirm').on('click', function(event) {

    //event.preventDefault();
    //const url = $(this).attr('href')
    const url = $(this).attr('href');
    Swal({
        title: 'Are you sure?',
        text: 'This record and it`s details will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
    }).then(function(value) {

        if (value) {
            window.location.href = url;
        }

    });
});

function deleteMember(e) {
    //event.preventDefault();
    //const url = $(this).attr('href');

    let id = $(e).data('id');
    let url = '{{ route("collection.show", ":id") }}';
    url = url.replace(':id', id);

    const url = " ";
    swal({
        title: 'Are you sure?',
        text: 'This record and it`s details will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
    }).then(function(value) {

        if (value) {
            window.location.href = url;
        }

    });

}
</script>

<!-- End  javascript for sweatalertpopup -->
@endsection