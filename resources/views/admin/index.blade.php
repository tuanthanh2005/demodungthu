@extends('admin.layouts.admin')

@section('title', 'Bảng điều khiển')
@section('page-title', 'Bảng điều khiển phân tích')

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-header">
                <span class="stat-title">Lượt truy cập</span>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-value">2,382</div>
            <div class="stat-change positive">+3.65% so với tuần trước</div>
        </div>

        <div class="stat-card green">
            <div class="stat-header">
                <span class="stat-title">Doanh thu</span>
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
            <div class="stat-value">21.300.000 đ</div>
            <div class="stat-change positive">+6.65% so với tuần trước</div>
        </div>

        <div class="stat-card yellow">
            <div class="stat-header">
                <span class="stat-title">Khách hàng</span>
                <div class="stat-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
            </div>
            <div class="stat-value">14,212</div>
            <div class="stat-change positive">+1.48% so với tuần trước</div>
        </div>

        <div class="stat-card red">
            <div class="stat-header">
                <span class="stat-title">Đơn đặt hàng</span>
                <div class="stat-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
            <div class="stat-value">64</div>
            <div class="stat-change negative">-2.75% so với tuần trước</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <!-- Revenue Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Doanh thu theo tháng</h3>
                <div class="chart-filter">
                    <button class="filter-btn">Tuần</button>
                    <button class="filter-btn active">Tháng</button>
                    <button class="filter-btn">Năm</button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Trình duyệt</h3>
            </div>
            <div class="donut-chart">
                <canvas id="donutChart"></canvas>
            </div>
            <div class="donut-legend">
                <div class="legend-item">
                    <div class="legend-label">
                        <div class="legend-color" style="background: #4285f4;"></div>
                        <span>Chrome</span>
                    </div>
                    <span class="legend-value">45%</span>
                </div>
                <div class="legend-item">
                    <div class="legend-label">
                        <div class="legend-color" style="background: #fbbc04;"></div>
                        <span>Safari</span>
                    </div>
                    <span class="legend-value">30%</span>
                </div>
                <div class="legend-item">
                    <div class="legend-label">
                        <div class="legend-color" style="background: #ea4335;"></div>
                        <span>Firefox</span>
                    </div>
                    <span class="legend-value">25%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="charts-grid">
        <!-- Calendar -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Lịch</h3>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <button class="filter-btn"><i class="fas fa-chevron-left"></i></button>
                    <span style="font-size: 14px; font-weight: 500;">Tháng 2, 2026</span>
                    <button class="filter-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="calendar-grid">
                <div class="calendar-header">T2</div>
                <div class="calendar-header">T3</div>
                <div class="calendar-header">T4</div>
                <div class="calendar-header">T5</div>
                <div class="calendar-header">T6</div>
                <div class="calendar-header">T7</div>
                <div class="calendar-header">CN</div>
                
                <div class="calendar-day"></div>
                <div class="calendar-day"></div>
                <div class="calendar-day"></div>
                <div class="calendar-day"></div>
                <div class="calendar-day"></div>
                <div class="calendar-day">1</div>
                <div class="calendar-day">2</div>
                <div class="calendar-day">3</div>
                <div class="calendar-day">4</div>
                <div class="calendar-day">5</div>
                <div class="calendar-day">6</div>
                <div class="calendar-day">7</div>
                <div class="calendar-day today">8</div>
                <div class="calendar-day">9</div>
                <div class="calendar-day">10</div>
                <div class="calendar-day">11</div>
                <div class="calendar-day">12</div>
                <div class="calendar-day">13</div>
                <div class="calendar-day">14</div>
                <div class="calendar-day">15</div>
                <div class="calendar-day">16</div>
                <div class="calendar-day">17</div>
                <div class="calendar-day">18</div>
                <div class="calendar-day">19</div>
                <div class="calendar-day">20</div>
                <div class="calendar-day">21</div>
                <div class="calendar-day">22</div>
                <div class="calendar-day">23</div>
                <div class="calendar-day">24</div>
                <div class="calendar-day">25</div>
                <div class="calendar-day">26</div>
                <div class="calendar-day">27</div>
                <div class="calendar-day">28</div>
            </div>
        </div>

        <!-- Map -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Người dùng theo khu vực</h3>
            </div>
            <div class="map-container">
                <canvas id="mapChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            datasets: [{
                label: 'Doanh thu',
                data: [1200, 1900, 1500, 2200, 2800, 2400, 3100, 2900, 3400, 3800, 3600, 4100],
                borderColor: '#4285f4',
                backgroundColor: 'rgba(66, 133, 244, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 0,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f3f4'
                    },
                    ticks: {
                        callback: function(value) {
                            return value / 1000 + 'K';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Donut Chart
    const donutCtx = document.getElementById('donutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Chrome', 'Safari', 'Firefox'],
            datasets: [{
                data: [45, 30, 25],
                backgroundColor: ['#4285f4', '#fbbc04', '#ea4335'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    });

    // Map Chart (World Map Visualization)
    const mapCtx = document.getElementById('mapChart').getContext('2d');
    const mapImage = new Image();
    mapImage.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iODAwIiBoZWlnaHQ9IjQwMCIgZmlsbD0iI2YxZjNmNCIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTgiIGZpbGw9IiM1ZjYzNjgiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5CxINuIMSR4buTIHRo4bq/IGdp4buRaSB04bqhaSDEkcOieTwvdGV4dD48L3N2Zz4=';
    mapImage.onload = function() {
        mapCtx.drawImage(mapImage, 0, 0, mapCtx.canvas.width, mapCtx.canvas.height);
        
        // Add some dots for visitor locations
        const locations = [
            {x: 150, y: 100}, {x: 400, y: 150}, {x: 600, y: 120},
            {x: 200, y: 180}, {x: 500, y: 200}
        ];
        
        locations.forEach(loc => {
            mapCtx.beginPath();
            mapCtx.arc(loc.x, loc.y, 5, 0, 2 * Math.PI);
            mapCtx.fillStyle = '#4285f4';
            mapCtx.fill();
        });
    };
</script>
@endpush
