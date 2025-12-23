<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Dd_Version;
use Illuminate\Http\Request;
use App\Models\Product_tools;
use App\Models\User;
use App\Models\Farmer;
use App\Models\Land_properties;
use App\Models\Region;
use App\Models\District;
use App\Models\Ward;
use DOMDocument;
use Illuminate\Support\Facades\DB;

class Farmer_assetsController extends Controller
{
   public function get_version2(){

        $tools = Dd_Version::select('id','name','priority')->orderBy('id', 'DESC')->first();

    //    $tools = DB::table('db_Version')->select('id','name','priority')->orderBy('id', 'DESC')->limit('1');

        if($tools){

            

            $response=['success'=>true,'error'=>false,'message'=>'Version Found successful', 'data' => $tools];
           return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'Version Not Found'];
            return response()->json($response,200);

        }


   }

   public function store_version(Request $request){

        $this->validate($request,[
            'name'=>'required',
            'priority'=>'required',
        ]);

        $data = new Dd_Version();

        // $doc = new DOMDocument();

        // $dom = new \DomDocument();

        $data->name = $request->input('name');
        $data->priority = $request->input('priority');

        $data->save();

        if($data){

            $response=['success'=>true,'error'=>false,'message'=>'Version Saved successful', 'data' => $data];
           return response()->json($response,200);
        }

        else{

            $response=['success'=>false,'error'=>true,'message'=>'Version Not Saved'];
            return response()->json($response,200);
        }

        
        


   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
      $lands=Land_properties::where('owner_id', $id)->get();
    //   $user = Farmer::where('user_id', $id)->where('id', '>' ,$lastId)->get();

      $farmer=Farmer::all();
     //print_r($land);
        // return view('agrihub.manage-land')->with('farmer',$land)->with('owner',$farmer)->with('farmer2',$land)->with('farmer3',$land)->with('owneredit',$farmer);
   
        if($lands->isNotEmpty()){

          foreach($lands as $row){

            if(!empty($row->region_id)){
                    $region = Region::where('id', $row->region_id)->value('name');
                    $district = District::where('id', $row->district_id)->value('name');
                    $ward = Ward::where('id', $row->ward_id)->value('name');
                    $data['location'] = $ward. ",".$district. ",".$region; 
                }
                elseif(!empty($row->province) && !empty($row->city)){
                    $data['location'] = $row->city.",".$row->province;
                }
                elseif(!empty($row->province)){
                    $data['location'] = $row->province;
                }
                elseif(!empty($row->city)){
                    $data['location'] = $row->city;
                }
                else{
                    $data['location'] = $row->location;
                }
            
           

            $data['picture'] = url('season_images/'.$row->picture);


            
            $data['land_value'] = $row->land_value;
            $data['size'] = $row->size;
            $data['owner_id'] = $row->owner_id;

            $data['id'] = $row->id;

            $farmers[] = $data;    
        }
        $response=['success'=>true,'error'=>false,'message'=>'Lands Found successful', 'farmer' => $farmers];
           return response()->json($response,200);

            
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'Lands Not Found'];
            return response()->json($response,200);
        }

    //    $tools = Product_tools::all();
    //    $farmer = Farmer::all();
    //    $type = "tool";
    //  $region=Region::all();
    //    $land = Land_properties::all();
    //     return view('farmer_assets.manage_assets',compact('tools','land','type','farmer','region'));
       
    }

    public function indexOff(int $id, int $lastId)
    {
      $lands=Land_properties::where('owner_id', $id)->where('id', '>' ,$lastId)->get();
    //   $user = Farmer::where('user_id', $id)->where('id', '>' ,$lastId)->get();

      $farmer=Farmer::all();
     //print_r($land);
        // return view('agrihub.manage-land')->with('farmer',$land)->with('owner',$farmer)->with('farmer2',$land)->with('farmer3',$land)->with('owneredit',$farmer);
   
        if($lands->isNotEmpty()){

          foreach($lands as $row){

            
            if(!empty($row->region_id)){
                    $region = Region::where('id', $row->region_id)->value('name');
                    $district = District::where('id', $row->district_id)->value('name');
                    $ward = Ward::where('id', $row->ward_id)->value('name');
                    $data['location'] = $ward. ",".$district. ",".$region; 
                }
                elseif(!empty($row->province)){
                    $data['location'] = $row->province;
                }
                elseif(!empty($row->city)){
                    $data['location'] = $row->city;
                }

            $data['picture'] = url('season_images/'.$row->picture);

            $data['land_value'] = $row->land_value;
            $data['size'] = $row->size;
            $data['owner_id'] = $row->owner_id;

            $data['id'] = $row->id;

            $farmers[] = $data;    
        }
        $response=['success'=>true,'error'=>false,'message'=>'Lands Found successful', 'farmer' => $farmers];
           return response()->json($response,200);

            
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'Lands Not Found'];
            return response()->json($response,200);
        }

    //    $tools = Product_tools::all();
    //    $farmer = Farmer::all();
    //    $type = "tool";
    //  $region=Region::all();
    //    $land = Land_properties::all();
    //     return view('farmer_assets.manage_assets',compact('tools','land','type','farmer','region'));
       
    }

    public function index1(int $id)
    {
      $tools=Product_tools::where('owner_id', $id)->get();
      $farmer=Farmer::all();
   
        if($tools->isNotEmpty()){

            foreach($tools as $row){
                                                
                $data = $row;
                $data['picture'] = url('season_images/'.$row->picture);
    
                $farm_program[] = $data;    
            }
         
          $response=['success'=>true,'error'=>false,'message'=>'Assets Found successful', 'farmer_assets' => $farm_program];
           return response()->json($response,200);

            
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'Assets Not Found'];
            return response()->json($response,200);
        }
       
    }

    public function index1Off(int $id, int $lastId)
    {
      $tools=Product_tools::where('owner_id', $id)->where('id', '>' ,$lastId)->get();
      $farmer=Farmer::all();
   
        if($tools->isNotEmpty()){

            foreach($tools as $row){
                                                
                $data = $row;
                $data['picture'] = url('season_images/'.$row->picture);
    
                $farm_program[] = $data;    
            }
         
          $response=['success'=>true,'error'=>false,'message'=>'Assets Found successful', 'farmer_assets' => $farm_program];
           return response()->json($response,200);

            
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'Assets Not Found'];
            return response()->json($response,200);
        }
       
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

        $this->validate($request,[
            'reg_no'=>'required',
            'size'=>'required',
            'id'=>'required',
        ]); 
        // $owner_id=$id;
        //$user=User::find($user_id);
        //$data=$this->request();
        if ($request->hasFile('picture')) {
            $photo=$request->file('picture');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            $logo=$fileName;
            $photo->move('season_images', $fileName );
             $picture2 = $logo;

        }
        else{
            $picture2 = "";
        }

        $data= new Land_properties();


        $data->reg_no=$request->input('reg_no');
        $data->region_id=$request->input('region_id');
        $data->district_id=$request->input('district_id');
        $data->ward_id=$request->input('ward_id');
        $data->province=$request->input('province');
        $data->city=$request->input('city');
        $data->location=$request->input('location');
        $data->size=$request->input('size');
        $data->coordinates=$request->input('coordinates');
        $data->land_value=$request->input('land_value');
        $data->owner_id=$request->input('id');
        $data->picture=$picture2;

        
        $data->save();

        $data['picture'] = url('season_images/'.$picture2);

        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'New land asset registered', 'data' => $data];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to register new land asset'];
            return response()->json($response,200);
        }
        
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store1(Request $request)
    {
        
        // $this->validate($request,[
        //     'firstname'=>'required',
        //     'lastname'=>'required',
        //     'phone'=>'required',
        //     'address'=>'required'
        // ]); 

        
        $this->validate($request,[
            'tool_name'=>'required',
            'quantity'=>'required',
            'units'=>'required',
            'farmer_id'=>'required',
        ]); 
        // $owner_id=$id;
        //$user=User::find($user_id);
        //$data=$this->request();
        if ($request->hasFile('picture')) {
            $photo=$request->file('picture');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            $logo=$fileName;
            $photo->move('season_images', $fileName );
             $picture2 = $logo;

        }
        else{
            $picture2 = "";
        }

        $data= new Product_tools();
        $data->tool_name=$request->input('tool_name');
        $data->quantity=$request->input('quantity');
        $data->units=$request->input('units');
        $data->owner_id=$request->input('farmer_id');
        $data->picture=$picture2;


        $data->save();

        $data['picture'] = url('season_images/'.$picture2);

        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'New  Asset registered', 'data' =>$data];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to register new Asset'];
            return response()->json($response,200);
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