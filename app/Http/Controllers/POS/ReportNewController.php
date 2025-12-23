<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\POS\InvoicePayments;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\MasterHistory;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\SerialList;
use App\Models\POS\GoodIssue;
use App\Models\POS\GoodIssueItem;
use App\Models\POS\StockMovement;
use App\Models\POS\StockMovementItem;
use App\Models\POS\GoodDisposal;
use App\Models\POS\GoodDisposalItem;
use App\Models\POS\Items;
use App\Models\POS\Category;
use App\Models\POS\Color;
use App\Models\POS\Size;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
use App\Models\Client;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\Restaurant\POS\Menu;
use App\Models\User;
use PDF;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



use App\Traits\SalesReportTrait;
use App\Traits\MasterHistoryTrait;
use App\Traits\MinHistoryTrait;

use Carbon\Carbon;

use App\Models\Branch;

class ReportNewController extends Controller
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


    use SalesReportTrait;

public function sales_report(Request $request)
{
    // Get the 'added_by' of the authenticated user
    $addedBy = Auth::user()->added_by;

    // Get locations based on 'added_by'
    $locations = Location::where('added_by', $addedBy)->get();  

    // Get input values for filters
    $startDate  = $request->input('start_date');
    $endDate    = $request->input('end_date');
    $location   = $request->input('location');
    $salesType  = $request->input('sales_type');
    $perPage    = 10; // Number of items per page
    $page       = $request->input('page', 1); // Get current page

    // If no dates are provided, return an empty paginated response
    if (empty($startDate) || empty($endDate)) {
        $salesReport = new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage);
    } else {
        // Fetch paginated sales report with filters
        $salesReport = $this->getSalesReport($perPage, $startDate, $endDate, $location, $salesType);
    }

    // Append query parameters to pagination links
    $salesReport->appends([
        'start_date' => $startDate,
        'end_date' => $endDate,
        'location' => $location,
        'sales_type' => $salesType,
    ]);
    
    // dd([
    //    'addedBy'     => $addedBy,
    //    'locations'   => $locations,
    //    'startDate'   => $startDate,
    //    'endDate'     => $endDate,
    //    'location'    => $location,
    //    'salesType'   => $salesType,
    //    'salesReport' => $salesReport
    // ]);

    return view('pos.report.salesreport', compact('salesReport', 'locations', 'startDate', 'endDate', 'location', 'salesType'));
}


    use MinHistoryTrait;

    public function min_quantity_report(Request $request)
{
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $location = $request->input('location', ''); // Default to empty string if not set

    $locations = Location::where('added_by', auth()->user()->id)->get();

    if (!$start_date || !$end_date) {
        // Preload items with status "Out of Stock" and "Almost Out of Stock"
        $items = $this->getItems(null, null, $location ?? null);

        
        
        // Filter out only items with status "In Stock"
        $items = collect($items)->filter(function ($item) {
            if ($item['quantity'] <= 0) {
                $item['status'] = 'Out of Stock';
            } elseif ($item['quantity'] < $item['minimum_balance']) {
                $item['status'] = 'Almost Out of Stock';
            }
            return in_array($item['status'], ['Out of Stock', 'Almost Out of Stock']);
        });

       // dd($items); // Debugging the result

    } else {
        // Get filtered items based on dates
        $items = $this->getItems($start_date, $end_date, $location ?? null);

        // Apply the status logic
        $items = collect($items)->map(function ($item) {
            if ($item['quantity'] <= 0) {
                $item['status'] = 'Out of Stock';
            } elseif ($item['quantity'] < $item['minimum_balance']) {
                $item['status'] = 'Almost Out of Stock';
            } else {
                $item['status'] = 'In Stock';
            }

            return $item;
        })->filter(function ($item) {
            return $item['status'] !== 'In Stock'; // Exclude items that are In Stock
        });

       // dd($items); // Debugging the result
    }

    return view('pos.report.min_quantity_report', compact('items', 'locations', 'location', 'start_date', 'end_date'));
}


    public function expire_report(Request $request)
{
    $now = Carbon::now();
    // Define predefined expiration ranges
    $ranges = [
        'one_week' => Carbon::parse($now)->addWeek(),
        'two_weeks' => Carbon::parse($now)->addWeeks(2),
        'three_weeks' => Carbon::parse($now)->addWeeks(3),
        'one_month' => Carbon::parse($now)->addMonth(),
        'two_months' => Carbon::parse($now)->addMonths(2),
        'three_months' => Carbon::parse($now)->addMonths(3),
        'six_months' => Carbon::parse($now)->addMonths(6),
    ];

    // Set default range to one week if not selected
    $selectedRange = $request->input('range', 'one_week');

    // Get the future date based on the selected range
    $futureDate = $ranges[$selectedRange] ?? $ranges['one_week'];

    // Query items that are either expired or expiring within the selected range
    $items = Items::where('expire_date', '<', $now)
        ->orWhereBetween('expire_date', [$now, $futureDate])
        ->get()
        ->map(function ($item) use ($now) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'type' => $item->type,
                'cost_price' => $item->cost_price,
                'sales_price' => $item->sales_price,
                'minimum_balance' => $item->minimum_balance,
                'tax_rate' => $item->tax_rate,
                'crate_size' => $item->crate_size,
                'quantity' => $item->quantity,
                'unit' => $item->unit,
                'expire_date' => $item->expire_date,
                'status' => Carbon::parse($item->expire_date)->lessThanOrEqualTo($now) ? 'expired' : 'expiring'
            ];
        });

       // dd($items);

    // Pass items and the selected range to the view
    return view('pos.report.product_expire_report', compact('items', 'selectedRange'));
}


