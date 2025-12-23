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
use App\Models\POS\Items;
use App\Models\POS\MasterHistory;
use App\Models\POS\Activity;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\Category;
use App\Models\POS\Color;
use App\Models\POS\Size;
use App\Models\Supplier;
use App\Models\POS\SerialList;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Branch;
use DB;
use App\Models\Package;

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
            $data = Items::select('*')->where('disabled', '0')->where('restaurant', '0')->whereIn('type', [1, 4, 6])->where('added_by', auth()->user()->added_by);
            return Datatables::of($data)
                ->addIndexColumn()



                ->editColumn('name', function ($row) {

                    $c = Color::find($row->color);
                    $s = Size::find($row->size);

                    if (!empty($c) && empty($s)) {
                        $name = $row->name . ' - ' . $c->name;
                        return '<a href="#" onclick = "model3(' . $row->id . ')" data-id3 = "' . $row->id . '" data-type="details"  class="details" title="Details"  data-toggle="modal" data-target="#appFormModal">' . $name . '</a>';
                    } elseif (empty($c) && !empty($s)) {
                        $name = $row->name . ' - ' . $s->name;
                        return '<a href="#" onclick = "model3(' . $row->id . ')" data-id3 = "' . $row->id . '" data-type="details"  class="details" title="Details"  data-toggle="modal" data-target="#appFormModal">' . $name . '</a>';
                    } elseif (!empty($c) && !empty($s)) {
                        $name = $row->name . ' - ' . $c->name . ' - ' . $s->name;
                        return '<a href="#" onclick = "model3(' . $row->id . ')" data-id3 = "' . $row->id . '" data-type="details"  class="details" title="Details"  data-toggle="modal" data-target="#appFormModal">' . $name . '</a>';
                    } else {

                        $name = $row->name;
                        return '<a href="#" onclick = "model3(' . $row->id . ')" data-id3 = "' . $row->id . '" data-type="details"  class="details" title="Details"  data-toggle="modal" data-target="#appFormModal">' . $name . '</a>';

                    }


                })
                ->editColumn('type', function ($row) {
                    if ($row->type == 1) {
                        return 'Inventory';
                    } elseif ($row->type == 2) {
                        return 'Manufacturing';
                    } elseif ($row->type == 3) {
                        return 'Raw Material';
                    } elseif ($row->type == 4) {
                        return 'Service';
                    } elseif ($row->type == 5) {
                        return 'Semi Finished Goods';
                    } elseif ($row->type == 6) {
                        return 'Inventory';
                    }


                })
                ->editColumn('cost_price', function ($row) {
                    return number_format($row->cost_price, 2);
                })
                ->editColumn('sales_price', function ($row) {
                    return number_format($row->sales_price, 2);
                })
                ->editColumn('quantity', function ($row) {
                    // Check if the type is 6 (or whatever type indicates a crate-based system)
                    if ($row->type == 6) {
                        // Ensure crate_size is greater than zero to avoid division by zero
                        if ($row->crate_size > 0) {
                            // Number of full crates (floor division)
                            $crates = floor($row->quantity / $row->crate_size);
                            // Remaining bottles (remainder)
                            $remainingBottles = $row->quantity % $row->crate_size;

                            // Format the result (crates and remaining bottles)
                            return number_format($crates) . ", " . number_format($remainingBottles);
                        }
                    } else {
                        // For other types, simply return the quantity as is (formatted)
                        return number_format($row->quantity);
                    }
                })
                                

                ->editColumn('action', function ($row) {
                    $action = '';
                    if ($row->type == 4) {
                        $action = ' <div class="form-inline"><a href="' . route('items.edit', $row->id) . '"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
                    <a href="javascript:void(0)"   onclick = "deleteItem(' . $row->id . ')"  title="Delete " class="list-icons-item text-danger delete" > <i class="icon-trash"></i> </a>&nbsp
    
                                </div>';
                    } else {

                        if($row->type == 6){


                            if (empty($row->barcode)) {
                                            $action = ' <div class="form-inline"><a href="' . route('items.edit', $row->id) . '"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
                                    <a href="javascript:void(0)"   onclick = "deleteItem(' . $row->id . ')"  title="Delete " class="list-icons-item text-danger delete" > <i class="icon-trash"></i> </a>&nbsp
                                <div class="dropdown"><a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a><div class="dropdown-menu">
                    
                        
                        <a href="#" onclick = "model(' . $row->id . ')" data-id = "' . $row->id . '"  data-type="crate_qty" class="nav-link updt" title="Update"  data-toggle="modal" data-target="#appFormModal"> Update Wholesale</a>
                                        
                                                    </div></div>
                                                
                                                </div>';
                                        } else {
                                            $action = ' <div class="form-inline"><a href="' . route('items.edit', $row->id) . '"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
                                    <a href="javascript:void(0)"   onclick = "deleteItem(' . $row->id . ')"  title="Delete " class="list-icons-item text-danger delete" > <i class="icon-trash"></i> </a>&nbsp
                    <div class="dropdown"><a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a><div class="dropdown-menu">
                            
                            <a href="#"  onclick = "model(' . $row->id . ')" data-id = "' . $row->id . '" data-type="crate_qty"  class="nav-link updt" title="Update"  data-toggle="modal" data-target="#appFormModal"> Update Wholesale</a>
                            <a href="#" onclick = "model2(' . $row->id . ')" data-id2 = "' . $row->id . '" data-type="print"  class="nav-link updt" title="Update"  data-toggle="modal" data-target="#appFormModal"> Print Barcode</a>
                                                    </div></div>
                                                
                                                </div>';
                                        }

                        }

                        elseif (empty($row->barcode)) {
                            $action = ' <div class="form-inline"><a href="' . route('items.edit', $row->id) . '"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
                    <a href="javascript:void(0)"   onclick = "deleteItem(' . $row->id . ')"  title="Delete " class="list-icons-item text-danger delete" > <i class="icon-trash"></i> </a>&nbsp
       <div class="dropdown"><a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a><div class="dropdown-menu">
      
        
        <a href="#" onclick = "model(' . $row->id . ')" data-id = "' . $row->id . '"  data-type="qty" class="nav-link updt" title="Update"  data-toggle="modal" data-target="#appFormModal"> Update Quantity</a>
                          
                                     </div></div>
                                 
                                </div>';
                        } else {
                            $action = ' <div class="form-inline"><a href="' . route('items.edit', $row->id) . '"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
                    <a href="javascript:void(0)"   onclick = "deleteItem(' . $row->id . ')"  title="Delete " class="list-icons-item text-danger delete" > <i class="icon-trash"></i> </a>&nbsp
       <div class="dropdown"><a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a><div class="dropdown-menu">
             
               <a href="#"  onclick = "model(' . $row->id . ')" data-id = "' . $row->id . '" data-type="qty"  class="nav-link updt" title="Update"  data-toggle="modal" data-target="#appFormModal"> Update Quantity</a>
               <a href="#" onclick = "model2(' . $row->id . ')" data-id2 = "' . $row->id . '" data-type="print"  class="nav-link updt" title="Update"  data-toggle="modal" data-target="#appFormModal"> Print Barcode</a>
                                     </div></div>
                                 
                                </div>';
                        }

                    }


                    return $action;
                })
                ->rawColumns(['action', 'name'])
                ->make(true);
        }

        $category = Category::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
        $color = Color::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
        $size = Size::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();

        if (request()->user()->can('view-cost-price')) {

            return view('pos.items.index', compact('category', 'color', 'size'));

        } else {
            return view('pos.items.index2', compact('category', 'color', 'size'));
        }


    }


    public function manufacture_index(Request $request)
    {
        //
        $package = Package::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
        if ($request->ajax()) {
            $data = Items::select('*')->whereIn('type', [2, 3, 5])->where('restaurant', '0')->where('disabled', '0')->where('added_by', auth()->user()->added_by);

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('type', function ($row) {
                    if ($row->type == 2) {
                        return 'Manufacture';
                    } elseif ($row->type == 1) {
                        return 'Inventory';
                    } elseif ($row->type == 3) {
                        return 'Raw Material';
                    } elseif ($row->type == 5) {
                        return 'Semi Finished Goods';
                    }elseif ($row->type == 6) {
                        return 'Dozen Inventory';
                    } else {
                        return 'Service';
                    }
                })
                ->editColumn('cost_price', function ($row) {
                    return number_format($row->cost_price, 2);
                })
                ->editColumn('sales_price', function ($row) {
                    return number_format($row->sales_price, 2);
                })
                ->editColumn('quantity', function ($row) {
                    return number_format($row->quantity, 2);
                })

                ->editColumn('action', function ($row) {
                    $action = ' <div class="form-inline"><a href="' . route('items2.edit', $row->id) . '"  title="Edit " class="list-icons-item text-primary"  > <i class="icon-pencil7"></i> </a>&nbsp
                    <a href="javascript:void(0)"   onclick = "deleteItem(' . $row->id . ')"  title="Delete " class="list-icons-item text-danger delete" > <i class="icon-trash"></i> </a>&nbsp
       <div class="dropdown"><a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a><div class="dropdown-menu">
               <a href="#"   onclick = "model(' . $row->id . ')"  class="nav-link" title="Update"  data-toggle="modal" data-target="#appFormModal"> Update Quantity</a>
                                     </div></div>
                                 
                                </div>';

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pos.items.manufacture_index', compact('package'));
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

        if ($request->product == 'No') {

            if (!empty($request->barcode_type)) {
                $random = substr(str_shuffle(str_repeat($x = '0123456789', ceil(11 / strlen($x)))), 1, 11);
                $data['barcode'] = $random;
            }
        } else {
            $data['barcode'] = $request->barcode;
        }

        if ($request->type != 6) {
        $data['crate_size'] = 1; // Default for type != 6
    } else {
        $inputCrateSize = $request->input('crate_size');
        $data['crate_size'] = ($inputCrateSize == 0 || $inputCrateSize === null) ? 1 : $inputCrateSize;
    }
        
        $data['added_by'] = auth()->user()->added_by;
        $items = Items::create($data);

        if (!empty($items)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $items->id,
                    'module' => 'Inventory',
                    'activity' => "Inventory " . $items->name . "  Created",
                ]
            );
        }

        return redirect(route('items.index'))->with(['success' => 'Created Successfully']);
    }


    public function store2(Request $request)
    {
        //
        $data = $request->all();

        $data['added_by'] = auth()->user()->added_by;
        $items = Items::create($data);

        if (!empty($items)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $items->id,
                    'module' => 'Inventory',
                    'activity' => "Inventory " . $items->name . "  Created",
                ]
            );
        }

        return redirect(route('items2.index'))->with(['success' => 'Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        if ($request->type == 'qty') {
            $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
                ->where('locations.disabled', '0')
                ->where('locations.added_by', auth()->user()->added_by)
                ->where('location_manager.manager', auth()->user()->id)
                ->select('locations.*')
                ->get();

            $supplier = Supplier::where('user_id', auth()->user()->added_by)->where('disabled', '0')->get();

            return view('pos.items.update', compact('id', 'location', 'supplier'));
        }

        elseif ($request->type == 'crate_qty') {
            $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
                ->where('locations.disabled', '0')
                ->where('locations.added_by', auth()->user()->added_by)
                ->where('location_manager.manager', auth()->user()->id)
                ->select('locations.*')
                ->get();

            $supplier = Supplier::where('user_id', auth()->user()->added_by)->where('disabled', '0')->get();

            return view('pos.items.update_crate', compact('id', 'location', 'supplier'));
        }
        
        elseif ($request->type == 'print') {
            $data = Items::find($id);
            return view('pos.items.print', compact('id', 'data'));
        } elseif ($request->type == 'details') {
            $data = Items::find($id);
            return view('pos.items.details', compact('id', 'data'));
        }

    }

    public function show2($id)
    {
        $location = Location::whereIn('type', [3, 4])->where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        ;
        $branch = Branch::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
        return view('pos.items.manufacture_update', compact('id', 'location', 'branch'));
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
        $data = Items::find($id);
        $category = Category::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
        $color = Color::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
        $size = Size::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
        return view('pos.items.index', compact('data', 'id', 'category', 'color', 'size'));

    }

    public function edit2($id)
    {
        //
        $data = Items::find($id);
        $package = Package::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
        return view('pos.items.manufacture_index', compact('data', 'id', 'package'));

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
        $item = Items::find($id);
        $data = $request->all();

        $inputCrateSize = $request->input('crate_size');
        $data['crate_size'] = ($inputCrateSize == 0 || $inputCrateSize === null || $inputCrateSize === '') ? 1 : $inputCrateSize;

        if ($request->product == 'No') {

            if (!empty($request->barcode_type)) {
                $random = substr(str_shuffle(str_repeat($x = '0123456789', ceil(7 / strlen($x)))), 1, 7);
                $data['barcode'] = $random;
            }
        } else {
            $data['barcode'] = $request->barcode;
        }

        //dd($data);

        $item->update($data);

        if (!empty($item)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Inventory',
                    'activity' => "Inventory " . $item->name . "  Updated",
                ]
            );
        }
        return redirect(route('items.index'))->with(['success' => 'Updated Successfully']);
        ;
    }



    public function update2(Request $request, $id)
    {
        //
        $item = Items::find($id);
        $data = $request->all();

        $item->update($data);

        if (!empty($item)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Inventory',
                    'activity' => "Inventory " . $item->name . "  Updated",
                ]
            );
        }
        return redirect(route('items2.index'))->with(['success' => 'Updated Successfully']);
        ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //
        $item = Items::find($id);
        $name = $item->name;
        $item->update(['disabled' => '1']);


        if (!empty($item)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Inventory',
                    'activity' => "Inventory " . $name . "  Deleted",
                ]
            );
        }
        return response()->json(['success' => 'Deleted Successfully']);
    }


    public function destroy2($id, Request $request)
    {
        //
        $item = Items::find($id);
        $name = $item->name;
        $item->update(['disabled' => '1']);


        if (!empty($item)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Inventory',
                    'activity' => "Inventory " . $name . "  Deleted",
                ]
            );
        }
        return response()->json(['success' => 'Deleted Successfully']);
    }

    public function findItem(Request $request)
    {


        $loc = Items::where(DB::raw('lower(name)'), strtolower($request->id))->where('disabled', '0')->where('added_by', auth()->user()->added_by)->first();

        if (empty($loc)) {
            $region = '';
        } else {
            $region = 'error';

        }

        return response()->json($region);

    }


    public function findCode(Request $request)
    {


        $loc = Items::where('barcode', $request->id)->where('added_by', auth()->user()->added_by)->where('disabled', '0')->whereNotNull('barcode')->first();

        //dd($loc);

        if (empty($loc)) {
            $region = '';
        } else {
            $region = 'error';

        }

        return response()->json($region);

    }

    public function update_quantity(Request $request)
    {
        //
        $item = Items::find($request->id);

        if($item->type == 6){

        $data['quantity'] = $item->quantity + ($request->quantity * $item->crate_size);


            $item->update($data);

            $lists = array(
                'quantity' => $request->quantity * $item->crate_size,
                'price' => $item->cost_price * $request->quantity * $item->crate_size,
                'item_id' => $item->id,
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'purchase_date' => $request->purchase_date,
                'location' => $request->location,
                'supplier_id' => $request->supplier_id,
                'expire_date' => $request->expire_date,
                'type' => 'Purchases'
            );

            PurchaseHistory::create($lists);

            if ($request->quantity > 0) {

                $mlists = [
                    'in' => $request->quantity * $item->crate_size,
                    'price' => $item->cost_price * $request->quantity * $item->crate_size,
                    'item_id' => $item->id,
                    'added_by' => auth()->user()->added_by,
                    'location' => $request->location,
                    'supplier_id' => $request->supplier_id,
                    'date' => $request->purchase_date,
                    'expire_date' => $request->expire_date,
                    'type' => 'Purchases',
                ];


            } else {

                $mlists = [
                    'out' => abs($request->quantity * $item->crate_size),
                    'price' => $item->cost_price * $request->quantity * $item->crate_size,
                    'item_id' => $item->id,
                    'added_by' => auth()->user()->added_by,
                    'location' => $request->location,
                    'supplier_id' => $request->supplier_id,
                    'date' => $request->purchase_date,
                    'expire_date' => $request->expire_date,
                    'type' => 'Purchases',
                ];


            }

            MasterHistory::create($mlists);


            $loc = Location::find($request->location);
            if ($item->bar == '1') {
                $lq['crate'] = $loc->crate + $request->quantity;
                $lq['bottle'] = $loc->bottle + ($request->quantity * $item->bottle);
            }
            elseif($item->type == 6){

                $lq['crate'] = $loc->crate + $request->quantity;
                $lq['bottle'] = $loc->bottle + ($request->quantity * $item->crate_size);

            }

            $lq['quantity'] = $loc->quantity + ($request->quantity * $item->crate_size);
            $loc->update($lq);

            $cost = abs($item->cost_price * $request->quantity * $item->crate_size);



        }
        else{
            $data['quantity'] = $item->quantity + $request->quantity;


            $item->update($data);

            $lists = array(
                'quantity' => $request->quantity,
                'price' => $item->cost_price,
                'item_id' => $item->id,
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'purchase_date' => $request->purchase_date,
                'location' => $request->location,
                'supplier_id' => $request->supplier_id,
                'expire_date' => $request->expire_date,
                'type' => 'Purchases'
            );

            PurchaseHistory::create($lists);

            if ($request->quantity > 0) {

                $mlists = [
                    'in' => $request->quantity,
                    'price' => $item->cost_price,
                    'item_id' => $item->id,
                    'added_by' => auth()->user()->added_by,
                    'location' => $request->location,
                    'supplier_id' => $request->supplier_id,
                    'date' => $request->purchase_date,
                    'expire_date' => $request->expire_date,
                    'type' => 'Purchases',
                ];


            } else {

                $mlists = [
                    'out' => abs($request->quantity),
                    'price' => $item->cost_price,
                    'item_id' => $item->id,
                    'added_by' => auth()->user()->added_by,
                    'location' => $request->location,
                    'supplier_id' => $request->supplier_id,
                    'date' => $request->purchase_date,
                    'expire_date' => $request->expire_date,
                    'type' => 'Purchases',
                ];


            }

            MasterHistory::create($mlists);


            $loc = Location::find($request->location);
            if ($item->bar == '1') {
                $lq['crate'] = $loc->crate + $request->quantity;
                $lq['bottle'] = $loc->bottle + ($request->quantity * $item->bottle);
            }

            $lq['quantity'] = $loc->quantity + $request->quantity;
            $loc->update($lq);

            $cost = abs($item->cost_price * $request->quantity);



        }

        if ($item->cost_price * $request->quantity > 0) {
            $cr = AccountCodes::where('account_name', 'Inventory')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cr->id;
            $date = explode('-', $request->purchase_date);
            $journal->date = $request->purchase_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_update_item';
            $journal->name = 'Items';
            $journal->debit = $cost;
            $journal->income_id = $item->id;
            $journal->supplier_id = $request->supplier_id;
            $journal->added_by = auth()->user()->added_by;

            $journal->notes = "POS Item Update for " . $item->name;
            $journal->save();



            $codes = AccountCodes::where('account_name', 'Balance Control')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $codes->id;
            $date = explode('-', $request->purchase_date);
            $journal->date = $request->purchase_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_update_item';
            $journal->name = 'Items';
            $journal->income_id = $item->id;
            $journal->supplier_id = $request->supplier_id;
            $journal->credit = $cost;
            $journal->added_by = auth()->user()->added_by;

            $journal->notes = "POS Item Update for " . $item->name;
            $journal->save();

        } else {

            $codes = AccountCodes::where('account_name', 'Balance Control')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $codes->id;
            $date = explode('-', $request->purchase_date);
            $journal->date = $request->purchase_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_update_item';
            $journal->name = 'Items';
            $journal->debit = $cost;
            $journal->income_id = $item->id;
            $journal->supplier_id = $request->supplier_id;
            $journal->added_by = auth()->user()->added_by;

            $journal->notes = "POS Item Update for " . $item->name;
            $journal->save();


            $cr = AccountCodes::where('account_name', 'Inventory')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cr->id;
            $date = explode('-', $request->purchase_date);
            $journal->date = $request->purchase_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_update_item';
            $journal->name = 'Items';
            $journal->income_id = $item->id;
            $journal->supplier_id = $request->supplier_id;
            $journal->credit = $cost;
            $journal->added_by = auth()->user()->added_by;
            $journal->notes = "POS Item Update for " . $item->name;
            $journal->save();



        }


        return redirect(route('items.index'))->with(['success' => 'Updated Successfully']);
        ;
    }



    public function update_quantity2(Request $request)
    {
        //
        $item = Items::find($request->id);
        $data['quantity'] = $item->quantity + $request->quantity;
        $item->update($data);

        $lists = array(
            'quantity' => $request->quantity,
            'price' => $item->cost_price,
            'item_id' => $item->id,
            'added_by' => auth()->user()->added_by,
            'user_id' => auth()->user()->id,
            'purchase_date' => $request->purchase_date,
            'location' => $request->location,
            'type' => 'Purchases'
        );

        PurchaseHistory::create($lists);

        if ($request->quantity > 0) {

            $mlists = [
                'in' => $request->quantity,
                'price' => $item->cost_price,
                'item_id' => $item->id,
                'added_by' => auth()->user()->added_by,
                'location' => $request->location,
                'date' => $request->purchase_date,
                'type' => 'Purchases',
            ];


        } else {

            $mlists = [
                'out' => abs($request->quantity),
                'price' => $item->cost_price,
                'item_id' => $item->id,
                'added_by' => auth()->user()->added_by,
                'location' => $request->location,
                'date' => $request->purchase_date,
                'type' => 'Purchases',
            ];


        }

        MasterHistory::create($mlists);

        $loc = Location::find($request->location);


        $lq['quantity'] = $loc->quantity + $request->quantity;
        $loc->update($lq);


        if ($item->cost_price * $request->quantity > 0) {
            $cr = AccountCodes::where('account_name', 'Inventory')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cr->id;
            $date = explode('-', $request->purchase_date);
            $journal->date = $request->purchase_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_update_item';
            $journal->name = 'Items';
            $journal->debit = abs($item->cost_price * $request->quantity);
            $journal->income_id = $item->id;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $request->branch_id;
            $journal->notes = "POS Item Update for " . $item->name;
            $journal->save();

            $codes = AccountCodes::where('account_name', 'Balance Control')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $codes->id;
            $date = explode('-', $request->purchase_date);
            $journal->date = $request->purchase_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_update_item';
            $journal->name = 'Items';
            $journal->income_id = $item->id;
            $journal->credit = abs($item->cost_price * $request->quantity);
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $request->branch_id;
            $journal->notes = "POS Item Update for " . $item->name;
            $journal->save();

        } else {

            $codes = AccountCodes::where('account_name', 'Balance Control')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $codes->id;
            $date = explode('-', $request->purchase_date);
            $journal->date = $request->purchase_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_update_item';
            $journal->name = 'Items';
            $journal->debit = abs($item->cost_price * $request->quantity);
            $journal->income_id = $item->id;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $request->branch_id;
            $journal->notes = "POS Item Update for " . $item->name;
            $journal->save();


            $cr = AccountCodes::where('account_name', 'Inventory')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cr->id;
            $date = explode('-', $request->purchase_date);
            $journal->date = $request->purchase_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_update_item';
            $journal->name = 'Items';
            $journal->income_id = $item->id;
            $journal->credit = abs($item->cost_price * $request->quantity);
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $request->branch_id;
            $journal->notes = "POS Item Update for " . $item->name;
            $journal->save();

        }


        return redirect(route('items2.index'))->with(['success' => 'Updated Successfully']);
        ;
    }

}