<!-- Default dropstart button -->
<a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown">
    Select Action
    <span class="d-none d-lg-inline-block ml-2"></span>
</a>
<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-150">
    <div class="dropdown-content-body p-2">
        <ul class="media-list">

            <li><a href="{{ route('pacel_show', $row->id) }}" class="btn btn-warning">View
                    More</a>
            </li>
            <br>
            <li><a href="{{ route('car.show', $row->id) }}" class="btn btn-primary">Print
                    Delivery</a></li>
            <br>
            <li>
                <a type="button" class="btn btn-warning btn-xs" onclick="editbtn({{ $row->id }})"
                    data-toggle="modal" data-target="#exampleModalCenter">
                    Edit Cargo
                </a>
            </li>
            <br>

            <li>
                <a class="btn btn-danger" href="{{ route('pacel_delete', $row->id) }}" role="button">Delete</a><br>
            </li>
            <br>

            <li>
                <a type="button" class="btn btn-success btn-xs" onclick="moneybtn({{ $row->id }})"
                    data-toggle="modal" data-target="#exampleModalCenter22">

                    Receive Money
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Mzigo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form data-parsley-validate class="form-horizontal form-label-left" action="{{ route('pacel.update') }}"
                method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="pacel_id" id="pacel_id" value="">
                    <div class="form-group form-group-float">
                        <label class="control-label">Jina la Mteja</label>
                        <input type="text" class="form-control" name="mteja" id="mteja">
                    </div>
                    <div class="form-group form-group-float">
                        <label class="control-label">Jina la Mpokeaji</label>
                        <input type="text" class="form-control" name="mpokeaji" id="mpokeaji">
                    </div>
                    <div class="form-group form-group-float">
                        <label class="control-label">jina la mzigo</label>
                        <input type="text" name="name" class="form-control" id="pacelName" required>
                    </div>
                    <div class="form-group form-group-float">
                        <label class="control-label">idadi ya mizigo</label>
                        <input type="number" class="form-control" name="idadi" id="pacelIdadi">
                    </div>
                    <div class="form-group form-group-float">
                        <label class="control-label">bei ya kila mzigo</label>
                        <input type="number" class="form-control" name="bei" id="pacelBei">
                    </div>
                    <div class="form-group form-group-float">
                        <label class="control-label">jumla kuu</label>
                        <input type="number" class="form-control" name="jumla" id="pacelJumla" readonly>
                    </div>
                    <div class="form-group form-group-float">
                        <label class="control-label">ela iliyopokelewa</label>
                        <input type="number" class="form-control" name="ela_iliyopokelewa" id="pacelEla_iliyopokelewa">
                    </div>
                    <div class="form-group form-group-float">
                        <label class="control-label">mzigo ulipotoka</label>
                        <input type="text" class="form-control" name="mzigo_unapotoka" id="pacelMzigo_unapotoka">
                    </div>
                    <div class="form-group form-group-float">
                        <label class="control-label">mzigo unapokwenda</label>
                        <input type="text" class="form-control" name="mzigo_unapokwenda"
                            id="pacelMzigo_unapokwenda">
                    </div>

                    <div class="border p-3 rounded">
                        <label class="">Je ?</label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="receipt" id="cr_l_i_s"
                                value="R" checked>
                            <label class="custom-control-label" for="cr_l_i_s">Una Risiti</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" value="HR" name="receipt"
                                id="cr_l_i_u">
                            <label class="custom-control-label" for="cr_l_i_u">Hauna Risiti</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Mzigo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<br>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter22" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle22" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle22">Receive Money</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form data-parsley-validate class="form-horizontal form-label-left" action="{{ route('money.update') }}"
                method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="pacel_id" id="pacel_id2" value="">
                    <div class="form-group form-group-float">
                        <label class="control-label">ela iliyopokelewa</label>
                        <input type="number" class="form-control" name="ela_iliyopokelewa"
                            id="pacelEla_iliyopokelewa2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update changes</button>
                </div>

            </form>
        </div>
    </div>
</div>



<script>
    function editbtn(id) {
        let url = '{{ route('pacel.edit', ':id') }}';
        url = url.replace(':id', id)

        // var id = $(this).val();


        $.ajax({

            type: 'GET',
            url: url,

            success: function(response) {
                $('#pacel_id').val(response.paceldata.id);
                $('#mteja').val(response.paceldata.mteja);
                $('#mpokeaji').val(response.paceldata.mpokeaji);
                $('#pacelName').val(response.paceldata.name);
                $('#pacelIdadi').val(response.paceldata.idadi);
                $('#pacelBei').val(response.paceldata.bei);
                $('#pacelJumla').val(response.paceldata.jumla);
                $('#pacelEla_iliyopokelewa').val(response.paceldata.ela_iliyopokelewa);
                $('#pacelMzigo_unapotoka').val(response.paceldata.mzigo_unapotoka);
                $('#pacelMzigo_unapokwenda').val(response.paceldata.mzigo_unapokwenda);
                //   $('#pacel_id').val(id);
            }
        });

    }

    function moneybtn(id) {
        let url = '{{ route('money.edit', ':id') }}';
        url = url.replace(':id', id)

        $.ajax({

            type: 'GET',
            url: url,

            success: function(response) {
                $('#pacel_id2').val(response.paceldata2.id);
                $('#pacelEla_iliyopokelewa2').val(response.paceldata2.ela_iliyopokelewa);
            }
        });

    }
</script>
