@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>School Fees Registration</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" href="#home2" data-toggle="tab">Fees List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" href="#profile2" data-toggle="tab">Create New Fee</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered">
                            <!-- Fees List -->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fee Type</th>
                                                <th>Price</th>
                                                <th>Branch</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($schools))
                                            @foreach ($schools as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{ $row->feeType }}</td>
                                                <td>{{ number_format($row->price, 2) }}</td>
                                                <td>{{ $row->branch->name ?? 'N/A' }}</td>
                                                <td>
                                                    <div class="form-inline">
                                                        <a href="{{ route('school.edit', $row->id) }}" class="list-icons-item text-primary" title="Edit"><i class="icon-pencil7"></i></a>
                                                        <form action="{{ route('school.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this fee?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="list-icons-item text-danger border-0" title="Delete"><i class="icon-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Create/Edit Form -->
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2">
                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Fee</h5>
                                        @else
                                        <h5>Edit Fee</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                @if(isset($id))
                                                {{ Form::model($school, ['route' => ['school.update', $id], 'method' => 'PUT', 'role' => 'form', 'enctype' => 'multipart/form-data']) }}
                                                @else
                                                {{ Form::open(['route' => 'school.store', 'role' => 'form', 'enctype' => 'multipart/form-data']) }}
                                                @method('POST')
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Fee Type <span class="required">*</span></label>
                                                    <div class="col-lg-8">
                                                        <select name="feeType" class="form-control m-b" required>
                                                            <option value="">Select Fee Type</option>
                                                            @foreach ($group as $fee)
                                                            <option value="{{ $fee->name }}" @if(isset($school) && $school->feeType == $fee->name) selected @endif>{{ $fee->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Price <span class="required">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="price" class="form-control" required placeholder="0.00" value="{{ isset($school) ? $school->price : '' }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Branch <span class="required">*</span></label>
                                                    <div class="col-lg-8">
                                                        <select name="branch_id" class="form-control m-b" required>
                                                            <option value="">Select Branch</option>
                                                            @foreach ($branch as $br)
                                                            <option value="{{ $br->id }}" @if(isset($school) && $school->branch_id == $br->id) selected @endif>{{ $br->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Levels and Classes -->
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Levels and Classes</label>
                                                    <div class="col-lg-8">
                                                        <table class="table" id="levelTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Level</th>
                                                                    <th>Class</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(isset($items) && $items->count() > 0)
                                                                @foreach ($items as $item)
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" name="level[]" class="form-control" value="{{ $item->level }}" required>
                                                                        <input type="hidden" name="details[]" value="{{ $item->id }}">
                                                                    </td>
                                                                    <td>
                                                                        <select name="class[]" class="form-control" required>
                                                                            <option value="">Select Class</option>
                                                                            @foreach ($level as $lvl)
                                                                            @if($lvl->level == $item->level)
                                                                            <option value="{{ $lvl->id }}" selected>{{ $lvl->class }}</option>
                                                                            @else
                                                                            <option value="{{ $lvl->id }}">{{ $lvl->class }}</option>
                                                                            @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-danger remove-level" onclick="removeLevel(this, {{ $item->id }})">Remove</button>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                                @else
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" name="level[]" class="form-control" required>
                                                                    </td>
                                                                    <td>
                                                                        <select name="class[]" class="form-control" required>
                                                                            <option value="">Select Class</option>
                                                                            @foreach ($level as $lvl)
                                                                            <option value="{{ $lvl->id }}">{{ $lvl->class }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-danger remove-level" onclick="removeLevel(this)">Remove</button>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                        <button type="button" class="btn btn-primary mt-2" onclick="addLevel()">Add Level</button>
                                                    </div>
                                                </div>

                                                <!-- Breakdown Types and Amounts -->
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Breakdown Types</label>
                                                    <div class="col-lg-8">
                                                        <table class="table" id="typeTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Type</th>
                                                                    <th>Amount</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(isset($type) && $type->count() > 0)
                                                                @foreach ($type as $t)
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" name="type[]" class="form-control" value="{{ $t->type }}" required>
                                                                        <input type="hidden" name="type_id[]" value="{{ $t->id }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="amount[]" class="form-control" value="{{ $t->amount }}" required>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-danger remove-type" onclick="removeType(this, {{ $t->id }})">Remove</button>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                                @else
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" name="type[]" class="form-control" required>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="amount[]" class="form-control" required>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-danger remove-type" onclick="removeType(this)">Remove</button>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                        <button type="button" class="btn btn-primary mt-2" onclick="addType()">Add Type</button>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!empty($id))
                                                        <a href="{{ route('school.index') }}" class="btn btn-sm btn-danger float-right m-t-n-xs">Cancel</a>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs mr-2" type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit">Save</button>
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
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
    function addLevel() {
        let table = document.getElementById('levelTable').getElementsByTagName('tbody')[0];
        let row = table.insertRow();
        row.innerHTML = `
            <td><input type="text" name="level[]" class="form-control" required></td>
            <td>
                <select name="class[]" class="form-control" required>
                    <option value="">Select Class</option>
                    @foreach ($level as $lvl)
                    <option value="{{ $lvl->id }}">{{ $lvl->class }}</option>
                    @endforeach
                </select>
            </td>
            <td><button type="button" class="btn btn-danger remove-level" onclick="removeLevel(this)">Remove</button></td>
        `;
    }

    function removeLevel(button, id = null) {
        if (id) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'removed_id[]';
            input.value = id;
            button.closest('form').appendChild(input);
        }
        button.closest('tr').remove();
    }

    function addType() {
        let table = document.getElementById('typeTable').getElementsByTagName('tbody')[0];
        let row = table.insertRow();
        row.innerHTML = `
            <td><input type="text" name="type[]" class="form-control" required></td>
            <td><input type="text" name="amount[]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger remove-type" onclick="removeType(this)">Remove</button></td>
        `;
    }

    function removeType(button, id = null) {
        if (id) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'tremoved_id[]';
            input.value = id;
            button.closest('form').appendChild(input);
        }
        button.closest('tr').remove();
    }
</script>
@endsection