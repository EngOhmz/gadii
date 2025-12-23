<?php

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Leads\Leads;
use App\Models\Client;
use App\Models\Leads\LeadStatus;
use App\Models\Leads\LeadSource;
use App\Models\Leads\Calls;
use App\Models\Leads\Meetings;
use App\Models\Leads\MeetingsAttendees;
use App\Models\Leads\Activity;
use App\Models\Leads\Proposal;
use App\Models\Leads\Reminder;
use App\Models\Leads\ProposalItems;
use App\Models\Leads\ProposalAssignment;
use App\Models\POS\Items;
use App\Models\Language;
use App\Models\Country;
use App\Models\User;

use App\Models\Currency;

use App\Models\Location;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Payment_methodes;

use App\Models\Project\Milestone;
use App\Models\Project\Project;
use App\Models\Project\TaskCategory;
use App\Models\Project\Billing_Type;
use App\Models\Project\TaskActivity;
use App\Models\Project\Task;

use App\Models\Project\Comment;
use App\Models\Project\Attachment;
use App\Models\Project\Notes;


use Session;


class LeadsController extends Controller
{

    public function index()
    {

        $leads = Leads::all()->where('added_by', auth()->user()->added_by)->where('change_status', '0')->where('disabled', '0');
        $user = User::all()->where('added_by', auth()->user()->added_by);
        $status = LeadStatus::all()->where('added_by', auth()->user()->added_by);
        $source = LeadSource::all()->where('added_by', auth()->user()->added_by);
        $lang = Language::all();
        $country = Country::all();

        return view('leads.index', compact('leads', 'user', 'status', 'source', 'lang', 'country'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['added_by'] = auth()->user()->added_by;

        $leads = Leads::create($data);

        if (!empty($leads)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->id,
                    'module_id' => $leads->id,
                    'module' => 'Leads',
                    'leads_id' => $leads->id,
                    'activity' => "Leads " .  $leads->lead_name . " Created",
                ]
            );
        }

        return redirect(route('leads.index'))->with(['success' => 'Leads Created Successfully']);
    }


    public function show($id)
    {
        //

        $type = Session::get('type');
        if (empty($type))
            $type = 'details';

        $data = Leads::find($id);

        $comment_details = Comment::where('leads_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->orderBy('comment_datetime', 'DESC')->get();
        $attach = Attachment::where('leads_id', $id)->where('disabled', '0')->get();
        $reminders = Reminder::where('leads_id', $id)->get();
        $notes = Notes::where('leads_id', $id)->where('disabled', '0')->get();
        $activity = Activity::where('leads_id', $id)->get();

        $task = Task::all()->where('added_by', auth()->user()->added_by)->where('leads_id', $id)->where('disabled', '0');
        $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);

        $name = Items::where('added_by', auth()->user()->added_by)->get();
        $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
        $location = Location::where('added_by', auth()->user()->added_by)->get();;
        $currency = Currency::all();

        $users = User::all()->where('added_by', auth()->user()->added_by);

        $task_leads = Leads::all()->where('added_by', auth()->user()->added_by)->where('change_status', '0');

        $proposal = Proposal::all()->where('invoice_status', 1)->where('leads_id', $id)->where('added_by', auth()->user()->added_by);

        $calls = Calls::where('leads_id', $id)->where('disabled', '0')->get();
        $staff = User::all()->where('added_by', auth()->user()->added_by);
        $client = Client::all()->where('added_by', auth()->user()->added_by);
        $meetings = Meetings::where('leads_id', $id)->where('disabled', '0')->get();

        return view('leads.details', compact(
            'data',
            'id',
            'type',
            'calls',
            'staff',
            'client',
            'meetings',
            'proposal',
            'comment_details',
            'name',
            'chart_of_accounts',
            'location',
            'currency',
            'users',
            'task_leads',
            'attach',
            'notes',
            'activity',
            'reminders',
            'task',
            'categories'
        ));
    }

