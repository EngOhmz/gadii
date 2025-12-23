<?php

namespace App\Http\Controllers\Bar\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\FieldStaff;
use App\Models\Bar\POS\GoodIssue;
use App\Models\Bar\POS\GoodIssueItem;
use App\Models\Location;
use App\Models\Bar\POS\Items;
use App\Models\Bar\POS\Activity;
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
        $location=Location::where('added_by',auth()->user()->added_by)->where('main','0')->get();
        $inventory= Items::where('added_by',auth()->user()->added_by)->get();;
        $staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
       return view('bar.pos.purchases.good_issue',compact('issue','inventory','location','staff'));
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
        $data['date']=$request->date;
        $data['location']=$request->location;    
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
                        'quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'issue_id' =>$issue->id);

                    
                   GoodIssueItem::create($items);

                   $loc=Location::find($request->location);
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$issue->id,
                             'module'=>'Good Issue',
                            'activity'=>"Good issue for ".$itm->name . " to  " .$loc->name ." is Created",
                        ]
                        );                      
       }

    
                }
            }
           
        }    


                return redirect(route('store_pos_issue.index'))->with(['success'=>'Good Issue Created Successfully']);
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
        $location=Location::where('added_by',auth()->user()->added_by)->where('main','0')->get();
        $inventory= Items::where('added_by',auth()->user()->added_by)->get();;
        $staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
        $items=GoodIssueItem::where('issue_id',$id)->get();
       return view('bar.pos.purchases.good_issue',compact('items','inventory','location','staff','data','id'));
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
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$issue->id,
                             'module'=>'Good Issue',
                            'activity'=>"Good issue for ".$itm->name . " to  " .$loc->name ." is Updated",
                        ]
                        );                      
       }

    
                }
            }
           
        }    

                return redirect(route('store_pos_issue.index'))->with(['success'=>'Good Issue Updated Successfully']);
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
                  $itm=Items::find($i->item_id);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Issue',
                            'activity'=>"Good issue for ".$itm->name . " to  " .$loc->name ." is Deleted",
                        ]
                        );                      
       }
}

        $issue->delete();

                return redirect(route('store_good_issue.index'))->with(['success'=>'Good Issue Deleted Successfully']);
    }

    public function approve($id){
        //
 $item=GoodIssueItem::where('issue_id',$id)->get();
 $total=0;

foreach($item as $i){

$issue=GoodIssue::find($id);


 $inv=Items::where('id',$i->item_id)->first();
 $q=$inv->quantity - $i->quantity;
Items::where('id',$i->item_id)->update(['quantity' => $q]);


$loc=Location::where('id',$i->location)->first();
$lq['crate']=$loc->crate + $i->quantity;
$lq['bottle']=$loc->bottle+ ($i->quantity * $inv->bottle);
Location::where('id',$i->location)->update($lq);

$main_loc=Location::where('main','1')->first();
$main_lq['crate']=$main_loc->crate - $i->quantity;
$main_lq['bottle']=$main_loc->bottle - ($i->quantity * $inv->bottle);
Location::where('main','1')->update($main_lq);

$total+= $inv->cost_price *  $i->quantity;


 $loc=Location::find($i->location);
                  $itm=Items::find($i->item_id);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Issue',
                            'activity'=>"Good issue for ".$itm->name . " to  " .$loc->name ." is Approved",
                        ]
                        );                      
       }


}

  $d=$issue->date;

  $codes= AccountCodes::where('account_name','Counter Inventory')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'pos_inventory_issue';
  $journal->name = 'POS Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->debit =$total;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="POS Inventory Issued to " . $loc->name;
  $journal->save();

  $cr= AccountCodes::where('account_name','Store')->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'pos_inventory_issue';
  $journal->name = 'POS Good Issue of Inventory ';
  $journal->income_id= $id;
    $journal->credit = $total;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="POS Inventory Issued to " . $loc->name;
  $journal->save();

 

GoodIssue::where('id',$id)->update(['status' => '1']);;
GoodIssueItem::where('issue_id',$id)->update(['status' => '1']);;

       
        return redirect(route('store_pos_issue.index'))->with(['success'=>'Good Issue Approved Successfully']);
    }


    public function findQuantity(Request $request)
    {
 
$item=$request->item;


$item_info=Items::where('id', $item)->first();  
 if ($item_info->quantity > 0) {

if($request->id >  $item_info->quantity){
$price="You have exceeded your Stock. Choose quantity between 1.00 and ".  $item_info->quantity ;
}
else if($request->id <=  0){
$price="Choose quantity between 1.00 and ".  $item_info->quantity ;
}
else{
$price='' ;
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
              if($type == 'issue'){
                $data=GoodIssueItem::where('issue_id',$id)->get();
                return view('bar.pos.purchases.view_issue',compact('id','data'));
  }

             }

}
