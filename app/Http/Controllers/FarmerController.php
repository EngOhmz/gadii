<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Group;
use App\Models\Region;
use App\Models\District;
use App\Models\Ward;

class FarmerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id=auth()->user()->id;
        $user=User::find($user_id)->farmer;
        $group=User::find($user_id)->group;
      $region=Region::all();
     $farm_all=Farmer::all();
        //return view('agrihub.dashboard');
        return view('agrihub.manage-farmer')->with('farm',$user)->with('group',$group)->with('region',$region);
        //print_r($user->farmer);
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
      
        $farmer= new Farmer();

        $farmer->firstname=$request->input('firstname');
        $farmer->lastname=$request->input('lastname');
        $farmer->phone=$request->input('phone');
        $farmer->email=$request->input('email');
        $farmer->region_id=$request->input('region_id');
      $farmer->district_id=$request->input('district_id');
        $farmer->address=$request->input('address');
        $farmer->group_id=$request->input('group_id');
        $farmer->user_id=$user_id=auth()->user()->id;
        $farmer->save();
        if($farmer)
        {
            $messagev="New Farmer registered successful'";
            return redirect('/farmer')->with('messagev',$messagev);
        }
        else
        {
            $messager="Failed to register new Farmer'";
            return redirect('/farmer')->with('messager',$messager);
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
        
    
        //return view('agrihub.dashboard');
        return view('agrihub.manage-profile')->with('farmer',$user->farmer);

        }
        else
        {
            return view('agrihub.profile')->with('farmer',$farmer)->with('group',$group)->with('region',$region)->with('district',$district)->with('ward',$ward);
        }
        //return view('agrihub.profile');
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


        return view('agrihub.manage-farmer')->with('farmer',$farmer)->with('group',$group)->with('region',$region)->with('district',$district)->with('id',$id)->with('farm',$farm)->with('ward',$ward);

       
        
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
            $messagev="Success Updated'";
            return redirect('/farmer')->with('messagev',$messagev);
        }
        else
        {
            return view('agrihub.manage-farmer')->with('farmer',$user->farmer);
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
            $messagev="Success Deleted'";
            return redirect('/farmer')->with('messagev',$messagev);
        }
    }

public function findRegion(Request $request)
    {

        $district= District::where('region_id',$request->id)->get();                                                                                    
               return response()->json($district);

}

public function findDistrict(Request $request)
    {

        $ward= Ward::where('district_id',$request->id)->get();                                                                                    
               return response()->json($ward);

}


   public function assign_farmer()
    {
     $farm_all=Farmer::orderBy('id','DESC')->get();
        return view('agrihub.assign_farmer')->with('farm_all',$farm_all);
    }

public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;
                if($type == 'assign'){
                    $data =  Farmer::find($id);
                    $staff=User::where('role','agronomy')->get();
                    return view('agrihub.adduser',compact('id','data','staff'));   
                 }

                 }

 public function save_farmer(Request $request){
                     //
                     $farmer =  Farmer::find($request->id);
                     $data['assign']=$request->assign;
                      $farmer->update($data);
        
                 if($farmer)
        {
            $messagev="Farmer Assigned Successfully'";
            return redirect('/assign_farmer')->with('messagev',$messagev);
        }
              

                 }


}
