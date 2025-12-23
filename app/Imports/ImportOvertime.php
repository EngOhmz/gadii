<?php
namespace App\Imports;

use App\Models\Departments;
use App\Models\Payroll\SalaryAllowance;
use App\Models\Payroll\SalaryDeduction;
use App\Models\Payroll\SalaryTemplate;
use App\Models\Payroll\EmployeePayroll;
use App\Models\Payroll\PayrollActivity;
use App\Models\Payroll\Overtime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use DateTime;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportOvertime implements ToCollection,WithHeadingRow

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
         
        $overtime=Overtime::create([
       'overtime_amount'=> $row['amount'],
    'user_id'=>User::where('name',$row['staff_name'])->get()->first()->id,
    'overtime_date'=>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['overtime_date'])->format('Y-m-d'),
    'status'=>'1',
    'approve_by' => User::where('name',$row['approved_by'])->get()->first()->id,
   'added_by' => auth()->user()->added_by,
      ]);



$month= date('d F Y', strtotime($overtime->overtime_date)) ;         
         
          if(!empty($overtime)){
                    $activity =PayrollActivity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                              'user_id'=>auth()->user()->id,
                           'module_id'=> $overtime->id,
                            'module'=>'Overtime',
                            'activity'=>"Overtime to  " .  $row['staff_name'].  "  for the period " . $month. " is Approved",
                        ]
                        );                      
       }


    
    }
  }  




}
