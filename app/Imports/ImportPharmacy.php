<?php

namespace App\Imports;

use App\Models\AccountCodes;
use App\Models\JournalEntry;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use DateTime;
use App\Models\Pharmacy\Activity;
use App\Models\Pharmacy\Items;
use App\Models\Pharmacy\PurchaseHistory;
use App\Models\Pharmacy\PurchaseSerial;
use App\Models\Pharmacy\PurchaseSerialList;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class ImportItems  implements ToCollection,WithHeadingRow

{ 
//, WithValidation
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
      foreach ($rows as $row) 
      {

if($row['manufacturer'] == 'BROKEN'){
          $qty=0;
        $m='';
        }

        elseif($row['manufacturer'] == 'EXPIRED'){
       $qty=0;
       $m='';
        }

     elseif($row['manufacturer'] == 'SOLD'){
       $qty=0;
       $m='';
        }

     else{
       $qty=$row['quantity'];
      $m=$row['manufacturer'];
        }


     $item= Items::create([
       
        'name' => $row['name'],
       'category' => $row['category'],
       'cost_price' => $row['cost_price'],
        'sales_price' => $row['sales_price'],
        'quantity' =>   $qty,
        'unit' => $row['unit'],
        'description' => $row['description'],
        'manufacturer' => $m,
        'user_id' => auth()->user()->added_by,

        ]);

if(!empty($item)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$item->id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $item->name. "  Created",
                        ]
                        );                      
       }


     $today=date('Y-m-d');
     //dd($today);
        //$new= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($today)->format('Y-m-d');

              $date = explode('-', $today);

     $drjournal= JournalEntry::create([
        'account_id' => AccountCodes::where('account_name','Inventory')->get()->first()->account_id,
       'date' =>  $today, 
        'month' => $date[1],     
        'year' => $date[0],
        'credit' => '0',
        'debit' =>$row['balance'],
        'income_id' => $item->id,
        'name' => 'POS Items',
        'transaction_type' => 'import_pos_items',
        'notes' => 'POS Item Balance for ' .$row['name'],
        'added_by' => auth()->user()->added_by,
        ]);


        $crjournal= JournalEntry::create([
          'account_id' => AccountCodes::where('account_name','Open Balance')->get()->first()->account_id,
         'date' =>  $today, 
          'month' => $date[1],     
          'year' => $date[0],
          'credit' =>$row['balance'],
          'debit' => '0',
          'income_id' => $item->id,
          'name' => 'POS Items',
          'transaction_type' => 'import_pos_items',
          'notes' => 'POS Item Balance for ' .$row['name'],
          'added_by' => auth()->user()->added_by,
          ]);


     if($row['category'] == 'Serial'){     
        if($qty > 0){
            for($x = 1; $x <= $qty ; $x++){    
                $name=Items::where('id',$item->id)->first();
              $id=0;
                    $lists = array(
                        'serial_no' => $name->name."_" .$id."_".$x,                      
                         'brand_id' => $item->id,
                           'added_by' => auth()->user()->added_by,
                         'purchase_date' =>  $today,
                           'status' => '0');
                       
     
                    PurchaseSerialList::create($lists);   
      
                }
            }
       }

if(!empty($row['expire_date'])){  
$new= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['expire_date'])->format('Y-m') ;

}
else{
$new='';
}

     if($row['category'] == 'Batch'){     
        if($qty > 0){ 
              $id=0;
                    $b_lists = array(
                       'quantity' => $qty,
                             'due_quantity' =>  $qty,
                            'expire_date' => $new,
                             'item_id' => $item->id,
                               'added_by' => auth()->user()->added_by,
                             'purchase_date' =>  $today,
                            'type' =>   'Purchases');                           
                         PurchaseHistory::create($b_lists);   
                               
      
            }
       }



      } 

    
    
  }  




}
