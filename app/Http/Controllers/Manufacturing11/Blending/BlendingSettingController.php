<?php

namespace App\Http\Controllers\Manufacturing\Blending;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\Blending\Alcohol;
use App\Models\Manufacturing\Blending\Line;
use App\Models\Manufacturing\Blending\Flavor;
use App\Models\Manufacturing\Blending\Type;
use App\Models\Manufacturing\Blending\Tank;
use App\Models\Manufacturing\Blending\Pack;
use Illuminate\Http\Request;

class BlendingSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    //     $location= Location::all();
      
    //   return view('manufacturing.location',compact('location'));
       
       $tanks = Tank::all();
       $lines = Line::all();
      $type = "tool";
     $flavors = Flavor::all();
       $alcohols = Alcohol::all();
       
       $products =Type::all();
       $packs = Pack::all();
        return view('manufacturing.blending.settings',compact('tanks','lines','type','flavors','alcohols','products','packs'));
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
        
        
        if($request->type == "line"){

        $lines = Line::create($request->all());
        return back()->with(['success'=>'Line Number created successfully']);

      }
      elseif($request->type == "flavor"){
          $flavors = Flavor::create($request->all());
          return back()->with(['success'=>'flavor batch created successfully']);
      }
      
      elseif($request->type == "alcohol"){
         $alcohols = Alcohol::create($request->all()); 
         return back()->with(['success'=>'Alcohol Percentage  created successfully']);
      }
      
      elseif($request->type == "product"){
          $products = Type::create($request->all());
          return back()->with(['success'=>'Product Type  created successfully']);
      }
      
      elseif($request->type == "pack"){
          $packs = Pack::create($request->all());
          return back()->with(['success'=>'Pack Size  created successfully']);
      }
      
      else{
          $tanks = Tank::create($request->all());
          return back()->with(['success'=>'Tank Number  created successfully']);
          
      }
      
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
    public function edit(Request $request, $id)
    {
        
            $data=Tank::find($id);
            return view('manufacturing.blending.edit_tank',compact('data','id'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit1(Request $request, $id)
    {
        
       
          $data=Line::find($id);
          return view('manufacturing.blending.edit_line',compact('data','id'));
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit2(Request $request, $id)
    {
        
          $data=Flavor::find($id);
          return view('manufacturing.blending.edit_batch',compact('data','id'));
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit3(Request $request, $id)
    {
        
          $data=Alcohol::find($id);
          return view('manufacturing.blending.edit_alcohol',compact('data','id'));
          
    }      
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit4(Request $request, $id)
    {
       
          $data=Type::find($id);
          return view('manufacturing.blending.edit_product',compact('data','id'));
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit5(Request $request, $id)
    {
       
          $data=Pack::find($id);
          return view('manufacturing.blending.edit_pack',compact('data','id'));
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
        
          
        $tanks = Tank::find($id);
        $tanks->update($request->all());
            
        return redirect(route('blending_settings.index'))->with(['success'=>'Tank Number  updated successfully']);
        
    }
    
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update1(Request $request, $id)
    {
       

        $lines = Line::find($id);
        $lines->update($request->all());
        
        return redirect(route('blending_settings.index'))->with(['success'=>'Line Number updated successfully']);
    }
    
    
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update2(Request $request, $id)
    {
       
          $flavors = Flavor::find($id);
          
         $flavors->update($request->all());
            
            
          return redirect(route('blending_settings.index'))->with(['success'=>'flavor batch updated successfully']);
    }
    
    
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update3(Request $request, $id)
    {
       
         $alcohols = Alcohol::find($id); 
         $alcohols->update($request->all());
         return redirect(route('blending_settings.index'))->with(['success'=>'Alcohol Percentage  updated successfully']);
    }
    
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update4(Request $request, $id)
    {
        
          $products = Type::find($id);
          $products->update($request->all());
          return redirect(route('blending_settings.index'))->with(['success'=>'Product Type  updated successfully']);
     
    }
    
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update5(Request $request, $id)
    {
       
          $packs = Pack::find($id);
          $packs->update($request->all());
          return redirect(route('blending_settings.index'))->with(['success'=>'Pack Size  updated successfully']);

    }
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy1($id)
    {
        
          
        $tanks = Tank::find($id);
        $tanks->delete();
        
        if($tanks)
        {
        return redirect(route('blending_settings.index'))->with(['success'=>'Tank Number  deleted successfully']);
        }
      
    }
    
    public function destroy2($id)
    {

        $lines = Line::find($id);
        $lines->delete();
        
        if($lines)
        {
        return redirect(route('blending_settings.index'))->with(['success'=>'Line Number deleted successfully']);
        }
    }
    
    public function destroy3($id)
    {
        
         $flavors = Flavor::find($id);
          
         $flavors->delete();
         
      if($flavors)
        {
         return redirect(route('blending_settings.index'))->with(['success'=>'flavor batch deleted successfully']);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy4($id)
    {
        
         $alcohols = Alcohol::find($id); 
         $alcohols->delete();
         
         return redirect(route('blending_settings.index'))->with(['success'=>'Alcohol Percentage  deleted successfully']);
        
      
    }
    
    public function destroy5($id)
    {
        
          $products = Type::find($id);
          $products->delete();
          if($products)
        {
          return redirect(route('blending_settings.index'))->with(['success'=>'Product Type  deleted successfully']);
        }
      
    }
    
    
    public function destroy6($id)
    {
        
     
          $packs = Pack::find($id);
          $packs->delete();
          if($packs)
        {
          return redirect(route('blending_settings.index'))->with(['success'=>'Pack Size  deleted successfully']);
        }
      
    }
}
