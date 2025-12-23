<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Carbon\Carbon;

use App\Models\Branch;

class SysAuditingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
{
    $startDate   = $request->input('start_date');
    $endDate     = $request->input('end_date');
    $reportType  = $request->input('report_type');
    $perPage     = 10; // Number of items per page

    // Default: empty paginator if dates not provided
    if (empty($startDate) || empty($endDate)) {
        $salesReport = new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage);
    } else {
        // Pick model based on report type
        switch (strtolower($reportType)) {
            case 'sales':
                $model = \App\Models\Auditing\SalesAuditing::class;
                break;
            case 'hr':
                $model = \App\Models\Auditing\HrAuditing::class;
                break;
            case 'lead':
                $model = \App\Models\Auditing\LeadsAuditing::class;
                break;
            default:
                $model = null;
        }

        if ($model) {
            $salesReport = $model::query()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        } else {
            $salesReport = new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage);
        }
    }

    // Append query parameters to pagination links
    if ($salesReport instanceof \Illuminate\Pagination\AbstractPaginator) {
        $salesReport->appends([
            'start_date'  => $startDate,
            'end_date'    => $endDate,
            'report_type' => $reportType,
        ]);
    }

    return view('auditing.index', compact('salesReport', 'startDate', 'endDate', 'reportType'));
}

}