<?php

namespace App\Http\Controllers;
use App\Traits\Calculate_netProfitTrait;
use App\Traits\Calculate_netProfitTrait2;
use App\Traits\Calculate_netProfitTrait3;
use App\Traits\Calculate_netProfitTrait4;
use App\Models\ClassAccount;
use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\AccountCodes;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\Pacel;
use App\Region;
use App\User;
use PDF;
use App\Exports\ExportTrialBalance;
use App\Exports\ExportIncomeStatement;
use App\Exports\ExportBalanceSheet;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{


  use Calculate_netProfitTrait3;
     use Calculate_netProfitTrait4;
    public function trial_balance(Request $request)
    {
       
        $start_date = $request->start_date;
         $second_date = $request->second_date;
        //$end_date = $request->end_date;

          $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();


       $data = ClassAccount::where('added_by',auth()->user()->added_by)->get();
        return view('financial_report.trial_balance',
            compact('start_date','second_date','income','expense',
                'cost' ,'data'));
    }

 use Calculate_netProfitTrait3;
     use Calculate_netProfitTrait4;
    public function trial_balance_summary(Request $request)
    {
       
        $start_date = $request->start_date;
         $second_date = $request->second_date;
        //$end_date = $request->end_date;

          $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();


       $data = ClassAccount::where('added_by',auth()->user()->added_by)->get();
        return view('financial_report.trial_balance_summary',
            compact('start_date','second_date','income','expense',
                'cost' ,'data'));
    }

    public function trial_balance_pdf(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
      $data = ClassAccount::where('added_by',auth()->user()->added_by)->get();
        $pdf = PDF::loadView('financial_report.trial_balance_pdf', compact('start_date',
            'end_date','data'));

                 $s=  date('d-m-Y', strtotime($start_date));
                 $e=  date('d-m-Y', strtotime($end_date));
        return $pdf->download('TRIAL BALANCE  FOR THE PERIOD ' . $s . ' to '. $e. ".pdf");

    }

    public function trial_balance_excel(Request $request)
    {
       
       $start_date = $request->start_date;
        $end_date = $request->end_date;

       $s=  date('d-m-Y', strtotime($start_date));
        $e=  date('d-m-Y', strtotime($end_date));

        if (!empty($start_date)) {
            $trial = [];
            array_push($trial, [
                'TRIAL BALANCE FOR THE PERIOD ' . ":" . $s . " to"  . $e
            ]);
            array_push($trial, [
                'ACCOUNT NAME',
                'ACCOUNT CODE',
               'DEBIT',
                'CREDIT'
            ]);
            $credit_total = 0;
            $debit_total = 0;
               $total_vat_cr=0;;
               $total_vat_dr=0;;

                 $class = ClassAccount::where('added_by',auth()->user()->added_by)->get();
            foreach($class->where('added_by',auth()->user()->added_by) as $account_class) {
               foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group){
             if($group->name != 'Retained Earnings/Loss'){

            foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){
       if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)'){


                 
                        $cr = 0;
                        $dr = 0;
                        $balance=0;
                           $total_d=0;
                             $total_c=0;


                        $cr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');

                     if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense'){
                            $debit_total += $dr-$cr ;
                       $value_dr=$dr-$cr;
                         $value_cr=0;
                        }
                        else{
                            $credit_total += $cr-$dr ;
                          $value_dr=0;
                            $value_cr=$cr-$dr;
                        }




}

elseif($account_code->account_name == 'Value Added Tax (VAT)'){
  $cr_in = 0;
                        $dr_in = 0;                   
                        $cr_out  = 0;
                        $dr_out  = 0;
                        $total_vat=0;
                           $total_out=0;
                             $total_in=0;
                             
                      
                        $vat_in=AccountCodes::where('account_name', 'VAT IN')->where('added_by',auth()->user()->added_by)->first();
                        $vat_out=AccountCodes::where('account_name', 'VAT OUT')->where('added_by',auth()->user()->added_by)->first();

                        $cr_in = JournalEntry::where('account_id', $vat_in->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in =JournalEntry::where('account_id', $vat_in->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = JournalEntry::where('account_id',  $vat_out->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = JournalEntry::where('account_id', $vat_out->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            

                         $total_in= $dr_in- $cr_in ;
                          $total_out = $cr_out - $dr_out ;
                         if ($total_in - $total_out < 0){
                        $total_vat_cr=($total_in -  $total_out) * -1;
                       $value_dr=0;
                       $value_cr=abs(($total_in - $total_out) *-1 );
                       }
                       else{
                         $total_vat_dr=$total_in -  $total_out;
                            $value_dr=abs($total_in - $total_out );
                                   $value_cr=0;
                                
                         }
                    
                       

}

 array_push($trial, [$account_code->account_name, $account_code->account_codes, number_format($value_dr , 2), number_format($value_cr , 2)]);
}
}
}
}

array_push($trial, [
               'Total',
                "",
                number_format($debit_total +  $total_vat_dr, 2),
                number_format($credit_total +  $total_vat_cr, 2)
            ]);


               return Excel::download(new ExportTrialBalance($trial), 'TRIAL BALANCE  FOR THE PERIOD ' .  $s . ' to '. $e. ".xls");
          

}

    }


