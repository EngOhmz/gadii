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
use App\Models\POS\InvoiceHistory;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\MasterHistory;
use App\Models\POS\GoodDisposal;
use App\Models\POS\GoodDisposalItem;
use App\Models\POS\SerialList;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Truck;
use App\Models\POS\Items;
use App\Models\POS\Activity;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Client;
use DB;
use PDF;

class GoodIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $issue= GoodIssue::where('added_by',auth()->user()->added_by)->get();;
      $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         //$location= LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $inventory= Items::whereIn('type', [1,2,3,5])->where('bar',0)->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get();
         $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
          $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();  
       return view('pos.purchases.good_issue',compact('issue','inventory','location','staff','truck','bank_accounts','branch','client'));
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
         $count=GoodIssue::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $dt=date('m/d', strtotime($request->date));
        $x=Location::find($request->location);
        
        $words = preg_split("/\s+/", $x->name);
        $acronym = "";
        
        foreach ($words as $w) {
          $acronym .= mb_substr($w, 0, 1);
        }
        $a=strtoupper($acronym);
//dd($a);

        $data['date']=$request->date;
        $data['location']=$request->location;    
        $data['staff']=$request->staff;
        $data['staff_id']=$request->staff;
         $data['client_id']=$request->client_id;
        $data['name']=$a.'/'.$dt.'/00'.$pro;
        $data['branch_id']=$request->branch_id;
        $data['status']= 0;
        $data['costs']=$request->costs;
        $data['description']=$request->description;
        $data['account_id']=$request->account_id;
        $data['branch_id']=$request->branch_id;
        $data['user_id']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $issue = GoodIssue::create($data);
        
       

        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'item_id' => $nameArr[$i],
                        'status' => 0,
                        'location' => $request->location,
                         'truck_id' => $request->truck_id,
                        'quantity' =>    $qtyArr[$i],
                        'due_quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'issue_id' =>$issue->id);

                    
                   GoodIssueItem::create($items);

                  
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$issue->id,
                             'module'=>'Good Issue',
                            'activity'=>"Good issue for ".$itm->name . " with reference " .$issue->name ." is Created",
                        ]
                        );                      
       }

    
                }
            }
           
        }    


                return redirect(route('pos_issue.index'))->with(['success'=>'Good Issue Created Successfully']);
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
        $data=GoodIssue::find($id);
       $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         //$location=LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $inventory= Items::whereIn('type', [1,2,3,5])->where('bar',0)->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
         $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
       //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $items=GoodIssueItem::where('issue_id',$id)->get();
$bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get();
 $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();  
       return view('pos.purchases.good_issue',compact('items','inventory','location','staff','data','id','truck','bank_accounts','client'));
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

        $issue=GoodIssue::find($id);

        $data['date']=$request->date;
        $data['location']=$request->location;    
        $data['staff']=$request->staff;
        $data['staff_id']=$request->staff;
         $data['client_id']=$request->client_id;
          $data['costs']=$request->costs;
           $data['description']=$request->description;
          $data['account_id']=$request->account_id;
        $data['added_by']= auth()->user()->added_by;
        $issue->update($data);
        
       
        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_id ;




           
        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
               GoodIssueItem::where('id',$remArr[$i])->delete();   
                            
                   }
               }
           }

           



        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'item_id' => $nameArr[$i],
                        'location' => $request->location,
                      'truck_id' => $request->truck_id,
                        'quantity' =>    $qtyArr[$i],
                        'due_quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'issue_id' =>$id);
                       
                    
                   
                            if(!empty($expArr[$i])){
                                GoodIssueItem::where('id',$expArr[$i])->update($items);                              
                             }
                          else{
                         GoodIssueItem::create($items);  
                       
                          }                         
                     
                   
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Issue',
                            'activity'=>"Good issue for ".$itm->name . "  with reference " .$issue->name ." is Updated",
                        ]
                        );                      
       }

    
                }
            }
           
        }    

                return redirect(route('pos_issue.index'))->with(['success'=>'Good Issue Updated Successfully']);
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
      
        $issue =  GoodIssue::find($id);

          $items= GoodIssueItem::where('issue_id',$id)->get();
          foreach($items as $i){

                   $loc=Truck::find($i->truck_id);
                  $itm=Items::find($i->item_id);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                               'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Issue',
                             'activity'=>"Good issue for ".$itm->name ."  with reference " .$issue->name ." is Deleted",
                        ]
                        );                      
       }
}

       GoodIssueItem::where('issue_id', $id)->delete();
        $issue->delete();

                return redirect(route('pos_issue.index'))->with(['success'=>'Good Issue Deleted Successfully']);
    }

    public function approve($id){
        //

 $item=GoodIssueItem::where('issue_id',$id)->get();

foreach($item as $i){

$issue=GoodIssue::find($id);


 $inv=Items::where('id',$i->item_id)->first();
 $q=$inv->quantity - $i->quantity;
Items::where('id',$i->item_id)->update(['quantity' => $q]);

$loc=Location::find($i->location);
 $lq=$loc->quantity - $i->quantity;
Location::find($i->location)->update(['quantity' => $lq]);

                    $mlists = [
                        'out' => $i->quantity,
                        'price' => $inv->cost_price,
                        'item_id' => $i->item_id,
                         'staff_id' => $issue->staff,
                         'client_id' => $issue->client_id,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $i->location,
                        'date' =>$issue->date,
                        'type' =>   'Good Issue',
                        'other_id' =>$id,
                    ];

                    MasterHistory::create($mlists);



//$chk=SerialList::where('brand_id',$i->item_id)->where('location',$i->location)->where('added_by',auth()->user()->added_by)->where('status','0')->where('expire_date', '>=', $date)
//->orWhereNull('expire_date')->where('brand_id',$i->item_id)->where('location',$i->location)->where('added_by',auth()->user()->added_by)->where('status','0')->take($i->quantity)->update(['status'=> '3']) ; 


                  $itm=Items::find($i->item_id);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                          'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Issue',
                             'activity'=>"Good issue for ".$itm->name . "  with reference " .$issue->name ." is Approved",
                        ]
                        );                      
       }



if($inv->type == '1' || $inv->type == '3'){
  $d=$issue->date;

$codes= AccountCodes::where('account_name','Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'pos_inventory_issue';
  $journal->name = 'POS Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->debit =$inv->cost_price *  $i->quantity;
  $journal->branch_id= $inv->branch_id;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="POS Inventory Issued with reference " .$issue->name;
  $journal->save();

  $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'pos_inventory_issue';
  $journal->name = 'POS Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->credit = $inv->cost_price *  $i->quantity;
  $journal->branch_id= $inv->branch_id;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="POS Inventory Issued with reference " .$issue->name;
  $journal->save();
}


} 


$chk=GoodIssue::find($id);

if($chk->costs > 0){

    $shp= AccountCodes::where('account_name','Shipping Cost')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $shp->id;
          $date = explode('-',$chk->date);
          $journal->date =   $chk->date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_good_issue';
          $journal->name = 'POS Good Issue';
          $journal->debit = $chk->costs ;
          $journal->payment_id= $id;
          $journal->branch_id= $inv->branch_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Transportation Cost for POS Good Issue with reference " .$chk->name  ;
          $journal->save();
        
         
          $journal = new JournalEntry();
          $journal->account_id = $chk->id;
           $date = explode('-',$chk->date);
          $journal->date =   $chk->date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
       $journal->transaction_type = 'pos_good_issue';
          $journal->name = 'POS Good Issue';
          $journal->credit = $chk->costs ;
            $journal->payment_id= $id;
          $journal->added_by=auth()->user()->added_by;
          $journal->branch_id= $inv->branch_id;
          $journal->notes= "Transportation Cost for POS Good Issue with reference " .$chk->name  ;
          $journal->save();

}

