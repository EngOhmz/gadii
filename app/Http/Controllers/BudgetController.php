<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fiscal;
use App\Models\AccountType;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\GroupAccount;
use App\Models\JournalEntry;
use App\Models\User;
use App\Models\Budget\Budget;
use App\Models\Budget\BudgetItem;
use App\Models\Branch;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $issue= Budget::where('added_by',auth()->user()->added_by)->get();;
        $type = AccountType::where('added_by',auth()->user()->added_by)->get();
        $year =Fiscal::where('added_by',auth()->user()->added_by)->where('status','1')->get();
        $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('budget.index',compact('issue','year','type','branch'));
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
        
    
        
        $data['name']=$request->name;
        $data['year_id']=$request->year_id;    
        $data['branch_id']=$request->branch_id;
        $data['amount']= 0;
        $data['added_by']= auth()->user()->added_by;

        $issue = Budget::create($data);
        
       

        $nameArr =$request->account_id ;


           $cost['amount'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){


                    $items = array(
                        'account_id' => $nameArr[$i],
                        'year_id' => $request->year_id,
                        'period1'=> str_replace(",","",$request->period1[$i]),
                        'period2'=> str_replace(",","",$request->period2[$i]),
                        'period3'=> str_replace(",","",$request->period3[$i]),
                        'period4'=> str_replace(",","",$request->period4[$i]),
                        'period5'=> str_replace(",","",$request->period5[$i]),
                        'period6'=> str_replace(",","",$request->period6[$i]),
                        'period7'=> str_replace(",","",$request->period7[$i]),
                        'period8'=> str_replace(",","",$request->period8[$i]),
                        'period9'=> str_replace(",","",$request->period9[$i]),
                        'period10'=> str_replace(",","",$request->period10[$i]),
                        'period11'=> str_replace(",","",$request->period11[$i]),
                        'period12'=> str_replace(",","",$request->period12[$i]),
                        'added_by' => auth()->user()->added_by,
                        'budget_id' =>$issue->id);

                    
                   BudgetItem::create($items);

                  
                  

    
                }
            }
           
        }    


                return redirect(route('budgets.index'))->with(['success'=>'Budget Created Successfully']);
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
        
         $data= Budget::find($id);;
        $type = AccountType::where('added_by',auth()->user()->added_by)->get();
       return view('budget.budget_details',compact('data','type','id'));
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
        $inventory= Items::whereIn('type', [1,2,3])->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
         $truck=Truck::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();;
       //$staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();;
         $staff=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
        $items=GoodDisposalItem::where('disposal_id',$id)->get();
$bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get();
       return view('pos.purchases.good_disposal',compact('items','inventory','location','staff','data','id','truck','bank_accounts'));
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


                    $items = array(
                        'item_id' => $nameArr[$i],
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
                     
                   
                  $itm=Items::find($nameArr[$i]);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Disposal',
                            'activity'=>"Good Disposal for ".$itm->name . "  with reference " .$issue->name ." is Updated",
                        ]
                        );                      
       }

    
                }
            }
           
        }    

                return redirect(route('disposal.index'))->with(['success'=>'Good Disposal Updated Successfully']);
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

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                               'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Disposal',
                             'activity'=>"Good Disposal for ".$itm->name ."  with reference " .$issue->name ." is Deleted",
                        ]
                        );                      
       }
}

       GoodDisposalItem::where('disposal_id', $id)->delete();
        $issue->delete();

                return redirect(route('disposal.index'))->with(['success'=>'Good Disposal Deleted Successfully']);
    }

    public function approve($id){
        //

 $item=GoodDisposalItem::where('disposal_id',$id)->get();

foreach($item as $i){

$issue=GoodDisposal::find($id);


 $inv=Items::where('id',$i->item_id)->first();
 $q=$inv->quantity - $i->quantity;
Items::where('id',$i->item_id)->update(['quantity' => $q]);

$loc=Location::find($i->location);
 $lq=$loc->quantity - $i->quantity;
Location::find($i->location)->update(['quantity' => $lq]);

 
                       $mlists = [
                        'out' => $i->quantity,
                        'price' => $inv->cost_price,
                        'item_id' => $i->item_id,
                         'staff_id' => $issue->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $i->location,
                        'date' =>$issue->date,
                        'type' =>   'Good Disposal',
                        'other_id' =>$id,
                    ];

                    MasterHistory::create($mlists);

//$chk=SerialList::where('brand_id',$i->item_id)->where('location',$i->location)->where('added_by',auth()->user()->added_by)->where('status','0')->take($i->quantity)->update(['status'=> '4','crate_status'=>$status]) ; 


                  $itm=Items::find($i->item_id);

               if(!empty($issue)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                          'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Good Disposal',
                             'activity'=>"Good Disposal for ".$itm->name . "  with reference " .$issue->name ." is Approved",
                        ]
                        );                      
       }




  $d=$issue->date;

