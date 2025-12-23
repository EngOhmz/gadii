<div class="card-header"> <strong></strong> </div>

<div class="card-body">
    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if ($type == 'details' || $type == 'comments' || $type == 'task' || $type == 'activities') active @endif" id="home-tab2" data-toggle="tab"
                href="#notes-home2" role="tab" aria-controls="home" aria-selected="true">Activities
                List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($type == 'edit-activities') active @endif" id="profile-tab2" data-toggle="tab"
                href="#notes-profile2" role="tab" aria-controls="profile" aria-selected="false">New Activities</a>
        </li>

    </ul>
    <br>
    <div class="tab-content tab-bordered" id="myTab3Content">
        <div class="tab-pane fade  @if ($type == 'details' || $type == 'comments' || $type == 'task' || $type == 'activities') active show @endif " id="notes-home2"
            role="tabpanel" aria-labelledby="home-tab2">
            <div class="table-responsive">
                <table class="table datatable-basic table-striped" style="width:100%">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Browser: activate to sort column ascending"
                                style="width: 28.531px;">#</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">Notes</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                style="width: 98.1094px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>

                </table>
            </div>
        </div>
        <div class="tab-pane fade  @if ($type == 'edit-activities') active show @endif" id="notes-profile2"
            role="tabpanel" aria-labelledby="profile-tab2">

            <div class="card">
                <div class="card-header">
                    @if ($type == 'edit-activities')
                        <h5>Edit Activities</h5>
                    @else
                        <h5>Add New Activities</h5>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 ">
                            form activities
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

