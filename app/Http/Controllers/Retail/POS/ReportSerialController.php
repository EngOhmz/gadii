<?php

namespace App\Http\Controllers\Retail\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\POS\Items;
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

class ReportSerialController extends Controller
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
       
$data=PurchaseSerialList::all();
     

        return view('retail.pos.serial_report.purchase_report',
            compact('data'));
    
    }

public function sales_report(Request $request)
    {
       
$data=PurchaseSerialList::where('status','1')->get();
     

        return view('retail.pos.serial_report.sales_report',
            compact('data'));
    
    }
public function balance_report(Request $request)
    {
       
$data=PurchaseSerialList::all();
     

        return view('retail.pos.serial_report.balance_report',
            compact('data'));
    
    }
public function discountModal(Request $request)
    {
               
              $id=$request->id;
                 $type = $request->type;
                   $data=PurchaseSerialList::find($request->id);
                    return view('retail.pos.serial_report.addwarrant',compact('id','data','type'));
     
                 }

 public function save_warrant (Request $request){
                     //
                     $inv=   PurchaseSerialList::find($request->id);
                      if($request->type == 'purchase'){                     
                     $data['purchase_warrant']=$request->warrant;
                     $inv->update($data);
                     return redirect(route('serial.purchase'))->with(['success'=>'Purchase Warrant Saved Successfully']);
                    }

                else if($request->type == 'sales'){                     
                     $data['sales_warrant']=$request->warrant;
                     $inv->update($data);
                     return redirect(route('serial.sales'))->with(['success'=>'Sales Warrant Saved Successfully']);
                    }

                 }

}
