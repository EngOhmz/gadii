<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\InventoryPayment;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\District;
use App\Models\Payment_methodes;
use App\Models\Cotton\Cotton;
use App\Models\Cotton\PurchaseCotton;
use App\Models\Cotton\PurchaseItemCotton;
use App\Models\Cotton\CottonList;
use App\Models\Cotton\CottonHistory;
use App\Models\Supplier;
use App\Models\InventoryList;
use App\Models\Cotton\CollectionCenter;
use App\Models\Cotton\Production;
use App\Models\Cotton\Costants;
use App\Models\Cotton\ProductionActivity;
use App\Models\Cotton\Operator;  
use App\Models\Cotton\ProductionList;  
use PDF;

use Illuminate\Http\Request;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $currency= Currency::all();
        $purchases=PurchaseCotton::orderBy('created_at','asc')->get();
        $supplier=Supplier::all();
           $operator=Operator::all();
        $type="";
            $name = Cotton::all();
            $production = Production::all();

       return view('cotton.production',compact('name','currency','purchases','operator','type','production'));
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
        //
    

      
        $data['weight_note']=$request->weight_note;
         $data['date']=$request->date;
        $data['location']=$request->location;
        $data['lot_no']=$request->lot_no;
       
        $data['client']=$request->client;
        $data['location']=$request->location;
        
        $data['added_by']= auth()->user()->id;

        $production = Production::create($data);
        
        $cost['net_weight'] =0;
        $cost['gross_weight'] = 0;
        $cost['no_of_bales'] = 0;
        
        
        $baleArr =$request->bale;
        if(!empty($baleArr)){
             for($i = 0; $i < count($baleArr); $i++){

                    if(!empty($baleArr[$i])){
                         $cost['gross_weight'] = $cost['gross_weight'] + $baleArr[$i];
                        $cost['no_of_bales']++;
                        
                        
               $items = array(
                            'production_id' => $production->id,
                            'bale' =>   $baleArr[$i],
                             'added_by' => auth()->user()->id,
                            );
                            
                            $productionlist = ProductionList::create($items);
                    }
             }
              $cost['net_weight'] =  $cost['gross_weight'] - $request->tale * count($baleArr);
               $cost['bale_weight'] =  $cost['net_weight'];
            
        }
         $cost['tale']=$request->tale * count($baleArr);
         $cost['bale_no']=count($baleArr);
        $costants = Costants::all()->first();
        $data = Production::find($production->id); 
        $data->update($cost);
        
        for($i=0; $i<3; $i++){
        $activity1['lot_no'] = $request->lot_no;
        $activity1['production_id'] = $production->id;
        if($i == 0){
           $activity1['production_quantity'] = $cost['net_weight']*$costants->seeds;
        $activity1['type'] = 1;
        }elseif($i ==1){
             $activity1['production_quantity'] = $cost['net_weight']*$costants->raw_cotton;
        $activity1['type'] = 3;
        }elseif($i == 2){
            $activity1['production_quantity'] = $cost['net_weight']*$costants->dust;
        $activity1['type'] = 2;
        }
        
        
        $activity1['added_by'] = auth()->user()->id;
        
           $activity = ProductionActivity::create($activity1);
            
        }
        
        $main=CollectionCenter::where('head','1')->first();
        $deducted_quantity = $cost['net_weight'];
        $total_amount = 0;
        $cotton_list = CottonHistory::where('location', $main->id)->get();
        
                foreach($cotton_list as $row){
            if($deducted_quantity > 0){
                if($row->due_quantity < $deducted_quantity && ($row->due_quantity > 0) ){
                    
                    $deducted_quantity = $deducted_quantity - $row->due_quantity;
                    $temp_amount = $row->due_quantity * $row->amount;
                    $total_amount = $total_amount + $temp_amount;
                    $temp_qty = 0;

                    
                    
                }elseif($row->due_quantity >= $deducted_quantity && ($row->due_quantity > 0)){
                    $temp_amount = $deducted_quantity * $row->amount;
                    $total_amount = $total_amount + $temp_amount;
                    
                    $temp_qty = $row->due_quantity -$deducted_quantity ;
                    $deducted_quantity = 0;
                    
 
                }
                 
            }
               
                 
        }
        
        
        
            
          $cr= AccountCodes::where('account_name','Production Control')->first();
          $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          
          $journal->date =   $request->date ;
          $journal->year = date('y',strtotime($request->date));
          $journal->month = date('m',strtotime($request->date));
          $journal->transaction_type = 'cotton';
          $journal->name = 'Cotton Production';
          $journal->debit = $total_amount;
          $journal->income_id= $production->id;
            $journal->center_id= $main->id;
           $journal->added_by=auth()->user()->id;
             $journal->notes="Stock Control with lot no " .$production->lot_no;             
          $journal->save();
          
          
             $cr= AccountCodes::where('account_name','Stock Movement')->first();
          $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          
          $journal->date =   $request->date ;
          $journal->year = date('y',strtotime($request->date));
          $journal->month = date('m',strtotime($request->date));
          $journal->transaction_type = 'cotton';
          $journal->name = 'Cotton Production';
          $journal->credit = $total_amount;;
          $journal->income_id= $production->id;
            $journal->center_id= $main->id;
           $journal->added_by=auth()->user()->id;
             $journal->notes="Stock Control with lot no " .$production->lot_no;               
          $journal->save();
        
        
        
       
        
            
              


         //return redirect(route('production.index'));
         return view('cotton.productionDetails',compact('data'));
          
       
        
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
          $data = Production::find($id); 


         //return redirect(route('production.index'));
         return view('cotton.productionDetails',compact('data'));
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
        $data = Production::find($id); 


         //return redirect(route('production.index'));
         return view('cotton.production',compact('data','id'));
      
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
      
      $production = Production::find($id);
      
      $data['weight_note']=$request->weight_note;
         $data['date']=$request->date;
        $data['location']=$request->location;
        $data['lot_no']=$request->lot_no;
       
        $data['client']=$request->client;
        $data['location']=$request->location;
        
        $data['added_by']= auth()->user()->id;

        $production->update($data);
        
        $cost['net_weight'] =0;
        $cost['gross_weight'] = 0;
        $cost['no_of_bales'] = 0;
        
        
        $baleArr =$request->bale;
        if(!empty($baleArr)){
            ProductionList::where('production_id',$id)->delete();
             for($i = 0; $i < count($baleArr); $i++){

                    if(!empty($baleArr[$i])){
                         $cost['gross_weight'] +=$baleArr[$i];
                        $cost['no_of_bales']++;
                        
                        
               $items = array(
                            'production_id' => $id,
                            'bale' =>   $baleArr[$i],
                             'added_by' => auth()->user()->id,
                            );
                            
                            $productionlist = ProductionList::create($items);
                    }
             }
              $cost['net_weight'] =  $cost['gross_weight'] - $request->tale;
               $cost['bale_weight'] =  $cost['net_weight'];
            
        }
         $cost['tale']=$request->tale * count($baleArr);
         $cost['bale_no']=$count($baleArr);
        $costants = Costants::all()->first();
        $data = Production::find($id); 
        $data->update($cost);
        
        for($i=0; $i<3; $i++){
        $activity1['lot_no'] = $request->lot_no;
        $activity1['production_id'] = $id;
        if($i == 0){
           $activity1['production_quantity'] = $cost['net_weight']*$costants->seeds;
        $activity1['type'] = 1;
        }elseif($i ==1){
             $activity1['production_quantity'] = $cost['net_weight']*$costants->raw_cotton;
        $activity1['type'] = 3;
        }elseif($i == 2){
            $activity1['production_quantity'] = $cost['net_weight']*$costants->dust;
        $activity1['type'] = 2;
        }
        
        
        $activity1['added_by'] = auth()->user()->id;
        
           $activity = ProductionActivity::create($activity1);
            
        }
        
        
        
       
        
            
              


         //return redirect(route('production.index'));
         return view('cotton.productionDetails',compact('data'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        ProductionList::where('production_id', $id)->delete();
       ProductionActivity::where('production_id', $id)->delete();
       $production = production::find($id);
        $production->delete();
        return redirect(route('production.index'))->with(['success'=>'Deleted Successfully']);
    }


    public function inv_pdfview(Request $request)
    {
        //
         $data = Production::find($request->id); 
       

        view()->share(['data'=>$data]);

        if($request->has('download')){
        $pdf = PDF::loadView('cotton.productionDetails_pdf')->setPaper('a4', 'landscape');
         return $pdf->download('bell record lot no # ' .  $data->lot_no . ".pdf");
        }
        return view('inv_pdfview');
    }
}
