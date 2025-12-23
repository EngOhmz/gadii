<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Hash;
use App\Models\Region;
use App\Models\District;
use App\Models\FarmLand;
use App\Models\Land_properties;
use App\Models\Product_tools;
use App\Models\Role;
use App\Models\Ward;
use Illuminate\Support\Facades\DB;

class FarmerController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        // $user_id= $id;

        // $user=User::find($user_id)->farmer->isNotEmpty();
        $user = Farmer::where('user_id', $id)->get();

        // return response()->json($user,200);
        
        if($user->isNotEmpty()){

            foreach($user as $row){

                $data['name'] = $row->firstname. " ". $row->lastname;

                $data['national_id'] = $row->national_id;


                $data['picture'] = url('season_images/'.$row->picture);

                // $data['lastname'] = $row->lastname;
                $data['email'] = $row->email;

                $data['phone'] = $row->phone;
    
                $data['id'] = $row->id;
                // $data['firstname'] = $row->firstname;
                // $data['region'] = $row->region->name;
                // $data['district'] = $row->district->name;
                if(!empty($row->region_id)){
                   $data['location'] = $row->ward->name. ",".$row->district->name. ",".$row->region->name; 
                }
                elseif(!empty($row->city)){
                    $data['location'] = $row->city;
                }
                
                elseif(!empty($row->province)){
                    $data['location'] = $row->province;
                }
                
                $lands = Land_properties::where('owner_id', $row->id)->get();
                if($lands->isNotEmpty()){

                $data['land'] = Land_properties::where('owner_id', $row->id)->count();

                }
                else{

                    $data['land'] = 0;
                }

                $products = Product_tools::where('owner_id', $row->id)->get();

                if($products->isNotEmpty()){

                $y = Product_tools::where('owner_id', $row->id)->sum('quantity');
                $data['assets'] = (int) $y;

                }
                else{
                    $data['assets'] = 0;
                }
                // $data['lastname'] = $row->lastname;
                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','farmer'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No farmers found'];
            return response()->json($response,200);
        } 
    }

    public function get_farmer(int $id, int $lastId)
    {
        // $user_id= $id;

        // $user=User::find($user_id)->farmer->isNotEmpty();
        $user = Farmer::where('user_id', $id)->where('id', '>' ,$lastId)->get();

        // return response()->json($user,200);
        
        if($user->isNotEmpty()){

            foreach($user as $row){
                $data = $row;

                $data['name'] = $row->firstname." ".$row->lastname;

                $data['national_id'] = $row->national_id;


                $data['picture'] = url('season_images/'.$row->picture);




                if(!empty($row->region_id)){
                   $data['location'] = $row->ward->name. ",".$row->district->name. ",".$row->region->name; 
                }
                elseif(!empty($row->city)){
                    $data['location'] = $row->city;
                }
                
                elseif(!empty($row->province)){
                    $data['location'] = $row->province;
                }
                
                $lands = Land_properties::where('owner_id', $row->id)->get();
                if($lands->isNotEmpty()){

                $data['land'] = Land_properties::where('owner_id', $row->id)->count();

                }
                else{

                    $data['land'] = 0;
                }

                $products = Product_tools::where('owner_id', $row->id)->get();

                if($products->isNotEmpty()){

                $y = Product_tools::where('owner_id', $row->id)->sum('quantity');
                $data['assets'] = (int) $y;

                }
                else{
                    $data['assets'] = 0;
                }
                // $data['lastname'] = $row->lastname;
                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','farmer'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No farmers found'];
            return response()->json($response,200);
        } 
    }

    public function get_agronomy(){
            // $role = Role::where('id', $roleId)->value('slug');
            // $user['role'] = $role;
        $agronomy_role_id = Role::where('slug', 'Agronomy')->value('id');
        $agronomy_users = DB::table('users_roles')->where('role_id', $agronomy_role_id)->get();
        // $agronomy = User::all();


        if($agronomy_users->isNotEmpty()){

            foreach($agronomy_users as $ag){

                $agronomy =  User::where('id', $ag->user_id )->get();
               
                foreach($agronomy as $row){
                    $data = $row;

                    $farmers[] = $data;


                }



     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','agronomy'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Agronomy found'];
            return response()->json($response,200);
        } 



    }

    public function get_agronomyOff(int $lastId){
        $agronomy_role_id = Role::where('slug', 'Agronomy')->value('id');
        $agronomy_users = DB::table('users_roles')->where('role_id', $agronomy_role_id)->get();
        // $agronomy = User::all();


        if($agronomy_users->isNotEmpty()){

            foreach($agronomy_users as $ag){
                

                $agronomy =  User::where('id', $ag->user_id)->where('id', '>' ,$lastId)->get();

                if($agronomy->isNotEmpty()){

                    foreach($agronomy as $row){
                    
                        $data = $row;

                        $farmers[] = $data;


                     }
                }
                else{

                    $farmers = [];
                }
               
              



     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','agronomy'=> $farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Agronomy found'];
            return response()->json($response,200);
        } 

    }
    public function get_regions(){

        $region=Region::all();
        return response()->json($region,200);

    }

    public function get_Alldistricts(){

        $district= District::all();
        return response()->json($district,200);

    }

    public function get_Allwards(){

        $ward = Ward::all();
        return response()->json($ward,200);

    }

    public function get_districts(int $id){

        $district= District::where('region_id', $id)->get();
        return response()->json($district,200);

    }

    public function get_wards(int $id){

        $ward = Ward::where('district_id', $id)->get();
        return response()->json($ward,200);

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
        
        $this->validate($request,[
            'firstname'=>'required',
            'lastname'=>'required',
            'phone'=>'required',

        ]); 
        
        //$data=$this->request();
        //$data['user_id'] =auth()->user()->id;
        //$farmer= Farmer::create($data);
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
      
        $farmer= new Farmer();

        $farmer->firstname=$request->input('firstname');
        $farmer->lastname=$request->input('lastname');
        $farmer->phone=$request->input('phone');
        $farmer->email=$request->input('email');
        $farmer->region_id=$request->input('region_id');
         $farmer->district_id=$request->input('district_id');
      
        $farmer->ward_id=$request->input('ward_id');
        
        $farmer->amcos_id=$request->input('amcos_id');
        
        $farmer->city=$request->input('city');
        $farmer->province=$request->input('province');

        $farmer->address=$request->input('address');
        $farmer->group_id=$request->input('group_id');
        $farmer->user_id=$request->input('user_id');

        $farmer->national_id=$request->input('national_id');
        $farmer->dob=$request->input('dob');
        $farmer->picture=$picture2;


        $farmer->save();

        $name = $request->input('firstname')." ".$request->input('lastname');
        // $address = $request->input('')

        $country = User::find( $request->input('user_id'))->country;

        $user =  User::create([
            'name' => $name,
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'country' => $country,
            'address' => $request->input('address'),
            'status' => "1",
            'password' => Hash::make($request->input('phone')),
        ]);

        $farmer['picture'] = url('season_images/'.$picture2);
        
        $farmer['country'] = $country;


        if($farmer)
        {

            $response=['success'=>true,'error'=>false,'message'=>'New Farmer registered successful','farmer'=>$farmer];
            return response()->json($response,200);
        }
        else
        {
            $response=['success'=>false,'error'=>true,'message'=>'Failed to register new Farmer'];
            return response()->json($response,200);
        }

        //return view('manage-farmer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id=auth()->user()->id;
        $user=User::find($user_id);
        $farmer=Farmer::find($id);
      $region=Region::all();
         $district= District::where('region_id', $farmer->region_id)->get();  
       $ward= Ward::where('district_id', $farmer->district_id)->get();
        $group=User::find($user_id)->group;
        if(empty($farmer))
        {

            $response=['success'=>false,'error'=>true,'farmer'=>$user->farmer];
            return response()->json($response,200);

        }
        else
        {
            
            $response=['success'=>true,'error'=>false,'farmer'=>$farmer,'group'=>$group,'region'=> $region, 'district' => $district, 'ward' => $ward];
            return response()->json($response,200);
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
        $farmer=Farmer::find($id);
        $user_id=auth()->user()->id;
        $user=User::find($user_id);
         $region=Region::all();
         $district= District::where('region_id', $farmer->region_id)->get();  
      $ward= Ward::where('district_id', $farmer->district_id)->get();
        $farm=User::find($user_id)->farmer;
        //return view('agrihub.dashboard');
        $group=User::find($user_id)->group;


        $response=['success'=>true,'error'=>false,'farmer'=>$farmer,'group'=>$group,'region'=> $region, 'district' => $district, 'ward' => $ward,'id' => $id,'farm' => $farm];
        return response()->json($response,200);
       
        
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
        $data=Farmer::find($id);
         $this->validate($request,[
            'firstname'=>'required',
            'lastname'=>'required',
            'phone'=>'required',

        ]); 
       
        $result=$request->all();
        //print_r($result);
        $result['user_id']=auth()->user()->id;
        
        $data->update($result);
         //retrieve data for manage user page
        $user_id=auth()->user()->id;
        $user=User::find($user_id);
        //Validate update of data 
        if($data)
        {
            $response=['success'=>true,'error'=>false,'message'=>'Updated Successfuly '];
            return response()->json($response,200);
        }
        else
        {
            // return view('agrihub.manage-farmer')->with('farmer',$user->farmer);

            $response=['success'=>false,'error'=>true,'message'=>'Updated Failed ', 'farmer' => $user->farmer];
            return response()->json($response,200);
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
        $data=Farmer::find($id);
        $data->delete();
        if($data)
        {

            $response=['success'=>true,'error'=>false,'message'=>'Deleted Successfuly '];
            return response()->json($response,200);
        }
    }

public function findRegion(Request $request)
    {

        $district= District::where('region_id',$request->id)->get(); 
        if ($district) {
            $response=['success'=>true,'error'=>false,'message'=>'Regions Founds', 'district' => $district];
            return response()->json($response, 200);
        }
        else{
            $response=['success'=>false,'error'=>true,'message'=>'Regions Not Founds'];
            return response()->json($response, 200);
        }                                                                                    
               

}

public function findDistrict(Request $request)
    {

        $ward= Ward::where('district_id',$request->id)->get();  
        if ($ward) {
            $response=['success'=>true,'error'=>false,'message'=>'Ward Founds', 'ward' => $ward];
            return response()->json($response, 200);
        }
        else{
            $response=['success'=>false,'error'=>true,'message'=>'Ward Not Founds'];
            return response()->json($response, 200);
        }                                      

}


   public function assign_farmer()
    {
        $farm_all=Farmer::orderBy('id','DESC')->get();

        $response=['success'=>true,'error'=>false,'message'=>'Updated Successfuly', 'farm_all' => $farm_all];
        return response()->json($response,200); 
    }

public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;
                if($type == 'assign'){
                    $data =  Farmer::find($id);
                    $staff=User::where('role','agronomy')->get();
                    // return view('agrihub.adduser',compact('id','data','staff')); 
                    
                    $response=['success'=>true,'error'=>false,'message'=>'Updated Successfuly', 'id' => $id, 'data' => $data, 'staff' => $staff];
                    return response()->json($response,200);
                 }

                 }

 public function save_farmer(Request $request){
                     //
                     $farmer =  Farmer::find($request->id);
                     $data['assign']=$request->assign;
                      $farmer->update($data);
        
                 if($farmer)
        {
            // $messagev="Farmer Assigned Successfully'";
            // return redirect('/assign_farmer')->with('messagev',$messagev);

            $response=['success'=>true,'error'=>false,'message'=>'Farmer Assigned Successfully'];
            return response()->json($response,200);
        }
              

                 }


}
