<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\GoodMovement;
use App\Models\GoodMovementItem;
use App\Models\GoodReallocation;
use App\Models\GoodReallocationItem;
use App\Models\GoodDisposalItem;
use App\Models\InventoryList;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\MasterHistory;
use App\Models\Truck;
use App\Models\POS\Items;
use App\Models\Branch;
use Illuminate\Http\Request;
use PDF;

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
        $issue= GoodMovement::where('added_by',auth()->user()->added_by)->get();;
        $location=Location::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $source= Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
        $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $inventory= InventoryList::where('status','0')->where('added_by',auth()->user()->added_by)->get();
        //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
        $staff=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get();
        $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('inventory.good_movement',compact('issue','inventory','location','staff','truck','bank_accounts','branch','source'));
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
       return redirect(route('good_movement.index'))->with(['error'=>'You have Chosen the same Location']);

}


else{
    
         $count=GoodMovement::where('added_by', auth()->user()->added_by)->count();
            $pro=$count+1;
            $dt=date('m/d', strtotime($request->date));
            $x=Location::find($request->start);
            
            $words = preg_split("/\s+/", $x->name);
            $acronym = "";
            
            foreach ($words as $w) {
              $acronym .= mb_substr($w, 0, 1);
            }
            $a=strtoupper($acronym);
        
        $data['movement_date']=$request->date;
        $data['destination_store']=$request->location;
        $data['source_store']=$request->start;    
        $data['staff']=$request->staff;
        $data['name']=$a.'/'.$dt.'/00'.$pro;
        $data['costs']=$request->costs;
        $data['branch_id']=$request->branch_id;
        $data['account_id']=$request->account_id;
        $data['description']=$request->description;
        $data['status']= 0;
         $data['user_id']= auth()->user()->added_by;
        $data['added_by']= auth()->user()->added_by;

        $issue = GoodMovement::create($data);
        
       

        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;

       $total=0;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                     $b=InventoryList::find($nameArr[$i]);
                    $items = array(
                        'item_id' => $nameArr[$i],
                         'brand_id' => $b->brand_id,
                        'status' => 0,
                        'destination_store' =>$request->location,
                        'source_store' => $request->start,   
                        'quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'movement_id' =>$issue->id);

                    
                   GoodMovementItem::create($items);

                    $total+= $qtyArr[$i];

               

    
                }
            }

        GoodMovement::find($issue->id)->update(['quantity' => $total]);
           
        }    


                return redirect(route('good_movement.index'))->with(['success'=>'  Created Successfully']);
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
        $data=GoodMovement::find($id);
        $location=Location::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $source= Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
        $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $inventory= InventoryList::where('status','0')->where('location',$data->source_store)->where('added_by',auth()->user()->added_by)->get();
        //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
        $staff=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $items=GoodMovementItem::where('movement_id',$id)->get();
         $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get();
       return view('inventory.good_movement',compact('items','inventory','location','staff','data','id','truck','bank_accounts','source'));
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
   return redirect(route('good_movement.index'))->with(['error'=>'You have Chosen the same Location']);

}


else{
        $issue=GoodMovement::find($id);

     $data['movement_date']=$request->date;
   $data['destination_store']=$request->location;
    $data['source_store']=$request->start;    
    $data['staff']=$request->staff;
  
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
              GoodMovementItem::where('id',$remArr[$i])->delete();   
                            
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
                    'status' => 0,
                    'destination_store' =>$request->location,
                    'source_store' => $request->start,   
                    'quantity' =>    $qtyArr[$i],
                       'order_no' => $i,
                       'added_by' => auth()->user()->added_by,
                    'movement_id' =>$id);
                       
                    
                   
                            if(!empty($expArr[$i])){
                               GoodMovementItem::where('id',$expArr[$i])->update($items);                              
                             }
                          else{
                        GoodMovementItem::create($items);  
                       
                          }                         
                     
                  $total+= $qtyArr[$i];
                   
                   

    
                }
            }

                      GoodMovement::find($id)->update(['quantity' => $total]);           
        }    

                return redirect(route('good_movement.index'))->with(['success'=>' Updated Successfully']);
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
        $issue =   GoodMovement::find($id);
          

       GoodMovementItem::where('movement_id',$id)->delete();
        $issue->delete();

               return redirect(route('good_movement.index'))->with(['success'=>'  Deleted Successfully']);
    }

    public function approve($id){
        //

 $item=GoodMovementItem::where('movement_id',$id)->get();

foreach($item as $i){

 $inv=Inventory::where('id',$i->brand_id)->first();
$issue=GoodMovement::find($id);

$sloc=Location::find($i->source_store);
$sq['quantity']=$sloc->quantity - $i->quantity;
$sloc->update($sq);

$dloc=Location::find($i->destination_store);
$dq['quantity']=$dloc->quantity + $i->quantity;
$dloc->update($dq);


$slists = [
                        'out' => $i->quantity,
                        'price' => $inv->price,
                        'serial_id' => $i->item_id,
                        'item_id' => $i->brand_id,
                         'staff_id' => $issue->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $i->source_store,
                        'date' =>$issue->movement_date,
                        'type' =>   'Stock Movement',
                        'other_id' =>$id,
                    ];

                    MasterHistory::create($slists);
                    
                    
                    $dlists = [
                        'in' => $i->quantity,
                        'price' => $inv->price,
                        'serial_id' => $i->item_id,
                        'item_id' => $i->brand_id,
                         'staff_id' => $issue->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $i->destination_store,
                        'date' =>$issue->movement_date,
                        'type' =>   'Stock Movement',
                        'other_id' =>$id,
                    ];

                    MasterHistory::create($dlists);


InventoryList::where('id',$i->item_id)->where('location',$i->source_store)->where('added_by',auth()->user()->added_by)->where('status','0')->update(['location'=> $i->destination_store]) ; 


} 


$chk= GoodMovement::find($id);
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
         $journal->transaction_type = 'good_movement';
          $journal->name = 'Good Movement';
          $journal->debit = $chk->costs ;
          $journal->payment_id= $id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Transportation Cost for Good Movement from " .$ss->name ."  to  " .$ds->name  ;
          $journal->save();
        
         
          $journal = new JournalEntry();
          $journal->account_id = $chk->id;
           $date = explode('-',$chk->movement_date);
          $journal->date =   $chk->movement_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
       $journal->transaction_type = 'good_movement';
          $journal->name = 'Good Movement';
          $journal->credit = $chk->costs ;
            $journal->payment_id= $id;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Transportation Cost for Good Movement from " .$ss->name ."  to  " .$ds->name  ;
          $journal->save();

}



 GoodMovement::where('id',$id)->update(['status' => '1']);;
 GoodMovementItem::where('movement_id',$id)->update(['status' => '1']);;

       
        return redirect(route('good_movement.index'))->with(['success'=>'Good Movement Approved Successfully']);
    }


    public function findQuantity(Request $request)
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

  

public function discountModal(Request $request)
{
             $id=$request->id;
             $type = $request->type;
              if($type == 'issue'){
                $data=GoodMovementItem::where('movement_id',$id)->get();
                return view('inventory.view_movement',compact('id','data'));
  }
  else if($type == 'reallocation'){
                $data=GoodReallocationItem::where('movement_id',$id)->get();
                return view('inventory.view_reallocation',compact('id','data'));
  }
  
  else if($type == 'disposal'){
                $data=GoodDisposalItem::where('disposal_id',$id)->get();
                return view('inventory.view_disposal',compact('id','data'));
  }

             }
             
             
             
    
             
             

}
