<?php

namespace App\Http\Controllers\Bar\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Bar\POS\InvoicePayments;
use App\Models\Bar\POS\InvoiceHistory;
use App\Models\Bar\POS\PurchaseHistory;
use App\Models\Bar\POS\Items;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
//use App\Models\invoice_items;
use App\Models\Client;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\Bar\POS\Invoice;
use App\Models\Bar\POS\InvoiceItems;
use App\Models\Bar\POS\Activity;
use App\Models\User;
use PDF;


use Illuminate\Http\Request;

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

    
public function purchase_report(Request $request)
    {
       
$data=Items::where('added_by',auth()->user()->added_by)->get();
     

        return view('bar.pos.report.purchase_report',
            compact('data'));
    
    }

public function sales_report(Request $request)
    {
       
$data=Items::where('added_by',auth()->user()->added_by)->get();
     

        return view('bar.pos.report.sales_report',
            compact('data'));
    
    }
public function balance_report(Request $request)
    {
       
$data=Items::where('added_by',auth()->user()->added_by)->get();
     

        return view('bar.pos.report.balance_report',
            compact('data'));
    
    }

    public function crate_report(Request $request)
    {
       
$data=Items::where('added_by',auth()->user()->added_by)->get();
     

        return view('bar.pos.report.crate_report',
            compact('data'));
    
    }


    public function bottle_report(Request $request)
    {
       
$data=Items::where('added_by',auth()->user()->added_by)->get();
     

        return view('bar.pos.report.bottle_report',
            compact('data'));
    
    }

public function summary(Request $request)
    {
        //

    $all_employee=User::where('added_by',auth()->user()->added_by)->get();

 $search_type = $request->search_type;
 $check_existing_payment='';
$start_date='';
$end_date='';
$by_month='';
$user_id='';
$flag = $request->flag;

 

if (!empty($flag)) {
            if ($search_type == 'employee') {
             $user_id = $request->user_id;
             $check_existing_payment =Activity::where('user_id', $user_id)->get();
            }
          
            else if ($search_type == 'period') {
              $start_date = $request->start_date;
              $end_date= $request->end_date;
             $check_existing_payment = Activity::all()->where('added_by',auth()->user()->added_by)->whereBetween('date',[$start_date,$end_date]);
            }
           elseif ($search_type == 'activities') {
             $check_existing_payment =Activity::where('added_by',auth()->user()->added_by)->get();
            }
}
else{
 $check_existing_payment='';
$start_month='';
$end_month='';
$search_type='';
$by_month='';
$user_id='';
        }

 

 return view('bar.pos.report.activity',compact('all_employee','check_existing_payment','start_date','end_date','search_type','user_id','flag'));
    }

}
