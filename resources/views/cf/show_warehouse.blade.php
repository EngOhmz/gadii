<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModal">Manage Warehouse</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="card-header text-primary">Storage Details</div>

        <div class="row">
            <div class="col-sm-12 ">
                <div class="row">
                    <div class="col-6">

                        <strong>Storage Charge :</strong>
                        {{ $storage->store_charge }}
                    </div>
                    <div class="col-6">
                        <strong>Storage Start date :</strong>
                        {{ $storage->store_start_date }}
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-6">

                        <strong>Due Date :</strong>
                        {{ $storage->due_date }}
                    </div>
                    <div class="col-6">
                        <strong>Charge Start Due Date :</strong>
                        {{ $storage->charge_start }}
                    </div>
                </div>


            </div>
        </div>
    

    <div class="card-header text-primary">Stock Movement Details</div>

    <div class="row">
        <div class="col-sm-12 ">
            <div class="row">
                <div class="col-6">
                      @php $source = App\Models\Location::find($stock->source_store)->name; @endphp
                    <strong>Source Location :</strong>
                    {{ $source }}
                </div>
                <div class="col-6">
                    @php $distination = App\Models\Location::find($stock->destination_store)->name; @endphp
                    <strong>Distination Location :</strong>
                    {{ $distination }}
                </div>
            </div><br>

            <div class="row">
                <div class="col-6">

                    <strong>Date :</strong>
                    {{ $stock->movement_date }}
                </div>
                <div class="col-6">
                  @php $staff = App\Models\User::find($stock->staff)->name; @endphp
                    <strong>Staff:</strong>
                    {{ $staff }}
                </div>
            </div>

            {{-- <div class="row">
                    <div class="col-6">
                        
                        <strong>Refference :</strong>
                        {{ $stock->due_date }}
                    </div>
                    <div class="col-6">
                        <strong>Transport:</strong>
                        {{ $stock->charge_start }}
                    </div>
                </div> --}}


        </div>
    </div>
</div>

@yield('scripts')
