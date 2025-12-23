<?php


namespace App\Http\Controllers\CargoAgency;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CargoAgency\Customer\Customer;
use App\Models\CargoAgency\Pacel\TempolaryPacel;

use App\Models\CargoAgency\Customer\CustomerPacel;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;
use App\Models\CargoAgency\PacelHistory;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    
    public function index() {
        if(Session::get('customer_ID')){

            $customer_ID = Session::get('customer_ID');
            $word_print = 'right';
            $client =Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get(); 
             return view('cargo_agency.dashboard.dashboard2', compact('word_print', 'customer_ID','client'));

        }
        else{

            $word_print = 'wrong';
            if(Session::get('mzigo_ID')){

                $mzigo_ID = Session::get('mzigo_ID');
                $client =Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get(); 
                return view('cargo_agency.dashboard.dashboard2',compact('word_print', 'mzigo_ID','client'));

            }
            else{
                $client =Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get(); 
                return view('cargo_agency.dashboard.dashboard2',compact('word_print','client'));

            }

        }
    }

    public function temp_pacel_delete($id){

        $temp_pacel = TempolaryPacel::find(intval($id));


        $data22 = $temp_pacel->delete();

            // dd($data22);

        return redirect()->route('dashboard.index')->with('success', 'Delete Successfully');
    }

    public function store(Request $request){

        $validated = Validator::make($request->all(), [
            'name' => 'required',
        ],
            [
                'name.required' => 'Add at least one mzigo'
            ]);

        if ($validated->fails()) {
            return redirect('staffs/dashboard')
                        ->withErrors($validated)
                        ->withInput();
        }

        $data['mteja'] =$request->mteja;
        $data['mpokeaji'] =$request->mpokeaji;
        $data['added_by'] = auth()->user()->id;
        $customer = Customer::create($data);

        $customer_ID = $customer->id;

        $mteja =$customer->mteja;

        // dd($mteja);
        $mpokeaji =$customer->mpokeaji;
        $activity = "kusajiliwa";
        // $hashtag = "";

        $nameArr =$request->name;
        $idadi =$request->quantity;
        $bei =$request->price;
        $receipt = $request->receipt;

        $mzigo_unapotokaArr = $request->from;
        $mzigo_unapokwendaArr = $request->to;
        $jumlaArr = $request->total_cost ;
        $ela_iliyopokelewaArr = $request->ela_iliyopokelewa;

        $subArr = str_replace(",","",$request->subtotal);
       
;

                    // $cost['total_mizigo'] = 0;
                    // $cost['total_amount'] = 0;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){

                if(!empty($nameArr[$i])){

                    // $cost['total_amount'] = $subArr[$i];


                    if(!is_null($idadi[$i])){
                        $idadiT = $idadi[$i];
                    }
                    else{
                        $idadiT = 1;
                
                    }
                    if(!is_null($mzigo_unapotokaArr[$i])){
                        $mzigo_unapotokaT = $mzigo_unapotokaArr[$i];
                    }
                    else{
                        $mzigo_unapotokaT = "#";
                
                    }
                    if(!is_null($mzigo_unapokwendaArr[$i])){
                        $mzigo_unapokwendaT = $mzigo_unapokwendaArr[$i];
                    }
                    else{
                        $mzigo_unapokwendaT = "#";
                
                    }
                    if(!is_null($ela_iliyopokelewaArr[$i])){
                        $ela_iliyopokelewaT = $ela_iliyopokelewaArr[$i];
                    }
                    else{
                        $ela_iliyopokelewaT = "0";
                
                    }
                    
                    if(!is_null($bei[$i])){
                        $bei = $bei[$i];
                    }
                    else{
                        $bei = "0";
                
                    }
                    if(!is_null($jumlaArr[$i])){
                        $jumlaT = $jumlaArr[$i];
                    }
                    else{
                        $jumlaT = "0";
                
                    }

                    // dd($subArr[$i]);

                    // $subfloatn = doubleval($subArr[$i]);

                    

                    

                    $items = array(
                        'mteja' => $mteja,
                        'mpokeaji' => $mpokeaji,
                        'activity' => $activity,
                        'name' => $nameArr[$i],
                        'idadi' => $idadiT,
                        'idadi_stoo' => $idadiT,
                        'bei' => $bei[$i],
                        'receipt' =>$receipt[$i],
                        'mzigo_unapotoka' =>   $mzigo_unapotokaT,
                        'mzigo_unapokwenda' =>  $mzigo_unapokwendaT,
                         'jumla' => $jumlaT,
                         'customer_id' => $customer->id,
                           'ela_iliyopokelewa' =>  $ela_iliyopokelewaT,
                           'added_by' => auth()->user()->id);
                       
                        $cp   =   CustomerPacel::create($items);

                     
                    PacelHistory::create([
                        'pacel_id' => $cp->id,
                        'mteja' => $mteja,
                        'mpokeaji' => $mpokeaji,
                        'activity' => $activity,
                        'name' => $cp->name,
                        'idadi' => $cp->idadi,
                        'idadi_stoo' => $cp->idadi,
                        'receipt' =>$cp->receipt,
                        'bei' => $cp->bei,
                        'customer_id' => $customer->id,
                        'mzigo_unapotoka' =>   $cp->mzigo_unapotoka,
                        'mzigo_unapokwenda' =>  $cp->mzigo_unapokwenda,
                        'jumla' => $cp->jumla,
                        'ela_iliyopokelewa' =>  $cp->ela_iliyopokelewa,
                        'added_by' => auth()->user()->id
                       
                        ]);  


                        

                        // Customer::where('id', $customer->id)->update($cost);


                        $data['id'] = $cp->id;
                        $pacel_id_arry[] = $data;
    
                }
            }
            
                        $count = $this->generateUniqueCode();

                        $delivery = $count.$customer->id."-".auth()->user()->id;

                        // dd($delivery);

                        CustomerPacel::where('customer_id', $customer->id)->update(['delivery' => $delivery]);

                        PacelHistory::where('customer_id', $customer->id)->update(['delivery' => $delivery]);
            
        }  
        // TempolaryPacel::where('added_by',auth()->user()->id)->delete();

        return redirect()->back()->with(['success'=>'taharifa zimefanikiwa kuingizwa', 'customer_ID' => $customer_ID]);
    }

    public function generateUniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (CustomerPacel::where("delivery", "=", $code)->first());
  
        return $code;
    }
    
    
    public function editmzigo($id)
    {

        if(Session::get('customer_ID')){


            $customer_ID = Session::get('customer_ID');
            // dd($data_array);
            $word_print = 'right';

            $data2 = Customer::find($id);

            // $data2 = Customer::where('id', $id)->value('level');

            $items = CustomerPacel::where('customer_id', $id)->get();

             return view('cargo_agency.customer.editmzigo', compact('word_print', 'customer_ID', 'data2', 'items', 'id'));
        }
        else{

            $word_print = 'wrong';

            //
            $data2 = Customer::find($id);

            // $data2 = Customer::where('id', $id)->value('level');

            $items = CustomerPacel::where('customer_id', $id)->get();

            

            return view('cargo_agency.customer.editmzigo', compact('word_print', 'data2', 'items', 'id'));

        }
        
    }

    public function editmzigolist(Request $request){

        $customer = Customer::find($request->c_id);
        
        $customer_ID = $request->c_id;
        
        $countxx = CustomerPacel::where('customer_id', $customer_ID)->first();

        $delivery = $countxx->delivery;

        $mteja =$customer->mteja;

        // dd($mteja);
        $mpokeaji =$customer->mpokeaji;
        $activity = "kusajiliwa";
        // $hashtag = "";

        $nameArr =$request->name;
        $idadi =$request->quantity;
        $bei =$request->price;
        $receipt = $request->receipt;

        $mzigo_unapotokaArr = $request->from;
        $mzigo_unapokwendaArr = $request->to;
        $jumlaArr = $request->total_cost ;
        $ela_iliyopokelewaArr = $request->ela_iliyopokelewa;

        $subArr = str_replace(",","",$request->subtotal);
       
;

                    // $cost['total_mizigo'] = 0;
                    // $cost['total_amount'] = 0;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){

                if(!empty($nameArr[$i])){

                    // $cost['total_amount'] = $subArr[$i];


                    if(!is_null($idadi[$i])){
                        $idadiT = $idadi[$i];
                    }
                    else{
                        $idadiT = 1;
                
                    }
                    if(!is_null($mzigo_unapotokaArr[$i])){
                        $mzigo_unapotokaT = $mzigo_unapotokaArr[$i];
                    }
                    else{
                        $mzigo_unapotokaT = "#";
                
                    }
                    if(!is_null($mzigo_unapokwendaArr[$i])){
                        $mzigo_unapokwendaT = $mzigo_unapokwendaArr[$i];
                    }
                    else{
                        $mzigo_unapokwendaT = "#";
                
                    }
                    if(!is_null($ela_iliyopokelewaArr[$i])){
                        $ela_iliyopokelewaT = $ela_iliyopokelewaArr[$i];
                    }
                    else{
                        $ela_iliyopokelewaT = "0";
                
                    }
                    if(!is_null($bei[$i])){
                        $bei = $bei[$i];
                    }
                    else{
                        $bei = "0";
                
                    }
                    if(!is_null($jumlaArr[$i])){
                        $jumlaT = $jumlaArr[$i];
                    }
                    else{
                        $jumlaT = "0";
                
                    }

                    // dd($subArr[$i]);

                    // $subfloatn = doubleval($subArr[$i]);

                    

                    

                    $items = array(
                        'mteja' => $mteja,
                        'mpokeaji' => $mpokeaji,
                        'activity' => $activity,
                        'name' => $nameArr[$i],
                        'idadi' => $idadiT,
                        'idadi_stoo' => $idadiT,
                        'bei' => $bei[$i],
                        'receipt' =>$receipt[$i],
                        'mzigo_unapotoka' =>   $mzigo_unapotokaT,
                        'mzigo_unapokwenda' =>  $mzigo_unapokwendaT,
                         'jumla' => $jumlaT,
                         'delivery' => $delivery,
                         'customer_id' => $customer->id,
                           'ela_iliyopokelewa' =>  $ela_iliyopokelewaT,
                           'added_by' => auth()->user()->id);
                       
                        $cp   =   CustomerPacel::create($items);

                     
                    PacelHistory::create([
                        'pacel_id' => $cp->id,
                        'mteja' => $mteja,
                        'mpokeaji' => $mpokeaji,
                        'activity' => $activity,
                        'name' => $cp->name,
                        'idadi' => $cp->idadi,
                        'idadi_stoo' => $cp->idadi,
                        'receipt' =>$cp->receipt,
                        'bei' => $cp->bei,
                        'delivery' => $delivery,
                        'mzigo_unapotoka' =>   $cp->mzigo_unapotoka,
                        'mzigo_unapokwenda' =>  $cp->mzigo_unapokwenda,
                        'jumla' => $cp->jumla,
                        'ela_iliyopokelewa' =>  $cp->ela_iliyopokelewa,
                        'added_by' => auth()->user()->id
                       
                        ]);  


                        

                        // Customer::where('id', $customer->id)->update($cost);


                        $data['id'] = $cp->id;
                        $pacel_id_arry[] = $data;
    
                }
            }
            
                    

                        // dd($delivery);  customer_ID

                        // CustomerPacel::where('id', $cp->id)->update(['delivery' => $delivery]);

                        // PacelHistory::where('pacel_id', $cp->id)->update(['delivery' => $delivery]);
            
        }  
        // TempolaryPacel::where('added_by',auth()->user()->id)->delete();

        return redirect()->back()->with(['success'=>'taharifa zimefanikiwa kuongezwa', 'customer_ID' => $customer_ID]);
    
    }

    public function findNameItem(Request $request){

        if(empty($request->id)){
            $data = "Andika jina la mzigo Tafadhali";
        }
        else{
            $data = '';
        }

        return response()->json($data);
    }

    public function findNameItem2(Request $request){

        if(empty($request->id)){
            $data = "Andika idadi ya mzigo Tafadhali";
        }
        elseif($request->id < 1){
            $data = "idadi ya mzigo inaanza na 1";
        }
        else{
            $data = '';
        }

        return response()->json($data);
    }
}
