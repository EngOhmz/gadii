<?php

namespace App\Http\Controllers\CF;

use App\Http\Controllers\Controller;
use App\Models\CF\ShipmentPlanning;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ShipmentPlanningController extends Controller
{
    public function index()
    {
        $shipments = ShipmentPlanning::with('supplier')->get();
        return view('cf.shipment_planning.index', compact('shipments'));
    }

    public function create()
    {
        // Get the authenticated user's added_by value
        $userAddedBy = Auth::user()->added_by;
        
        // Fetch suppliers where added_by matches the user's added_by
        $suppliers = Supplier::where('user_id', $userAddedBy)->get();
        
        return view('cf.shipment_planning.create', compact('suppliers'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'supplier_id' => 'required|string|max:255',
        'shipment_id' => 'required|string',
        'type' => 'required|string|max:255',
        'quantity' => 'required|string|max:255',
        'value' => 'required|string|max:255',
        'port_origin' => 'required|string|max:255',
        'port_entry' => 'required|string|max:255',
        'etd' => 'required|string|max:255',
        'eta' => 'required|string|max:255',
        'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'pl_document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'inv_document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ]);

    // Handle file uploads
    // B/L Document
    if ($request->hasFile('document')) {
        $file = $request->file('document');
        $fileName = time() . '_bl_' . $file->getClientOriginalName();
        $file->move(public_path('shipments'), $fileName);
        $validated['document'] = 'shipments/' . $fileName;
    }

    // Packing List Document
    if ($request->hasFile('pl_document')) {
        $file = $request->file('pl_document');
        $fileName = time() . '_pl_' . $file->getClientOriginalName();
        $file->move(public_path('shipments'), $fileName);
        $validated['pl_document'] = 'shipments/' . $fileName;
    }

    // Invoice Document
    if ($request->hasFile('inv_document')) {
        $file = $request->file('inv_document');
        $fileName = time() . '_inv_' . $file->getClientOriginalName();
        $file->move(public_path('shipments'), $fileName);
        $validated['inv_document'] = 'shipments/' . $fileName;
    }

    $validated['status'] = 'Ready at Supplier';
    
    // Create shipment with validated data
    ShipmentPlanning::create($validated);

    return redirect()->route('cf.shipment-planning.index')
        ->with('success', 'Shipment planning created successfully');
}

    public function show(ShipmentPlanning $shipmentPlanning)
    {
        return view('cf.shipment_planning.show', compact('shipmentPlanning'));
    }
    
    public function edit($id)
{
    $shipment = ShipmentPlanning::findOrFail($id);
    $suppliers = Supplier::all(); 

    return view('cf.shipment_planning.edit', compact('shipment', 'suppliers'));
}

public function update(Request $request, $id)
{
    $shipment = ShipmentPlanning::findOrFail($id);

    $validated = $request->validate([
        'supplier_id' => 'required|string|max:255',
        'shipment_id' => 'required|string',
        'type' => 'required|string|max:255',
        'quantity' => 'required|string|max:255',
        'value' => 'required|string|max:255',
        'port_origin' => 'required|string|max:255',
        'port_entry' => 'required|string|max:255',
        'etd' => 'required|string|max:255',
        'eta' => 'required|string|max:255',
        'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'pl_document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'inv_document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'status' => 'required|string'
    ]);

    // Handle file uploads
    if ($request->hasFile('document')) {
        // Delete old file if it exists
        if ($shipment->document && file_exists(public_path($shipment->document))) {
            unlink(public_path($shipment->document));
        }
        $file = $request->file('document');
        $fileName = time() . '_bl_' . $file->getClientOriginalName();
        $file->move(public_path('shipments'), $fileName);
        $validated['document'] = 'shipments/' . $fileName;
    } else {
        $validated['document'] = $shipment->document; // Retain existing file path
    }

    if ($request->hasFile('pl_document')) {
        // Delete old file if it exists
        if ($shipment->pl_document && file_exists(public_path($shipment->pl_document))) {
            unlink(public_path($shipment->pl_document));
        }
        $file = $request->file('pl_document');
        $fileName = time() . '_pl_' . $file->getClientOriginalName();
        $file->move(public_path('shipments'), $fileName);
        $validated['pl_document'] = 'shipments/' . $fileName;
    } else {
        $validated['pl_document'] = $shipment->pl_document; // Retain existing file path
    }

    if ($request->hasFile('inv_document')) {
        // Delete old file if it exists
        if ($shipment->inv_document && file_exists(public_path($shipment->inv_document))) {
            unlink(public_path($shipment->inv_document));
        }
        $file = $request->file('inv_document');
        $fileName = time() . '_inv_' . $file->getClientOriginalName();
        $file->move(public_path('shipments'), $fileName);
        $validated['inv_document'] = 'shipments/' . $fileName;
    } else {
        $validated['inv_document'] = $shipment->inv_document; // Retain existing file path
    }

    // Update shipment with validated data
    $shipment->update($validated);

    return redirect()->route('cf.shipment-planning.index')
        ->with('success', 'Shipment planning updated successfully');
}
}
