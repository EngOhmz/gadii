<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\School\School;
use App\Models\School\SchoolDetails;
use App\Models\School\SchoolBreakdown;
use App\Models\School\SchoolLevel;
use App\Models\School\Student;
use App\Models\School\StudentHistory;

use App\Models\School\StudentLevel;
use App\Models\School\StudentsClass;
use App\Models\School\SchoolStreams;
use App\Models\School\SchoolBranch;

use App\Models\School\GraduateHistory;
use App\Models\School\StudentPayment;
use App\Models\School\SchoolPayment;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\Branch;
use App\Models\Payment_methodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Exports\ExportStudentReport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use App\Imports\ImportStudentsPayments ;
use Response;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::where('disabled', 0)->where('added_by', auth()->user()->added_by)->latest('id')->get();
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        $classes = StudentsClass::where('added_by', auth()->user()->added_by)->get();
        $branches = SchoolBranch::where('added_by', auth()->user()->added_by)->get();
        $streams = SchoolStreams::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.student.home', compact('students', 'levels', 'classes', 'branches', 'streams'));
    }

    public function create()
    {
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        $classes = StudentsClass::where('added_by', auth()->user()->added_by)->get();
        $branches = SchoolBranch::where('added_by', auth()->user()->added_by)->get();
        $streams = SchoolStreams::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.student.home', compact('levels', 'classes', 'branches', 'streams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:15',
            'school_level_id' => 'required|required|string|max:255',
            'class_id' => 'required|required|string|max:255',
            'stream_id' => 'required|required|string|max:255',
            'type' => 'required|in:Boarding,Day',
            'yearStudy' => 'required|date',
            'branch_id' => 'nullable|required|string|max:255',
        ]);

        $data = $request->only([
            'student_name', 'gender', 'parent_name', 'parent_phone',
            'school_level_id', 'class_id', 'stream_id', 'type', 'yearStudy', 'branch_id'
        ]);
        $data['added_by'] = auth()->user()->added_by;

        $student = Student::create($data);

        $item = [
            'student_id' => $student->id,
            'school_level_id' => $student->school_level_id,
            'class_id' => $student->class_id,
            'stream_id' => $student->stream_id,
            'year' => date('Y'),
            'added_by' => auth()->user()->added_by,
        ];

        StudentHistory::create($item);

        return redirect()->route('student.index')->with('success', 'Saved Successfully');
    }

    public function edit($id)
    {
        $data = Student::findOrFail($id);
        $levels = StudentLevel::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        $classes = StudentsClass::where('added_by', auth()->user()->added_by)->get();
        $branches = SchoolBranch::where('added_by', auth()->user()->added_by)->get();
        $streams = SchoolStreams::where('added_by', auth()->user()->added_by)->where('status', 'Active')->get();
        return view('raja.student.home', compact('data', 'levels', 'classes', 'id', 'branches', 'streams'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:15',
            'school_level_id' => 'required|required|string|max:255',
            'class_id' => 'required|required|string|max:255',
            'stream_id' => 'required|required|string|max:255',
            'type' => 'required|in:Boarding,Day',
            'yearStudy' => 'required|date',
            'branch_id' => 'nullable|required|string|max:255',
        ]);

        $student = Student::findOrFail($id);
        $data = $request->only([
            'student_name', 'gender', 'parent_name', 'parent_phone',
            'school_level_id', 'class_id', 'stream_id', 'type', 'yearStudy', 'branch_id'
        ]);
        $student->update($data);

        return redirect()->route('student.index')->with('success', 'Updated Successfully');
    }    

    public function show($id, Request $request)
    {
        //
           if($request->type == 'payment'){
          $payment=SchoolPayment::where('payment_id',$id)->where('type','!=','Discount Fees')->get();
           $data=StudentPayment::find($id);
return view('raja.payment.details', compact('payment','data'));
}

 else if($request->type == 'discount'){
           $students =StudentPayment::find($id);
       $fee=School::find($students->fee_id);
          $acc=AccountCodes::where('account_name','School Fees')->where('added_by',auth()->user()->added_by)->first();
       $school_fees=SchoolBreakdown::where('fee_id',$students->fee_id)->where('type',$acc->id)->first();
        $discount=SchoolPayment::where('type','Discount Fees')->where('fee_id',$students->fee_id)->where('student_id',$students->student_id)->where('year',$students->year)->sum('paid');
         $amount=SchoolPayment::where('type_id',$acc->id)->where('fee_id',$students->fee_id)->where('student_id',$students->student_id)->where('year',$students->year)->sum('paid');
        $details=SchoolBreakdown::where('fee_id',$students->fee_id)->get();
return view('raja.payment.add_discount', compact('students','fee','details','id','school_fees','amount','discount'));
}

 else if($request->type == 'disable'){
           $data =Student::find($id);
      
return view('raja.student.disable', compact('data','id'));
}


         
           
           
else{

        $student = Student::find($id);
return view('raja.student.show', compact('student'));
}

        
    }



    public function destroy($id)
    {
        //

        $student=Student::where('id', $id)->firstorFail();
        $student->delete();

        return redirect()->route('student.index')->with('success', 'Deleted Successfully');
    }

 public function disable(Request $request)
    {

          $student=Student::find($request->id);
             $data['disabled']='1';
            $data['disabled_reason']=$request->reason;
             $data['disabled_date']=date('Y-m-d');
               $student->update($data);

        return redirect()->route('student.index')->with('success', 'Disabled Successfully');
}


