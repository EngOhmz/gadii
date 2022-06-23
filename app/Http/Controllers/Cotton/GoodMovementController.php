<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\Cotton\CottonMovement;
use App\Models\Cotton\CottonItemMovement;
use App\Models\Cotton\CottonLevyMovement; ;;
use App\Models\Cotton\CottonHistory;
use App\Models\Cotton\Cotton;
use App\Models\Cotton\Levy;
use App\Models\District;

use App\Models\Cotton\PurchaseCotton;
use App\Models\Cotton\PurchaseItemCotton;
use App\Models\Cotton\CottonList;
use App\Models\Cotton\CollectionCenter;
use App\Models\Location;
use App\Models\Truck;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Cotton\TopUpOperator;
use App\Models\Cotton\TopUpCenter;
use App\Models\Cotton\Operator;

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
        
        $all_center =AccountCodes::all()->where('account_group','Cotton Creditor');
       $cotton=Cotton::where('name','Cotton')->first();
        $purchases= CottonHistory::where('items_id',$cotton->id)->where('due_quantity','>','0')->get();
        $movement= CottonMovement::all();
             $truck= Truck::all();
      $levy=Levy::where('required','0')->get();
             $reqlevy=Levy::where('required','1')->get();
 $center=CollectionCenter::where('head','!=','1')->get();
 $name = Cotton::all();
       return view('cotton.good_movement',compact('movement','purchases','levy','center','reqlevy','name','all_center'));
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
        
        
        $total_quantity = CottonHistory::where('location', $request->source)->sum('quantity');
        
        if($total_quantity < $request->quantity){
            return redirect(route('cotton_movement.index'))->with(['error'=>"Quantity insuficient"]);
        }
        $deducted_quantity = $request->quantity;
        $total_amount = 0;
        
        
        
        $amountArr = array();
        $nameArr =array() ;
        $qtyArr = array();
        $priceArr = array();
        $purArr =array();
        $costArr=array();
        
        $cotton_list = CottonHistory::where('location', $request->source)->get();
        
       // $result=array();
        
        
        foreach($cotton_list as $row){
            if($deducted_quantity > 0){
                if($row->due_quantity < $deducted_quantity && ($row->due_quantity > 0) ){
                    
                    $deducted_quantity = $deducted_quantity - $row->due_quantity;
                    $temp_amount = $row->due_quantity * $row->price;
                    $total_amount = $total_amount + $temp_amount;
                    $temp_qty = 0;
                    
                 array_push($nameArr,$row->id);
                 array_push($qtyArr,$temp_qty); 
                 array_push($priceArr,$row->price); 
                 array_push($purArr,$row->purchase_id);
                 array_push($costArr,$temp_amount);
                 array_push($amountArr,$total_amount);
                    
                    
                }elseif($row->due_quantity >= $deducted_quantity && ($row->due_quantity > 0)){
                    $temp_amount = $deducted_quantity * $row->price;
                    $total_amount = $total_amount + $temp_amount;
                    
                    $temp_qty = $row->due_quantity -$deducted_quantity ;
                    $deducted_quantity = 0;
                    
                 array_push($nameArr,$row->id);
                 array_push($qtyArr,$temp_qty); 
                 array_push($priceArr,$row->price); 
                 array_push($purArr,$row->purchase_id);
                 array_push($costArr,$temp_amount);
                 array_push($amountArr,$total_amount);
                }
                 
            }
               
                 
        }
        //
        
        
  $cotton=Cotton::where('name','Cotton')->first();


    $main=CollectionCenter::where('head','1')->first();
    
    
     $district2=CollectionCenter::find($request->source);
     if(!empty($district2))
     $district = $district2->district_id;
     else
     $district = 1;
    

       $data['source_location']=$request->source;
       $data['district_id']=$district;
       $data['destination_location']=$main->id;
           $data['rate']=$request->rate;
           $data['distance']=$request->distance;
        $data['transport']=$request->transport;
        $data['date']=$request->date;
        $data['amount']=$total_amount;
      $data['quantity']=$request->quantity;
        $data['truck_id']=$request->truck_id;
        $data['added_by']= auth()->user()->id;

        $movement= CottonMovement::create($data);
  
  

        

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

 $itemArr =$nameArr ;
$reqArr =$request->levy_req_id ;
 $purchaseArr =$purArr;
 if(!empty($reqArr)){
 for($x= 0; $x < count($purchaseArr); $x++){
            for($i= 0; $i < count($reqArr); $i++){
                if(!empty($reqArr[$i])){

  $pur= PurchaseCotton::where('id',$purchaseArr[$x])->first();

$lvy=Levy::where('id',$reqArr[$i])->first();
if($lvy->type == 'Fixed'){
$levycostArr[$i]=$lvy->value * $pur->quantity;
}
else if($lvy->type == 'Rate'){
 $levycostArr[$i]=($lvy->value/100) *$pur->purchase_amount;
}


                    $gl = array(
                         'levy_cost' =>   $levycostArr[$i],
                           'levy_id' =>  $reqArr[$i],
                            'account_id' =>  $lvy->account_id,
                         'movement_id' => $movement->id,
                           'order_no' => $i,
                           'added_by' => auth()->user()->id,
                        'purchase_id' =>$purchaseArr[$x]);
                       
                     CottonLevyMovement::create($gl);  ;
 }   
    
                }
            }
         
        }


$m=  CottonMovement::where('id',$movement->id)->first();
 $collection = CollectionCenter::find($m->source_location);
