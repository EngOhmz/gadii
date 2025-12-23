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
use App\Models\UserDetails\BasicDetails;
use App\Models\UserDetails\BankDetails;
use App\Models\UserDetails\SalaryDetails;
use Illuminate\Support\Facades\Hash;
use App\Models\Accounts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportUserDetails implements ToCollection,WithHeadingRow

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
         

        $bank = BankDetails::create([
       'user_id'=>User::where('name',$row['name'])->get()->first()->id,
       'bank_name'=>$row['bank_name'],
       'account_name'=> $row['account_name'],
       'account_number'=>$row['account_number'],
   'added_by' => auth()->user()->added_by,
      ]);


           $salary = SalaryDetails::create([
       'user_id'=>User::where('name',$row['name'])->get()->first()->id,
       'TIN'=>$row['tin_number'],
       'NSSF'=> $row['nssf_number'],
        'added_by' => auth()->user()->added_by,
      ]);



    
    }
  }  




}