public function promote($id){
     $student=Student::find($id);
     
     $class=SchoolLevel::where('class',$student->class)->first(); 
     $next=$class->id + 1;
     
         $next_class=SchoolLevel::find($next); 
         $data['class']=$next_class->class;
         $data['level']=$next_class->level;
         $data['graduate']='0';
     
         $student->update($data);
        
           $item['student_id']=$student->id;
           $item['level']=$student->level;
           $item['class']=$student->class;
           $item['year']= date('Y');
           $item['added_by']=auth()->user()->added_by;
           
           StudentHistory::create($item);
           
            return redirect()->route('student.index')->with('success', 'Promoted Successfully');
           
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
          $student= Student::where('class',$request->id)->where('added_by',auth()->user()->added_by)->get();                                                                                    
               return response()->json($student);
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
                $st=Student::find($nameArr[$i]);

                $items = array(
                    'student_id' => $nameArr[$i],
                     'class' =>  $st->class,
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

  $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
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
         $journal->branch_id= $price->branch_id;
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
        $journal->branch_id= $price->branch_id;
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
        $payment =Student::where('student_name', $request->name)->where('added_by',auth()->user()->added_by)->first();
       $students=StudentPayment::where('student_id', $payment->id)->where('year', $request->year)->where('added_by',auth()->user()->added_by)->get();
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
       $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get() ;

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


public function findDiscount(Request $request)
    {
 

if($request->id > $request->total){
$price="You have exceeded the amount. Choose amount less or equal to  than ".  number_format($request->total,2) ;

}
else{
$price='' ;
 }


                return response()->json($price);                    
 
    }

 public function store_discount(Request $request){

$nameArr =$request->fee_id ;
 $feeArr = $request->discount  ;



  if(!empty($feeArr)){
        for($i = 0; $i < count($feeArr); $i++){
            if(!empty($feeArr[$i])){

              $students =StudentPayment::find($request->payment_id);

                
                //update due amount from invoice table
                $data['due_fee'] =  $students->due_fee - $feeArr[$i];
               $data['discount'] =  $students->discount + $feeArr[$i];

                if($data['due_fee'] != 0 ){
                $data['status'] = 1;
                }else{
                    $data['status'] = 2;
                }
                $students->update($data);


$school= AccountCodes::where('account_name','Discount Fees')->where('added_by',auth()->user()->added_by)->first();
 $stud = Student::find( $request->student_id);

                $items = array(
        'payment_id' => $request->payment_id ,
     'student_id' =>$request->student_id ,
      'class' =>$stud->class ,
      'fee_id' => $nameArr[$i] ,
     'type' => 'Discount Fees' ,
      'type_id' => $school->id ,
     'duration' => '12' ,
     'year' => $request->year ,
     'paid' => $feeArr[$i] ,
    'date' => date('Y-m-d') ,
     'added_by'=>auth()->user()->added_by);

     $sch_payment=SchoolPayment::create($items);  ;

       

 $cr= AccountCodes::where('account_name','School Fees')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
        $journal->account_id = $cr->id;
        $date = explode('-',$sch_payment->date);
        $journal->date =   $sch_payment->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'school_fees_payment';
        $journal->name = $school->account_name. ' Payment';
        $journal->debit = $feeArr[$i] ;
        $journal->payment_id=  $sch_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;
        $journal->branch_id= $stud->branch_id;
        $journal->notes= 'School Fees Discount For ' . $stud->student_name   ;
        $journal->save();


       
        $journal = new JournalEntry();
        $journal->account_id =$school->id;
          $date = explode('-',$sch_payment->date);
        $journal->date =  $sch_payment->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'school_fees_payment';
        $journal->name = $school->account_name. ' Payment';
        $journal->credit =$feeArr[$i] ;
       $journal->payment_id=  $sch_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;;
        $journal->added_by=auth()->user()->added_by;
         $journal->branch_id= $stud->branch_id;
           $journal->notes= 'School Fees Discount For ' . $stud->student_name   ;
        $journal->save();


}
}
}



 return redirect(route('student.action',$request->payment_id))->with('success', 'Saved Successfully');




}

 public function store_payment(Request $request)
    {
        //

 $nameArr =$request->type ;
$typeArr =$request->type_id ;
 $feeArr = $request->paid  ;



  if(!empty($feeArr)){
      
        
        $words = preg_split("/\s+/", auth()->user()->name);
        $acronym = "";
        
        foreach ($words as $w) {
          $acronym .= mb_substr($w, 0, 1);
        }
        $a=strtoupper($acronym);
        
         $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
        $count=SchoolPayment::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        
        $multiple=$a.$random.$pro;
      
        for($i = 0; $i < count($feeArr); $i++){
            if(!empty($feeArr[$i])){

              $students =StudentPayment::find($request->payment_id);

                
                //update due amount from invoice table
                $data['due_fee'] =  $students->due_fee - $feeArr[$i];
                if($data['due_fee'] != 0 ){
                $data['status'] = 1;
                }else{
                    $data['status'] = 2;
                }
                $students->update($data);


$school= AccountCodes::where('id',$typeArr[$i])->where('added_by',auth()->user()->added_by)->first();
 $stud = Student::find($request->student_id);
 
                $items = array(
        'payment_id' => $request->payment_id ,
     'student_id' =>$request->student_id ,
      'class' =>$stud->class ,
      'fee_id' => $nameArr[$i] ,
     'type' => $school->account_name ,
      'type_id' => $typeArr[$i] ,
     'duration' => '12' ,
     'year' => $request->year ,
     'paid' => $feeArr[$i] ,
     'reference' => $request->reference  ,
     'multiple' => $multiple  ,
     'bank_id' => $request->bank_id ,
    'date' => $request->date ,
     'payment_method' => $request->payment_method  ,
     'added_by'=>auth()->user()->added_by);

     $sch_payment=SchoolPayment::create($items);  ;

      
       
 $cr= AccountCodes::where('id','$request->bank_id')->first();
          $journal = new JournalEntry();
        $journal->account_id = $request->bank_id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'school_fees_payment';
        $journal->name = $school->account_name. ' Payment';
        $journal->debit = $feeArr[$i] ;
        $journal->payment_id=  $sch_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;
        $journal->branch_id= $stud->branch_id;
        $journal->notes= $school->account_name. ' Payment For '  .$stud->student_name. '. The Payment Reference is ' . $request->reference   ;
        $journal->save();


        $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'school_fees_payment';
        $journal->name = $school->account_name. ' Payment';
        $journal->credit =$feeArr[$i] ;
       $journal->payment_id=  $sch_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;;
        $journal->added_by=auth()->user()->added_by;
         $journal->branch_id= $stud->branch_id;
        $journal->notes= $school->account_name. ' Payment For '  .$stud->student_name. '. The Payment Reference is ' . $request->reference   ;
        $journal->save();


$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance + $feeArr[$i]  ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= $feeArr[$i] ;
       $new[' exchange_code']= 'TZS';
        $new['added_by']=auth()->user()->added_by;
    $balance=$request->paid;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' =>$school->account_name. 'Payment',
                                 'module_id' => $sch_payment->id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => $school->account_name. ' Payment with reference ' .$request->reference,
                                'type' => 'Income',
                                'amount' =>$feeArr[$i] ,
                                'credit' => $feeArr[$i],
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$request->payment_method ,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from school fees payment.The Reference is ' .$request->reference ,
                                'added_by' =>auth()->user()->added_by,
                            ]);

   }
        }
  
    }    




if($request->transport == 'Yes'){
$end=$request->transport_start_month + ($request->transport_duration-1);
$start_month_name = date("F", mktime(0, 0, 0, $request->transport_start_month, 10));
$end_month_name = date("F", mktime(0, 0, 0, $end, 10));
$trans_codes= AccountCodes::where('account_name','Transport Fees')->where('added_by',auth()->user()->added_by)->first();
 $stud = Student::find($request->student_id); 
 
      $trans_payment=SchoolPayment::create([
     'payment_id' => $request->payment_id ,
     'student_id' =>$request->student_id ,
      'class' =>$stud->class ,
     'type' => 'Transport Fees' ,
      'type_id' =>$trans_codes->id ,
     'duration' =>$request->transport_duration  ,
     'year' => $request->year ,
    'start_month' =>$start_month_name ,
   'end_month' => $end_month_name ,
     'paid' => $request->transport_paid ,
      'multiple' => $multiple  ,
     'reference' => $request->reference  ,
     'bank_id' => $request->bank_id ,
    'date' => $request->date ,
     'payment_method' => $request->payment_method  ,
     'added_by'=>auth()->user()->added_by,
]);


 $trans_cr= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
        $journal->account_id = $trans_cr->id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'transport_fees_payment';
        $journal->name = 'Transport Fees Payment';
        $journal->debit =  $request->transport_paid;
        $journal->income_id=   $trans_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;
         $journal->branch_id= $stud->branch_id;
        $journal->notes= 'Transport Fees Payment  For '  .$stud->student_name. '. The Payment Reference is ' . $request->reference   ;
        $journal->save();


        
        $journal = new JournalEntry();
        $journal->account_id =  $trans_codes->id;
          $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
         $journal->transaction_type = 'transport_fees_payment';
        $journal->name = 'Transport Fees Payment';
        $journal->credit = $request->transport_paid;
        $journal->income_id=   $trans_payment->id;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;;
        $journal->added_by=auth()->user()->added_by;
         $journal->branch_id= $stud->branch_id;
        $journal->notes= 'Transport Fees Payment  For '  .$stud->student_name. '. The Payment Reference is ' . $request->reference   ;
        $journal->save();

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
         $journal->branch_id= $stud->branch_id;
        $journal->notes= 'Transport Fees Payment  For '  .$stud->student_name. '. The Payment Reference is ' . $request->reference   ;
        $journal->save();


        $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
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
           $journal->branch_id= $stud->branch_id;
        $journal->notes= 'Transport Fees Payment  For '  .$stud->student_name. '. The Payment Reference is ' . $request->reference   ;
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
$host_codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
$stud = Student::find($request->student_id); 

      $host_payment=SchoolPayment::create([
     'payment_id' => $request->payment_id ,
     'student_id' =>$request->student_id ,
      'class' =>$stud->class ,
     'type' => 'Hostel Fees' ,
     'type_id' =>$host_codes->id ,
     'duration' =>$request->hostel_duration  ,
     'year' => $request->year ,
    'start_month' =>$start_month_name ,
   'end_month' => $end_month_name ,
     'paid' => $request->hostel_paid ,
      'multiple' => $multiple  ,
     'reference' => $request->reference  ,
     'bank_id' => $request->bank_id ,
    'date' => $request->date ,
     'payment_method' => $request->payment_method  ,
     'added_by'=>auth()->user()->added_by,
]);

 
          $journal = new JournalEntry();
        $journal->account_id = $host_cr->id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'hostel_fees_payment';
        $journal->name = 'Hostel Fees Payment';
        $journal->debit =  $request->hostel_paid;
        $journal->income_id=   $host_payment->id;;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;
         $journal->branch_id= $stud->branch_id;
        $journal->notes= 'Hostel Fees Payment  For '  .$stud->student_name. '. The Payment Reference is ' . $request->reference   ;
        $journal->save();


       
        $journal = new JournalEntry();
        $journal->account_id =  $host_codes->id;
          $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
           $journal->transaction_type = 'hostel_fees_payment';
        $journal->name = 'Hostel Fees Payment';
        $journal->credit = $request->hostel_paid;
       $journal->income_id=   $host_payment->id;;
       $journal->added_by=auth()->user()->added_by;
        $journal->student_id= $request->student_id;;
        $journal->added_by=auth()->user()->added_by;
        $journal->branch_id= $stud->branch_id;
        $journal->notes= 'Hostel Fees Payment  For '  .$stud->student_name. '. The Payment Reference is ' . $request->reference   ;
        $journal->save();

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
       $journal->branch_id= $stud->branch_id;
        $journal->notes= 'Hostel Fees Payment  For '  .$stud->student_name. '. The Payment Reference is ' . $request->reference   ;
        $journal->save();


        $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
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
         $journal->branch_id= $stud->branch_id;
        $journal->notes= 'Hostel Fees Payment  For '  .$stud->student_name. '. The Payment Reference is ' . $request->reference   ;
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

 public function payments()
    {
        //
         $payments=SchoolPayment::where('added_by',auth()->user()->added_by)->where('type','!=','Discount Fees')->latest()->groupBy('multiple')->get();
        return view('raja.payment.payments',compact('payments'));
    }
    
    
     public function payments_report(Request $request)
    {
        //
         $class = $request->class;
        $year = $request->year;


         $schools = [];
        foreach (SchoolLevel::all() as $key) {
            $schools[$key->class] = $key->class;
        }

        

        if($request->isMethod('post')){
           
        $data=SchoolPayment::leftJoin('students', 'school_payments.student_id','students.id')
                          ->where('school_payments.type','!=','Discount Fees')
                          ->where('school_payments.added_by',auth()->user()->added_by)
                          ->where('school_payments.class',$class)
                          ->where('school_payments.year',$year)
                           ->select('school_payments.*')
                           ->latest()
                           ->groupBy('multiple')
                              ->get()  ;
                              
        }else{
           
       $data=[];

        }
         
        return view('raja.report.payments_report',compact('class','year','schools','data'));
    }
    
     public function invoice_receipt(Request $request){

        //if landscape heigth * width but if portrait widht *height      // dd($dataResult);
        $customPaper = array(0,0,198.425,494.80);

        $invoices = SchoolPayment::find($request->id);
        $invoice_items=SchoolPayment::where('multiple',$invoices->multiple)->where('type','!=','Discount Fees')->get();
     

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('raja.payment.invoice_receipt_pdf')->setPaper($customPaper, 'portrait');
         return $pdf->download('PAYMENT RECEIPT NO # ' .  $invoices->reference . ".pdf");
        }
       return view('invoice_receipt');

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



public function student_report(Request $request)
    {
       
        $class = $request->class;
        $year = $request->year;
        $name=$request->name;


         $schools = [];
        foreach (SchoolLevel::all() as $key) {
            $schools[$key->class] = $key->class;
        }

        

        if($request->isMethod('post')){
           
            $student=StudentPayment::where('student_id', $name)->where('year',$year)->first();          
         $payments=SchoolPayment::where('fee_id', $student->fee_id)->where('student_id', $name)->where('year',$year)->where('type','!=','Discount Fees')->get();
        $data=SchoolBreakdown::where('fee_id', $student->fee_id)->get();
          $list= Student::where('class',$class)->where('added_by',auth()->user()->added_by)->get(); 
        }else{
           
            $student='';
         $payments='';
       $data=[];
        $list='';
        }

       
         if($request->type == 'print_pdf'){
              $student=StudentPayment::where('student_id', $name)->where('year',$year)->first();          
         $payments=SchoolPayment::where('fee_id', $student->fee_id)->where('student_id', $name)->where('year',$year)->where('type','!=','Discount Fees')->get();
                         $data=SchoolBreakdown::where('fee_id', $student->fee_id)->get();

             $pdf = PDF::loadView('raja.report.student_report_pdf',
            compact('class','year','schools','data','name','student','payments'))->setPaper('a4', 'potrait');

               $client=Student::where('id',$name)->first();
                 $st_name=strtoupper($client->student_name);
        return $pdf->download($st_name  .' FEE REPORT  FOR THE YEAR ' . $request->year . ".pdf");
        
         
        }else{
             return view('raja.report.student_report',
            compact('class','year','schools','data','name','student','payments','list'));
        }
       
    }


  public function student_report_excel($name,$year)
    {

            $client=Student::where('id',$name)->first();
             $st_name=strtoupper($client->student_name);

         return Excel::download(new ExportStudentReport($name,$year), $st_name  .' FEE REPORT  FOR THE YEAR ' . $year. ".xls");
      
    }


public function class_report(Request $request)
    {
       
        $class = $request->class;
        $year = $request->year;


         $schools = [];
        foreach (SchoolLevel::all() as $key) {
            $schools[$key->class] = $key->class;
        }

        

        if($request->isMethod('post')){
           
        $data= DB::table('student_payments')
                           ->leftJoin('students', 'students.id', 'student_payments.student_id')
                            ->where('student_payments.year', $year)
                            ->where('students.added_by', auth()->user()->added_by)
                          ->where('student_payments.class', $class)
                            ->select('student_payments.*','students.student_name')
                            ->get();
          
        }else{
           
       $data=[];

        }

       
         if($request->type == 'print_pdf'){
                         $data= DB::table('student_payments')
                           ->leftJoin('students', 'students.id', 'student_payments.student_id')
                            ->where('student_payments.year', $year)
                            ->where('students.added_by', auth()->user()->added_by)
                          ->where('students.class', $class)
                            ->select('student_payments.*','students.student_name')
                            ->get();

             $pdf = PDF::loadView('raja.report.class_report_pdf',
            compact('class','year','schools','data'))->setPaper('a4', 'potrait');

                 $st_name=strtoupper($class);
        return $pdf->download($st_name  .' FEE REPORT  FOR THE YEAR ' . $request->year . ".pdf");
        
         
        }else{
             return view('raja.report.class_report',
            compact('class','year','schools','data'));
        }
       
    }


public function uncollected_fees(Request $request)
    {
       
        $class = $request->class;
        $year = $request->year;


         $schools = [];
        foreach (SchoolLevel::all() as $key) {
            $schools[$key->class] = $key->class;
        }

        

        if($request->isMethod('post')){
           
        $data= DB::table('student_payments')
                           ->leftJoin('students', 'students.id', 'student_payments.student_id')
                            ->where('student_payments.year', $year)
                           ->where('student_payments.status', '!=' ,'2')
                            ->where('students.added_by', auth()->user()->added_by)
                          ->where('student_payments.class', $class)
                            ->select('student_payments.*','students.student_name')
                            ->get();
          
        }else{
           
       $data=[];

        }

       
         if($request->type == 'print_pdf'){
                         $data= DB::table('student_payments')
                           ->leftJoin('students', 'students.id', 'student_payments.student_id')
                            ->where('student_payments.year', $year)
                              ->where('student_payments.status', '!=' ,'2')
                            ->where('students.added_by', auth()->user()->added_by)
                          ->where('students.class', $class)
                            ->select('student_payments.*','students.student_name')
                            ->get();

             $pdf = PDF::loadView('raja.report.uncollected_report_pdf',
            compact('class','year','schools','data'))->setPaper('a4', 'potrait');

                 $st_name=strtoupper($class);
        return $pdf->download($st_name  .' FEE REPORT  FOR THE YEAR ' . $request->year . ".pdf");
        
         
        }else{
             return view('raja.report.uncollected_report',
            compact('class','year','schools','data'));
        }
       
    }
    
    
  
      public function findPLevel(Request $request)
    {
        //
        
        $type=$request->id;
        
     if($type == 'class'){
      $students = SchoolLevel::whereNotIn('class', ['Preparatory Class', 'Class Seven', 'Form Four','Form Six'])->get();     
     }
      else if($type == 'level'){
      $students = SchoolLevel::whereIn('class', ['Preparatory Class', 'Class Seven', 'Form Four'])->get();     
     }
     else if($type == 'graduate'){
      $students = SchoolLevel::whereIn('class', ['Preparatory Class', 'Class Seven', 'Form Four','Form Six'])->get();     
     }
     
       
        return response()->json($students);
    }
    
    
      public function promote_students(Request $request)
    {
        //
        
       
        $type=$request->type;
        $class_id=$request->class;
       

         if($request->isMethod('post')){
             
         $l=SchoolLevel::find($class_id);
        $class=$l->class;     
             
             
     if($type == 'class'){
      $students = Student::where('class', $class)->where('graduate', '0')->whereNotIn('class', ['Preparatory Class', 'Class Seven', 'Form Four','Form Six'])->where('added_by',auth()->user()->added_by)->get();   
       $classes = SchoolLevel::whereNotIn('class', ['Preparatory Class', 'Class Seven', 'Form Four','Form Six'])->get();
     }
      else if($type == 'level'){
      $students = Student::where('class', $class)->where('graduate', '1')->whereIn('class', ['Preparatory Class', 'Class Seven', 'Form Four'])->where('added_by',auth()->user()->added_by)->get();  
       $classes = SchoolLevel::whereIn('class', ['Preparatory Class', 'Class Seven', 'Form Four'])->get(); 
     }
     else if($type == 'graduate'){
      $students = Student::where('class', $class)->where('graduate', '0')->whereIn('class', ['Preparatory Class', 'Class Seven', 'Form Four','Form Six'])->where('added_by',auth()->user()->added_by)->get();  
       $classes =SchoolLevel::whereIn('class', ['Preparatory Class', 'Class Seven', 'Form Four','Form Six'])->get(); 
     }
     
       
}

else{
      $students = [];
      $classes=[];
      $class='';

}
        return view('raja.student.multiple_promote',compact('students','type','class','classes','class_id'));
    }
      

 public function save_promote(Request $request){

$nameArr =$request->checked_item_id ;


  if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){


          $student=Student::find($nameArr[$i]);
          
          if($request->type == 'class' || $request->type == 'level'){
     
     $class=SchoolLevel::where('class',$student->class)->first(); 
     $next=$class->id + 1;
     
         $next_class=SchoolLevel::find($next); 
         $data['class']=$next_class->class;
         $data['level']=$next_class->level;
         $data['graduate']='0';
     
         $student->update($data);
        
           $item['student_id']=$student->id;
           $item['level']=$student->level;
           $item['class']=$student->class;
           $item['year']= date('Y');
           $item['added_by']=auth()->user()->added_by;
           
           StudentHistory::create($item);
            }
            
      else if($request->type == 'graduate'){
     
         $data['graduate']='1';
     
         $student->update($data);
         
         $g=StudentHistory::where('student_id',$student->id)->where('class',$student->class)->first();
         if(!empty($g)){
             $year=$g->year;
         }
         else{
             $year=date('Y');
         }
        
           $item['student_id']=$student->id;
           $item['level']=$student->level;
           $item['class']=$student->class;
           $item['year']= $year;
           $item['added_by']=auth()->user()->added_by;
           
           GraduateHistory::create($item);
            }

       

}
}
    return redirect(route('multiple_student.promote'))->with('success', 'Promoted Successfully');
    }

