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
use App\Models\Tyre\TyreActivity;
use App\Models\Tyre\TyreBrand;
use App\Models\Tyre\MasterHistory;
use App\Models\Tyre\Tyre;
use App\Models\Tyre\TyreHistory;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use DB;

class ImportTyre implements ToCollection,WithHeadingRow,WithCalculatedFormulas

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


/*
if($row['tax_rate'] == '18%'){
    $tax=0.18;
   }

 elseif($row['tax_rate'] != '18%'){
    $tax=0;

}
*/

$old=TyreBrand::where(DB::raw('lower(brand)'), strtolower($row['brand']))->where('added_by',auth()->user()->added_by)->where('disabled','0')->first();  

    if (empty($old)) {  
        
  $a= TyreBrand::create([
       
        'brand' => $row['brand'],
        'price' => $row['price'],
        'quantity' => $row['quantity'],
        'unit' => $row['unit'],
        'description' => $row['description'],  
         //'tax_rate' => $tax,
         'added_by' => auth()->user()->added_by,

        ]);


if(!empty($a)){
                    $activity =TyreActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$a->id,
                             'module'=>'Tyre Brand',
                            'activity'=>"Tyre brand " .  $a->brand. " is Created",
                        ]
                        );                      
}

$c=$a->id;


}
else{
    
     TyreBrand::find($old->id)->update([
        'quantity' => $old->quantity + $row['quantity'],
        ]);
        
        $b= TyreBrand::find($old->id);
        
        
        if(!empty($b)){
                    $activity =TyreActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$b->id,
                             'module'=>'Tyre Brand',
                            'activity'=>"Tyre brand " .  $b->brand. " is Updated",
                        ]
                        );                      
} 

$c=$old->id;


}
      
  
  
    $item=TyreBrand::find($c) ;
if(!empty($item)){  
   
     //dd($today);
        //$new= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($today)->format('Y-m-d');
        
        
    if(!empty($row['date'])){
      $today=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])->format('Y-m-d');
      $date = explode('-', $today);  
    }    

  else{
        $today=date('Y-m-d');
         $date = explode('-', $today);
  }

             
              
      //dd($date);     
   
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
        'name' => 'Tire',
        'transaction_type' => 'import_tire',
        'notes' => 'Tire Balance for ' .$row['brand'],
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
          'name' => 'Tire',
          'transaction_type' => 'import_tire',
          'notes' => 'Tire Balance for ' .$row['brand'],
          'added_by' => auth()->user()->added_by,
          ]);
          
              }  

    
                       $lists= array(
                            'quantity' =>   $nameArr,
                             'price' => $row['price'],
                             'item_id' =>$item->id,
                             'added_by' => auth()->user()->added_by,
                               'user_id' => auth()->user()->id,
                             'purchase_date' =>  $today,
                             'location' => Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->get()->first()->id,
                            'type' =>   'Purchases');
                           
                         TyreHistory::create($lists);   
                         
                          $mlists = [
                        'in' => $nameArr,
                        'price' => $row['price'],
                        'item_id' => $item->id,
                        'added_by' => auth()->user()->added_by,
                        'location' =>  Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->get()->first()->id,
                        'date' =>$today,
                        'type' => 'Purchases',
                    ];

                     MasterHistory::create($mlists);
                         
                         

                        $loc=Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->first();
                        $lq['quantity']=$loc->quantity + $nameArr;
                        Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->update($lq);
                        
                          $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                          $words = preg_split("/\s+/", $item->brand);
                          $acronym = "";
                            
                           foreach ($words as $w) {
                              $acronym .= mb_substr($w, 0, 1);
                            }
                            $a=strtoupper($acronym);
                            
                            
                          
                            
                            
                          
                        for($x = 1; $x <= $nameArr; $x++){    
                        $name=TyreBrand::where('id', $item->id)->first();

                        $series = array(
                            'serial_no' => $a.$random.$x, 
                            'brand_id' => $item->id,
                            'added_by' => auth()->user()->added_by,
                            'purchase_date' =>   $today,
                            'location' =>  Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->get()->first()->id,
                            'quantity' =>  1,
                            'due_quantity' =>  1,
                            'source_store' => Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->get()->first()->id,
                            'status' => '0');
                       
                    
                            Tyre::create($series);   
                  
                  
                   
                     
                                
                            }
                    
                    
                   
 }              


               
            
            }    




      } 

    
    
  }  




}
