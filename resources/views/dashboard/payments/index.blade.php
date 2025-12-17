@extends('layouts.master')

@section('title', 'Payment Terminal')

@section('css')
    <style>
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

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
            body {
                padding: 10px;
            }

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
            flex-wrap: wrap;
        }

        /* Print styles */
        @media print {

            .btn,
            .delete-btn,
            .month-selector {
                display: none !important;
            }

            body {
                background: white;
                padding: 0;
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
    </style>
@endsection

@section('content')
    <div class="container">
        <header class="dashboard-header">
            <div class="header-left">
                <h1><i class="fas fa-receipt"></i> Payment Tracker</h1>
                <p>Track your product payments by Hikayat Account and Self Account with monthly subtotals</p>
            </div>
        </header>


        <div class="main-content-payment">
            <div class="form-section">
                <form action="{{ route('payment.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="paid_by" id="paid_by" value="hikayat">
                    <h2 class="section-title"><i class="fas fa-plus-circle"></i> Add New Payment</h2>

                    <div class="form-group">
                        <label for="product_name">Product Name<span class="text-danger">*</span></label>
                        <input type="text" id="product_name" name="product_name" placeholder="Enter product name"
                            required>
                        @error('product_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="product_price">Product Price (PKR)<span class="text-danger">*</span></label>
                        <input type="number" id="product_price" name="product_price" min="0" step="1"
                            placeholder="0" required>
                        @error('product_price')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Paid By</label>
                        <div class="paid-by-options">
                            <div class="paid-by-option active" data-account="hikayat">
                                <i class="fas fa-building"></i> Hikayat Account
                            </div>
                            <div class="paid-by-option" data-account="self">
                                <i class="fas fa-user"></i> Self Account
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="payment_date">Payment Date</label>
                        <input type="date" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" required>
                        @error('payment_date')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="custom-btn btn-add" id="addPayment">
                        <i class="fas fa-plus"></i> Add Payment
                    </button>
                </form>
            </div>

            <div class="summary-section">
                <h2 class="section-title"><i class="fas fa-chart-pie"></i> Monthly Summary
                    <!-- Reset -->
                    <button type="button" id="resetFilters" class="reset-btn" title="Reset Filters">
                        <i class="fas fa-rotate-left"></i>
                    </button>
                </h2>

                <form action="{{ route('payment-terminal') }}" method="GET" id="filterForm">
                    <div class="filters-row" style="display:flex; gap:15px; justify-content: center; align-items: center;">

                        <!-- Month -->
                        <div class="month-selector">
                            <label><i class="fas fa-calendar-alt"></i> Select Month</label>
                            <select id="monthFilter" name="month"></select>
                        </div>

                        <!-- Year -->
                        <div class="month-selector">
                            <label><i class="fas fa-calendar-alt"></i> Select Year</label>
                            <select id="yearFilter" name="year"></select>
                        </div>

                    </div>
                </form>



                <div class="monthly-summary">
                    <div class="account-summary hikayat-account">
                        <h3><i class="fas fa-building"></i> Hikayat Account</h3>
                        <div class="amount" id="hikayatTotal">{{ \App\Helpers\Helper::formatCurrency($paymentByHikayat) }}
                        </div>
                    </div>

                    <div class="account-summary self-account">
                        <h3><i class="fas fa-user"></i> Self Account</h3>
                        <div class="amount" id="selfTotal">{{ \App\Helpers\Helper::formatCurrency($paymentBySelf) }}</div>
                    </div>
                </div>

                <div class="total-section">
                    <h3><i class="fas fa-calculator"></i> Combined Total</h3>
                    <div class="amount" id="combinedTotal">{{ \App\Helpers\Helper::formatCurrency($totalPayment) }}</div>
                </div>
            </div>

        </div>

        <div class="form-section" style="margin-top: 25px;">
            <h2 class="section-title"><i class="fas fa-list"></i> Payment History</h2>

            <div class="table-container">
                @if (isset($payments) && count($payments) > 0)
                    <table id="paymentTable">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Paid By</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="paymentTableBody">
                            @foreach ($payments as $payment)
                                <tr>
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
                                            @canany(['delete user'])
                                                <form action="{{ route('payment.destroy', $payment->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <a href="#" type="submit" class="delete-btn delete_confirmation"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Delete Payment') }}">
                                                        <i class="fas fa-trash ti-md"></i> Delete
                                                    </a>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <div id="noPaymentsMessage" class="no-payments">
                        <i class="fas fa-receipt fa-2x" style="margin-bottom: 15px;"></i>
                        <p>No payments added yet. Start by adding your first payment above.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const paidByOptions = document.querySelectorAll('.paid-by-option');
        const paidByInput = document.getElementById('paid_by');

        paidByOptions.forEach(option => {
            option.addEventListener('click', () => {

                // remove active from all
                paidByOptions.forEach(opt => opt.classList.remove('active'));

                // add active to clicked
                option.classList.add('active');

                // set hidden input value
                paidByInput.value = option.getAttribute('data-account');
            });

            // mobile support
            option.addEventListener('touchstart', function(e) {
                e.preventDefault();
                this.click();
            });
        });
    </script>

    <script>
        const monthFilter = document.getElementById('monthFilter');
        const yearFilter = document.getElementById('yearFilter');
        const filterForm = document.getElementById('filterForm');
        const resetBtn = document.getElementById('resetFilters');

        const months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        const params = new URLSearchParams(window.location.search);

        const selectedMonth = params.get('month') || '';
        const selectedYear = params.get('year') || '';

        /* ---- Month ---- */
        let allMonthOption = new Option('All Months', '');
        monthFilter.add(allMonthOption);

        months.forEach((month, index) => {
            let option = new Option(month, index + 1);
            if (option.value == selectedMonth) option.selected = true;
            monthFilter.add(option);
        });

        /* ---- Year ---- */
        let allYearOption = new Option('All Years', '');
        yearFilter.add(allYearOption);

        const currentYear = new Date().getFullYear();
        for (let y = currentYear - 5; y <= currentYear + 1; y++) {
            let option = new Option(y, y);
            if (y == selectedYear) option.selected = true;
            yearFilter.add(option);
        }

        /* Auto submit on change */
        monthFilter.addEventListener('change', () => filterForm.submit());
        yearFilter.addEventListener('change', () => filterForm.submit());

        /* 🔄 Reset filters */
        resetBtn.addEventListener('click', () => {
            window.location.href = "{{ route('payment-terminal') }}";
        });
    </script>
@endsection
