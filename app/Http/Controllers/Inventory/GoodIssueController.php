<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\GoodIssue;
use App\Models\GoodIssueItem;
use App\Models\InventoryHistory;
use App\Models\PurchaseInventory;
use App\Models\PurchaseItemInventory;
use App\Models\Inventory;
use App\Models\InventoryList;
use App\Models\Location;
use App\Models\MasterHistory;
use App\Models\LocationManager;
use App\Models\Truck;
use App\Models\Branch;
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
       $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
        $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $inventory= InventoryList::where('status','0')->where('added_by',auth()->user()->added_by)->get();
        $staff=FieldStaff::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        //$staff=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get();
         $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('inventory.good_issue',compact('issue','inventory','location','staff','truck','bank_accounts','branch'));
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
        $data['truck_id']=$request->truck_id;
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

                   $b=InventoryList::find($nameArr[$i]);
                    $items = array(
                        'item_id' => $nameArr[$i],
                        'brand_id' => $b->brand_id,
                        'status' => 0,
                        'location' => $request->location,
                         'truck_id' => $request->truck_id,
                        'quantity' =>    $qtyArr[$i],
                        'due_quantity' =>    $qtyArr[$i],
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
        $items=GoodIssueItem::where('issue_id',$id)->get();
        $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
        $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $inventory= InventoryList::where('status','0')->where('location',$data->location)->where('added_by',auth()->user()->added_by)->get();
        $staff=FieldStaff::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        //$staff=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get();
         $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('inventory.good_issue',compact('items','inventory','location','staff','data','id','truck','bank_accounts'));
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
        $data['truck_id']=$request->truck_id;
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


                    $b=InventoryList::find($nameArr[$i]);
                    $items = array(
                        'item_id' => $nameArr[$i],
                        'brand_id' => $b->brand_id,
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
      
        $issue =  GoodIssue::find($id);

          $items= GoodIssueItem::where('issue_id',$id)->get();
          foreach($items as $i){

                   $loc=Truck::find($i->truck_id);
                  $itm=Inventory::find($i->item_id);

             
}

       GoodIssueItem::where('issue_id', $id)->delete();
        $issue->delete();

                return redirect(route('good_issue.index'))->with(['success'=>'Good Issue Deleted Successfully']);
    }

    public function approve($id){
        //

 $item=GoodIssueItem::where('issue_id',$id)->get();

foreach($item as $i){

$issue=GoodIssue::find($id);


 $inv=Inventory::where('id',$i->brand_id)->first();
 $q=$inv->quantity - $i->quantity;
Inventory::where('id',$i->brand_id)->update(['quantity' => $q]);

$loc=Location::find($i->location);
 $lq=$loc->quantity - $i->quantity;
Location::find($i->location)->update(['quantity' => $lq]);

 $mlists = [
                        'out' => $i->quantity,
                        'price' => $inv->price,
                        'item_id' => $i->brand_id,
                        'serial_id' => $i->item_id,
                         'staff_id' => $issue->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $i->location,
                        'date' =>$issue->date,
                        'type' =>   'Good Issue',
                        'other_id' =>$id,
                    ];

                    MasterHistory::create($mlists);


$lst=InventoryList::where('id',$i->item_id)->where('location',$i->location)->where('added_by',auth()->user()->added_by)->where('status','0')->first();
$chk=InventoryList::where('id',$i->item_id)->where('location',$i->location)->where('added_by',auth()->user()->added_by)->where('status','0')
->update([
    'status'=> '3',
    'truck_id' => $i->truck_id,
     'staff'=> $issue->staff_id
    ]) ; 


                 



  $d=$issue->date;
$truck=Truck::find($i->truck_id);

$codes= AccountCodes::where('account_name','Maintenance and Service')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'inventory_issue';
  $journal->name = 'Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->debit =$inv->price *  $i->quantity;
  $journal->branch_id= $issue->branch_id;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="Inventory with serial_no ".$lst->serial_no." Issued to truck ".$truck->truck_name . " - " .$truck->reg_no. " with reference " .$issue->name;
  $journal->save();

  $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'inventory_issue';
  $journal->name = 'Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->credit = $inv->price *  $i->quantity;
  $journal->branch_id= $issue->branch_id;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="Inventory with serial_no ".$lst->serial_no." Issued to truck ".$truck->truck_name . " - " .$truck->reg_no. " with reference " .$issue->name;
  $journal->save();

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
         $journal->transaction_type = 'inventory_good_issue';
          $journal->name = 'Good Issue of Inventory';
          $journal->debit = $chk->costs ;
          $journal->payment_id= $id;
          $journal->branch_id= $inv->branch_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Transportation Cost for Good Issue with reference " .$chk->name. " to Inventory with serial_no ".$lst->serial_no." Issued to truck ".$truck->truck_name . " - " .$truck->reg_no;
          $journal->save();
        
         
          $journal = new JournalEntry();
          $journal->account_id = $chk->id;
           $date = explode('-',$chk->date);
          $journal->date =   $chk->date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
       $journal->transaction_type = 'inventory_good_issue';
          $journal->name = 'Good Issue of Inventory';
          $journal->credit = $chk->costs ;
            $journal->payment_id= $id;
          $journal->added_by=auth()->user()->added_by;
          $journal->branch_id= $inv->branch_id;
          $journal->notes= "Transportation Cost for Good Issue with reference " .$chk->name. " to Inventory with serial_no ".$lst->serial_no." Issued to truck ".$truck->truck_name . " - " .$truck->reg_no;
          $journal->save();

}

GoodIssue::find($id)->update(['status' => '1']);;
GoodIssueItem::where('issue_id',$id)->update(['status' => '1']);;

       
        return redirect(route('good_issue.index'))->with(['success'=>'Good Issue Approved Successfully']);
    }


    public function findItem(Request $request)
    {
 
$item=$request->item;
$location=$request->location;
$location_info=Location::find($request->location);

$quantity=InventoryList::where('id',$request->id)->where('location',$location)->where('added_by',auth()->user()->added_by)->where('status',0)->first();  


 if (!empty($quantity)) {
$price='' ;
 }


else{
$price=$location_info->name . " Stock Balance  is Zero." ;

}



                return response()->json($price);                      
 
    }

    
    
    public function return($id)
    {
        //
        $data=GoodIssueItem::where('issue_id',$id)->where('due_quantity','>', '0')->get();
        $name =InventoryList::where('added_by',auth()->user()->added_by)->get();;
        $inventory= InventoryList::where('status','0')->where('added_by',auth()->user()->added_by)->get();
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $returned='1';
       return view('inventory.good_issue',compact('id','data','name','returned','inventory','staff'));
    }
    
     public function disposal($id)
    {
        //
        $data=GoodIssueItem::where('issue_id',$id)->where('due_quantity','>', '0')->get();
        $name =InventoryList::where('added_by',auth()->user()->added_by)->get();;
        $inventory= InventoryList::where('status','0')->where('added_by',auth()->user()->added_by)->get();
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $returned='2';
       return view('inventory.good_issue',compact('id','data','name','returned','inventory','staff'));
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
                         
                          $it=Inventory::where('id',$saved->brand_id)->first();
                        $q=$it->quantity + $qtyArr[$i];
                        Inventory::where('id',$saved->brand_id)->update(['quantity' => $q]);


                         $loc=Location::where('id', $saved->location)->first();
                         $lq['quantity']=$loc->quantity + $qtyArr[$i];
                         Location::where('id',$saved->location)->update($lq);
                         

                         
                         

                         
                         
        if($qtyArr[$i] > 0) {   
             $d=date('Y-m-d');
             
            $mlists = [
                        'in' => $qtyArr[$i],
                        'price' => $it->price,
                       'item_id' => $saved->brand_id,
                        'serial_id' => $saved->item_id,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $saved->location,
                        'date' =>$d,
                        'type' =>   'Returned Good Issue',
                        'other_id' =>$id,
                    ];

                    MasterHistory::create($mlists);  
             
            
     $lst=InventoryList::where('id',$saved->item_id)->where('location',$saved->location)->where('added_by',auth()->user()->added_by)->where('status','3')->first();                
    $chk=InventoryList::where('id',$saved->item_id)->where('location',$saved->location)->where('added_by',auth()->user()->added_by)->where('status','3')
    ->update([
    'status'=> '0',
    'truck_id' => '',
     'staff'=> ''
    ]) ; 

    
    
     $truck=Truck::find($saved->truck_id);
    $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'return_inventory_issue';
  $journal->name = 'Return Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->debit =$it->price *  $qtyArr[$i];
  $journal->branch_id= $purchase->branch_id;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes="Returned Inventory with serial_no ".$lst->serial_no." Issued to truck ".$truck->truck_name . " - " .$truck->reg_no. " with reference " .$purchase->name;
  $journal->save();

 
   $codes= AccountCodes::where('account_name','Maintenance and Service')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'return_inventory_issue';
  $journal->name = 'Return Good Issue of Inventory ';
  $journal->income_id= $id;
  $journal->credit = $it->price *  $qtyArr[$i];
   $journal->branch_id= $purchase->branch_id;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="Returned Inventory with serial_no ".$lst->serial_no." Issued to truck ".$truck->truck_name . " - " .$truck->reg_no. " with reference " .$purchase->name;
  $journal->save();
  

            

       
       
        }
       
       
                    }
                    
                }
                
               //GoodIssue::where('id',$id)->update(['return' => '1']);;

    return redirect(route('good_issue.index'))->with(['success'=>'Returned Successfully']);

            
            }    


