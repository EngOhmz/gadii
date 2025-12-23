 <table class="table datatable-basic table-striped">
                            <thead>
                                <tr role="row">

                                   <th class="" rowspan="1" colspan="1" style="width: 28.531px;">#</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 126.484px;">Date</th>
                                      <th class="" rowspan="1" colspan="1" style="width: 106.484px;">Ref No </th>
                                    <th class="" rowspan="1" colspan="1" style="width: 186.484px;">Client </th>
                                    <th class="" rowspan="1" colspan="1" style="width: 181.219px;">Tariff </th>
                                    <th class="" rowspan="1" colspan="1" style="width: 101.219px;">Weight</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" style="width: 101.219px;">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                 @if(!@empty($report))
                                            @foreach ($report as $row)
                                            <tr class="gradeA even" role="row">

                                                <td> {{$loop->iteration}}</td>
                                                <td>{{Carbon\Carbon::parse($row->collection_date)->format('d/m/Y')}}</td>
                                                <td>{{$row->pacel_number}} </td>
                                                    <td>{{$row->client->name}} </td>                                              
                                                <td>From {{$row->region_s->name}} to {{$row->region_e->name}}</td>   
                                            <td>{{$row->weight}} kgs</td>
                                                          
                                                
<td>
                                                    @if($row->status == 3)
                                                    <div class="badge badge-success badge-shadow">Picked</div>
                                                       @elseif($row->status == 4)
                                                    <div class="badge badge-info badge-shadow">Freighted</div>
                                                       @elseif($row->status == 5)
                                                    <div class="badge badge-primary badge-shadow">Commissioned</div>
                                                      @elseif($row->status == 6)
                                                    <div class="badge badge-primary  badge-shadow">Delivered</div>
                                                    @endif
                                                </td>

                                              

                                            </tr>
                                            @endforeach
                                      
                                            @endif
                            </tbody>
                        </table>