<?php

namespace App\Http\Controllers\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project\Category;


class ProjectCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $cat = Category::all()->where('added_by', auth()->user()->added_by);
      
        return view('project.project_categories', compact('cat'));
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
        $cat = Category::create($data);

        return redirect(route('project_categories.index'))->with(['success' => 'Created Successfully']);
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
        $data =  Category::find($id);
        return view('project.project_categories', compact('data','id'));
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
        $cat = Category::find($id);
        $data = $request->post();
        $data['added_by'] = auth()->user()->id;
        $cat->update($data);

        return redirect(route('project_categories.index'))->with(['success' => 'Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $price = Category::find($id);
        $price->delete();

        return redirect(route('project_categories.index'))->with(['error' => 'Crop Type Deleted Successfully']);
    }
}
