<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Details\UserDetails;
use App\Models\System;
use Image;


class UserDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        //$user_id=auth()->user()->id;
        //$user=User::find($user_id);

        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();
        $data['added_by'] = auth()->user()->added_by;

        
      if ($request->hasFile('files')) {
        $file=$request->file('files');
        $fileType=$file->getClientOriginalExtension();
        $fileName=rand(1,1000).date('dmyhis').".".$fileType;
        $logo=$fileName;
        $photo->move('public/assets/img/logo', $fileName );

        $data['logo'] = $logo;
    }else{
        $data['logo'] = null;
    }
        UserDetails::create($data);
        
        
        $data1['name'] = $request->company_name;
        $data1['currency']=$request->currency;
        $data1['tin'] = $request->tin;
         $data1['vat'] = $request->vat;
        $data1['email'] = $request->email;
        $data1['address'] = $request->address;
        $data1['phone']=$request->phone;
       $data1['added_by'] = auth()->user()->added_by;
       
       
            	
            	  if ($request->hasFile('picture')) {
     
					$photo=$request->file('picture');
					
						//dd($photo);
					
					$fileType=$photo->getClientOriginalExtension();
					$fileName=rand(1,1000).date('dmyhis').".".$fileType;
					$logo=$fileName;
					$data1['picture'] = $logo;
					 
                $destinationPath = public_path('/assets/img/logo');
                $img = Image::make($photo->path());
                $img->resize(300, 300, function ($constraint) {
                   $constraint->aspectRatio();
                })->save($destinationPath.'/'.$logo);
        
                $destinationPath = public_path('/assets/img/original');
                $photo->move($destinationPath, $logo);
					
            	}
            	
            	
            	else{
            	  
            	  
            	  $oldPath = 'default_logo.jpg'; // publc/images/1.jpg

                    $fileExtension = \File::extension($oldPath);
                    $fileName=rand(1,1000).date('dmyhis').".".$fileExtension;
                    $logo=$fileName;
                    $data1['picture'] = $logo;

                    $destinationPath = public_path('/assets/img/logo');
                    $img = Image::make('default_logo.jpg');
                    $img->resize(300, 300, function ($constraint) {
                       $constraint->aspectRatio();
                    })->save($destinationPath.'/'.$logo);
                    
                    $newPathWithName = 'assets/img/original/'.$logo;
 
                    if (\File::copy($oldPath , $newPathWithName)) {
                        //dd("success");
                    }
     
					

            	}
            
            $system = System::create($data1);

        
        //return view('agrihub.dashboard');

      return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
