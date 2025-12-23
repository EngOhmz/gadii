<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Courier\Courier;
use App\Models\Courier\CourierInvoiceItem;
use App\Models\Courier\CourierInvoice;
use App\Models\Courier\CourierItem;
use App\Models\Courier\CourierList;
use App\Models\Courier\CourierCost;
use App\Models\Courier\CourierPayment;
use App\Models\Courier\CourierActivity;
use App\Models\Courier\CourierMovement;
use App\Models\Courier\Storage;
use App\Models\Payment_methodes;
use App\Models\Route;
use App\Models\Tariff;
use App\Models\Courier\CourierClient;
use Illuminate\Http\Request;
use PDF;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\orders\OrderMovement;
use App\Models\Region;
use App\Models\District;
use App\Models\Courier\CourierLoading;
use App\Models\Courier\CourierCollection;

class NewCourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $courier = Courier::where('added_by',auth()->user()->added_by)->get();
        $route = Route::all();
        $users = CourierClient::where('user_id',auth()->user()->added_by)->get();
          $name = CourierList::all();
          $currency = Currency::all();
       $region = Region::all();   
      $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;
        return view('courier.new_quotation',compact('courier','route','users','name','currency','region','bank_accounts'));
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

public function addNewSales(Request $request){
    
        //
        $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
 


  $clientArr =$request->owner_id;
  $nameArr =$request->item_name ;
 $qtyArr = $request->quantity  ;
 $priceArr = $request->price;
 $rateArr = $request->tax_rate ;
 $unitArr = $request->unit  ;
 $costArr = str_replace(",","",$request->total_cost)  ;
 $taxArr =  str_replace(",","",$request->total_tax );
 $amountArr = str_replace(",","",$request->amount);
 $totalArr =  str_replace(",","",$request->tax);

 if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){
                   $count=Courier::count();
                   $pro=$count+1;

                $data = array(
                     'pacel_number' =>'CM0'.$pro ,
                    'date' => $request->date ,
                   'owner_id' => $clientArr[$i],
                     'activity' =>'1',
                   'discount' => '0'  ,
                    'status' => '0'  ,
                   'good_receive' => '1'  ,
                  'currency_code' =>'TZS',
                   'exchange_rate' => '1',
                   'amount' =>  $costArr[$i] +  $taxArr[$i] ,
                    'due_amount' =>   $costArr[$i] +  $taxArr[$i] ,
                      'weight' =>  $qtyArr[$i] , 
                    'tax' =>   $taxArr[$i],
                  'added_by'=>auth()->user()->added_by);

                $pacel= Courier::create($data);  


 
                $items = array(
                    'item_name' => $nameArr[$i],
                    'quantity' =>   $qtyArr[$i],
                    'tax_rate' =>  $rateArr [$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i],
                     'items_id' =>  $nameArr[$i],
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'pacel_id' =>$pacel->id);

                $it= CourierItem::create($items);  ;

       
         $cost['tariff_id'] =$it->item_name  ;
       $cost['confirmation_number'] = "CM".$random.$pacel->id;
          Courier::where('id',$pacel->id)->update($cost);




     
       $pickup_costs=str_replace(",","",$request->total_p);
       $loading_costs=str_replace(",","",$request->total_l);
       $off_costs=str_replace(",","",$request->total_o);
      $del_costs=str_replace(",","",$request->total_d);




$num=count($nameArr);
//dd($pickup_costs[$i]);

 if(!empty($request->pcosts)){
$pcosts=($pickup_costs[0]/$num);
}else{
$pcosts=0;
}

 if(!empty($request->lcosts)){
$lcosts=($loading_costs[0]/$num);
}else{
$lcosts=0;
}

 if(!empty( $request->ocosts)){
$ocosts=($off_costs[0]/$num);
}else{
$ocosts=0;
}

 if(!empty($request->dcosts)){
$dcosts=($del_costs[0]/$num);
}else{
$dcosts=0;
}





     $quot=Courier::find($pacel->id);  
                $route = Tariff::find($quot->tariff_id); 
               $region_from= Region::where('name',$route->from_region_id)->first(); 
             $region_to= Region::where('name',$route->to_region_id)->first(); 
        
                $result['pacel_id']=$pacel->id;
                $result['pacel_number']=$quot->pacel_number;
                $result['weight']=$quot->weight;
               $result['due_weight']=$quot->weight;
                $result['start_location']= $route->from_region_id;
                $result['end_location']=$route->to_region_id;
                $result['owner_id']=$quot->owner_id;
                $result['amount']=$quot->amount;
                $result['tariff_id']=$quot->tariff_id;
                $result['status']='2';
                 $result['activity'] ='1';
                $result['added_by'] = auth()->user()->added_by;
                $movement=CourierCollection::create($result);

$collection=CourierCollection::find($movement->id);
  $loading_cargo =CourierLoading::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,                            
                            'type'=>'non_owned',
                            'weight'=>$collection->weight,
                           'total_weight'=>$collection->weight,
                            'status'=>'3',
                             'activity'=>'1',
                              'fuel'=>'0',
                           'pacel_id'=>$collection->pacel_id,
                           'pacel_name'=>$collection->pacel_name,
                         'pacel_number'=>$collection->pacel_number,
                         'start_location'=> $collection->start_location,
                         'end_location'=>$collection->end_location,
                        'owner_id'=>$collection->owner_id,
                         'collection_id'=>$movement->id,
                        'amount'=>$collection->amount,
                        'tariff_id'=>$collection->tariff_id,
                       'collection_date'=>$request->date,
                        ]
                        );                      
      

                 
                if(!empty($loading_cargo)){
                    $activity = CourierActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                            'module_id'=>$collection->pacel_id,
                            'module'=>'Courier',
                            'activity'=>"Confirm Pickup",
                             'costs'=>$pcosts,
                               'bank_id'=>$request->bank_id,
                          'loading_id'=>$loading_cargo->id,
                           'date'=>$request->date,
                        ]
                        );                      
       }


