<?php
namespace App\Http\Controllers\Api_controllers\MazaoHub\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Group;
use App\Models\FarmLand;
class LandController extends Controller
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
        // $user_id=$id;
        $lands=FarmLand::where('farmer_id', $id)->get();
        // $user = Farmer::where('user_id', $id)->where('id', '>' ,$lastId)->get();

        $farmer=Farmer::all();
     //print_r($land);
        // return view('agrihub.manage-land')->with('farmer',$land)->with('owner',$farmer)->with('farmer2',$land)->with('farmer3',$land)->with('owneredit',$farmer);
   
        if($lands->isNotEmpty()){

            $response=['success'=>true,'error'=>false,'message'=>'Lands Found successful', 'farmer' => $lands];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>true,'error'=>false,'message'=>'Lands Not Found'];
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id)
    {
        $data= new FarmLand();
        $this->validate($request,[
            'registration'=>'required',
            'location'=>'required',
            'size'=>'required',
            'id'=>'required',
            'ownership'=>'required',
        ]); 
        $user_id=$id;
        //$user=User::find($user_id);
        //$data=$this->request();
        $data->farmer_id=$request->input('id');
        $data->user_id=$user_id;
        $data->regno=$request->input('registration');
        $data->size=$request->input('size');
        $data->ownership=$request->input('ownership');
        $data->location=$request->input('location');
        $data->farmer_id=$request->input('id');
        $data->save();
        if($data)
        {
           
        //     $messagev="New land asset registered";
        // return redirect('/farmer/land')->with('messagev',$messagev);

            $response=['success'=>true,'error'=>false,'message'=>'New land asset registered', 'data' =>$data];
            return response()->json($response,200);
        }
        else
        {
            // $messagev="Form have some errors";
            // return redirect('/farmer/land')->with('messager',$messagev);

            $response=['success'=>false,'error'=>true,'message'=>'Failed to register new land asset'];
            return response()->json($response,204);
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
        $data=FarmLand::find($id);
        $this->validate($request,[
            'registration'=>'required',
            'location'=>'required',
            'size'=>'required',
           
            'ownership'=>'required',
        ]); 
      
        $result['user_id']=auth()->user()->id;
        $result['farmer_id']=$id;
        $result=$request->all();
        $data->update($result);
        if($data)
        {
           
        //     $messagev="Details updated";
        // return redirect('land')->with('messagev',$messagev);

            $response=['success'=>true,'error'=>false,'message'=>'Details updated'];
            return response()->json($response,200);
        }
        else
        {
            // $messagev="Form have some errors";
            // return redirect('/farmer/land')->with('messager',$messagev);

            $response=['success'=>false,'error'=>true,'message'=>'Form have some errors'];
            return response()->json($response,204);
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
        
    $data=FarmLand::find($id);
    $data->delete();
    if($data)
    {
        // $messagev="Land asset deleted'";
        // return redirect('/farmer/land')->with('messager',$messagev);

            $response=['success'=>true,'error'=>false,'message'=>'Land asset deleted Successfuly '];
            return response()->json($response,200);
    }
    }
}
