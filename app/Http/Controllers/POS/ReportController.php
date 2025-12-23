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
//use App\Models\invoice_items;
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

use App\Traits\StockMovementTrait;

use App\Traits\SalesPurchasesCalculation;

class ReportController extends Controller
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



    public function report_by_date(Request $request)
    {


        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();

        if (!empty($location[0])) {
            foreach ($location as $loc) {
                $x[] = $loc->id;

            }
        } else {
            $x[] = '';
        }

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $location_id = $request->location_id;

        $z[] = $location_id;

        $a = trim(json_encode($x), '[]');
        if ($location_id == $a) {
            $loc_id = $x;
        } else {

            $loc_id = $z;
        }



        //$data=Items::select('*')->where('added_by',auth()->user()->added_by)->where('restaurant',0)->where('disabled',0)->where('type','!=',4);  

        $data = [];


        if ($request->ajax()) {

            $added_by = auth()->user()->added_by;

            $rowDatampya = "SELECT pos_master_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color,  SUM(CASE WHEN pos_master_history.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' THEN pos_master_history.in ELSE 0 END) AS in_qty, 
        SUM(CASE WHEN pos_master_history.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' THEN pos_master_history.out  ELSE 0 END) AS out_qty, SUM(CASE WHEN pos_master_history.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' THEN pos_master_history.in - pos_master_history.out ELSE 0 END) AS balance,
        SUM(CASE WHEN pos_master_history.date < '" . $start_date . "' THEN pos_master_history.in - pos_master_history.out ELSE 0 END) AS open_balance 
        FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color WHERE tbl_items.type != '4' AND tbl_items.restaurant = '0' AND tbl_items.disabled = '0'
        AND pos_master_history.location IN ($location_id)  AND pos_master_history.added_by = '" . $added_by . "' AND tbl_items.added_by = '" . $added_by . "' GROUP by pos_master_history.item_id ";

            $data = DB::select($rowDatampya);


            $dt = Datatables::of($data);

            $dt = $dt->editColumn('name', function ($row) {

                if (!empty($row->color) && empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color;
                    return $name;
                } elseif (empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->size;
                    return $name;
                } elseif (!empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color . ' - ' . $row->size;
                    return $name;
                } else {

                    $name = $row->name;
                    return $name;

                }


            });

            $dt = $dt->editColumn('open', function ($row) {

                return '<a href="#"   class="item" data-id = "' . $row->id . '" data-type="open_in_qty" data-toggle="modal" data-target="#viewModal">' . number_format($row->open_balance, 2) . '</a>';
            });

            $dt = $dt->editColumn('in', function ($row) {
                return '<a href="#"   class="item" data-id = "' . $row->id . '" data-type="in_qty" data-toggle="modal" data-target="#viewModal">' . number_format($row->in_qty, 2) . '</a>';
            });
            $dt = $dt->editColumn('out', function ($row) {
                return '<a href="#" class="item"  data-id = "' . $row->id . '" data-type="out_qty" data-toggle="modal" data-target="#viewModal">' . number_format($row->out_qty, 2) . '</a>';
            });


            $dt = $dt->editColumn('balance', function ($row) {
                return number_format($row->open_balance + $row->balance, 2);
            });

            $dt = $dt->rawColumns(['open', 'in', 'out', 'balance']);
            return $dt->make(true);
        }



        return view(
            'pos.report.report_by_date',
            compact('data', 'start_date', 'end_date', 'location', 'x', 'z', 'location_id')
        );

    }

    public function general_operation_report(Request $request)
    {

        return view('pos.report.general_operation_report');
    }


    public function stock_report(Request $request)
    {

        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();

        if (!empty($location[0])) {
            foreach ($location as $loc) {
                $x[] = $loc->id;

            }
        } else {
            $x[] = '';
        }

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $location_id = $request->location_id;

        $z[] = $location_id;

        $a = trim(json_encode($x), '[]');
        if ($location_id == $a) {
            $loc_id = $x;
        } else {

            $loc_id = $z;
        }



        //$data=Items::select('*')->where('added_by',auth()->user()->added_by)->where('restaurant',0)->where('disabled',0)->where('type','!=',4);  

        $data = [];


        if ($request->ajax()) {

            $added_by = auth()->user()->added_by;

            $rowDatampya = "SELECT pos_master_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color, SUM(CASE WHEN pos_master_history.date < '" . $start_date . "' AND pos_master_history.type IN('Purchases','Debit Note') THEN pos_master_history.in * pos_master_history.price - pos_master_history.out * pos_master_history.price ELSE 0 END) AS open_qty,
        SUM(CASE WHEN pos_master_history.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND pos_master_history.type IN('Purchases','Debit Note') THEN pos_master_history.in * pos_master_history.price - pos_master_history.out * pos_master_history.price ELSE 0 END) AS pur_qty,
        SUM(CASE WHEN pos_master_history.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND pos_master_history.type IN('Sales','Credit Note')THEN pos_master_history.out * pos_master_history.price - pos_master_history.in * pos_master_history.price ELSE 0 END) AS sales_qty 
        FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color WHERE tbl_items.type != '4' AND tbl_items.restaurant = '0' AND tbl_items.disabled = '0'
        AND pos_master_history.location IN ($location_id)  AND pos_master_history.added_by ='" . $added_by . "' AND tbl_items.added_by = '" . $added_by . "' GROUP by pos_master_history.item_id";



            $data = DB::select($rowDatampya);


            $dt = Datatables::of($data);

            $dt = $dt->editColumn('name', function ($row) {

                if (!empty($row->color) && empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color;
                    return $name;
                } elseif (empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->size;
                    return $name;
                } elseif (!empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color . ' - ' . $row->size;
                    return $name;
                } else {

                    $name = $row->name;
                    return $name;

                }


            });

            $dt = $dt->editColumn('open', function ($row) {

                return '<a href="#"   class="item" data-id = "' . $row->id . '" data-type="open_qty" data-toggle="modal" data-target="#viewModal">' . number_format($row->open_qty, 2) . '</a>';
            });

            $dt = $dt->editColumn('purchases', function ($row) {
                return '<a href="#"   class="item" data-id = "' . $row->id . '" data-type="pur_qty" data-toggle="modal" data-target="#viewModal">' . number_format($row->pur_qty, 2) . '</a>';
            });
            $dt = $dt->editColumn('sales', function ($row) {
                return '<a href="#" class="item"  data-id = "' . $row->id . '" data-type="sales_qty" data-toggle="modal" data-target="#viewModal">' . number_format($row->sales_qty, 2) . '</a>';
            });


            $dt = $dt->editColumn('balance', function ($row) {
                return number_format(($row->open_qty + $row->pur_qty) - $row->sales_qty, 2);
            });

            $dt = $dt->rawColumns(['open', 'purchases', 'sales', 'balance']);
            return $dt->make(true);
        }





        return view(
            'pos.report.stock_report',
            compact('data', 'start_date', 'end_date', 'location', 'x', 'z', 'location_id')
        );

    }



    public function profit_report(Request $request)
    {

        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();

        if (!empty($location[0])) {
            foreach ($location as $loc) {
                $x[] = $loc->id;

            }
        } else {
            $x[] = '';
        }

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $location_id = $request->location_id;

        $z[] = $location_id;

        $a = trim(json_encode($x), '[]');
        if ($location_id == $a) {
            $loc_id = $x;
        } else {

            $loc_id = $z;
        }



        //$data=Items::select('*')->where('added_by',auth()->user()->added_by)->where('restaurant',0)->where('disabled',0)->where('type','!=',4);  

        $data = [];


        if ($request->ajax()) {

            $added_by = auth()->user()->added_by;

            $rowDatampya = "SELECT pos_master_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color, SUM(CASE WHEN pos_master_history.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND pos_master_history.type IN('Sales','Credit Note') THEN pos_master_history.out * pos_master_history.price - pos_master_history.in * pos_master_history.price ELSE 0 END) AS sales_qty, 
        SUM(CASE WHEN pos_master_history.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND pos_master_history.type IN('Sales','Credit Note')THEN pos_master_history.out * tbl_items.cost_price - pos_master_history.in * tbl_items.cost_price ELSE 0 END) AS cost_qty 
        FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color WHERE tbl_items.type != '4' AND tbl_items.restaurant = '0' AND tbl_items.disabled = '0'
        AND pos_master_history.location IN ($location_id)  AND pos_master_history.added_by ='" . $added_by . "' AND tbl_items.added_by = '" . $added_by . "' GROUP by pos_master_history.item_id";



            $data = DB::select($rowDatampya);


            $dt = Datatables::of($data);

            $dt = $dt->editColumn('name', function ($row) {

                if (!empty($row->color) && empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color;
                    return $name;
                } elseif (empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->size;
                    return $name;
                } elseif (!empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color . ' - ' . $row->size;
                    return $name;
                } else {

                    $name = $row->name;
                    return $name;

                }


            });



            $dt = $dt->editColumn('sales', function ($row) {
                return '<a href="#"   class="item" data-id = "' . $row->id . '" data-type="sales_qty" data-toggle="modal" data-target="#viewModal">' . number_format($row->sales_qty, 2) . '</a>';
            });
            $dt = $dt->editColumn('cost', function ($row) {
                return '<a href="#" class="item"  data-id = "' . $row->id . '" data-type="cost_qty" data-toggle="modal" data-target="#viewModal">' . number_format($row->cost_qty, 2) . '</a>';
            });


            $dt = $dt->editColumn('balance', function ($row) {
                return number_format($row->sales_qty - $row->cost_qty, 2);
            });

            $dt = $dt->rawColumns(['open', 'cost', 'sales', 'balance']);
            return $dt->make(true);
        }



        return view(
            'pos.report.profit_report',
            compact('data', 'start_date', 'end_date', 'location', 'x', 'z', 'location_id')
        );

    }

    public function good_issue_report(Request $request)
    {

        //$data=Items::where('added_by',auth()->user()->added_by)->whereIn('type', [1,2,3])->where('restaurant',0)->where('disabled',0)->get();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $location_id = $request->location_id;

        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();

        if (!empty($location[0])) {

            foreach ($location as $loc) {
                $x[] = $loc->id;


            }
        } else {
            $x[] = '';
        }

        $z[] = $location_id;

        $a = trim(json_encode($x), '[]');
        if ($location_id == $a) {
            $loc_id = $x;
        } else {

            $loc_id = $z;
        }





        $data = [];


        if ($request->ajax()) {

            $added_by = auth()->user()->added_by;

            $rowDatampya = " SELECT pos_master_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color,SUM(CASE WHEN pos_master_history.type='Good Issue' THEN pos_master_history.out ELSE 0 END) AS issue_qty,   
                        SUM(CASE WHEN pos_master_history.type='Returned Good Issue' THEN pos_master_history.in ELSE 0 END) AS return_qty,SUM(CASE WHEN pos_master_history.type='Good Issue' THEN pos_master_history.out ELSE 0 END - CASE WHEN pos_master_history.type='Returned Good Issue' THEN pos_master_history.in ELSE 0 END) AS balance, 
                        SUM(CASE WHEN pos_master_history.type='Good Issue' THEN pos_master_history.out * price ELSE 0 END - CASE WHEN pos_master_history.type='Returned Good Issue' THEN pos_master_history.in * price ELSE 0 END) AS cost FROM `pos_master_history` 
                        JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color WHERE tbl_items.type != '4' 
                        AND tbl_items.restaurant = '0' AND tbl_items.disabled = '0' AND pos_master_history.location IN ($location_id)  AND pos_master_history.added_by = '" . $added_by . "' AND  pos_master_history.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND tbl_items.added_by = '" . $added_by . "' GROUP by pos_master_history.item_id ";

            $data = DB::select($rowDatampya);


            $dt = Datatables::of($data);

            $dt = $dt->editColumn('name', function ($row) {

                if (!empty($row->color) && empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color;
                    return $name;
                } elseif (empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->size;
                    return $name;
                } elseif (!empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color . ' - ' . $row->size;
                    return $name;
                } else {

                    $name = $row->name;
                    return $name;

                }


            });

            $dt = $dt->editColumn('issue', function ($row) {

                return '<a href="#"   class="item" data-id = "' . $row->id . '" data-type="issue_qty" data-toggle="modal" data-target="#viewModal">' . number_format($row->issue_qty, 2) . '</a>';
            });

            $dt = $dt->editColumn('return', function ($row) {
                return '<a href="#"   class="item" data-id = "' . $row->id . '" data-type="return_qty" data-toggle="modal" data-target="#viewModal">' . number_format($row->return_qty, 2) . '</a>';
            });
            $dt = $dt->editColumn('balance', function ($row) {
                return number_format($row->balance, 2);
            });


            $dt = $dt->editColumn('cost', function ($row) {
                return number_format($row->cost, 2);
            });

            $dt = $dt->rawColumns(['issue', 'return']);
            return $dt->make(true);
        }



        return view(
            'pos.report.good_issue_report',
            compact('data', 'start_date', 'end_date', 'location', 'x', 'z', 'location_id')
        );

    }

    public function good_disposal_report(Request $request)
    {


        //$data=Items::where('added_by',auth()->user()->added_by)->whereIn('type', [1,2,3])->where('restaurant',0)->where('disabled',0)->get();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $location_id = $request->location_id;

        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();

        if (!empty($location[0])) {

            foreach ($location as $loc) {
                $x[] = $loc->id;


            }
        } else {
            $x[] = '';
        }

        $z[] = $location_id;

        $a = trim(json_encode($x), '[]');
        if ($location_id == $a) {
            $loc_id = $x;
        } else {

            $loc_id = $z;
        }





        $data = [];


        if ($request->ajax()) {

            $added_by = auth()->user()->added_by;

            $rowDatampya = "SELECT pos_master_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color, SUM(pos_master_history.out) AS total_qty,
                        SUM(pos_master_history.out * pos_master_history.price) AS total_cost FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color 
                        WHERE tbl_items.type != '4' AND  pos_master_history.type='Good Disposal' AND pos_master_history.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND tbl_items.restaurant = '0' AND tbl_items.disabled = '0' AND pos_master_history.location IN ($location_id)  AND pos_master_history.added_by = '" . $added_by . "' 
                        AND tbl_items.added_by = '" . $added_by . "' GROUP by pos_master_history.item_id ";

            $data = DB::select($rowDatampya);


            $dt = Datatables::of($data);

            $dt = $dt->editColumn('name', function ($row) {

                if (!empty($row->color) && empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color;

                } elseif (empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->size;

                } elseif (!empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color . ' - ' . $row->size;

                } else {

                    $name = $row->name;


                }

                return '<a href="#"   class="item" data-id = "' . $row->id . '" data-type="disposal_qty" data-toggle="modal" data-target="#viewModal">' . $name . '</a>';


            });

            $dt = $dt->editColumn('qty', function ($row) {

                return number_format($row->total_qty, 2);
            });

            $dt = $dt->editColumn('cost', function ($row) {
                return number_format($row->total_cost, 2);
            });


            $dt = $dt->rawColumns(['name']);
            return $dt->make(true);
        }


        return view(
            'pos.report.good_disposal_report',
            compact('data', 'start_date', 'end_date', 'location', 'x', 'z', 'location_id')
        );

    }

    use StockMovementTrait;
    public function stock_movement_report(Request $request)
{
    // Retrieve start_date and end_date from the request
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // If no dates are provided, return an empty array
    if (!$startDate || !$endDate) {
        $stockMovementDetails = []; // Return an empty array if no dates are provided
    } else {
        // Pass the dates to the method to get filtered results
        $stockMovementDetails = $this->getStockMovementDetails($startDate, $endDate);
    }

    // Debug the stock movement details to inspect the result
    // dd($stockMovementDetails);

    // Return the view with the stock movement details
    return view('pos.report.stock_movement_report', compact('stockMovementDetails'));
}


    use SalesPurchasesCalculation;