if($pcosts > 0){

        $codes= AccountCodes::where('account_name','Pickup Cost')->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$loading_cargo->collection_date);
        $journal->date =  $loading_cargo->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier_costs';
        $journal->name = 'Pickup Cost';
        $journal->debit =$pcosts;
          $journal->payment_id=$collection->pacel_id;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Pickup Costs  with reference no " .$collection->pacel_number  ;
        $journal->save();

$cr= AccountCodes::where('id',$request->bank_id)->first();
          $journal = new JournalEntry();
        $journal->account_id =$request->bank_id;
           $date = explode('-',$loading_cargo->collection_date);
        $journal->date =  $loading_cargo->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
    $journal->transaction_type = 'courier_costs';
        $journal->name = 'Pickup Cost';
        $journal->credit = $pcosts;
        $journal->payment_id= $collection->pacel_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Pickup Costs  with reference no " .$collection->pacel_number  ;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $pcosts;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']=  0-$pcosts;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$pcosts;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Pickup Cost',
                                 'module_id' => $collection->pacel_id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier Pickup Costs  with reference no ' .$collection->pacel_number,
                                'type' => 'Expense',
                                'amount' =>$pcosts,
                                'debit' => $pcosts,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($loading_cargo->collection_date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier pickup cost.The Reference is ' .$collection->pacel_number ,
                                'added_by' =>auth()->user()->added_by,
                            ]);       

}

$data['due_weight']='0';
 $data['status']='3';

$collection->update($data);


