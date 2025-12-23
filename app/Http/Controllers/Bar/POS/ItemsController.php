<?php

namespace App\Http\Controllers\Bar\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use  App\Models\Bar\POS\Items;
use App\Models\Bar\POS\Activity;

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
            $data = Items::select('*')->where('added_by',auth()->user()->added_by);
            return Datatables::of($data)
                    ->addIndexColumn()
                          ->editColumn('cost_price', function ($row) {
                        return number_format($row->cost_price,2);
                   })
                       ->editColumn('sales_price', function ($row) {
                        return number_format($row->sales_price,2);
                   })
                     ->editColumn('quantity', function ($row) {
                        return number_format($row->quantity,2);
                   })

                    ->editColumn('action', function($row){
               $action=' <div class="form-inline"><a href="'.route('store_items.edit',$row->id).'"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
                    <a href="javascript:void(0)"   onclick = "deleteItem('.$row->id.')"  title="Delete " class="list-icons-item text-danger delete" > <i class="icon-trash"></i> </a>&nbsp
                                </div>';
                      
                    return $action;   
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('bar.pos.items.index');
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

       if(!empty($items)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$items->id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $items->name. "  Created",
                        ]
                        );                      
       }

       
        return redirect(route('store_items.index'))->with(['success'=>'Created Successfully']);
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
       $data=Items::find($id);
    return view('bar.pos.items.index',compact('data','id'));
    
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
     $item=Items::find($id);
     $data = $request->all();
        $item->update($data);

if(!empty($item)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $item->name. "  Updated",
                        ]
                        );                      
       }
        
    return redirect(route('store_items.index'))->with(['success'=>'Updated Successfully']);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        //
  $item=Items::find($id);
 $name=$item->name;
        $item->delete();

if(!empty($item)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Inventory',
                            'activity'=>"Inventory " .  $name. "  Deleted",
                        ]
                        );                      
       }
        
return response()->json(['success'=>'Deleted Successfully']);
    }
}
