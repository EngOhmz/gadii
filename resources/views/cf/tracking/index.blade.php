@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Shipment Tracking</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Tracking List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cf.tracking.create') }}"
                                    role="tab" aria-selected="false">Update Status</a>
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
                                                <th>Shipment ID</th>
                                                <th>Last Status</th>
                                                <th>Last Updated By</th>
                                                <th>Last Updated Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($trackings as $track)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="#" class="shipment-id-link" data-shipment-id="{{ $track->shipment_id }}"
                                                       data-toggle="modal" data-target="#statusModal">
                                                        {{ $track->shipment_id }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $track->status == 'Delivered to Warehouse' ? 'success' : 
                                                                              ($track->status == 'Cleared' ? 'primary' : 
                                                                              ($track->status == 'Custom Clearance Started' ? 'info' : 
                                                                              ($track->status == 'Arrived at Port' ? 'secondary' : 
                                                                              ($track->status == 'In Transit' ? 'warning' : 
                                                                              ($track->status == 'Shipped' ? 'dark' : 
                                                                              ($track->status == 'Ready at Supplier' ? 'info' : 'light')))))) }}">
                                                        {{ ucfirst($track->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $track->addedByUser->name ?? 'Unknown' }}</td>
                                                <td>{{ $track->updated_at->format('Y-m-d H:i:s') }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5">No tracking records found</td>
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

<!-- Bootstrap Modal for Status History -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Shipment Status History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Shipment ID: <span id="modalShipmentId"></span></h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Updated By</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody id="statusTableBody">
                            <!-- Populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('.datatable-basic').DataTable({
        autoWidth: false,
        columnDefs: [],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '→', 'previous': '←' }
        },
    });

    // Handle shipment ID click to load status history
    $(document).on('click', '.shipment-id-link', function (e) {
        e.preventDefault();
        var shipmentId = $(this).data('shipment-id');

        // Update modal shipment ID
        $('#modalShipmentId').text(shipmentId);

        // Fetch statuses via AJAX
        $.ajax({
            url: '{{ url("/cf/tracking/statuses") }}/' + shipmentId,
            method: 'GET',
            success: function (response) {
                var tbody = $('#statusTableBody');
                tbody.empty();

                if (response.statuses.length > 0) {
                    response.statuses.forEach(function (status) {
                        tbody.append(`
                            <tr>
                                <td>${status.status}</td>
                                <td>${status.updated_by}</td>
                                <td>${status.updated_at}</td>
                            </tr>
                        `);
                    });
                } else {
                    tbody.append('<tr><td colspan="3">No status history found</td></tr>');
                }
            },
            error: function () {
                $('#statusTableBody').html('<tr><td colspan="3">Error loading statuses</td></tr>');
            }
        });
    });
</script>
@endsection
