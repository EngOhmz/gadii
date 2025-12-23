<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\Equipment;
use App\Models\EquipmentList;
use App\Models\TruckEquipment;
use App\Models\TruckEquipmentItem;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Truck;
use App\Models\Branch;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$issue= TruckEquipment::where('added_by',auth()->user()->added_by)->get();;
        $issue= EquipmentList::where('added_by',auth()->user()->added_by)->get();;
        $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $inventory= Equipment::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
         $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('truck.good_issue',compact('issue','inventory','staff','truck','branch'));
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
         $count=TruckEquipment::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $dt=date('m/d', strtotime($request->date));
       
        $a='AET';
//dd($a);

        $data['date']=$request->date;
        $data['location']=$request->location;    
        $data['staff']=$request->staff;
        $data['staff_id']=$request->staff;
        $data['name']=$a.'/'.$dt.'/00'.$pro;
        $data['branch_id']=$request->branch_id;
        $data['status']= 0;
        $data['description']=$request->description;
        $data['account_id']=$request->account_id;
        $data['truck_id']=$request->truck_id;
        $data['branch_id']=$request->branch_id;
        $data['user_id']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $issue = TruckEquipment::create($data);
        
       

        $nameArr =$request->item_id ;
        $costArr =$request->cost;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'item_id' => $nameArr[$i],
                         'cost' => $costArr[$i],
                         'due_cost' => $costArr[$i],
                        'status' => 0,
                        'location' => $request->location,
                         'truck_id' => $request->truck_id,
                        'quantity' =>    1,
                        'due_quantity' =>   1,
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'issue_id' =>$issue->id);

                    
                   TruckEquipmentItem::create($items);

                 
    
                }
            }
           
        }    


                return redirect(route('assign_equipment.index'))->with(['success'=>'Created Successfully']);
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
        $data=TruckEquipment::find($id);
       $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $inventory= Equipment::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
         $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $items=TruckEquipmentItem::where('issue_id',$id)->get();
       return view('truck.good_issue',compact('items','inventory','staff','data','id','truck'));
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

        $issue=TruckEquipment::find($id);

        $data['date']=$request->date;
        $data['location']=$request->location;    
        $data['staff']=$request->staff;
        $data['staff_id']=$request->staff;
        
           $data['description']=$request->description;
          $data['account_id']=$request->account_id;
           $data['truck_id']=$request->truck_id;
            $data['branch_id']=$request->branch_id;
        $data['added_by']= auth()->user()->added_by;
        $issue->update($data);
        
       
        $nameArr =$request->item_id ;
         $costArr =$request->cost ;
        $qtyArr =$request->quantity ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_id ;




           
        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
               TruckEquipmentItem::where('id',$remArr[$i])->delete();   
                            
                   }
               }
           }

           



        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'item_id' => $nameArr[$i],
                        'cost' => $costArr[$i],
                         'due_cost' => $costArr[$i],
                        'location' => $request->location,
                         'truck_id' => $request->truck_id,
                        'quantity' =>    1,
                        'due_quantity' =>   1,
                      'truck_id' => $request->truck_id,
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'issue_id' =>$id);
                       
                    
                   
                            if(!empty($expArr[$i])){
                                TruckEquipmentItem::where('id',$expArr[$i])->update($items);                              
                             }
                          else{
                         TruckEquipmentItem::create($items);  
                       
                          }                         
                     
                   
                 

    
                }
            }
           
        }    

                return redirect(route('assign_equipment.index'))->with(['success'=>'Updated Successfully']);
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
      
        $issue =  TruckEquipment::find($id);

          $items= TruckEquipmentItem::where('issue_id',$id)->get();
          

       TruckEquipmentItem::where('issue_id', $id)->delete();
        $issue->delete();

                return redirect(route('assign_equipment.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function approve(Request $request){
        //
        
       $count=TruckEquipment::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $dt=date('m/d', strtotime($request->date));
       
        $a='AET';
//dd($a);

        $data['date']=$request->date;
        $data['staff']=$request->staff;
        $data['staff_id']=$request->staff;
        $data['name']=$a.'/'.$dt.'/00'.$pro;
        $data['status']= 0;
        $data['description']=$request->description;
        $data['truck_id']=$request->truck_id;
        $data['user_id']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $issue = TruckEquipment::create($data);
        
       

        $nameArr =$request->item_id ;
        $costArr =$request->cost;

        if(!empty($nameArr)){
            
            $x=EquipmentList::find($nameArr);

                    $items = array(
                        'item_id' => $nameArr,
                         'brand_id' => $x->brand_id,
                         'cost' => $costArr,
                         'due_cost' => $costArr,
                        'status' => 0,
                         'truck_id' => $request->truck_id,
                        'quantity' =>    1,
                        'due_quantity' =>   1,
                           'added_by' => auth()->user()->added_by,
                        'issue_id' =>$issue->id);

                    
                   TruckEquipmentItem::create($items);

        }      
        
 $id= $issue->id;      
$chk=TruckEquipment::find($id);
 $item=TruckEquipmentItem::where('issue_id',$id)->get();

foreach($item as $i){
    
    
      $as = array(
        'status' => 1,
        'issue_id' => $id,
        'truck_id' => $request->truck_id,
        'staff' => $request->staff);

$issue=TruckEquipment::find($id);
EquipmentList::find($i->item_id)->update($as);

  $d=$issue->date;
$itm=Equipment::find($i->brand_id);
$q=$itm->quantity-1;
Equipment::find($i->brand_id)->update(['quantity'=>$q]);
$truck=Truck::find($i->truck_id);

$codes= AccountCodes::where('account_name','Truck Equipment')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'assign_equipment';
  $journal->name = 'Assign Equipment to Truck ';
  $journal->income_id= $id;
  $journal->debit =$i->cost;
  $journal->branch_id= $chk->branch_id;
  $journal->truck_id= $chk->truck_id;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="Equipment " .$itm->name." Assigned to Truck " .$truck->truck_name."- ".$truck->reg_no;
  $journal->save();

  $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'assign_equipment';
  $journal->name = 'Assign Equipment to Truck ';
  $journal->income_id= $id;
  $journal->credit =$i->cost;
  $journal->branch_id= $chk->branch_id;
   $journal->truck_id= $chk->truck_id;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="Equipment " .$itm->name." Assigned to Truck " .$truck->truck_name."- ".$truck->reg_no;
  $journal->save();

} 





TruckEquipment::find($id)->update(['status' => '1']);;
TruckEquipmentItem::where('issue_id',$id)->update(['status' => '1']);;

       
        return redirect(route('assign_equipment.index'))->with(['success'=>'Assigned Successfully']);
    }



    
    
    public function return($id)
    {
        /*
        $data=TruckEquipmentItem::where('issue_id',$id)->where('due_quantity','>', '0')->get();
        $name =Equipment::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $inventory= Equipment::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $returned='1';
       return view('truck.good_issue',compact('id','data','name','returned','inventory','staff'));
       */
       
       
     $x=EquipmentList::find($id);
     $qtyArr = '1'  ;

    $purchase = TruckEquipment::find($x->issue_id);

                
     $saved=TruckEquipmentItem::where('issue_id',$x->issue_id)->first();
     //dd($x);

           $lists= array(
            'due_quantity' =>  $saved->due_quantity-1,
             'returned' =>  $saved->returned+1,
                   );
               
             $saved->update($lists); 
                         
 
  $as = array(
        'status' => 0,
        'issue_id' => '',
        'truck_id' => '',
        'staff' => '');

$x->update($as);
                         
            
            
                         
     $d=date('Y-m-d');
     $itm=Equipment::find($saved->brand_id);
     $q=$itm->quantity+1;
     Equipment::find($saved->brand_id)->update(['quantity'=>$q]);
   $truck=Truck::find($saved->truck_id);
     
    $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'return_assigned_equipment';
  $journal->name = 'Return Assigned Equipment to Truck ';
  $journal->income_id= $saved->issue_id;
  $journal->debit =$saved->cost;
  $journal->branch_id= $purchase->branch_id;
  $journal->truck_id= $purchase->truck_id;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes="Equipment " .$itm->name." Returned from Truck " .$truck->truck_name."- ".$truck->reg_no;
  $journal->save();
  
  


$codes= AccountCodes::where('account_name','Truck Equipment')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'return_assigned_equipment';
  $journal->name = 'Return Assigned Equipment to Truck ';
  $journal->income_id=$saved->issue_id;
  $journal->credit =$saved->cost;
  $journal->branch_id= $purchase->branch_id;
  $journal->truck_id= $purchase->truck_id;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="Equipment " .$itm->name." Returned from Truck " .$truck->truck_name."- ".$truck->reg_no;
  $journal->save();


  
 
        return redirect(route('assign_equipment.index'))->with(['success'=>'Returned Successfully']);
    }
    
     public function disposal($id)
    {
        /*
        $data=TruckEquipmentItem::where('issue_id',$id)->where('due_quantity','>', '0')->get();
         $name =Equipment::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $inventory= Equipment::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $returned='2';
        */
        
        
               
     $x=EquipmentList::find($id);
     $qtyArr = '1'  ;

    $purchase = TruckEquipment::find($x->issue_id);

                
     $saved=TruckEquipmentItem::where('issue_id',$x->issue_id)->first();
     //dd($x);

           $lists= array(
            'due_quantity' =>  $saved->due_quantity-1,
              'disposed' =>  $saved->disposed+1,
                   );
               
             $saved->update($lists); 
                         
 
  $as = array(
        'status' => 2,
        'issue_id' => '',
        'truck_id' => '',
        'staff' => '');

$x->update($as);
                         
            
          
                         
     $d=date('Y-m-d');
     $itm=Equipment::find($saved->brand_id);
   $truck=Truck::find($saved->truck_id);
     
    $cr= AccountCodes::where('account_name','Truck Maintenance and Service')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'dispose_assigned_equipment';
  $journal->name = 'Dispose Assigned Equipment to Truck ';
  $journal->income_id= $saved->issue_id;
  $journal->debit =$saved->cost;
  $journal->branch_id= $purchase->branch_id;
  $journal->truck_id= $purchase->truck_id;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes="Equipment " .$itm->name." Disposed from Truck " .$truck->truck_name."- ".$truck->reg_no;
  $journal->save();
  
  


$codes= AccountCodes::where('account_name','Inventory')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
$journal->transaction_type = 'dispose_assigned_equipment';
  $journal->name = 'Dispose Assigned Equipment to Truck ';
  $journal->income_id=$saved->issue_id;
  $journal->credit =$saved->cost;
  $journal->branch_id= $purchase->branch_id;
  $journal->truck_id= $purchase->truck_id;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="Equipment " .$itm->name." Disposed from Truck " .$truck->truck_name."- ".$truck->reg_no;
  $journal->save();
        
        
      return redirect(route('assign_equipment.index'))->with(['success'=>'Disposed Successfully']);
    }
    
    
     public function dispose_equipment($id)
    {

               
     $x=EquipmentList::find($id);
   
  $as = array(
        'status' => 2,
        'issue_id' => '',
        'truck_id' => '',
        'staff' => '');

$x->update($as);
                         
            
          
                         
     $d=date('Y-m-d');
     $saved=EquipmentList::find($id);
     $itm=Equipment::find($saved->brand_id);
     
     $q=$itm->quantity-1;
     Equipment::find($saved->brand_id)->update(['quantity'=>$q]);
     
    $cr= AccountCodes::where('account_name','Truck Maintenance and Service')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'dispose_equipment';
  $journal->name = 'Dispose Equipment ';
  $journal->income_id= $id;
  $journal->debit =$saved->cost;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes="Equipment " .$itm->name." Disposed ";
  $journal->save();
  
  


$codes= AccountCodes::where('account_name','Inventory')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
$journal->transaction_type = 'dispose_equipment';
  $journal->name = 'Dispose Equipment ';
  $journal->income_id= $id;
  $journal->credit =$saved->cost;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="Equipment " .$itm->name." Disposed ";
  $journal->save();
        
        
      return redirect(route('assign_equipment.index'))->with(['success'=>'Disposed Successfully']);
    }
    

 public function save_return(Request $request)
    {
        //
     $id=$request->issue_id;
     $nameArr =$request->items_id ;
     $qtyArr = $request->quantity  ;

        $purchase = TruckEquipment::find($id);

$item=count($request->items_id);

        if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                
                 $saved=TruckEquipmentItem::find($nameArr[$i]);
    
                       $lists= array(
                        'due_quantity' =>  $saved->due_quantity-1,
                         'returned' =>  $saved->returned+1,
                               );
                           
                         $saved->update($lists); 
                         
 
 
                         
        if($item > 0) { 
            
            
                         
     $d=date('Y-m-d');
     $itm=Equipment::find($saved->item_id);
   $truck=Truck::find($saved->truck_id);
     
    $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'return_assigned_equipment';
  $journal->name = 'Return Assigned Equipment to Truck ';
  $journal->income_id= $id;
  $journal->debit =$saved->cost;
  $journal->branch_id= $purchase->branch_id;
  $journal->truck_id= $purchase->truck_id;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes="Equipment " .$itm->name." Returned from Truck " .$truck->truck_name."- ".$truck->reg_no;
  $journal->save();
  
  


$codes= AccountCodes::where('account_name','Truck Equipment')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'return_assigned_equipment';
  $journal->name = 'Return Assigned Equipment to Truck ';
  $journal->income_id= $id;
  $journal->credit =$saved->cost;
  $journal->branch_id= $purchase->branch_id;
  $journal->truck_id= $purchase->truck_id;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="Equipment " .$itm->name." Returned from Truck " .$truck->truck_name."- ".$truck->reg_no;
  $journal->save();


       
       
        }
       
       
                    }
                    
                }
                
               //TruckEquipment::where('id',$id)->update(['return' => '1']);;

    return redirect(route('assign_equipment.index'))->with(['success'=>'Returned Successfully']);

            
            }    


