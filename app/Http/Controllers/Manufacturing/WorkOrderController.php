<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\WorkOrder;
use App\Models\Manufacturing\WorkOrderItems;
use App\Models\Manufacturing\Issue;
use App\Models\Manufacturing\ExciseDuty;
use App\Models\Supplier;
use  App\Models\POS\Items;
use App\Models\Location;
use Carbon\Carbon;
use App\Models\AccountCodes;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\JournalEntry;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\MasterHistory;
use App\Models\Branch;
use App\Models\Manufacturing\BillOfMaterial;
use App\Models\Manufacturing\BillOfMaterialInventory;

use App\Models\User;
use App\Models\LocationManager;
use App\Models\Manufacturing\WorkOrderProductionActivity;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $work_orders = WorkOrder::all()->where('added_by', auth()->user()->added_by);
        
        $billofmaterials = BillOfMaterial::all()->where('added_by', auth()->user()->added_by);
        
        $locationWs = Location::all()->where('type',1)->where('main',1)->where('added_by', auth()->user()->added_by); 
        
        $locationFs = Location::all()->where('type',2)->where('main',1)->where('added_by', auth()->user()->added_by);
        
        $locations = Location::all()->where('type',3)->where('main',1)->where('added_by', auth()->user()->added_by);
        
           $items = Items::all()->where('type',2)->where('disabled','0')->where('added_by', auth()->user()->added_by);
           $users = User::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
              $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
        return view('manufacturing.work_order',compact('work_orders','items','locationWs', 'locationFs', 'locations', 'users', 'billofmaterials','branch'));
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
        
        $location = Location::all()->where('type',4)->where('main',1)->where('added_by', auth()->user()->added_by);
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
        
        $today = Carbon::now()->format('Y-m-d');

        // $data=$request->post();  Finish Goods
        $count=WorkOrder::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $data['reference_no']= "WOD_NO".$pro;
        

        $data['unit']=$request->unit;        
        $data['type']=$request->type; 
        $data['work_type']=$request->work_type; 
        $data['quantity']=$request->quantity;
         $data['due_quantity']=$request->quantity;        
         $data['balance']=$request->quantity;
        $data['product']=$request->product;
        
        
        $bill   = BillOfMaterial::find($request->product);
        
        $data['product_name']= $bill->product;

        $data['work_center']=$request->work_center;
        
        if(!empty($request->finished_store22)){
            
            $data['finished_store']=$request->finished_store22;
            
        }
        else{
            
            $data['finished_store']=$request->finished_store;
            
        }
        
        
        
        $data['location_id']=$request->location_id;
         $data['branch_id']=$request->branch_id;
        $data['description']=$request->description;
        
        $data['expected_date']=$request->expected_date;
        
        
        
        $data['added_by']=auth()->user()->added_by;
        $data['responsible_id']=$request->user_id;
        $data['created_by']=auth()->user()->id;
        $data['created_date']= $today;
        $work_order = WorkOrder::create($data);
 
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
        $location = Location::all()->where('type',4)->where('main',1)->where('added_by', auth()->user()->added_by);
        $work_centre = Location::all()->where('type',1)->where('main',1)->where('added_by', auth()->user()->added_by);
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
        $locationWs = Location::all()->where('type',1)->where('main',1)->where('added_by', auth()->user()->added_by);        
        $locationFs = Location::all()->where('type',2)->where('main',1)->where('added_by', auth()->user()->added_by);        
        $locations = Location::all()->where('type',3)->where('main',1)->where('added_by', auth()->user()->added_by);
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
        
        $data['unit']=$request->unit;
        
        $data['type']=$request->type;
        
        $data['quantity']=$request->quantity;
        $data['due_quantity']=$request->quantity;
        
         $data['balance']=$request->quantity;
         $data['branch_id']=$request->branch_id;
       
        $data['product']=$request->product;
        
        
        $bill   = BillOfMaterial::find($request->product);

        
        $data['product_name']= $bill->product;
        
   //dd($data['product_name']);     
        
        $data['work_center']=$request->work_center;
        
        // $data['finished_store']=$request->finished_store;
        
        if(!empty($request->finished_store22)){
            
            $data['finished_store']=$request->finished_store22;
            
        }
        else{
            
            $data['finished_store']=$request->finished_store;
            
        }
        
        $data['location_id']=$request->location_id;
        
        $data['description']=$request->description;
        
        $data['expected_date']=$request->expected_date;
        
        
        
        $data['added_by']=auth()->user()->added_by;
        $data['responsible_id']=$request->user_id;
        $data['created_by']=auth()->user()->id;
        
        $work_order->update($data);
 
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
                
                // dd($inv_items);
                
                foreach($inv_items as $row){
                    
                    $data['id'] = $row->items_id;

                    $data['quantity_wk'] = $row->quantity * $purchase->quantity;
                       $total_qty += $row->quantity * $purchase->quantity;
                    //dd($data['quantity_wk']);
                    
                    $dt2 = Items::find($row->items_id);
                    
                    if($dt2->name == "Labour" || $dt2->name == "transport" || $dt2->name == "electricity"){
                        
                        $temp[] = $data;
                        
                        
                    }
                    else{
                        
                         if($dt2->quantity >= $data['quantity_wk']){
                         
                            $temp[] = $data;
                    
                        
                        }
                        
                        else{
                            return redirect(route('work_order.index'))->with(['error'=>'Inventory Store Quanttity is low']);
                        }
                        
                    }
                    
                   
                    
                    
         
                }

                //dd($total_qty);

                $temp_quantity = $total_qty;
                      $pur_items['release_quantity']= $temp_quantity;
                        $pur_items['due_quantity']= $purchase->quantity;
                $purchase->update($pur_items);
                
               
                
                foreach($temp as $row2){

//dd($row2);
                
                    $dt3 = Items::find($row2['id']);
                    
                    if($dt3->name == "Labour" || $dt3->name == "transport" || $dt3->name == "electricity"){
                        
                         //dd(3);
                    }
                    
                    
                    else{
                        
                         //dd(1);
                        
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
                        
                        $nwDate = Carbon::now()->format('Y-m-d');
                        
                        $listsXYZ= array(
                                    'quantity' =>   $row2['quantity_wk'] * -1,
                                    'price' => $dt3->cost_price,
                                    'item_id' =>$dt3->id,
                                      'added_by' => $purchase->added_by,
                                     'purchase_date' =>   $nwDate,
                                     'location' => $purchase->location_id,
                                    'type' =>   'Purchases');
                           
                         PurchaseHistory::create($listsXYZ); 
                        
                        $mlists = array(
                        'out' => $row2['quantity_wk'],
                        'price' => $dt3->cost_price,
                        'item_id' => $dt3->id,
                        'added_by' => $purchase->added_by,
                        'location' => $purchase->location_id,
                        'date' =>$nwDate,
                        'type' => 'Purchases' );

                         $vvttt =    MasterHistory::create($mlists);
                        
                    }
                    
                    
                    
                    
                    // -------------------***inventory adding ***-------------------------
                        // $items23 = array(
                        //         'name' => $dt3->name,
                        //         'type' =>   3,
                        //         'cost_price' => $dt3->cost_price,
                        //         'sales_price' =>  $dt3->sales_price,
                        //         'unit' =>$dt3->unit,
                        //         'quantity' =>  $row2['quantity_wk'],
                        //         'description' =>  $dt3->description,
                        //     'added_by' => $dt3->added_by);

                        // Items::create($items23);;
                    
                    
                    
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
                               
                               $invItem = Items::find($rmtt->item_id);
                               
                                $d=date('Y-m-d');
                               
                                 $rem_quantity = $rmtt->rem_quantity;
                            
                            $finishGoods_quantity = $rmtt->finishGoods_quantity;
                                    
                            $xyt = BillOfMaterialInventory::where('bill_of_material_id', $purchase->product)->where('items_id', $rmtt->item_id)->first();
                            
                            $new_ct = Items::find($rmtt->item_id)->cost_price;
                            
                            $total_cost_price  += $new_ct;
                            
                            // $to_godown[] = $new_cost;
                                    
                            $xyz = $xyt->quantity;
                                    
                            //$quantityZZ = number_format(($xyz * $temp_sum),4);
                            $quantityZZ = $xyz * $temp_sum;

                            $t = array( 
                              'rem_quantity' => $rem_quantity - $quantityZZ,
                              'finishGoods_quantity' => $finishGoods_quantity + $quantityZZ);
         
                                WorkOrderItems::where('work_order_id',$purchase->id)->where('items_id', $rmtt->item_id)->update($t); 
                                
                               
                            if($invItem->name == "Labour" || $invItem->name == "transport" || $invItem->name == "electricity"){ 
                                
                                 if($invItem->name == 'electricity'){
                                    $cr12= AccountCodes::where('account_name','Electricity')->where('added_by',auth()->user()->added_by)->first();
                                              $journal = new JournalEntry();
                                              $journal->account_id = $cr12->id;
                                              $date = explode('-',$d);
                                              $journal->date =   $d ;
                                              $journal->year = $date[0];
                                              $journal->month = $date[1];
                                              $journal->transaction_type = 'Manufacturing';
                                              $journal->name = 'Manufacturing Product';
                                              $journal->income_id= $id;
                                              $journal->branch_id= $purchase->branch_id;
                                                $journal->debit = $quantityZZ * $invItem->cost_price;
                                             $journal->added_by=auth()->user()->added_by;
                                             $journal->notes="Manufacturing Product -  " . $invItem->name;
                                             $journal->save();
                                             
                                             $codes12= AccountCodes::where('account_name','Accruals-Electricity')->where('added_by',auth()->user()->added_by)->first();
                                              $journal = new JournalEntry();
                                              $journal->account_id = $codes12->id;
                                               $date = explode('-',$d);
                                              $journal->date =   $d ;
                                              $journal->year = $date[0];
                                              $journal->month = $date[1];
                                              $journal->transaction_type = 'Manufacturing';
                                              $journal->name = 'Manufacturing Product';
                                              $journal->income_id= $id;
                                              $journal->branch_id= $purchase->branch_id;
                                              $journal->credit = $quantityZZ * $invItem->cost_price;
                                             $journal->added_by=auth()->user()->added_by;
                                            $journal->notes="Manufacturing Product -  " . $invItem->name;
                                              $journal->save();
                                }
                                elseif($invItem->name == 'transport'){
                                    $cr12= AccountCodes::where('account_name','Transport')->where('added_by',auth()->user()->added_by)->first();
                                              $journal = new JournalEntry();
                                              $journal->account_id = $cr12->id;
                                              $date = explode('-',$d);
                                              $journal->date =   $d ;
                                              $journal->year = $date[0];
                                              $journal->month = $date[1];
                                              $journal->transaction_type = 'Manufacturing';
                                              $journal->name = 'Manufacturing Product';
                                              $journal->income_id= $id;
                                              $journal->branch_id= $purchase->branch_id;
                                                $journal->debit = $quantityZZ * $invItem->cost_price;
                                             $journal->added_by=auth()->user()->added_by;
                                             $journal->notes="Manufacturing Product -  " . $invItem->name;
                                             $journal->save();
                                             
                                             $codes12= AccountCodes::where('account_name','Accruals-Transport')->where('added_by',auth()->user()->added_by)->first();
                                              $journal = new JournalEntry();
                                              $journal->account_id = $codes12->id;
                                               $date = explode('-',$d);
                                              $journal->date =   $d ;
                                              $journal->year = $date[0];
                                              $journal->month = $date[1];
                                              $journal->transaction_type = 'Manufacturing';
                                              $journal->name = 'Manufacturing Product';
                                              $journal->income_id= $id;
                                              $journal->branch_id= $purchase->branch_id;
                                              $journal->credit =$quantityZZ * $invItem->cost_price;
                                             $journal->added_by=auth()->user()->added_by;
                                            $journal->notes="Manufacturing Product -  " . $invItem->name;
                                              $journal->save();
                                }
                                elseif($invItem->name == 'Labour'){
                                   
                                    $cr12= AccountCodes::where('account_name','Labour')->where('added_by',auth()->user()->added_by)->first();
                                              $journal = new JournalEntry();
                                              $journal->account_id = $cr12->id;
                                              $date = explode('-',$d);
                                              $journal->date =   $d ;
                                              $journal->year = $date[0];
                                              $journal->month = $date[1];
                                              $journal->transaction_type = 'Manufacturing';
                                              $journal->name = 'Manufacturing Product';
                                              $journal->income_id= $id;
                                              $journal->branch_id= $purchase->branch_id;
                                              $journal->debit = $quantityZZ * $invItem->cost_price;
                                             $journal->added_by=auth()->user()->added_by;
                                             $journal->notes="Manufacturing Product -  " . $invItem->name;
                                             $journal->save();
                                             
                                             $codes12= AccountCodes::where('account_name','Accruals-Labour')->where('added_by',auth()->user()->added_by)->first();
                                              $journal = new JournalEntry();
                                              $journal->account_id = $codes12->id;
                                               $date = explode('-',$d);
                                              $journal->date =   $d ;
                                              $journal->year = $date[0];
                                              $journal->month = $date[1];
                                              $journal->transaction_type = 'Manufacturing';
                                              $journal->name = 'Manufacturing Product';
                                              $journal->income_id= $id;
                                              $journal->branch_id= $purchase->branch_id;
                                              $journal->credit = $quantityZZ * $invItem->cost_price;
                                             $journal->added_by=auth()->user()->added_by;
                                            $journal->notes="Manufacturing Product -  " . $invItem->name;
                                              $journal->save();
                                }

                                
                                
                                
                            }  

                            else{

                              
                                 
                                  
                                 
                                  
                                  
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
                                     $journal->credit =$invItem->cost_price *  $temp_sum;
                                    $journal->added_by=auth()->user()->added_by;
                                   $journal->notes="Manufacturing Product -  " . $invItem->name;
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
                                       $journal->debit  = $invItem->cost_price *  $temp_sum;
                                    $journal->added_by=auth()->user()->added_by;
                                    $journal->notes="Manufacturing Product -  " . $invItem->name;
                                     $journal->save();

                            }
                               
                               
                             
                            
                            
                                
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
                                 
                                 if($itm_iddd->package == "18,900ml bottles Returnable")
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
                                        
                                        $d=date('Y-m-d');
                                        
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
                         
                         
                         $mlists = array(
                        'in' => $temp_sum,
                        'price' => $xyyz,
                        'item_id' => $itm_iddd23444->id,
                        'added_by' => $purchase->added_by,
                        'location' => $purchase->finished_store,
                        'date' =>$nwDate,
                        'type' => 'Purchases' );

                 $vvttt =    MasterHistory::create($mlists);
                 
                            //dd($vvttt);
                            
                            // -----
                            
                            

                          $inv = Items::find($purchase->product_name);

$d=date('Y-m-d');

$crExcise = AccountCodes::where('account_name','Excise Duty Payable')->where('added_by',auth()->user()->added_by)->first();
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

            $user_send = User::find($purchase->responsible_id);

                        // $key = "891bf62609dcbefad622090d577294dcab6d0607";
                        // //   $number = "0747022515";
                        //   $number = $user_send->phone;
                        //   $message = "Hello $user_send->name , umefanikiwa kuzalisha jumla ya carton  $temp_sum ya $inv->name . \n Powered by UjuziNet.";
                        //   $option11 = 1;
                        //   $type = "sms";
                        //   $useRandomDevice = 1;
                        //   $prioritize = 1;
                          
                        //   $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
                           
                    
                       
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


     public function findProduceModal(Request $request)
    {
                 $id=$request->id;
                 
                 $purchase = WorkOrder::find($id);
                 
                 $work = WorkOrderProductionActivity::where('work_order_id',$purchase->id)->get();
                 
                 
                return view('manufacturing.produced_activity_list',compact('id', 'purchase', 'work'));

    }
                 
                 public function store_produced(Request $request, $id){
                     
                        
            //work_id is the work production activity id
                           $nameArr = $request->work_id;
                              $qntArr = $request->quantity;
                              
                              $purchase = WorkOrder::find($id);
                              
                              $inv= Items::find($purchase->product_name);
                              
                              $to_qn = 0;
                    
                         if(!empty($nameArr)){
                            for($i = 0; $i < count($nameArr); $i++){
                                if(!empty($nameArr[$i])){
                                    
                                    
                            $to_qn += $qntArr[$i];
                        
                          $dt3 = Location::find($purchase->finished_store);
                          
                        //   dd($dt3);
                            
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
                         
                         $temp_sum = $to_qn;
                         
                          
                          
                          $manager_id = LocationManager::where('location_id', $purchase->finished_store)->first();
                          
                          $dt3T = Location::find($purchase->finished_store);
                          
                          $user_send = User::find($manager_id->manager);

                        // $key = "891bf62609dcbefad622090d577294dcab6d0607";
                        // //   $number = "0747022515";
                        //   $number = $user_send->phone;
                        //   $message = "Hello $user_send->name , umepokea jumla ya carton  $temp_sum ya $inv->name kwa sasa una balance ya $dt3T->quantity . \n Powered by UjuziNet.";
                        //   $option11 = 1;
                        //   $type = "sms";
                        //   $useRandomDevice = 1;
                        //   $prioritize = 1;
                          
                        //   $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
                           
                         
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

  public function finish(Request $request,$id){
        
        $work_order =  WorkOrder::find($id);
        
        $data2['status']=3;
        $work_order->update($data2);
        
        
        // --------
        
        
                           $d=date('Y-m-d');
                           $nameArr = $request->item_id;
                              $rejArr = $request->quantity_rj;
                    
                         if(!empty($nameArr)){
                            for($i = 0; $i < count($nameArr); $i++){
                                if(!empty($nameArr[$i])){
                                    
                                     $invItem = Items::find($nameArr[$i]);
                                    
                                     if($invItem->name == "Labour" || $invItem->name == "transport" || $invItem->name == "electricity"){ 
                                         
                                          $rmqID = WorkOrderItems::where('work_order_id',$work_order->id)->where('item_id',$nameArr[$i])->first();
                                    
                                            $rem_quantity = $rmqID->rem_quantity;
                                            
                                            $finishGoods_quantity = $rmqID->finishGoods_quantity;
                                            
                                            $qntt = $rmqID->rem_quantity - $rejArr[$i];
                                            
                                            $incomplete_quantity = $rmqID->incomplete_quantity + $qntt;
                                            
                                            $reject_quantity = $rmqID->reject_quantity + $rejArr[$i];
                                            
                                            // $xyt = BillOfMaterialInventory::where('bill_of_material_id', $work_order->product)->where('items_id', $nameArr[$i])->first();
                                            
                                            // $xyz = $xyt->quantity;
                                            
                                            // $quantityZZ = $xyz * $temp_sum;
                                            
                                            $t = array(
                                                'incomplete_quantity' =>  $incomplete_quantity,
                                                 'reject_quantity' =>  $reject_quantity, 
                                                 'rem_quantity' => $qntt);
                            
                                                   WorkOrderItems::where('work_order_id',$work_order->id)->where('item_id',$nameArr[$i])->update($t);  
                                                   
                                                   if( $incomplete_quantity > 0)
                                                   {
                                                      $dataPT['incomplete_quantity'] = "Yes"; 
                                                   }
                                                   else{
                                                       $dataPT['incomplete_quantity'] = "No";
                                                   }
                                                   
                                                   if( $reject_quantity > 0)
                                                   {
                                                      $dataPT['reject_quantity'] = "Yes"; 
                                                   }
                                                   else{
                                                       $dataPT['reject_quantity'] = "No";
                                                   }
                                                   
                                                   $prdTT = $work_order->update($dataPT);
                                         
                                     }
                                     else{
                                         
                                         $rmqID = WorkOrderItems::where('work_order_id',$work_order->id)->where('item_id',$nameArr[$i])->first();
                                    
                                            $rem_quantity = $rmqID->rem_quantity;
                                            
                                            $finishGoods_quantity = $rmqID->finishGoods_quantity;
                                            
                                            $qntt = $rmqID->rem_quantity - $rejArr[$i];
                                            
                                            $incomplete_quantity = $rmqID->incomplete_quantity + $qntt;
                                            
                                            $reject_quantity = $rmqID->reject_quantity + $rejArr[$i];
                                            
                                            // $xyt = BillOfMaterialInventory::where('bill_of_material_id', $work_order->product)->where('items_id', $nameArr[$i])->first();
                                            
                                            // $xyz = $xyt->quantity;
                                            
                                            // $quantityZZ = $xyz * $temp_sum;
                                            
                                            $t = array(
                                                'incomplete_quantity' =>  $incomplete_quantity,
                                                 'reject_quantity' =>  $reject_quantity, 
                                                 'rem_quantity' => $qntt);
                            
                                                   WorkOrderItems::where('work_order_id',$work_order->id)->where('item_id',$nameArr[$i])->update($t);  
                                                   
                                                   if( $incomplete_quantity > 0)
                                                   {
                                                      $dataPT['incomplete_quantity'] = "Yes"; 
                                                   }
                                                   else{
                                                       $dataPT['incomplete_quantity'] = "No";
                                                   }
                                                   
                                                   if( $reject_quantity > 0)
                                                   {
                                                      $dataPT['reject_quantity'] = "Yes"; 
                                                   }
                                                   else{
                                                       $dataPT['reject_quantity'] = "No";
                                                   }
                                                   
                                                   $prdTT = $work_order->update($dataPT);
                                                   
                                                   
                                                   $inv = Items::find($nameArr[$i]);
                                                   
                                                   $dt3 = Items::find($nameArr[$i]);
                                                   
                                                   $diff=$dt3->quantity + $incomplete_quantity;
                                    
                                //1. update quantity on inventory store after release 
                                
                                //1.1 updating value on inventory items
                                $dt3->update(['quantity' => $diff]);
                                
                                //1.2 reduce value on inventory store location
                                
                                $dt31 = Location::find($purchase->location_id);
                                        
                                $data221 =$dt31->quantity + $incomplete_quantity;
                                        
                                
                                $dt31->update(['quantity' => $data221]);
                                
                                
                                //2. increase value on work center store location
                                
                                $dt3W = Location::find($purchase->work_center);
                                        
                                $data22W =$dt3W->quantity -  $incomplete_quantity;
                                        
                                $dt3W->update(['quantity' => $data22W]);
                                
                                $nwDate = Carbon::now()->format('Y-m-d');
                                
                                $listsXYZ= array(
                                            'quantity' =>   $incomplete_quantity * 1,
                                            'price' => $dt3->cost_price,
                                            'item_id' =>$dt3->id,
                                              'added_by' => $purchase->added_by,
                                             'purchase_date' =>   $nwDate,
                                             'location' => $purchase->location_id,
                                            'type' =>   'Purchases');
                                   
                                 PurchaseHistory::create($listsXYZ); 
                                
                                $mlists = array(
                                'in' => $incomplete_quantity,
                                'price' => $dt3->cost_price,
                                'item_id' => $dt3->id,
                                'added_by' => $purchase->added_by,
                                'location' => $purchase->location_id,
                                'date' =>$nwDate,
                                'type' => 'Purchases' );
        
                                 $vvttt =    MasterHistory::create($mlists);
                                                   
                                                  
                                                   /*
                                                     $codes= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
                                                      $journal = new JournalEntry();
                                                      $journal->account_id = $codes->id;
                                                       $date = explode('-',$d);
                                                      $journal->date =   $d ;
                                                      $journal->year = $date[0];
                                                      $journal->month = $date[1];
                                                      $journal->transaction_type = 'Manufacturing';
                                                      $journal->name = 'Manufacturing Product';
                                                      $journal->income_id= $id;
                                                      $journal->branch_id= $work_order->branch_id;
                                                      $journal->debit =$inv->cost_price *  $rejArr[$i];
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
                                                      $journal->transaction_type = 'Manufacturing';
                                                      $journal->name = 'Manufacturing Product';
                                                      $journal->income_id= $id;
                                                      $journal->branch_id= $work_order->branch_id;
                                                        $journal->credit = $inv->cost_price *  $rejArr[$i];
                                                     $journal->added_by=auth()->user()->added_by;
                                                     $journal->notes="Manufacturing Product -  " . $inv->name;
                                                     */
                                                     
                                                     $cr1= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
                                                      $journal = new JournalEntry();
                                                      $journal->account_id = $cr1->id;
                                                      $date = explode('-',$d);
                                                      $journal->date =   $d ;
                                                      $journal->year = $date[0];
                                                      $journal->month = $date[1];
                                                      $journal->transaction_type = 'Manufacturing';
                                                      $journal->name = 'Manufacturing Product';
                                                      $journal->income_id= $id;
                                                      $journal->branch_id= $work_order->branch_id;
                                                        $journal->credit = $inv->cost_price *  $rejArr[$i];
                                                     $journal->added_by=auth()->user()->added_by;
                                                     $journal->notes="Manufacturing Product -  " . $inv->name;
                                                     
                                                     
                                                     $codes1= AccountCodes::where('account_name','Product Disposal')->where('added_by',auth()->user()->added_by)->first();
                                                      $journal = new JournalEntry();
                                                      $journal->account_id = $codes1->id;
                                                       $date = explode('-',$d);
                                                      $journal->date =   $d ;
                                                      $journal->year = $date[0];
                                                      $journal->month = $date[1];
                                                      $journal->transaction_type = 'Manufacturing';
                                                      $journal->name = 'Manufacturing Product';
                                                      $journal->income_id= $id;
                                                      $journal->branch_id= $work_order->branch_id;
                                                      $journal->debit =$inv->cost_price *  $rejArr[$i];
                                                     $journal->added_by=auth()->user()->added_by;
                                                    $journal->notes="Manufacturing Product -  " . $inv->name;
                                                      $journal->save();
                                                     
                                         
                                     }
                                    
                                    
                                             
                                             
                    
                    
                                }
                            }
                        }
                        
                        // $billM = BillOfMaterial::find($work_order->product);
                        
         
                        
        
        
        
        // -----------


   if($work_order->due_quantity > 0){

$inv = Items::find($work_order->product_name);

$d=date('Y-m-d');

         $codes= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'manufacturing';
  $journal->name = 'Manufacturing Defective Product';
  $journal->income_id= $id;
  $journal->branch_id= $work_order->branch_id;
  $journal->credit =$inv->cost_price * $work_order->due_quantity ;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="Manufacturing Defective Product -  " . $inv->name;
  $journal->save();

  $cr= AccountCodes::where('account_name','Defective Item')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'manufacturing';
  $journal->name ='Manufacturing Defective Product';
  $journal->income_id= $id;
  $journal->branch_id= $work_order->branch_id;
    $journal->debit = $inv->cost_price * $work_order->due_quantity ;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="Manufacturing Defective Product -  " . $inv->name;
  $journal->save();


}
      

  
    return redirect(route('work_order.index'))->with(['success'=>'Production Ended Successfully']);
    }


     public function discountModal(Request $request)
    {
                 $id=$request->id;
                 
                 $purchase = WorkOrder::find($id);
                 
                 $wrk_items = WorkOrderItems::where('work_order_id',$purchase->id)->get();
                 
                 $inv_items   = BillOfMaterialInventory::where('bill_of_material_id', $purchase->product)->where('added_by', auth()->user()->added_by)->whereNotIn('item_name', ['TRA Sticker','electricity','transport','Labour'])->get();
                 
                 $type = $request->type;
                  if($type == 'produce'){
                    return view('manufacturing.produce',compact('id', 'purchase'));
      }
                    
                 else if($type == 'overhead'){
    $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
     $chart_of_accounts =AccountCodes::all()->whereIn('account_type', ['Expense','Liability'])->whereNotIn('account_name', ['Deffered Tax','Value Added Tax (VAT)'])->where('disabled','0')->where('added_by',auth()->user()->added_by);
     $client=Supplier::where('user_id',auth()->user()->added_by)->where('disabled', '0')->get();
     $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
     $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                    return view('manufacturing.overhead',compact('id','bank_accounts','chart_of_accounts','branch','client','users'));
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


 public function produce2(Request $request, $id)
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
 
 $inv_items   = BillOfMaterialInventory::where('bill_of_material_id', $material_bill)->where('added_by', auth()->user()->added_by)->whereNotIn('item_name', ['TRA Sticker','electricity','transport','Labour'])->get();

            $total_qty=0;
          
                
                foreach($inv_items as $row){
                    
                    $data['id'] = $row->items_id;

                    $data['quantity_wk'] = $row->quantity * $quantity_to_produced;
                       $total_qty += $row->quantity * $quantity_to_produced;
                    
                    
                    $dt2 = Items::find($row->items_id);
                    
                    if($dt2->quantity >= $data['quantity_wk']){
                        
                        // if($dt2->name != "TRA Sticker" || $dt2->name != "electricity" || $dt2->name != "transport" || $dt2->name != "Labour"){
                         
                            $tempS[] = $data;
                            
                        // }
                    
                        
                    }
                    
                    else{
                        //quantity remained on inv store
                        // if($dt2->name != "TRA Sticker" || $dt2->name != "electricity" || $dt2->name != "transport" || $dt2->name != "Labour"){
                            
                            
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
    
    // $dt2 = Items::where('id', $item_id)->whereNotIn('item_name', ['TRA Sticker','electricity','transport','Labour'])->first();
    
     $dt2 = Items::find($item_id);
     
     if(!empty($dt2)){
         
         
        //  if($dt2->name != "TRA Sticker" || $dt2->name != "electricity" || $dt2->name != "transport" || $dt2->name != "Labour"){
             
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
