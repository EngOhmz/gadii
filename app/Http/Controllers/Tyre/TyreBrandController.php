<?php

namespace App\Http\Controllers\Tyre;

use App\Http\Controllers\Controller;
use App\Models\Tyre\TyreActivity;
use App\Models\Tyre\TyreBrand;
use App\Models\Tyre\MasterHistory;
use App\Models\Tyre\Tyre;
use App\Models\Tyre\TyreHistory;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DB;
use App\Models\AccountCodes;
use App\Models\JournalEntry;

class TyreBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        //
      $tyre= [];
        
          if ($request->ajax()) {
            $tyre = TyreBrand::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get();
            //dd($tyre);
            return Datatables::of($tyre)
                    ->addIndexColumn()
                       
                     ->editColumn('price', function ($row) {
                        return number_format($row->price,2);
                   })
                     
                     ->editColumn('quantity', function ($row) {
                        return number_format($row->quantity,2);
                   })

                    ->editColumn('action', function($row){
                        $action='';
                   
                            $action=' <div class="form-inline"><a href="'.route('tyre_brand.edit',$row->id).'"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
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
        
      
       return view('tyre.tyre_brand',compact('tyre'));
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
        $tyre = TyreBrand::create($data);

        if(!empty($tyre)){
        $activity = TyreActivity::create(
            [ 
                'added_by'=>auth()->user()->added_by,
                'module_id'=>$tyre->id,
                'module'=>'Tyre Brand',
                'activity'=>"Tyre brand  " .  $tyre->brand. "  Created",
                'date'=>date('Y-m-d'),
            ]
            );                      
}
 
        return redirect(route('tyre_brand.index'))->with(['success'=>'Tyre Created Successfully']);
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
                              
       return view('tyre.update_quantity',compact('id','location'));
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
        $data =  TyreBrand::find($id);
        return view('tyre.tyre_brand',compact('data','id'));
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
        $tyre =  TyreBrand::find($id);
        $data=$request->post();
        $data['added_by']=auth()->user()->added_by;
        $tyre->update($data);

        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$tyre->id,
                    'module'=>'Tyre Brand',
                    'activity'=>"Tyre brand  " .  $tyre->brand. "  Updated",
                    'date'=>date('Y-m-d'),
                ]
                );                      
    }
 
        return redirect(route('tyre_brand.index'))->with(['success'=>'Tyre Updated Successfully']);
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
        
        $tyre = TyreBrand::find($id);
       $tyre->update(['disabled'=> '1']);

        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$tyre->id,
                    'module'=>'Tyre Brand',
                   'activity'=>"Tyre brand  " .  $tyre->brand. "  Deleted",
                    'date'=>date('Y-m-d'),
                ]
                );                      
    }
 
 
       return response()->json(['success'=>'Deleted Successfully']);
    }
    
    
     public function findItem(Request $request){
  

$loc=TyreBrand::where(DB::raw('lower(brand)'), strtolower($request->id))->where('disabled','0')->where('added_by',auth()->user()->added_by)->first();  

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
     $item=TyreBrand::find($request->id);
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
                           
                        TyreHistory ::create($lists); 
                        
                        
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
                          $words = preg_split("/\s+/", $item->brand);
                          $acronym = "";
                            
                           foreach ($words as $w) {
                              $acronym .= mb_substr($w, 0, 1);
                            }
                            $a=strtoupper($acronym);
                    
                        for($x = 1; $x <= $request->quantity; $x++){    
                        $name=TyreBrand::where('id', $request->id)->first();

              
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
                       
                    
                                Tyre::create($series);   

                   
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
          $journal->transaction_type = 'update_tire';
          $journal->name = 'Tire';
          $journal->debit = $cost;
          $journal->income_id= $item->id;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Tire Update for ".  $item->brand ;
          $journal->save();
          
          $codes= AccountCodes::where('account_name','Balance Control')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$request->purchase_date);
          $journal->date =   $request->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'update_tire';
          $journal->name = 'Tire';
          $journal->income_id= $item->id;
          $journal->credit = $cost;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Tire Update for ".  $item->brand ;
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
          $journal->transaction_type = 'update_tire';
          $journal->name = 'Tire';
          $journal->debit = $cost;
          $journal->income_id= $item->id;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Tire Update for ".  $item->brand ;
          $journal->save();

          
          $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$request->purchase_date);
          $journal->date =   $request->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'update_tire';
          $journal->name = 'Tire';
          $journal->income_id= $item->id;
          $journal->credit = $cost ;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Tire Update for ".  $item->brand ;
          $journal->save();
          
          

          }


    return redirect(route('tyre_brand.index'))->with(['success'=>'Updated Successfully']);;
    }
    
    
    
}
