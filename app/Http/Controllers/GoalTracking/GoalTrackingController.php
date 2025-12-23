<?php

namespace App\Http\Controllers\GoalTracking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Goal_Tracking\Achievement;
use App\Models\Goal_Tracking\GoalTracking;
use App\Models\Goal_Tracking\GoalAssignment;
use App\Models\Goal_Tracking\Comment;
use App\Models\Goal_Tracking\Activity;
use App\Models\Goal_Tracking\TaskCategory;
use App\Models\Goal_Tracking\TaskActivity;
use App\Models\Goal_Tracking\TaskAssignment;
use App\Models\Goal_Tracking\Task;
use App\Models\Goal_Tracking\Milestone;
use App\Models\Goal_Tracking\MilestoneActivity;
use App\Models\POS\Invoice;
use App\Models\POS\InvoicePayments;
use App\Models\Project\Ticket;
use App\Models\Expenses;
use App\Models\Leads\Leads;
use App\Models\User;
use Carbon\Carbon;
use Session;

class GoalTrackingController extends Controller
{
    public function index()
    {
        $data = Achievement::all();
        $user = User::all()->where('added_by', auth()->user()->added_by);
        $goal = GoalTracking::all()->where('added_by', auth()->user()->added_by);
        return view('goalTracking.index', compact('data', 'user', 'goal'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['added_by'] = auth()->user()->added_by;

        $trans_id = $request->trans_id;
        $data['assigned_to'] = implode(',', $trans_id);

       if (Carbon::now() < Carbon::parse($request->start_date)->format('Y-m-d')) {
            $data['status'] = 'Not Started';
        } elseif (Carbon::now() >= Carbon::parse($request->start_date)->format('Y-m-d') && Carbon::now() < Carbon::parse($request->end_date)->format('Y-m-d') ) {
            $data['status'] = 'On Going';
        } elseif (Carbon::now() > Carbon::parse($request->end_date)->format('Y-m-d')) {
            $data['status'] = 'Ended';
        }

        $save = GoalTracking::create($data);

        if (!empty($trans_id)) {
            for ($i = 0; $i < count($trans_id); $i++) {
                if (!empty($trans_id[$i])) {
                    $data_ass['goal_id'] = $save->id;
                    $data_ass['user_id'] = $trans_id[$i];
                    $data_ass['added_by'] = auth()->user()->added_by;

                    GoalAssignment::create($data_ass);
                }
            }
        }

        return redirect(route('goal.index'))->with(['success' => ' Created Successfully']);
    }
    public function show($id)
    {
        $data = GoalTracking::find($id);

        $type = Session::get('type');

        if (empty($type)) {
            $type = 'details';
        } else {
            $type = Session::get('type');
        }

        $comment_details = Comment::where('goal_id', $id)
            ->where('disabled', '0')
            ->where('comments_reply_id', '0')
            ->orderBy('comment_datetime', 'DESC')
            ->get();
        $task = Task::all()
            ->where('added_by', auth()->user()->added_by)
            ->where('goal_id', $id)
            ->where('disabled', '0');
        $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);
        
        $mile = Milestone::all()
            ->where('goal_id', $id)
            ->where('disabled', '0')
            ->where('added_by', auth()->user()->added_by);
        $user = User::all()->where('added_by', auth()->user()->added_by);

        
        
         $expense = Expenses::where('multiple', '0')
            ->where('added_by', auth()->user()->added_by)
            ->where('user_id', $data->user_id)
            ->sum('amount');
            
        $converted = Leads::where('change_status','1')
        ->where('added_by', auth()->user()->added_by)
        ->where('assigned_to', $data->user_id)
        ->count();
        
         $ticket = Ticket::where('status','Closed')
        ->where('added_by', auth()->user()->added_by)
        ->where('reporter', $data->user_id)
        ->count();
       
            
        $fixed = Invoice::where('good_receive', 1)
            ->where('added_by', auth()->user()->added_by)
            ->where('user_id', $data->user_id)
            ->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));
            
       $payment = InvoicePayments::where('added_by', auth()->user()->added_by)
            ->where('user_id', $data->user_id)
            ->sum('amount');

