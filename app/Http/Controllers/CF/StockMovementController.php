<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\POS\GoodIssue;
use App\Models\POS\GoodIssueItem;
use App\Models\POS\StockMovement;
use App\Models\POS\StockMovementItem;
use App\Models\POS\GoodDisposal;
use App\Models\POS\GoodDisposalItem;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\PurchaseHistory;
use App\Models\Restaurant\POS\OrderHistory;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Truck;
use App\Models\POS\Items;
use App\Models\POS\Activity;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $issue= StockMovement::where('added_by',auth()->user()->added_by)->get();;
        $location=Location::where('added_by',auth()->user()->added_by)->get();;
         //$location= LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $inventory= Items::whereIn('type', [1,2,3])->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->get();;
          $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get();
       return view('pos.purchases.stock_movement',compact('issue','inventory','location','staff','truck','bank_accounts'));
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
       if($request->start == $request->location){
       return redirect(route('stock_movement.index'))->with(['error'=>'You have Chosen the same Location']);

}


else{
        $data['movement_date']=$request->date;
       $data['destination_store']=$request->location;
        $data['source_store']=$request->start;    
        $data['staff']=$request->staff;
        $data['name']=$request->name;
        $data['costs']=$request->costs;
          $data['account_id']=$request->account_id;
       $data['description']=$request->description;
        $data['status']= 0;
         $data['user_id']= auth()->user()->added_by;
        $data['added_by']= auth()->user()->added_by;

        $issue = StockMovement::create($data);
        
       

        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;

       $total=0;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'item_id' => $nameArr[$i],
                        'status' => 0,
                        'destination_store' =>$request->location,
                        'source_store' => $request->start,   
                        'quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'movement_id' =>$issue->id);

                    
                   StockMovementItem::create($items);

                    $total+= $qtyArr[$i];

   
                $loc=Location::find($request->location);
                  $st_loc=Location::find($request->start);               
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$issue->id,
                             'module'=>'Stock Movement',
                           'activity'=>"Stock Movement for ".$itm->name . " from ". $st_loc->name ."  to  " .$loc->name ." is Created",
                        ]
                        );                      
       }

    
                }
            }

        StockMovement::find($issue->id)->update(['quantity' => $total]);
           
        }    


                return redirect(route('stock_movement.index'))->with(['success'=>' Stock Movement Created Successfully']);
}

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
        $data=StockMovement::find($id);
         $location=Location::where('added_by',auth()->user()->added_by)->get();;
         //$location=LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $inventory=Items::whereIn('type', [1,2,3])->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
         $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
       //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->get();;
        $items=StockMovementItem::where('movement_id',$id)->get();
         $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get();
       return view('pos.purchases.stock_movement',compact('items','inventory','location','staff','data','id','truck','bank_accounts'));
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
         //
   if($request->start == $request->location){
   return redirect(route('stock_movement.index'))->with(['error'=>'You have Chosen the same Location']);

}


else{
        $issue=StockMovement::find($id);

     $data['movement_date']=$request->date;
   $data['destination_store']=$request->location;
    $data['source_store']=$request->start;    
    $data['staff']=$request->staff;
    $data['name']=$request->name;
    $data['costs']=$request->costs;
 $data['description']=$request->description;
          $data['account_id']=$request->account_id;
    $data['status']= 0;
    $data['added_by']= auth()->user()->added_by;
        $issue->update($data);
        
       
        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_id ;

          $total=0;

           
        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
              StockMovementItem::where('id',$remArr[$i])->delete();   
                            
                   }
               }
           }

           



        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                   $items = array(
                    'item_id' => $nameArr[$i],
                    'status' => 0,
                    'destination_store' =>$request->location,
                    'source_store' => $request->start,   
                    'quantity' =>    $qtyArr[$i],
                       'order_no' => $i,
                       'added_by' => auth()->user()->added_by,
                    'movement_id' =>$id);
                       
                    
                   
                            if(!empty($expArr[$i])){
                               StockMovementItem::where('id',$expArr[$i])->update($items);                              
                             }
                          else{
                        StockMovementItem::create($items);  
                       
                          }                         
                     
                  $total+= $qtyArr[$i];
                   
                    $loc=Location::find($request->location);
              $st_loc=Location::find($request->start);
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                           'module'=>'Stock Movement',
                       'activity'=>"Stock Movement for ".$itm->name . " from ". $st_loc->name ."  to  " .$loc->name ." is Updated",
                        ]
                        );                      
       }

    
                }
            }

                      StockMovement::find($id)->update(['quantity' => $total]);           
        }    

                return redirect(route('stock_movement.index'))->with(['success'=>' Stock Movement Updated Successfully']);
    }

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
        $issue =   StockMovement::find($id);
          $items=  StockMovementItem::where('movement_id',$id)->get();
          foreach($items as $i){

               $loc=Location::find($i->location);
                     $st_loc=Location::find($i->start);
                  $itm=Items::find($i->item_id);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                               'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Stock Movement',
                       'activity'=>"Stock Movement for ".$itm->name . " from ". $st_loc->name ."  to  " .$loc->name ." is Deleted",
                        ]
                        );                      
       }
               
}

       StockMovementItem::where('movement_id',$id)->delete();
        $issue->delete();

               return redirect(route('stock_movement.index'))->with(['success'=>' Stock Movement Deleted Successfully']);
    }

    public function approve($id){
        //

 $item=StockMovementItem::where('movement_id',$id)->get();

foreach($item as $i){

 $inv=Items::where('id',$i->item_id)->first();
$issue=StockMovement::find($id);

$sloc=Location::find($i->source_store);
 $sq['quantity']=$sloc->quantity - $i->quantity;
$sq['crate']=$sloc->crate - $i->quantity;
$sq['bottle']=$sloc->bottle - ($i->quantity * $inv->bottle);
$sloc->update($sq);

$dloc=Location::find($i->destination_store);
 $dq['quantity']=$dloc->quantity + $i->quantity;
$dq['crate']=$dloc->crate + $i->quantity;
$dq['bottle']=$dloc->bottle + ($i->quantity * $inv->bottle);
$dloc->update($dq);


                  $itm=Items::find($i->item_id);
                    $loc=Location::find($i->destination_store);
                     $st_loc=Location::find($i->source_store);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                          'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Stock Movement',
                       'activity'=>"Stock Movement for ".$itm->name . " from ". $st_loc->name ."  to  " .$loc->name ." is Approved",
                        ]
                        );                      
       }





} 


