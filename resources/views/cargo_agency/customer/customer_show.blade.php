@extends('layouts.master')

@push('plugin-styles')
    {!! Html::style('assets/css/loader.css') !!}
    {!! Html::style('plugins/apex/apexcharts.css') !!}
    {!! Html::style('assets/css/dashboard/dashboard_1.css') !!}
    {!! Html::style('plugins/flatpickr/flatpickr.css') !!}
    {!! Html::style('plugins/flatpickr/custom-flatpickr.css') !!}
    {!! Html::style('assets/css/elements/tooltip.css') !!}

    <script src="{{ asset('global_assets/js/plugins/forms/inputs/inputmask.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/uploaders/bs_custom_file_input.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/extensions/jquery_ui/core.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/tags/tagsinput.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/tags/tokenfield.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/inputs/touchspin.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/inputs/maxlength.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/inputs/formatter.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/form_floating_labels.js') }}"></script>
@endpush
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer List</h4>
                        </div>
                        <div class="card-body">
                            <div class="tab-content tab-bordered">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Customer Info</h5>
                                        </div>
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-5">
                                                    <p class="form-control-static"><strong>Customer Name:
                                                </div>
                                                <div class="col-7">
                                                    <p class="form-control-static"><strong>Receivers Name:
                                                </div>
                                            </div>
                                            <hr><br>

                                            <div class="row">
                                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                    <div class="panel panel-custom">
                                                        <div class="panel-heading">
                                                            <div class="panel-title">
                                                                <h6>Customer Info and Cargo</h6><br>
                                                            </div>
                                                        </div>

                                                        <div class="panel-body">
                                                            <div class="card-body table-responsive">
                                                                <table class="table table-bordered table-striped bg-light">

                                                                    <?php
                                                                         if (!empty($data)):foreach ($data as $row):
                                                                        ?>
                                                                    <tr>
                                                                        <th>Cargo Name:</th>
                                                                        <td><strong><?php echo $row->name; ?></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>From:</th>
                                                                        <td><strong><?php echo $row->mzigo_unapotoka; ?></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>To:</th>
                                                                        <td><strong><?php echo $row->mzigo_unapokwenda; ?></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Quantity:</th>
                                                                        <td><strong><?php echo $row->idadi; ?></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Price:</th>
                                                                        <td><strong><?php echo $row->bei; ?></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Money Received:</th>
                                                                        <td><strong><?php echo $row->ela_iliyopokelewa; ?></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Total:</th>
                                                                        <td><strong><?php echo $row->jumla; ?></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Receipt:</th>
                                                                        <td><strong><?php echo $row->receipt; ?></strong></td>
                                                                    </tr>
                                                                    <?php endforeach; ?>
                                                                    <?php else: ?>

                                                                    <tr>NO DATA FOUND</tr>

                                                                    <?php endif; ?>
                                                                </table>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    <div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        </div>
    </div>
@endsection

@push('plugin-scripts')
    {!! Html::script('assets/js/loader.js') !!}
    {!! Html::script('plugins/apex/apexcharts.min.js') !!}
    {!! Html::script('plugins/flatpickr/flatpickr.js') !!}
    {!! Html::script('assets/js/dashboard/dashboard_1.js') !!}
@endpush

@push('custom-scripts')
    <script type="text/javascript">
        $(function() {



            var table = $('.data-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: "{{ route('list_ya_wateja.index') }}",

                columns: [

                    {
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'mteja',
                        name: 'mteja'
                    },

                    {
                        data: 'mpokeaji',
                        name: 'mpokeaji'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },

                ]

            });


            $.fn.dataTable.ext.errMode = 'none';

            $('#table').on('error.dt', function(e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            });



        });
    </script>

    <script type="text/javascript">
        function model(id, type) {

            let url = '{{ route('list_ya_wateja.detail', ':id') }}';
            url = url.replace(':id', id)

            $.ajax({
                type: 'GET',
                url: url,
                data: {
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
    </script>
@endpush
