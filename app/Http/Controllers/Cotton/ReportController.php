<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\Cotton\CollectionCenter;
use App\Models\Cotton\Operator;
use App\Models\Insurance;
use App\Models\User;
use App\Models\Farmer_account;
use App\Models\Deposite_withdraw;
use App\Models\Crops_type;
use App\Models\Group;
use App\Models\ChartOfAccount;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\Cotton\CottonMovement;
use App\Models\Cotton\CottonItemMovement;
use App\Models\Cotton\CottonLevyMovement; ;;
use App\Models\Cotton\CottonHistory;
use App\Models\Cotton\TopUpCenter;
use App\Models\Cotton\ReverseTopUpCenter;

use App\Models\JournalEntry;
use App\Models\Cotton\PurchaseCotton;
use App\Models\Cotton\InvoiceCotton;
use App\Models\Cotton\InvoiceSeed;
use App\Models\Cotton\CottonClient;
use App\Models\Region;
use App\Models\District;
use App\Models\Ward;
use App\Models\Cotton\Levy;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id=auth()->user()->id;
        $warehouse =CollectionCenter::all();
        $user=User::all();
        $insurance=Insurance::all();
         $operator=Operator::all();
        $group=USer::find($user_id)->group;
         $region=Region::all();
        return view('cotton.center',compact('insurance','warehouse','user','operator','region'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
             $data=$request->post();
      $data['added_by']=auth()->user()->id;
      $collection= CollectionCenter::create($data);


       

      return redirect(route('collection_center.index'))->with(['success'=>' Created Successfully']);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id ,Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        
        $all_data=[];
        $singel_row_datas=[];
        foreach ($data=CollectionCenter::where('district_id', $id)->get() as $key) {
        $singel_row_datas['name']= $key->name;
        $singel_row_datas['debit']= TopUpCenter::where('to_account_id', $key->id)->whereBetween('date',[$start_date, $end_date])->sum('amount');
        $singel_row_datas['credit'] = ReverseTopUpCenter::where('to_account_id', $key->id)->whereBetween('date',[$start_date, $end_date])->sum('amount');
         $singel_row_datas['kg_received'] = CottonMovement::where('source_location', $key->id)->whereBetween('date',[$start_date, $end_date])->sum('quantity') ;
        $singel_row_datas['stock_kijijini'] = PurchaseCotton::where('location', $key->id)->whereBetween('purchase_date',[$start_date, $end_date])->sum('quantity') - $singel_row_datas['kg_received'];
         $singel_row_datas['value_kg_received'] = CottonMovement::where('source_location', $key->id)->whereBetween('date',[$start_date, $end_date])->sum('amount');
        $singel_row_datas['value_of_stock_kijijini'] = PurchaseCotton::where('location', $key->id)->whereBetween('purchase_date',[$start_date, $end_date])->sum('purchase_amount') - $singel_row_datas['value_kg_received'];
       
       
        array_push($all_data,$singel_row_datas);
        }
       return response()->json(["all_data"=>$all_data]);
  
    }


                        

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
       $user_id=auth()->user()->id;
        $data =CollectionCenter::find($id);
        $user=User::all();
        $insurance=Insurance::all();
         $operator=Operator::all();
        $group=USer::find($user_id)->group;
         $region=Region::all();
        $district= District::where('region_id', $data->region_id)->get();  
      $ward= Ward::where('district_id', $data->district_id)->get();
        return view('cotton.center',compact('insurance','data','user','operator','region','district','ward','id'));
        
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
           $collection= CollectionCenter::find($id);
       $data=$request->post();
       $data['added_by']=auth()->user()->id;
       $collection->update($data);

      
       return redirect(route('collection_center.index'))->with(['success'=>' Updated Successfully']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AccountCodes::where('collection_id', $id)->delete();
       ChartOfAccount::where('collection_id', $id)->delete();
        $purchases = CollectionCenter::find($id);
        $purchases->delete();
        return redirect(route('collection_center.index'))->with(['success'=>'Deleted Successfully']);
    }

public function findRegion(Request $request)
    {

        $district= District::where('region_id',$request->id)->get();                                                                                    
               return response()->json($district);

}

public function findDistrict(Request $request)
    {

        $ward= Ward::where('district_id',$request->id)->get();                                                                                    
               return response()->json($ward);

}

public function discountModal(Request $request)
   {
                $id=$request->id;
                $type = $request->type;
                if($type == 'operator'){
               return view('cotton.addOperator');
               
                }elseif($type == 'licence'){
                return view('cotton.addLicence');   
                }
                      elseif($type=='quantity'){
       $movement= CottonHistory::where('location',$id)->get();
               return view('cotton.center_quantity',compact('id','movement'));
}
  elseif($type=='head'){
       $main= CottonHistory::all();
               return view('cotton.head_quantity',compact('id','main'));
}
else{
               
                 $old = Pacel::find($id);
                return view('pacel.addLoading',compact('id','old'));
               
                }
                
 

       
   }

   public function addOperator(Request $request){
       
    
          
           $operator= Operator::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'TIN' => $request['TIN'],
         'account_codes' =>$request['account_codes'],
            'user_id'=> auth()->user()->id,
        ]);

         $account_codes = new AccountCodes();
        $account_codes->account_codes = $request['account_codes'];
       $account_codes->account_name = $request['name'] ;
        $account_codes->account_group  = 'Operator'  ;
        $account_codes->account_status  = 'Active'  ;
        $account_codes->operator_id = $operator->id ;

              $group_type=GroupAccount::where('name', 'Operator')->get();
              foreach($group_type as $group){                        
                        $account_codes->account_type= $group->type;
            }
        
           
            $account_codes->save();

            AccountCodes::where('id',$account_codes->id)->update(['account_id' => $account_codes->id]);

              $chart_of_account = new ChartOfAccount();
              $chart_of_account->id =  $account_codes->id;
             $chart_of_account->account_codes = $request['account_codes'];
            $chart_of_account->account_name = $request['name'] ;
               $chart_of_account->name = $request->name ;
                $chart_of_account->gl_code = $request['account_codes'];;
           $chart_of_account->account_type =     $account_codes->account_type ;
              $chart_of_account->active = 'Active'  ;
             $chart_of_account->operator_id = $operator->id ;
            $chart_of_account->save();

        
        
      

        if (!empty($operator)) {           
            return response()->json($operator);
         }

       
   }

   public function addLicence(Request $request){
       
       
      //
     $insurance= new Insurance();

        $insurance->insurance_name=$request->input('insurancename');
        $insurance->insurance_amount=$request->input('insuranceamount');
        $insurance->asset_value=$request->input('assetvalue');
        $insurance->insurance_type=$request->input('insurancetype');
        $insurance->cover_age=$request->input('coveringage');
        $insurance->start_date=$request->input('startdate');
        $insurance->end_date=$request->input('enddate');
        $insurance->save();
      
    

      if (!empty($insurance)) {           
          return response()->json($insurance);
       }

     
 }

 public function stock_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (CollectionCenter::where('head','0')->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        if($request->isMethod('post')){
            $data=PurchaseCotton::where('location', $request->account_id)->whereBetween('purchase_date',[$start_date,$end_date])->get();
        }else{
            $data=[];
        }

       

        return view('cotton.stock_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }


 public function center_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (CollectionCenter::where('head','0')->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        if($request->isMethod('post')){
            $data=JournalEntry::where('center_id', $request->account_id)->whereBetween('date',[$start_date,$end_date])->get();
        }else{
            $data=[];
        }

       

        return view('cotton.center_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }
    
     public function general_report(Request $request)
    {
       $district=District::all();
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (CollectionCenter::where('head','0')->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        if($request->isMethod('post')){
            //$data=JournalEntry::where('center_id', $request->account_id)->whereBetween('date',[$start_date,$end_date])->get();
            $data=CollectionCenter::where('district_id', $request->district_id)->get();
            //$data=CollectionCenter::all();
        }else{
            $data=[];
        }

       

        return view('cotton.general_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id','district'));
    }
    
         public function general_report2(Request $request)
    {
       $district=District::all();
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (CollectionCenter::where('head','0')->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        if($request->isMethod('post')){
            //$data=JournalEntry::where('center_id', $request->account_id)->whereBetween('date',[$start_date,$end_date])->get();
            //$data=CollectionCenter::where('district_id', $request->district_id)->get();
            //$data=CollectionCenter::all();
        }else{
            $data=[];
        }

       

        return view('cotton.general_report2',
            compact('start_date',
                'end_date','chart_of_accounts','account_id','district'));
    }

public function levy_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (Levy::all() as $key) {
            $chart_of_accounts[$key->account_id] = $key->name;
        }
        if($request->isMethod('post')){
            $data=JournalEntry::where('account_id', $request->account_id)->whereBetween('date',[$start_date,$end_date])->get();
        }else{
            $data=[];
        }

       

        return view('cotton.levy_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }
    
public function debtors_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (AccountCodes::where('account_group','LIKE','%Sundry Debtors%')->get() as $key) {
            $chart_of_accounts[$key->id] = $key->account_name;
        }
        if($request->isMethod('post')){
            $cotton=InvoiceCotton::where('supplier_id', $request->account_id)->whereBetween('purchase_date',[$start_date,$end_date]);
            $data=InvoiceSeed::where('supplier_id', $request->account_id)->whereBetween('purchase_date',[$start_date,$end_date])->union($cotton)->get();
        }else{
            $data=[];
        }

       

        return view('cotton.debtors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }


}