<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\InvoicePayments;
use App\Models\InvoiceHistory;
use App\Models\MasterHistory;
use App\Models\GoodIssue;
use App\Models\GoodIssueItem;
use App\Models\StockMovement;
use App\Models\StockMovementItem;
use App\Models\GoodDisposal;
use App\Models\GoodDisposalItem;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\PurchaseInventory;
use App\Models\PurchaseItemInventory;
use App\Models\Client;
use App\Models\InventoryList;
use App\Models\User;
use PDF;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function __construct()
    {
        $this->middleware('auth');
    }

    
    
        public function report_by_date(Request $request)
    {
    
    
    $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
   
                        if(!empty($location[0])){                      
                         foreach($location as $loc){
                          $x[]=$loc->id;
                        
                            }
                            }
                            
                            else{
                                 $x[]='';  
                            }
                            
        $start_date = $request->start_date;
        $end_date = $request->end_date;  
        $location_id = $request->location_id; 

        $z[]=$location_id;   
        
        $a=  trim(json_encode($x), '[]'); 
                  if($location_id == $a){
                     $loc_id=$x;
                 }
                 
                 else{
                     
                  $loc_id=$z;    
                 }
                 
                 
                 
       
        
       $data=[];
        
             
       if ($request->ajax()) {
           
        $added_by = auth()->user()->added_by;
        
        $rowDatampya = "SELECT inventory_master_history.item_id as id,inventories.name , SUM(CASE WHEN inventory_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' THEN inventory_master_history.in ELSE 0 END) AS in_qty, 
        SUM(CASE WHEN inventory_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' THEN inventory_master_history.out  ELSE 0 END) AS out_qty, SUM(CASE WHEN inventory_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' THEN inventory_master_history.in - inventory_master_history.out ELSE 0 END) AS balance,
        SUM(CASE WHEN inventory_master_history.date < '".$start_date."' THEN inventory_master_history.in - inventory_master_history.out ELSE 0 END) AS open_balance 
        FROM `inventory_master_history` JOIN inventories ON inventories.id=inventory_master_history.item_id  WHERE inventories.disabled = '0' AND inventory_master_history.location IN ($location_id)  AND inventory_master_history.added_by = '".$added_by."' AND inventories.added_by = '".$added_by."' GROUP by inventory_master_history.item_id ";
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                
                       
                    $name= $row->name ; 
                    return $name;
 
           
            });
                    
        $dt = $dt->editColumn('open', function ($row){
                        
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="open_in_qty" data-toggle="modal" data-target="#viewModal">'.number_format($row->open_balance,2).'</a>';
        });
        
       $dt = $dt->editColumn('in', function ($row){
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="in_qty" data-toggle="modal" data-target="#viewModal">'.number_format($row->in_qty,2).'</a>';
       });
        $dt = $dt->editColumn('out', function ($row) {
           return '<a href="#" class="item"  data-id = "'.$row->id.'" data-type="out_qty" data-toggle="modal" data-target="#viewModal">'.number_format($row->out_qty,2).'</a>';
       });
       
      
         $dt = $dt->editColumn('balance', function ($row) {
            return number_format($row->open_balance + $row->balance ,2);
       });

       $dt = $dt->rawColumns(['open','in','out','balance']);
        return $dt->make(true);
        }
       
  
 
        return view('inventory.report.report_by_date',
          compact('data','start_date','end_date','location','x','z','location_id'));
    
    }


