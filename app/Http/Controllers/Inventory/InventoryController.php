<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Inventory;
use App\Models\MasterHistory;
use App\Models\InventoryHistory;
use App\Models\InventoryList;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $inventory= Inventory::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        
          if ($request->ajax()) {
            $data = Inventory::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                       
                     ->editColumn('price', function ($row) {
                        return number_format($row->price,2);
                   })
                     
                     ->editColumn('quantity', function ($row) {
                        return number_format($row->quantity,2);
                   })

                    ->editColumn('action', function($row){
                        $action='';
                   
                            $action=' <div class="form-inline"><a href="'.route('inventory.edit',$row->id).'"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
                    <a href="javascript:void(0)"   onclick = "deleteItem('.$row->id.')"  title="Delete " class="list-icons-item text-danger delete" > <i class="icon-trash"></i> </a>&nbsp
                       <div class="dropdown"><a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a><div class="dropdown-menu">
               <a href="#" onclick = "model('.$row->id.')" data-id = "'.$row->id.'" class="nav-link" title="Update"  data-toggle="modal" data-target="#appFormModal"> Update Quantity</a>
                                     </div></div>
                                </div>';
                      
                         
                      
                    return $action;   
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
      
        return view('inventory.inventory',compact('inventory'));
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

        $data=$request->post();
        $data['added_by']=auth()->user()->added_by;
        $inventory = Inventory::create($data);
 
        return redirect(route('inventory.index'))->with(['success'=>'Inventory Created Successfully']);
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
                              
       return view('inventory.update_quantity',compact('id','location'));
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
        $data =  Inventory::find($id);
        return view('inventory.inventory',compact('data','id'));
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
        $inventory =  Inventory::find($id);
        $data=$request->post();
        $data['added_by']=auth()->user()->added_by;
        $inventory->update($data);
 
        return redirect(route('inventory.index'))->with(['success'=>'Inventory Updated Successfully']);
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
        $inventory =  Inventory::find($id);
        $inventory->update(['disabled'=> '1']);
 
       return response()->json(['success'=>'Inventory Deleted Successfully']);
    }
    
    
    public function findItem(Request $request){
  

$loc=Inventory::where(DB::raw('lower(name)'), strtolower($request->id))->where('disabled','0')->where('added_by',auth()->user()->added_by)->first();  

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
     $item=Inventory::find($request->id);
     $data['quantity'] = $item->quantity + $request->quantity;
        $item->update($data);

                     $lists= array(
                            'quantity' =>   $request->quantity,
                            'price' => $item->price,
                             'item_id' =>$item->id,
                             'added_by' => auth()->user()->added_by,
                             'user_id' => auth()->user()->id,
                             'purchase_date' =>   $request->purchase_date,
                             'location' => $request->location,
                            'type' =>   'Purchases');
                           
                        InventoryHistory ::create($lists); 
                        
                        
                        if($request->quantity > 0){
                             
                          $mlists = [
                        'in' => $request->quantity,
                        'price' => $item->price,
                        'item_id' => $item->id,
                        'added_by' => auth()->user()->added_by,
                        'location' =>  $request->location,
                        'date' =>$request->purchase_date,
                        'type' => 'Purchases',
                    ];

                    
                         }
                         
                         
                         else{
                             
                              $mlists = [
                        'out' => abs($request->quantity),
                        'price' => $item->price,
                        'item_id' => $item->id,
                        'added_by' => auth()->user()->added_by,
                        'location' =>  $request->location,
                        'date' =>$request->purchase_date,
                        'type' => 'Purchases',
                    ];
                             
                             
                         }
                         
                         MasterHistory::create($mlists);
                        
                         
                           if($request->quantity > 0){
                          $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                          $words = preg_split("/\s+/", $item->name);
                          $acronym = "";
                            
                           foreach ($words as $w) {
                              $acronym .= mb_substr($w, 0, 1);
                            }
                            $a=strtoupper($acronym);
                    
                        for($x = 1; $x <= $request->quantity; $x++){    
                        $name=Inventory::where('id', $request->id)->first();

              
                        $series = array(
                            'serial_no' => $a.$random.$x, 
                            'brand_id' => $request->id,
                            'added_by' => auth()->user()->added_by,
                            'purchase_date' =>   $request->purchase_date,
                            'location' => $request->location,
                            'quantity' =>  1,
                            'due_quantity' =>  1,
                            'source_store' =>$request->location,
                            'status' => '0');
                       
                    
                                InventoryList::create($series);   

                   
                    }
               
                           }

                $loc=Location::find($request->location);
                        
                        $lq['quantity']=$loc->quantity + $request->quantity;
                        $loc->update($lq);
                        
                    $cost=abs($item->price *  $request->quantity);           
            
             
          if($item->price *  $request->quantity > 0){
          $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id =$cr->id;
          $date = explode('-',$request->purchase_date);
          $journal->date =   $request->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'update_inventory';
          $journal->name = 'Inventory';
          $journal->debit = $cost;
          $journal->income_id= $item->id;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Inventory Update for ".  $item->name ;
          $journal->save();
          
          $codes= AccountCodes::where('account_name','Balance Control')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$request->purchase_date);
          $journal->date =   $request->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'update_inventory';
          $journal->name = 'Inventory';
          $journal->income_id= $item->id;
          $journal->credit = $cost;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Inventory Update for ".  $item->name ;
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
          $journal->transaction_type = 'update_inventory';
          $journal->name = 'Inventory';
          $journal->debit = $cost;
          $journal->income_id= $item->id;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Inventory Update for ".  $item->name ;
          $journal->save();

          
          $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$request->purchase_date);
          $journal->date =   $request->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'update_inventory';
          $journal->name = 'Inventory';
          $journal->income_id= $item->id;
          $journal->credit = $cost ;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Inventory Update for ".  $item->name ;
          $journal->save();
          
          

          }


    return redirect(route('inventory.index'))->with(['success'=>'Updated Successfully']);;
    }
    
}
