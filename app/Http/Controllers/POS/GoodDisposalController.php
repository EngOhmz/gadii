<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\POS\GoodDisposal;
use App\Models\POS\GoodDisposalItem;
use App\Models\POS\GoodIssue;
use App\Models\POS\GoodIssueItem;
use App\Models\POS\StockMovement;
use App\Models\POS\StockMovementItem;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\MasterHistory;
use App\Models\POS\SerialList;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Truck;
use App\Models\POS\Items;
use App\Models\POS\Activity;
use App\Models\Branch;
use Illuminate\Http\Request;
use DB;

class GoodDisposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $issue= GoodDisposal::where('added_by',auth()->user()->added_by)->get();;
       $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         //$location= LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $inventory= Items::whereIn('type', [1,2,3])->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
        $staff=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get();
        $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('pos.purchases.good_disposal',compact('issue','inventory','location','staff','truck','bank_accounts','branch'));
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
        
         $count=GoodDisposal::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $dt=date('m/d', strtotime($request->date));
        $x=Location::find($request->location);
        
        $words = preg_split("/\s+/", $x->name);
        $acronym = "";
        
        foreach ($words as $w) {
          $acronym .= mb_substr($w, 0, 1);
        }
        $a=strtoupper($acronym);
        
        $data['date']=$request->date;
        $data['location']=$request->location;    
        $data['staff']=$request->staff;
        $data['staff_id']=$request->staff;
        $data['name']=$a.'/'.$dt.'/00'.$pro;
        $data['status']= 0;
        $data['branch_id']=$request->branch_id;
        $data['costs']=$request->costs;
        $data['description']=$request->description;
        $data['account_id']=$request->account_id;
        $data['user_id']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $issue = GoodDisposal::create($data);
        
       

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
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'disposal_id' =>$issue->id);

                    
                   GoodDisposalItem::create($items);

                  
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$issue->id,
                             'module'=>'Good Disposal',
                            'activity'=>"Good Disposal for ".$itm->name . " with reference " .$issue->name ." is Created",
                        ]
                        );                      
       }

    
                }
            }
           
        }    


                return redirect(route('disposal.index'))->with(['success'=>'Good Disposal Created Successfully']);
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
        $data=GoodDisposal::find($id);
        $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         //$location=LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $inventory= Items::whereIn('type', [1,2,3])->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
         $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
       //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $items=GoodDisposalItem::where('disposal_id',$id)->get();
$bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get();
       return view('pos.purchases.good_disposal',compact('items','inventory','location','staff','data','id','truck','bank_accounts'));
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

        $issue=GoodDisposal::find($id);

        $data['date']=$request->date;
        $data['location']=$request->location;    
        $data['staff']=$request->staff;
        $data['staff_id']=$request->staff;
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
               GoodDisposalItem::where('id',$remArr[$i])->delete();   
                            
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
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'disposal_id' =>$id);
                       
                    
                   
                            if(!empty($expArr[$i])){
                                GoodDisposalItem::where('id',$expArr[$i])->update($items);                              
                             }
                          else{
                         GoodDisposalItem::create($items);  
                       
                          }                         
                     
                   
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Disposal',
                            'activity'=>"Good Disposal for ".$itm->name . "  with reference " .$issue->name ." is Updated",
                        ]
                        );                      
       }

    
                }
            }
           
        }    

                return redirect(route('disposal.index'))->with(['success'=>'Good Disposal Updated Successfully']);
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
      
        $issue =  GoodDisposal::find($id);

          $items= GoodDisposalItem::where('disposal_id',$id)->get();
          foreach($items as $i){

                   $loc=Truck::find($i->truck_id);
                  $itm=Items::find($i->item_id);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                               'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Disposal',
                             'activity'=>"Good Disposal for ".$itm->name ."  with reference " .$issue->name ." is Deleted",
                        ]
                        );                      
       }
}

       GoodDisposalItem::where('disposal_id', $id)->delete();
        $issue->delete();

                return redirect(route('disposal.index'))->with(['success'=>'Good Disposal Deleted Successfully']);
    }

    public function approve($id){
        //

 $item=GoodDisposalItem::where('disposal_id',$id)->get();

foreach($item as $i){

$issue=GoodDisposal::find($id);


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
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $i->location,
                        'date' =>$issue->date,
                        'type' =>   'Good Disposal',
                        'other_id' =>$id,
                    ];

                    MasterHistory::create($mlists);

//$chk=SerialList::where('brand_id',$i->item_id)->where('location',$i->location)->where('added_by',auth()->user()->added_by)->where('status','0')->take($i->quantity)->update(['status'=> '4','crate_status'=>$status]) ; 


                  $itm=Items::find($i->item_id);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                          'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Disposal',
                             'activity'=>"Good Disposal for ".$itm->name . "  with reference " .$issue->name ." is Approved",
                        ]
                        );                      
       }




  $d=$issue->date;

$codes= AccountCodes::where('account_name','Disposal')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'pos_disposal';
  $journal->name = 'POS Good Disposal ';
  $journal->income_id= $id;
  $journal->debit =$inv->cost_price *  $i->quantity;
  $journal->branch_id= $inv->branch_id;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="POS Disposal Issued with reference " .$issue->name;
  $journal->save();

  $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'pos_disposal';
  $journal->name = 'POS Good Disposal ';
  $journal->income_id= $id;
  $journal->credit = $inv->cost_price *  $i->quantity;
  $journal->branch_id= $inv->branch_id;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="POS Disposal Issued with reference " .$issue->name;
  $journal->save();

} 




GoodDisposal::where('id',$id)->update(['status' => '1']);;
GoodDisposalItem::where('disposal_id',$id)->update(['status' => '1']);;

       
        return redirect(route('disposal.index'))->with(['success'=>'Good Disposal Approved Successfully']);
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
     

$quantity=SerialList::where('brand_id',$item)->where('location',$location)->where('added_by',auth()->user()->added_by)->where('status',0)->sum('quantity');  
 



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

    public function findService(Request $request)
    {

 switch ($request->id) {
        case 'Service':
              $type_id= Service::where('status','=','0')->get();                                                                                    
               return response()->json($type_id);
                      
            break;

       case 'Maintenance':
           $type_id= Maintainance::where('status','=','0')->get(); 
                return response()->json($type_id);
                      
            break;

    

    }

}
    

public function discountModal(Request $request)
{
             $id=$request->id;
             $type = $request->type;
              if($type == 'disposal'){
                $data=GoodDisposalItem::where('disposal_id',$id)->get();
                return view('pos.purchases.view_disposal',compact('id','data'));
  }

             }

}