else{

  return redirect(route('assign_equipment.index'))->with(['error'=>'No data found']);


}

   

    }

  
  public function save_disposal(Request $request)
    {
        //
     $id=$request->issue_id;
     $nameArr =$request->items_id ;
     $qtyArr = $request->quantity  ;

        $purchase = TruckEquipment::find($id);
        $item=count($request->items_id);

        if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                
                      $saved=TruckEquipmentItem::find($nameArr[$i]);
        
    
                       $lists= array(
                        'due_quantity' =>  $saved->due_quantity-1,
                         'disposed' =>  $saved->disposed+1,
                               );
                           
                         $saved->update($lists); 
  
                         
                          
       if($item > 0) {                       
     $d=date('Y-m-d');
     
      
      $itm=Equipment::find($saved->item_id);
   $truck=Truck::find($saved->truck_id);

     
  $codes= AccountCodes::where('account_name','Truck Maintenance and Service')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'dispose_assigned_equipment';
  $journal->name = 'Dispose Assigned Equipment to Truck ';
  $journal->income_id= $id;
  $journal->debit =$saved->cost;
  $journal->truck_id= $purchase->truck_id;
  $journal->branch_id= $purchase->branch_id;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="Equipment " .$itm->name." Disposed from Truck " .$truck->truck_name."- ".$truck->reg_no;
  $journal->save();
  
   $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'dispose_assigned_equipment';
  $journal->name = 'Dispose Assigned Equipment to Truck ';
  $journal->income_id= $id;
  $journal->credit =$saved->cost;
  $journal->branch_id= $purchase->branch_id;
  $journal->truck_id= $purchase->truck_id;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes="Equipment " .$itm->name." Disposed from Truck " .$truck->truck_name."- ".$truck->reg_no;
  $journal->save();

          
    
       
       
       }
       
                    }
                    
                }
                
               //TruckEquipment::where('id',$id)->update(['return' => '1']);;

    return redirect(route('assign_equipment.index'))->with(['success'=>'Disposed Successfully']);

            
            }    