else{
  return redirect(route('multiple_student.promote'))->with(['error'=>'You have not chosen an entry']);
}



 




}


    
    
         public function disable_students(Request $request)
    {
        //
        
        $type=$request->type;
        $class_id=$request->class;
        
          $classes = SchoolLevel::all();

         if($request->isMethod('post')){
             
         $l=SchoolLevel::find($class_id);
        $class=$l->class;     
             
      $students = Student::where('class', $class)->where('graduate', '0')->where('added_by',auth()->user()->added_by)->get();     


}else{
      $students = [];
      $class='';
      

}
        return view('raja.student.multiple_disable',compact('students','type','class','class_id','classes'));
    }


 public function save_disable(Request $request){

$nameArr =$request->checked_item_id ;


  if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){


          $student=Student::find($nameArr[$i]);
          
         $data['disabled']='1';
         $data['disabled_date']= date('Y-m-d');
     
         $student->update($data);

            

}
}
return redirect(route('multiple_student.disable'))->with('success', 'Disabled Successfully');
    }

else{
  return redirect(route('multiple_student.disable'))->with(['error'=>'You have not chosen an entry']);
}


}




  public function import_payments()
    {
        //

        return view('raja.payment.import_payments');
    }

 public function import(Request $request){
      
        
        $data = Excel::import(new ImportStudentsPayments, $request->file('file')->store('files'));
        
        return redirect()->back()->with('success', 'File Imported Successfully');
    }
    
     public function sample(Request $request){

       $filepath = public_path('students_payments_sample.xlsx');
       return Response::download($filepath);
    }










}