public function trial_balance_summary_pdf(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
     $data =ClassAccount::where('added_by',auth()->user()->added_by)->get();
        $pdf = PDF::loadView('financial_report.trial_balance_summary_pdf', compact('start_date',
            'end_date','data'));

               $s=  date('d-m-Y', strtotime($start_date));
                 $e=  date('d-m-Y', strtotime($end_date));

        return $pdf->download('TRIAL BALANCE  SUMMARY FOR THE PERIOD ' . $s . ' to '. $e. ".pdf");

    }

    public function trial_balance_summary_excel(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;

         $s=  date('d-m-Y', strtotime($start_date));
                 $e=  date('d-m-Y', strtotime($end_date));

        if (!empty($start_date)) {
            $trial = [];
            array_push($trial, [
                  'TRIAL BALANCE SUMMARY FOR THE PERIOD ' . ":" . $s . " to"  . $e
            ]);
            array_push($trial, [
                'ACCOUNT',
               'DEBIT',
                'CREDIT'
            ]);

            $credit_total = 0;
            $debit_total = 0;
             

                 $class = ClassAccount::where('added_by',auth()->user()->added_by)->get();
            foreach($class->where('added_by',auth()->user()->added_by) as $account_class) {

                  $total_dr_unit=0;
                   $total_cr_unit=0;
                $total_vat_cr=0;;
               $total_vat_dr=0;;

               foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group){
             if($group->name != 'Retained Earning/Loss'){

            foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){
       if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)'){


                        $cr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');

                       $total_dr_unit  +=($dr-$cr);
                        $total_cr_unit  +=($cr-$dr);

                     if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense'){
                            $debit_total += $dr-$cr ;

                        }
                        else{
                            $credit_total += $cr-$dr ;
                          
                        }




}

elseif($account_code->account_name == 'Value Added Tax (VAT)'){
  $cr_in = 0;
                        $dr_in = 0;                   
                        $cr_out  = 0;
                        $dr_out  = 0;
                        $total_vat=0;
                           $total_out=0;
                             $total_in=0;
                             
                      
                        $vat_in=AccountCodes::where('account_name', 'VAT IN')->where('added_by',auth()->user()->added_by)->first();
                        $vat_out=AccountCodes::where('account_name', 'VAT OUT')->where('added_by',auth()->user()->added_by)->first();

                        $cr_in = JournalEntry::where('account_id', $vat_in->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in =JournalEntry::where('account_id', $vat_in->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = JournalEntry::where('account_id',  $vat_out->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = JournalEntry::where('account_id', $vat_out->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            

                         $total_in= $dr_in- $cr_in ;
                          $total_out = $cr_out - $dr_out ;

                        if ($total_in - $total_out < 0){
                        $total_vat_cr=($total_in -  $total_out) * -1;
                         $total_cr_unit=$total_cr_unit + (($total_in -  $total_out) * -1);
                        $credit_total=$credit_total +$total_vat_cr;

                       }
                       else{
                         $total_vat_dr=$total_in -  $total_out;
                   $total_dr_unit=$total_cr_unit + (($total_in -  $total_out) * -1);
                    $debit_total= $debit_total +$total_vat_dr;

                         }
                    
                       

}

}
}
}

 if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense'){
                            $value_dr=$total_dr_unit;
                         $value_cr=0;
                        }
                        else{
                               $value_dr=0;
                            $value_cr=$total_cr_unit;
                          
                        }

 array_push($trial, [$account_class->class_name, number_format($value_dr, 2), number_format($value_cr, 2)]);
}

