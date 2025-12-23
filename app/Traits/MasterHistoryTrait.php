<?php

namespace App\Traits;

use App\Models\POS\MasterHistory;
use App\Models\POS\Items;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

trait MasterHistoryTrait
{
    public function getItemQuantities($start_date = null, $end_date = null, $location = null)
    {
        $user = Auth::user();
        $addedBy = $user ? $user->added_by : null;

        // Return empty if no date range is provided
        if (empty($start_date) || empty($end_date)) {
            return [];
        }

        // Base query
        $query = MasterHistory::select('item_id', 'location')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN type = 'Purchases' THEN `in` ELSE 0 END), 0) + 
                COALESCE(SUM(CASE WHEN type = 'Credit Note' THEN `in` ELSE 0 END), 0) + 
                COALESCE(SUM(CASE WHEN type = 'Returned Good Issue' THEN `in` ELSE 0 END), 0) + 
                COALESCE(SUM(CASE WHEN type = 'Stock Movement' THEN `in` ELSE 0 END), 0) - 
                COALESCE(SUM(CASE WHEN type = 'Sales' THEN `out` ELSE 0 END), 0) - 
                COALESCE(SUM(CASE WHEN type = 'Debit Note' THEN `out` ELSE 0 END), 0) - 
                COALESCE(SUM(CASE WHEN type = 'Good Disposal' THEN `out` ELSE 0 END), 0) - 
                COALESCE(SUM(CASE WHEN type = 'Good Issue' THEN `out` ELSE 0 END), 0) - 
                COALESCE(SUM(CASE WHEN type = 'Stock Movement' THEN `out` ELSE 0 END), 0)
            AS quantity")
            ->where('added_by', '=', $addedBy);

        // Apply date range filter
        $query->whereBetween('date', [$start_date, $end_date]);

        // Apply location filter if specified
        if (!empty($location)) {
            $query->where('location', '=', $location);
        }

        // Group by item and location
        $query->groupBy('item_id', 'location');

        // Fetch results and filter item types
        return $query->get()->map(function ($item) {
            $itemDetails = Items::find($item->item_id);
            $locationDetails = Location::find($item->location);

            // Ensure item type is only 1 or 6
            if (!$itemDetails || !in_array($itemDetails->type, [1, 6])) {
                return null;
            }

            return [
                'item_id' => $item->item_id,
                'quantity' => $item->quantity,
                'location_id' => $item->location,
                'location_name' => $locationDetails ? $locationDetails->name : null,
                'item_name' => $itemDetails->name,
                'item_type' => $itemDetails->type,
                'cost_price' => $itemDetails->cost_price,
                'sales_price' => $itemDetails->sales_price,
                'minimum_balance' => $itemDetails->minimum_balance,
                'crate_size' => $itemDetails->crate_size,
            ];
        })->filter()->values()->toArray(); // Remove null values and reindex
    }
}

