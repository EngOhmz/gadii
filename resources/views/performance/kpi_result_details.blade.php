
<div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="formModal" >Key Performance Indicator Result for {{$list->user->name}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       <br>
        <div class="modal-body">
 <div class="row">
 <div class="table-responsive">
                                                        <table class="table datatable-modal table-striped">
                                                            <thead>
                                                                <tr>
                                                                     <th>#</th>
                                                                    <th>Key Result Area</th>
                                                                    <th>Key Performance Indicator</th>
                                                                     <th>Goal - %</th>
                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                              @if(!empty($data))
                                                                @foreach ($data as $i)
                                                                <tr class="line_items">
                                                                    
                                                    <td>{{$loop->iteration }}</td>                
                                                <td>{{$i->list->area }}</td>
                                                <td>{!! $i->list->indicator !!}</td>
                                                      <td>@if(!empty($i->goal_id)) {{$i->goal->subject }} -  @endif {{$i->percent }}</td>
                                                                </tr>
                                                
                                                                @endforeach
                                                                @endif
            
                                                            </tbody>
                                                               
                                                        </table>
                                                    </div>
       
        </div>

        <div class="modal-footer ">
     <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
    </div>
      
    </div>


@yield('scripts')
 <script>
       $('.datatable-modal').DataTable({
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