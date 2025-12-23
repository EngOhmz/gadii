<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Imports\ImportJournalEntry ;
use App\Imports\CheckJournalEntry ;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class JournalImportController extends Controller
{
    use Importable;
    
   
   
    
    public function import(Request $request){
        //$data = Excel::import(new ImportJournalEntry, $request->file('file')->store('files'));
        
        $import = new ImportJournalEntry;
        
        $data = Excel::import($import, $request->file('file'));
        
        $notploaded=$import->notploaded;
        
        //dd($notploaded); 

        if ($notploaded)
            {
               return redirect()->back()->with(['error'=>'The Journal must balance (Debits equal to Credits)']);  
            }
            
            else{
                return redirect()->back()->with(['success'=>'File Imported Successfully']); 
            }
        
       
    }
    
     public function sample(Request $request){
        return Storage::download('sample.xlsx');
    }
}
