@extends('layouts.master')

@section('content')
<style>
    .delivery-card {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: none;
    }
    .detail-label {
        color: #6777ef;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .detail-value {
        margin-bottom: 15px;
        color: #34395e;
    }
    .table thead th {
        background-color: #6777ef;
        color: white;
        border: none;
    }
    .table tbody tr:hover {
        background-color: #f8f9fc;
    }
    .grand-total {
        background-color: #f4f6fd;
        font-weight: bold;
    }
</style>

<section class="section">
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-12">
                <div class="card delivery-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="m-0">Delivery Details - Sale #{{ $invoice->id }}</h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Part 1: Client Details -->
                        <div class="card mb-4 delivery-card">
                            <div class="card-header bg-light">
                                <h5 class="m-0">Client Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="detail-label">Name</div>
                                        <div class="detail-value">{{ $clientDetails->name }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-label">Phone</div>
                                        <div class="detail-value">{{ $clientDetails->phone }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-label">Address</div>
                                        <div class="detail-value">{{ $clientDetails->address }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Part 2: Company Details -->
                        <div class="card mb-4 delivery-card">
                            <div class="card-header bg-light">
                                <h5 class="m-0">Company Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="detail-label">Name</div>
                                        <div class="detail-value">{{ $company->name }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-label">Phone</div>
                                        <div class="detail-value">{{ $company->phone }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-label">Address</div>
                                        <div class="detail-value">{{ $company->address }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                       <!-- Part 3: Delivery Guy Details -->
                        <div class="card mb-4 delivery-card">
                            <div class="card-header bg-light">
                                <h5 class="m-0">Delivery Guy Details</h5>
                                <button type="button" class="btn btn-sm btn-primary float-right" 
                                        data-toggle="modal" data-target="#driverModal">
                                    <i class="fas fa-user-plus mr-1"></i> Assign Driver
                                </button>
                            </div>
                            <div class="card-body">
                                @if($deliveryDetails && $deliveryDetails->driver)
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="detail-label">Name</div>
                                            <div class="detail-value">{{ $deliveryDetails->driver->name }}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="detail-label">Phone</div>
                                            <div class="detail-value">{{ $deliveryDetails->driver->phone }}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="detail-label">Plate Number</div>
                                            <div class="detail-value">{{ $deliveryDetails->plate_number }}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="detail-label">Licence</div>
                                            <div class="detail-value">{{ $deliveryDetails->driver->licence }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-12 text-center text-muted">
                                            <p>No driver assigned yet. Click "Assign Driver" to add one.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Part 4: Item Details -->
                        <div class="card delivery-card">
                            <div class="card-header bg-light">
                                <h5 class="m-0">Item Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($items as $item)
                                                <tr>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ number_format($item->price, 2) }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ number_format($item->total, 2) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">No items found</td>
                                                </tr>
                                            @endforelse
                                            <tr class="grand-total">
                                                <td colspan="3" class="text-right">Grand Total:</td>
                                                <td>{{ number_format(array_sum(array_column($items, 'total')), 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <button type="button" class="btn btn-primary float-right px-4 py-2" 
                                data-toggle="modal" data-target="#deliveryNotificationModal" 
                                data-id="{{ $invoice->id }}"
                                data-company-phone="{{ $company->phone ?? 'N/A' }}"
                                data-client-phone="{{ $clientDetails->phone ?? 'N/A' }}"
                                data-driver-phone="{{ $deliveryDetails->driver->phone ?? 'N/A' }}"
                                data-invoice-id="{{ $invoice->id }}"
                                data-client-name="{{ $clientDetails->name ?? 'N/A' }}"
                                data-driver-name="{{ $deliveryDetails->driver->name ?? 'N/A' }}"
                                data-plate-number="{{ $deliveryDetails->plate_number ?? 'N/A' }}"
                                data-client-address="{{ $clientDetails->address ?? 'N/A' }}">
                            <i class="fas fa-sync-alt mr-2"></i>Send Delivery Notification
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Delivery Notification Modal -->
<div class="modal fade" id="deliveryNotificationModal" tabindex="-1" role="dialog" aria-labelledby="deliveryNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="deliveryNotificationModalLabel">Deliver Package: Send Notification of Delivery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Company Notification -->
                <div class="mb-4">
                    <h6 class="text-muted">Company</h6>
                    <div class="form-group">
                        <label for="company_phone">Phone</label>
                        <input type="text" class="form-control" id="company_phone" readonly>
                    </div>
                    <div class="form-group">
                        <label for="company_message">Message</label>
                        <textarea class="form-control" id="company_message" rows="3"></textarea>
                    </div>
                </div>

                <!-- Customer Notification -->
                <div class="mb-4">
                    <h6 class="text-muted">Customer</h6>
                    <div class="form-group">
                        <label for="customer_phone">Phone</label>
                        <input type="text" class="form-control" id="customer_phone" readonly>
                    </div>
                    <div class="form-group">
                        <label for="customer_message">Message</label>
                        <textarea class="form-control" id="customer_message" rows="3"></textarea>
                    </div>
                </div>

                <!-- Driver Notification -->
                <div class="mb-4">
                    <h6 class="text-muted">Dereva</h6>
                    <div class="form-group">
                        <label for="driver_phone">Phone</label>
                        <input type="text" class="form-control" id="driver_phone" readonly>
                    </div>
                    <div class="form-group">
                        <label for="driver_message">Message</label>
                        <textarea class="form-control" id="driver_message" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendNotifications">Send Notifications</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#deliveryNotificationModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var invoiceId = button.data('id');
    
            // Preloaded data from Blade (fallback if AJAX fails)
            var companyPhone = button.data('company-phone');
            var clientPhone = button.data('client-phone');
            var driverPhone = button.data('driver-phone');
            var invoiceIdFromData = button.data('invoice-id');
            var clientName = button.data('client-name');
            var driverName = button.data('driver-name');
            var plateNumber = button.data('plate-number');
            var clientAddress = button.data('client-address');
    
            // Normalize phone numbers for input fields (starts with 255)
            function normalizePhone(phone) {
                if (!phone || phone === 'N/A' || phone.trim() === '') return '255000000000';
                phone = phone.trim();
                if (phone.startsWith('0')) {
                    return '255' + phone.slice(1);
                } else if (!phone.startsWith('255')) {
                    return '255' + phone;
                }
                return phone;
            }
    
            // Denormalize phone numbers for messages (starts with 0)
            function denormalizePhone(phone) {
                if (!phone || phone === 'N/A' || phone.trim() === '') return '0700000000';
                phone = phone.trim();
                if (phone.startsWith('255')) {
                    return '0' + phone.slice(3);
                } else if (!phone.startsWith('0')) {
                    return '0' + phone;
                }
                return phone; // Return as is if already starts with 0
            }
    
            // Populate fields with preloaded data initially
            document.getElementById('company_phone').value = normalizePhone(companyPhone);
            document.getElementById('customer_phone').value = normalizePhone(clientPhone);
            document.getElementById('driver_phone').value = normalizePhone(driverPhone);
    
            // Use denormalized phone numbers in messages
            document.getElementById('company_message').value = 
                `Habari, Package Invoice #${invoiceIdFromData}, umetoka dukani, itakua delivered kwa mteja: ${clientName} na dereva: ${driverName} [Pikipiki] mwenye plate number: ${plateNumber}. Asante.`;
            document.getElementById('customer_message').value = 
                `Habari ${clientName}, Package Invoice #${invoiceIdFromData}, imetoka dukani, itakua delivered kwako na dereva, jina: ${driverName} [Pikipiki] mwenye plate number: ${plateNumber}. Number ya simu ya dereva ni: ${denormalizePhone(driverPhone)}. Asante.`;
            document.getElementById('driver_message').value = 
                `Habari ${driverName}, Package Invoice #${invoiceIdFromData}, imetoka dukani, unatakiwa kuifikisha kwa mteja, jina: ${clientName} eneo la ${clientAddress}. Number ya simu ya mteja ni: ${denormalizePhone(clientPhone)}. Asante.`;
    
            // Attempt to fetch fresh data via AJAX
            fetch(`/pos/sales/pos/delivery/${invoiceId}/notifications`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    // Update with fresh data if AJAX succeeds
                    document.getElementById('company_phone').value = normalizePhone(data.company.phone);
                    document.getElementById('customer_phone').value = normalizePhone(data.client.phone);
                    document.getElementById('driver_phone').value = normalizePhone(data.driver.phone);
    
                    document.getElementById('company_message').value = 
                        `Habari, Package Invoice #${data.invoice.id}, umetoka dukani, itakua delivered kwa mteja: ${data.client.name} na dereva: ${data.driver.name} [Pikipiki] mwenye plate number: ${data.plate_number}. Asante.`;
                    document.getElementById('customer_message').value = 
                        `Habari ${data.client.name}, Package Invoice #${data.invoice.id}, imetoka dukani, itakua delivered kwako na dereva, jina: ${data.driver.name} [Pikipiki] mwenye plate number: ${data.plate_number}. Number ya simu ya dereva ni: ${denormalizePhone(data.driver.phone)}. Asante.`;
                    document.getElementById('driver_message').value = 
                        `Habari ${data.driver.name}, Package Invoice #${data.invoice.id}, imetoka dukani, unatakiwa kuifikisha kwa mteja, jina: ${data.client.name} eneo la ${data.client.address}. Number ya simu ya mteja ni: ${denormalizePhone(data.client.phone)}. Asante.`;
                })
                .catch(error => {
                    console.error('Error fetching notification data:', error);
                    // Fallback to preloaded data is already set
                });
        });
    
        // Handle Send Notifications
        document.getElementById('sendNotifications').addEventListener('click', function () {
            alert('Notifications would be sent here!');
            $('#deliveryNotificationModal').modal('hide');
        });
    });
    </script>





<!-- Driver Assignment Modal -->
<div class="modal fade" id="driverModal" tabindex="-1" role="dialog" aria-labelledby="driverModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="driverModalLabel">Assign Delivery Driver</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">×</span>
                </button>
            </div>
            <form method="POST" action="{{ route('assign_driver', ['id' => $invoice->id]) }}" id="driverForm">
                @csrf
                <div class="modal-body">
                    <!-- Select Existing Driver -->
                    <div class="form-group">
                        <label for="driver_id">Select Driver</label>
                        <select class="form-control" id="driver_id" name="driver_id" onchange="toggleNewDriverFields()">
                            <option value="">-- Select a Driver --</option>
                            @foreach ($drivers ?? [] as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->name }} ({{ $driver->phone }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Plate Number (required for all cases) -->
                    <div class="form-group">
                        <label for="plate_number">Plate Number</label>
                        <input type="text" class="form-control" id="plate_number" name="plate_number" 
                               placeholder="Enter plate number" required>
                    </div>

                    <!-- New Driver Fields (hidden by default) -->
                    <hr>
                    <h6 class="text-muted">Or Add New Driver</h6>
                    <div id="newDriverFields">
                        <div class="form-group">
                            <label for="driver_name">Name</label>
                            <input type="text" class="form-control" id="driver_name" name="driver_name" 
                                   placeholder="Enter driver name">
                        </div>
                        <div class="form-group">
                            <label for="driver_phone">Phone</label>
                            <input type="text" class="form-control" id="driver_phone" name="driver_phone" 
                                   placeholder="Enter phone number">
                        </div>
                        <div class="form-group">
                            <label for="driver_licence">Licence</label>
                            <input type="text" class="form-control" id="driver_licence" name="driver_licence" 
                                   placeholder="Enter licence number">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Driver</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleNewDriverFields() {
        const driverId = document.getElementById('driver_id').value;
        const newDriverFields = document.getElementById('newDriverFields');
        const newDriverInputs = newDriverFields.getElementsByTagName('input');
        
        if (driverId) {
            newDriverFields.style.display = 'none';
            for (let input of newDriverInputs) {
                input.removeAttribute('required');
                input.value = ''; // Clear new driver fields when selecting existing
            }
        } else {
            newDriverFields.style.display = 'block';
            for (let input of newDriverInputs) {
                input.setAttribute('required', 'required');
            }
        }
    }

    // Run on page load
    document.addEventListener('DOMContentLoaded', toggleNewDriverFields);
</script>

@endsection