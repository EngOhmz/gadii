<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Activity;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;
use App\Models\POS\Items;
use App\Models\POS\Category;
use App\Models\POS\PurchaseHistory;

use App\Models\POS\SerialList;


use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\User;
use DateTime;


class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;

                $items = Items::where('added_by', $added_by)->whereIn('type', [1,4])->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
                // return response()->json($user,200);
                
                if($items->isNotEmpty()){
        
                    foreach($items as $row){
        
                        $data = $row;
                        
                        if ($row->type == 1) {
                            $data['quantity'] = $row->quantity;
                        }
                        elseif($row->type == 4) {
                            $data['quantity'] = 1;
                        }
                        else{
                            $data['quantity'] = $row->quantity;
                        }
        
                        $farmers[] = $data;
             
                    }
        
                    $response=['success'=>true,'error'=>false,'message'=>'successfully','inventory'=>$farmers];
                    return response()->json($response,200);
                }
                else{
        
                    $response=['success'=>false,'error'=>true,'message'=>'No Inventory found'];
                    return response()->json($response,200);
                } 
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
    }

    public function indexOff(int $id, int $lastId)
    {
        
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;

                $items = Items::where('added_by', $added_by)->whereIn('type', [1,4])->where('disabled','0')->where('id', '>', $lastId)->orderBy('created_at', 'desc')->get();
        
        
                // return response()->json($user,200);
                
                if($items->isNotEmpty()){
        
                    foreach($items as $row){
        
                        $data = $row;
                        
                        if ($row->type == 1) {
                            $data['quantity'] = $row->quantity;
                        }
                        elseif($row->type == 4) {
                            $data['quantity'] = 1;
                        }
                        else{
                            $data['quantity'] = $row->quantity;
                        }
        
                        $farmers[] = $data;
             
                    }
        
                    $response=['success'=>true,'error'=>false,'message'=>'successfully','inventory'=>$farmers];
                    return response()->json($response,200);
                }
                else{
        
                    $response=['success'=>false,'error'=>true,'message'=>'No Inventory found'];
                    return response()->json($response,200);
                } 
        
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
       
    }
    
    public function item_find(int $id, String $name)
    {
        // $emailFind = User::all()->where('email', $email)->first();
        
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           $added_by = $usr->added_by;
        
        $itemFind = Items::where('added_by', $added_by)->where(DB::raw('lower(name)'), strtolower($name))->first();
        
        if($itemFind){
            $response=['success'=>false,'error'=>true, 'message'=>'Item exists, Please Update quantity instead of adding new..'];
            return response()->json($response,200);
        }
        else{
            $response=['success'=>true,'error'=>false, 'message'=>'Proceed'];
            return response()->json($response,200);
        }
        // $roles = Role::all()->whereNotIn('slug', 'superAdmin');
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
        
    }

    public function category(int $id)
    {
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
            
        $category=Category::where('added_by', $added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get();

        // return response()->json($user,200);
        
        if($category->isNotEmpty()){

            foreach($category as $row){

                $data = $row;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','category'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Category found for user'];
            return response()->json($response,200);
        }
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
    }

    public function categoryOff(int $id, int $lastId)
    {
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
            
        $category=Category::where('added_by', $id)->where('id', '>', $lastId)->orderBy('created_at', 'desc')->get();

        // return response()->json($user,200);
        
        if($category->isNotEmpty()){

            foreach($category as $row){

                $data = $row;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','category'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Category found for user'];
            return response()->json($response,200);
        }
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
    }

    public function addCategory(Request $request){

        $this->validate($request,[
            'name'=>'required',
            'id'=>'required',
            
        ]); 
       
    
        $data = new Category();
        $data->name=$request->input('name');
        $data->added_by=$request->input('id');
        
      
        $data->save();


        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Inventory  Created successful', 'category' => $data];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Inventory Successfully'];
            return response()->json($response,200);
        }

       
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

        $this->validate($request,[
            'name'=>'required',
            'cost_price'=>'required',
            'sales_price'=>'required',
            'unit'=>'required',
            'id'=>'required',
            
        ]); 
        
        $usr = User::find($request->input('id'));
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
            
            $old=Items::where(DB::raw('lower(name)'), strtolower($request->input('name')))->where('added_by', $added_by)->first();  

            if (empty($old)) { 

            $data = new Items();
            $data->name=$request->input('name');
            $data->cost_price=$request->input('cost_price');
            $data->category_id=$request->input('category_id');
            $data->sales_price=$request->input('sales_price');
            $data->unit=$request->input('unit');
            
            $data->type = 1;
            
            if(is_null($request->input('quantity'))){
                $data->quantity= 0;
            }
            else{
                $data->quantity=$request->input('quantity');
            }
            
            $data->description=$request->input('description');
            $data->manufacture=$request->input('manufacturer');
            $data->barcode=$request->input('barcode');
            $data->added_by=$added_by;
    
            $data->save();
    
            // $dt = $data->id;
    
            if(!empty($data)){
                $activity =Activity::create(
                    [ 
                        'added_by'=> $data->added_by,
                         'user_id'=> $usr->id,
                        'module_id'=>$data->id,
                         'module'=>'Inventory',
                        'activity'=>"Inventory " .  $data->name. "  Created",
                    ]
                    );                      
                }
                
                
                
                if(is_null($request->input('quantity'))){
                $quantity = 0;
            }
            else{
                $quantity = $request->input('quantity');
            }
                
                
                 $today=date('Y-m-d');
     //dd($today);
        //$new= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($today)->format('Y-m-d');

              $date = explode('-', $today);

     $drjournal= JournalEntry::create([
        'account_id' => AccountCodes::where('account_name','Inventory')->where('added_by', $added_by)->get()->first()->account_id,
       'date' =>  $today, 
        'month' => $date[1],     
        'year' => $date[0],
        'credit' => '0',
        'debit' => $quantity * $request->input('cost_price'),
        'income_id' => $data->id,
        'name' => 'POS Items',
        'transaction_type' => 'import_pos_items',
        'notes' => 'POS Item Balance for ' .$request->input('name'),
        'added_by' => $added_by,
        ]);


        $crjournal= JournalEntry::create([
          'account_id' => AccountCodes::where('account_name','Open Balance')->where('added_by', $added_by)->get()->first()->account_id,
         'date' =>  $today, 
          'month' => $date[1],     
          'year' => $date[0],
          'credit' => $quantity * $request->input('cost_price'),
          'debit' => '0',
          'income_id' => $data->id,
          'name' => 'POS Items',
          'transaction_type' => 'import_pos_items',
          'notes' => 'POS Item Balance for ' .$request->input('name'),
          'added_by' => $added_by,
          ]);
          
          
          
 if( !is_null($request->input('quantity'))  || $request->input('quantity') > 0){ 

                    if(!empty($request->input('location'))){
                        $lists= array(
                            'quantity' =>   $quantity,
                             'item_id' =>$data->id,
                               'added_by' => $added_by,
                             'purchase_date' =>  $today,
                             'location' => $request->input('location'),
                             'price' => $request->input('cost_price'),
                            'type' =>   'Purchases');
                           
                         PurchaseHistory::create($lists);   

                    $loc=Location::find($request->input('location'));
                    $lq['quantity']=$loc->quantity + $quantity;
                    Location::where('id', $request->input('location'))->update($lq);
                    
                    
                    $nameArr = $request->input('quantity');
 if($nameArr > 0){ 
                        
                          $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                        
                         for($x = 1; $x <= $nameArr; $x++){    
                $name=Items::where('id', $data->id)->first();

                    if($name->bar == '1'){ 
                    $due=1 * $name->bottle;
                    }

                    else{
                    $due=1 ;
                    }
              
                        $series = array(
                            'serial_no' => $random."-".$x, 
                            'bar' => $name->bar,                     
                            'brand_id' => $data->id,
                            'added_by' => $added_by,
                            'purchase_date' =>   $today,
                            'location' =>  Location::where('id',$request->input('location'))->first()->id,
                            'quantity' =>  1,
                            'due_quantity' =>  $due,
                            'source_store' => Location::where('id',$request->input('location'))->first()->id,
                            'crate_status' => '0',
                            'status' => '0');
                       
                    
                  SerialList::create($series);   

                   
                    }
                    


               
            
            }
         
                    }
                    else{
                        
                        $lists= array(
                            'quantity' =>   $quantity,
                             'item_id' =>$data->id,
                               'added_by' => $added_by,
                             'purchase_date' =>  $today,
                             'price' => $request->input('cost_price'),
                            'type' =>   'Purchases');
                           
                         PurchaseHistory::create($lists);   

                    // $loc=Location::where('name', $request->input('location'))->where('added_by', $added_by)->first();
                    //     $lq['quantity']=$loc->quantity + $quantity;
                    //     Location::where('name',$row['location'])->where('added_by', $added_by)->update($lq);
         
                    }
    
                       
            
            }
    
            
    
    
            if($data)
            {
                 $x = intval(0);
                $data['quantity'] = $x;
    
                $data['barcode'] = $data->barcode;
    
               
            
                $response=['success'=>true,'error'=>false, 'message' => 'Inventory  Created successful', 'inventory' => $data];
                return response()->json($response, 200);
            }
            else
            {
                
                $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Inventory Successfully'];
                return response()->json($response,200);
            }
                
                
                
                
                
                
            }
            else{
                
                 Items::find($old->id)->update([
                    'quantity' => $old->quantity + $request->input('quantity'),
                    ]);
                    
                    $item= Items::find($old->id);
            
            if(!empty($item)){
                                $activity =Activity::create(
                                    [ 
                                        'added_by'=> $item->added_by,
                                         'user_id'=> $usr->id,
                                        'module_id'=>$item->id,
                                         'module'=>'Inventory',
                                        'activity'=>"Inventory " .  $item->name. " is Updated",
                                    ]
                                    );                      
            } 
            
            
            
            if($item)
            {
                 $x = intval(0);
                $item['quantity'] = $x;
    
                $item['barcode'] = $item->barcode;
    
               
            
                $response=['success'=>true,'error'=>false, 'message' => 'Inventory  Created successful', 'inventory' => $item];
                return response()->json($response, 200);
            }
            else
            {
                
                $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Inventory Successfully'];
                return response()->json($response,200);
            }
            
            
            
            }
                
                
                
            
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
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
        $this->validate($request,[
            'name'=>'required',
            'cost_price'=>'required',
            'sales_price'=>'required',
            'unit'=>'required',
            
        ]); 

        $data = Items::find($request->input('id'));

        $data->name=$request->input('name');
        $data->cost_price=$request->input('cost_price');
        $data->sales_price=$request->input('sales_price');
        $data->unit=$request->input('unit');
        $data->quantity=$request->input('quantity');
        $data->description=$request->input('description');
        $data->manufacturer=$request->input('manufacturer');
        $data->barcode=$request->input('barcode');
        $data->added_by=$request->input('id');

        $seed =  $data->update();


        // $dt = $data->id;

        if(!empty($data)){
            $activity =Activity::create(
                [ 
                    'added_by'=> $data->added_by,
                    'module_id'=>$data->id,
                     'module'=>'Inventory',
                    'activity'=>"Inventory " .  $data->name. "  Updated",
                ]
                );                      
            }

        


        if($seed)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Inventory Updated successful', 'inventory' => $data];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Update Inventory Successfully'];
            return response()->json($response,200);
        }
        
    }
    
    public function quantity_update(Request $request){
        
        $this->validate($request,[
            'location'=>'required',
            'price'=>'required',
            'quantity'=>'required',
            'item_id'=>'required',
            'id'=>'required',
            
        ]); 
        
        $usr = User::find($request->input('id'));
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
        
        $item=Items::find($request->item_id);
     $data['quantity'] = $item->quantity + $request->quantity;
     $data['cost_price'] =  $request->price;
       $seed = $item->update($data);
        
        $today=date('Y-m-d');

     $lists= array(
                            'quantity' =>   $request->quantity,
                          'price' => $request->price,
                             'item_id' =>$item->id,
                               'added_by' => $added_by,
                             'purchase_date' =>   $today,
                             'location' => $request->location,
                            'type' =>   'Purchases');
                           
                         PurchaseHistory ::create($lists);  
                         
                         
                          $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                    
                for($x = 1; $x <= $request->quantity; $x++){    
                $name=Items::where('id', $request->item_id)->first();

                    if($name->bar == '1'){ 
                    $due=1 * $name->bottle;
                    }

                    else{
                    $due=1 ;
                    }
              
                        $series = array(
                            'serial_no' => $random."-".$x, 
                            'bar' => $name->bar,                     
                            'brand_id' => $request->item_id,
                            'added_by' => $added_by,
                            'purchase_date' =>   $today,
                            'location' => $request->location,
                            'quantity' =>  1,
                            'due_quantity' =>  $due,
                            'source_store' =>$request->location,
                            'crate_status' => '0',
                            'status' => '0');
                       
                    
                  SerialList::create($series);   

                   
                    }
               
           

                    $loc=Location::find($request->location);
                         if($item->bar == '1'){ 
                        $lq['crate']=$loc->crate +$request->quantity;
                        $lq['bottle']=$loc->bottle+ ($request->quantity * $item->bottle);
                            }
                   
                        $lq['quantity']=$loc->quantity + $request->quantity;
                        $loc->update($lq);
                        
                                          $cost=abs($request->price *  $request->quantity);           
             $tax=$cost * $item->tax_rate ;
             
          if($request->price *  $request->quantity > 0){
          $cr= AccountCodes::where('account_name','Purchases')->where('added_by',$added_by)->first();
        //   dd($cr);
          $journal = new JournalEntry();
          $journal->account_id =$cr->id;
          $date = explode('-',$today);
          $journal->date =   $today ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_update_item';
          $journal->name = 'Items';
          $journal->debit = $cost;
          $journal->income_id= $item->id;
          $journal->added_by=$added_by;
        
          $journal->notes= "POS Item Update for ".  $item->name ;
          $journal->save();
          
          if($tax > 0){
         $vat= AccountCodes::where('account_name','VAT IN')->where('added_by',$added_by)->first();
         $journal = new JournalEntry();
          $journal->account_id = $vat->id;
          $date = explode('-',$today);
          $journal->date =   $today;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_update_item';
          $journal->name = 'Items';
          $journal->debit = $tax;
          $journal->income_id= $item->id;
          $journal->added_by=$added_by;
         
          $journal->notes= "POS Item Update for ".  $item->name;
          $journal->save();
        }

          $codes= AccountCodes::where('account_name','Balance Control')->where('added_by',$added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$today);
          $journal->date =   $today;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_update_item';
          $journal->name = 'Items';
          $journal->income_id= $item->id;
          $journal->credit = $cost + $tax;
          $journal->added_by=$added_by;
         
          $journal->notes= "POS Item Update for ".  $item->name ;
          $journal->save();

          }

          else{

          $codes= AccountCodes::where('account_name','Balance Control')->where('added_by',$added_by)->first(); 
          $journal = new JournalEntry();
          $journal->account_id =$codes->id;
          $date = explode('-',$today);
          $journal->date =   $today;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_update_item';
          $journal->name = 'Items';
          $journal->debit = $cost + $tax;
          $journal->income_id= $item->id;
          $journal->added_by=$added_by;
         
          $journal->notes= "POS Item Update for ".  $item->name ;
          $journal->save();

          
          $cr= AccountCodes::where('account_name','Purchases')->where('added_by',$added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$today);
          $journal->date =   $today ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_update_item';
          $journal->name = 'Items';
          $journal->income_id= $item->id;
          $journal->credit = $cost ;
          $journal->added_by=$added_by;
         
          $journal->notes= "POS Item Update for ".  $item->name ;
          $journal->save();
          
           if($tax > 0){
         $vat= AccountCodes::where('account_name','VAT IN')->where('added_by',$added_by)->first();
         $journal = new JournalEntry();
          $journal->account_id = $vat->id;
          $date = explode('-',$today);
          $journal->date =   $today ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_update_item';
          $journal->name = 'Items';
          $journal->credit = $tax;
          $journal->income_id= $item->id;
          $journal->added_by=$added_by;
         
          $journal->notes= "POS Item Update for ".  $item->name;
          $journal->save();
        }

          }
          
          if($seed)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Inventory Updated successful', 'inventory' => $item];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Update Inventory Successfully'];
            return response()->json($response,200);
        }
          
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
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

        $data = Items::find($id);

        if(!empty($data)){
            $activity =Activity::create(
                [ 
                    'added_by'=> $data->added_by,
                    'module_id'=> $id,
                     'module'=>'Inventory',
                    'activity'=>"Inventory " .  $data->name. "  Deleted",
                ]
                );                      
        }


        $crop = $data->delete();


 
        if($crop)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'Inventory deleted'];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to delete Inventory'];
            return response()->json($response,200);
        }

    }

   
}