GoodIssue::find($id)->update(['status' => '1']);;
GoodIssueItem::where('issue_id',$id)->update(['status' => '1']);;

       
        return redirect(route('pos_issue.index'))->with(['success'=>'Good Issue Approved Successfully']);
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

 $pqty= PurchaseHistory::where('item_id', $item)->where('location',$location)->where('type', 'Purchases')->where('added_by',auth()->user()->added_by)->sum('quantity'); 
 $dn= PurchaseHistory::where('item_id', $item)->where('location',$location)->where('type', 'Debit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');  
 $dgood=StockMovementItem::where('item_id',$item)->where('destination_store',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');

$sgood=StockMovementItem::where('item_id',$item)->where('source_store',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');
 $issue=GoodIssueItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum(\DB::raw('quantity - returned'));
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

    public function findQuantity2(Request $request)
    {
 
$item=$request->item;
$location=$request->location;
 $date = today()->format('Y-m'); 

$item_info=Items::where('id', $item)->first();  
$location_info=Location::find($request->location);
 if ($item_info->quantity > 0) {
  $date = today()->format('Y-m');    

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

                return response()->json($price);                      
 
    }

    
    
    public function return($id)
    {
        //
        $data=GoodIssueItem::where('issue_id',$id)->where('due_quantity','>', '0')->get();
        $name =Items::whereIn('type', [1,3,6])->where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $inventory= Items::whereIn('type', [1,2,3])->where('bar',0)->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $returned='1';
       return view('pos.purchases.good_issue',compact('id','data','name','returned','inventory','staff'));
    }
    
     public function disposal($id)
    {
        //
        $data=GoodIssueItem::where('issue_id',$id)->where('due_quantity','>', '0')->get();
        $name =Items::whereIn('type', [1,3,6])->where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $inventory= Items::whereIn('type', [1,2,3])->where('bar',0)->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $returned='2';
       return view('pos.purchases.good_issue',compact('id','data','name','returned','inventory','staff'));
    }

 public function save_return(Request $request)
    {
        //
     $id=$request->issue_id;
     $nameArr =$request->items_id ;
     $qtyArr = $request->quantity  ;

        $purchase = GoodIssue::find($id);

        if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                
                       $saved=GoodIssueItem::find($nameArr[$i]);
    
                       $lists= array(
                        'due_quantity' =>  $saved->due_quantity-$qtyArr[$i],
                         'returned' =>  $saved->returned+$qtyArr[$i],
                               );
                           
                         $saved->update($lists); 
                         
                          $it=Items::where('id',$saved->item_id)->first();
                        $q=$it->quantity + $qtyArr[$i];
                        Items::where('id',$saved->item_id)->update(['quantity' => $q]);


                         $loc=Location::where('id', $saved->location)->first();
                         $lq['quantity']=$loc->quantity + $qtyArr[$i];
                         Location::where('id',$saved->location)->update($lq);
                         
                         

                         
                         
        if($qtyArr[$i] > 0) {    
            $d=date('Y-m-d');
            
             $mlists = [
                        'in' => $qtyArr[$i],
                        'price' => $it->cost_price,
                        'item_id' => $saved->item_id,
                        'client_id' => $purchase->client_id,
                         'staff_id' => $purchase->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $saved->location,
                        'date' =>$d,
                        'type' =>   'Returned Good Issue',
                        'other_id' =>$id,
                    ];

                    MasterHistory::create($mlists);
            
            
            //$chk=SerialList::where('brand_id',$saved->item_id)->where('location',$saved->location)->where('added_by',auth()->user()->added_by)->where('status','3')->take($qtyArr[$i])->update(['status'=> '0']) ;
                         
     
   if($it->type == '1' || $it->type == '3'){  
    $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'return_pos_inventory_issue';
  $journal->name = 'Return POS Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->debit =$it->cost_price *  $qtyArr[$i];
  $journal->branch_id= $purchase->branch_id;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes="Returned POS Inventory Issued with reference " .$purchase->name;
  $journal->save();

 
   $codes= AccountCodes::where('account_name','Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'return_pos_inventory_issue';
  $journal->name = 'Return POS Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->credit = $it->cost_price *  $qtyArr[$i];
   $journal->branch_id= $purchase->branch_id;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="Returned POS Inventory Issued with reference " .$purchase->name;
  $journal->save();
   } 

            

    if(!empty($purchase)){
              
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                          'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Issue',
                             'activity'=>"Good issue for ".$it->name . "  with reference " .$purchase->name ." is Returned",
                        ]
                        );                      
       }
       
       
        }
       
       
                    }
                    
                }
                
               //GoodIssue::where('id',$id)->update(['return' => '1']);;

    return redirect(route('pos_issue.index'))->with(['success'=>'Returned Successfully']);

            
            }    


