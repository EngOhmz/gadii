<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\POS\Activity;
use App\Models\POS\InvoicePayments;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\SerialList;
use App\Models\POS\GoodIssue;
use App\Models\POS\GoodIssueItem;
use App\Models\POS\StockMovement;
use App\Models\POS\StockMovementItem;
use App\Models\POS\GoodDisposal;
use App\Models\POS\GoodDisposalItem;
use App\Models\POS\Items;
use App\Models\JournalEntry;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
use App\Models\POS\Category;
//use App\Models\invoice_items;
use App\Models\Client;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\Branch;
use App\Models\User;
use PDF;


use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $category=Category::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
       return view('pos.purchases.category',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data['name']=$request->name;
        $data['description']=$request->description;
          
       $data['user_id']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $invoice = Category::create($data);
   
        return redirect(route('category.index'))->with(['success'=>'Created Successfully']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cateory = Category::find($id);;
        
        return view('pos.sales.invoice_details',compact('cateory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $data=Category::find($id);
       $category=Category::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
       return view('pos.purchases.category',compact('category','data','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $invoice=Category::find($id);
        
       $data['name']=$request->name;
        $data['description']=$request->description;
          
    //   $data['user_id']= auth()->user()->id;
    //     $data['added_by']= auth()->user()->added_by;
    
            $invoice->update($data);
        



        return redirect(route('category.index'))->with(['success'=>'Updated Successfully']);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
        $item = Category::find($id);

        $item->update(['disabled'=> '1']);
        
         return redirect(route('category.index'))->with(['success'=>'Deleted Successfully']);

    }

    public function findPrice(Request $request)
    {
               $price= Items::where('id',$request->id)->get();
                return response()->json($price);                      

    }
    
public function findQuantity(Request $request)
   {

  $item=$request->item;
 $location=$request->location;
 $date = today()->format('Y-m');

 $item_info=Items::where('id', $item)->first();  
 $location_info=Location::find($request->location);
 if ($item_info->type == '4') {
 $price='' ;
 }
 else{
  if ($item_info->quantity > 0) {

 $a=SerialList::where('brand_id',$item)->where('location',$location)->where('added_by',auth()->user()->added_by)->where('status',0)->whereNull('expire_date')->sum('due_quantity');  
 $b=SerialList::where('brand_id',$item)->where('location',$location)->where('added_by',auth()->user()->added_by)->where('status',0)->whereNotNull('expire_date')->where('expire_date', '>=', $date)->sum('due_quantity'); 


 $quantity=$a + $b;

  if ($quantity > 0) {

 if($request->id >  $quantity){
 $price="You have exceeded your Stock. Choose quantity between 1.00 and ".  number_format($quantity,2) ;
 }
 else if($request->id <=  0){
 $price="Choose quantity between 1.00 and ".  number_format($quantity,2) ;
 }

 else{
 $price='' ;
  }

 }

 else{
 $price=$location_info->name . " Stock Balance  is Zero." ;

 }



 }



 else{
 $price="Your Stock Balance is Zero." ;

 }

 
 }               

 return response()->json($price);                      
 
     }
     
     
     
     


   public function discountModal(Request $request)
    {

          $id=$request->id;
                 $type = $request->type;

          switch ($type) {      
     case 'client':
            return view('pos.sales.client_modal');
                    break;

 default:
             break;

            }

                       }

         

public function save_client(Request $request){
       
      //dd($request->all());

       $data = $request->all();   
    $data['user_id'] = auth()->user()->id;
$data['owner_id'] = auth()->user()->added_by;
        $client = Client::create($data);
        
      

  if(!empty($client)){
              $activity =Activity::create(
                  [ 
                       'added_by'=>auth()->user()->added_by,
                        'user_id'=>auth()->user()->id,
                      'module_id'=>$client->id,
                       'module'=>'Client',
                      'activity'=>"Client " .  $client->name. "  Created",
                  ]
                  );
    
            return response()->json($client);
         }

       
   }

    public function approve($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 1;
        $invoice->update($data);

     if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Approved",
                        ]
                        );                      
       }
        return redirect(route('invoice.index'))->with(['success'=>'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 4;
        $invoice->update($data);
       if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            
                            'module_id'=>$id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Cancelled",
                        ]
                        ); 
}
        return redirect(route('invoice.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
        $client=Client::where('user_id',auth()->user()->added_by)->get(); 
        $name =Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->get();   
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get(); 
        $data=Invoice::find($id);
        $items=InvoiceItems::where('invoice_id',$id)->get();
    //$location=Location::where('added_by',auth()->user()->added_by)->get();;
         $location=LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $type="receive";
       return view('pos.sales.invoice',compact('name','client','currency','data','id','items','type','bank_accounts','location'));
    }

 
    public function make_payment($id)
    {
        //
        $invoice = Invoice::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get();;
        return view('pos.sales.invoice_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function invoice_pdfview(Request $request)
    {
        //
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('pos.sales.invoice_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('SALES INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('inv_pdfview');
    }

public function debtors_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
       $account_id=$request->account_id;
        $currency=$request->currency;
        $chart_of_accounts = [];
         $accounts = [];

        foreach (Client::where('owner_id',auth()->user()->added_by)->where('disabled',0)->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
         foreach (Currency::all() as $key) {
            $accounts[$key->code] = $key->name;
        }
        if($request->isMethod('post')){
         $data=Invoice::where('client_id', $request->account_id)->where('exchange_code', $request->currency)->whereBetween('invoice_date',[$start_date,$end_date])->where('status','!=',0)->where('added_by',auth()->user()->added_by)->get();
        }else{
            $data=[];
        }

       

        return view('pos.sales.debtors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id','currency','accounts'));
    }

public function debtors_summary_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $currency=$request->currency;
         $accounts = [];

     foreach (Currency::all() as $key) {
            $accounts[$key->code] = $key->name;
        }
        if($request->isMethod('post')){
       $data= Invoice::where('exchange_code', $request->currency)->whereBetween('invoice_date',[$start_date,$end_date])->where('status','!=',0)->where('added_by',auth()->user()->added_by)->groupBy('client_id')->get();
        }else{
            $data=[];
        }

       

        return view('pos.sales.debtors_summary_report',
            compact('start_date',
                'end_date','data','currency','accounts'));
    }



public function findQuantity2(Request $request)
   {

  $item=$request->item;
 $location=$request->location;
 $date = today()->format('Y-m');

 $item_info=Items::where('id', $item)->first();  
 $location_info=Location::find($request->location);
 if ($item_info->type == '4') {
 $price='' ;
 }
 else{
  if ($item_info->quantity > 0) {

 $pqty= PurchaseHistory::where('item_id', $item)->where('location',$location)->where('type', 'Purchases')->where('added_by',auth()->user()->added_by)->sum('quantity'); 
 $dn= PurchaseHistory::where('item_id', $item)->where('location',$location)->where('type', 'Debit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');  
 $dgood=StockMovementItem::where('item_id',$item)->where('destination_store',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');

$sgood=StockMovementItem::where('item_id',$item)->where('source_store',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');
 $issue=GoodIssueItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');
 $sqty= InvoiceHistory::where('item_id', $item)->where('location',$location)->where('type', 'Sales')->where('added_by',auth()->user()->added_by)->sum('quantity'); 
  $cn= InvoiceHistory::where('item_id', $item)->where('location',$location)->where('type', 'Credit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');  
   $disposal=GoodDisposalItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');

 $qty=$pqty-$dn;
 $inv=$sqty-$cn ;

 //$quantity=($pqty-$dn)-($sqty-$cn);

 $quantity=($qty + $dgood) - ($issue +$inv + $sgood + $disposal);;

  if ($quantity > 0) {

 if($request->id >  $quantity){
 $price="You have exceeded your Stock. Choose quantity between 1.00 and ".  number_format($quantity,2) ;
 }
 else if($request->id <=  0){
 $price="Choose quantity between 1.00 and ".  number_format($quantity,2) ;
 }

 else{
 $price='' ;
  }

 }

 else{
 $price=$location_info->name . " Stock Balance  is Zero." ;

 }



 }



 else{
 $price="Your Stock Balance is Zero." ;

 }

 
 }               

 return response()->json($price);                      
 
     }


}
