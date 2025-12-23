@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Manage Teachers</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table datatable-basic table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Subjects</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($teachers as $teacher)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->subjects->pluck('name')->implode(', ') ?: 'No subjects assigned' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#assignSubjectsModal"
                                                    data-teacher-id="{{ $teacher->id }}" data-teacher-name="{{ $teacher->name }}"
                                                    data-subjects="{{ json_encode($teacher->subjects->pluck('id')->toArray()) }}">
                                                Assign/Edit
                                            </button>
                                            <form action="{{ route('teachersregister.destroy', $teacher->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove all subjects?')">Remove Subjects</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No teachers found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="assignSubjectsModal" tabindex="-1" role="dialog" aria-labelledby="assignSubjectsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignSubjectsModalLabel">Assign Subjects</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="assignSubjectsForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="teacher_id" id="modal_teacher_id">
                    <div class="form-group">
                        <label>Subjects (Select multiple) <span class="text-danger">*</span></label>
                        <div class="checkbox-list">
                            @foreach ($subjects as $subject)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="subject_ids[]"
                                       value="{{ $subject->id }}" id="subject_{{ $subject->id }}">
                                <label class="form-check-label" for="subject_{{ $subject->id }}">
                                    {{ $subject->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('subject_ids')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#assignSubjectsModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var teacherId = button.data('teacher-id');
        var teacherName = button.data('teacher-name');
        var assignedSubjects = button.data('subjects');

        var modal = $(this);
        modal.find('.modal-title').text('Assign ' + teacherName);
        modal.find('#modal_teacher_id').val(teacherId);

        modal.find('input[name="subject_ids[]"]').prop('checked', false);

        if (assignedSubjects) {
            assignedSubjects.forEach(function(subjectId) {
                modal.find('#subject_' + subjectId).prop('checked', true);
            });
        }

        var form = modal.find('#assignSubjectsForm');
        if (assignedSubjects && assignedSubjects.length > 0) {
            form.attr('action', '{{ url("school/teachersregister") }}/' + teacherId);
            form.append('<input type="hidden" name="_method" value="PUT">');
        } else {
            form.attr('action', '{{ route("teachersregister.store") }}');
            form.find('input[name="_method"]').remove();
        }
    });

    $('#assignSubjectsModal').on('hidden.bs.modal', function () {
        $(this).find('input[name="_method"]').remove();
    });
</script>

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
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
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection
@endsection