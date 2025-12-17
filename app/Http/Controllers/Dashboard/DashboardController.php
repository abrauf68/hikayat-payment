<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Current & Last Month
            $currentMonth = Carbon::now();
            $lastMonth = Carbon::now()->subMonth();

            // ===== CURRENT MONTH =====
            $currentPurchases = Purchase::whereMonth('created_at', $currentMonth->month)
                ->whereYear('created_at', $currentMonth->year)
                ->get();

            // ===== LAST MONTH =====
            $lastPurchases = Purchase::whereMonth('created_at', $lastMonth->month)
                ->whereYear('created_at', $lastMonth->year)
                ->get();

            // ===== TOTALS =====
            $totalPurchases = $currentPurchases->count();
            $totalValue = $currentPurchases->sum('discounted_price');
            $totalPaidAmount = $currentPurchases->where('payment_status', 'paid')->sum('discounted_price');
            $totalUnpaidAmount = $currentPurchases->where('payment_status', 'unpaid')->sum('discounted_price');

            // ===== LAST MONTH TOTALS =====
            $lastTotalValue = $lastPurchases->sum('discounted_price');
            $lastPaidAmount = $lastPurchases->where('payment_status', 'paid')->sum('discounted_price');
            $lastUnpaidAmount = $lastPurchases->where('payment_status', 'unpaid')->sum('discounted_price');
            $lastTotalPurchases = $lastPurchases->count();

            // ===== PERCENTAGE CALCULATIONS =====
            $revenueChange = $lastTotalValue > 0
                ? (($totalValue - $lastTotalValue) / $lastTotalValue) * 100
                : 0;

            $paidChange = $lastPaidAmount > 0
                ? (($totalPaidAmount - $lastPaidAmount) / $lastPaidAmount) * 100
                : 0;

            $unpaidChange = $lastUnpaidAmount > 0
                ? (($totalUnpaidAmount - $lastUnpaidAmount) / $lastUnpaidAmount) * 100
                : 0;

            $purchaseChange = $lastTotalPurchases > 0
                ? (($totalPurchases - $lastTotalPurchases) / $lastTotalPurchases) * 100
                : 0;

            // ===== Monthly Revenue Data (last 12 months) =====
            $monthlyRevenue = [];
            $monthLabels = [];

            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $monthLabels[] = $date->format('M Y'); // Jan 2025
                $monthlyRevenue[] = Purchase::whereMonth('purchase_date', $date->month)
                                            ->whereYear('purchase_date', $date->year)
                                            ->sum('discounted_price');
            }

            // ===== Yearly Revenue Data (last 5 years) =====
            $yearlyRevenue = [];
            $yearLabels = [];
            for ($i = 4; $i >= 0; $i--) {
                $year = Carbon::now()->subYears($i)->year;
                $yearLabels[] = $year;
                $yearlyRevenue[] = Purchase::whereYear('purchase_date', $year)
                                            ->sum('discounted_price');
            }

            // ===== Quarters Revenue (last 4 quarters) =====
            $quarterRevenue = [];
            $quarterLabels = [];
            for ($i = 3; $i >= 0; $i--) {
                $quarterStart = Carbon::now()->subQuarters($i)->firstOfQuarter();
                $quarterEnd = Carbon::now()->subQuarters($i)->lastOfQuarter();
                $quarterLabels[] = 'Q' . $quarterStart->quarter . ' ' . $quarterStart->year;
                $quarterRevenue[] = Purchase::whereBetween('purchase_date', [$quarterStart, $quarterEnd])
                                            ->sum('discounted_price');
            }

            $allPayments = Payment::get();

            $hikayatPayments = $allPayments->where('paid_by', 'hikayat')->sum('product_price');
            $selfPayments = $allPayments->where('paid_by', 'self')->sum('product_price');

            $paymentBySource = [
                'all' => [
                    'hikayat' => $hikayatPayments,
                    'self' => $selfPayments
                ],
                'hikayat' => [
                    'hikayat' => $hikayatPayments,
                    'self' => 0
                ],
                'self' => [
                    'hikayat' => 0,
                    'self' => $selfPayments
                ],
            ];

            return view('dashboard.index', compact(
                'totalPurchases',
                'totalValue',
                'totalPaidAmount',
                'totalUnpaidAmount',
                'revenueChange',
                'paidChange',
                'unpaidChange',
                'purchaseChange',
                'monthlyRevenue',
                'monthLabels',
                'quarterRevenue',
                'quarterLabels',
                'yearlyRevenue',
                'yearLabels',
                'paymentBySource'
            ));
        } catch (\Throwable $th) {
            Log::error('Dashboard Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Something went wrong! Please try again later');
        }
    }

    public function trash(Request $request)
    {
        try {
            $deletedPayments = Payment::onlyTrashed()->get();
            $deletedPurchases = Purchase::onlyTrashed()->get();
            return view('dashboard.trash.index', compact('deletedPayments', 'deletedPurchases'));
        } catch (\Throwable $th) {
            Log::error('Trash Page Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Something went wrong! Please try again later');
        }
    }
}
