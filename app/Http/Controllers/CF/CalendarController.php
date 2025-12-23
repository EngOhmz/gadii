<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Project\Milestone;
use App\Models\Project\Project;
use App\Models\Project\Ticket;
use App\Models\Client;
use App\Models\Project\Category;
use App\Models\Project\Billing_Type;
use App\Models\User;
use App\Models\Departments;
use App\Models\Project\Activity;

class CalendarController extends Controller
{  
    
    public function index()
    {  
        
        $projects = Project::all()->where('added_by',auth()->user()->added_by);
        // $departments = Departments::all()->where('added_by',auth()->user()->added_by);
        // $category = Category::all()->where('added_by',auth()->user()->added_by);
        // $tickets = Ticket::all()->where('added_by',auth()->user()->added_by);
        // $billing_type = Billing_Type::all()->where('added_by',auth()->user()->added_by);
        // $users = User::all()->where('added_by', auth()->user()->added_by);
    
        return view('project.calendar.index', compact('projects'));
        
        // return view('project.calendar.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // $data = $request->all();client_visible
        
        $data['project_id'] = $request->project_id;
        
        $data['ticket_code']=$request->ticket_code;
        
        $data['reporter']=$request->reporter;
        
        // $data['upload_file']=$request->upload_file;
        
        $data['departments_id']=$request->departments_id;
        
        
        
        
        $data['priority']=$request->priority;
        
        $data['body']=$request->body;
        
        $data['status']=$request->status;
        
        // $data['email']=$request->email;
        
        $data['subject']=$request->subject;
        
        $data['tags']=$request->tags;
        
        
        
        $data['added_by']=auth()->user()->added_by;
        $data['permission']=$request->permission;
        
        if ($request->hasFile('upload_file')) {
                    $file=$request->file('upload_file');
                    $fileType=$file->getClientOriginalExtension();
                    $fileName=rand(1,1000).date('dmyhis').".".$fileType;
                    $name=$fileName;
                    $path = public_path(). "/assets/files";
                    $file->move($path, $fileName );
                    
                    $data['upload_file'] = $name;
                }else{
                        $data['upload_file'] = null;
                }
                
        
        $ticket = Ticket::create($data);

if(!empty($ticket)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$ticket->id,
                             'module'=>'Ticket',
                            'activity'=>"Ticket " .  $ticket->ticket_code  ." Created",
                        ]
                        );                      
       }
        
        return redirect(route('calendar.index'))->with(['success'=>'Ticket Created Successfully']);
    }
      public function edit($id)
    {
        //
         $data = Ticket::find($id);

        $project = Project::all()->where('added_by',auth()->user()->added_by);
        $departments = Departments::all()->where('added_by',auth()->user()->added_by);
        $tickets = Ticket::all()->where('added_by',auth()->user()->added_by);
        $users = User::all()->where('added_by', auth()->user()->added_by);


                
                        return view('project.calendar.index', compact('data', 'users', 'tickets','id', 'project', 'departments'));
    }

    public function show($id)
    {
        //
                $data = Ticket::find($id);
                
                return view('project.calendar.project_details',compact('data'));
    }

  


    public function update(Request $request, $id)
    {
         $data['project_id'] = $request->project_id;
        
        $data['ticket_code']=$request->ticket_code;
        
        $data['reporter']=$request->reporter;
        
        // $data['upload_file']=$request->upload_file;
        
        $data['departments_id']=$request->department;
        
        
        $data['attachment'] = $request->attachment;
        
        $data['priority']=$request->priority;
        
        $data['body']=$request->body;
        
        $data['status']=$request->status;
        
        // $data['email']=$request->email;
        
        $data['subject']=$request->subject;
        
        $data['tags']=$request->tags;
        
        
        
        $data['added_by']=auth()->user()->added_by;
        $data['permission']=$request->permission;
        
        
        $ticket = Ticket::find($id)->update($data);

if(!empty($ticket)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$ticket->id,
                             'module'=>'Ticket',
                            'activity'=>"Ticket " .  $ticket->ticket_code  ." Updated",
                        ]
                        );                      
       }
        
        return redirect(route('calendar.index'))->with(['success'=>'Ticket updated Successfully']);
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);
     
if(!empty($ticket)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                             'module_id'=>$ticket->id,
                             'module'=>'Ticket',
                            'activity'=>"Ticket " .  $ticket->ticket_code . " Deleted",
                        ]
                        );                      
       }
   $ticket->delete();

        return redirect(route('calendar.index'))->with(['success'=>'Ticket Deleted Sussessfully']);
    }
}
