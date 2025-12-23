@extends('layouts.master')


@section('content')
<div class="card">
    <div class="card-body text-primary">
        <h1 class="h3 mb-0 text-gray-800">
            <img width="48" height="48"
                src="https://img.icons8.com/ink/48/22C3E6/presentation.png"/>
                Student Results
        </h1>
    </div>
</div>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <form method="GET" action="">
                            <div class="row mb-4">
                                <div class="col-md-2">
                                    <select name="level" class="form-control">
                                        <option value="">Select Teacher</option>

                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select name="class" class="form-control">
                                        <option value="">Select Subject</option>

                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select name="stream" class="form-control">
                                        <option value="">Select Class</option>

                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select name="branch" class="form-control">
                                        <option value="">Select Stream</option>

                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select name="exam" class="form-control">
                                        <option value="">Select Examtype</option>

                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select name="subject" class="form-control">
                                        <option value="">Select Term</option>

                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select name="subject" class="form-control">
                                        <option value="">Select Year</option>

                                    </select>
                                </div>
                            </div>

                        </form>



                        <div class="table-responsive mt-4">
                            <table class="table table-bordered datatable-basic">
                                 <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Subject</th>
                                        <th>Exam</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


@endsection

@section('scripts')
<script>
    $('.datatable-basic').DataTable({
        autoWidth: false,
        "columnDefs": [{
            "orderable": false,
            "targets": [1]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        "language": {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {
                'first': 'First',
                'last': 'Last',
                'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
            }
        },

    });


    $('.demo4').click(function() {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function() {
            swal("Deleted!", "Your imaginary file has been deleted.", "success");
        });
    });
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection