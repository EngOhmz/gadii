<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Group;
use App\Models\gmember;
use Illuminate\Support\Facades\DB;
class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('groups')->select('id','name', DB::raw('count(*) as total'))->groupBy('name')->get();
        // return view('agrihub.manage-group')->with('group',$data);

        if($data->isNotEmpty()){

            $response=['success'=>true,'error'=>false,'message'=>'successfully','group'=>$data];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'failed'];
            return response()->json($response,200);
        }
        
        //print_r($data);
    }

    public function indexOff(int $lastId)
    {
        $data = DB::table('groups')->where('id', '>' ,$lastId)->select('id','name', DB::raw('count(*) as total'))->groupBy('name')->get();
        // return view('agrihub.manage-group')->with('group',$data);

        if($data->isNotEmpty()){

            $response=['success'=>true,'error'=>false,'message'=>'successfully','group'=>$data];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'failed'];
            return response()->json($response,200);
        }
        
        //print_r($data);
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
            'name'=>'required:unique',
            'id' => 'required',  
        ]); 
        
        //$data=$this->request();
        //$data['user_id'] =auth()->user()->id;
        //$farmer= Farmer::create($data);
      
        $group= new Group();

        $group->name=$request->input('name');
        $group->user_id=$request->input('id');
        $group->save();
        if($group)
        {
            //  $messagev="New group of farmer registered successful";
            // return redirect('manage-group')->with('messagev',$messagev);

            $response=['success'=>true,'error'=>false,'message'=>'New group of farmer registered successful', 'group' => $group];
            return response()->json($response,200);
       
        }
         else
         {
            // $messager="Failed to register new Group";
            // return redirect('manage-group')->with('messager',$messager);

            $response=['success'=>false,'error'=>true,'message'=>'Failed to register new Group'];
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
        $data=Group::find($id);
         $this->validate($request,[
            'name'=>'required',
            
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
            // $messagev="Success Updated'";
            // return redirect('manage/group')->with('messagev',$messagev);

            $response=['success'=>true,'error'=>false,'message'=>'Success Updated'];
            return response()->json($response,200);
        }
        else
        {
            // return view('manage/group')->with('farmer',$user->farmer);

            $response=['success'=>false,'error'=>true,'message'=>'Failed to register new Group', 'farmer' => $user->farmer];
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
        $data=Group::find($id);
        $data->delete();
        if($data)
        {
            // $messagev="Group deleted";
            // return redirect('manage-group')->with('messagev',$messagev);

            $response=['success'=>true,'error'=>false,'message'=>'Group Deleted Successfuly '];
            return response()->json($response,200);
        }
    }
}
