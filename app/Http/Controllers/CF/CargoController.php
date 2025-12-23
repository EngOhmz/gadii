<?php

namespace App\Http\Controllers\CF;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Project\Milestone;
use App\Models\Project\Project;
use App\Models\Client;
use App\Models\Project\Category;
use App\Models\CF\Cargo;
use App\Models\Project\Billing_Type;
use App\Models\Project\MilestoneActivity as Activity;
use App\Models\User;

class CargoController extends Controller
{  
    
    public function index()
    {  
         $cargo= Cargo::all()->where('added_by', auth()->user()->added_by)->where('disabled','0');
           
        return view('cf.cargo', compact('cargo'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    { 
         $data=$request->post();
        
        $data['added_by']=auth()->user()->added_by;
        
        $cargo= Cargo::create($data);

       
        
        return redirect(route('cargo_type.index'))->with(['success'=>'Cargo Created Successfully']);
    }
    
      public function edit($id)
    {
        
        $data = Cargo::find($id);
        

        return view('cf.cargo', compact('data','id'));
    }
    

    public function show($id)
    {
        //
                $data = Milestone::find($id);
                
                return view('project.milestone.project_details',compact('data'));
    }

  


     
public function update(Request $request, $id)
    {
        $cargo = Cargo::find($id);
        
        $data=$request->post();
        $data['added_by']=auth()->user()->added_by;
        $cargo->update($data);
        
      
        

        return redirect(route('cargo_type.index'))->with(['success'=>'Cargo Updated Successfully']);
    }

    public function destroy($id)
    {
        $cargo = Cargo::find($id);
     
        

        $cargo->update(['disabled'=> '1']);;

        return redirect(route('cargo_type.index'))->with(['error'=>'Cargo Deleted Sussessfully']);
    }
}
