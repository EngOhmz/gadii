@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Shipment Planning</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Shipment List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cf.shipment-planning.create') }}"
                                    role="tab" aria-selected="false">New Shipment</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade active show" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Supplier ID</th>
                                                <th>Shipment ID</th>
                                                <th>Type</th>
                                                <th>Quantity</th>
                                                <th>Value</th>
                                                <th>Port Origin</th>
                                                <th>Port Entry</th>
                                                <th>ETD</th>
                                                <th>ETA</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($shipments as $shipment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $shipment->supplier ? $shipment->supplier->name : 'N/A' }}</td>
                                                <td>{{ $shipment->shipment_id }}</td>
                                                <td>{{ $shipment->type }}</td>
                                                <td>{{ $shipment->quantity }}</td>
                                                <td>{{ $shipment->value }}</td>
                                                <td>{{ $shipment->port_origin }}</td>
                                                <td>{{ $shipment->port_entry }}</td>
                                                <td>{{ $shipment->etd }}</td>
                                                <td>{{ $shipment->eta }}</td>
                                                <td>
    <span class="badge badge-{{ $shipment->status == 'Delivered to Warehouse' ? 'success' : 
                              ($shipment->status == 'Cleared' ? 'primary' : 
                              ($shipment->status == 'Custom Clearance Started' ? 'info' : 
                              ($shipment->status == 'Arrived at Port' ? 'secondary' : 
                              ($shipment->status == 'In Transit' ? 'warning' : 
                              ($shipment->status == 'Shipped' ? 'dark' : 'light'))))) }}">
        {{ ucfirst($shipment->status) }}
    </span>
</td>
                    
                                                <td>
                                                    <div class="form-inline">
                                                        <div class="input-group">
                                                            <a class="list-icons-item text-primary"
                                                               href="{{ route('cf.shipment-planning.edit', $shipment->id) }}">
                        
                                                                <i class="icon-pencil7"></i>
                                                            </a>
                                                        </div>
                                                       @if($shipment->status == 'Custom Clearance Started')
    <div class="input-group">
        <a class="list-icons-item text-primary"
           href="#"
           title="Convert or Start Clearing and Forwarding"
           data-toggle="tooltip">
            <i class="icon-loop"></i>
        </a>
    </div>
@endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="12">No shipments found</td>
                                            </tr>
                                            @endforelse
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
<script>
    $('.datatable-basic').DataTable({
        autoWidth: false,
        "columnDefs": [
            {"orderable": false, "targets": [11]}
        ],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        "language": {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '→', 'previous': '←' }
        },
    });
</script>
@endsection
