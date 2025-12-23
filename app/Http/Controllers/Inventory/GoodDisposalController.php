<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\GoodDisposal;
use App\Models\GoodDisposalItem;
use App\Models\InventoryList;
use App\Models\MasterHistory;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Truck;
use App\Models\Branch;
use Illuminate\Http\Request;

class GoodDisposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $issue= GoodDisposal::where('added_by',auth()->user()->added_by)->get();;
       $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         //$location= LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
        $inventory= InventoryList::where('status','0')->where('added_by',auth()->user()->added_by)->get();
        //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
        $staff=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get();
        $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('inventory.good_disposal',compact('issue','inventory','location','staff','truck','bank_accounts','branch'));
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
        
         $count=GoodDisposal::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $dt=date('m/d', strtotime($request->date));
        $x=Location::find($request->location);
        
        $words = preg_split("/\s+/", $x->name);
        $acronym = "";
        
        foreach ($words as $w) {
          $acronym .= mb_substr($w, 0, 1);
        }
        $a=strtoupper($acronym);
        
        $data['date']=$request->date;
        $data['location']=$request->location;    
        $data['staff']=$request->staff;
        $data['staff_id']=$request->staff;
        $data['name']=$a.'/'.$dt.'/00'.$pro;
        $data['status']= 0;
        $data['branch_id']=$request->branch_id;
        $data['costs']=$request->costs;
        $data['description']=$request->description;
        $data['account_id']=$request->account_id;
        $data['user_id']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $issue = GoodDisposal::create($data);
        
       

        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $b=InventoryList::find($nameArr[$i]);
                    $items = array(
                        'item_id' => $nameArr[$i],
                        'brand_id' => $b->brand_id,
                        'status' => 0,
                        'location' => $request->location,
                         'truck_id' => $request->truck_id,
                        'quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'disposal_id' =>$issue->id);

                    
                   GoodDisposalItem::create($items);

                

    
                }
            }
           
        }    


                return redirect(route('good_disposal.index'))->with(['success'=>'Good Disposal Created Successfully']);
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
        $data=GoodDisposal::find($id);
        $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         //$location=LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $inventory= InventoryList::where('status','0')->where('location',$data->location)->where('added_by',auth()->user()->added_by)->get();
         $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
       //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $items=GoodDisposalItem::where('disposal_id',$id)->get();
$bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get();
       return view('inventory.good_disposal',compact('items','inventory','location','staff','data','id','truck','bank_accounts'));
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

        $issue=GoodDisposal::find($id);

        $data['date']=$request->date;
        $data['location']=$request->location;    
        $data['staff']=$request->staff;
        $data['staff_id']=$request->staff;
         $data['costs']=$request->costs;
        $data['description']=$request->description;
        $data['account_id']=$request->account_id;
        $data['added_by']= auth()->user()->added_by;
        $issue->update($data);
        
       
        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_id ;




           
        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
               GoodDisposalItem::where('id',$remArr[$i])->delete();   
                            
                   }
               }
           }

           



        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $b=InventoryList::find($nameArr[$i]);
                    $items = array(
                        'item_id' => $nameArr[$i],
                        'brand_id' => $b->brand_id,
                        'location' => $request->location,
                      'truck_id' => $request->truck_id,
                        'quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'disposal_id' =>$id);
                       
                    
                   
                            if(!empty($expArr[$i])){
                                GoodDisposalItem::where('id',$expArr[$i])->update($items);                              
                             }
                          else{
                         GoodDisposalItem::create($items);  
                       
                          }                         
                     
                   
               

    
                }
            }
           
        }    

                return redirect(route('good_disposal.index'))->with(['success'=>'Good Disposal Updated Successfully']);
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
      
        $issue =  GoodDisposal::find($id);

          $items= GoodDisposalItem::where('disposal_id',$id)->get();
          foreach($items as $i){

                   $loc=Truck::find($i->truck_id);
                  $itm=Items::find($i->item_id);

}

       GoodDisposalItem::where('disposal_id', $id)->delete();
        $issue->delete();

                return redirect(route('good_disposal.index'))->with(['success'=>'Good Disposal Deleted Successfully']);
    }

    public function approve($id){
        //

 $item=GoodDisposalItem::where('disposal_id',$id)->get();

foreach($item as $i){

$issue=GoodDisposal::find($id);


$inv=Inventory::where('id',$i->brand_id)->first();
 $q=$inv->quantity - $i->quantity;
Inventory::where('id',$i->brand_id)->update(['quantity' => $q]);

$loc=Location::find($i->location);
 $lq=$loc->quantity - $i->quantity;
Location::find($i->location)->update(['quantity' => $lq]);

$mlists = [
                        'out' => $i->quantity,
                        'price' => $inv->price,
                        'item_id' => $i->brand_id,
                        'serial_id' => $i->item_id,
                         'staff_id' => $issue->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $i->location,
                        'date' =>$issue->date,
                        'type' =>   'Good Disposal',
                        'other_id' =>$id,
                    ];

                    MasterHistory::create($mlists);

$lst=InventoryList::where('id',$i->item_id)->where('location',$i->location)->where('added_by',auth()->user()->added_by)->where('status','0')->first();
$chk=InventoryList::where('id',$i->item_id)->where('location',$i->location)->where('added_by',auth()->user()->added_by)->where('status','0')->update(['status'=> '4']) ; 

                 


  $d=$issue->date;

$codes= AccountCodes::where('account_name','Disposal')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'inventory_disposal';
  $journal->name = 'Inventory Good Disposal ';
  $journal->income_id= $id;
  $journal->debit =$inv->price *  $i->quantity;
  $journal->branch_id= $inv->branch_id;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="Inventory with serial_no ".$lst->serial_no." is disposed Issued with reference " .$issue->name;
  $journal->save();

  $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
   $journal->transaction_type = 'inventory_disposal';
  $journal->name = 'Inventory Good Disposal ';
  $journal->income_id= $id;
  $journal->credit = $inv->price *  $i->quantity;
  $journal->branch_id= $inv->branch_id;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="Inventory with serial_no ".$lst->serial_no." is disposed Issued with reference " .$issue->name;
  $journal->save();

} 




GoodDisposal::where('id',$id)->update(['status' => '1']);;
GoodDisposalItem::where('disposal_id',$id)->update(['status' => '1']);;

       
        return redirect(route('good_disposal.index'))->with(['success'=>'Good Disposal Approved Successfully']);
    }


   

}
