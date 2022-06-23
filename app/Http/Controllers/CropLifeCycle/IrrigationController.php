<?php

namespace App\Http\Controllers\CropLifeCycle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\farming\IrrigationSystem;
use App\Models\farming\IrrigationSettings;
use App\Models\farming\IrrigationProcess;
use Yajra\DataTables\DataTables;

class IrrigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        

        if ($request->ajax()) {
            $data = IrrigationSettings::all();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return '<button type="button" class="btn btn-xs btn-outline-info"
                        data-toggle="modal" data-target="#appFormModal" onclick="model("'.$row->id.'","edit")"
                        data-id="' . $row->id . '" data-type="edit">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-xs btn-outline-danger" onclick="deleteContract(this)"
                        data-url="' . $row->id. '">
                        <i class="fa fa-trash"></i>
                    </button>';
                    })
        
                    ->editColumn('water_volume', function ($row) {
                        return $row->harvest_volume.' Litre';
                   })
                //     ->editColumn('harvest_volume', function ($row) {
                //         return $row->harvest_volume.' kg';
                //    })
                   ->rawColumns(['action'])
                    ->make(true);
        }

       // return view('seeds_type.manage_seeds_type',compact('seeds_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = IrrigationProcess::all();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return '<button type="button" class="btn btn-xs btn-outline-info"
                        data-toggle="modal" data-target="#appFormModal" onclick="model("'.$row->id.'","edit")"
                        data-id="' . $row->id . '" data-type="edit">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-xs btn-outline-danger" onclick="deleteContract(this)"
                        data-url="' . $row->id. '">
                        <i class="fa fa-trash"></i>
                    </button>';
                    })
        
                    ->editColumn('water_volume', function ($row) {
                        return $row->water_volume.' Litre';
                   })
                //     ->editColumn('harvest_volume', function ($row) {
                //         return $row->harvest_volume.' kg';
                //    })
                   ->rawColumns(['action'])
                    ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $this->validate($request, [
            'type' => 'required',
            
        ]);
        //
        $data = $request->all();

        $data['user_id'] = auth()->user()->added_by;
         
        $function = $request->type;

        if($request->type2 == "process"){
            $result = IrrigationProcess::create($data);
           // echo $data[];
        }else{
            $result = IrrigationSettings::create($data);
            //echo $data;
        }

       // $result = IrrigationProcess::create($data);
        
       return redirect()->route('cropslifecycle.index', $function)->with(['success'=>$function,'seasson_id'=>$request->seasson_id]);
        //return response(['message' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        //
        $applicant_id = $request->applicant_id;
        switch ($request->type) {
            case 'add':
                $irrigation_system = IrrigationSystem::all();
                return view('irrigation.addSettings',compact('irrigation_system'));
                break;
            case 'add2':
   
                //$data = Seeds_type::find($id);
                return view('irrigation.addProcess');
                break;

            default:
                return abort(404);
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
        //
        $data = Seeds_type::find($id);

        return view('seeds_type.manage_seeds_type',compact('data','id'));
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
        $data = $request->all();
        $data['user_id'] = auth()->user()->added_by;

        $result = Seeds_type::find($id);
        $result->update($data);

        return redirect(route('seeds_type.index'));
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
        $result = Seeds_type::find($id);
        if(!empty($result))
        $result->delete();

        return redirect(route('seeds_type'));
    }
}
