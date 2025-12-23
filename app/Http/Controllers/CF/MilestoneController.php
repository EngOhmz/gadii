<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Project\Milestone;
use App\Models\Project\Project;
use App\Models\Client;
use App\Models\Project\Category;
use App\Models\Project\Billing_Type;
use App\Models\Project\MilestoneActivity as Activity;
use App\Models\User;

class MilestoneController extends Controller
{  
    
    public function index()
    {  
        
        $project = Project::all()->where('disabled','0')->where('added_by',auth()->user()->added_by);
        $client = Client::all()->where('added_by',auth()->user()->added_by);
        $category = Category::all()->where('added_by',auth()->user()->added_by);
        $milestones = Milestone::all()->where('disabled','0')->where('added_by',auth()->user()->added_by);
        $billing_type = Billing_Type::all()->where('added_by',auth()->user()->added_by);
        $users = User::all()->where('added_by', auth()->user()->added_by);
    
        return view('project.milestone.index', compact('project', 'category','billing_type','client', 'milestones', 'users'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // $data = $request->all();client_visible
        
        $data['project_id'] = $request->project_id;
        
        $data['name']=$request->name;
        
        $data['start_date']=$request->start_date;
        
        $data['end_date']=$request->end_date;
        
        $data['description']=$request->description;
        
        
        
        $data['added_by']=auth()->user()->added_by;
        $data['responsible_id']=$request->user_id;
        
        $milestone = Milestone::create($data);

if(!empty($milestone)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$milestone->id,
                             'module'=>'Milestone',
                            'activity'=>"Milestone " .  $milestone->name. "-". $milestone->project_id. "Created",
                        ]
                        );                      
       }
        
        return redirect(route('milestone.index'))->with(['success'=>'Milestone Created Successfully']);
    }
      public function edit($id)
    {
        //
         $data = Milestone::find($id);

        $client = Client::all()->where('added_by',auth()->user()->added_by);
        $category = Category::all()->where('added_by',auth()->user()->added_by);
        $billing_type = Billing_Type::all()->where('added_by',auth()->user()->added_by);
        $project = Project::all()->where('disabled','0')->where('added_by',auth()->user()->added_by);
        $milestones = Milestone::all()->where('added_by',auth()->user()->added_by);


                        return view('project.milestone.index', compact('data', 'category','billing_type','client','id', 'project', 'milestones'));
    }

    public function show($id)
    {
        //
                $data = Milestone::find($id);
                
                return view('project.milestone.project_details',compact('data'));
    }

  


    public function update(Request $request, $id)
    {
        $data['project_id'] = $request->project_id;
        
        $data['name']=$request->name;
        
        $data['start_date']=$request->start_date;
        
        $data['end_date']=$request->end_date;
        
        $data['description']=$request->description;
        
        
        
        $data['added_by']=auth()->user()->added_by;
        $data['responsible_id']=$request->user_id;
        
        
        $milestone = Milestone::find($id)->update($data);

if(!empty($milestone)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$milestone->id,
                             'module'=>'Milestone',
                            'activity'=>"Milestone " .  $milestone->name. "-". $milestone->project_id. "Updated",
                        ]
                        );                      
       }
        
        return redirect(route('milestone.index'))->with(['success'=>'Milestone updated Successfully']);
    }

    public function destroy($id)
    {
        $milestone = Milestone::find($id);
     
if(!empty($milestone)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                             'module_id'=>$milestone->id,
                             'module'=>'Milestone',
                            'activity'=>"Milestone " .  $milestone->name. "-". $milestone->project_id. "Deleted",
                        ]
                        );                      
       }

    $milestone->update(['disabled'=>'1']);

        return redirect(route('milestone.index'))->with(['success'=>'Milestone Deleted Sussessfully']);
    }
}
