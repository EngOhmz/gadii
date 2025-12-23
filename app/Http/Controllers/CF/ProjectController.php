<?php

namespace App\Http\Controllers\CF;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CF\Project;
use App\Models\Client;
use App\Models\Country;
use App\Models\Departments;
use App\Models\CF\Category;
use App\Models\CF\Assignment;
use App\Models\CF\Billing_Type;
use App\Models\CF\Activity;
use App\Models\CF\Cargo;
use App\Models\CF\CargoType;

use App\Models\CF\CargoActivity;

use App\Models\CF\CFservice;
use App\Models\CF\Storage;
use App\Models\CF\Charge;
use App\Models\CF\Comment;
use App\Models\CF\Attachment;
use App\Models\CF\Notes;
use App\Models\CF\Milestone;
use App\Models\CF\MilestoneActivity;
use App\Models\CF\TaskCategory;
use App\Models\CF\TaskActivity;
use App\Models\CF\Task;
use App\Models\Currency;
use App\Models\POS\Items;
use App\Models\POS\Purchase;
use App\Models\POS\PurchaseItems;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\PurchasePayments;
use App\Models\POS\ReturnPurchases;
use App\Models\POS\ReturnPurchasesItems;
use App\Models\Supplier;
use App\Models\Route;
use App\Models\POS\Activity as POSActivity;
use App\Models\CF\InvoiceHistory;
use App\Models\CF\InvoicePayments;
use App\Models\CF\Invoice;
use App\Models\CF\InvoiceItems;
use App\Models\POS\ReturnInvoice;
use App\Models\POS\ReturnInvoiceItems;
use App\Models\Location;
use App\Models\Branch;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Payment_methodes;
use App\Models\Expenses;
use App\Models\User;
use App\Models\Project\TaskAssignment;
use App\Models\CF\StockMovement;
use App\Models\CF\StockMovementItem;
use App\Models\Pacel\Pacel;
use App\Models\Pacel\PacelItem;
use App\Models\Pacel\PacelList;
use App\Models\Pacel\PacelPayment;
use App\Models\Pacel\PacelInvoice;
use App\Models\Pacel\PacelInvoiceItem;
use Session;
use PDF;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function index()
    {
        $project = Project::all()
            ->where('added_by', auth()->user()->added_by)
            ->where('disabled', '0');

        $client = Departments::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);

        $category = Category::all()->where('added_by', auth()->user()->added_by);
        $billing_type = Billing_Type::all()->where('added_by', auth()->user()->added_by);
        $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        $clientspj =Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();
        $count = Project::where('added_by', auth()->user()->added_by)->count();
        $pro = $count + 1;
        $reference = '00' . $pro;
        return view('cf.index', compact('project', 'category', 'billing_type', 'client', 'user', 'reference', 'clientspj'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        $trans_id = $request->trans_id;

        $data['added_by'] = auth()->user()->added_by;
        
        $data['assigned_to'] = implode(',', $trans_id);

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
            $activity = Activity::create([
                'added_by' => auth()->user()->id,
                'module_id' => $project->id,
                'project_id' => $project->id,
                'module' => 'Project',
                'activity' => 'Project '.$project->project_name . '-' . $project->reff_no . 'Created',
            ]);
        }

        return redirect(route('cf.index'))->with(['success' => 'Project Created Successfully']);
    }
    public function edit($id)
    {
        //
        $data = Project::find($id);

        $category = Category::all()->where('added_by', auth()->user()->added_by);
        $billing_type = Billing_Type::all()->where('added_by', auth()->user()->added_by);
        
        $client = Departments::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
        $user  =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        $clientspj =Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();

        return view('cf.index', compact('data', 'category', 'billing_type', 'client', 'id', 'user', 'clientspj'));
    }
    
    
   

    public function show($id)
    {
        //
        $data = Project::find($id);

        $type = Session::get('type');

        if (empty($type)) {
            $type = 'details';
        } else {
            $type = Session::get('type');
        }

        $ca = Session::get('a');

        if (!empty($ca)) {
            $tbl_ctype = CargoType::find($ca);
        } else {
            $tbl_ctype = '';
        }
        //dd($tbl_ctype );

        $cargoActivity = CargoActivity::where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->get();

        $selectedCargoActivity = null;
            if ($type == 'edit-cargoActivity') {
                $type_id = request('type_id'); // Assuming type_id is passed in the URL
                $selectedCargoActivity = CargoActivity::find($type_id);
            }


        $comment_details = Comment::where('project_id', $id)
            ->where('disabled', '0')
            ->where('comments_reply_id', '0')
            ->orderBy('comment_datetime', 'DESC')
            ->get();
        $attach = Attachment::where('project_id', $id)
            ->where('disabled', '0')
            ->get();
        $notes = Notes::where('project_id', $id)
            ->where('disabled', '0')
            ->get();
        $activity = Activity::where('project_id', $id)->get();
        $task = Task::all()
            ->where('added_by', auth()->user()->added_by)
            ->where('project_id', $id)
            ->where('disabled', '0');
        $mile = Milestone::all()
            ->where('project_id', $id)
            ->where('disabled', '0')
            ->where('added_by', auth()->user()->added_by);
        $inv = Invoice::all()
            ->where('invoice_status', 1)
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by);
        $pur = Purchase::all()
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by);
        $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);

        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $users  =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        $Cargo = Cargo::all()->where('added_by', auth()->user()->added_by);
        $charge = Charge::where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->get();
        $storage = Storage::where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->where('status',Null)
            ->get();
        $CargoType = CargoType::all()
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by);
            
        $CFservice = CFservice::all()->where('added_by', auth()->user()->added_by);
        
        $route = Route::where('added_by', auth()->user()->added_by)->get();
        $country = Country::all();
        $pro_det = Project::find($id);
        $logistic = Pacel::where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->get();

        $dn = ReturnPurchases::all()
            ->where('project_id', $id)
            ->where('added_by', auth()->user()->added_by);

        $prof = Invoice::all()
            ->where('invoice_status', 0)
            ->where('project_id', $id)
            ->where('added_by', auth()->user()->added_by);
        $invoices = Invoice::where('added_by', auth()->user()->added_by)
                    ->where('cf_id', $id)
                    ->where('type', 'Invoice')
                    ->where('quotation', '0')
                    ->get();
                    
        $custom = Invoice::where('added_by', auth()->user()->added_by)
                    ->where('cf_id', $id)
                    ->where('type', 'Customer')
                    ->where('quotation', '0')
                    ->get(); 
        $quot = Invoice::where('added_by', auth()->user()->added_by)
                    ->where('cf_id', $id)
                    ->where('type', 'Invoice')
                    ->where('quotation', '1')
                    ->get();
        $crd = ReturnInvoice::all()
            ->where('project_id', $id)
            ->where('added_by', auth()->user()->added_by);
        $name = CFService::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
        $location = Location::where('added_by', auth()->user()->added_by)->get();
        $currency = Currency::all();
        $client = Client::where('user_id', auth()->user()->added_by)->get();
        $supplier = Supplier::where('user_id', auth()->user()->added_by)->where('disabled', '0')->get();
        $exp = Expenses::where('multiple', '0')
            ->where('added_by', auth()->user()->added_by)
            ->where('cf_id', $id)
            ->orderBy('date', 'DESC')
            ->get();
        $bank_accounts = AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        
        $chart_of_accounts = AccountCodes::all()->whereIn('account_type', ['Expense','Liability'])->whereNotIn('account_name', ['Deffered Tax','Value Added Tax (VAT)'])->where('disabled','0')
        ->where('added_by',auth()->user()->added_by)->groupBy('account_type');;

        $fixed = Invoice::where('good_receive', 1)
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));
        $total_exp = Expenses::where('multiple', '0')
            ->where('added_by', auth()->user()->added_by)
            ->where('project_id', $id)
            ->sum('amount');

        $ccount = Comment::where('project_id', $id)
            ->where('disabled', '0')
            ->where('comments_reply_id', '0')
            ->count();
        $attcount = Attachment::where('project_id', $id)
            ->where('disabled', '0')
            ->count();
        $ncount = Notes::where('project_id', $id)
            ->where('disabled', '0')
            ->count();
        $actcount = Activity::where('project_id', $id)->count();
        $storecount = Storage::where('cf_id', $id)->count();
        $tcount = Task::where('added_by', auth()->user()->added_by)
            ->where('project_id', $id)
            ->where('disabled', '0')
            ->count();
        $mcount = Milestone::all()
            ->where('project_id', $id)
            ->where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $pcount = Invoice::all()
            ->where('invoice_status', 0)
            ->where('project_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $invcount = Invoice::where('added_by', auth()->user()->added_by)
                    ->where('cf_id', $id)
                    ->where('type', 'Invoice')
                    ->where('quotation', '0')
                    ->count();
         $logcount = Invoice::where('added_by', auth()->user()->added_by)
                    ->where('cf_id', $id)
                    ->where('type', 'Customer')
                    ->where('quotation', '0')->
                    count();  
        $qcount = Invoice::where('added_by', auth()->user()->added_by)
                    ->where('cf_id', $id)
                    ->where('type', 'Invoice')
                    ->where('quotation', '1')
                    ->count();
        $crdcount = ReturnInvoice::all()
            ->where('project_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $expcount = Expenses::where('multiple', '0')
            ->where('added_by', auth()->user()->added_by)
            ->where('cf_id', $id)
            ->count();
        $purcount = Purchase::all()
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $chargecount = Charge::all()
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $ctypecount = CargoType::all()
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $cargoActivitycount = CargoActivity::all()
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $dncount = ReturnPurchases::all()
            ->where('project_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
         $issue= StockMovement::where('added_by',auth()->user()->added_by)->where('cf_id',$id)->get();;
         $inventory= Items::whereIn('type', [1,2,3])->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         $staff=User::where('added_by',auth()->user()->added_by)->get();
         $location=Location::where('added_by',auth()->user()->added_by)->get();;

        return view('cf.project_details', compact('data', 'id', 'type', 'comment_details', 'attach', 'notes', 'activity', 'task', 'categories', 'mile', 'users', 'name', 'currency', 'invoices', 'location', 'prof', 
        'chart_of_accounts', 'bank_accounts', 'exp', 'client', 'crd', 'fixed', 'total_exp', 'ccount', 'attcount', 'ncount', 'actcount', 'tcount', 'mcount', 'pcount', 'invcount', 'crdcount', 'expcount', 'pur','logcount', 
        'dn', 'purcount', 'dncount', 'supplier', 'Cargo', 'route', 'CargoType', 'ctypecount', 'cargoActivitycount', 'storage', 'storecount', 'CFservice', 'chargecount', 'charge', 'tbl_ctype', 'pro_det', 'custom',
        'logistic', 'country','inventory','staff','location','issue','bank_accounts','branch','quot','qcount', 'cargoActivity', 'selectedCargoActivity' ));
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        $trans_id = $request->trans_id;

        $data = $request->all();
        //dd($data);
        $data['added_by'] = auth()->user()->added_by;
        $data['assigned_to'] = implode(',', $trans_id);
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
            $activity = Activity::create([
                'added_by' => auth()->user()->id,
                'module_id' => $id,
                'project_id' => $id,
                'module' => 'Project',
                'activity' => 'Project ' . $project->project_name . '-' . $project->reff_no . 'Updated',
            ]);
        }

        return redirect(route('cf.index'))->with(['success' => 'Project updated Successfully']);
    }

    public function destroy($id)
    {
        $project = Project::find($id);

        if (!empty($project)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->id,
                'module_id' => $project->id,
                'project_id' => $project->id,
                'module' => 'Project',
                'activity' => 'Project ' . $project->project_name . '-' . $project->reff_no . 'Deleted',
            ]);
        }

        $project->update(['disabled' => '1']);

        return redirect(route('cf.index'))->with(['success' => 'Project Deleted Sussessfully']);
    }

    public function change_status($id, $status)
    {
        $project = Project::find($id);

        if (!empty($project)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->id,
                'module_id' => $project->id,
                'project_id' => $project->id,
                'module' => 'Project',
                'activity' => 'Project ' . $project->project_name . '-' . $project->reff_no . 'Status has been Changed from ' . $project->status . ' to ' . $status,
            ]);
        }

        $project->update(['status' => $status]);

        return redirect()->back()->with(['success' => 'Status Changed Successfully']);
    }

    public function discountModal(Request $request)
    {
        
        //dd($request->all());
         $id = $request->id;
         
         if(!empty($request->modal_type)){
            $type = $request->modal_type; 
         }
         else{
        $type = $request->type;
         }
         
          
        if ($type == 'assign') {
            $user = User::where('added_by', auth()->user()->added_by)->get();
            $data = Project::find($id);
            return view('cf.assign_user', compact('id', 'user', 'data'));
        } elseif ($type == 'view') {
            $user = Assignment::where('project_id', $id)->get();
            $data = Project::find($id);
            return view('cf.view_user', compact('id', 'user', 'data'));
            
        } elseif ($type == 'cargotype') {
            $cargotype = CargoType::find($id);
            $data = Project::find($cargotype->cf_id);
            return view('cf.cargo_id', compact('id', 'cargotype', 'data'));

        } elseif ($type == 'cargoActivity') {
            $cargoactivity = CargoActivity::find($id);
            $data = Project::find($cargoactivity->cf_id);
            return view('cf.cargo_activity', compact('id', 'cargoActivity', 'data'));
            
        } elseif ($type == 'show_warehouse') {
            
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)
                    ->where('account_group', 'Cash and Cash Equivalent')
                    ->where('added_by', auth()->user()->added_by)
                    ->get();
                    
                 $issue= StockMovement::where('added_by',auth()->user()->added_by)->where('cf_id',$id)->get();;
                 $inventory= Items::whereIn('type', [1,2,3])->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
                 $staff=User::where('added_by',auth()->user()->added_by)->get();
                 $location=Location::where('added_by',auth()->user()->added_by)->get();;
                 
                 $storage = Storage::find($id);
                 $stock = StockMovement::where('storage_id',$id)->first();;
              
                 
            return view('cf.show_warehouse', compact('id','bank_accounts','location','inventory','staff','storage','stock'));
            
            
        } elseif ($type == 'category') {
            return view('cf.category', compact('id'));
            
        } elseif ($type == 'expenses') {
            $expense = Expenses::where('multiple_id', $id)->get();
            $main = Expenses::where('id', $id)->first();
             $con = Expenses::where('multiple_id',$id)->count() ;
            $st = Expenses::where('multiple_id',$id)->where('status','1')->count() ;
            return view('cf.list', compact('expense', 'id', 'main','con','st'));
        }
        
        elseif ($type == 'client') {
          return view('pos.sales.client_modal');
            
        }
        elseif ($type == 'department') {
          return view('manage.department.department_modal');
            
        }
        
        else if($type == 'view-attachment'){
                    
      $data = Attachment::find($id);
      $filename =  $data->attachment;
                return view('cf.file_preview',compact('filename'));
  }
  
  else if($type == 'invoice'){
                    
       $invoices = Invoice::find($id);
        $invoice_items=InvoiceItems::where('invoice_id',$id)->where('due_quantity','>', '0')->get();
        $payments=InvoicePayments::where('invoice_id',$id)->get();
     
        $deposits = [];
        
        return view('cf.sales.invoice_details',compact('invoices','invoice_items','payments','deposits'));
  }
  
   else if($type == 'invoice_payment'){
                    
       $invoice = Invoice::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        return view('cf.sales.invoice_payments',compact('invoice','payment_method','bank_accounts'));
  }
  
  else if($type == 'edit'){
                    
        $item = CFService::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
                  $name=$request->item_name[0];
                  $desc=$request->description[0];
                  $qty=$request->quantity[0];
                  $price=str_replace(",","",$request->price[0]);
                  $cost=$request->total_cost[0];
                  $tax=$request->total_tax[0];
                  $unit=$request->unit[0];
                  $rate=$request->tax_rate[0];
                  $order=$request->no[0];
                  if(!empty($request->saved_items_id[0])){
                  $saved=$request->saved_items_id[0];
                  }
                  else{
                   $saved='';   
                  }
                return view('cf.sales.edit_modal', compact('item','name','desc','qty','price','cost','tax','unit','rate','order','type','saved'));
  }
  
  else{
      
  }
  
  
    }
  
    
        public function stockModal(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $storage_id = $request->storage_id;

        if($type == 'stock_movement') {
            
                $bank_accounts = AccountCodes::where('added_by', auth()->user()->added_by)
                    ->where('account_group', 'Cash and Cash Equivalent')
                    ->where('added_by', auth()->user()->added_by)
                    ->get();
                 $issue= StockMovement::where('added_by',auth()->user()->added_by)->where('cf_id',$id)->get();;
                 $inventory= Items::whereIn('type', [1,2,3])->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
                 $staff=User::where('added_by',auth()->user()->added_by)->get();
                 $location=Location::where('added_by',auth()->user()->added_by)->get();
                    
             $data = Project::find($id);
            return view('cf.show_stockMovement', compact('id','data','bank_accounts','location','inventory','staff','storage_id'));
            
        } 
    }
    
    public function saveCategory(Request $request)
    {
        $data['category_name'] = $request['category_name'];
        $data['added_by'] = auth()->user()->added_by;

        $project = Category::create($data);

        if (!empty($project)) {
            return response()->json($project);
        }
    }

    public function assign_user(Request $request)
    {
        //
        $trans_id = $request->trans_id;

        if (!empty($trans_id)) {
            $project = Project::find($request->project_id);
            $d = implode(',', $trans_id);

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
            return redirect(route('cf.index'))->with(['success' => 'Assignment Successfully']);
        } else {
            return redirect(route('cf.index'))->with(['error' => 'You have not chosen an entry']);
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
                        'project_id' => $request->project_id,
                        'module' => 'Comment',
                        'activity' => 'Comment Created',
                    ]);
                }

                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Created Successfully', 'type' => 'comments']);

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
                        'project_id' => $request->project_id,
                        'module' => 'Comment',
                        'activity' => 'Reply on Comment Created',
                    ]);
                }

                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Created Successfully', 'type' => 'comments']);

                break;

            case 'attachment':
                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                if ($request->hasFile('attachment')) {
                    $filenameWithExt = $request->file('attachment')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('attachment')->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $path = public_path('/cf');
                    $request->file('attachment')->move($path, $fileNameToStore);
                } else {
                    $fileNameToStore = '';
                }

                $data['attachment'] = $fileNameToStore;
                $meet = Attachment::create($data);

                if (!empty($meet)) {
                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $meet->id,
                        'project_id' => $request->project_id,
                        'module' => 'Attachment',
                        'activity' => 'Attachment ' . $meet->title . ' Created',
                    ]);
                }

                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Created Successfully', 'type' => 'attachment']);
                break;

            case 'milestone':
                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                $milestone = Milestone::create($data);

                if (!empty($milestone)) {
                    $project = Project::find($request->project_id);


                    $milestone_activity = MilestoneActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $milestone->id,
                        'module' => 'Milestone',
                        'activity' => 'Milestone ' . $milestone->name . ' Created for CF File ' . $project->project_name . '-' . $project->reff_no,
                    ]);
                }

                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Created Successfully', 'type' => 'milestone']);
                break;

            case 'notes':
                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                $note = Notes::create($data);

                if (!empty($note)) {
                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $note->id,
                        'project_id' => $request->project_id,
                        'module' => 'Notes',
                        'activity' => 'Notes  Created',
                    ]);
                }

                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Created Successfully', 'type' => 'notes']);
                break;

            case 'cargoType':
                $data = $request->all();
                //dd($data);
                $data['added_by'] = auth()->user()->added_by;
                $data['cf_id'] = $request->project_id;
                $ctype = CargoType::create($data);

                if (!empty($ctype)) {
                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $ctype->id,
                        'project_id' => $request->project_id,
                        'module' => 'Cargo Type',
                        'activity' => 'Cargo Type Created',
                    ]);
                }

                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Created Successfully', 'type' => 'cargo']);
                break;
                
                
            case 'cargoActivity':
                $cargoActivity = CargoActivity::create([
                    'name_id' => $request->name_id,
                    'activity' => $request->activity,
                    'activity_date' => $request->activity_date,
                    'notes' => $request->notes,
                    'cf_id' => $request->cf_id,
                    'added_by' => auth()->user()->added_by,
                ]);

                if (!empty($cargoActivity)) {
                    return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Created Successfully', 'type' => 'cargoActivity']);
                } else {
                    return redirect(route('cf.show', $request->project_id))->with(['error' => 'Failed to create Cargo Activity', 'type' => 'cargoActivity']);
                }
                break;
                           

            case 'tasks':
                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['goal_tracking_id'] = 'Projects';

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
                    $project = Project::find($request->project_id);

                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $task->id,
                        'project_id' => $request->project_id,
                        'module' => 'Tasks',
                        'activity' => 'Task ' . $task->task_name . ' Created for CF File ' . $project->project_name . '-' . $project->reff_no,
                    ]);

                    $task_activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $task->id,
                        'module' => 'Task',
                        'activity' => 'Task ' . $task->task_name . ' Created',
                    ]);
                }

                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Created Successfully', 'type' => 'tasks']);
                break;

            case 'quotation':
                
                 $project=Project::find($request->project_id) ;  
            
                if($project->related == 'Clients'){
                    $client=$project->client_id;
                     $supp=Client::find($client);
                }
                else{
                   $client=$project->department_id;
                   $supp=Departments::find($client);
                }
            
                $count = Invoice::where('added_by', auth()->user()->added_by)->where('type', 'Invoice')->where('quotation', '1')->count();
                $pro = $count + 1;
                $data['reference_no']= "CFQ0".$pro;
                $data['related']=$project->related;
                $data['client_id']=$client;
                $data['invoice_date'] = $request->invoice_date;
                $data['due_date'] = $request->due_date;
                $data['exchange_code'] = $request->exchange_code;
                $data['exchange_rate'] = $request->exchange_rate;
                $data['branch_id']=$request->branch_id;
                $data['type']='Invoice';
                $data['invoice_amount'] = '1';
                $data['due_amount'] = '1';
                $data['invoice_tax'] = '1';
                $data['status'] = '0';
                $data['good_receive'] = '0';
                $data['invoice_status'] = '0';
                $data['quotation']=1;
                $data['cf_id']=$request->project_id;
                $data['user_id']= auth()->user()->id;
                $data['user_agent']= $request->user_agent;
                $data['added_by'] = auth()->user()->added_by;

                $invoice = Invoice::create($data);

        $nameArr =$request->item_name ;
         $descArr =$request->description ;
        $qtyArr = $request->quantity  ;
        $priceArr =  str_replace(",","",$request->price);
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );

        $savedArr =$request->item_name ;
        
        
        $subArr = str_replace(",","",$request->subtotal);
        $totalArr =  str_replace(",","",$request->tax);
        $amountArr = str_replace(",","",$request->amount);


     if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'invoice_amount' =>  $subArr[$i],
                     'invoice_tax' =>  $totalArr[$i],
                   'due_amount' =>  $amountArr[$i]);

                     Invoice::where('id',$invoice->id)->update($t);  


            }
        }
    } 
        
        $cost['invoice_amount'] = 0;
        $cost['invoice_tax'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['invoice_amount'] +=$costArr[$i];
                    $cost['invoice_tax'] +=$taxArr[$i];

                    $items = array(
                        'item_name' => $nameArr[$i],
                         'description' =>$descArr[$i],
                        'quantity' =>   $qtyArr[$i],
                      'due_quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$invoice->id);
                       
                        InvoiceItems::create($items);  ;
    
    
                }
            }
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
            InvoiceItems::where('id',$invoice->id)->update($cost);
        }    




                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Created Successfully', 'type' => 'quotation']);
                break;

          

            case 'expenses':
                
                $nameArr =$request->account_id ;
     $suppArr =$request->supplier_id ;
 $amountArr = str_replace(',', '', $request->amount)  ;
 $notesArr = $request->notes;