$dist=District::find($collection->district_id);

 if($dist->levy_status == '1'){
       
     
 $itemArr =$nameArr ;
 $purchaseArr =$purArr;
 $levyArr =$dist->levy_id ;

 if(!empty($levyArr)){
 for($x= 0; $x < count($purchaseArr); $x++){

  $pur= PurchaseCotton::where('id',$purchaseArr[$x])->first();

$lvy=Levy::where('id',$levyArr)->first();
if($lvy->type == 'Fixed'){
$levycostArr[$x]=$lvy->value * $pur->quantity;
}
else if($lvy->type == 'Rate'){
 $levycostArr[$x]=($lvy->value/100) *$pur->purchase_amount;
}


                    $gl = array(
                         'levy_cost' =>   $levycostArr[$x],
                           'levy_id' =>  $levyArr,
                         'account_id' =>  $lvy->account_id,
                         'movement_id' => $movement->id,
                           'order_no' => $i,
                           'added_by' => auth()->user()->id,
                        'purchase_id' =>$purchaseArr[$x]);
                       
                     CottonLevyMovement::create($gl);  ;
 
            }
         
        }

 }
$transfer=CottonMovement::find( $movement->id);

$from=CollectionCenter::where('id',$transfer->source_location)->first();
$from_qty['quantity']=$from->quantity- $transfer->quantity;
$from->update($from_qty);

$to=CollectionCenter::where('id',$transfer->destination_location)->first();
$to_qty['quantity']=$to->quantity + $transfer->quantity  ;
$to->update($to_qty);

 $levy=CottonLevyMovement::where('movement_id',$transfer->id)->get(); 
$total_levy=0;
foreach($levy as $l){
$total_levy+=$l->levy_cost;
}



  $dr= AccountCodes::where('account_name','Stock Control Account')->first();
   $cr= AccountCodes::where('account_name','Collection Center Account')->first();
 $cr2= AccountCodes::where('account_name','Stock-In Village')->first();
   $dr2= AccountCodes::where('account_name','Stock Movement')->first();
   $truck=Truck::find($transfer->truck_id);

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
    $journal->added_by=auth()->user()->id;
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
$journal->added_by=auth()->user()->id;
        $journal->save();
    
$journal = new JournalEntry();
        $journal->account_id = $dr2->id;
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
    $journal->added_by=auth()->user()->id;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id =    $cr2->id;
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
$journal->added_by=auth()->user()->id;
        $journal->save();
    

if($truck->type == 'non_owned'){
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
$journal->added_by=auth()->user()->id;
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
$journal->added_by=auth()->user()->id;
         $journal->income_id =    $transfer->id;
        $journal->save();

}

foreach($levy as $lv){
        $journal = new JournalEntry();
        $journal->account_id = $lv->account_id ;
        $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'cotton';
        $journal->name = 'Stock  Movement';
        $journal->income_id =    $transfer->id;
         $journal->notes='Stock  Movement Levy From '.$from->name.' to  ' .$to->name;
        $journal->credit= $lv->levy_cost ;
$journal->added_by=auth()->user()->id;
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
        $journal->debit=    $lv->levy_cost  ;
$journal->added_by=auth()->user()->id;
        $journal->center_id= $transfer->source_location;
 $journal->income_id =    $transfer->id;
        $journal->save();

}








       



        return redirect(route('cotton_movement.index'))->with(['success'=>'Stock Movement Created Successfully']);
        

     

    }
    
    
       public function store2(Request $request)
    {
        
        
        $total_quantity = CottonHistory::where('location', $request->source)->sum('quantity');
        
        if($total_quantity < $request->quantity){
            return view('');
        }
        
     $cotton_list = CottonHistory::where('location', $request->source)->get();
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
$from_qty['quantity']=$from->quantity- $transfer->quantity;
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


$op=
       
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
         public function chekBalance(Request $request)
    {   $result = CollectionCenter::find($request->source);
        $centre = $result->name;
        $cotton=Cotton::where('name','Cotton')->first();
        $price = $cotton->price;
        $quantity = $request->quantity;
        $source = $request->source;
        $date = $request->date;
        
         $kg_received = CottonMovement::where('source_location', $request->source)->sum('quantity'); 
        
         $total_quantity = PurchaseCotton::where('location', $request->source)->sum('quantity') - $kg_received;
        
        //$total_quantity = CottonHistory::where('location', $source)->sum('quantity');
        
         if($total_quantity < $quantity){
        $id = $source;
            return view('cotton.add1',compact('id','quantity','source','date','total_quantity','price','centre'));
         }
         else{
            // return view('cotton.add2');
              return abort(404);
         }
        
        
        
        
        
    }
    public function show($id)
    {
        //
        $total_quantity = CottonHistory::where('location', $request->source)->sum('quantity');
        
        if($total_quantity < $request->quantity){
            //return view('');
            return view('cotton_movement.add1',compact('id'));
        }
        else{
            return view('cotton_movement.add2',compact('id'));
        }
        
        
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
public function discountModal(Request $request)
   {
                $id=$request->id;
                $type = $request->type;
              if($type=='quantity'){
       $movement= CottonItemMovement::where('movement_id',$id)->get();
               return view('cotton.movement_quantity',compact('id','movement'));
}
       
   }

public function findPurchase(Request $request)
    {

        $data['purchases']= CottonHistory::where('location', $request->id)->get();
        $data['levy']=Levy::where('required','0')->get();
          $data['reqlevy']=Levy::where('required','1')->get();
         $data['total']=$request->total;
        $data['truck']= Truck::all();
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
