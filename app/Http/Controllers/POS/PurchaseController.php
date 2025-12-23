<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\Activity;
use App\Models\POS\MasterHistory;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\PurchasePayments;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
//use App\Models\Purchase_items;
use App\Models\PurchaseInventory;
use App\Models\PurchaseItemInventory;
use App\Models\Supplier;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\POS\Purchase;
use App\Models\POS\PurchaseItems;
use App\Models\POS\SerialList;
use App\Models\POS\Items;
use App\Models\POS\Category ;
use App\Models\POS\Color ;
use App\Models\POS\Size ;
use App\Models\Branch;
use App\Models\User;
use PDF;
use DB;
use App\Models\MechanicalItem;
use App\Models\MechanicalRecommedation;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $currency = Currency::all();
        $purchases = Purchase::where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();
        
        $branch = Branch::where('added_by', auth()->user()->added_by)
            ->where('disabled', '0')
            ->get();


        // dd($branch);

        $supplier = Supplier::where('user_id', auth()->user()->added_by)
            ->where('disabled', '0')
            ->get();
        $name = Items::whereIn('type', [1, 3, 6])
            ->where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();
        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $user = User::where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();
        $type = '';
        
         $pos_purchase= Purchase::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw(' ((purchase_amount + purchase_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= Purchase::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= Purchase::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->count();
         $unpaid= Purchase::where('added_by',auth()->user()->added_by)->where('status','1')->count();
         $part= Purchase::where('added_by',auth()->user()->added_by)->where('status','2')->count();
         $paid= Purchase::where('added_by',auth()->user()->added_by)->where('status','3')->count();
         
        return view('pos.purchases.index', compact('name', 'supplier', 'currency', 'purchases', 'location', 'type', 'user', 'branch',
       'pos_purchase','pos_due','total','unpaid','part','paid'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $count = Purchase::where('added_by', auth()->user()->added_by)->count();
        $pro = $count + 1;
        $data['reference_no'] = 'P0' . $pro;
        $data['supplier_id'] = $request->supplier_id;
        $data['purchase_date'] = $request->purchase_date;
        $data['due_date'] = $request->due_date;
        $data['location'] = $request->location;
        $data['exchange_code'] = $request->exchange_code;
        $data['exchange_rate'] = $request->exchange_rate;
        $data['delivery_terms'] = $request->delivery_terms;
        $data['payment_terms'] = $request->payment_terms;
        $data['branch_id'] = $request->branch_id;
        $data['purchase_amount'] = '1';
        $data['due_amount'] = '1';
        $data['purchase_tax'] = '1';
        $data['status'] = '0';
        $data['good_receive'] = '0';
        $data['branch_id'] = $request->branch_id;
        $data['supplier_reference'] = $request->supplier_reference;
        $data['purchase_heading'] = $request->purchase_heading;
        $data['user_agent'] = $request->user_agent;
        $data['user_id'] = auth()->user()->id;
        $data['added_by'] = auth()->user()->added_by;


         if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $attachmentFileType = $attachment->getClientOriginalExtension();
            $attachmentFileName = uniqid() . '_attachment_' . date('dmyhis') . '.' . $attachmentFileType;
            $destinationPath = public_path();
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $attachment->move($destinationPath, $attachmentFileName);
            $data['attachment'] = $attachmentFileName;
        } else {
            $data['attachment'] = null;
        }

        $purchase = Purchase::create($data);

        $nameArr = $request->item_name;
        $descArr = $request->description;
        $qtyArr = $request->quantity;
        $priceArr = str_replace(",","",$request->price) ;
        $rateArr = $request->tax_rate;
        $unitArr = $request->unit;
        $costArr = str_replace(',', '', $request->total_cost);
        $taxArr = str_replace(',', '', $request->total_tax);
        $savedArr = $request->item_name;

        $subArr = str_replace(',', '', $request->subtotal);
        $totalArr = str_replace(',', '', $request->tax);
        $amountArr = str_replace(',', '', $request->amount);
        $disArr = str_replace(',', '', $request->discount);
        $shipArr = str_replace(',', '', $request->shipping_cost);

        if (!empty($nameArr)) {
            for ($i = 0; $i < count($amountArr); $i++) {
                if (!empty($amountArr[$i])) {
                    $t = [
                        'purchase_amount' => $subArr[$i],
                        'purchase_tax' => $totalArr[$i],
                        'shipping_cost' => $shipArr[$i],
                        'discount' => $disArr[$i],
                        'due_amount' => $amountArr[$i],
                    ];

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

                    $items = [
                        'item_name' => $nameArr[$i],
                        'description' => $descArr[$i],
                        'quantity' => $qtyArr[$i],
                        'due_quantity' => $qtyArr[$i],
                        'tax_rate' => $rateArr[$i],
                        'unit' => $unitArr[$i],
                        'price' => $priceArr[$i],
                        'total_cost' => $costArr[$i],
                        'total_tax' => $taxArr[$i],
                        'items_id' => $savedArr[$i],
                        'order_no' => $i,
                        'added_by' => auth()->user()->added_by,
                        'purchase_id' => $purchase->id,
                    ];

                    PurchaseItems::create($items);
                }
            }
            $cost['due_amount'] = $cost['purchase_amount'] + $cost['purchase_tax'];
            PurchaseItems::where('id', $purchase->id)->update($cost);
        }

        if (!empty($purchase)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'module_id' => $purchase->id,
                'module' => 'Purchase',
                'activity' => 'Purchase with reference no ' . $purchase->reference_no . '  is Created',
            ]);
        }

        return redirect(route('purchase.show', $purchase->id))->with(['success' => 'Created Successfully']);
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
        $purchases = Purchase::find($id);
        $purchase_items = PurchaseItems::where('purchase_id', $id)
            ->where('due_quantity', '>', '0')
            ->get();
        $payments = PurchasePayments::where('purchase_id', $id)->get();
        
        $dn=AccountCodes::where('account_name','Debit Note Control')->where('added_by',auth()->user()->added_by)->first();
        if(!empty($dn)){
        
         $added_by = auth()->user()->added_by;
        
        $a = "SELECT pos_return_purchases.reference_no,pos_return_purchases.return_date,journal_entries.credit,pos_return_purchases.bank_id,journal_entries.id FROM pos_return_purchases INNER JOIN journal_entries ON pos_return_purchases.id=journal_entries.income_id 
        INNER JOIN pos_purchases ON pos_return_purchases.purchase_id = pos_purchases.id WHERE pos_return_purchases.added_by = '".$added_by."' AND pos_purchases.id = '".$id."' AND journal_entries.account_id = '".$dn->id."' AND journal_entries.transaction_type = 'pos_debit_note' ";
        
        $deposits = DB::select($a);
        }
        
        else{
            $deposits=[];
        }
        

        return view('pos.purchases.purchase_details', compact('purchases', 'purchase_items', 'payments','deposits'));
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
        $currency = Currency::all();
        $supplier = Supplier::where('user_id', auth()->user()->added_by)
            ->where('disabled', '0')
            ->get();
        $name = Items::whereIn('type', [1, 3, 6])
            ->where('added_by', auth()->user()->added_by)
            ->where('disabled', '0')
            ->get();
        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $data = Purchase::find($id);
        $items = PurchaseItems::where('purchase_id', $id)->get();
        $type = '';
        $user = User::where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();
        $branch = Branch::where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();
            
            
         $pos_purchase= Purchase::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw(' ((purchase_amount + purchase_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= Purchase::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= Purchase::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->count();
         $unpaid= Purchase::where('added_by',auth()->user()->added_by)->where('status','1')->count();
         $part= Purchase::where('added_by',auth()->user()->added_by)->where('status','2')->count();
         $paid= Purchase::where('added_by',auth()->user()->added_by)->where('status','3')->count();
         
       
        return view('pos.purchases.index', compact('name', 'supplier', 'currency', 'location', 'data', 'id', 'items', 'type', 'user', 'branch',
       'pos_purchase','pos_due','total','unpaid','part','paid'));
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

        if ($request->edit_type == 'receive') {
            $purchase = Purchase::find($id);
            $data['supplier_id'] = $request->supplier_id;
            $data['purchase_date'] = $request->purchase_date;
            $data['due_date'] = $request->due_date;
            $data['location'] = $request->location;
            $data['delivery_terms'] = $request->delivery_terms;
            $data['payment_terms'] = $request->payment_terms;
            $data['exchange_code'] = $request->exchange_code;
            $data['exchange_rate'] = $request->exchange_rate;
            $data['approval_date'] = date('Y-m-d');
            $data['purchase_amount'] = '1';
            $data['due_amount'] = '1';
            $data['purchase_tax'] = '1';
            $data['status'] = '1';
            $data['user_agent'] = $request->user_agent;
            $data['added_by'] = auth()->user()->added_by;
            $data['supplier_reference'] = $request->supplier_reference;
            $data['purchase_heading'] = $request->purchase_heading;
            
            
            if ($request->hasFile('attachment')) {
                    $attachment = $request->file('attachment');
                    $attachmentFileType = $attachment->getClientOriginalExtension();
                    $attachmentFileName = uniqid() . '_attachment_' . date('dmyhis') . '.' . $attachmentFileType;
                    $destinationPath = public_path();
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    $attachment->move($destinationPath, $attachmentFileName);
                    $data['attachment'] = $attachmentFileName;
                } else {
                    $data['attachment'] = null;
                }

            $purchase->update($data);

            $nameArr = $request->item_name;
            $descArr = $request->description;
            $qtyArr = $request->quantity;
            $priceArr = str_replace(",","",$request->price);
            $rateArr = $request->tax_rate;
            $unitArr = $request->unit;
            $costArr = str_replace(',', '', $request->total_cost);
            $taxArr = str_replace(',', '', $request->total_tax);
            $remArr = $request->removed_id;
            $expArr = $request->saved_items_id;
            $savedArr = $request->item_name;

            $subArr = str_replace(',', '', $request->subtotal);
            $totalArr = str_replace(',', '', $request->tax);
            $amountArr = str_replace(',', '', $request->amount);
            $disArr = str_replace(',', '', $request->discount);
            $shipArr = str_replace(',', '', $request->shipping_cost);

            if (!empty($nameArr)) {
                for ($i = 0; $i < count($amountArr); $i++) {
                    if (!empty($amountArr[$i])) {
                        $t = [
                            'purchase_amount' => $subArr[$i],
                            'purchase_tax' => $totalArr[$i],
                            'shipping_cost' => $shipArr[$i],
                            'discount' => $disArr[$i],
                            'due_amount' => $amountArr[$i],
                        ];

                        Purchase::where('id', $id)->update($t);
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

                        $items = [
                            'item_name' => $nameArr[$i],
                            'description' => $descArr[$i],
                            'quantity' => $qtyArr[$i],
                            'due_quantity' => $qtyArr[$i],
                            'tax_rate' => $rateArr[$i],
                            'unit' => $unitArr[$i],
                            'price' => $priceArr[$i],
                            'total_cost' => $costArr[$i],
                            'total_tax' => $taxArr[$i],
                            'items_id' => $savedArr[$i],
                            'order_no' => $i,
                            'added_by' => auth()->user()->added_by,
                            'purchase_id' => $id,
                        ];

                        if (!empty($expArr[$i])) {
                            PurchaseItems::where('id', $expArr[$i])->update($items);
                        } else {
                            PurchaseItems::create($items);
                        }
                    }
                }
            }

            $inv = Purchase::find($id);
            $supp = Supplier::find($inv->supplier_id);

            if ($inv->discount > 0) {
                $disc = AccountCodes::where('account_name', 'Purchase Discount')
                    ->where('added_by', auth()->user()->added_by)
                    ->first();
                $journal = new JournalEntry();
                $journal->account_id = $disc->id;
                $date = explode('-', $inv->purchase_date);
                $journal->date = $inv->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_purchase';
                $journal->name = 'Purchases';
                $journal->debit = $inv->discount * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                $journal->branch_id = $inv->branch_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Purchase Discount for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();

                $cr = AccountCodes::where('account_name', 'Inventory')
                    ->where('added_by', auth()->user()->added_by)
                    ->first();
                $journal = new JournalEntry();
                $journal->account_id = $cr->id;
                $date = explode('-', $inv->purchase_date);
                $journal->date = $inv->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_purchase';
                $journal->name = 'Purchases';
                $journal->credit = $inv->discount * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                 $journal->branch_id = $inv->branch_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Purchase Discount for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();
            }

            if ($inv->shipping_cost > 0) {
                $shp = AccountCodes::where('account_name', 'Shipping Cost')
                    ->where('added_by', auth()->user()->added_by)
                    ->first();
                $journal = new JournalEntry();
                $journal->account_id = $shp->id;
                $date = explode('-', $inv->purchase_date);
                $journal->date = $inv->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_purchase';
                $journal->name = 'Purchases';
                $journal->debit = $inv->shipping_cost * $inv->exchange_rate;
                $journal->income_id = $inv->id;
                 $journal->branch_id = $inv->branch_id;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Purchase Shipping Cost for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();

                $codes = AccountCodes::where('account_name', 'Payables')
                    ->where('added_by', auth()->user()->added_by)
                    ->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                $date = explode('-', $inv->purchase_date);
                $journal->date = $inv->purchase_date;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'pos_purchase';
                $journal->name = 'Purchases';
                $journal->income_id = $inv->id;
                 $journal->branch_id = $inv->branch_id;
                $journal->credit = $inv->shipping_cost * $inv->exchange_rate;
                $journal->currency_code = $inv->exchange_code;
                $journal->exchange_rate = $inv->exchange_rate;
                $journal->added_by = auth()->user()->added_by;
                $journal->notes = 'Credit Shipping Cost for Purchase Order  ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                $journal->save();
            }

            if (!empty($purchase)) {
                $activity = Activity::create([
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Purchase',
                    'activity' => 'Purchase with reference no ' . $purchase->reference_no . ' is Approved',
                ]);
            }
            return redirect(route('purchase.show', $id))->with(['success' => 'Approved Successfully']);
        } else {
            $purchase = Purchase::find($id);
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
            $priceArr = str_replace(",","",$request->price) ;;
            $rateArr = $request->tax_rate;
            $unitArr = $request->unit;
            $costArr = str_replace(',', '', $request->total_cost);
            $taxArr = str_replace(',', '', $request->total_tax);
            $remArr = $request->removed_id;
            $expArr = $request->saved_items_id;
            $savedArr = $request->item_name;

            $subArr = str_replace(',', '', $request->subtotal);
            $totalArr = str_replace(',', '', $request->tax);
            $amountArr = str_replace(',', '', $request->amount);
            $disArr = str_replace(',', '', $request->discount);
            $shipArr = str_replace(',', '', $request->shipping_cost);

            if (!empty($nameArr)) {
                for ($i = 0; $i < count($amountArr); $i++) {
                    if (!empty($amountArr[$i])) {
                        $t = [
                            'purchase_amount' => $subArr[$i],
                            'purchase_tax' => $totalArr[$i],
                            'shipping_cost' => $shipArr[$i],
                            'discount' => $disArr[$i],
                            'due_amount' => $amountArr[$i],
                        ];

                        Purchase::where('id', $id)->update($t);
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

                        $items = [
                            'item_name' => $nameArr[$i],
                            'description' => $descArr[$i],
                            'quantity' => $qtyArr[$i],
                            'due_quantity' => $qtyArr[$i],
                            'tax_rate' => $rateArr[$i],
                            'unit' => $unitArr[$i],
                            'price' => $priceArr[$i],
                            'total_cost' => $costArr[$i],
                            'total_tax' => $taxArr[$i],
                            'items_id' => $savedArr[$i],
                            'order_no' => $i,
                            'added_by' => auth()->user()->added_by,
                            'purchase_id' => $id,
                        ];

                        if (!empty($expArr[$i])) {
                            PurchaseItems::where('id', $expArr[$i])->update($items);
                        } else {
                            PurchaseItems::create($items);
                        }
                    }
                }
            }

            if (!empty($purchase)) {
                $activity = Activity::create([
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Purchase',
                    'activity' => 'Purchase with reference no ' . $purchase->reference_no . '  is Updated',
                ]);
            }

            return redirect(route('purchase.show', $id))->with(['success' => 'Updated Successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*
        PurchaseItems::where('purchase_id', $id)->delete();
       PurchasePayments::where('purchase_id', $id)->delete();
        InventoryHistory::where('purchase_id', $id)->delete();
      
*/

        $purchases = Purchase::find($id);
        if (!empty($purchases)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'module_id' => $id,
                'module' => 'Purchase',
                'activity' => 'Purchase with reference no ' . $purchases->reference_no . '  is Deleted',
            ]);
        }
        $purchases->update(['disabled' => '1']);

        return redirect(route('purchase.index'))->with(['success' => 'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
        $price = Items::where('id', $request->id)->get();
        return response()->json($price);
    }
    public function discountModal(Request $request)
    {
        $id = $request->id;
        $type = $request->type;  
       
        //dd($request->all());

        switch ($type) {
            case 'supplier':
                return view('pos.purchases.supplier_modal');
                break;

            case 'item':
                $category = Category::where('added_by',auth()->user()->added_by)->where('disabled','0')->get(); 
                $color = Color::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
                $size = Size::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
                return view('pos.purchases.items_modal', compact('id','category','color','size'));
                break;

            case 'unit_modal':
                return view('pos.items.unit_modal');
                break;

            case 'receive':
                $purchases = Purchase::find($id);
                $purchase_items = PurchaseItems::where('purchase_id', $id)
                    ->where('due_quantity', '>', '0')
                    ->get();
                $name = Items::whereIn('type', [1, 3])
                    ->where('added_by', auth()->user()->added_by)
                    ->where('disabled', '0')
                    ->get();
                return view('pos.purchases.item_details', compact('purchases', 'purchase_items', 'id', 'name'));
                break;
                
                 case 'edit':
                  $item = Items::whereIn('type', [1, 3])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
                  $name=$request->item_name[0];
                  $desc=$request->description[0];
                  $qty=$request->quantity[0];
                  $price=str_replace(",","",$request->price[0]) ;
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
                return view('pos.purchases.edit_modal', compact('item','name','desc','qty','price','cost','tax','unit','rate','order','type','saved'));
                break;

            default:
                break;
        }
    }

    public function save_supplier(Request $request)
    {
        $supplier = Supplier::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'TIN' => $request['TIN'],
            'user_id' => auth()->user()->added_by,
        ]);

        if (!empty($supplier)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'module_id' => $supplier->id,
                'module' => 'Supplier',
                'activity' => 'Supplier ' . $supplier->name . '  Created',
            ]);

            return response()->json($supplier);
        }
    }

    public function save_item(Request $request)
    {
        //dd($request->all());

        $data = $request->all();

        if ($request->type == 'Kitchen') {
            $data['bar'] = 0;
            $data['type'] = 1;
            $data['restaurant'] = 1;
        } elseif ($request->type == 'Drinks') {
            $data['bar'] = 1;
            $data['type'] = 1;
            $data['restaurant'] = 1;
        }

        $data['added_by'] = auth()->user()->added_by;
        $items = Items::create($data);

        if (!empty($items)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'module_id' => $items->id,
                'module' => 'Inventory',
                'activity' => 'Inventory ' . $items->name . '  Created',
            ]);
            
                 $c = Color::find($items->color);
                $s = Size::find($items->size);
                    
                   if(!empty($c) && empty($s)){
                     $obj['name'] = $items->name .' - '.$c->name;  
                   }
                      
                  elseif(empty($c) && !empty($s)){
                     $obj['name'] =  $items->name .' - '.$s->name;   
                   } 
                   
                   elseif(!empty($c) && !empty($s)){
                   $obj['name'] =  $items->name .' - '.$c->name . ' - '.$s->name;
                   } 
                   
                   else{
                        $obj['name'] =  $items->name ; 
                   }
                   
            $obj['id'] = $items->id;
            $obj['cost_price'] = $items->cost_price;
            $obj['unit'] = $items->unit;
            $obj['tax_rate'] = $items->tax_rate;
            $obj['description'] = $items->description;
		          
			$list[] = $obj;
            

            return response()->json($list);
        }
    }
    
    
    
    public function add_item(Request $request)
    {
        //dd($request->all());

       $data=$request->all();
       
       
        
          $list = '';
          $list1 = ''; 
          
           $it=Items::where('id',$request->checked_item_name)->first();
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
          
          if(!empty($request->type) && $request->type == 'edit'){
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($qty,2).'</td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$cost.'</td>';
            $list .= '<td>'.$tax.'</td>';
             if(!empty($saved)){
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger rem" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '" value="'.$saved.'"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
                }
            else{
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            }
            
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="description[]" class="form-control item_desc" id="desc lst'.$order.'"  value="'.$desc.'"  />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_qty" id="qty lst'.$order.'"  value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
            $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
            
            if(!empty($saved)){
            $list1 .= '<input type="hidden" name="saved_items_id[]" class="form-control item_saved'.$order.'" value="'.$saved.'"  required/>';
                }
          }
            else{
            $list .= '<tr class="trlst'.$order.'">';
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($qty,2).'</td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$cost.'</td>';
            $list .= '<td>'.$tax.'</td>';
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            $list .= '</tr>';
                    
            $list1 .= '<div class="line_items" id="lst'.$order.'">';
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="description[]" class="form-control item_desc" id="desc lst'.$order.'"  value="'.$desc.'"  />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_qty" id="qty lst'.$order.'"  value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
             $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
            $list1 .= '</div>';
            }


             return response()->json([
            'list'          => $list,
            'list1' => $list1
    ]);
        
    }

    public function approve($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['status'] = 1;
        $purchase->update($data);
        if (!empty($purchase)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'module_id' => $id,
                'module' => 'Purchase',
                'activity' => 'Purchase with reference no ' . $purchase->reference_no . '  is Approved',
            ]);
        }

        return redirect(route('purchase.index'))->with(['success' => 'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['status'] = 4;
        $purchase->update($data);

        if (!empty($purchase)) {
            $activity = Activity::create([
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'module_id' => $id,
                'module' => 'Purchase',
                'activity' => 'Purchase with reference no ' . $purchase->reference_no . '  is Cancelled',
            ]);
        }

        return redirect(route('purchase.index'))->with(['success' => 'Cancelled Successfully']);
    }

    public function grn(Request $request)
    {
        //
        $id = $request->purchase_id;
        $nameArr = $request->items_id;
        $priceArr = $request->price;
        $qtyArr = $request->quantity;
        $dateArr = $request->date;
        $recArr = $request->receive_date;
        $savedArr = $request->items_id;
        $dateArr22 = $request->expire_date;

        $purchase = Purchase::find($id);

        if (!empty($nameArr)) {
            for ($i = 0; $i < count($nameArr); $i++) {
                if (!empty($nameArr[$i])) {
                    $saved = Items::find($savedArr[$i]);

                   // dd($qtyArr[$i] * $saved->crate_size);

                    $lists = [
                        'quantity' => $qtyArr[$i] * $saved->crate_size,
                        'price' => $priceArr[$i],
                        'item_id' => $savedArr[$i],
                        'added_by' => auth()->user()->added_by,
                         'user_id' => auth()->user()->id,
                        'supplier_id' => $purchase->supplier_id,
                        'location' => $purchase->location,
                        'purchase_date' =>$recArr[$i],
                        'expire_date' => $dateArr22[$i],
                        'type' => 'Purchases',
                        'purchase_id' => $id,
                    ];
                    
                     PurchaseHistory::create($lists);
                    
                     $mlists = [
                        'in' => $qtyArr[$i] * $saved->crate_size,
                        'price' => $priceArr[$i],
                        'item_id' => $savedArr[$i],
                        'added_by' => auth()->user()->added_by,
                        'supplier_id' => $purchase->supplier_id,
                        'location' => $purchase->location,
                        'date' =>$recArr[$i],
                        'expire_date' => $dateArr22[$i],
                        'type' => 'Purchases',
                        'purchase_id' => $id,
                    ];

                    MasterHistory::create($mlists);

                    $it = Items::where('id', $nameArr[$i])->first();
                    $q = ($it->quantity + $qtyArr[$i])  * $saved->crate_size;
                    Items::where('id', $nameArr[$i])->update(['quantity' => $q]);

                    $loc = Location::where('id', $purchase->location)->first();

                    $lq['quantity'] = ($loc->quantity + $qtyArr[$i]) * $saved->crate_size;

                    if ($saved->bar == '1') {
                        $lq['crate'] = $loc->crate + $qtyArr[$i];
                        $lq['bottle'] = $loc->bottle + $qtyArr[$i] * $saved->bottle;
                    }
                    Location::where('id', $purchase->location)->update($lq);

                    $random = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4 / strlen($x)))), 1, 4);
                   
                    $inv = Purchase::find($id);
                    $supp = Supplier::find($inv->supplier_id);

                    $itm = PurchaseItems::where('purchase_id', $id)
                        ->where('item_name', $savedArr[$i])
                        ->first();
                    $acc = Items::find($savedArr[$i]);

                    $tax = $itm->price * $qtyArr[$i] * $itm->tax_rate;
                    $cost = $itm->price * $qtyArr[$i];

                    $cr = AccountCodes::where('account_name', 'Inventory')
                        ->where('added_by', auth()->user()->added_by)
                        ->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $cr->id;
                    $date = explode('-', $recArr[$i]);
                    $journal->date = $recArr[$i];
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_purchase';
                    $journal->name = 'Purchases';
                    $journal->debit = $cost * $inv->exchange_rate;
                    $journal->income_id = $inv->id;
                    $journal->supplier_id = $inv->supplier_id;
                    $journal->branch_id = $inv->branch_id;
                    $journal->currency_code = $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Purchase for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                    $journal->save();

                    if ($tax > 0) {
                        $vat = AccountCodes::where('account_name', 'VAT IN')
                            ->where('added_by', auth()->user()->added_by)
                            ->first();
                        $journal = new JournalEntry();
                        $journal->account_id = $vat->id;
                        $date = explode('-', $recArr[$i]);
                    $journal->date = $recArr[$i];
                        $journal->year = $date[0];
                        $journal->month = $date[1];
                        $journal->transaction_type = 'pos_purchase';
                        $journal->name = 'Purchases';
                        $journal->debit = $tax * $inv->exchange_rate;
                        $journal->income_id = $inv->id;
                        $journal->supplier_id = $inv->supplier_id;
                         $journal->branch_id = $inv->branch_id;
                        $journal->currency_code = $inv->exchange_code;
                        $journal->exchange_rate = $inv->exchange_rate;
                        $journal->added_by = auth()->user()->added_by;
                        $journal->notes = 'Purchase Tax for Purchase Order ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                        $journal->save();
                    }

                    $codes = AccountCodes::where('account_name', 'Payables')
                        ->where('added_by', auth()->user()->added_by)
                        ->first();
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-', $recArr[$i]);
                    $journal->date = $recArr[$i];
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_purchase';
                    $journal->name = 'Purchases';
                    $journal->income_id = $inv->id;
                    $journal->supplier_id = $inv->supplier_id;
                     $journal->branch_id = $inv->branch_id;
                    $journal->credit = ($cost + $tax) * $inv->exchange_rate;
                    $journal->currency_code = $inv->exchange_code;
                    $journal->exchange_rate = $inv->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Credit for Purchase Order  ' . $inv->reference_no . ' by Supplier ' . $supp->name;
                    $journal->save();
                }
            }

            if (!empty($purchase)) {
                $user = User::find(auth()->user()->id);
                $activity = Activity::create([
                    'added_by' => auth()->user()->added_by,
                    'user_id' => auth()->user()->id,
                    'module_id' => $id,
                    'module' => 'Purchase',
                    'activity' => 'Good Receive for Purchase with reference no ' . $purchase->reference_no,
                ]);
            }

            return redirect(route('purchase.index'))->with(['success' => 'Good Receive Done Successfully']);
        } else {
            return redirect(route('purchase.index'))->with(['error' => 'No data found']);
        }
    }

    public function issue($id)
    {
        //
        $purchase = Purchase::find($id);
        $data['good_receive'] = 1;
        $purchase->update($data);

        if (!empty($purchase)) {
            $user = User::find(auth()->user()->id);
            $activity = Activity::create([
                'added_by' => auth()->user()->added_by,
                'user_id' => auth()->user()->id,
                'module_id' => $id,
                'module' => 'Purchase',
                'activity' => 'Purchase with reference no ' . $purchase->reference_no . ' has been issued ',
            ]);
        }
        
         $codes = AccountCodes::where('account_name', 'Payables')->where('added_by', auth()->user()->added_by)->first();
         $supp = Supplier::find($purchase->supplier_id);
         $cr = AccountCodes::where('account_name', 'GRN Control')->where('added_by', auth()->user()->added_by)->first();
         $a=JournalEntry::where('account_id',$codes->id)->where('transaction_type','pos_purchase')->where('income_id',$id)->where('added_by', auth()->user()->added_by)->sum('credit');
         $grn=$a/$purchase->exchange_rate;
         $tt=PurchasePayments::where('purchase_id',$id)->sum('amount');
         
         if($tt > $grn){
                    $journal = new JournalEntry();
                    $journal->account_id = $codes->id;
                    $date = explode('-', date('Y-m-d'));
                    $journal->date = date('Y-m-d');
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_issue_supplier';
                    $journal->name = 'Purchases';
                    $journal->income_id = $id;
                    $journal->supplier_id = $purchase->supplier_id;
                    $journal->debit = ($tt - $grn ) * $purchase->exchange_rate;
                    $journal->currency_code = $purchase->exchange_code;
                    $journal->exchange_rate = $purchase->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Credit for Issued Purchase Order  ' . $purchase->reference_no . ' by Supplier ' . $supp->name;
                    $journal->save();
                    
                    
                     $journal = new JournalEntry();
                    $journal->account_id = $cr->id;
                    $date = explode('-', date('Y-m-d'));
                    $journal->date = date('Y-m-d');
                    $journal->year = $date[0];
                    $journal->month = $date[1];
                    $journal->transaction_type = 'pos_issue_supplier';
                    $journal->name = 'Purchases';
                    $journal->income_id = $id;
                    $journal->supplier_id = $purchase->supplier_id;
                    $journal->credit = ($tt - $grn ) * $purchase->exchange_rate;
                    $journal->currency_code =  $purchase->exchange_code;
                    $journal->exchange_rate =  $purchase->exchange_rate;
                    $journal->added_by = auth()->user()->added_by;
                    $journal->notes = 'Credit for Issued Purchase Order  ' . $purchase->reference_no . ' by Supplier ' . $supp->name;
                    $journal->save();
                    
         }
         
         
         

        return redirect(route('purchase.index'))->with(['success' => 'Issued Successfully']);
    }

    public function receive($id)
    {
        //

        $currency = Currency::all();
        $supplier = Supplier::where('user_id', auth()->user()->added_by)
            ->where('disabled', '0')
            ->get();
        $name = Items::whereIn('type', [1, 3])
            ->where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();
        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $data = Purchase::find($id);
        $items = PurchaseItems::where('purchase_id', $id)->get();
        $type = 'receive';
        $user = User::where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();
        $branch = Branch::where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();
            
            
                 
         $pos_purchase= Purchase::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw(' ((purchase_amount + purchase_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= Purchase::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= Purchase::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->count();
         $unpaid= Purchase::where('added_by',auth()->user()->added_by)->where('status','1')->count();
         $part= Purchase::where('added_by',auth()->user()->added_by)->where('status','2')->count();
         $paid= Purchase::where('added_by',auth()->user()->added_by)->where('status','3')->count();
         
       

        return view('pos.purchases.index', compact('name', 'supplier', 'currency', 'location', 'data', 'id', 'items', 'type', 'user', 'branch',
       'pos_purchase','pos_due','total','unpaid','part','paid'));
    }

    public function make_payment($id)
    {
        //
        $invoice = Purchase::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts = AccountCodes::where('account_status', 'Bank')
            ->where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();
        return view('pos.purchases.purchase_payments', compact('invoice', 'payment_method', 'bank_accounts'));
    }

    public function assign_expire(Request $request)
    {
        $data = Items::where('added_by', auth()->user()->added_by)
            ->whereIn('type', [1, 3])
            ->where('disabled', 0)
            ->get();

        return view('pos.purchases.assign_expire', compact('data'));
    }

    public function save_expire(Request $request)
    {
        //

        $date = $request->expire_date;
        $reference = $request->reference;
        $id = $request->id;
        //$purchase =SerialList::where('brand_id', $id)->where('status','0')->whereNull('purchase_id')->whereNull('expire_date')->take($request->quantity)->update(['expire_date'=> $date,'reference'=>$reference]) ;
        $purchase = SerialList::where('brand_id', $id)
            ->where('status', '0')
            ->whereNull('purchase_id')
            ->whereNull('expire_date')
            ->take($request->quantity)
            ->update(['expire_date' => $date, 'reference' => $reference]);

        return redirect(route('pos.assign_expire'))->with(['success' => 'Assigned Successfully']);
    }

    public function expire_list(Request $request)
    {
        $data = Items::where('added_by', auth()->user()->added_by)
            ->whereIn('type', [1, 3])
            ->where('disabled', 0)
            ->get();

        return view('pos.purchases.expire', compact('data'));
    }

    public function dispose($id)
    {
        //
        $date = today()->format('Y-m');

        $inv = Items::where('id', $id)->first();
        if ($inv->bar == '1') {
            $status = 1;
        } else {
            $status = 0;
        }

        $purchase = SerialList::where('brand_id', $id)
            ->where('status', '0')
            ->whereNotNull('expire_date')
            ->where('expire_date', '<', $date)
            ->update(['status' => '5', 'crate_status' => $status]);

        return redirect(route('pos.expire'))->with(['success' => 'Disposed Successfully']);
    }

    public function inv_pdfview(Request $request)
    {
        //
        $purchases = Purchase::find($request->id);
        $purchase_items = PurchaseItems::where('purchase_id', $request->id)->where('due_quantity','>', '0')->get();

        view()->share(['purchases' => $purchases, 'purchase_items' => $purchase_items]);

        if ($request->has('download')) {
            $pdf = PDF::loadView('pos.purchases.purchase_details_pdf')->setPaper('a4', 'potrait');
            return $pdf->download('PURCHASES REF NO # ' . $purchases->reference_no . '.pdf');
        }
        return view('inv_pdfview');
    }

    public function issue_pdfview(Request $request)
    {
        //
        $purchases = Purchase::find($request->id);
        $purchase_items = PurchaseItems::where('purchase_id', $request->id)->where('due_quantity','>', '0')->get();

        view()->share(['purchases' => $purchases, 'purchase_items' => $purchase_items]);

        if ($request->has('download')) {
            $pdf = PDF::loadView('pos.purchases.issue_supplier_pdf')->setPaper('a4', 'potrait');
            return $pdf->download('ISSUED PURCHASES REF NO # ' . $purchases->reference_no . '.pdf');
        }
        return view('issue_pdfview');
    }
    
    
    public function grn_pdfview(Request $request)
    {
        //
        $purchases = PurchaseHistory::find($request->id);
        //$purchase_items = PurchaseItems::where('purchase_id', $request->id)->where('due_quantity','>', '0')->get();

        view()->share(['purchases' => $purchases]);

        if ($request->has('download')) {
            $pdf = PDF::loadView('pos.purchases.grn_pdf')->setPaper('a4', 'potrait');
            return $pdf->download('GOOD RECEIVE.pdf');
        }
        return view('grn_pdfview');
    }


    public function creditors_report(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id = $request->account_id;
        $currency = $request->currency;
        $chart_of_accounts = [];
        $accounts = [];

        foreach (
            Supplier::where('user_id', auth()->user()->added_by)
                ->where('disabled', 0)
                ->get()
            as $key
        ) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        foreach (Currency::all() as $key) {
            $accounts[$key->code] = $key->name;
        }
        if ($request->isMethod('post')) {
            $data = Purchase::where('supplier_id', $request->account_id)
                ->where('exchange_code', $request->currency)
                ->whereBetween('purchase_date', [$start_date, $end_date])
                ->where('status', '!=', 0)
                ->where('added_by', auth()->user()->added_by)
                ->get();
        } else {
            $data = [];
        }

        return view('pos.purchases.creditors_report', compact('start_date', 'end_date', 'chart_of_accounts', 'data', 'account_id', 'currency', 'accounts'));
    }

    public function creditors_summary_report(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $currency = $request->currency;
        $accounts = [];

        foreach (Currency::all() as $key) {
            $accounts[$key->code] = $key->name;
        }
        if ($request->isMethod('post')) {
            $data = Purchase::where('exchange_code', $request->currency)
                ->whereBetween('purchase_date', [$start_date, $end_date])
                ->where('status', '!=', 0)
                ->where('added_by', auth()->user()->added_by)
                ->groupBy('supplier_id')
                ->get();
        } else {
            $data = [];
        }

        return view('pos.purchases.creditors_summary_report', compact('start_date', 'end_date', 'data', 'currency', 'accounts'));
    }

    public function summary(Request $request)
    {
        //

        $all_employee = User::where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();

        $search_type = $request->search_type;
        $check_existing_payment = '';
        $start_date = '';
        $end_date = '';
        $by_month = '';
        $user_id = '';
        $flag = $request->flag;

        if (!empty($flag)) {
            if ($search_type == 'employee') {
                $user_id = $request->user_id;
                $check_existing_payment = Activity::where('user_id', $user_id)->get();
            } elseif ($search_type == 'period') {
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                $check_existing_payment = Activity::all()
                    ->where('added_by', auth()->user()->added_by)
                    ->whereBetween('date', [$start_date, $end_date]);
            } elseif ($search_type == 'activities') {
                $check_existing_payment = Activity::where('added_by', auth()->user()->added_by)->get();
            }
        } else {
            $check_existing_payment = '';
            $start_month = '';
            $end_month = '';
            $search_type = '';
            $by_month = '';
            $user_id = '';
        }

        return view('pos.purchases.summary', compact('all_employee', 'check_existing_payment', 'start_date', 'end_date', 'search_type', 'user_id', 'flag'));
    }
}
