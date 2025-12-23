<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Region;
use App\Models\District;
use Illuminate\Http\Request;
use DB;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       //
   $region = Region::all();   
       $route = Route::where('added_by',auth()->user()->added_by)->get();     
       return view('route.route',compact('route','region'));
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
// if($request->from_district_id != $request->to_district_id){
      $data=$request->post();
      $data['added_by']=auth()->user()->added_by;

     $from_region=Region::find($request->from_region_id);
      $to_region=Region::find($request->to_region_id);

    //      $from_district=District::find($request->from_district_id);
    //   $to_district=District::find($request->to_district_id);
      
      $specific_place = $request->depature_specific_place;
      
      $arrive_place = $request->arrive_specific_place;
      
    //   $data['from']=$from_region->name ." - ". $from_district->name ." - ". $specific_place ;
    //   $data['to']=$to_region->name ." - ". $to_district->name ;
    
     $data['from']=$specific_place ;
     $data['to']=$arrive_place;
    
      $route = Route::create($data);

      return redirect(route('routes.index'))->with(['success'=>'Route Created Successfully']);
//}

// else{
//     return redirect(route('routes.index'))->with(['error'=>'Start Point and Destination Point cannot be the same']);

// }

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
  $data =  Route::find($id);
 $region = Region::all(); 
// $from_district= District::where('region_id', $data->from_region_id)->get(); 
 // $to_district= District::where('region_id', $data->to_region_id)->get();   
       return view('route.route',compact('data','id','region'));

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
       $route = Route::find($id);
    // if($request->from_district_id != $request->to_district_id){
      $data=$request->post();
      $data['added_by']=auth()->user()->added_by;

     $from_region=Region::find($request->from_region_id);
      $to_region=Region::find($request->to_region_id);

       //  $from_district=District::find($request->from_district_id);
     // $to_district=District::find($request->to_district_id);
      
          
      $specific_place = $request->depature_specific_place;
      
      $arrive_place = $request->arrive_specific_place;
      

    
     $data['from']=$specific_place ;
     $data['to']=$arrive_place;
      
    //   $data['from']=$from_region->name ." - ". $from_district->name ;
    //   $data['to']=$to_region->name ." - ". $to_district->name ;

       $route->update($data);

       return redirect(route('routes.index'))->with(['success'=>'Route Updated Successfully']);

// }else{
//     return redirect(route('routes.index'))->with(['error'=>'Start Point and Destination Point cannot be the same']);

// }

   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($id)
   {
       //

       $route = Route::find($id);
       $route->delete();

       return redirect(route('routes.index'))->with(['success'=>'Route Deleted Successfully']);
   }


 public function findFromRegion(Request $request)
    {

        $district= District::where('region_id',$request->id)->get();                                                                                    
               return response()->json($district);

}
 public function findToRegion(Request $request)
    {

        $district= District::where('region_id',$request->id)->get();                                                                                    
               return response()->json($district);

}

 public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;

              
                    return view('route.addlocation',compact('id','type'));
                

}

public function addlocation(Request $request){
        
        $region= Region::create([
            'name' => $request['location'],
        ]);
        
    
        if (!empty($region)) {           
            return response()->json($region);
         }

       
   }


public function findlocation(Request $request){
       
$loc=Region::where(DB::raw('lower(name)'), strtolower($request->id))->first();  

    if (empty($loc)) {    
 $region='';    
}
else{
$region='error';

}
  
 return response()->json($region);
     
   }


}
