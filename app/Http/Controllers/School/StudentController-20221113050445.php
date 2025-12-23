<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\School\School;
use App\Models\School\SchoolDetails;
use App\Models\School\SchoolBreakdown;
use App\Models\School\SchoolLevel;
use App\Models\School\Student;
use App\Models\School\StudentPayment;
use App\Models\School\SchoolPayment;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\Payment_methodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $students = Student::where('added_by',auth()->user()->added_by)->get();
       $level=SchoolLevel::groupBy('level')->get();;
        return view('raja.student.home',compact('students','level'));
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
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

          $data=$request->post();
         $class=SchoolLevel::where('id',$request->level_class)->first();
            $data['class']=$class->class;
          $data['added_by']=auth()->user()->added_by;
           $student = Student::create($data);

        return redirect()->route('student.index')->with('success', 'Saved Successfully');
        
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        //
           if($request->type == 'payment'){
          $payment=SchoolPayment::where('payment_id',$id)->get();
           $data=StudentPayment::find($id);
return view('raja.payment.details', compact('payment','data'));
}

else{

        $student = Student::find($id);
return view('raja.student.show', compact('student'));
}

        
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
        $data= Student::find($id);
       $level=SchoolLevel::groupBy('level')->get();;
         $class=SchoolLevel::where('level',$data->level)->get();
        return view('raja.student.home',compact('data','level','id','class'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
    
      
      $student = Student::find($id);
       $data=$request->post();
         $class=SchoolLevel::where('id',$request->level_class)->first();
        $data['class']=$class->class;
        $student->update($data);

        return redirect()->route('student.index')->with('success', 'Updated Successfully');
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

        $student=Student::where('id', $id)->firstorFail();
        $student->delete();

        return redirect()->route('student.index')->with('success', 'Deleted Successfully');
    }

 public function findLevel(Request $request)
    {

        $district= SchoolLevel::where('level',$request->id)->get();                                                                                    
               return response()->json($district);

}





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function general(Request $request)
    {
        //
        $schools= School::where('added_by',auth()->user()->added_by)->get();
         if($request->isMethod('post')){
       $fee = $request->fee;
        $sch=School::find($request->fee);
        $price=$sch->price;
        $feeType=$sch->feeType;
        $details = SchoolDetails::where('fee_id',$request->fee)->get();
}

else{
      $fee = '';
        $price='';
        $feeType='';
        $details = '';
       $payment='';
}
        return view('raja.invoice.home',compact('schools','fee','price','feeType','details'));
    }

public function findStudent(Request $request)
    {
        
    }

 public function generate(Request $request)
    {
        //

 $nameArr =$request->student_id ;
 $feeArr = $request->student_fee  ;
 $yearArr = $request->year;
 $notesArr = $request->notes;

    if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){
                $price=School::find($feeArr); 

                $items = array(
                    'student_id' => $nameArr[$i],
                    'fee_id' =>  $feeArr ,
                    'year' =>   $yearArr ,
                    'notes' =>   $notesArr ,
                     'fee' =>  $price->price,
                       'due_fee' =>  $price->price,
                    'status' =>  '0',
                       'added_by'=>auth()->user()->added_by);

                 $student=StudentPayment::create($items);  ;

        $details=SchoolBreakdown::where('fee_id',$feeArr)->get(); 

       foreach($details as $dtls){

  $codes= AccountCodes::where('account_group','Receivables')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
         $date = explode('-', $student->created_at);
        $journal->date =   $student->created_at ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'student_invoice';
        $journal->name = 'Student Invoice';
         $journal->income_id= $student->id;    
        $journal->debit =$dtls->amount;
         $journal->student_id= $student->student_id;
        $journal->added_by= auth()->user()->added_by;
        $journal->notes= $student->notes ;
        $journal->save();

$cr= AccountCodes::where('id',$dtls->type)->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
        $journal->account_id = $dtls->type;
        $date = explode('-', $student->created_at);
        $journal->date =   $student->created_at ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'student_invoice';
        $journal->name = 'Student Invoice';       
       $journal->income_id= $student->id;  ;
      $journal->credit = $dtls->amount;
        $journal->student_id= $student->student_id;
        $journal->added_by= auth()->user()->added_by;
        $journal->notes= $student->notes ;
        $journal->save();
}


            }
        }
   return redirect()->route('student.general')->with('success', 'Generated Successfully');
    }    