$freight=CourierLoading::find($loading_cargo->id);
                           $data['status']=4;
                        $freight->update($data);
                         
                        if(!empty($freight)){
                            $activity = CourierActivity::create(
                                [ 
                                    'added_by'=>auth()->user()->added_by,
                                    'module_id'=>$freight->pacel_id,
                                    'module'=>'Courier',
                                    'activity'=>"Confirm Freight",
                               'costs'=>$lcosts,
                               'bank_id'=>$request->bank_id,
                                'loading_id'=>$loading_cargo->id,
                                     'date'=>$request->date,
                                ]
                                );                      
               }
        

           if($lcosts > 0){

        $codes= AccountCodes::where('account_name','Freight Cost')->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$freight->collection_date);
        $journal->date =  $freight->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier_costs';
        $journal->name = 'Loading Cost';
        $journal->debit =$lcosts;
          $journal->payment_id=$freight->pacel_id;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Freight Cost  with reference no " .$freight->pacel_number  ;
        $journal->save();

$cr= AccountCodes::where('id',$request->bank_id)->first();
          $journal = new JournalEntry();
        $journal->account_id =$request->bank_id;
         $date = explode('-',$freight->collection_date);
        $journal->date =  $freight->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
    $journal->transaction_type = 'courier_costs';
        $journal->name = 'Loading Cost';
        $journal->credit = $lcosts;
        $journal->payment_id= $freight->pacel_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Freight Cost  with reference no " .$freight->pacel_number  ;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $lcosts;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']=  0-$lcosts;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$lcosts;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Freight Cost',
                                 'module_id' => $freight->pacel_id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier Freight Cost  with reference no ' .$freight->pacel_number,
                                'type' => 'Expense',
                                'amount' =>$lcosts,
                                'debit' => $lcosts,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($freight->collection_date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier freight cost.The Reference is ' .$freight->pacel_number ,
                                'added_by' =>auth()->user()->added_by,
                            ]);       

}



$comm=CourierLoading::find($loading_cargo->id);
                           $data['status']=5;
                        $comm->update($data);
                         
                        if(!empty($comm)){
                            $activity = CourierActivity::create(
                                [ 
                                    'added_by'=>auth()->user()->added_by,
                                    'module_id'=>$comm->pacel_id,
                                    'module'=>'Courier',
                                    'activity'=>"Confirm Commission",
                               'costs'=>$ocosts,
                               'bank_id'=>$request->bank_id,
                                'loading_id'=>$loading_cargo->id,
                                     'date'=>$request->date,
                                ]
                                );                      
               }
        

           if($ocosts > 0){

        $codes= AccountCodes::where('account_name','Commission Cost')->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$comm->collection_date);
        $journal->date =  $comm->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier_costs';
        $journal->name = 'Offloading Cost';
        $journal->debit =$ocosts;
          $journal->payment_id=$comm->pacel_id;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Commission Cost  with reference no " .$comm->pacel_number  ;
        $journal->save();

$cr= AccountCodes::where('id',$request->bank_id)->first();
          $journal = new JournalEntry();
        $journal->account_id =$request->bank_id;
          $date = explode('-',$comm->collection_date);
        $journal->date =  $comm->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
    $journal->transaction_type = 'courier_costs';
        $journal->name = 'Offloading Cost';
        $journal->credit = $ocosts;
        $journal->payment_id= $comm->pacel_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Commission Cost with reference no " .$comm->pacel_number  ;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $ocosts;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']=  0-$ocosts;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$ocosts;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Commission Cost',
                                 'module_id' => $comm->pacel_id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier Commission Cost  with reference no ' .$comm->pacel_number,
                                'type' => 'Expense',
                                'amount' =>$ocosts,
                                'debit' => $ocosts,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($comm->collection_date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier commission cost.The Reference is ' .$comm->pacel_number ,
                                'added_by' =>auth()->user()->added_by,
                            ]);        

}


