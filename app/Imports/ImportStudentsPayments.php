<?php

namespace App\Imports;

use App\Models\School\Student;
use App\Models\School\School;
use App\Models\School\SchoolDetails;
use App\Models\School\SchoolBreakdown;
use App\Models\School\SchoolLevel;
use App\Models\School\StudentPayment;
use App\Models\School\SchoolPayment;
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
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportStudentsPayments  implements ToCollection,WithHeadingRow

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
      $std=Student::where('student_name',$row['student_name'])->where('class',$row['class'])->where('added_by',auth()->user()->added_by)->first();
    $payment=StudentPayment::where('student_id', $std->id)->where('year', $row['payment_year'])->first();

      $sch_payment=SchoolPayment::create([

      'payment_id' => $payment->id ,
     'student_id' =>Student::where('student_name',$row['student_name'])->where('class',$row['class'])->where('added_by',auth()->user()->added_by)->get()->first()->id ,
      'fee_id' =>$payment->fee_id ,
     'type' =>$row['particular'] ,
      'type_id' => AccountCodes::where('account_name',$row['particular'])->where('added_by',auth()->user()->added_by)->first()->id ,
     'duration' => '12' ,
     'year' => $row['payment_year'] ,
     'paid' => $row['paid']  ,
     'bank_id' =>  AccountCodes::where('account_name',$row['bank_account'])->where('added_by',auth()->user()->added_by)->first()->id ,
    'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])->format('Y-m-d') ,
     'added_by'=>auth()->user()->added_by

        ]);


 $students =StudentPayment::find( $payment->id);

                
                //update due amount from invoice table
                $data['due_fee'] =  $students->due_fee -$row['paid'];
                if($data['due_fee'] != 0 ){
                $data['status'] = 1;
                }else{
                    $data['status'] = 2;
                }
                $students->update($data);


  $bank=   AccountCodes::where('account_name',$row['bank_account'])->where('added_by',auth()->user()->added_by)->first()->id; 
 //$cr= AccountCodes::where('id',$bank)->first();
          $journal = new JournalEntry();
        $journal->account_id =  $bank;
        $date = explode('-', $sch_payment->date);
        $journal->date =   $sch_payment->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'school_fees_payment';
        $journal->name =$sch_payment->type. ' Payment';
        $journal->debit =$row['paid'] ;
        $journal->payment_id=  $sch_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $sch_payment->student_id;
        $journal->branch_id= $std->branch_id;;
        $journal->notes= $sch_payment->type.' for  ' . $row['student_name']   ;
        $journal->save();


        $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
         $date = explode('-', $sch_payment->date);
        $journal->date =   $sch_payment->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'school_fees_payment';
        $journal->name = $sch_payment->type. ' Payment';
        $journal->credit =$row['paid'];
       $journal->payment_id=  $sch_payment->id;
       $journal->added_by=auth()->user()->added_by;
      $journal->student_id= $sch_payment->student_id;
        $journal->branch_id= $std->branch_id;;
        $journal->notes= $sch_payment->type.' for  ' . $row['student_name']   ;
        $journal->save();


$account= Accounts::where('account_id',$bank)->first();

if(!empty($account)){
$balance=$account->balance + $row['paid']  ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$bank)->first();

     $new['account_id']= $bank;
       $new['account_name']= $cr->account_name;
      $new['balance']= $row['paid'] ;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
    $balance=$row['paid'];
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' =>$sch_payment->type. 'Payment',
                                 'module_id' => $sch_payment->id,
                               'account_id' => $bank,
                                'code_id' => $codes->id,
                                'name' => $sch_payment->type. ' Payment',
                                'type' => 'Income',
                                'amount' =>$row['paid'] ,
                                'credit' => $row['paid'],
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($sch_payment->date)),
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from school fees payment.' ,
                                'added_by' =>auth()->user()->added_by,
                            ]);





           
    }

  }  
}
