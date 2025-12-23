<div class="card-header"> <strong></strong> </div>

<div class="card-body">
    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if (
                $type == 'credit' ||
                    $type == 'details' ||
                    $type == 'calendar' ||
                    $type == 'purchase' ||
                    $type == 'debit' ||
                    $type == 'invoice' ||
                    $type == 'comments' ||
                    $type == 'attachment' ||
                    $type == 'milestone' ||
                    $type == 'tasks' ||
                    $type == 'expenses' ||
                    $type == 'estimate' ||
                    $type == 'notes' ||
                    $type == 'activities' ||
                    $type == 'logistic' ||
                    $type == 'cargo' ||
                    $type == 'storage' ||
                    $type == 'charge') active @endif" id="home-tab2" data-toggle="tab"
                href="#logistic-home2" role="tab" aria-controls="home" aria-selected="true">Customer Duty
                List</a>
        </li>
                               @if ($type == 'edit-logistic')
                                <li class="nav-item">
                                    <a class="nav-link @if ($type == 'edit-logistic') active @endif"
                                        id="profile-tab2" data-toggle="tab" href="#logistic-profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Customer Duty</a>
                                </li>
                                @endif

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (
            $type == 'credit' ||
                $type == 'details' ||
                $type == 'calendar' ||
                $type == 'purchase' ||
                $type == 'debit' ||
                $type == 'invoice' ||
                $type == 'comments' ||
                $type == 'attachment' ||
                $type == 'milestone' ||
                $type == 'tasks' ||
                $type == 'expenses' ||
                $type == 'estimate' ||
                $type == 'notes' ||
                $type == 'activities' ||
                $type == 'logistic' ||
                $type == 'cargo' ||
                $type == 'storage' ||
                $type == 'charge') active show @endif " id="logistic-home2"
            role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                            <thead>
                                                <tr>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 106.484px;">Ref No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 186.484px;">Client Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 126.484px;">Invoice Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 161.219px;">Amount</th>
                                                    
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 121.219px;">Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 168.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($custom))
                                                    @foreach ($custom as $row)
                                                       
                                        @php $cl= App\Models\Client::find($row->client_id); $dep = App\Models\Departments::find($row->department_id); @endphp  

                                                        <tr class="gradeA even" role="row">

                                                <td><a href="" data-toggle="modal" value="{{ $row->id }}"  data-target="#app2FormModal" onclick="model({{ $row->id }},'invoice')">{{ $row->reference_no }}</a></td>
                                                <td>@if($row->related == 'Clients') {{ $cl->name }} @else {{$dep->name}} @endif</td>

                                                            <td>{{ Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y') }}</td>

                                                            <td>{{ number_format(($row->invoice_amount + $row->invoice_tax +  $row->shipping_cost)  - $row->discount, 2) }}</td>
                                                           
                                                            <td>
                                                                @if ($row->status == 0)
                                                                <div class="badge badge-danger badge-shadow">Not Approved</div>
                                                                @elseif($row->status == 1)
                                                                    <div class="badge badge-warning badge-shadow">Completed
                                                                @elseif($row->status == 2)
                                                                    <div class="badge badge-success badge-shadow">Approved</div>
                                                                 @elseif($row->status == 3)
                                                                    <div class="badge badge-info badge-shadow">Partially Paid
                                                                @elseif($row->status == 4)
                                                                    <div class="badge badge-success badge-shadow">Fully Paid</div>
                                                                @endif
                                                            </td>


                                                            <td>
                                                          
                                                        <div class="dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

                                                            <div class="dropdown-menu">

                                                       @if($row->status == 3 || $row->status == 2)
                                                         <li>
                                                        <a class="nav-link" href="" data-toggle="modal" value="{{ $row->id }}"  data-target="#app2FormModal" onclick="model({{ $row->id }},'invoice_payment')">Make Payments</a>
                                                         </li>
                                                        @endif
                                                                            
                    
                                                                               

                             <a class="nav-link" id="profile-tab2" href="{{ route('cf_invoice_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}">Download PDF</a>
                             <a class="nav-link" id="profile-tab2" href="{{ route('cf_invoice_receipt', ['download' => 'pdf', 'id' => $row->id]) }}">Download Receipt</a>
                             
                              @if($row->status == 3 || $row->status == 2)
                 <a class="nav-link"  href="{{ route('cf_invoice_history_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  title="" > Download Payment History </a>
                   @endif 
                   
                    <a class="nav-link" id="profile-tab2" target="_blank" href="{{ route('cf_invoice_print', ['download' => 'pdf', 'id' => $row->id]) }}">Print PDF</a>
                    <a class="nav-link" id="profile-tab2" target="_blank" href="{{ route('cf_receipt_print', ['download' => 'pdf', 'id' => $row->id]) }}">Print Receipt</a>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                

    </div>
</div>

    
    



     
    


