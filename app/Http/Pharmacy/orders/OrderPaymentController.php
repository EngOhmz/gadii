<?php

namespace App\Http\Controllers\orders;

use App\Http\Controllers\Controller;
use App\Models\orders\Cost_function;
use App\Models\orders\OrderMovement;
use App\Models\orders\OrderPayment;
use App\Models\orders\Transport_quotation;
use Illuminate\Http\Request;

class OrderPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $receipt = $request->all();
        $sales =Transport_quotation::find($request->transport_id);

        if(($receipt['amount'] <= $sales->amount + $sales->tax)){
            if( $receipt['amount'] >= 0){
                $receipt['trans_id'] = "ORDER PAY-".$request->transport_id.'-'. substr(str_shuffle(1234567890), 0, 1).'-'.date('d/m/y');
                $receipt['added_by'] = auth()->user()->id;
                
                //update due amount from invoice table
                $data['due_amount'] =  $sales->due_amount-$receipt['amount'];
                if($data['due_amount'] != 0 ){
                $data['status'] = 1;
                }else{
                    $data['status'] = 2;

                }
                $sales->update($data);

                $quot=Transport_quotation::find($request->transport_id);
                if($quot->status == 2){             
                $result = $quot->toArray();
                $result['module_id']=$request->transport_id;
                $result['module']='Order';
                $movement=OrderMovement::create($result);
                }
                 
                $payment = OrderPayment::create($receipt);

                $user_id=auth()->user()->id;
                $quotation = Transport_quotation::all();
                $costs = Cost_function::all()->where('user_id',$user_id);
               

                return view('orders.quotation_list')->with('quotation',$quotation)->with('costs',$costs)->with(['success'=>'Payment Added successfully']);
            }else{
                return view('orders.quotation_list')->with('quotation',$quotation)->with('costs',$costs)->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return view('orders.quotation_list')->with('quotation',$quotation)->with('costs',$costs)->with(['error'=>'Amount should  be less than Purchase amount ']);

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
