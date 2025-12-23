<?php

namespace App\Exports;
use App\Models\School\School;
use App\Models\School\SchoolDetails;
use App\Models\School\SchoolBreakdown;
use App\Models\School\SchoolLevel;
use App\Models\School\Student;
use App\Models\School\StudentPayment;
use App\Models\School\SchoolPayment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class  ExportStudentReport implements FromView
{
    protected $name,$year;

 public function __construct(String  $name,String $year){
            $this->name = $name;
           $this->year= $year;
        }


   public function view() : View
    {

          $student=StudentPayment::where('student_id', $this->name)->where('year',$this->year)->first();          
         $payments=SchoolPayment::where('fee_id', $student->fee_id)->where('student_id', $this->name)->where('year',$this->year)->where('type','!=','Discount Fees')->get();
         $data=SchoolBreakdown::where('fee_id', $student->fee_id)->get();

        return view('raja.report.student_report_excel', [
          'student' => $student,
          'payments' => $payments,
            'data' => $data,
            'name' => $this->name,
              'year' => $this->year,
        ]);
    }

  
  
}