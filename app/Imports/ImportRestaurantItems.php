<?php

namespace App\Imports;

use App\Models\AccountCodes;
use App\Models\JournalEntry;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use DateTime;
use App\Models\Location;
use App\Models\POS\Activity;
use App\Models\POS\Items;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\SerialList;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use DB;

class ImportRestaurantItems  implements ToCollection,WithHeadingRow,WithCalculatedFormulas

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

   if($row['type'] == 'Drinks'){
    $bar=1;
   }

 if($row['type'] == 'Kitchen'){
    $bar=0;

}

if($row['tax_rate'] == '18%'){
    $tax=0.18;
   }

 elseif($row['tax_rate'] != '18%'){
    $tax=0;

}

$old=Items::where(DB::raw('lower(name)'), strtolower($row['name']))->where('added_by',auth()->user()->added_by)->first();  

    if (empty($old)) {  
        
  $item= Items::create([
       
        'name' => $row['name'],
        'cost_price' => $row['cost_price'],
        'unit_price' => $row['unit_price'],
        'bottle' => $row['bottle'],
        'quantity' => $row['quantity'],
        'unit' => $row['unit'],
        'description' => $row['description'],  
         'type' => '1', 
         'restaurant' => '1', 
          'bar' => $bar,
         'tax_rate' => $tax,
         'added_by' => auth()->user()->added_by,

        ]);

if(!empty($item)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$item->id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $item->name. " is Created",
                        ]
                        );                      
}

}
else{
    
     Items::find($old->id)->update([
        'quantity' => $old->quantity + $row['quantity'],
        ]);
        
        $item= Items::find($old->id);

if(!empty($item)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$item->id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $item->name. " is Updated",
                        ]
                        );                      
} 

}
      
  
  
  if(!empty($item)){     

     $today=date('Y-m-d');
     //dd($today);
        //$new= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($today)->format('Y-m-d');

              $date = explode('-', $today);
              
           
   
$nameArr=$row['quantity'];
 if($nameArr > 0){ 
     
     
      if($row['balance'] > 0){ 

     $drjournal= JournalEntry::create([
        'account_id' => AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->get()->first()->id,
       'date' =>  $today, 
        'month' => $date[1],     
        'year' => $date[0],
        'credit' => '0',
        'debit' => $row['balance'],
        'income_id' => $item->id,
        'name' => 'POS Items',
        'transaction_type' => 'import_pos_items',
        'notes' => 'POS Item Balance for ' .$row['name'],
        'added_by' => auth()->user()->added_by,
        ]);


        $crjournal= JournalEntry::create([
          'account_id' => AccountCodes::where('account_name','Open Balance')->where('added_by',auth()->user()->added_by)->get()->first()->id,
         'date' =>  $today, 
          'month' => $date[1],     
          'year' => $date[0],
          'credit' => $row['balance'],
          'debit' => '0',
          'income_id' => $item->id,
          'name' => 'POS Items',
          'transaction_type' => 'import_pos_items',
          'notes' => 'POS Item Balance for ' .$row['name'],
          'added_by' => auth()->user()->added_by,
          ]);
          
              }  

    
                       $lists= array(
                            'quantity' =>   $nameArr,
                          'price' => $row['cost_price'],
                             'item_id' =>$item->id,
                               'added_by' => auth()->user()->added_by,
                             'purchase_date' =>  $today,
                             'location' => Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->get()->first()->id,
                            'type' =>   'Purchases');
                           
                         PurchaseHistory::create($lists);   

                    $loc=Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->first();
                        $lq['quantity']=$loc->quantity + $nameArr;
                        Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->update($lq);
                        
                          $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                        
                        /*
                         for($x = 1; $x <= $nameArr; $x++){    
                $name=Items::where('id', $item->id)->first();

                    if($name->bar == '1'){ 
                    $due=1 * $name->bottle;
                    }

                    else{
                    $due=1 ;
                    }
              
                        $series = array(
                            'serial_no' => $random."-".$x, 
                            'bar' => $name->bar,                     
                            'brand_id' => $item->id,
                            'added_by' => auth()->user()->added_by,
                            'purchase_date' =>   $today,
                            'location' =>  Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->get()->first()->id,
                            'quantity' =>  1,
                            'due_quantity' =>  $due,
                            'source_store' => Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->get()->first()->id,
                            'crate_status' => '0',
                            'status' => '0');
                       
                    
                  SerialList::create($series);   
                  
                  
                   
                    }
                    */
                    
                    
                   
                    
}

               
            
            }    




      } 

    
    
  }  




}
