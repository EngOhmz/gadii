@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Bank Reconciliation Report</h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                  <table class="table datatable-basic table-striped"  id="table-1">
                                       <thead>
                                            <tr>
                                            <th>#</th>
                                            <th> Type</th>
                                             <th>Account Name</th>
                                            <th>Date</th>
                                            <th>Balance</th>
                                            <th>Notes</th>
                                           
                                            
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($data))
                                            @foreach ($data as $row)
                                            @php
                        
                                            $balance=$row->debit -$row->credit;
                                             
                                       @endphp

                                            <tr class="gradeA even" role="row">
                                                <td>{{ $loop->iteration }}</td>
                                                @if ($balance < 0)
                                                <td>Withdraw</td>
                                                @else
                                                <td>Deposit</td>
                                                @endif

                                                  @if(!empty($row->chart))
                                                <td>{{$row->chart->name}}</td>
                                                     @endif

                                                 <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
                                                <td>{{ number_format(abs($row->debit -$row->credit),2) }}</td>
                                               <td>{{$row->notes }}</td>
                                            </tr>
                                            @endforeach

                                            @endif

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
                </div>
            </div>
        </div>

    </div>
</section>



@endsection

@section('scripts')

<link rel="stylesheet" href="{{ asset('assets/datatables/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">

<script src="{{asset('assets/datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/datatables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/datatables/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/buttons.print.min.js')}}"></script>
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [3]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection