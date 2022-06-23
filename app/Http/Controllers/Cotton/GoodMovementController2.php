<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\Cotton\CottonMovement;
use App\Models\Cotton\CottonItemMovement;
use App\Models\Cotton\CottonLevyMovement; ;;
use App\Models\Cotton\CottonHistory;
use App\Models\Cotton\Cotton;
use App\Models\Cotton\PurchaseCotton;
use App\Models\Cotton\PurchaseItemCotton;
use App\Models\Cotton\CottonList;
use App\Models\Cotton\CollectionCenter;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Cotton\TopUpOperator;
use App\Models\Cotton\TopUpCenter;

class GoodMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       $cotton=Cotton::where('name','Cotton')->first();
        $purchases= CottonHistory::where('items_id',$cotton->id)->where('due_quantity','>','0')->get();
        $movement= CottonMovement::all();
      $levy=AccountCodes::where('account_group','Levy')->get();
 $center=CollectionCenter::where('head','!=','1')->get();
       return view('cotton.good_movement',compact('movement','purchases','levy','center'));
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
  $cotton=Cotton::where('name','Cotton')->first();


    $main=CollectionCenter::where('head','1')->first();

    $data['source_location']='1';
       $data['destination_location']=$main->id;
        $data['transport']=$request->transport;
        $data['date']=$request->date;
        $data['amount']=$request->amount;
      $data['quantity']=$request->total_quantity;
        $data['added_by']= auth()->user()->id;

        $movement= CottonMovement::create($data);
  
  
 $amountArr = str_replace(",","",$request->amount);

        $nameArr =$request->checked_item_id ;
        $qtyArr = $request->checked_quantity  ;
        $priceArr = $request->checked_price;
        $purArr =$request->checked_purchase_id;
        $costArr=str_replace(",","",$request->checked_total_cost);
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                 
                    $items = array(
                        'item_id' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                         'movement_id' => $movement->id,
                           'order_no' => $i,
                           'added_by' => auth()->user()->id,
                        'purchase_id' =>$purArr[$i]);
                       
                     CottonItemMovement::create($items);  ;

               $qty=CottonHistory::where('purchase_id', $purArr[$i])->first();
            $from_balance=$qty->due_quantity - $qtyArr[$i]  ;
              $item['due_quantity']=$from_balance;
              $qty->update($item);

 $inv=CottonHistory::where('purchase_id',$purArr[$i])->first();
$cost['source_location']=$inv->location;
     CottonMovement::where('id',$movement->id)->update($cost);
    
                }


}
        }    

 
 $itemArr =$request->checked_item_id ;
$levyArr =$request->levy_id ;
 $purchaseArr =$request->checked_purchase_id;
 if(!empty($levyArr)){
 for($x= 0; $x < count($purchaseArr); $x++){
            for($i= 0; $i < count($levyArr); $i++){
                if(!empty($levyArr[$i])){

  $pur= PurchaseCotton::where('id',$purchaseArr[$x])->first();
$district=0.03 *$pur->purchase_amount;
$comm=50* $pur->quantity;

$cr= AccountCodes::where('account_name','District Levy')->first();
if($cr->id == $levyArr[$i]){
$levycostArr[$i]=$district;
}else{
$levycostArr[$i]=$comm;
}


                    $gl = array(
                         'levy_cost' =>   $levycostArr[$i],
                           'levy_id' =>  $levyArr[$i],
                         'movement_id' => $movement->id,
                           'order_no' => $i,
                           'added_by' => auth()->user()->id,
                        'purchase_id' =>$purchaseArr[$x]);
                       
                     CottonLevyMovement::create($gl);  ;
 }   
    
                }
            }
         
        }

 
$transfer=CottonMovement::find( $movement->id);

$from=CollectionCenter::where('id',$transfer->source_location)->first();
$from_qty['quantity']=$from->quantity- $transfer->quantity  ;
$from->update($from_qty);

$to=CollectionCenter::where('id',$transfer->destination_location)->first();
$to_qty['quantity']=$to->quantity + $transfer->quantity  ;
$to->update($to_qty);

 $levy=CottonLevyMovement::where('movement_id',$transfer->id)->get(); 
$total_levy=0;
foreach($levy as $l){
$total_levy+=$l->levy_cost;
}


  $dr= AccountCodes::where('account_name','Purchasing Account')->first();
   $cr= AccountCodes::where('account_name','Collection Center Account')->first();

        $journal = new JournalEntry();
        $journal->account_id = $dr->id;
        $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'cotton';
        $journal->name = 'Stock Movement';
        $journal->income_id =    $transfer->id;
         $journal->notes='Stock Movement From '.$from->name.' to  ' .$to->name;
        $journal->debit= $transfer->amount ;
        $journal->center_id= $transfer->source_location;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id =    $cr->id;
       $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
         $journal->month = $date[1];
        $journal->transaction_type = 'cotton';
        $journal->name = 'Stock  Movement';
          $journal->notes='Stock  Movement From  '.$from->name.' to ' .$to->name;
        $journal->credit=    $transfer->amount ;
      $journal->income_id =    $transfer->id;
        $journal->center_id= $transfer->source_location;
        $journal->save();
    

if(!empty($transfer->transport)){
 $trans_dr= AccountCodes::where('account_name','Transport Expenses Account')->first();
        $journal = new JournalEntry();
        $journal->account_id =  $trans_dr->id;
        $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'cotton';
        $journal->name = 'Stock Movement';
        $journal->income_id =    $transfer->id;
         $journal->notes='Stock  Movement From '.$from->name.' to  ' .$to->name;
        $journal->debit= $transfer->transport ;
        $journal->center_id= $transfer->source_location;
        $journal->save();

 $trans_cr= AccountCodes::where('account_name','Transport Account')->first();
        $journal = new JournalEntry();
        $journal->account_id =     $trans_cr->id;
       $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
         $journal->month = $date[1];
        $journal->transaction_type = 'cotton';
        $journal->name = 'Stock  Movement';
          $journal->notes='Stock  Movement From  '.$from->name.' to ' .$to->name;
        $journal->credit=   $transfer->transport ;
        $journal->center_id= $transfer->source_location;
         $journal->income_id =    $transfer->id;
        $journal->save();

}

foreach($levy as $lv){
$district= AccountCodes::where('account_name','District Levy')->first();
if($lv->levy_id == $district->id ){
        $journal = new JournalEntry();
        $journal->account_id = $lv->levy_id ;
        $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'cotton';
        $journal->name = 'Stock  Movement';
        $journal->income_id =    $transfer->id;
         $journal->notes='Stock  Movement District Levy From '.$from->name.' to  ' .$to->name;
        $journal->debit= $lv->levy_cost ;
        $journal->center_id= $transfer->source_location;
        $journal->save();

$control= AccountCodes::where('account_name','Levy Control')->first();
        $journal = new JournalEntry();
        $journal->account_id =    $control->id;
       $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
         $journal->month = $date[1];
        $journal->transaction_type = 'cotton';
        $journal->name = 'Stock  Movement';
          $journal->notes='Stock  Movement Levy Control From  '.$from->name.' to ' .$to->name;
        $journal->credit=    $lv->levy_cost  ;
        $journal->center_id= $transfer->source_location;
 $journal->income_id =    $transfer->id;
        $journal->save();

}

$cm= AccountCodes::where('account_name','Community Level')->first();
if($lv->levy_id == $cm->id ){
        $journal = new JournalEntry();
        $journal->account_id = $lv->levy_id ;
        $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'cotton';
        $journal->name = 'Stock  Movement';
        $journal->income_id =    $transfer->id;
         $journal->notes='Stock  Movement Community Levy From '.$from->name.' to  ' .$to->name;
        $journal->debit= $lv->levy_cost ;
        $journal->center_id= $transfer->source_location;
        $journal->save();

$control= AccountCodes::where('account_name','Levy Control')->first();
        $journal = new JournalEntry();
        $journal->account_id =    $control->id;
       $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
         $journal->month = $date[1];
        $journal->transaction_type = 'cotton';
        $journal->name = 'Stock  Movement';
          $journal->notes='Stock  Movement Levy Control From  '.$from->name.' to ' .$to->name;
        $journal->credit=    $lv->levy_cost  ;
        $journal->center_id= $transfer->source_location;
       $journal->income_id =    $transfer->id;
        $journal->save();

}


}



       
$top=TopUpCenter::where('to_account_id',$transfer->source_location)->where('status', '1')->first();
$balance['due_amount']=$top->due_amount - ($transfer->amount + $total_levy + $transfer->transport);
      $top->update($balance);



        return redirect(route('cotton_movement.index'))->with(['success'=>'Stock Movement Created Successfully']);
        

     

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

     $purchases= PurchaseCotton::where('good_receive','1')->get();
        $data= CottonMovement::find($id);
       $cotton=Cotton::where('name','Cotton')->first();
        $purchases= CottonHistory::where('items_id',$cotton->id)->where('due_quantity','>','0')->where('location', $data->siurc)->get();
      $levy=AccountCodes::where('account_group','Levy')->get();
        $item=  CottonItemMovement::where('movement_id',$id)->get();
        $levy_item=  CottonLevyMovement::where('movement_id',$id)->get();
 $center=CollectionCenter::where('head','!=','1')->get();
       return view('cotton.good_movement',compact('data','purchases','id','purchases','levy','item','levy_item','center'));
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
        $movement=CottonMovement::find($id);

         $cotton=Cotton::where('name','Cotton')->first();

 $inv=CottonHistory::where('purchase_id',$request->purchase_id)->where('items_id',$cotton->id)->first();
    $main=CollectionCenter::where('head','1')->first();

    $data['source_location']=$inv->location;
       $data['destination_location']=$main->id;
       $data['purchase_id']=$request->purchase_id;
        $data['transport']=$request->transport;
        $data['date']=$request->date;
        $data['amount']='1';
      $data['quantity']='1';
        $data['added_by']= auth()->user()->id;

         $movement->update($data);
  
  
 $amountArr = str_replace(",","",$request->amount);

        $nameArr =$request->item_id ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $costArr = str_replace(",","",$request->total_cost)  ;
         $remArr = $request->removed_id ;
            $expArr = $request->levy_item_id ;
            $savedArr =$request->cotton_item_id;
        
        $cost['amount'] = 0;
       $cost['quantity'] = 0;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['amount'] +=$costArr[$i];
                    $cost['quantity'] +=$qtyArr[$i];
                    $items = array(
                        'item_id' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                         'movement_id' => $movement->id,
                           'order_no' => $i,
                           'added_by' => auth()->user()->id,
                        'purchase_id' =>$request->purchase_id);
                       
                     CottonItemMovement::where('id', $savedArr[$i])->update($items);   ;
    
    
                }
            }
           CottonMovement::where('id',$movement->id)->update($cost);
        }    


  if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                   CottonLevyMovement::where('id',$remArr[$i])->delete();        
                       }
                   }
               }

   $pur= PurchaseCotton::where('id',$request->purchase_id)->first();
$district=0.03 *$pur->purchase_amount;

$comm=50* $pur->weight;

  $levyArr =$request->levy_id ;
 if(!empty($levyArr)){
            for($i = 0; $i < count($levyArr); $i++){
                if(!empty($levyArr[$i])){
$cr= AccountCodes::where('account_name','District Levy')->first();
if($cr->id == $levyArr[$i]){
$levycostArr=$district;
}else{
$levycostArr=$comm;
}


                    $gl = array(
                        'levy_cost' =>   $levycostArr,
                           'levy_id' =>  $levyArr[$i],
                         'movement_id' => $movement->id,
                           'order_no' => $i,
                           'added_by' => auth()->user()->id,
                        'purchase_id' =>$request->purchase_id);
                       
                      
                            if(!empty($expArr[$i])){
                                CottonLevyMovement::where('id',$expArr[$i])->update($gl);  
          
          }
          else{
              CottonLevyMovement::create($gl);  ;  
          }
                     
    
    
                }
            }
         
        }

      

 return redirect(route('cotton_movement.index'))->with(['success'=>'Good Movement Updated Successfully']);
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
        $movement =  CottonMovement::find($id);
        $movement->delete();

        return redirect(route('cotton_movement.index'))->with(['success'=>'Good Movement  Deleted Successfully']);
    }

public function findQuantity(Request $request)
    {
   $cotton=Cotton::where('name','Cotton')->first();
$total= CottonHistory::where('purchase_id',$request->id)->where('items_id',$cotton->id)->first();


                return response()->json($total);	                  
 
    }

public function findPurchase(Request $request)
    {

        $data['purchases']= CottonHistory::where('location', $request->id)->get();
        $data['levy']=AccountCodes::where('account_group','Levy')->get();
                //return response()->json($purchases);	                  
        return response()->json(['html' => view('cotton.addreport', $data)->render()]);
    }

     public function approve($id)
    {
        //
        $transfer= CottonMovement::find($id);
        $data['status'] = 1;
        $data['approve_by']=auth()->user()->id;
        $transfer->update($data);



        return redirect(route('cotton_movement.index'))->with(['success'=>'Approved Successfully']);
    }

}