array_push($trial, [
               'Total',
                number_format($debit_total , 2),
                number_format($credit_total , 2)
            ]);

              return Excel::download(new ExportTrialBalance($trial), 'TRIAL BALANCE  SUMMARY FOR THE PERIOD ' .  $s . ' to '. $e. ".xls");
          

}

    }


    public function income_statement(Request $request)
    {
       
        $start_date = $request->start_date;
         $second_date = $request->second_date;
        $end_date = $request->end_date;
        
        
           $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();

        return view('financial_report.income_statement',
            compact('start_date','second_date','income','expense','end_date',
                'cost'));
    }
   public function income_statement_summary(Request $request)
    {
       
        $start_date = $request->start_date;
         $second_date = $request->second_date;
        $end_date = $request->end_date;
        
        
              $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();

        return view('financial_report.income_statement_summary',
            compact('start_date','second_date','income','expense','end_date',
                'cost'));
    }

    public function income_statement_pdf(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;

  $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();

        $pdf = PDF::loadView('financial_report.income_statement_pdf', compact('start_date','end_date','income','expense',
                'cost'));

                  $s=  date('d-m-Y', strtotime($start_date));
                 $e=  date('d-m-Y', strtotime($end_date));
        return $pdf->download('INCOME STATEMENT  FOR THE PERIOD ' . $s . ' to '. $e. ".pdf");

    }

   public function income_statement_excel(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;

       $s=  date('d-m-Y', strtotime($start_date));
                 $e=  date('d-m-Y', strtotime($end_date));

        if (!empty($start_date)) {
            $statement = [];
            array_push($statement, [
                'INCOME STATEMENT FOR THE PERIOD ' . ":" . $s . " to"  . $e
            ]);
            array_push($statement, [
              'ACCOUNT NAME',
               'ACCOUNT CODE',
                'BALANCE',
            ]);
            array_push($statement, [
                "",
               'Income',
                ""
            ]);
            $total_income = 0;
            $total_expenses = 0;

                $sales_balance  = 0;
                    $total_incomes  = 0;
                     $total_other_incomes  = 0;
                    $cost_balance  = 0;
                    $total_cost  = 0;
                    $expense_balance  = 0;
                    $total_expense  = 0;
                    $gross  = 0;
                   $profit=0;
                  $tax=0;
                $net_profit=0;

            $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();


          foreach($income->where('added_by',auth()->user()->added_by) as $account_class){
        foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group){   
        foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){

                     $cr =JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');

                $income_balance=$dr- $cr;
                  $total_incomes+=$income_balance ;

                array_push($statement, [$account_code->account_name, $account_code->account_codes, number_format(abs($income_balance),2)]);
            }
}

}

            array_push($statement, [
                "",
               'Total Income',
                  "",
                number_format(abs($total_incomes),2)
            ]);


            array_push($statement, [
                "",
                'Expenses',
                ""
            ]);


    foreach($expense->where('added_by',auth()->user()->added_by) as $account_class){
  foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group){        
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){
  
                $cr =JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');

               $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;

                array_push($statement, [$account_code->account_name, $account_code->account_codes,number_format(abs($expense_balance),2)]);

            }
}
}

            array_push($statement, [
                "",
                'Total Expenses',
                  "",
                number_format($total_expense, 2)
            ]);