public function stock_profit_report(Request $request)
{
    // Retrieve the start and end dates
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $locationId = $request->input('location', null); 

    // Retrieve the locations added by the authenticated user
    $locations = Location::where('added_by', auth()->user()->added_by)->get();

    // Fetch the report data
    if (!$startDate || !$endDate) {
        $reportData = [];
    } else {
        $reportData = $this->calculateSalesPurchases($startDate, $endDate, $locationId);
    }

    // Pass the data to the view
    return view('pos.report.stock_profit_report', compact('reportData', 'locations', 'locationId', 'startDate', 'endDate'));
}








    public function sales_report(Request $request)
    {

        $data = Items::where('added_by', auth()->user()->added_by)->where('bar', 0)->where('disabled', 0)->get();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        return view(
            'pos.report.sales_report',
            compact('data', 'start_date', 'end_date')
        );

    }
    public function balance_report(Request $request)
    {

        $data = Items::where('added_by', auth()->user()->added_by)->where('bar', 0)->where('disabled', 0)->get();


        return view(
            'pos.report.balance_report',
            compact('data')
        );

    }





    public function store_value(Request $request)
    {


        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();

        if (!empty($location[0])) {
            foreach ($location as $loc) {
                $x[] = $loc->id;

            }
        } else {
            $x[] = '';
        }

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $location_id = $request->location_id;

        $z[] = $location_id;

        $a = trim(json_encode($x), '[]');
        if ($location_id == $a) {
            $loc_id = $x;
        } else {

            $loc_id = $z;
        }



        $data = Items::select('*')->where('added_by', auth()->user()->added_by)->where('restaurant', 0)->where('disabled', 0)->where('type', '!=', 4);

        if ($request->ajax()) {

            $i = 0;

            $dt = Datatables::of($data);


            $i++;


            $dt = $dt->addColumn('a', function ($row) use ($start_date, $end_date, $loc_id, $location_id, &$pqty, &$sqty) {


                $ppd = DB::select("SELECT (SELECT coalesce(SUM(quantity), 0)  FROM `pos_purchases_history` WHERE `item_id` = '" . $row->id . "' AND type='Purchases' AND purchase_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND location IN ($location_id)) - (SELECT coalesce(SUM(quantity), 0)  FROM `pos_purchases_history` WHERE `item_id` = '" . $row->id . "' AND type='Debit Note' AND purchase_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND location IN ($location_id)) AS pd");
                $a = collect($ppd)->pluck('pd')->toArray();
                $pgood = $a[0];

                $impd = DB::select("SELECT coalesce(SUM(pos_stock_movement_items.quantity), 0) as imq FROM `pos_stock_movement_items` INNER JOIN pos_stock_movement ON pos_stock_movement_items.movement_id=pos_stock_movement.id WHERE pos_stock_movement_items.item_id = '" . $row->id . "' AND pos_stock_movement.movement_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND pos_stock_movement_items.destination_store IN ($location_id) AND pos_stock_movement.status = '1' ");
                $b = collect($impd)->pluck('imq')->toArray();
                $dgood = $b[0];

                $pqty = $pgood + $dgood;

                $spd = DB::select("SELECT (SELECT coalesce(SUM(quantity), 0)  FROM `pos_invoices_history` WHERE `item_id` = '" . $row->id . "' AND type='Sales' AND invoice_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND location IN ($location_id)) - (SELECT coalesce(SUM(quantity), 0)  FROM `pos_invoices_history` WHERE `item_id` = '" . $row->id . "' AND type='Credit Note' AND invoice_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND location IN ($location_id)) AS sd");
                $c = collect($spd)->pluck('sd')->toArray();
                $sgood = $c[0];

                $ompd = DB::select("SELECT coalesce(SUM(pos_stock_movement_items.quantity), 0) as omq FROM `pos_stock_movement_items` INNER JOIN pos_stock_movement ON pos_stock_movement_items.movement_id=pos_stock_movement.id WHERE pos_stock_movement_items.item_id = '" . $row->id . "' AND pos_stock_movement.movement_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND pos_stock_movement_items.source_store IN ($location_id) AND pos_stock_movement.status = '1' ");
                $d = collect($ompd)->pluck('omq')->toArray();
                $ogood = $d[0];

                $ispd = DB::select("SELECT coalesce(SUM(pos_good_issues_items.due_quantity), 0) as isq FROM `pos_good_issues_items` INNER JOIN pos_good_issues ON pos_good_issues_items.issue_id=pos_good_issues.id WHERE pos_good_issues_items.item_id = '" . $row->id . "' AND pos_good_issues.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND pos_good_issues_items.location IN ($location_id) AND pos_good_issues.status = '1' ");
                $e = collect($ispd)->pluck('isq')->toArray();
                $isgood = $e[0];


                $dpd = DB::select("SELECT coalesce(SUM(pos_good_disposal_items.quantity), 0) as dq FROM `pos_good_disposal_items` INNER JOIN pos_good_disposal ON pos_good_disposal_items.disposal_id=pos_good_disposal.id WHERE pos_good_disposal_items.item_id = '" . $row->id . "' AND pos_good_disposal.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND pos_good_disposal_items.location IN ($location_id) AND pos_good_disposal.status = '1' ");
                $f = collect($dpd)->pluck('dq')->toArray();
                $disgood = $f[0];

                $sqty = $sgood + $ogood + $isgood + $disgood;

            });







            $dt = $dt->editColumn('name', function ($row) {
                return $row->name;
            });
            $dt = $dt->editColumn('in', function ($row) use (&$pqty, &$sqty) {
                return '<a href="#"   class="item" data-id = "' . $row->id . '" data-type="in_qty" data-toggle="modal" data-target="#viewModal">' . number_format($pqty, 2) . '</a>';
            });
            $dt = $dt->editColumn('out', function ($row) use (&$pqty, &$sqty) {
                return '<a href="#" class="item"  data-id = "' . $row->id . '" data-type="out_qty" data-toggle="modal" data-target="#viewModal">' . number_format($sqty, 2) . '</a>';
            });


            $dt = $dt->editColumn('balance', function ($row) use (&$pqty, &$sqty) {
                return number_format($pqty - $sqty, 2);
            });

            $dt = $dt->rawColumns(['in', 'out', 'balance']);
            return $dt->make(true);
        }




        return view(
            'pos.report.store_value',
            compact('data', 'start_date', 'end_date', 'location', 'x', 'z', 'location_id')
        );

    }



    public function expire_report(Request $request)
    {

        $data = Items::where('added_by', auth()->user()->added_by)->whereIn('type', [1, 2, 3])->where('restaurant', 0)->where('disabled', 0)->get();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $location_id = $request->location_id;

        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();

        if (!empty($location[0])) {

            foreach ($location as $loc) {
                $x[] = $loc->id;


            }
        } else {
            $x[] = '';
        }

        $z[] = $location_id;

        return view(
            'pos.report.expire_report',
            compact('data', 'start_date', 'end_date', 'location', 'x', 'z', 'location_id')
        );

    }


    public function service_report(Request $request)
    {

        //$data=Items::where('added_by',auth()->user()->added_by)->whereIn('type', [1,2,3])->where('restaurant',0)->where('disabled',0)->get();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $location_id = $request->location_id;

        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();

        if (!empty($location[0])) {

            foreach ($location as $loc) {
                $x[] = $loc->id;


            }
        } else {
            $x[] = '';
        }

        $z[] = $location_id;

        $a = trim(json_encode($x), '[]');
        if ($location_id == $a) {
            $loc_id = $x;
        } else {

            $loc_id = $z;
        }





        $data = [];


        if ($request->ajax()) {

            $added_by = auth()->user()->added_by;

            $rowDatampya = "SELECT pos_master_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color, SUM(pos_master_history.out) AS total_qty,
                        SUM(pos_master_history.out * pos_master_history.price) AS total_cost FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color 
                        WHERE tbl_items.type = '4' AND  pos_master_history.type='Sales' AND pos_master_history.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND tbl_items.restaurant = '0' AND tbl_items.disabled = '0' AND pos_master_history.location IN ($location_id)  AND pos_master_history.added_by = '" . $added_by . "' 
                        AND tbl_items.added_by = '" . $added_by . "' GROUP by pos_master_history.item_id ";

            $data = DB::select($rowDatampya);


            $dt = Datatables::of($data);

            $dt = $dt->editColumn('name', function ($row) {

                if (!empty($row->color) && empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color;

                } elseif (empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->size;

                } elseif (!empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color . ' - ' . $row->size;

                } else {

                    $name = $row->name;


                }

                return '<a href="#"   class="item" data-id = "' . $row->id . '" data-type="service_qty" data-toggle="modal" data-target="#viewModal">' . $name . '</a>';


            });

            $dt = $dt->editColumn('qty', function ($row) {

                return number_format($row->total_qty, 2);
            });

            $dt = $dt->editColumn('cost', function ($row) {
                return number_format($row->total_cost, 2);
            });


            $dt = $dt->rawColumns(['name']);
            return $dt->make(true);
        }



        return view(
            'pos.report.service_report',
            compact('data', 'start_date', 'end_date', 'location', 'x', 'z', 'location_id')
        );

    }


    public function client_report(Request $request)
    {

        //$data=Items::where('added_by',auth()->user()->added_by)->whereIn('type', [1,2,3])->where('restaurant',0)->where('disabled',0)->get();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $location_id = $request->location_id;

        /*
        $location = Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();
         
          if(!empty($location[0])){                      
         
         foreach($location as $loc){
          $x[]=$loc->id;
        
   
}
}

else{
     $x[]='';  
}
 
 $z[]=$location_id;
 
  $a=  trim(json_encode($x), '[]'); 
                  if($location_id == $a){
                     $loc_id=$x;
                 }
                 
                 else{
                     
                  $loc_id=$z;    
                 }
                 
                 
                
   */

        $data = [];


        if ($request->ajax()) {

            $added_by = auth()->user()->added_by;

            $rowDatampya = "SELECT pos_master_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color, pos_master_history.out AS total_qty,
                        pos_master_history.client_id as client_id,pos_master_history.invoice_id as invoice_id,pos_master_history.out * pos_master_history.price AS total_cost 
                        FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size 
                        LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color WHERE pos_master_history.type='Sales' AND 
                        pos_master_history.date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND tbl_items.restaurant = '0' AND tbl_items.disabled = '0' AND 
                        pos_master_history.added_by = '" . $added_by . "' AND tbl_items.added_by = '" . $added_by . "'";

            $data = DB::select($rowDatampya);


            $dt = Datatables::of($data);

            $dt = $dt->editColumn('client', function ($row) {


                $client = Client::find($row->client_id);

                if (!empty($client)) {
                    $name = $client->name;

                } else {

                    $name = '';


                }

                return $name;


            });

            $dt = $dt->editColumn('name', function ($row) {

                if (!empty($row->color) && empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color;

                } elseif (empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->size;

                } elseif (!empty($row->color) && !empty($row->size)) {
                    $name = $row->name . ' - ' . $row->color . ' - ' . $row->size;

                } else {

                    $name = $row->name;


                }

                return $name;


            });


            $dt = $dt->editColumn('invoice', function ($row) {


                $invoice = Invoice::find($row->invoice_id);

                if (!empty($invoice)) {
                    $name = $invoice->reference_no;

                    return '<a href="#"   class="item" data-id = "' . $row->invoice_id . '" data-item = "' . $row->id . '" data-type="client_qty" data-toggle="modal" data-target="#viewModal">' . $name . '</a>';

                } else {

                    $name = '';

                    return $name;


                }




            });

            $dt = $dt->editColumn('qty', function ($row) {

                return number_format($row->total_qty, 2);
            });

            $dt = $dt->editColumn('cost', function ($row) {
                return number_format($row->total_cost, 2);
            });


            $dt = $dt->rawColumns(['invoice']);
            return $dt->make(true);
        }



        return view(
            'pos.report.client_report',
            compact('data', 'start_date', 'end_date')
        );

    }


    public function client_point_report(Request $request)
{
    // Get the authenticated user's added_by value
    $added_by = auth()->user()->added_by;

    // Get start_date and end_date from request
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    // Initialize report as empty array
    $report = [];

    // Only fetch data if both dates are provided (i.e., after search)
    if ($start_date && $end_date) {
        // Use provided dates or defaults if invalid
        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));

        // Get sales data from MasterHistory with filters, summing price in the date range
        $salesData = MasterHistory::where('type', 'Sales')
            ->where('added_by', $added_by)
            ->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->selectRaw('client_id, SUM(price) as total_amount')
            ->groupBy('client_id')
            ->orderBy('total_amount', 'desc')
            ->get();

        // Prepare the result array
        foreach ($salesData as $sale) {
            // Get client details from Client model
            $client = Client::where('id', $sale->client_id)->first();

            if ($client) {
                // Calculate points (total_amount divided by 1000)
                $points = floor($sale->total_amount / 1000);

                // Build the result array
                $report[] = [
                    'client_id' => $sale->client_id,
                    'client_name' => $client->name,
                    'total_amount' => $sale->total_amount,
                    'points' => $points,
                ];
            }
        }
    }

    // Set default dates for the form (pre-selected)
    $default_start_date = date('Y-m-d', strtotime('first day of january this year'));
    $default_end_date = date('Y-m-d');

    // Return the Blade view with the report data and dates
    return view('pos.report.client_point_report', compact('report', 'start_date', 'end_date', 'default_start_date', 'default_end_date'));
}






    public function report_by_date2(Request $request)
    {


        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();

        if (!empty($location[0])) {
            foreach ($location as $loc) {
                $x[] = $loc->id;

            }
        } else {
            $x[] = '';
        }

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $location_id = $request->location_id;

        $z[] = $location_id;

        $a = trim(json_encode($x), '[]');
        if ($location_id == $a) {
            $loc_id = $x;
        } else {

            $loc_id = $z;
        }



        $data = Items::select('*')->where('added_by', auth()->user()->added_by)->where('restaurant', 0)->where('disabled', 0)->where('type', '!=', 4);

        if ($request->ajax()) {

            $i = 0;

            $dt = Datatables::of($data);


            $i++;


            $dt = $dt->addColumn('a', function ($row) use ($start_date, $end_date, $loc_id, $location_id, &$bqty, &$pqty, &$sqty) {

                /*       
               //$bpqty= DB::table('pos_purchases_history')->where('item_id', $row->id)->where('type', 'Purchases')->whereIn('location',$loc_id)->where('purchase_date','<', $start_date)->sum(DB::raw('quantity'));  
               //$bdn= DB::table('pos_purchases_history')->where('item_id', $row->id)->where('type', 'Debit Note')->whereIn('location',$loc_id)->where('purchase_date','<', $start_date)->sum(DB::raw('quantity')); 
               $pqty=DB::table('pos_purchases_history')->where('item_id', $row->id)->where('type', 'Purchases')->whereIn('location',$loc_id)->whereBetween('purchase_date',[$start_date,$end_date])->sum(DB::raw('quantity'));   
               $dn= DB::table('pos_purchases_history')->where('item_id', $row->id)->where('type', 'Debit Note')->whereIn('location',$loc_id)->whereBetween('purchase_date',[$start_date,$end_date])->sum(DB::raw('quantity'));  
               $sqty= DB::table('pos_invoices_history')->where('item_id', $row->id)->where('type', 'Sales')->whereIn('location',$loc_id)->whereBetween('invoice_date',[$start_date,$end_date])->sum(DB::raw('quantity'));  
               $cn= DB::table('pos_invoices_history')->where('item_id', $row->id)->where('type', 'Credit Note')->whereIn('location',$loc_id)->whereBetween('invoice_date',[$start_date,$end_date])->sum(DB::raw('quantity')); 
               */

                $od = DB::select("SELECT (SELECT coalesce(SUM(quantity), 0)  FROM `pos_purchases_history` WHERE `item_id` = '" . $row->id . "' AND type='Purchases' AND purchase_date < '" . $start_date . "' AND location IN ($location_id)) - (SELECT coalesce(SUM(quantity), 0)  FROM `pos_purchases_history` WHERE `item_id` = '" . $row->id . "' AND type='Debit Note' AND purchase_date < '" . $start_date . "' AND location IN ($location_id)) AS bpd");
                $a = collect($od)->pluck('bpd')->toArray();
                $bqty = $a[0];
                //dd($bqty);

                $ppd = DB::select("SELECT (SELECT coalesce(SUM(quantity), 0)  FROM `pos_purchases_history` WHERE `item_id` = '" . $row->id . "' AND type='Purchases' AND purchase_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND location IN ($location_id)) - (SELECT coalesce(SUM(quantity), 0)  FROM `pos_purchases_history` WHERE `item_id` = '" . $row->id . "' AND type='Debit Note' AND purchase_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND location IN ($location_id)) AS pd");
                $b = collect($ppd)->pluck('pd')->toArray();
                $pqty = $b[0];

                $spd = DB::select("SELECT (SELECT coalesce(SUM(quantity), 0)  FROM `pos_invoices_history` WHERE `item_id` = '" . $row->id . "' AND type='Sales' AND invoice_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND location IN ($location_id)) - (SELECT coalesce(SUM(quantity), 0)  FROM `pos_invoices_history` WHERE `item_id` = '" . $row->id . "' AND type='Credit Note' AND invoice_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND location IN ($location_id)) AS sd");
                $c = collect($spd)->pluck('sd')->toArray();
                $sqty = $c[0];

            });







            $dt = $dt->editColumn('name', function ($row) {
                return $row->name;
            });
            $dt = $dt->editColumn('open', function ($row) use (&$bqty, &$pqty, &$sqty) {
                return '<a href="#"   class="item" data-id = "' . $row->id . '" data-type="open_qty" data-toggle="modal" data-target="#viewModal">' . number_format($bqty, 2) . '</a>';
            });
            $dt = $dt->editColumn('purchase', function ($row) use (&$bqty, &$pqty, &$sqty) {
                return '<a href="#" class="item"  data-id = "' . $row->id . '" data-type="pur_qty" data-toggle="modal" data-target="#viewModal">' . number_format($pqty, 2) . '</a>';
            });

            $dt = $dt->editColumn('sales', function ($row) use (&$bqty, &$pqty, &$sqty) {

                return '<a href="#" class="item"  data-id = "' . $row->id . '" data-type="sales_qty" data-toggle="modal" data-target="#viewModal">' . number_format($sqty, 2) . '</a>';

            });
            $dt = $dt->editColumn('close', function ($row) use (&$bqty, &$pqty, &$sqty) {
                return number_format(($bqty + $pqty) - $sqty, 2);
            });

            $dt = $dt->rawColumns(['open', 'purchase', 'sales']);
            return $dt->make(true);
        }




        return view(
            'pos.report.report_by_date',
            compact('data', 'start_date', 'end_date', 'location', 'x', 'z', 'location_id')
        );

    }


    public function discountModal(Request $request)
    {

        $id = $request->id;
        $type = $request->type;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $location_id = $request->loc_id;
        $added_by = auth()->user()->added_by;

        $location = Client::where('owner_id', auth()->user()->added_by)->where('disabled', '0')->get();

        if (!empty($location[0])) {
            foreach ($location as $loc) {
                $x[] = $loc->id;

            }
        } else {
            $x[] = '';
        }


        $z[] = $location_id;

        $a = trim(json_encode($x), '[]');
        if ($location_id == $a) {
            $loc_id = $x;
        } else {

            $loc_id = $z;
        }

        //dd($type);
        switch ($type) {
            case 'open_qty':
                $key = Items::find($id);


                return view('pos.report.modal.open_qty', compact('id', 'start_date', 'end_date', 'loc_id', 'key'));
                break;
            case 'pur_qty':
                $key = Items::find($id);
                return view('pos.report.modal.pur_qty', compact('id', 'start_date', 'end_date', 'loc_id', 'key'));
                break;
            case 'sales_qty':
                $key = Items::find($id);
                return view('pos.report.modal.sales_qty', compact('id', 'start_date', 'end_date', 'loc_id', 'key'));
                break;

            case 'cost_qty':
                $key = Items::find($id);
                return view('pos.report.modal.cost_qty', compact('id', 'start_date', 'end_date', 'loc_id', 'key'));
                break;


            case 'open_in_qty':
                $key = Items::find($id);
                $rowDatampya = "SELECT *  FROM `pos_master_history` WHERE location IN ($location_id) AND date < '" . $start_date . "' AND pos_master_history.added_by = '" . $added_by . "' AND  pos_master_history.item_id ='" . $id . "' ORDER BY date DESC ";
                $account = DB::select($rowDatampya);

                return view('pos.report.modal.open_in_qty', compact('id', 'start_date', 'end_date', 'loc_id', 'key', 'account'));
                break;

            case 'in_qty':
                $key = Items::find($id);
                $rowDatampya = "SELECT *  FROM `pos_master_history` WHERE location IN ($location_id) AND date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND added_by = '" . $added_by . "' AND item_id ='" . $id . "'  AND `in` > 0 ORDER BY date DESC ";
                $account = DB::select($rowDatampya);
                return view('pos.report.modal.in_qty', compact('id', 'start_date', 'end_date', 'loc_id', 'key', 'account'));
                break;
            case 'out_qty':
                $key = Items::find($id);
                $rowDatampya = "SELECT *  FROM `pos_master_history` WHERE location IN ($location_id) AND date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND added_by = '" . $added_by . "' AND item_id ='" . $id . "'  AND `out` > 0 ORDER BY date DESC ";
                $account = DB::select($rowDatampya);
                return view('pos.report.modal.out_qty', compact('id', 'start_date', 'end_date', 'loc_id', 'key', 'account'));
                break;
            case 'issue_qty':
                $key = Items::find($id);
                $rowDatampya = "SELECT *  FROM `pos_master_history` WHERE location IN ($location_id) AND date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND added_by = '" . $added_by . "' AND item_id ='" . $id . "'   AND type = 'Good Issue' ORDER BY date DESC ";
                $account = DB::select($rowDatampya);
                return view('pos.report.modal.issue_qty', compact('id', 'start_date', 'end_date', 'loc_id', 'key', 'account'));
                break;
            case 'return_qty':
                $key = Items::find($id);
                $rowDatampya = "SELECT *  FROM `pos_master_history` WHERE location IN ($location_id) AND date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND added_by = '" . $added_by . "' AND item_id ='" . $id . "'   AND type = 'Returned Good Issue' ORDER BY date DESC ";
                $account = DB::select($rowDatampya);
                return view('pos.report.modal.return_issue_qty', compact('id', 'start_date', 'end_date', 'loc_id', 'key', 'account'));
                break;
            case 'movement_qty':
                $key = Items::find($id);
                return view('pos.report.modal.movement_qty', compact('id', 'start_date', 'end_date', 'loc_id', 'key'));
                break;
            case 'disposal_qty':
                $key = Items::find($id);
                return view('pos.report.modal.disposal_qty', compact('id', 'start_date', 'end_date', 'loc_id', 'key'));
                break;

            case 'service_qty':
                $key = Items::find($id);
                return view('pos.report.modal.service_qty', compact('id', 'start_date', 'end_date', 'loc_id', 'key'));
                break;
            case 'client_qty':
                $key = Items::find($request->item);
                return view('pos.report.modal.client_qty', compact('id', 'start_date', 'end_date', 'key'));
                break;


            default:
                break;

        }

    }



    public function purchase_report(Request $request)
    {

        $data = Items::where('added_by', auth()->user()->added_by)->where('bar', 0)->where('disabled', 0)->get();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        return view(
            'pos.report.purchase_report',
            compact('data', 'start_date', 'end_date')
        );

    }


}