<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Assign Farmer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('farmer.save'), 'method' => 'POST')) }}
        <div class="modal-body">
            <p><strong>Make sure you enter valid information</strong> .</p>
                     
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Assign to</label>

                <div class="col-lg-12">
                    <select name="assign"
                    class="form-control" required>
                    <option value="">Select</option>
                    @foreach($staff as $n) 
                    <option @if(isset($data))
                     {{ $data->assign == $n->id  ? 'selected' : ''}}@endif value="{{ $n->id}}">{{$n->name}}</option>                                                            
                    @endforeach
                </select>

                <input type="hidden" name="id" value="{{$id}}" required class="form-control">
                </div>
            </div>

           


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>