       if ($data->achievement_id == '1') {
            
            if($fixed > 0){
            $totol = ($data->target_amount / $fixed) * 100;
            }
            
            else{
             $totol=0;   
            }
            
            
        } elseif ($data->achievement_id == '2') {
             if($payment > 0){
            $totol = ($data->target_amount / $payment) * 100;
        }
            
            else{
             $totol=0;   
            }
        } elseif ($data->achievement_id == '3') {
             if($expense > 0){
            $totol = ($data->target_amount / $expense) * 100;
             }
            
            else{
             $totol=0;   
            }
        } elseif ($data->achievement_id == '4') {
             if($converted > 0){
            $totol = ( $converted / $data->target_amount) * 100;
             }
            
            else{
             $totol=0;   
            }
        } elseif ($data->achievement_id == '5') {
            
            if($ticket > 0){
            $totol = ( $ticket / $data->target_amount) * 100;
             }
            
            else{
            $totol=0;   
            }
        
        }

        return view('goalTracking.goal_details', compact('data', 'id', 'type', 'comment_details', 'mile', 'user', 'categories', 'task', 'totol'));
    }

    public function edit($id)
    {
        $edit_data = GoalTracking::find($id);
        $data = Achievement::all();
        $user = User::all()->where('added_by', auth()->user()->added_by);

        return view('goalTracking.index', compact('id', 'edit_data','data','user'));
    }
    public function edit_details($type, $type_id)
    {
        switch ($type) {
            case 'edit-task':
                $edit_data = Task::find($type_id);
                $id = $edit_data->goal_id;
                $data = GoalTracking::find($id);
                $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);
                $user = User::all()->where('added_by', auth()->user()->added_by);
                $task = Task::all()
                    ->where('added_by', auth()->user()->added_by)
                    ->where('goal_id', $id)
                    ->where('disabled', '0');

                $mile = Milestone::all()
                    ->where('goal_id', $id)
                    ->where('disabled', '0')
                    ->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('goal_id', $id)
                    ->where('disabled', '0')
                    ->where('comments_reply_id', '0')
                    ->count();
                $actcount = Activity::where('goal_id', $id)->count();

                $tcount = Task::where('added_by', auth()->user()->added_by)
                    ->where('goal_id', $id)
                    ->where('disabled', '0')
                    ->count();
                $mcount = Milestone::all()
                    ->where('goal_id', $id)
                    ->where('disabled', '0')
                    ->where('added_by', auth()->user()->added_by)
                    ->count();
                $pro_det = GoalTracking::find($id);

                     if ($data->achievement_id == '1') {
                
                        if($fixed > 0){
                        $totol = ($data->target_amount / $fixed) * 100;
                        }
                        
                        else{
                         $totol=0;   
                        }
                        
                        
                    } elseif ($data->achievement_id == '2') {
                         if($payment > 0){
                        $totol = ($data->target_amount / $payment) * 100;
                    }
                        
                        else{
                         $totol=0;   
                        }
                    } elseif ($data->achievement_id == '3') {
                         if($expense > 0){
                        $totol = ($data->target_amount / $expense) * 100;
                         }
                        
                        else{
                         $totol=0;   
                        }
                    }  elseif ($data->achievement_id == '4') {
                         if($converted > 0){
                        $totol = ( $converted / $data->target_amount) * 100;
                         }
                        
                        else{
                         $totol=0;   
                    }
                    }
                    elseif ($data->achievement_id == '5') {
            
                    if($ticket > 0){
                    $totol = ( $ticket / $data->target_amount) * 100;
                     }
                    
                    else{
                    $totol=0;   
                    }
                
                }

                return view('goalTracking.goal_details', compact('data', 'id', 'type', 'type_id', 'edit_data', 'categories', 'user', 'task', 'mile', 'ccount', 'actcount', 'tcount', 'mcount', 'pro_det', 'totol'));

                break;

            case 'edit-milestone':
                $edit_data = Milestone::find($type_id);
                $id = $edit_data->goal_id;
                $data = GoalTracking::find($id);
                $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);
                $user = User::all()->where('added_by', auth()->user()->added_by);
                $task = Task::all()
                    ->where('added_by', auth()->user()->added_by)
                    ->where('goal_id', $id)
                    ->where('disabled', '0');

                $mile = Milestone::all()
                    ->where('goal_id', $id)
                    ->where('disabled', '0')
                    ->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('goal_id', $id)
                    ->where('disabled', '0')
                    ->where('comments_reply_id', '0')
                    ->count();
                $actcount = Activity::where('goal_id', $id)->count();

                $tcount = Task::where('added_by', auth()->user()->added_by)
                    ->where('goal_id', $id)
                    ->where('disabled', '0')
                    ->count();
                $mcount = Milestone::all()
                    ->where('goal_id', $id)
                    ->where('disabled', '0')
                    ->where('added_by', auth()->user()->added_by)
                    ->count();
                $pro_det = GoalTracking::find($id);
                
              if ($data->achievement_id == '1') {
                        
                        if($fixed > 0){
                        $totol = ($data->target_amount / $fixed) * 100;
                        }
                        
                        else{
                         $totol=0;   
                        }
                        
                        
                    } elseif ($data->achievement_id == '2') {
                         if($payment > 0){
                        $totol = ($data->target_amount / $payment) * 100;
                    }
                        
                        else{
                         $totol=0;   
                        }
                    } elseif ($data->achievement_id == '3') {
                         if($expense > 0){
                        $totol = ($data->target_amount / $expense) * 100;
                         }
                        
                        else{
                         $totol=0;   
                        }
                    } elseif ($data->achievement_id == '4') {
                         if($converted > 0){
                        $totol = ( $converted / $data->target_amount) * 100;
                         }
                        
                        else{
                         $totol=0;   
                    }
                    }
                    elseif ($data->achievement_id == '5') {
                        
                        if($ticket > 0){
                        $totol = ( $ticket / $data->target_amount) * 100;
                         }
                        
                        else{
                        $totol=0;   
                        }
                    
                    }
                return view('goalTracking.goal_details', compact('data', 'id', 'type', 'type_id', 'edit_data', 'categories', 'user', 'task', 'mile', 'ccount', 'actcount', 'tcount', 'mcount', 'pro_det', 'totol'));

                break;
        }
    }

    public function save_details(Request $request)
    {
        switch ($request->type) {
            case 'comments':
                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['user_id'] = auth()->user()->id;

                $calls = Comment::create($data);

                if (!empty($calls)) {
                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $calls->id,
                        'goal_id' => $request->goal_id,
                        'module' => 'Comment',
                        'activity' => 'Comment Created',
                    ]);
                }

                return redirect(route('goal.show', $request->goal_id))->with(['success' => 'Details Created Successfully', 'type' => 'comments']);

                break;

            case 'comments-reply':
                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['user_id'] = auth()->user()->id;

                $calls = Comment::create($data);

                if (!empty($calls)) {
                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $calls->id,
                        'goal_id' => $request->goal_id,
                        'module' => 'Comment',
                        'activity' => 'Reply on Comment Created',
                    ]);
                }

                return redirect(route('cf.show', $request->goal_id))->with(['success' => 'Details Created Successfully', 'type' => 'comments']);

                break;

            case 'tasks':
                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['goal_tracking_id'] = $request->goal_id;
                $trans_id = $request->trans_id;

                $data['assigned_to'] = implode(',', $trans_id);

                $task = Task::create($data);

                if (!empty($trans_id)) {
                    for ($i = 0; $i < count($trans_id); $i++) {
                        if (!empty($trans_id[$i])) {
                            $data['task_id'] = $task->id;
                            $data['user_id'] = $trans_id[$i];
                            $data['added_by'] = auth()->user()->added_by;
                            TaskAssignment::create($data);
                        }
                    }
                }

                if (!empty($task)) {
                    $project = GoalTracking::find($request->goal_id);

                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $task->id,
                        'goal_id' => $request->goal_id,
                        'module' => 'Tasks',
                        'activity' => 'Task ' . $task->task_name . ' Created for Project ' . $project->subject . '-' . $project->type,
                    ]);
                }

                return redirect(route('goal.show', $request->goal_id))->with(['success' => 'Details Created Successfully', 'type' => 'task']);
                break;

            case 'milestone':
                $data = $request->all();
                $data['description'] = $request->description;
                $data['added_by'] = auth()->user()->added_by;

                $milestone = Milestone::create($data);

                if (!empty($milestone)) {
                    $project = GoalTracking::find($request->goal_id);

                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $milestone->id,
                        'goal_id' => $request->goal_id,
                        'module' => 'Milestone',
                        'activity' => 'Milestone ' . $milestone->name . ' Created for Project ' . $project->subject . '-' . $project->type,
                    ]);
                }

                return redirect(route('goal.show', $request->goal_id))->with(['success' => 'Details Created Successfully', 'type' => 'milestone']);
                break;

            default:
                return abort(404);
        }
    }

    public function update_details(Request $request)
    {
        switch ($request->type) {
            case 'milestone':
                $milestone = Milestone::find($request->id);

                $data = $request->all();
                $data['description'] = $request->description;
                $data['added_by'] = auth()->user()->added_by;

                $milestone->update($data);

                if (!empty($milestone)) {
                    $project = GoalTracking::find($request->goal_id);

                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $milestone->id,
                        'goal_id' => $request->goal_id,
                        'module' => 'Milestone',
                        'activity' => 'Milestone ' . $milestone->name . ' Updated for Project ' . $project->subject . '-' . $project->project_no,
                    ]);
                }

                return redirect(route('goal.show', $request->goal_id))->with(['success' => 'Details Updated Successfully', 'type' => 'milestone']);
                break;

            case 'task':
                $task = Task::find($request->id);

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['goal_tracking_id'] = 'Projects';

                $task->update($data);

                if (!empty($task)) {
                    $project = GoalTracking::find($request->goal_id);

                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $task->id,
                        'goal_id' => $request->goal_id,
                        'module' => 'Tasks',
                        'activity' => 'Task ' . $task->task_name . ' Updated for Project ' . $project->subject . '-' . $project->goal_type,
                    ]);
                }

                return redirect(route('goal.show', $request->goal_id))->with(['success' => 'Details Updated Successfully', 'type' => 'task']);
                break;
        }
    }

    public function update(Request $request, $id)
    {
        $goal = GoalTracking::find($id);

        $data = $request->all();
        $data['added_by'] = auth()->user()->added_by;
     
       
        
        $trans_id = $request->trans_id;
        $data['assigned_to'] = implode(',', $trans_id);

       if (Carbon::now() < Carbon::parse($request->start_date)->format('Y-m-d')) {
            $data['status'] = 'Not Started';
        } elseif (Carbon::now() >= Carbon::parse($request->start_date)->format('Y-m-d') && Carbon::now() < Carbon::parse($request->end_date)->format('Y-m-d') ) {
            $data['status'] = 'On Going';
        } elseif (Carbon::now() > Carbon::parse($request->end_date)->format('Y-m-d')) {
            $data['status'] = 'Ended';
        }

         $goal->update($data);

        if (!empty($trans_id)) {
            for ($i = 0; $i < count($trans_id); $i++) {
                if (!empty($trans_id[$i])) {
                    $data_ass['goal_id'] = $goal->id;
                    $data_ass['user_id'] = $trans_id[$i];
                    $data_ass['added_by'] = auth()->user()->added_by;

                    GoalAssignment::create($data_ass);
                }
            }
        }
        
         if (!empty($goal)) {
                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $goal->id,
                        'goal_id' => $goal->id,
                        'module' => 'Goal',
                        'activity' => 'Goal Updated',
                    ]);
                }


        return redirect(route('goal.index'))->with(['success' => 'Updated Successfully']);
    }

    public function delete_goals($type, $type_id)
    {
        switch ($type) {
            case 'delete-comments':
                $edit_data = Comment::find($type_id);
                $id = $edit_data->goal_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'goal_id' => $id,
                        'module' => 'Comment',
                        'activity' => 'Comment  Deleted',
                    ]);
                }

                return redirect(route('goal.show', $id))->with(['success' => 'Delete Successfully', 'type' => 'comments']);

                break;

            case 'delete-milestone':
                $edit_data = Milestone::find($type_id);
                $id = $edit_data->goal_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $project = GoalTracking::find($id);

                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'goal_id' => $id,
                        'module' => 'Milestone',
                        'activity' => 'Milestone ' . $edit_data->name . ' Deleted for Project ' . $project->subject . '-' . $project->goal_subject,
                    ]);
                }
                return redirect(route('goal.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'milestone']);
                break;

            case 'delete-tasks':
                $edit_data = Task::find($type_id);
                $id = $edit_data->goal_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $project = GoalTracking::find($id);

                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'goal_id' => $id,
                        'module' => 'Tasks',
                        'activity' => 'Task ' . $edit_data->task_name . ' Deleted for Project ' . $project->subject . '-' . $project->goal_type,
                    ]);
                }

               return redirect(route('goal.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'task']);
                break;
        }
    }
}