$cost['amount'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                   $cost['amount'] += $amountArr[$i];
                  
                }
            }

             $items = array(
                  'name' =>  $request->name,
                    'ref' =>   $request->ref ,
                    'type' =>  'Expenses',
                    'amount' =>   $cost['amount'] ,
                     'date' => $request->date , 
                     'bank_id' =>  $request->bank_id ,
                     'branch_id' =>  $request->branch_id ,
                    'status'  => '0' ,
                     'view'  => '1' ,
                      'multiple'  => '0' ,
                      'user_id' => $request->user_id,
                      'cf_id' => $request->project_id,
                    'added_by' => auth()->user()->added_by,
                    'payment_method' =>  $request->payment_method

);

                    $total_expenses = Expenses::create($items);  ; 
         
        }    


  if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){
             $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
            
                $t = array(
                   'name' =>  $request->name,
                    'ref' =>   $request->ref ,
                    'type' =>  'Expenses',
                    'amount' =>  $amountArr[$i] ,
                     'date' => $request->date , 
                     'bank_id' =>  $request->bank_id ,
                     'branch_id' =>  $request->branch_id ,
                     'account_id' =>  $nameArr[$i] , 
                     'notes'  => $notesArr[$i] , 
                    'exchange_code' =>   $request->exchange_code,
                   'exchange_rate'=>  $request->exchange_rate,
                    'status'  => '0' ,
                      'view'  => '1' ,
                      'multiple'  => '1' ,
                      'multiple_id'  =>  $total_expenses->id ,
                    'trans_id' => 'TRANS_EXP_'.$random,
                   'user_id' => $request->user_id,
                    'cf_id' => $request->project_id,
                   'supplier_id' => $suppArr[$i] ,
                    'added_by' => auth()->user()->added_by,
                    'payment_method' =>  $request->payment_method
                        );

                     $expenses = Expenses::create($t);  ; 

            }
        }
    }    
    
    
                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Created Successfully', 'type' => 'expenses']);
                break;

           
                
                 case 'invoice_payment':
                     
        $receipt = $request->all();
        $sales =Invoice::find($request->invoice_id);
        
        if($sales->type == 'Invoice'){
            $type='invoice';
        }else{
            $type='logistic'; 
        }

    
        $count=InvoicePayments::count();
        $pro=$count+1;

        if(($receipt['amount'] <= $sales->due_amount)){
            if( $receipt['amount'] >= 0){
                $receipt['trans_id'] =  "CFP-".$pro;
                $receipt['account_id'] = $request->account_id;
                $receipt['added_by'] = auth()->user()->added_by;
                 $receipt['user_id'] = $sales->user_agent;
                
                //update due amount from invoice table
                $data['due_amount'] =  $sales->due_amount-$receipt['amount'];
                if($data['due_amount'] != 0 ){
                $data['status'] = 3;
                }else{
                    $data['status'] = 4;
                }
                $sales->update($data);
                 
                $payment = InvoicePayments::create($receipt);

                if($sales->related == 'Clients'){
                 $supp=Client::find($sales->client_id);
                }
                else{
               $supp=Departments::find($sales->client_id);
                }
                
                  $service=CFService::find($request->cf_servece_id) ;
                
        $cr= AccountCodes::where('id','$request->account_id')->first();
        $journal = new JournalEntry();
        $journal->account_id = $request->account_id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'cf_customer_invoice_payment';
        $journal->name = 'CF Charge Payment';
        $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
        $journal->payment_id= $payment->id;
        $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Deposit for Sales for Duty No " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();

     if($sales->type == 'Invoice'){
            $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
          $journal->transaction_type = 'cf_customer_invoice_payment';
        $journal->name = 'CF Charge Payment';
        $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
          $journal->payment_id= $payment->id;
      $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
        $journal->added_by=auth()->user()->added_by;
         $journal->notes= "Clear Receivable for Duty No  " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();
        }else{
            
            $itt=InvoiceItems::where('invoice_id',$request->invoice_id)->get();
            
            foreach($itt as $z){
            $service=CFService::find($z->item_name) ; 
            
        $journal = new JournalEntry();
        $journal->account_id = $service->gl_account_id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'cf_customer_invoice_payment';
        $journal->name = 'CF Charge Payment';
        $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
        $journal->payment_id= $payment->id;
      $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
        $journal->added_by=auth()->user()->added_by;
         $journal->notes= "Clear Receivable for Duty No  " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();
            }
            
            
            
        }
        
        

        return redirect(route('cf.show', $request->project_id))->with(['success' => 'Payment Added successfully', 'type' => $type]); 
            }else{
          return redirect(route('cf.show', $request->project_id))->with(['error' => 'Amount should not be equal or less to zero', 'type' => $type]);         
            }
        }else{
         return redirect(route('cf.show', $request->project_id))->with(['error' => 'Amount should  be less than Invoice amount', 'type' => $type]);   

        }
                   
                     break;

            default:
                return abort(404);
        }
    }

    public function edit_details($id,$type, $type_id)
    {
        
        
      $ccount = Comment::where('project_id', $id)
            ->where('disabled', '0')
            ->where('comments_reply_id', '0')
            ->count();
        $attcount = Attachment::where('project_id', $id)
            ->where('disabled', '0')
            ->count();
        $ncount = Notes::where('project_id', $id)
            ->where('disabled', '0')
            ->count();
        $actcount = Activity::where('project_id', $id)->count();
        $storecount = Storage::where('cf_id', $id)->count();
        $tcount = Task::where('added_by', auth()->user()->added_by)
            ->where('project_id', $id)
            ->where('disabled', '0')
            ->count();
        $mcount = Milestone::all()
            ->where('project_id', $id)
            ->where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $pcount = Invoice::all()
            ->where('invoice_status', 0)
            ->where('project_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $invcount = Invoice::where('added_by', auth()->user()->added_by)
                    ->where('cf_id', $id)
                    ->where('type', 'Invoice')
                    ->where('quotation', '0')
                    ->count();
         $logcount = Invoice::where('added_by', auth()->user()->added_by)
                    ->where('cf_id', $id)
                    ->where('type', 'Customer')
                    ->where('quotation', '0')->
                    count();  
        $qcount = Invoice::where('added_by', auth()->user()->added_by)
                    ->where('cf_id', $id)
                    ->where('type', 'Invoice')
                    ->where('quotation', '1')
                    ->count();
        $crdcount = ReturnInvoice::all()
            ->where('project_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $expcount = Expenses::where('multiple', '0')
            ->where('added_by', auth()->user()->added_by)
            ->where('project_id', $id)
            ->count();
        $purcount = Purchase::all()
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $chargecount = Charge::all()
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $ctypecount = CargoType::all()
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
        $dncount = ReturnPurchases::all()
            ->where('project_id', $id)
            ->where('added_by', auth()->user()->added_by)
            ->count();
 
            $name = CFService::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
           $CFservice = CFService::where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
            $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
            $chart_of_accounts=AccountCodes::all()->whereIn('account_type', ['Expense','Liability'])->whereNotIn('account_name', ['Deffered Tax','Value Added Tax (VAT)'])->where('disabled','0')->where('added_by',auth()->user()->added_by)->groupBy('account_type');;
            $users  =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
            $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
            $currency = Currency::all();
            $Cargo = Cargo::all()->where('added_by', auth()->user()->added_by);
            $country = Country::all();
             $supplier=Supplier::where('user_id',auth()->user()->added_by)->where('disabled', '0')->get();
              $categories = TaskCategory::all()->where('added_by', auth()->user()->added_by);

            $comment_details = Comment::where('project_id', $id)
            ->where('disabled', '0')
            ->where('comments_reply_id', '0')
            ->orderBy('comment_datetime', 'DESC')
            ->get();
        $attach = Attachment::where('project_id', $id)
            ->where('disabled', '0')
            ->get();
        $notes = Notes::where('project_id', $id)
            ->where('disabled', '0')
            ->get();
        $activity = Activity::where('project_id', $id)->get();
        $task = Task::all()
            ->where('added_by', auth()->user()->added_by)
            ->where('project_id', $id)
            ->where('disabled', '0');
        $mile = Milestone::all()
            ->where('project_id', $id)
            ->where('disabled', '0')
            ->where('added_by', auth()->user()->added_by);
        $inv = Invoice::all()
            ->where('invoice_status', 1)
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by);
        $pur = Purchase::all()
            ->where('cf_id', $id)
            ->where('added_by', auth()->user()->added_by);

            $data = Project::find($id);
 
            switch ($type) {
            case 'edit-attachment':
                $edit_data = Attachment::find($type_id);
                return view('cf.project_details', compact('data', 'id', 'type', 'type_id', 'edit_data', 'name', 'chart_of_accounts', 'currency', 'bank_accounts', 'users', 'task', 'mile', 'inv', 'pur','Cargo','country','CFservice','supplier','categories',
                'ccount', 'attcount', 'ncount', 'actcount', 'tcount', 'mcount', 'pcount', 'invcount', 'crdcount', 'expcount', 'purcount', 'dncount','qcount','ctypecount','logcount'));

                break;

            case 'edit-notes':
                $edit_data = Notes::find($type_id);
                
                 return view('cf.project_details', compact('data', 'id', 'type', 'type_id', 'edit_data', 'name', 'chart_of_accounts', 'currency', 'bank_accounts', 'users', 'task', 'mile', 'inv', 'pur','Cargo','country','CFservice','supplier','categories',
                'ccount', 'attcount', 'ncount', 'actcount', 'tcount', 'mcount', 'pcount', 'invcount', 'crdcount', 'expcount', 'purcount', 'dncount','qcount','ctypecount','logcount'));

                break;
           

            case 'edit-tasks':
                $edit_data = Task::find($type_id);
               

                return view('cf.project_details', compact('data', 'id', 'type', 'type_id', 'edit_data', 'name', 'chart_of_accounts', 'currency', 'bank_accounts', 'users', 'task', 'mile', 'inv', 'pur','Cargo','country','CFservice','supplier','categories',
                'ccount', 'attcount', 'ncount', 'actcount', 'tcount', 'mcount', 'pcount', 'invcount', 'crdcount', 'expcount', 'purcount', 'dncount','qcount','ctypecount','logcount'));

                break;

            case 'edit-milestone':
                $edit_data = Milestone::find($type_id);
      

                return view('cf.project_details', compact('data', 'id', 'type', 'type_id', 'edit_data', 'name', 'chart_of_accounts', 'currency', 'bank_accounts', 'users', 'task', 'mile', 'inv', 'pur','Cargo','country','CFservice','supplier','categories',
                'ccount', 'attcount', 'ncount', 'actcount', 'tcount', 'mcount', 'pcount', 'invcount', 'crdcount', 'expcount', 'purcount', 'dncount','qcount','ctypecount','logcount'));

                break;

            case 'edit-cargoType':
                $edit_data = CargoType::find($type_id);
               
               return view('cf.project_details', compact('data', 'id', 'type', 'type_id', 'edit_data', 'name', 'chart_of_accounts', 'currency', 'bank_accounts', 'users', 'task', 'mile', 'inv', 'pur','Cargo','country','CFservice','supplier','categories',
                'ccount', 'attcount', 'ncount', 'actcount', 'tcount', 'mcount', 'pcount', 'invcount', 'crdcount', 'expcount', 'purcount', 'dncount','qcount','ctypecount','logcount'));

                break;

                case 'edit-quotation':
                $edit_data = Invoice::find($type_id);
                 $items=InvoiceItems::where('invoice_id',$type_id)->get();    
                 
                return view('cf.project_details', compact('data', 'id', 'type', 'type_id', 'edit_data','items','name', 'chart_of_accounts', 'currency', 'bank_accounts', 'users', 'task', 'mile', 'inv', 'pur','Cargo','country','CFservice','supplier','categories',
                'ccount', 'attcount', 'ncount', 'actcount', 'tcount', 'mcount', 'pcount', 'invcount', 'crdcount', 'expcount', 'purcount', 'dncount','qcount','ctypecount','logcount'));

                break;
          

            case 'edit-invoice':
                $edit_data = Invoice::find($type_id);
                 $items=InvoiceItems::where('invoice_id',$type_id)->get();    
               
               return view('cf.project_details', compact('data', 'id', 'type', 'type_id', 'edit_data', 'items','name', 'chart_of_accounts', 'currency', 'bank_accounts', 'users', 'task', 'mile', 'inv', 'pur','Cargo','country','CFservice','supplier','categories',
                'ccount', 'attcount', 'ncount', 'actcount', 'tcount', 'mcount', 'pcount', 'invcount', 'crdcount', 'expcount', 'purcount', 'dncount','qcount','ctypecount','logcount'));

                break;

            case 'approve-invoice':
                $edit_data = Invoice::find($type_id);
                 $items=InvoiceItems::where('invoice_id',$type_id)->get();  
                 $receive='1';
               
               return view('cf.project_details', compact('data', 'id', 'type', 'type_id', 'edit_data', 'items','name', 'chart_of_accounts', 'currency', 'bank_accounts', 'users', 'task', 'mile', 'inv', 'pur','Cargo','country','CFservice','supplier','categories',
                'ccount', 'attcount', 'ncount', 'actcount', 'tcount', 'mcount', 'pcount', 'invcount', 'crdcount', 'expcount', 'purcount', 'dncount','qcount','ctypecount','logcount','receive'));

                break;

            case 'edit-expenses':
                $edit_data = Expenses::find($type_id);
               
              return view('cf.project_details', compact('data', 'id', 'type', 'type_id', 'edit_data', 'name', 'chart_of_accounts', 'currency', 'bank_accounts', 'users', 'task', 'mile', 'inv', 'pur','Cargo','country','CFservice','supplier','categories',
                'ccount', 'attcount', 'ncount', 'actcount', 'tcount', 'mcount', 'pcount', 'invcount', 'crdcount', 'expcount', 'purcount', 'dncount','qcount','ctypecount','logcount'));

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
                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $calls->id,
                        'project_id' => $request->project_id,
                        'module' => 'Attachment',
                        'activity' => 'Attachment ' . $calls->title . ' Updated',
                    ]);
                }

                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Updated Successfully', 'type' => 'attachment']);

                break;

            case 'milestone':
                $milestone = Milestone::find($request->id);

                $data = $request->all();;
                $data['added_by'] = auth()->user()->added_by;

                $milestone->update($data);

                if (!empty($milestone)) {
                    $project = Project::find($request->project_id);



                    $milestone_activity = MilestoneActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $milestone->id,
                        'module' => 'Milestone',
                        'activity' => 'Milestone ' . $milestone->name . ' Updated for CF File ' . $project->project_name . '-' . $project->reff_no,
                    ]);
                }

                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Updated Successfully', 'type' => 'milestone']);
                break;

            case 'notes':
                $meet = Notes::find($request->id);

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;

                $meet->update($data);

                if (!empty($meet)) {
                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $meet->id,
                        'project_id' => $request->project_id,
                        'module' => 'Notes',
                        'activity' => 'Notes Updated',
                    ]);
                }

                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Updated Successfully', 'type' => 'notes']);

                break;

          
            case 'tasks':
                $task = Task::find($request->id);

                $data = $request->all();
                $data['added_by'] = auth()->user()->added_by;
                $data['goal_tracking_id'] = 'Projects';

                $task->update($data);

                if (!empty($task)) {
                    $project = Project::find($request->project_id);

                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $task->id,
                        'project_id' => $request->project_id,
                        'module' => 'Tasks',
                        'activity' => 'Task ' . $task->task_name . ' Updated for CF File ' . $project->project_name . '-' . $project->reff_no,
                    ]);

                    $task_activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $task->id,
                        'module' => 'Task',
                        'activity' => 'Task ' . $task->task_name . ' Updated',
                    ]);
                }

                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Created Successfully', 'type' => 'tasks']);
                break;

            case 'quotation':
              
                $project=Project::find($request->project_id) ;  
            
                if($project->related == 'Clients'){
                    $client=$project->client_id;
                     $supp=Client::find($client);
                }
                else{
                   $client=$project->department_id;
                   $supp=Departments::find($client);
                }
            
                $invoice = Invoice::find($request->id);
                $data['related']=$project->related;
                $data['client_id']=$client;
                $data['invoice_date'] = $request->invoice_date;
                $data['due_date'] = $request->due_date;
                $data['exchange_code'] = $request->exchange_code;
                $data['exchange_rate'] = $request->exchange_rate;
                $data['branch_id']=$request->branch_id;
                $data['type']='Invoice';
                $data['invoice_amount'] = '1';
                $data['due_amount'] = '1';
                $data['invoice_tax'] = '1';
                $data['status'] = '0';
                $data['good_receive'] = '0';
                $data['invoice_status'] = '0';
                $data['quotation']=1;
                $data['cf_id']=$request->project_id;
                $data['user_id']= auth()->user()->id;
                $data['user_agent']= $request->user_agent;
                $data['added_by'] = auth()->user()->added_by;

                $invoice->update($data);

        $nameArr =$request->item_name ;
         $descArr =$request->description ;
        $qtyArr = $request->quantity  ;
        $priceArr =  str_replace(",","",$request->price);
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;
        $savedArr =$request->item_name ;
        
        
        $subArr = str_replace(",","",$request->subtotal);
        $totalArr =  str_replace(",","",$request->tax);
        $amountArr = str_replace(",","",$request->amount);


     if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'invoice_amount' =>  $subArr[$i],
                     'invoice_tax' =>  $totalArr[$i],
                   'due_amount' =>  $amountArr[$i]);

                     Invoice::where('id',$invoice->id)->update($t);  


            }
        }
    } 
        
        $cost['invoice_amount'] = 0;
        $cost['invoice_tax'] = 0;
        
         if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    InvoiceItems::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
        
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['invoice_amount'] +=$costArr[$i];
                    $cost['invoice_tax'] +=$taxArr[$i];

                    $items = array(
                        'item_name' => $nameArr[$i],
                         'description' =>$descArr[$i],
                        'quantity' =>   $qtyArr[$i],
                      'due_quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$invoice->id);
                       
                       if(!empty($expArr[$i])){
                                InvoiceItems::where('id',$expArr[$i])->update($items);  
          
          }
          else{
            InvoiceItems::create($items);   
          }
    
    
                }
            }
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
            InvoiceItems::where('id',$invoice->id)->update($cost);
        }    

  
                
                
           return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Updated Successfully', 'type' => 'quotation']);
                break;
                
            case 'invoice':
                
                $project=Project::find($request->project_id) ;  
            
                if($project->related == 'Clients'){
                    $client=$project->client_id;
                     $supp=Client::find($client);
                }
                else{
                   $client=$project->department_id;
                   $supp=Departments::find($client);
                }
            
                $invoice = Invoice::find($request->id);
                $data['related']=$project->related;
                $data['client_id']=$client;
                $data['invoice_date'] = $request->invoice_date;
                $data['due_date'] = $request->due_date;
                $data['branch_id']=$request->branch_id;
                $data['invoice_amount'] = '1';
                $data['due_amount'] = '1';
                $data['invoice_tax'] = '1';
                $data['cf_id']=$request->project_id;
                $data['user_id']= auth()->user()->id;
                $data['user_agent']= $request->user_agent;
                $data['added_by'] = auth()->user()->added_by;
                
                if ($request->receive == '1') {
                    $data['status'] = '2';
                }
                

                $invoice->update($data);

        $nameArr =$request->item_name ;
         $descArr =$request->description ;
        $qtyArr = $request->quantity  ;
        $priceArr =  str_replace(",","",$request->price);
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;
        $savedArr =$request->item_name ;
        
        
        $subArr = str_replace(",","",$request->subtotal);
        $totalArr =  str_replace(",","",$request->tax);
        $amountArr = str_replace(",","",$request->amount);


     if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'invoice_amount' =>  $subArr[$i],
                     'invoice_tax' =>  $totalArr[$i],
                   'due_amount' =>  $amountArr[$i]);

                     Invoice::where('id',$invoice->id)->update($t);  


            }
        }
    } 
        
        $cost['invoice_amount'] = 0;
        $cost['invoice_tax'] = 0;
        
         if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    InvoiceItems::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
        
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['invoice_amount'] +=$costArr[$i];
                    $cost['invoice_tax'] +=$taxArr[$i];

                    $items = array(
                        'item_name' => $nameArr[$i],
                         'description' =>$descArr[$i],
                        'quantity' =>   $qtyArr[$i],
                      'due_quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$invoice->id);
                       
                       if(!empty($expArr[$i])){
                                InvoiceItems::where('id',$expArr[$i])->update($items);  
          
          }
          else{
            InvoiceItems::create($items);   
          }
    
    
                }
            }
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
            InvoiceItems::where('id',$invoice->id)->update($cost);
        }    

                
                
                if ($request->receive == '1') {
                    
                    if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    
                     $lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'price' =>   $priceArr[$i],
                             'item_id' => $nameArr[$i],
                               'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                               'client_id' =>   $data['client_id'],
                             'invoice_date' =>  $data['invoice_date'],
                            'type' =>   'Sales',
                            'cf_id' =>$request->project_id,
                            'invoice_id' =>$invoice->id);
                           
         
                       InvoiceHistory::create($lists);
                    
                $inv = Invoice::find($invoice->id);
                $service=CFService::find($nameArr[$i]) ; 
                      
            $journal = new JournalEntry();
          $journal->account_id = $service->gl_account_id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'cf_invoice';
          $journal->name = 'CF Invoice';
          $journal->credit = $costArr[$i] *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
         $journal->branch_id= $inv->branch_id;
             $journal->notes= "Sales for CF Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
                      
             $tax= AccountCodes::where('account_name','VAT OUT')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'cf_invoice';
          $journal->name = 'CF Invoice';
          $journal->credit= $taxArr[$i] *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
           $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Sales Tax for CF Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
              $journal->branch_id= $inv->branch_id;
          $journal->save();
          
          
            $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'cf_invoice';
          $journal->name = 'CF Invoice';
          $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
          $journal->debit = ($costArr[$i] + $taxArr[$i])  *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
            $journal->notes= "Receivables for Sales CF Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
                      
                      
                      
                      
                }
            }
                    }
               
                    
                      
                    
                }
                   
                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Updated Successfully', 'type' => 'invoice']);
                break;

            case 'expenses':
               $expenses= Expenses::find($request->id);

            $expenses->name = $request->name;
           $expenses->ref = $request->ref;

             $expenses->type='Expenses';
             $expenses->amount = str_replace(',', '', $request->amount) ;
             $expenses->date  = $request->date  ;
             $expenses->account_id  = $request->account_id  ;
             $expenses->bank_id  = $request->bank_id ;
             $expenses->branch_id =  $request->branch_id ;
             $expenses->supplier_id  = $request->supplier_id ;
             $expenses->user_id = $request->user_id;
             $expenses->notes  = $request->notes ;
             $expenses->added_by = auth()->user()->added_by;
             $expenses->save();


