<?php

namespace App\Http\Controllers;
use App\Models\ChartOfAccount;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\System;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;

class SystemController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $system = System::all()->where('added_by',auth()->user()->added_by);
        
        return view('system.data', compact('system'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
      
        return view('account_codes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
$data = $request->all();
					 $data['added_by'] = auth()->user()->added_by;
      if ($request->hasFile('picture')) {
					$photo=$request->file('picture');
					$fileType=$photo->getClientOriginalExtension();
					$fileName=rand(1,1000).date('dmyhis').".".$fileType;
					$logo=$fileName;
					$photo->move('assets/img/logo', $fileName );
					 $data['picture'] = $logo;
					 
					  // $file = $request->picture;

                      // $file_new_name =  $file->move("public/assets/img/logo", $file->getClientOriginalName());

    //$post->filename = $file_new_names;
            	}

        
            
           
            
            $system = System::create($data);
            //   $system->name = $request->name;         
            //   $system->picture = $logo ;
            // $system->save();

            
            //Flash::success(trans('general.successfully_saved'));
            return redirect('system');
        }
   

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
       $data= System::find($id);
         
        return View::make('system.data', compact('data','id'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
             $data = $request->all();
      if ($request->hasFile('picture')) {
					$photo=$request->file('picture');
					$fileType=$photo->getClientOriginalExtension();
					$fileName=rand(1,1000).date('dmyhis').".".$fileType;
					$logo=$fileName;
					$photo->move('assets/img/logo', $fileName );
					$data['picture'] = $logo;
            	}
            
     

            
         $system= System::find($id);
         
        $system->update($data);
        //= $request->name ;
  
       
    //   if($request->hasFile('picture')){
    //           unlink('public/assets/img/logo/'. $system->picture);      
    //             $system->picture = $logo ;         
    //         }
             
    //         $system->save();
          return redirect('system');
  

        
            
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        System::destroy($id);
        //Flash::success(trans('general.successfully_deleted'));
           return redirect('system');
    }
}
