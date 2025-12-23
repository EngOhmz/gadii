<?php

namespace App\Http\Controllers;
use App\Traits\Calculate_netProfitTrait;
use App\Traits\Calculate_netProfitTrait2;
use App\Traits\Calculate_netProfitTrait3;
use App\Traits\Calculate_netProfitTrait4;
use App\Models\Branch;
use App\Models\ClassAccount;
use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\AccountCodes;
use App\Models\GroupAccount;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\Pacel;
use App\Models\Deposit;
use App\Region;
use App\Models\User;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportTrialBalance;
use App\Exports\ExportIncomeStatement;
use App\Exports\ExportBalanceSheet;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User_Roles;
use App\Models\Role;
use App\Models\User_RolesCopy2;
use App\Models\UserDetails\DueDate;
use App\Models\Notification;
use Carbon\Carbon;
use  DateTime;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{


  use Calculate_netProfitTrait3;
     use Calculate_netProfitTrait4;
    public function trial_balance(Request $request)
    {
       
        $start_date = $request->start_date;
         $second_date = $request->second_date;
          $branch_id = $request->branch_id;
          
        //$end_date = $request->end_date;

          $income = ClassAccount::where('class_type','Income')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();

         $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
         
         if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;
 
 //dd($x);
 
 if(!empty($start_date)){
          $net_profit = $this->get_netProfit($start_date,$second_date,$branch_id);
        }
else{
     $net_profit ='';      
}
 
       $data = ClassAccount::where('added_by',auth()->user()->added_by)->where('disabled','0')->orderBy('class_id','asc')->get();
        return view('financial_report.trial_balance',
            compact('start_date','second_date','income','expense',
                'cost' ,'data','branch','branch_id','x','z','net_profit'));
    }

 use Calculate_netProfitTrait3;
     use Calculate_netProfitTrait4;
    public function trial_balance_summary(Request $request)
    {
       
        $start_date = $request->start_date;
         $second_date = $request->second_date;
          $branch_id= $request->branch_id;
        //$end_date = $request->end_date;

          $income = ClassAccount::where('class_type','Income')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();

 $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
 
   if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;
 
 if(!empty($start_date)){
          $net_profit = $this->get_netProfit($start_date,$second_date,$branch_id);
        }
else{
     $net_profit ='';      
}
 
 
       $data = ClassAccount::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
        return view('financial_report.trial_balance_summary',
            compact('start_date','second_date','income','expense',
                'cost' ,'data','branch','branch_id','x','z','net_profit'));
    }

    public function trial_balance_pdf(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
         $branch_id= $request->branch_id;
         
         $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
         
         if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}

 $z[]=$branch_id;
 
 if(!empty($start_date)){
          $net_profit = $this->get_netProfit($start_date,$end_date,$branch_id);
        }
else{
     $net_profit ='';      
}
 
         
         
      $data = ClassAccount::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
        $pdf = PDF::loadView('financial_report.trial_balance_pdf', compact('start_date',
            'end_date','data','branch_id','x','z','net_profit'));

                 $s=  date('d-m-Y', strtotime($start_date));
                 $e=  date('d-m-Y', strtotime($end_date));
        return $pdf->download('TRIAL BALANCE  FOR THE PERIOD ' . $s . ' to '. $e. ".pdf");

    }

    public function trial_balance_excel(Request $request)
    {
       
       $start_date = $request->start_date;
        $end_date = $request->end_date;
         $branch_id= $request->branch_id;
         
         $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
         
          if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;
 
 
  $a=  trim(json_encode($x), '[]'); 
     if($branch_id == $a){
         $br_id=$x;
     }
     
     else{
         
      $br_id=$z;    
     }
     

       $s=  date('d-m-Y', strtotime($start_date));
        $e=  date('d-m-Y', strtotime($end_date));

        if (!empty($start_date)) {
            $net_profit = $this->get_netProfit($start_date,$end_date,$branch_id);
            
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

                 $class = ClassAccount::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
            foreach($class->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_class) {
               foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group){
            

            foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0')->where('disabled','0') as $account_code){
       if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)' && $account_code->account_codes != '31101'){


                 
                        $cr = 0;
                        $dr = 0;
                        $cr1 = 0;
                        $dr1 = 0;
                        $balance=0;
                           $total_d=0;
                             $total_c=0;


                        if(!empty($branch_id) && $branch_id != $a){
                         $cr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                $cr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                $cr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                $cr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }


                         if ($account_class->class_type == 'Assets'){
                            $debit_total += $dr1-$cr1 ;
                            $value_dr=$dr1-$cr1;
                            $value_cr=0;
                        }
                        elseif ($account_class->class_type == 'Liability'){
                            $credit_total += $cr1-$dr1 ;
                            $value_dr=0;
                            $value_cr=$cr1-$dr1;
                        }
                         elseif ($account_class->class_type == 'Equity'){
                            $credit_total += $cr1-$dr1 ;
                            $value_dr=0;
                            $value_cr=$cr1-$dr1;
                        }
                        elseif ($account_class->class_type == 'Expense'){
                           $debit_total += $dr-$cr ;
                            $value_dr=$dr-$cr;
                            $value_cr=0;
                        }
                        elseif ($account_class->class_type == 'Income'){
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

                        if(!empty($branch_id) && $branch_id != $a){
                       $cr_in = JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = JournalEntry::where('account_id',  $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = JournalEntry::where('account_id', $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            $cr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = JournalEntry::where('account_id', $vat_out->id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

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


elseif($account_code->account_name == 'Deffered Tax'){
                  $cr2 = 0;
                    $dr2 = 0;
                             
                      if(!empty($branch_id) && $branch_id != $a){
                         $cr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
               $cr2 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr2 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
               
                $cr2 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr2 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }


                            $credit_total += ($cr2-$dr2) +$net_profit['tax_for_second_date']; ;
                            $value_dr=0;
                            $value_cr=($cr2+$net_profit['tax_for_second_date']) - $dr2;
                        

}



elseif($account_code->account_codes  == 31101){
                 


                            $credit_total += $net_profit['profit_for_second_date'] ;
                            $value_dr=0;
                            $value_cr=$net_profit['profit_for_second_date'];
                        

}


 array_push($trial, [$account_code->account_name, $account_code->account_codes, number_format($value_dr , 2), number_format($value_cr , 2)]);

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
         $branch_id= $request->branch_id;
     $data =ClassAccount::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
     
      $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
         
         if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;
 
 if(!empty($start_date)){
         $net_profit = $this->get_netProfit($start_date,$end_date,$branch_id);
        }
else{
     $net_profit ='';      
}
 
 
        $pdf = PDF::loadView('financial_report.trial_balance_summary_pdf', compact('start_date',
            'end_date','data','branch_id','x','z','net_profit'));

               $s=  date('d-m-Y', strtotime($start_date));
                 $e=  date('d-m-Y', strtotime($end_date));

        return $pdf->download('TRIAL BALANCE  SUMMARY FOR THE PERIOD ' . $s . ' to '. $e. ".pdf");

    }

    public function trial_balance_summary_excel(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
         $branch_id= $request->branch_id;
         
          $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
         
         if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;
 
 
  $a=  trim(json_encode($x), '[]'); 
     if($branch_id == $a){
         $br_id=$x;
     }
     
     else{
         
      $br_id=$z;    
     }

         $s=  date('d-m-Y', strtotime($start_date));
                 $e=  date('d-m-Y', strtotime($end_date));

        if (!empty($start_date)) {
            $net_profit = $this->get_netProfit($start_date,$end_date,$branch_id);
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
             

                 $class = ClassAccount::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
            foreach($class->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_class) {

                  $total_dr_unit=0;
                   $total_cr_unit=0;
                $total_vat_cr=0;;
               $total_vat_dr=0;;

               foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')->where('disabled','0')  as $group){
            

            foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code){
       if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)'  && $account_code->account_codes != '31101'){


                       if(!empty($branch_id) && $branch_id != $a){
                $cr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                $cr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                $cr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                $cr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            

                       if ($account_class->class_type == 'Assets'){
                            $debit_total += $dr1-$cr1 ;
                            $total_dr_unit  +=($dr1-$cr1);
                        }
                        elseif ($account_class->class_type == 'Liability'){
                            $credit_total += $cr1-$dr1 ;
                             $total_cr_unit  +=($cr1-$dr1);
                        }
                         elseif ($account_class->class_type == 'Equity'){
                            $credit_total += $cr1-$dr1 ;
                             $total_cr_unit  +=($cr1-$dr1);
                        }
                        elseif ($account_class->class_type == 'Expense'){
                           $debit_total += $dr-$cr ;
                            $total_dr_unit  +=($dr-$cr);
                        }
                        elseif ($account_class->class_type == 'Income'){
                           $credit_total += $cr-$dr ;
                            $total_cr_unit  +=($cr-$dr);
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

                        if(!empty($branch_id) && $branch_id != $a){
                       $cr_in = JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = JournalEntry::where('account_id',  $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = JournalEntry::where('account_id', $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            $cr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = JournalEntry::where('account_id', $vat_out->id)->where('date', '<=',$end_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            

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


elseif($account_code->account_name == 'Deffered Tax' ){


  if(!empty($branch_id) && $branch_id != $a){
                $cr2 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr2 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
               
                $cr2 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr2 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            

                             $credit_total +=  ($cr2-$dr2) +$net_profit['tax_for_second_date']; ;
                             $total_cr_unit  +=($cr2-$dr2) +$net_profit['tax_for_second_date']; ;;
                      
                        

 
}

elseif($account_code->account_codes  == 31101 ){

                             $credit_total +=  $net_profit['profit_for_second_date']; ;
                              $total_cr_unit  +=$net_profit['profit_for_second_date'] ;;
                      
                        

 
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
         $branch_id= $request->branch_id;
        
           $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
             $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
             
                    if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;
             
        return view('financial_report.income_statement',
            compact('start_date','second_date','income','expense','end_date',
                'cost','branch','branch_id','x','z'));
    }
   public function income_statement_summary(Request $request)
    {
       
        $start_date = $request->start_date;
         $second_date = $request->second_date;
        $end_date = $request->end_date;
         $branch_id= $request->branch_id;
        
        
              $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           
           $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
             
                    if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;

        return view('financial_report.income_statement_summary',
            compact('start_date','second_date','income','expense','end_date',
                'cost','branch','branch_id','x','z'));
    }

    public function income_statement_pdf(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
         $branch_id= $request->branch_id;

  $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           
            $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
             
                    if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;

        $pdf = PDF::loadView('financial_report.income_statement_pdf', compact('start_date','end_date','income','expense',
                'cost','branch_id','x','z'));

                  $s=  date('d-m-Y', strtotime($start_date));
                 $e=  date('d-m-Y', strtotime($end_date));
        return $pdf->download('INCOME STATEMENT  FOR THE PERIOD ' . $s . ' to '. $e. ".pdf");

    }

   public function income_statement_excel(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
         $branch_id= $request->branch_id;
         
         
          $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
         
         if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;
 
 
  $a=  trim(json_encode($x), '[]'); 
     if($branch_id == $a){
         $br_id=$x;
     }
     
     else{
         
      $br_id=$z;    
     }

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
        foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group){   
        foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code){

                     if(!empty($branch_id) && $branch_id != $a){
                        $cr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                             $cr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

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
  foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group){        
foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code){
  
               if(!empty($branch_id) && $branch_id != $a){
                        $cr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                             $cr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
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
         $branch_id= $request->branch_id;

   $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           
              $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
             
                    if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;

        $pdf = PDF::loadView('financial_report.income_statement_summary_pdf', compact('start_date','end_date','income','expense',
                'cost','branch_id','x','z'));

       $s=  date('d-m-Y', strtotime($start_date));
        $e=  date('d-m-Y', strtotime($end_date));
        return $pdf->download('INCOME STATEMENT SUMMARY  FOR THE PERIOD ' . $s . ' to '. $e. ".pdf");
    }

    public function income_statement_summary_excel(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
         $branch_id= $request->branch_id;
         
         
          $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
         
         if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;
 
 
  $a=  trim(json_encode($x), '[]'); 
     if($branch_id == $a){
         $br_id=$x;
     }
     
     else{
         
      $br_id=$z;    
     }

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
        foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group){   
        foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code){

                     if(!empty($branch_id) && $branch_id != $a){
                        $cr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                             $cr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

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
  foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group){        
foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code){
  
                if(!empty($branch_id) && $branch_id != $a){
                        $cr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                             $cr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $end_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

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
    $branch_id= $request->branch_id;
    
        $asset = ClassAccount::where('class_type','Assets')->where('added_by',auth()->user()->added_by)->get();
    $liability = ClassAccount::where('class_type','Liability')->where('added_by',auth()->user()->added_by)->get();
   $equity = ClassAccount::where('class_type','Equity')->where('added_by',auth()->user()->added_by)->get();

 $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           
            $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
            
            
         if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;

  if(!empty($start_date)){
          $net_profit = $this->get_netProfit($start_date,$end_date,$branch_id);
        }
else{
     $net_profit ='';      
}

$net_p = $this->get_netProfit2();
       return view('financial_report.balance_sheet',
            compact('start_date','income','expense',
                'cost' ,'end_date','asset','liability',
                'equity','net_p','net_profit','branch','branch_id','z','x'));
    }
    
       use Calculate_netProfitTrait;
     use Calculate_netProfitTrait2;
    public function balance_sheet_summary(Request $request)
    {  
       
         $start_date = $request->start_date;
   $end_date = $request->end_date;
    $branch_id= $request->branch_id;
    
          $asset = ClassAccount::where('class_type','Assets')->where('added_by',auth()->user()->added_by)->get();
    $liability = ClassAccount::where('class_type','Liability')->where('added_by',auth()->user()->added_by)->get();
   $equity = ClassAccount::where('class_type','Equity')->where('added_by',auth()->user()->added_by)->get();

 $income = ClassAccount::where('class_type','Income')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('added_by',auth()->user()->added_by)->get();
           
            $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
            
              if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;


  if(!empty($start_date)){
          $net_profit = $this->get_netProfit($start_date,$end_date,$branch_id);
        }
else{
     $net_profit ='';      
}

$net_p = $this->get_netProfit2();
       return view('financial_report.balance_sheet_summary',
            compact('start_date','income','expense',
                'cost' ,'end_date','asset','liability',
                'equity','net_p','net_profit','branch','branch_id','x','z'));
    }

  

    public function balance_sheet_pdf(Request $request)
    {
       
         $start_date = $request->start_date;
          $end_date = $request->end_date;
           $branch_id= $request->branch_id;

       $asset = ClassAccount::where('class_type','Assets')->where('added_by',auth()->user()->added_by)->get();
    $liability = ClassAccount::where('class_type','Liability')->where('added_by',auth()->user()->added_by)->get();
   $equity = ClassAccount::where('class_type','Equity')->where('added_by',auth()->user()->added_by)->get();
   
    $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
         
         if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;

if(!empty($start_date)){
          $net_profit = $this->get_netProfit($start_date,$end_date,$branch_id);
        }
else{
     $net_profit ='';      
}

        $pdf = PDF::loadView('financial_report.balance_sheet_pdf', compact('start_date',
             'asset','liability',
                'equity','net_profit','branch_id','x','z'));

         $s=  date('d-m-Y', strtotime($start_date));

return $pdf->download('BALANCE SHEET AS AT - '. $s. ".pdf");       

    }

   use Calculate_netProfitTrait;
     use Calculate_netProfitTrait2;
    public function balance_sheet_excel(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
         $branch_id = $request->branch_id;
         
         
          $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
         
         if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;
 
 
  $a=  trim(json_encode($x), '[]'); 
     if($branch_id == $a){
         $br_id=$x;
     }
     
     else{
         
      $br_id=$z;    
     }
       
        $s=  date('d-m-Y', strtotime($start_date));

        if (!empty($start_date)) {
          $net_profit = $this->get_netProfit($start_date,$end_date,$branch_id);

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


                    foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group){
                   foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code){

    
                         if(!empty($branch_id) && $branch_id != $a){
                        $cr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                              $cr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }


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

             foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group){
             foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code){
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

                        if(!empty($branch_id) && $branch_id != $a){
                        $cr_in = JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = JournalEntry::where('account_id',  $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = JournalEntry::where('account_id', $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                             $cr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = JournalEntry::where('account_id', $vat_out->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            

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

                          if(!empty($branch_id) && $branch_id != $a){
                        $cr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                              $cr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

                      if($account_code->account_name == 'Deffered Tax'){
                       $total_credit_liability  =   $total_credit_liability + ($cr1-$dr1) +$net_profit['tax_for_second_date'];
                          $total=  ($cr1-$dr1) +  $net_profit['tax_for_second_date'];;                  

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
             
              foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group){
              foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code){

                if(!empty($branch_id) && $branch_id != $a){
                        $cr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                              $cr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                     
                     
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
           $branch_id= $request->branch_id;

       $asset = ClassAccount::where('class_type','Assets')->where('added_by',auth()->user()->added_by)->get();
    $liability = ClassAccount::where('class_type','Liability')->where('added_by',auth()->user()->added_by)->get();
   $equity = ClassAccount::where('class_type','Equity')->where('added_by',auth()->user()->added_by)->get();
   
    $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
         
         if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;

if(!empty($start_date)){
          $net_profit = $this->get_netProfit($start_date,$end_date,$branch_id);
        }
else{
     $net_profit ='';      
}

        $pdf = PDF::loadView('financial_report.balance_sheet_summary_pdf', compact('start_date',
             'asset','liability',
                'equity','net_profit','branch_id','x','z'));

$s=  date('d-m-Y', strtotime($start_date));

        return $pdf->download('BALANCE SHEET SUMMARY AS AT ' . ' - ' . $request->start_date . ".pdf");
    }


 use Calculate_netProfitTrait;
     use Calculate_netProfitTrait2;
    public function balance_sheet_summary_excel(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $branch_id= $request->branch_id;
        
        
          $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
         
         if(!empty($branch[0])){
         
         foreach($branch as $br){
          $x[]=$br->id;
        
   
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;
 
 
  $a=  trim(json_encode($x), '[]'); 
     if($branch_id == $a){
         $br_id=$x;
     }
     
     else{
         
      $br_id=$z;    
     }

           $s=  date('d-m-Y', strtotime($start_date));

        if (!empty($start_date)) {
          $net_profit = $this->get_netProfit($start_date,$end_date,$branch_id);

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


                    foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group){
                   foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code){


                         if(!empty($branch_id) && $branch_id != $a){
                        $cr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                              $cr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }


                         $total_credit_assets +=($dr1-$cr1);                         


               
            }
}
}
            array_push($balance, [
               'Assets',
                number_format($total_credit_assets, 2)
            ]);



         

            foreach($liability->where('added_by',auth()->user()->added_by)  as $account_class){

             foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group){
             foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code){
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

                        if(!empty($branch_id) && $branch_id != $a){
                        $cr_in = JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = JournalEntry::where('account_id',  $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = JournalEntry::where('account_id', $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                             $cr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = JournalEntry::where('account_id', $vat_out->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

                            

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

                          if(!empty($branch_id) && $branch_id != $a){
                        $cr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                              $cr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

                      if($account_code->account_name == 'Deffered Tax'){
                       $total_credit_liability  =    $total_credit_liability + ($cr1-$dr1) +$net_profit['tax_for_second_date'];
                          $total=  ($cr1-$dr1) +  $net_profit['tax_for_second_date'];                 

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
             
              foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group){
              foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code){

                 if(!empty($branch_id) && $branch_id != $a){
                        $cr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                              $cr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 = JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                     
                     
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




public function reportModal(Request $request)
    {

          $id=$request->id;
          $start_date=$request->start_date;
          $second_date=$request->second_date;
          $end_date=$request->end_date;
          $branch_id= $request->branch_id;
          $type=$request->type;
          
          //dd($request->all());
          
          
          $income = ClassAccount::where('class_type','Income')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
           $cost = ClassAccount::where('class_type','Expense')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
           $expense= ClassAccount::where('class_type','Expense')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         
         $account_code=AccountCodes::find($id);
         $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
         
          if(!empty($branch[0])){
         foreach($branch as $br){
          $x[]=$br->id;
        
}
}


else{
   $x[]='';   
}
 
 $z[]=$branch_id;
 
 
  $a=  trim(json_encode($x), '[]'); 
     if($branch_id == $a){
         $br_id=$x;
     }
     
     else{
         
      $br_id=$z;    
     }
     
       switch ($type) {  
          
           case 'account':
                return view('financial_report.modal.account_modal',compact('id','start_date','end_date','second_date','branch_id','br_id','a','account_code'));
                break; 
                
                  case 'vat':
                return view('financial_report.modal.vat_modal',compact('id','start_date','end_date','second_date','branch_id','br_id','a','account_code'));
                break; 
                
                 case 'deff':
                      if(!empty($start_date)){
                    $net_profit = $this->get_netProfit($start_date,$second_date,$branch_id);
                        }
                    else{
                    $net_profit ='';      
                    }
 
                return view('financial_report.modal.deff_modal',compact('id','start_date','end_date','second_date','branch_id','br_id','a','account_code','net_profit'));
                break; 

                  case 'np':
                return view('financial_report.modal.np_modal',compact('id','start_date','end_date','second_date','branch_id','br_id','a','account_code','income','expense',
                'cost'));
                break; 
                
                 case 'class':
                $account_class = ClassAccount::where('added_by',auth()->user()->added_by)->where('id',$id)->first();
                 if(!empty($start_date)){
                  $net_profit = $this->get_netProfit($start_date,$second_date,$branch_id);
                }
                else{
                     $net_profit ='';      
                }
 
                return view('financial_report.modal.class_modal',compact('id','start_date','end_date','second_date','branch_id','br_id','a','account_code','income','expense',
                'cost','account_class','net_profit'));
                break; 
                
                 case 'income':
                return view('financial_report.modal.income_modal',compact('id','start_date','end_date','second_date','branch_id','br_id','a','account_code','income','expense',
                'cost'));
                break; 
                
                 case 'expenses':
                return view('financial_report.modal.expenses_modal',compact('id','start_date','end_date','second_date','branch_id','br_id','a','account_code','income','expense',
                'cost'));
                break;  
                
                 case 'b_account':
                return view('financial_report.modal.balance_account_modal',compact('id','start_date','end_date','second_date','branch_id','br_id','a','account_code'));
                break; 
                
                  case 'b_vat':
                return view('financial_report.modal.balance_vat_modal',compact('id','start_date','end_date','second_date','branch_id','br_id','a','account_code'));
                break; 
                
                
                 case 'b_class':
                $account_class = ClassAccount::where('added_by',auth()->user()->added_by)->where('id',$id)->first();
                 if(!empty($start_date)){
                  $net_profit = $this->get_netProfit($start_date,$second_date,$branch_id);
                }
                else{
                     $net_profit ='';      
                }
                
 
                return view('financial_report.modal.balance_class_modal',compact('id','start_date','end_date','second_date','branch_id','br_id','a','account_code','income','expense',
                'cost','account_class','net_profit'));
                break; 
                                    
     

 default:
             break;

            }
     
                

           
                  

                       }
       
       
       
   
    
    
     public function subscription(Request $request)
    {
       /*
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        */
        
        $account_id=$request->account_id;
        
        
        $chart_of_accounts = User::where('disabled','0')->whereColumn('added_by', 'id')->get();
        
        if($request->isMethod('post') || !empty($account_id)){
            
            $data=User_RolesCopy2::where('user_id', $request->account_id)->get();
         
         
        }else{
            $data=[];
        }
        return view('subscription.subscription',
            compact('chart_of_accounts','data','account_id'));
    }
      
      
       public function subscription_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        
        
        //$data = User::whereColumn('added_by', 'id')->get();
        
        $data = DB::table('users')->leftJoin('integration_deposits', 'integration_deposits.user_id','users.id')
                           ->whereBetween('integration_deposits.created_at',[$start_date,$end_date])
                          ->whereColumn('users.added_by', 'users.id')
                           ->select('users.*','integration_deposits.*')
                           ->groupBy('integration_deposits.user_id')
                             ->get() ;
                             
                            //dd ($data);
                            
            
        
        return view('subscription.subscription_report',
            compact('start_date',
                'end_date','data'));
    }
    
    
     public function expired_users(Request $request)
    {
       
         $today = date('Y-m-d');
 
        $data=User_RolesCopy2::where('due_date','<',$today)->get();
         
        
        return view('subscription.expired_users',compact('data'));
    }
    
     public function discountModal(Request $request)
    {
              $id=$request->id;
                 $type = $request->type;

          switch ($type) {      

        case 'price':
        $data = User_RolesCopy2::find($id);
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        return view('subscription.adjust',compact('end_date','start_date','id','data'));
                    break;
                    
        case 'sms':
        $data = User_RolesCopy2::find($id);
        return view('subscription.sms',compact('id','data'));
                    break; 
                    
          case 'deposit':
        $data = User_RolesCopy2::find($id);
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         
        return view('subscription.add_deposit',compact('end_date','start_date','id','data','bank_accounts'));
                    break;            
   
         default:
             break;

            }


  
                 }
                 
                 
                   
  public function adjust(Request $request)
    {
        //
     $id=$request->id;
     $start_date = $request->start_date;
     $end_date = $request->end_date;
    
    
     $day = str_replace(",","",$request->day);
     $month = str_replace(",","",$request->month);
     $year = str_replace(",","",$request->year);
     $date = $request->due_date  ;

        $purchase = User_RolesCopy2::find($id);
         $account_id=$purchase->user_id;
        $chk= User_Roles::where('user_id', $purchase->user_id)->where('role_id', $purchase->role_id)->first();
       
        if(empty($chk)){
        
                        User_Roles::insert([
                            'user_id' => $purchase->user_id,
                            'role_id' => $purchase->role_id,
                        ]);
        }
        
        if($purchase->due_date !=  $date){
            
            $datetime1 = new DateTime($purchase->due_date);
            $datetime2 = new DateTime($date);

            $difference = $datetime1->diff($datetime2);
            
            if($difference->y > 0 && $difference->m > 0 && $difference->d > 0){
            $xx= $difference->y.' years , '.$difference->m.' months and '.$difference->d.' days';
            }
            else if($difference->y > 0 && $difference->m == 0 && $difference->d > 0){
    		$xx=$difference->y.' years and '.$difference->d.' days';
            }
            else if($difference->y > 0 && $difference->m > 0 && $difference->d == 0){
    		$xx=$difference->y.' years and '.$difference->m.' months';
            }
           else if($difference->y > 0 && $difference->m == 0 && $difference->d == 0){
              $xx=$difference->y.' years';  
            }
            
            else if($difference->y == 0 && $difference->m > 0 && $difference->d > 0){
                $xx=$difference->m.' months and '.$difference->d.' days';
            }
            else if($difference->y == 0 && $difference->m > 0 && $difference->d == 0){
            $xx=$difference->m.' months';  
                        }
            else if($difference->y == 0 && $difference->m == 0 && $difference->d > 0){
            $xx=$difference->d.' days';  
                        }            

            //dd($xx);
            $dlist['user_id']=$purchase->user_id;
             $dlist['role_id']=$purchase->role_id;
             $dlist['old_date']=$purchase->due_date;
             $dlist['new_date']=$date;
             $dlist['duration']=$xx;
             $dlist['reason']='cash';
             $dlist['added_by']=$purchase->user_id;
             //dd($dlist);
            DueDate::create($dlist); 
            
                }

                           $lists= array(
                             'day' =>   $day,
                            'month' =>   $month,
                            'year' =>   $year,
                             'due_date' =>  $date);
                           
                        $purchase->update($lists); 
                        
                        
        $user_info=User::find($purchase->user_id);
         $user_info->update(['mobile_status'=>'active']);
         
         
           $activated_roleToRun = $purchase->role_id;
            
            $rolesunderToUpadte = Role::where('added_by', $user_info->added_by)->get();
            
            if($rolesunderToUpadte->isNotEmpty()){
                
                foreach($rolesunderToUpadte as $underRolesToUpadte){
                        
                        $role_idToUpdate = $underRolesToUpadte->id;
                
                        $queryToRun = "UPDATE roles_permissions rp set rp.status = 1 WHERE  rp.role_id = '".$role_idToUpdate."' and rp.permission_id IN (SELECT permission_id from roles_permissions where roles_permissions.role_id = '".$activated_roleToRun."')";
                        
                        $rowDatampya = DB::insert(DB::raw($queryToRun));
                        
                        // dd($rowDatampya);
                
                    }
                
                
            }


      
    return redirect(route('subscription',['start_date'=>$start_date,'end_date'=>$end_date,'account_id'=>$account_id]))->with(['success'=>'Adjusted Successfully']);

            

    }
           
           
           
    public function send_sms(Request $request)
    {
        //
    
         $items = array(
         'user_id' => $request->id ,
         'message' =>$request->message ,
         'phone' =>$request->phone ,
         'date' => date('Y-m-d') ,
         'status' => 0 ,
         'sent_by'=>auth()->user()->id,
         'added_by'=>auth()->user()->added_by);
         
         $a= DB::table('expire_messages')->insertGetId($items);
         
         //dd($a);
          

        $key="3b3e9650a2888de375cb46b285b4bea6e3a797e4";
        $number = $request->phone;
        $message = $request->message;
          
        $option11 = 1;
        $type = "sms";
        $useRandomDevice = 1;
        $prioritize = 1;

      $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&option=1&type=sms&prioritize=0 ")->json();
      
      if(!empty($response)){       
        DB::table('expire_messages')->where('id',$a)->update(['status' => 1]);
      }
     
    return redirect(route('expired_users'))->with(['success'=>'Sent Successfully']);

            

    }  
    
    
      public function deposit()
    {
       
       $roles = Role::where('status','1')->get()  ;
                              
                              //dd($role);
                              
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $client=User::where('disabled','0')->whereColumn('added_by', 'id')->get();                    
      
       return view('subscription.deposit',compact('client','roles','bank_accounts'));
    

    }
    
    
    
      public function save_deposit(Request $request)
    {
        
         $id=$request->id;
         $start_date = $request->start_date;
         $end_date = $request->end_date;
       
        $amount = str_replace(",","",$request->amount);
        
         $checkusrRoleCopy2=User_RolesCopy2::where('user_id', $request->client_id)->where('role_id', $request->role_id)->first();
         if(!empty($checkusrRoleCopy2)){
                      
                      $prc = Role::find($request->role_id);
                      
                      //daily
                      if($checkusrRoleCopy2->day <= $amount && $amount <  $checkusrRoleCopy2->month ){
                        $x=$amount/ $checkusrRoleCopy2->day;
                         $due_date=floor($x);;
                               
                               $nowDT = Carbon::now();
                                $due_dateOld = Carbon::createFromFormat('Y-m-d',  $checkusrRoleCopy2->due_date); 
                                
                                // dd($due_dateOld);
                                
                                if($due_dateOld > $nowDT)
                                {
                                    $now = $due_dateOld;
                                }
                                else{
                                    
                                    $now = $nowDT;
                                    
                                }
                            
                                       
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                            $xx=$due_date.' days';;
                             //dd($xx);
                             
                   
                    }
                        
                        //monthly
                       else if($checkusrRoleCopy2->month <= $amount && $amount <  $checkusrRoleCopy2->year ){
                        $x=$amount/ $checkusrRoleCopy2->month;
                         $due_date=ceil($x * 30.436875);
                          $y=0;
       
                        $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31) 
                		$m = floor($m); // Remove
                
                		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
                	    $d = floor($d); // the rest of days
                        
                        if($m > 0 && $d > 0){
                		$xx=$m.' months and '.$d.' days';
                        }
                        else if($m > 0 && $d== 0){
                          $xx=$m.' months';  
                        }
                               
                               $nowDT = Carbon::now();
                                $due_dateOld = Carbon::createFromFormat('Y-m-d',  $checkusrRoleCopy2->due_date); 
                                
                                // dd($due_dateOld);
                                
                                if($due_dateOld > $nowDT)
                                {
                                    $now = $due_dateOld;
                                }
                                else{
                                    
                                    $now = $nowDT;
                                    
                                }
                            
                                     
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                           
                             //dd($xx);
                             
                   
                    }
                    
                    //yearly
                    else if($amount >= $checkusrRoleCopy2->year ){
                        $x=$amount/ $checkusrRoleCopy2->year;
                         $ii=floor($x);;
                         
                         $rem=$amount - ($ii * $checkusrRoleCopy2->year);
            
                            $nd=0;
                           
                            if($rem > 0){
                                
                            if($checkusrRoleCopy2->day <= $rem && $rem < $checkusrRoleCopy2->month ){
                            $rx=$rem/$checkusrRoleCopy2->day;
                            $nd=floor($rx);
                        }
                        
                         else if($checkusrRoleCopy2->month <= $rem && $rem < $checkusrRoleCopy2->year ){
                            $rx=$rem/$checkusrRoleCopy2->month;
                            $nd=ceil($rx * 30.436875);
                           
                                
                        } 
                            
                               
                            }
                            
                            $due_date=($ii * 365) + $nd;
                            //dd($nd);
        
                            $y = ($due_date / 365) ; // days / 365 days
                    		$y = floor($y); // Remove all decimals
                                
                           $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31) 
                    		$m = floor($m); // Remove
                    
                    		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
                    		$d = floor($d); // the rest of days
                    
                            if($y > 0 && $m > 0 && $d > 0){
                            $xx= $y.' years , '.$m.' months and '.$d.' days';
                            }
                            else if($y > 0 && $m == 0 && $d > 0){
                    		$xx=$y.' years and '.$d.' days';
                            }
                            else if($y > 0 && $m > 0 && $d == 0){
                    		$xx=$y.' years and '.$m.' months';
                            }
                           else if($y > 0 && $m == 0 && $d == 0){
                              $xx=$y.' years';  
                            }
                                                   
                               $nowDT = Carbon::now();
                                $due_dateOld = Carbon::createFromFormat('Y-m-d',  $checkusrRoleCopy2->due_date); 
                                
                                // dd($due_dateOld);
                                
                                if($due_dateOld > $nowDT)
                                {
                                    $now = $due_dateOld;
                                }
                                else{
                                    
                                    $now = $nowDT;
                                    
                                }
                            
                                         
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                          
                             //dd($xx);
                             
                   
                    }
                               
                                
                              
                                     $dlist['user_id']=$checkusrRoleCopy2->user_id;
                                     $dlist['role_id']=$checkusrRoleCopy2->role_id;
                                     $dlist['old_date']=$now;
                                     $dlist['new_date']=$due_dateNew;
                                     $dlist['duration']=$xx;
                                     $dlist['reason']='cash';
                                     $dlist['added_by']=$checkusrRoleCopy2->user_id;
                                     //dd($dlist);
                                    DueDate::create( $dlist);  
                          
                           User_RolesCopy2::find($checkusrRoleCopy2->id)->update([
                                'user_id' => $checkusrRoleCopy2->user_id,
                                'role_id' => $checkusrRoleCopy2->role_id,
                                'day' => $checkusrRoleCopy2->day,
                                'month' => $checkusrRoleCopy2->month,
                                'year' => $checkusrRoleCopy2->year,
                                'disabled' => 0,
                                'due_date' => $due_dateNew
                            ]);
                            
                            User::find($checkusrRoleCopy2->user_id)->update([
                                'due_date' => $due_dateNew,
                                'mobile_status'=>'active'
                            ]);
                      
                      
                  }
                  else{
                      
                      $prc = Role::find($request->role_id);
                        
                                    //daily
                      if($prc->day <= $amount && $amount <  $prc->month ){
                        $x=$amount/ $prc->day;
                         $due_date=floor($x);;
                               
                               $now = Carbon::now();       
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                            $xx=$due_date.' days';;
                             //dd($xx);
                             
                   
                    }
                        
                        //monthly
                       else if($prc->month <= $amount && $amount <  $prc->year ){
                        $x=$amount/ $prc->month;
                         $due_date=ceil($x * 30.436875);
                          $y=0;
       
                        $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31) 
                		$m = floor($m); // Remove
                
                		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
                	    $d = floor($d); // the rest of days
                        
                        if($m > 0 && $d > 0){
                		$xx=$m.' months and '.$d.' days';
                        }
                        else if($m > 0 && $d== 0){
                          $xx=$m.' months';  
                        }
                               
                               $now = Carbon::now();     
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                           
                             //dd($xx);
                             
                   
                    }
                    
                    //yearly
                    else if($amount >= $prc->year ){
                        $x=$amount/ $prc->year;
                         $ii=floor($x);;
                         
                         $rem=$amount - ($ii * $prc->year);
            
                            $nd=0;
                           
                            if($rem > 0){
                                
                            if($prc->day <= $rem && $rem < $prc->month ){
                            $rx=$rem/$prc->day;
                            $nd=floor($rx);
                        }
                        
                         else if($prc->month <= $rem && $rem < $prc->year ){
                            $rx=$rem/$prc->month;
                            $nd=ceil($rx * 30.436875);
                           
                                
                        } 
                            
                               
                            }
                            
                            $due_date=($ii * 365) + $nd;
        
                            $y = ($due_date / 365) ; // days / 365 days
                    		$y = floor($y); // Remove all decimals
                                
                           $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31)
                    		$m = floor($m); // Remove
                    
                    		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
                    		$d = floor($d); // the rest of days
                    
                            if($y > 0 && $m > 0 && $d > 0){
                            $xx= $y.' years , '.$m.' months and '.$d.' days';
                            }
                            else if($y > 0 && $m == 0 && $d > 0){
                    		$xx=$y.' years and '.$d.' days';
                            }
                            else if($y > 0 && $m > 0 && $d == 0){
                    		$xx=$y.' years and '.$m.' months';
                            }
                           else if($y > 0 && $m == 0 && $d == 0){
                              $xx=$y.' years';  
                            }
                                                   
                               $now = Carbon::now();
                                    
                            $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                          
                             //dd($xx);
                             
                   
                    }
                                
                                  $dlist['user_id']=$request->client_id;
                                     $dlist['role_id']=$request->role_id;
                                     $dlist['old_date']=$now;
                                     $dlist['new_date']=$due_dateNew;
                                     $dlist['duration']=$xx;
                                     $dlist['reason']='cash';
                                     $dlist['added_by']=$request->client_id;
                                     //dd($dlist);
                                    DueDate::create( $dlist); 
            
                            $usrRoles = User_RolesCopy2::create([
                                'user_id' => $request->client_id,
                                'role_id' => $request->role_id,
                                'day' => $prc->day,
                                 'month' => $prc->month,
                                  'year' => $prc->year,
                                'disabled' => 0,
                                'due_date' =>  $due_dateNew,
                            ]);
                            
                            User::find($request->client_id)->update([
                                'due_date' =>  $due_dateNew,
                                'mobile_status'=>'active'
                            ]);
                      
                  }
                  
                  
                  
                $chk= User_Roles::where('user_id', $request->client_id)->where('role_id', $request->role_id)->first();
       
        if(empty($chk)){
        
                        User_Roles::insert([
                            'user_id' => $request->client_id,
                            'role_id' => $request->role_id,
                        ]);
        }
                  
             
         
          $activated_roleToRun = $request->role_id;
            
            $rolesunderToUpadte = Role::where('added_by', $request->user_id)->get();
            
            if($rolesunderToUpadte->isNotEmpty()){
                
                foreach($rolesunderToUpadte as $underRolesToUpadte){
                        
                        $role_idToUpdate = $underRolesToUpadte->id;
                
                        $queryToRun = "UPDATE roles_permissions rp set rp.status = 1 WHERE  rp.role_id = '".$role_idToUpdate."' and rp.permission_id IN (SELECT permission_id from roles_permissions where roles_permissions.role_id = '".$activated_roleToRun."')";
                        
                        $rowDatampya = DB::insert(DB::raw($queryToRun));
                        
                        // dd($rowDatampya);
                
                    }
                
                
            }     
            
            
             $u=User::where('id', $request->client_id)->first();
               $admin=User::where('email','info@ujuzinet.com')->first();
               $aa=Role::find($request->role_id);
               $dd=date('d/m/Y', strtotime($due_dateNew));
               $cc= $xx;
               
               //dd($cc);
                 $notif = array(
                      'name' => 'User Subscription',
                      'description' =>'Dear ' .$u->name .', You have paid for '.$aa->slug.' package for '. $cc.' . Your Subscription period will end on '. $dd  ,
                      'date' =>   date('Y-m-d'),
                      'to_user_id' => $u->id,
                      'added_by' => $u->id);
                       
                        Notification::create($notif);  ;
                        
                        
                        $ema_notif = array(
                        'name' => 'User Subscription',
                        'description' =>'User ' .$u->name .', has paid for '.$aa->slug.' package for '. $cc.' . Subscription period will end on '. $dd  ,
                        'date' =>   date('Y-m-d'),
                        'from_user_id' => $admin->id,
                        'to_user_id' => $u->id,
                         'added_by' => $admin->added_by);
                       
                        Notification::create($ema_notif);  ;
                        
                        
                        
                         $admin_notif = array(
                        'name' => 'User Subscription',
                        'description' =>'User ' .$u->name .', has paid for '.$aa->slug.' package for '. $cc.' . Subscription period will end on '. $dd  ,
                        'date' =>   date('Y-m-d'),
                        'from_user_id' => '1',
                        'to_user_id' => $u->id,
                         'added_by' => '1');
                       
                        Notification::create($admin_notif);  ;
      
      
      
                  //shule  accounting -management
        if($request->role_id == 55 || $request->role_id == 64  ){
                
                //for school roles 
                
                 $sql="SELECT * FROM gl_account_group_school WHERE name NOT IN(SELECT name FROM gl_account_group WHERE added_by = '".$request->client_id."')";
                $account_groupSchoolOld = DB::select($sql);
        
                   if(count($account_groupSchoolOld) > 0){
                       
                foreach($account_groupSchoolOld as $row){
            
                 $class=ClassAccount::where('class_name', $row->class)->where('added_by',$request->client_id)->first();
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$request->client_id)->latest('id')->first();
                if(!empty($before)){
                  $group_id =    $before->group_id +100;
                  $group_order = $before->order_no +1;  
                }
                
                else{
                    $group_id=    $class->class_id +100;
                    $group_order = '0'; 
                }
                
                DB::table('gl_account_group')->insert([
                    
                    'group_id' => $group_id,
                    'name' => $row->name,
                    'class' => $class->id,
                    'type' => $row->type,
                    'order_no' => $group_order,
                    'added_by' => $request->client_id,
                    'edited' => $row->edited,
                    'disabled' => $row->disabled,
                    
                    
                ]);
                
            
                }
                
                   }
                   
               
                 $sql_codes="SELECT * FROM gl_account_codes_school WHERE account_name NOT IN(SELECT account_name FROM gl_account_codes WHERE added_by = '".$request->client_id."')";
  
                $account_codesSchoolOld = DB::select($sql_codes);
                
                if(count($account_codesSchoolOld) > 0){
                
                foreach($account_codesSchoolOld as $row){
                    
                    $group=GroupAccount::where('name', $row->account_group)->where('added_by',$request->client_id)->first();
                     if(!empty($group)){
                         
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$request->client_id)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                        
                    $cID =    DB::table('gl_account_codes')->insertGetId([
                            
                            'account_codes' => $codes,
                            'account_name' => $row->account_name,
                            'account_group' => $group->id,
                            'account_type' => $row->account_type,
                            'account_status' => $status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $code_order,
                            'edited' => $row->edited,
                            'disabled' => $row->disabled,
                            'added_by' => $request->client_id,
                            
                        ]);
                        
                        $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);
                        
                     }   
                     
                     else{
                        $cID =   DB::table('gl_account_codes')->insertGetId([
                        
                        'account_codes' => $row->account_codes,
                        'account_name' => $row->account_name,
                        'account_group' => $row->account_group,
                        'account_type' => $row->account_type,
                        'account_status' => $row->account_status,
                        'allow_manual' => $row->allow_manual,
                        'account_id' => $row->account_id,
                        'order_no' => $row->order_no,
                        'edited' => $row->edited,
                        'disabled' => $row->disabled,
                        'added_by' => $request->client_id,
                        
                    ]);
                    
                    
                    $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);  
                     }
                     
                    
                     
                    
                }
                }      
               
        
        }
        
        
        //manufacture
        
        elseif($request->role_id == 72 || $request->role_id == 46  ){
                
                //for school roles 
                
                 $sql="SELECT * FROM gl_account_group_manufact WHERE name NOT IN(SELECT name FROM gl_account_group WHERE added_by = '".$request->client_id."')";
                $account_groupSchoolOld = DB::select($sql);
        
                   if(count($account_groupSchoolOld) > 0){
                       
                foreach($account_groupSchoolOld as $row){
            
                 $class=ClassAccount::where('class_name', $row->class)->where('added_by',$request->client_id)->first();
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$request->client_id)->latest('id')->first();
                if(!empty($before)){
                  $group_id =    $before->group_id +100;
                  $group_order = $before->order_no +1;  
                }
                
                else{
                    $group_id=    $class->class_id +100;
                    $group_order = '0'; 
                }
                
                DB::table('gl_account_group')->insert([
                    
                    'group_id' => $group_id,
                    'name' => $row->name,
                    'class' => $class->id,
                    'type' => $row->type,
                    'order_no' => $group_order,
                    'added_by' => $request->client_id,
                    'edited' => $row->edited,
                    'disabled' => $row->disabled,
                    
                    
                ]);
                
            
                }
                
                   }
                   
               
                 $sql_codes="SELECT * FROM gl_account_codes_manufact WHERE account_name NOT IN(SELECT account_name FROM gl_account_codes WHERE added_by = '".$request->client_id."')";
  
                $account_codesSchoolOld = DB::select($sql_codes);
                
                if(count($account_codesSchoolOld) > 0){
                
                foreach($account_codesSchoolOld as $row){
                    
                    $group=GroupAccount::where('name', $row->account_group)->where('added_by',$request->client_id)->first();
                     if(!empty($group)){
                         
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$request->client_id)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                        
                    $cID =    DB::table('gl_account_codes')->insertGetId([
                            
                            'account_codes' => $codes,
                            'account_name' => $row->account_name,
                            'account_group' => $group->id,
                            'account_type' => $row->account_type,
                            'account_status' => $status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $code_order,
                            'edited' => $row->edited,
                            'disabled' => $row->disabled,
                            'added_by' => $request->client_id,
                            
                        ]);
                        
                        $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);
                        
                     }   
                     
                     else{
                        $cID =   DB::table('gl_account_codes')->insertGetId([
                        
                        'account_codes' => $row->account_codes,
                        'account_name' => $row->account_name,
                        'account_group' => $row->account_group,
                        'account_type' => $row->account_type,
                        'account_status' => $row->account_status,
                        'allow_manual' => $row->allow_manual,
                        'account_id' => $row->account_id,
                        'order_no' => $row->order_no,
                        'edited' => $row->edited,
                        'disabled' => $row->disabled,
                        'added_by' => $request->client_id,
                        
                    ]);
                    
                    
                    $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);  
                     }
                     
                    
                     
                    
                }
                }      
               
        
        }
        
        
        //courier
        
        elseif($request->role_id == 34 ){
                
                //for school roles 
                
                 $sql="SELECT * FROM gl_account_group_cour WHERE name NOT IN(SELECT name FROM gl_account_group WHERE added_by = '".$request->client_id."')";
                $account_groupSchoolOld = DB::select($sql);
        
                   if(count($account_groupSchoolOld) > 0){
                       
                foreach($account_groupSchoolOld as $row){
            
                 $class=ClassAccount::where('class_name', $row->class)->where('added_by',$request->client_id)->first();
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$request->client_id)->latest('id')->first();
                if(!empty($before)){
                  $group_id =    $before->group_id +100;
                  $group_order = $before->order_no +1;  
                }
                
                else{
                    $group_id=    $class->class_id +100;
                    $group_order = '0'; 
                }
                
                DB::table('gl_account_group')->insert([
                    
                    'group_id' => $group_id,
                    'name' => $row->name,
                    'class' => $class->id,
                    'type' => $row->type,
                    'order_no' => $group_order,
                    'added_by' => $request->client_id,
                    'edited' => $row->edited,
                    'disabled' => $row->disabled,
                    
                    
                ]);
                
            
                }
                
                   }
                   
               
                 $sql_codes="SELECT * FROM gl_account_codes_courier WHERE account_name NOT IN(SELECT account_name FROM gl_account_codes WHERE added_by = '".$request->client_id."')";
  
                $account_codesSchoolOld = DB::select($sql_codes);
                
                if(count($account_codesSchoolOld) > 0){
                
                foreach($account_codesSchoolOld as $row){
                    
                    $group=GroupAccount::where('name', $row->account_group)->where('added_by',$request->client_id)->first();
                     if(!empty($group)){
                         
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$request->client_id)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                        
                    $cID =    DB::table('gl_account_codes')->insertGetId([
                            
                            'account_codes' => $codes,
                            'account_name' => $row->account_name,
                            'account_group' => $group->id,
                            'account_type' => $row->account_type,
                            'account_status' => $status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $code_order,
                            'edited' => $row->edited,
                            'disabled' => $row->disabled,
                            'added_by' => $request->client_id,
                            
                        ]);
                        
                        $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);
                        
                     }   
                     
                     else{
                        $cID =   DB::table('gl_account_codes')->insertGetId([
                        
                        'account_codes' => $row->account_codes,
                        'account_name' => $row->account_name,
                        'account_group' => $row->account_group,
                        'account_type' => $row->account_type,
                        'account_status' => $row->account_status,
                        'allow_manual' => $row->allow_manual,
                        'account_id' => $row->account_id,
                        'order_no' => $row->order_no,
                        'edited' => $row->edited,
                        'disabled' => $row->disabled,
                        'added_by' => $request->client_id,
                        
                    ]);
                    
                    
                    $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);  
                     }
                     
                    
                     
                    
                }
                }      
               
        
        }
        
        //logistic
        
        elseif($request->role_id == 13 ){
                
                //for school roles 
                
                 $sql="SELECT * FROM gl_account_grouplogis WHERE name NOT IN(SELECT name FROM gl_account_group WHERE added_by = '".$request->client_id."')";
                $account_groupSchoolOld = DB::select($sql);
        
                   if(count($account_groupSchoolOld) > 0){
                       
                foreach($account_groupSchoolOld as $row){
            
                 $class=ClassAccount::where('class_name', $row->class)->where('added_by',$request->client_id)->first();
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$request->client_id)->latest('id')->first();
                if(!empty($before)){
                  $group_id =    $before->group_id +100;
                  $group_order = $before->order_no +1;  
                }
                
                else{
                    $group_id=    $class->class_id +100;
                    $group_order = '0'; 
                }
                
                DB::table('gl_account_group')->insert([
                    
                    'group_id' => $group_id,
                    'name' => $row->name,
                    'class' => $class->id,
                    'type' => $row->type,
                    'order_no' => $group_order,
                    'added_by' => $request->client_id,
                    'edited' => $row->edited,
                    'disabled' => $row->disabled,
                    
                    
                ]);
                
            
                }
                
                   }
                   
               
                 $sql_codes="SELECT * FROM gl_account_codeslogis WHERE account_name NOT IN(SELECT account_name FROM gl_account_codes WHERE added_by = '".$request->client_id."')";
  
                $account_codesSchoolOld = DB::select($sql_codes);
                
                if(count($account_codesSchoolOld) > 0){
                
                foreach($account_codesSchoolOld as $row){
                    
                    $group=GroupAccount::where('name', $row->account_group)->where('added_by',$request->client_id)->first();
                     if(!empty($group)){
                         
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$request->client_id)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                        
                    $cID =    DB::table('gl_account_codes')->insertGetId([
                            
                            'account_codes' => $codes,
                            'account_name' => $row->account_name,
                            'account_group' => $group->id,
                            'account_type' => $row->account_type,
                            'account_status' => $status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $code_order,
                            'edited' => $row->edited,
                            'disabled' => $row->disabled,
                            'added_by' => $request->client_id,
                            
                        ]);
                        
                        $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);
                        
                     }   
                     
                     else{
                        $cID =   DB::table('gl_account_codes')->insertGetId([
                        
                        'account_codes' => $row->account_codes,
                        'account_name' => $row->account_name,
                        'account_group' => $row->account_group,
                        'account_type' => $row->account_type,
                        'account_status' => $row->account_status,
                        'allow_manual' => $row->allow_manual,
                        'account_id' => $row->account_id,
                        'order_no' => $row->order_no,
                        'edited' => $row->edited,
                        'disabled' => $row->disabled,
                        'added_by' => $request->client_id,
                        
                    ]);
                    
                    
                    $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);  
                     }
                     
                    
                     
                    
                }
                }      
               
        
        }
               
        //else
        
        else{
                
                //for school roles 
                
                 $sql="SELECT * FROM gl_account_groupOld WHERE name NOT IN(SELECT name FROM gl_account_group WHERE added_by = '".$request->client_id."')";
                $account_groupSchoolOld = DB::select($sql);
        
                   if(count($account_groupSchoolOld) > 0){
                       
                foreach($account_groupSchoolOld as $row){
            
                 $class=ClassAccount::where('class_name', $row->class)->where('added_by',$request->client_id)->first();
                 
                //dd($row->class);
                 
                 $before=GroupAccount::where('class',$class->id)->where('added_by',$request->client_id)->latest('id')->first();
                if(!empty($before)){
                  $group_id =    $before->group_id +100;
                  $group_order = $before->order_no +1;  
                }
                
                else{
                    $group_id=    $class->class_id +100;
                    $group_order = '0'; 
                }
                
                DB::table('gl_account_group')->insert([
                    
                    'group_id' => $group_id,
                    'name' => $row->name,
                    'class' => $class->id,
                    'type' => $row->type,
                    'order_no' => $group_order,
                    'added_by' => $request->client_id,
                    'edited' => $row->edited,
                    'disabled' => $row->disabled,
                    
                    
                ]);
                
            
                }
                
                   }
                   
               
                 $sql_codes="SELECT * FROM gl_account_codesOld WHERE account_name NOT IN(SELECT account_name FROM gl_account_codes WHERE added_by = '".$request->client_id."')";
  
                $account_codesSchoolOld = DB::select($sql_codes);
                
                if(count($account_codesSchoolOld) > 0){
                
                foreach($account_codesSchoolOld as $row){
                    
                    $group=GroupAccount::where('name', $row->account_group)->where('added_by',$request->client_id)->first();
                     if(!empty($group)){
                         
                     if($row->account_group == 'Cash and Cash Equivalent'){
                    $status='Bank';
                        }
                    else{
                    $status='Non Bank'; 
                        }
                    
                    $before=AccountCodes::where('account_group', $group->id)->where('added_by',$request->client_id)->latest('id')->first();
                    if(!empty($before)){
                      $codes =    $before->account_codes +1;
                     $code_order = $before->order_no +1;
            
                                }
                                else{
                        $codes = $group->group_id +1;
                     $code_order = '0';

                                        }
                        
                    $cID =    DB::table('gl_account_codes')->insertGetId([
                            
                            'account_codes' => $codes,
                            'account_name' => $row->account_name,
                            'account_group' => $group->id,
                            'account_type' => $row->account_type,
                            'account_status' => $status,
                            'allow_manual' => $row->allow_manual,
                            'account_id' => $row->account_id,
                            'order_no' => $code_order,
                            'edited' => $row->edited,
                            'disabled' => $row->disabled,
                            'added_by' => $request->client_id,
                            
                        ]);
                        
                        $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);
                        
                     }   
                     
                     else{
                        $cID =   DB::table('gl_account_codes')->insertGetId([
                        
                        'account_codes' => $row->account_codes,
                        'account_name' => $row->account_name,
                        'account_group' => $row->account_group,
                        'account_type' => $row->account_type,
                        'account_status' => $row->account_status,
                        'allow_manual' => $row->allow_manual,
                        'account_id' => $row->account_id,
                        'order_no' => $row->order_no,
                        'edited' => $row->edited,
                        'disabled' => $row->disabled,
                        'added_by' => $request->client_id,
                        
                    ]);
                    
                    
                    $update_details = array(
                            'account_id' => $cID
                        );
                        
                        DB::table('gl_account_codes')
                            ->where('id', $cID)
                            ->update($update_details);  
                     }
                     
                    
                     
                    
                }
                }      
               
        
        }
                      
                  
         
            $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(5/strlen($x)) )),1,5);
            $account= AccountCodes::where('account_name','Sales')->where('added_by', auth()->user()->added_by)->first();
            $client=User::find($request->client_id);
            $role=Role::find($request->role_id);
            $deposit = new Deposit();
            $deposit->name = 'Subscription Payment';
            $deposit->amount = $amount ;
            $deposit->date  = $request->date  ;
            $deposit->account_id  = $account->id ;
            $deposit->bank_id  = $request->bank_id ;
            $deposit->notes  = 'Subscription Payment from ' .$client->name .' for '. $role->slug ;
            $deposit->status  = '1' ;
            $deposit->trans_id = "DEP".$random;
            $deposit->type=' Deposit';
            $deposit->client_id  = $request->client_id ;
            $deposit->added_by = auth()->user()->added_by;
            $deposit->save();
            
            
        $journal = new JournalEntry();
        $journal->account_id = $deposit->bank_id;
        $date = explode('-',  $deposit->date);
        $journal->date = $deposit->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'deposit';
        $journal->name = 'Deposit Payment';
        $journal->payment_id =    $deposit->id;
        $journal->notes= 'Deposit Payment for Subscription Payment from ' .$client->name .' for '. $role->slug ;
        $journal->debit=    $deposit->amount ;
         $journal->added_by=auth()->user()->added_by;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id =    $deposit->account_id;
         $date = explode('-',  $deposit->date);
        $journal->date = $deposit->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'deposit';
        $journal->name = 'Deposit Payment';
        $journal->payment_id =    $deposit->id;
        $journal->notes= 'Deposit Payment for Subscription Payment from ' .$client->name .' for '. $role->slug ;
        $journal->credit=   $deposit->amount ;
         $journal->added_by=auth()->user()->added_by;
        $journal->save();
         
      
      if($request->type == 'subscription'){
            return redirect(route('subscription',['start_date'=>$start_date,'end_date'=>$end_date,'account_id'=>$request->client_id]))->with(['success'=>'Deposited Successfully']);
      } 
      
      else{
    return redirect(route('subscription.deposit'))->with(['success'=>'Deposited Successfully']);
      }
   

    }

    public function index(Request $request)
    {
       
       
    

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
