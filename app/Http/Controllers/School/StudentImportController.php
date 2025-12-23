<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Imports\ImportStudents ;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class StudentImportController extends Controller
{
    use Importable;
    
    public function import(Request $request){
        //$data = Excel::import(new ImportStudents, $request->file('file')->store('files'));
        
        $data = Excel::import(new ImportStudents, $request->file('file')->store('files'));
        
        return redirect()->back()->with(['success'=>'File Imported Successfull']);
    }
    
     public function sample(Request $request){
        return Storage::download('students.xlsx');
    }
}
