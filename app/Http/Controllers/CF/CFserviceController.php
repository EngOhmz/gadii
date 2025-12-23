<?php

namespace App\Http\Controllers\CF;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Project\Milestone;
use App\Models\CF\Project;
use App\Models\Client;
use App\Models\Project\Category;
use App\Models\CF\Cargo;
use App\Models\CF\CargoType;
use App\Models\CF\Storage;
use App\Models\CF\Charge;
use App\Models\CF\CFservice;
use App\Models\CF\Warehouse;
use App\Models\AccountCodes;
use App\Models\Project\Billing_Type;
use App\Models\Project\MilestoneActivity as Activity;
use App\Models\User;
use Carbon\Carbon;
use App\Models\CF\Invoice;
use App\Models\CF\InvoiceItems;
use App\Models\CF\InvoicePayments;
use App\Models\CF\InvoiceHistory;
use App\Models\Branch;
use App\Models\JournalEntry;
use App\Models\Accounts;
use App\Models\Currency;

class CFserviceController extends Controller
{  
    
    public function index()
    {  
        $gl_account= AccountCodes::all()->whereNotIn('account_name', ['VAT IN', 'VAT OUT','Value Added Tax (VAT)','Deffered Tax'])->whereNotIn('account_codes', ['31101'])->where('disabled','0')->where('added_by',auth()->user()->added_by);
        $cfservice= CFservice::all()->where('added_by',auth()->user()->added_by)->where('disabled','0');
                
        return view('cf.cfservice',compact('gl_account','cfservice'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    { 
        $data=$request->post();
        $data['amount'] = str_replace(",","",$request->amount);
        $data['added_by']=auth()->user()->added_by;
        
        $cfservice= CFservice::create($data);


        
        return redirect(route('cf_service.index'))->with(['success'=>'CF service Created Successfully']);
    }
    
         public function show($id)
    {
        $data = CFservice::find($id);
                
        return redirect(route('cf_service.index',compact('data')));
              
    }

    
      public function edit($id)
    {
         $data = CFService::find($id);
         $gl_account =AccountCodes::all()->whereNotIn('account_name', ['VAT IN', 'VAT OUT','Value Added Tax (VAT)','Deffered Tax'])->whereNotIn('account_codes', ['31101'])->where('disabled','0')->where('added_by',auth()->user()->added_by);
         $warehouse = Warehouse::find($id);

          return view('cf.cfservice',compact('data','gl_account', 'id','warehouse'));
         
    }
    

  
public function update(Request $request, $id)
    {
        $cfservice = Cfservice::find($id);
        
          $data=$request->post();
           $data['amount'] = str_replace(",","",$request->amount);
        $data['added_by']=auth()->user()->added_by;
        
         $cfservice->update($data);

       
        return redirect(route('cf_service.index'))->with(['success'=>'CF service Updated Successfully']);
    }

    public function destroy($id)
    {
        $Cfservice = CFservice ::find($id);
        $Cfservice->update(['disabled'=> '1']);;
        return redirect(route('cf_service.index'))->with(['success'=>'CF service Created Successfully']);
    }
    
     public function edit_warehouse($id)
    {
         
         //$data = Warehouse::find($id);
       
          return view('cf.warehouse',compact('id','data'));
         
    }
    
    public function storage_details(Request $request){
        
        switch ($request->type) {
            
        case 'storage':
         
        $data = $request->all();
        $data['cf_id'] = $request->cf_id;
        $data['added_by'] = auth()->user()->added_by;
        $data['user_id'] = auth()->user()->id;

        $storage =Storage::create($data);

        if(!empty($storage)){
                            $activity =Activity::create(
                                [ 
                                    'added_by'=>auth()->user()->id,
                                    'module_id'=>$storage->id,
                                    'project_id'=>$request->cf_id,
                                    'module'=>'Comment',
                                    'activity'=>"Comment Created",
                                ]
                                );                      
               }
        
          return redirect(route('cf.show',$request->cf_id))->with(['success'=>"Details Created Successfully",'type'=>'storage']);

        break;
        
         case 'warehouse':
         
        $data = $request->all();
       
        $data['cf_id'] = $request->cf_id;
        $data['added_by'] = auth()->user()->added_by;
        $data['user_id'] = auth()->user()->id;

        $storage = Warehouse::create($data);

        if(!empty($storage)){
                            $activity = Activity::create(
                                [ 
                                    'added_by'=>auth()->user()->id,
                                    'module_id'=>$storage->id,
                                    'project_id'=>$request->cf_id,
                                    'module'=>'warehouse',
                                    'activity'=>"warehouse Created",
                                ]
                                );                      
               }
        
           return redirect()->back()->with('success', ' Warehouse Created Succsessfully');

            break;
    }
}


    public function findService(Request $request)
    {
               $price= CFService::where('id',$request->id)->get();
                return response()->json($price);                      

    }
    

     public function charge_details(Request $request){

//dd($request->all());
        $b= $request->all();
        $b['amount'] = str_replace(",","",$request->amount);
        $b['added_by'] = auth()->user()->added_by;
        $charge=Charge::create($b);

        if(!empty($charge)){
                            $activity =Activity::create(
                                [ 
                                    'added_by'=>auth()->user()->id,
                                    'module_id'=>$charge->id,
                                    'project_id'=>$request->cf_id,
                                    'module'=>'Charge',
                                    'activity'=>"ChargeCreated",
                                ]
                                );                      
               }
               
            $project=Project::find($request->cf_id) ;  
            $service=CFService::find($request->cf_servece_id) ; 
            
            if($project->related == 'Clients'){
                $client=$project->client_id;
                 $supp=Client::find($client);
            }
            else{
               $client=$project->department_id;
               $supp=Departments::find($client);
            }
               
        if($request->charge_type == 'Invoiced'){
            
        $chk=Invoice::where('added_by', auth()->user()->added_by)->where('cf_id', $request->cf_id)->where('type', 'Invoice')->where('quotation', '0')->whereIn('status', [0,1])->first(); 
        if(!empty($chk)){
            $prev=Invoice::where('added_by', auth()->user()->added_by)->where('type', 'Invoice')->where('quotation', '0')->whereIn('status', [0,1])->latest('id')->first();
            
        $nameArr =$request->cf_servece_id ;
        $qtyArr = 1  ;
        $priceArr = str_replace(",","",$request->amount);
        $rateArr = 0.18 ;
        $costArr = str_replace(",","",$request->amount)  ;
        $taxArr =  $costArr * $rateArr;        

    

     if(!empty($nameArr)){
         
                $t = array(
                'invoice_amount' =>  $prev->invoice_amount + $costArr,
                'invoice_tax' =>   $prev->invoice_tax + $taxArr,                     
                'due_amount' =>   $prev->due_amount + $costArr +  $taxArr);

              Invoice::where('id',$prev->id)->update($t);  
     
 
                    $items = array(
                        'item_name' => $nameArr,
                        'quantity' =>   $qtyArr,
                       'due_quantity' =>   $qtyArr,
                       'tax_rate' =>  $rateArr,
                       'price' =>  $priceArr,
                       'total_cost' =>  $costArr,
                       'total_tax' =>   $taxArr,
                        'items_id' => $nameArr,
                        'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$prev->id);
                       
                        InvoiceItems::create($items);  ;
    
             $cost['invoice_amount'] = $costArr;
             $cost['invoice_tax'] = $rateArr;
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
            InvoiceItems::where('id',$prev->id)->update($cost);
        }  
        
            
        }
        else{            
        $count=Invoice::where('added_by', auth()->user()->added_by)->where('type', 'Invoice')->where('quotation', '0')->count();
        $pro=$count+1;
        $data['reference_no']= "CFS0".$pro;
        $data['related']=$project->related;
        $data['client_id']=$client;
        $data['invoice_date']=date('Y-m-d');
        $data['due_date']=date('Y-m-d', strtotime('+10 days'));
        $data['notes']=$request->notes;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['branch_id']=$request->branch_id;
        $data['invoice_tax']='1';
        $data['type']='Invoice';
        $data['bank_id']=$request->bank_id;
        $data['good_receive']='1';
        $data['invoice_status']=1;
        $data['status']=0;
        $data['quotation']=0;
        $data['cf_id']=$request->cf_id;
        $data['charge_id']=$charge->id;
        $data['user_id']= auth()->user()->id;
        $data['user_agent']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $invoice = Invoice::create($data);
        

        $nameArr =$request->cf_servece_id ;
        $qtyArr = 1  ;
        $priceArr = str_replace(",","",$request->amount);
        $rateArr = 0.18 ;
        $costArr = str_replace(",","",$request->amount)  ;
        $taxArr =  $costArr * $rateArr;        

    

     if(!empty($nameArr)){
         
                $t = array(
                'invoice_amount' =>   $costArr,
                'invoice_tax' =>  $taxArr,                     
                'due_amount' =>  $costArr +  $taxArr);

              Invoice::where('id',$invoice->id)->update($t);  
     
 
                    $items = array(
                        'item_name' => $nameArr,
                        'quantity' =>   $qtyArr,
                       'due_quantity' =>   $qtyArr,
                       'tax_rate' =>  $rateArr,
                       'price' =>  $priceArr,
                       'total_cost' =>  $costArr,
                       'total_tax' =>   $taxArr,
                        'items_id' => $nameArr,
                        'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$invoice->id);
                       
                        InvoiceItems::create($items);  ;
    
             $cost['invoice_amount'] = $costArr;
             $cost['invoice_tax'] = $rateArr;
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
            InvoiceItems::where('id',$invoice->id)->update($cost);
        }  
        
        }
        
        return redirect(route('cf.show',$request->cf_id))->with(['success'=>"Details Created Successfully",'type'=>'logistic']);
                  
                    }
                    
                    else{
        $count=Invoice::where('added_by', auth()->user()->added_by)->where('type', 'Customer')->where('quotation', '0')->count();
        $pro=$count+1;
        $data['reference_no']= "CFC0".$pro;
        $data['related']=$project->related;
        $data['client_id']=$client;
        $data['invoice_date']=date('Y-m-d');
        $data['due_date']=date('Y-m-d', strtotime('+10 days'));
        $data['notes']=$request->notes;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['branch_id']=$request->branch_id;
        $data['invoice_tax']='1';
        $data['type']='Customer';
        $data['bank_id']=$request->bank_id;
        $data['good_receive']='1';
        $data['invoice_status']=1;
        $data['status']=2;
        $data['quotation']=0;
        $data['cf_id']=$request->cf_id;
        $data['charge_id']=$charge->id;
        $data['user_id']= auth()->user()->id;
        $data['user_agent']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $invoice = Invoice::create($data);
        

        $nameArr =$request->cf_servece_id ;
        $qtyArr = 1  ;
        $priceArr = str_replace(",","",$request->amount);
        $rateArr = 0 ;
        $costArr = str_replace(",","",$request->amount)  ;
        $taxArr =  $costArr * $rateArr;        

    

     if(!empty($nameArr)){
         
                $t = array(
                'invoice_amount' =>   $costArr,
                'invoice_tax' =>  $taxArr,                     
                'due_amount' =>  $costArr +  $taxArr);

              Invoice::where('id',$invoice->id)->update($t);  
     
 
                    $items = array(
                        'item_name' => $nameArr,
                        'quantity' =>   $qtyArr,
                       'due_quantity' =>   $qtyArr,
                       'tax_rate' =>  $rateArr,
                       'price' =>  $priceArr,
                       'total_cost' =>  $costArr,
                       'total_tax' =>   $taxArr,
                        'items_id' => $nameArr,
                        'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$invoice->id);
                       
                        InvoiceItems::create($items);  ;
    
             $cost['invoice_amount'] = $costArr;
             $cost['invoice_tax'] = $rateArr;
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
            InvoiceItems::where('id',$invoice->id)->update($cost);
            
              $lists= array(
                            'quantity' =>   $qtyArr,
                             'price' =>   $priceArr,
                             'item_id' => $nameArr,
                               'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                               'client_id' =>   $data['client_id'],
                             'invoice_date' =>  $data['invoice_date'],
                            'type' =>   'Sales',
                            'cf_id' =>$request->cf_id,
                            'invoice_id' =>$invoice->id);
                           
         
                       InvoiceHistory::create($lists);
        }  
         
         
          $inv = Invoice::find($invoice->id);
            $staff=User::find($inv->user_agent);
            
            //dd($inv);
            
            $journal = new JournalEntry();
          $journal->account_id = $service->gl_account_id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'cf_customer_invoice';
          $journal->name = 'CF Charge';
          $journal->debit = $inv->due_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
         $journal->branch_id= $inv->branch_id;
             $journal->notes= "Sales for Duty No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
        
          $journal = new JournalEntry();
          $journal->account_id = $request->bank_id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'cf_customer_invoice';
          $journal->name = 'CF Charge';
          $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
          $journal->credit =$inv->due_amount  *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
            $journal->notes= "Credit for Duty No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
    
         
            return redirect(route('cf.show',$request->cf_id))->with(['success'=>"Details Created Successfully",'type'=>'logistic']);
         
                    }
                    
                    
    
        
       

                
    
}

     public function warehouse(){
         
        
           $warehouse = Storage::where('added_by', auth()->user()->added_by)
            ->where('status','activeWarehouse')
            ->get();
         
         return view('cf.warehouse',compact('warehouse'));
     }

    public function delete_details($type,$type_id){
       
         switch ($type) {

             case 'delete-storage':
    
               $storage = Storage::find($type_id);
     
                if(!empty($storage)){
                                    $activity =Activity::create(
                                        [ 
                                            'added_by'=>auth()->user()->id,
                                             'module_id'=>$storage->id,
                                             'module'=>'cf_Storage',
                                            'activity'=>"cf_storage " .  $storage->name. "-". $storage->type_id. "Deleted",
                                        ]
                                        );                      
                       }
        
                 Storage::find($type_id)->delete();
                
               return redirect(route('cf.show',$storage->cf_id))->with(['success'=>"Details Deleted Successfully",'type'=>'storage']);
        
        break;

         case 'delete-charge':
    
               $charge= Charge::find($type_id);
     
                if(!empty($charge)){
                                    $activity =Activity::create(
                                        [ 
                                            'added_by'=>auth()->user()->id,
                                             'module_id'=>$charge->id,
                                             'module'=>'Charge',
                                            'activity'=>"Charge" .  $charge->name. "-". $charge->type_id. "Deleted",
                                        ]
                                        );                      
                       }
        
                 Charge::find($type_id)->delete();
                
               return redirect(route('cf.show',$charge->cf_id))->with(['error'=>"Details Deleted Successfully",'type'=>'charge']);
        
        break;
        
         case 'delete-warehouse':
    
               $warehouse= Warehouse::find($type_id);
     
                if(!empty($warehouse)){
                                    $activity =Activity::create(
                                        [ 
                                            'added_by'=>auth()->user()->id,
                                            'module_id'=>$warehouse->id,
                                            'module'=>'warehouse',
                                            'activity'=>" Warehouse Deleted",
                                        ]
                                        );                      
                       }
        
                 Warehouse::find($type_id)->delete();
                
               return redirect(route('cf_warehouse'))->with(['error'=>"Details Deleted Successfully",'type'=>'charge']);
        
        break;
        
    }
    
    }
    
   public function updateAmount($id)
    {
        $storage = Storage::find($id);
        $storage->due_date;
        $value =  now()->diffInDays($storage->due_date);
        $amount['amount'] = $value*$storage->charge_start;

         $storage->update($amount);

         return redirect(route('cf.show',$storage->cf_id))->with(['success'=>"Updated Created Successfully",'type'=>'storage']);
    }
    
    
    
    public function cf_update_details(Request $request){
       
        switch($request->type){
            
            case 'storage';
             
            $storage = Storage::find($request->id);
            
            $data = $request->all();

            $storage->update($data);
            
             if(!empty($storage)){
                            $activity =Activity::create(
                                [ 
                                    'added_by'=>auth()->user()->id,
                                    'module_id'=>$storage->id,
                                    'project_id'=>$request->id,
                                    'module'=>'storage',
                                    'activity'=>"storage update",
                                ]
                                );                      
               }
            
            return redirect(route('cf.show',$storage->cf_id))->with(['success'=>"Updated Created Successfully",'type'=>'storage']);
           break;
           
           
           case 'edit-warehouse';
             
                $warehouse = Warehouse::find($request->id);
                
                $data = $request->all();
    
                $warehouse->update($data);
                
                 if(!empty($warehouse)){
                            $activity =Activity::create(
                                [ 
                                    'added_by'=>auth()->user()->id,
                                    'module_id'=>$warehouse->id,
                                    'project_id'=>$request->id,
                                    'module'=>'warehouse',
                                    'activity'=>"warehouse update",
                                ]
                                );                      
               }
                
              return redirect(route('cf_warehouse'))->with(['success'=>"Details Updated Successfully",'type'=>'warehouse']);
              
                
           break;

           case 'logistic';
           
           $request->type;

              if( $request->logistic_con=='yes'){
               $data = $request->all();
               $data['added_by'] = auth()->user()->added_by;
    
             $cargoType_id = $request->cargoType_id;
      
              return redirect(route('cf.show',$request->cf_id))->with(['success'=>"Successfully",'type'=>'logistic','a'=>$request->cargoType_id,'b'=>$request->cf_id]);
              }else{
                  return redirect(route('cf.show',$request->cf_id))->with(['success'=>"Updated Successfully",'type'=>'cargo']);
             }
          
          break;
          
          
          case 'charge';
          
             
            $charge = Charge::find($request->id);
           
            $data = $request->all();
             
            $charge->update($data);
             if(!empty($charge)){
                            $activity =Activity::create(
                                [ 
                                    'added_by'=>auth()->user()->id,
                                    'module_id'=>$charge->id,
                                    'project_id'=>$request->id,
                                    'module'=>'charge',
                                    'activity'=>"charge update",
                                ]
                                );                      
               }
              
            return redirect(route('cf.show',$charge->cf_id))->with(['success'=>"Updated Created Successfully",'type'=>'charge']);
           break;
        }
        
    }
    
    

   
}