    public function edit($id)
    {
        //
        $data = Leads::find($id);

        $user = User::all()->where('added_by', auth()->user()->added_by);
        $status = LeadStatus::all()->where('added_by', auth()->user()->added_by);
        $source = LeadSource::all()->where('added_by', auth()->user()->added_by);
        $lang = Language::all();
        $country = Country::all();



        return view('leads.index', compact('data', 'user', 'status', 'source', 'lang', 'country', 'id'));
    }


    public function update(Request $request, $id)
    {
        $leads = Leads::find($id);

        $data = $request->all();
        $data['added_by'] = auth()->user()->added_by;

        $leads->update($data);

        if (!empty($leads)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->id,
                    'module_id' => $leads->id,
                    'module' => 'Leads',
                    'leads_id' => $leads->id,
                    'activity' => "Leads " .  $leads->lead_name . " Updated",
                ]
            );
        }

        return redirect(route('leads.index'))->with(['success' => 'Leads updated Successfully']);
    }

    // change_status

    public function change_status($id)
    {
        $leads = Leads::find($id);

        // $data = $request->all();
        // $data['change_status'] = 1;
        // $data['added_by'] = auth()->user()->added_by;

        // $leads ->update($data);

        $data['name'] = $leads->contact_name;
        $data['address'] = $leads->address;
        $data['phone'] = $leads->phone;
        $data['email'] = $leads->email;
        //   $data['name']=$leads->contact_name;
        $data['user_id'] = $leads->assigned_to;
        $data['owner_id'] = $leads->added_by;
        $client = Client::create($data);



        if (!empty($leads)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->id,
                    'module_id' => $leads->id,
                    'module' => 'Leads',
                    'leads_id' => $leads->id,
                    'activity' => "Leads " .  $leads->lead_name . " Changed Status to Client",
                ]
            );
        }

        $leads->update(['change_status' => '1', 'client_id' => $client->id]);

        return redirect(route('leads.index'))->with(['success' => 'Leads updated Successfully']);
    }



    public function destroy($id)
    {
        $leads = Leads::find($id);

        if (!empty($leads)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->id,
                    'module_id' => $leads->id,
                    'module' => 'Leads',
                    'leads_id' => $leads->id,
                    'activity' => "Leads " .  $leads->lead_name . " Deleted",
                ]
            );
        }
        $leads->update(['disabled' => '1']);

        return redirect(route('leads.index'))->with(['success' => 'Leads Deleted Sussessfully']);
    }



    public function discountModal(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        if ($type == 'status') {
            return view('leads.addstatus');
        } else if ($type == 'source') {
            return view('leads.addsource');
        }
    }



 public function addSource(Request $request)
{
    $data['lead_source'] = $request->lead_source;
    $data['added_by'] = auth()->user()->added_by;

    $source = LeadSource::create($data);

    return response()->json($source); // This matches your JavaScript now
}




    public function addStatus(Request $request)
    {

        $data['lead_status'] = $request['lead_status'];
        $data['lead_type'] = $request['lead_type'];
        $data['added_by'] = auth()->user()->added_by;

        $status = LeadStatus::create($data);


        if (!empty($status)) {
            return response()->json($status);
        }
    }


    public function file_preview(Request $request)
    {
        $id = $request->id;

        $data = Attachment::find($id);
        $filename =  $data->attachment;
        return view('leads.file_preview', compact('filename'));
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
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $calls->id,
                            'leads_id' => $request->leads_id,
                            'module' => 'Comment',
                            'activity' => "Comment Created",
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Created Successfully", 'type' => 'comments']);

                break;


            case 'comments-reply':

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['user_id'] = auth()->user()->id;

                $calls = Comment::create($data);

                if (!empty($calls)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $calls->id,
                            'leads_id' => $request->leads_id,
                            'module' => 'Comment',
                            'activity' => "Reply on Comment Created",
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Created Successfully", 'type' => 'comments']);

                break;


            case 'attachment':

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                if ($request->hasFile('attachment')) {
                    $filenameWithExt = $request->file('attachment')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('attachment')->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $path = $request->file('attachment')->storeAs('project', $fileNameToStore);
                } else {
                    $fileNameToStore = '';
                }

                $data['attachment'] = $fileNameToStore;
                $meet = Attachment::create($data);


                if (!empty($meet)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $meet->id,
                            'leads_id' => $request->leads_id,
                            'module' => 'Attachment',
                            'activity' => "Attachment " .  $meet->title . " Created",
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Created Successfully", 'type' => 'attachment']);
                break;

            case 'reminder':

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                $data['reminder_date'] = $request->reminder_date;

                $meet = Reminder::create($data);

                if (!empty($meet)) {
                    Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $meet->id,
                        'leads_id' => $request->leads_id,
                        'module' => 'Reminder',
                        'activity' => "Reminder '" . $meet->title . "' set for " . $meet->reminder_date,
                    ]);
                }

                return redirect(route('leads.show', $request->leads_id))
                    ->with(['success' => "Details Created Successfully", 'type' => 'reminder']);

                break;


            case 'notes':

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                $note = Notes::create($data);


                if (!empty($note)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $note->id,
                            'leads_id' => $request->leads_id,
                            'module' => 'Notes',
                            'activity' => "Notes  Created",
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Created Successfully", 'type' => 'notes']);
                break;



            case 'calls':

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                $calls = Calls::create($data);

                if (!empty($calls)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $calls->id,
                            'module' => 'Calls',
                            'leads_id' => $calls->leads_id,
                            'activity' => "Call Created",
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Created Successfully", 'type' => 'calls']);

                break;

            case 'tasks':

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['goal_tracking_id'] = 'Leads';

                $trans_id = $request->trans_id;

                $data['assigned_to'] = implode(",", $trans_id);;

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


                    $task_activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $task->id,
                            'leads_id' => $request->leads_id,
                            'module' => 'Task',
                            'activity' => "Task " .  $task->task_name .  " Created",
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Created Successfully", 'type' => 'tasks']);
                break;


            case 'proposal':

                $count = Proposal::count();
                $pro = $count + 1;
                $data['reference_no'] = "LD/P0" . $pro;
                $data['leads_id'] = $request->leads_id;
                $data['discount'] = $request->discount;
                $data['proposal_date'] = $request->proposal_date;
                $data['expire_date'] = $request->expire_date;
                $data['related'] = $request->related;
                $data['exchange_code'] = $request->exchange_code;
                $data['tags'] = $request->tags;

                $data['note'] = $request->notes;


                $data['invoice_amount'] = '1';
                $data['due_amount'] = '1';
                $data['invoice_tax'] = '1';
                $data['status'] = $request->status;
                $data['good_receive'] = '1';
                $data['invoice_status'] = '1';
                $data['added_by'] = auth()->user()->added_by;

                $trans_id = $request->trans_id;

                $data['assigned_to'] = implode(",", $trans_id);;




                $invoice = Proposal::create($data);

                if (!empty($trans_id)) {
                    for ($i = 0; $i < count($trans_id); $i++) {
                        if (!empty($trans_id[$i])) {


                            $data['proposal_id'] = $invoice->id;
                            $data['user_id'] = $trans_id[$i];
                            $data['added_by'] = auth()->user()->added_by;
                            ProposalAssignment::create($data);
                        }
                    }
                }

                $amountArr = str_replace(",", "", $request->amount);
                $totalArr =  str_replace(",", "", $request->tax);

                $nameArr = $request->item_name;
                $qtyArr = $request->quantity;
                $priceArr = $request->price;
                $rateArr = $request->tax_rate;
                $unitArr = $request->unit;
                $costArr = str_replace(",", "", $request->total_cost);
                $taxArr =  str_replace(",", "", $request->total_tax);


                $savedArr = $request->item_name;

                $cost['invoice_amount'] = 0;
                $cost['invoice_tax'] = 0;
                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($nameArr); $i++) {
                        if (!empty($nameArr[$i])) {
                            $cost['invoice_amount'] += $costArr[$i];
                            $cost['invoice_tax'] += $taxArr[$i];

                            $items = array(
                                'item_name' => $nameArr[$i],
                                'quantity' =>   $qtyArr[$i],
                                'due_quantity' =>   $qtyArr[$i],
                                'tax_rate' =>  $rateArr[$i],
                                'unit' => $unitArr[$i],
                                'price' =>  $priceArr[$i],
                                'total_cost' =>  $costArr[$i],
                                'total_tax' =>   $taxArr[$i],
                                'items_id' => $savedArr[$i],
                                'order_no' => $i,
                                'added_by' => auth()->user()->added_by,
                                'invoice_id' => $invoice->id
                            );

                            ProposalItems::create($items);;
                        }
                    }

                    $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
                    ProposalItems::where('id', $invoice->id)->update($cost);
                }

                Proposal::find($invoice->id)->update($cost);


                if (!empty($invoice)) {
                    $leads = Leads::find($request->leads_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $invoice->id,
                            'leads_id' => $request->leads_id,
                            'module' => 'Proposal',
                            'activity' => "Proposa with reference no  " .  $invoice->reference_no . "  is Created for Project " .  $leads->lead_name,
                        ]
                    );
                }



                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Created Successfully", 'type' => 'proposal']);
                break;



            case 'meetings':

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                $meet = Meetings::create($data);

                $nameArr = $request->attendee;

                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($nameArr); $i++) {
                        if (!empty($nameArr[$i])) {

                            $items = array(
                                'meeting_id' => $meet->id,
                                'user_id' => $nameArr[$i],
                                'added_by' => auth()->user()->added_by
                            );


                            MeetingsAttendees::create($items);
                        }
                    }
                }



                if (!empty($meet)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $meet->id,
                            'module' => 'Meetings',
                            'leads_id' => $meet->leads_id,
                            'activity' => "Meeting " .  $meet->meeting_subject . " Created",
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Created Successfully", 'type' => 'meetings']);
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
                $id = $edit_data->leads_id;
                $data = Leads::find($id);

                $calls = Calls::where('leads_id', $id)->where('disabled', '0')->get();
                $staff = User::all()->where('added_by', auth()->user()->added_by);
                $client = Client::all()->where('added_by', auth()->user()->added_by);
                $meetings = Meetings::where('leads_id', $id)->where('disabled', '0')->get();

                $name = Items::where('added_by', auth()->user()->added_by)->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->get();;
                $currency = Currency::all();

                $proposal = Proposal::all()->where('invoice_status', 1)->where('leads_id', $id)->where('added_by', auth()->user()->added_by);
                $users = User::all()->where('added_by', auth()->user()->added_by);

                $task_leads = Leads::all()->where('added_by', auth()->user()->added_by)->where('change_status', '0');

                $comment_details = Comment::where('leads_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->orderBy('comment_datetime', 'DESC')->get();
                $attach = Attachment::where('leads_id', $id)->where('disabled', '0')->get();
                $notes = Notes::where('leads_id', $id)->where('disabled', '0')->get();
                $activity = Activity::where('leads_id', $id)->get();

                return view('leads.details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'users',
                    'task_leads',
                    'proposal',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'calls',
                    'staff',
                    'client',
                    'meetings',
                    'comment_details',
                    'attach',
                    'notes',
                    'activity'
                ));

                break;

            case 'edit-notes':

                $edit_data = Notes::find($type_id);
                $id = $edit_data->leads_id;
                $data = Leads::find($id);

                $calls = Calls::where('leads_id', $id)->where('disabled', '0')->get();
                $staff = User::all()->where('added_by', auth()->user()->added_by);
                $client = Client::all()->where('added_by', auth()->user()->added_by);
                $meetings = Meetings::where('leads_id', $id)->where('disabled', '0')->get();

                $name = Items::where('added_by', auth()->user()->added_by)->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->get();;
                $currency = Currency::all();

                $proposal = Proposal::all()->where('invoice_status', 1)->where('leads_id', $id)->where('added_by', auth()->user()->added_by);

                $users = User::all()->where('added_by', auth()->user()->added_by);

                $task_leads = Leads::all()->where('added_by', auth()->user()->added_by)->where('change_status', '0');

                $comment_details = Comment::where('leads_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->orderBy('comment_datetime', 'DESC')->get();
                $attach = Attachment::where('leads_id', $id)->where('disabled', '0')->get();
                $notes = Notes::where('leads_id', $id)->where('disabled', '0')->get();
                $activity = Activity::where('leads_id', $id)->get();



                return view('leads.details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'users',
                    'task_leads',
                    'proposal',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'calls',
                    'staff',
                    'client',
                    'meetings',
                    'comment_details',
                    'attach',
                    'notes',
                    'activity'
                ));

                break;

            case 'edit-task':

                $edit_data = Task::find($type_id);
                $id = $edit_data->leads_id;
                $data = Leads::find($id);

                $name = Items::where('added_by', auth()->user()->added_by)->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->get();;
                $currency = Currency::all();

                $calls = Calls::where('leads_id', $id)->where('disabled', '0')->get();
                $staff = User::all()->where('added_by', auth()->user()->added_by);
                $client = Client::all()->where('added_by', auth()->user()->added_by);
                $meetings = Meetings::where('leads_id', $id)->where('disabled', '0')->get();

                $proposal = Proposal::all()->where('invoice_status', 1)->where('leads_id', $id)->where('added_by', auth()->user()->added_by);

                $users = User::all()->where('added_by', auth()->user()->added_by);

                $task_leads = Leads::all()->where('added_by', auth()->user()->added_by)->where('change_status', '0');

                $comment_details = Comment::where('leads_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->orderBy('comment_datetime', 'DESC')->get();
                $attach = Attachment::where('leads_id', $id)->where('disabled', '0')->get();
                $notes = Notes::where('leads_id', $id)->where('disabled', '0')->get();
                $activity = Activity::where('leads_id', $id)->get();

                return view('leads.details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'users',
                    'task_leads',
                    'proposal',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'calls',
                    'staff',
                    'client',
                    'meetings',
                    'comment_details',
                    'attach',
                    'notes',
                    'activity'
                ));

                break;

            case 'edit-proposal':

                $edit_data = Proposal::find($type_id);
                $id = $edit_data->leads_id;
                $data = Leads::find($id);
                $items = ProposalItems::all()->where('proposal_id', $id);

                $name = Items::where('added_by', auth()->user()->added_by)->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->get();;
                $currency = Currency::all();



                $calls = Calls::where('leads_id', $id)->where('disabled', '0')->get();
                $staff = User::all()->where('added_by', auth()->user()->added_by);
                $client = Client::all()->where('added_by', auth()->user()->added_by);
                $meetings = Meetings::where('leads_id', $id)->where('disabled', '0')->get();

                $proposal = Proposal::all()->where('invoice_status', 1)->where('leads_id', $id)->where('added_by', auth()->user()->added_by);

                $users = User::all()->where('added_by', auth()->user()->added_by);

                $task_leads = Leads::all()->where('added_by', auth()->user()->added_by)->where('change_status', '0');

                $comment_details = Comment::where('leads_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->orderBy('comment_datetime', 'DESC')->get();
                $attach = Attachment::where('leads_id', $id)->where('disabled', '0')->get();
                $notes = Notes::where('leads_id', $id)->where('disabled', '0')->get();
                $activity = Activity::where('leads_id', $id)->get();

                return view('leads.details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'items',
                    'edit_data',
                    'users',
                    'task_leads',
                    'proposal',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'calls',
                    'staff',
                    'client',
                    'meetings',
                    'comment_details',
                    'attach',
                    'notes',
                    'activity'
                ));

                break;




            case 'edit-calls':


                $edit_data = Calls::find($type_id);
                $id = $edit_data->leads_id;
                $data = Leads::find($id);

                $calls = Calls::where('leads_id', $id)->where('disabled', '0')->get();
                $staff = User::all()->where('added_by', auth()->user()->added_by);
                $client = Client::all()->where('added_by', auth()->user()->added_by);
                $meetings = Meetings::where('leads_id', $id)->where('disabled', '0')->get();

                $name = Items::where('added_by', auth()->user()->added_by)->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->get();;
                $currency = Currency::all();

                $proposal = Proposal::all()->where('invoice_status', 1)->where('leads_id', $id)->where('added_by', auth()->user()->added_by);

                $users = User::all()->where('added_by', auth()->user()->added_by);

                $task_leads = Leads::all()->where('added_by', auth()->user()->added_by)->where('change_status', '0');

                $comment_details = Comment::where('leads_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->orderBy('comment_datetime', 'DESC')->get();
                $attach = Attachment::where('leads_id', $id)->where('disabled', '0')->get();
                $notes = Notes::where('leads_id', $id)->where('disabled', '0')->get();
                $activity = Activity::where('leads_id', $id)->get();

                return view('leads.details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'users',
                    'task_leads',
                    'proposal',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'calls',
                    'staff',
                    'client',
                    'meetings',
                    'comment_details',
                    'attach',
                    'notes',
                    'activity'
                ));

                break;

            case 'edit-meetings':

                $edit_data = Meetings::find($type_id);
                $id = $edit_data->leads_id;
                $data = Leads::find($id);
                $edit_items = MeetingsAttendees::all()->where('meeting_id', $id);

                $calls = Calls::where('leads_id', $id)->where('disabled', '0')->get();
                $staff = User::all()->where('added_by', auth()->user()->added_by);
                $client = Client::all()->where('added_by', auth()->user()->added_by);
                $meetings = Meetings::where('leads_id', $id)->where('disabled', '0')->get();

                $name = Items::where('added_by', auth()->user()->added_by)->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->get();;
                $currency = Currency::all();

                $proposal = Proposal::all()->where('invoice_status', 1)->where('leads_id', $id)->where('added_by', auth()->user()->added_by);

                $users = User::all()->where('added_by', auth()->user()->added_by);

                $task_leads = Leads::all()->where('added_by', auth()->user()->added_by)->where('change_status', '0');

                $comment_details = Comment::where('leads_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->orderBy('comment_datetime', 'DESC')->get();
                $attach = Attachment::where('leads_id', $id)->where('disabled', '0')->get();
                $notes = Notes::where('leads_id', $id)->where('disabled', '0')->get();
                $activity = Activity::where('leads_id', $id)->get();

                return view('leads.details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_items',
                    'edit_data',
                    'users',
                    'task_leads',
                    'proposal',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'calls',
                    'staff',
                    'client',
                    'meetings',
                    'comment_details',
                    'attach',
                    'notes',
                    'activity'
                ));

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
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $calls->id,
                            'leads_id' => $request->leads_id,
                            'module' => 'Attachment',
                            'activity' => "Attachment " .  $calls->title . " Updated",
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Updated Successfully", 'type' => 'attachment']);

                break;

            case 'notes':

                $meet = Notes::find($request->id);

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                $meet->update($data);



                if (!empty($meet)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $meet->id,
                            'leads_id' => $request->leads_id,
                            'module' => 'Notes',
                            'activity' => "Notes Updated",
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Updated Successfully", 'type' => 'notes']);

                break;


            case 'tasks':

                $task = Task::find($request->id);

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['goal_tracking_id'] = 'Leads';

                $task->update($data);


                if (!empty($task)) {




                    $task_activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $task->id,
                            'module' => 'Task',
                            'leads_id' => $request->leads_id,
                            'activity' => "Task " .  $task->task_name .  " Updated",
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Created Successfully", 'type' => 'tasks']);
                break;


            case 'proposal':

                $invoice = Proposal::find($request->id);

                $data['leads_id'] = $request->leads_id;
                $data['discount'] = $request->discount;
                $data['proposal_date'] = $request->proposal_date;
                $data['expire_date'] = $request->expire_date;
                $data['related'] = $request->related;
                $data['exchange_code'] = $request->exchange_code;
                $data['tags'] = $request->tags;

                $data['note'] = $request->notes;


                $data['invoice_amount'] = '1';
                $data['due_amount'] = '1';
                $data['invoice_tax'] = '1';
                $data['status'] = $request->status;
                $data['good_receive'] = '1';
                $data['invoice_status'] = '1';
                $data['added_by'] = auth()->user()->added_by;

                $trans_id = $request->trans_id;

                $data['assigned_to'] = implode(",", $trans_id);;

                $invoice->update($data);

                $amountArr = str_replace(",", "", $request->amount);
                $totalArr =  str_replace(",", "", $request->tax);

                $nameArr = $request->item_name;
                $qtyArr = $request->quantity;
                $priceArr = $request->price;
                $rateArr = $request->tax_rate;
                $unitArr = $request->unit;
                $costArr = str_replace(",", "", $request->total_cost);
                $taxArr =  str_replace(",", "", $request->total_tax);
                $remArr = $request->removed_id;
                $expArr = $request->saved_items_id;
                $savedArr = $request->item_name;



                $cost['invoice_amount'] = 0;
                $cost['invoice_tax'] = 0;


                if (!empty($remArr)) {
                    for ($i = 0; $i < count($remArr); $i++) {
                        if (!empty($remArr[$i])) {
                            ProposalItems::where('id', $remArr[$i])->delete();
                        }
                    }
                }

                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($nameArr); $i++) {
                        if (!empty($nameArr[$i])) {
                            $cost['invoice_amount'] += $costArr[$i];
                            $cost['invoice_tax'] += $taxArr[$i];

                            $items = array(
                                'item_name' => $nameArr[$i],
                                'quantity' =>   $qtyArr[$i],
                                'due_quantity' =>   $qtyArr[$i],
                                'tax_rate' =>  $rateArr[$i],
                                'unit' => $unitArr[$i],
                                'price' =>  $priceArr[$i],
                                'total_cost' =>  $costArr[$i],
                                'total_tax' =>   $taxArr[$i],
                                'items_id' => $savedArr[$i],
                                'order_no' => $i,
                                'added_by' => auth()->user()->added_by,
                                'invoice_id' => $invoice->id
                            );

                            if (!empty($expArr[$i])) {
                                ProposalItems::where('id', $expArr[$i])->update($items);
                            } else {
                                ProposalItems::create($items);
                            }
                        }
                    }

                    $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
                    ProposalItems::where('id', $invoice->id)->update($cost);
                }

                Proposal::find($invoice->id)->update($cost);


                if (!empty($invoice)) {
                    $project = Leads::find($request->leads_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $invoice->id,
                            'leads_id' => $request->leads_id,
                            'module' => 'Proposal',
                            'activity' => "Proposal with reference no  " .  $invoice->reference_no . "  is Updated for Project " .  $project->lead_name,
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Updated Successfully", 'type' => 'proposal']);
                break;




            case 'calls':

                $calls = Calls::find($request->id);

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                $calls->update($data);

                if (!empty($calls)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $request->id,
                            'module' => 'Calls',
                            'leads_id' => $calls->leads_id,
                            'activity' => "Call Updated",
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Updated Successfully", 'type' => 'calls']);

                break;

            case 'meetings':

                $meet = Meetings::find($request->id);

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                $meet->update($data);

                $nameArr = $request->attendee;
                $remArr = $request->removed_id;
                $expArr = $request->saved_id;


                if (!empty($remArr)) {
                    for ($i = 0; $i < count($remArr); $i++) {
                        if (!empty($remArr[$i])) {
                            MeetingsAttendees::where('id', $remArr[$i])->delete();
                        }
                    }
                }


                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($nameArr); $i++) {
                        if (!empty($nameArr[$i])) {

                            $items = array(
                                'meeting_id' => $meet->id,
                                'user_id' => $nameArr[$i],
                                'added_by' => auth()->user()->added_by
                            );

                            if (!empty($expArr[$i])) {
                                MeetingsAttendees::where('id', $expArr[$i])->update($items);
                            } else {
                                MeetingsAttendees::create($items);
                            }
                        }
                    }
                }



                if (!empty($meet)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $meet->id,
                            'module' => 'Meetings',
                            'leads_id' => $meet->leads_id,
                            'activity' => "Meeting " .  $meet->meeting_subject . " Updated",
                        ]
                    );
                }

                return redirect(route('leads.show', $request->leads_id))->with(['success' => "Details Updated Successfully", 'type' => 'meetings']);
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
                $id = $edit_data->leads_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'leads_id' => $id,
                            'module' => 'Comment',
                            'activity' => "Comment  Deleted",
                        ]
                    );
                }


                return redirect(route('leads.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'comments']);

            case 'delete-attachment':


                $edit_data = Attachment::find($type_id);
                $id = $edit_data->leads_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'leads_id' => $id,
                            'module' => 'Attachment',
                            'activity' => "Attachment " .  $edit_data->title . " Deleted",
                        ]
                    );
                }


                return redirect(route('leads.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'attachment']);

                break;

            case 'delete-notes':


                $edit_data = Notes::find($type_id);
                $id = $edit_data->leads_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'leads_id' => $id,
                            'module' => 'Notes',
                            'activity' => "Notes Deleted",
                        ]
                    );
                }


                return redirect(route('leads.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'notes']);

                break;


            case 'delete-tasks':


                $edit_data = Task::find($type_id);
                $id = $edit_data->leads_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {

                    $task_activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'leads_id' => $id,
                            'module' => 'Task',
                            'activity' => "Task " .  $edit_data->task_name .  " Deleted",
                        ]
                    );
                }

                return redirect(route('leads.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'tasks']);

                break;

            case 'delete-proposal':

                $edit_data = Proposal::find($type_id);
                $id = $edit_data->leads_id;

                //$data['disabled'] = '1';        
                //$edit_data->update($data);
                ProposalItems::where('proposal_id', $type_id)->delete();
                $edit_data->delete();

                if (!empty($edit_data)) {
                    $project = Leads::find($id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'leads_id' => $id,
                            'module' => 'Proposal',
                            'activity' => "Proposal with reference no  " .  $edit_data->reference_no . "  is Deleted for Leads " .  $project->lead_name,
                        ]
                    );
                }


                return redirect(route('project.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'estimate']);
                break;



            case 'delete-calls':


                $edit_data = Calls::find($type_id);
                $id = $edit_data->leads_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $id,
                            'module' => 'Calls',
                            'leads_id' => $id,
                            'activity' => "Call Deleted",
                        ]
                    );
                }


                return redirect(route('leads.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'calls']);

                break;

            case 'delete-meetings':


                $edit_data = Meetings::find($type_id);
                $id = $edit_data->leads_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $id,
                            'module' => 'Meetings',
                            'leads_id' => $id,
                            'activity' => "Meeting " .  $edit_data->meeting_subject . " Deleted",
                        ]
                    );
                }


                return redirect(route('leads.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'meetings']);

                break;




            default:
                return abort(404);
        }
    }
}

