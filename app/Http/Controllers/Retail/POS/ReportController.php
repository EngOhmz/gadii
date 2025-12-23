<?php

namespace App\Http\Controllers\Retail\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Retail\Items;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
//use App\Models\invoice_items;
use App\Models\Client;
use App\Models\ServiceType;
use App\Models\Retail\InventoryList;
use App\Models\Retail\InvoiceSerialPayments;
use App\Models\Retail\InvoiceSerialHistory;
use App\Models\Retail\InvoiceSerial;
use App\Models\Retail\InvoiceSerialItems;
use App\Models\Retail\PurchaseHistory;
use App\Models\Retail\PurchaseSerialList;
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
       
$data=Items::where('category','Batch')->get();
     

        return view('retail.pos.report.purchase_report',
            compact('data'));
    
    }

public function sales_report(Request $request)
    {
       
$data=$data=Items::where('category','Batch')->get();
     

        return view('retail.pos.report.sales_report',
            compact('data'));
    
    }
public function balance_report(Request $request)
    {
       
$data=Items::where('category','Batch')->get();
     

        return view('retail.pos.report.balance_report',
            compact('data'));
    
    }


 

}
