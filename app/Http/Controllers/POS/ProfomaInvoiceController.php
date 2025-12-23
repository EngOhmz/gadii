<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\POS\Activity;
use App\Models\POS\MasterHistory;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\InvoicePayments;
use App\Models\POS\Items;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
use App\Models\SystemDetails;

//use App\Models\invoice_items;
use App\Models\Client;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Response;
use PDF;
use Carbon\Carbon;


use Illuminate\Http\Request;

class ProfomaInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $currency = Currency::all();
        // $invoices = Invoice::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
        // $invoices = Invoice::where('invoice_status', '!=', 6)->where('disabled', 0)->where('added_by', auth()->user()->added_by)->latest()->get();
        
       // $invoices = Invoice::where('invoice_status', '!=', 6)->where('disabled', 0)->latest()->get();
       
      // $invoices = Invoice::where('invoice_status', '!=', 6)->latest()->get();

       // $invoices = Invoice::all();
      
       $invoices = Invoice::latest()->get();

      // dd($invoices->pluck('reference_no'));

        $client = Client::where('owner_id', auth()->user()->added_by)->where('disabled', '0')->get();
        $name = Items::whereIn('type', [1, 2, 4])->where('added_by', auth()->user()->added_by)->where('restaurant',
            '0')->where('disabled', '0')->get();
        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->orderBy('locations.created_at', 'asc')
            ->get();

        $bank_details =SystemDetails::where('added_by',auth()->user()->added_by)->get();
        $user = User::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $type = "";
        $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        return view('pos.sales.profoma_invoice',
            compact('name', 'client', 'currency', 'invoices', 'location', 'type', 'user', 'branch', 'bank_details'));
    }


    public function profoma_add_new_item(Request $request)
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $count = Invoice::where('added_by', auth()->user()->added_by)->count();
        // $pro = $count + 1;
        // $data['reference_no'] = "S0" . $pro;
        
        $pro = str_pad($count + 1, 2, '0', STR_PAD_LEFT);
        $month = date('m');
        $year = date('y');
        $data['reference_no'] = "PI/{$pro}/{$month}/{$year}";

        $data['client_id'] = $request->client_id;
        $data['invoice_date'] = $request->invoice_date;
        $data['due_date'] = $request->due_date;
        $data['location'] = $request->location;
        $data['heading'] = $request->heading;
        $data['supplier_reference'] = $request->supplier_reference;
        $data['notes'] = $request->notes;
        $data['exchange_code'] = $request->exchange_code;
        $data['exchange_rate'] = $request->exchange_rate;
        $data['invoice_amount'] = '1';
        $data['due_amount'] = '1';
        $data['invoice_tax'] = '1';
        $data['branch_id'] = $request->branch_id;
        $data['bank_details_id'] = $request->bank_details_id;
        $data['payment_condition'] = $request->payment_condition;
        $data['delivery_terms'] = $request->delivery_terms;
        // $data['delivery_date'] = $request->delivery_date;
        $data['delivery_date'] = Carbon::parse($request->invoice_date)->addDays(30)->toDateString();
        // $data['status'] = '0';
        $data['status'] = null;
        $data['validity'] = 0; // 0 = open, 1 = closed
        $data['good_receive'] = '0';
        // $data['invoice_status'] = '0';
        $data['invoice_status'] = null;
        $data['user_id'] = auth()->user()->id;
        $data['user_agent'] = $request->user_agent;
        $data['added_by'] = auth()->user()->added_by;

        if ($request->hasFile('profoma_attachment')) {
            $profomaAttachment = $request->file('profoma_attachment');
            $attachmentFileType = $profomaAttachment->getClientOriginalExtension();
            $attachmentFileName = uniqid() . '_profoma_attachment_' . date('dmyhis') . '.' . $attachmentFileType;

            $destinationPath = public_path('uploads/profoma_attachments');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $profomaAttachment->move($destinationPath, $attachmentFileName);

            $data['profoma_attachment'] = 'uploads/profoma_attachments/' . $attachmentFileName;
        } else {
            $data['profoma_attachment'] = null;
        }

        $invoice = Invoice::create($data);

        $nameArr = $request->item_name;
        $descArr = $request->description;
        $qtyArr = $request->quantity;
        $priceArr = str_replace(",", "", $request->price);
        $rateArr = $request->tax_rate;
        $unitArr = $request->unit;
        $costArr = str_replace(",", "", $request->total_cost);
        $taxArr = str_replace(",", "", $request->total_tax);
        $savedArr = $request->item_name;
        $saleTypeArr = $request->sale_type; // Added sale_type array

        $subArr = str_replace(",", "", $request->subtotal);
        $totalArr = str_replace(",", "", $request->tax);
        $amountArr = str_replace(",", "", $request->amount);