$del=CourierLoading::find($loading_cargo->id);
                           $data['status']=6;

                            $off=CourierActivity::where('loading_id',$loading_cargo->id)->where('activity','Confirm Commission')->first();
                                               $storage=Storage::where('name','Weight')->first();
                                               $courier=Courier::where('id',$del->pacel_id)->first();
                                              $s=$storage->days;
                                              $today = date('Y-m-d', strtotime($del->collection_date));
                                              $next= date('Y-m-d', strtotime("+$s days", strtotime($off->date))) ;

                                              if ($today >= $next) {
                                            $now = strtotime($today);; // or your date as well
                                           $your_date = strtotime($next);
                                           $datediff = $now - $your_date;

                                         $x= round($datediff / (60 * 60 * 24));
                                        $price=$x *($storage->price/$courier->exchange_rate) * $movement->weight;
                                         }

                                     else{
                                     $price=0;
                                                }

                                            $data['storage_costs']=$price;

                                             $del->update($data);
                         

                          $ditems['storage_costs']=$price;
                           $ditems['status']=4;

                        CourierCollection::where('id',$del->collection_id)->update($ditems);; 


                        if(!empty($del)){
                            $activity = CourierActivity::create(
                                [ 
                                    'added_by'=>auth()->user()->added_by,
                                    'module_id'=>$comm->pacel_id,
                                    'module'=>'Courier',
                                    'activity'=>"Confirm Delivery",
                               'costs'=>$dcosts,
                               'bank_id'=>$request->bank_id,
                                'loading_id'=>$loading_cargo->id,
                                     'date'=>$request->date,
                                ]
                                );                      
               }
        

           if($dcosts > 0){

        $codes= AccountCodes::where('account_name','Delivery Cost')->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$del->collection_date);
        $journal->date =  $del->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier_costs';
        $journal->name = 'Delivery Cost';
        $journal->debit =$dcosts;
          $journal->payment_id=$movement->pacel_id;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Delivery Cost  with reference no " .$movement->pacel_number  ;
        $journal->save();

$cr= AccountCodes::where('id',$request->bank_id)->first();
          $journal = new JournalEntry();
        $journal->account_id =$request->bank_id;
          $date = explode('-',$del->collection_date);
        $journal->date =  $del->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
    $journal->transaction_type = 'courier_costs';
        $journal->name = 'Delivery Cost';
        $journal->credit = $dcosts;
        $journal->payment_id= $movement->pacel_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Delivery Cost with reference no " .$movement->pacel_number  ;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $dcosts;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']=  0-$dcosts;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$dcosts;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Delivery Cost',
                                 'module_id' => $movement->pacel_id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier Delivery Cost  with reference no ' .$movement->pacel_number,
                                'type' => 'Expense',
                                'amount' =>$dcosts,
                                'debit' => $dcosts,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($del->collection_date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier delivery cost.The Reference is ' .$movement->pacel_number ,
                                'added_by' =>auth()->user()->added_by,
                            ]);       

}
     
    

            }
        }   
    
    }   


//dd($request->pcosts );
   $pArr =$request->pcosts ;
        $lArr = $request->lcosts  ;
        $oArr =$request->ocosts;
        $dArr = $request->dcosts;


        if(!empty($pArr)){
    for($xp = 0; $xp < count($pArr); $xp++){
                if(!empty($pArr[$xp])){
                      
                  
                    $cp = array(
                        'amount' => $pArr[$xp],
                        'date' =>   $request->date ,
                        'type' =>  'Pickup Costs',
                         'account_id' => $request->bank_id,                         
                           'added_by' => auth()->user()->added_by);
                       
                       CourierCost::create($cp);  ;    
    
                }
            }            
        }  


   
   if(!empty($lArr)){
    for($xl = 0; $xl < count($lArr); $xl++){
                if(!empty($lArr[$xl])){
                      
                  
                    $lp = array(
                        'amount' => $lArr[$xl],
                        'date' =>   $request->date ,
                        'type' =>  'Loading Costs',
                         'account_id' => $request->bank_id,                         
                           'added_by' => auth()->user()->added_by);
                       
                       CourierCost::create($lp);  ;    
    
                }
            }            
        }  