if($total_other_incomes < 0){
$total_o=$total_other_incomes * -1;
}
else if($total_other_incomes >= 0){
$total_o=$total_other_incomes ;
}

if($total_incomes < 0){
$total_s=$total_incomes * -1;
$gross=$total_s+$total_o-$total_cost;
}
else if($total_incomes >= 0){
$gross=$total_incomes+$total_o-$total_cost;
}


if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else if($gross >= 0 && $total_expense < 0){
$profit=$total_expense +$gross;
}
else{
$profit=$gross-$total_expense;
}

if($profit > 0){
$tax=$profit*0.3;
}


            array_push($statement, [
                "",
                'Profit Before Tax',
                       "",
                number_format($profit, 2)
            ]);

        array_push($statement, [
                "",
                'Tax',
                     "",
                number_format($tax, 2)
            ]);

            array_push($statement, [
                "",
                'Net Profit',
                   "",
                number_format($profit-$tax, 2)
            ]);


               return Excel::download(new ExportIncomeStatement($statement), 'INCOME STATEMENT FOR THE PERIOD ' .  $s . ' to '. $e. ".xls");
            
        }
    }


   public function income_statement_summary_pdf(Request $request)
    {
       
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;

   $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();

        $pdf = PDF::loadView('financial_report.income_statement_summary_pdf', compact('start_date','end_date','income','expense',
                'cost'));

       $s=  date('d-m-Y', strtotime($start_date));
        $e=  date('d-m-Y', strtotime($end_date));
        return $pdf->download('INCOME STATEMENT SUMMARY  FOR THE PERIOD ' . $s . ' to '. $e. ".pdf");
    }

    public function income_statement_summary_excel(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;

      $s=  date('d-m-Y', strtotime($start_date));
        $e=  date('d-m-Y', strtotime($end_date));

        if (!empty($start_date)) {
            $statement = [];
            array_push($statement, [
                'INCOME STATEMENT SUMMARY FOR THE PERIOD ' . ":" . $s . " to"  . $e
            ]);
           
          
            $total_income = 0;
            $total_expenses = 0;

                $sales_balance  = 0;
                    $total_incomes  = 0;
                     $total_other_incomes  = 0;
                    $cost_balance  = 0;
                    $total_cost  = 0;
                    $expense_balance  = 0;
                    $total_expense  = 0;
                    $gross  = 0;
                   $profit=0;
                  $tax=0;
                $net_profit=0;

            $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();


          foreach($income->where('added_by',auth()->user()->added_by) as $account_class){
        foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group){   
        foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){

                     $cr =JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');

                $income_balance=$dr- $cr;
                  $total_incomes+=$income_balance ;

               
            }
}

}



            array_push($statement, [
               'Income',
                number_format(abs($total_incomes),2)
            ]);


         


    foreach($expense->where('added_by',auth()->user()->added_by) as $account_class){
  foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group){        
foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){
  
                $cr =JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');

               $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;

               

            }
}
}

            array_push($statement, [
                'Expenses',
                number_format($total_expense, 2)
            ]);



if($total_other_incomes < 0){
$total_o=$total_other_incomes * -1;
}
else if($total_other_incomes >= 0){
$total_o=$total_other_incomes ;
}

if($total_incomes < 0){
$total_s=$total_incomes * -1;
$gross=$total_s+$total_o-$total_cost;
}
else if($total_incomes >= 0){
$gross=$total_incomes+$total_o-$total_cost;
}


if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else if($gross >= 0 && $total_expense < 0){
$profit=$total_expense +$gross;
}
else{
$profit=$gross-$total_expense;
}

