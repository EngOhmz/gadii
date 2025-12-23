<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use DateTime;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use App\Models\Tariff;
use App\Models\Region;
use App\Models\District;
use App\Models\Zone;
use App\Models\Courier\CourierClient;

class ImportTariff  implements ToCollection,WithHeadingRow

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

 
      
     $item= Tariff::create([
       
        'client_id' => CourierClient::where('name',$row['client'])->get()->first()->id,
        'price' => $row['price'],
        'from_region_id' =>Region::where('name',$row['departure_region'])->get()->first()->id,
        'to_region_id' =>Region::where('name',$row['arrival_region'])->get()->first()->id,
        'from' => $row['departure_region'],
        'to' => $row['arrival_region'], 
        'distance' => $row['distance'], 
        'weight' => $row['weight'],  
       'type' => $row['type'], 
       'description' => $row['description'],  
        'zone_id' => Zone::where('name',$row['zone'])->get()->first()->id,     
         'added_by' => auth()->user()->added_by,

        ]);


   
      } 

    
    
  }  




}
