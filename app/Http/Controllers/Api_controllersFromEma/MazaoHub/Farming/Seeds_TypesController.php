<?php

namespace App\Http\Controllers\farming;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\farming\Seeds_Type;
use App\Models\Crops_type;
use Yajra\DataTables\DataTables;

class Seeds_TypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $seeds_type = Seeds_Type::all();

        if ($request->ajax()) {
            $data = Seeds_Type::all();

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
                    ->editColumn('harvest_volume', function ($row) {
                        return $row->harvest_volume.' kg';
                   })
                   ->rawColumns(['action'])
                    ->make(true);
        }

        return view('seeds_type.manage_seeds_type',compact('seeds_type'));
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
        // $this->validate($request, [
        //     'name' => 'required',
            
        // ]);
        //
        $data = $request->all();
        $data['user_id'] = auth()->user()->added_by;

        $result = Seeds_type::create($data);

        return response(['message' => true]);
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
                $crop_types = Crops_type::all();
                return view('seeds_type.add',compact('crop_types'));
                break;
            case 'edit':
                $crop_types = Crops_type::all();
                //$data = Seeds_type::find($id);
                return view('seeds_type.add', compact('crop_types'));
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
