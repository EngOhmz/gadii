<?php

namespace App\Http\Controllers\CargoAgency\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CargoAgency\Customer\Customer;
use App\Models\CargoAgency\Customer\CustomerPacel;
use DataTables;

class CustomerList extends Controller
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

            $data = Customer::select('*');

            return Datatables::of($data)

                    ->addIndexColumn()
                    
                    ->editColumn('created_at', function ($row) {

                        return $row->created_at->format('Y-m-d H:i:s');
                    
                    })

                    ->addColumn('action', function($row){

                     return view('cargo_agency.customer.action', compact('row'));

                    })
                

                    ->rawColumns(['action'])

                    ->make(true);

        }

        

        return view('cargo_agency.customer.customer_list');

    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id, Request $request)
    {
        //
        $data2 = Customer::find($id);

        // $data2 = Customer::where('id', $id)->value('level');

        $data = CustomerPacel::where('customer_id', $id)->get();

        

        return view('cargo_agency.customer.customer_show', compact('data2', 'data'));
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
