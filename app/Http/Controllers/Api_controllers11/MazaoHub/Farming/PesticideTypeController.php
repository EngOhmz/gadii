<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\Farming;


use App\Http\Controllers\Controller;
use App\Models\PesticideType;
use App\Models\Crops_type;
use Illuminate\Http\Request;

class PesticideTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pests =PesticideType::all();
    //    $crop=Crops_type::all();

       if($pests->isNotEmpty()){

        foreach($pests as $row){

            $data = $row;

            $farmers[] = $data; 
        }

        
        $response=['success'=>true,'error'=>false,'message'=>'Pesticide Type Found successful', 'pesticide_type' => $farmers];
        return response()->json($response,200);

        
        }
        else{

        $response=['success'=>false,'error'=>true,'message'=>'Pesticide Type Not Found'];
        return response()->json($response,200);
        }

    }

    public function indexOff(int $lastId)
    {
        //
        // $pests =PesticideType::all();
        $pests=PesticideType::where('id', '>' ,$lastId)->get();

    //    $crop=Crops_type::all();

       if($pests->isNotEmpty()){

        foreach($pests as $row){

            $data = $row;

            $farmers[] = $data; 
        }

        
        $response=['success'=>true,'error'=>false,'message'=>'Pesticide Type Found successful', 'pesticide_type' => $farmers];
        return response()->json($response,200);

        
        }
        else{

        $response=['success'=>false,'error'=>true,'message'=>'Pesticide Type Not Found'];
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

        $data= new PesticideType();
        $data->name=$request->input('name');
        $data->type=$request->input('type');
        $data['user_id']=$request->input('id');

        $data->save();
        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'New Pesticide Type registered', 'pesticide_type' => $data];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to register new Pesticide type'];
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
        
        $data =  PesticideType::find($id);
        $crop=Crops_type::all();
        return view('farming.pesticide_type',compact('data','id','crop'));
 
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
        
        $price = PesticideType::find($id);

        $data=$request->post();
         $data['user_id']=auth()->user()->id;
        $price->update($data);
 
        return redirect(route('pesticide_type.index'))->with(['success'=>'Updated Successfully']);
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
 
        $price = PesticideType::find($id);
        $price->delete();
 
        return redirect(route('pesticide_type.index'))->with(['success'=>' Deleted Successfully']);
    }
}
