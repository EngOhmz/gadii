<?php
namespace App\Imports;

use App\Models\Departments;
use App\Models\Payroll\SalaryAllowance;
use App\Models\Payroll\SalaryDeduction;
use App\Models\Payroll\SalaryTemplate;
use App\Models\Payroll\EmployeePayroll;
use App\Models\Payroll\PayrollActivity;
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

class ImportSalaryTemplate implements ToCollection,WithHeadingRow

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
         
       if($row['nssf'] > 0){
      $checked = 1;
    }
   else{
     $checked = 0;
    }

  if($row['heslb'] > 0){
      $heslb_check = 1;
    }
   else{
     $heslb_check = 0;
    }

        $template =SalaryTemplate::create([
       'salary_grade'=> $row['salary_grade'],
       'basic_salary'=>$row['basic_salary'],
        'checked'=> $checked,
       'heslb_check'=> $heslb_check,
       'user_id'=> auth()->user()->added_by,
      ]);



           $provident_fund = $row['nssf'];
            $tax_deduction =$row['paye'];
           $heslb=$row['heslb'];

if ($provident_fund > 0) {

                   $adeduction_data['salary_template_id'] = $template->salary_template_id;
                    $adeduction_data['deduction_label'] = 'NSSF';
                    $adeduction_data['deduction_value'] =$provident_fund;
                    $adeduction_data['user_id'] = auth()->user()->added_by;
                    SalaryDeduction::create($adeduction_data);
              
            }

            if ($tax_deduction > 0) {

                 $adeduction_data['salary_template_id'] = $template->salary_template_id;
                    $adeduction_data['deduction_label'] = 'PAYE';
                    $adeduction_data['deduction_value'] =$tax_deduction;
                    $adeduction_data['user_id'] = auth()->user()->added_by;

                    SalaryDeduction::create($adeduction_data);
            }

   if ($heslb > 0) {

                 $adeduction_data['salary_template_id'] = $template->salary_template_id;
                    $adeduction_data['deduction_label'] = 'HESLB';
                    $adeduction_data['deduction_value'] =$heslb;
                    $adeduction_data['user_id'] = auth()->user()->added_by;

                    SalaryDeduction::create($adeduction_data);
            }
          
         
          if(!empty($template)){
                    $activity =PayrollActivity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                              'user_id'=>auth()->user()->id,
                            'module_id'=>$template->salary_template_id,
                             'module'=>'Salary Template',
                            'activity'=>"Salary Template for  " .  $template->salary_grade. "  Created",
                        ]
                        );                      
       }


    
    }
  }  




}
