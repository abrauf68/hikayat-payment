<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            $purchases = Purchase::get();
            $totalPurchases = $purchases->count();
            $totalValue = $purchases->sum('discounted_price');
            $totalPaidAmount = $purchases->where('payment_status', 'paid')->sum('discounted_price');
            $totalUnpaidAmount = $purchases->where('payment_status', 'unpaid')->sum('discounted_price');
            return view('dashboard.index', compact('totalPurchases', 'totalValue', 'totalPaidAmount', 'totalUnpaidAmount'));
        } catch (\Throwable $th) {
            Log::error('Dashboard Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