if(!empty($oArr)){
    for($xo = 0; $xo < count($oArr); $xo++){
                if(!empty($oArr[$xo])){
                    
                  
                    $op = array(
                        'amount' => $oArr[$xo],
                        'date' =>   $request->date ,
                        'type' =>  'OffLoading Costs',
                         'account_id' => $request->bank_id,                         
                           'added_by' => auth()->user()->added_by);
                       
                       CourierCost::create($op);  ;    
    
                }
            }            
        }  


        if(!empty($dArr)){
    for($xd = 0; $xd < count($dArr); $xd++){
                if(!empty($dArr[$xd])){
                     
                    $dp = array(
                        'amount' => $dArr[$xd],
                        'date' =>   $request->date ,
                        'type' =>  'Delivery Costs',
                         'account_id' => $request->bank_id,                         
                           'added_by' => auth()->user()->added_by);
                       
                       CourierCost::create($dp);  ;    
    
                }
            }            
        }  
      
 return redirect(route('courier.index'))->with(['success'=>'Activities Saved Successfully']);

    }



public function addSales(Request $request){
    
        //
        $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
 
 if($request->from_district_id != $request->to_district_id){   
 $count=Courier::count();
        $pro=$count+1;

  $pacel=Courier::create([
   'pacel_number' =>'CM0'.$pro ,
   'date' => $request->date ,
     'owner_id' => $request->owner_id ,
     'from_region_id' =>$request->from_region_id,
    'to_region_id' => $request->to_region_id ,
     'from_district_id' =>$request->from_district_id,
    'to_district_id' => $request->to_district_id ,
     'docs' => $request->docs  ,
     'non_docs' => $request->non_docs  ,
     'bags' => $request->bags ,
     'discount' => '0'  ,
     'status' => '0'  ,
     'good_receive' => '1'  ,
     'currency_code' => $request->currency_code,
     'exchange_rate' => $request->exchange_rate,
     'instructions' => $request->instructions  ,
     'added_by'=>auth()->user()->added_by,
]);


       $confirmation_number = "CM".$random.$pacel->id;
  $amountArr = str_replace(",","",$request->amount);
 $totalArr =  str_replace(",","",$request->tax);

  $nameArr =$request->item_name ;
 $qtyArr = $request->quantity  ;
 $priceArr = $request->price;
 $rateArr = $request->tax_rate ;
 $unitArr = $request->unit  ;
 $costArr = str_replace(",","",$request->total_cost)  ;
 $taxArr =  str_replace(",","",$request->total_tax );

  if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'amount' =>  $amountArr[$i],
                    'due_amount' =>  $amountArr[$i] ,
                      'confirmation_number' =>  $confirmation_number , 
                    'tax' =>   $totalArr[$i]);

                      Courier::where('id',$pacel->id)->update($t);  


            }
        }
    }    



    $cost['weight'] = 0;
    if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){
                  $cost['weight'] += $qtyArr[$i];
                $items = array(
                    'item_name' => $nameArr[$i],
                    'quantity' =>   $qtyArr[$i],
                    'tax_rate' =>  $rateArr [$i],
                     'unit' => $unitArr[$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i],
                     'items_id' =>  $nameArr[$i],
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'pacel_id' =>$pacel->id);

                $it= CourierItem::create($items);  ;

            }
        }
         $cost['tariff_id'] =$it->item_name  ;
          Courier::where('id',$pacel->id)->update($cost);
    }    


     $quot=Courier::find($pacel->id);  
                $route = Tariff::find($quot->tariff_id); 
               $region_from= Region::where('name',$route->from_region_id)->first(); 
             $region_to= Region::where('name',$route->to_region_id)->first(); 
        
                $result['pacel_id']=$pacel->id;
                $result['pacel_number']=$quot->pacel_number;
                $result['weight']=$quot->weight;
               $result['due_weight']=$quot->weight;
                $result['start_location']= $route->from_region_id;
                $result['end_location']=$route->to_region_id;
                $result['owner_id']=$quot->owner_id;
                $result['amount']=$quot->amount;
                $result['tariff_id']=$quot->tariff_id;
                $result['status']='2';
                $result['added_by'] = auth()->user()->added_by;
                $movement=CourierCollection::create($result);
       
       //return redirect(route('courier_quotation.show',$pacel->id));

        if (!empty($pacel)) {           
            return response()->json($movement);
         }

}


    }


