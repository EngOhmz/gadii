<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Project\Milestone;
use App\Models\Project\Project;
use App\Models\Project\Ticket;
use App\Models\Project\TicketAssigment;
use App\Models\Client;
use App\Models\Project\Category;
use App\Models\Project\Billing_Type;
use App\Models\User;
use App\Models\Departments;
use App\Models\Project\TicketActivity as Activity;
use Session;

class TicketController extends Controller
{
    public function index()
    {
        $project = Project::all()->where('added_by',auth()->user()->added_by)->where('disabled','0');
        $departments = Departments::all()->where('added_by', auth()->user()->added_by);
        $category = Category::all()->where('added_by', auth()->user()->added_by);
        $tickets = Ticket::all()->where('added_by', auth()->user()->added_by);
        $billing_type = Billing_Type::all()->where('added_by', auth()->user()->added_by);
        $users = User::all()->where('added_by', auth()->user()->added_by);
     

        return view('project.ticket.index', compact('project', 'category', 'billing_type', 'departments', 'tickets', 'users'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // $data = $request->all();client_visible

        $data['project_id'] = $request->project_id;

        $data['ticket_code'] = $request->ticket_code;

        $data['reporter'] = $request->reporter;

        // $data['upload_file']=$request->upload_file;

        $data['departments_id'] = $request->departments_id;

        $data['priority'] = $request->priority;

        $data['body'] = $request->body;

        $data['status'] = 'In Progress';

        // $data['email']=$request->email;

        $data['subject'] = $request->subject;

        $data['tags'] = $request->tags;

        $data['added_by'] = auth()->user()->added_by;
        $data['permission'] = $request->permission;

        $trans_id = $request->trans_id;
        $data['assigned_to'] = implode(',', $trans_id);
        
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $fileType = $file->getClientOriginalExtension();
            $fileName = rand(1, 1000) . date('dmyhis') . '.' . $fileType;
            $name = $fileName;
            $path = public_path() . '/assets/files';
            $file->move($path, $fileName);

            $data['upload_file'] = $name;
        } else {
            $data['upload_file'] = null;
        }

        $ticket = Ticket::create($data);
        
          if (!empty($trans_id)) {
            for ($i = 0; $i < count($trans_id); $i++) {
                if (!empty($trans_id[$i])) {
                    $data_ass['ticket_id'] = $ticket->id;
                    $data_ass['user_id'] = $trans_id[$i];
                    $data_ass['added_by'] = auth()->user()->added_by;

                    TicketAssigment::create($data_ass);
                }
            }
        }
        
 

        if (!empty($ticket)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->id,
                'module_id' => $ticket->id,
                'module' => 'Ticket',
                'activity' => 'Ticket ' . $ticket->ticket_code . ' Created',
            ]);
        }

        return redirect(route('ticket.index'))->with(['success' => 'Ticket Created Successfully']);
    }
    

    public function change_status($id, $status)
    {
        $ticket = Ticket::find($id);

        if (!empty($ticket)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->id,
                'module_id' => $ticket->id,
                'project_id' => $ticket->id,
                'module' => 'Ticket',
                'activity' => 'Ticket Change Status ',
            ]);
        }

        $ticket->update(['status' => $status]);

        return redirect(route('ticket.index'))->with(['success' => 'Status Changed Successfully']);
    }
    
    
    public function edit($id)
    {
        //
        $data = Ticket::find($id);

        $project = Project::all()->where('added_by', auth()->user()->added_by);
        $departments = Departments::all()->where('added_by', auth()->user()->added_by);
        $tickets = Ticket::all()->where('added_by', auth()->user()->added_by);
        $users = User::all()->where('added_by', auth()->user()->added_by);

        return view('project.ticket.index', compact('data', 'users', 'tickets', 'id', 'project', 'departments'));
    }

    public function showDet($id)
    {
        
        $data = Ticket::find($id);
        
        $type = Session::get('type');

        if (empty($type)) {
            $type = 'details';
        } else {
            $type = Session::get('type');
        }


        return view('project.ticket.ticket_details', compact('data','type'));
    }

    public function update(Request $request, $id)
    
    {
        
        $ticket = Ticket::find($id);
        
        $data = $request->all();
        $data['added_by'] = auth()->user()->added_by;

        $trans_id = $request->trans_id;
 
        
        $data['assigned_to'] = implode(',', $trans_id);


        $ticket->update($data);
        
        
         if (!empty($trans_id)) {
            TicketAssigment::where('ticket_id',$id)->delete();
            for ($i = 0; $i < count($trans_id); $i++) {
                if (!empty($trans_id[$i])) {
                    $data_ass['ticket_id'] = $ticket->id;
                    $data_ass['user_id'] = $trans_id[$i];
                    $data_ass['added_by'] = auth()->user()->added_by;
                   
                 
                    TicketAssigment::create($data_ass);
                }
            }
        }

        if (!empty($ticket)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->id,
                'module_id' => $ticket->id,
                'module' => 'Ticket',
                'activity' => 'Ticket ' . $ticket->ticket_code . ' Updated',
            ]);
        }

        return redirect(route('ticket.index'))->with(['success' => 'Ticket updated Successfully']);
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);

        if (!empty($ticket)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->id,
                'module_id' => $ticket->id,
                'module' => 'Ticket',
                'activity' => 'Ticket ' . $ticket->ticket_code . ' Deleted',
            ]);
        }
        $ticket->delete();

        return redirect(route('ticket.index'))->with(['success' => 'Ticket Deleted Sussessfully']);
    }
}
