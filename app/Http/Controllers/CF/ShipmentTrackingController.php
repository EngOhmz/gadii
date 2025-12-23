<?php

namespace App\Http\Controllers\CF;

use App\Http\Controllers\Controller;
use App\Models\CF\ShipmentPlanning;
use App\Models\CF\ShipmentTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShipmentTrackingController extends Controller
{
    // public function index()
    // {
    //     $tracking = ShipmentTracking::all();
    //     return view('cf.tracking.index', compact('tracking'));
    // }

    public function index()
    {
        // Get the latest tracking record for each shipment_id
        $trackings = ShipmentTracking::select('shipment_id')
            ->groupBy('shipment_id')
            ->get()
            ->map(function ($item) {
                return ShipmentTracking::where('shipment_id', $item->shipment_id)
                    ->with('addedByUser')
                    ->latest('updated_at')
                    ->first();
            });

        return view('cf.tracking.index', compact('trackings'));
    }


    public function getStatuses($shipment_id)
    {
        $statuses = ShipmentTracking::where('shipment_id', $shipment_id)
            ->with('addedByUser')
            ->orderBy('updated_at', 'desc')
            ->get(['status', 'updated_at', 'added_by']);

        return response()->json([
            'shipment_id' => $shipment_id,
            'statuses' => $statuses->map(function ($status) {
                return [
                    'status' => $status->status,
                    'updated_by' => $status->addedByUser->name ?? 'Unknown',
                    'updated_at' => $status->updated_at->format('Y-m-d H:i:s'),
                ];
            }),
        ]);
    }

    public function create()
    {
        // Fetch all shipment planning records
        $shipments = ShipmentPlanning::all();
        return view('cf.tracking.create', compact('shipments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipment_id' => 'required|string|max:255|exists:cf_shipment_planning,shipment_id',
            'status' => 'required|string',
        ]);

        // Create tracking record
        ShipmentTracking::create([
            'shipment_id' => $validated['shipment_id'],
            'status' => $validated['status'],
            'added_by' => auth()->id(),
        ]);

        // Update the corresponding shipment planning status
        ShipmentPlanning::where('shipment_id', $validated['shipment_id'])
            ->update(['status' => $validated['status']]);

        return redirect()->route('cf.tracking.index')
            ->with('success', 'Shipment status updated successfully');
    }
}