<?php

namespace App\Http\Controllers\Pharmacy\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use  App\Models\Pharmacy\POS\Items1;
use  App\Models\Pharmacy\Items;
use  App\Models\Pharmacy\Category;

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
             $data = Items::select('*')->where('user_id',auth()->user()->added_by);
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
               $action=' <div class="form-inline"><a href="'.route('pharmacy_items.edit',$row->id).'"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
               <a href="javascript:void(0)"   onclick = "deleteItem('.$row->id.')"  title="Delete " class="list-icons-item text-danger delete" > <i class="icon-trash"></i> </a>&nbsp
                                </div>';
                      
                    return $action;   
                    })
                    ->rawColumns(['action'])
                    ->make(true);

 
        }
        
$category=Category::where('added_by',auth()->user()->added_by)->get();
        return view('pharmacy.pos.items.index',compact('category'));
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
        $data['user_id'] = auth()->user()->added_by;
        $items = Items::create($data);

        return redirect(route('pharmacy_items.index'))->with(['success'=>'Created Successfully']);;
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
 $category=Category::where('added_by',auth()->user()->added_by)->get();
    return view('pharmacy.pos.items.index',compact('data','id','category'));
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
        $data['user_id'] = auth()->user()->added_by;
        $item->update($data);
    return redirect(route('pharmacy_items.index'))->with(['success'=>'Updated Successfully']);;
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
    $items=Items::find($id);
    $items->delete();
    return redirect(route('pharmacy_items.index'))->with(['success'=>'Deleted Successfully']);;
// return response()->json(['success'=>'Deleted Successfully']);

    }

   public function addCategory(Request $request){
       
    
        $client= Category::create([
            'name' => $request['name'],
            'added_by'=> auth()->user()->added_by,
        ]);
        
      

        if (!empty($client)) {           
            return response()->json($client);
         }

       
   }
}