else{
  return redirect(route('student.general'))->with(['error'=>'You have not chosen an entry']);
}
     
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function payment(Request $request)
    {
        //
               if($request->isMethod('post')){
        $payment =Student::where('student_name', $request->name)->first();
       $students=StudentPayment::where('student_id', $payment->id)->where('year', $request->year)->get();
   $name=$request->name;
  $year=$request->year;
}

else{
      $students = '';
       $name='';
  $year='';
}

        return view('raja.payment.home',compact('students','name','year'));
    }

 public function autocomplete(Request $request)
    {

 return Student::select('student_name')
        ->where('student_name', 'like', "%{$request->term}%")
         ->where('added_by',auth()->user()->added_by)
        ->pluck('student_name');
            
    }

    public function action($id, Request $request)
    {
        //
        $students =StudentPayment::find($id);
       $fee=School::find($students->fee_id);
        $details=SchoolBreakdown::where('fee_id',$students->fee_id)->get();
          $payment_method = Payment_methodes::all();
       $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;

        return view('raja.payment.action', compact('students','fee','id','payment_method','bank_accounts','details'));
    }

public function findAmount(Request $request)
    {
 

 $students =StudentPayment::find($request->payment);

if($request->id == '0'){
$price="Choose amount greater than  ".  number_format(0,2) ;
}

else{
if($request->id > $request->due){
$price="You have exceeded the amount. Choose amount less or equal to  than ".  number_format($request->due,2) ;

}
else{
$price='' ;
 }

}
                return response()->json($price);                    
 
    }



 public function store_payment(Request $request)
    {
        //
 $students =StudentPayment::find($request->payment_id);

                
                //update due amount from invoice table
                $data['due_fee'] =  $students->due_fee - $request->paid;
                if($data['due_fee'] != 0 ){
                $data['status'] = 1;
                }else{
                    $data['status'] = 2;
                }
                $students->update($data);

      $sch_payment=SchoolPayment::create([
     'payment_id' => $request->payment_id ,
     'student_id' =>$request->student_id ,
      'fee_id' => $request->type ,
     'type' => 'School Fees' ,
     'duration' => '12' ,
     'year' => $request->year ,
     'paid' => $request->paid ,
     'reference' => $request->reference  ,
     'bank_id' => $request->bank_id ,
    'date' => $request->date ,
     'payment_method' => $request->payment_method  ,
     'added_by'=>auth()->user()->added_by,
]);



 $cr= AccountCodes::where('id','$request->bank_id')->first();
          $journal = new JournalEntry();
        $journal->account_id = $request->bank_id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'school_fees_payment';
        $journal->name = 'School Fees Payment';
        $journal->debit = $request->paid;
        $journal->payment_id=  $sch_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;
        $journal->notes= 'The Payment Reference is ' . $request->reference   ;
        $journal->save();


        $codes= AccountCodes::where('account_group','Receivables')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'school_fees_payment';
        $journal->name = 'School Fees Payment';
        $journal->credit =$request->paid;
       $journal->payment_id=  $sch_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= 'The Payment Reference is ' . $request->reference   ;
        $journal->save();


$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance + $request->paid ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= $request->paid;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
    $balance=$request->paid;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'School Fees Payment',
                                 'module_id' => $sch_payment->id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'School Fees Payment with reference ' .$request->reference,
                                'type' => 'Income',
                                'amount' =>$request->paid ,
                                'credit' => $request->paid,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$request->payment_method ,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from school fees payment.The Reference is ' .$request->reference ,
                                'added_by' =>auth()->user()->added_by,
                            ]);


