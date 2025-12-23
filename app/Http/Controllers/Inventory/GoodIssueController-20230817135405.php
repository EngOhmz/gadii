<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\GoodIssue;
use App\Models\GoodIssueItem;
use App\Models\PurchaseInventory;
use App\Models\PurchaseItemInventory;
use App\Models\Inventory;
use App\Models\InventoryList;
use App\Models\Location;
use App\Models\Maintainance;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\AccountCodes;
use App\Models\JournalEntry;

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
        $location=Location::where('added_by',auth()->user()->added_by)->get();
        $inventory=InventoryList::where('status','0')->orwhere('status','2')->where('added_by',auth()->user()->added_by)->get();
        $issue= GoodIssue::where('added_by',auth()->user()->added_by)->get();
       return view('inventory.good_issue',compact('issue','inventory','location'));
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
        $data['type']=$request->type;
        $data['type_id']=$request->type_id;

        if($request->type == 'Service'){
         $service= Service::where('id',$request->type_id)->first();
          $data['staff']=$service->mechanical;
       $list['truck_id']=$service->truck;
        }
        else if($request->type == 'Maintenance'){
            $maintain=Maintainance::where('id',$request->type_id)->first();
             $data['staff']= $maintain->mechanical;
             $list['truck_id']=$maintain->truck;
           }

        $data['added_by']= auth()->user()->added_by;

        $issue = GoodIssue::create($data);
        
       

        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'item_id' => $nameArr[$i],
                        'quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'issue_id' =>$issue->id);

                        GoodIssueItem::create($items);  
    
                }
            }
           
        }    

        return redirect(route('good_issue.index'))->with(['success'=>'Good Issue Created Successfully']);
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
        $inventory=InventoryList::where('status','0')->orwhere('status','2')->where('added_by',auth()->user()->added_by)->get();
        $items=GoodIssueItem::where('issue_id',$id)->get();
       return view('inventory.good_issue',compact('items','inventory','location','data','id'));
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
        $data['type']=$request->type;
        $data['type_id']=$request->type_id;

        if($request->type == 'Service'){
         $service= Service::where('id',$request->type_id)->first();
          $data['staff']=$service->mechanical;
         $list['truck_id']=$service->truck;
        }
        else if($request->type == 'Maintenance'){
            $maintain=Maintainance::where('id',$request->type_id)->first();
             $data['staff']= $maintain->mechanical;
          $list['truck_id']=$maintain->truck;
           }

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
                        'quantity' => $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'issue_id' =>$id);
                       
                    
                   
                            if(!empty($expArr[$i])){
                                GoodIssueItem::where('id',$expArr[$i])->update($items);                              
                             }
                          else{
                         GoodIssueItem::create($items);  
                       
                          }                         
                     
    
                }
            }
           
        }    




        return redirect(route('good_issue.index'))->with(['success'=>'Good Issue Updated Successfully']);
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
        $issue->delete();

        return redirect(route('good_issue.index'))->with(['success'=>'Good Issue Deleted Successfully']);
    }

 public function approve($id){
        //
 $item=GoodIssueItem::where('issue_id',$id)->get();
foreach($item as $i){

$issue=GoodIssue::find($id);
if($issue->type == 'Service'){
$service= Service::where('id',$issue->type_id)->first();
 $list['truck_id']=$service->truck;
}
elseif($issue->type == 'Maintenance'){
$maintain=Maintainance::where('id',$issue->type_id)->first();
 $list['truck_id']=$maintain->truck;
}

 $a=InventoryList::where('id',$i->item_id)->first();                       
 $list['status']='1';
 $a->update($list);

 $inv=Inventory::where('id',$a->brand_id)->first();
 $q=$inv->quantity - 1;
Inventory::where('id',$a->brand_id)->update(['quantity' => $q]);

if(!empty($a->purchase_id)){
   $tt=PurchaseItemInventory::where('purchase_id', $a->purchase_id)->where('item_name', $a->brand_id)->first();
   $p=PurchaseInventory::find($a->purchase_id);
   $total=$tt->price *  $p->exchange_rate;
}
else if(empty($a->purchase_id)){
   $total= $inv->price;
}

$truck= $list['truck_id'];
  $d=date('Y-m-d');
   $t=Truck::find($truck);

  $codes= AccountCodes::where('account_name','Maintenance and Repair')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'good_issue_inventory';
  $journal->name = ' Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->debit =$total;
    $journal->truck_id= $truck;
 $journal->added_by=auth()->user()->added_by;
      $journal->notes="Inventory " . $a->serial_no. " Issued to " . $t->truck_name. " - " . $t->reg_no;
  $journal->save();

  $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'good_issue_inventory';
  $journal->name = ' Good Issue of Inventory ';
  $journal->income_id= $id;
    $journal->credit = $total;
  $journal->truck_id= $truck;
 $journal->added_by=auth()->user()->added_by;
      $journal->notes="Inventory " . $a->serial_no. " Issued to " . $t->truck_name. " - " . $t->reg_no;
  $journal->save();

 }

GoodIssue::where('id',$id)->update(['status' => '1']);;

  
        return redirect(route('good_issue.index'))->with(['success'=>'Good Issue Approved Successfully']);
    }


    public function findService(Request $request)
    {

 switch ($request->id) {
        case 'Service':
              $type_id= Service::where('status','1')->where('added_by',auth()->user()->added_by)->orderBy('id', 'DESC')->groupBy('truck')->get(); 
            //$type_id= Service::all();                                                                                     
               return response()->json($type_id);
                      
            break;

       case 'Maintenance':
           $type_id= Maintainance::where('status','1')->where('added_by',auth()->user()->added_by)->orderBy('id', 'DESC')->groupBy('truck')->get(); 
           //$type_id= Maintainance::all(); 
      
                return response()->json($type_id);
                      
            break;

    

    }

}
    


}
