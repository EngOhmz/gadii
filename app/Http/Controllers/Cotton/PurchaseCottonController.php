<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\InventoryPayment;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\District;
use App\Models\Payment_methodes;
use App\Models\Cotton\Cotton;
use App\Models\Cotton\PurchaseCotton;
use App\Models\Cotton\PurchaseItemCotton;
use App\Models\Cotton\CottonList;
use App\Models\Cotton\CottonHistory;
use App\Models\Supplier;
use App\Models\InventoryList;
use App\Models\Cotton\CollectionCenter;
use App\Models\Cotton\Operator;
use App\Models\Cotton\CottonMovement;
use App\Models\Cotton\CottonItemMovement;
use App\Models\Cotton\CottonLevyMovement; ;;

use PDF;

use Illuminate\Http\Request;

class PurchaseCottonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $currency= Currency::all();
        $purchases=PurchaseCotton::orderBy('created_at','asc')->get();
        $supplier=Supplier::all();
           $operator=Operator::all();
           $all_center =CollectionCenter::all();
        $type="";
            $name = Cotton::all();

       return view('cotton.manage_purchase_cotton',compact('name','currency','purchases','operator','type'))->with('all_center',$all_center);
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
        if ($request->from == "movement") {
            if(empty($request->purchase_date))
            return redirect(route('cotton_movement.index'))->with(['error'=>"Purchase Not saved.Select Date First"]);
            $qty=CollectionCenter::find($request->location);
$balance=abs($qty->quantity-$request->quantity);

       $collection = CollectionCenter::find($request->location);



        $data['reference_no']='1';
        $data['reference']=$request->reference;
         $data['district_id']=$collection->district_id;
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['item_id'] =$request->item_id ;
        $data['quantity'] = $balance  ;
         $data['price'] = $request->price;
         $data['tax_rate'] = $request->tax_rate ;
         $data['unit'] = $request->unit  ;
        $data['purchase_amount']=$balance * $request->price + (($balance * $request->price) * $request->tax_rate);
        $data['due_amount']=$balance * $request->price + (($balance * $request->price) * $request->tax_rate);
        $data['purchase_tax']=($balance * $request->price) * $request->tax_rate;
        $data['status']='1';
        $data['good_receive']='1';
        $data['added_by']= auth()->user()->id;

        $purchase = PurchaseCotton::create($data);
        
            $cost['reference_no']= "PUR_CTN-".$purchase->id."-".$data['purchase_date'];
            PurchaseCotton::where('id',$purchase->id)->update($cost);
          

                $name=Cotton::where('id', $request->item_id)->first();
                $dt=date('Y',strtotime($data['purchase_date']));
                    $lists = array(
                        'serial_no' => $name->name."_" .$purchase->id."__" .$dt,                      
                         'brand_id' => $request->item_id,
                           'added_by' => auth()->user()->id,
                           'purchase_id' =>   $purchase->id,
                         'purchase_date' =>  $data['purchase_date'],
                           'location' => $data['location'],
                           'status' => '0');
                       
     
                   CottonList::create($lists);  


           $items = array(
                            'quantity' =>  $balance,
                              'due_quantity' =>   $balance,
                             'items_id' =>  $request->item_id,
                               'added_by' => auth()->user()->id,
                               'supplier_id' =>   $data['supplier_id'],
                             'purchase_date' =>  $data['purchase_date'],
                        'reference' =>    $purchase->reference,
                             'price' =>   $request->price,
                               'location' => $data['location'],
                            'purchase_id' =>$purchase->id);
                           
         
                        CottonHistory::create($items);   
          
                        $inv=CollectionCenter::where('id',$data['location'])->first();
                        $q=$inv->quantity + $balance;
                       CollectionCenter::where('id',$data['location'])->update(['quantity' => $q]);



            $supp=Operator::find($purchase->supplier_id);
            $cr= AccountCodes::where('account_name','Stock-In Village')->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$purchase->purchase_date);
          $journal->date =   $purchase->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'cotton';
          $journal->name = 'Cotton Purchase';
          $journal->debit = $purchase->purchase_amount - $purchase->purchase_tax;
          $journal->income_id= $purchase->id;
            $journal->center_id= $inv->id;
           $journal->added_by=auth()->user()->id;
             $journal->notes="Stock Control with reference no " .$purchase->reference ." by Operator ". $supp->name." from ".$inv->name." Center" ;             
          $journal->save();
        
        if($purchase->purchase_tax > 0){
         $tax= AccountCodes::where('account_name','VAT IN')->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
           $journal->transaction_type = 'cotton';
          $journal->name = 'Cotton Purchase';
         $date = explode('-',$purchase->purchase_date);
          $journal->date =   $purchase->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->debit = $purchase->purchase_tax ;
          $journal->income_id= $purchase->id;
        $journal->center_id= $inv->id;
       $journal->added_by=auth()->user()->id;
          $journal->notes="Stock Control with reference no " .$purchase->reference ." by Operator ". $supp->name." from ".$inv->name." Center"  ;
          $journal->save();
        }
        
          $codes= AccountCodes::where('account_name','Collection Center Account')->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$purchase->purchase_date);
          $journal->date =   $purchase->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'cotton';
          $journal->name = 'Cotton Purchase';
          $journal->income_id= $purchase->id;
         $journal->center_id= $inv->id;
          $journal->credit =$purchase->purchase_amount ;
          $journal->added_by=auth()->user()->id;
            $journal->notes="Stock Control with reference no " .$purchase->reference ." by Operator ". $supp->name." from ".$inv->name." Center"  ;
          $journal->save();
          
          //return view('cotton.add3');
         //return response(['message' => true]);
         return redirect(route('cotton_movement.index'));
          
        }elseif($request->type == "creditor"){
        
        $amountArr = array();
        $nameArr =array() ;
        $qtyArr = array();
        $priceArr = array();
        $purArr =array();
        $costArr=array();
        $temp_amount = $request->quantity * $request->price;
        $total_amount = $temp_amount;
           array_push($nameArr,$request->item_id);
                 array_push($qtyArr,$request->quantity); 
                 array_push($priceArr,$request->price); 
                 array_push($purArr,0);
                 array_push($costArr,$temp_amount);
                 array_push($amountArr,$total_amount);
        
          $cotton=Cotton::where('name','Cotton')->first();


    $main=CollectionCenter::where('head','1')->first();
    
       $data['source_location']=$request->location;
       $data['destination_location']=$main->id;
           $data['rate']=1;
           $data['distance']=0;
        $data['transport']=0;
        $data['date']=$request->date;
        $data['amount']=$total_amount;
      $data['quantity']=$request->quantity;
        $data['truck_id']=0;
        $data['status2'] = 2;
        $data['added_by']= auth()->user()->id;

        $movement= CottonMovement::create($data);
        
        
               if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                 
                    $items = array(
                        'item_id' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                         'movement_id' => $movement->id,
                           'order_no' => $i,
                            
                           'added_by' => auth()->user()->id,
                        'purchase_id' =>$purArr[$i]);
                       
                     CottonItemMovement::create($items);  ;

$transfer=CottonMovement::find( $movement->id);

 $dr= AccountCodes::where('account_name','Stock Movement')->first();
 $cr= $request->location;
              
                  $journal = new JournalEntry();
        $journal->account_id = $dr->id;
        $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'cotton';
        $journal->name = 'Stock Movement';
        $journal->income_id =    $transfer->id;
         $journal->notes='Stock Movement From creditors';
        $journal->debit= $transfer->amount ;
        //$journal->center_id= $transfer->source_location;
    $journal->added_by=auth()->user()->id;
        $journal->save();
        
           $journal = new JournalEntry();
        $journal->account_id =    $cr;
       $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
         $journal->month = $date[1];
        $journal->transaction_type = 'cotton';
        $journal->name = 'Stock  Movement';
          $journal->notes='Stock  Movement From  creditors';
        $journal->credit=    $transfer->amount ;
      $journal->income_id =    $transfer->id;
       // $journal->center_id= $transfer->source_location;
$journal->added_by=auth()->user()->id;
        $journal->save();

//  $inv=CottonHistory::where('purchase_id',$purArr[$i])->first();
// $cost['source_location']=$inv->location;
//      CottonMovement::where('id',$movement->id)->update($cost);
    
                }


}
        }   
        
             return redirect()->back();  
        }
        
        
     
        else{
$qty=CollectionCenter::find($request->location);
$balance=abs($qty->quantity-$request->quantity);

$collection = CollectionCenter::find($request->location);



        $data['reference_no']='1';
        $data['reference']=$request->reference;
         $data['district_id']=$collection->district_id;
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['item_id'] =$request->item_id ;
        $data['quantity'] = $balance  ;
         $data['price'] = $request->price;
         $data['tax_rate'] = $request->tax_rate ;
         $data['unit'] = $request->unit  ;
        $data['purchase_amount']=$balance * $request->price + (($balance * $request->price) * $request->tax_rate);
        $data['due_amount']=$balance * $request->price + (($balance * $request->price) * $request->tax_rate);
        $data['purchase_tax']=($balance * $request->price) * $request->tax_rate;
        $data['status']='1';
        $data['good_receive']='1';
        $data['added_by']= auth()->user()->id;

        $purchase = PurchaseCotton::create($data);
        
            $cost['reference_no']= "PUR_CTN-".$purchase->id."-".$data['purchase_date'];
            PurchaseCotton::where('id',$purchase->id)->update($cost);
          

                $name=Cotton::where('id', $request->item_id)->first();
                $dt=date('Y',strtotime($data['purchase_date']));
                    $lists = array(
                        'serial_no' => $name->name."_" .$purchase->id."__" .$dt,                      
                         'brand_id' => $request->item_id,
                           'added_by' => auth()->user()->id,
                           'purchase_id' =>   $purchase->id,
                         'purchase_date' =>  $data['purchase_date'],
                           'location' => $data['location'],
                           'status' => '0');
                       
     
                   CottonList::create($lists);  


           $items = array(
                            'quantity' =>  $balance,
                              'due_quantity' =>   $balance,
                             'items_id' =>  $request->item_id,
                               'added_by' => auth()->user()->id,
                               'supplier_id' =>   $data['supplier_id'],
                             'purchase_date' =>  $data['purchase_date'],
                        'reference' =>    $purchase->reference,
                             'price' =>   $request->price,
                               'location' => $data['location'],
                            'purchase_id' =>$purchase->id);
                           
         
                        CottonHistory::create($items);   
          
                        $inv=CollectionCenter::where('id',$data['location'])->first();
                        $q=$inv->quantity + $balance;
                       CollectionCenter::where('id',$data['location'])->update(['quantity' => $q]);



            $supp=Operator::find($purchase->supplier_id);
            $cr= AccountCodes::where('account_name','Stock-In Village')->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$purchase->purchase_date);
          $journal->date =   $purchase->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'cotton';
          $journal->name = 'Cotton Purchase';
          $journal->debit = $purchase->purchase_amount - $purchase->purchase_tax;
          $journal->income_id= $purchase->id;
            $journal->center_id= $inv->id;
           $journal->added_by=auth()->user()->id;
             $journal->notes="Stock Control with reference no " .$purchase->reference ." by Operator ". $supp->name." from ".$inv->name." Center" ;             
          $journal->save();
        
        if($purchase->purchase_tax > 0){
         $tax= AccountCodes::where('account_name','VAT IN')->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
           $journal->transaction_type = 'cotton';
          $journal->name = 'Cotton Purchase';
         $date = explode('-',$purchase->purchase_date);
          $journal->date =   $purchase->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->debit = $purchase->purchase_tax ;
          $journal->income_id= $purchase->id;
        $journal->center_id= $inv->id;
       $journal->added_by=auth()->user()->id;
          $journal->notes="Stock Control with reference no " .$purchase->reference ." by Operator ". $supp->name." from ".$inv->name." Center"  ;
          $journal->save();
        }
        
          $codes= AccountCodes::where('account_name','Collection Center Account')->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$purchase->purchase_date);
          $journal->date =   $purchase->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'cotton';
          $journal->name = 'Cotton Purchase';
          $journal->income_id= $purchase->id;
         $journal->center_id= $inv->id;
          $journal->credit =$purchase->purchase_amount ;
          $journal->added_by=auth()->user()->id;
            $journal->notes="Stock Control with reference no " .$purchase->reference ." by Operator ". $supp->name." from ".$inv->name." Center"  ;
          $journal->save();
          
        
        return redirect(route('purchase_cotton.index'))->with(['success'=>'Stock Created Successfully']);;
        
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
        $purchases = PurchaseCotton::find($id);
        $purchase_items=PurchaseItemCotton::where('purchase_id',$id)->get();
        
        return view('cotton.purchase_cotton_details',compact('purchases','purchase_items'));
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
        $currency= Currency::all();
        $name = Cotton::all();
        $data=PurchaseCotton::find($id);
        $items=PurchaseItemCotton::where('purchase_id',$id)->get();
      $operator=Operator::all() ;
    $center= CollectionCenter::where('operator_id',$data->supplier_id)->where('name','!=','Main Center')->get();
        $type="";
       return view('cotton.manage_purchase_cotton',compact('name','currency','data','id','items','type','operator','center'));
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

        if($request->type == 'receive'){
            $purchase = PurchaseCotton::find($id);
            $data['supplier_id']=$request->supplier_id;
         $data['weight']=$request->weight;
            $data['purchase_date']=$request->purchase_date;
            $data['due_date']=$request->due_date;
            $data['location']=$request->location;
            $data['purchase_amount']='1';
            $data['due_amount']='1';
            $data['purchase_tax']='1';
            $data['good_receive']='1';
           $data['status']='1';
            $data['added_by']= auth()->user()->id;
    
            $purchase->update($data);
            
            $amountArr = str_replace(",","",$request->amount);
            $totalArr =  str_replace(",","",$request->tax);
    
            $nameArr =$request->item_name ;
            $qtyArr = $request->quantity  ;
            $priceArr = $request->price;
            $rateArr = $request->tax_rate ;
            $unitArr = $request->unit  ;
            $costArr = str_replace(",","",$request->total_cost)  ;
            $taxArr =  str_replace(",","",$request->total_tax );
            $remArr = $request->removed_id ;
            $expArr = $request->saved_items_id ;
            $savedArr =$request->item_name ;
            
            $cost['purchase_amount'] = 0;
            $cost['purchase_tax'] = 0;
    
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    PurchaseItemCotton::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $cost['purchase_amount'] +=$costArr[$i];
                        $cost['purchase_tax'] +=$taxArr[$i];
    
                        $items = array(
                            'item_name' => $nameArr[$i],
                            'quantity' =>   $qtyArr[$i],
                            'tax_rate' =>  $rateArr [$i],
                             'unit' => $unitArr[$i],
                               'price' =>  $priceArr[$i],
                            'total_cost' =>  $costArr[$i],
                            'total_tax' =>   $taxArr[$i],
                             'items_id' => $savedArr[$i],
                               'order_no' => $i,
                               'added_by' => auth()->user()->id,
                            'purchase_id' =>$id);
                           
                            if(!empty($expArr[$i])){
                                PurchaseItemCotton::where('id',$expArr[$i])->update($items);  
          
          }
          else{
            PurchaseItemCotton::create($items);   
          }
                      
  
                $name=Cotton::where('id', $savedArr[$i])->first();
                $dt=date('Y',strtotime($data['purchase_date']));
                    $lists = array(
                        'serial_no' => $name->name."_" .$id."__" .$dt,                      
                         'brand_id' => $savedArr[$i],
                           'added_by' => auth()->user()->id,
                           'purchase_id' =>   $id,
                         'purchase_date' =>  $data['purchase_date'],
                           'location' => $data['location'],
                           'status' => '0');
                       
     
                   CottonList::create($lists);   
      
              
         
  
                    }
                }
                $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
                PurchaseCotton::where('id',$id)->update($cost);
            }    
    
            
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                        $items = array(
                            'quantity' =>   $qtyArr[$i],
                              'due_quantity' =>   $qtyArr[$i],
                             'items_id' => $savedArr[$i],
                               'added_by' => auth()->user()->id,
                               'supplier_id' =>   $data['supplier_id'],
                             'purchase_date' =>  $data['purchase_date'],
                        'reference' =>    $purchase->reference,
                             'price' =>  $priceArr[$i],
                               'location' => $data['location'],
                            'purchase_id' =>$id);
                           
         
                        CottonHistory::create($items);   
          
                        $inv=CollectionCenter::where('id',$data['location'])->first();
                        $q=$inv->quantity + $qtyArr[$i];
                       CollectionCenter::where('id',$data['location'])->update(['quantity' => $q]);
                    }
                }
            
            }    
    
    
            $inv = PurchaseCotton::find($id);
            $supp=Operator::find($inv->supplier_id);
            $cr= AccountCodes::where('account_name','Cotton')->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'cotton';
          $journal->name = 'Cotton Purchase';
          $journal->debit = $inv->purchase_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
             $journal->notes= "Cotton Purchase with reference no " .$inv->reference_no ." by Supplier ". $supp->name ;
          $journal->save();
        
        if($inv->purchase_tax > 0){
         $tax= AccountCodes::where('account_name','VAT IN')->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
           $journal->transaction_type = 'cotton';
          $journal->name = 'Cotton Purchase';
         $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->debit = $inv->purchase_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
             $journal->notes= "Cotton Purchase Tax with reference no " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
        }
        
          $codes= AccountCodes::where('account_name','Payables')->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'cotton';
          $journal->name = 'Cotton Purchase';
          $journal->income_id= $inv->id;
          $journal->credit =$inv->due_amount *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
             $journal->notes= "Credit for Cotton Purchase with reference no " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
    
    
            return redirect(route('purchase_cotton.show',$id));
    

        }

        else{
        $purchase = PurchaseCotton::find($id);
        $data['supplier_id']=$request->supplier_id;
     $data['weight']=$request->weight;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
        $data['added_by']= auth()->user()->id;

        $purchase->update($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;
        $savedArr =$request->item_name ;
        
        $cost['purchase_amount'] = 0;
        $cost['purchase_tax'] = 0;

        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                PurchaseItemCotton::where('id',$remArr[$i])->delete();        
                   }
               }
           }

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['purchase_amount'] +=$costArr[$i];
                    $cost['purchase_tax'] +=$taxArr[$i];

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->id,
                        'purchase_id' =>$id);
                       
                        if(!empty($expArr[$i])){
                            PurchaseItemCotton::where('id',$expArr[$i])->update($items);  
      
      }
      else{
        PurchaseItemCotton::create($items);   
      }
                    
                }
            }
            $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
            PurchaseCotton::where('id',$id)->update($cost);
        }    

        

        return redirect(route('purchase_cotton.show',$id));

    }



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
        PurchaseItemCotton::where('purchase_id', $id)->delete();
       CottonHistory::where('purchase_id', $id)->delete();
        $purchases = PurchaseCotton::find($id);
        $purchases->delete();
        return redirect(route('purchase_cotton.index'))->with(['success'=>'Deleted Successfully']);
    }

   public function findStock(Request $request)
    {
               $stock=CollectionCenter::where('id',$request->id)->first();
$price="The current stock for " .$stock->name." is ".  number_format($stock->quantity,2) ;
                return response()->json($price);	                  

    }

    public function findPrice(Request $request)
    {
               $price=Cotton::where('id',$request->id)->get();
                return response()->json($price);	                  

    }

    public function approve($id)
    {
        //
        $purchase = PurchaseCotton::find($id);
        $data['status'] = 1;
        $purchase->update($data);
        return redirect(route('purchase_cotton.index'))->with(['success'=>'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $purchase = PurchaseCotton::find($id);
        $data['status'] = 4;
        $purchase->update($data);
        return redirect(route('purchase_cotton.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
        $name = Cotton::all();
        $operator = Operator::all();
      $data=PurchaseCotton::find($id);
        $items=PurchaseItemCotton::where('purchase_id',$id)->get();
       $center= CollectionCenter::where('operator_id',$data->supplier_id)->where('head','!=','1')->get();
        $type="receive";
       return view('cotton.manage_purchase_cotton',compact('name','currency','operator','data','id','items','type','center'));
    }

  public function inventory_list()
    {
        //
        $tyre= CottonList ::all();
       return view('cotton.list',compact('tyre'));
    }
   
    public function inv_pdfview(Request $request)
    {
        //
        $purchases = PurchaseCotton::find($request->id);
        $purchase_items=PurchaseItemCotton::where('purchase_id',$request->id)->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('cotton.purchase_cotton_pdf')->setPaper('a4', 'landscape');
         return $pdf->download('STOCK CONTROL REF NO # ' .  $purchases->reference . ".pdf");
        }
        return view('inv_pdfview');
    }
}
