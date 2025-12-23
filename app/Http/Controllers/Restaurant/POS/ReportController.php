<?php

namespace App\Http\Controllers\Restaurant\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Restaurant\POS\Menu;
use App\Models\Restaurant\POS\InvoicePayments;
use App\Models\Restaurant\POS\OrderHistory;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\Items;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
use App\Models\Client;
use App\Models\Restaurant\POS\Activity;
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
                 
                 
                 
        //$data=Items::select('*')->where('added_by',auth()->user()->added_by)->where('restaurant',0)->where('disabled',0)->where('type','!=',4);  
        
       $data=[];
        
             
       if ($request->ajax()) {
           
        $added_by = auth()->user()->added_by;
        
        $rowDatampya = "SELECT pos_master_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color,  SUM(CASE WHEN pos_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' THEN pos_master_history.in ELSE 0 END) AS in_qty, 
        SUM(CASE WHEN pos_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' THEN pos_master_history.out  ELSE 0 END) AS out_qty, SUM(CASE WHEN pos_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' THEN pos_master_history.in - pos_master_history.out ELSE 0 END) AS balance,
        SUM(CASE WHEN pos_master_history.date < '".$start_date."' THEN pos_master_history.in - pos_master_history.out ELSE 0 END) AS open_balance 
        FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color WHERE tbl_items.type != '4' AND tbl_items.restaurant = '1' AND tbl_items.disabled = '0'
        AND pos_master_history.location IN ($location_id)  AND pos_master_history.added_by = '".$added_by."' AND tbl_items.added_by = '".$added_by."' GROUP by pos_master_history.item_id ";
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                
                if(!empty($row->color) && empty($row->size)){
                    $name= $row->name .' - '.$row->color;  
                    return $name;
                   }
                      
                  elseif(empty($row->color) && !empty($row->size)){
                      $name= $row->name .' - '.$row->size;  
                      return $name;
                   } 
                   
                   elseif(!empty($row->color) && !empty($row->size)){
                        $name= $row->name .' - '.$row->color . ' - '.$row->size;
                        return $name;
                   } 
                   
                   else{
                       
                    $name= $row->name ; 
                    return $name;
                        
                   }
               
           
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
       
     

        return view('restaurant.pos.report.report_by_date',
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
        
        $rowDatampya = "SELECT pos_master_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color, SUM(CASE WHEN pos_master_history.date < '".$start_date."' AND pos_master_history.type IN('Purchases','Debit Note') THEN pos_master_history.in * pos_master_history.price - pos_master_history.out * pos_master_history.price ELSE 0 END) AS open_qty,
        SUM(CASE WHEN pos_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' AND pos_master_history.type IN('Purchases','Debit Note') THEN pos_master_history.in * pos_master_history.price - pos_master_history.out * pos_master_history.price ELSE 0 END) AS pur_qty
        FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color WHERE tbl_items.type != '4' AND tbl_items.restaurant = '1' AND tbl_items.disabled = '0'
        AND pos_master_history.location IN ($location_id)  AND pos_master_history.added_by ='".$added_by."' AND tbl_items.added_by = '".$added_by."' GROUP by pos_master_history.item_id";
        
       
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                
                if(!empty($row->color) && empty($row->size)){
                    $name= $row->name .' - '.$row->color;  
                    return $name;
                   }
                      
                  elseif(empty($row->color) && !empty($row->size)){
                      $name= $row->name .' - '.$row->size;  
                      return $name;
                   } 
                   
                   elseif(!empty($row->color) && !empty($row->size)){
                        $name= $row->name .' - '.$row->color . ' - '.$row->size;
                        return $name;
                   } 
                   
                   else{
                       
                    $name= $row->name ; 
                    return $name;
                        
                   }
               
           
            });
                    
        $dt = $dt->editColumn('open', function ($row){
                        
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="open_qty" data-toggle="modal" data-target="#viewModal">'.number_format($row->open_qty,2).'</a>';
        });
        
       $dt = $dt->editColumn('purchases', function ($row){
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="pur_qty" data-toggle="modal" data-target="#viewModal">'.number_format($row->pur_qty,2).'</a>';
       });
      
       
      
         $dt = $dt->editColumn('balance', function ($row) {
            return number_format($row->open_qty + $row->pur_qty  ,2);
       });

       $dt = $dt->rawColumns(['open','purchases','balance']);
        return $dt->make(true);
        }
       
     

        return view('restaurant.pos.report.stock_report',
          compact('data','start_date','end_date','location','x','z','location_id'));
    
    }


    public function kitchen_report(Request $request)
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
        
        $rowDatampya = "SELECT pos_master_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color, SUM(CASE WHEN pos_master_history.date < '".$start_date."' AND pos_master_history.type IN('Purchases','Debit Note') THEN pos_master_history.in - pos_master_history.out  ELSE 0 END) AS open_qty,
        SUM(CASE WHEN pos_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' AND pos_master_history.type IN('Purchases','Debit Note') THEN pos_master_history.in  - pos_master_history.out ELSE 0 END) AS pur_qty,
        SUM(CASE WHEN pos_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' AND pos_master_history.type IN('Good Issue','Returned Good Issue')THEN pos_master_history.out  - pos_master_history.in  ELSE 0 END) AS sales_qty 
        FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color WHERE tbl_items.type != '4' AND tbl_items.restaurant = '1' AND tbl_items.bar = '0' AND tbl_items.disabled = '0'
        AND pos_master_history.location IN ($location_id)  AND pos_master_history.added_by ='".$added_by."' AND tbl_items.added_by = '".$added_by."' GROUP by pos_master_history.item_id";
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                
                if(!empty($row->color) && empty($row->size)){
                    $name= $row->name .' - '.$row->color;  
                    return $name;
                   }
                      
                  elseif(empty($row->color) && !empty($row->size)){
                      $name= $row->name .' - '.$row->size;  
                      return $name;
                   } 
                   
                   elseif(!empty($row->color) && !empty($row->size)){
                        $name= $row->name .' - '.$row->color . ' - '.$row->size;
                        return $name;
                   } 
                   
                   else{
                       
                    $name= $row->name ; 
                    return $name;
                        
                   }
               
           
            });
                    
        $dt = $dt->editColumn('open', function ($row){
                        
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="open_k" data-toggle="modal" data-target="#viewModal">'.number_format($row->open_qty,2).'</a>';
        });
        
       $dt = $dt->editColumn('in', function ($row){
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="pur_k" data-toggle="modal" data-target="#viewModal">'.number_format($row->pur_qty,2).'</a>';
       });
        $dt = $dt->editColumn('out', function ($row) {
           return '<a href="#" class="item"  data-id = "'.$row->id.'" data-type="issue_k" data-toggle="modal" data-target="#viewModal">'.number_format($row->sales_qty,2).'</a>';
       });
       
      
         $dt = $dt->editColumn('balance', function ($row) {
            return number_format(($row->open_qty + $row->pur_qty) - $row->sales_qty  ,2);
       });

       $dt = $dt->rawColumns(['open','in','out','balance']);
        return $dt->make(true);
        }
     

        return view('restaurant.pos.report.kitchen_report',
          compact('data','start_date','end_date','location','x','z','location_id'));
    
    }
    
    
    public function balance_report(Request $request)
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
        
        $rowDatampya = "SELECT pos_master_history.item_id as id,tbl_items.name, SUM(CASE WHEN pos_master_history.date < '".$start_date."' AND pos_master_history.location IN ($location_id) AND pos_master_history.added_by ='".$added_by."' AND pos_master_history.type IN('Purchases','Debit Note') THEN pos_master_history.in * tbl_items.bottle - pos_master_history.out * tbl_items.bottle  ELSE 0 END) AS open_qty,
        SUM(CASE WHEN pos_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' AND pos_master_history.location IN ($location_id) AND pos_master_history.added_by ='".$added_by."' AND pos_master_history.type IN('Purchases','Debit Note') THEN pos_master_history.in * tbl_items.bottle  - pos_master_history.out * tbl_items.bottle ELSE 0 END) AS pur_qty,
        (SELECT COALESCE(SUM(order_history.quantity),0)FROM order_history WHERE tbl_items.id=order_history.item_id AND order_history.invoice_date BETWEEN '".$start_date."' AND '".$end_date."' AND order_history.added_by ='".$added_by."' AND  order_history.item_type='Bar' AND order_history.location IN ($location_id)) AS sales_qty 
        FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id WHERE tbl_items.type != '4' AND tbl_items.restaurant = '1' AND tbl_items.bar = '1' AND tbl_items.disabled = '0'   AND tbl_items.added_by = '".$added_by."' GROUP by pos_master_history.item_id";
         
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {

                       
                    $name= $row->name ; 
                    return $name;
                        
                  
               
           
            });
                    
        $dt = $dt->editColumn('open', function ($row){
                        
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="open_d" data-toggle="modal" data-target="#viewModal">'.number_format($row->open_qty,2).'</a>';
        });
        
       $dt = $dt->editColumn('in', function ($row){
        return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="pur_d" data-toggle="modal" data-target="#viewModal">'.number_format($row->pur_qty,2).'</a>';
       });
        $dt = $dt->editColumn('out', function ($row) {
           return '<a href="#" class="item"  data-id = "'.$row->id.'" data-type="sales_d" data-toggle="modal" data-target="#viewModal">'.number_format($row->sales_qty,2).'</a>';
       });
       
      
         $dt = $dt->editColumn('balance', function ($row) {
            return number_format(($row->open_qty + $row->pur_qty) - $row->sales_qty  ,2);
       });

       $dt = $dt->rawColumns(['open','in','out','balance']);
        return $dt->make(true);
        }
     
 
        return view('restaurant.pos.report.balance_report',
            compact('data','start_date','end_date','location','x','z','location_id'));
    
    }




  public function kitchen_sales(Request $request)
    {
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
        
        $rowDatampya = "SELECT order_history.item_id as id,menus.name , SUM(order_history.quantity) AS total_qty,SUM(order_history.quantity * order_history.price) AS total_cost 
                        FROM `order_history` JOIN menus ON menus.id=order_history.item_id WHERE order_history.item_type='Kitchen' AND order_history.invoice_date BETWEEN '".$start_date."' AND '".$end_date."'   AND menus.disabled = '0' AND order_history.location IN ($location_id)  AND order_history.added_by = '".$added_by."' 
                        AND menus.added_by = '".$added_by."' GROUP by order_history.item_id ";
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                
            $name= $row->name ; 
            return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="kitchen_sales" data-toggle="modal" data-target="#viewModal">'.$name.'</a>';

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
       
     

        return view('restaurant.pos.report.kitchen_sales',
          compact('data','start_date','end_date','location','x','z','location_id'));
    
    }

