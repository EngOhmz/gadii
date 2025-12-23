<?php

namespace App\Imports;
use App\Models\Supplier;
use App\Models\POS\Activity;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use DateTime;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSupplier  implements ToCollection,WithHeadingRow

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
     
        


         foreach ($rows as $row) 
      {
      


                 $result=Supplier::create([
                    'name' =>  $row['name'],
                    'phone' =>  $row['phone'],
                    'email' =>  $row['email'],
                    'address' =>   $row['address'] ,
                    'VAT' =>   $row['vat'] ,
                    'TIN' =>   $row['tin'] ,
                    'user_id' => auth()->user()->added_by,

        ]);


if(!empty($result)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                            'user_id'=>auth()->user()->id,
                            'module_id'=>$result->id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $result->name. "  Created",
                        ]
                        );                      
       }



           
    }

  }  
}
