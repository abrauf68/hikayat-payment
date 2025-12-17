@extends('layouts.master')

@section('title', 'Purchases')

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

        .main-content-purchase {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        @media (max-width: 1200px) {
            .main-content-purchase {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        form-section,
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

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }
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

        .price-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        @media (max-width: 576px) {
            .price-row {
                grid-template-columns: 1fr;
            }
        }

        .status-options {
            display: flex;
            gap: 12px;
            margin-top: 5px;
        }

        @media (max-width: 576px) {
            .status-options {
                flex-direction: column;
                gap: 10px;
            }
        }

        .status-option {
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

        .status-option:hover {
            background-color: #f9f9f9;
        }

        .status-option.active {
            border-color: #457b9d;
            background-color: #edf2f7;
            color: #457b9d;
        }

        .status-option-edit {
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

        .status-option-edit:hover {
            background-color: #f9f9f9;
        }

        .status-option-edit.active {
            border-color: #457b9d;
            background-color: #edf2f7;
            color: #457b9d;
        }

        .btn {
            padding: 14px 24px;
            background-color: #457b9d;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn:hover {
            background-color: #386691;
        }

        .btn-add {
            width: 100%;
            margin-top: 10px;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
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

        .variant-summary {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .variant-summary {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }

        .variant-card {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #457b9d;
        }

        .variant-card h4 {
            color: #457b9d;
            margin-bottom: 10px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .variant-card .amount {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: #1d3557;
        }

        .variant-card .count {
            font-size: 0.9rem;
            color: #666;
        }

        .month-selector {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 25px;
            background-color: #edf2f7;
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
            }

            .month-selector label {
                text-align: center;
            }

            .month-selector select {
                min-width: 100%;
            }
        }

        .action-buttons {
            display: flex;
            gap: 8px;
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

        .edit-btn {
            background-color: #ffc107;
            color: #212529;
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

        .edit-btn:hover {
            background-color: #e0a800;
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

        .no-purchases {
            text-align: center;
            padding: 40px 20px;
            color: #7f8c8d;
            font-style: italic;
        }

        .stats-section {
            margin-top: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #2a9d8f 0%, #1d3557 100%);
            color: white;
            border-radius: 8px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .stat-card {
            text-align: center;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
        }

        .stat-card h4 {
            font-size: 1rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .stat-card .value {
            font-size: 1.8rem;
            font-weight: 700;
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

            .delete-btn,
            .edit-btn {
                padding: 6px 10px;
                font-size: 0.85rem;
            }
        }

        /* Print styles */
        @media print {

            .btn,
            .delete-btn,
            .edit-btn,
            .month-selector,
            .form-section {
                display: none !important;
            }

            body {
                background: white;
                padding: 0;
            }

            .container {
                max-width: 100%;
            }

            .summary-section,
            .form-section:last-child {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }

        .search-filter {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 200px;
        }

        .filter-box {
            width: 200px;
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

        .custom-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 9999;
        }

        .modal-box {
            background: #fff;
            width: 450px;
            margin: 10% auto;
            padding: 20px;
            border-radius: 6px;
            position: relative;
        }

        .close-modal {
            position: absolute;
            right: 12px;
            top: 8px;
            cursor: pointer;
            font-size: 22px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <header class="dashboard-header">
            <div class="header-left">
                <h1><i class="fas fa-shopping-cart"></i> Purchase Management System</h1>
                <p>Track purchases by variant, client, payment status with monthly subtotals</p>
            </div>
        </header>

        <div class="main-content-purchase">
            <form action="{{ route('purchase.store') }}" method="POST">
                @csrf
                <div class="form-section">
                    <input type="hidden" name="status" id="status" value="paid">
                    <h2 class="section-title"><i class="fas fa-plus-circle"></i> Add New Purchase</h2>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="variant_name">Variant Name<span class="text-danger">*</span></label>
                            <input type="text" id="variant_name" name="variant_name" placeholder="Variant Name" required>
                            @error('variant_name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="client_name">Client Name<span class="text-danger">*</span></label>
                            <input type="text" id="client_name" name="client_name" placeholder="Enter client name"
                                required>
                            @error('client_name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="price-row">
                        <div class="form-group">
                            <label for="original_price">Original Price (PKR)<span class="text-danger">*</span></label>
                            <input type="number" id="original_price" name="original_price" min="0" placeholder="0"
                                required>
                            @error('original_price')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="discounted_price">Discounted Price (PKR)<span class="text-danger">*</span></label>
                            <input type="number" id="discounted_price" name="discounted_price" min="0"
                                placeholder="0" required>
                            @error('discounted_price')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Payment Status<span class="text-danger">*</span></label>
                        <div class="status-options">
                            <div class="status-option active" data-status="paid">
                                <i class="fas fa-check-circle"></i> Paid
                            </div>
                            <div class="status-option" data-status="unpaid">
                                <i class="fas fa-clock"></i> Unpaid
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="purchase_date">Purchase Date<span class="text-danger">*</span></label>
                            <input type="date" id="purchase_date" name="purchase_date" required>
                            @error('purchase_date')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="payment_date">Payment Date (If Paid)</label>
                            <input type="date" id="payment_date" name="payment_date">
                            @error('payment_date')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-add" id="addPurchase">
                        <i class="fas fa-plus"></i> Add Purchase
                    </button>

                    <a href="{{ route('purchase-terminal') }}" class="btn btn-secondary"
                        style="margin-top: 10px; width: 100%;">
                        <i class="fas fa-broom"></i> Clear Form
                    </a>
                </div>
            </form>

            <div class="summary-section">
                {{-- <h2 class="section-title"><i class="fas fa-chart-bar"></i> Monthly Summary</h2>

                <div class="month-selector">
                    <label for="monthFilter"><i class="fas fa-calendar-alt"></i> Select Month:</label>
                    <select id="monthFilter">
                        <!-- Months will be populated by JavaScript -->
                    </select>
                </div> --}}
                <h2 class="section-title"><i class="fas fa-chart-pie"></i> Monthly Summary
                    <!-- Reset -->
                    <button type="button" id="resetFilters" class="reset-btn" title="Reset Filters">
                        <i class="fas fa-rotate-left"></i>
                    </button>
                </h2>

                <form action="{{ route('purchase-terminal') }}" method="GET" id="filterForm">
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

                <div class="variant-summary" id="variantSummary">
                    @if (isset($latestPurchases) && $latestPurchases->count() > 0)
                        @foreach ($latestPurchases as $purchase)
                            <div class="variant-card">
                                <h4><i class="fas fa-box"></i> {{ $purchase->variant_name }}</h4>
                                <div class="amount">{{ \App\Helpers\Helper::formatCurrency($purchase->discounted_price) }}
                                </div>
                                <div class="count">Client: {{ $purchase->client_name }}</div>
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1/-1; text-align: center; padding: 30px; color: #7f8c8d;">
                            <i class="fas fa-chart-bar fa-2x" style="margin-bottom: 15px;"></i>
                            <p>No purchases for selected month</p>
                        </div>
                    @endif
                </div>

                <div class="stats-section">
                    <h3 class="section-title" style="color: white; border-bottom-color: rgba(255,255,255,0.2);">
                        <i class="fas fa-chart-pie"></i> Financial Overview
                    </h3>

                    <div class="stats-row">
                        <div class="stat-card">
                            <h4>Total Purchases</h4>
                            <div class="value" id="totalPurchases">{{ $totalPurchases }}</div>
                        </div>

                        <div class="stat-card">
                            <h4>Total Value</h4>
                            <div class="value" id="totalValue">{{ \App\Helpers\Helper::formatCurrency($totalValue) }}
                            </div>
                        </div>

                        <div class="stat-card">
                            <h4>Paid Amount</h4>
                            <div class="value" id="paidAmount">
                                {{ \App\Helpers\Helper::formatCurrency($totalPaidAmount) }}</div>
                        </div>

                        <div class="stat-card">
                            <h4>Pending Amount</h4>
                            <div class="value" id="pendingAmount">
                                {{ \App\Helpers\Helper::formatCurrency($totalUnpaidAmount) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section" style="margin-top: 25px;">
            <h2 class="section-title"><i class="fas fa-list"></i> Purchase History</h2>
            <form action="{{ route('purchase-terminal') }}" method="GET" id="searchFilterForm">
                <div class="search-filter">
                    <div class="search-box">
                        <input type="text" id="searchInput" name="search"
                            placeholder="Search by client or variant...">
                    </div>
                    <div class="filter-box">
                        <select id="statusFilter" name="status">
                            <option value="all">All Status</option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                        </select>
                    </div>
                    <div class="filter-box">
                        <button type="submit" class="btn btn-add" style="margin: 0;">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                    <div class="filter-box">
                        <a href="{{ route('purchase-terminal') }}" type="button" class="btn btn-add" style="margin: 0;" title="Reset Filters">
                            <i class="fas fa-rotate-left"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-container">
                @if (isset($purchases) && count($purchases) > 0)
                    <table id="purchaseTable">
                        <thead>
                            <tr>
                                <th>Variant</th>
                                <th>Client</th>
                                <th>Original Price</th>
                                <th>Discounted Price</th>
                                <th>Status</th>
                                <th>Purchase Date</th>
                                <th>Payment Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="purchaseTableBody">
                            @foreach ($purchases as $purchase)
                                <tr>
                                    <td><strong>{{ $purchase->variant_name }}</strong></td>
                                    <td>{{ $purchase->client_name }}</td>
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
                                            <button class="edit-btn" data-id="{{ $purchase->id }}"
                                                data-variant="{{ $purchase->variant_name }}"
                                                data-client="{{ $purchase->client_name }}"
                                                data-original="{{ $purchase->original_price }}"
                                                data-discounted="{{ $purchase->discounted_price }}"
                                                data-status="{{ $purchase->payment_status }}"
                                                data-purchase="{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}"
                                                data-payment="{{ $purchase->payment_date ? \Carbon\Carbon::parse($purchase->payment_date)->format('Y-m-d') : '' }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            @canany(['delete user'])
                                                <form action="{{ route('purchase.destroy', $purchase->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <a href="#" type="submit" class="delete-btn delete_confirmation"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Delete Purchase') }}">
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
                    <div id="noPurchasesMessage" class="no-purchases">
                        <i class="fas fa-shopping-cart fa-2x" style="margin-bottom: 15px;"></i>
                        <p>No purchases added yet. Start by adding your first purchase above.</p>
                    </div>
                @endif
            </div>
        </div>

        <div id="editModal" class="custom-modal">
            <div class="modal-box">
                <span class="close-modal">&times;</span>
                <form method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status_edit" id="status_edit" value="">
                    <div class="form-section">
                        <input type="hidden" name="status" id="status" value="paid">
                        <h2 class="section-title"><i class="fas fa-plus-circle"></i> Edit Purchase</h2>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="variant_name_edit">Variant Name<span class="text-danger">*</span></label>
                                <input type="text" id="variant_name_edit" name="variant_name_edit"
                                    placeholder="Variant Name" required>
                                @error('variant_name_edit')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="client_name_edit">Client Name<span class="text-danger">*</span></label>
                                <input type="text" id="client_name_edit" name="client_name_edit"
                                    placeholder="Enter client name" required>
                                @error('client_name_edit')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="price-row">
                            <div class="form-group">
                                <label for="original_price_edit">Original Price (PKR)<span
                                        class="text-danger">*</span></label>
                                <input type="number" id="original_price_edit" name="original_price_edit" min="0"
                                    placeholder="0" required>
                                @error('original_price_edit')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="discounted_price_edit">Discounted Price (PKR)<span
                                        class="text-danger">*</span></label>
                                <input type="number" id="discounted_price_edit" name="discounted_price_edit"
                                    min="0" placeholder="0" required>
                                @error('discounted_price_edit')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Payment Status<span class="text-danger">*</span></label>
                            <div class="status-options">
                                <div class="status-option-edit active" data-status-edit="paid">
                                    <i class="fas fa-check-circle"></i> Paid
                                </div>
                                <div class="status-option-edit" data-status-edit="unpaid">
                                    <i class="fas fa-clock"></i> Unpaid
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="purchase_date_edit">Purchase Date<span class="text-danger">*</span></label>
                                <input type="date" id="purchase_date_edit" name="purchase_date_edit" required>
                                @error('purchase_date_edit')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="payment_date_edit">Payment Date (If Paid)</label>
                                <input type="date" id="payment_date_edit" name="payment_date_edit">
                                @error('payment_date_edit')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-add" id="editPurchase">
                            <i class="fas fa-plus"></i> Edit Purchase
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const statusOptions = document.querySelectorAll('.status-option');
        const paymentStatusInput = document.getElementById('status');
        const purchaseDateInput = document.getElementById('purchase_date');
        const paymentDateInput = document.getElementById('payment_date');

        // Set today's date safely
        const today = new Date().toISOString().split('T')[0];

        if (purchaseDateInput) purchaseDateInput.value = today;
        if (paymentDateInput) paymentDateInput.value = today;

        statusOptions.forEach(option => {
            option.addEventListener('click', () => {

                statusOptions.forEach(opt => opt.classList.remove('active'));
                option.classList.add('active');

                const selectedStatus = option.getAttribute('data-status');

                // Disable payment date if unpaid
                if (paymentDateInput) {
                    paymentDateInput.disabled = selectedStatus === 'unpaid';

                    // Optional: clear date if unpaid
                    if (selectedStatus === 'unpaid') {
                        paymentDateInput.value = '';
                    }
                }

                // Set hidden input
                if (paymentStatusInput) {
                    paymentStatusInput.value = selectedStatus;
                }
            });
        });
    </script>

    {{-- <script>
        const modal = document.getElementById('editModal');
        const closeBtn = document.querySelector('.close-modal');
        const form = document.getElementById('editForm');

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const statusOptionsEdit = document.querySelectorAll('.status-option-edit');
                const paymentStatusInputEdit = document.getElementById('status_edit');
                const paymentDateInputEdit = document.getElementById('payment_date_edit');

                document.getElementById('variant_name_edit').value = btn.dataset.variant;
                document.getElementById('client_name_edit').value = btn.dataset.client;
                document.getElementById('original_price_edit').value = btn.dataset.original;
                document.getElementById('discounted_price_edit').value = btn.dataset.discounted;
                document.getElementById('purchase_date_edit').value = btn.dataset.purchase;
                document.getElementById('payment_date_edit').value = btn.dataset.payment || '';
                document.getElementById('status_edit').value = btn.dataset.status;

                let actionUrl = "{{ route('purchase.update', ':id') }}";
                actionUrl = actionUrl.replace(':id', btn.dataset.id);

                form.action = actionUrl;

                modal.style.display = 'block';

                statusOptionsEdit.forEach(option => {
                    option.addEventListener('click', () => {

                        statusOptionsEdit.forEach(opt => opt.classList.remove('active'));
                        option.classList.add('active');

                        const selectedStatusEdit = option.getAttribute('data-status-edit');

                        // Disable payment date if unpaid
                        if (paymentDateInputEdit) {
                            paymentDateInputEdit.disabled = selectedStatusEdit === 'unpaid';

                            // Optional: clear date if unpaid
                            if (selectedStatusEdit === 'unpaid') {
                                paymentDateInputEdit.value = '';
                            }
                        }

                        // Set hidden input
                        if (paymentStatusInputEdit) {
                            paymentStatusInputEdit.value = selectedStatusEdit;
                        }
                    });
                });
            });
        });

        closeBtn.onclick = () => modal.style.display = 'none';

        window.onclick = e => {
            if (e.target === modal) modal.style.display = 'none';
        };
    </script> --}}

    <script>
    const modal = document.getElementById('editModal');
    const closeBtn = document.querySelector('.close-modal');
    const form = document.getElementById('editForm');

    const statusOptionsEdit = document.querySelectorAll('.status-option-edit');
    const paymentStatusInputEdit = document.getElementById('status_edit');
    const paymentDateInputEdit = document.getElementById('payment_date_edit');

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {

            // ===== Fill form fields =====
            document.getElementById('variant_name_edit').value = btn.dataset.variant;
            document.getElementById('client_name_edit').value = btn.dataset.client;
            document.getElementById('original_price_edit').value = btn.dataset.original;
            document.getElementById('discounted_price_edit').value = btn.dataset.discounted;
            document.getElementById('purchase_date_edit').value = btn.dataset.purchase;
            paymentDateInputEdit.value = btn.dataset.payment || '';

            const currentStatus = btn.dataset.status; // paid | unpaid
            paymentStatusInputEdit.value = currentStatus;

            // ===== Set active status on modal open =====
            statusOptionsEdit.forEach(opt => {
                opt.classList.remove('active');

                if (opt.dataset.statusEdit === currentStatus) {
                    opt.classList.add('active');
                }
            });

            // ===== Enable / Disable payment date =====
            if (currentStatus === 'unpaid') {
                paymentDateInputEdit.disabled = true;
                paymentDateInputEdit.value = '';
            } else {
                paymentDateInputEdit.disabled = false;
            }

            // ===== Set form action =====
            let actionUrl = "{{ route('purchase.update', ':id') }}";
            form.action = actionUrl.replace(':id', btn.dataset.id);

            modal.style.display = 'block';
        });
    });

    // ===== Status click handler (ONE TIME) =====
    statusOptionsEdit.forEach(option => {
        option.addEventListener('click', () => {

            statusOptionsEdit.forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');

            const selectedStatus = option.dataset.statusEdit;
            paymentStatusInputEdit.value = selectedStatus;

            if (selectedStatus === 'unpaid') {
                paymentDateInputEdit.disabled = true;
                paymentDateInputEdit.value = '';
            } else {
                paymentDateInputEdit.disabled = false;
            }
        });
    });

    // ===== Close modal =====
    closeBtn.onclick = () => modal.style.display = 'none';

    window.onclick = e => {
        if (e.target === modal) modal.style.display = 'none';
    };
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
            window.location.href = "{{ route('purchase-terminal') }}";
        });
    </script>
@endsection
