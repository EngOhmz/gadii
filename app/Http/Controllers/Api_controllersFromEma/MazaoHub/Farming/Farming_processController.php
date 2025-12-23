<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\Farming;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Farming_process;


class Farming_processController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $gap = Farming_process::all();

        if($gap->isNotEmpty()){

        
            $response=['success'=>true,'error'=>false,'message'=>'Gap  Founds successful', 'gap' => $gap];
            return response()->json($response,200);
    
            
            }
            else{
    
            $response=['success'=>false,'error'=>true,'message'=>'Gap Not Found'];
            return response()->json($response,200);
            }

    }

    public function indexOff(int $lastId)
    {
        //
        $gap = Farming_process::where('id', '>' ,$lastId)->get();

        if($gap->isNotEmpty()){

        
            $response=['success'=>true,'error'=>false,'message'=>'Gap  Founds successful', 'gap' => $gap];
            return response()->json($response,200);
    
            
            }
            else{
    
            $response=['success'=>false,'error'=>true,'message'=>'Gap Not Found'];
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
            'process_name'=>'required',
        ]); 

        $data= new Farming_process();
        $data->process_name=$request->input('process_name');
        $data->save();
        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'New Gap  registered', 'gap' => $data];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to register new Gap'];
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
        $data = Farming_process::find($id);

        return view('farming_process.manage_farming_process',compact('id','data'));
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
        $process = Farming_process::find($id);
        $process->update($request->all());

        return redirect(route('farming_process.index'))->with(['success'=>"Updated successfully"]);
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
        $cost = Farming_process::find($id);
        $cost->delete();

        return redirect(route('farming_process.index'))->with(['success'=>"Deleted successfuly"]);
    }
}