$chk= StockMovement::find($id);
$ds=Location::find($chk->destination_store);
$ss=Location::find($chk->source_store);

if($chk->costs > 0){

    $shp= AccountCodes::where('account_name','Shipping Cost')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $shp->id;
          $date = explode('-',$chk->movement_date);
          $journal->date =   $chk->movement_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_stock_movement';
          $journal->name = 'POS Stock Movement';
          $journal->debit = $chk->costs ;
          $journal->payment_id= $id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Transportation Cost for POS Stock Movement from " .$ss->name ."  to  " .$ds->name  ;
          $journal->save();
        
         
          $journal = new JournalEntry();
          $journal->account_id = $chk->account_id;
           $date = explode('-',$chk->movement_date);
          $journal->date =   $chk->movement_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
       $journal->transaction_type = 'pos_stock_movement';
          $journal->name = 'POS Stock Movement';
          $journal->credit = $chk->costs ;
            $journal->payment_id= $id;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Transportation Cost for POS Stock Movement from " .$ss->name ."  to  " .$ds->name  ;
          $journal->save();

}



 StockMovement::where('id',$id)->update(['status' => '1']);;
 StockMovementItem::where('movement_id',$id)->update(['status' => '1']);;

       
        return redirect(route('stock_movement.index'))->with(['success'=>'Stock Movement Approved Successfully']);
    }


    public function findQuantity(Request $request)
    {
 
$item=$request->item;
$location=$request->location;
$date = today()->format('Y-m');

$item_info=Items::where('id', $item)->first();  
$location_info=Location::find($request->location);
 if ($item_info->quantity > 0) {

$pqty= PurchaseHistory::where('item_id', $item)->where('location',$location)->where('type', 'Purchases')->where('added_by',auth()->user()->added_by)->sum('quantity');   
$dn= PurchaseHistory::where('item_id', $item)->where('location',$location)->where('type', 'Debit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');  
$dgood=StockMovementItem::where('item_id',$item)->where('destination_store',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');

$sgood=StockMovementItem::where('item_id',$item)->where('source_store',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');
$issue=GoodIssueItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');
 $disposal=GoodDisposalItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');

if($item_info->bar == '0'){ 
$sqty= InvoiceHistory::where('item_id', $item)->where('location',$location)->where('type', 'Sales')->where('added_by',auth()->user()->added_by)->sum('quantity'); 
$cn= InvoiceHistory::where('item_id', $item)->where('location',$location)->where('type', 'Credit Note')->where('added_by',auth()->user()->added_by)->sum('quantity'); 
$inv=$sqty-$cn ;
}

else if($item_info->bar == '1'){
$sqty= OrderHistory::where('item_id', $item)->where('location',$location)->where('type', 'Sales')->where('item_type', 'Bar')->where('added_by',auth()->user()->added_by)->sum('quantity'); 
$cn= OrderHistory::where('item_id', $item)->where('location',$location)->where('type', 'Credit Note')->where('item_type', 'Bar')->where('added_by',auth()->user()->added_by)->sum('quantity');
$c=$sqty-$cn ;
$cr=$c/$item_info->bottle;
$inv=round($cr, 1);
}


$qty=$pqty-$dn;
$q=($qty + $dgood) - ($issue +$inv + $sgood);
$quantity=floor($q);

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

                return response()->json($price);                      
 
    }

  

public function discountModal(Request $request)
{
             $id=$request->id;
             $type = $request->type;
              if($type == 'issue'){
                $data=StockMovementItem::where('movement_id',$id)->get();
                return view('pos.purchases.view_movement',compact('id','data'));
  }

             }

}