if($profit > 0){
$tax=$profit*0.3;
}


            array_push($statement, [
                'Profit Before Tax',
                number_format($profit, 2)
            ]);

        array_push($statement, [
                'Tax',
                number_format($tax, 2)
            ]);

            array_push($statement, [
                'Net Profit',
                number_format($profit-$tax, 2)
            ]);


               return Excel::download(new ExportIncomeStatement($statement), 'INCOME STATEMENT SUMMARY  FOR THE PERIOD ' .  $s . ' to '. $e. ".xls");
            
        }
    }

    
    use Calculate_netProfitTrait;
     use Calculate_netProfitTrait2;
    public function balance_sheet(Request $request)
    {  
       
         $start_date = $request->start_date;
   $end_date = $request->end_date;
        $asset = ClassAccount::where('class_type','Assets')->where('added_by',auth()->user()->added_by)->get();
    $liability = ClassAccount::where('class_type','Liability')->where('added_by',auth()->user()->added_by)->get();
   $equity = ClassAccount::where('class_type','Equity')->where('added_by',auth()->user()->added_by)->get();

 $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();

  if(!empty($start_date)){
          $net_profit = $this->get_netProfit($start_date,$end_date);
        }
else{
     $net_profit ='';      
}

$net_p = $this->get_netProfit2();
       return view('financial_report.balance_sheet',
            compact('start_date','income','expense',
                'cost' ,'end_date','asset','liability',
                'equity','net_p','net_profit'));
    }
    
       use Calculate_netProfitTrait;
     use Calculate_netProfitTrait2;
    public function balance_sheet_summary(Request $request)
    {  
       
         $start_date = $request->start_date;
   $end_date = $request->end_date;
          $asset = ClassAccount::where('class_type','Assets')->where('added_by',auth()->user()->added_by)->get();
    $liability = ClassAccount::where('class_type','Liability')->where('added_by',auth()->user()->added_by)->get();
   $equity = ClassAccount::where('class_type','Equity')->where('added_by',auth()->user()->added_by)->get();

 $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();


  if(!empty($start_date)){
          $net_profit = $this->get_netProfit($start_date,$end_date);
        }
else{
     $net_profit ='';      
}

$net_p = $this->get_netProfit2();
       return view('financial_report.balance_sheet_summary',
            compact('start_date','income','expense',
                'cost' ,'end_date','asset','liability',
                'equity','net_p','net_profit'));
    }

  

    public function balance_sheet_pdf(Request $request)
    {
       
         $start_date = $request->start_date;
          $end_date = $request->end_date;

       $asset = ClassAccount::where('class_type','Assets')->where('added_by',auth()->user()->added_by)->get();
    $liability = ClassAccount::where('class_type','Liability')->where('added_by',auth()->user()->added_by)->get();
   $equity = ClassAccount::where('class_type','Equity')->where('added_by',auth()->user()->added_by)->get();

if(!empty($start_date)){
          $net_profit = $this->get_netProfit($start_date,$end_date);
        }
else{
     $net_profit ='';      
}

        $pdf = PDF::loadView('financial_report.balance_sheet_pdf', compact('start_date',
             'asset','liability',
                'equity','net_profit'));

         $s=  date('d-m-Y', strtotime($start_date));

return $pdf->download('BALANCE SHEET AS AT - '. $s. ".pdf");       

    }

   use Calculate_netProfitTrait;
     use Calculate_netProfitTrait2;
    public function balance_sheet_excel(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
       
        $s=  date('d-m-Y', strtotime($start_date));

        if (!empty($start_date)) {
          $net_profit = $this->get_netProfit($start_date,$end_date);

            $balance = [];
            array_push($balance, ['BALANCE SHEET  AS AT ' . ' - ' . $s
            ]);
            array_push($balance, [
               'ACCOUNT CODE',
               'ACCOUNT NAME',
                'BALANCE',
            ]);
            array_push($balance, [
                'Assets',
                "",
                ""
            ]);

                     $total_liabilities = 0;
                    $total_debit_assets = 0;
                    $total_credit_assets = 0;
                      $total_debit_liability  = 0;
                    $total_credit_liability  = 0;
                        $total_debit_equity  = 0;
                    $total_credit_equity  = 0;
                   $total_assets = 0;
                    $total_equity = 0;


                  $asset = ClassAccount::where('class_type','Assets')->where('added_by',auth()->user()->added_by)->get();
    $liability = ClassAccount::where('class_type','Liability')->where('added_by',auth()->user()->added_by)->get();
   $equity = ClassAccount::where('class_type','Equity')->where('added_by',auth()->user()->added_by)->get();

            foreach($asset->where('added_by',auth()->user()->added_by) as $account_class){

              $unit_total1   = 0;
               $unit_total2   = 0;


                    foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group){
                   foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){


                        $cr1 =JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');


                         $total_credit_assets +=($dr1-$cr1);                         


                array_push($balance, [$account_code->account_codes, $account_code->account_name, number_format($dr1-$cr1, 2)]);
            }
}
}
            array_push($balance, [
                "",
               'Total Assets',
                number_format($total_credit_assets, 2)
            ]);



            array_push($balance, [
                "",
               'Liabilities',
                ""
            ]);


            foreach($liability->where('added_by',auth()->user()->added_by)  as $account_class){

             foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group){
             foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){
           if($account_code->account_name == 'Value Added Tax (VAT)'){


                   $cr_in = 0;
                        $dr_in = 0;                   
                        $cr_out  = 0;
                        $dr_out  = 0;
                        $total_vat=0;
                           $total_out=0;
                             $total_in=0;
                             
                      
                        $vat_in= AccountCodes::where('account_name', 'VAT IN')->where('added_by',auth()->user()->added_by)->first();
                        $vat_out= AccountCodes::where('account_name', 'VAT OUT')->where('added_by',auth()->user()->added_by)->first();

                        $cr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out =JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out =JournalEntry::where('account_id', $vat_out->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            

                         $total_in= $dr_in- $cr_in ;
                          $total_out = $cr_out - $dr_out ;
                         if ($total_in - $total_out < 0){
                        $total=($total_in -  $total_out) * -1;
                          $total_vat=($total_in -  $total_out) * -1;
                       }
                       else{
                         $total=($total_in -  $total_out) * -1;;
                             $total_vat=($total_in -  $total_out) * -1;;
                         }
                

}


else{

                          $cr1 =JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');

                      if($account_code->account_name == 'Deffered Tax'){
                       $total_credit_liability  =    $total_credit_liability + $net_profit['tax_for_second_date'];
                          $total=  $net_profit['tax_for_second_date'];                  

                         }
                         else{
                          
                         $total_credit_liability  +=($cr1-$dr1);   
                           $total=  $cr1-$dr1;                      
                           }



}

                array_push($balance, [$account_code->account_codes, $account_code->account_name, number_format($total, 2)]);
            }
}

}

            array_push($balance, [
                "",
               'Total Liabilities',
                number_format($total_credit_liability + $total_vat, 2)
            ]);



            array_push($balance, [
                "",
               'Equities',
                ""
            ]);

             foreach($equity->where('added_by',auth()->user()->added_by)   as $account_class){
             
              foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group){
              foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){

                $cr1 =JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                     
                     
                         if($account_code->account_codes == 31101){
                         $total_credit_equity    =$total_credit_equity + $net_profit['profit_for_second_date'];
                           $total=$net_profit['profit_for_second_date'];
                         }else{
                         $total_credit_equity    +=($cr1-$dr1) ;
                           $total=$cr1-$dr1;
                         }

               
                array_push($balance, [ $account_code->account_codes, $account_code->account_name, number_format($total, 2)]);
            }
}

}

            array_push($balance, [
                "",
                'Total Equities',
                number_format($total_credit_equity    , 2)
            ]);


            array_push($balance, [
                "",
               'Total Liabilities And Equities',
                number_format($total_credit_liability+$total_credit_equity + $total_vat, 2)
            ]);

               return Excel::download(new ExportBalanceSheet($balance), 'BALANCE SHEET AS AT ' .  '- ' . $s. ".xls");
            
        }
    }
   

