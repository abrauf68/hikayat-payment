@extends('layouts.master')

@section('title', 'Payments')

@section('css')
    <style>
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 20px 25px;
            background: linear-gradient(135deg, #2a9d8f 0%, #1d3557 100%);
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* LEFT */
        .header-left h1 {
            font-size: 2rem;
            margin-bottom: 6px;
        }

        .header-left p {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* RIGHT */
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* PROFILE */
        .profile-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.9rem;
        }

        .profile-icon {
            font-size: 2.2rem;
            cursor: pointer;
        }

        .profile-name {
            margin-top: 4px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        /* MOBILE */
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .header-right {
                align-self: flex-end;
            }
        }


        .main-content-payment {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        @media (max-width: 992px) {
            .main-content-payment {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        .form-section,
        .summary-section {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-size: 1.3rem;
            margin-bottom: 18px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #2a9d8f;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
            font-size: 0.95rem;
        }

        input,
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border 0.3s;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #2a9d8f;
            box-shadow: 0 0 0 2px rgba(42, 157, 143, 0.2);
        }

        .paid-by-options {
            display: flex;
            gap: 12px;
            margin-top: 5px;
        }

        @media (max-width: 576px) {
            .paid-by-options {
                flex-direction: column;
                gap: 10px;
            }
        }

        .paid-by-option {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 8px;
            border: 2px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-size: 0.95rem;
            text-align: center;
        }

        .paid-by-option:hover {
            background-color: #f9f9f9;
        }

        .paid-by-option.active {
            border-color: #2a9d8f;
            background-color: #e9f7f5;
            color: #2a9d8f;
        }

        .btn-add {
            width: 100%;
            margin-top: 10px;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th {
            background-color: #2a9d8f;
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95rem;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid #eee;
            font-size: 0.95rem;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f0f9f8;
        }

        .monthly-summary {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-top: 20px;
        }

        @media (max-width: 576px) {
            .monthly-summary {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }

        .account-summary {
            padding: 20px 15px;
            border-radius: 8px;
            color: white;
        }

        .account-summary h3 {
            font-size: 1.2rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .account-summary h3 i {
            font-size: 1.3rem;
        }

        .account-summary .amount {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .account-summary p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .hikayat-account {
            background: linear-gradient(135deg, #2a9d8f 0%, #1d3557 100%);
        }

        .self-account {
            background: linear-gradient(135deg, #e76f51 0%, #e63946 100%);
        }

        /* PROFIT */
        .profitable {
            background: linear-gradient(135deg, #2ecc71 0%, #1e8449 100%);
            color: #fff;
        }

        /* LOSS */
        .loss {
            background: linear-gradient(135deg, #e63946 0%, #6a040f 100%);
            color: #fff;
        }

        .total-amount {
            background: linear-gradient(135deg, #457b9d 0%, #1d3557 100%);
        }


        .month-selector {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 25px;
            background-color: #f0f9f8;
            padding: 15px;
            border-radius: 8px;
        }

        .month-selector label {
            margin-bottom: 0;
            font-size: 1.05rem;
            white-space: nowrap;
        }

        .month-selector select {
            width: auto;
            min-width: 200px;
            flex-grow: 1;
        }

        @media (max-width: 576px) {
            .month-selector {
                flex-direction: column;
                align-items: stretch;
                width: 100%;
            }

            .month-selector label {
                text-align: center;
            }

            .month-selector select {
                min-width: 100%;
            }
        }

        .delete-btn {
            background-color: #e63946;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
        }

        .delete-btn:hover {
            background-color: #c1121f;
        }

        .no-payments {
            text-align: center;
            padding: 40px 20px;
            color: #7f8c8d;
            font-style: italic;
        }

        .total-section {
            margin-top: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #457b9d 0%, #1d3557 100%);
            color: white;
            border-radius: 8px;
            text-align: center;
        }

        .total-section h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .total-section .amount {
            font-size: 2.2rem;
            font-weight: 700;
        }

        .total-section p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Mobile-specific adjustments */
        @media (max-width: 768px) {
            header {
                padding: 15px 10px;
                margin-bottom: 20px;
            }

            header h1 {
                font-size: 1.7rem;
            }

            header p {
                font-size: 0.95rem;
            }

            .form-section,
            .summary-section {
                padding: 18px 15px;
            }

            .section-title {
                font-size: 1.2rem;
            }

            .total-section .amount {
                font-size: 1.9rem;
            }

            .account-summary .amount {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 480px) {
            header h1 {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 1.1rem;
            }

            th,
            td {
                padding: 12px 10px;
                font-size: 0.9rem;
            }

            .delete-btn {
                padding: 6px 10px;
                font-size: 0.85rem;
            }

            .account-summary {
                padding: 15px 12px;
            }

            .account-summary .amount {
                font-size: 1.4rem;
            }

            .total-section .amount {
                font-size: 1.7rem;
            }
        }

        /* Payment badge styling */
        .paid-by-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .paid-by-badge.hikayat {
            background-color: #e9f7f5;
            color: #2a9d8f;
        }

        .paid-by-badge.self {
            background-color: #ffeaea;
            color: #e63946;
        }

        /* Action buttons container for mobile */
        .action-buttons {
            display: flex;
            gap: 8px;
            /* flex-wrap: wrap; */
        }

        /* Print styles */
        @media print {

            .btn,
            .delete-btn,
            .month-selector {
                display: none !important;
            }

            .container {
                max-width: 100%;
            }

            .form-section {
                display: none;
            }

            .summary-section,
            .form-section:last-child {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }

        .reset-btn {
            border: none;
            background: #f3f3f3;
            padding: 10px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .reset-btn:hover {
            background: #e2e2e2;
        }
        .btn-restore {
            background-color: #f0d068;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
        }

        .btn-restore:hover {
            background-color: #ecc84f;
        }

        .discount-badge {
            background-color: #ffd166;
            color: #7d6608;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-left: 5px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-badge.paid {
            background-color: #d4edda;
            color: #155724;
        }

        .status-badge.unpaid {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <header class="dashboard-header">
            <div class="header-left">
                <h1><i class="fas fa-trash"></i> Trash</h1>
                <p>You can manage your trash from here.</p>
            </div>
        </header>

        <div class="form-section" style="margin-top: 25px;">
            <h2 class="section-title"><i class="fas fa-list"></i> Payments Trash</h2>

            <div class="table-container">
                @if (isset($deletedPayments) && count($deletedPayments) > 0)
                    <table id="paymentTable">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Paid By</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="paymentTableBody">
                            @foreach ($deletedPayments as $index => $payment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $payment->product_name }}</td>
                                    <td>{{ \App\Helpers\Helper::formatCurrency($payment->product_price) }}</td>
                                    <td>
                                        <span class="paid-by-badge {{ $payment->paid_by }}">
                                            @if ($payment->paid_by == 'hikayat')
                                                <i class="fas fa-building"></i> Hikayat
                                            @else
                                                <i class="fas fa-user"></i> Self
                                            @endif
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <form action="{{ route('payment.permanent-destroy', $payment->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="#" type="submit"
                                                    class="btn delete-btn delete_confirmation"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Permanent Delete') }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </form>
                                            <span class="text-nowrap">
                                                <a href="{{route('payment.restore', $payment->id)}}" class="btn btn-restore" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Restore Payment') }}">
                                                    <i class="fas fa-rotate-left"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <div id="noPaymentsMessage" class="no-payments">
                        <i class="fas fa-receipt fa-2x" style="margin-bottom: 15px;"></i>
                        <p>No payments in trash yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-section" style="margin-top: 25px;">
            <h2 class="section-title"><i class="fas fa-list"></i> Purchases Trash</h2>

            <div class="table-container">
                @if (isset($deletedPurchases) && count($deletedPurchases) > 0)
                    <table id="purchaseTable">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Variant</th>
                                <th>Client</th>
                                <th>Qty</th>
                                <th>Original Price</th>
                                <th>Discounted Price</th>
                                <th>Status</th>
                                <th>Purchase Date</th>
                                <th>Payment Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="purchaseTableBody">
                            @foreach ($deletedPurchases as $index => $purchase)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $purchase->variant_name }}</strong></td>
                                    <td>{{ $purchase->client_name }}</td>
                                    <td>{{ $purchase->quantity }}</td>
                                    <td>{{ \App\Helpers\Helper::formatCurrency($purchase->original_price) }}</td>
                                    <td>{{ \App\Helpers\Helper::formatCurrency($purchase->discounted_price) }}
                                        <span class="discount-badge">{{ $purchase->discount_percentage }}% off</span>
                                    </td>
                                    <td><span
                                            class="status-badge {{ $purchase->payment_status }}">{{ ucfirst($purchase->payment_status) }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($purchase->payment_date)->format('d M Y') }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <form action="{{ route('purchase.permanent-destroy', $purchase->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="#" type="submit"
                                                    class="btn delete-btn delete_confirmation"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Permanent Delete') }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </form>
                                            <span class="text-nowrap">
                                                <a href="{{route('purchase.restore', $purchase->id)}}" class="btn btn-restore" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Restore Purchase') }}">
                                                    <i class="fas fa-rotate-left"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <div id="noPurchasesMessage" class="no-payments">
                        <i class="fas fa-receipt fa-2x" style="margin-bottom: 15px;"></i>
                        <p>No purchases in trash yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
