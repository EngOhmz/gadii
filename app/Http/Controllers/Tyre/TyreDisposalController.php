<?php

namespace App\Http\Controllers\Tyre;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\Tyre\Tyre;
use App\Models\Tyre\TyreActivity;
use App\Models\Tyre\TyreBrand;
use App\Models\Tyre\TyreDisposal;
use App\Models\Tyre\TyreDisposalItems;
use Illuminate\Http\Request;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Tyre\MasterHistory;
use App\Models\Tyre\PurchaseItemTyre;
use App\Models\Tyre\PurchaseTyre;

class TyreDisposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $list= Tyre::where('status','0')->where('added_by',auth()->user()->added_by)->get();
      $staff=FieldStaff::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         //$staff=User::where('id','!=','1')->get();
        $disposal= TyreDisposal::where('added_by',auth()->user()->added_by)->get();
       return view('tyre.good_disposal',compact('disposal','list','staff'));
        

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
        
        
        $count=TyreDisposal::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $dt=date('m/d', strtotime($request->date));
 
       
        $data['name']='TD/'.$dt.'/00'.$pro;
        $data['date']=$request->date;
        $data['staff']=$request->staff;
        $data['added_by']=auth()->user()->added_by;
        $data['status']='0';

        $tyre = TyreDisposal::create($data);
        

        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;


        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                     $b=Tyre::find($nameArr[$i]);
                    $items = array(
                        'item_id' => $nameArr[$i],
                         'brand_id' => $b->brand_id,
                        'status' => 0,
                        'location'=>$b->location,   
                        'quantity' =>    $qtyArr[$i],
                         'order_no' => $i,
                         'added_by' => auth()->user()->added_by,
                        'disposal_id' =>$tyre->id);

                    
                   TyreDisposalItems::create($items);

    
                }
            }

           
        }

  
       
        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$tyre->id,
                    'module'=>'Good Disposal',
                    'activity'=>"Disposal of Tyre with reference " .$tyre->name. " is Created",
                    'date'=>$request->date,
                ]
                );                      
}

        return redirect(route('tyre_disposal.index'))->with(['success'=>'Good Disposal Created Successfully']);
      

        
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

      $list= Tyre::where('status','0')->where('added_by',auth()->user()->added_by)->get();
      $staff=FieldStaff::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
         //$staff=User::where('id','!=','1')->get();
        $data= TyreDisposal::find($id);
         $items=TyreDisposalItems::where('disposal_id',$id)->get();
       return view('tyre.good_disposal',compact('data','list','staff','id','items'));
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
      $tyre= TyreDisposal::find($id);


        $data['date']=$request->date;
        $data['staff']=$request->staff;
        $data['added_by']=auth()->user()->added_by;
        $data['status']='0';

        $tyre->update($data);
        

        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_id ;

        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
              TyreDisposalItems::where('id',$remArr[$i])->delete();   
                            
                   }
               }
           }


        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                     $b=Tyre::find($nameArr[$i]);
                    $items = array(
                        'item_id' => $nameArr[$i],
                         'brand_id' => $b->brand_id,
                        'status' => 0,
                        'truck_id'=>$request->truck_id,
                        'location'=>$b->location,   
                        'quantity' =>    $qtyArr[$i],
                         'order_no' => $i,
                         'added_by' => auth()->user()->added_by,
                        'disposal_id' =>$id);

                     if(!empty($expArr[$i])){
                    TyreDisposalItems::where('id',$expArr[$i])->update($items);                              
                             }
                          else{
                    TyreDisposalItems::create($items);  
                       
                          }   
                    
                 
    
                }
            }

           
        }
  
       
        if(!empty($disposal)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$disposal->id,
                    'module'=>'Good Disposal',
                    'activity'=>"Disposal of Tyre " .$tyre->name. " is Updated",
                    'date'=>$request->date,
                ]
                );                      
}

        return redirect(route('tyre_disposal.index'))->with(['success'=>'Good Disposal Updated Successfully']);


       
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

        $tyre = TyreDisposal::find($id);
        

        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$tyre->id,
                    'module'=>'Good Disposal',
                    'activity'=>"Delete of Tyre",
                   'date'=>date('Y-m-d'),
                ]
                );                      
}

       TyreDisposalItems::where('disposal_id',$id)->delete();
        $tyre->delete();

        return redirect(route('tyre_disposal.index'))->with(['success'=>'Good Disposal Deleted Successfully']);
    }

    public function approve($id)
    {
        //

        $disposal = TyreDisposal::find($id);
        $data['status'] = 1;
        $disposal->update($data);
        
          $items= TyreDisposalItems::where('disposal_id',$id)->get();

            foreach($items as $i){
                
                 $name=Tyre::where('id',$i->item_id)->first();

        $list['status']='4';
        Tyre::where('id',$i->item_id)->update($list);
        
        
        $inv=TyreBrand::where('id',$name->brand_id)->first();
        $q=$inv->quantity - 1;
        TyreBrand::where('id',$name->brand_id)->update(['quantity' => $q]);
        
        
                    if(!empty($name->purchase_id)){
   $tt=PurchaseItemTyre::where('purchase_id', $name->purchase_id)->where('item_name', $name->brand_id)->first();
   $p=PurchaseTyre::find($name->purchase_id);
   $total=$tt->price *  $p->exchange_rate;
}
else if(empty($name->purchase_id)){
   $total= $inv->price;
}

  $d=date('Y-m-d');
  
  $mlists = [
                        'out' => 1,
                        'price' => $total,
                        'item_id' => $name->brand_id,
                        'serial_id' => $i->item_id,
                         'staff_id' => $disposal->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $name->location,
                        'date' =>$d,
                        'type' =>   'Good Disposal',
                        'other_id' =>$id,
                    ];

                    MasterHistory::create($mlists);
                    
                    
                    
    $codes= AccountCodes::where('account_name','Disposal')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'tire_disposal';
  $journal->name = 'Tire Disposal ';
  $journal->income_id= $id;
  $journal->debit =$total;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="Tire Disposal with reference " .$disposal->name;
  $journal->save();

  $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'tire_disposal';
  $journal->name = 'Tire Disposal ';
  $journal->income_id= $id;
  $journal->credit = $total;
  $journal->branch_id= $inv->branch_id;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="Tire Disposal with reference " .$disposal->name;
  $journal->save();
  
                
            }



        if(!empty($disposal)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$disposal->id,
                    'module'=>'Good Disposal',
                    'activity'=>"Disposal of Tyre " .$disposal->name." is Approved",
                   'date'=>date('Y-m-d'),
                ]
                );                      
}


       
        return redirect(route('tyre_disposal.index'))->with(['success'=>'Approved Successfully']);
    }

}
