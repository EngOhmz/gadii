@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Assign Expire Date</h4>
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
                            ?>

                        @foreach($data as $key)

                        @php
                                      //$pqty= App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','0')->whereNull('purchase_id')->whereNull('expire_date')->sum('quantity');   
                                      $pqty= App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','0')->whereNull('expire_date')->sum('quantity');   
                                          
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
                                 <td><a  href="#views{{$key->id}}"  data-toggle="modal" >Assign</a></td>     
                                                        
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
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}}  Balance<h5>
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
                                                    style="width: 110.484px;">Date</th>
                                                                                               
                                             
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
                                                $account =App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','0')->whereNull('expire_date')->whereNull('purchase_id')
                                                ->orderBy('purchase_date','desc')->groupBy('purchase_date')->get();
                                                ?>  
                                         @foreach($account  as $a)
                                                         <tr>
                                              <td >{{$loop->iteration }}</td>
                                              <td >{{$a->purchase_date }}</td>
                                            <td >@if(!empty($a->location)){{$a->store->name }}@endif</td>
                                            
                                             <?php                   
                                       
                                         $exp_qty =App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','0')->whereNull('purchase_id')->whereNull('expire_date')->where('purchase_date', $a->purchase_date)
                                        ->sum('quantity'); 
                                                ?> 
                                                
                                      <td>{{ number_format($exp_qty,2) }}</td>
                                          
                                         
                                          
                                            </tr> 
                        
                          @endforeach
                            </tbody>
                         
                         <?php
                                           
                                                $q = App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','0')->whereNull('expire_date')->whereNull('purchase_id')->sum('quantity');

                                            
                                                ?>  
                        <tfoot>
                                            <tr>     
                                                 <td></td>
                                                   <td></td>  <td><b> Total Balance</b></td>
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



@foreach($data as $key)
  <div class="modal fade " data-backdrop=""  id="views{{$key->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Assign Expire Date<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


 <form id="form" role="form" enctype="multipart/form-data" action="{{route('pos.save_expire')}}"  method="post" >
                   
                @csrf
        <div class="modal-body">
           <?php
                                           
                                                $chk = App\Models\POS\SerialList::where('brand_id', $key->id)->where('status','0')->whereNull('purchase_id')->whereNull('expire_date')->sum('quantity');

                                                ?> 
          
            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

                                            <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Quantity</label>
                                                        <div class="col-lg-10">
                                                    <input type="number" name="quantity" class="form-control item_quantity" placeholder="quantity" id="quantity"  min="1" max="{{$chk}}" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Expire Date</label>

                                                        <div class="col-lg-10">
                                                            <input type="month" name="expire_date"  class="form-control monthyear" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Serial No</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="reference"  class="form-control">
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="id"  class="form-control" value="{{$key->id}}" required>

 
                 
               
              </div>
</div>
                                                    </div>                                      
                                                
                                                

        </div>
        <div class="modal-footer bg-whitesmoke br">
           <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
         </form>
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