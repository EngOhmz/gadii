<?php

namespace App\Http\Controllers\Restaurant\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\Restaurant\POS\PurchaseHistory;
use App\Models\Restaurant\POS\InvoiceHistory;
use App\Models\Restaurant\POS\GoodIssue;
use App\Models\Restaurant\POS\GoodIssueItem;
use App\Models\Location;
use App\Models\Restaurant\POS\Items;
use App\Models\Restaurant\POS\Activity;
use Illuminate\Http\Request;

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
        $location=Location::where('added_by',auth()->user()->added_by)->get();
        $inventory= Items::where('added_by',auth()->user()->added_by)->get();;
        $staff=User::where('added_by',auth()->user()->added_by)->get();;
        //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
       return view('restaurant.pos.purchases.good_issue',compact('issue','inventory','location','staff'));
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
 if($request->location == $request->start){
       return redirect(route('restaurant_pos_issue.index'))->with(['error'=>'You have Chosen the same Location']);

}


else{
        $data['date']=$request->date;
        $data['location']=$request->location;
        $data['start']=$request->start;    
        $data['staff']=$request->staff;
        $data['status']= 0;
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
                       'start' => $request->start,
                        'quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'issue_id' =>$issue->id);

                    
                   GoodIssueItem::create($items);

                   $loc=Location::find($request->location);
                  $st_loc=Location::find($request->start);
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
 'user_id'=>auth()->user()->id,
                            'module_id'=>$issue->id,
                             'module'=>'Good Issue',
                            'activity'=>"Good issue for ".$itm->name . " from ". $st_loc->name ."  to  " .$loc->name ." is Created",
                        ]
                        );                      
       }

    
                }
            }
           
        }    


         return redirect(route('restaurant_pos_issue.index'))->with(['success'=>'Good Issue Created Successfully']);

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
        $data=GoodIssue::find($id);
        $location=Location::where('added_by',auth()->user()->added_by)->get();
        $inventory= Items::where('added_by',auth()->user()->added_by)->get();;
       $staff=User::where('added_by',auth()->user()->added_by)->get();;
        //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
        $items=GoodIssueItem::where('issue_id',$id)->get();
       return view('restaurant.pos.purchases.good_issue',compact('items','inventory','location','staff','data','id'));
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


    if($request->location == $request->start){
       return redirect(route('restaurant_pos_issue.index'))->with(['error'=>'You have Chosen the same Location']);

}


else{
        $issue=GoodIssue::find($id);

        $data['date']=$request->date;
        $data['location']=$request->location;
          $data['start']=$request->start;       
        $data['staff']=$request->staff;
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
                     'start' => $request->start,
                        'quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'issue_id' =>$id);
                       
                    
                   
                            if(!empty($expArr[$i])){
                                GoodIssueItem::where('id',$expArr[$i])->update($items);                              
                             }
                          else{
                         GoodIssueItem::create($items);  
                       
                          }                         
                     
                 $loc=Location::find($request->location);
                  $st_loc=Location::find($request->start);
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
 'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Issue',
                            'activity'=>"Good issue for ".$itm->name . " from ". $st_loc->name ."  to  " .$loc->name ." is Updated",
                        ]
                        );                      
       }

    
                }
            }
           
        }    

         return redirect(route('restaurant_pos_issue.index'))->with(['success'=>'Good Issue Updated Successfully']);
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
GoodIssueItem::where('issue_id', $id)->delete();

        $issue =  GoodIssue::find($id);

          $items= GoodIssueItem::where('issue_id',$id)->get();
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
                             'module'=>'Good Issue',
                             'activity'=>"Good issue for ".$itm->name . " from ". $st_loc->name ."  to  " .$loc->name ." is Deleted",
                        ]
                        );                      
       }
}

        $issue->delete();

                return redirect(route('restaurant_good_issue.index'))->with(['success'=>'Good Issue Deleted Successfully']);
    }

    public function approve($id){
        //
 $item=GoodIssueItem::where('issue_id',$id)->get();
 $total=0;

foreach($item as $i){

$issue=GoodIssue::find($id);

 $inv=Items::where('id',$i->item_id)->first();

$loc=Location::where('id',$i->location)->first();

$lq['bar_crate']=$loc->bar_crate + $i->quantity;
$lq['bar_bottle']=$loc->bar_bottle+ ($i->quantity * $inv->bottle);
Location::where('id',$i->location)->update($lq);

$main_loc=Location::where('id',$i->start)->first();
$main_lq['bar_crate']=$main_loc->bar_crate - $i->quantity;
$main_lq['bar_bottle']=$main_loc->bar_bottle - ($i->quantity * $inv->bottle);
Location::where('id',$i->start)->update($main_lq);

$total+= $inv->cost_price *  $i->quantity;


 $loc=Location::find($i->location);
  $st_loc=Location::find($i->start);
                  $itm=Items::find($i->item_id);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
 'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Issue',
                             'activity'=>"Good issue for ".$itm->name . " from ". $st_loc->name ."  to  " .$loc->name ." is Approved",
                        ]
                        );                      
       }


}

  $d=$issue->date;

   $codes= AccountCodes::where('account_name','Counter Restaurant Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'restaurant_pos_inventory_issue';
  $journal->name = 'Restaurant POS Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->debit =$total;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="Restaurant POS Inventory Issued from " . $st_loc->name ."  to  " .$loc->name;
  $journal->save();

   $cr= AccountCodes::where('account_name','Restaurant Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'restaurant_pos_inventory_issue';
  $journal->name = 'Restaurant POS Good Issue of Inventory ';
  $journal->income_id= $id;
    $journal->credit = $total;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="Restaurant POS Inventory Issued from " . $st_loc->name ."  to  " .$loc->name;
  $journal->save();

 

GoodIssue::where('id',$id)->update(['status' => '1']);;
GoodIssueItem::where('issue_id',$id)->update(['status' => '1']);;

       
        return redirect(route('restaurant_pos_issue.index'))->with(['success'=>'Good Issue Approved Successfully']);
    }


    public function findQuantity(Request $request)
    {
 
$item=$request->item;
$location=$request->location;

$item_info=Items::where('id', $item)->first();  
$location_info=Location::find($request->location);

 if ($item_info->quantity > 0) {

$due=PurchaseHistory::where('item_id',$item)->where('location',$location)->where('type', 'Purchases')->where('added_by',auth()->user()->added_by)->sum('quantity');
$return=PurchaseHistory::where('item_id',$item)->where('location',$location)->where('type', 'Debit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');    
                                                      
$rgood=GoodIssueItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');
$good=GoodIssueItem::where('item_id',$item)->where('start',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');

$sqty= InvoiceHistory::where('item_id', $item)->where('location',$location)->where('type', 'Sales')->where('added_by',auth()->user()->added_by)->sum('quantity'); 
 $cn= InvoiceHistory::where('item_id', $item)->where('location',$location)->where('type', 'Credit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');

$qty=$due-$return;
$inv=$sqty-$cn ;
$cr=$inv/$item_info->bottle;
$cq=round($cr, 1);

$b=($qty + $rgood) - $good - $cq;
$balance=floor($b);

 if ($balance > 0) {

if($request->id >  $balance){
$price="You have exceeded your Stock. Choose quantity between 1.00 and ".  number_format($balance,2) ;
}
else if($request->id <=  0){
$price="Choose quantity between 1.00 and ".  number_format($balance,2) ;
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
                $data=GoodIssueItem::where('issue_id',$id)->get();
                return view('restaurant.pos.purchases.view_issue',compact('id','data'));
  }

             }

}