public function stock_report(Request $request)
    {
    
      $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
   
                        if(!empty($location[0])){                      
                         foreach($location as $loc){
                          $x[]=$loc->id;
                        
                            }
                            }
                            
                            else{
                                 $x[]='';  
                            }
                            
        $start_date = $request->start_date;
        $end_date = $request->end_date;  
        $location_id = $request->location_id; 

        $z[]=$location_id;   
        
        $a=  trim(json_encode($x), '[]'); 
                  if($location_id == $a){
                     $loc_id=$x;
                 }
                 
                 else{
                     
                  $loc_id=$z;    
                 }
                 
                 
                 
        //$data=Items::select('*')->where('added_by',auth()->user()->added_by)->where('restaurant',0)->where('disabled',0)->where('type','!=',4);  
        
       $data=[];
        
             
       if ($request->ajax()) {
           
        $added_by = auth()->user()->added_by;
        
        $rowDatampya = "SELECT inventory_master_history.item_id as id,inventories.name , SUM(CASE WHEN inventory_master_history.date < '".$start_date."' AND inventory_master_history.type IN('Purchases','Debit Note') THEN inventory_master_history.in * inventory_master_history.price - inventory_master_history.out * inventory_master_history.price ELSE 0 END) AS open_qty,
        SUM(CASE WHEN inventory_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' AND inventory_master_history.type IN('Purchases','Debit Note') THEN inventory_master_history.in * inventory_master_history.price - inventory_master_history.out * inventory_master_history.price ELSE 0 END) AS pur_qty,
        SUM(CASE WHEN inventory_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' AND inventory_master_history.type IN('Sales','Credit Note')THEN inventory_master_history.out * inventory_master_history.price - inventory_master_history.in * inventory_master_history.price ELSE 0 END) AS sales_qty 
        FROM `inventory_master_history` JOIN inventories ON inventories.id=inventory_master_history.item_id  WHERE  inventories.disabled = '0'
        AND inventory_master_history.location IN ($location_id)  AND inventory_master_history.added_by ='".$added_by."' AND inventories.added_by = '".$added_by."' GROUP by inventory_master_history.item_id";
        
       
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                
                       
                    $name= $row->name ; 
                    return $name;
                        
               
           
            });
                    
        $dt = $dt->editColumn('open', function ($row){
                        
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="open_qty" data-toggle="modal" data-target="#viewModal">'.number_format($row->open_qty,2).'</a>';
        });
        
       $dt = $dt->editColumn('purchases', function ($row){
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="pur_qty" data-toggle="modal" data-target="#viewModal">'.number_format($row->pur_qty,2).'</a>';
       });
        $dt = $dt->editColumn('sales', function ($row) {
           return '<a href="#" class="item"  data-id = "'.$row->id.'" data-type="sales_qty" data-toggle="modal" data-target="#viewModal">'.number_format($row->sales_qty,2).'</a>';
       });
       
      
         $dt = $dt->editColumn('balance', function ($row) {
            return number_format(($row->open_qty + $row->pur_qty) - $row->sales_qty  ,2);
       });

       $dt = $dt->rawColumns(['open','purchases','sales','balance']);
        return $dt->make(true);
        }
       
  
             
  

        return view('inventory.report.stock_report',
          compact('data','start_date','end_date','location','x','z','location_id'));
    
    }



public function profit_report(Request $request)
    {
    
       $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
   
                        if(!empty($location[0])){                      
                         foreach($location as $loc){
                          $x[]=$loc->id;
                        
                            }
                            }
                            
                            else{
                                 $x[]='';  
                            }
                            
        $start_date = $request->start_date;
        $end_date = $request->end_date;  
        $location_id = $request->location_id; 

        $z[]=$location_id;   
        
        $a=  trim(json_encode($x), '[]'); 
                  if($location_id == $a){
                     $loc_id=$x;
                 }
                 
                 else{
                     
                  $loc_id=$z;    
                 }
                 
                 
                 
        //$data=Items::select('*')->where('added_by',auth()->user()->added_by)->where('restaurant',0)->where('disabled',0)->where('type','!=',4);  
        
       $data=[];
        
             
       if ($request->ajax()) {
           
        $added_by = auth()->user()->added_by;
        
        $rowDatampya = "SELECT inventory_master_history.item_id as id,inventories.name , SUM(CASE WHEN inventory_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' AND inventory_master_history.type IN('Sales','Credit Note') THEN inventory_master_history.out * inventory_master_history.price - inventory_master_history.in * inventory_master_history.price ELSE 0 END) AS sales_qty, 
        SUM(CASE WHEN inventory_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' AND inventory_master_history.type IN('Sales','Credit Note')THEN inventory_master_history.out * inventories.price - inventory_master_history.in * inventories.price ELSE 0 END) AS cost_qty 
        FROM `inventory_master_history` JOIN inventories ON inventories.id=inventory_master_history.item_id  WHERE  inventories.disabled = '0'
        AND inventory_master_history.location IN ($location_id)  AND inventory_master_history.added_by ='".$added_by."' AND inventories.added_by = '".$added_by."' GROUP by inventory_master_history.item_id";
        
       
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                

                       
                    $name= $row->name ; 
                    return $name;
                        
                  
               
           
            });
                    
       
        
       $dt = $dt->editColumn('sales', function ($row){
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="sales_qty" data-toggle="modal" data-target="#viewModal">'.number_format($row->sales_qty,2).'</a>';
       });
        $dt = $dt->editColumn('cost', function ($row) {
           return '<a href="#" class="item"  data-id = "'.$row->id.'" data-type="cost_qty" data-toggle="modal" data-target="#viewModal">'.number_format($row->cost_qty,2).'</a>';
       });
       
      
         $dt = $dt->editColumn('balance', function ($row) {
            return number_format($row->sales_qty - $row->cost_qty  ,2);
       });

       $dt = $dt->rawColumns(['open','cost','sales','balance']);
        return $dt->make(true);
        }
       
  

        return view('inventory.report.profit_report',
          compact('data','start_date','end_date','location','x','z','location_id'));
    
    }

