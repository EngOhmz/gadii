<?php

namespace App\Http\Controllers\GoalTracking;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Goal_Tracking\Milestone;
use App\Models\Project\Project;
use App\Models\Client;
use App\Models\Goal_Tracking\TaskCategory;
use App\Models\Goal_Tracking\Billing_Type;
use App\Models\Goal_Tracking\TaskActivity;
use App\Models\Goal_Tracking\Task;
use App\Models\Goal_Tracking\Comment;
use App\Models\User;
use App\Models\POS\Items;
use App\Models\AccountCodes;
use App\Models\Goal_Tracking\TaskAssignment;

use Session;

class TaskController extends Controller
{
    public function index()
    {
        $project = Project::all()
            ->where('added_by', auth()->user()->added_by)
            ->where('disabled', '0');
        $task = Task::all()
            ->where('added_by', auth()->user()->added_by)
            ->whereNull('task_id')
            ->where('disabled', '0');
        $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);
        $milestones = Milestone::all()->where('added_by', auth()->user()->added_by);
        $leads = Leads::all()->where('added_by', auth()->user()->added_by);
        $billing_type = Billing_Type::all()->where('added_by', auth()->user()->added_by);
        $user = User::all()->where('added_by',auth()->user()->added_by);

        $count = Task::all()
            ->where('added_by', auth()->user()->added_by)
            ->whereNull('task_id')
            ->where('disabled', '0')
            ->count();
        $pro = $count + 1;
        $reference = '00' . $pro;

        return view('cf.task.index', compact('project', 'categories', 'billing_type', 'task', 'milestones', 'leads', 'user', 'reference'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // $data = $request->all();client_visible

        $data['project_id'] = $request->project_id;

        $data['category_id'] = $request->category_id;

        $data['goal_tracking_id'] = $request->goal_tracking_id;

        $data['milestone_id'] = $request->milestone_id;

        $data['task_name'] = $request->task_name;

        $data['task_start_date'] = $request->task_start_date;

        $data['task_status'] = $request->task_status;

        $data['task_description'] = $request->task_description;

        $data['due_date'] = $request->due_date;

        $data['task_progress'] = $request->task_progress;

        $data['calculate_progress'] = $request->calculate_progress;

        // $data['task_hour']=$request->task_hour;

        // $data['hourly_rate']=$request->hourly_rate;

        // $data['tags']=$request->tags;

        $data['billable'] = $request->billable;

        // $data['client_visible']=$request->client_visible;

        // $data['assigned_to']=$request->assigned_to;

        $trans_id = $request->trans_id;

        $data['assigned_to'] = implode(',', $trans_id);

        $data['leads_id'] = $request->leads_id;

        $data['added_by'] = auth()->user()->added_by;

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
            $activity = TaskActivity::create([
                'added_by' => auth()->user()->id,
                'module_id' => $task->id,
                'task_id' => $task->id,
                'module' => 'Task',
                'activity' => 'Task ' . $task->name . ' - ' . $task->id . 'Created',
            ]);
        }

        return redirect(route('cf_task.index'))->with(['success' => 'Task Created Successfully']);
    }
    public function edit($id)
    {
        //
        $data = Task::find($id);

        $task = Task::all()
            ->where('added_by', auth()->user()->added_by)
            ->whereNull('task_id');
        $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);
        $billing_type = Billing_Type::all()->where('added_by', auth()->user()->added_by);
        $project = Project::all()->where('added_by', auth()->user()->added_by);
        $leads = Leads::all()->where('added_by', auth()->user()->added_by);
        $milestones = Milestone::all()->where('added_by', auth()->user()->added_by);