//        $disArr = str_replace(",", "", $request->discount);
//        $shipArr = str_replace(",", "", $request->shipping_cost);
        $adjArr = str_replace(",", "", $request->adjustment);

        if (!empty($nameArr)) {
            for ($i = 0; $i < count($amountArr); $i++) {
                if (!empty($amountArr[$i])) {
                    $t = array(
                        'invoice_amount' => $subArr[$i],
                        'invoice_tax' => $totalArr[$i],
//                        'shipping_cost' => $shipArr[$i],
//                        'discount' => $disArr[$i],
                        'adjustment' => $adjArr[$i],
                        'due_amount' => $amountArr[$i]
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
                    // Fetch the item to get crate_size
                    $item = Items::where('id', $nameArr[$i])->first();
                    $crateSize = $item->crate_size ?? 1; // Default to 1 if crate_size is not set

                    // Adjust quantity based on sale_type
                    $adjustedQuantity = $qtyArr[$i];
                    if (isset($saleTypeArr[$i]) && $saleTypeArr[$i] === 'crate') {
                        $adjustedQuantity = $qtyArr[$i] * $crateSize;
                    }

                    $cost['invoice_amount'] += $costArr[$i];
                    $cost['invoice_tax'] += $taxArr[$i];

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'description' => $descArr[$i],
                        'quantity' => $adjustedQuantity, // Use adjusted quantity
                        'due_quantity' => $adjustedQuantity, // Use adjusted quantity
                        'tax_rate' => $rateArr[$i],
                        'unit' => $unitArr[$i],
                        'price' => $priceArr[$i],
                        'total_cost' => $costArr[$i],
                        'total_tax' => $taxArr[$i],
                        'items_id' => $savedArr[$i],
                        'order_no' => $i,
                        'added_by' => auth()->user()->added_by,
                        'invoice_id' => $invoice->id,
                        'sale_type' => $saleTypeArr[$i] ?? 'qty' // Store the sale_type
                    );

                    InvoiceItems::create($items);
                }
            }
            $cost['due_amount'] = $cost['invoice_amount'] + $cost['invoice_tax'];
            Invoice::where('id', $invoice->id)->update($cost); // Update Invoice instead of InvoiceItems
        }

        if (!empty($invoice)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'module_id' => $invoice->id,
                'module' => 'Proforma Invoice',
                'activity' => "Proforma Invoice with reference no " . $invoice->reference_no . " is Created",
            ]);
        }

        return redirect(route('profoma_invoice.show', $invoice->id))->with(['success' => 'Created Successfully']);
    }

    public function profoma_approve($id)
    {
        
        $invoice = Invoice::find($id);
        $data['status'] = 0;
        $data['invoice_status'] = 0;
        $invoice->update($data);
       
        return redirect(route('profoma_invoice.index'))->with(['success' => 'Profoma Invoice Approved Successfully']);
    }

    public function close_profoma($id)
    {
        
        $invoice = Invoice::find($id);
        $data['validity'] = 1;
        $invoice->update($data);
       
        return redirect(route('profoma_invoice.index'))->with(['success' => 'Profoma Invoice Closed Successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //

        if ($request->edit_type == 'receive') {
            $invoice = Invoice::find($id);
            $data['client_id'] = $request->client_id;
            $data['invoice_date'] = $request->invoice_date;
            $data['due_date'] = $request->due_date;
            $data['location'] = $request->location;
            $data['notes'] = $request->notes;
            $data['exchange_code'] = $request->exchange_code;
            $data['exchange_rate'] = $request->exchange_rate;
            
            // Generate new unique reference number starting with INV for invoice
            $month = date('m');
            $year = date('y');
            $pro = 1;
            do {
                $number = str_pad($pro, 2, '0', STR_PAD_LEFT);
                $newReferenceNo = "INV/{$number}/{$month}/{$year}";
                $exists = Invoice::where('added_by', auth()->user()->added_by)
                    ->where('reference_no', $newReferenceNo)
                    ->where('id', '!=', $id)
                    ->exists();
                if (!$exists) {
                    break;
                }
                $pro++;
            } while (true);
            $data['reference_no'] = $newReferenceNo;
            
            $data['invoice_amount'] = '1';
            $data['due_amount'] = '1';
            $data['invoice_tax'] = '1';
            $data['good_receive'] = '1';
            $data['invoice_status'] = '1';
            $data['user_agent'] = $request->user_agent;
            $data['sales_type'] = 'Credit Sales';
            $data['status'] = '1';
            $data['added_by'] = auth()->user()->added_by;

            $invoice->update($data);


            $nameArr = $request->item_name;
            $descArr = $request->description;
            $qtyArr = $request->quantity;
            $priceArr = str_replace(",", "", $request->price);
            $rateArr = $request->tax_rate;
            $unitArr = $request->unit;
            $costArr = str_replace(",", "", $request->total_cost);
            $taxArr = str_replace(",", "", $request->total_tax);
            $remArr = $request->removed_id;
            $expArr = $request->saved_items_id;
            $savedArr = $request->item_name;


            $subArr = str_replace(",", "", $request->subtotal);
            $totalArr = str_replace(",", "", $request->tax);
            $amountArr = str_replace(",", "", $request->amount);
//            $disArr = str_replace(",", "", $request->discount);
//            $shipArr = str_replace(",", "", $request->shipping_cost);
            $adjArr = str_replace(",", "", $request->adjustment);

            if (!empty($nameArr)) {
                for ($i = 0; $i < count($amountArr); $i++) {
                    if (!empty($amountArr[$i])) {
                        $t = array(
                            'invoice_amount' => $subArr[$i],
                            'invoice_tax' => $totalArr[$i],
//                            'shipping_cost' => $shipArr[$i],
//                            'discount' => $disArr[$i],
                            'adjustment' => $adjArr[$i],
                            'due_amount' => $amountArr[$i]
                        );

                        Invoice::where('id', $invoice->id)->update($t);


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
                            'quantity' => $qtyArr[$i],
                            'due_quantity' => $qtyArr[$i],
                            'tax_rate' => $rateArr [$i],
                            'unit' => $unitArr[$i],
                            'price' => $priceArr[$i],
                            'total_cost' => $costArr[$i],
                            'total_tax' => $taxArr[$i],
                            'items_id' => $savedArr[$i],
                            'order_no' => $i,
                            'added_by' => auth()->user()->added_by,
                            'invoice_id' => $id
                        );

                        if (!empty($expArr[$i])) {
                            InvoiceItems::where('id', $expArr[$i])->update($items);

                        } else {
                            InvoiceItems::create($items);
                        }


                    }
                }
                $cost['due_amount'] = $cost['invoice_amount'] + $cost['invoice_tax'];

            }


            if (!empty($nameArr)) {
                for ($i = 0; $i < count($nameArr); $i++) {
                    if (!empty($nameArr[$i])) {

                        $lists = array(
                            'quantity' => $qtyArr[$i],
                            'price' => $priceArr[$i],
                            'item_id' => $savedArr[$i],
                            'added_by' => auth()->user()->added_by,
                            'client_id' => $data['client_id'],
                            'location' => $data['location'],
                            'invoice_date' => $data['invoice_date'],
                            'type' => 'Sales',
                            'invoice_id' => $id
                        );


                        InvoiceHistory::create($lists);


                        $mlists = [
                            'out' => $qtyArr[$i],
                            'price' => $priceArr[$i],
                            'item_id' => $savedArr[$i],
                            'added_by' => auth()->user()->added_by,
                            'client_id' => $data['client_id'],
                            'location' => $data['location'],
                            'date' => $data['invoice_date'],
                            'type' => 'Sales',
                            'invoice_id' => $invoice->id,
                        ];

                        MasterHistory::create($mlists);

                        $inv = Items::where('id', $nameArr[$i])->first();
                        if ($inv->type != '4') {
                            $q = $inv->quantity - $qtyArr[$i];
                            Items::where('id', $nameArr[$i])->update(['quantity' => $q]);

                            $loc = Location::where('id', $invoice->location)->first();
                            $lq['quantity'] = $loc->quantity - $qtyArr[$i];
                            Location::where('id', $invoice->location)->update($lq);

                            /*
                            $date = today()->format('Y-m');

                       $chk=SerialList::where('brand_id',$nameArr[$i])->where('location',$invoice->location)->where('added_by',auth()->user()->added_by)->where('status','0')->where('expire_date', '>=', $date)
                       ->orWhereNull('expire_date')->where('brand_id',$nameArr[$i])->where('location',$invoice->location)->where('added_by',auth()->user()->added_by)->where('status','0')->take($qtyArr[$i])->update(['status'=> '2','invoice_id'=>$invoice->id]) ;
                           */
                        }
                    }
                }

            }


            $total_cost = 0;

            $x_items = InvoiceItems::where('invoice_id', $invoice->id)->get();
            foreach ($x_items as $x) {
                $a = Items::where('id', $x->item_name)->first();
                if ($a->type == '4') {
                    $total_cost = 0;
                } else {
                    $total_cost += $a->cost_price * $x->quantity;
                }

            }


            $inv = Invoice::find($id);
            $supp = Client::find($inv->client_id);

            $cr = AccountCodes::where('account_name', 'Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $cr->id;
            $date = explode('-', $inv->invoice_date);
            $journal->date = $inv->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice';
            $journal->name = 'Invoice';
            $journal->credit = $inv->invoice_amount * $inv->exchange_rate;
            $journal->income_id = $inv->id;
            $journal->client_id = $inv->client_id;
            $journal->currency_code = $inv->exchange_code;
            $journal->exchange_rate = $inv->exchange_rate;
            $journal->branch_id = $inv->branch_id;
            $journal->added_by = auth()->user()->added_by;
            $journal->notes = "Sales for Invoice No " . $inv->reference_no . " to Client " . $supp->name;
            $journal->save();

            if ($inv->invoice_tax > 0) {
                $tax = AccountCodes::where('account_name', 'VAT OUT')->where('added_by',
                    auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $tax->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date = $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->credit = $inv->invoice_tax * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->branch_id = $inv->branch_id;
                $journal->notes = "Sales Tax for Invoice No " . $inv->reference_no . " to Client " . $supp->name;
                $journal->branch_id = $inv->branch_id;
                $journal->save();
            }

            $codes = AccountCodes::where('account_name', 'Receivable and Prepayments')->where('added_by',
                auth()->user()->added_by)->first();
            $journal = new JournalEntry();
            $journal->account_id = $codes->id;
            $date = explode('-', $inv->invoice_date);
            $journal->date = $inv->invoice_date;
            $journal->year = $date[0];
            $journal->month = $date[1];
            $journal->transaction_type = 'pos_invoice';
            $journal->name = 'Invoice';
            $journal->income_id = $inv->id;
            $journal->client_id = $inv->client_id;
            $journal->debit = $inv->due_amount * $inv->exchange_rate;
            $journal->currency_code = $inv->exchange_code;
            $journal->exchange_rate = $inv->exchange_rate;
            $journal->added_by = auth()->user()->added_by;
            $journal->branch_id = $inv->branch_id;
            $journal->notes = "Receivables for Sales Invoice No " . $inv->reference_no . " to Client " . $supp->name;
            $journal->save();


            if ($total_cost > 0) {
                $stock = AccountCodes::where('account_name', 'Inventory')->where('added_by',
                    auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $stock->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date = $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->credit = $total_cost;
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->branch_id = $inv->branch_id;
                $journal->notes = "Reduce Stock  for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name;
                $journal->save();

                $cos = AccountCodes::where('account_name', 'Cost of Goods Sold')->where('added_by',
                    auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $cos->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date = $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->debit = $total_cost;
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->branch_id = $inv->branch_id;
                $journal->notes = "Cost of Goods Sold  for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name;
                $journal->save();
            }


            if ($inv->discount > 0) {
                $cr = AccountCodes::where('account_name', 'Sales')->where('added_by',
                    auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $cr->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date = $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->debit = $inv->discount * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->branch_id = $inv->branch_id;
                $journal->notes = "Sales Discount for for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name;
                $journal->save();


                $disc = AccountCodes::where('account_name', 'Sales Discount')->where('added_by',
                    auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $disc->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date = $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->credit = $inv->discount * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->branch_id = $inv->branch_id;
                $journal->notes = "Sales Discount for for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name;
                $journal->save();

            }


            if ($inv->shipping_cost > 0) {


                $shp = AccountCodes::where('account_name', 'Shipping Cost')->where('added_by',
                    auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $shp->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date = $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->debit = $inv->shipping_cost * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->branch_id = $inv->branch_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = "Shipping Cost for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name;
                $journal->save();

                $pc = AccountCodes::where('account_name', 'Payables')->where('added_by',
                    auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $pc->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date = $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->credit = $inv->shipping_cost * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->branch_id = $inv->branch_id;
                $journal->notes = "Sales Shipping Cost for Sales Invoice No " . $inv->reference_no . " to Client " . $supp->name;
                $journal->save();


            }

            if (!empty($inv->adjustment) && $inv->adjustment != '0') {
                $cr = AccountCodes::where('account_name', 'Sales')->where('added_by',
                    auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $cr->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date = $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->debit = $inv->adjustment * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->branch_id = $inv->branch_id;
                $journal->notes = "Sales Adjustment for for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name;
                $journal->save();


                $adj = AccountCodes::where('account_name', 'Adjustment')->where('added_by',
                    auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $adj->id;
                $date = explode('-', $inv->invoice_date);
                $journal->date = $inv->invoice_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_invoice';
                $journal->name = 'Invoice';
                $journal->credit = $inv->adjustment * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->client_id = $inv->client_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->branch_id = $inv->branch_id;
                $journal->notes = "Sales Adjustment for for Sales  Invoice No " . $inv->reference_no . " to Client " . $supp->name;
                $journal->save();

            }


            if (!empty($invoice)) {
                $activity = Activity::create(
                    [
                        'added_by' => auth()->user()->added_by,
                        'user_id' => auth()->user()->id,
                        'module_id' => $id,
                        'module' => 'Proforma Invoice',
                        'activity' => "Proforma Invoice with reference no  " . $invoice->reference_no . "  is  converted to Invoice",
                    ]
                );
            }

            return redirect(route('invoice.show', $id))->with(['success' => 'Converted  Successfully']);


        } else {
            $invoice = Invoice::find($id);
            $data['client_id'] = $request->client_id;
            $data['invoice_date'] = $request->invoice_date;
            $data['due_date'] = $request->due_date;
            $data['location'] = $request->location;
            $data['heading'] = $request->heading;
            $data['supplier_reference'] = $request->supplier_reference;
            $data['notes'] = $request->notes;
            $data['exchange_code'] = $request->exchange_code;
            $data['exchange_rate'] = $request->exchange_rate;
            $data['invoice_amount'] = '1';
            $data['due_amount'] = '1';
            $data['invoice_tax'] = '1';
            $data['user_agent'] = $request->user_agent;
            $data['added_by'] = auth()->user()->added_by;

        if ($request->hasFile('profoma_attachment')) {
            if (!empty($invoice->profoma_attachment) && file_exists(public_path($invoice->profoma_attachment))) {
                @unlink(public_path($invoice->profoma_attachment));
            }

            $profomaAttachment = $request->file('profoma_attachment');
            $attachmentFileType = $profomaAttachment->getClientOriginalExtension();
            $attachmentFileName = uniqid() . '_profoma_attachment_' . date('dmyhis') . '.' . $attachmentFileType;

            $destinationPath = public_path('uploads/profoma_attachments');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $profomaAttachment->move($destinationPath, $attachmentFileName);

            $data['profoma_attachment'] = 'uploads/profoma_attachments/' . $attachmentFileName;
        }

            $invoice->update($data);


            $nameArr = $request->item_name;
            $descArr = $request->description;
            $qtyArr = $request->quantity;
            $priceArr = str_replace(",", "", $request->price);
            $rateArr = $request->tax_rate;
            $unitArr = $request->unit;
            $costArr = str_replace(",", "", $request->total_cost);
            $taxArr = str_replace(",", "", $request->total_tax);
            $remArr = $request->removed_id;
            $expArr = $request->saved_items_id;
            $savedArr = $request->item_name;


            $subArr = str_replace(",", "", $request->subtotal);
            $totalArr = str_replace(",", "", $request->tax);
            $amountArr = str_replace(",", "", $request->amount);
//            $disArr = str_replace(",", "", $request->discount);
//            $shipArr = str_replace(",", "", $request->shipping_cost);
            $adjArr = str_replace(",", "", $request->adjustment);

            if (!empty($nameArr)) {
                for ($i = 0; $i < count($amountArr); $i++) {
                    if (!empty($amountArr[$i])) {
                        $t = array(
                            'invoice_amount' => $subArr[$i],
                            'invoice_tax' => $totalArr[$i],
//                            'shipping_cost' => $shipArr[$i],
//                            'discount' => $disArr[$i],
                            'adjustment' => $adjArr[$i],
                            'due_amount' => $amountArr[$i]
                        );

                        Invoice::where('id', $invoice->id)->update($t);


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
                            'quantity' => $qtyArr[$i],
                            'due_quantity' => $qtyArr[$i],
                            'tax_rate' => $rateArr [$i],
                            'unit' => $unitArr[$i],
                            'price' => $priceArr[$i],
                            'total_cost' => $costArr[$i],
                            'total_tax' => $taxArr[$i],
                            'items_id' => $savedArr[$i],
                            'order_no' => $i,
                            'added_by' => auth()->user()->added_by,
                            'invoice_id' => $id
                        );

                        if (!empty($expArr[$i])) {
                            InvoiceItems::where('id', $expArr[$i])->update($items);

                        } else {
                            InvoiceItems::create($items);
                        }

                    }
                }
                $cost['due_amount'] = $cost['invoice_amount'] + $cost['invoice_tax'];

            }


            if (!empty($invoice)) {
                $activity = Activity::create(
                    [
                        'added_by' => auth()->user()->added_by,
                        'user_id' => auth()->user()->id,
                        'module_id' => $id,
                        'module' => 'Proforma Invoice',
                        'activity' => "Proforma Invoice with reference no  " . $invoice->reference_no . "  is Updated",
                    ]
                );
            }


            return redirect(route('profoma_invoice.show', $id))->with(['success' => 'Updated Successfully']);

        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
        $invoices = Invoice::find($id);
        $invoice_items = InvoiceItems::where('invoice_id', $id)->get();
        $payments = InvoicePayments::where('invoice_id', $id)->get();

        return view('pos.sales.profoma_invoice_details', compact('invoices', 'invoice_items', 'payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
        $currency = Currency::all();
        $client = Client::where('owner_id', auth()->user()->added_by)->where('disabled', '0')->get();
        $name = Items::whereIn('type', [1, 2, 4])->where('added_by', auth()->user()->added_by)->where('restaurant',
            '0')->where('disabled', '0')->get();
        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->orderBy('locations.created_at', 'asc')
            ->get();
        $data = Invoice::find($id);
        $items = InvoiceItems::where('invoice_id', $id)->get();
        $type = "";
        $user = User::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        return view('pos.sales.profoma_invoice',
            compact('name', 'client', 'currency', 'location', 'data', 'id', 'items', 'type', 'user', 'branch'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {

        InvoiceItems::where('invoice_id', $id)->delete();
        InvoicePayments::where('invoice_id', $id)->delete();


        $invoices = Invoice::find($id);
        if (!empty($invoices)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Proforma Invoice',
                    'activity' => "Proforma Invoice with reference no  " . $invoices->reference_no . "  is Deleted",
                ]
            );
        }

        $invoices->delete();
        return redirect(route('profoma_invoice.index'))->with(['success' => 'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
        $price = Items::where('id', $request->id)->get();
        return response()->json($price);

    }

    public function discountModal(Request $request)
    {

    }


    public function approve($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 1;
        $invoice->update($data);
        if (!empty($invoice)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Proforma Invoice',
                    'activity' => "Proforma Invoice with reference no  " . $invoice->reference_no . "  is Approved",
                ]
            );
        }
        return redirect(route('invoice.index'))->with(['success' => 'Approved Successfully']);
    }

    public function convert_to_invoice($id)
    {
        //

        $currency = Currency::all();
        $client = Client::where('owner_id', auth()->user()->added_by)->where('disabled', '0')->get();
        $name = Items::whereIn('type', [1, 2, 4])->where('added_by', auth()->user()->added_by)->where('restaurant',
            '0')->where('disabled', '0')->get();
        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->orderBy('locations.created_at', 'asc')
            ->get();
        $data = Invoice::find($id);
        $items = InvoiceItems::where('invoice_id', $id)->get();
        $type = "receive";
        $user = User::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        return view('pos.sales.profoma_invoice',
            compact('name', 'client', 'currency', 'location', 'data', 'id', 'items', 'type', 'user', 'branch'));


    }

    public function cancel($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 4;
        $invoice->update($data);

        if (!empty($invoice)) {
            $activity = Activity::create(
                [
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Proforma Invoice',
                    'activity' => "Proforma Invoice with reference no  " . $invoice->reference_no . "  is  Cancelled",
                ]
            );
        }
        return redirect(route('invoice.index'))->with(['success' => 'Cancelled Successfully']);
    }


    public function receive($id)
    {
        //
        $currency = Currency::all();
        $client = Client::where('user_id', auth()->user()->added_by)->get();
        $name = Items::where('added_by', auth()->user()->added_by)->get();
        $location = Location::where('added_by', auth()->user()->added_by)->get();
        $data = Invoice::find($id);
        $items = InvoiceItems::where('invoice_id', $id)->get();
        $type = "receive";
        return view('pos.invoices.index',
            compact('name', 'client', 'currency', 'location', 'data', 'id', 'items', 'type'));
    }

    public function inventory_list()
    {
        //
        $tyre = InventoryList::all();
        return view('inventory.list', compact('tyre'));
    }

    public function make_payment($id)
    {
        //
        $invoice = Invoice::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts = AccountCodes::where('account_group', 'Cash and Cash Equivalent')->get();
        return view('pos.invoices.invoice_payments', compact('invoice', 'payment_method', 'bank_accounts'));
    }

    public function invoice_pdfview(Request $request)
    {
        //
        $invoices = Invoice::find($request->id);
        $invoice_items = InvoiceItems::where('invoice_id', $request->id)->get();

        view()->share(['invoices' => $invoices, 'invoice_items' => $invoice_items]);

        if ($request->has('download')) {
            $pdf = PDF::loadView('pos.sales.profoma_invoice_pdf')->setPaper('a4', 'portrait');
            
            // Get dompdf instance and add page numbers
            $dompdf = $pdf->getDomPDF();
            $canvas = $dompdf->getCanvas();
            
            // Add page numbers - this will be executed for each page
            $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
                $font = $fontMetrics->get_font("helvetica", "normal");
                $size = 8;

                // Page number (right aligned at bottom)
                $pageText = "Page $pageNumber of $pageCount";
                $pageWidth = $fontMetrics->get_text_width($pageText, $font, $size);
                $xPage = $canvas->get_width() - $pageWidth - 20; // right margin
                $yPage = $canvas->get_height() - 20; // push up from bottom
                $canvas->text($xPage, $yPage, $pageText, $font, $size, [0, 0, 0]);
            });
            
            return $pdf->download('PROFORMA INV NO # ' . $invoices->reference_no . ".pdf");
        }
        return view('inv_pdfview');
    }
}