public function good_issue_report(Request $request)
    {
       
//$data=Items::where('added_by',auth()->user()->added_by)->whereIn('type', [1,2,3])->where('restaurant',0)->where('disabled',0)->get();
       $start_date = $request->start_date;
        $end_date = $request->end_date; 
        $location_id = $request->location_id;
        
        $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         
          if(!empty($location[0])){                      
         
         foreach($location as $loc){
          $x[]=$loc->id;
        
   
}
}

else{
     $x[]='';  
}
 
 $z[]=$location_id;
 
  $a=  trim(json_encode($x), '[]'); 
                  if($location_id == $a){
                     $loc_id=$x;
                 }
                 
                 else{
                     
                  $loc_id=$z;    
                 }
                 
                 
                 
       
        
       $data=[];
        
             
       if ($request->ajax()) {
           
        $added_by = auth()->user()->added_by;
        
        $rowDatampya = " SELECT inventory_master_history.item_id as id,inventories.name ,SUM(CASE WHEN inventory_master_history.type='Good Issue' THEN inventory_master_history.out ELSE 0 END) AS issue_qty,   
                        SUM(CASE WHEN inventory_master_history.type='Returned Good Issue' THEN inventory_master_history.in ELSE 0 END) AS return_qty,SUM(CASE WHEN inventory_master_history.type='Good Issue' THEN inventory_master_history.out ELSE 0 END - CASE WHEN inventory_master_history.type='Returned Good Issue' THEN inventory_master_history.in ELSE 0 END) AS balance, 
                        SUM(CASE WHEN inventory_master_history.type='Good Issue' THEN inventory_master_history.out * inventory_master_history.price ELSE 0 END - CASE WHEN inventory_master_history.type='Returned Good Issue' THEN inventory_master_history.in * inventory_master_history.price ELSE 0 END) AS cost FROM `inventory_master_history` 
                        JOIN inventories ON inventories.id=inventory_master_history.item_id  WHERE inventories.disabled = '0' AND inventory_master_history.location IN ($location_id)  AND inventory_master_history.added_by = '".$added_by."' AND  inventory_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' AND inventories.added_by = '".$added_by."' GROUP by inventory_master_history.item_id ";
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                

                    $name= $row->name ; 
                    return $name;
                        
                   
               
           
            });
                    
        $dt = $dt->editColumn('issue', function ($row){
                        
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="issue_qty" data-toggle="modal" data-target="#viewModal">'.number_format($row->issue_qty,2).'</a>';
        });
        
       $dt = $dt->editColumn('return', function ($row){
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="return_qty" data-toggle="modal" data-target="#viewModal">'.number_format($row->return_qty,2).'</a>';
       });
        $dt = $dt->editColumn('balance', function ($row) {
           return number_format($row->balance,2);
       });
       
      
         $dt = $dt->editColumn('cost', function ($row) {
            return number_format($row->cost ,2);
       });

       $dt = $dt->rawColumns(['issue','return']);
        return $dt->make(true);
        }
       
  

        return view('inventory.report.good_issue_report',
              compact('data','start_date','end_date','location','x','z','location_id'));
    
    }
    
    public function good_disposal_report(Request $request)
    {
       
       
//$data=Items::where('added_by',auth()->user()->added_by)->whereIn('type', [1,2,3])->where('restaurant',0)->where('disabled',0)->get();
       $start_date = $request->start_date;
        $end_date = $request->end_date; 
        $location_id = $request->location_id;
        
        $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         
          if(!empty($location[0])){                      
         
         foreach($location as $loc){
          $x[]=$loc->id;
        
   
}
}

else{
     $x[]='';  
}
 
 $z[]=$location_id;
 
  $a=  trim(json_encode($x), '[]'); 
                  if($location_id == $a){
                     $loc_id=$x;
                 }
                 
                 else{
                     
                  $loc_id=$z;    
                 }
                 
                 
                 
       
        
       $data=[];
        
             
       if ($request->ajax()) {
           
        $added_by = auth()->user()->added_by;
        
        $rowDatampya = "SELECT inventory_master_history.item_id as id,inventories.name , SUM(inventory_master_history.out) AS total_qty,
                        SUM(inventory_master_history.out * inventory_master_history.price) AS total_cost FROM `inventory_master_history` JOIN inventories ON inventories.id=inventory_master_history.item_id  
                        WHERE inventory_master_history.type='Good Disposal' AND inventory_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' AND inventories.disabled = '0' AND inventory_master_history.location IN ($location_id)  AND inventory_master_history.added_by = '".$added_by."' 
                        AND inventories.added_by = '".$added_by."' GROUP by inventory_master_history.item_id ";
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                
 
                       
                    $name= $row->name ; 

                        
                  
                   
                    return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="disposal_qty" data-toggle="modal" data-target="#viewModal">'.$name.'</a>';
               
           
            });
                    
        $dt = $dt->editColumn('qty', function ($row){
                        
        return number_format($row->total_qty,2);
        });
        
       $dt = $dt->editColumn('cost', function ($row){
        return number_format($row->total_cost,2);
       });
       

       $dt = $dt->rawColumns(['name']);
        return $dt->make(true);
        }
       

        return view('inventory.report.good_disposal_report',
              compact('data','start_date','end_date','location','x','z','location_id'));
    
    }
    
    public function stock_movement_report(Request $request)
    {
       
//$data=Items::where('added_by',auth()->user()->added_by)->whereIn('type', [1,2,3])->where('restaurant',0)->where('disabled',0)->get();
       $start_date = $request->start_date;
        $end_date = $request->end_date; 
        $location_id = $request->location_id;
        
        $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         
          if(!empty($location[0])){                      
         
         foreach($location as $loc){
          $x[]=$loc->id;
        
   
}
}

else{
     $x[]='';  
}
 
 $z[]=$location_id;
 
  $a=  trim(json_encode($x), '[]'); 
                  if($location_id == $a){
                     $loc_id=$x;
                 }
                 
                 else{
                     
                  $loc_id=$z;    
                 }
                 
                 
                 
       
        
       $data=[];
        
             
       if ($request->ajax()) {
           
        $added_by = auth()->user()->added_by;
        
        $rowDatampya = "SELECT inventory_master_history.item_id as id,inventories.name , SUM(inventory_master_history.in) AS total_qty,SUM(inventory_master_history.in * inventory_master_history.price) AS total_cost FROM `inventory_master_history` JOIN inventories ON inventories.id=inventory_master_history.item_id  
                        WHERE inventory_master_history.type='Stock Movement' AND inventory_master_history.date BETWEEN '".$start_date."' AND '".$end_date."'  AND inventories.disabled = '0' AND inventory_master_history.location IN ($location_id)  AND inventory_master_history.added_by = '".$added_by."' 
                        AND inventories.added_by = '".$added_by."' GROUP by inventory_master_history.item_id ";
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
    
                       
                    $name= $row->name ; 

                   
                    return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="movement_qty" data-toggle="modal" data-target="#viewModal">'.$name.'</a>';
               
           
            });
                    
        $dt = $dt->editColumn('qty', function ($row){
                        
        return number_format($row->total_qty,2);
        });
        
       $dt = $dt->editColumn('cost', function ($row){
        return number_format($row->total_cost,2);
       });
       

       $dt = $dt->rawColumns(['name']);
        return $dt->make(true);
        }
       
  

        return view('inventory.report.stock_movement_report',
              compact('data','start_date','end_date','location','x','z','location_id'));
    
    }



