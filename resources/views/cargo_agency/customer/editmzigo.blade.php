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
                                    <a class="nav-link @if (!empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Add/Edit Cargo 
                                        </a>
                                </li>

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                {{ Form::open(['route' => 'mizigo.kuongeza']) }}
                                                @method('POST')
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Customer Name</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" class="form-control" value="{{ $data2->mteja }}" readonly required/>

                                                            <input type="hidden" name="c_id"    class="form-control" value="{{ $data2->id }}"   readonly required/>
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Receivers Name</label>
                                                        <div class="col-lg-4">
                                                            <div class="input-group mb-3">
                                                            <input type="text" class="form-control" value="{{  $data2->mpokeaji  }}" readonly required/>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <br>
                                                    <hr>
                                                    @if(isset($customer_ID))
                                
                                                        <div align="center">
                                                            <a class="btn btn-primary" href="{{route('pacel_reg', $customer_ID)}}" role="button">Print Receipt</a>
                                                        </div>

                                                        @endif
                                                    <hr>
                                                    <button type="button" name="add"
                                                        class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add</i></button><br>
                                                    <br>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                            <thead>
                                                                <tr>
                                                                    <th>Cargo Name</th>
                                                                    <th>From</th>
                                                                    <th>To</th>
                                                                    <th>Quantity</th>
                                                                    <th>Price</th>
                                                                    <th>Money Received</th>
                                                                    <th>Receipt</th>
                                                                    <th>Previous Balance</th>
                                                                    <th>Total</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                            </tbody>
                                                            <tfoot>


                                                            @if (!empty($id))
                                                                    @if (!empty($items))
                                                                        @foreach ($items as $i)
                                                                            <tr class="line_items">
                                                                            <td><input type="text"
                                                                                        class="form-control item_name2"
                                                                                        data-category_id="{{ $i->id }}_edit"
                                                                                         required
                                                                                         readonly
                                                                                        value="{{ isset($i) ? $i->name : '' }}" />
                                                                                </td>
                                                                                <td><input type="text"
                                                                                        class="form-control item_from"
                                                                                        data-category_id="{{ $i->id }}_edit"
                                                                                         
                                                                                         readonly
                                                                                        value="{{ isset($i) ? $i->mzigo_unapotoka : '' }}" />
                                                                                </td>
                                                                                <td><input type="text" 
                                                                                        class="form-control item_to"
                                                                                        data-category_id="{{ $i->id }}_edit"
                                                                                         required
                                                                                         readonly
                                                                                        value="{{ isset($i) ? $i->mzigo_unapokwenda : '' }}" />
                                                                                </td> 
                                                                                <td><input type="number" 
                                                                                        class="form-control"
                                                                                        data-category_id="{{ $i->id }}_edit"
                                                                                        id="quantity"
                                                                                        value="{{ isset($i) ? $i->idadi_stoo : '' }}"
                                                                                        readonly
                                                                                         />
                                                                                </td>
                                                                                <td><input type="number" 
                                                                                        class="form-control {{ $i->id }}_edit"
                                                                                         
                                                                                         readonly
                                                                                        value="{{ isset($i) ? $i->bei : '' }}" />
                                                                                </td>

                                                                                <td><input type="number" 
                                                                                        class="form-control {{ $i->id }}_edit"
                                                                                         
                                                                                         readonly
                                                                                        value="{{ isset($i) ? $i->ela_iliyopokelewa : '' }}" />
                                                                                </td>
                                                                                <td>
                                                                                    <div class="input-group mb-3"><select
                                                                                            class="form-control  m-b receipt"
                                                                                            readonly
                                                                                            
                                                                                            data-sub_category_id="{{ $i->id }}_edit">
                                                                                            <option >Select
                                                                                                </option>
                                                                                                <option value="R" @if(isset($i))@if($i->receipt == 'R') selected @endif @endif >R</option>
                                                                                                <option value="HR" @if(isset($i))@if($i->receipt == 'HR') selected @endif @endif >HR</option>
                                                                                                
                                                                                        </select></div>
                                                                                </td>
                                                                                <td><input type="text" 
                                                                                        class="form-control item_total{{ $i->id }}_edit"
                                                                                         
                                                                                        value="{{ isset($i) ? $i->jumla : '' }}"
                                                                                        readonly/>
                                                                                </td>
                                                                                <td><input type="text" 
                                                                                        class="form-control {{ $i->id }}_edit"
                                                                                         
                                                                                         placeholder="NAN"
                                                                                         readonly
                                                                                        value="{{ 'NAN' }}" />
                                                                                </td>
                                                                                <td><i  class="btn btn-info icon-envelop5"></i>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                @endif

                                                                <tr class="line_items">
                                                                    <td colspan="7"></td>
                                                                    <td><span class="bold">Total (+)</span>: </td>
                                                                    <td><input type="text" name="subtotal[]"
                                                                            class="form-control item_total"
                                                                            required jAutoCalc="SUM({total_cost})"
                                                                            readonly></td>
                                                                </tr>

                                                            </tfoot>
                                                        </table>
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
    </section>

    <!-- supplier Modal -->
    <div class="modal fade " data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-lg">

        </div>
    </div>


    <div class="modal fade " data-backdrop="" id="app2FormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">

        </div>
    </div>




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
                $('table#cart tr.line_items').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true
                });
                $('table#cart').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup();

            $('.add').on("click", function(e) {

                count++;
                var html = '';
                html += '<tr class="line_items">';
                html += '<td><input type="text" name="name[]"  class="form-control item_name2[]" data-category_id="' + count +
                        '" placeholder ="name" id ="name" required  /><div class=""><p class="form-control-static errors'+count+'" id="errors" style="text-align:center;color:red;"></p></div></td>';
                html += '<td><input type="text" name="from[]"  class="form-control item_from[]" data-category_id="' + count +
                        '" placeholder ="from"  /></td>';
                html += '<td><input type="text" name="to[]"  class="form-control item_to[]" data-category_id="' + count +
                        '" placeholder ="to" required  /></td>';  
                html +=
                    '<td><input type="number" name="quantity[]" step="any" class="form-control item_quantity" data-sub_category_id="' +
                    count + '"placeholder ="quantity" id ="quantity" required /><div class=""><p class="form-control-static errorsQnt'+count+'" id="errors" style="text-align:center;color:red;"></p></div></td>';
                html += '<td><input type="number" name="price[]" step="any" class="form-control item_price' + count +
                    '" placeholder ="price"  value=""/></td>';
                html += '<td><input type="number" name="ela_iliyopokelewa[]" step="any" class="form-control ' + count +
                    '" placeholder ="ela_iliyopokelewa"  value=""/></td>';    
               
               html +=
                    '<td> <div class="input-group mb-3"><select name="receipt[]" class="form-control receipt"  id="receipt' +
                    count + '" data-sub_category_id="' + count +
                    '" required><option value="">Select</option><option value="R">R</option><option value="HR">HR</option></select></td>';
                html += '<td><input type="text"  class="form-control ' + count +
                    '" placeholder ="NAN"  value="NAN" readonly/></td>';     

                html += '<td><input type="text" name="total_cost[]" class="form-control item_total' +
                    count +
                    '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
                html +=
                    '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

                $('tbody').append(html);
                autoCalcSetup();

                $('.append-button-single-field').select2({
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass(
                        'w-100') ? '100%' : 'style',
                });

            });



            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
                autoCalcSetup();
            });


            $(document).on('click', '.rem', function() {
                var btn_value = $(this).attr("value");
                $(this).closest('tr').remove();
                $('tfoot').append(
                    '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                    btn_value + '"/>');
                autoCalcSetup();
            });

        });
    </script>





    
@endsection