public function addPickup(Request $request){
    
$movement=CourierCollection::find($request->id);


                    $loading_cargo =CourierLoading::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,                            
                            'type'=>'non_owned',
                            'weight'=>$movement->weight,
                           'total_weight'=>$movement->weight,
                            'status'=>'3',
                              'fuel'=>'0',
                           'pacel_id'=>$movement->pacel_id,
                           'pacel_name'=>$movement->pacel_name,
                         'pacel_number'=>$movement->pacel_number,
                         'start_location'=> $movement->start_location,
                         'end_location'=>$movement->end_location,
                        'owner_id'=>$movement->owner_id,
                         'collection_id'=>$request->id,
                        'amount'=>$movement->amount,
                        'tariff_id'=>$movement->tariff_id,
                       'collection_date'=>$request->collection_date,
                        ]
                        );                      
      

                 
                if(!empty($loading_cargo)){
                    $activity = CourierActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                            'module_id'=>$movement->pacel_id,
                            'module'=>'Courier',
                            'activity'=>"Confirm Pickup",
                            'notes'=>$request->notes,
                             'costs'=>$request->costs,
                               'bank_id'=>$request->bank_id,
                          'loading_id'=>$loading_cargo->id,
                           'date'=>$request->collection_date,
                        ]
                        );                      
       }

       
if($request->costs > 0){

        $codes= AccountCodes::where('account_name','Pickup Cost')->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier_costs';
        $journal->name = 'Pickup Cost';
        $journal->debit =$request->costs;
          $journal->payment_id=$movement->pacel_id;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Pickup Costs  with reference no " .$movement->pacel_number  ;
        $journal->save();

$cr= AccountCodes::where('id',$request->bank_id)->first();
          $journal = new JournalEntry();
        $journal->account_id =$request->bank_id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
    $journal->transaction_type = 'courier_costs';
        $journal->name = 'Pickup Cost';
        $journal->credit = $request->costs;
        $journal->payment_id= $movement->pacel_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Pickup Costs  with reference no " .$movement->pacel_number  ;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $request->costs;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']=  0-$request->costs;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$request->costs;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Pickup Cost',
                                 'module_id' => $movement->pacel_id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier Pickup Costs  with reference no ' .$movement->pacel_number,
                                'type' => 'Expense',
                                'amount' =>$request->costs,
                                'debit' => $request->costs,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->collection_date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier pickup cost.The Reference is ' .$movement->pacel_number ,
                                'added_by' =>auth()->user()->added_by,
                            ]);       

}



$data['due_weight']='0';
 $data['status']='3';

$result=$movement->update($data);
     

        if (!empty($loading_cargo)) {           
            return response()->json($loading_cargo);
         }



    }



public function addFreight(Request $request){
    
$movement=CourierLoading::find($request->id);

                             $data['method']=$request->method;
                             $data['awb']=$request->awb;
                           $data['status']=4;
                        $result=$movement->update($data);
                         
                        if(!empty($result)){
                            $activity = CourierActivity::create(
                                [ 
                                    'added_by'=>auth()->user()->added_by,
                                    'module_id'=>$movement->pacel_id,
                                    'module'=>'Courier',
                                    'activity'=>"Confirm Freight",
                                    'notes'=>$request->notes,
                               'costs'=>$request->costs,
                               'bank_id'=>$request->bank_id,
                                'loading_id'=>$request->id,
                                   'date'=>$request->collection_date,
                                ]
                                );                      
               }
        

           if($request->costs > 0){

        $codes= AccountCodes::where('account_name','Freight Cost')->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier_costs';
        $journal->name = 'Loading Cost';
        $journal->debit =$request->costs;
          $journal->payment_id=$movement->pacel_id;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Freight Cost  with reference no " .$movement->pacel_number  ;
        $journal->save();

$cr= AccountCodes::where('id',$request->bank_id)->first();
          $journal = new JournalEntry();
        $journal->account_id =$request->bank_id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
    $journal->transaction_type = 'courier_costs';
        $journal->name = 'Loading Cost';
        $journal->credit = $request->costs;
        $journal->payment_id= $movement->pacel_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Freight Cost  with reference no " .$movement->pacel_number  ;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $request->costs;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']=  0-$request->costs;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$request->costs;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Freight Cost',
                                 'module_id' => $movement->pacel_id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier Freight Cost  with reference no ' .$movement->pacel_number,
                                'type' => 'Expense',
                                'amount' =>$request->costs,
                                'debit' => $request->costs,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->collection_date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier freight cost.The Reference is ' .$movement->pacel_number ,
                                'added_by' =>auth()->user()->added_by,
                            ]);       

}

   if (!empty($result)) {    
          $loading_cargo=CourierLoading::find($request->id);       
            return response()->json($loading_cargo);
         }



    }



