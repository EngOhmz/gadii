@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('farming.seeds_type')}}</h4>
                    </div>
                    <div class="card-body">

                        <ul class="nav nav-tabs" id="myTab2" role="tablist">

                            <button type="button" class="btn btn-outline-info btn-xs px-4" data-toggle="modal"
                                onclick="model(1,'add')" data-target="#appFormModal">
                                <i class="fa fa-plus-circle"></i>
                                Add
                            </button>


                        </ul>


                        <div class="tab-content tab-bordered" id="myTab3Content">

                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="">
                                    @can('view-purchase')
                                    <table class="table table-striped" id="appFormDatatable">
                                        <thead>
                                            <tr>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 141.219px;">
                                                    #.No</th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 141.219px;">
                                                    {{__('farming.seeds_name')}}</th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 141.219px;">
                                                    {{__('farming.seed_age')}}</th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 141.219px;">
                                                    {{__('farming.soil_type')}}</th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 141.219px;">
                                                    {{__('farming.water_volume')}}</th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 141.219px;">
                                                    {{__('farming.properties')}}</th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 141.219px;">
                                                    {{__('farming.harvest_volume')}}</th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 141.219px;">
                                                    {{__('farming.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    @endcan
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!--  Modal -->


<div class="modal fade bd-example-modal-lg" id="appFormModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

    </div>
</div>
</div>
</div>


<!-- route Modal -->

</div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
$(function() {
    let urlcontract = "{{ route('seeds_type.index') }}";
    $('#appFormDatatable').DataTable({
        processing: true,
        serverSide: true,
        lengthChange: true,
        searching: true,
        type: 'GET',
        ajax: {
            url: urlcontract,
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'nme'
            },
            {
                data: 'age',
                name: 'age'
            },
            {
                data: 'soil_type',
                name: 'soil_type'
            },
            {
                data: 'water_volume',
                name: 'water_volume'
            },
            {
                data: 'properties',
                name: 'properties'
            },
            {
                data: 'harvest_volume',
                name: 'harvest_volume',
                orderable: true,
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },

        ]
    })
});

function model(id, type) {
    let url = '{{ route("seeds_type.show", ":id") }}';
    url = url.replace(':id', id)
    $.ajax({
        type: 'GET',
        url: url,
        data: {
            'id': id,
            'type': type,
        },
        cache: false,
        async: true,
        success: function(data) {
            //alert(data);
            $('.modal-dialog').html(data);
        },
        error: function(error) {
            $('#appFormModal').modal('toggle');

        }
    });

}

function saveClient(e) {
    alert($('#address').val());

    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var phone = $('#phone').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var currency_code = $('currency_code').val();
    var tin = $('#tin').val;
    var vat = $('#vat').val;

    $.ajax({
        type: 'GET',
        url: '/courier/public/addClient/',
        data: {
            'fname': fname,
            'lname': lname,
            'phone': phone,
            'email': email,
            'address': address,
            'tin': tin,
            'vat': vat,
            'currency_code': currency_code,
        },
        cache: false,
        async: true,
        success: function(response) {
            var len = 0;
            if (response.data != null) {
                len = response.data.length;
            }

            if (len > 0) {
                $('#client').html("");
                for (var i = 0; i < len; i++) {
                    var id = response.data[i].id;
                    var name = response.data[i].fname;

                    var option = "<option value='" + id + "'>" + name + "</option>";

                    $("#client").append(option);
                    $('#appFormModal').hide();
                }
            }
        },
        error: function(error) {
            $('#appFormModal').modal('toggle');

        }
    });
}

function saveSeeds(e) {
    let url = "{{ route('seeds_type.store') }}";
    let form = $(e).closest('form');
    let formID = '#' + form.attr('id');
    let formElement = $(formID);

    var form1 = $('form')[0];

    let modal = $('#appFormModal');
    let loading = $('.ibox-loading');
    modal.find('.modal-content').addClass('d-none').removeClass('d-block');
    loading.removeClass('d-none').addClass('d-block');
    loading.children('.ibox-content').toggleClass('sk-loading');


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: 'POST',
        data: {
            'name': $('#name').val(),
            'age': $('#age').val(),
            'soil_type': $('#soil_type').val(),
            'water_volume': $('#water_volume').val(),
            'properties': $('#properties').val(),
            'harvest_volume': $('#harvest_volume').val(),
            

        },
        contentType: false,
        processData: false,
        success: function(res) {
            let oTable = $('#appFormDatatable').dataTable()
            oTable.fnDraw(false)
            modal.html("")
            modal.modal('toggle')
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            })
            Toast.fire({
                type: 'success',
                title: 'Information added successffully. '
            })
        },
        error: function(error) {
            modal.find('.modal-content-div').addClass('d-block').removeClass('d-none');
            loading.children('.ibox-content').toggleClass('sk-loading');
            loading.addClass('d-none').removeClass('d-block');

            if (error.status === 422) {
                let errorsJson = error.responseJSON.errors
                let errorString = ''
                Object.values(errorsJson).forEach(e => errorString += e[0] + '<br>')
                $('.errors').removeClass('d-none').addClass('d-block')
                    .html(errorString);
            }
            if (error.status === 423) {
                let errorsJson = error.responseJSON.errors
                let errorString = ''
                Object.values(errorsJson).forEach(e => errorString += e[0] + '<br>')
                $('.errors').removeClass('d-none').addClass('d-block')
                    .html(errorString);
            }

            console.log(error);
        }
    })
}

function updateSeeds(e) {
    let form = $(e).closest('form')
    let formID = '#' + form.attr('id')
    let formElement = $(formID)

    var form1 = $('form')[0];

    let id = $(e).data('id');
    let url = '{{ route("seeds_type.update", ":id") }}';
    url = url.replace(':id', id);

    let modal = $('#appFormModal');
    let loading = $('.ibox-loading');
    modal.find('.modal-content').addClass('d-none').removeClass('d-block');
    loading.removeClass('d-none').addClass('d-block');
    loading.children('.ibox-content').toggleClass('sk-loading');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: 'PUT',
        data: new FormData(form1),
        contentType: false,
        processData: false,
        success: function(res) {
            let oTable = $('#appFormDatatable').dataTable()
            oTable.fnDraw(false)
            modal.modal('toggle')
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            })
            Toast.fire({
                type: 'success',
                title: 'Information updated successffully. '
            })
        },
        error: function(error) {
            modal.find('.modal-content-div').addClass('d-block').removeClass('d-none');
            loading.children('.ibox-content').toggleClass('sk-loading');
            loading.addClass('d-none').removeClass('d-block');

            if (error.status === 422) {
                let errorsJson = error.responseJSON.errors
                let errorString = ''
                Object.values(errorsJson).forEach(e => errorString += e[0] + '<br>')
                $('.errors').removeClass('d-none').addClass('d-block')
                    .html(errorString);
            }
            if (error.status === 423) {
                let errorsJson = error.responseJSON.errors
                let errorString = ''
                Object.values(errorsJson).forEach(e => errorString += e[0] + '<br>')
                $('.errors').removeClass('d-none').addClass('d-block')
                    .html(errorString);
            }

            console.log(error);
        }
    })
}
</script>

@endsection