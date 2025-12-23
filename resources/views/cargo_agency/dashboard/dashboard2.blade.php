@extends('layouts.master')
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Cargo </h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">New Cargo
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            <h5>New Cargo</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    {{ Form::open(['route' => 'dashboard.store']) }}
                                                    @method('POST')
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="form-group row">
                                                                    <label class="col-lg-4 col-form-label">Customer Name</label>
                                                                    <div class="col-lg-8">
                                                                        <select class="m-b account_id" id="client_id" name="mteja">
                                                                            <option value="">Select Here</option>                                                    
                                                                                @foreach ($client as $row)                                                             
                                                                                <option value="{{$row->name}}">{{$row->name}}</option>
                                                                                @endforeach
                                                                         </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-lg-4 col-form-label">Receivers Name</label>
                                                                    <div class="col-lg-8">
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" name="mpokeaji"
                                                                                class="form-control"
                                                                                placeholder="Receiver....." required />

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if (isset($customer_ID))
                                                        <div align="center">
                                                            <a class="btn btn-primary"
                                                                href="{{ route('pacel_reg', $customer_ID) }}"
                                                                role="button">Print Receipt</a>
                                                        </div>
                                                    @endif
                                               
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="cart">
                                                                    <tr>
                                                                        <th>Cargo Name:</th>
                                                                        <td><input type="text" name="name[]"
                                                                                class="form-control item_name2[]"
                                                                                 id="name"
                                                                                required /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Quantity:</th>
                                                                        <td><input type="number" name="quantity[]"
                                                                                step="any"
                                                                                class="form-control item_quantity"
                                                                                id="quantity"
                                                                                required /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Price:</th>
                                                                        <td><input type="number" name="price[]"
                                                                                step="any"
                                                                                class="form-control item_price" value="" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Total:</th>
                                                                        <td><input type="text" name="total_cost[]"
                                                                                class="form-control item_total" readonly
                                                                                jAutoCalc="{quantity} * {price}" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Money Received:</th>
                                                                        <td><input type="number" name="ela_iliyopokelewa[]"
                                                                                step="any" class="form-control"
                                                                                value="" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>From:</th>
                                                                        <td><input type="text" name="from[]"
                                                                                class="form-control item_from[]" /></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>To:</th>
                                                                        <td><input type="text" name="to[]"
                                                                                class="form-control item_to[]" required />
                                                                        </td>
                                                                    </tr>


                                                                    <tr>
                                                                        <th>Receipt:</th>
                                                                        <td>

                                                                            <div class="form-check">
                                                                                <input type="radio"
                                                                                    class="form-check-input" id="radio1"
                                                                                    name="receipt[]" value="R"
                                                                                    checked>R
                                                                                <label class="form-check-label"
                                                                                    for="radio1"></label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input type="radio"
                                                                                    class="form-check-input"
                                                                                    id="radio2" name="receipt[]"
                                                                                    value="HR">HR
                                                                                <label class="form-check-label"
                                                                                    for="radio2"></label>
                                                                            </div>

                                                                        </td>


                                                                    </tr>



                                                                </table>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-3">
                                                        </div>

                                                    </div>


                                                    <br>
                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">

                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                type="submit" id="save">Save</button>

                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
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

         <!-- supplier Modal -->
    <div class="modal fade " data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-lg">

        </div>
    </div>


    <div class="modal fade " data-backdrop="" id="app2FormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">

        </div>
    </div>
    </section>
@endsection

@section('scripts')
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            order: [
                [2, 'desc']
            ],
            "columnDefs": [{
                "targets": [3]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },
        });
    </script>




    <script>
        $(document).ready(function() {
            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            var count = 0;

            function autoCalcSetup() {
                $('table#cart').jAutoCalc('destroy');
                $('table#cart tr').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true
                });
                $('table#cart').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup();
        });
    </script>
@endsection
