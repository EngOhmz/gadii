<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Leave Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1, h3 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed; /* Fix table layout */
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            vertical-align: middle; /* Center-align content vertically */
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            margin-bottom: 20px;
            text-align: center;
        }
        .badge {
            padding: 5px;
            border-radius: 3px;
            font-size: 10px;
            text-transform: uppercase;
        }
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        td.reason {
            text-align: left; /* Align reason text to the left */
            word-wrap: break-word; /* Break long words */
            overflow: hidden; /* Hide overflow */
            text-overflow: ellipsis; /* Add ellipsis for overflowing text */
        }
        /* Set column widths */
        th:nth-child(1), td:nth-child(1) {
            width: 5%;
        }
        th:nth-child(2), td:nth-child(2) {
            width: 15%;
        }
        th:nth-child(3), td:nth-child(3),
        th:nth-child(4), td:nth-child(4) {
            width: 10%;
        }
        th:nth-child(5), td:nth-child(5) {
            width: 10%;
        }
        th:nth-child(6), td:nth-child(6) {
            width: 15%;
        }
        th:nth-child(7), td:nth-child(7) {
            width: 35%; /* Wider column for reason */
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Individual Leave Report</h1>
        @if($leaves->isNotEmpty())
            <h3>Employee: {{ $leaves->first()->staff->name }}</h3>
        @endif
        @if($start_date && $end_date)
            <p>Period: {{ \Carbon\Carbon::parse($start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}</p>
        @else
            <p>Showing all leave records.</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaves as $index => $leave)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $leave->category->leave_category }}</td>
                <td>{{ \Carbon\Carbon::parse($leave->leave_start_date)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($leave->leave_end_date)->format('d M Y') }}</td>
                <td>
                    @if($leave->duration_type == 'hours')
                        {{ $leave->hours }} hours  
                        {{ \Carbon\Carbon::parse($leave->start_hour)->format('g:i A') }} to 
                        {{ \Carbon\Carbon::parse($leave->end_hour)->format('g:i A') }}
                    @else
                        {{ \Carbon\Carbon::parse($leave->leave_end_date)->diffInDays($leave->leave_start_date) + 1 }} days
                    @endif
                </td>
                <td>
                   
                    @if($leave->application_status == 1)
                        Pending
                    @elseif($leave->application_status == 2)
                        First Level Approved (HDO)
                    @elseif($leave->application_status == 3)
                        Second Level Approved (MD)
                    @elseif($leave->application_status == 4)
                        Third Level Approved (Director)
                    @elseif($leave->application_status == 5)
                        Rejected
                    @else
                        Unknown
                    @endif
               
                </td>
                <td class="reason">{{ $leave->reason ?? 'N/A' }}</td> 
            </tr>
            @empty
            <tr>
                <td colspan="7">No leave records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