if($request->transport == 'Yes'){
$end=$request->transport_start_month + ($request->transport_duration-1);
$start_month_name = date("F", mktime(0, 0, 0, $request->transport_start_month, 10));
$end_month_name = date("F", mktime(0, 0, 0, $end, 10));

      $trans_payment=SchoolPayment::create([
     'payment_id' => $request->payment_id ,
     'student_id' =>$request->student_id ,
     'type' => 'Transport Fees' ,
     'duration' =>$request->transport_duration  ,
     'year' => $request->year ,
    'start_month' =>$start_month_name ,
   'end_month' => $end_month_name ,
     'paid' => $request->transport_paid ,
     'reference' => $request->reference  ,
     'bank_id' => $request->bank_id ,
    'date' => $request->date ,
     'payment_method' => $request->payment_method  ,
     'added_by'=>auth()->user()->added_by,
]);



 $cr= AccountCodes::where('id','$request->bank_id')->first();
          $journal = new JournalEntry();
        $journal->account_id = $request->bank_id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'transport_fees_payment';
        $journal->name = 'Transport Fees Payment';
        $journal->debit =  $request->transport_paid;
        $journal->payment_id=   $trans_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;
        $journal->notes='The Payment Reference is ' . $request->reference   ;
        $journal->save();


        $codes= AccountCodes::where('account_group','Receivables')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
         $journal->transaction_type = 'transport_fees_payment';
        $journal->name = 'Transport Fees Payment';
        $journal->credit = $request->transport_paid;
       $journal->payment_id=   $trans_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes= 'The Payment Reference is ' . $request->reference   ;
        $journal->save();


$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$trans_balance=$account->balance + $request->transport_paid ;
$item_to['balance']= $trans_balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= $request->transport_paid;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
   $trans_balance=$request->transport_paid;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Transport Fees Payment',
                                 'module_id' => $trans_payment->id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Transport Fees Payment with reference ' .$request->reference,
                                'type' => 'Income',
                                'amount' =>$request->transport_paid ,
                                'credit' => $request->transport_paid,
                                 'total_balance' =>$trans_balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$request->payment_method ,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from transport fees payment.The Reference is ' .$request->reference ,
                                'added_by' =>auth()->user()->added_by,
                            ]);
}


if($request->hostel == 'Yes'){
$end=$request->hostel_start_month + ($request->hostel_duration-1);
$start_month_name = date("F", mktime(0, 0, 0, $request->hostel_start_month, 10));
$end_month_name = date("F", mktime(0, 0, 0, $end, 10));

      $host_payment=SchoolPayment::create([
     'payment_id' => $request->payment_id ,
     'student_id' =>$request->student_id ,
     'type' => 'Hostel Fees' ,
     'duration' =>$request->hostel_duration  ,
     'year' => $request->year ,
    'start_month' =>$start_month_name ,
   'end_month' => $end_month_name ,
     'paid' => $request->hostel_paid ,
     'reference' => $request->reference  ,
     'bank_id' => $request->bank_id ,
    'date' => $request->date ,
     'payment_method' => $request->payment_method  ,
     'added_by'=>auth()->user()->added_by,
]);



 $cr= AccountCodes::where('id','$request->bank_id')->first();
          $journal = new JournalEntry();
        $journal->account_id = $request->bank_id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'hostel_fees_payment';
        $journal->name = 'Hostel Fees Payment';
        $journal->debit =  $request->hostel_paid;
        $journal->payment_id=    $host_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;
        $journal->notes= 'The Payment Reference is ' . $request->reference   ;
        $journal->save();


        $codes= AccountCodes::where('account_group','Receivables')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
         $journal->transaction_type = 'hostel_fees_payment';
        $journal->name = 'Hostel Fees Payment';
        $journal->credit = $request->hostel_paid;
       $journal->payment_id=    $host_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;;
        $journal->added_by=auth()->user()->added_by;
           $journal->notes='The Payment Reference is ' . $request->reference   ;
        $journal->save();


$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$host_balance=$account->balance + $request->hostel_paid ;
$item_to['balance']= $host_balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= $request->hostel_paid;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
   $host_balance=$request->hostel_paid;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Hostel Fees Payment',
                                 'module_id' => $host_payment->id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Hostel Fees Payment with reference ' .$request->reference,
                                'type' => 'Income',
                                'amount' =>$request->hostel_paid ,
                                'credit' => $request->hostel_paid,
                                 'total_balance' =>$host_balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$request->payment_method ,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from hostel fees payment.The Reference is ' .$request->reference ,
                                'added_by' =>auth()->user()->added_by,
                            ]);
}


   return redirect()->route('student.list')->with('success', 'Saved Successfully');

        
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice($id, Request $request)
    {
        //
        $student = Student::find($id);
        //$level = Student::where('id', $id)->value('level');
        $class = Student::where('id', $id)->value('class');
        $details = SchoolDetails::where('class', $class)->first();
        $schools = School::where('id', $details->fee_id)->first();
     
        

        return view('raja.invoice.show', compact('student', 'schools','details'));
    }

 public function list(Request $request)
    {
        //
          $schools=SchoolLevel::all();
            if($request->isMethod('post')){
       $class = $request->class;
       $year = $request->year;
}

else{
      $class = '';
        $year='';
}
        return view('raja.payment.list',compact('class','year','schools'));
    }

 


}