public function drink_sales(Request $request)
    {
       
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
        
        $rowDatampya = "SELECT order_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color, SUM(order_history.quantity) AS total_qty,
                        SUM(order_history.quantity * order_history.price) AS total_cost FROM `order_history` JOIN tbl_items ON tbl_items.id=order_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color 
                        WHERE tbl_items.type != '4' AND  order_history.item_type='Bar' AND order_history.invoice_date BETWEEN '".$start_date."' AND '".$end_date."' AND tbl_items.restaurant = '1' AND tbl_items.bar = '1' AND tbl_items.disabled = '0' AND order_history.location IN ($location_id)  AND order_history.added_by = '".$added_by."' 
                        AND tbl_items.added_by = '".$added_by."' GROUP by order_history.item_id ";
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                
                if(!empty($row->color) && empty($row->size)){
                    $name= $row->name .' - '.$row->color;  

                   }
                      
                  elseif(empty($row->color) && !empty($row->size)){
                      $name= $row->name .' - '.$row->size;  

                   } 
                   
                   elseif(!empty($row->color) && !empty($row->size)){
                        $name= $row->name .' - '.$row->color . ' - '.$row->size;

                   } 
                   
                   else{
                       
                    $name= $row->name ; 

                        
                   }
                   
                    return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="drink_sales" data-toggle="modal" data-target="#viewModal">'.$name.'</a>';
               
           
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
       
 
        return view('restaurant.pos.report.drink_sales',
            compact('data','start_date','end_date','location','x','z','location_id'));
    
    }

    
    public function stock_movement_report(Request $request)
    {
       
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
        
        $rowDatampya = "SELECT pos_master_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color, SUM(pos_master_history.in) AS total_qty,
                        SUM(pos_master_history.in * pos_master_history.price) AS total_cost FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color 
                        WHERE tbl_items.type != '4' AND  pos_master_history.type='Stock Movement' AND pos_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' AND tbl_items.restaurant = '1' AND tbl_items.disabled = '0' AND pos_master_history.location IN ($location_id)  AND pos_master_history.added_by = '".$added_by."' 
                        AND tbl_items.added_by = '".$added_by."' GROUP by pos_master_history.item_id ";
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                
                if(!empty($row->color) && empty($row->size)){
                    $name= $row->name .' - '.$row->color;  

                   }
                      
                  elseif(empty($row->color) && !empty($row->size)){
                      $name= $row->name .' - '.$row->size;  

                   } 
                   
                   elseif(!empty($row->color) && !empty($row->size)){
                        $name= $row->name .' - '.$row->color . ' - '.$row->size;

                   } 
                   
                   else{
                       
                    $name= $row->name ; 

                        
                   }
                   
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
       
  

        return view('restaurant.pos.report.stock_movement_report',
              compact('data','start_date','end_date','location','x','z','location_id'));
    
    }
    
    public function good_disposal_report(Request $request)
    {
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
        
        $rowDatampya = "SELECT pos_master_history.item_id as id,tbl_items.name , pos_item_size.name as size,pos_item_color.name as color, SUM(pos_master_history.out) AS total_qty,
                        SUM(pos_master_history.out * pos_master_history.price) AS total_cost FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color 
                        WHERE tbl_items.type != '4' AND  pos_master_history.type='Good Disposal' AND pos_master_history.date BETWEEN '".$start_date."' AND '".$end_date."' AND tbl_items.restaurant = '1' AND tbl_items.disabled = '0' AND pos_master_history.location IN ($location_id)  AND pos_master_history.added_by = '".$added_by."' 
                        AND tbl_items.added_by = '".$added_by."' GROUP by pos_master_history.item_id ";
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                
                if(!empty($row->color) && empty($row->size)){
                    $name= $row->name .' - '.$row->color;  

                   }
                      
                  elseif(empty($row->color) && !empty($row->size)){
                      $name= $row->name .' - '.$row->size;  

                   } 
                   
                   elseif(!empty($row->color) && !empty($row->size)){
                        $name= $row->name .' - '.$row->color . ' - '.$row->size;

                   } 
                   
                   else{
                       
                    $name= $row->name ; 

                        
                   }
                   
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
       

        return view('restaurant.pos.report.good_disposal_report',
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
          $key=Items::find($id); 
          return view('restaurant.pos.report.modal.open_qty',compact('id','start_date','end_date','loc_id','key'));
                    break;
          case 'pur_qty':
          $key=Items::find($id);      
          return view('restaurant.pos.report.modal.pur_qty',compact('id','start_date','end_date','loc_id','key'));
                    break;
                    
            case 'open_k':
          $key=Items::find($id); 
          return view('restaurant.pos.report.modal.open_kitchen',compact('id','start_date','end_date','loc_id','key'));
                    break;
          case 'pur_k':
          $key=Items::find($id);      
          return view('restaurant.pos.report.modal.pur_kitchen',compact('id','start_date','end_date','loc_id','key'));
                    break;
         case 'issue_k':
          $key=Items::find($id);   
          $rowDatampya= "SELECT *  FROM `pos_master_history` WHERE location IN ($location_id) AND date BETWEEN '".$start_date."' AND '".$end_date."' AND added_by = '".$added_by."' AND item_id ='".$id."'   AND type IN ('Good Issue','Returned Good Issue') ORDER BY date DESC " ;
         $account = DB::select($rowDatampya);
          return view('restaurant.pos.report.modal.issue_kitchen',compact('id','start_date','end_date','loc_id','key','account'));
                    break; 
                    
             case 'open_d':
          $key=Items::find($id); 
          return view('restaurant.pos.report.modal.open_drink',compact('id','start_date','end_date','loc_id','key'));
                    break;
          case 'pur_d':
          $key=Items::find($id);      
          return view('restaurant.pos.report.modal.pur_drink',compact('id','start_date','end_date','loc_id','key'));
                    break;
         case 'sales_d':
          $key=Items::find($id);   
          return view('restaurant.pos.report.modal.sales_drink',compact('id','start_date','end_date','loc_id','key'));
                    break;         
                    
          case 'drink_sales':
          $key=Items::find($id);      
          return view('restaurant.pos.report.modal.drink_sales',compact('id','start_date','end_date','loc_id','key'));
                    break;  
                    
             case 'kitchen_sales':
          $key=Menu::find($id);      
          return view('restaurant.pos.report.modal.kitchen_sales',compact('id','start_date','end_date','loc_id','key'));
                    break;  
                    
            
           case 'open_in_qty':
          $key=Items::find($id); 
         $rowDatampya= "SELECT *  FROM `pos_master_history` WHERE location IN ($location_id) AND date < '".$start_date."' AND pos_master_history.added_by = '".$added_by."' AND  pos_master_history.item_id ='".$id."' ORDER BY date DESC " ;
         $account = DB::select($rowDatampya);
         
          return view('restaurant.pos.report.modal.open_in_qty',compact('id','start_date','end_date','loc_id','key','account'));
                    break;        

           case 'in_qty':
          $key=Items::find($id); 
           $rowDatampya= "SELECT *  FROM `pos_master_history` WHERE location IN ($location_id) AND date BETWEEN '".$start_date."' AND '".$end_date."' AND added_by = '".$added_by."' AND item_id ='".$id."'  AND `in` > 0 ORDER BY date DESC " ;
         $account = DB::select($rowDatampya);
          return view('restaurant.pos.report.modal.in_qty',compact('id','start_date','end_date','loc_id','key','account'));
                    break;
          case 'out_qty':
          $key=Items::find($id);  
          $rowDatampya= "SELECT *  FROM `pos_master_history` WHERE location IN ($location_id) AND date BETWEEN '".$start_date."' AND '".$end_date."' AND added_by = '".$added_by."' AND item_id ='".$id."'  AND `out` > 0 ORDER BY date DESC " ;
         $account = DB::select($rowDatampya);
          return view('restaurant.pos.report.modal.out_qty',compact('id','start_date','end_date','loc_id','key','account'));
                    break; 
                 
                     case 'movement_qty':
          $key=Items::find($id);      
          return view('restaurant.pos.report.modal.movement_qty',compact('id','start_date','end_date','loc_id','key'));
                    break; 
                     case 'disposal_qty':
          $key=Items::find($id);      
          return view('restaurant.pos.report.modal.disposal_qty',compact('id','start_date','end_date','loc_id','key'));
                    break; 
                    
                                   
     

 default:
             break;

            }

                       }


