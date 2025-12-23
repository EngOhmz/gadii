@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Dispose Expired Item</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">


        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

                 <table class="table datatable-basic table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                              <th>Quantity</th>
                               <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                          <?php
                            $total_p=0; 
                            $i=0; 
                             $date = today()->format('Y-m');
                            ?>

                        @foreach($data as $key)

                        @php
                        
                       
                      $pqty= App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','0')->whereNotNull('expire_date')->where('expire_date', '<', $date)->sum('quantity');   
                                          
                                        @endphp 

                                @if($pqty > 0 )

                            <?php   $i++;  ?>

                            <tr>
                                <td>{{ $i }}</td>
                                 <td>{{$key->name}}</td>

                                 @php  
                                        $total_p+=$pqty;
                                       
                                        @endphp 

                           <td><a  href="#viewp{{$key->id}}"  data-toggle="modal" >{{number_format($pqty,2)}}</a></td>
                                 <td><a onclick="return confirm('Are you sure, you want to dispose ?')"   href="{{ route('pos.dispose_expire', $key->id)}}"  title="Dispose">Dispose</a></td>     
                                                        
                            </tr>

                        @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                                <td>Total</td>
                     <td></td>
                           <td>{{number_format($total_p ,2)}}</td>
                                <td></td>
                                                   
                            </tr>
                        </tfoot>
                    </table>
                  
                </div>
            </div>
            <!-- /.panel-body -->
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

 <!-- Modal -->
@foreach($data as $key)
  <div class="modal fade " data-backdrop=""  id="viewp{{$key->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Expired List<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                           <table class="table datatable-basic table-striped">
                                       <thead>
                                            <tr>
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 30.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 120.484px;">Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 110.484px;">Expire Date</th>
                                                                                                
                                                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Location</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Quantity</th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php                   
                                        $account =App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','0')->whereNotNull('expire_date')->where('expire_date', '<', $date)
                                        ->orderBy('expire_date','desc')->groupBy('expire_date')->get();
                                        
                                                ?>  
                                         @foreach($account  as $a)
                                                         <tr>
                                              <td >{{$loop->iteration }}</td>
                                              
                                              <td >{{Carbon\Carbon::parse($a->purchase_date)->format('d/m/Y')}} </td>
                                         <td ><?php echo date('F Y', strtotime($a->expire_date)); ?></td>
                                <td >@if(!empty($a->location)){{$a->store->name }}@endif</td>
                                
                                     <?php                   
                                       
                                          $exp_qty =App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','0')->whereNotNull('expire_date')->where('expire_date', $a->expire_date)
                                        ->groupBy('expire_date')->sum('quantity'); 
                                                ?> 
                                                
                                      <td>{{ number_format($exp_qty,2) }}</td>    
                                            </tr> 
                        
                          @endforeach
                            </tbody>
                         
                         <?php
                                           
                                                $q = App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','0')->whereNotNull('expire_date')->where('expire_date', '<', $date)->sum('quantity'); 
                                            
                                                ?>  
                        <tfoot>
                                            <tr>     
                                                     <td></td> <td></td><td></td> <td><b> Total Balance</b></td>
                                                    <td><b>{{ number_format($q,2) }}</b></td>
                                                
                                            </tr> 
                        
                                              
                         
                                                      </tfoot>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>

@endforeach



@endsection

@section('scripts')


<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [1]}
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


@endsection