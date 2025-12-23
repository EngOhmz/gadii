<?php

namespace App\Http\Controllers\Bar\POS;

use App\Http\Controllers\Controller;
use App\Imports\ImportBarItems;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use File;
use Response;
use Illuminate\Support\Facades\Storage;

class ImportItemsController extends Controller
{
    use Importable;
    
    public function import(Request $request){

        
        $data = Excel::import(new ImportBarItems, $request->file('file')->store('files'));
        
      return redirect()->back()->with(['success'=>'File Imported Successfull']);
    }
    
     public function sample(Request $request){
        $filepath = public_path('bar_sample.xlsx');
        return Response::download($filepath); 
    }
}
