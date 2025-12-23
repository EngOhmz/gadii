<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Project\Project;
use App\Models\Client;
use App\Models\Departments;
use App\Models\Project\Category;
use App\Models\Project\Assignment;
use App\Models\Project\Billing_Type;
use App\Models\Project\Activity;
use App\Models\Project\Comment;
use App\Models\Project\Attachment;
use App\Models\Project\Notes;
use App\Models\Project\Milestone;
use App\Models\Project\MilestoneActivity;
use App\Models\Project\TaskCategory;
use App\Models\Project\TaskActivity;
use App\Models\Project\Task;
use App\Models\Currency;
use App\Models\POS\Items;
use App\Models\POS\Purchase;
use App\Models\POS\PurchaseItems;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\PurchasePayments;
use App\Models\POS\ReturnPurchases;
use App\Models\POS\ReturnPurchasesItems;
use App\Models\Supplier;
use App\Models\POS\Activity as POSActivity;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\InvoicePayments;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\POS\ReturnInvoice;
use App\Models\POS\ReturnInvoiceItems;
use App\Models\Location;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Payment_methodes;
use App\Models\Expenses;
use App\Models\User;
use App\Models\Branch;
use App\Models\Project\TaskAssignment;
use Session;
use PDF;
use App\Exports\ExportProfitReport;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{

    public function index()
    {
        $project = Project::all()->where('added_by', auth()->user()->added_by)->where('disabled', '0');
        $client = Departments::all()->where('added_by', auth()->user()->added_by);

        $clientspj = Client::where('owner_id', auth()->user()->added_by)->where('disabled', '0')->get();

        $category = Category::all()->where('added_by', auth()->user()->added_by);
        $billing_type = Billing_Type::all()->where('added_by', auth()->user()->added_by);
        $user = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);

        $count = Project::where('added_by', auth()->user()->added_by)->count();
        $pro = $count + 1;
        $reference = "00" . $pro;
        $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        return view('project.index', compact('project', 'category', 'billing_type', 'client', 'user', 'reference', 'clientspj', 'branch'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $trans_id = $request->trans_id;

        $cat_id = $request->category_id;

        $data['category_id'] = implode(",", $cat_id);;

        $data['added_by'] = auth()->user()->added_by;
        $data['assigned_to'] = implode(",", $trans_id);;

        $project = Project::create($data);

        if (!empty($trans_id)) {
            for ($i = 0; $i < count($trans_id); $i++) {
                if (!empty($trans_id[$i])) {


                    $data['project_id'] = $project->id;
                    $data['user_id'] = $trans_id[$i];
                    $data['added_by'] = auth()->user()->added_by;
                    Assignment::create($data);
                }
            }
        }


        if (!empty($project)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->id,
                    'module_id' => $project->id,
                    'project_id' => $project->id,
                    'module' => 'Project',
                    'activity' => "Project " .  $project->project_name . "-" . $project->project_no . " Created",
                ]
            );
        }

        return redirect(route('project.index'))->with(['success' => 'Project Created Successfully']);
    }
    public function edit($id)
    {
        //
        $data = Project::find($id);

        $client = Departments::all()->where('added_by', auth()->user()->added_by);
        $clientspj = Client::where('owner_id', auth()->user()->added_by)->where('disabled', '0')->get();
        $category = Category::all()->where('added_by', auth()->user()->added_by);
        $billing_type = Billing_Type::all()->where('added_by', auth()->user()->added_by);
        $user = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);


        return view('project.index', compact('data', 'category', 'billing_type', 'client', 'id', 'user', 'clientspj'));
    }

    public function show($id)
    {
        //
        $data = Project::find($id);

        $type = Session::get('type');
        if (empty($type))
            $type = 'details';

        $comment_details = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->orderBy('comment_datetime', 'DESC')->get();
        $attach = Attachment::where('project_id', $id)->where('disabled', '0')->get();
        $notes = Notes::where('project_id', $id)->where('disabled', '0')->get();
        $activity = Activity::where('project_id', $id)->get();
        $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
        $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
        $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
        $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
        $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);

        $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);

        $dn = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by);

        $prof = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
        $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
        $crd = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by);
        $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
        $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
        $location = Location::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
        $currency = Currency::all();
        $client = Client::where('owner_id', auth()->user()->added_by)->where('disabled', '0')->get();
        $supplier = Supplier::where('user_id', auth()->user()->added_by)->where('disabled', '0')->get();;
        $exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->orderBy('date', 'DESC')->get();;
        $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
        $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();

        $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
        $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;

        $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
        $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
        $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
        $actcount = Activity::where('project_id', $id)->count();
        $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
        $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
        $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
        $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
        $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
        $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
        $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
        $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
        $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();

        return view('project.project_details', compact(
            'data',
            'id',
            'type',
            'comment_details',
            'attach',
            'notes',
            'activity',
            'task',
            'categories',
            'mile',
            'users',
            'name',
            'currency',
            'inv',
            'location',
            'prof',
            'chart_of_accounts',
            'bank_accounts',
            'exp',
            'client',
            'crd',
            'fixed',
            'total_exp',
            'ccount',
            'attcount',
            'ncount',
            'actcount',
            'tcount',
            'mcount',
            'pcount',
            'invcount',
            'crdcount',
            'expcount',
            'pur',
            'dn',
            'purcount',
            'dncount',
            'supplier',
            'bname',
            'branch'
        ));
    }




    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        $trans_id = $request->trans_id;

        $data = $request->all();
        $data['added_by'] = auth()->user()->added_by;
        $data['assigned_to'] = implode(",", $trans_id);;

        $cat_id = $request->category_id;

        $data['category_id'] = implode(",", $cat_id);;

        $project->update($data);


        if (!empty($trans_id)) {

            Assignment::where('project_id', $id)->delete();

            for ($i = 0; $i < count($trans_id); $i++) {
                if (!empty($trans_id[$i])) {

                    $data['project_id'] = $id;
                    $data['user_id'] = $trans_id[$i];
                    $data['added_by'] = auth()->user()->added_by;
                    Assignment::create($data);
                }
            }
        }

        if (!empty($project)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->id,
                    'module_id' => $id,
                    'project_id' => $id,
                    'module' => 'Project',
                    'activity' => "Project " .  $project->project_name . "-" . $project->project_no . " Updated",
                ]
            );
        }

        return redirect(route('project.index'))->with(['success' => 'Project updated Successfully']);
    }

    public function destroy($id)
    {
        $project = Project::find($id);

        if (!empty($project)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->id,
                    'module_id' => $project->id,
                    'project_id' => $project->id,
                    'module' => 'Project',
                    'activity' => "Project " .  $project->project_name . "-" . $project->project_no . " Deleted",
                ]
            );
        }

        $project->update(['disabled' => '1']);

        return redirect(route('project.index'))->with(['success' => 'Project Deleted Sussessfully']);
    }


    public function change_status($id, $status)
    {

        $project = Project::find($id);

        if (!empty($project)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->id,
                    'module_id' => $project->id,
                    'project_id' => $project->id,
                    'module' => 'Project',
                    'activity' => "Project " .  $project->project_name . "-" . $project->project_no . "Status has been Changed from " . $project->status . " to " . $status,
                ]
            );
        }

        $project->update(['status' => $status]);


        return redirect(route('project.index'))->with(['success' => 'Status Changed Successfully']);
    }


    public function discountModal(Request $request)
    {
        $id = $request->id;
        $type = $request->type;

        if ($type == 'assign') {
            $user = User::where('added_by', auth()->user()->added_by)->get();
            $data = Project::find($id);
            return view('project.assign_user', compact('id', 'user', 'data'));
        } else if ($type == 'view') {
            $user = Assignment::where('project_id', $id)->get();
            $data = Project::find($id);
            return view('project.view_user', compact('id', 'user', 'data'));
        } elseif ($type == 'assignPCategory') {
            $user = User::where('added_by', auth()->user()->added_by)->get();
            $data = Project::find($id);
            return view('project.assign_user', compact('id', 'user', 'data'));
        } else if ($type == 'viewPCategory') {
            $user = Assignment::where('project_id', $id)->get();
            $data = Project::find($id);
            return view('project.view_user', compact('id', 'user', 'data'));
        } else if ($type == 'view-attachment') {

            $data = Attachment::find($id);
            $filename =  $data->attachment;
            return view('project.file_preview', compact('filename'));
        } else if ($type == 'category') {

            return view('project.category', compact('id'));
        } else if ($type == 'expenses') {
            $expense = Expenses::where('multiple_id', $id)->get();
            $main = Expenses::where('id', $id)->first();
            return view('project.list', compact('expense', 'id', 'main'));
        } else if ($type == 'supplier') {
            return view('project.purchases.supplier_modal');
        } else if ($type == 'item') {
            return view('project.purchases.items_modal', compact('id'));
        } else if ($type == 'client') {
            return view('project.sales.client_modal', compact('id', 'type'));
        } else if ($type == 'inv-client') {
            return view('project.sales.client_modal', compact('id', 'type'));
        } else if ($type == 'receive') {
            $purchases = Purchase::find($id);
            $purchase_items = PurchaseItems::where('purchase_id', $id)->where('due_quantity', '>', '0')->get();
            $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
            return view('project.purchases.item_details', compact('purchases', 'purchase_items', 'id', 'name'));
        } else if ($type == 'invoice') {
            $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
            $inv = Invoice::all()->where('good_receive', 1)->where('project_id', $request->project)->whereBetween('invoice_date', [$request->start, $request->end])->where('added_by', auth()->user()->added_by);
            $data = Project::find($request->project);
            return view('project.report.invoice_modal', compact('inv', 'data', 'codes'));
        } else if ($type == 'credit') {
            $inv = ReturnInvoice::all()->where('good_receive', 1)->where('project_id', $request->project)->whereBetween('return_date', [$request->start, $request->end])->where('added_by', auth()->user()->added_by);
            $data = Project::find($request->project);
            return view('project.report.credit_modal', compact('inv', 'data'));
        } else if ($type == 'purchase') {
            $payable = AccountCodes::where('account_name', 'Payables')->where('added_by', auth()->user()->added_by)->first();
            $inv = Purchase::all()->where('status', '!=', 0)->where('project_id', $request->project)->whereBetween('purchase_date', [$request->start, $request->end])->where('added_by', auth()->user()->added_by);
            $data = Project::find($request->project);
            return view('project.report.purchase_modal', compact('inv', 'data', 'payable'));
        } else if ($type == 'debit') {
            $inv = ReturnPurchases::all()->where('good_receive', 1)->where('project_id', $request->project)->whereBetween('return_date', [$request->start, $request->end])->where('added_by', auth()->user()->added_by);
            $data = Project::find($request->project);
            return view('project.report.debit_modal', compact('inv', 'data'));
        } else if ($type == 'expense') {
            $inv = Expenses::all()->where('status', 1)->where('multiple', '1')->where('project_id', $request->project)->whereBetween('date', [$request->start, $request->end])->where('added_by', auth()->user()->added_by);
            $data = Project::find($request->project);
            return view('project.report.expense_modal', compact('inv', 'data'));
        }
    }




    public function saveCategory(Request $request)
      {
    $request->validate([
        'category_name' => 'required|string|max:255',
    ]);

    $category = new ProjectCategory();
    $category->category_name = $request->category_name;
    $category->added_by = auth()->user()->id;
    $category->save();

    return response()->json([
        'id' => $category->id,
        'category_name' => $category->category_name,
    ]);
}


    public function assign_user(Request $request)
    {
        //
        $trans_id = $request->trans_id;

        if (!empty($trans_id)) {

            $project = Project::find($request->project_id);
            $d = implode(",", $trans_id);

            Assignment::where('project_id', $request->project_id)->delete();

            for ($i = 0; $i < count($trans_id); $i++) {
                if (!empty($trans_id[$i])) {


                    $data['project_id'] = $request->project_id;
                    $data['user_id'] = $trans_id[$i];
                    $data['added_by'] = auth()->user()->added_by;
                    Assignment::create($data);
                }
            }

            Project::find($request->project_id)->update(['assigned_to' => $d]);
            return redirect(route('project.index'))->with(['success' => "Assignment Successfully"]);
        } else {

            return redirect(route('project.index'))->with(['error' => 'You have not chosen an entry']);
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
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $calls->id,
                            'project_id' => $request->project_id,
                            'module' => 'Comment',
                            'activity' => "Comment Created",
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Created Successfully", 'type' => 'comments']);

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
                            'project_id' => $request->project_id,
                            'module' => 'Comment',
                            'activity' => "Reply on Comment Created",
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Created Successfully", 'type' => 'comments']);

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
                            'project_id' => $request->project_id,
                            'module' => 'Attachment',
                            'activity' => "Attachment " .  $meet->title . " Created",
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Created Successfully", 'type' => 'attachment']);
                break;

            case 'milestone':

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                $milestone = Milestone::create($data);


                if (!empty($milestone)) {
                    $project = Project::find($request->project_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $milestone->id,
                            'project_id' => $request->project_id,
                            'module' => 'Milestone',
                            'activity' => "Milestone " .  $milestone->name .  " Created for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );


                    $milestone_activity = MilestoneActivity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $milestone->id,
                            'module' => 'Milestone',
                            'activity' => "Milestone " .  $milestone->name .  " Created for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Created Successfully", 'type' => 'milestone']);
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
                            'project_id' => $request->project_id,
                            'module' => 'Notes',
                            'activity' => "Notes  Created",
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Created Successfully", 'type' => 'notes']);
                break;

            case 'purchase':

                $count = Purchase::count();
                $pro = $count + 1;
                $data['reference_no'] = "PRJ/P0" . $pro;
                $data['project_id'] = $request->project_id;
                $data['supplier_id'] = $request->supplier_id;
                $data['purchase_date'] = $request->purchase_date;
                $data['due_date'] = $request->due_date;
                $data['location'] = $request->location;
                $data['exchange_code'] = $request->exchange_code;
                $data['exchange_rate'] = $request->exchange_rate;
                $data['purchase_amount'] = '1';
                $data['due_amount'] = '1';
                $data['purchase_tax'] = '1';
                $data['status'] = '0';
                $data['good_receive'] = '0';
                $data['user_agent'] = $request->user_agent;
                $data['user_id'] = auth()->user()->id;
                $data['added_by'] = auth()->user()->added_by;

                $purchase = Purchase::create($data);



                $nameArr = $request->item_name;
                $descArr = $request->description;
                $qtyArr = $request->quantity;
                $priceArr = $request->price;
                $rateArr = $request->tax_rate;
                $unitArr = $request->unit;
                $costArr = str_replace(",", "", $request->total_cost);
                $taxArr =  str_replace(",", "", $request->total_tax);
                $savedArr = $request->item_name;

                $subArr = str_replace(",", "", $request->subtotal);
                $totalArr =  str_replace(",", "", $request->tax);
                $amountArr = str_replace(",", "", $request->amount);
                $disArr =  str_replace(",", "", $request->discount);
                $shipArr =  str_replace(",", "", $request->shipping_cost);


                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($amountArr); $i++) {
                        if (!empty($amountArr[$i])) {
                            $t = array(
                                'purchase_amount' =>  $subArr[$i],
                                'purchase_tax' =>  $totalArr[$i],
                                'shipping_cost' =>   $shipArr[$i],
                                'discount' => $disArr[$i],
                                'due_amount' =>  $amountArr[$i]
                            );

                            Purchase::where('id', $purchase->id)->update($t);
                        }
                    }
                }

                $cost['purchase_amount'] = 0;
                $cost['purchase_tax'] = 0;
                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($nameArr); $i++) {
                        if (!empty($nameArr[$i])) {
                            $cost['purchase_amount'] += $costArr[$i];
                            $cost['purchase_tax'] += $taxArr[$i];

                            $items = array(
                                'item_name' => $nameArr[$i],
                                'description' => $descArr[$i],
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
                                'purchase_id' => $purchase->id
                            );

                            PurchaseItems::create($items);;
                        }
                    }

                    $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
                    PurchaseItems::where('id', $purchase->id)->update($cost);
                }




                if (!empty($purchase)) {

                    $project = Project::find($request->project_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $purchase->id,
                            'project_id' => $request->project_id,
                            'module' => 'Purchase',
                            'activity' => "Purchase with reference no  " .  $purchase->reference_no . "  is Created for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );

                    $pos_activity = POSActivity::create(
                        [
                            'added_by' => auth()->user()->added_by,
                            'user_id' => auth()->user()->id,
                            'module_id' => $purchase->id,
                            'module' => 'Purchase',
                            'activity' => "Purchase with reference no  " .  $purchase->reference_no . "  is Created for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Created Successfully", 'type' => 'purchase']);
                break;


            case 'debit':

                $count = ReturnPurchases::count();
                $pro = $count + 1;
                $invoice = Purchase::find($request->purchase_id);
                $data['reference_no'] = "PRJ/DN0" . $pro;
                $data['project_id'] = $request->project_id;
                $data['supplier_id'] = $request->supplier_id;
                $data['purchase_id'] = $request->purchase_id;
                $data['return_date'] = $request->return_date;
                $data['due_date'] = $request->due_date;
                $data['location'] = $invoice->location;
                $data['exchange_code'] = $invoice->exchange_code;
                $data['exchange_rate'] = $invoice->exchange_rate;
                $data['purchase_amount'] = '1';
                $data['due_amount'] = '1';
                $data['purchase_tax'] = '1';
                $data['status'] = '0';
                $data['good_receive'] = '0';
                $data['user_id'] = auth()->user()->id;
                $data['added_by'] = auth()->user()->added_by;

                $return = ReturnPurchases::create($data);

                $amountArr = str_replace(",", "", $request->amount);
                $totalArr =  str_replace(",", "", $request->tax);

                $nameArr = $request->items_id;
                $qtyArr = $request->quantity;
                $priceArr = $request->price;
                $unitArr = $request->unit;
                $costArr = str_replace(",", "", $request->total_cost);
                $taxArr =  str_replace(",", "", $request->total_tax);
                $idArr = $request->id;


                $cost['purchase_amount'] = 0;
                $cost['purchase_tax'] = 0;
                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($nameArr); $i++) {
                        if (!empty($nameArr[$i])) {
                            $cost['purchase_amount'] += $costArr[$i];
                            $cost['purchase_tax'] += $taxArr[$i];

                            if ($taxArr[$i] == '0') {
                                $rateArr[$i] = 0;
                            } else {
                                $rateArr[$i] = 0.18;
                            }

                            $items = array(
                                'item_name' => $nameArr[$i],
                                'quantity' =>   $qtyArr[$i],
                                'tax_rate' =>  $rateArr[$i],
                                'unit' => $unitArr[$i],
                                'price' =>  $priceArr[$i],
                                'total_cost' =>  $costArr[$i],
                                'total_tax' =>   $taxArr[$i],
                                'items_id' => $nameArr[$i],
                                'order_no' => $i,
                                'added_by' => auth()->user()->added_by,
                                'return_id' => $return->id,
                                'return_item' => $idArr[$i],
                                'purchase_id' => $request->purchase_id
                            );

                            ReturnPurchasesItems::create($items);;
                        }
                    }

                    $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
                    ReturnPurchasesItems::where('return_id', $return->id)->update($cost);
                }

                ReturnPurchases::find($return->id)->update($cost);


                if (!empty($return)) {

                    $project = Project::find($request->project_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $return->id,
                            'project_id' => $request->project_id,
                            'module' => 'Debit Note',
                            'activity' => "Debit Note created for Invoice with reference no  " .  $invoice->reference_no . "  for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );

                    $pos_activity = POSActivity::create(
                        [
                            'added_by' => auth()->user()->added_by,
                            'user_id' => auth()->user()->id,
                            'module_id' => $return->id,
                            'module' => 'Debit Note',
                            'activity' => "Debit Note created for Invoice with reference no  " .  $invoice->reference_no . "  for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Created Successfully", 'type' => 'debit']);
                break;


            case 'tasks':

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['goal_tracking_id'] = 'Projects';

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
                    $project = Project::find($request->project_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $task->id,
                            'project_id' => $request->project_id,
                            'module' => 'Tasks',
                            'activity' => "Task " .  $task->task_name .  " Created for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );


                    $task_activity = TaskActivity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $task->id,
                            'module' => 'Task',
                            'activity' => "Task " .  $task->task_name .  " Created",
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Created Successfully", 'type' => 'tasks']);
                break;





            case 'estimate':

                $count = Invoice::count();
                $pro = $count + 1;
                $data['reference_no'] = "PRJ/S0" . $pro;
                $data['project_id'] = $request->project_id;
                $data['client_id'] = $request->client_id;
                $data['invoice_date'] = $request->invoice_date;
                $data['due_date'] = $request->due_date;
                $data['location'] = $request->location;
                $data['exchange_code'] = $request->exchange_code;
                $data['exchange_rate'] = $request->exchange_rate;
                $data['invoice_amount'] = '1';
                $data['due_amount'] = '1';
                $data['invoice_tax'] = '1';
                $data['status'] = '0';
                $data['good_receive'] = '0';
                $data['invoice_status'] = '0';
                $data['user_agent'] = $request->user_agent;
                $data['user_id'] = auth()->user()->id;
                $data['added_by'] = auth()->user()->added_by;

                $invoice = Invoice::create($data);


                $nameArr = $request->item_name;
                $descArr = $request->description;
                $qtyArr = $request->quantity;
                $priceArr = $request->price;
                $rateArr = $request->tax_rate;
                $unitArr = $request->unit;
                $costArr = str_replace(",", "", $request->total_cost);
                $taxArr =  str_replace(",", "", $request->total_tax);

                $savedArr = $request->item_name;


                $subArr = str_replace(",", "", $request->subtotal);
                $totalArr =  str_replace(",", "", $request->tax);
                $amountArr = str_replace(",", "", $request->amount);
                $disArr =  str_replace(",", "", $request->discount);
                $shipArr =  str_replace(",", "", $request->shipping_cost);

                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($amountArr); $i++) {
                        if (!empty($amountArr[$i])) {
                            $t = array(
                                'invoice_amount' =>  $subArr[$i],
                                'invoice_tax' =>  $totalArr[$i],
                                'shipping_cost' =>   $shipArr[$i],
                                'discount' => $disArr[$i],
                                'due_amount' =>  $amountArr[$i]
                            );

                            Invoice::where('id', $invoice->id)->update($t);
                        }
                    }
                }

                $cost['invoice_amount'] = 0;
                $cost['invoice_tax'] = 0;
                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($nameArr); $i++) {
                        if (!empty($nameArr[$i])) {
                            $cost['invoice_amount'] += $costArr[$i];
                            $cost['invoice_tax'] += $taxArr[$i];

                            $items = array(
                                'item_name' => $nameArr[$i],
                                'description' => $descArr[$i],
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

                            InvoiceItems::create($items);;
                        }
                    }

                    $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
                    InvoiceItems::where('id', $invoice->id)->update($cost);
                }




                if (!empty($invoice)) {
                    $project = Project::find($request->project_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $invoice->id,
                            'project_id' => $request->project_id,
                            'module' => 'Proforma Invoice',
                            'activity' => "Proforma Invoice with reference no  " .  $invoice->reference_no . "  is Created for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );

                    $pos_activity = POSActivity::create(
                        [
                            'added_by' => auth()->user()->added_by,
                            'user_id' => auth()->user()->id,
                            'module_id' => $invoice->id,
                            'module' => 'Proforma Invoice',
                            'activity' => "Proforma Invoice with reference no  " .  $invoice->reference_no . "  is Created for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }



                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Created Successfully", 'type' => 'estimate']);
                break;


            case 'invoice':

                $count = Invoice::count();
                $pro = $count + 1;
                $data['reference_no'] = "PRJ/S0" . $pro;
                $data['project_id'] = $request->project_id;
                $data['client_id'] = $request->client_id;
                $data['invoice_date'] = $request->invoice_date;
                $data['due_date'] = $request->due_date;
                $data['location'] = $request->location;
                $data['exchange_code'] = $request->exchange_code;
                $data['exchange_rate'] = $request->exchange_rate;
                $data['invoice_amount'] = '1';
                $data['due_amount'] = '1';
                $data['invoice_tax'] = '1';
                $data['status'] = '0';
                $data['sales_type'] = $request->sales_type;
                $data['bank_id'] = $request->bank_id;
                $data['good_receive'] = '1';
                $data['invoice_status'] = 1;
                $data['status'] = '1';
                $data['user_agent'] = $request->user_agent;
                $data['user_id'] = auth()->user()->id;
                $data['added_by'] = auth()->user()->added_by;

                $invoice = Invoice::create($data);



                $nameArr = $request->item_name;
                $descArr = $request->description;
                $qtyArr = $request->quantity;
                $priceArr = $request->price;
                $rateArr = $request->tax_rate;
                $unitArr = $request->unit;
                $costArr = str_replace(",", "", $request->total_cost);
                $taxArr =  str_replace(",", "", $request->total_tax);
                $savedArr = $request->item_name;

                $subArr = str_replace(",", "", $request->subtotal);
                $totalArr =  str_replace(",", "", $request->tax);
                $amountArr = str_replace(",", "", $request->amount);
                $disArr =  str_replace(",", "", $request->discount);
                $shipArr =  str_replace(",", "", $request->shipping_cost);

                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($amountArr); $i++) {
                        if (!empty($amountArr[$i])) {
                            $t = array(
                                'invoice_amount' =>  $subArr[$i],
                                'invoice_tax' =>  $totalArr[$i],
                                'shipping_cost' =>   $shipArr[$i],
                                'discount' => $disArr[$i],
                                'due_amount' =>  $amountArr[$i]
                            );

                            Invoice::where('id', $invoice->id)->update($t);
                        }
                    }
                }


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
                                'description' => $descArr[$i],
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

                            InvoiceItems::create($items);;
                        }
                    }

                    $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
                    InvoiceItems::where('id', $invoice->id)->update($cost);
                }

                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($nameArr); $i++) {
                        if (!empty($nameArr[$i])) {

                            $lists = array(
                                'quantity' =>   $qtyArr[$i],
                                'price' =>   $priceArr[$i],
                                'item_id' => $savedArr[$i],
                                'added_by' => auth()->user()->added_by,
                                'client_id' =>   $data['client_id'],
                                'location' =>   $data['location'],
                                'invoice_date' =>  $data['invoice_date'],
                                'type' =>   'Sales',
                                'invoice_id' => $invoice->id
                            );


                            InvoiceHistory::create($lists);

                            $inv = Items::where('id', $nameArr[$i])->first();
                            $q = $inv->quantity - $qtyArr[$i];
                            Items::where('id', $nameArr[$i])->update(['quantity' => $q]);

                            $loc = Location::where('id', $invoice->location)->first();
                            $lq['quantity'] = $loc->quantity - $qtyArr[$i];
                            Location::where('id', $invoice->location)->update($lq);
                        }
                    }
                }


                $project = Project::find($request->project_id);
                $inv = Invoice::find($invoice->id);
                $supp = Client::find($inv->client_id);
                $cr = AccountCodes::where('account_name', 'Sales')->where('added_by', auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $cr->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date =   $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->project_id = $inv->project_id;
                $journal->currency_code =  $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = "Sales for Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                $journal->save();

                if ($inv->invoice_tax > 0) {
                    $tax = AccountCodes::where('account_name', 'VAT OUT')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $tax->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->credit = $inv->invoice_tax *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Sales Tax for Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();
                }

            //  $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
                $codes = AccountCodes::where('account_name', 'Receivable and Prepayments')->where('added_by', auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date =   $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->project_id = $inv->project_id;
                $journal->debit = ($inv->invoice_amount + $inv->invoice_tax) *  $inv->exchange_rate;
                $journal->currency_code =  $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = "Receivables for Sales Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                $journal->save();

                $stock = AccountCodes::where('account_name', 'Inventory')->where('added_by', auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id =  $stock->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date =   $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->project_id = $inv->project_id;
                $journal->currency_code =  $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = "Reduce Stock  for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                $journal->save();

                $cos = AccountCodes::where('account_name', 'Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id =  $cos->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date =   $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->project_id = $inv->project_id;
                $journal->currency_code =  $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = "Cost of Goods Sold  for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                $journal->save();


                if ($inv->discount > 0) {
                    $cr = AccountCodes::where('account_name', 'Sales')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $cr->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->debit = $inv->discount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Sales Discount for for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();


                    $disc = AccountCodes::where('account_name', 'Sales Discount')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $disc->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->credit = $inv->discount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Sales Discount for for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();
                }


                if ($inv->shipping_cost > 0) {

                    $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Sales Shipping Cost for Sales Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();


                    $shp = AccountCodes::where('account_name', 'Shipping Cost')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $shp->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->credit = $inv->shipping_cost *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Credit Shipping Cost for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();
                }




                if (!empty($invoice)) {

                    $project = Project::find($request->project_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $invoice->id,
                            'project_id' => $request->project_id,
                            'module' => 'Invoice',
                            'activity' => "Invoice with reference no  " .  $invoice->reference_no . "  is Created for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );

                    $pos_activity = POSActivity::create(
                        [
                            'added_by' => auth()->user()->added_by,
                            'user_id' => auth()->user()->id,
                            'module_id' => $invoice->id,
                            'module' => 'Invoice',
                            'activity' => "Invoice with reference no  " .  $invoice->reference_no . "  is Created for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }


                //invoice payment
                if ($inv->sales_type == 'Cash Sales') {

                    $sales = Invoice::find($inv->id);
                    $method = Payment_methodes::where('name', 'Cash')->first();
                    $count = InvoicePayments::count();
                    $pro = $count + 1;

                    $receipt['trans_id'] = "TBSPH-" . $pro;
                    $receipt['invoice_id'] = $inv->id;
                    $receipt['amount'] = $inv->due_amount;
                    $receipt['date'] = $inv->invoice_date;
                    $receipt['account_id'] = $request->bank_id;
                    $receipt['payment_method'] = $method->id;
                    $receipt['user_id'] = $sales->user_agent;
                    $receipt['added_by'] = auth()->user()->added_by;

                    //update due amount from invoice table
                    $b['due_amount'] =  0;
                    $b['status'] = 3;

                    $sales->update($b);

                    $payment = InvoicePayments::create($receipt);

                    $supp = Client::find($sales->client_id);

                    $cr = AccountCodes::where('id', '$request->bank_id')->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $request->bank_id;
                    $date = explode('-', $request->invoice_date);
                    $journal->date =   $request->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice_payment';
                    $journal->name = 'Invoice Payment';
                    $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
                    $journal->payment_id = $payment->id;
                    $journal->client_id = $sales->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =   $sales->currency_code;
                    $journal->exchange_rate =  $sales->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Deposit for Sales Invoice No " . $sales->reference_no . " by Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();


                //    $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
                    $codes = AccountCodes::where('account_name', 'Receivable and Prepayments')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-', $request->invoice_date);
                    $journal->date =   $request->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice_payment';
                    $journal->name = 'Invoice Payment';
                    $journal->credit = $receipt['amount'] *  $sales->exchange_rate;
                    $journal->payment_id = $payment->id;
                    $journal->client_id = $sales->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =   $sales->currency_code;
                    $journal->exchange_rate =  $sales->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Clear Receivable for Invoice No  " . $sales->reference_no . " by Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    // $account = Accounts::where('account_id', $request->bank_id)->first();

                    // if (!empty($account)) {
                    //     $balance = $account->balance + $payment->amount;
                    //     $item_to['balance'] = $balance;
                    //     $account->update($item_to);
                    // } else {
                    //     $cr = AccountCodes::where('id', $request->bank_id)->first();

                    //     $new['account_id'] = $request->bank_id;
                    //     $new['account_name'] = $cr->account_name;
                    //     $new['balance'] = $payment->amount;
                    //     $new[' exchange_code'] = $sales->currency_code;
                    //     $new['added_by'] = auth()->user()->added_by;
                    //     $balance = $payment->amount;
                    //     Accounts::create($new);
                    // }

                    $account = Accounts::where('account_id', $request->bank_id)->first();

                    if (!empty($account)) {
                        $balance = $account->balance + $payment->amount;
                        $item_to['balance'] = $balance;
                        $account->update($item_to);
                    } else {
                        $new['account_id'] = $request->bank_id ?? 1; 
                        $new['account_name'] = 'Default Bank Account'; 

                        if (!empty($request->bank_id) && is_numeric($request->bank_id)) {
                            $cr = AccountCodes::where('id', $request->bank_id)->first();
                            if ($cr) {
                                $new['account_name'] = $cr->account_name; 
                            } else {
                                \Log::warning('No AccountCodes record found for bank_id: ' . $request->bank_id);
                            }
                        } else {
                            \Log::warning('Invalid or missing bank_id', ['bank_id' => $request->bank_id]);
                        }

                        $new['balance'] = $payment->amount ?? 0;
                        $new['exchange_code'] = $sales->currency_code ?? 'USD';
                        $new['added_by'] = auth()->user()->added_by ?? 0;
                        $balance = $payment->amount ?? 0;

                        try {
                            Accounts::create($new);
                        } catch (\Exception $e) {
                            \Log::error('Failed to create Accounts record', ['error' => $e->getMessage(), 'data' => $new]);
                        }
                    }

                    // save into tbl_transaction

                    $transaction = Transaction::create([
                        'module' => 'POS Invoice Payment',
                        'module_id' => $payment->id,
                        'account_id' => $request->bank_id ?? 1,
                        'code_id' => $codes->id,
                        'name' => 'POS Invoice Payment with reference ' . $payment->trans_id,
                        'transaction_prefix' => $payment->trans_id,
                        'type' => 'Income',
                        'amount' => $payment->amount,
                        'credit' => $payment->amount,
                        'total_balance' => $balance,
                        'date' => date('Y-m-d', strtotime($request->date)),
                        'paid_by' => $sales->client_id,
                        'payment_methods_id' => $payment->payment_method,
                        'status' => 'paid',
                        'notes' => 'This deposit is from pos invoice  payment. The Reference is ' . $sales->reference_no . ' by Client ' . $supp->name,
                        'added_by' => auth()->user()->added_by,
                    ]);


                    if (!empty($payment)) {
                        $project = Project::find($request->project_id);

                        $activity = Activity::create(
                            [
                                'added_by' => auth()->user()->id,
                                'module_id' => $payment->id,
                                'project_id' => $request->project_id,
                                'module' => 'Invoice Payment',
                                'activity' => "Invoice with reference no  " .  $sales->reference_no . "  is Paid for the Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );

                        $pos_activity = POSActivity::create(
                            [
                                'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                                'module_id' => $payment->id,
                                'module' => 'Invoice Payment',
                                'activity' => "Invoice with reference no  " .  $sales->reference_no . "  is Paid for the Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );
                    }
                }




                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Created Successfully", 'type' => 'invoice']);
                break;


            case 'expenses':

                $nameArr = $request->account_id;
                $amountArr = $request->amount;
                $notesArr = $request->notes;



                $cost['amount'] = 0;
                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($nameArr); $i++) {
                        if (!empty($nameArr[$i])) {
                            $cost['amount'] += $amountArr[$i];
                        }
                    }

                    $items = array(
                        'name' =>  $request->name,
                        'ref' =>   $request->ref,
                        'type' =>  'Expenses',
                        'amount' =>   $cost['amount'],
                        'date' => $request->date,
                        'bank_id' =>  $request->bank_id,
                        'status'  => '0',
                        'view'  => '1',
                        'project_id' => $request->project_id,
                        'multiple'  => '0',
                        'added_by' => auth()->user()->added_by,
                        'payment_method' =>  $request->payment_method

                    );

                    $total_expenses = Expenses::create($items);;
                }


                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($nameArr); $i++) {
                        if (!empty($nameArr[$i])) {
                            $random = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4 / strlen($x)))), 1, 4);

                            $t = array(
                                'name' =>  $request->name,
                                'ref' =>   $request->ref,
                                'type' =>  'Expenses',
                                'amount' =>  $amountArr[$i],
                                'date' => $request->date,
                                'bank_id' =>  $request->bank_id,
                                'account_id' =>  $nameArr[$i],
                                'notes'  => $notesArr[$i],
                                'exchange_code' =>   $request->exchange_code,
                                'exchange_rate' =>  $request->exchange_rate,
                                'status'  => '0',
                                'view'  => '1',
                                'multiple'  => '1',
                                'multiple_id'  =>  $total_expenses->id,
                                'project_id' => $request->project_id,
                                'trans_id' => 'TRANS_EXP_' . $random,
                                'added_by' => auth()->user()->added_by,
                                'payment_method' =>  $request->payment_method
                            );

                            $expenses = Expenses::create($t);;
                        }
                    }
                }



                if (!empty($total_expenses)) {
                    $project = Project::find($request->project_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $total_expenses->id,
                            'project_id' => $request->project_id,
                            'module' => 'Expenses',
                            'activity' => "Expenses with reference " .  $request->name . "  is Created for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Created Successfully", 'type' => 'expenses']);
                break;

            case 'credit':

                $count = ReturnInvoice::count();
                $pro = $count + 1;
                $invoice = Invoice::find($request->invoice_id);
                $data['reference_no'] = "PRJ/CN0" . $pro;
                $data['project_id'] = $request->project_id;
                $data['client_id'] = $request->client_id;
                $data['invoice_id'] = $request->invoice_id;
                $data['return_date'] = $request->return_date;
                $data['due_date'] = $request->due_date;
                $data['location'] = $invoice->location;
                $data['exchange_code'] = $invoice->exchange_code;
                $data['exchange_rate'] = $invoice->exchange_rate;
                $data['invoice_amount'] = '1';
                $data['due_amount'] = '1';
                $data['invoice_tax'] = '1';
                $data['status'] = '0';
                $data['good_receive'] = '0';
                $data['user_id'] = auth()->user()->id;
                $data['added_by'] = auth()->user()->added_by;

                $return = ReturnInvoice::create($data);

                $amountArr = str_replace(",", "", $request->amount);
                $totalArr =  str_replace(",", "", $request->tax);

                $nameArr = $request->items_id;
                $qtyArr = $request->quantity;
                $priceArr = $request->price;
                $unitArr = $request->unit;
                $costArr = str_replace(",", "", $request->total_cost);
                $taxArr =  str_replace(",", "", $request->total_tax);
                $idArr = $request->id;


                $cost['invoice_amount'] = 0;
                $cost['invoice_tax'] = 0;
                if (!empty($nameArr)) {
                    for ($i = 0; $i < count($nameArr); $i++) {
                        if (!empty($nameArr[$i])) {
                            $cost['invoice_amount'] += $costArr[$i];
                            $cost['invoice_tax'] += $taxArr[$i];

                            if ($taxArr[$i] == '0') {
                                $rateArr[$i] = 0;
                            } else {
                                $rateArr[$i] = 0.18;
                            }

                            $items = array(
                                'item_name' => $nameArr[$i],
                                'quantity' =>   $qtyArr[$i],
                                'tax_rate' =>  $rateArr[$i],
                                'unit' => $unitArr[$i],
                                'price' =>  $priceArr[$i],
                                'total_cost' =>  $costArr[$i],
                                'total_tax' =>   $taxArr[$i],
                                'items_id' => $nameArr[$i],
                                'order_no' => $i,
                                'added_by' => auth()->user()->added_by,
                                'return_id' => $return->id,
                                'return_item' => $idArr[$i],
                                'invoice_id' => $request->invoice_id
                            );

                            ReturnInvoiceItems::create($items);;
                        }
                    }

                    $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
                    ReturnInvoiceItems::where('return_id', $return->id)->update($cost);
                }

                ReturnInvoice::find($return->id)->update($cost);


                if (!empty($return)) {

                    $project = Project::find($request->project_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $return->id,
                            'project_id' => $request->project_id,
                            'module' => 'Credit Note',
                            'activity' => "Credit Note created for Invoice with reference no  " .  $invoice->reference_no . "  for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );

                    $pos_activity = POSActivity::create(
                        [
                            'added_by' => auth()->user()->added_by,
                            'user_id' => auth()->user()->id,
                            'module_id' => $return->id,
                            'module' => 'Credit Note',
                            'activity' => "Credit Note created for Invoice with reference no  " .  $invoice->reference_no . "  for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Created Successfully", 'type' => 'credit']);
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
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();

                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;

                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'bank_accounts',
                    'users',
                    'bname',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp'
                ));

                break;

            case 'edit-notes':

                $edit_data = Notes::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();

                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;

                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'bank_accounts',
                    'users',
                    'bname',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp'
                ));

                break;

            case 'edit-tasks':

                $edit_data = Task::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();


                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;

                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'categories',
                    'users',
                    'name',
                    'chart_of_accounts',
                    'bank_accounts',
                    'bname',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp'
                ));

                break;

            case 'edit-milestone':

                $edit_data = Milestone::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();

                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;



                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'categories',
                    'users',
                    'name',
                    'chart_of_accounts',
                    'bank_accounts',
                    'bname',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp'
                ));

                break;

            case 'edit-purchase':

                $edit_data = Purchase::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $currency = Currency::all();
                $items = PurchaseItems::where('purchase_id', $type_id)->get();
                $supplier = Supplier::where('user_id', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();

                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;


                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'items',
                    'bank_accounts',
                    'supplier',
                    'users',
                    'bname',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp'
                ));

                break;

            case 'purchase-good-receive':

                $edit_data = Purchase::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $currency = Currency::all();
                $items = PurchaseItems::where('purchase_id', $type_id)->get();
                $supplier = Supplier::where('user_id', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $receive = '1';

                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;
                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'items',
                    'bank_accounts',
                    'supplier',
                    'receive',
                    'users',
                    'bname',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp'
                ));;

                break;

            case 'edit-estimate':

                $edit_data = Invoice::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $currency = Currency::all();
                $items = InvoiceItems::where('invoice_id', $type_id)->get();
                $client = Client::where('user_id', auth()->user()->added_by)->get();
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();

                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;

                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'items',
                    'client',
                    'bank_accounts',
                    'users',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp',
                    'bname'
                ));

                break;


            case 'estimate-good-receive':

                $edit_data = Invoice::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $currency = Currency::all();
                $items = InvoiceItems::where('invoice_id', $type_id)->get();
                $client = Client::where('user_id', auth()->user()->added_by)->get();
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $receive = '1';

                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;


                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'items',
                    'bank_accounts',
                    'client',
                    'receive',
                    'users',
                    'bname',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp'
                ));

                break;

            case 'edit-invoice':

                $edit_data = Invoice::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $currency = Currency::all();
                $items = InvoiceItems::where('invoice_id', $type_id)->get();
                $client = Client::where('user_id', auth()->user()->added_by)->get();
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();


                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;

                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'items',
                    'bank_accounts',
                    'client',
                    'users',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp',
                    'bname'
                ));

                break;


            case 'good-receive':

                $edit_data = Invoice::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $currency = Currency::all();
                $items = InvoiceItems::where('invoice_id', $type_id)->get();
                $client = Client::where('user_id', auth()->user()->added_by)->get();
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $receive = '1';

                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;


                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'items',
                    'bank_accounts',
                    'client',
                    'receive',
                    'users',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp',
                    'bname'
                ));

                break;

            case 'edit-expenses':

                $edit_data = Expenses::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();


                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;

                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'bank_accounts',
                    'users',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp',
                    'bname'
                ));

                break;

            case 'edit-credit':

                $edit_data = ReturnInvoice::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $currency = Currency::all();
                $items = ReturnInvoiceItems::where('return_id', $type_id)->get();
                $invoice = Invoice::where('client_id', $edit_data->client_id)->where('project_id', $id)->where('status', 1)->get();
                $client = Client::where('user_id', auth()->user()->added_by)->get();
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();


                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;


                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'items',
                    'bank_accounts',
                    'client',
                    'invoice',
                    'users',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp',
                    'bname'
                ));

                break;

            case 'credit-good-receive':

                $edit_data = ReturnInvoice::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $currency = Currency::all();
                $items = ReturnInvoiceItems::where('return_id', $type_id)->get();
                $invoice = Invoice::where('client_id', $edit_data->client_id)->where('project_id', $id)->where('status', 1)->get();
                $client = Client::where('user_id', auth()->user()->added_by)->get();
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $receive = '1';


                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;



                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'items',
                    'bank_accounts',
                    'client',
                    'invoice',
                    'receive',
                    'users',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp',
                    'bname'
                ));

                break;



            case 'edit-debit':

                $edit_data = ReturnPurchases::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $currency = Currency::all();
                $items = ReturnPurchasesItems::where('return_id', $type_id)->get();
                $invoice = Purchase::where('supplier_id', $edit_data->supplier_id)->where('good_receive', 0)->where('status', 1)->where('project_id', $id)->get();
                $supplier = Supplier::where('user_id', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();

                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;


                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'items',
                    'bank_accounts',
                    'supplier',
                    'invoice',
                    'users',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp',
                    'bname'
                ));

                break;

            case 'debit-good-receive':

                $edit_data = ReturnPurchases::find($type_id);
                $id = $edit_data->project_id;
                $data = Project::find($id);
                $name = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bname = Items::whereIn('type', [1, 4])->where('added_by', auth()->user()->added_by)->where('bar', '0')->where('disabled', '0')->get();
                $chart_of_accounts = AccountCodes::where('account_group', '!=', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $location = Location::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();;
                $currency = Currency::all();
                $items = ReturnPurchasesItems::where('return_id', $type_id)->get();
                $invoice = Purchase::where('supplier_id', $edit_data->supplier_id)->where('good_receive', 0)->where('status', 1)->where('project_id', $id)->get();
                $supplier = Supplier::where('user_id', auth()->user()->added_by)->where('disabled', '0')->get();;
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)->where('account_group', 'Cash and Cash Equivalent')->where('added_by', auth()->user()->added_by)->get();
                $receive = '1';


                $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $task = Task::all()->where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0');
                $mile = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);
                $inv = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by);
                $pur = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by);

                $ccount = Comment::where('project_id', $id)->where('disabled', '0')->where('comments_reply_id', '0')->count();
                $attcount = Attachment::where('project_id', $id)->where('disabled', '0')->count();
                $ncount = Notes::where('project_id', $id)->where('disabled', '0')->count();
                $actcount = Activity::where('project_id', $id)->count();
                $tcount = Task::where('added_by', auth()->user()->added_by)->where('project_id', $id)->where('disabled', '0')->count();;
                $mcount = Milestone::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();
                $pcount = Invoice::all()->where('invoice_status', 0)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $invcount = Invoice::all()->where('invoice_status', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $crdcount = ReturnInvoice::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();
                $expcount = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->count();
                $purcount = Purchase::all()->where('project_id', $id)->where('disabled', '0')->where('added_by', auth()->user()->added_by)->count();;
                $dncount = ReturnPurchases::all()->where('project_id', $id)->where('added_by', auth()->user()->added_by)->count();;
                $fixed = Invoice::where('good_receive', 1)->where('project_id', $id)->where('added_by', auth()->user()->added_by)->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));;
                $total_exp = Expenses::where('multiple', '0')->where('added_by', auth()->user()->added_by)->where('project_id', $id)->sum('amount');;



                return view('project.project_details', compact(
                    'data',
                    'id',
                    'type',
                    'type_id',
                    'edit_data',
                    'name',
                    'chart_of_accounts',
                    'location',
                    'currency',
                    'items',
                    'bank_accounts',
                    'supplier',
                    'invoice',
                    'receive',
                    'users',
                    'task',
                    'mile',
                    'inv',
                    'pur',
                    'ccount',
                    'attcount',
                    'ncount',
                    'actcount',
                    'tcount',
                    'mcount',
                    'pcount',
                    'invcount',
                    'crdcount',
                    'expcount',
                    'purcount',
                    'dncount',
                    'fixed',
                    'total_exp',
                    'bname'
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
                            'project_id' => $request->project_id,
                            'module' => 'Attachment',
                            'activity' => "Attachment " .  $calls->title . " Updated",
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Updated Successfully", 'type' => 'attachment']);

                break;

            case 'milestone':

                $milestone = Milestone::find($request->id);

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                $milestone->update($data);


                if (!empty($milestone)) {
                    $project = Project::find($request->project_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $milestone->id,
                            'project_id' => $request->project_id,
                            'module' => 'Milestone',
                            'activity' => "Milestone " .  $milestone->name .  " Updated for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );


                    $milestone_activity = MilestoneActivity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $milestone->id,
                            'module' => 'Milestone',
                            'activity' => "Milestone " .  $milestone->name .  " Updated for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Updated Successfully", 'type' => 'milestone']);
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
                            'project_id' => $request->project_id,
                            'module' => 'Notes',
                            'activity' => "Notes Updated",
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Updated Successfully", 'type' => 'notes']);

                break;

            case 'purchase':

                if ($request->receive == '1') {
                    $purchase = Purchase::find($request->id);

                    $data['project_id'] = $request->project_id;
                    $data['supplier_id'] = $request->supplier_id;
                    $data['purchase_date'] = $request->purchase_date;
                    $data['due_date'] = $request->due_date;
                    $data['location'] = $request->location;
                    $data['exchange_code'] = $request->exchange_code;
                    $data['exchange_rate'] = $request->exchange_rate;
                    $data['purchase_amount'] = '1';
                    $data['due_amount'] = '1';
                    $data['purchase_tax'] = '1';
                    $data['status'] = '1';
                    $data['user_agent'] = $request->user_agent;
                    $data['added_by'] = auth()->user()->added_by;

                    $purchase->update($data);



                    $nameArr = $request->item_name;
                    $descArr = $request->description;
                    $qtyArr = $request->quantity;
                    $priceArr = $request->price;
                    $rateArr = $request->tax_rate;
                    $unitArr = $request->unit;
                    $costArr = str_replace(",", "", $request->total_cost);
                    $taxArr =  str_replace(",", "", $request->total_tax);
                    $remArr = $request->removed_id;
                    $expArr = $request->saved_items_id;
                    $savedArr = $request->item_name;


                    $subArr = str_replace(",", "", $request->subtotal);
                    $totalArr =  str_replace(",", "", $request->tax);
                    $amountArr = str_replace(",", "", $request->amount);
                    $disArr =  str_replace(",", "", $request->discount);
                    $shipArr =  str_replace(",", "", $request->shipping_cost);


                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($amountArr); $i++) {
                            if (!empty($amountArr[$i])) {
                                $t = array(
                                    'purchase_amount' =>  $subArr[$i],
                                    'purchase_tax' =>  $totalArr[$i],
                                    'shipping_cost' =>   $shipArr[$i],
                                    'discount' => $disArr[$i],
                                    'due_amount' =>  $amountArr[$i]
                                );

                                Purchase::where('id', $request->id)->update($t);
                            }
                        }
                    }

                    $cost['purchase_amount'] = 0;
                    $cost['purchase_tax'] = 0;

                    if (!empty($remArr)) {
                        for ($i = 0; $i < count($remArr); $i++) {
                            if (!empty($remArr[$i])) {
                                PurchaseItems::where('id', $remArr[$i])->delete();
                            }
                        }
                    }

                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($nameArr); $i++) {
                            if (!empty($nameArr[$i])) {
                                $cost['purchase_amount'] += $costArr[$i];
                                $cost['purchase_tax'] += $taxArr[$i];

                                $items = array(
                                    'item_name' => $nameArr[$i],
                                    'description' => $descArr[$i],
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
                                    'purchase_id' => $purchase->id
                                );

                                if (!empty($expArr[$i])) {
                                    PurchaseItems::where('id', $expArr[$i])->update($items);
                                } else {
                                    PurchaseItems::create($items);
                                }
                            }
                        }
                    }


                    /*
if(!empty($nameArr)){
               for($i = 0; $i < count($nameArr); $i++){
                   if(!empty($nameArr[$i])){
   
                      $lists= array(
                            'quantity' =>   $qtyArr[$i],
                              'price' =>   $priceArr[$i],
                             'item_id' => $savedArr[$i],
                               'added_by' => auth()->user()->added_by,
                               'supplier_id' => $data['supplier_id'],
                              'location' =>    $data['location'],
                             'purchase_date' =>  $data['purchase_date'],
                            'type' =>   'Purchases',
                            'purchase_id' =>$purchase->id);
                           
                         PurchaseHistory ::create($lists);   
          
                        $inv=Items::where('id',$nameArr[$i])->first();
                        $q=$inv->quantity + $qtyArr[$i];
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);
                        
                        $loc=Location::where('id',$purchase->location)->first();
                        // $lq['quantity']=$loc->quantity + $request->quantity;
                        $lq['quantity']=$loc->quantity + $qtyArr[$i];
                        $loc_qun =   Location::where('id',$purchase->location)->update($lq);
                   }
               }
           
           }  
           */

                    $project = Project::find($request->project_id);
                    $inv = Purchase::find($purchase->id);
                    $supp = Supplier::find($inv->supplier_id);

                    if ($inv->discount > 0) {

                        $disc = AccountCodes::where('account_name', 'Purchase Discount')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $disc->id;
                        $date = explode('-', $inv->purchase_date);
                        $journal->date =   $inv->purchase_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_purchase';
                        $journal->name = 'Purchases';
                        $journal->debit = $inv->discount *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->supplier_id = $inv->supplier_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Purchase Discount for Purchase Order " . $inv->reference_no . " by Supplier " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();

                        $cr = AccountCodes::where('account_name', 'Purchases')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $cr->id;
                        $date = explode('-', $inv->purchase_date);
                        $journal->date =   $inv->purchase_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_purchase';
                        $journal->name = 'Purchases';
                        $journal->credit = $inv->discount *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->supplier_id = $inv->supplier_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Purchase Discount for Purchase Order " . $inv->reference_no . " by Supplier " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();
                    }

                    if ($inv->shipping_cost > 0) {

                        $shp = AccountCodes::where('account_name', 'Shipping Cost')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $shp->id;
                        $date = explode('-', $inv->purchase_date);
                        $journal->date =   $inv->purchase_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_purchase';
                        $journal->name = 'Purchases';
                        $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->supplier_id = $inv->supplier_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Purchase Shipping Cost for Purchase Order " . $inv->reference_no . " by Supplier " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();

                        $codes = AccountCodes::where('account_name', 'Payables')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $codes->id;
                        $date = explode('-', $inv->purchase_date);
                        $journal->date =   $inv->purchase_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_purchase';
                        $journal->name = 'Purchases';
                        $journal->credit = $inv->shipping_cost *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->supplier_id = $inv->supplier_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Purchase Shipping Cost for Purchase Order " . $inv->reference_no . " by Supplier " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();
                    }




                    if (!empty($purchase)) {

                        $project = Project::find($request->project_id);

                        $activity = Activity::create(
                            [
                                'added_by' => auth()->user()->id,
                                'module_id' => $purchase->id,
                                'project_id' => $request->project_id,
                                'module' => 'Purchase',
                                'activity' => "Purchase with reference no  " .  $purchase->reference_no . "  is Approved for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );

                        $pos_activity = POSActivity::create(
                            [
                                'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                                'module_id' => $purchase->id,
                                'module' => 'Purchase',
                                'activity' => "Purchase with reference no  " .  $purchase->reference_no . "  is Approved for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );
                    }
                } else {

                    $purchase = Purchase::find($request->id);

                    $data['project_id'] = $request->project_id;
                    $data['supplier_id'] = $request->supplier_id;
                    $data['purchase_date'] = $request->purchase_date;
                    $data['due_date'] = $request->due_date;
                    $data['location'] = $request->location;
                    $data['exchange_code'] = $request->exchange_code;
                    $data['exchange_rate'] = $request->exchange_rate;
                    $data['purchase_amount'] = '1';
                    $data['due_amount'] = '1';
                    $data['purchase_tax'] = '1';
                    $data['user_agent'] = $request->user_agent;
                    $data['added_by'] = auth()->user()->added_by;

                    $purchase->update($data);



                    $nameArr = $request->item_name;
                    $descArr = $request->description;
                    $qtyArr = $request->quantity;
                    $priceArr = $request->price;
                    $rateArr = $request->tax_rate;
                    $unitArr = $request->unit;
                    $costArr = str_replace(",", "", $request->total_cost);
                    $taxArr =  str_replace(",", "", $request->total_tax);
                    $remArr = $request->removed_id;
                    $expArr = $request->saved_items_id;
                    $savedArr = $request->item_name;


                    $subArr = str_replace(",", "", $request->subtotal);
                    $totalArr =  str_replace(",", "", $request->tax);
                    $amountArr = str_replace(",", "", $request->amount);
                    $disArr =  str_replace(",", "", $request->discount);
                    $shipArr =  str_replace(",", "", $request->shipping_cost);


                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($amountArr); $i++) {
                            if (!empty($amountArr[$i])) {
                                $t = array(
                                    'purchase_amount' =>  $subArr[$i],
                                    'purchase_tax' =>  $totalArr[$i],
                                    'shipping_cost' =>   $shipArr[$i],
                                    'discount' => $disArr[$i],
                                    'due_amount' =>  $amountArr[$i]
                                );

                                Purchase::where('id', $request->id)->update($t);
                            }
                        }
                    }

                    $cost['purchase_amount'] = 0;
                    $cost['purchase_tax'] = 0;

                    if (!empty($remArr)) {
                        for ($i = 0; $i < count($remArr); $i++) {
                            if (!empty($remArr[$i])) {
                                PurchaseItems::where('id', $remArr[$i])->delete();
                            }
                        }
                    }

                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($nameArr); $i++) {
                            if (!empty($nameArr[$i])) {
                                $cost['purchase_amount'] += $costArr[$i];
                                $cost['purchase_tax'] += $taxArr[$i];

                                $items = array(
                                    'item_name' => $nameArr[$i],
                                    'description' => $descArr[$i],
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
                                    'purchase_id' => $purchase->id
                                );

                                if (!empty($expArr[$i])) {
                                    PurchaseItems::where('id', $expArr[$i])->update($items);
                                } else {
                                    PurchaseItems::create($items);
                                }
                            }
                        }
                    }



                    if (!empty($purchase)) {

                        $project = Project::find($request->project_id);

                        $activity = Activity::create(
                            [
                                'added_by' => auth()->user()->id,
                                'module_id' => $purchase->id,
                                'project_id' => $request->project_id,
                                'module' => 'Purchase',
                                'activity' => "Purchase with reference no  " .  $purchase->reference_no . "  is Updated for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );

                        $pos_activity = POSActivity::create(
                            [
                                'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                                'module_id' => $purchase->id,
                                'module' => 'Purchase',
                                'activity' => "Purchase with reference no  " .  $purchase->reference_no . "  is Updated for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );
                    }
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Updated Successfully", 'type' => 'purchase']);
                break;


            case 'debit':

                if ($request->receive == '1') {
                    $return = ReturnPurchases::find($request->id);

                    $invoice = Purchase::find($request->purchase_id);
                    $data['project_id'] = $request->project_id;
                    $data['supplier_id'] = $request->supplier_id;
                    $data['return_date'] = $request->return_date;
                    $data['due_date'] = $request->due_date;
                    $data['location'] = $invoice->location;
                    $data['exchange_code'] = $invoice->exchange_code;
                    $data['exchange_rate'] = $invoice->exchange_rate;
                    $data['purchase_amount'] = '1';
                    $data['due_amount'] = '1';
                    $data['purchase_tax'] = '1';
                    $data['status'] = '1';
                    $data['good_receive'] = '1';
                    $data['added_by'] = auth()->user()->added_by;

                    $return->update($data);


                    $amountArr = str_replace(",", "", $request->amount);
                    $totalArr =  str_replace(",", "", $request->tax);

                    $nameArr = $request->items_id;
                    $qtyArr = $request->quantity;
                    $priceArr = $request->price;
                    $unitArr = $request->unit;
                    $costArr = str_replace(",", "", $request->total_cost);
                    $taxArr =  str_replace(",", "", $request->total_tax);
                    $idArr = $request->return_item;
                    $remArr = $request->removed_id;
                    $expArr = $request->item_id;


                    $cost['purchase_amount'] = 0;
                    $cost['purchase_tax'] = 0;

                    if (!empty($remArr)) {
                        for ($i = 0; $i < count($remArr); $i++) {
                            if (!empty($remArr[$i])) {
                                ReturnPurchasesItems::where('id', $remArr[$i])->delete();
                            }
                        }
                    }

                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($nameArr); $i++) {
                            if (!empty($nameArr[$i])) {
                                $cost['purchase_amount'] += $costArr[$i];
                                $cost['purchase_tax'] += $taxArr[$i];

                                if ($taxArr[$i] == '0') {
                                    $rateArr[$i] = 0;
                                } else {
                                    $rateArr[$i] = 0.18;
                                }

                                $items = array(
                                    'item_name' => $nameArr[$i],
                                    'quantity' =>   $qtyArr[$i],
                                    'tax_rate' =>  $rateArr[$i],
                                    'unit' => $unitArr[$i],
                                    'price' =>  $priceArr[$i],
                                    'total_cost' =>  $costArr[$i],
                                    'total_tax' =>   $taxArr[$i],
                                    'items_id' => $nameArr[$i],
                                    'order_no' => $i,
                                    'added_by' => auth()->user()->added_by,
                                    'return_id' => $return->id,
                                    'return_item' => $idArr[$i],
                                    'purchase_id' => $request->purchase_id
                                );

                                if (!empty($expArr[$i])) {
                                    ReturnPurchasesItems::where('id', $expArr[$i])->update($items);
                                } else {
                                    ReturnPurchasesItems::create($items);
                                }
                            }
                        }

                        $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
                        ReturnPurchasesItems::where('return_id', $return->id)->update($cost);
                    }

                    ReturnPurchases::find($request->id)->update($cost);


                    /*
           $rn= ReturnPurchases::find($id);
                        $crn= Purchase::where('id',$request->purchase_id)->first();
                        $nxt['purchase_amount']=$crn->purchase_amount - $rn->purchase_amount ;
                        $nxt['purchase_tax']=$crn->purchase_tax - $rn->purchase_tax ;
                        $nxt['due_amount']=$crn->due_amount -   $rn->due_amount ;
                  //dd($nxt);
                         Purchase::where('id',$request->purchase_id)->update($nxt);

  */

                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($nameArr); $i++) {
                            if (!empty($nameArr[$i])) {

                                $saved = Items::find($nameArr[$i]);

                                $lists = array(
                                    'quantity' =>   $qtyArr[$i],
                                    'price' =>   $priceArr[$i],
                                    'item_id' => $nameArr[$i],
                                    'added_by' => auth()->user()->added_by,
                                    'supplier_id' =>   $data['supplier_id'],
                                    'location' =>    $invoice->location,
                                    'return_date' =>  $data['return_date'],
                                    'purchase_date' =>  $data['return_date'],
                                    'return_id' =>  $return->id,
                                    'project_id' => $request->project_id,
                                    'type' =>   'Debit Note',
                                    'purchase_id' => $request->purchase_id
                                );

                                PurchaseHistory::create($lists);

                                $inv_qty = Items::where('id', $nameArr[$i])->first();
                                $q = $inv_qty->quantity - $qtyArr[$i];
                                Items::where('id', $nameArr[$i])->update(['quantity' => $q]);

                                $loc = Location::where('id', $invoice->location)->first();
                                $lq['quantity'] = $loc->quantity - $qtyArr[$i];
                                if ($saved->bar == '1') {
                                    $lq['crate'] = $loc->crate - $qtyArr[$i];
                                    $lq['bottle'] = $loc->bottle - ($qtyArr[$i] * $saved->bottle);
                                }
                                Location::where('id', $invoice->location)->update($lq);

                                /*

                       $due_qty= PurchaseItems::where('id',$idArr[$i])->first();
                         $prev['due_quantity']=$due_qty->due_quantity - $qtyArr[$i];
                         $prev['total_tax']=$due_qty->total_tax - $taxArr[$i];
                        $prev['total_cost']=$due_qty->total_cost - $costArr[$i];
                        PurchaseItems::where('id',$idArr[$i])->update($prev);

                       */
                            }
                        }
                    }

                    $project = Project::find($request->project_id);
                    $inv =  ReturnPurchases::find($request->id);
                    $sales = Purchase::find($inv->purchase_id);
                    $supp = Supplier::find($inv->supplier_id);

                    $cr = AccountCodes::where('account_name', 'Purchases')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $cr->id;
                    $date = explode('-', $inv->return_date);
                    $journal->date =   $inv->return_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_debit_note';
                    $journal->name = 'Debit Note';
                    $journal->credit = $inv->purchase_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->supplier_id = $inv->supplier_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Return Purchases for Purchase Order " . $sales->reference_no . " to Supplier  " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    if ($inv->purchase_tax > 0) {
                        $tax = AccountCodes::where('account_name', 'VAT IN')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $tax->id;
                        $date = explode('-', $inv->return_date);
                        $journal->date =   $inv->return_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_debit_note';
                        $journal->name = 'Debit Note';
                        $journal->credit = $inv->purchase_tax *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->supplier_id = $inv->supplier_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Return Purchases Tax for Purchase Order " . $sales->reference_no . " to Supplier  " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();
                    }

                    $codes = AccountCodes::where('account_name', 'Payables')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-', $inv->return_date);
                    $journal->date =   $inv->return_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_debit_note';
                    $journal->name = 'Debit Note';
                    $journal->income_id = $inv->id;
                    $journal->supplier_id = $inv->supplier_id;
                    $journal->project_id = $inv->project_id;
                    $journal->debit = $inv->due_amount *  $inv->exchange_rate;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Return Debit for Purchase Order " . $sales->reference_no . " to Supplier  " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();




                    if (!empty($return)) {
                        $project = Project::find($request->project_id);

                        $activity = Activity::create(
                            [
                                'added_by' => auth()->user()->id,
                                'module_id' => $return->id,
                                'project_id' => $request->project_id,
                                'module' => 'Debit Note',
                                'activity' => "Debit Note for Purchases with reference no  " .  $sales->reference_no . "  is Approved for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );


                        $pos_activity = POSActivity::create(
                            [
                                'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                                'module_id' => $return->id,
                                'module' => 'Debit Note',
                                'activity' => "Debit Note for Purchases with reference no  " .  $sales->reference_no . "  is Approved for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );
                    }
                } else {

                    $return = ReturnPurchases::find($request->id);

                    $invoice = Purchase::find($request->purchase_id);
                    $data['project_id'] = $request->project_id;
                    $data['supplier_id'] = $request->supplier_id;
                    $data['return_date'] = $request->return_date;
                    $data['due_date'] = $request->due_date;
                    $data['location'] = $invoice->location;
                    $data['exchange_code'] = $invoice->exchange_code;
                    $data['exchange_rate'] = $invoice->exchange_rate;
                    $data['purchase_amount'] = '1';
                    $data['due_amount'] = '1';
                    $data['purchase_tax'] = '1';

                    $data['added_by'] = auth()->user()->added_by;

                    $return->update($data);


                    $amountArr = str_replace(",", "", $request->amount);
                    $totalArr =  str_replace(",", "", $request->tax);

                    $nameArr = $request->items_id;
                    $qtyArr = $request->quantity;
                    $priceArr = $request->price;
                    $unitArr = $request->unit;
                    $costArr = str_replace(",", "", $request->total_cost);
                    $taxArr =  str_replace(",", "", $request->total_tax);
                    $idArr = $request->return_item;
                    $remArr = $request->removed_id;
                    $expArr = $request->item_id;


                    $cost['purchase_amount'] = 0;
                    $cost['purchase_tax'] = 0;

                    if (!empty($remArr)) {
                        for ($i = 0; $i < count($remArr); $i++) {
                            if (!empty($remArr[$i])) {
                                ReturnPurchasesItems::where('id', $remArr[$i])->delete();
                            }
                        }
                    }

                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($nameArr); $i++) {
                            if (!empty($nameArr[$i])) {
                                $cost['purchase_amount'] += $costArr[$i];
                                $cost['purchase_tax'] += $taxArr[$i];

                                if ($taxArr[$i] == '0') {
                                    $rateArr[$i] = 0;
                                } else {
                                    $rateArr[$i] = 0.18;
                                }

                                $items = array(
                                    'item_name' => $nameArr[$i],
                                    'quantity' =>   $qtyArr[$i],
                                    'tax_rate' =>  $rateArr[$i],
                                    'unit' => $unitArr[$i],
                                    'price' =>  $priceArr[$i],
                                    'total_cost' =>  $costArr[$i],
                                    'total_tax' =>   $taxArr[$i],
                                    'items_id' => $nameArr[$i],
                                    'order_no' => $i,
                                    'added_by' => auth()->user()->added_by,
                                    'return_id' => $return->id,
                                    'return_item' => $idArr[$i],
                                    'purchase_id' => $request->purchase_id
                                );

                                if (!empty($expArr[$i])) {
                                    ReturnPurchasesItems::where('id', $expArr[$i])->update($items);
                                } else {
                                    ReturnPurchasesItems::create($items);
                                }
                            }
                        }

                        $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
                        ReturnPurchasesItems::where('return_id', $return->id)->update($cost);
                    }

                    ReturnPurchases::find($return->id)->update($cost);



                    if (!empty($return)) {
                        $project = Project::find($request->project_id);

                        $activity = Activity::create(
                            [
                                'added_by' => auth()->user()->id,
                                'module_id' => $return->id,
                                'project_id' => $request->project_id,
                                'module' => 'Debit Note',
                                'activity' => "Debit Note for Purchases with reference no  " .  $invoice->reference_no . "  is Updated for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );


                        $pos_activity = POSActivity::create(
                            [
                                'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                                'module_id' => $return->id,
                                'module' => 'Debit Note',
                                'activity' => "Debit Note for Purchases with reference no  " .  $invoice->reference_no . "  is Updated for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );
                    }
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Updated Successfully", 'type' => 'debit']);
                break;




            case 'tasks':

                $task = Task::find($request->id);

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['goal_tracking_id'] = 'Projects';

                $task->update($data);


                if (!empty($task)) {
                    $project = Project::find($request->project_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $task->id,
                            'project_id' => $request->project_id,
                            'module' => 'Tasks',
                            'activity' => "Task " .  $task->task_name .  " Updated for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );


                    $task_activity = TaskActivity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $task->id,
                            'module' => 'Task',
                            'activity' => "Task " .  $task->task_name .  " Updated",
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Updated Successfully", 'type' => 'tasks']);
                break;

            case 'estimate':

                if ($request->receive == '1') {

                    $invoice = Invoice::find($request->id);

                    $data['project_id'] = $request->project_id;
                    $data['client_id'] = $request->client_id;
                    $data['invoice_date'] = $request->invoice_date;
                    $data['due_date'] = $request->due_date;
                    $data['location'] = $request->location;
                    $data['exchange_code'] = $request->exchange_code;
                    $data['exchange_rate'] = $request->exchange_rate;
                    $data['invoice_amount'] = '1';
                    $data['due_amount'] = '1';
                    $data['invoice_tax'] = '1';
                    $data['good_receive'] = '1';
                    $data['invoice_status'] = '1';
                    $data['sales_type'] = 'Credit Sales';
                    $data['status'] = '1';
                    $data['user_agent'] = $request->user_agent;
                    $data['added_by'] = auth()->user()->added_by;

                    $invoice->update($data);

                    $nameArr = $request->item_name;
                    $descArr = $request->description;
                    $qtyArr = $request->quantity;
                    $priceArr = $request->price;
                    $rateArr = $request->tax_rate;
                    $unitArr = $request->unit;
                    $costArr = str_replace(",", "", $request->total_cost);
                    $taxArr =  str_replace(",", "", $request->total_tax);
                    $remArr = $request->removed_id;
                    $expArr = $request->saved_items_id;
                    $savedArr = $request->item_name;


                    $subArr = str_replace(",", "", $request->subtotal);
                    $totalArr =  str_replace(",", "", $request->tax);
                    $amountArr = str_replace(",", "", $request->amount);
                    $disArr =  str_replace(",", "", $request->discount);
                    $shipArr =  str_replace(",", "", $request->shipping_cost);

                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($amountArr); $i++) {
                            if (!empty($amountArr[$i])) {
                                $t = array(
                                    'invoice_amount' =>  $subArr[$i],
                                    'invoice_tax' =>  $totalArr[$i],
                                    'shipping_cost' =>   $shipArr[$i],
                                    'discount' => $disArr[$i],
                                    'due_amount' =>  $amountArr[$i]
                                );

                                Invoice::where('id', $request->id)->update($t);
                            }
                        }
                    }



                    $cost['invoice_amount'] = 0;
                    $cost['invoice_tax'] = 0;


                    if (!empty($remArr)) {
                        for ($i = 0; $i < count($remArr); $i++) {
                            if (!empty($remArr[$i])) {
                                InvoiceItems::where('id', $remArr[$i])->delete();
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
                                    'description' => $descArr[$i],
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
                                    InvoiceItems::where('id', $expArr[$i])->update($items);
                                } else {
                                    InvoiceItems::create($items);
                                }
                            }
                        }

                        $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
                        InvoiceItems::where('id', $invoice->id)->update($cost);
                    }



                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($nameArr); $i++) {
                            if (!empty($nameArr[$i])) {

                                $lists = array(
                                    'quantity' =>   $qtyArr[$i],
                                    'price' =>   $priceArr[$i],
                                    'item_id' => $savedArr[$i],
                                    'added_by' => auth()->user()->added_by,
                                    'client_id' =>   $data['client_id'],
                                    'location' =>   $data['location'],
                                    'invoice_date' =>  $data['invoice_date'],
                                    'type' =>   'Sales',
                                    'invoice_id' => $request->id
                                );


                                InvoiceHistory::create($lists);

                                $inv = Items::where('id', $nameArr[$i])->first();
                                $q = $inv->quantity - $qtyArr[$i];
                                Items::where('id', $nameArr[$i])->update(['quantity' => $q]);

                                $loc = Location::where('id', $invoice->location)->first();
                                $lq['quantity'] = $loc->quantity - $qtyArr[$i];
                                Location::where('id', $invoice->location)->update($lq);
                            }
                        }
                    }


                    $inv = Invoice::find($request->id);
                    $supp = Client::find($inv->client_id);
                    $project = Project::find($request->project_id);

                    $cr = AccountCodes::where('account_name', 'Sales')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $cr->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Sales for Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    if ($inv->invoice_tax > 0) {
                        $tax = AccountCodes::where('account_name', 'VAT OUT')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $tax->id;
                        $date = explode('-', $inv->invoice_date);
                        $journal->date =   $inv->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice';
                        $journal->name = 'Invoice';
                        $journal->credit = $inv->invoice_tax *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->client_id = $inv->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Sales Tax for Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();
                    }

                    $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->debit = ($inv->invoice_amount + $inv->invoice_tax)  *  $inv->exchange_rate;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Receivables for Sales Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    $stock = AccountCodes::where('account_name', 'Inventory')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id =  $stock->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Reduce Stock  for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    $cos = AccountCodes::where('account_name', 'Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id =  $cos->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Cost of Goods Sold  for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();


                    if ($inv->discount > 0) {
                        $cr = AccountCodes::where('account_name', 'Sales')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $cr->id;
                        $date = explode('-', $inv->invoice_date);
                        $journal->date =   $inv->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice';
                        $journal->name = 'Invoice';
                        $journal->debit = $inv->discount *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->client_id = $inv->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Sales Discount for for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;;
                        $journal->save();


                        $disc = AccountCodes::where('account_name', 'Sales Discount')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $disc->id;
                        $date = explode('-', $inv->invoice_date);
                        $journal->date =   $inv->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice';
                        $journal->name = 'Invoice';
                        $journal->credit = $inv->discount *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->client_id = $inv->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Sales Discount for for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;;
                        $journal->save();
                    }


                    if ($inv->shipping_cost > 0) {

                        $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $codes->id;
                        $date = explode('-', $inv->invoice_date);
                        $journal->date =   $inv->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice';
                        $journal->name = 'Invoice';
                        $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->client_id = $inv->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Sales Shipping Cost for Sales Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;;
                        $journal->save();


                        $shp = AccountCodes::where('account_name', 'Shipping Cost')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $shp->id;
                        $date = explode('-', $inv->invoice_date);
                        $journal->date =   $inv->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice';
                        $journal->name = 'Invoice';
                        $journal->credit = $inv->shipping_cost *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->client_id = $inv->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Credit Shipping Cost for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;;
                        $journal->save();
                    }



                    if (!empty($invoice)) {
                        $project = Project::find($request->project_id);

                        $activity = Activity::create(
                            [
                                'added_by' => auth()->user()->id,
                                'module_id' => $invoice->id,
                                'project_id' => $request->project_id,
                                'module' => 'Proforma Invoice',
                                'activity' => "Proforma Invoice with reference no  " .  $invoice->reference_no . "  is  converted to Invoice for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );

                        $pos_activity = POSActivity::create(
                            [
                                'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                                'module_id' => $invoice->id,
                                'module' => 'Proforma Invoice',
                                'activity' => "Proforma Invoice with reference no  " .  $invoice->reference_no . "  is  converted to Invoice for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );
                    }

                    return redirect(route('project.show', $request->project_id))->with(['success' => "Converted  Successfully", 'type' => 'invoice']);
                } else {



                    $invoice = Invoice::find($request->id);

                    $data['project_id'] = $request->project_id;
                    $data['client_id'] = $request->client_id;
                    $data['invoice_date'] = $request->invoice_date;
                    $data['due_date'] = $request->due_date;
                    $data['location'] = $request->location;
                    $data['exchange_code'] = $request->exchange_code;
                    $data['exchange_rate'] = $request->exchange_rate;
                    $data['invoice_amount'] = '1';
                    $data['due_amount'] = '1';
                    $data['invoice_tax'] = '1';
                    $data['user_agent'] = $request->user_agent;
                    $data['added_by'] = auth()->user()->added_by;

                    $invoice->update($data);

                    $nameArr = $request->item_name;
                    $descArr = $request->description;
                    $qtyArr = $request->quantity;
                    $priceArr = $request->price;
                    $rateArr = $request->tax_rate;
                    $unitArr = $request->unit;
                    $costArr = str_replace(",", "", $request->total_cost);
                    $taxArr =  str_replace(",", "", $request->total_tax);
                    $remArr = $request->removed_id;
                    $expArr = $request->saved_items_id;
                    $savedArr = $request->item_name;


                    $subArr = str_replace(",", "", $request->subtotal);
                    $totalArr =  str_replace(",", "", $request->tax);
                    $amountArr = str_replace(",", "", $request->amount);
                    $disArr =  str_replace(",", "", $request->discount);
                    $shipArr =  str_replace(",", "", $request->shipping_cost);

                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($amountArr); $i++) {
                            if (!empty($amountArr[$i])) {
                                $t = array(
                                    'invoice_amount' =>  $subArr[$i],
                                    'invoice_tax' =>  $totalArr[$i],
                                    'shipping_cost' =>   $shipArr[$i],
                                    'discount' => $disArr[$i],
                                    'due_amount' =>  $amountArr[$i]
                                );

                                Invoice::where('id', $request->id)->update($t);
                            }
                        }
                    }



                    $cost['invoice_amount'] = 0;
                    $cost['invoice_tax'] = 0;


                    if (!empty($remArr)) {
                        for ($i = 0; $i < count($remArr); $i++) {
                            if (!empty($remArr[$i])) {
                                InvoiceItems::where('id', $remArr[$i])->delete();
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
                                    'description' => $descArr[$i],
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
                                    InvoiceItems::where('id', $expArr[$i])->update($items);
                                } else {
                                    InvoiceItems::create($items);
                                }
                            }
                        }

                        $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
                        InvoiceItems::where('id', $invoice->id)->update($cost);
                    }


                    if (!empty($invoice)) {
                        $project = Project::find($request->project_id);

                        $activity = Activity::create(
                            [
                                'added_by' => auth()->user()->id,
                                'module_id' => $invoice->id,
                                'project_id' => $request->project_id,
                                'module' => 'Proforma Invoice',
                                'activity' => "Proforma Invoice with reference no  " .  $invoice->reference_no . "  is Updated for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );

                        $pos_activity = POSActivity::create(
                            [
                                'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                                'module_id' => $invoice->id,
                                'module' => 'Proforma Invoice',
                                'activity' => "Proforma Invoice with reference no  " .  $invoice->reference_no . "  is Updated for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );
                    }

                    return redirect(route('project.show', $request->project_id))->with(['success' => "Details Updated Successfully", 'type' => 'estimate']);
                }

                break;

            case 'invoice':

                if ($request->receive == '1') {
                    $invoice = Invoice::find($request->id);

                    $data['project_id'] = $request->project_id;
                    $data['client_id'] = $request->client_id;
                    $data['invoice_date'] = $request->invoice_date;
                    $data['due_date'] = $request->due_date;
                    $data['location'] = $request->location;
                    $data['exchange_code'] = $request->exchange_code;
                    $data['exchange_rate'] = $request->exchange_rate;
                    $data['invoice_amount'] = '1';
                    $data['due_amount'] = '1';
                    $data['invoice_tax'] = '1';
                    $data['good_receive'] = '1';
                    $data['user_agent'] = $request->user_agent;
                    $data['sales_type'] = $request->sales_type;
                    $data['bank_id'] = $request->bank_id;
                    $data['status'] = '1';
                    $data['added_by'] = auth()->user()->added_by;

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
                                InvoiceItems::where('id', $remArr[$i])->delete();
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
                                    InvoiceItems::where('id', $expArr[$i])->update($items);
                                } else {
                                    InvoiceItems::create($items);
                                }
                            }
                        }

                        $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
                        InvoiceItems::where('id', $invoice->id)->update($cost);
                    }

                    Invoice::find($invoice->id)->update($cost);


                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($nameArr); $i++) {
                            if (!empty($nameArr[$i])) {

                                $lists = array(
                                    'quantity' =>   $qtyArr[$i],
                                    'price' =>   $priceArr[$i],
                                    'item_id' => $savedArr[$i],
                                    'project_id' => $request->project_id,
                                    'added_by' => auth()->user()->added_by,
                                    'client_id' =>   $data['client_id'],
                                    'location' => $data['location'],
                                    'invoice_date' =>  $data['invoice_date'],
                                    'type' =>   'Sales',
                                    'invoice_id' => $invoice->id
                                );

                                InvoiceHistory::create($lists);

                                $inv = Items::where('id', $nameArr[$i])->first();
                                $q = $inv->quantity - $qtyArr[$i];
                                Items::where('id', $nameArr[$i])->update(['quantity' => $q]);
                            }
                        }
                    }

                    $project = Project::find($request->project_id);
                    $inv = Invoice::find($request->id);
                    $supp = Client::find($inv->client_id);
                    $cr = AccountCodes::where('account_name', 'Sales')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $cr->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Sales for Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    if ($inv->invoice_tax > 0) {
                        $tax = AccountCodes::where('account_name', 'VAT OUT')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $tax->id;
                        $date = explode('-', $inv->invoice_date);
                        $journal->date =   $inv->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice';
                        $journal->name = 'Invoice';
                        $journal->credit = $inv->invoice_tax *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->client_id = $inv->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Sales Tax for Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();
                    }

                    $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->debit = $inv->due_amount *  $inv->exchange_rate;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Receivables for Sales Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    $stock = AccountCodes::where('account_name', 'Inventory')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id =  $stock->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Reduce Stock  for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    $cos = AccountCodes::where('account_name', 'Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id =  $cos->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Cost of Goods Sold  for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();


                    if (!empty($invoice)) {
                        $project = Project::find($request->project_id);

                        $activity = Activity::create(
                            [
                                'added_by' => auth()->user()->id,
                                'module_id' => $inv->id,
                                'project_id' => $request->project_id,
                                'module' => 'Invoice',
                                'activity' => "Invoice with reference no  " .  $inv->reference_no . "  is Approved for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );


                        $pos_activity = POSActivity::create(
                            [
                                'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                                'module_id' => $inv->id,
                                'module' => 'Invoice',
                                'activity' => "Invoice with reference no  " .  $inv->reference_no . "  is Approved for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );
                    }


                    //invoice payment
                    if ($inv->sales_type == 'Cash Sales') {

                        $sales = Invoice::find($inv->id);
                        $method = Payment_methodes::where('name', 'Cash')->first();
                        $count = InvoicePayments::count();
                        $pro = $count + 1;

                        $receipt['trans_id'] = "TBSPH-" . $pro;
                        $receipt['invoice_id'] = $inv->id;
                        $receipt['amount'] = $inv->due_amount;
                        $receipt['date'] = $inv->invoice_date;
                        $receipt['account_id'] = $request->bank_id;
                        $receipt['payment_method'] = $method->id;
                        $receipt['user_id'] = $sales->user_agent;
                        $receipt['added_by'] = auth()->user()->added_by;

                        //update due amount from invoice table
                        $b['due_amount'] =  0;
                        $b['status'] = 3;

                        $sales->update($b);

                        $payment = InvoicePayments::create($receipt);

                        $supp = Client::find($sales->client_id);

                        $cr = AccountCodes::where('id', '$request->bank_id')->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $request->bank_id;
                        $date = explode('-', $request->invoice_date);
                        $journal->date =   $request->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice_payment';
                        $journal->name = 'Invoice Payment';
                        $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
                        $journal->payment_id = $payment->id;
                        $journal->client_id = $sales->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =   $sales->currency_code;
                        $journal->exchange_rate =  $sales->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Deposit for Sales Invoice No " . $sales->reference_no . " by Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();


                        $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $codes->id;
                        $date = explode('-', $request->invoice_date);
                        $journal->date =   $request->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice_payment';
                        $journal->name = 'Invoice Payment';
                        $journal->credit = $receipt['amount'] *  $sales->exchange_rate;
                        $journal->payment_id = $payment->id;
                        $journal->client_id = $sales->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =   $sales->currency_code;
                        $journal->exchange_rate =  $sales->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Clear Receivable for Invoice No  " . $sales->reference_no . " by Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();

                        $account = Accounts::where('account_id', $request->bank_id)->first();

                        if (!empty($account)) {
                            $balance = $account->balance + $payment->amount;
                            $item_to['balance'] = $balance;
                            $account->update($item_to);
                        } else {
                            $cr = AccountCodes::where('id', $request->bank_id)->first();

                            $new['account_id'] = $request->bank_id;
                            $new['account_name'] = $cr->account_name;
                            $new['balance'] = $payment->amount;
                            $new[' exchange_code'] = $sales->currency_code;
                            $new['added_by'] = auth()->user()->added_by;
                            $balance = $payment->amount;
                            Accounts::create($new);
                        }

                        // save into tbl_transaction

                        $transaction = Transaction::create([
                            'module' => 'POS Invoice Payment',
                            'module_id' => $payment->id,
                            'account_id' => $request->bank_id,
                            'code_id' => $codes->id,
                            'name' => 'POS Invoice Payment with reference ' . $payment->trans_id,
                            'transaction_prefix' => $payment->trans_id,
                            'type' => 'Income',
                            'amount' => $payment->amount,
                            'credit' => $payment->amount,
                            'total_balance' => $balance,
                            'date' => date('Y-m-d', strtotime($request->date)),
                            'paid_by' => $sales->client_id,
                            'payment_methods_id' => $payment->payment_method,
                            'status' => 'paid',
                            'notes' => 'This deposit is from pos invoice  payment. The Reference is ' . $sales->reference_no . ' by Client ' . $supp->name,
                            'added_by' => auth()->user()->added_by,
                        ]);


                        if (!empty($payment)) {
                            $project = Project::find($request->project_id);

                            $activity = Activity::create(
                                [
                                    'added_by' => auth()->user()->id,
                                    'module_id' => $payment->id,
                                    'project_id' => $request->project_id,
                                    'module' => 'Invoice Payment',
                                    'activity' => "Invoice with reference no  " .  $sales->reference_no . "  is Paid for the Project " .  $project->project_name . "-" . $project->project_no,
                                ]
                            );

                            $pos_activity = POSActivity::create(
                                [
                                    'added_by' => auth()->user()->added_by,
                                    'user_id' => auth()->user()->id,
                                    'module_id' => $payment->id,
                                    'module' => 'Invoice Payment',
                                    'activity' => "Invoice with reference no  " .  $sales->reference_no . "  is Paid for the Project " .  $project->project_name . "-" . $project->project_no,
                                ]
                            );
                        }
                    }
                } else {

                    $invoice = Invoice::find($request->id);

                    $old = InvoiceItems::where('invoice_id', $request->id)->get();

                    foreach ($old as $o) {

                        $oinv = Items::where('id', $o->item_name)->first();
                        $oq = $oinv->quantity + $o->due_quantity;
                        Items::where('id', $o->item_name)->update(['quantity' => $oq]);

                        $oloc = Location::where('id', $invoice->location)->first();
                        $olq['quantity'] = $oloc->quantity + $o->due_quantity;
                        Location::where('id', $invoice->location)->update($olq);
                    }

                    $data['project_id'] = $request->project_id;
                    $data['client_id'] = $request->client_id;
                    $data['invoice_date'] = $request->invoice_date;
                    $data['due_date'] = $request->due_date;
                    $data['location'] = $request->location;
                    $data['exchange_code'] = $request->exchange_code;
                    $data['exchange_rate'] = $request->exchange_rate;
                    $data['invoice_amount'] = '1';
                    $data['due_amount'] = '1';
                    $data['invoice_tax'] = '1';
                    $data['user_agent'] = $request->user_agent;
                    $data['sales_type'] = $request->sales_type;
                    $data['bank_id'] = $request->bank_id;
                    $data['added_by'] = auth()->user()->added_by;

                    $invoice->update($data);



                    $nameArr = $request->item_name;
                    $descArr = $request->description;
                    $qtyArr = $request->quantity;
                    $priceArr = $request->price;
                    $rateArr = $request->tax_rate;
                    $unitArr = $request->unit;
                    $costArr = str_replace(",", "", $request->total_cost);
                    $taxArr =  str_replace(",", "", $request->total_tax);
                    $remArr = $request->removed_id;
                    $expArr = $request->saved_items_id;
                    $savedArr = $request->item_name;

                    $subArr = str_replace(",", "", $request->subtotal);
                    $totalArr =  str_replace(",", "", $request->tax);
                    $amountArr = str_replace(",", "", $request->amount);
                    $disArr =  str_replace(",", "", $request->discount);
                    $shipArr =  str_replace(",", "", $request->shipping_cost);

                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($amountArr); $i++) {
                            if (!empty($amountArr[$i])) {
                                $t = array(
                                    'invoice_amount' =>  $subArr[$i],
                                    'invoice_tax' =>  $totalArr[$i],
                                    'shipping_cost' =>   $shipArr[$i],
                                    'discount' => $disArr[$i],
                                    'due_amount' =>  $amountArr[$i]
                                );

                                Invoice::where('id', $request->id)->update($t);
                            }
                        }
                    }




                    $cost['invoice_amount'] = 0;
                    $cost['invoice_tax'] = 0;


                    if (!empty($remArr)) {
                        for ($i = 0; $i < count($remArr); $i++) {
                            if (!empty($remArr[$i])) {
                                InvoiceItems::where('id', $remArr[$i])->delete();
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
                                    'description' => $descArr[$i],
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
                                    InvoiceItems::where('id', $expArr[$i])->update($items);
                                } else {
                                    InvoiceItems::create($items);
                                }
                            }
                        }

                        $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
                        InvoiceItems::where('id', $invoice->id)->update($cost);
                    }


                    InvoiceHistory::where('invoice_id', $invoice->id)->delete();
                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($nameArr); $i++) {
                            if (!empty($nameArr[$i])) {

                                $lists = array(
                                    'quantity' =>   $qtyArr[$i],
                                    'price' =>   $priceArr[$i],
                                    'item_id' => $savedArr[$i],
                                    'added_by' => auth()->user()->added_by,
                                    'client_id' =>   $data['client_id'],
                                    'location' =>   $data['location'],
                                    'invoice_date' =>  $data['invoice_date'],
                                    'type' =>   'Sales',
                                    'invoice_id' => $invoice->id
                                );


                                InvoiceHistory::create($lists);

                                $inv = Items::where('id', $nameArr[$i])->first();
                                $q = $inv->quantity - $qtyArr[$i];
                                Items::where('id', $nameArr[$i])->update(['quantity' => $q]);

                                $loc = Location::where('id', $invoice->location)->first();
                                $lq['quantity'] = $loc->quantity - $qtyArr[$i];
                                Location::where('id', $request->location)->update($lq);
                            }
                        }
                    }

                    JournalEntry::where('income_id', $invoice->id)->where('transaction_type', 'pos_invoice')->delete();

                    $project = Project::find($request->project_id);
                    $inv = Invoice::find($request->id);
                    $supp = Client::find($inv->client_id);

                    $cr = AccountCodes::where('account_name', 'Sales')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $cr->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Sales for Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    if ($inv->invoice_tax > 0) {
                        $tax = AccountCodes::where('account_name', 'VAT OUT')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $tax->id;
                        $date = explode('-', $inv->invoice_date);
                        $journal->date =   $inv->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice';
                        $journal->name = 'Invoice';
                        $journal->credit = $inv->invoice_tax *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->client_id = $inv->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Sales Tax for Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();
                    }

                    $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->debit = ($inv->invoice_amount + $inv->invoice_tax) *  $inv->exchange_rate;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Receivables for Sales Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    $stock = AccountCodes::where('account_name', 'Inventory')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id =  $stock->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Reduce Stock  for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    $cos = AccountCodes::where('account_name', 'Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id =  $cos->id;
                    $date = explode('-', $inv->invoice_date);
                    $journal->date =   $inv->invoice_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_invoice';
                    $journal->name = 'Invoice';
                    $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Cost of Goods Sold  for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();


                    if ($inv->discount > 0) {
                        $cr = AccountCodes::where('account_name', 'Sales')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $cr->id;
                        $date = explode('-', $inv->invoice_date);
                        $journal->date =   $inv->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice';
                        $journal->name = 'Invoice';
                        $journal->debit = $inv->discount *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->client_id = $inv->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Sales Discount for for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();


                        $disc = AccountCodes::where('account_name', 'Sales Discount')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $disc->id;
                        $date = explode('-', $inv->invoice_date);
                        $journal->date =   $inv->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice';
                        $journal->name = 'Invoice';
                        $journal->credit = $inv->discount *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->client_id = $inv->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Sales Discount for for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();
                    }


                    if ($inv->shipping_cost > 0) {

                        $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $codes->id;
                        $date = explode('-', $inv->invoice_date);
                        $journal->date =   $inv->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice';
                        $journal->name = 'Invoice';
                        $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->client_id = $inv->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Sales Shipping Cost for Sales Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();


                        $shp = AccountCodes::where('account_name', 'Shipping Cost')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $shp->id;
                        $date = explode('-', $inv->invoice_date);
                        $journal->date =   $inv->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice';
                        $journal->name = 'Invoice';
                        $journal->credit = $inv->shipping_cost *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->client_id = $inv->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Credit Shipping Cost for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();
                    }



                    if (!empty($invoice)) {
                        $project = Project::find($request->project_id);

                        $activity = Activity::create(
                            [
                                'added_by' => auth()->user()->id,
                                'module_id' => $invoice->id,
                                'project_id' => $request->project_id,
                                'module' => 'Invoice',
                                'activity' => "Invoice with reference no  " .  $invoice->reference_no . "  is Updated for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );


                        $pos_activity = POSActivity::create(
                            [
                                'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                                'module_id' => $invoice->id,
                                'module' => 'Invoice',
                                'activity' => "Invoice with reference no  " .  $invoice->reference_no . "  is Updated for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );
                    }


                    //invoice payment
                    if ($inv->sales_type == 'Cash Sales') {

                        $sales = Invoice::find($inv->id);
                        $method = Payment_methodes::where('name', 'Cash')->first();
                        $count = InvoicePayments::count();
                        $pro = $count + 1;

                        $receipt['trans_id'] = "TBSPH-" . $pro;
                        $receipt['invoice_id'] = $inv->id;
                        $receipt['amount'] = $inv->due_amount;
                        $receipt['date'] = $inv->invoice_date;
                        $receipt['account_id'] = $request->bank_id;
                        $receipt['payment_method'] = $method->id;
                        $receipt['user_id'] = $sales->user_agent;
                        $receipt['added_by'] = auth()->user()->added_by;

                        //update due amount from invoice table
                        $b['due_amount'] =  0;
                        $b['status'] = 3;

                        $sales->update($b);

                        $payment = InvoicePayments::create($receipt);

                        $supp = Client::find($sales->client_id);

                        $cr = AccountCodes::where('id', '$request->bank_id')->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $request->bank_id;
                        $date = explode('-', $request->invoice_date);
                        $journal->date =   $request->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice_payment';
                        $journal->name = 'Invoice Payment';
                        $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
                        $journal->payment_id = $payment->id;
                        $journal->client_id = $sales->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =   $sales->currency_code;
                        $journal->exchange_rate =  $sales->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Deposit for Sales Invoice No " . $sales->reference_no . " by Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();


                        $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $codes->id;
                        $date = explode('-', $request->invoice_date);
                        $journal->date =   $request->invoice_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_invoice_payment';
                        $journal->name = 'Invoice Payment';
                        $journal->credit = $receipt['amount'] *  $sales->exchange_rate;
                        $journal->payment_id = $payment->id;
                        $journal->client_id = $sales->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =   $sales->currency_code;
                        $journal->exchange_rate =  $sales->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Clear Receivable for Invoice No  " . $sales->reference_no . " by Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();

                        $account = Accounts::where('account_id', $request->bank_id)->first();

                        if (!empty($account)) {
                            $balance = $account->balance + $payment->amount;
                            $item_to['balance'] = $balance;
                            $account->update($item_to);
                        } else {
                            $cr = AccountCodes::where('id', $request->bank_id)->first();

                            $new['account_id'] = $request->bank_id;
                            $new['account_name'] = $cr->account_name;
                            $new['balance'] = $payment->amount;
                            $new[' exchange_code'] = $sales->currency_code;
                            $new['added_by'] = auth()->user()->added_by;
                            $balance = $payment->amount;
                            Accounts::create($new);
                        }

                        // save into tbl_transaction

                        $transaction = Transaction::create([
                            'module' => 'POS Invoice Payment',
                            'module_id' => $payment->id,
                            'account_id' => $request->bank_id,
                            'code_id' => $codes->id,
                            'name' => 'POS Invoice Payment with reference ' . $payment->trans_id,
                            'transaction_prefix' => $payment->trans_id,
                            'type' => 'Income',
                            'amount' => $payment->amount,
                            'credit' => $payment->amount,
                            'total_balance' => $balance,
                            'date' => date('Y-m-d', strtotime($request->date)),
                            'paid_by' => $sales->client_id,
                            'payment_methods_id' => $payment->payment_method,
                            'status' => 'paid',
                            'notes' => 'This deposit is from pos invoice  payment. The Reference is ' . $sales->reference_no . ' by Client ' . $supp->name,
                            'added_by' => auth()->user()->added_by,
                        ]);


                        if (!empty($payment)) {
                            $project = Project::find($request->project_id);

                            $activity = Activity::create(
                                [
                                    'added_by' => auth()->user()->id,
                                    'module_id' => $payment->id,
                                    'project_id' => $request->project_id,
                                    'module' => 'Invoice Payment',
                                    'activity' => "Invoice with reference no  " .  $sales->reference_no . "  is Paid for the Project " .  $project->project_name . "-" . $project->project_no,
                                ]
                            );

                            $pos_activity = POSActivity::create(
                                [
                                    'added_by' => auth()->user()->added_by,
                                    'user_id' => auth()->user()->id,
                                    'module_id' => $payment->id,
                                    'module' => 'Invoice Payment',
                                    'activity' => "Invoice with reference no  " .  $sales->reference_no . "  is Paid for the Project " .  $project->project_name . "-" . $project->project_no,
                                ]
                            );
                        }
                    }
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Updated Successfully", 'type' => 'invoice']);
                break;


            case 'expenses':

                $total_expenses = Expenses::find($request->id);
                $data = $request->all();
                $total_expenses->update($data);;



                $total_multiple = Expenses::find($total_expenses->multiple_id);
                if (!empty($total_multiple)) {
                    $multiple = Expenses::where('multiple_id', $total_multiple->id)->sum('amount');
                    $m['amount'] = $multiple;
                    $total_multiple->update($m);
                }



                if (!empty($total_expenses)) {
                    $project = Project::find($request->project_id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $total_expenses->id,
                            'project_id' => $request->project_id,
                            'module' => 'Expenses',
                            'activity' => "Expenses with reference " .  $request->name . "  is Updated for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Updated Successfully", 'type' => 'expenses']);
                break;


            case 'credit':

                if ($request->receive == '1') {
                    $return = ReturnInvoice::find($request->id);

                    $invoice = Invoice::find($request->invoice_id);
                    $data['project_id'] = $request->project_id;
                    $data['client_id'] = $request->client_id;
                    $data['return_date'] = $request->return_date;
                    $data['due_date'] = $request->due_date;
                    $data['location'] = $invoice->location;
                    $data['exchange_code'] = $invoice->exchange_code;
                    $data['exchange_rate'] = $invoice->exchange_rate;
                    $data['invoice_amount'] = '1';
                    $data['due_amount'] = '1';
                    $data['invoice_tax'] = '1';
                    $data['good_receive'] = '1';
                    $data['status'] = '1';
                    $data['added_by'] = auth()->user()->added_by;

                    $return->update($data);


                    $amountArr = str_replace(",", "", $request->amount);
                    $totalArr =  str_replace(",", "", $request->tax);

                    $nameArr = $request->items_id;
                    $qtyArr = $request->quantity;
                    $priceArr = $request->price;
                    $unitArr = $request->unit;
                    $costArr = str_replace(",", "", $request->total_cost);
                    $taxArr =  str_replace(",", "", $request->total_tax);
                    $idArr = $request->return_item;
                    $remArr = $request->removed_id;
                    $expArr = $request->item_id;


                    $cost['invoice_amount'] = 0;
                    $cost['invoice_tax'] = 0;


                    if (!empty($remArr)) {
                        for ($i = 0; $i < count($remArr); $i++) {
                            if (!empty($remArr[$i])) {
                                ReturnInvoiceItems::where('id', $remArr[$i])->delete();
                            }
                        }
                    }

                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($nameArr); $i++) {
                            if (!empty($nameArr[$i])) {
                                $cost['invoice_amount'] += $costArr[$i];
                                $cost['invoice_tax'] += $taxArr[$i];

                                if ($taxArr[$i] == '0') {
                                    $rateArr[$i] = 0;
                                } else {
                                    $rateArr[$i] = 0.18;
                                }

                                $items = array(
                                    'item_name' => $nameArr[$i],
                                    'quantity' =>   $qtyArr[$i],
                                    'tax_rate' =>  $rateArr[$i],
                                    'unit' => $unitArr[$i],
                                    'price' =>  $priceArr[$i],
                                    'total_cost' =>  $costArr[$i],
                                    'total_tax' =>   $taxArr[$i],
                                    'items_id' => $nameArr[$i],
                                    'order_no' => $i,
                                    'added_by' => auth()->user()->added_by,
                                    'return_id' => $return->id,
                                    'return_item' => $idArr[$i],
                                    'invoice_id' => $request->invoice_id
                                );

                                if (!empty($expArr[$i])) {
                                    ReturnInvoiceItems::where('id', $expArr[$i])->update($items);
                                } else {
                                    ReturnInvoiceItems::create($items);
                                }
                            }
                        }

                        $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
                        ReturnInvoiceItems::where('return_id', $return->id)->update($cost);
                    }

                    ReturnInvoice::find($return->id)->update($cost);

                    $rn = ReturnInvoice::find($return->id);
                    $crn = Invoice::where('id', $request->invoice_id)->first();
                    $nxt['invoice_amount'] = $crn->invoice_amount - $rn->invoice_amount;
                    $nxt['invoice_tax'] = $crn->invoice_tax - $rn->invoice_tax;
                    $nxt['due_amount'] = $crn->due_amount -   $rn->due_amount;
                    Invoice::where('id', $request->invoice_id)->update($nxt);

                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($nameArr); $i++) {
                            if (!empty($nameArr[$i])) {

                                $lists = array(
                                    'quantity' =>   $qtyArr[$i],
                                    'price' =>   $priceArr[$i],
                                    'item_id' => $nameArr[$i],
                                    'added_by' => auth()->user()->added_by,
                                    'client_id' =>   $data['client_id'],
                                    'location' =>   $invoice->location,
                                    'project_id' => $request->project_id,
                                    'return_date' =>  $data['return_date'],
                                    'invoice_date' =>  $data['return_date'],
                                    'return_id' =>  $return->id,
                                    'type' =>   'Credit Note',
                                    'invoice_id' => $request->invoice_id
                                );

                                InvoiceHistory::create($lists);

                                $inv_qty = Items::where('id', $nameArr[$i])->first();
                                $q = $inv_qty->quantity + $qtyArr[$i];
                                Items::where('id', $nameArr[$i])->update(['quantity' => $q]);

                                $loc = Location::where('id', $invoice->location)->first();
                                $lq['quantity'] = $loc->quantity + $qtyArr[$i];
                                Location::where('id', $invoice->location)->update($lq);

                                $due_qty = InvoiceItems::where('id', $idArr[$i])->first();
                                $prev['due_quantity'] = $due_qty->due_quantity - $qtyArr[$i];
                                $prev['total_tax'] = $due_qty->total_tax - $taxArr[$i];
                                $prev['total_cost'] = $due_qty->total_cost - $costArr[$i];
                                InvoiceItems::where('id', $idArr[$i])->update($prev);
                            }
                        }
                    }

                    $project = Project::find($request->project_id);
                    $inv = ReturnInvoice::find($request->id);
                    $sales = Invoice::find($inv->invoice_id);
                    $supp = Client::find($inv->client_id);

                    $cr = AccountCodes::where('account_name', 'Sales')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $cr->id;
                    $date = explode('-', $inv->return_date);
                    $journal->date =   $inv->return_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_credit_note';
                    $journal->name = 'Credit Note';
                    $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Return Sales for Invoice No " . $sales->reference_no . " by Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    if ($inv->invoice_tax > 0) {
                        $tax = AccountCodes::where('account_name', 'VAT OUT')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $tax->id;
                        $date = explode('-', $inv->return_date);
                        $journal->date =   $inv->return_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_credit_note';
                        $journal->name = 'Credit Note';
                        $journal->debit = $inv->invoice_tax *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->client_id = $inv->client_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Return Sales Tax for Invoice No " . $sales->reference_no . " by Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();
                    }

                    $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-', $inv->return_date);
                    $journal->date =   $inv->return_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_credit_note';
                    $journal->name = 'Credit Note';
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->credit = $inv->due_amount *  $inv->exchange_rate;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Return Receivables for Invoice No " . $sales->reference_no . " by Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    $stock = AccountCodes::where('account_name', 'Inventory')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id =  $stock->id;
                    $date = explode('-', $inv->return_date);
                    $journal->date =   $inv->return_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_credit_note';
                    $journal->name = 'Credit Note';
                    $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Return Stock  for Sales  Invoice No " . $sales->reference_no . " by Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();

                    $cos = AccountCodes::where('account_name', 'Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id =  $cos->id;
                    $date = explode('-', $inv->return_date);
                    $journal->date =   $inv->return_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_credit_note';
                    $journal->name = 'Credit Note';
                    $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->client_id = $inv->client_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Return Cost of Goods Sold  for Sales  Invoice No " . $sales->reference_no . " by Client " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();


                    if (!empty($return)) {
                        $project = Project::find($request->project_id);

                        $activity = Activity::create(
                            [
                                'added_by' => auth()->user()->id,
                                'module_id' => $return->id,
                                'project_id' => $request->project_id,
                                'module' => 'Credit Note',
                                'activity' => "Credit Note for Invoice with reference no  " .  $sales->reference_no . "  is Approved for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );


                        $pos_activity = POSActivity::create(
                            [
                                'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                                'module_id' => $return->id,
                                'module' => 'Credit Note',
                                'activity' => "Credit Note for Invoice with reference no  " .  $sales->reference_no . "  is Approved for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );
                    }
                } else {

                    $return = ReturnInvoice::find($request->id);

                    $invoice = Invoice::find($request->invoice_id);
                    $data['project_id'] = $request->project_id;
                    $data['client_id'] = $request->client_id;
                    $data['return_date'] = $request->return_date;
                    $data['due_date'] = $request->due_date;
                    $data['location'] = $invoice->location;
                    $data['exchange_code'] = $invoice->exchange_code;
                    $data['exchange_rate'] = $invoice->exchange_rate;
                    $data['invoice_amount'] = '1';
                    $data['due_amount'] = '1';
                    $data['invoice_tax'] = '1';

                    $data['added_by'] = auth()->user()->added_by;

                    $return->update($data);


                    $amountArr = str_replace(",", "", $request->amount);
                    $totalArr =  str_replace(",", "", $request->tax);

                    $nameArr = $request->items_id;
                    $qtyArr = $request->quantity;
                    $priceArr = $request->price;
                    $unitArr = $request->unit;
                    $costArr = str_replace(",", "", $request->total_cost);
                    $taxArr =  str_replace(",", "", $request->total_tax);
                    $idArr = $request->return_item;
                    $remArr = $request->removed_id;
                    $expArr = $request->item_id;


                    $cost['invoice_amount'] = 0;
                    $cost['invoice_tax'] = 0;


                    if (!empty($remArr)) {
                        for ($i = 0; $i < count($remArr); $i++) {
                            if (!empty($remArr[$i])) {
                                ReturnInvoiceItems::where('id', $remArr[$i])->delete();
                            }
                        }
                    }

                    if (!empty($nameArr)) {
                        for ($i = 0; $i < count($nameArr); $i++) {
                            if (!empty($nameArr[$i])) {
                                $cost['invoice_amount'] += $costArr[$i];
                                $cost['invoice_tax'] += $taxArr[$i];

                                if ($taxArr[$i] == '0') {
                                    $rateArr[$i] = 0;
                                } else {
                                    $rateArr[$i] = 0.18;
                                }

                                $items = array(
                                    'item_name' => $nameArr[$i],
                                    'quantity' =>   $qtyArr[$i],
                                    'tax_rate' =>  $rateArr[$i],
                                    'unit' => $unitArr[$i],
                                    'price' =>  $priceArr[$i],
                                    'total_cost' =>  $costArr[$i],
                                    'total_tax' =>   $taxArr[$i],
                                    'items_id' => $nameArr[$i],
                                    'order_no' => $i,
                                    'added_by' => auth()->user()->added_by,
                                    'return_id' => $return->id,
                                    'return_item' => $idArr[$i],
                                    'invoice_id' => $request->invoice_id
                                );

                                if (!empty($expArr[$i])) {
                                    ReturnInvoiceItems::where('id', $expArr[$i])->update($items);
                                } else {
                                    ReturnInvoiceItems::create($items);
                                }
                            }
                        }

                        $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
                        ReturnInvoiceItems::where('return_id', $return->id)->update($cost);
                    }

                    ReturnInvoice::find($return->id)->update($cost);




                    if (!empty($return)) {
                        $project = Project::find($request->project_id);

                        $activity = Activity::create(
                            [
                                'added_by' => auth()->user()->id,
                                'module_id' => $return->id,
                                'project_id' => $request->project_id,
                                'module' => 'Credit Note',
                                'activity' => "Credit Note for Invoice with reference no  " .  $invoice->reference_no . "  is Updated for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );


                        $pos_activity = POSActivity::create(
                            [
                                'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                                'module_id' => $return->id,
                                'module' => 'Credit Note',
                                'activity' => "Credit Note for Invoice with reference no  " .  $invoice->reference_no . "  is Updated for Project " .  $project->project_name . "-" . $project->project_no,
                            ]
                        );
                    }
                }

                return redirect(route('project.show', $request->project_id))->with(['success' => "Details Updated Successfully", 'type' => 'credit']);
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
                $id = $edit_data->project_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'project_id' => $id,
                            'module' => 'Comment',
                            'activity' => "Comment  Deleted",
                        ]
                    );
                }


                return redirect(route('project.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'comments']);

            case 'delete-attachment':


                $edit_data = Attachment::find($type_id);
                $id = $edit_data->project_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'project_id' => $id,
                            'module' => 'Attachment',
                            'activity' => "Attachment " .  $edit_data->title . " Deleted",
                        ]
                    );
                }


                return redirect(route('project.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'attachment']);

                break;

            case 'delete-meetings':


                $edit_data = Notes::find($type_id);
                $id = $edit_data->project_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'project_id' => $id,
                            'module' => 'Notes',
                            'activity' => "Notes Deleted",
                        ]
                    );
                }


                return redirect(route('project.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'notes']);

                break;

            case 'delete-milestone':


                $edit_data = Milestone::find($type_id);
                $id = $edit_data->project_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {

                    $project = Project::find($id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'project_id' => $id,
                            'module' => 'Milestone',
                            'activity' => "Milestone " .  $edit_data->name .  " Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );


                    $task_activity = TaskActivity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'module' => 'Milestone',
                            'activity' => "Milestone " .  $edit_data->name .  " Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }

                return redirect(route('project.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'milestone']);
                break;

            case 'delete-purchase':
                $edit_data = Purchase::find($type_id);
                $id = $edit_data->project_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                //PurchaseItems::where('purchase_id', $type_id)->delete();
                //$edit_data->delete();

                if (!empty($edit_data)) {
                    $project = Project::find($id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'project_id' => $id,
                            'module' => 'Purchase',
                            'activity' => "Purchase with reference no  " .  $edit_data->reference_no . "  is Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );


                    $pos_activity = POSActivity::create(
                        [
                            'added_by' => auth()->user()->added_by,
                            'user_id' => auth()->user()->id,
                            'module_id' => $type_id,
                            'module' => 'Purchase',
                            'activity' => "Purchase with reference no  " .  $edit_data->reference_no . "  is Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }


                return redirect(route('project.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'purchase']);
                break;

            case 'delete-debit':
                $edit_data = ReturnPurchases::find($type_id);
                $id = $edit_data->project_id;

                //$data['disabled'] = '1';        
                //$edit_data->update($data);

                ReturnPurchasesItems::where('return_id', $type_id)->delete();
                $edit_data->delete();

                if (!empty($edit_data)) {
                    $project = Project::find($id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'project_id' => $id,
                            'module' => 'Debit Note',
                            'activity' => "Return Purchases with reference no  " .  $edit_data->reference_no . "  is Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );


                    $pos_activity = POSActivity::create(
                        [
                            'added_by' => auth()->user()->added_by,
                            'user_id' => auth()->user()->id,
                            'module_id' => $type_id,
                            'module' => 'Debit Note',
                            'activity' => "Return Purchases with reference no  " .  $edit_data->reference_no . "  is Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }


                return redirect(route('project.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'debit']);
                break;


            case 'delete-tasks':


                $edit_data = Task::find($type_id);
                $id = $edit_data->project_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {

                    $project = Project::find($id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'project_id' => $id,
                            'module' => 'Tasks',
                            'activity' => "Task " .  $edit_data->task_name .  " Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );


                    $task_activity = TaskActivity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'module' => 'Task',
                            'activity' => "Task " .  $edit->task_name .  " Deleted",
                        ]
                    );
                }

                return redirect(route('project.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'tasks']);
                break;

            case 'delete-estimate':

                $edit_data = Invoice::find($type_id);
                $id = $edit_data->project_id;

                //$data['disabled'] = '1';        
                //$edit_data->update($data);
                InvoiceItems::where('invoice_id', $type_id)->delete();
                $edit_data->delete();

                if (!empty($edit_data)) {
                    $project = Project::find($id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'project_id' => $id,
                            'module' => 'Estimate',
                            'activity' => "Estimate with reference no  " .  $edit_data->reference_no . "  is Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );

                    $pos_activity = POSActivity::create(
                        [
                            'added_by' => auth()->user()->added_by,
                            'user_id' => auth()->user()->id,
                            'module_id' => $type_id,
                            'module' => 'Proforma Invoice',
                            'activity' => "Proforma Invoice with reference no  " .  $edit_data->reference_no . "  is Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }


                return redirect(route('project.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'estimate']);
                break;



            case 'delete-expenses':

                $edit_data = Expenses::find($type_id);
                $id = $edit_data->project_id;

                //$data['disabled'] = '1';        
                //$edit_data->update($data);


                $total_multiple = Expenses::find($edit_data->multiple_id);
                if (!empty($total_multiple)) {
                    $multiple = Expenses::where('multiple_id', $total_multiple->id)->sum('amount');
                    $m['amount'] = $multiple - $edit_data->amount;
                    $total_multiple->update($m);

                    if ($multiple - $edit_data->amount == '0') {
                        Expenses::destroy($edit_data->multiple_id);
                    }
                }

                Expenses::destroy($type_id);

                if (!empty($edit_data)) {

                    $project = Project::find($id);
                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'project_id' => $id,
                            'module' => 'Expenses',
                            'activity' => "Expenses with reference " .  $edit_data->name . "  is Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }


                return redirect(route('project.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'expenses']);
                break;


            case 'delete-invoice':
                $edit_data = Invoice::find($type_id);
                $id = $edit_data->project_id;

                //$data['disabled'] = '1';        
                //$edit_data->update($data);

                InvoiceItems::where('invoice_id', $type_id)->delete();
                $edit_data->delete();

                if (!empty($edit_data)) {
                    $project = Project::find($id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'project_id' => $id,
                            'module' => 'Invoice',
                            'activity' => "Invoice with reference no  " .  $edit_data->reference_no . "  is Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );


                    $pos_activity = POSActivity::create(
                        [
                            'added_by' => auth()->user()->added_by,
                            'user_id' => auth()->user()->id,
                            'module_id' => $type_id,
                            'module' => 'Invoice',
                            'activity' => "Invoice with reference no  " .  $edit_data->reference_no . "  is Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }


                return redirect(route('project.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'invoice']);
                break;

            case 'delete-credit':
                $edit_data = ReturnInvoice::find($type_id);
                $id = $edit_data->project_id;

                //$data['disabled'] = '1';        
                //$edit_data->update($data);

                ReturnInvoiceItems::where('return_id', $type_id)->delete();
                $edit_data->delete();

                if (!empty($edit_data)) {
                    $project = Project::find($id);

                    $activity = Activity::create(
                        [
                            'added_by' => auth()->user()->id,
                            'module_id' => $type_id,
                            'project_id' => $id,
                            'module' => 'Credit Note',
                            'activity' => "Return Invoice with reference no  " .  $edit_data->reference_no . "  is Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );


                    $pos_activity = POSActivity::create(
                        [
                            'added_by' => auth()->user()->added_by,
                            'user_id' => auth()->user()->id,
                            'module_id' => $type_id,
                            'module' => 'Credit Note',
                            'activity' => "Return Invoice with reference no  " .  $edit_data->reference_no . "  is Deleted for Project " .  $project->project_name . "-" . $project->project_no,
                        ]
                    );
                }


                return redirect(route('project.show', $id))->with(['success' => "Details Deleted Successfully", 'type' => 'credit']);
                break;

            default:
                return abort(404);
        }
    }


    public function multiple_approve(Request $request)
    {
        //
        $trans_id = $request->checked_trans_id;


        if (!empty($trans_id)) {
            for ($i = 0; $i < count($trans_id); $i++) {
                if (!empty($trans_id[$i])) {



                    $expenses = Expenses::find($trans_id[$i]);
                    $data['status'] = 1;
                    $expenses->update($data);

                    $project = Project::find($expenses->project_id);

                    $journal = new JournalEntry();
                    $journal->account_id =    $expenses->account_id;
                    $date = explode('-',  $expenses->date);
                    $journal->date = $expenses->date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'expense_payment';
                    $journal->name = 'Expense Payment';
                    $journal->payment_id =    $expenses->id;
                    $journal->project_id =    $expenses->project_id;
                    $journal->notes = 'Expense Payment with transaction id ' . $expenses->name . ' for Project ' .  $project->project_name . '-' . $project->project_no;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->debit =   $expenses->amount;
                    $journal->save();

                    $journal = new JournalEntry();
                    $journal->account_id = $expenses->bank_id;
                    $date = explode('-',  $expenses->date);
                    $journal->date = $expenses->date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'expense_payment';
                    $journal->name = 'Expense Payment';
                    $journal->credit =    $expenses->amount;
                    $journal->payment_id =    $expenses->id;
                    $journal->project_id =    $expenses->project_id;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Expense Payment with transaction id ' . $expenses->name . ' for Project ' .  $project->project_name . '-' . $project->project_no;
                    $journal->save();

                    $bank_accounts = AccountCodes::where('account_id', $expenses->bank_id)->first();
                    if ($bank_accounts->account_group == 'Cash and Cash Equivalent') {
                        $account = Accounts::where('account_id', $expenses->bank_id)->first();

                        if (!empty($account)) {
                            $balance = $account->balance -  $expenses->amount;
                            $item_to['balance'] = $balance;
                            $account->update($item_to);
                        } else {
                            $cr = AccountCodes::where('id', $expenses->bank_id)->first();

                            $new['account_id'] =  $expenses->bank_id;
                            $new['account_name'] = $cr->account_name;
                            $new['balance'] = 0 - $expenses->amount;
                            $new[' exchange_code'] = 'TZS';
                            $new['added_by'] = auth()->user()->added_by;
                            $balance = 0 - $expenses->amount;
                            Accounts::create($new);
                        }

                        // save into tbl_transaction

                        $transaction = Transaction::create([
                            'module' => 'Expenses',
                            'module_id' => $expenses->id,
                            'account_id' =>  $expenses->bank_id,
                            'code_id' =>  $expenses->account_id,
                            'name' => 'Expense Payment with reference' . $expenses->trans_id,
                            'transaction_prefix' =>  $expenses->name,
                            'type' => 'Expense',
                            'amount' => $expenses->amount,
                            'debit' =>  $expenses->amount,
                            'total_balance' => $balance,
                            'date' => date('Y-m-d', strtotime($expenses->date)),
                            'status' => 'paid',
                            'notes' => 'Expense Payment with transaction id ' . $expenses->name,
                            'added_by' => auth()->user()->added_by,
                        ]);
                    }

                    if (!empty($expenses)) {

                        $activity = Activity::create(
                            [
                                'added_by' => auth()->user()->id,
                                'module_id' => $expenses->id,
                                'project_id' => $expenses->project_id,
                                'module' => 'Expenses',
                                'activity' => 'Expense Payment with transaction id ' . $expenses->name . ' is  Approved for Project ' .  $project->project_name . '-' . $project->project_no,
                            ]
                        );
                    }
                }
            }
            return redirect(route('project.show', $expenses->project_id))->with(['success' => "Approved Successfully", 'type' => 'expenses']);
        } else {

            return redirect(route('project.show', $request->project_id))->with(['error' => 'You have not chosen an entry', 'type' => 'expenses']);
        }
    }



    public function file_preview(Request $request)
    {
        $id = $request->id;

        $data = Attachment::find($id);
        $filename =  $data->attachment;
        return view('project.file_preview', compact('filename'));
    }


    public function approve_purchase($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['status'] = 1;
        $purchase->update($data);

        if (!empty($purchase)) {
            $project = Project::find($purchase->project_id);

            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Purchase',
                    'project_id' => $purchase->project_id,
                    'activity' => "Purchase with reference no  " .  $purchase->reference_no . "  is approved for Project " .  $project->project_name . "-" . $project->project_no,
                ]
            );

            $pos_activity = POSActivity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Purchase',
                    'activity' => "Purchase with reference no  " .  $purchase->reference_no . "  is approved for Project " .  $project->project_name . "-" . $project->project_no,
                ]
            );
        }
        return redirect(route('project.show', $purchase->project_id))->with(['success' => "Approved Successfully", 'type' => 'purchase']);
    }

    public function grn(Request $request)
    {
        //
        $id = $request->purchase_id;
        $nameArr = $request->items_id;
        $priceArr = $request->price;
        $qtyArr = $request->quantity;
        $dateArr = $request->date;
        $savedArr = $request->items_id;

        $purchase = Purchase::find($id);
        $project = Project::find($purchase->project_id);

        if (!empty($nameArr)) {
            for ($i = 0; $i < count($nameArr); $i++) {
                if (!empty($nameArr[$i])) {

                    $saved = Items::find($savedArr[$i]);

                    $lists = array(
                        'quantity' =>   $qtyArr[$i],
                        'price' =>   $priceArr[$i],
                        'item_id' => $savedArr[$i],
                        'added_by' => auth()->user()->added_by,
                        'supplier_id' => $purchase->supplier_id,
                        'location' =>    $purchase->location,
                        'purchase_date' =>  $purchase->purchase_date,
                        'expire_date' =>  $dateArr[$i],
                        'type' =>   'Purchases',
                        'purchase_id' => $id
                    );

                    PurchaseHistory::create($lists);


                    $it = Items::where('id', $nameArr[$i])->first();
                    $q = $it->quantity + $qtyArr[$i];
                    Items::where('id', $nameArr[$i])->update(['quantity' => $q]);


                    $loc = Location::where('id', $purchase->location)->first();

                    $lq['quantity'] = $loc->quantity + $qtyArr[$i];

                    if ($saved->bar == '1') {
                        $lq['crate'] = $loc->crate + $qtyArr[$i];
                        $lq['bottle'] = $loc->bottle + ($qtyArr[$i] * $saved->bottle);
                    }
                    Location::where('id', $purchase->location)->update($lq);



                    $inv = Purchase::find($id);
                    $supp = Supplier::find($inv->supplier_id);


                    $itm = PurchaseItems::where('purchase_id', $id)->where('item_name', $savedArr[$i])->first();
                    $acc = Items::find($savedArr[$i]);


                    $tax = (($itm->price * $qtyArr[$i]) * $itm->tax_rate);
                    $cost = $itm->price * $qtyArr[$i];

                    $cr = AccountCodes::where('account_name', 'Purchases')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $cr->id;
                    $date = explode('-', $inv->purchase_date);
                    $journal->date =   $inv->purchase_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_purchase';
                    $journal->name = 'Purchases';
                    $journal->debit = $cost *  $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->supplier_id = $inv->supplier_id;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Purchase for Purchase Order " . $inv->reference_no . " by Supplier " . $supp->name;
                    $journal->save();

                    if ($tax > 0) {
                        $vat = AccountCodes::where('account_name', 'VAT IN')->where('added_by', auth()->user()->added_by)->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $vat->id;
                        $date = explode('-', $inv->purchase_date);
                        $journal->date =   $inv->purchase_date;
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_purchase';
                        $journal->name = 'Purchases';
                        $journal->debit = $tax *  $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->supplier_id = $inv->supplier_id;
                        $journal->project_id = $inv->project_id;
                        $journal->currency_code =  $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = "Purchase Tax for Purchase Order " . $inv->reference_no . " by Supplier " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                        $journal->save();
                    }

                    $codes = AccountCodes::where('account_name', 'Payables')->where('added_by', auth()->user()->added_by)->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-', $inv->purchase_date);
                    $journal->date =   $inv->purchase_date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_purchase';
                    $journal->name = 'Purchases';
                    $journal->income_id = $inv->id;
                    $journal->supplier_id = $inv->supplier_id;
                    $journal->credit = ($cost + $tax) *  $inv->exchange_rate;
                    $journal->project_id = $inv->project_id;
                    $journal->currency_code =  $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = "Credit for Purchase Order " . $inv->reference_no . " by Supplier " . $supp->name . "  for Project " .  $project->project_name . "-" . $project->project_no;
                    $journal->save();
                }
            }

            if (!empty($purchase)) {
                $user = User::find(auth()->user()->id);


                $activity = Activity::create(
                    [
                        'added_by' => auth()->user()->id,
                        'module_id' => $id,
                        'project_id' => $inv->project_id,
                        'module' => 'Purchase',
                        'activity' => "Good Receive for Purchase with reference no  " .  $purchase->reference_no . " for Project " .  $project->project_name . "-" . $project->project_no,
                    ]
                );

                $pos_activity = POSActivity::create(
                    [
                        'added_by' => auth()->user()->added_by,
                        'user_id' => auth()->user()->id,
                        'module_id' => $id,
                        'module' => 'Purchase',
                        'activity' => "Good Receive for Purchase with reference no  " .  $purchase->reference_no . " for Project " .  $project->project_name . "-" . $project->project_no,
                    ]
                );
            }


            return redirect(route('project.show', $inv->project_id))->with(['success' => "Good Receive Done Successfully", 'type' => 'purchase']);
        } else {
            return redirect(route('project.show', $purchase->project_id))->with(['error' => 'No data found']);
        }
    }


    public function issue($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['good_receive'] = 1;
        $purchase->update($data);
        $project = Project::find($purchase->project_id);

        if (!empty($purchase)) {
            $user = User::find(auth()->user()->id);


            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->id,
                    'module_id' => $id,
                    'project_id' => $purchase->project_id,
                    'module' => 'Purchase',
                    'activity' => "Purchase with reference no  " .  $purchase->reference_no . " has been issued for Project " .  $project->project_name . "-" . $project->project_no,
                ]
            );

            $pos_activity = POSActivity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Purchase',
                    'activity' => "Purchase with reference no  " .  $purchase->reference_no . " has been issued for Project " .  $project->project_name . "-" . $project->project_no,
                ]
            );
        }


        return redirect(route('project.show', $purchase->project_id))->with(['success' => "Issued Successfully", 'type' => 'purchase']);
    }


    public function convert_to_invoice($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['invoice_status'] = 1;
        $invoice->update($data);


        if (!empty($invoice)) {

            $project = Project::find($invoice->project_id);

            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Estimate',
                    'project_id' => $invoice->project_id,
                    'activity' => "Estimate with reference no  " .  $invoice->reference_no . "  is  converted to Invoice for Project " .  $project->project_name . "-" . $project->project_no,
                ]
            );

            $pos_activity = POSActivity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Proforma Invoice',
                    'activity' => "Proforma Invoice with reference no  " .  $invoice->reference_no . "  is converted to Invoice for Project " .  $project->project_name . "-" . $project->project_no,
                ]
            );
        }
        return redirect(route('project.show', $invoice->project_id))->with(['success' => "Converted  Successfully", 'type' => 'invoice']);
    }

    public function findInvoice(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        if ($type == 'view') {
            $expense = Expenses::where('multiple_id', $id)->get();
            $main = Expenses::find($id);
            return view('project.list', compact('expense', 'id', 'main'));
        }
    }



   public function profit_report(Request $request)
   {

       $start = $request->start_date;
       $end = $request->end_date;
       $name = $request->name;


       $list = Project::all()->where('added_by', auth()->user()->added_by)->where('disabled', '0');
       $codes = AccountCodes::where('account_name', 'Receivable and Prepayments')->where('added_by', auth()->user()->added_by)->first();
       $payable = AccountCodes::where('account_name', 'Payables')->where('added_by', auth()->user()->added_by)->first();
       $pdisc = AccountCodes::where('account_name', 'Purchase Discount')->where('added_by', auth()->user()->added_by)->first();
       $sdisc = AccountCodes::where('account_name', 'Sales Discount')->where('added_by', auth()->user()->added_by)->first();

       if ($request->isMethod('post')) {

           $purchase = JournalEntry::where('project_id', $name)->where('transaction_type', 'pos_purchase')->where('account_id', $payable->id)->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('credit');
           $pdiscount = JournalEntry::where('project_id', $name)->where('transaction_type', 'pos_purchase')->where('account_id', $pdisc->id)->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('debit');
           $debit = JournalEntry::where('project_id', $name)->where('transaction_type', 'pos_debit_note')->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('debit');
           $invoice = JournalEntry::where('project_id', $name)->where('transaction_type', 'pos_invoice')->where('account_id', $codes->id)->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('debit');
           $sdiscount = JournalEntry::where('project_id', $name)->where('transaction_type', 'pos_invoice')->where('account_id', $sdisc->id)->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('credit');
           $credit = JournalEntry::where('project_id', $name)->where('transaction_type', 'pos_credit_note')->where('account_id', $codes->id)->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('credit');
           $expense = JournalEntry::where('project_id', $name)->where('transaction_type', 'expense_payment')->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('debit');
       } else {

           $purchase = '';
           $debit = '';
           $pdiscount = '';
           $invoice = '';
           $sdiscount = '';
           $credit = '';
           $expense = '';
       }


       if ($request->type == 'print_pdf') {
           $purchase = JournalEntry::where('project_id', $name)->where('transaction_type', 'pos_purchase')->where('account_id', $payable->id)->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('credit');
           $pdiscount = JournalEntry::where('project_id', $name)->where('transaction_type', 'pos_purchase')->where('account_id', $pdisc->id)->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('debit');
           $debit = JournalEntry::where('project_id', $name)->where('transaction_type', 'pos_debit_note')->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('debit');
           $invoice = JournalEntry::where('project_id', $name)->where('transaction_type', 'pos_invoice')->where('account_id', $codes->id)->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('debit');
           $sdiscount = JournalEntry::where('project_id', $name)->where('transaction_type', 'pos_invoice')->where('account_id', $sdisc->id)->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('credit');
           $credit = JournalEntry::where('project_id', $name)->where('transaction_type', 'pos_credit_note')->where('account_id', $codes->id)->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('credit');
           $expense = JournalEntry::where('project_id', $name)->where('transaction_type', 'expense_payment')->whereBetween('date', [$start, $end])->where('added_by', auth()->user()->added_by)->sum('debit');

           $pdf = PDF::loadView(
               'project.report.profit_report_pdf',
               compact('start', 'end', 'name', 'list', 'purchase', 'debit', 'invoice', 'credit', 'expense', 'pdiscount', 'sdiscount')
           )->setPaper('a4', 'potrait');

           $client = Project::where('id', $name)->first();
           $st_name = strtoupper($client->project_name);
           $s =  date('d-m-Y', strtotime($start));
           $e =  date('d-m-Y', strtotime($end));
           return $pdf->download($st_name  . '-' . $client->project_no . ' PROFIT REPORT  FOR THE PERIOD ' . $s . ' to ' . $e . ".pdf");
       } else {
           return view(
               'project.report.profit_report',
               compact('start', 'end', 'name', 'list', 'purchase', 'debit', 'invoice', 'credit', 'expense', 'pdiscount', 'sdiscount')
           );
       }
   }


//    public function profit_report(Request $request)
// {
//     $start = $request->start_date;
//     $end = $request->end_date;
//     $name = $request->name;

//     $list = Project::all()->where('added_by', auth()->user()->added_by)->where('disabled', '0');
//     $codes = AccountCodes::where('account_group', 'Receivables')->where('added_by', auth()->user()->added_by)->first();
//     $payable = AccountCodes::where('account_name', 'Payables')->where('added_by', auth()->user()->added_by)->first();
//     $pdisc = AccountCodes::where('account_name', 'Purchase Discount')->where('added_by', auth()->user()->added_by)->first();
//     $sdisc = AccountCodes::where('account_name', 'Sales Discount')->where('added_by', auth()->user()->added_by)->first();

//     if (!$codes || !$payable || !$pdisc || !$sdisc) {
//         return redirect()->back()->with('error', 'Required account codes (Receivables, Payables, Purchase Discount, or Sales Discount) are not configured.');
//     }

//     if ($request->isMethod('post') || $request->type == 'print_pdf') {
//         $purchase = JournalEntry::where('project_id', $name)
//             ->where('transaction_type', 'pos_purchase')
//             ->where('account_id', $payable->id)
//             ->whereBetween('date', [$start, $end])
//             ->where('added_by', auth()->user()->added_by)
//             ->sum('credit');

//         $pdiscount = JournalEntry::where('project_id', $name)
//             ->where('transaction_type', 'pos_purchase')
//             ->where('account_id', $pdisc->id)
//             ->whereBetween('date', [$start, $end])
//             ->where('added_by', auth()->user()->added_by)
//             ->sum('debit');

//         $debit = JournalEntry::where('project_id', $name)
//             ->where('transaction_type', 'pos_debit_note')
//             ->whereBetween('date', [$start, $end])
//             ->where('added_by', auth()->user()->added_by)
//             ->sum('debit');

//         $invoice = JournalEntry::where('project_id', $name)
//             ->where('transaction_type', 'pos_invoice')
//             ->where('account_id', $codes->id)
//             ->whereBetween('date', [$start, $end])
//             ->where('added_by', auth()->user()->added_by)
//             ->sum('debit');

//         $sdiscount = JournalEntry::where('project_id', $name)
//             ->where('transaction_type', 'pos_invoice')
//             ->where('account_id', $sdisc->id)
//             ->whereBetween('date', [$start, $end])
//             ->where('added_by', auth()->user()->added_by)
//             ->sum('credit');

//         $credit = JournalEntry::where('project_id', $name)
//             ->where('transaction_type', 'pos_credit_note')
//             ->where('account_id', $codes->id)
//             ->whereBetween('date', [$start, $end])
//             ->where('added_by', auth()->user()->added_by)
//             ->sum('credit');

//         $expense = JournalEntry::where('project_id', $name)
//             ->where('transaction_type', 'expense_payment')
//             ->whereBetween('date', [$start, $end])
//             ->where('added_by', auth()->user()->added_by)
//             ->sum('debit');
//     } else {
//         $purchase = $debit = $pdiscount = $invoice = $sdiscount = $credit = $expense = '';
//     }

//     if ($request->type == 'print_pdf') {
//         $pdf = PDF::loadView(
//             'project.report.profit_report_pdf',
//             compact('start', 'end', 'name', 'list', 'purchase', 'debit', 'invoice', 'credit', 'expense', 'pdiscount', 'sdiscount')
//         )->setPaper('a4', 'portrait'); 

//         $client = Project::where('id', $name)->first();
//         if (!$client) {
//             return redirect()->back()->with('error', 'Selected project not found.');
//         }
//         $st_name = strtoupper($client->project_name);
//         $s = date('d-m-Y', strtotime($start));
//         $e = date('d-m-Y', strtotime($end));
//         return $pdf->download($st_name . '-' . $client->project_no . ' PROFIT REPORT FOR THE PERIOD ' . $s . ' to ' . $e . '.pdf');
//     } else {
//         return view(
//             'project.report.profit_report',
//             compact('start', 'end', 'name', 'list', 'purchase', 'debit', 'invoice', 'credit', 'expense', 'pdiscount', 'sdiscount')
//         );
//     }
// }


    public function profit_report_excel($name, $start, $end)
    {

        $client = Project::where('id', $name)->first();
        $st_name = strtoupper($client->project_name);
        $s =  date('d-m-Y', strtotime($start));
        $e =  date('d-m-Y', strtotime($end));

        return Excel::download(new ExportProfitReport($name, $start, $end), $st_name  . '-' . $client->project_no . ' PROFIT REPORT  FOR THE PERIOD ' . $s . ' to ' . $e . ".xls");
    }
}