$codes= AccountCodes::where('account_name','Disposal')->where('added_by', auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
   $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'pos_disposal';
  $journal->name = 'POS Good Disposal ';
  $journal->income_id= $id;
  $journal->debit =$inv->cost_price *  $i->quantity;
  $journal->branch_id= $inv->branch_id;
 $journal->added_by=auth()->user()->added_by;
$journal->notes="POS Disposal Issued with reference " .$issue->name;
  $journal->save();

  $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $cr->id;
  $date = explode('-',$d);
  $journal->date =   $d ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'pos_disposal';
  $journal->name = 'POS Good Disposal ';
  $journal->income_id= $id;
  $journal->credit = $inv->cost_price *  $i->quantity;
  $journal->branch_id= $inv->branch_id;
 $journal->added_by=auth()->user()->added_by;
 $journal->notes="POS Disposal Issued with reference " .$issue->name;
  $journal->save();

} 




GoodDisposal::where('id',$id)->update(['status' => '1']);;
GoodDisposalItem::where('disposal_id',$id)->update(['status' => '1']);;

       
        return redirect(route('disposal.index'))->with(['success'=>'Good Disposal Approved Successfully']);
    }


public function findMonth(Request $request)
   {

    $year=Fiscal::where('id',$request->id)->where('added_by',auth()->user()->added_by)->first();
    if(!empty($year)){
    $data['period1']= Carbon::parse($year->start)->format('M Y') ;
    $data['period2']= date('M Y', strtotime("+1 month", strtotime($year->start))) ;
    $data['period3']= date('M Y', strtotime("+2 months", strtotime($year->start))) ;
    $data['period4']= date('M Y', strtotime("+3 months", strtotime($year->start))) ;
    $data['period5']= date('M Y', strtotime("+4 months", strtotime($year->start))) ;
    $data['period6']= date('M Y', strtotime("+5 months", strtotime($year->start))) ;
    $data['period7']= date('M Y', strtotime("+6 months", strtotime($year->start))) ;
    $data['period8']= date('M Y', strtotime("+7 months", strtotime($year->start))) ;
    $data['period9']= date('M Y', strtotime("+8 months", strtotime($year->start))) ;
    $data['period10']= date('M Y', strtotime("+9 months", strtotime($year->start))) ;
    $data['period11']= date('M Y', strtotime("+10 months", strtotime($year->start))) ;
    $data['period12']= date('M Y', strtotime("+11 months", strtotime($year->start))) ;
     $data['error']= '' ;
    }
    
    else{
        $data['error']= 'No data found' ; 
    }
 
 
 return response()->json($data);                      
 
     }
     
 

public function discountModal(Request $request)
{
             $id=$request->id;
             $type = $request->type;
              if($type == 'year'){
                return view('budget.year_modal',compact('id'));
  }

             }
             
             
             
    public function save_year(Request $request){
       
      //dd($request->all());

        $client = Fiscal::create([
        'start' => $request->start,
        'end' => date('Y-m', strtotime("+1 year", strtotime($request->start))) ,
        'added_by' => auth()->user()->added_by
        ]);
        
      
      $data['id']=$client->id;
      $data['start']= Carbon::parse($client->start)->format('M Y') ;
      $data['end']= Carbon::parse($client->end)->format('M Y') ;
    
            return response()->json($data);
         }
         
         

       
   
   
   

}
