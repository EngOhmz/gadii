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
use App\Models\Retail\POS\Activity;
use App\Models\Retail\POS\Items;
use App\Models\Retail\POS\PurchaseHistory;
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

 
      
     $item= Items::create([
       
        'name' => $row['name'],
        'cost_price' => $row['cost_price'],
        'sales_price' => $row['sales_price'],
        'quantity' => $row['quantity'],
        'unit' => $row['unit'],
        'description' => $row['description'],       
         'added_by' => auth()->user()->added_by,

        ]);

if(!empty($item)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
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
        'debit' => $row['balance'],
        'income_id' => $item->id,
        'name' => 'POS Items',
        'transaction_type' => 'import_pos_items',
        'notes' => 'POS Item Balance for ' .$row['name'],
        'added_by' => auth()->user()->id,
        ]);


        $crjournal= JournalEntry::create([
          'account_id' => AccountCodes::where('account_name','Open Balance')->get()->first()->account_id,
         'date' =>  $today, 
          'month' => $date[1],     
          'year' => $date[0],
          'credit' => $row['balance'],
          'debit' => '0',
          'income_id' => $item->id,
          'name' => 'POS Items',
          'transaction_type' => 'import_pos_items',
          'notes' => 'POS Item Balance for ' .$row['name'],
          'added_by' => auth()->user()->id,
          ]);
   
$nameArr=$row['quantity'];
 if($nameArr > 0){ 
                for($i = 0; $i < $nameArr; $i++){
                    if(!empty($nameArr[$i])){
    
                       $lists= array(
                            'quantity' =>   $nameArr[$i],
                             'item_id' =>$item->id,
                               'added_by' => auth()->user()->added_by,
                             'purchase_date' =>  $today,
                            'type' =>   'Purchases');
                           
                         PurchaseHistory ::create($lists);   
          
                       
                    }
                }
            
            }    



      } 

    
    
  }  




}
