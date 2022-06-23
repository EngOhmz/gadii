<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmer_account;
use App\Models\Deposite_withdraw;
use App\Models\Monitoring_type;
use App\Models\Monitoring_Solutions;

class Single_warehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
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

        if($request->input('type')=="register_farmer_account")
        {
            $this->validate($request,[
                'cropstype'=>'required',
                'selectfamer'=>'required',
            ]); 
            $farmerAccount= new Farmer_account();
            $farmerAccount->crops_type_id=$request->input('cropstype');
            $farmerAccount->farmer_id=$request->input('selectfamer');
            $farmerAccount->warehouse_id=$request->input('warehouseid');
            $farmerAccount->save();
            if($farmerAccount)
            {
                $message="New Farmer Account is registered successful'";
                return response()
                ->json($message);
            }
            else
            {
                $message="Failed to register new Farmer Account'";
                return response()
                ->json($message);
            }
        }

        if($request->input('type')=="deposity"){
            $id =$request->input('account_id');
            $farmerAccount=Farmer_account::find($id);
            $this->validate($request,[
                'deposityquantity'=>'required',
            ]); 
            $warehouseid=$request->input('warehouseid');
            $accountBalance=$farmerAccount->total_quantity;
            $accountBalance =$accountBalance+$request->input('deposityquantity');
            $farmerAccount->update(['total_quantity' => $accountBalance]);
            if($farmerAccount){
            $deposity= new Deposite_withdraw();
            $deposity->farm_account_id=$request->input('account_id');
            $deposity->quantity=$request->input('deposityquantity');
             $deposity->cost=$request->input('deposityprice');
             $deposity->warehouse_id=$request->input('warehouseid');
            $deposity->status=2;
            $deposity->save();
            if($deposity)
            {
                $message="deposity successful";
                return response()
                ->json($message);
            }
            else
            {
                $message="Failed to deposity";
                return response()
                ->json($message);
            }
     
          }
        }

        if($request->input('type')=="withdraw"){
            $this->validate($request,[
                'withquantity'=>'required',
            ]); 
            $warehouseid=$request->input('warehouseid');
            $id =$request->input('account_id');
            $farmerAccount=Farmer_account::find($id);
            $withdrawamount =$request->input('withquantity');
            $accountBalance=$farmerAccount->total_quantity;
            if($accountBalance>$withdrawamount){
            $accountBalance =$accountBalance-$withdrawamount;
            
            $farmerAccount->update(['total_quantity' => $accountBalance]);
          if($farmerAccount){
            $withdraw= new Deposite_withdraw();
    
            $withdraw->farm_account_id=$request->input('account_id');;
            $withdraw->quantity=$request->input('withquantity');
            $withdraw->cost=$request->input('deposityprice');
            $withdraw->warehouse_id=$request->input('warehouseid');
            $withdraw->status=1;
           
            $withdraw->save();
             if($withdraw)
            {
                $message="withdraw successful'";
                return response()
                ->json($message);
            } else
            {
                $message="Failed to withdraw";
                return response()
                ->json($message);
            }}
            else
            {
                $message="Failed to withdraw";
                return response()
                ->json($message);
            }
             }else{
                 $message="Failed to withdraw you have no balance";
                 return response()
                ->json($message); 
             }
          
        }
      

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
      $warehouse_id = $request->warehouse_id;
       switch ($request->type) {
        case 'withdraw':
                return view('warehouses.withdraw-form',compact('warehouse_id','id'));
                break;
        case 'deposity':
         
                return view('warehouses.deposity-form',compact('warehouse_id','id'));
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
       

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     public function download(Request $request)
{
   
}

    public function destroy($id)
    {
      
    }
}
