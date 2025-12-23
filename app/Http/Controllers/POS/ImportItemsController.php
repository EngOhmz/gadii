<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Imports\ImportItems;
use App\Imports\ImportManufacturingItems;
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
    
    
     public function import2(Request $request){
        //$data = Excel::import(new ImportJournalEntry, $request->file('file')->store('files'));
        
        $data = Excel::import(new ImportManufacturingItems, $request->file('file')->store('files'));
        
        return redirect()->back()->with(['success'=>'File Imported Successfull']);
    }
    
     public function sample2(Request $request){
        //return Storage::download('items_sample.xlsx');
        $filepath = public_path('manufacturing_sample.xlsx');
        return Response::download($filepath); 
    }
}
