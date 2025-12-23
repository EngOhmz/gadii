<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\WorkOrder;
use App\Models\Manufacturing\WorkOrderItems;
use App\Models\Manufacturing\Issue;
use App\Models\Manufacturing\ExciseDuty;

use  App\Models\POS\Items;
use App\Models\Location;
use Carbon\Carbon;
use App\Models\AccountCodes;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\JournalEntry;
use App\Models\POS\PurchaseHistory;
use App\Models\Branch;
use App\Models\Manufacturing\BillOfMaterial;
use App\Models\Manufacturing\BillOfMaterialInventory;

use App\Models\User;
use App\Models\Manufacturing\WorkOrderProductionActivity;

use Illuminate\Http\Request;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
           $users = User::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
           
           $locations= Location::all()->whereIn('type', [3])->where('disabled','0')->where('added_by', auth()->user()->added_by);
           
        //   $locations = Location::all()->where('disabled','0')->whereNull('shopkeeper_id');
           
        //   $userNoStore = User::all()->where('disabled','0')->whereNull('store_id');
        $distributors = [];
        
        $distributorsNoStore = [];
           
           foreach($users as $row){
               $userRole =  User_Roles::where('user_id',$row->id)->first();
               if($userRole == 91){
                   
                   $data = $row;
                   
                   if(!empty($row->store_id)){
                       
                    $dat = Location::find($row->store_id);
                    
                            if(!empty($dat)){
                                $data['store_name'] = $dat->name;
                            }
                            else{
                                $data['store_name'] = null;
                            }
                        $distributors[] = $data;
                    }
                    else{
                        
                        $data['store_name'] = null;
                        
                        $distributorsNoStore[] = $data;
                    }
                   
                   
               }
           }
        return view('distributor.index',compact('distributors','distributorsNoStore','locations'));
    }
    
    
    
    public function findDistributorModal(Request $request)
    {
                 $id=$request->id;
                 
                 $user = User::find($id);
                 
                 $locations = Location::all()->where('type',3)->where('disabled','0');
                 
                 
                return view('distributor.modal',compact('id', 'user', 'locations'));

    }
    
    public function finish(Request $request,$id){
        
        $user =  User::find($id);
        
        $data2['store_id']=$request->store_id;
        $user->update($data2);
        
        $loc = Location::find($request->store_id);
        $xy = ",";
        
        $assigned = $loc->assigned_to.''.$xy.''.$id;
        
        $trans_id= $assigned;
        
        $data['assigned_to'] = implode("," ,$trans_id);;
        
        $loc->update($data);


// if(!empty($trans_id)){

//  Assignment::where('project_id',$id)->delete();

//     for($i = 0; $i < count($trans_id); $i++){
//   if(!empty($trans_id[$i])){

//         $data['project_id'] = $id;
//          $data['user_id'] = $trans_id[$i];
//          $data['added_by'] = auth()->user()->added_by;
//          Assignment::create($data);

// }                            

//  }
         
//     }
      

  
        return redirect(route('distributor.index'))->with(['success'=>'Store Updated Successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $work_order= WorkOrder::all()->where('added_by', auth()->user()->added_by);
        
        $location = Location::all()->where('type',4)->where('added_by', auth()->user()->added_by);
        $item = Items::all()->where('type',2)->where('disabled','0')->where('added_by', auth()->user()->added_by);
        
        $users = User::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
      
        return view('manufacturing.work_order_details',compact('work_order','item','location', 'users', 'billofmaterials'));
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
            $trans_id= $request->trans_id;
        
        $cat_id = $request->category_id;
        
        $data['category_id'] = implode("," ,$cat_id);;

        $data['added_by'] = auth()->user()->added_by;
      $data['assigned_to'] = implode("," ,$trans_id);;
        
        $project = Location::create($data);

   if(!empty($trans_id)){
    for($i = 0; $i < count($trans_id); $i++){
   if(!empty($trans_id[$i])){


        $data['project_id'] = $project->id;
         $data['user_id'] = $trans_id[$i];
         $data['added_by'] = auth()->user()->added_by;
         Assignment::create($data);


}                            

 }
         
    }
 
        return redirect(route('work_order.index'))->with(['success'=>'Work Order Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
   {
        $location = Location::all()->where('type',4)->where('added_by', auth()->user()->added_by);
        $work_centre = Location::all()->where('type',1)->where('added_by', auth()->user()->added_by);
       switch ($request->type) {
        case 'show':
               
                return view('manufacturing.issue',compact('id','location','work_centre'));
                break;
         default:
         return abort(404);
         
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
        $data =  WorkOrder::find($id);

           $billofmaterials = BillOfMaterial::all()->where('added_by', auth()->user()->added_by);        
        $locationWs = Location::all()->where('type',1)->where('added_by', auth()->user()->added_by);        
        $locationFs = Location::all()->where('type',2)->where('added_by', auth()->user()->added_by);        
        $locations = Location::all()->where('type',3)->where('added_by', auth()->user()->added_by);
          $items = Items::all()->where('type',2)->where('disabled','0')->where('added_by', auth()->user()->added_by);
           $users = User::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
      $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);

        return view('manufacturing.work_order',compact('data','id','items','locationWs', 'locationFs', 'locations', 'users', 'billofmaterials','branch'));
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
        $work_order =  WorkOrder::find($id);
        // $data=$request->post();
               $trans_id= $request->trans_id;

        $data = $request->all();
        $data['added_by'] = auth()->user()->added_by;
        $data['assigned_to'] = implode("," ,$trans_id);;
        
        $cat_id = $request->category_id;
        
        $data['category_id'] = implode("," ,$cat_id);;
        
        $project->update($data);


if(!empty($trans_id)){

 Assignment::where('project_id',$id)->delete();

    for($i = 0; $i < count($trans_id); $i++){
   if(!empty($trans_id[$i])){

        $data['project_id'] = $id;
         $data['user_id'] = $trans_id[$i];
         $data['added_by'] = auth()->user()->added_by;
         Assignment::create($data);

}                            

 }
         
    }
 
        return redirect(route('work_order.index'))->with(['success'=>'Work Order Updated Successfully']);
    }
    
    
    public function findbillProduct(Request $request)
    {

        $district= SchoolLevel::where('level',$request->id)->get();                                                                                    
               return response()->json($district);

    }

    public function approve($id)
    {
        //
        $purchase = WorkOrder::find($id);
        $data['status'] = 1;
        $purchase->update($data);
        return redirect(route('work_order.index'))->with(['success'=>'Approved Successfully']);
    }
    
    public function work_order_details($id)
    {
        //
        $purchase = WorkOrder::find($id);
                 
        $inv_items   = BillOfMaterialInventory::where('bill_of_material_id', $purchase->product)->where('added_by', auth()->user()->added_by)->get();
                 
        $type = $request->type;
        
        return view('manufacturing.produce',compact('id', 'inv_items', 'purchase'));
    }
    
    
    // $temp_sum = array_sum($temp);

                    
                    // $dt2 = Location::find($purchase->location_id);
                    
                    // if($dt2->quantity >= $temp_sum){
                        
                    //         $dataR['status'] = 2;
        
                    //         $purchase->update($dataR);
                        
                    //         $diff=$dt2->quantity - $temp_sum;
                            
                    //         //update quantity on inventory store after release 
                    //         $lctr = Location::where('id',$purchase->location_id)->update(['quantity' => $diff]);
                       
                    //         $dt3 = Location::find($purchase->work_center);
                            
                    //         $data22 =$dt3->quantity + $temp_sum;
                            
                    //         //update quantity on work center store after release
                    //         Location::where('id',$purchase->work_center)->update(['quantity' => $data22]);
                    
                       
                    //      return redirect(route('work_order.index'))->with(['success'=>'Released Successfully']);
                        
                    // }
                    
                    // else{
                    //     return redirect(route('work_order.index'))->with(['error'=>'Inventory Store Quanttity is low']);
                    // }
    
    public function release($id)
    {
        //
        $purchase = WorkOrder::find($id);
        if(!empty($purchase)){
            
            
            $inv_items   = BillOfMaterialInventory::where('bill_of_material_id', $purchase->product)->where('added_by', auth()->user()->added_by)->get();

            $total_qty=0;
            if($inv_items->isNotEmpty()){
                
                foreach($inv_items as $row){
                    
                    $data['id'] = $row->items_id;

                    $data['quantity_wk'] = $row->quantity * $purchase->quantity;
                       $total_qty += $row->quantity * $purchase->quantity;
                    
                    
                    $dt2 = Items::find($row->items_id);
                    
                    if($dt2->quantity >= $data['quantity_wk']){
                         
                            $temp[] = $data;
                    
                        
                    }
                    
                    /*
                    else{
                        return redirect(route('work_order.index'))->with(['error'=>'Inventory Store Quanttity is low']);
                    }
                    */
                    
                    
         
                }

                //dd($total_qty);

                $temp_quantity = $total_qty;
                      $pur_items['release_quantity']= $temp_quantity;
                        $pur_items['due_quantity']= $purchase->quantity;
                $purchase->update($pur_items);
                
                foreach($temp as $row2){

                
                    $dt3 = Items::find($row2['id']);
                    
                    $diff=$dt3->quantity - $row2['quantity_wk'];
                            
                    //1. update quantity on inventory store after release 
                    
                    //1.1 updating value on inventory items
                    $dt3->update(['quantity' => $diff]);
                    
                    //1.2 reduce value on inventory store location
                    
                    $dt31 = Location::find($purchase->location_id);
                            
                    $data221 =$dt31->quantity - $row2['quantity_wk'];
                            
                    
                    $dt31->update(['quantity' => $data221]);
                    
                    
                    //2. increase value on work center store location
                    
                    $dt3W = Location::find($purchase->work_center);
                            
                    $data22W =$dt3W->quantity +  $row2['quantity_wk'];
                            
                    $dt3W->update(['quantity' => $data22W]);
                    
                    // -------------------***inventory adding ***-------------------------
                        $items23 = array(
                                'name' => $dt3->name,
                                'type' =>   3,
                                'cost_price' => $dt3->cost_price,
                                'sales_price' =>  $dt3->sales_price,
                                'unit' =>$dt3->unit,
                                'quantity' =>  $row2['quantity_wk'],
                                'description' =>  $dt3->description,
                            'added_by' => $dt3->added_by);

                        Items::create($items23);;
                    
                    
                    
                    // -------------------------------------------
                    
                    
                    // ----------------***work order items save***----------------------------
                        $itemswrk23 = array(
                                'work_order_id' => $purchase->id,
                                'bill_of_material_id' => $purchase->product,
                                'item_id' => $dt3->id,
                                'item_name' => $dt3->name,
                                'unit' =>$dt3->unit,
                                'quantity_to_use' =>  $row2['quantity_wk'],
                                'rem_quantity' =>  $row2['quantity_wk'],
                                'items_id' =>  $dt3->id,
                            'added_by' => $purchase->added_by);

                        WorkOrderItems::create($itemswrk23);;
                    
                    
                    
                    // -------------------------------------------
                    
         
                }
                

                                $dataP['status']= 2;
                            $prd = $purchase->update($dataP);
            
              return redirect(route('work_order.index'))->with(['success'=>'Released Successfully']);  
                
            }
            else{
                        return redirect(route('work_order.index'))->with(['error'=>'Bill Of Material Inventory Not Found']);
                }
        }
        else{
            return redirect(route('work_order.index'))->with(['error'=>'Purchase ID Not Found']);
        }
        
    }
    
    public function produce(Request $request, $id)
    {
        //
        $purchase = WorkOrder::find($id);
        
        if(!empty($purchase)){
            
                    $temp_sum = $request->withdraw_quantity;

                    
                    $dt2 = Location::find($purchase->work_center);
                    
                    $total_cost_price=0;
                    
                    if($purchase->due_quantity >= $temp_sum){
                        
                           //$dataP['status'] = 3; temp_sum
                           
                           $rmqID = WorkOrderItems::where('work_order_id',$purchase->id)->get();
                           
                           foreach($rmqID as $rmtt){
                               
                               $rem_quantity = $rmtt->rem_quantity;
                            
                            $finishGoods_quantity = $rmtt->finishGoods_quantity;
                                    
                            $xyt = BillOfMaterialInventory::where('bill_of_material_id', $purchase->product)->where('items_id', $rmtt->item_id)->first();
                            
                            $new_ct = Items::find($rmtt->item_id)->cost_price;
                            
                            $total_cost_price  += $new_ct;
                            
                            // $to_godown[] = $new_cost;
                                    
                            $xyz = $xyt->quantity;
                                    
                            $quantityZZ = $xyz * $temp_sum;
                            
                            
                                $t = array( 
                                         'rem_quantity' => $rem_quantity - $quantityZZ,
                                         'finishGoods_quantity' => $finishGoods_quantity + $quantityZZ);
                    
                                           WorkOrderItems::where('work_order_id',$purchase->id)->where('items_id', $rmtt->item_id)->update($t); 
                           }
                                    
                            
                           
                        
    
    

                                   
        
                            $dataP['due_quantity'] = $purchase->due_quantity - $temp_sum ;
                            
                            // $dataP['release_quantity'] = $purchase->release_quantity + $temp_sum;
                            
                            $dataP['finishGoods_quantity'] =  $purchase->finishGoods_quantity + $temp_sum;
                         
                               if( $dataP['due_quantity'] != 0 ){
                                $dataP['status']= 2;
                                         }else{
                                         $dataP['status'] = 3;
                                         }
                            $prd = $purchase->update($dataP);
                        
                            $diff=$dt2->quantity - $temp_sum;
                            
                            //update quantity on work center store after release 
                            $lctr = Location::where('id',$purchase->work_center)->update(['quantity' => $diff]);
                            
                             // -------------------***work production activity adding ***-------------------------
                             $itm_idfinish = Items::find($purchase->product_name)->name;
                             
                             $nowct = Carbon::now()->format('Y-m-d H:i:s');
                             
                             $count=WorkOrderProductionActivity::where('work_order_id', $purchase->id)->count();
                             
                                $pro=$count+1;
                                
                                    $workproduction23 = array(
                                            'work_order_id' => $purchase->id,
                                            'produced_date' => $nowct,
                                            'product' => $itm_idfinish,
                                            'order_no' =>   $pro,
                                            'work_center_store' => $purchase->work_center,
                                            'finish_store' =>   $purchase->finished_store,
                                            'quantity_produced' => $temp_sum,
                                            'quantity_rem' => $temp_sum,
                                            'user_id' =>  auth()->user()->id,
                                        'added_by' => $purchase->added_by);
            
                                    WorkOrderProductionActivity::create($workproduction23);;
                    
                    
                    
                    // -------------------------------------------
                       
                            // $dt3 = Location::find($purchase->finished_store);
                            
                            // $data22 =$dt3->quantity + $temp_sum;
                            
                            // //update quantity on finished  store after release  
                            // Location::where('id',$purchase->finished_store)->update(['quantity' => $data22]);
                            
                            // //update quantity on finished  item on produce 
                            
                            // $itm_idfinish = Items::find($purchase->product_name);
                            
                            // $data22IT =$itm_idfinish->quantity + $temp_sum;
                            
                            // Items::where('id',$purchase->product_name)->update(['quantity' => $data22IT]);
                            
                            
                            
                            
                            // ------
                                // find bill of material from work order bill of material id of product
                                $billMTTT = BillOfMaterial::find($purchase->product);
                                
                                
                                 $itm_iddd = Items::find($purchase->product_name);
                                 
                                 if($itm_iddd->package == "18,900ml bottles")
                                 {
                                     
                                        $billMxy = $billMTTT->duty_excess;
                                    
                                        if(!empty($billMxy)){
                                            
                                            $billM = $billMxy;
                                        }
                                        else{
                                            
                                            $billM = 0;
                                        }
                                        
                                        
                                        $itm_prrxy = $itm_iddd->vol_produced;
                                        
                                        if(!empty($itm_prrxy)){
                                            
                                            $itm_prr = $itm_prrxy;
                                        }
                                        else{
                                            
                                            $itm_prr = 0;
                                        } 
                                        
                                        // quantity produced * volume produced from item manufactured * duty excise from bill of material;  
                            
                                        $amtff = $temp_sum * $itm_prr  * $billM * 385.5;
                                        
                                        $crExcise222 = AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
                                          $journal = new JournalEntry();
                                          $journal->account_id = $crExcise222->id;
                                          $date = explode('-',$d);
                                          $journal->date =   $d ;
                                          $journal->year = $date[0];
                                          $journal->month = $date[1];
                                          $journal->transaction_type = 'manufacturing';
                                          $journal->name = 'Manufacturing Product';
                                          $journal->income_id= $id;
                                           $journal->branch_id= $purchase->branch_id;
                                            $journal->credit = $amtff;
                                         $journal->added_by=auth()->user()->added_by;
                                         $journal->notes="Manufacturing Product -  " . $inv->name;
                                          $journal->save();
                                        
                                        $dbExcise222= AccountCodes::where('account_name','Cost of 1890mls')->where('added_by',auth()->user()->added_by)->first();
                                          $journal = new JournalEntry();
                                          $journal->account_id = $dbExcise222->id;
                                          $date = explode('-',$d);
                                          $journal->date =   $d ;
                                          $journal->year = $date[0];
                                          $journal->month = $date[1];
                                          $journal->transaction_type = 'manufacturing';
                                          $journal->name = 'Manufacturing Product';
                                          $journal->income_id= $id;
                                          $journal->branch_id= $purchase->branch_id;
                                            $journal->debit = $amtff;
                                         $journal->added_by=auth()->user()->added_by;
                                         $journal->notes="Manufacturing Product -  " . $inv->name;
                                          $journal->save();
                                        
                                        
                                 }
                                 else{
                                     
                                     
                                     $billMxy = $billMTTT->duty_excess;
                                
                                    if(!empty($billMxy)){
                                        
                                        $billM = $billMxy;
                                    }
                                    else{
                                        
                                        $billM = 0;
                                    }
                                    
                                    
                                    $itm_prrxy = $itm_iddd->vol_produced;
                                    
                                    if(!empty($itm_prrxy)){
                                        
                                        $itm_prr = $itm_prrxy;
                                    }
                                    else{
                                        
                                        $itm_prr = 0;
                                    }
                                    
                                    // quantity produced * volume produced from item manufactured * duty excise from bill of material;  
                            
                                    // $amtff = $temp_sum * $itm_prr  * $billM;
                                    
                                    $amtff = $temp_sum * $itm_prr;
                                
                                
                                 }
                                 
                                
                                    $nwDate = Carbon::now()->format('Y-m-d');
                            
                            
                                    $excise2222 = array(
                                        'work_order_id' => $purchase->id,
                                        'date' =>   $nwDate,
                                        'bill_material_id' => $purchase->product,
                                        'amount' =>  $amtff,
                                        'quantity' =>  $temp_sum,
                                    'added_by' => $purchase->added_by);
        
                                ExciseDuty::create($excise2222);;
                                
                                $itm_iddd23444 = Items::find($purchase->product_name);
                                
                                $xyyz = $total_cost_price + $billMTTT->duty_excess;
                                
                                $listsXYZ= array(
                            'quantity' =>   $temp_sum,
                          'price' => $xyyz,
                             'item_id' =>$itm_iddd23444->id,
                               'added_by' => $purchase->added_by,
                             'purchase_date' =>   $nwDate,
                             'location' => $purchase->finished_store,
                            'type' =>   'Purchases');
                           
                         PurchaseHistory::create($listsXYZ); 
                            
                            
                            // -----
                            
                            

                          $inv = Items::find($purchase->product_name);

$d=date('Y-m-d');

$crExcise = AccountCodes::where('account_name','Excise Duty')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $crExcise->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'manufacturing';
  $journal->name = 'Manufacturing Product';
  $journal->income_id= $id;
  $journal->branch_id= $purchase->branch_id;
    $journal->credit = $amtff;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="Manufacturing Product -  " . $inv->name;
  $journal->save();

$dbExcise= AccountCodes::where('account_name','Excise Duty Expenses')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $dbExcise->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'manufacturing';
  $journal->name = 'Manufacturing Product';
  $journal->income_id= $id;
  $journal->branch_id= $purchase->branch_id;
    $journal->debit = $amtff;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="Manufacturing Product -  " . $inv->name;
  $journal->save();
  
  

  $codes= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'manufacturing';
  $journal->name = 'Manufacturing Product';
  $journal->income_id= $id;
  $journal->branch_id= $purchase->branch_id;
  $journal->credit =$inv->cost_price *  $temp_sum;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="Manufacturing Product -  " . $inv->name;
  $journal->save();

  $cr= AccountCodes::where('account_name','Bill of Material')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'manufacturing';
  $journal->name = 'Manufacturing Product';
  $journal->income_id= $id;
  $journal->branch_id= $purchase->branch_id;
    $journal->debit  = $inv->cost_price *  $temp_sum;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="Manufacturing Product -  " . $inv->name;
  $journal->save();

// $good= AccountCodes::where('account_name','Finish Goods')->where('added_by',auth()->user()->added_by)->first();
//   $journal = new JournalEntry();
//   $journal->account_id = $good->id;
//   $date = explode('-',$d);
//   $journal->date =   $d ;
//   $journal->year = $date[0];
//   $journal->month = $date[1];
//   $journal->transaction_type = 'manufacturing';
//   $journal->name = 'Manufacturing Product';
//   $journal->income_id= $id;
//   $journal->branch_id= $purchase->branch_id;
//     $journal->debit = $inv->cost_price *  $temp_sum;
//  $journal->added_by=auth()->user()->added_by;
//  $journal->notes="Manufacturing Product -  " . $inv->name;
//   $journal->save();


// $prd= AccountCodes::where('account_name','Production Control')->where('added_by',auth()->user()->added_by)->first();
//   $journal = new JournalEntry();
//   $journal->account_id = $prd->id;
//   $date = explode('-',$d);
//   $journal->date =   $d ;
//   $journal->year = $date[0];
//   $journal->month = $date[1];
//   $journal->transaction_type = 'manufacturing';
//   $journal->name = 'Manufacturing Product';
//   $journal->income_id= $id;
//   $journal->branch_id= $purchase->branch_id;
//     $journal->credit = $inv->cost_price *  $temp_sum;
//  $journal->added_by=auth()->user()->added_by;
//  $journal->notes="Manufacturing Product -  " . $inv->name;
//   $journal->save();
                    
                       
                        return redirect(route('work_order.index'))->with(['success'=>'Produced Successfully']);
                        
                    }
                    
                    else{
                        return redirect(route('work_order.index'))->with(['error'=>'Work Center Store Quantity is low']);
                    }
                    
            
                
                
            // }
            
        }
        else{
            return redirect(route('work_order.index'))->with(['error'=>'Purchase ID Not Found']);
        }
        
        
    }


     
                 
                 public function store_produced(Request $request, $id){
                     
                        
            //work_id is the work production activity id
                           $nameArr = $request->work_id;
                              $qntArr = $request->quantity;
                    
                         if(!empty($nameArr)){
                            for($i = 0; $i < count($nameArr); $i++){
                                if(!empty($nameArr[$i])){
                                    
                                    $purchase = WorkOrder::find($id);
                            
                        
                          $dt3 = Location::find($purchase->finished_store);
                            
                            $data22 =$dt3->quantity + $qntArr[$i];
                            
                            // //update quantity on finished  store after release  
                             Location::where('id',$purchase->finished_store)->update(['quantity' => $data22]);
                            
                            // //update quantity on finished  item on produce 
                            
                            $itm_idfinish = Items::find($purchase->product_name);
                            
                             $data22IT =$itm_idfinish->quantity + $qntArr[$i];
                            
                             Items::where('id',$purchase->product_name)->update(['quantity' => $data22IT]);
                             
                             //
                             $workact = WorkOrderProductionActivity::where('id',$nameArr[$i])->first();
                             
                             $quantity_store = $workact->quantity_store + $qntArr[$i];
                             
                             $quantity_rem = $workact->quantity_rem - $qntArr[$i];
                             
                              WorkOrderProductionActivity::where('id',$nameArr[$i])->update(['quantity_store'=> $quantity_store, 'quantity_rem'=>$quantity_rem]);
                            
                 }
                                
                            }
                             
                         }
                         
                         return redirect(route('work_order.index'))->with(['success'=>'Produced Quantity Successfully Transfered to store']);
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
        $work_order =  WorkOrder::find($id);
        $work_order->delete();
 
        return redirect(route('work_order.index'))->with(['success'=>'Work Order Deleted Successfully']);
    }

  


     public function discountModal(Request $request)
    {
                 $id=$request->id;
                 
                 $purchase = WorkOrder::find($id);
                 
                 $wrk_items = WorkOrderItems::where('work_order_id',$purchase->id)->get();
                 
                 $inv_items   = BillOfMaterialInventory::where('bill_of_material_id', $purchase->product)->where('added_by', auth()->user()->added_by)->whereNotIn('item_name', ['TRA Sticker','electricity','transport','labor'])->get();
                 
                 $type = $request->type;
                  if($type == 'produce'){
                    return view('manufacturing.produce',compact('id', 'purchase'));
      }
                    
                 else if($type == 'overhead'){
              $bank_accounts=AccountCodes::where('added_by',auth()->user()->added_by)->where('account_group','Cash and Cash Equivalent')->orwhere('account_name','Payables')->where('added_by',auth()->user()->added_by)->get() ;
     $chart_of_accounts =AccountCodes::where('account_group','!=','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;
     $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
                    return view('manufacturing.overhead',compact('id','bank_accounts','chart_of_accounts','branch'));
      }
      
                elseif($type == 'finish'){
                    return view('manufacturing.finishproduction',compact('id', 'inv_items',  'wrk_items', 'purchase'));
      }

                 }
    
    public function issue(Request $request,$id){
        
        $data = $request->all();
        $data['added_by']=auth()->user()->id;
        Issue::create($data);
        
        $work_order =  WorkOrder::find($id);
        
        $data2['status']=1;
        $work_order->update($data2);
        
    return redirect(route('work_order.index'))->with(['success'=>'Work Issued Successfully']);
    }


 public function produce2 (Request $request, $id)
    {
        //
        $purchase = WorkOrder::find($id);
        
        if(!empty($purchase)){
            
                    $temp_sum = $request->withdraw_quantity;

                    
                    $dt2 = Location::find($purchase->work_center);
                    
                    if($dt2->quantity >= $temp_sum){
                        
                            $dataP['status'] = 3;
        
                            $prd = $purchase->update($dataP);
                        
                            $diff=$dt2->quantity - $temp_sum;
                            
                            //update quantity on work center store after release 
                            $lctr = Location::where('id',$purchase->work_center)->update(['quantity' => $diff]);
                       
                            $dt3 = Location::find($purchase->finished_store);
                            
                            $data22 =$dt3->quantity + $temp_sum;
                            
                            //update quantity on finished  store after release
                            Location::where('id',$purchase->finished_store)->update(['quantity' => $data22]);
                    
                       
                        return redirect(route('work_order.index'))->with(['success'=>'Produced Successfully']);
                        
                    }
                    
                    else{
                        return redirect(route('work_order.index'))->with(['error'=>'Work Center Store Quanttity is low']);
                    }
                    
            
                
                
            // }
            
        }
        else{
            return redirect(route('work_order.index'))->with(['error'=>'Purchase ID Not Found']);
        }
        
        
    }
    
    
    
    public function findQuantity(Request $request)
   {

 $material_bill=$request->material_bill;
 
 $quantity_to_produced = $request->id;
 
//  item_name
 
 $inv_items   = BillOfMaterialInventory::where('bill_of_material_id', $material_bill)->where('added_by', auth()->user()->added_by)->whereNotIn('item_name', ['TRA Sticker','electricity','transport','labor'])->get();

            $total_qty=0;
          
                
                foreach($inv_items as $row){
                    
                    $data['id'] = $row->items_id;

                    $data['quantity_wk'] = $row->quantity * $quantity_to_produced;
                       $total_qty += $row->quantity * $quantity_to_produced;
                    
                    
                    $dt2 = Items::find($row->items_id);
                    
                    if($dt2->quantity >= $data['quantity_wk']){
                        
                        // if($dt2->name != "TRA Sticker" || $dt2->name != "electricity" || $dt2->name != "transport" || $dt2->name != "labor"){
                         
                            $tempS[] = $data;
                            
                        // }
                    
                        
                    }
                    
                    else{
                        //quantity remained on inv store
                        // if($dt2->name != "TRA Sticker" || $dt2->name != "electricity" || $dt2->name != "transport" || $dt2->name != "labor"){
                            
                            
                            $xt['quantity_st'] = $data['quantity_wk'] - $dt2->quantity;
                        
                            $xq = $data['quantity_wk'] - $dt2->quantity;
                            
                            //quantity can be produced by that particular bill of material
                            $xt['quantity_cp'] = $xq / $row->quantity;
                            
                            $xt['material_name'] = $dt2->name;
                            
                            $tempF[] = $xt;
                        
                        
                        // }
                        
                        
                        
                        
                        // $price= "Bill Of Material Is Out Of Date  ". $dt2->name ." material are ".  number_format($dt2->quantity,2) ." remained on Inventory Store, either purchase material or update quantity" ;
                        
                        // return response()->json($price);
                        
                    }
                    
                    
                    
         
                }

                //dd($total_qty);

                // $temp_quantity = $total_qty;
                //       $pur_items['release_quantity']= $temp_quantity;
                //         $pur_items['due_quantity']= $purchase->quantity;
                // $purchase->update($pur_items);
                
                if(!empty($tempF)){
                    
                   foreach($tempF as $row2){
                    
                    
                    $data99 = $row2['material_name']." - available quantity: ". $row2['quantity_st'] ." , Quantity which can be produced: ".$row2['quantity_cp']."<br>";
                    
                    $price[] = $data99;
    
                    }
                    
                    return response()->json($price);
                
                }
                else{
                    
                    $price = '';
                    return response()->json($price);
                    
                }
                
                
                
                
                // $response=['price' => $data];
            
             
                 
                     
 
     }
     
     
      public function findWrkQuantity(Request $request)
   {

 
    $quantity_finish = $request->id;
    
    $workID=$request->workID;
    
    $purchase = WorkOrder::find($workID);
 
     $dt2 = Location::find($purchase->work_center);
                    
                    if($quantity_finish >= $purchase->due_quantity){
                        $price="Choose quantity between 1.00 and ".  number_format($purchase->due_quantity,2) ;
                    }
                    else{
                        $price = '';
                        
                    }
                    
                    return response()->json($price);

 
     }
     
 public function findInvWrkQuantity(Request $request)
   {

 
    $quantity_finish_item = $request->id;
    
    $quantity_finish = $request->withdraw_check;
    
    $item_id = $request->item_id;
    
    $workID=$request->workID;
    
    // if(is_null($quantity_finish)){
    //     $quantity_to_pro = 0;
    // }
    // else{
        $quantity_to_pro = $quantity_finish;
    // }
    
    
    // $qnchk = $quantity_to_pro * 
    
    
    $purchase = WorkOrder::find($workID);

     $wrk =  WorkOrderItems::where('work_order_id',$purchase->id)->where('item_id',$item_id)->first();
     
    //  rem_quantity
    $qntrv = $wrk->rem_quantity;
    
    // $dt2 = Items::where('id', $item_id)->whereNotIn('item_name', ['TRA Sticker','electricity','transport','labor'])->first();
    
     $dt2 = Items::find($item_id);
     
     if(!empty($dt2)){
         
         
        //  if($dt2->name != "TRA Sticker" || $dt2->name != "electricity" || $dt2->name != "transport" || $dt2->name != "labor"){
             
             if($quantity_finish_item > $qntrv){
                        $price="Choose quantity between 1.00 and ".  number_format($qntrv,2) ;
                    }
                    else{
                        $price = '';
                        
                    }
        //  }
        //  else{
        //       $price = '';
        //  }
         
         
     }
     else{
         $price = '';
     }
     
                    
                    return response()->json($price);

 
     }



}
