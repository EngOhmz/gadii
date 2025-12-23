<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Supplier;
use App\Models\POS\Activity;
//use App\Models\FarmLand;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use App\Imports\ImportSupplier ;
use Response;
use App\Models\POS\Purchase;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\MasterHistory;
use App\Models\POS\ReturnPurchases;
use App\Models\POS\PurchasePayments;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Expenses;
use Session;
use DB;

class SupplierController extends Controller
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
    
    public function index()
    {
        
        $supply=Supplier::where('user_id',auth()->user()->added_by)->where('disabled','0')->get();
        return view('supplier.manage-supplier')->with("supply",$supply);
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
        // $data= new Supply();
        $this->validate($request,[
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
            
        ]); 
        
           
        $data=$request->all();
        $data['user_id']=auth()->user()->added_by;
        $result=Supplier::create($data);

if(!empty($result)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                            'user_id'=>auth()->user()->id,
                            'module_id'=>$result->id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $result->name. "  Created",
                        ]
                        );                      
       }
       return redirect(route('supplier.index'))->with(['success'=>'Supplier Created Successfully']);
     
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
        
         $data = Supplier::find($id);

        $type = Session::get('type');
            if(empty($type))
             $type='details';
             
    $purchase = Purchase::where('added_by',auth()->user()->added_by)->where('supplier_id',$id)->get();;
    $debit = ReturnPurchases::where('added_by',auth()->user()->added_by)->where('supplier_id',$id)->get();;
    $grn = PurchaseHistory::where('added_by',auth()->user()->added_by)->where('supplier_id',$id)->where('type','Purchases')->orderBy('purchase_date','desc')->get();;
    $payment = PurchasePayments::leftJoin('pos_purchases', 'pos_purchases.id', 'pos_purchase_payments.purchase_id')
            ->where('pos_purchases.supplier_id', $id)
            ->where('pos_purchase_payments.added_by', auth()->user()->added_by)
            ->select('pos_purchase_payments.*','pos_purchases.exchange_code')
            ->get();
    
    
   $dn=AccountCodes::where('account_name','Debit Note Control')->where('added_by',auth()->user()->added_by)->first();
        if(!empty($dn)){
        
         $added_by = auth()->user()->added_by;
        
        $a = "SELECT pos_purchases.exchange_code,pos_purchases.exchange_rate,pos_return_purchases.reference_no,pos_return_purchases.return_date,journal_entries.credit,pos_return_purchases.bank_id,journal_entries.id FROM pos_return_purchases INNER JOIN journal_entries ON pos_return_purchases.id=journal_entries.income_id 
        INNER JOIN pos_purchases ON pos_return_purchases.purchase_id = pos_purchases.id WHERE pos_return_purchases.added_by = '".$added_by."' AND pos_purchases.supplier_id = '".$id."' AND journal_entries.account_id = '".$dn->id."' AND journal_entries.transaction_type = 'pos_debit_note' ";
        
        $deposits = DB::select($a);
        }
        
        else{
            $deposits=[];
        }
        
    $expense = Expenses::where('multiple','1')->where('added_by',auth()->user()->added_by)->where('supplier_id',$id)->get();;
    $journal = JournalEntry::where('added_by',auth()->user()->added_by)->where('supplier_id',$id)->whereNotIn('transaction_type', ['pos_debit_note','pos_purchase','pos_purchase_payment','expense_payment'])->get();;
                
    $purcount=Purchase::where('added_by',auth()->user()->added_by)->where('supplier_id',$id)->count();                
    $dncount=ReturnPurchases::where('added_by',auth()->user()->added_by)->where('supplier_id',$id)->count();   
    $grncount=PurchaseHistory::where('added_by',auth()->user()->added_by)->where('supplier_id',$id)->where('type','Purchases')->count();    
    $paycount=PurchasePayments::leftJoin('pos_purchases', 'pos_purchases.id', 'pos_purchase_payments.purchase_id')
            ->where('pos_purchases.supplier_id', $id)
            ->where('pos_purchase_payments.added_by', auth()->user()->added_by)
            ->select('pos_purchase_payments.*','pos_purchases.exchange_code')->count();   
    $expcount = Expenses::where('multiple','1')->where('added_by',auth()->user()->added_by)->where('supplier_id',$id)->count();  
    $jcount = JournalEntry::where('added_by',auth()->user()->added_by)->where('supplier_id',$id)->whereNotIn('transaction_type', ['pos_debit_note','pos_purchase','pos_purchase_payment','expense_payment'])->count();;
   $depcount=count( $deposits);
      return view('supplier.supplier_details',compact
                  ('data','id','type','purchase','debit','grn','payment','deposits','expense','journal',
                    'purcount', 'dncount','grncount', 'paycount','depcount', 'expcount','jcount'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
 $data=Supplier::find($id);
 return view('supplier.manage-supplier',compact('data','id'));
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
        
        $this->validate($request,[
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
           
        ]); 
        
        $data=Supplier::find($id);
        $result=$request->all();
        $data->update($result);

 if(!empty($data)){
                    $activity =Activity::create(
                        [ 
                           'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $request->name. "  Updated",
                        ]
                        );                      
       }
        return redirect(route('supplier.index'))->with(['success'=>'Supplier Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=Supplier::find($id);
        $data->update(['disabled'=> '1']);

 if(!empty($data)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                          'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $data->name. "  Deleted",
                        ]
                        );                      
       }

         return redirect(route('supplier.index'))->with(['success'=>'Supplier Deleted Successfully']);
    }
    
     public function import(Request $request){
      
        
        $data = Excel::import(new ImportSupplier, $request->file('file')->store('files'));
        
        return redirect()->back()->with('success', 'File Imported Successfully');
    }
    
     public function sample(Request $request){

       $filepath = public_path('supplier_sample.xlsx');
       return Response::download($filepath);
    }
}