public function requisition_report(Request $request)
    {
    
      $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
   
                        if(!empty($location[0])){                      
                         foreach($location as $loc){
                          $x[]=$loc->id;
                        
                            }
                            }
                            
                            else{
                                 $x[]='';  
                            }
                            
        $start_date = $request->start_date;
        $end_date = $request->end_date;  
        $location_id = $request->location_id; 

        $z[]=$location_id;   
        
        $a=  trim(json_encode($x), '[]'); 
                  if($location_id == $a){
                     $loc_id=$x;
                 }
                 
                 else{
                     
                  $loc_id=$z;    
                 }
                 
                 
                 
        //$data=Items::select('*')->where('added_by',auth()->user()->added_by)->where('restaurant',0)->where('disabled',0)->where('type','!=',4);  
        
       $data=[];
        
             
       if ($request->ajax()) {
           
        $added_by = auth()->user()->added_by;
        
        $rowDatampya = "SELECT purchase_item_inventories.item_name as id,inventories.name,purchase_inventories.reference_no,purchase_item_inventories.purchase_id,
        purchase_item_inventories.quantity,purchase_item_inventories.total_cost,purchase_inventories.approved_by,purchase_inventories.status,purchase_inventories.req_id 
        FROM purchase_inventories JOIN purchase_item_inventories ON  purchase_inventories.id= purchase_item_inventories.purchase_id 
        JOIN inventories ON inventories.id=purchase_item_inventories.item_name  WHERE  inventories.disabled = '0' 
        AND purchase_inventories.purchase_date BETWEEN '".$start_date."' AND '".$end_date."' AND purchase_inventories.location IN ($location_id)  
        AND purchase_inventories.added_by ='".$added_by."'";
        
       
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);

        $dt = $dt->editColumn('req', function ($row) {

            if(!empty($row->req_id)){
            $a=Requisition::find($row->req_id);
             return '<a href="'.route('requisition.show',$row->req_id).'" target="_blank">'.$a->reference_no.'</a>'; 
            }
            else{
            return '-' ;
            }
         
            });

        $dt = $dt->editColumn('ref', function ($row) {
                     
                $ref= $row->reference_no ; 
                 return '<a href="'.route('purchase_inventory.show',$row->purchase_id).'" target="_blank">'.$row->reference_no.'</a>'; 
        });

       
             
        $dt = $dt->editColumn('name', function ($row) {
                    $name= $row->name ; 
                    return $name;
           
            });

            $dt = $dt->editColumn('qty', function ($row) {
                    return number_format($row->quantity,2) ; 
           
            });

            $dt = $dt->editColumn('cost', function ($row) {
                    return number_format($row->total_cost,2) ; 
           
            });

            
            $dt = $dt->editColumn('user', function ($row) {
              $b=User::find($row->approved_by);
              if(!empty($b)){
              $user=$b->name ; 
            }
            else{
              $user='';
            }
                return $user ; 
           
            });


            $dt = $dt->editColumn('status', function ($row) {
                if($row->status == 0){
                return '<div class="badge badge-danger badge-shadow">Not Approved</div>';
                }elseif($row->status == 1){
                return '<div class="badge badge-warning badge-shadow">Not Paid</div>';
                }elseif($row->status == 2){
                return '<div class="badge badge-info badge-shadow">Partially Paid</div>';
                }elseif($row->status == 3){
                return '<div class="badge badge-success  badge-shadow">Fully Paid</div>';
                }elseif($row->status == 4){
                return '<div class="badge badge-danger  badge-shadow">Cancelled</div>';
                }
                    });
                  
        
         $dt = $dt->rawColumns(['status','req','ref']);
         return $dt->make(true);
        }
       
  
             
  

        return view('inventory.report.requisition_report',
          compact('data','start_date','end_date','location','x','z','location_id'));
    
    }




   
    

