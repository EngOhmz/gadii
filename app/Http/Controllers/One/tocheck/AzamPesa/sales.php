use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\POS\Activity;
use App\Models\POS\InvoicePayments;
use App\Models\POS\Items;
use App\Models\JournalEntry;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
use App\Models\Client;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\POS\InvoiceAttachment;
use App\Models\Branch;
use App\Models\User;



        //
        $admin=User::where('email','info@ujuzinet.com')->first();
        $bank=AccountCodes::where('account_name','AZAM PAY')->where('added_by', $admin->added_by)->first();
         $loc=Location::where('added_by',$admin->id)->first();
        $br=Branch::where('added_by',$admin->id)->where('name','EMASUITE ERP')->first();
        
        $count=Invoice::where('added_by', $admin->added_by)->count();
        $pro=$count+1;
       
        $data['reference_no']= "S0".$pro;
        $data['client_id']=$request->user_id;
        $data['invoice_date']=date('Y-m-d');
        $data['due_date']=$user->due_date;
        $data['location']=$loc->id;
        $data['exchange_code']='TZS';
        $data['exchange_rate']='1';
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['branch_id']=$br->id;
        $data['invoice_tax']='1';
        $data['sales_type']='Cash Sales';
        $data['good_receive']='1';
        $data['invoice_status']=1;
        $data['status']=1;
        $data['user_id']= $admin->id;
        $data['user_agent']=$admin->id;
        $data['added_by']= $admin->added_by;

        $invoice = Invoice::create($data);
        

        $nameArr =$request->role_id ;
        $priceArr = str_replace(",","",$request->amount);;
        $costArr = str_replace(",","",$request->amount);;
        $amountArr = str_replace(",","",$request->amount);

     if(!empty($nameArr)){
            if(!empty($amountArr)){
                $t = array(
                    'invoice_amount' => $amountArr,
                     'invoice_tax' =>  '0',                     
                     'shipping_cost' => '0',
                      'discount' =>  '0', ,
                     'due_amount' =>  $amountArr);

                       Invoice::where('id',$invoice->id)->update($t);  


            }
        }
     

        
        $cost['invoice_amount'] = $costArr;
        $cost['invoice_tax'] = 0;
        
        if(!empty($nameArr)){
            
            $client=Client::find($inv->client_id);
            $role=Role::find($nameArr);
            
            $chk_items=Items::where('role_id',$nameArr)->where('disabled','0')->first();
            if(empty($chk_items)){
                
             $new_items = Items::create([
            'name' => $role->slug,
            'type' => '4',
            'cost_price' =>'0',
            'tax_rate' =>'0',
            'sales_price' => $role->price,
            'added_by' => $admin->added_by,
            'role_id' => $nameArr,
        ]);

                    if(!empty($new_items)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>$admin->added_by,
                              'user_id'=>$admin->id,
                            'module_id'=>$new_items->id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $new_items->name. "  Created",
                        ]
                        );                      
       }
       

               $role_name= $new_items->id;     
              }
              
              else{
                $role_name= $chk_items->id; 
                  
              }
                    $items = array(
                    'item_name' => $role_name,
                        'description' =>'Subscription Payment from ' .$client->name .' for '. $role->slug ,
                        'quantity' =>   '1',
                        'due_quantity' =>   '1',
                        'tax_rate' =>  '0',
                        'price' =>  $priceArr,
                        'total_cost' =>  $costArr,
                        'total_tax' =>   '0',
                         'items_id' =>  $role_name,
                         'order_no' => '0',
                         'added_by' => $admin->added_by,
                        'invoice_id' =>$invoice->id);
                       
                        InvoiceItems::create($items);  ;
                        
                        
                         $lists= array(
                            'quantity' =>  '1',
                             'price' =>    $priceArr,
                             'item_id' => $role_name,
                              'added_by' => $admin->added_by,
                              'client_id' =>   $data['client_id'],
                             'location' =>   $data['location'],
                             'invoice_date' =>  $data['invoice_date'],
                            'type' =>   'Sales',
                            'invoice_id' =>$invoice->id);
                           
         
                       InvoiceHistory::create($lists);
    
    
 
            
            $cost['due_amount'] =  $costArr + $cost['invoice_tax'];
            InvoiceItems::where('id',$invoice->id)->update($cost);
        }  
        
        
 
                   
                   
    
            $inv = Invoice::find($invoice->id);
            $supp=Client::find($inv->client_id);
            
            
            $cr= AccountCodes::where('account_name','Sales')->where('added_by', $admin->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=$admin->added_by;
         $journal->branch_id= $inv->branch_id;
             $journal->notes= "Sales for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
     
          $codes=AccountCodes::where('account_group','Receivables')->where('added_by', $admin->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
          $journal->debit =($inv->invoice_amount + $inv->invoice_tax)  *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=$admin->added_by;
           $journal->branch_id= $inv->branch_id;
            $journal->notes= "Receivables for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
    
      

    

    if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>$admin->added_by,
                            'user_id'=>$admin->id,
                            'module_id'=>$invoice->id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Created",
                        ]
                        );                      
       }