use MasterHistoryTrait;
public function stock_report(Request $request)
{
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $location = $request->input('location', ''); // Default to empty string if not set

    // Get locations where added_by matches the authenticated user
    $locations = Location::where('added_by', auth()->user()->id)->get();

    // If no start date or end date is provided, initialize $items as an empty array
    if (!$start_date || !$end_date) {
        $items = [];
    } else {
        // If location is empty or null, fetch all items (no location filter)
        $items = $this->getItemQuantities($start_date, $end_date, $location ?? null);
    }

    // Pass $items, $locations, $start_date, $end_date, and $location to the view
    return view('pos.report.stock_report_new', compact('items', 'locations', 'location', 'start_date', 'end_date'));
}





 
    

    public function profit_report(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if (auth()->user()->id = 1 || (auth()->user()->added_by = 1259 || auth()->user()->id == 18792 || auth()->user()->id == 16173)) {
            $location = Location::whereIn('added_by', [1259, 1])->get();
        } elseif (!empty(auth()->user()->location)) {
            $location = Location::where('id', auth()->user()->location)->get();
        } elseif (auth()->user()->id == auth()->user()->added_by) {
            $location = Location::where('added_by', auth()->user()->added_by)->get();
        } else {
            $location = Location::where('added_by', auth()->user()->added_by)->get();
        }

        // $location = Location::whereIn('added_by', [1259, 1])->get();

        $added_by = auth()->user()->added_by;

        $location_ids = [];

        $location_id = $request->location_id;

        if (!empty($location_id)) {
            if ($location_id == 'all') {
                // Construct the SQL query
                $rowDatampya =
                    "
                                        SELECT
                                            pos_master_history.item_id AS id,
                                            tbl_items.name,
                                            pos_item_size.name AS size,
                                            pos_item_color.name AS color,
                                            SUM(CASE WHEN pos_master_history.date BETWEEN '" .
                    $start_date .
                    "' AND '" .
                    $end_date .
                    "'
                                                    AND pos_master_history.type IN('Sales','Credit Note')
                                                    THEN pos_master_history.out * pos_master_history.price - pos_master_history.in * pos_master_history.price
                                                    ELSE 0 END) AS sales_qty,
                                            SUM(CASE WHEN pos_master_history.date BETWEEN '" .
                    $start_date .
                    "' AND '" .
                    $end_date .
                    "'
                                                    AND pos_master_history.type IN('Sales','Credit Note')
                                                    THEN pos_master_history.out * tbl_items.cost_price - pos_master_history.in * tbl_items.cost_price
                                                    ELSE 0 END) AS cost_qty
                                        FROM
                                            pos_master_history
                                        JOIN
                                            tbl_items ON tbl_items.id = pos_master_history.item_id
                                        LEFT OUTER JOIN
                                            pos_item_size ON pos_item_size.id = tbl_items.size
                                        LEFT OUTER JOIN
                                            pos_item_color ON pos_item_color.id = tbl_items.color
                                        WHERE
                                            tbl_items.type != '4'
                                            AND tbl_items.restaurant = '0'
                                            AND tbl_items.disabled = '0'
                                            AND pos_master_history.added_by = '" .
                    $added_by .
                    "'
                                            AND tbl_items.added_by = '" .
                    $added_by .
                    "'
                                        GROUP BY
                                            pos_master_history.item_id
                                    ";

                // Execute the query and get the results
                $data = DB::select($rowDatampya);

                // Construct the SQL query for totals
                $totalQuery =
                    "
                                        SELECT
                                            SUM(
                                                CASE WHEN pos_master_history.date BETWEEN '" .
                    $start_date .
                    "' AND '" .
                    $end_date .
                    "'
                                                AND pos_master_history.type IN('Sales','Credit Note')
                                                THEN pos_master_history.out * pos_master_history.price - pos_master_history.in * pos_master_history.price
                                                ELSE 0
                                                END
                                            ) AS total_sales_qty,
                                    
                                            SUM(
                                                CASE WHEN pos_master_history.date BETWEEN '" .
                    $start_date .
                    "' AND '" .
                    $end_date .
                    "'
                                                AND pos_master_history.type IN('Sales','Credit Note')
                                                THEN pos_master_history.out * tbl_items.cost_price - pos_master_history.in * tbl_items.cost_price
                                                ELSE 0
                                                END
                                            ) AS total_cost_qty,
                                    
                                            SUM(
                                                CASE WHEN pos_master_history.date BETWEEN '" .
                    $start_date .
                    "' AND '" .
                    $end_date .
                    "'
                                                AND pos_master_history.type IN('Sales','Credit Note')
                                                THEN (pos_master_history.out * pos_master_history.price - pos_master_history.in * pos_master_history.price)
                                                - (pos_master_history.out * tbl_items.cost_price - pos_master_history.in * tbl_items.cost_price)
                                                ELSE 0
                                                END
                                            ) AS total_profit
                                        FROM
                                            pos_master_history
                                        JOIN
                                            tbl_items ON tbl_items.id = pos_master_history.item_id
                                        WHERE
                                            tbl_items.type != '4'
                                            AND tbl_items.restaurant = '0'
                                            AND tbl_items.disabled = '0'
                                            AND pos_master_history.added_by = '" .
                    $added_by .
                    "'
                                            AND tbl_items.added_by = '" .
                    $added_by .
                    "'
                                    ";

                // Execute the query to get total values
                $totalData = DB::select($totalQuery);

                // Assuming $totalData returns the total_sales_qty, total_cost_qty, and total_profit

                // $dt =  Datatables::of($data);
            } else {
                // Construct the SQL query
                $rowDatampya =
                    "
                                SELECT
                                    pos_master_history.item_id AS id,
                                    tbl_items.name,
                                    pos_item_size.name AS size,
                                    pos_item_color.name AS color,
                                    SUM(CASE WHEN pos_master_history.date BETWEEN '" .
                    $start_date .
                    "' AND '" .
                    $end_date .
                    "'
                                            AND pos_master_history.type IN('Sales','Credit Note')
                                            THEN pos_master_history.out * pos_master_history.price - pos_master_history.in * pos_master_history.price
                                            ELSE 0 END) AS sales_qty,
                                    SUM(CASE WHEN pos_master_history.date BETWEEN '" .
                    $start_date .
                    "' AND '" .
                    $end_date .
                    "'
                                            AND pos_master_history.type IN('Sales','Credit Note')
                                            THEN pos_master_history.out * tbl_items.cost_price - pos_master_history.in * tbl_items.cost_price
                                            ELSE 0 END) AS cost_qty
                                FROM
                                    pos_master_history
                                JOIN
                                    tbl_items ON tbl_items.id = pos_master_history.item_id
                                LEFT OUTER JOIN
                                    pos_item_size ON pos_item_size.id = tbl_items.size
                                LEFT OUTER JOIN
                                    pos_item_color ON pos_item_color.id = tbl_items.color
                                WHERE
                                    tbl_items.type != '4'
                                    AND tbl_items.restaurant = '0'
                                    AND tbl_items.disabled = '0'
                                    AND pos_master_history.location IN ($location_id)
                                    AND pos_master_history.added_by = '" .
                    $added_by .
                    "'
                                    AND tbl_items.added_by = '" .
                    $added_by .
                    "'
                                GROUP BY
                                    pos_master_history.item_id
                            ";

                // Execute the query and get the results
                $data = DB::select($rowDatampya);

                // $dt =  Datatables::of($data);

                // Construct the SQL query for totals
                $totalQuery =
                    "
                                        SELECT
                                            SUM(
                                                CASE WHEN pos_master_history.date BETWEEN '" .
                    $start_date .
                    "' AND '" .
                    $end_date .
                    "'
                                                AND pos_master_history.type IN('Sales','Credit Note')
                                                THEN pos_master_history.out * pos_master_history.price - pos_master_history.in * pos_master_history.price
                                                ELSE 0
                                                END
                                            ) AS total_sales_qty,
                                    
                                            SUM(
                                                CASE WHEN pos_master_history.date BETWEEN '" .
                    $start_date .
                    "' AND '" .
                    $end_date .
                    "'
                                                AND pos_master_history.type IN('Sales','Credit Note')
                                                THEN pos_master_history.out * tbl_items.cost_price - pos_master_history.in * tbl_items.cost_price
                                                ELSE 0
                                                END
                                            ) AS total_cost_qty,
                                    
                                            SUM(
                                                CASE WHEN pos_master_history.date BETWEEN '" .
                    $start_date .
                    "' AND '" .
                    $end_date .
                    "'
                                                AND pos_master_history.type IN('Sales','Credit Note')
                                                THEN (pos_master_history.out * pos_master_history.price - pos_master_history.in * pos_master_history.price)
                                                - (pos_master_history.out * tbl_items.cost_price - pos_master_history.in * tbl_items.cost_price)
                                                ELSE 0
                                                END
                                            ) AS total_profit
                                        FROM
                                            pos_master_history
                                        JOIN
                                            tbl_items ON tbl_items.id = pos_master_history.item_id
                                        WHERE
                                            tbl_items.type != '4'
                                            AND tbl_items.restaurant = '0'
                                            AND tbl_items.disabled = '0'
                                            AND pos_master_history.location IN ($location_id)
                                            AND pos_master_history.added_by = '" .
                    $added_by .
                    "'
                                            AND tbl_items.added_by = '" .
                    $added_by .
                    "'
                                    ";

                // Execute the query to get total values
                $totalData = DB::select($totalQuery);
            }

            //  dd($data);

            return view('pos.report.profit_report_new', [
                // 'users' => $users,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'location' => $location,
                'location_id' => $location_id,
                'data' => $data,
                'totalData' => $totalData,
            ]);
        } else {
            return view('pos.report.profit_report_new', [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'location' => $location,
                'location_id' => $location_id,
            ]);
        }
    }
}