public function addCommission(Request $request){
    
$movement=CourierLoading::find($request->id);
$result=$movement->update(['status'=>5]);
                                 
                                if(!empty($result)){
                                    $activity = CourierActivity::create(
                                        [ 
                                            'added_by'=>auth()->user()->added_by,
                                            'module_id'=>$movement->pacel_id,
                                            'module'=>'Courier',
                                            'activity'=>"Confirm Commission",
                                            'notes'=>$request->notes,
                                            'loading_id'=>$request->id,
                                          'costs'=>$request->costs,
                               'bank_id'=>$request->bank_id,
                                           'date'=>$request->collection_date,
                                        ]
                                        );                      
                       }

 
                                if($request->costs > 0){

        $codes= AccountCodes::where('account_name','Commission Cost')->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier_costs';
        $journal->name = 'Offloading Cost';
        $journal->debit =$request->costs;
          $journal->payment_id=$movement->pacel_id;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Commission Cost  with reference no " .$movement->pacel_number  ;
        $journal->save();

$cr= AccountCodes::where('id',$request->bank_id)->first();
          $journal = new JournalEntry();
        $journal->account_id =$request->bank_id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
    $journal->transaction_type = 'courier_costs';
        $journal->name = 'Offloading Cost';
        $journal->credit = $request->costs;
        $journal->payment_id= $movement->pacel_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Commission Cost with reference no " .$movement->pacel_number  ;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $request->costs;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']=  0-$request->costs;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$request->costs;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Commission Cost',
                                 'module_id' => $movement->pacel_id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier Commission Cost  with reference no ' .$movement->pacel_number,
                                'type' => 'Expense',
                                'amount' =>$request->costs,
                                'debit' => $request->costs,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->collection_date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier commission cost.The Reference is ' .$movement->pacel_number ,
                                'added_by' =>auth()->user()->added_by,
                            ]);       

}

                    
                      
        if (!empty($result)) {    
          $loading_cargo=CourierLoading::find($request->id);       
            return response()->json($loading_cargo);
         }



    }


