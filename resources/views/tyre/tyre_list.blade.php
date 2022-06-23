<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Tyre list</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
     
        <div class="modal-body">
           
                                            <div class="table-responsive">
                                                
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                      <th>#</th>
                                                        <th>Tyre</th>
                                                          <th>Tyre Position</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody >
                                              
            
 @if(!@empty($tyre))
                                            @foreach ($tyre as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->tyre->reference }}</td>
                                                <td>{{$row->position}}</td>
                                               
                                            </tr>
                                          
  @endforeach

                                            @endif
                                                </tbody>
                                               
                                            </table>
                                         

                                    
</div>
</div>
        <div class="modal-footer bg-whitesmoke br">
         
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>