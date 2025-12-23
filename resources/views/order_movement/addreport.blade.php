<table class="table datatable-basic table-striped" id="tableExport" style="width:100%;">
                            <thead>
                                <tr role="row">

                                          <th class="" rowspan="1" colspan="1" style="width: 38.531px;">#</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 106.484px;">Date</th>
                                 <th class="" rowspan="1" colspan="1" style="width: 186.484px;">REF NO <br>Shipment Name</th>
                                  <th class="" rowspan="1" colspan="1" style="width: 106.484px;">Receipt</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 186.484px;">Client <br>Receiver</th>                             
                                    <th class="" rowspan="1" colspan="1" style="width: 141.219px;">Route </th>
                              <th class="" rowspan="1" colspan="1" style="width: 146.484px;">Truck</th>
                              <th class="" rowspan="1" colspan="1" style="width: 141.219px;">Driver</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 91.219px;">Qty</th>
                                       <th class=""  rowspan="1"  colspan="1" style="width: 91.219px;">Status</th>
                                       

                                </tr>
                            </thead>
                            <tbody>
                                 @if(!@empty($report))
                                            @foreach ($report as $row)
                                            <tr class="gradeA even" role="row">

                                                <td> {{$loop->iteration}}</td>
                                               <td>{{Carbon\Carbon::parse($row->collection_date)->format('d/m/Y')}}</td>
                                                <td>{{$row->pacel_number}} <br>{{$row->pacel_name}}</td>
                                                     <td>{{$row->receipt}}</td>
                                                    <td>-{{$row->client->name}} <br>-{{$row->receiver_name}}</td>                                              
                                                <td>From {{$row->region_s->name}} to {{$row->region_e->name}}</td>
                                            <td>{{$row->truck->reg_no}}</td> 
                                             <td>{{$row->driver->driver_name}}</td>   
                                            <td>{{$row->quantity}} </td>
                                                          
                                                
<td>
                                                    @if($row->status == 3)
                                                     <div class="badge badge-dark badge-shadow">Collected</div>
                                                       @elseif($row->status == 4)
                                                    <div class="badge badge-info badge-shadow">On Transit</div>
                                                       @elseif($row->status == 5)
                                                    <div class="badge badge-primary badge-shadow">Off Loaded</div>
                                                      @elseif($row->status == 6)
                                                    <div class="badge badge-success  badge-shadow">Delivered</div>
                                                    @endif
                                                </td>

                                              

                                            </tr>
                                            @endforeach
                                      
                                            @endif
                            </tbody>
                        </table>

<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        searching: false,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },
    
            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});
</script>
