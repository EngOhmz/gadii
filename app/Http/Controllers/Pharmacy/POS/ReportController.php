<?php

namespace App\Http\Controllers\Pharmacy\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Pharmacy\Items;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
//use App\Models\invoice_items;
use App\Models\Client;
use App\Models\ServiceType;
use App\Models\Pharmacy\InventoryList;
use App\Models\Pharmacy\InvoiceSerialPayments;
use App\Models\Pharmacy\InvoiceSerialHistory;
use App\Models\Pharmacy\InvoiceSerial;
use App\Models\Pharmacy\InvoiceSerialItems;
use App\Models\Pharmacy\PurchaseHistory;
use App\Models\Pharmacy\PurchaseSerialList;
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
     

        return view('pharmacy.pos.report.purchase_report',
            compact('data'));
    
    }

public function sales_report(Request $request)
    {
       
$data=$data=Items::where('category','Batch')->get();
     

        return view('pharmacy.pos.report.sales_report',
            compact('data'));
    
    }
public function balance_report(Request $request)
    {
       
$data=Items::where('category','Batch')->get();
     

        return view('pharmacy.pos.report.balance_report',
            compact('data'));
    
    }


 

}
