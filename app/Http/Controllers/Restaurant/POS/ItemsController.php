<?php

namespace App\Http\Controllers\Restaurant\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use  App\Models\POS\Items;
use App\Models\POS\Activity;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\SerialList;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use DB;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
          if ($request->ajax()) {
            $data = Items::select('*')->where('disabled','0')->where('restaurant','1')->where('added_by',auth()->user()->added_by);
            return Datatables::of($data)
                    ->addIndexColumn()
                        ->editColumn('type', function ($row) {
                        if ($row->bar == 0) {
                            return 'Kitchen';
                        }
                         elseif ($row->bar == 1) {
                            return 'Drinks';
                        }
                        
                        
                       
                    })
                          ->editColumn('cost_price', function ($row) {
                        return number_format($row->cost_price,2);
                   })
                       ->editColumn('sales_price', function ($row) {
                        return number_format($row->sales_price,2);
                   })
                     ->editColumn('quantity', function ($row) {
                        return number_format(floor($row->quantity),2);
                   })

                    ->editColumn('action', function($row){
               $action=' <div class="form-inline"><a href="'.route('restaurant_items.edit',$row->id).'"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
                    <a href="javascript:void(0)"   onclick = "deleteItem('.$row->id.')"  title="Delete " class="list-icons-item text-danger delete" > <i class="icon-trash"></i> </a>&nbsp
       <div class="dropdown"><a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a><div class="dropdown-menu">
               <a href="#"   onclick = "model('.$row->id.')"  class="nav-link" title="Update"  data-toggle="modal" data-target="#appFormModal"> Update Quantity</a>
                                     </div></div>
                                 
                                </div>';
                      
                    return $action;   
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        
        return view('restaurant.pos.items.index');
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
        $data = $request->all();
        if($request->type == 'Kitchen'){
            $data['bar'] = 0; 
        }
        elseif($request->type == 'Drinks'){
            $data['bar'] = 1; 
        }
         $data['type'] = 1; 
         $data['restaurant'] = 1; 
        $data['added_by'] = auth()->user()->added_by;
        $items = Items::create($data);

       if(!empty($items)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$items->id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $items->name. "  Created",
                        ]
                        );                      
       }

       
        return redirect(route('restaurant_items.index'))->with(['success'=>'Created Successfully']);
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
       $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
       return view('restaurant.pos.items.update',compact('id','location'));
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
       $data=Items::find($id);
    return view('restaurant.pos.items.index',compact('data','id'));
    
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
     $item=Items::find($id);
     $data = $request->all();
     if($request->type == 'Kitchen'){
            $data['bar'] = 0; 
        }
        elseif($request->type == 'Drinks'){
            $data['bar'] = 1; 
        }
         $data['type'] = 1; 
         $data['restaurant'] = 1; 
        $item->update($data);

if(!empty($item)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $item->name. "  Updated",
                        ]
                        );                      
       }
        
    return redirect(route('restaurant_items.index'))->with(['success'=>'Updated Successfully']);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        //
  $item=Items::find($id);
  $name=$item->name;
  $item->update(['disabled'=> '1']);

if(!empty($item)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $name. "  Deleted",
                        ]
                        );                      
       }
        
return response()->json(['success'=>'Deleted Successfully']);
    }
    
    
public function findItem(Request $request){
  

$loc=Items::where(DB::raw('lower(name)'), strtolower($request->id))->where('added_by',auth()->user()->added_by)->first();  

    if (empty($loc)) {    
 $region='';    
}
else{
$region='error';

}
  
 return response()->json($region);
     
   }

 public function update_quantity(Request $request)
    {
        //
     $item=Items::find($request->id);
     $data['quantity'] = $item->quantity + $request->quantity;
        $item->update($data);

     $lists= array(
                            'quantity' =>   $request->quantity,
                          'price' => $item->cost_price,
                             'item_id' =>$item->id,
                               'added_by' => auth()->user()->added_by,
                             'purchase_date' =>   $request->purchase_date,
                             'location' => $request->location,
                            'type' =>   'Purchases');
                           
                         PurchaseHistory ::create($lists);  
                         
                           if($request->quantity > 0){
                          $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                    
                for($x = 1; $x <= $request->quantity; $x++){    
                $name=Items::where('id', $request->id)->first();

                    if($name->bar == '1'){ 
                    $due=1 * $name->bottle;
                    }

                    else{
                    $due=1 ;
                    }
              
                        $series = array(
                            'serial_no' => $random."-".$x, 
                            'bar' => $name->bar,                     
                            'brand_id' => $request->id,
                            'added_by' => auth()->user()->added_by,
                            'purchase_date' =>   $request->purchase_date,
                            'location' => $request->location,
                            'quantity' =>  1,
                            'due_quantity' =>  $due,
                            'source_store' =>$request->location,
                            'crate_status' => '0',
                            'status' => '0');
                       
                    
                  SerialList::create($series);   

                   
                    }
               
                           }

                    $loc=Location::find($request->location);
                         if($item->bar == '1'){ 
                        $lq['crate']=$loc->crate +$request->quantity;
                        $lq['bottle']=$loc->bottle+ ($request->quantity * $item->bottle);
                            }
                   
                        $lq['quantity']=$loc->quantity + $request->quantity;
                        $loc->update($lq);
                        
            $cost=abs($item->cost_price *  $request->quantity);           
             $tax=0;
             
          if($item->cost_price *  $request->quantity > 0){
          $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id =$cr->id;
          $date = explode('-',$request->purchase_date);
          $journal->date =   $request->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_update_item';
          $journal->name = 'Items';
          $journal->debit = $cost;
          $journal->income_id= $item->id;
          $journal->added_by=auth()->user()->added_by;
        
          $journal->notes= "POS Item Update for ".  $item->name ;
          $journal->save();
          


          $codes= AccountCodes::where('account_name','Balance Control')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$request->purchase_date);
          $journal->date =   $request->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_update_item';
          $journal->name = 'Items';
          $journal->income_id= $item->id;
          $journal->credit = $cost + $tax;
          $journal->added_by=auth()->user()->added_by;
         
          $journal->notes= "POS Item Update for ".  $item->name ;
          $journal->save();

          }

          else{

          $codes= AccountCodes::where('account_name','Balance Control')->where('added_by',auth()->user()->added_by)->first(); 
          $journal = new JournalEntry();
          $journal->account_id =$codes->id;
          $date = explode('-',$request->purchase_date);
          $journal->date =   $request->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_update_item';
          $journal->name = 'Items';
          $journal->debit = $cost + $tax;
          $journal->income_id= $item->id;
          $journal->added_by=auth()->user()->added_by;
         
          $journal->notes= "POS Item Update for ".  $item->name ;
          $journal->save();

          
          $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$request->purchase_date);
          $journal->date =   $request->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_update_item';
          $journal->name = 'Items';
          $journal->income_id= $item->id;
          $journal->credit = $cost ;
          $journal->added_by=auth()->user()->added_by;
         
          $journal->notes= "POS Item Update for ".  $item->name ;
          $journal->save();
          


          }


    return redirect(route('restaurant_items.index'))->with(['success'=>'Updated Successfully']);;
    }
    

    
}
