<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\GroupAccount;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\POS\Activity;
use App\Models\POS\InvoicePayments;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\MasterHistory;
use App\Models\POS\SerialList;
use App\Models\POS\GoodIssue;
use App\Models\POS\GoodIssueItem;
use App\Models\POS\StockMovement;
use App\Models\POS\StockMovementItem;
use App\Models\POS\GoodDisposal;
use App\Models\POS\GoodDisposalItem;
use App\Models\POS\Items;
use App\Models\POS\Category ;
use App\Models\POS\Color ;
use App\Models\POS\Size ;
use App\Models\JournalEntry;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
//use App\Models\invoice_items;
use App\Models\Client;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\POS\InvoiceAttachment;
use App\Models\Branch;
use App\Models\User;
use App\Models\System;
use App\Models\SystemDetails;
use App\Models\Supplier ;
use PDF;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

use Illuminate\Http\Request;
use Carbon\Carbon;


use App\Models\Delivery;
use App\Models\DeliveryDriver;

class DeliveryNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $currency= Currency::all();

        $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();
        $name =Items::whereIn('type', [1,2,4,6])->where('added_by',auth()->user()->added_by)->where('restaurant','0')->where('disabled','0')->get();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->orderBy('id','asc')->get();
        $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
            ->where('locations.disabled','0')
            ->where('locations.added_by',auth()->user()->added_by)
            ->where('location_manager.manager',auth()->user()->id)
            ->select('locations.*')
            ->orderBy('locations.created_at','asc')
            ->get();
        $bank_details =SystemDetails::where('added_by',auth()->user()->added_by)->get();

        $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        $type="receive";

        if(auth()->user()->added_by == auth()->user()->id){
            $invoices=Invoice::where('invoice_status',6)->where('disabled','0')->where('added_by',auth()->user()->added_by)->latest()->get();
            $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
            $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->sum(\DB::raw('due_amount * exchange_rate'));

            $total= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->count();
            $unpaid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','1')->count();
            $part= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','2')->count();
            $paid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','3')->count();
        }

        else{
            $invoices=Invoice::where('invoice_status',6)->where('disabled','0')->where('added_by',auth()->user()->added_by)->where('user_agent',auth()->user()->id)->latest()->get();
            $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
            $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->sum(\DB::raw('due_amount * exchange_rate'));

            $total= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->count();
            $unpaid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','1')->count();
            $part= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','2')->count();
            $paid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','3')->count();

        }

        //dd($unpaid);
        return view('pos.sales.invoice_delivery_note',compact('name', 'bank_details', 'client','currency','invoices','type','bank_accounts','location','user','branch',
            'pos_invoice','pos_due','total','unpaid','part','paid'

        ));
    }


    public function add_new_item(Request $request)
        {
            $request->validate([
                'name'            => 'required',
                'cost_price'      => 'nullable',
                'sales_price'     => 'nullable',
                'unit'            => 'required',
                'tax_rate'        => 'required',
            ]);

            $id = \DB::table('tbl_items')->insertGetId([
                'type'            => 1, 
                'name'            => $request->name,
                'cost_price'      => $request->cost_price,
                'sales_price'     => $request->sales_price,
                'unit'            => $request->unit, 
                'minimum_balance' => $request->minimum_balance,     
                'added_by'        => auth()->id(),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            $item = \DB::table('tbl_items')->where('id', $id)->first();

            return response()->json($item);
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

    public function create_sales()
    {

        $currency= Currency::all();

        $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();
        $name =Items::whereIn('type', [1,2,4,6])->where('added_by',auth()->user()->added_by)->where('restaurant','0')->where('disabled','0')->get();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->orderBy('id','asc')->get();
        $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
            ->where('locations.disabled','0')
            ->where('locations.added_by',auth()->user()->added_by)
            ->where('location_manager.manager',auth()->user()->id)
            ->select('locations.*')
            ->orderBy('locations.created_at','asc')
            ->get()  ;
        $bank_details =SystemDetails::where('added_by',auth()->user()->added_by)->get();


        $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        $type="receive";

        if(auth()->user()->added_by == auth()->user()->id){
            $invoices=Invoice::where('invoice_status',1)->where('disabled','0')->where('added_by',auth()->user()->added_by)->latest()->get();
            $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
            $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->sum(\DB::raw('due_amount * exchange_rate'));

            $total= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->count();
            $unpaid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','1')->count();
            $part= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','2')->count();
            $paid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','3')->count();
        }

        else{
            $invoices=Invoice::where('invoice_status',1)->where('disabled','0')->where('added_by',auth()->user()->added_by)->where('user_agent',auth()->user()->id)->latest()->get();
            $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
            $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->sum(\DB::raw('due_amount * exchange_rate'));

            $total= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->count();
            $unpaid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','1')->count();
            $part= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','2')->count();
            $paid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','3')->count();

        }

        //dd($unpaid);
        return view('pos.sales.create_sales',compact('name', 'bank_details', 'client','currency','invoices','type','bank_accounts','location','user','branch',
            'pos_invoice','pos_due','total','unpaid','part','paid'

        ));



        // return view('pos.sales.create_sales');
    }



    public function modified_sales()
    {

        $currency= Currency::all();

        $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();
        $name =Items::whereIn('type', [1,2,4,6])->where('added_by',auth()->user()->added_by)->where('restaurant','0')->where('disabled','0')->get();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->orderBy('id','asc')->get();
        $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
            ->where('locations.disabled','0')
            ->where('locations.added_by',auth()->user()->added_by)
            ->where('location_manager.manager',auth()->user()->id)
            ->select('locations.*')
            ->orderBy('locations.created_at','asc')
            ->get()  ;

        $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        $type="receive";

        if(auth()->user()->added_by == auth()->user()->id){
            $invoices=Invoice::where('invoice_status',1)->where('disabled','0')->where('added_by',auth()->user()->added_by)->latest()->get();
            $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
            $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->sum(\DB::raw('due_amount * exchange_rate'));

            $total= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->count();
            $unpaid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','1')->count();
            $part= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','2')->count();
            $paid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','3')->count();
        }

        else{
            $invoices=Invoice::where('invoice_status',1)->where('disabled','0')->where('added_by',auth()->user()->added_by)->where('user_agent',auth()->user()->id)->latest()->get();
            $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
            $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->sum(\DB::raw('due_amount * exchange_rate'));

            $total= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->count();
            $unpaid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','1')->count();
            $part= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','2')->count();
            $paid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','3')->count();

        }

        //dd($unpaid);
        return view('pos.sales.modified_sales',compact('name','client','currency','invoices','type','bank_accounts','location','user','branch',
            'pos_invoice','pos_due','total','unpaid','part','paid'

        ));



        // return view('pos.sales.create_sales');
    }



    public function show_delivery($id)
    {
        $invoice = Invoice::findOrFail($id);

        $client = Client::find($invoice->client_id);
        $clientDetails = (object) [
            'name' => $client->name ?? 'N/A',
            'phone' => $client->phone ?? 'N/A',
            'address' => $client->address ?? 'N/A'
        ];

        $user = User::find($invoice->added_by);
        $company = (object) [
            'name' => $user->name ?? 'N/A',
            'phone' => $user->phone ?? 'N/A',
            'address' => $user->address ?? 'N/A'
        ];

        $invoiceHistories = InvoiceHistory::where('invoice_id', $id)->get();
        $items = [];
        foreach ($invoiceHistories as $history) {
            $item = Items::find($history->item_id);
            if ($item) {
                $items[] = (object) [
                    'name' => $item->name ?? 'N/A',
                    'price' => $history->price ?? 0,
                    'quantity' => $history->quantity ?? 0,
                    'total' => ($history->price ?? 0) * ($history->quantity ?? 0)
                ];
            }
        }

        $drivers = DeliveryDriver::all();

        $deliveryDetails = Delivery::with('driver')->where('invoice_id', $id)->first();

        return view('pos.sales.delivery', compact(
            'invoice',
            'clientDetails',
            'drivers',
            'company',
            'deliveryDetails',
            'items'
        ));
    }



    public function assignDriver(Request $request, $id)
    {

        try {
            if ($request->filled('driver_id')) {
                // Assign existing driver
                $delivery = Delivery::updateOrCreate(
                    ['invoice_id' => $id],
                    [
                        'driver_id' => $request->driver_id,
                        'plate_number' => $request->plate_number
                    ]
                );
            } else {
                // Create new driver and assign
                $driver = DeliveryDriver::create([
                    'name' => $request->driver_name,
                    'phone' => $request->driver_phone,
                    'plate_number' => $request->plate_number,
                    'licence' => $request->driver_licence,
                ]);

                $delivery = Delivery::updateOrCreate(
                    ['invoice_id' => $id],
                    [
                        'driver_id' => $driver->id,
                        'plate_number' => $request->plate_number
                    ]
                );
            }

            return redirect()->route('show_delivery', ['id' => $id])
                ->with('success', 'Driver assigned successfully');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to assign driver: ' . $e->getMessage());
        }
    }



    public function getDeliveryNotifications($id)
    {
        $invoice = Invoice::findOrFail($id);

        $client = Client::find($invoice->client_id);
        $clientDetails = (object) [
            'name' => $client->name ?? 'N/A',
            'phone' => $client->phone ?? 'N/A',
            'address' => $client->address ?? 'N/A'
        ];

        $user = User::find($invoice->added_by);
        $company = (object) [
            'name' => $user->name ?? 'N/A',
            'phone' => $user->phone ?? 'N/A',
            'address' => $user->address ?? 'N/A'
        ];

        $deliveryDetails = Delivery::with('driver')->where('invoice_id', $id)->first();
        $driver = $deliveryDetails->driver ?? (object) [
            'name' => 'N/A',
            'phone' => 'N/A'
        ];
        $plate_number = $deliveryDetails->plate_number ?? 'N/A';

        return response()->json([
            'invoice' => ['id' => $invoice->id],
            'client' => $clientDetails,
            'company' => $company,
            'driver' => $driver,
            'plate_number' => $plate_number
        ]);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Count invoices for reference number
        $count = Invoice::where('added_by', auth()->user()->added_by)->count();
        // $pro = $count + 1;
        // $data['reference_no'] = "S0" . $pro;
        $pro = $count + 1; // Increment counter
        $month = date('m'); // Current month (e.g., 10)
        $year = date('y');  // Current year (e.g., 25)

        $number = str_pad($pro, 2, '0', STR_PAD_LEFT);

        $data['reference_no'] = "DN/{$number}/{$month}/{$year}";

        $data['client_id'] = $request->client_id;
        $data['invoice_date'] = $request->invoice_date;
        $data['due_date'] = $request->due_date;
        // $data['delivery_date'] = $request->delivery_date;
        $data['delivery_date'] = Carbon::parse($request->invoice_date)->addDays(30)->toDateString();
        $data['heading'] = $request->heading;
        $data['supplier_reference'] = $request->supplier_reference;
        $data['location'] = $request->location;
        $data['notes'] = $request->notes;
        $data['exchange_code'] = $request->exchange_code;
        $data['exchange_rate'] = $request->exchange_rate;
        $data['invoice_amount'] = 0; // Placeholder, updated later
        $data['due_amount'] = 0; // Placeholder, updated later
        $data['branch_id'] = $request->branch_id;
        $data['invoice_tax'] = 0; // Placeholder, updated later
        $data['sales_type'] = $request->sales_type;
        $data['bank_id'] = $request->bank_id;
        $data['bank_details_id'] = $request->bank_details_id;
        $data['payment_condition'] = $request->payment_condition;
        $data['delivery_terms'] = $request->delivery_terms;
        $data['good_receive'] = '1';
        $data['invoice_status'] = 6;
        $data['status'] = 6;
        $data['user_id'] = auth()->user()->id;
        $data['user_agent'] = $request->user_agent;
        $data['added_by'] = auth()->user()->added_by;

        // Create the invoice
        $invoice = Invoice::create($data);

        // Arrays from request
        $nameArr = $request->item_name;
        $descArr = $request->description;
        $qtyArr = $request->quantity;
        $priceArr = str_replace(",", "", $request->price);
        $rateArr = $request->tax_rate;
        $unitArr = $request->unit;
        $costArr = str_replace(",", "", $request->total_cost);
        $taxArr = str_replace(",", "", $request->total_tax);
        $savedArr = $request->item_name;
        $imgArr = $request->filename;
        $ogArr = $request->original_filename;
        $saleTypeArr = $request->sale_type; // Added sale_type array

        $subArr = str_replace(",", "", $request->subtotal);
        $totalArr = str_replace(",", "", $request->tax);
        $amountArr = str_replace(",", "", $request->amount);
        $disArr = str_replace(",", "", $request->discount);
        $shipArr = str_replace(",", "", $request->shipping_cost);
        $adjArr = str_replace(",", "", $request->adjustment);

        // Update invoice totals
        if (!empty($nameArr)) {
            for ($i = 0; $i < count($amountArr); $i++) {
                if (!empty($amountArr[$i])) {
                    $t = [
                        'invoice_amount' => 0,
                        'invoice_tax' => 0,
                        'shipping_cost' => 0,
                        'discount' => 0,
                        'adjustment' => 0,
                        'due_amount' => 0
                    ];
                    Invoice::where('id', $invoice->id)->update($t);
                }
            }
        }

        // Process items with crate_size logic
        $cost['invoice_amount'] = 0;
        $cost['invoice_tax'] = 0;
        if (!empty($nameArr)) {
            for ($i = 0; $i < count($nameArr); $i++) {
                if (!empty($nameArr[$i])) {
                    // Fetch the item to get crate_size
                    $item = Items::where('id', $nameArr[$i])->first();
                    $crateSize = $item->crate_size ?? 1; // Default to 1 if crate_size is not set

                    // Adjust quantity based on sale_type
                    $adjustedQuantity = $qtyArr[$i];
                    if (isset($saleTypeArr[$i]) && $saleTypeArr[$i] === 'crate') {
                        $adjustedQuantity = $qtyArr[$i] * $crateSize;
                    }

                    // Accumulate costs
                    $cost['invoice_amount'] += $costArr[$i];
                    $cost['invoice_tax'] += $taxArr[$i];

                    // Create InvoiceItems with adjusted quantity
                    $items = [
                        'item_name' => $nameArr[$i],
                        'description' => $descArr[$i],
                        'quantity' => $adjustedQuantity, // Use adjusted quantity
                        'due_quantity' => $adjustedQuantity, // Use adjusted quantity
                        'tax_rate' => 0,
                        'unit' => $unitArr[$i],
                        'price' => 0,
                        'total_cost' => 0,
                        'total_tax' => 0,
                        'items_id' => $savedArr[$i],
                        'order_no' => $i,
                        'added_by' => auth()->user()->added_by,
                        'invoice_id' => $invoice->id,
                        'sale_type' => $saleTypeArr[$i] ?? 'qty'
                    ];

                    // dd($items);

                    InvoiceItems::create($items);
                }
            }

            $cost['due_amount'] = 0;
            Invoice::where('id', $invoice->id)->update($cost); // Update Invoice
        }

        // Handle attachments
        if (!empty($imgArr)) {
            for ($i = 0; $i < count($imgArr); $i++) {
                if (!empty($imgArr[$i])) {
                    InvoiceAttachment::create([
                        'filename' => $imgArr[$i],
                        'original_filename' => $ogArr[$i],
                        'order_no' => $i,
                        'added_by' => auth()->user()->added_by,
                        'invoice_id' => $invoice->id
                    ]);
                }
            }
        }

        // Handle invoice history and stock updates
        if (!empty($nameArr)) {
            for ($i = 0; $i < count($nameArr); $i++) {
                if (!empty($nameArr[$i])) {
                    // Fetch adjusted quantity again for consistency
                    $item = Items::where('id', $nameArr[$i])->first();
                    $crateSize = $item->crate_size ?? 1;
                    $adjustedQuantity = $qtyArr[$i];
                    if (isset($saleTypeArr[$i]) && $saleTypeArr[$i] === 'crate') {
                        $adjustedQuantity = $qtyArr[$i] * $crateSize;
                    }

                    $lists = [
                        'quantity' => $adjustedQuantity,
                        'price' => $priceArr[$i],
                        'item_id' => $savedArr[$i],
                        'added_by' => auth()->user()->added_by,
                        'user_id' => auth()->user()->id,
                        'client_id' => $data['client_id'],
                        'location' => $data['location'],
                        'invoice_date' => $data['invoice_date'],
                        'type' => 'Sales',
                        'invoice_id' => $invoice->id
                    ];
                    // dd($lists);

                    InvoiceHistory::create($lists);

                    $mlists = [
                        'out' => $adjustedQuantity,
                        'price' => $priceArr[$i],
                        'item_id' => $savedArr[$i],
                        'added_by' => auth()->user()->added_by,
                        'client_id' => $data['client_id'],
                        'location' => $data['location'],
                        'date' => $data['invoice_date'],
                        'type' => 'Sales',
                        'invoice_id' => $invoice->id
                    ];

                    // dd($mlists);

                    MasterHistory::create($mlists);

                    $inv = Items::where('id', $nameArr[$i])->first();
                    if ($inv->type != '4') {
                        $q = $inv->quantity - $adjustedQuantity;
                        Items::where('id', $nameArr[$i])->update(['quantity' => $q]);

                        $loc = Location::where('id', $invoice->location)->first();
                        $lq['quantity'] = $loc->quantity - $adjustedQuantity;
                        Location::where('id', $invoice->location)->update($lq);
                    }
                }
            }
        }

        // Calculate total cost for journal entries
        $total_cost = 0;
        $x_items = InvoiceItems::where('invoice_id', $invoice->id)->get();
        foreach ($x_items as $x) {
            $a = Items::where('id', $x->item_name)->first();
            if ($a->type == '4') {
                $total_cost = 0;
            } else {
                $tt = PurchaseHistory::where('item_id', $x->item_name)
                    ->where('location', $invoice->location)
                    ->where('type', 'Purchases')
                    ->latest('id')
                    ->first();

                if (!empty($tt)) {
                    $total_cost += $tt->price * $x->quantity;
                } else {
                    $total_cost += $a->cost_price * $x->quantity;
                }
            }
        }

        // Journal entries
        $inv = Invoice::find($invoice->id);
        $supp = Client::find($inv->client_id);
        $staff = User::find($inv->user_agent);

        $cr = AccountCodes::where('account_name', 'Sales')->where('added_by', auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $cr->id;
        $date = explode('-', $inv->invoice_date);
        $journal->date = $inv->invoice_date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'delivery_note';
        $journal->name = 'Delivery Note';
        $journal->credit = 0;
        $journal->income_id = $inv->id;
        $journal->client_id = $inv->client_id;
        $journal->currency_code = 0;
        $journal->exchange_rate = 0;
        $journal->added_by = auth()->user()->added_by;
        $journal->branch_id = $inv->branch_id;
        $journal->notes = "Delivery Note No " . $inv->reference_no . " to Client " . $supp->name;
        $journal->save();

        if ($inv->invoice_tax > 0) {
            $tax = AccountCodes::where('account_name', 'VAT OUT')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $tax->id;
            $date = explode('-', $inv->invoice_date);
            $journal->date = $inv->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'delivery_note';
            $journal->name = 'Delivery Note';
            $journal->credit = 0;
            $journal->income_id = $inv->id;
            $journal->client_id = $inv->client_id;
            $journal->currency_code = 0;
            $journal->exchange_rate = 0;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $inv->branch_id;
            $journal->notes = "Delivery Note No " . $inv->reference_no . " to Client " . $supp->name;
            $journal->save();
        }

        $codes = AccountCodes::where('account_name', 'Receivable and Prepayments')->where('added_by', auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
        $date = explode('-', $inv->invoice_date);
        $journal->date = $inv->invoice_date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'delivery_note';
        $journal->name = 'Delivery Note';
        $journal->income_id = $inv->id;
        $journal->client_id = $inv->client_id;
        $journal->debit = 0;
        $journal->currency_code = 0;
        $journal->exchange_rate = 0;
        $journal->added_by = auth()->user()->added_by;
        $journal->branch_id = $inv->branch_id;
        $journal->notes = "Delivery Note No " . $inv->reference_no . " to Client " . $supp->name;
        $journal->save();

        if ($total_cost > 0) {
            $stock = AccountCodes::where('account_name', 'Inventory')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $stock->id;
            $date = explode('-', $inv->invoice_date);
            $journal->date = $inv->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'delivery_note';
            $journal->name = 'Delivery Note';
            $journal->credit = 0;
            $journal->income_id = $inv->id;
            $journal->client_id = $inv->client_id;
            $journal->currency_code = 0;
            $journal->exchange_rate = 0;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $inv->branch_id;
            $journal->notes = "Delivery Note No " . $inv->reference_no . " to Client " . $supp->name;
            $journal->save();

            $cos = AccountCodes::where('account_name', 'Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cos->id;
            $date = explode('-', $inv->invoice_date);
            $journal->date = $inv->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'delivery_note';
            $journal->name = 'Delivery Note';
            $journal->debit = 0;
            $journal->income_id = $inv->id;
            $journal->client_id = $inv->client_id;
            $journal->currency_code = 0;
            $journal->exchange_rate = 0;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $inv->branch_id;
            $journal->notes = "Delivery Note No " . $inv->reference_no . " to Client " . $supp->name;
            $journal->save();
        }

        if ($inv->discount > 0) {
            $cr = AccountCodes::where('account_name', 'Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cr->id;
            $date = explode('-', $inv->invoice_date);
            $journal->date = $inv->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'delivery_note';
            $journal->name = 'Delivery Note';
            $journal->debit = 0;
            $journal->income_id = $inv->id;
            $journal->client_id = $inv->client_id;
            $journal->currency_code = 0;
            $journal->exchange_rate = 0;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $inv->branch_id;
            $journal->notes = "Delivery Note No " . $inv->reference_no . " to Client " . $supp->name;
            $journal->save();

            $disc = AccountCodes::where('account_name', 'Sales Discount')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $disc->id;
            $date = explode('-', $inv->invoice_date);
            $journal->date = $inv->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'delivery_note';
            $journal->name = 'Delivery Note';
            $journal->credit = 0;
            $journal->income_id = $inv->id;
            $journal->client_id = $inv->client_id;
            $journal->currency_code = 0;
            $journal->exchange_rate = 0;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $inv->branch_id;
            $journal->notes = "Delivery Note No " . $inv->reference_no . " to Client " . $supp->name;
            $journal->save();
        }

        if ($inv->shipping_cost > 0) {
            $shp = AccountCodes::where('account_name', 'Shipping Cost')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $shp->id;
            $date = explode('-', $inv->invoice_date);
            $journal->date = $inv->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'delivery_note';
            $journal->name = 'Delivery Note';
            $journal->debit = 0;
            $journal->income_id = $inv->id;
            $journal->client_id = $inv->client_id;
            $journal->branch_id = $inv->branch_id;
            $journal->currency_code = 0;
            $journal->exchange_rate = 0;
            $journal->added_by = auth()->user()->added_by;
            $journal->notes = "Delivery Note No " . $inv->reference_no . " to Client " . $supp->name;
            $journal->save();

            $pc = AccountCodes::where('account_name', 'Payables')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $pc->id;
            $date = explode('-', $inv->invoice_date);
            $journal->date = $inv->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'delivery_note';
            $journal->name = 'Delivery Note';
            $journal->credit = 0;
            $journal->income_id = $inv->id;
            $journal->client_id = $inv->client_id;
            $journal->currency_code = 0;
            $journal->exchange_rate = 0;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $inv->branch_id;
            $journal->notes = "Delivery Note No " . $inv->reference_no . " to Client " . $supp->name;
            $journal->save();
        }

        if (!empty($inv->adjustment) && $inv->adjustment != '0') {
            $cr = AccountCodes::where('account_name', 'Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cr->id;
            $date = explode('-', $inv->invoice_date);
            $journal->date = $inv->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'delivery_note';
            $journal->name = 'Delivery Note';
            $journal->debit = 0;
            $journal->income_id = $inv->id;
            $journal->client_id = $inv->client_id;
            $journal->currency_code = 0;
            $journal->exchange_rate = 0;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $inv->branch_id;
            $journal->notes = "Delivery Note No " . $inv->reference_no . " to Client " . $supp->name;
            $journal->save();

            $adj = AccountCodes::where('account_name', 'Adjustment')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $adj->id;
            $date = explode('-', $inv->invoice_date);
            $journal->date = $inv->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'delivery_note';
            $journal->name = 'Delivery Note';
            $journal->credit = 0;
            $journal->income_id = $inv->id;
            $journal->client_id = $inv->client_id;
            $journal->currency_code = 0;
            $journal->exchange_rate = 0;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $inv->branch_id;
            $journal->notes = "Delivery Note No " . $inv->reference_no . " to Client " . $supp->name;
            $journal->save();
        }

        // Activity log
        if (!empty($invoice)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'module_id' => $invoice->id,
                'module' => 'Invoice',
                'activity' => "Invoice with reference no " . $invoice->reference_no . " is Created",
            ]);
        }

        // Invoice payment for Cash Sales
        if ($inv->sales_type == 'Cash Sales') {
            $sales = Invoice::find($inv->id);
            $method = Payment_methodes::where('name', 'Cash')->first();
            $count = InvoicePayments::count();
            $pro = $count + 1;

            $receipt['trans_id'] = "TSP-" . $pro;
            $receipt['invoice_id'] = $inv->id;
            $receipt['amount'] = 0;
            $receipt['date'] = $inv->invoice_date;
            $receipt['account_id'] = $request->bank_id;
            $receipt['payment_method'] = $method->id;
            $receipt['user_id'] = $sales->user_agent;
            $receipt['added_by'] = auth()->user()->added_by;

            // Update due amount and status
            $b['due_amount'] = 0;
            $b['status'] = 3;
            $sales->update($b);

            $payment = InvoicePayments::create($receipt);

            $supp = Client::find($sales->client_id);

            $cr = AccountCodes::where('id', $request->bank_id)->first();
            $journal = new JournalEntry();
            $journal->account_id = $request->bank_id;
            $date = explode('-', $request->invoice_date);
            $journal->date = $request->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'delivery_note';
            $journal->name = 'Delivery Note';
            $journal->debit = 0;
            $journal->payment_id = $payment->id;
            $journal->client_id = $sales->client_id;
            $journal->currency_code = 0;
            $journal->exchange_rate = 0;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $sales->branch_id;
            $journal->notes = "Delivery Note No " . $sales->reference_no . " by Client " . $supp->name;
            $journal->save();

            $codes = AccountCodes::where('account_name', 'Receivable and Prepayments')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $codes->id;
            $date = explode('-', $request->invoice_date);
            $journal->date = $request->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'delivery_note';
            $journal->name = 'Delivery Note';
            $journal->credit = 0;
            $journal->payment_id = $payment->id;
            $journal->client_id = $sales->client_id;
            $journal->currency_code = 0;
            $journal->exchange_rate = 0;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $sales->branch_id;
            $journal->notes = "Delivery Note No " . $sales->reference_no . " by Client " . $supp->name;
            $journal->save();

            $account = Accounts::where('account_id', $request->bank_id)->first();
            if (!empty($account)) {
                $balance = 0;
                $item_to['balance'] = $balance;
                $account->update($item_to);
            } else {
                $cr = AccountCodes::where('id', $request->bank_id)->first();
                $new['account_id'] = $request->bank_id;
                $new['account_name'] = $cr->account_name;
                $new['balance'] = 0;
                $new['exchange_code'] = $sales->currency_code;
                $new['added_by'] = auth()->user()->added_by;
                $balance = $payment->amount;
                Accounts::create($new);
            }

            $transaction = Transaction::create([
                'module' => 'POS Invoice Payment',
                'module_id' => $payment->id,
                'account_id' => $request->bank_id,
                'code_id' => $codes->id,
                'name' => 'Delivery Note with reference ' . $payment->trans_id,
                'transaction_prefix' => $payment->trans_id,
                'type' => 'Income',
                'amount' => 0,
                'credit' => 0,
                'total_balance' => 0,
                'date' => date('Y-m-d', strtotime($request->date)),
                'paid_by' => $sales->client_id,
                'payment_methods_id' => $payment->payment_method,
                'status' => 'paid',
                'notes' => 'This deposit is from pos invoice payment. The Reference is ' . $sales->reference_no . ' by Client ' . $supp->name,
                'added_by' => auth()->user()->added_by,
            ]);

            if (!empty($payment)) {
                $activity = Activity::create([
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $payment->id,
                    'module' => 'Invoice Payment',
                    'activity' => "Invoice with reference no " . $sales->reference_no . " is Paid",
                ]);
            }
        }

        return redirect(route('delivery_note.show', $invoice->id))->with(['success' => 'Delivery Note Created Successfully']);
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
        $invoices = Invoice::find($id);
        $invoice_items=InvoiceItems::where('invoice_id',$id)->where('due_quantity','>', '0')->get();
        $payments=InvoicePayments::where('invoice_id',$id)->get();

        $added_by = auth()->user()->added_by;


        $a = "SELECT pos_return_invoices.reference_no,pos_return_invoices.return_date,journal_entries.credit,pos_return_invoices.bank_id FROM pos_return_invoices INNER JOIN journal_entries ON pos_return_invoices.id=journal_entries.income_id 
        INNER JOIN pos_invoices ON pos_return_invoices.invoice_id = pos_invoices.id WHERE pos_return_invoices.added_by = '".$added_by."' AND pos_invoices.id = '".$id."' AND journal_entries.reference = 'Credit Note Deposit' AND journal_entries.credit IS NOT NULL ";

        $deposits = DB::select($a);

        return view('pos.sales.invoice_delivery_note_details',compact('invoices','invoice_items','payments','deposits'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $currency= Currency::all();

        $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();
        $name =Items::whereIn('type', [1,2,4,6])->where('added_by',auth()->user()->added_by)->where('restaurant','0')->where('disabled','0')->get();
        $data=Invoice::find($id);
        $items=InvoiceItems::where('invoice_id',$id)->get();
        $bank_details =SystemDetails::where('added_by',auth()->user()->added_by)->get();

        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->orderBy('id','asc')->get();
        $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
            ->where('locations.disabled','0')
            ->where('locations.added_by',auth()->user()->added_by)
            ->where('location_manager.manager',auth()->user()->id)
            ->select('locations.*')
            ->get()  ;
        //$location=LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $type="receive";
        $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();


        if(auth()->user()->added_by == auth()->user()->id){

            $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
            $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->sum(\DB::raw('due_amount * exchange_rate'));

            $total= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->count();
            $unpaid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','1')->count();
            $part= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','2')->count();
            $paid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','3')->count();
        }

        else{
            $invoices=Invoice::where('invoice_status',1)->where('disabled','0')->where('added_by',auth()->user()->added_by)->where('user_agent',auth()->user()->id)->latest()->get();
            $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
            $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->sum(\DB::raw('due_amount * exchange_rate'));

            $total= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->count();
            $unpaid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','1')->count();
            $part= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','2')->count();
            $paid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','3')->count();

        }

        return view('pos.sales.invoice_delivery_note',compact('name','client','currency','data','id','items','bank_details','type','bank_accounts','location','user','branch',
            'pos_invoice','pos_due','total','unpaid','part','paid'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //


        $invoice = Invoice::find($id);

        $old_qty=InvoiceItems::where('invoice_id',$id)->sum('due_quantity');
        $old=InvoiceItems::where('invoice_id',$id)->get();

        foreach($old as $o){

            $oinv=Items::where('id',$o->item_name)->first();
            if($oinv->type != '4'){
                $oq=$oinv->quantity + $o->due_quantity;
                Items::where('id',$o->item_name)->update(['quantity' => $oq]);

                $oloc=Location::where('id', $invoice->location)->first();
                $olq['quantity']=$oloc->quantity + $o->due_quantity;
                Location::where('id', $invoice->location)->update($olq);
            }


        }

        /*
        $date = today()->format('Y-m');
        $old_chk=SerialList::where('invoice_id',$id)->where('location', $invoice->location)->where('status','2')->where('added_by',auth()->user()->added_by)->where('expire_date', '>=', $date)
        ->orWhereNull('expire_date')->where('invoice_id',$id)->where('location', $invoice->location)->where('status','2')->where('added_by',auth()->user()->added_by)->take($old_qty)->update(['status'=> '0']) ;
        */

        $data['client_id']=$request->client_id;
        $data['invoice_date']=$request->invoice_date;
        $data['due_date']=$request->due_date;
        $data['delivery_date'] = $request->delivery_date;
        $data['heading'] = $request->heading;
        $data['supplier_reference'] = $request->supplier_reference;
        $data['location']=$request->location;
        $data['notes']=$request->notes;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['bank_id'] = $request->bank_id;
        $data['bank_details_id'] = $request->bank_details_id;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
        $data['sales_type']=$request->sales_type;
        $data['bank_id']=$request->bank_id;
        $data['user_agent']= $request->user_agent;
        $data['added_by']= auth()->user()->added_by;

        $invoice->update($data);

        $nameArr =$request->item_name ;
        $descArr =$request->description ;
        $qtyArr = $request->quantity  ;
        $priceArr =str_replace(",","",$request->price);
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;
        $savedArr =$request->item_name ;
        $imgArr =$request->filename ;
        $ogArr =$request->original_filename ;

        $subArr = str_replace(",","",$request->subtotal);
        $totalArr =  str_replace(",","",$request->tax);
        $amountArr = str_replace(",","",$request->amount);
        $disArr =  str_replace(",","",$request->discount);
        $shipArr =  str_replace(",","",$request->shipping_cost);
        $adjArr =  str_replace(",","",$request->adjustment);

        if(!empty($nameArr)){
            for($i = 0; $i < count($amountArr); $i++){
                if(!empty($amountArr[$i])){
                    $t = array(
                        'invoice_amount' =>  $subArr[$i],
                        'invoice_tax' =>  $totalArr[$i],
                        'shipping_cost' =>   $shipArr[$i],
                        'discount' => $disArr[$i] ,
                        'adjustment' => $adjArr[$i] ,
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
                        'invoice_id' =>$id);

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


        InvoiceAttachment::where('invoice_id',$id)->delete();
        if(!empty($imgArr)){
            for($i = 0; $i < count($imgArr); $i++){
                if(!empty($imgArr[$i])){


                    InvoiceAttachment::create([
                        'filename' =>$imgArr[$i],
                        'original_filename' =>$ogArr[$i],
                        'order_no' => $i,
                        'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$id
                    ]);

                }
            }

        }

        InvoiceHistory::where('invoice_id',$id)->delete();
        MasterHistory::where('invoice_id',$id)->delete();
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                    $lists= array(
                        'quantity' =>   $qtyArr[$i],
                        'price' =>   $priceArr[$i],
                        'item_id' => $savedArr[$i],
                        'added_by' => auth()->user()->added_by,
                        'user_id' => auth()->user()->id,
                        'client_id' =>   $data['client_id'],
                        'location' =>   $data['location'],
                        'invoice_date' =>  $data['invoice_date'],
                        'type' =>   'Sales',
                        'invoice_id' =>$id);


                    InvoiceHistory::create($lists);


                    $mlists = [
                        'out' => $qtyArr[$i],
                        'price' => $priceArr[$i],
                        'item_id' => $savedArr[$i],
                        'added_by' => auth()->user()->added_by,
                        'client_id' =>   $data['client_id'],
                        'location' =>   $data['location'],
                        'date' =>$data['invoice_date'],
                        'type' =>   'Sales',
                        'invoice_id' =>$invoice->id,
                    ];

                    MasterHistory::create($mlists);

                    $inv=Items::where('id',$nameArr[$i])->first();

                    if($inv->type != '4'){
                        $q=$inv->quantity - $qtyArr[$i];
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);

                        $loc=Location::where('id', $invoice->location)->first();
                        $lq['quantity']=$loc->quantity - $qtyArr[$i];
                        Location::where('id', $invoice->location)->update($lq);
                    }

                    /*
                     $date = today()->format('Y-m');

$chk=SerialList::where('brand_id',$nameArr[$i])->where('location',$invoice->location)->where('added_by',auth()->user()->added_by)->where('status','0')->where('expire_date', '>=', $date)
->orWhereNull('expire_date')->where('brand_id',$nameArr[$i])->where('location',$invoice->location)->where('added_by',auth()->user()->added_by)->where('status','0')->take($qtyArr[$i])->update(['status'=> '2','invoice_id'=>$invoice->id]) ;
*/
                }
            }

        }

        JournalEntry::where('income_id',$id)->where('transaction_type','pos_invoice')->where('added_by', auth()->user()->added_by)->delete();

        $total_cost=0;

        $x_items=InvoiceItems::where('invoice_id',$invoice->id)->get()  ;
        foreach($x_items as $x){
            $a=Items::where('id',$x->item_name)->first();
            if($a->type == '4'){
                $total_cost=0;
            }
            else{

                $tt=PurchaseHistory::where('item_id', $x->item_name)->where('location',$invoice->location)->where('type','Purchases')->latest('id')->first();

                if(!empty($tt)){
                    $total_cost+=$tt->price * $x->quantity;
                }

                else{
                    $total_cost+=$a->cost_price * $x->quantity;
                }


            }

        }



        $inv = Invoice::find($id);
        $supp=Client::find($inv->client_id);
        $staff=User::find($inv->user_agent);

        $cr= AccountCodes::where('account_name','Sales')->where('added_by', auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $cr->id;
        $date = explode('-',$inv->invoice_date);
        $journal->date =   $inv->invoice_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'pos_invoice';
        $journal->name = 'Invoice';
        $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
        $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
        $journal->currency_code =  $inv->exchange_code;
        $journal->exchange_rate= $inv->exchange_rate;
        $journal->added_by=auth()->user()->added_by;
        $journal->branch_id= $inv->branch_id;
        $journal->notes= "Sales for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
        $journal->save();

        if($inv->invoice_tax > 0){
            $tax= AccountCodes::where('account_name','VAT OUT')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $tax->id;
            $date = explode('-',$inv->invoice_date);
            $journal->date =   $inv->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice';
            $journal->name = 'Invoice';
            $journal->credit= $inv->invoice_tax *  $inv->exchange_rate;
            $journal->income_id= $inv->id;
            $journal->client_id= $inv->client_id;
            $journal->currency_code =  $inv->exchange_code;
            $journal->exchange_rate= $inv->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->branch_id= $inv->branch_id;
            $journal->notes= "Sales Tax for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
            $journal->save();
        }

        $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
        $date = explode('-',$inv->invoice_date);
        $journal->date =   $inv->invoice_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'pos_invoice';
        $journal->name = 'Invoice';
        $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
        $journal->debit =$inv->due_amount  *  $inv->exchange_rate;
        $journal->currency_code =  $inv->exchange_code;
        $journal->exchange_rate= $inv->exchange_rate;
        $journal->added_by=auth()->user()->added_by;
        $journal->branch_id= $inv->branch_id;
        $journal->notes= "Receivables for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
        $journal->save();

        if($total_cost > 0){
            $stock= AccountCodes::where('account_name','Inventory')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id =  $stock->id;
            $date = explode('-',$inv->invoice_date);
            $journal->date =   $inv->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice';
            $journal->name = 'Invoice';
            $journal->credit = $total_cost;
            $journal->income_id= $inv->id;
            $journal->client_id= $inv->client_id;
            $journal->currency_code =  $inv->exchange_code;
            $journal->exchange_rate= $inv->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->branch_id= $inv->branch_id;
            $journal->notes= "Reduce Stock  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
            $journal->save();

            $cos= AccountCodes::where('account_name','Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id =  $cos->id;
            $date = explode('-',$inv->invoice_date);
            $journal->date =   $inv->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice';
            $journal->name = 'Invoice';
            $journal->debit = $total_cost ;
            $journal->income_id= $inv->id;
            $journal->client_id= $inv->client_id;
            $journal->currency_code =  $inv->exchange_code;
            $journal->exchange_rate= $inv->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->branch_id= $inv->branch_id;
            $journal->notes= "Cost of Goods Sold  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
            $journal->save();
        }

        if($inv->discount > 0){
            $cr= AccountCodes::where('account_name','Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cr->id;
            $date = explode('-',$inv->invoice_date);
            $journal->date =   $inv->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice';
            $journal->name = 'Invoice';
            $journal->debit = $inv->discount *  $inv->exchange_rate;
            $journal->income_id= $inv->id;
            $journal->client_id= $inv->client_id;
            $journal->currency_code =  $inv->exchange_code;
            $journal->exchange_rate= $inv->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->branch_id= $inv->branch_id;
            $journal->notes= "Sales Discount for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
            $journal->save();


            $disc= AccountCodes::where('account_name','Sales Discount')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $disc->id;
            $date = explode('-',$inv->invoice_date);
            $journal->date =   $inv->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice';
            $journal->name = 'Invoice';
            $journal->credit = $inv->discount *  $inv->exchange_rate;
            $journal->income_id= $inv->id;
            $journal->client_id= $inv->client_id;
            $journal->currency_code =  $inv->exchange_code;
            $journal->exchange_rate= $inv->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->branch_id= $inv->branch_id;
            $journal->notes= "Sales Discount for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
            $journal->save();

        }


        if($inv->shipping_cost > 0){

            $shp= AccountCodes::where('account_name','Shipping Cost')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $shp->id;
            $date = explode('-',$inv->invoice_date);
            $journal->date =   $inv->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice';
            $journal->name = 'Invoice';
            $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
            $journal->income_id= $inv->id;
            $journal->client_id= $inv->client_id;
            $journal->branch_id= $inv->branch_id;
            $journal->currency_code =  $inv->exchange_code;
            $journal->exchange_rate= $inv->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->notes= "Shipping Cost for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
            $journal->save();

            $pc=AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $pc->id;
            $date = explode('-',$inv->invoice_date);
            $journal->date =   $inv->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice';
            $journal->name = 'Invoice';
            $journal->credit = $inv->shipping_cost *  $inv->exchange_rate;
            $journal->income_id= $inv->id;
            $journal->client_id= $inv->client_id;
            $journal->currency_code =  $inv->exchange_code;
            $journal->exchange_rate= $inv->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->branch_id= $inv->branch_id;
            $journal->notes= "Sales Shipping Cost for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
            $journal->save();
        }
        if(!empty($inv->adjustment) && $inv->adjustment != '0'){
            $cr= AccountCodes::where('account_name','Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cr->id;
            $date = explode('-',$inv->invoice_date);
            $journal->date =   $inv->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice';
            $journal->name = 'Invoice';
            $journal->debit = $inv->adjustment *  $inv->exchange_rate;
            $journal->income_id= $inv->id;
            $journal->client_id= $inv->client_id;
            $journal->currency_code =  $inv->exchange_code;
            $journal->exchange_rate= $inv->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->branch_id= $inv->branch_id;
            $journal->notes= "Sales Adjustment for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
            $journal->save();


            $adj= AccountCodes::where('account_name','Adjustment')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $adj->id;
            $date = explode('-',$inv->invoice_date);
            $journal->date =   $inv->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice';
            $journal->name = 'Invoice';
            $journal->credit = $inv->adjustment *  $inv->exchange_rate;
            $journal->income_id= $inv->id;
            $journal->client_id= $inv->client_id;
            $journal->currency_code =  $inv->exchange_code;
            $journal->exchange_rate= $inv->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->branch_id= $inv->branch_id;
            $journal->notes= "Sales Adjustment for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
            $journal->save();

        }



        if(!empty($invoice)){
            $activity =Activity::create(
                [
                    'added_by'=>auth()->user()->added_by,
                    'user_id'=>auth()->user()->id,
                    'module_id'=>$id,
                    'module'=>'Invoice',
                    'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Updated",
                ]
            );
        }


        $old_pay=InvoicePayments::where('invoice_id',$id)->get();

        if(!empty($old_pay[0])){
            foreach($old_pay as $o_pay){
                JournalEntry::where('payment_id', $o_pay->id)->where('transaction_type','pos_invoice_payment')->where('added_by', auth()->user()->added_by)->delete();
            }
        }


        InvoicePayments::where('invoice_id', $id)->delete();

//invoice payment
        if($inv->sales_type == 'Cash Sales'){

            $sales =Invoice::find($inv->id);
            $method= Payment_methodes::where('name','Cash')->first();
            $count=InvoicePayments::count();
            $pro=$count+1;

            $receipt['trans_id'] = "TSP-".$pro;
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

            $supp=Client::find($sales->client_id);

            $cr= AccountCodes::where('id','$request->bank_id')->first();
            $journal = new JournalEntry();
            $journal->account_id = $request->bank_id;
            $date = explode('-',$request->invoice_date);
            $journal->date =   $request->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice_payment';
            $journal->name = 'Invoice Payment';
            $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
            $journal->payment_id= $payment->id;
            $journal->client_id= $sales->client_id;
            $journal->currency_code =   $sales->currency_code;
            $journal->exchange_rate=  $sales->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->notes= "Deposit for Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
            $journal->save();


            $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $codes->id;
            $date = explode('-',$request->invoice_date);
            $journal->date =   $request->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice_payment';
            $journal->name = 'Invoice Payment';
            $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
            $journal->payment_id= $payment->id;
            $journal->client_id= $sales->client_id;
            $journal->currency_code =   $sales->currency_code;
            $journal->exchange_rate=  $sales->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->notes= "Clear Receivable for Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
            $journal->save();

            $account= Accounts::where('account_id',$request->bank_id)->first();

            if(!empty($account)){
                $balance=$account->balance + $payment->amount ;
                $item_to['balance']=$balance;
                $account->update($item_to);
            }

            else{
                $cr= AccountCodes::where('id',$request->bank_id)->first();

                $new['account_id']= $request->bank_id;
                $new['account_name']= $cr->account_name;
                $new['balance']= $payment->amount;
                $new[' exchange_code']= $sales->currency_code;
                $new['added_by']=auth()->user()->added_by;
                $balance=$payment->amount;
                Accounts::create($new);
            }

            // save into tbl_transaction

            $transaction= Transaction::create([
                'module' => 'POS Invoice Payment',
                'module_id' => $payment->id,
                'account_id' => $request->bank_id,
                'code_id' => $codes->id,
                'name' => 'POS Invoice Payment with reference ' .$payment->trans_id,
                'transaction_prefix' => $payment->trans_id,
                'type' => 'Income',
                'amount' =>$payment->amount ,
                'credit' => $payment->amount,
                'total_balance' =>$balance,
                'date' => date('Y-m-d', strtotime($request->date)),
                'paid_by' => $sales->client_id,
                'payment_methods_id' =>$payment->payment_method,
                'status' => 'paid' ,
                'notes' => 'This deposit is from pos invoice  payment. The Reference is ' .$sales->reference_no .' by Client '. $supp->name  ,
                'added_by' =>auth()->user()->added_by,
            ]);


            if(!empty($payment)){
                $activity =Activity::create(
                    [
                        'added_by'=>auth()->user()->added_by,
                        'user_id'=>auth()->user()->id,
                        'module_id'=>$payment->id,
                        'module'=>'Invoice Payment',
                        'activity'=>"Invoice with reference no  " .  $sales->reference_no. "  is Paid",
                    ]
                );
            }



        }



        return redirect(route('delivery_note.show',$id))->with(['success'=>'Updated Successfully']);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $invoices = Invoice::find($id);

        $old_qty=InvoiceItems::where('invoice_id',$id)->sum('due_quantity');
        $old=InvoiceItems::where('invoice_id',$id)->get();
        $old_pay=InvoicePayments::where('invoice_id',$id)->get();
        $old_file=InvoiceAttachment::where('invoice_id',$id)->get();

        foreach($old as $o){

            $oinv=Items::where('id',$o->item_name)->first();
            if($oinv->type != '4'){
                $oq=$oinv->quantity + $o->due_quantity;
                Items::where('id',$o->item_name)->update(['quantity' => $oq]);

                $oloc=Location::where('id', $invoices->location)->first();
                $olq['quantity']=$oloc->quantity + $o->due_quantity;
                Location::where('id', $invoices->location)->update($olq);
            }

        }

        /*
        $chk=SerialList::where('invoice_id',$id)->where('location', $invoices->location)->where('status','2')->where('added_by',auth()->user()->added_by)->get();
        if(!empty($chk)){
        $old_chk=SerialList::where('invoice_id',$id)->where('location', $invoices->location)->where('status','2')->where('added_by',auth()->user()->added_by)->take($old_qty)->update(['status'=> '0']) ;
        }
        */
        JournalEntry::where('income_id',$id)->where('transaction_type','pos_invoice')->where('added_by', auth()->user()->added_by)->delete();
        JournalEntry::where('income_id',$id)->where('transaction_type','pos_commission')->where('added_by', auth()->user()->added_by)->delete();
        if(!empty($old_pay[0])){
            foreach($old_pay as $o_pay){
                JournalEntry::where('payment_id', $o_pay->id)->where('transaction_type','pos_invoice_payment')->where('added_by', auth()->user()->added_by)->delete();
            }
        }

        if(!empty($old_file[0])){
            foreach($old_file as $o_file){
                $filename =  $o_file->filename;
                $path = InvoiceController . phppublic_path('pos/') . $filename;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        InvoiceAttachment::where('invoice_id',$id)->delete();
        InvoiceHistory::where('invoice_id',$id)->delete();
        MasterHistory::where('invoice_id',$id)->delete();
        InvoiceItems::where('invoice_id', $id)->delete();
        InvoicePayments::where('invoice_id', $id)->delete();
        DB::table('invoice_commission')->where('invoice_id', $id)->delete();





        if(!empty($invoices)){
            $activity =Activity::create(
                [
                    'added_by'=>auth()->user()->added_by,
                    'user_id'=>auth()->user()->id,
                    'module_id'=>$id,
                    'module'=>'Invoice',
                    'activity'=>"Invoice with reference no  " .  $invoices->reference_no. "  is Deleted",
                ]
            );
        }

        $invoices->delete();

        return redirect(route('delivery_note.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
        $price= Items::where('id',$request->id)->get();
        return response()->json($price);

    }

    public function findQuantity2(Request $request)
    {

        $item=$request->item;
        $location=$request->location;
        $date = today()->format('Y-m');

        $item_info=Items::where('id', $item)->first();
        $location_info=Location::find($request->location);
        if ($item_info->type == '4') {
            $price='' ;
        }
        else{
            if ($item_info->quantity > 0) {

                $a=SerialList::where('brand_id',$item)->where('location',$location)->where('added_by',auth()->user()->added_by)->where('status',0)->whereNull('expire_date')->sum('due_quantity');
                $b=SerialList::where('brand_id',$item)->where('location',$location)->where('added_by',auth()->user()->added_by)->where('status',0)->whereNotNull('expire_date')->where('expire_date', '>=', $date)->sum('due_quantity');


                $quantity=$a + $b;

                if ($quantity > 0) {

                    if($request->id >  $quantity){
                        $price="You have exceeded your Stock. Choose quantity between 1.00 and ".  number_format($quantity,2) ;
                    }
                    else if($request->id <=  0){
                        $price="Choose quantity between 1.00 and ".  number_format($quantity,2) ;
                    }

                    else{
                        $price='' ;
                    }

                }

                else{
                    $price=$location_info->name . " Stock Balance  is Zero." ;

                }



            }



            else{
                $price="Your Stock Balance is Zero." ;

            }


        }

        return response()->json($price);

    }






    public function discountModal(Request $request)
    {

        $id=$request->id;
        $type = $request->type;

        switch ($type) {
            case 'client':
                return view('pos.sales.client_modal');
                break;


            case 'scan':
                return view('pos.sales.scan_modal',compact('id'));
                break;


            case 'commission':
                $data=Invoice::find($id);
                $items= DB::table('invoice_commission')->where('invoice_id',$id)->select("*")->select("*")->get();
                $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
                $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();

                $name = Items::leftJoin('pos_invoice_items', 'tbl_items.id','pos_invoice_items.item_name')
                    ->where('pos_invoice_items.invoice_id',$id)
                    ->whereIn('tbl_items.type', [1,2,4])
                    ->where('pos_invoice_items.due_quantity','>', '0')
                    ->where('tbl_items.added_by',auth()->user()->added_by)
                    ->where('tbl_items.restaurant','0')
                    ->select('tbl_items.*')
                    ->get();


                return view('pos.sales.commission_modal',compact('id','items','user','bank_accounts','data','name'));
                break;

            case 'edit':
                $item = Items::whereIn('type', [1,2,4 ])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
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
                return view('pos.sales.edit_modal', compact('item','name','desc','qty','price','cost','tax','unit','rate','order','type','saved'));
                break;

            case 'update':

                $loc = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                    ->where('locations.disabled','0')
                    ->where('locations.added_by',auth()->user()->added_by)
                    ->where('location_manager.manager',auth()->user()->id)
                    ->select('locations.*')
                    ->orderBy('locations.created_at','asc')
                    ->get()  ;

                $supplier = Supplier::where('user_id', auth()->user()->added_by)->where('disabled', '0')->get();
                $item=$request->item;
                $location=$request->location;

                return view('pos.sales.update',compact('id','location','supplier','loc','item'));
                break;



            default:
                break;

        }

    }



    public function findItem(Request $request){

        //dd($request->all());

        $items =  InvoiceItems::where('invoice_id', $request->invoice)->where('item_name', $request->id)->where('added_by',auth()->user()->added_by)->first();

        return response()->json($items);



    }

    public function check_item(Request $request){

        //dd($request->all());

        $list = '';
        $list1 = '';
        $it = Items::where('barcode', $request->barcode)->where('added_by',auth()->user()->added_by)->where('disabled','0')->whereNotNull('barcode')->first();

        $c = Color::find($it->color);
        $s = Size::find($it->size);

        if(!empty($c) && empty($s)){
            $a = $it->name .' - '.$c->name;
        }

        elseif(empty($c) && !empty($s)){
            $a =  $it->name .' - '.$s->name;
        }

        elseif(!empty($c) && !empty($s)){
            $a =  $it->name .' - '.$c->name . ' - '.$s->name;
        }

        else{
            $a =  $it->name ;
        }

        $name=$it->id;
        $desc=$it->description;
        $qty=1;
        $price=str_replace(",","",$it->sales_price);
        $sub=$price;
        $cost=$price;
        $tax=$it->tax_rate * $price;
        $order=$request->order_no;
        $unit=$it->unit;
        $rate=$it->tax_rate;

        if($rate == '0'){
            $r='No Tax';

        }
        else if($rate == '0.18'){
            $r='Exclusive (18%)';

        }else if($rate == '0.16'){
            $r='Exclusive (16%)';

        }


        $list .= '<tr class="trlst'.$order.'">';
        $list .= '<td>'.$a.'</td>';
        $list .= '<td>'.number_format($qty,2).'<div class=""> <span class="form-control-static errorslst'.$order.'" id="errors" style="text-align:center;color:red;"></span></div></td>';
        $list .= '<td>'.number_format($price,2).'</td>';
        $list .= '<td>'.$r.'</td>';
        $list .= '<td>'.number_format($tax,2).'</td>';
        $list .= '<td>'.number_format($cost + $tax,2).'</td>';
        $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
        $list .= '</tr>';

        $list1 .= '<div class="line_items" id="lst'.$order.'">';
        $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
        $list1 .= '<input type="hidden" name="description[]" class="form-control item_desc" id="desc lst'.$order.'"  value="'.$desc.'"  />';
        $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_quantity" id="qty lst'.$order.'"  data-category_id="lst'.$order.'" value="'.$qty.'" required />';
        $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
        $list1 .= '<input type="hidden" name="sub[]" class="form-control item_sub" id="sub lst'.$order.'"  value="'.$sub.'" required />';
        $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
        $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
        $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
        $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
        $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
        $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
        $list1 .= '<input type="hidden"  class="form-control item_idlst'.$order.'" id="item_id "  value="'.$name.'"  />';
        $list1 .= '</div>';




        return response()->json([
            'list'          => $list,
            'list1' => $list1
        ]);



    }



    public function update_item(Request $request){

        //dd($request->all());

        $item=Items::find($request->id);
        $data['quantity'] = $item->quantity + $request->quantity;
        $item->update($data);

        $lists= array(
            'quantity' =>   $request->quantity,
            'price' => $item->cost_price,
            'item_id' =>$item->id,
            'added_by' => auth()->user()->added_by,
            'user_id' => auth()->user()->id,
            'purchase_date' =>   $request->purchase_date,
            'location' => $request->location,
            'supplier_id' => $request->supplier_id,
            'type' =>   'Purchases');

        PurchaseHistory ::create($lists);

        if($request->quantity > 0){

            $mlists = [
                'in' => $request->quantity,
                'price' => $item->cost_price,
                'item_id' => $item->id,
                'added_by' => auth()->user()->added_by,
                'location' =>  $request->location,
                'supplier_id' => $request->supplier_id,
                'date' =>$request->purchase_date,
                'type' => 'Purchases',
            ];


        }


        else{

            $mlists = [
                'out' => abs($request->quantity),
                'price' => $item->cost_price,
                'item_id' => $item->id,
                'added_by' => auth()->user()->added_by,
                'location' =>  $request->location,
                'supplier_id' => $request->supplier_id,
                'date' =>$request->purchase_date,
                'type' => 'Purchases',
            ];


        }

        MasterHistory::create($mlists);




        $loc=Location::find($request->location);
        if($item->bar == '1'){
            $lq['crate']=$loc->crate +$request->quantity;
            $lq['bottle']=$loc->bottle+ ($request->quantity * $item->bottle);
        }

        $lq['quantity']=$loc->quantity + $request->quantity;
        $loc->update($lq);

        $cost=abs($item->cost_price *  $request->quantity);


        if($item->cost_price *  $request->quantity > 0){
            $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id =$cr->id;
            $date = explode('-',$request->purchase_date);
            $journal->date =   $request->purchase_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_update_item';
            $journal->name = 'Items';
            $journal->debit = $cost;
            $journal->income_id= $item->id;
            $journal->supplier_id = $request->supplier_id;
            $journal->added_by=auth()->user()->added_by;

            $journal->notes= "POS Item Update for ".  $item->name ;
            $journal->save();



            $codes= AccountCodes::where('account_name','Balance Control')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $codes->id;
            $date = explode('-',$request->purchase_date);
            $journal->date =   $request->purchase_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_update_item';
            $journal->name = 'Items';
            $journal->income_id= $item->id;
            $journal->supplier_id = $request->supplier_id;
            $journal->credit = $cost;
            $journal->added_by=auth()->user()->added_by;

            $journal->notes= "POS Item Update for ".  $item->name ;
            $journal->save();

        }

        else{

            $codes= AccountCodes::where('account_name','Balance Control')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id =$codes->id;
            $date = explode('-',$request->purchase_date);
            $journal->date =   $request->purchase_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_update_item';
            $journal->name = 'Items';
            $journal->debit = $cost;
            $journal->income_id= $item->id;
            $journal->supplier_id = $request->supplier_id;
            $journal->added_by=auth()->user()->added_by;

            $journal->notes= "POS Item Update for ".  $item->name ;
            $journal->save();


            $cr= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cr->id;
            $date = explode('-',$request->purchase_date);
            $journal->date =   $request->purchase_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_update_item';
            $journal->name = 'Items';
            $journal->income_id= $item->id;
            $journal->supplier_id = $request->supplier_id;
            $journal->credit = $cost ;
            $journal->added_by=auth()->user()->added_by;
            $journal->notes= "POS Item Update for ".  $item->name ;
            $journal->save();



        }


        return response()->json($item);



    }



    public function add_item(Request $request)
    {
        // Uncomment to debug request data if needed
        // dd($request->all());

        $data = $request->all();

        $list = '';
        $list1 = '';

        // Fetch item details
        $it = Items::where('id', $request->checked_item_name[0])->first();
        $c = Color::find($it->color);
        $s = Size::find($it->size);

        // Build item display name
        if (!empty($c) && empty($s)) {
            $a = $it->name . ' - ' . $c->name;
        } elseif (empty($c) && !empty($s)) {
            $a = $it->name . ' - ' . $s->name;
        } elseif (!empty($c) && !empty($s)) {
            $a = $it->name . ' - ' . $c->name . ' - ' . $s->name;
        } else {
            $a = $it->name;
        }

        // Extract form data
        $name = $request->checked_item_name[0];
        $desc = $request->checked_description[0];
        $qty = $request->checked_quantity[0];
        $price = str_replace(",", "", $request->checked_price[0]);
        $order = $request->checked_no[0];
        $unit = $request->checked_unit[0];
        $rate = $request->checked_tax_rate[0];
        $sale_type = $request->checked_sale_type[0];

        // Determine sale type display
        if ($sale_type == 'qty') {
            $z = 'Quantity';
        } else if ($sale_type == 'crate') {
            $z = 'Wholesale';
        } else {
            $z = 'N/A';
        }

        // Calculate tax and cost using user-entered quantity
        $sub = ($qty * $price); // Matches jAutoCalc
        if ($rate == '0') {
            $r = 'No Tax';
            $tax = 0;
            $cost = $sub;
        } else if ($rate == '0.18') {
            $r = 'Exclusive (18%)';
            $tax = $sub * 0.18;
            $cost = $sub; // Exclude tax from cost, add it to total below
        } else if ($rate == '0.16') {
            $r = 'Exclusive (16%)';
            $tax = $sub * 0.16;
            $cost = $sub; // Exclude tax from cost, add it to total below
        }

        // Handle saved items
        $saved = !empty($request->saved_items_id[0]) ? $request->saved_items_id[0] : '';

        // Build the table row HTML
        if (!empty($request->type) && $request->type == 'edit') {
            $list .= '<td>' . $a . '</td>';
            $list .= '<td>' . $z . '</td>';
            $list .= '<td>' . number_format($qty, 2) . '<div class=""><span class="form-control-static errorslst' . $order . '" id="errors" style="text-align:center;color:red;"></span></div></td>';
            $list .= '<td>' . number_format($price, 2) . '</td>';
            $list .= '<td>' . $r . '</td>';
            $list .= '<td>' . number_format($tax, 2) . '</td>';
            $list .= '<td>' . number_format($cost + $tax, 2) . '</td>';
            if (!empty($saved)) {
                $list .= '<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' . $order . '"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp;&nbsp;<a class="list-icons-item text-danger rem" title="Delete" href="javascript:void(0)" data-button_id="' . $order . '" value="' . $saved . '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            } else {
                $list .= '<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' . $order . '"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp;&nbsp;<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' . $order . '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            }

            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name_lst' . $order . '" value="' . $name . '" required />';
            $list1 .= '<input type="hidden" name="description[]" class="form-control item_desc" id="desc_lst' . $order . '" value="' . $desc . '" />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_quantity" id="qty_lst' . $order . '" data-category_id="lst' . $order . '" value="' . $qty . '" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price_lst' . $order . '" value="' . $price . '" required />';
            $list1 .= '<input type="hidden" name="sub[]" class="form-control item_sub" id="sub_lst' . $order . '" value="' . $sub . '" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate_lst' . $order . '" value="' . $rate . '" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost_lst' . $order . '" value="' . $cost . '" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax_lst' . $order . '" value="' . $tax . '" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit_lst' . $order . '" value="' . $unit . '" />';
            $list1 .= '<input type="hidden" name="sale_type[]" class="form-control sale_type" id="sale_type_lst' . $order . '" value="' . $sale_type . '" required />'; // Ensure sale_type is passed
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type_lst' . $order . '" value="edit" />';
            $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no_lst' . $order . '" value="' . $order . '" />';
            $list1 .= '<input type="hidden" class="form-control item_idlst' . $order . '" id="item_id" value="' . $name . '" />';
            if (!empty($saved)) {
                $list1 .= '<input type="hidden" name="saved_items_id[]" class="form-control item_saved' . $order . '" value="' . $saved . '" required/>';
            }
        } else {
            $list .= '<tr class="trlst' . $order . '">';
            $list .= '<td>' . $a . '</td>';
            $list .= '<td>' . $z . '</td>';
            $list .= '<td>' . number_format($qty, 2) . '<div class=""><span class="form-control-static errorslst' . $order . '" id="errors" style="text-align:center;color:red;"></span></div></td>';
            $list .= '<td>' . number_format($price, 2) . '</td>';
            $list .= '<td>' . $r . '</td>';
            $list .= '<td>' . number_format($tax, 2) . '</td>';
            $list .= '<td>' . number_format($cost + $tax, 2) . '</td>';
            $list .= '<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' . $order . '"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp;&nbsp;<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' . $order . '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            $list .= '</tr>';

            $list1 .= '<div class="line_items" id="lst' . $order . '">';
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name_lst' . $order . '" value="' . $name . '" required />';
            $list1 .= '<input type="hidden" name="description[]" class="form-control item_desc" id="desc_lst' . $order . '" value="' . $desc . '" />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_quantity" id="qty_lst' . $order . '" data-category_id="lst' . $order . '" value="' . $qty . '" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price_lst' . $order . '" value="' . $price . '" required />';
            $list1 .= '<input type="hidden" name="sub[]" class="form-control item_sub" id="sub_lst' . $order . '" value="' . $sub . '" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate_lst' . $order . '" value="' . $rate . '" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost_lst' . $order . '" value="' . $cost . '" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax_lst' . $order . '" value="' . $tax . '" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit_lst' . $order . '" value="' . $unit . '" />';
            $list1 .= '<input type="hidden" name="sale_type[]" class="form-control sale_type" id="sale_type_lst' . $order . '" value="' . $sale_type . '" required />'; // Ensure sale_type is passed
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type_lst' . $order . '" value="new" />';
            $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no_lst' . $order . '" value="' . $order . '" />';
            $list1 .= '<input type="hidden" class="form-control item_idlst' . $order . '" id="item_id" value="' . $name . '" />';
            $list1 .= '</div>';
        }

        return response()->json([
            'list' => $list,
            'list1' => $list1
        ]);
    }


    public function save_client(Request $request){

        //dd($request->all());

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $data['owner_id'] = auth()->user()->added_by;
        $client = Client::create($data);



        if(!empty($client)){
            $activity =Activity::create(
                [
                    'added_by'=>auth()->user()->added_by,
                    'user_id'=>auth()->user()->id,
                    'module_id'=>$client->id,
                    'module'=>'Client',
                    'activity'=>"Client " .  $client->name. "  Created",
                ]
            );

            return response()->json($client);
        }


    }

    public function approve($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 1;
        $invoice->update($data);

        if(!empty($invoice)){
            $activity =Activity::create(
                [
                    'added_by'=>auth()->user()->added_by,
                    'user_id'=>auth()->user()->id,
                    'module_id'=>$id,
                    'module'=>'Invoice',
                    'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Approved",
                ]
            );
        }
        return redirect(route('invoice.index'))->with(['success'=>'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 4;
        $invoice->update($data);
        if(!empty($invoice)){
            $activity =Activity::create(
                [

                    'module_id'=>$id,
                    'module'=>'Invoice',
                    'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Cancelled",
                ]
            );
        }
        return redirect(route('invoice.index'))->with(['success'=>'Cancelled Successfully']);
    }



    public function receive($id)
    {
        //
        $currency= Currency::all();
        $client=Client::where('owner_id',auth()->user()->added_by)->get();
        $name =Items::whereIn('type', [1,2,4])->where('added_by',auth()->user()->added_by)->where('restaurant','0')->where('disabled','0')->get();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->orderBy('id','asc')->get();
        $data=Invoice::find($id);
        $items=InvoiceItems::where('invoice_id',$id)->get();
        //$location=Location::where('added_by',auth()->user()->added_by)->get();;
        $location=LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $type="receive";
        return view('pos.sales.invoice',compact('name','client','currency','data','id','items','type','bank_accounts','location'));
    }


    public function make_payment($id)
    {
        //
        $invoice = Invoice::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        return view('pos.sales.invoice_payments',compact('invoice','payment_method','bank_accounts'));
    }

    // public function invoice_pdfview(Request $request)
    // {
    //     //
    //     $invoices = Invoice::find($request->id);
    //     $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();

    //     view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

    //     if($request->has('download')){
    //         $pdf = PDF::loadView('pos.sales.invoice_details_pdf')->setPaper('a4', 'potrait');
    //         return $pdf->download('SALES INV NO # ' .  $invoices->reference_no . ".pdf");
    //     }
    //     return view('inv_pdfview');
    // }

    // public function invoice_pdfview(Request $request)
    // {
    //     $invoices = Invoice::find($request->id);
    //     $invoice_items = InvoiceItems::where('invoice_id', $request->id)
    //         ->where('due_quantity', '>', '0')
    //         ->get();

    //     view()->share(['invoices' => $invoices, 'invoice_items' => $invoice_items]);

    //     if ($request->has('download')) {
    //         $pdf = PDF::loadView('pos.sales.invoice_details_pdf')
    //                 ->setPaper('a4', 'portrait');

    //         $pdf->output();
    //         $dompdf = $pdf->getDomPDF();
    //         $canvas = $dompdf->getCanvas();
    //         $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
    //             $text = "Powered by MazaoHub – Page $pageNumber of $pageCount";
    //             $font = $fontMetrics->get_font("DejaVu Sans", "normal");
    //             $canvas->text(270, 820, $text, $font, 9, [0,0,0]);
    //         });

    //         return $pdf->download('SALES INV NO # ' .  $invoices->reference_no . ".pdf");
    //     }


    //     return view('inv_pdfview');
    // }

    public function invoice_pdfview(Request $request)
    {
        $invoices = Invoice::find($request->id);
        $invoice_items = InvoiceItems::where('invoice_id', $request->id)
            ->where('due_quantity', '>', '0')
            ->get();

        view()->share(['invoices' => $invoices, 'invoice_items' => $invoice_items]);

        if ($request->has('download')) {
            $pdf = PDF::loadView('pos.sales.invoice_details_pdf')
                ->setPaper('a4', 'portrait');

            // Get dompdf instance
            $dompdf = $pdf->getDomPDF();
            $canvas = $dompdf->getCanvas();

            // $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            //     // Footer text (long text)
            //     $text = "Dealers In: Sales of Industrial mechanical, Electrical, electronic & pneumatic spares, "
            //         . "Consumables, Industrial Chemicals, lubricants, Motors & motor Rewinding, Industrial PPEs, "
            //         . "General Hardware, Industrial Tools and Building Materials.";

            //     $font = $fontMetrics->get_font("helvetica", "normal");
            //     $size = 8;

            //     // Maximum width for footer text (leave margins)
            //     $maxWidth = $canvas->get_width() - 80; 

            //     // Split text into lines that fit within $maxWidth
            //     $words = explode(' ', $text);
            //     $lines = [];
            //     $currentLine = "";

            //     foreach ($words as $word) {
            //         $testLine = $currentLine === "" ? $word : $currentLine . " " . $word;
            //         $testWidth = $fontMetrics->get_text_width($testLine, $font, $size);

            //         if ($testWidth <= $maxWidth) {
            //             $currentLine = $testLine;
            //         } else {
            //             $lines[] = $currentLine;
            //             $currentLine = $word;
            //         }
            //     }
            //     if ($currentLine !== "") {
            //         $lines[] = $currentLine;
            //     }

            //     // Starting Y position (a bit above bottom margin)
            //     $y = $canvas->get_height() - 100;

            //     // Draw each line centered
            //     foreach ($lines as $line) {
            //         $width = $fontMetrics->get_text_width($line, $font, $size);
            //         $x = ($canvas->get_width() - $width) / 2;
            //         $canvas->text($x, $y, $line, $font, $size, [218/255, 165/255, 32/255]); // golden color
            //         $y += 10; // line spacing
            //     }

            //     // Page number (right aligned, below footer)
            //     $pageText = "Page $pageNumber of $pageCount";
            //     $pageWidth = $fontMetrics->get_text_width($pageText, $font, $size);
            //     $xPage = $canvas->get_width() - $pageWidth - 20; 
            //     $yPage = $canvas->get_height() - 15;
            //     $canvas->text($xPage, $yPage, $pageText, $font, $size);
            // });
            $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
                $font = $fontMetrics->get_font("helvetica", "normal");
                $size = 8;

                // Page number (right aligned at bottom)
                $pageText = "Page $pageNumber of $pageCount";
                $pageWidth = $fontMetrics->get_text_width($pageText, $font, $size);
                $xPage = $canvas->get_width() - $pageWidth - 20; // right margin
                $yPage = $canvas->get_height() - 20; // push up from bottom
                $canvas->text($xPage, $yPage, $pageText, $font, $size);
            });



            return $pdf->download('SALES INV NO # ' . $invoices->reference_no . ".pdf");
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
            $pdf = PDF::loadView('pos.sales.invoice_receipt_pdf')->setPaper($customPaper, 'portrait');
            return $pdf->download('SALES RECEIPT INV NO # ' .  $invoices->reference_no . ".pdf");
        }
        return view('invoice_receipt');

    }

    public function print_pdfview(Request $request)
    {

        //if landscape heigth * width but if portrait widht *height;
        $customPaper = array(0,0,198.425,494.80);

        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();

        if($invoices->invoice_status == 0){
            $pdf = PDF::loadView('pos.sales.profoma_invoice_pdf', compact('invoices','invoice_items'));
        }
        else{
            $pdf = PDF::loadView('pos.sales.invoice_details_pdf', compact('invoices','invoice_items'));
        }

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

        $pdf = PDF::loadView('pos.sales.invoice_receipt_pdf', compact('invoices','invoice_items'))->setPaper($customPaper, 'portrait');
        $output = $pdf->output();

        return new Response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'inline; filename="invoice_receipt.pdf"',
        ]);


    }


    public function debtors_report(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $currency=$request->currency;
        $chart_of_accounts = [];
        $accounts = [];

        foreach (Client::where('owner_id',auth()->user()->added_by)->where('disabled',0)->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        foreach (Currency::all() as $key) {
            $accounts[$key->code] = $key->name;
        }
        if($request->isMethod('post')){
            $data=Invoice::where('client_id', $request->account_id)->where('exchange_code', $request->currency)->whereBetween('invoice_date',[$start_date,$end_date])->where('status','!=',0)->where('added_by',auth()->user()->added_by)->get();
        }else{
            $data=[];
        }



        return view('pos.sales.debtors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id','currency','accounts'));
    }

    public function debtors_summary_report(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $currency=$request->currency;
        $accounts = [];

        foreach (Currency::all() as $key) {
            $accounts[$key->code] = $key->name;
        }
        if($request->isMethod('post')){
            $data= Invoice::where('exchange_code', $request->currency)->whereBetween('invoice_date',[$start_date,$end_date])->where('status','!=',0)->where('added_by',auth()->user()->added_by)->groupBy('client_id')->get();
        }else{
            $data=[];
        }



        return view('pos.sales.debtors_summary_report',
            compact('start_date',
                'end_date','data','currency','accounts'));
    }



    public function findQuantity(Request $request)
    {

        $item=$request->item;
        $location=$request->location;
        $date = today()->format('Y-m');

        $item_info=Items::where('id', $item)->first();
        $location_info=Location::find($request->location);

        //a
        if ($item_info->type == '4') {
            $price='' ;
        }
        //b
        else{


            $pqty= PurchaseHistory::where('item_id', $item)->where('location',$location)->where('type', 'Purchases')->where('expire_date', '<',$request->invoice_date)->where('added_by',auth()->user()->added_by)->sum('quantity');
            $dn= PurchaseHistory::where('item_id', $item)->where('location',$location)->where('type', 'Debit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');
            $dgood=StockMovementItem::where('item_id',$item)->where('destination_store',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');

            $sgood=StockMovementItem::where('item_id',$item)->where('source_store',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');
            $issue=GoodIssueItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum(\DB::raw('quantity - returned'));
            $sqty= InvoiceHistory::where('item_id', $item)->where('location',$location)->where('type', 'Sales')->where('added_by',auth()->user()->added_by)->sum('quantity');
            $cn= InvoiceHistory::where('item_id', $item)->where('location',$location)->where('type', 'Credit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');
            $disposal=GoodDisposalItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');

            $qty=$pqty-$dn;
            $inv=$sqty-$cn ;

            //$quantity=($pqty-$dn)-($sqty-$cn);

            $quantity=($qty + $dgood) - ($issue +$inv + $sgood + $disposal);;

//c
            if ($quantity > 0) {

//d
                if($request->id >  $quantity){
                    $price="You have exceeded your Stock. Choose quantity between 0.00 and ".  number_format($quantity,2) ;
                }
                //e
                else if($request->id <=  0){
                    $price="Choose quantity between 0.00 and ".  number_format($quantity,2) ;
                }
//f
                else{
                    $price='' ;
                }

            }

            else{
                $price=$location_info->name . " Stock Balance  is Zero." ;

            }



        }


        return response()->json($price);

    }



    public function uploadImageViaAjax(Request $request)
    {
        $name = [];
        $original_name = [];
        foreach ($request->file('file') as $key => $value) {
            $image = InvoiceController . phpuniqid() . time() . '.' . $value->getClientOriginalExtension();
            $destinationPath = public_path().'/pos/';
            $value->move($destinationPath, $image);
            $name[] = $image;
            $original_name[] = $value->getClientOriginalName();




        }

        return response()->json([
            'name'          => $name,
            'original_name' => $original_name
        ]);
    }


    public function deleteImageViaAjax(Request $request)
    {
        $filename =  $request->get('filename');
        //Gallery::where('filename',$filename)->delete();
        $path = InvoiceController . phppublic_path('pos/') . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success'=>$filename]);
    }


    public function getImageViaAjax(Request $request)
    {
        $images = InvoiceAttachment::all()->where('invoice_id',$request->id)->toArray();
        foreach($images as $image){
            $tableImages[] = $image['filename'];
        }
        $storeFolder = public_path('pos');
        $file_path = public_path('pos');
        $files = scandir($storeFolder);
        foreach ( $files as $file ) {
            if ($file !='.' && $file !='..' && in_array($file,$tableImages)) {
                $og=InvoiceAttachment::where('invoice_id',$request->id)->where('filename',$file)->first();
                $obj['name'] = $og->original_filename;
                $file_path = InvoiceController . phppublic_path('pos/') . $file;
                $obj['size'] = filesize($file_path);
                $obj['path'] = url('public/pos/'.$file);
                $obj['img'] = $file;
                $data[] = $obj;
            }

        }
        //dd($data);
        return response()->json($data);
    }


    public function attachModal(Request $request)
    {

        $id=$request->id;
        $type = $request->type;

        switch ($type) {
            case 'attach':
                $images = InvoiceAttachment::where('invoice_id',$id)->get();
                return view('pos.sales.attachment_modal',compact('id','images'));
                break;

            default:
                break;

        }

    }



    public function save_attachment(Request $request)
    {
        //

        $imgArr =$request->filename ;
        $ogArr =$request->original_filename ;

        if(!empty($imgArr)){
            for($i = 0; $i < count($imgArr); $i++){
                if(!empty($imgArr[$i])){


                    InvoiceAttachment::create([
                        'filename' =>$imgArr[$i],
                        'original_filename' =>$ogArr[$i],
                        'order_no' => $i,
                        'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$request->invoice_id
                    ]);

                }
            }

            return redirect(route('invoice.index'))->with(['success'=>'Uploaded Successfully']);
        }

        else{

            return redirect(route('invoice.index'))->with(['error'=>'No File Uploaded ']);
        }



    }



    public function download_attachment($id)
    {
        $data=InvoiceAttachment::find($id);

        $file = $data->filename;
        $myFile = public_path("pos/".$file);

        $newName = $data->original_filename;

        return response()->download($myFile, $newName);

    }

    public function delete_attachment($id)
    {
        $data=InvoiceAttachment::find($id);
        $filename =  $data->filename;
        $path = InvoiceController . phppublic_path('pos/') . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        $data->delete();

        return redirect(route('invoice.index'))->with(['success'=>'Deleted Successfully']);
    }


    public function save_commission(Request $request)
    {
        //


        $nameArr =$request->user_id ;
        $itemArr =$request->item_name;
        $costArr =  str_replace(",","",$request->total_cost);
        $totalArr =  str_replace(",","",$request->amount);
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;

        $subArr = str_replace(",","",$request->subtotal);



        if(!empty($nameArr)){
            for($i = 0; $i < count($subArr); $i++){
                if(!empty($subArr[$i])){
                    $t = array(
                        'commission_bank'=>   $request->bank_id,
                        'commission' =>  $subArr[$i]);



                    Invoice::where('id',$request->id)->update($t);



                }
            }
        }





        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
                if(!empty($remArr[$i])){
                    DB::table('invoice_commission')->where('id',$remArr[$i])->delete();
                }
            }
        }


        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                    $x=Invoice::find($request->id);

                    $items = array(
                        'user_id' => $nameArr[$i],
                        'invoice_date' =>  $x->invoice_date,
                        'item_name' =>$itemArr[$i],
                        'total_cost' =>$costArr[$i],
                        'amount' =>$totalArr[$i],
                        'bank_id' =>  $request->bank_id,
                        'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$request->id);

                    if(!empty($expArr[$i])){
                        DB::table('invoice_commission')->where('id',$expArr[$i])->update($items);

                    }
                    else{
                        DB::table('invoice_commission')->insert($items);
                    }


                }
            }

        }


        $comm= DB::table('invoice_commission')->where('invoice_id', $request->id)->get();

        JournalEntry::where('income_id',$request->id)->where('transaction_type','pos_commission')->where('added_by', auth()->user()->added_by)->delete();

        foreach($comm as $c){

            $inv = Invoice::find($request->id);
            $staff=User::find($c->user_id);

            $cm= AccountCodes::where('account_name','Sales Commission')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cm->id;
            $date = explode('-',$inv->invoice_date);
            $journal->date =   $inv->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_commission';
            $journal->name = 'Sales Commission';
            $journal->debit = $c->amount *  $inv->exchange_rate;
            $journal->income_id= $inv->id;
            $journal->client_id= $inv->client_id;
            $journal->currency_code =  $inv->exchange_code;
            $journal->exchange_rate= $inv->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->branch_id= $inv->branch_id;
            $journal->notes= "Commission for Sales  Invoice No " .$inv->reference_no ." to user ". $staff->name ;
            $journal->save();



            $journal = new JournalEntry();
            $journal->account_id = $request->bank_id;
            $date = explode('-',$inv->invoice_date);
            $journal->date =   $inv->invoice_date ;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_commission';
            $journal->name = 'Sales Commission';
            $journal->credit =$c->amount *  $inv->exchange_rate;
            $journal->income_id= $inv->id;
            $journal->client_id= $inv->client_id;
            $journal->currency_code =  $inv->exchange_code;
            $journal->exchange_rate= $inv->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
            $journal->branch_id= $inv->branch_id;
            $journal->notes= "Commission for Sales  Invoice No " .$inv->reference_no ." to user ". $staff->name ;
            $journal->save();

        }



        return redirect(route('invoice.index'))->with(['success'=>'Created Successfully']);



    }



    public function commission_report(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;


        //$data = User::whereColumn('added_by', 'id')->get();

        $data = DB::table('users')->leftJoin('invoice_commission', 'invoice_commission.user_id','users.id')
            ->whereBetween('invoice_commission.invoice_date',[$start_date,$end_date])
            ->where('users.added_by',auth()->user()->added_by)
            ->select('users.*','invoice_commission.*')
            ->groupBy('invoice_commission.user_id')
            ->get() ;

        //dd ($data);



        return view('pos.sales.commission_report',
            compact('start_date',
                'end_date','data'));
    }





}