<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Hotel\Client;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelItems;
use App\Models\Hotel\HouseType;
use App\Models\Hotel\RoomType;
use App\Models\Hotel\Invoice;
use App\Models\Hotel\InvoiceItems;
use App\Models\Hotel\InvoicePayments;
use App\Models\Hotel\InvoiceHistory;
use App\Models\Restaurant\POS\Activity;
use App\Models\Hotel\Booked;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
use App\Models\Restaurant\POS\Menu;
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
        FROM `pos_master_history` JOIN tbl_items ON tbl_items.id=pos_master_history.item_id LEFT OUTER JOIN pos_item_size ON pos_item_size.id = tbl_items.size LEFT OUTER JOIN pos_item_color ON pos_item_color.id = tbl_items.color WHERE tbl_items.type != '4' AND tbl_items.restaurant = '0' AND tbl_items.disabled = '0'
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
       
  
 
        return view('hotel.report.report_by_date',
          compact('data','start_date','end_date','location','x','z','location_id'));
    
    }


    
        public function room_report(Request $request)
    {
    

       $start_date = $request->start_date;
        $end_date = $request->end_date; 
        $location_id = $request->location_id;
        
        $location = Hotel::where('status',1)->where('added_by', auth()->user()->added_by)->where('disabled','0')->get();
         
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
        
        $rowDatampya = "SELECT hotel_invoices_history.room_id as id,hotel_items.name,SUM(hotel_invoices_history.quantity * hotel_invoices_history.price) AS total_cost FROM `hotel_invoices_history` JOIN hotel_items ON hotel_items.id=hotel_invoices_history.room_id 
                        WHERE  hotel_invoices_history.type='Sales' AND hotel_invoices_history.invoice_date BETWEEN '".$start_date."' AND '".$end_date."'  AND hotel_items.disabled = '0' AND hotel_invoices_history.hotel_id IN ($location_id)  AND hotel_invoices_history.added_by = '".$added_by."' 
                        AND hotel_items.added_by = '".$added_by."' GROUP by hotel_invoices_history.room_id ";
        
        $data = DB::select($rowDatampya);
 
                
        $dt =  Datatables::of($data);
             
        $dt = $dt->editColumn('name', function ($row) {
                
                       
                    $name= $row->name ; 

                        
                   
                    return '<a href="#"   class="item" data-id = "'.$row->id.'" data-type="room_qty" data-toggle="modal" data-target="#viewModal">'.$name.'</a>';
               
           
            });
                    
       $dt = $dt->editColumn('cost', function ($row){
        return number_format($row->total_cost,2);
       });
       

       $dt = $dt->rawColumns(['name']);
        return $dt->make(true);
        }
       
  

        return view('hotel.report.room_report',
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
         
     $location = Hotel::where('status',1)->where('added_by', auth()->user()->added_by)->where('disabled','0')->get();
   
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
         
                    
             case 'room_qty':
          $key=HotelItems::find($id);      
          return view('hotel.report.modal.room_qty',compact('id','start_date','end_date','loc_id','key'));
                    break;                         
     

 default:
             break;

            }

                       }
                       
                       
                       



}