//invoice payment

              $sales =Invoice::find($inv->id);
            $method= Payment_methodes::where('name','Cash')->first();
             $count=InvoicePayments::count();
            $pro=$count+1;

                $receipt['trans_id'] = "TBSPH-".$pro;
                $receipt['invoice_id'] = $inv->id;
              $receipt['amount'] = $inv->due_amount;
                $receipt['date'] = $inv->invoice_date;
               $receipt['account_id'] = $bank->id;
                 $receipt['payment_method'] = $method->id;
                  $receipt['user_id'] = $sales->user_agent;
                $receipt['added_by'] = $admin->added_by;
                
                //update due amount from invoice table
                $b['due_amount'] =  0;
               $b['status'] = 3;
              
                $sales->update($b);
                 
                $payment = InvoicePayments::create($receipt);

                $supp=Client::find($sales->client_id);

               $cr= AccountCodes::where('id',$bank->id)->first();
          $journal = new JournalEntry();
        $journal->account_id = $bank->id;
        $date = explode('-',$request->invoice_date);
        $journal->date =   $request->invoice_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'pos_invoice_payment';
        $journal->name = 'Invoice Payment';
        $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
        $journal->payment_id= $payment->id;
        $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
          $journal->added_by=$admin->added_by;
           $journal->branch_id= $sales->branch_id;
           $journal->notes= "Deposit for Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();


        $codes= AccountCodes::where('account_group','Receivables')->where('added_by', $admin->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->invoice_date);
        $journal->date =   $request->invoice_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
          $journal->transaction_type = 'pos_invoice_payment';
        $journal->name = 'Invoice Payment';
        $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
          $journal->payment_id= $payment->id;
      $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
        $journal->added_by=$admin->added_by;
         $journal->branch_id= $sales->branch_id;
         $journal->notes= "Clear Receivable for Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();
        
$account= Accounts::where('account_id',$bank->id)->first();

if(!empty($account)){
$balance=$account->balance + $payment->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$bank->id)->first();

     $new['account_id']= $bank->id;
       $new['account_name']= $cr->account_name;
      $new['balance']= $payment->amount;
       $new[' exchange_code']= $sales->currency_code;
        $new['added_by']=$admin->added_by;
$balance=$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'POS Invoice Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $bank->id,
                                'code_id' => $codes->id,
                                'name' => 'POS Invoice Payment with reference ' .$payment->trans_id,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Income',
                                'amount' =>$payment->amount ,
                                'credit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'paid_by' => $sales->client_id,
                                'payment_methods_id' =>$payment->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from pos invoice  payment. The Reference is ' .$sales->reference_no .' by Client '. $supp->name  ,
                                'added_by' =>$admin->added_by,
                            ]);


        if(!empty($payment)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>$admin->added_by,
       'user_id'=>$admin->id,
                            'module_id'=>$payment->id,
                             'module'=>'Invoice Payment',
                            'activity'=>"Invoice with reference no  " .  $sales->reference_no. "  is Paid",
                        ]
                        );                      
       }        

