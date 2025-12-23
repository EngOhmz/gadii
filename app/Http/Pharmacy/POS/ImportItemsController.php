<?php

namespace App\Http\Controllers\Pharmacy\POS;

use App\Http\Controllers\Controller;
use App\Imports\ImportItems;
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
        //$data = Excel::import(new ImportJournalEntry, $request->file('file')->store('files'));
        
        $data = Excel::import(new ImportItems, $request->file('file')->store('files'));
        
        return redirect()->back()->with(['success'=>'File Imported Successfull']);
    }
    
     public function sample(Request $request){
        //return Storage::download('items_sample.xlsx');
        $filepath = public_path('items_sample.xlsx');
        return Response::download($filepath); 
    }
}
