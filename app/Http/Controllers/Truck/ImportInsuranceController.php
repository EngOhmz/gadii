<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Imports\ImportInsurance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use File;
use Response;
use Illuminate\Support\Facades\Storage;

class ImportInsuranceController extends Controller
{
    use Importable;
    
    public function import(Request $request){
        
        $data = Excel::import(new ImportInsurance, $request->file('file')->store('files'));
        
       return redirect()->back()->with(['success'=>'File Imported Successfully']);
      
    }
    
     public function sample(Request $request){
        $filepath = public_path('insurance_sample.xlsx');
        return Response::download($filepath); 
    }
}