else{

  return redirect(route('assign_equipment.index'))->with(['error'=>'No data found']);


}

   

    }
   
    


public function equipment_report(Request $request)
    {
    
    /*
     $start_date = $request->start_date;
    $end_date = $request->end_date;  
    $data=Equipment::where('added_by',auth()->user()->added_by)->get();
     
     */
     
      if ($request->ajax()) {
            $data =Equipment::select('*')->where('added_by',auth()->user()->added_by)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->editColumn('name', function ($row) {
                              return $row->name;
                    })
                    ->editColumn('assign', function ($row) {
                        $qty=EquipmentList::where('brand_id',$row->id)->where('status',1)->where('added_by',auth()->user()->added_by)->count();
                       
                            return '<a href="#viewa'.$row->id.'" data-toggle="modal">'.number_format($qty,2).'</a>';
                   })
                     ->editColumn('dispose', function ($row) {
                        $bqty=EquipmentList::where('brand_id',$row->id)->where('status',2)->where('added_by',auth()->user()->added_by)->count();
                    
                             return '<a href="#viewd'.$row->id.'" data-toggle="modal">'.number_format($bqty,2).'</a>';
                   })
                   
                   
                   ->editColumn('available', function ($row) {
                        $aqty=EquipmentList::where('brand_id',$row->id)->where('status',0)->where('added_by',auth()->user()->added_by)->count();
                    
                         return '<a href="#viewav'.$row->id.'" data-toggle="modal">'.number_format($aqty,2).'</a>';     
                       
                        
                   })
                     ->editColumn('quantity', function ($row) {
                        return '<a href="#viewq'.$row->id.'" data-toggle="modal">'.number_format($row->quantity,2).'</a>';
                   })

                    ->rawColumns(['assign','dispose','quantity'])
                    ->make(true);
        }

 
  $list=Equipment::where('added_by',auth()->user()->added_by)->get();
        return view('truck.equipment_report',compact('list'));
    
    }





}
