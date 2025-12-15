<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display the payment terminal.
     */
    public function index()
    {
        try {
            $payments = Payment::latest()->get();

            $paymentBySelf = Payment::where('paid_by', 'self')->sum('product_price');
            $paymentByHikayat = Payment::where('paid_by', 'hikayat')->sum('product_price');
            $totalPayment = $paymentBySelf + $paymentByHikayat;

            return view('dashboard.payments.index', compact('payments'));
        } catch (\Throwable $th) {
            Log::error('Payment Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Store a new payment.
     */
    public function storePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'paid_by' => 'required|in:self,hikayat',
            'payment_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $payment = new Payment();
            $payment->product_name = $request->product_name;
            $payment->product_price = $request->product_price;
            $payment->paid_by = $request->paid_by;
            $payment->payment_date = $request->payment_date;
            $payment->save();
            DB::commit();
            return redirect()->back()->with('success', 'Payment Added Successfully');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            Log::error('Payment Store Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    /**
     * Delete a payment.
     */
    public function deletePayment($id)
    {
        try {
            $payment = Payment::find($id);
            if (!$payment) {
                return redirect()->back()->with('error', 'Payment not found');
            }
            $payment->delete();
            return redirect()->back()->with('success', 'Payment Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Payment Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function summary(Request $request)
    {
        $month = $request->month;
        $year  = $request->year;

        $hikayat = Payment::where('paid_by', 'hikayat')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('product_price');

        $self = Payment::where('paid_by', 'self')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('product_price');

        return response()->json([
            'hikayat' => $hikayat,
            'self'    => $self,
            'total'   => $hikayat + $self
        ]);
    }
}
