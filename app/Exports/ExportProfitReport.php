<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\AccountCodes;
use App\Models\JournalEntry;

class  ExportProfitReport implements FromView
{
    protected $name,$start,$end;

 public function __construct(String  $name,String $start,String $end){
            $this->name = $name;
           $this->start= $start;
             $this->end= $end;
        }


   public function view() : View
    {
 $codes=AccountCodes::where('account_group','Receivables')->where('added_by', auth()->user()->added_by)->first();
 $payable=AccountCodes::where('account_name','Payables')->where('added_by', auth()->user()->added_by)->first();
          $pdisc=AccountCodes::where('account_name','Purchase Discount')->where('added_by', auth()->user()->added_by)->first();
       $sdisc=AccountCodes::where('account_name','Sales Discount')->where('added_by', auth()->user()->added_by)->first();

       $purchase=JournalEntry::where('project_id',  $this->name)->where('transaction_type','pos_purchase')->where('account_id', $payable->id)->whereBetween('date',[$this->start,$this->end])->where('added_by',auth()->user()->added_by)->sum('credit'); 
       $pdiscount=JournalEntry::where('project_id',  $this->name)->where('transaction_type','pos_purchase')->where('account_id', $pdisc->id)->whereBetween('date',[$this->start,$this->end])->where('added_by',auth()->user()->added_by)->sum('debit'); 
   $debit = JournalEntry::where('project_id',  $this->name)->where('transaction_type','pos_debit_note')->whereBetween('date',[$this->start,$this->end])->where('added_by',auth()->user()->added_by)->sum('debit');
  $invoice=JournalEntry::where('project_id',  $this->name)->where('transaction_type','pos_invoice')->where('account_id', $codes->id)->whereBetween('date',[$this->start,$this->end])->where('added_by',auth()->user()->added_by)->sum('debit'); 
 $sdiscount=JournalEntry::where('project_id',  $this->name)->where('transaction_type','pos_invoice')->where('account_id', $sdisc->id)->whereBetween('date',[$this->start,$this->end])->where('added_by',auth()->user()->added_by)->sum('credit'); 
  $credit = JournalEntry::where('project_id',  $this->name)->where('transaction_type','pos_credit_note')->where('account_id', $codes->id)->whereBetween('date',[$this->start,$this->end])->where('added_by',auth()->user()->added_by)->sum('credit');
$expense=JournalEntry::where('project_id',  $this->name)->where('transaction_type','expense_payment')->whereBetween('date',[$this->start,$this->end])->where('added_by',auth()->user()->added_by)->sum('debit'); 


        return view('project.report.profit_report_excel', [
          'purchase' => $purchase,
          'pdiscount' => $pdiscount,
          'debit' => $debit,
            'invoice' => $invoice,
            'sdiscount' => $sdiscount,
            'credit' => $credit,
            'expense' => $expense,
            'name' => $this->name,
              'start' => $this->start,
             'end' => $this->end,
        ]);
    }

  
  
}