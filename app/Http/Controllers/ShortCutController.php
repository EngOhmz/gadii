<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\POS\Activity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\POS\Items;
use App\Models\Client;
use App\Models\Location;
use App\Models\AccountCodes;
use App\Models\Branch;
use App\Models\User;
use App\Models\Subscriber;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\POS\InvoiceAttachment;
use App\Models\Supplier;
use Response;
use Carbon\Carbon;

class ShortCutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shortCut.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe()
    {
        return view('subscribe');
    }
    
    
    public function subscriber_store()
    {    
    
      Subscriber::create([
        'email' => $request->email,
        'subscribed_at' => Carbon::now(),
    ]);

    return redirect()->back()->with('success', 'You have successfully subscribed!');
        
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save_details(Request $request)
    {
        switch ($request->type) {
            
            case 'supplier':
                
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

                       return redirect()->back()->with(['success' => 'Supplier Created Successfully']);
                    }
                break;
                
                case 'client' :
                    
                    $data=$request->post();
                    $data['user_id'] = auth()->user()->id;
                    $data['owner_id'] = auth()->user()->added_by;
                    $client = Client::create($data);

                     if (!empty($client)) {
                                    $activity = Activity::create([
                                    'added_by' => auth()->user()->added_by,
                                    'user_id' => auth()->user()->id,
                                    'module_id' => $client->id,
                                    'module' => 'Client',
                                    'activity' => 'Client ' . $client->name . '  Created',
                                ]);
                
                           return redirect()->back()->with(['success' => 'Client Created Successfully']);
                        }
                break;
                
                
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function discountModal(Request $request)
    {
        $type = $request->type;

        $currency = Currency::all();
        $invoices = Invoice::all()
            ->where('invoice_status', 1)
            ->where('disabled', '0')
            ->where('added_by', auth()->user()->added_by);
        $client = Client::where('owner_id', auth()->user()->added_by)
            ->where('disabled', '0')
            ->get();
        $name = Items::whereIn('type', [1, 2, 4])
            ->where('added_by', auth()->user()->added_by)
            ->where('restaurant', '0')
            ->where('disabled', '0')
            ->get();
        $bank_accounts = AccountCodes::where('account_group', 'Cash and Cash Equivalent')
            ->where('added_by', auth()->user()->added_by)
            ->get();
        $location = Location::leftJoin('location_manager', 'locations.id', 'location_manager.location_id')
            ->where('locations.disabled', '0')
            ->where('locations.added_by', auth()->user()->added_by)
            ->where('location_manager.manager', auth()->user()->id)
            ->select('locations.*')
            ->get();
        $branch = Branch::where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();
        $user = User::where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();

        return view('shortCut.index', compact('name', 'client', 'currency', 'invoices', 'type', 'bank_accounts', 'location', 'user', 'branch', 'type'));
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Client::find($id);
        return view('client.client', compact('data', 'id'));
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function sample(Request $request)
    {
    }
}
