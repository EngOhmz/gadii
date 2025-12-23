<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\POS;

use App\Http\Controllers\Controller;
use App\Models\Retail\Activity;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
// use  App\Models\Retail\POS\Items1;
use  App\Models\Retail\Items;
use  App\Models\Retail\Category;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {

        $items = Items::where('user_id', $id)->orderBy('created_at', 'desc')->get();

        // return response()->json($user,200);
        
        if($items->isNotEmpty()){

            foreach($items as $row){

                $data = $row;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','inventory'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Inventory found'];
            return response()->json($response,200);
        } 
    }

    public function indexOff(int $id, int $lastId)
    {

        $items = Items::where('user_id', $id)->where('id', '>', $lastId)->orderBy('created_at', 'desc')->get();


        // return response()->json($user,200);
        
        if($items->isNotEmpty()){

            foreach($items as $row){

                $data = $row;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','inventory'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Inventory found'];
            return response()->json($response,200);
        } 
    }

    public function category(int $id)
    {
        $category=Category::where('added_by', $id)->orderBy('created_at', 'desc')->get();

        // return response()->json($user,200);
        
        if($category->isNotEmpty()){

            foreach($category as $row){

                $data = $row;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','inventory'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Category found for user'];
            return response()->json($response,200);
        } 
    }

    public function categoryOff(int $id, int $lastId)
    {
        $category=Category::where('added_by', $id)->where('id', '>', $lastId)->orderBy('created_at', 'desc')->get();

        // return response()->json($user,200);
        
        if($category->isNotEmpty()){

            foreach($category as $row){

                $data = $row;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','inventory'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Category found for user'];
            return response()->json($response,200);
        } 
    }

    public function addCategory(Request $request){

        $this->validate($request,[
            'name'=>'required',
            'id'=>'required',
            
        ]); 
       
    
        $data = new Category();
        $data->name=$request->input('name');
        $data->added_by=$request->input('id');
        
      
        $data->save();


        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Inventory  Created successful', 'category' => $data];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Inventory Successfully'];
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
            'cost_price'=>'required',
            'sales_price'=>'required',
            'unit'=>'required',
            'id'=>'required',
            
        ]); 

        $data = new Items();
        $data->name=$request->input('name');
        $data->cost_price=$request->input('cost_price');
        $data->sales_price=$request->input('sales_price');
        $data->unit=$request->input('unit');
        $data->quantity=$request->input('quantity');
        $data->description=$request->input('description');
        $data->manufacturer=$request->input('manufacturer');
        $data->barcode=$request->input('barcode');
        $data->user_id=$request->input('id');

        $data->save();

        // $dt = $data->id;

        if(!empty($data)){
            $activity =Activity::create(
                [ 
                    'added_by'=> $data->user_id,
                    'module_id'=>$data->id,
                     'module'=>'Inventory',
                    'activity'=>"Inventory " .  $data->name. "  Created",
                ]
                );                      
            }

        


        if($data)
        {
             $x = intval(0);
            $data['quantity'] = $x;

            $data['barcode'] = $data->barcode;

           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Inventory  Created successful', 'inventory' => $data];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Inventory Successfully'];
            return response()->json($response,200);
        }
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
        $this->validate($request,[
            'name'=>'required',
            'cost_price'=>'required',
            'sales_price'=>'required',
            'unit'=>'required',
            
        ]); 

        $data = Items::find($id);

        $data->name=$request->input('name');
        $data->cost_price=$request->input('cost_price');
        $data->sales_price=$request->input('sales_price');
        $data->unit=$request->input('unit');
        $data->quantity=$request->input('quantity');
        $data->description=$request->input('description');
        $data->manufacturer=$request->input('manufacturer');
        $data->barcode=$request->input('barcode');
        $data->user_id=$request->input('id');

        $seed =  $data->update();


        // $dt = $data->id;

        if(!empty($data)){
            $activity =Activity::create(
                [ 
                    'added_by'=> $data->user_id,
                    'module_id'=>$data->id,
                     'module'=>'Inventory',
                    'activity'=>"Inventory " .  $data->name. "  Updated",
                ]
                );                      
            }

        


        if($seed)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Inventory Updated successful', 'inventory' => $data];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Update Inventory Successfully'];
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

        $data = Items::find($id);

        if(!empty($data)){
            $activity =Activity::create(
                [ 
                    'added_by'=> $data->user_id,
                    'module_id'=> $id,
                     'module'=>'Inventory',
                    'activity'=>"Inventory " .  $data->name. "  Deleted",
                ]
                );                      
        }


        $crop = $data->delete();


 
        if($crop)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'Inventory deleted'];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to delete Inventory'];
            return response()->json($response,200);
        }

    }

   
}
