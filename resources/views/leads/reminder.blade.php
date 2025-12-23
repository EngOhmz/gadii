<div class="card-header"> 
    <strong>Reminder</strong> 
</div>

<div class="card-body">
    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if($type == 'details' || $type == 'calls' || $type == 'meetings' || $type == 'comments' || $type == 'reminder' || $type == 'tasks' || $type == 'proposal' || $type == 'notes' || $type == 'activities') active @endif" 
                id="home-tab2" data-toggle="tab"
                href="#reminder-home2" role="tab" aria-controls="home" aria-selected="true">
                Reminder List
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($type == 'edit-reminder') active @endif" 
                id="profile-tab2" data-toggle="tab" 
                href="#reminder-profile2" role="tab" aria-controls="profile"
                aria-selected="false">
                New Reminder
            </a>
        </li>
    </ul>

    <br>

    <div class="tab-content tab-bordered" id="myTab3Content">
        {{-- Reminder List Tab --}}
        <div class="tab-pane fade @if($type == 'details' || $type == 'calls' || $type == 'meetings' || $type == 'comments' || $type == 'reminder' || $type == 'tasks' || $type == 'proposal' || $type == 'notes' || $type == 'activities') active show @endif" 
            id="reminder-home2" role="tabpanel" aria-labelledby="home-tab2">

            <div class="table-responsive">
                <table class="table datatable-attach table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Reminder Date</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($reminders))
                            @foreach ($reminders as $row)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($row->reminder_date)->format('Y-m-d') }}</td>
                                    <td>
                                        {{-- <div class="form-inline">
                                            <a class="list-icons-item text-primary" title="Edit"  
                                                href="{{ route('edit.lead_details', ['type'=>'edit-reminder','type_id'=>$row->id]) }}">
                                                <i class="icon-pencil7"></i>
                                            </a>
                                            &nbsp;
                                            <a class="list-icons-item text-danger" title="Delete"  
                                                href="{{ route('delete.lead_details', ['type'=>'delete-reminder','type_id'=>$row->id]) }}" 
                                                onclick="return confirm('Are you sure, you want to delete?')">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </div> --}}
                                        {{ $row->description }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Add / Edit Reminder Tab --}}
        <div class="tab-pane fade @if($type == 'edit-reminder') active show @endif" 
            id="reminder-profile2" role="tabpanel" aria-labelledby="profile-tab2">

            <br>
            <div class="card">
                <div class="card-header">
                    @if($type == 'edit-reminder')
                        <h5>Edit Reminder</h5>
                    @else
                        <h5>Add New Reminder</h5>
                    @endif
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @if($type == 'edit-reminder')
                                {!! Form::open(['route' => 'update.lead_details']) !!}
                                <input type="hidden" name="id" value="{{ $type_id }}">
                            @else
                                {!! Form::open(['route' => 'save.lead_details']) !!}
                                @method('POST')
                            @endif

                            <input type="hidden" name="leads_id" value="{{ $id }}">
                            <input type="hidden" name="type" value="reminder">

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Title <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" name="title"
                                        value="{{ isset($edit_data) ? $edit_data->title : '' }}"
                                        class="form-control" required>
                                </div>

                                <label class="col-lg-2 col-form-label">Description</label>
                                <div class="col-lg-4">
                                    <textarea name="description" class="form-control">@if(isset($edit_data)){{ $edit_data->description }}@endif</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Reminder Date <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="date" name="reminder_date"
                                        value="{{ isset($edit_data) ? $edit_data->reminder_date : '' }}"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-offset-2 col-lg-12">
                                    @if($type == 'edit-reminder')
                                        <button class="btn btn-sm btn-primary float-right" type="submit">Update</button>
                                    @else
                                        <button class="btn btn-sm btn-primary float-right" type="submit">Save</button>
                                    @endif
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

