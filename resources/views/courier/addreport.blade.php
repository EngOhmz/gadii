 <table class="table table-striped" id="table-1">
                            <thead>
                                <tr role="row">

                                    <th class="" rowspan="1" colspan="1" style="width: 208.531px;">#</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 186.484px;">Date</th>
                           <th class="" rowspan="1" colspan="1" style="width: 186.484px;">REF NO <br>Shipment Name</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 186.484px;">Client <br>Receiver</th>
                               
                                    <th class="" rowspan="1" colspan="1" style="width: 141.219px;">Route
                                       
                                    </th>
                              <th class="" rowspan="1" colspan="1" style="width: 186.484px;">Truck</th>
                              <th class="" rowspan="1" colspan="1" style="width: 141.219px;">Driver</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 141.219px;">Weight</th>
                                    

                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" style="width: 141.219px;">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                 @if(!@empty($report))
                                            @foreach ($report as $row)
                                            <tr class="gradeA even" role="row">

                                                <td> {{$loop->iteration}}</td>
                                                <td>{{Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}}</td>
                                                <td>{{$row->pacel_number}} <br>{{$row->pacel_name}}</td>
                                                    <td>-{{$row->client->name}} <br>-{{$row->receiver_name}}</td>                                              
                                                <td>From {{$row->region_s->name}} to {{$row->region_e->name}}</td>
                                             <td>{{$row->truck_id}}</td> 
                                             <td>{{$row->driver_id}}</td>   
                                            <td>{{$row->weight}} kgs</td>
                                                          
                                                
<td>
                                                    @if($row->status == 3)
                                                    <div class="badge badge-success badge-shadow">Collected</div>
                                                       @elseif($row->status == 4)
                                                    <div class="badge badge-info badge-shadow">On Transit</div>
                                                       @elseif($row->status == 5)
                                                    <div class="badge badge-primary badge-shadow">Arrived</div>
                                                      @elseif($row->status == 6)
                                                    <div class="badge badge-primary  badge-shadow">Delivered</div>
                                                    @endif
                                                </td>

                                              

                                            </tr>
                                            @endforeach
                                      
                                            @endif
                            </tbody>
                        </table>