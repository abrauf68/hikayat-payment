<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        try {
            $month  = $request->month;
            $year   = $request->year;
            $search = $request->search;
            $status = $request->status;

            // Base query
            $query = Purchase::query();

            // Month & Year filter
            if ($month && $year) {
                $query->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year);
            }

            // Search filter (client / variant etc)
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('variant_name', 'like', "%{$search}%")
                        ->where('client_name', 'like', "%{$search}%");
                });
            }

            // Status filter
            if (!empty($status) && $status !== 'all') {
                $query->where('payment_status', $status);
            }

            // Data
            $purchases = $query->latest()->get();
            $purchasesData = $query->latest()->get();
            $latestPurchases = (clone $query)->latest()->take(3)->get();

            // Totals
            $totalPurchases = $purchases->count();
            $totalValue = $purchases->sum('discounted_price');
            $totalPaidAmount = $purchases->where('payment_status', 'paid')->sum('discounted_price');
            $totalUnpaidAmount = $purchases->where('payment_status', 'unpaid')->sum('discounted_price');

            return view(
                'dashboard.purchases.index',
                compact(
                    'purchases',
                    'purchasesData',
                    'totalPurchases',
                    'totalValue',
                    'totalPaidAmount',
                    'totalUnpaidAmount',
                    'latestPurchases'
                )
            );
        } catch (\Throwable $th) {
            Log::error('Purchase Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Something went wrong! Please try again later');
        }
    }


    public function storePurchase(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'variant_name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'original_price' => 'required|numeric|min:0',
            'discounted_price' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid',
            'purchase_date' => 'required|date',
            'payment_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {

            $purchase = new Purchase();
            $purchase->variant_name = $request->variant_name;
            $purchase->client_name = $request->client_name;
            $purchase->quantity = $request->quantity;
            $purchase->original_price = $request->original_price;
            $purchase->discounted_price = $request->discounted_price;
            $discountPercentage = 0;
            if ($request->original_price > 0) {
                $discountPercentage = (1 - ($request->discounted_price / $request->original_price)) * 100;
            }
            $purchase->discount_percentage = round($discountPercentage);
            $purchase->payment_status = $request->status;
            $purchase->purchase_date = $request->purchase_date;
            $purchase->payment_date = $request->payment_date;
            $purchase->save();

            return redirect()->route('purchase-terminal')->with('success', 'Purchase added successfully.');
        } catch (\Throwable $th) {
            Log::error('Store Purchase Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    public function deletePurchase($id)
    {
        try {
            $purchase = Purchase::findOrFail($id);
            $purchase->delete();

            return redirect()->route('purchase-terminal')->with('success', 'Purchase deleted successfully.');
        } catch (\Throwable $th) {
            Log::error('Delete Purchase Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    public function updatePurchase(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'variant_name_edit' => 'required|string|max:255',
            'client_name_edit' => 'required|string|max:255',
            'quantity_edit' => 'required|integer|min:1',
            'original_price_edit' => 'required|numeric|min:0',
            'discounted_price_edit' => 'required|numeric|min:0',
            'status_edit' => 'required|in:paid,unpaid',
            'purchase_date_edit' => 'required|date',
            'payment_date_edit' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            $purchase = Purchase::findOrFail($id);
            $purchase->variant_name = $request->variant_name_edit;
            $purchase->client_name = $request->client_name_edit;
            $purchase->quantity = $request->quantity_edit;
            $purchase->original_price = $request->original_price_edit;
            $purchase->discounted_price = $request->discounted_price_edit;
            $discountPercentage = 0;
            if ($request->original_price_edit > 0) {
                $discountPercentage = (1 - ($request->discounted_price_edit / $request->original_price_edit)) * 100;
            }
            $purchase->discount_percentage = round($discountPercentage);
            $purchase->payment_status = $request->status_edit;
            $purchase->purchase_date = $request->purchase_date_edit;
            $purchase->payment_date = $request->payment_date_edit;
            $purchase->save();

            return redirect()->route('purchase-terminal')->with('success', 'Purchase updated successfully.');
        } catch (\Throwable $th) {
            Log::error('Update Purchase Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    public function restorePurchase($id)
    {
        try {
            $purchase = Purchase::onlyTrashed()->findOrFail($id);
            $purchase->restore();

            return redirect()->route('purchase-terminal')->with('success', 'Purchase restored successfully.');
        } catch (\Throwable $th) {
            Log::error('Restore Purchase Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    public function deletePurchasePermanently($id)
    {
        try {
            $purchase = Purchase::onlyTrashed()->findOrFail($id);
            $purchase->forceDelete();

            return redirect()->route('trash')->with('success', 'Purchase permanently deleted successfully.');
        } catch (\Throwable $th) {
            Log::error('Permanent Delete Purchase Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }
}
