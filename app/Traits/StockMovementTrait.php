<?php

namespace App\Traits;

use App\Models\POS\StockMovement;
use App\Models\Location;
use App\Models\User;
use App\Models\POS\Items;
use App\Models\POS\StockMovementItem;
use Illuminate\Support\Facades\Auth;

trait StockMovementTrait
{
    /**
     * Get the detailed stock movement information for the authenticated user, with optional date range filtering.
     *
     * @param string|null $startDate
     * @param string|null $endDate
     * @return array
     */
    public function getStockMovementDetails($startDate = null, $endDate = null)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Start the query to retrieve stock movements for the authenticated user
        $query = StockMovement::where('added_by', $user->added_by);

        // Apply date filters if provided
        if ($startDate) {
            $query->where('movement_date', '>=', $startDate); // Filter by start date
        }
        if ($endDate) {
            $query->where('movement_date', '<=', $endDate); // Filter by end date
        }

        // Retrieve the filtered stock movements
        $stockMovements = $query->get();

        if ($stockMovements->isEmpty()) {
            // If no stock movements are found, return an error message
            return ['error' => 'No stock movement found for this user within the specified date range.'];
        }

        $stockMovementDetails = [];

        // Iterate through each stock movement to get the necessary details
        foreach ($stockMovements as $stockMovement) {
            // Get staff name from the User model
            $staff = User::find($stockMovement->staff);
            $staffName = $staff ? $staff->name : null;

            // Get source and destination store names from the Location model
            $sourceStore = Location::find($stockMovement->source_store);
            $destinationStore = Location::find($stockMovement->destination_store);

            // Get stock movement items associated with this movement
            $stockMovementItems = StockMovementItem::where('movement_id', $stockMovement->id)->get();

            $itemsDetails = [];

            // Get item details from the Items model based on item_id
            foreach ($stockMovementItems as $item) {
                $itemDetails = Items::find($item->item_id);
                if ($itemDetails) {
                    $itemsDetails[] = [
                        'item_name' => $itemDetails->name,
                        'item_type' => $itemDetails->type, // Assuming 'type' is the column name in the items model
                        'quantity' => $item->quantity, // Quantity from StockMovementItem
                    ];
                }
            }

            // Collect data for each stock movement, including the new 'status' column
            $stockMovementDetails[] = [
                'name' => $stockMovement->name,
                'movement_date' => $stockMovement->movement_date,
                'staff' => $stockMovement->staff,
                'staff_name' => $staffName,
                'source_store' => $stockMovement->source_store,
                'source_name' => $sourceStore ? $sourceStore->name : null,
                'destination_store' => $stockMovement->destination_store,
                'destination_name' => $destinationStore ? $destinationStore->name : null,
                'status' => $stockMovement->status, // Include the status from the StockMovement model
                'items' => $itemsDetails,
            ];
        }

        return $stockMovementDetails;
    }
}

