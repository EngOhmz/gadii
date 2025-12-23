<?php

namespace App\Traits;

use App\Models\POS\Items;
use App\Models\POS\MasterHistory;
use Illuminate\Support\Facades\Auth;

trait SalesPurchasesCalculation
{
    /**
     * Calculate Sales and Purchases with optional filters for date range and location.
     *
     * @param  string|null  $startDate
     * @param  string|null  $endDate
     * @param  int|null     $locationId
     * @return array
     */
    public function calculateSalesPurchases($startDate = null, $endDate = null, $locationId = null)
    {
        $user = Auth::user();
        if (!$user) {
            return [];
        }

        // Get items added by the user
        $items = Items::where('added_by', $user->added_by)->get();
        $result = [];
        
        foreach ($items as $item) {
            // Build the query for MasterHistory
            $query = MasterHistory::where('item_id', $item->id)
                ->whereIn('type', ['Sales', 'Credit Note']);
            
            // Apply Date Range Filter if Provided
            if (!empty($startDate) && !empty($endDate)) {
                // Filter using whereBetween for the date range
                $query->whereBetween('date', [$startDate, $endDate]);
            }

            // Apply location filter if provided
            if ($locationId) {
                $query->where('location', $locationId);
            }

            // Get all the filtered history entries grouped by location
            $histories = $query->get()->groupBy('location');
            
            foreach ($histories as $locationId => $history) {
                $outTotal = $history->sum('out');
                $inTotal = $history->sum('in');
                $totalPrice = $history->sum(function ($h) {
                    return $h->out * $h->price - $h->in * $h->price;
                });

                $sales = $totalPrice;
                $purchases = ($outTotal * $item->cost_price) - ($inTotal * $item->cost_price);

                $balance = $sales - $purchases;
                
                // Add result for each location
                $result[] = [
                    'item_id' => $item->id,
                    'item_name' => $item->name,
                    'location_id' => $locationId,
                    'sales' => $sales,
                    'purchases' => $purchases,
                    'balance' => $balance
                ];
            }
        }

        // Debug: Log the report data to check the items
        \Log::debug('Filtered Report Data', $result);

        return $result;
    }
}

