@extends('layouts.master')

@section('title')
    <h2><i class="fas fa-th-large pr-2 text-info"></i>Permission Assignment</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            Home
        </li>
        <li class="breadcrumb-item">
            Permission
        </li>
        <li class="breadcrumb-item active">
            <strong>Assign</strong>
        </li>
    </ol>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="ibox p-0">
            <div class="ibox-title">
                <h3 class="text-uppercase">{{ $role->slug }} ( Role ) - Permissions</h3>
                <div class="ibox-tools text-white">
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-info btn-xs px-4"><i
                            class="fa fa-arrow-circle-left"></i> Back </a>
                </div>
            </div>
            <div class="ibox-content p-2">
                {!! Form::open(['route' => 'roles.create']) !!}
                @method('GET')
                <table class="table table-sm table-bordered w-100" id="datatable">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Module</th>
                        <th>CRUD</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($modules as $module)
                        <tr>
                            <td>{{ $module->id }}</td>
                            <td width="25%">{{ $module->slug }}</td>
                            <td>
                               <div class="row">
                                    @foreach($permissions as $permission)
                                        @if($permission->sys_module_id == $module->id)
                                            @if($role->hasAccess($permission->slug))
                                            <div class="col-md-4 col-sm-6">
                                                <label>
                                                    <input type="checkbox"
                                                        value="{{ $permission->id }}"
                                                        name="permissions[]" checked>
                                                    {{ $permission->slug }}
                                                </label>
                                            </div>
                                            @else
                                            <div class="col-md-4 col-sm-6">
                                                <label>
                                                    <input type="checkbox" value="{{ $permission->id }}"
                                                        name="permissions[]">
                                                    {{ $permission->slug }}
                                                </label>
                                            </div>
                                            @endif
                                        @endif
                                    @endforeach
                               </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <input type="hidden" name="role_id" value="{{$role->id}}">
                <div class="row justify-content-end p-0 mr-1">
                    <div class="p-1">
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary btn-xs px-4"><i
                                class="fa fa-arrow-circle-left"></i> Back </a>
                        {!! Form::submit('Assign', ['class' => 'btn btn-outline-success btn-xs px-4']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $('#datatable').DataTable();
    </script>
@endsection
