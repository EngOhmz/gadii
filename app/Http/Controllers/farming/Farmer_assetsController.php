<?php

namespace App\Http\Controllers\farming;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product_tools;
use App\Models\User;
use App\Models\Farmer;
use App\Models\Land_properties;
use App\Models\Region;
use App\Models\District;
use App\Models\Ward;

class Farmer_assetsController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $tools = Product_tools::all();
       $farmer = Farmer::all();
       $type = "tool";
     $region=Region::all();
       $land = Land_properties::all();
        return view('farmer_assets.manage_assets',compact('tools','land','type','farmer','region'));
       
    }

    public function index1()
    {
        $tools = Product_tools::all();
        $farmer = Farmer::all();
      $region=Region::all();
        $type = "land";
        $land = Land_properties::all();
         return view('farmer_assets.manage_assets',compact('tools','land','type','farmer','region'));
        
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // $this->validate($request,[
        //     'firstname'=>'required',
        //     'lastname'=>'required',
        //     'phone'=>'required',
        //     'address'=>'required'
        // ]); 
        
       
    
      if($request->type == "land"){

        $land_propertiees = Land_properties::create($request->all());
        return redirect(url('landview'))->with(['success'=>'Land Properties created successfully']);

      }else{

        $product_tool = Product_tools::create($request->all());
        return redirect(route('register_assets.index'))->with(['success'=>'Product Tool created successfully']);
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
        $type ="land";
        if($type == "land"){
            $data=Land_properties::find($id);
          $region=Region::all();
         $district= District::where('region_id', $data->region_id)->get(); 
         $ward= Ward::where('district_id', $data->district_id)->get();
        }else{
          

 
        }

        $farmer = Farmer::all();
         $region=Region::all();
        return view('farmer_assets.manage_assets',compact('data','type','id','farmer','region','district','ward'));
    }

    public function getFarm(Request $request){

      $data = Land_properties::all()->where('owner_id',$request->id);
       
      return response()->json(['data' => $data]);
    }
 
    public function edit($id)
    {    
        $type ="tool";
        if($type == "tool"){
            $data=Product_tools::find($id);
        }else{
          $data=Land_properties::find($id);
    $region=Region::all();
         $district= District::where('region_id', $data->region_id)->get(); 
        $ward= Ward::where('district_id', $data->district_id)->get();
        }

        $farmer = Farmer::all();

        return view('farmer_assets.manage_assets',compact('data','type','id','farmer','region','district','ward'));

        
     
    }


    public function update(Request $request, $id)
    { 
        
        //  $this->validate($request,[
        //     'firstname'=>'required',
        //     'lastname'=>'required',
        //     'phone'=>'required',
        //     'address'=>'required'
        // ]); 
       
        if($request->type == "land"){
            
            $land_propertiees = Land_properties::find($id);
            $land_propertiees->update($request->all());

            return redirect(url('landview'))->with(['success'=>'Land Properties updated successfully']);
    
          }else{
    
            $product_tool = Product_tools::find($id);
            $product_tool->update($request->all());
            return redirect(route('register_assets.index'))->with(['success'=>'Product Tool updated successfully']);
          }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=Product_tools::find($id);
        $data->delete();
        if($data)
        {
            
            return redirect(route('register_assets.index'))->with(['success'=>'Product Tool deleted successfully']);
    }
    
}

public function destroy1($id)
{
    $data=Land_properties::find($id);
    $data->delete();
    if($data)
    {
        
        return redirect(url('landview'))->with(['success'=>'Land Properties deleted successfully']);
}
}
}