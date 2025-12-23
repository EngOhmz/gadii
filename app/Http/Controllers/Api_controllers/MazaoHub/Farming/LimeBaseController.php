<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\Farming;


use App\Http\Controllers\Controller;
use App\Models\LimeBase;
use Illuminate\Http\Request;

class LimeBaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $limebase =LimeBase::all();

        if($limebase->isNotEmpty()){

        
            $response=['success'=>true,'error'=>false,'message'=>'Lime Base  Founds successful', 'limebase' => $limebase];
            return response()->json($response,200);
    
            
            }
            else{
    
            $response=['success'=>false,'error'=>true,'message'=>'Lime Base Not Found'];
            return response()->json($response,200);
            }
    }

    public function indexOff(int $lastId)
    {
        //
        // $limebase =LimeBase::all();

        $limebase=LimeBase::where('id', '>' ,$lastId)->get();


        if($limebase->isNotEmpty()){

        
            $response=['success'=>true,'error'=>false,'message'=>'Lime Base  Founds successful', 'limebase' => $limebase];
            return response()->json($response,200);
    
            
            }
            else{
    
            $response=['success'=>false,'error'=>true,'message'=>'Lime Base Not Found'];
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
    public function store(Request $request)
    {
        //

        $this->validate($request,[
            'name'=>'required',
            'type'=>'required',

        ]); 

        $data= new LimeBase();
        $data->name=$request->input('name');
        $data->type=$request->input('type');
        $data['added_by']=$request->input('id');
        $data->save();
        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'New LimeBase  registered', 'limebase' => $data];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to register new LimeBase'];
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
        $data =  LimeBase::find($id);
        return view('farming.base',compact('data','id'));
 
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
        $price = LimeBase::find($id);

        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $price->update($data);
 
        return redirect(route('lime_base.index'))->with(['success'=>' Updated Successfully']);
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
 
        $price = LimeBase::find($id);
        $price->delete();
 
        return redirect(route('lime_base.index'))->with(['success'=>' Deleted Successfully']);
    }
}
