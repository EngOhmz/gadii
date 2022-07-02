<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use  App\Models\POS\Items;

class ItemsController extends Controller
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
            $data = Items::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('action', function($row){
                        return '<button type="button" class="btn btn-xs btn-outline-info"
                        data-toggle="modal" data-target="#handoutModal"
                        data-id="' . $row->id . '" data-type="edit">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-xs btn-outline-warning"
                        data-toggle="modal" data-target="#handoutModal"
                        data-id="' . $row->id . '" data-type="show">
                        <i class="fa fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-xs btn-outline-danger" onclick="deleteHandout(this)"
                        data-id="' .  $row->id . '">
                        <i class="fa fa-trash"></i>
                    </button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('pos.items.index');
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
        $data = $request->all();
        $data['added_by'] = auth()->user()->added_by;
        $items = Items::create($data);

        return redirect(route('items.index'));
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
        //
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
    }
}