$total_multiple=Expenses::find($expenses->multiple_id);
if(!empty($total_multiple)){
$multiple=Expenses::where('multiple_id',$total_multiple->id)->sum('amount');
$m['amount']=$multiple;
$total_multiple->update($m);
}



                return redirect(route('cf.show', $request->project_id))->with(['success' => 'Details Updated Successfully', 'type' => 'expenses']);
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
                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'project_id' => $id,
                        'module' => 'Comment',
                        'activity' => 'Comment  Deleted',
                    ]);
                }

                return redirect(route('cf.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'comments']);

            case 'delete-attachment':
                $edit_data = Attachment::find($type_id);
                $id = $edit_data->project_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'project_id' => $id,
                        'module' => 'Attachment',
                        'activity' => 'Attachment ' . $edit_data->title . ' Deleted',
                    ]);
                }

                return redirect(route('cf.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'attachment']);

                break;

            case 'delete-meetings':
                $edit_data = Notes::find($type_id);
                $id = $edit_data->project_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'project_id' => $id,
                        'module' => 'Notes',
                        'activity' => 'Notes Deleted',
                    ]);
                }

                return redirect(route('project.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'notes']);

                break;

            case 'delete-milestone':
                $edit_data = Milestone::find($type_id);
                $id = $edit_data->project_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $project = Project::find($id);

                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'project_id' => $id,
                        'module' => 'Milestone',
                        'activity' => 'Milestone ' . $edit_data->name . ' Deleted for CF File ' . $project->project_name . '-' . $project->reff_no,
                    ]);

                    $task_activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'module' => 'Milestone',
                        'activity' => 'Milestone ' . $edit_data->name . ' Deleted for CF File ' . $project->project_name . '-' . $project->reff_no,
                    ]);
                }

                return redirect(route('cf.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'milestone']);
                break;


           

            case 'delete-tasks':
                $edit_data = Task::find($type_id);
                $id = $edit_data->project_id;

                $data['disabled'] = '1';
                $edit_data->update($data);

                if (!empty($edit_data)) {
                    $project = Project::find($id);

                    $activity = Activity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'project_id' => $id,
                        'module' => 'Tasks',
                        'activity' => 'Task ' . $edit_data->task_name . ' Deleted for CF File ' . $project->project_name . '-' . $project->reff_no,
                    ]);

                    $task_activity = TaskActivity::create([
                        'added_by' => auth()->user()->id,
                        'module_id' => $type_id,
                        'module' => 'Task',
                        'activity' => 'Task ' . $edit_data->task_name . ' Deleted',
                    ]);
                }

                return redirect(route('cf.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'tasks']);
                break;
                
                

           

            case 'delete-expenses':

                
          $expenses=Expenses::find($type_id);
           $id = $expenses->cf_id;

          $total_multiple=Expenses::find($expenses->multiple_id);
        if(!empty($total_multiple)){
        $multiple=Expenses::where('multiple_id',$total_multiple->id)->sum('amount');
        $m['amount']=$multiple -$expenses->amount;
        $total_multiple->update($m);
        
        
        if($multiple -$expenses->amount == '0'){
          Expenses::destroy($expenses->multiple_id);
        
        }
        
        }
        
         Expenses::destroy($type_id);

       

                return redirect(route('cf.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'expenses']);
                break;
                
                 case 'delete-invoice':
                $edit_data = Invoice::find($type_id);
                $id = $edit_data->project_id;


                InvoiceItems::where('invoice_id', $type_id)->delete();
                $edit_data->delete();

   
                return redirect(route('cf.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'invoice']);
                break;


            case 'delete-quotation':
                $edit_data = Invoice::find($type_id);
                $id = $edit_data->cf_id;

                //$data['disabled'] = '1';
                //$edit_data->update($data);

                InvoiceItems::where('invoice_id', $type_id)->delete();
                $edit_data->delete();

               

                return redirect(route('cf.show', $id))->with(['success' => 'Details Deleted Successfully', 'type' => 'quotation']);
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

                    $project = Project::find($expenses->cf_id);

                    $journal = new JournalEntry();
                    $journal->account_id = $expenses->account_id;
                    $date = explode('-', $expenses->date);
                    $journal->date = $expenses->date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'expense_payment';
                    $journal->name = 'Expense Payment';
                    $journal->payment_id = $expenses->id;
                    $journal->project_id = $expenses->project_id;
                    $journal->notes = 'Expense Payment with transaction id ' . $expenses->name . ' for CF ' . $project->project_name . '-' . $project->reff_no;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->debit = $expenses->amount;
                    $journal->save();

                    $journal = new JournalEntry();
                    $journal->account_id = $expenses->bank_id;
                    $date = explode('-', $expenses->date);
                    $journal->date = $expenses->date;
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'expense_payment';
                    $journal->name = 'Expense Payment';
                    $journal->credit = $expenses->amount;
                    $journal->payment_id = $expenses->id;
                    $journal->project_id = $expenses->project_id;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Expense Payment with transaction id ' . $expenses->name . ' for CF ' . $project->project_name . '-' . $project->reff_no;
                    $journal->save();

                    $bank_accounts = AccountCodes::where('account_id', $expenses->bank_id)->first();
                    if ($bank_accounts->account_status == 'Bank') {
                        $account = Accounts::where('account_id', $expenses->bank_id)->first();

                        if (!empty($account)) {
                            $balance = $account->balance - $expenses->amount;
                            $item_to['balance'] = $balance;
                            $account->update($item_to);
                        } else {
                            $cr = AccountCodes::where('id', $expenses->bank_id)->first();

                            $new['account_id'] = $expenses->bank_id;
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
                            'account_id' => $expenses->bank_id,
                            'code_id' => $expenses->account_id,
                            'name' => 'Expense Payment with reference' . $expenses->trans_id,
                            'transaction_prefix' => $expenses->name,
                            'type' => 'Expense',
                            'amount' => $expenses->amount,
                            'debit' => $expenses->amount,
                            'total_balance' => $balance,
                            'date' => date('Y-m-d', strtotime($expenses->date)),
                            'status' => 'paid',
                            'notes' => 'Expense Payment with transaction id ' . $expenses->name,
                            'added_by' => auth()->user()->added_by,
                        ]);
                    }

                   
                }
            }
            return redirect(route('cf.show', $expenses->cf_id))->with(['success' => 'Approved Successfully', 'type' => 'expenses']);
        } else {
            return redirect(route('cf.show', $request->project_id))->with(['error' => 'You have not chosen an entry', 'type' => 'expenses']);
        }
    }

    public function file_preview(Request $request)
    {
        $id = $request->id;

        $data = Attachment::find($id);
        $filename = $data->attachment;
        return view('cf.file_preview', compact('filename'));
    }

    public function approve_purchase($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['status'] = 1;
        $purchase->update($data);

        if (!empty($purchase)) {
            $project = Project::find($purchase->cf_id);

            $activity = Activity::create([
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'module_id' => $id,
                'module' => 'Purchase',
                'project_id' => $purchase->cf_id,
                'activity' => 'Purchase with reference no  ' . $purchase->reference_no . '  is approved for CF File ' . $project->project_name . '-' . $project->reff_no,
            ]);

            $pos_activity = POSActivity::create([
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'module_id' => $id,
                'module' => 'Purchase',
                'activity' => 'Purchase with reference no  ' . $purchase->reference_no . '  is approved for CF File ' . $project->project_name . '-' . $project->reff_no,
            ]);
        }
        return redirect(route('cf.show', $purchase->cf_id))->with(['success' => 'Approved Successfully', 'type' => 'purchase']);
    }

    public function convert_to_invoice($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['invoice_status'] = 1;
        $data['status'] = 1;
        $invoice->update($data);

        return redirect(route('cf.show', $invoice->cf_id))->with(['success' => 'Approved Successfully', 'type' => 'quotation']);
    }
    
    
    public function approve_invoice($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 1;
        $invoice->update($data);

        return redirect(route('cf.show', $invoice->cf_id))->with(['success' => 'Completed Successfully', 'type' => 'invoice']);
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
    
    //quotation
    public function add_inv_item(Request $request)
    {
        //dd($request->all());

       $data=$request->all();
       
       
        
          $list = '';
          $list1 = ''; 
          
           $it=CFService::where('id',$request->checked_item_name)->first();
                $a =  $it->name ; 

                   
          $name=$request->checked_item_name[0];
          $desc=$request->checked_description[0];
          $qty=$request->checked_quantity[0];
          $price=str_replace(",","",$request->checked_price[0]);
          $cost=$request->checked_total_cost[0];
          $tax=$request->checked_total_tax[0];
          $order=$request->checked_no[0];
          $unit=$request->checked_unit[0];
          $rate=$request->checked_tax_rate[0];
          
          if(!empty($request->saved_items_id[0])){
            $saved=$request->saved_items_id[0];
            }
            else{
            $saved='';   
                  }
          
          if(!empty($request->modal_type) && $request->modal_type == 'edit'){
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($qty,2).'<div class=""> <span class="form-control-static errorslst'.$order.'" id="errors" style="text-align:center;color:red;"></span></div></td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$cost.'</td>';
            $list .= '<td>'.$tax.'</td>';
             if(!empty($saved)){
            $list .='<td><a class="list-icons-item text-info qedit1" title="Check" href="javascript:void(0)" data-target="#app2FormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger qrem" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '" value="'.$saved.'"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
                }
            else{
            $list .='<td><a class="list-icons-item text-info qedit1" title="Check" href="javascript:void(0)" data-target="#app2FormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger qremove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            }
            
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control qitem_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="description[]" class="form-control qitem_desc" id="desc lst'.$order.'"  value="'.$desc.'"  />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control qitem_quantity" id="qty lst'.$order.'"  data-category_id="lst'.$order.'" value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control qitem_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control qitem_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control qitem_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control qitem_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control qitem_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="modal_type" class="form-control qitem_type" id="type lst'.$order.'"  value="edit"  />';
            $list1 .= '<input type="hidden" name="no[]" class="form-control qitem_type" id="no lst'.$order.'"  value="'.$order.'"  />';
            $list1 .= '<input type="hidden"  class="form-control qitem_idlst'.$order.'" id="item_id "  value="'.$name.'"  />';
            
            if(!empty($saved)){
            $list1 .= '<input type="hidden" name="saved_items_id[]" class="form-control qitem_saved'.$order.'" value="'.$saved.'"  required/>';
                }
          }
            else{
            $list .= '<tr class="trlst'.$order.'">';
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($qty,2).'<div class=""> <span class="form-control-static errorslst'.$order.'" id="errors" style="text-align:center;color:red;"></span></div></td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$cost.'</td>';
            $list .= '<td>'.$tax.'</td>';
            $list .='<td><a class="list-icons-item text-info qedit1" title="Check" href="javascript:void(0)" data-target="#app2FormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger qremove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            $list .= '</tr>';
                    
            $list1 .= '<div class="line_items" id="lst'.$order.'">';
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control qitem_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="description[]" class="form-control qitem_desc" id="desc lst'.$order.'"  value="'.$desc.'"  />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control qitem_quantity" id="qty lst'.$order.'"  data-category_id="lst'.$order.'" value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control qitem_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control qitem_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control qitem_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control qitem_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control qitem_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="modal_type" class="form-control qitem_type" id="type lst'.$order.'"  value="edit"  />';
             $list1 .= '<input type="hidden" name="no[]" class="form-control qitem_type" id="no lst'.$order.'"  value="'.$order.'"  />';
             $list1 .= '<input type="hidden"  class="form-control qitem_idlst'.$order.'" id="item_id "  value="'.$name.'"  />';
            $list1 .= '</div>';
            }


             return response()->json([
            'list'          => $list,
            'list1' => $list1
    ]);
        
    }
    
     //invoice
         public function add_item(Request $request)
    {
       //dd($request->all());

$data=$request->all();


 
   $list = '';
   $list1 = ''; 
   
    $it=CFService::where('id',$request->checked_item_name)->first();
         $a =  $it->name ; 

            
   $name=$request->checked_item_name[0];
   $desc=$request->checked_description[0];
   $qty=$request->checked_quantity[0];
   $price=str_replace(",","",$request->checked_price[0]);
   $cost=$request->checked_total_cost[0];
   $tax=$request->checked_total_tax[0];
   $order=$request->checked_no[0];
   $unit=$request->checked_unit[0];
   $rate=$request->checked_tax_rate[0];
   
   if(!empty($request->saved_items_id[0])){
     $saved=$request->saved_items_id[0];
     }
     else{
     $saved='';   
           }
   
   if(!empty($request->modal_type) && $request->modal_type == 'edit'){
     $list .= '<td>'.$a.'</td>';
     $list .= '<td>'.number_format($qty,2).'<div class=""> <span class="form-control-static errorslst'.$order.'" id="errors" style="text-align:center;color:red;"></span></div></td>';
     $list .= '<td>'.number_format($price,2).'</td>';
     $list .= '<td>'.$cost.'</td>';
     $list .= '<td>'.$tax.'</td>';
      if(!empty($saved)){
     $list .='<td><a class="list-icons-item text-info iedit1" title="Check" href="javascript:void(0)" data-target="#app2FormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger irem" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '" value="'.$saved.'"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
         }
     else{
     $list .='<td><a class="list-icons-item text-info iedit1" title="Check" href="javascript:void(0)" data-target="#app2FormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger iremove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
     }
     
     $list1 .= '<input type="hidden" name="item_name[]" class="form-control iitem_name" id="name lst'.$order.'"  value="'.$name.'" required />';
     $list1 .= '<input type="hidden" name="description[]" class="form-control iitem_desc" id="desc lst'.$order.'"  value="'.$desc.'"  />';
     $list1 .= '<input type="hidden" name="quantity[]" class="form-control iitem_quantity" id="qty lst'.$order.'"  data-category_id="lst'.$order.'" value="'.$qty.'" required />';
     $list1 .= '<input type="hidden" name="price[]" class="form-control iitem_price" id="price lst'.$order.'" value="'.$price.'" required />';
     $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control iitem_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
     $list1 .= '<input type="hidden" name="total_cost[]" class="form-control iitem_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
     $list1 .= '<input type="hidden" name="total_tax[]" class="form-control iitem_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
     $list1 .= '<input type="hidden" name="unit[]" class="form-control iitem_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
     $list1 .= '<input type="hidden" name="modal_type" class="form-control iitem_type" id="type lst'.$order.'"  value="edit"  />';
     $list1 .= '<input type="hidden" name="no[]" class="form-control iitem_type" id="no lst'.$order.'"  value="'.$order.'"  />';
     $list1 .= '<input type="hidden"  class="form-control iitem_idlst'.$order.'" id="item_id "  value="'.$name.'"  />';
     
     if(!empty($saved)){
     $list1 .= '<input type="hidden" name="saved_items_id[]" class="form-control iitem_saved'.$order.'" value="'.$saved.'"  required/>';
         }
   }
     else{
     $list .= '<tr class="trlst'.$order.'">';
     $list .= '<td>'.$a.'</td>';
     $list .= '<td>'.number_format($qty,2).'<div class=""> <span class="form-control-static errorslst'.$order.'" id="errors" style="text-align:center;color:red;"></span></div></td>';
     $list .= '<td>'.number_format($price,2).'</td>';
     $list .= '<td>'.$cost.'</td>';
     $list .= '<td>'.$tax.'</td>';
     $list .='<td><a class="list-icons-item text-info iedit1" title="Check" href="javascript:void(0)" data-target="#app2FormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger iremove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
     $list .= '</tr>';
             
     $list1 .= '<div class="line_items" id="lst'.$order.'">';
     $list1 .= '<input type="hidden" name="item_name[]" class="form-control iitem_name" id="name lst'.$order.'"  value="'.$name.'" required />';
     $list1 .= '<input type="hidden" name="description[]" class="form-control iitem_desc" id="desc lst'.$order.'"  value="'.$desc.'"  />';
     $list1 .= '<input type="hidden" name="quantity[]" class="form-control iitem_quantity" id="qty lst'.$order.'"  data-category_id="lst'.$order.'" value="'.$qty.'" required />';
     $list1 .= '<input type="hidden" name="price[]" class="form-control iitem_price" id="price lst'.$order.'" value="'.$price.'" required />';
     $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control iitem_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
     $list1 .= '<input type="hidden" name="total_cost[]" class="form-control iitem_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
     $list1 .= '<input type="hidden" name="total_tax[]" class="form-control iitem_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
     $list1 .= '<input type="hidden" name="unit[]" class="form-control iitem_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
     $list1 .= '<input type="hidden" name="modal_type" class="form-control iitem_type" id="type lst'.$order.'"  value="edit"  />';
      $list1 .= '<input type="hidden" name="no[]" class="form-control iitem_type" id="no lst'.$order.'"  value="'.$order.'"  />';
      $list1 .= '<input type="hidden"  class="form-control iitem_idlst'.$order.'" id="item_id "  value="'.$name.'"  />';
     $list1 .= '</div>';
            }


             return response()->json([
            'list'          => $list,
            'list1' => $list1
    ]);
        
    }
         
         
    
        public function invoice_pdfview(Request $request)
    {
        //
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('cf.sales.invoice_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('inv_pdfview');
    }
    
     public function invoice_receipt(Request $request){

        //if landscape heigth * width but if portrait widht *height;
        $customPaper = array(0,0,198.425,494.80);

        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();
     

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('cf.sales.invoice_receipt_pdf')->setPaper($customPaper, 'portrait');
         return $pdf->download('RECEIPT INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('invoice_receipt');

    }
    
      public function print_pdfview(Request $request)
    {
        
        //if landscape heigth * width but if portrait widht *height;
        $customPaper = array(0,0,198.425,494.80);
        
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();
        
        $pdf = PDF::loadView('cf.sales.invoice_details_pdf', compact('invoices','invoice_items'));
        $output = $pdf->output();
       
       return new Response($output, 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' =>  'inline; filename="invoice.pdf"',
]);

       
    }
    
    
     public function receipt_print_pdfview(Request $request)
    {
        //
        //if landscape heigth * width but if portrait widht *height;
        $customPaper = array(0,0,198.425,494.80);
        
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();
        
        $pdf = PDF::loadView('cf.sales.invoice_receipt_pdf', compact('invoices','invoice_items'))->setPaper($customPaper, 'portrait');
        $output = $pdf->output();
       
       return new Response($output, 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' =>  'inline; filename="invoice_receipt.pdf"',
]);

       
    }
    
    
      public function payment_pdfview(Request $request)
    {
        //
        $customPaper = array(0,0,198.425,494.80);
        $data=InvoicePayments::find($request->id);
        $purchases = Invoice::find($data->invoice_id);

        view()->share(['purchases'=>$purchases,'data'=> $data]);

        if($request->has('download')){
        $pdf = PDF::loadView('cf.sales.payments_pdf')->setPaper($customPaper, 'portrait');
         return $pdf->download('INVOICE PAYMENT REF NO # ' .  $data->trans_id . ".pdf");
        }
        return view('payment_pdfview');
    }
    
    
       public function history_pdfview(Request $request)
    {
        
        
        $payments=InvoicePayments::where('invoice_id',$request->id)->get();
        
        $added_by = auth()->user()->added_by;
    
        
        $a = "SELECT pos_return_invoices.reference_no,pos_return_invoices.return_date,journal_entries.credit,pos_return_invoices.bank_id FROM pos_return_invoices INNER JOIN journal_entries ON pos_return_invoices.id=journal_entries.income_id 
        INNER JOIN pos_invoices ON pos_return_invoices.invoice_id = pos_invoices.id WHERE pos_return_invoices.added_by = '".$added_by."' AND pos_invoices.id = '".$request->id."' AND journal_entries.reference = 'Credit Note Deposit' AND journal_entries.credit IS NOT NULL ";
        
        $deposits = [];
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items,'payments'=> $payments,'deposits'=> $deposits]);

        if($request->has('download')){
        $pdf = PDF::loadView('cf.sales.history_payments_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('PAYMENT HISTORY NO # ' .  $invoices->reference_no . ".pdf");
        }
        return view('history_pdfview');
    }
  
  
    
    
}