<?php
namespace App\Traits;

use App\Models\ClassAccount;
use App\Models\GroupAccount;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Branch;

trait Calculate_Balance {
    
public static function get_amount($start_date=null,$branch_id=null,$account_id=null){
    
$cr1 = 0;
$dr1 = 0;
$cr = 0;
$dr = 0; 
$cr_in = 0;
$dr_in = 0;                   
$cr_out  = 0;
$dr_out  = 0;
$total_out=0;
$total_in=0;
$credit = 0;
$debit = 0; 


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
        
        

    $account_code= AccountCodes::where('id',$account_id)->where('added_by',auth()->user()->added_by)->where('disabled','0')->first();


if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)' && $account_code->account_codes != '31101')
{
     
     
                           if(!empty($branch_id) && $branch_id != $a){
                        $cr1 =JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 =JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                              $cr1 =JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 =JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            
                        
                        if ($account_code->account_type == 'Assets'){
                            $debit = $dr1-$cr1 ;
                             $credit= 0 ;
                        }
                        elseif ($account_code->account_type == 'Liability'){
                             $debit= 0 ;
                            $credit= $cr1-$dr1 ;
                        }
                         elseif ($account_code->account_type == 'Equity'){
                              $debit= 0 ;
                            $credit= $cr1-$dr1 ;
                        }
                       
                            
                            
     
}

elseif($account_code->account_name == 'Value Added Tax (VAT)'){
   
                       
                             
                      
                        $vat_in= AccountCodes::where('account_name', 'VAT IN')->where('added_by',auth()->user()->added_by)->first();
                        $vat_out= AccountCodes::where('account_name', 'VAT OUT')->where('added_by',auth()->user()->added_by)->first();
                        
                          if(!empty($branch_id) && $branch_id != $a){
                       $cr_in = JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = JournalEntry::where('account_id',  $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = JournalEntry::where('account_id', $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                        $cr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = JournalEntry::where('account_id', $vat_out->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

                       
                            

                         $total_in= $dr_in- $cr_in ;
                          $total_out = $cr_out - $dr_out ;

                          
                         if ($total_in - $total_out < 0){
                                  $debit=0;
                                  $credit=abs(($total_in - $total_out) *-1 );
                                
                         }else{
                                 $debit=abs($total_in - $total_out);
                                  $credit=0;

                         }
                           
                          
}


elseif($account_code->account_name == 'Deffered Tax'){
   
                       
                             
              
                           if(!empty($branch_id) && $branch_id != $a){
                        $cr1 =JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 =JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                              $cr1 =JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr1 =JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            
                        
                           $debit= $dr1 ;
                            $credit= $cr1 ;
                            
                           
                          
}





 
 $data['debit'] =  $debit;
 $data['credit'] =  $credit;

   
   
   
   
   return $data; 
   
   
   
   
   
   
   
   
   
   
    }
    
    
    
}