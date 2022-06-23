<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">
@if($type=='mechanical_maintainance')
Maintainance
@else
Service 
@endif 
Mechanical Report </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
           

                                            <br>
                                            <div class="table-responsive">
                                                
                                            <table class="table table-bordered" id="service">
                                                <thead>
                                                    <tr>
                                                    <th>#</th>
                                                        <th>Service Type</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                @foreach ($item as $row)
                                              <tr class="gradeA even" role="row">
                                                <td>{{ $loop->iteration }}</td>
                                                 <td>{{ $row->service->name }}</td>
                                             </tr>
                                            @endforeach
                                                </tbody>
                                               

                                            </table>

                                    
<br>
                               <table class="table table-bordered" id="recommedation">
                                                <thead>
                                                    <tr>
                                                   <th>#</th>
                                                        <th>Recommedation</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody >
                                               @foreach ($notes as $row)
                                              <tr class="gradeA even" role="row">
                                                <td>{{ $loop->iteration }}</td>
                                                 <td>{{ $row->recommedation }}</td>
                                             </tr>
                                            @endforeach

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