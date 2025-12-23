@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Payments</h4>
                        </div>
                        <div class="card-body">
                           
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                    @php $tt =0; @endphp
                                    <table class="table datatable-button-html5-basic" id="itemsDatatable">
                                    <thead>
                                        <tr>
                                           <th >#</th>
                                            <th>Student</th> 
                                            <th>Reference</th> 
                                            <th>Amount</th> 
                                            <th>Payment Account</th> 
                                            <th>Payment Date</th>   
                                            <th class="always-visible">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach($payments as $row)
                                        
                                        @php
                             $paid=App\Models\School\SchoolPayment::where('added_by',auth()->user()->added_by)->where('type','!=','Discount Fees')->where('multiple',$row->multiple)->sum('paid');
                                        
                                        @endphp
                                       
                                        <tr>
                                           
                                           <th>{{ $loop->iteration }}</th>
                                           <td>@if(!empty($row->student_id)){{$row->student->student_name}}@endif</td>
                                            <td>{{$row->reference}}</td>
                                             <td>{{number_format($paid,2)}} </td>     
                                             <td>@if(!empty($row->bank_id)){{$row->chart->account_name}}@endif</td>
                                            <td>{{Carbon\Carbon::parse($row->date)->format('M d, Y')}}</td>
                                            <td><a  href="{{ route('payments_receipt',['download'=>'pdf','id'=>$row->id]) }}"  title="" > Download Receipt </a> </td>
                                        </tr>
                                        
                                         @php $tt +=$paid; @endphp
                                        @endforeach
                                       
                                    </tbody>
                                    
                                    
                                    <tfoot>
                                       
                                       
                                        <tr>
                                           
                                           <th></th>
                                           <td></td>
                                            <td></td>
                                             <td>{{number_format($tt,2)}} </td>     
                                             <td></td>
                                            <td></td>
                                            <td> </td>
                                        </tr>
                                    </tfoot>
                                   
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

    <!-- supplier Modal -->
    <div class="modal fade " data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-lg">

        </div>
    </div>


   




@endsection

@section('scripts')
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">

    <script src="{{ asset('assets/datatables/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.print.min.js') }}"></script>
    
    
    
</script>
    
    
    

    <script>
        $(function() {
          
            
            $('#itemsDatatable').DataTable({
                processing: true,
                serverSide: false,
                searching: true,
                "dom": 'lBfrtip',

                buttons: [{
                        extend: 'copyHtml5',
                        title: 'PAYMENTS ',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                      
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'PAYMENTS',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                       
                        footer: true
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'PAYMENTS',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'PAYMENTS',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)',
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        title: 'PAYMENTS',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    }

                ],

                
     
            })
        });


    </script>




@endsection
