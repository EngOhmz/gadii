@extends('layouts.master')

@push('plugin-styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .sales-container {
        width: 100%;
        min-height: 100vh;
        margin: 0;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }
    
    .sales-card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        background: #fff;
        width: 100%;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-header {
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
        padding: 1rem 1.5rem;
        border-radius: 8px 8px 0 0;
        flex-shrink: 0;
    }
    
    .card-body {
        flex: 1;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        width: 100%;
    }
    
    .input-group {
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-radius: 4px;
        width: 100%;
    }
    
    .cart-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 1.5rem;
        background: #fff;
        border-radius: 4px;
        overflow-x: auto;
    }
    
    .cart-table th {
        background: #007bff;
        color: white;
        padding: 1rem;
        font-weight: 600;
    }
    
    .cart-table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #eee;
    }
    
    .cart-table tfoot td {
        font-weight: bold;
        background: #f8f9fa;
    }
    
    .remove-item {
        color: #dc3545;
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .remove-item:hover {
        color: #bd2130;
    }
    
    .quantity-input, .price-input {
        width: 100%;
        max-width: 80px;
        padding: 5px;
        border-radius: 4px;
    }
    
    .items-selection {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 4px;
        margin-bottom: 1.5rem;
        width: 100%;
    }
    
    .select2-container {
        width: 100% !important;
    }
    
    .select2-container .select2-selection--multiple {
        min-height: 38px;
        border: 1px solid #ced4da;
        width: 100%;
    }
    
    .btn-add-cart {
        margin-left: 1rem;
        padding: 0.5rem 1.5rem;
        width: 100%;
    }

    .sale-type-select {
        width: 100px;
    }

    @media (max-width: 768px) {
        .sales-container {
            padding: 0.5rem;
        }
        
        .card-header {
            padding: 0.8rem 1rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .form-group row {
            flex-direction: column;
        }
        
        .form-group .col-lg-4,
        .form-group .col-lg-8 {
            width: 100%;
            padding: 5px 0;
        }
        
        .items-selection .row {
            flex-direction: column;
        }
        
        .items-selection .col-md-8,
        .items-selection .col-md-2 {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .btn-add-cart {
            margin-left: 0;
            margin-top: 10px;
        }
    }
</style>
@endpush

@section('content')
<div class="">
    <div class="sales-card">
        <div class="card-header">
            <h4 class="card-title mb-0">Create New Sale</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('invoice.store') }}" style="display: flex; flex-direction: column; flex: 1;">
                @csrf
                
                <div class="row" style="flex-wrap: wrap;">
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Client Name <span class="required">*</span></label>
                        <div class="col-lg-4 mb-4">
                            <div class="form-group">
                                <select class="form-control" name="client_id" id="client_id" required>
                                    <option value="">Select Client Name</option>
                                    @if (!empty($client))
                                        @foreach ($client as $row)
                                            <option @if (isset($data)) {{ $data->client_id == $row->id ? 'selected' : '' }} @endif 
                                                    value="{{ $row->id }}">
                                                {{ $row->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <label class="col-lg-2 col-form-label">Location <span class="required">*</span></label>
                        <div class="col-lg-4 mb-4">
                            <div class="form-group">
                                <select class="form-control" name="location" required id="location">
                                    <option value="" disabled>Select Location</option>
                                    @if (!empty($location))
                                        @foreach ($location as $loc)
                                            <option @if (isset($data)) {{ $data->location == $loc->id ? 'selected' : '' }} @endif 
                                                    value="{{ $loc->id }}">
                                                {{ $loc->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Invoice Date <span class="required">*</span></label>
                        <div class="col-lg-4 mb-4">
                            <input type="date" 
                                   name="invoice_date" 
                                   id="invoice_date"
                                   value="{{ isset($data) ? $data->invoice_date : date('Y-m-d') }}" 
                                   class="form-control">
                        </div>
                        
                        <label class="col-lg-2 col-form-label">Sales Type <span class="required">*</span></label>
                        <div class="col-lg-4 mb-4">
                            <div class="form-group">
                                <select class="form-control" name="sales_type" id="sales" required>
                                    <option value="">Select Sales Type</option>
                                    <option value="Cash Sales" @if (isset($data)) {{ $data->sales_type == 'Cash Sales' ? 'selected' : '' }} @else selected @endif>
                                        Cash Sales
                                    </option>
                                    <option value="Credit Sales" @if (isset($data)) {{ $data->sales_type == 'Credit Sales' ? 'selected' : '' }} @endif>
                                        Credit Sales
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Sales Agent <span class="required">*</span></label>
                        <div class="col-lg-4 mb-4">
                            <div class="form-group">
                                @if (!empty($data->user_agent))
                                    <select class="form-control" name="user_agent" id="user_agent" required>
                                        <option value="" disabled>Select User</option>
                                        @if (isset($user))
                                            @foreach ($user as $row)
                                                <option @if (isset($data)) {{ $data->user_agent == $row->id ? 'selected' : '' }} @endif 
                                                        value="{{ $row->id }}">
                                                    {{ $row->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                @else
                                    <select class="form-control" name="user_agent" id="user_agent" required>
                                        <option value="" disabled>Select User</option>
                                        @if (isset($user))
                                            @foreach ($user as $row)
                                                @if ($row->id == auth()->user()->id)
                                                    <option value="{{ $row->id }}" selected>{{ $row->name }}</option>
                                                @else
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                @endif
                            </div>
                        </div>
                        <label class="col-lg-2 col-form-label">Branch</label>
                        <div class="col-lg-4 mb-4">
                            <div class="form-group">
                                <select class="form-control" name="branch_id" id="branch_id">
                                    <option>Select Branch</option>
                                    @if (!empty($branch))
                                        @foreach ($branch as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        @if (!empty($data->bank_id))
                            <label class="col-lg-2 col-form-label bank1" style="display:block;">Bank/Cash Account <span class="required">*</span></label>
                            <div class="col-lg-4 mb-4 bank2" style="display:block;">
                                <div class="form-group">
                                    <select class="form-control" name="bank_id" id="bank_id">
                                        <option value="" disabled>Select Payment Account</option>
                                        @foreach ($bank_accounts as $bank)
                                            <option value="{{ $bank->id }}" @if (isset($data)) @if ($data->bank_id == $bank->id) selected @endif @endif>
                                                {{ $bank->account_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <label class="col-lg-2 col-form-label bank1">Bank/Cash Account <span class="required">*</span></label>
                            <div class="col-lg-4 mb-4 bank2">
                                <div class="form-group">
                                    <select class="form-control" name="bank_id" id="bank_id">
                                        <option value="" disabled>Select Payment Account</option>
                                        @foreach ($bank_accounts as $bank)
                                            <option value="{{ $bank->id }}" @if (isset($data)) @if ($data->bank_id == $bank->id) selected @endif @endif>
                                                {{ $bank->account_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="items-selection">
                    <h5>Select Items</h5>
                    <div class="row align-items-end">
                        <div class="col-md-8">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="item_search" placeholder="Search items by name..." aria-label="Search items">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                            <select class="form-control select2" id="item_select" multiple>
                                @foreach ($name as $item)
                                    <option value="{{ $item->id }}" 
                                            data-name="{{ $item->name }}"
                                            data-price="{{ $item->sales_price ?? 0 }}"
                                            data-quantity="{{ $item->quantity ?? 0 }}">
                                        {{ $item->name }} ({{ $item->sales_price ?? 0 }} - Qty: {{ $item->quantity ?? 0 }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <input type="number" 
                                   id="item_quantity" 
                                   class="form-control" 
                                   min="1" 
                                   value="1" 
                                   placeholder="Qty">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-add-cart" 
                                    type="button" 
                                    id="add_to_cart">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <table class="cart-table" id="cart_table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Sale Type</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="cart_items"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">Grand Total</td>
                            <td id="cart_total">0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Container for dynamic hidden inputs -->
                <div id="hidden_inputs"></div>

                <div class="form-group row mt-4" style="width: 100%;">
                    <div class="col-lg-12 text-right">
                        <button type="submit" class="btn btn-success px-4">Create Sale</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('plugin-scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('#item_select').select2({
        placeholder: "Select items",
        allowClear: true,
        templateResult: formatItem,
        templateSelection: formatItemSelection
    });

    // Search functionality
    $('#item_search').on('keyup', function() {
        var searchText = $(this).val().toLowerCase();
        $('#item_select').empty(); // Clear current options

        // Filter items based on search text
        @foreach ($name as $item)
            var itemName = "{{ $item->name }}".toLowerCase();
            if (itemName.includes(searchText)) {
                $('#item_select').append(
                    '<option value="{{ $item->id }}" ' +
                    'data-name="{{ $item->name }}" ' +
                    'data-price="{{ $item->sales_price ?? 0 }}" ' +
                    'data-quantity="{{ $item->quantity ?? 0 }}">' +
                    '{{ $item->name }} ({{ $item->sales_price ?? 0 }} - Qty: {{ $item->quantity ?? 0 }})' +
                    '</option>'
                );
            }
        @endforeach

        // Refresh Select2 to update displayed options
        $('#item_select').trigger('change');
    });

    // Format item display in dropdown
    function formatItem(item) {
        if (!item.id) {
            return item.text;
        }
        var $item = $(
            '<span>' + item.text + '</span>'
        );
        return $item;
    }

    // Format selected item display
    function formatItemSelection(item) {
        return item.text;
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let cart = [];
    
    $('#item_select').select2({
        placeholder: "Select items to add",
        allowClear: true
    });

    document.getElementById('add_to_cart').addEventListener('click', function() {
        const select = document.getElementById('item_select');
        const quantityInput = document.getElementById('item_quantity');
        const selectedOptions = Array.from(select.selectedOptions);
        const quantity = parseInt(quantityInput.value) || 1;

        if (selectedOptions.length > 0) {
            selectedOptions.forEach(option => {
                const item = {
                    id: option.value,
                    name: option.dataset.name,
                    price: parseFloat(option.dataset.price),
                    quantity: quantity,
                    saleType: 'quantity' // Default sale type
                };

                const existingItemIndex = cart.findIndex(cartItem => cartItem.id === item.id);
                if (existingItemIndex > -1) {
                    cart[existingItemIndex].quantity += quantity;
                } else {
                    cart.push(item);
                }
            });

            updateCartDisplay();
            $('#item_select').val(null).trigger('change');
            quantityInput.value = 1;
        }
    });

    function updateCartDisplay() {
        const tbody = document.getElementById('cart_items');
        const hiddenInputsContainer = document.getElementById('hidden_inputs');
        tbody.innerHTML = '';
        hiddenInputsContainer.innerHTML = '';
        
        let grandTotal = 0;
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            grandTotal += itemTotal;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    ${item.name}
                    <input type="hidden" name="item_name[]" value="${item.id}">
                </td>
                <td>
                    <input type="number" 
                           class="form-control price-input" 
                           value="${item.price.toFixed(2)}" 
                           min="0" 
                           step="0.01"
                           data-index="${index}"
                           name="price[]">
                </td>
                <td>
                    <input type="number" 
                           class="form-control quantity-input" 
                           value="${item.quantity}" 
                           min="1" 
                           data-index="${index}"
                           name="quantity[]">
                </td>
                <td>
                    <select class="form-control sale-type-select" 
                            data-index="${index}"
                            name="sale_type[]">
                        <option value="quantity" ${item.saleType === 'quantity' ? 'selected' : ''}>Quantity</option>
                        <option value="crate" ${item.saleType === 'crate' ? 'selected' : ''}>Wholesale</option>
                    </select>
                </td>
                <td class="item-total">${itemTotal.toFixed(2)}</td>
                <td><span class="remove-item" data-index="${index}">Remove</span></td>
            `;
            tbody.appendChild(row);

            // Add hidden inputs for each item
            hiddenInputsContainer.innerHTML += `
                <input type="hidden" name="subtotal[]" value="${itemTotal}">
                <input type="hidden" name="tax[]" value="0">
                <input type="hidden" name="amount[]" value="${itemTotal}">
                <input type="hidden" name="discount[]" value="0">
                <input type="hidden" name="shipping_cost[]" value="0">
                <input type="hidden" name="adjustment[]" value="0">
                <input type="hidden" name="description[]" value="">
                <input type="hidden" name="tax_rate[]" value="0">
                <input type="hidden" name="unit[]" value="">
                <input type="hidden" name="total_cost[]" value="${itemTotal}">
                <input type="hidden" name="total_tax[]" value="0">
                <input type="hidden" name="filename[]" value="">
                <input type="hidden" name="original_filename[]" value="">
            `;
        });

        document.getElementById('cart_total').textContent = grandTotal.toFixed(2);

        // Event listeners for price changes
        document.querySelectorAll('.price-input').forEach(input => {
            input.addEventListener('change', function() {
                const index = this.dataset.index;
                cart[index].price = parseFloat(this.value) || 0;
                updateCartDisplay();
            });
        });

        // Event listeners for quantity changes
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const index = this.dataset.index;
                cart[index].quantity = parseInt(this.value) || 1;
                updateCartDisplay();
            });
        });

        // Event listeners for sale type changes
        document.querySelectorAll('.sale-type-select').forEach(select => {
            select.addEventListener('change', function() {
                const index = this.dataset.index;
                cart[index].saleType = this.value;
                updateCartDisplay();
            });
        });

        // Event listeners for remove buttons
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.dataset.index;
                cart.splice(index, 1);
                updateCartDisplay();
            });
        });
    }
});
</script>
@endpush
@endsection
