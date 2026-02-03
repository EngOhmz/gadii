   @if (!@empty($images) && $images->count() > 0)
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>File name</th>
                        <th style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($images as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <i class="fa fa-file-o text-muted mr-1"></i>
                                {{ $row->original_filename }}
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-primary mr-1" title="View" href="{{ route('view_attachment', $row->id) }}" target="_blank">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-secondary mr-1" title="Download" href="{{ route('download_attachment', $row->id) }}">
                                    <i class="fa fa-download"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-danger" title="Delete" href="{{ route('delete_attachment', $row->id) }}" onclick="return confirm('Are you sure you want to delete this attachment?');">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr class="my-3">
   @else
        <p class="text-muted mb-0"><i class="fa fa-paperclip"></i> No attachments yet. Add some below.</p>
        <hr class="my-3">
   @endif
