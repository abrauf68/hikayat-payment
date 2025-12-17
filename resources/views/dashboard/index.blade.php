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
                    <span>{{ number_format(abs($revenueChange), 1) }}% from last month</span>
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
                    <span>{{ number_format(abs($paidChange), 1) }}% from last month</span>
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
                    <span>{{ number_format(abs($unpaidChange), 1) }}% from last month</span>
                </div>
            </div>
        </div>

        <div class="main-stat-card">
            <div class="stat-icon red">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3 id="totalPurchases">{{ $totalPurchases }}</h3>
                <p>Total Purchases</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ number_format(abs($purchaseChange), 1) }}% from last month</span>
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
                <canvas id="revenueChart" height="250"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3>Payment Distribution</h3>
                <div class="chart-actions">
                    <button class="chart-btn active" data-type="all">All</button>
                    <button class="chart-btn" data-type="hikayat">Hikayat</button>
                    <button class="chart-btn" data-type="self">Self</button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="paymentChart" height="250"></canvas>
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
        <a href="{{ route('payment-terminal') }}">
            <div class="action-card payment" id="quickPayment">
                <div class="action-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h3>Add Payment</h3>
                <p>Record a new payment in the tracker</p>
            </div>
        </a>

        <a href="{{ route('purchase-terminal') }}">
            <div class="action-card purchase" id="quickPurchase">
                <div class="action-icon">
                    <i class="fas fa-cart-plus"></i>
                </div>
                <h3>Add Purchase</h3>
                <p>Add a new purchase record for tracking</p>
            </div>
        </a>

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');

        const chartData = {
            month: {
                labels: @json($monthLabels),
                data: @json($monthlyRevenue)
            },
            quarter: {
                labels: @json($quarterLabels),
                data: @json($quarterRevenue)
            },
            year: {
                labels: @json($yearLabels),
                data: @json($yearlyRevenue)
            }
        };

        let currentPeriod = 'month';

        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData[currentPeriod].labels,
                datasets: [{
                    label: 'Revenue',
                    data: chartData[currentPeriod].data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // ===== Toggle Chart Period =====
        document.querySelectorAll('.chart-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.chart-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                currentPeriod = btn.dataset.period;

                revenueChart.data.labels = chartData[currentPeriod].labels;
                revenueChart.data.datasets[0].data = chartData[currentPeriod].data;
                revenueChart.update();
            });
        });
    </script>
    <script>
        const paymentBySource = @json($paymentBySource);
        const ctxpie = document.getElementById('paymentChart').getContext('2d');

        let currentType = 'all';

        const chartConfig = {
            type: 'pie',
            data: {
                labels: ['Hikayat', 'Self'],
                datasets: [{
                    label: 'Payments',
                    data: [
                        paymentBySource[currentType].hikayat,
                        paymentBySource[currentType].self
                    ],
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.8)', // Blue for Hikayat
                        'rgba(46, 204, 113, 0.8)' // Green for Self
                    ],
                    borderColor: [
                        'rgba(52, 152, 219, 1)',
                        'rgba(46, 204, 113, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed;
                                let total = context.chart._metasets[context.datasetIndex].total;
                                let percent = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percent}%)`;
                            }
                        }
                    }
                }
            }
        };

        const paymentChart = new Chart(ctxpie, chartConfig);

        // ===== Toggle Buttons =====
        document.querySelectorAll('.chart-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.chart-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                currentType = btn.dataset.type;

                paymentChart.data.datasets[0].data = [
                    paymentBySource[currentType].hikayat,
                    paymentBySource[currentType].self
                ];
                paymentChart.update();
            });
        });
    </script>
@endsection