        return view('cf.task.index', compact('data', 'categories', 'billing_type', 'task', 'id', 'project', 'leads', 'milestones'));
    }

    // public function show($id)
    // {
    //     //
    //     $type = Session::get('type');
    //     if(empty($type))
    //     $type='details';

    //     $data = Task::find($id);

    //     return view('cf.task.project_details',compact('data', 'id','type'));
    // }

    public function show($id)
    {
        //
        $data = Task::find($id);

        $type = Session::get('type');
        if (empty($type)) {
            $type = 'details';
        }

        $comment_details = Comment::where('task_id', $id)
            ->where('disabled', '0')
            ->where('comments_reply_id', '0')
            ->orderBy('comment_datetime', 'DESC')
            ->get();
        $task = Task::all()
            ->where('added_by', auth()->user()->added_by)
            ->where('task_id', $id)
            ->where('disabled', '0');
        $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);
        $milestones = Milestone::all()->where('added_by', auth()->user()->added_by);
        $user = User::all()->where('added_by', auth()->user()->added_by);

        $ccount = Comment::where('task_id', $id)
            ->where('disabled', '0')
            ->where('comments_reply_id', '0')
            ->count();

        // $tcount = Task::where('added_by', auth()->user()->added_by)
        //     ->where('task_id', $id)
        //     ->where('disabled', '0')
        //     ->count();

        return view('goalTracking.task.project_details', compact('data', 'id', 'type', 'comment_details', 'task', 'categories', 'milestones', 'user', 'ccount'));
    }

    // ---------------------------------------------------

    public function save_details(Request $request)
    {
        switch ($request->type) {
            case 'comments':
                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['user_id'] = auth()->user()->id;

                $calls = Comment::create($data);

                if (!empty($calls)) {
                    $activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $calls->id,
                        'task_id' => $request->task_id,
                        'module' => 'Comment',
                        'activity' => 'Comment Created',
                    ]);
                }

                return redirect(route('cf_task.show', $request->task_id))->with(['success' => 'Details Created Successfully', 'type' => 'comments']);

                break;

            case 'comments-reply':
                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['user_id'] = auth()->user()->id;

                $calls = Comment::create($data);

                if (!empty($calls)) {
                    $activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $calls->id,
                        'task_id' => $request->task_id,
                        'module' => 'Comment',
                        'activity' => 'Reply on Comment Created',
                    ]);
                }

                return redirect(route('cf_task.show', $request->task_id))->with(['success' => 'Details Created Successfully', 'type' => 'comments']);

                break;


            case 'tasks':
                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['goal_tracking_id'] = 'Projects';

                $task = Task::create($data);

                if (!empty($task)) {
                    $task = Task::find($request->task_id);

                    $task_activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $task->id,
                        'task_id' => $request->task_id,
                        'module' => 'Task',
                        'activity' => 'Task ' . $task->task_name . ' Created',
                    ]);
                }

                return redirect(route('cf_task.show', $request->task_id))->with(['success' => 'Details Created Successfully', 'type' => 'tasks']);
                break;

            default:
                return abort(404);
        }
    }

    public function edit_details($type, $type_id)
    {
        switch ($type) {
            case 'edit-attachment':
                $edit_data = Attachment::find($type_id);
                $id = $edit_data->task_id;
                $data = Task::find($id);
                $name = Items::where('added_by', auth()->user()->added_by)->get();
                $billing_type = Billing_Type::all()->where('added_by', auth()->user()->added_by);
                $milestones = Milestone::all()->where('added_by', auth()->user()->added_by);

                $project = Project::all()->where('added_by', auth()->user()->added_by);
                $leads = Leads::all()->where('added_by', auth()->user()->added_by);
                $task = Task::all()
                    ->where('added_by', auth()->user()->added_by)
                    ->where('task_id', $id)
                    ->where('disabled', '0');

                $comment_details = Comment::where('task_id', $id)
                    ->where('disabled', '0')
                    ->where('comments_reply_id', '0')
                    ->orderBy('comment_datetime', 'DESC')
                    ->get();
                $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);
                $attach = Attachment::where('task_id', $id)
                    ->where('disabled', '0')
                    ->get();

                $activity = TaskActivity::where('task_id', $id)->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')
                    ->where('added_by', auth()->user()->added_by)
                    ->get();

                $ccount = Comment::where('task_id', $id)
                    ->where('disabled', '0')
                    ->where('comments_reply_id', '0')
                    ->count();
                $attcount = Attachment::where('task_id', $id)
                    ->where('disabled', '0')
                    ->count();

                $actcount = TaskActivity::where('task_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)
                    ->where('task_id', $id)
                    ->where('disabled', '0')
                    ->count();

                return view('project.task.project_details', compact('data', 'id', 'type', 'type_id', 'edit_data', 'name', 'chart_of_accounts', 'activity', 'comment_details', 'attach', 'task', 'leads', 'project', 'categories', 'milestones', 'billing_type', 'ccount', 'attcount', 'ncount', 'actcount', 'tcount'));

                break;

                break;

            case 'edit-tasks':
                $edit_data = Task::find($type_id);
                $id = $edit_data->task_id;
                $data = Task::find($id);
                $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);
                $billing_type = Billing_Type::all()->where('added_by', auth()->user()->added_by);
                $milestones = Milestone::all()->where('added_by', auth()->user()->added_by);

                $project = Project::all()->where('added_by', auth()->user()->added_by);
                $leads = Leads::all()->where('added_by', auth()->user()->added_by);
                $task = Task::all()
                    ->where('added_by', auth()->user()->added_by)
                    ->where('task_id', $id)
                    ->where('disabled', '0');

                $comment_details = Comment::where('task_id', $id)
                    ->where('disabled', '0')
                    ->where('comments_reply_id', '0')
                    ->orderBy('comment_datetime', 'DESC')
                    ->get();
                $attach = Attachment::where('task_id', $id)
                    ->where('disabled', '0')
                    ->get();

                $activity = TaskActivity::where('task_id', $id)->get();

                $user = User::all()->where('added_by', auth()->user()->added_by);
                $name = Items::where('added_by', auth()->user()->added_by)->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')
                    ->where('added_by', auth()->user()->added_by)
                    ->get();

                $ccount = Comment::where('task_id', $id)
                    ->where('disabled', '0')
                    ->where('comments_reply_id', '0')
                    ->count();
                $attcount = Attachment::where('task_id', $id)
                    ->where('disabled', '0')
                    ->count();

                $actcount = TaskActivity::where('task_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)
                    ->where('task_id', $id)
                    ->where('disabled', '0')
                    ->count();

                return view('project.task.project_details', compact('data', 'id', 'type', 'type_id', 'edit_data', 'activity', 'comment_details', 'attach', 'task', 'leads', 'project',
                'categories', 'milestones', 'user', 'name', 'chart_of_accounts', 'billing_type', 'ccount', 'attcount', 'ncount', 'actcount', 'tcount'));

                break;

            default:
                return abort(404);
        }
    }

    public function update_details(Request $request)
    {
        switch ($request->type) {
            case 'attachment':
                $calls = Attachment::find($request->id);

                if ($request->hasFile('attachment')) {
                    $filenameWithExt = $request->file('attachment')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('attachment')->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $path = $request->file('attachment')->storeAs('project', $fileNameToStore);
                } else {
                    $fileNameToStore = '';
                }

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['attachment'] = $fileNameToStore;

                if (!empty($calls->attachment)) {
                    if ($request->hasFile('attachment')) {
                        unlink('project/' . $calls->attachment);
                    }
                }

                $calls->update($data);

                if (!empty($calls)) {
                    $activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $calls->id,
                        'task_id' => $request->task_id,
                        'module' => 'Attachment',
                        'activity' => 'Attachment ' . $calls->title . ' Updated',
                    ]);
                }

                return redirect(route('cf_task.show', $request->task_id))->with(['success' => 'Details Updated Successfully', 'type' => 'attachment']);

                break;

            case 'tasks':
                $task = Task::find($request->id);

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['goal_tracking_id'] = 'Projects';

                $task->update($data);

                if (!empty($task)) {
                    $task = Task::find($request->task_id);

                    $task_activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $task->id,
                        'module' => 'Task',
                        'activity' => 'Task ' . $task->task_name . ' Updated',
                    ]);
                }

                return redirect(route('cf_task.show', $request->task_id))->with(['success' => 'Details Created Successfully', 'type' => 'tasks']);
                break;

            default:
                return abort(404);
        }
    }

    public function delete_details($type, $type_id)
    {
        switch ($type) {
            case 'delete-comments':
                $edit_data = Comment::find($type_id);
                $id = $edit_data->task_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'task_id' => $id,
                        'module' => 'Comment',
                        'activity' => 'Comment  Deleted',
                    ]);
                }

                return redirect(route('cf_task.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'comments']);

            case 'delete-attachment':
                $edit_data = Attachment::find($type_id);
                $id = $edit_data->task_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'task_id' => $id,
                        'module' => 'Attachment',
                        'activity' => 'Attachment ' . $edit_date->title . ' Deleted',
                    ]);
                }

                return redirect(route('cf_task.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'attachment']);

                break;

            case 'delete-meetings':
                $edit_data = Notes::find($type_id);
                $id = $edit_data->task_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'task_id' => $id,
                        'module' => 'Notes',
                        'activity' => 'Notes Deleted',
                    ]);
                }

                return redirect(route('cf_task.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'notes']);

                break;

            case 'delete-tasks':
                $edit_data = Task::find($type_id);
                $id = $edit_data->task_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $task_activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'task_id' => $type_id,
                        'module' => 'Task',
                        'activity' => 'Task ' . $edit_data->task_name . ' Deleted',
                    ]);
                }

                return redirect(route('cf_task.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'tasks']);
                break;

            default:
                return abort(404);
        }
    }

    public function discountModal(Request $request)
    {
        $id = $request->id;
        $type = $request->type;

        if ($type == 'assign') {
            $user = User::where('added_by', auth()->user()->added_by)->get();
            $data = Task::find($id);
            return view('goalTracking.task.assign_user', compact('id', 'user', 'data'));
        } elseif ($type == 'view') {
            $user = TaskAssignment::where('task_id', $id)->get();
            $data = Task::find($id);
            
            return view('goalTracking.task.view_user', compact('id', 'user', 'data'));
        }
    }

    public function addCategory(Request $request)
    {
        $category = TaskCategory::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'added_by' => auth()->user()->added_by,
        ]);

        if (!empty($category)) {
            return response()->json($category);
        }
    }

    public function change_status($id, $status)
    {
        $task = Task::find($id);

        if (!empty($task)) {
            $activity = TaskActivity::create([
                'added_by' => auth()->user()->id,
                'module_id' => $task->id,
                'task_id' => $task->id,
                'module' => 'Task',
                'activity' => 'Task ' . $task->task_name . '-' . $task->id . 'Status has been Changed from ' . $task->task_status . ' to ' . $status,
            ]);
        }

        $task->update(['task_status' => $status]);

        return redirect(route('task.index'))->with(['success' => 'Task Status Changed Successfully']);
    }

    public function assign_user(Request $request)
    {
        //
        $trans_id = $request->trans_id;

        if (!empty($trans_id)) {
            $project = Task::find($request->task_id);
            $d = implode(',', $trans_id);

            TaskAssignment::where('task_id', $request->task_id)->delete();

            for ($i = 0; $i < count($trans_id); $i++) {
                if (!empty($trans_id[$i])) {
                    $data['task_id'] = $request->task_id;
                    $data['user_id'] = $trans_id[$i];
                    $data['added_by'] = auth()->user()->added_by;
                    TaskAssignment::create($data);
                }
            }

            Task::find($request->task_id)->update(['assigned_to' => $d]);
            return redirect(route('cf_task.index'))->with(['success' => 'Assignment Successfully']);
        } else {
            return redirect(route('cf_task.index'))->with(['error' => 'You have not chosen an entry']);
        }
    }

    public function update(Request $request, $id)
    {
        $data['project_id'] = $request->project_id;

        $data['category_id'] = $request->category_id;

        $data['goal_tracking_id'] = $request->goal_tracking_id;

        $data['milestone_id'] = $request->milestone_id;

        $data['task_name'] = $request->task_name;

        $data['task_start_date'] = $request->task_start_date;

        $data['task_status'] = $request->task_status;

        $data['task_description'] = $request->task_description;

        $data['due_date'] = $request->due_date;

        $data['task_progress'] = $request->task_progress;

        $data['calculate_progress'] = $request->calculate_progress;

        // $data['task_hour']=$request->task_hour;

        // $data['hourly_rate']=$request->hourly_rate;

        // $data['tags']=$request->tags;

        $data['billable'] = $request->billable;

        // $data['client_visible']=$request->client_visible;

        $data['assigned_to'] = $request->assigned_to;

        $data['leads_id'] = $request->leads_id;

        $data['added_by'] = auth()->user()->added_by;

        $task = Task::find($id)->update($data);

        if (!empty($task)) {
            $activity = TaskActivity::create([
                'added_by' => auth()->user()->id,
                'module_id' => $task->id,
                'task_id' => $task->id,
                'module' => 'Task',
                'activity' => 'Task ' . $task->name . ' - ' . $task->id . 'Updated',
            ]);
        }

        return redirect(route('cf_task.index'))->with(['success' => 'Task updated Successfully']);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!empty($task)) {
            $activity = TaskActivity::create([
                'added_by' => auth()->user()->id,
                'module_id' => $task->id,
                'task_id' => $task->id,
                'module' => 'Task',
                'activity' => 'Task ' . $task->name . ' - ' . $task->id . 'Deleted',
            ]);
        }

        $task->update(['disabled' => '1']);

        return redirect(route('cf_task.index'))->with(['success' => 'Task Deleted Sussessfully']);
    }

    public function file_preview(Request $request)
    {
        $id = $request->id;

        $data = Attachment::find($id);
        $filename = $data->attachment;
        return view('cf.task.file_preview', compact('filename'));
    }
}