use Calculate_netProfitTrait;
     use Calculate_netProfitTrait2;
    public function balance_sheet_summary_pdf(Request $request)
    {
       
          $start_date = $request->start_date;
          $end_date = $request->end_date;

       $asset = ClassAccount::where('class_type','Assets')->where('added_by',auth()->user()->added_by)->get();
    $liability = ClassAccount::where('class_type','Liability')->where('added_by',auth()->user()->added_by)->get();
   $equity = ClassAccount::where('class_type','Equity')->where('added_by',auth()->user()->added_by)->get();

if(!empty($start_date)){
          $net_profit = $this->get_netProfit($start_date,$end_date);
        }
else{
     $net_profit ='';      
}

        $pdf = PDF::loadView('financial_report.balance_sheet_summary_pdf', compact('start_date',
             'asset','liability',
                'equity','net_profit'));

$s=  date('d-m-Y', strtotime($start_date));

        return $pdf->download('BALANCE SHEET SUMMARY AS AT ' . ' - ' . $request->start_date . ".pdf");
    }


 use Calculate_netProfitTrait;
     use Calculate_netProfitTrait2;
    public function balance_sheet_summary_excel(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;

           $s=  date('d-m-Y', strtotime($start_date));

        if (!empty($start_date)) {
          $net_profit = $this->get_netProfit($start_date,$end_date);

            $balance = [];
            array_push($balance, ['BALANCE SHEET SUMMARY AS AT  ' . ' - ' . $s
            ]);
          
          

                     $total_liabilities = 0;
                    $total_debit_assets = 0;
                    $total_credit_assets = 0;
                      $total_debit_liability  = 0;
                    $total_credit_liability  = 0;
                        $total_debit_equity  = 0;
                    $total_credit_equity  = 0;
                   $total_assets = 0;
                    $total_equity = 0;


                  $asset = ClassAccount::where('class_type','Assets')->where('added_by',auth()->user()->added_by)->get();
    $liability = ClassAccount::where('class_type','Liability')->where('added_by',auth()->user()->added_by)->get();
   $equity = ClassAccount::where('class_type','Equity')->where('added_by',auth()->user()->added_by)->get();

            foreach($asset->where('added_by',auth()->user()->added_by) as $account_class){

              $unit_total1   = 0;
               $unit_total2   = 0;


                    foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group){
                   foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){


                        $cr1 =JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');


                         $total_credit_assets +=($dr1-$cr1);                         


               
            }
}
}
            array_push($balance, [
               'Assets',
                number_format($total_credit_assets, 2)
            ]);



         

            foreach($liability->where('added_by',auth()->user()->added_by)  as $account_class){

             foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group){
             foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){
           if($account_code->account_name == 'Value Added Tax (VAT)'){


                   $cr_in = 0;
                        $dr_in = 0;                   
                        $cr_out  = 0;
                        $dr_out  = 0;
                        $total_vat=0;
                           $total_out=0;
                             $total_in=0;
                             
                      
                        $vat_in= AccountCodes::where('account_name', 'VAT IN')->where('added_by',auth()->user()->added_by)->first();
                        $vat_out= AccountCodes::where('account_name', 'VAT OUT')->where('added_by',auth()->user()->added_by)->first();

                        $cr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out =JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out =JournalEntry::where('account_id', $vat_out->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            

                         $total_in= $dr_in- $cr_in ;
                          $total_out = $cr_out - $dr_out ;
                         if ($total_in - $total_out < 0){
                        $total=($total_in -  $total_out) * -1;
                          $total_vat=($total_in -  $total_out) * -1;
                       }
                       else{
                         $total=($total_in -  $total_out) * -1;;
                             $total_vat=($total_in -  $total_out) * -1;;
                         }
                

}


else{

                          $cr1 =JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');

                      if($account_code->account_name == 'Deffered Tax'){
                       $total_credit_liability  =    $total_credit_liability + $net_profit['tax_for_second_date'];
                          $total=  $net_profit['tax_for_second_date'];                  

                         }
                         else{
                          
                         $total_credit_liability  +=($cr1-$dr1);   
                           $total=  $cr1-$dr1;                      
                           }



}

                
            }
}

}

            array_push($balance, [
               'Liabilities',
                number_format($total_credit_liability + $total_vat, 2)
            ]);



     

             foreach($equity->where('added_by',auth()->user()->added_by)   as $account_class){
             
              foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group){
              foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code){

                $cr1 =JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                     
                     
                         if($account_code->account_codes == 31101){
                         $total_credit_equity    =$total_credit_equity + $net_profit['profit_for_second_date'];
                           $total=$net_profit['profit_for_second_date'];
                         }else{
                         $total_credit_equity    +=($cr1-$dr1) ;
                           $total=$cr1-$dr1;
                         }

               
  
            }
}

}

            array_push($balance, [
                'Equities',
                number_format($total_credit_equity    , 2)
            ]);


            array_push($balance, [
               'Liabilities And Equities',
                number_format($total_credit_liability+$total_credit_equity + $total_vat, 2)
            ]);

               return Excel::download(new ExportBalanceSheet($balance), 'BALANCE SHEET SUMMARY AS AT ' .  '- ' . $s. ".xls");
            
        }
    }






    public function index(Request $request)
    {
        //
        $region = Region::all();
        if ($request->ajax()) {
            $data = Pacel::query();
            $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
            $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');
            $status = (!empty($_GET["status"])) ? ($_GET["status"]) : ('');
            $from = (!empty($_GET["from"])) ? ($_GET["from"]) : ('');
            $to = (!empty($_GET["to"])) ? ($_GET["to"]) : ('');

     //filter selected columns
            if($start_date && $end_date){
             $start_date = date('Y-m-d', strtotime($start_date));
             $end_date = date('Y-m-d', strtotime($end_date));
             $data->whereRaw("date(pacels.created_at) >= '" . $start_date . "' AND date(pacels.created_at) <= '" . $end_date . "'");
            }
            if($from && $from!="all")
            $data->whereRaw("pacels.from = '" . $from . "'");
            if($to && $to!="all")
            $data->whereRaw("pacels.to = '" . $to . "'");
            if($status && $status!="all")
            $data->whereRaw("pacels.status = '" . $status . "'");
            $data2 = $data->select('*');


            return Datatables::of($data2)
                    ->addIndexColumn()
                    ->editColumn('date', function ($row) {
                        $newDate = date("d-m-Y", strtotime($row->created_at));
                        return '- '.$newDate.'<br>- Ref.no '.$row->pacel_number;
                   })
                   ->editColumn('pacel_number', function ($row) {
                    $user = User::find($row->owner_id);
                    return '- '.$user->fname.' '.$user->lname.'<Br>- '.$user->address.'<br>- '.$user->country;
               })
               ->editColumn('from', function ($row) {
                
                return $row->receiver_name;
           })
                    ->editColumn('weight', function ($row) {
                         return $row->weight.'kg';
                    })
                    ->editColumn('from_to', function ($row) {
                        return '- '.$row->from.'<br>- '.$row->to.'<br>- '.$row->pacel_name;
                   })
                    ->editColumn('amount', function ($row) {
                        return $row->amount.' /=Tsh';
                   })
                    ->editColumn('status', function ($row) {
                        if($row->status == 1)
                         return '<span class="label label-warning">payment processed</span>';
                        elseif($row->status == 2)
                        return '<span class="label label-info">payment confirmed</span>';
                        elseif($row->status == 3)
                        return '<span class="label label-success">Collected</span>';
                        elseif($row->status == 4)
                        return '<span class="label label-info">On Transit</span>';
                        elseif($row->status == 5)
                        return '<span class="label label-primary">arrive</span>';
                        elseif($row->status == 6)
                        return '<span class="label label-primary">derivered</span>';
                        
                    })
                    ->rawColumns(['status','date','pacel_number','from_to'])
                   
                    
                    ->make(true);
        }
      
        return view('report.pacel',compact('region'));
    

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




}
