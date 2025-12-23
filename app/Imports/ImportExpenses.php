<?php

namespace App\Imports;
use App\Models\Expenses;
use App\Models\JournalEntry ;
use App\Models\AccountCodes ;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use DateTime;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\User;
use App\Models\Branch;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportExpenses  implements ToCollection,WithHeadingRow

{ 
//, WithValidation
   // use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
     
        //  $myDateTime = DateTime::createFromFormat('Y-m-d', strtotime($row[2]));
        //  $year = $myDateTime->format('Y');
        //  $month = $myDateTime->format('M');


         foreach ($rows as $row) 
      {
      
      $cd= Branch::where('added_by',auth()->user()->added_by)->where('name',$row['branch'])->first(); 

if(!empty($cd)){
    $branch=$cd->id;
}

else{
    $branch='';
}

         $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);

                 $expenses=Expenses::create([
                  'name' =>  $row['reference'],
                    'type' =>  'Expenses',
                    'amount' =>   $row['amount'] ,
                     'date' =>  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])->format('Y-m-d') ,
                     'bank_id' =>   AccountCodes::where('account_name',$row['bank_account'])->where('added_by',auth()->user()->added_by)->first()->id ,
                     'account_id' =>   AccountCodes::where('account_name',$row['expense_account'])->where('added_by',auth()->user()->added_by)->first()->id ,
                     'user_id' =>   User::where('name',$row['created_by'])->where('added_by',auth()->user()->added_by)->first()->id ,
                     'status'  => '1' ,
                     'view'  => '0' ,
                      'multiple'  => '0' ,
                      'trans_id' => 'EXP_'.$random,
                      'notes' =>   $row['notes'] ,
                    'branch_id' => $branch,
                    'added_by' => auth()->user()->added_by,

        ]);




  $journal = new JournalEntry();
        $journal->account_id =    $expenses->account_id;
      $date = explode('-',  $expenses->date);
        $journal->date = $expenses->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'expense_payment';
        $journal->name = 'Expense Payment';
         $journal->payment_id=    $expenses->id;
         $journal->notes= 'Expense Payment with transaction id ' .$expenses->name;
        $journal->added_by=auth()->user()->added_by;
       $journal->supplier_id= $expenses->supplier_id;
        $journal->branch_id= $expenses->branch_id;
        $journal->debit =   $expenses->amount;
        $journal->save();

         $journal = new JournalEntry();
        $journal->account_id = $expenses->bank_id;
        $date = explode('-',  $expenses->date);
        $journal->date = $expenses->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'expense_payment';
        $journal->name = 'Expense Payment';
        $journal->credit =    $expenses->amount;
        $journal->payment_id=    $expenses->id;
        $journal->supplier_id= $expenses->supplier_id;
         $journal->branch_id= $expenses->branch_id;
        $journal->added_by=auth()->user()->added_by;
        $journal->notes= 'Expense Payment with transaction id ' .$expenses->name;
        $journal->save();


$bank_accounts=AccountCodes::where('id',$expenses->bank_id)->first() ;
if($bank_accounts->account_group == 'Cash and Cash Equivalent'){
    $account= Accounts::where('account_id', $expenses->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $expenses->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id', $expenses->bank_id)->first();

     $new['account_id']=  $expenses->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0- $expenses->amount;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->added_by;
$balance= 0-$expenses->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Expenses',
                                 'module_id' => $expenses->id,
                               'account_id' =>  $expenses->bank_id,
                                'code_id' =>  $expenses->account_id,
                                'name' => 'Expense Payment with reference' .$expenses->trans_id,
                                 'transaction_prefix' =>  $expenses->name,
                                'type' => 'Expense',
                                'amount' => $expenses->amount ,
                                'debit' =>  $expenses->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime( $expenses->date)),
                                   'status' => 'paid' ,
                                'notes' => 'Expense Payment with transaction id ' . $expenses->name ,
                                'added_by' =>auth()->user()->added_by,
                            ]);


}


           
    }

  }  
}