public function addDelivery(Request $request){
    
$movement=CourierLoading::find($request->id);
 $data['status']=6;

                                               $off=CourierActivity::where('loading_id',$request->id)->where('activity','Confirm Commission')->first();
                                               $storage=Storage::where('name','Weight')->first();
                                               $courier=Courier::where('id',$movement->pacel_id)->first();
                                              $s=$storage->days;
                                              $today = date('Y-m-d', strtotime($request->collection_date));
                                              $next= date('Y-m-d', strtotime("+$s days", strtotime($off->date))) ;

                                              if ($today >= $next) {
                                            $now = strtotime($today);; // or your date as well
                                           $your_date = strtotime($next);
                                           $datediff = $now - $your_date;

                                         $x= round($datediff / (60 * 60 * 24));
                                        $price=$x *($storage->price/$courier->exchange_rate) * $movement->weight;
                                         }

                                     else{
                                     $price=0;
                                                }

                                            $data['storage_costs']=$price;
                                        $result=$movement->update($data);

                                          $items['storage_costs']=$price;
                                           $items['status']=4;

                                        CourierCollection::where('id',$movement->collection_id)->update($items);; 
                                         
                                        if(!empty($result)){
                                            $activity = CourierActivity::create(
                                                [ 
                                                    'added_by'=>auth()->user()->added_by,
                                                    'module_id'=>$movement->pacel_id,
                                                    'module'=>'Courier',
                                                    'activity'=>"Confirm Delivery",
                                                 'loading_id'=>$request->id,
                                                 'costs'=>$request->costs,
                                                'bank_id'=>$request->bank_id,
                                                    'notes'=>$request->notes,
                                                   'date'=>$request->collection_date,
                                                ]
                                                );                      
                               }


 
                                if($request->costs > 0){

        $codes= AccountCodes::where('account_name','Delivery Cost')->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier_costs';
        $journal->name = 'Delivery Cost';
        $journal->debit =$request->costs;
          $journal->payment_id=$movement->pacel_id;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Delivery Cost  with reference no " .$movement->pacel_number  ;
        $journal->save();

$cr= AccountCodes::where('id',$request->bank_id)->first();
          $journal = new JournalEntry();
        $journal->account_id =$request->bank_id;
          $date = explode('-',$request->collection_date);
        $journal->date =  $request->collection_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
    $journal->transaction_type = 'courier_costs';
        $journal->name = 'Delivery Cost';
        $journal->credit = $request->costs;
        $journal->payment_id= $movement->pacel_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Courier Delivery Cost with reference no " .$movement->pacel_number  ;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $request->costs;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']=  0-$request->costs;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$request->costs;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Delivery Cost',
                                 'module_id' => $movement->pacel_id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier Delivery Cost  with reference no ' .$movement->pacel_number,
                                'type' => 'Expense',
                                'amount' =>$request->costs,
                                'debit' => $request->costs,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->collection_date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from courier delivery cost.The Reference is ' .$movement->pacel_number ,
                                'added_by' =>auth()->user()->added_by,
                            ]);       

}
                        

    if (!empty($result)) {    
         return redirect(route('courier.index'))->with(['success'=>'Activities Saved Successfully']);
         }



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
       
    }

   public function findTariff(Request $request)
    {
               //$price= CourierList::where('id',$request->id)->get();
              $price= Tariff::where('client_id',$request->id)->get();
                return response()->json($price);                      

    }

    public function findPrice(Request $request)
    {
               //$price= CourierList::where('id',$request->id)->get();
              $price= Tariff::where('id',$request->id)->get();
                return response()->json($price);                      

    }


 public function report()
    {
 //
        $region = Region::all();
         $client = CourierClient::where('user_id',auth()->user()->added_by)->get();
        $report = CourierLoading::where('activity',1)->get();
      
        return view('courier.newreport',compact('region','report','client'));
    

    }

 public function findReport (Request $request)
    {

         $data['report'] = CourierLoading::query();

          if(!empty($request->from)){
              $data['report'] = $data['report']->where('start_location',$request->from);
}
 if(!empty($request->to)){
              $data['report'] =$data['report']->where('end_location',$request->to);
}
 if(!empty($request->status)){
              $data['report'] = $data['report']->where('status',$request->status);
}
 if(!empty($request->client_id)){
              $data['report'] = $data['report']->where('owner_id',$request->client_id);
}
 if(!empty($request->start_date) && !empty($request->end_date)){
              $data['report'] =$data['report']->whereBetween('collection_date',  [$request->start_date, $request->end_date]);
}

$data['report']=$data['report']->where('activity',1)->get();
            
               $data['region'] = Region::all();
                 $data['client'] = CourierClient::where('user_id',auth()->user()->added_by)->get();
               // return response()->json($report);;
                   return response()->json(['html' => view('courier.addnewreport', $data)->render()]);           

    }

 


 
}