public function discountModal(Request $request)
    {

         $id=$request->id;
         $type = $request->type;
         $start_date = $request->start_date;
         $end_date = $request->end_date;  
         $location_id = $request->loc_id;
         $added_by=auth()->user()->added_by;
         
     $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
   
                        if(!empty($location[0])){                      
                         foreach($location as $loc){
                          $x[]=$loc->id;
                        
                            }
                            }
                            
                            else{
                                 $x[]='';  
                            }


        $z[]=$location_id;   
        
        $a=  trim(json_encode($x), '[]'); 
                  if($location_id == $a){
                     $loc_id=$x;
                 }
                 
                 else{
                     
                  $loc_id=$z;    
                 }

//dd($type);
          switch ($type) {      
          case 'open_qty':
          $key=Inventory::find($id); 
          
         
          return view('inventory.report.modal.open_qty',compact('id','start_date','end_date','loc_id','key'));
                    break;
          case 'pur_qty':
          $key=Inventory::find($id);      
          return view('inventory.report.modal.pur_qty',compact('id','start_date','end_date','loc_id','key'));
                    break;
          case 'sales_qty':
          $key=Inventory::find($id);      
          return view('inventory.report.modal.sales_qty',compact('id','start_date','end_date','loc_id','key'));
                    break;  
                    
             case 'cost_qty':
          $key=Inventory::find($id);      
          return view('inventory.report.modal.cost_qty',compact('id','start_date','end_date','loc_id','key'));
                    break;  
                    
            
           case 'open_in_qty':
          $key=Inventory::find($id); 
         $rowDatampya= "SELECT *  FROM `inventory_master_history` WHERE location IN ($location_id) AND date < '".$start_date."' AND inventory_master_history.added_by = '".$added_by."' AND  inventory_master_history.item_id ='".$id."' ORDER BY date DESC " ;
         $account = DB::select($rowDatampya);
         
          return view('inventory.report.modal.open_in_qty',compact('id','start_date','end_date','loc_id','key','account'));
                    break;        

           case 'in_qty':
          $key=Inventory::find($id); 
           $rowDatampya= "SELECT *  FROM `inventory_master_history` WHERE location IN ($location_id) AND date BETWEEN '".$start_date."' AND '".$end_date."' AND added_by = '".$added_by."' AND item_id ='".$id."'  AND `in` > 0 ORDER BY date DESC " ;
         $account = DB::select($rowDatampya);
          return view('inventory.report.modal.in_qty',compact('id','start_date','end_date','loc_id','key','account'));
                    break;
          case 'out_qty':
          $key=Inventory::find($id);  
          $rowDatampya= "SELECT *  FROM `inventory_master_history` WHERE location IN ($location_id) AND date BETWEEN '".$start_date."' AND '".$end_date."' AND added_by = '".$added_by."' AND item_id ='".$id."'  AND `out` > 0 ORDER BY date DESC " ;
         $account = DB::select($rowDatampya);
          return view('inventory.report.modal.out_qty',compact('id','start_date','end_date','loc_id','key','account'));
                    break; 
        case 'issue_qty':
          $key=Inventory::find($id);
          $rowDatampya= "SELECT *  FROM `inventory_master_history` WHERE location IN ($location_id) AND date BETWEEN '".$start_date."' AND '".$end_date."' AND added_by = '".$added_by."' AND item_id ='".$id."'   AND type = 'Good Issue' ORDER BY date DESC " ;
         $account = DB::select($rowDatampya);
          return view('inventory.report.modal.issue_qty',compact('id','start_date','end_date','loc_id','key','account'));
                    break; 
        case 'return_qty':
          $key=Inventory::find($id);  
          $rowDatampya= "SELECT *  FROM `inventory_master_history` WHERE location IN ($location_id) AND date BETWEEN '".$start_date."' AND '".$end_date."' AND added_by = '".$added_by."' AND item_id ='".$id."'   AND type = 'Returned Good Issue' ORDER BY date DESC " ;
         $account = DB::select($rowDatampya);
          return view('inventory.report.modal.return_issue_qty',compact('id','start_date','end_date','loc_id','key','account'));
                    break;             
                     case 'movement_qty':
          $key=Inventory::find($id);      
          return view('inventory.report.modal.movement_qty',compact('id','start_date','end_date','loc_id','key'));
                    break; 
                     case 'disposal_qty':
          $key=Inventory::find($id);      
          return view('inventory.report.modal.disposal_qty',compact('id','start_date','end_date','loc_id','key'));
                    break; 
                    
                                   
     

 default:
             break;

            }

                       }
                       
                       
                       
                      


}