public function purchase_report(Request $request)
    {
       
$data=Items::where('added_by',auth()->user()->added_by)->where('bar',1)->where('disabled',0)->get();
     $start_date = $request->start_date;
        $end_date = $request->end_date;    

        return view('restaurant.pos.report.purchase_report',
             compact('data','start_date','end_date'));
    
    }



public function summary(Request $request)
    {
        //

    $all_employee=User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;

 $search_type = $request->search_type;
 $check_existing_payment='';
$start_date='';
$end_date='';
$by_month='';
$user_id='';
$flag = $request->flag;

 

if (!empty($flag)) {
            if ($search_type == 'employee') {
             $user_id = $request->user_id;
             $check_existing_payment =Activity::where('user_id', $user_id)->get();
            }
          
            else if ($search_type == 'period') {
              $start_date = $request->start_date;
              $end_date= $request->end_date;
             $check_existing_payment = Activity::all()->where('added_by',auth()->user()->added_by)->whereBetween('date',[$start_date,$end_date]);
            }
           elseif ($search_type == 'activities') {
             $check_existing_payment =Activity::where('added_by',auth()->user()->added_by)->get();
            }
}
else{
 $check_existing_payment='';
$start_month='';
$end_month='';
$search_type='';
$by_month='';
$user_id='';
        }

 

 return view('restaurant.pos.report.activity',compact('all_employee','check_existing_payment','start_date','end_date','search_type','user_id','flag'));
    }

}