else{

  return redirect(route('pos_issue.index'))->with(['error'=>'No data found']);


}

   

    }

  
  public function save_disposal(Request $request)
    {
        //
     $id=$request->issue_id;
     $nameArr =$request->items_id ;
     $qtyArr = $request->quantity  ;

        $purchase = GoodIssue::find($id);

        if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                
                       $saved=GoodIssueItem::find($nameArr[$i]);
                        $inv=Items::where('id',$saved->item_id)->first();
    
                       $lists= array(
                        'due_quantity' =>  $saved->due_quantity-$qtyArr[$i],
                         'disposed' =>  $saved->disposed+$qtyArr[$i],
                               );
                           
                         $saved->update($lists); 
                         
                          
       if($qtyArr[$i] > 0) {     
           //$chk=SerialList::where('brand_id',$saved->item_id)->where('location',$saved->location)->where('added_by',auth()->user()->added_by)->where('status','3')->take($qtyArr[$i])->update(['status'=> '4']) ;
           
     $d=date('Y-m-d');
     
     //$total=($inv->cost_price *  $qtyArr[$i]) + (0.3 * ($inv->cost_price *  $qtyArr[$i]));
     $total=$inv->cost_price *  $qtyArr[$i];
     /*
     
  $codes= AccountCodes::where('account_name','Disposal')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'pos_issue_disposal';
  $journal->name = 'POS Good Issue Disposal';
  $journal->income_id= $id;
  $journal->debit =$total;
   $journal->branch_id= $purchase->branch_id;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="POS Disposal Issued with reference " .$purchase->name." for item ". $inv->name;
  $journal->save();

  $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'pos_issue_disposal';
  $journal->name = 'POS Good Issue Disposal';
  $journal->income_id= $id;
  $journal->credit = $total;
 $journal->added_by=auth()->user()->added_by;
  $journal->branch_id= $purchase->branch_id;
 $journal->notes="POS Disposal Issued with reference " .$purchase->name." for item ". $inv->name;
  $journal->save();

    */      
     
    if(!empty($purchase)){
              
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                          'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Issue',
                             'activity'=>"Good issue for ".$inv->name . "  with reference " .$purchase->name ." is Disposed",
                        ]
                        );                      
       }
       
       
       }
       
                    }
                    
                }
                
               //GoodIssue::where('id',$id)->update(['return' => '1']);;

    return redirect(route('pos_issue.index'))->with(['success'=>'Disposed Successfully']);

            
            }    


else{

  return redirect(route('pos_issue.index'))->with(['error'=>'No data found']);


}

   

    }
    
    
   public function issue_pdfview(Request $request)
    {
        //
        $purchases = GoodIssue::find($request->id);
        $purchase_items = GoodIssueItem::where('issue_id', $request->id)->get();

        view()->share(['purchases' => $purchases, 'purchase_items' => $purchase_items]);

        if ($request->has('download')) {
            $pdf = PDF::loadView('pos.purchases.good_issue_pdf')->setPaper('a4', 'potrait');
            return $pdf->download('GOOD ISSUE REF NO # ' . $purchases->name . '.pdf');
        }
        return view('issue_pdfview');
    }  
   
    

public function discountModal(Request $request)
{
             $id=$request->id;
             $type = $request->type;
              if($type == 'issue'){
                $data=GoodIssueItem::where('issue_id',$id)->get();
                return view('pos.purchases.view_issue',compact('id','data'));
  }
  
   else if($type == 'returned'){
                $data=GoodIssueItem::where('issue_id',$id)->get();
                return view('pos.purchases.view_returned',compact('id','data'));
  }

             }

}
