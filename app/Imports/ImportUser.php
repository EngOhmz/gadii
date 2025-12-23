<?php
namespace App\Imports;

use App\Models\Departments;
use App\Models\Designation;
use App\Models\JournalEntry ;
use App\Models\AccountCodes ;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use DateTime;
use App\Models\Transaction;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Accounts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportUser implements ToCollection,WithHeadingRow

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
         
//dd($row['department']);

        $user = User::create([
       'name'=> $row['name'],
       'email'=>$row['email'],
       'phone'=> $row['phone'],
       'password'=> Hash::make('11223344'),
       'department_id' => Departments::where('name',$row['department'])->get()->first()->id,
        'designation_id' =>Designation::where('name',$row['designation'])->get()->first()->id,
        'joining_date' =>  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['joining_date'])->format('Y-m'), 
   'added_by' => auth()->user()->id,
      ]);

      $role = Role::where('slug','Staff')->get()->first();
      $user->roles()->attach($role->id);
        


    
    }
  }  




}
