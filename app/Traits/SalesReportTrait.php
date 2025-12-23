<?php

namespace App\Traits;

use App\Models\POS\MasterHistory;
use App\Models\POS\Invoice;
use App\Models\POS\Items;
use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait SalesReportTrait
{
    public function getSalesReport($perPage = 10, $startDate = null, $endDate = null, $location = null, $salesType = null)
    {
        $addedBy = Auth::user()->added_by;

        // Fetch invoices with related data
        $query = Invoice::with([
            'client:id,name',
            'userAgent:id,name',
            'masterHistories' => function ($query) {
                $query->select('id', 'invoice_id', 'item_id', 'out', 'location', 'date')
                     ->where('type', 'Sales');
            },
        ])
        ->select(
            'id',
            'client_id',
            'due_amount',
            'paid_amount',
            'user_agent',
            'invoice_amount',
            'invoice_tax',
            'sales_type',
            'status',
            'heading'
        )
        ->where('added_by', $addedBy);

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereHas('masterHistories', function (Builder $query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            });
        }

        if (!empty($location) && strtolower($location) !== 'all') {
            $query->whereHas('masterHistories', function (Builder $query) use ($location) {
                $query->where('location', $location);
            });
        }

        if (!empty($salesType) && strtolower($salesType) !== 'all') {
            $query->where('sales_type', $salesType);
        }

        return $query->paginate($perPage)->through(function ($invoice) {
            // Get MasterHistory records (already eager-loaded)
            $histories = $invoice->masterHistories;

            // Fetch items and their quantities
            $itemIds = $histories->pluck('item_id')->unique();
            $items = Items::whereIn('id', $itemIds)
                ->select('id', 'name')
                ->get()
                ->map(function ($item) use ($histories) {
                    // Sum the 'out' field for this item across all MasterHistory records
                    $quantity = $histories->where('item_id', $item->id)->sum('out');
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'quantity' => number_format($quantity, 0), // Format as integer (e.g., 9, 7)
                    ];
                })->toArray();

            // Get location from the first MasterHistory record
            $locationId = $histories->isNotEmpty() ? $histories->first()->location : null;
            $location = $locationId ? Location::find($locationId) : null;

            return [
                'invoice_id'     => $invoice->id,
                'heading'        => $invoice->heading ?? 'N/A',
                'type'           => 'Sales',
                'client_id'      => $invoice->client_id,
                'client_name'    => optional($invoice->client)->name ?? 'N/A',
                'due_amount'     => $invoice->due_amount ?? 0,
                'paid_amount'    => $invoice->paid_amount ?? 0,
                'user_agent'     => optional($invoice->userAgent)->name ?? 'N/A',
                'items'          => $items, // Now includes item name and quantity
                'location_id'    => $locationId,
                'location_name'  => $location ? $location->name : 'N/A',
                'invoice_amount' => $invoice->invoice_amount ?? 0,
                'invoice_tax'    => $invoice->invoice_tax ?? 0,
                'sales_type'     => $invoice->sales_type ?? 'N/A',
                'status'         => $invoice->status ?? 'N/A',
                'date'           => $histories->isNotEmpty() ? $histories->first()->date : null,
            ];
        });
    }
}
