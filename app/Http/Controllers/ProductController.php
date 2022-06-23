<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Unit;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
        $user_id=auth()->user()->id;
        $product=User::find($user_id)->product;
        $unit=User::find($user_id)->unit;
        //$supply=User::find($user_id)->supply;
        //print_r($supply);
        return view('agrihub.manage-product')->with("product",$product)->with('product2',$product)->with('unit',$unit)->with('unit2',$unit);
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
        
        $this->validate($request,[
            'name'=>'required',
            'code'=>'required',
            'buyprice'=>'required',
            'sellprice'=>'required',
            'unit'=>'required',
            'balance'=>'required'
        ]);
            $data=$request->all();
            $data['user_id']=auth()->user()->id;
            $result=Product::create($data);
            if($result)
            {
                $messagev="Successful Added'";
                return redirect('manage/product')->with('messagev',$messagev);
            }
            else
            {
                $messager="Failed to add new product";
                return redirect('manage/product')->with('messagev',$messager);
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
        $data=Product::find($id);
        $this->validate($request,[
            'name'=>'required',
            'code'=>'required',
            'buyprice'=>'required',
            'sellprice'=>'required',
            'unit'=>'required',
            'balance'=>'required'
        ]);
            $result=$request->all();
            $data['user_id']=auth()->user()->id;
            
            $data->update($result);
            if($data)
            {
                $messagev="Successful Added'";
                return redirect('manage/product')->with('messagev',$messagev);
            }
            else
            {
                $messager="Failed to add new product";
                return redirect('manage/product')->with('messagev',$messager);
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
        $data=Product::find($id);
        $data->delete();
        if($data)
        {
            $messagev="Success Deleted'";
            return redirect('manage/product')->with('messagev',$messagev);
        }
    }
}
