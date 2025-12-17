@extends('layouts.master')

@section('title', 'Dashboard')

@section('css')

@endsection

@section('content')
    <!-- Dashboard Stats -->
    <div class="dashboard-stats">
        <div class="main-stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-rupee-sign"></i>
            </div>
            <div class="stat-info">
                <h3 id="totalRevenue">{{ \App\Helpers\Helper::formatCurrency($totalValue) }}</h3>
                <p>Total Revenue</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>12.5% from last month</span>
                </div>
            </div>
        </div>

        <div class="main-stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3 id="paidPayments">{{ \App\Helpers\Helper::formatCurrency($totalPaidAmount) }}</h3>
                <p>Paid Payments</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>8.2% from last month</span>
                </div>
            </div>
        </div>

        <div class="main-stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3 id="pendingPayments">{{ \App\Helpers\Helper::formatCurrency($totalUnpaidAmount) }}</h3>
                <p>Pending Payments</p>
                <div class="stat-change negative">
                    <i class="fas fa-arrow-down"></i>
                    <span>3.1% from last month</span>
                </div>
            </div>
        </div>

        <div class="main-stat-card">
            <div class="stat-icon red">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3 id="totalPurchases">{{ \App\Helpers\Helper::formatCurrency($totalPurchases) }}</h3>
                <p>Total Purchases</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>15.7% from last month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-section">
        <div class="chart-card">
            <div class="chart-header">
                <h3>Revenue Overview</h3>
                <div class="chart-actions">
                    <button class="chart-btn active" data-period="month">Monthly</button>
                    <button class="chart-btn" data-period="quarter">Quarterly</button>
                    <button class="chart-btn" data-period="year">Yearly</button>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-placeholder">
                    <i class="fas fa-chart-line"></i>
                    <p>Revenue chart will be displayed here</p>
                    <small>Integrated with payment and purchase data</small>
                </div>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3>Payment Status</h3>
                <div class="chart-actions">
                    <button class="chart-btn active" data-type="all">All</button>
                    <button class="chart-btn" data-type="hikayat">Hikayat</button>
                    <button class="chart-btn" data-type="self">Self</button>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-placeholder">
                    <i class="fas fa-chart-pie"></i>
                    <p>Payment distribution chart</p>
                    <small>Showing paid vs unpaid status</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="recent-activities">
        <div class="activities-header">
            <h3>Recent Activities</h3>
            <button class="chart-btn">View All</button>
        </div>

        <div class="activities-list" id="activitiesList">
            <!-- Activities will be populated by JavaScript -->
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <div class="action-card payment" id="quickPayment">
            <div class="action-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <h3>Add Payment</h3>
            <p>Record a new payment in the tracker</p>
        </div>

        <div class="action-card purchase" id="quickPurchase">
            <div class="action-icon">
                <i class="fas fa-cart-plus"></i>
            </div>
            <h3>Add Purchase</h3>
            <p>Add a new purchase record</p>
        </div>

        <div class="action-card report" id="quickReport">
            <div class="action-icon">
                <i class="fas fa-file-export"></i>
            </div>
            <h3>Generate Report</h3>
            <p>Create monthly financial report</p>
        </div>

        <div class="action-card settings" id="quickSettings">
            <div class="action-icon">
                <i class="fas fa-sliders-h"></i>
            </div>
            <h3>Settings</h3>
            <p>Configure dashboard preferences</p>
        </div>
    </div>
@endsection

@section('script')

@endsection
