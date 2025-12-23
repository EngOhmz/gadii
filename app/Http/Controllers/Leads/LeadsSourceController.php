<?php

namespace App\Http\Controllers\Leads;

use App\Models\Leads\LeadStatus;
use App\Models\Leads\LeadSource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project\Category;


class LeadsSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $lead = LeadSource::all()->where('added_by', auth()->user()->added_by);
      
        return view('leads.leads_source', compact('lead'));
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
        $data = $request->post();
        $data['added_by'] = auth()->user()->id;
        $cat = LeadSource::create($data);

        return redirect(route('leads_source.index'))->with(['success' => 'Created Successfully']);
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
        $data =  LeadSource::find($id);
        return view('leads.leads_source', compact('data','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $cat = LeadSource::find($id);
        $data = $request->post();
        $data['added_by'] = auth()->user()->id;
        $cat->update($data);

        return redirect(route('leads_source.index'))->with(['success' => 'Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $price = LeadSource::find($id);
        $price->delete();

        return redirect(route('leads_source.index'))->with(['error' => 'Deleted Successfully']);
    }
}