else{

  return redirect(route('good_issue.index'))->with(['error'=>'No data found']);


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
                        $inv=Inventory::where('id',$saved->item_id)->first();
    
                       $lists= array(
                        'due_quantity' =>  $saved->due_quantity-$qtyArr[$i],
                         'disposed' =>  $saved->disposed+$qtyArr[$i],
                               );
                           
                         $saved->update($lists); 
                         
                          
       if($qtyArr[$i] > 0) {     
    $chk=InventoryList::where('id',$saved->item_id)->where('location',$saved->location)->where('added_by',auth()->user()->added_by)->where('status','3')
    ->update([
    'status'=> '4',
    'truck_id' => '',
     'staff'=> ''
    ]) ; 
           
     
     
     /*
     $d=date('Y-m-d');
     $total=($inv->cost_price *  $qtyArr[$i]) + (0.3 * ($inv->cost_price *  $qtyArr[$i]));
     $total=$inv->cost_price *  $qtyArr[$i];
     
     
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
     
  
       
       }
       
                    }
                    
                }
                
               //GoodIssue::where('id',$id)->update(['return' => '1']);;

    return redirect(route('good_issue.index'))->with(['success'=>'Disposed Successfully']);

            
            }    


else{

  return redirect(route('good_issue.index'))->with(['error'=>'No data found']);


}

   

    }
   
   


public function discountModal(Request $request)
{
             $id=$request->id;
             $type = $request->type;
              if($type == 'issue'){
                $data=GoodIssueItem::where('issue_id',$id)->get();
                return view('inventory.view_issue',compact('id','data'));
  }
  
   else if($type == 'returned'){
                $data=GoodIssueItem::where('issue_id',$id)->whereRaw('quantity != due_quantity')->get();
                return view('inventory.view_returned',compact('id','data'));
  }

             }

}
