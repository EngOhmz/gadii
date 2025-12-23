<?php

namespace App\Imports;

use App\Models\JournalEntry ;
use App\Models\AccountCodes ;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use DateTime;
use App\Models\TruckInsurance;
use App\Models\Truck;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportInsurance  implements ToCollection,WithHeadingRow

{ 
//, WithValidation
   // use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
     
        //  $myDateTime = DateTime::createFromFormat('Y-m-d', strtotime($row[2]));
        //  $year = $myDateTime->format('Y');
        //  $month = $myDateTime->format('M');


         foreach ($rows as $row) 
      {

$supp=Supplier::where('name',$row['broker'])->first();
  //dd($supp);

       $item= TruckInsurance::create([
     
        'cover_date' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['cover_date'])->format('Y-m-d'), 
        'expire_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['expire_date'])->format('Y-m-d'), 
        'broker_name' =>$supp->id,
        'value' => $row['value'],
        'cover' => $row['cover_type'],
        'truck_id' => Truck::where('reg_no',$row['truck'])->get()->first()->id,
        'added_by' => auth()->user()->added_by,

        ]);

$today=date('Y-m-d');
$date = explode('-', $item->cover_date);
$truck=Truck::find($item->truck_id);

  $before=$item->value/1.18;
    $tax=$item->value -  $before;

     $drjournal= JournalEntry::create([
        'account_id' => AccountCodes::where('account_name','Insurance')->where('added_by',auth()->user()->added_by)->get()->first()->,
       'date' =>  $item->cover_date, 
        'month' => $date[1],     
        'year' => $date[0],
        'credit' => '0',
        'debit' => $before,
        'income_id' => $item->id,
         'truck_id' => $item->truck_id,
          'supplier_id' => $item->broker_name,
        'name' => 'Truck Insurance',
        'transaction_type' => 'truck_insurance',
        'notes' => 'Truck Insurance for the truck ' .$truck->truck_name .' - '. $truck->reg_no ,
        'added_by' => auth()->user()->added_by,
        ]);

$vatjournal= JournalEntry::create([
        'account_id' => AccountCodes::where('account_name','VAT IN')->where('added_by',auth()->user()->added_by)->get()->first()->,
       'date' =>  $item->cover_date, 
        'month' => $date[1],     
        'year' => $date[0],
        'credit' => '0',
        'debit' => $tax,
        'income_id' => $item->id,
         'truck_id' => $item->truck_id,
          'supplier_id' => $item->broker_name,
        'name' => 'Truck Insurance',
        'transaction_type' => 'truck_insurance',
        'notes' => 'Truck Insurance for the truck ' .$truck->truck_name .' - '. $truck->reg_no ,
        'added_by' => auth()->user()->added_by,
        ]);


        $crjournal= JournalEntry::create([
          'account_id' => AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->get()->first()->,
         'date' =>  $item->cover_date, 
          'month' => $date[1],     
          'year' => $date[0],
          'credit' => $row['value'],
          'debit' => '0',
          'income_id' => $item->id,
         'truck_id' => $item->truck_id,
        'supplier_id' => $item->broker_name,
        'name' => 'Truck Insurance',
        'transaction_type' => 'truck_insurance',
        'notes' => 'Truck Insurance for the truck ' .$truck->truck_name .' - '. $truck->reg_no ,
        'added_by' => auth()->user()->added_by,
          ]);


       




    
    }
  }  

}
