<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê chủ đề</title>
    <link rel="stylesheet" href="{{ asset('css/styles10.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @php
    $totalAttempted = $rows->count();
    $avgAccuracy = $rows->count() ? round($rows->avg('tong_phan_tram_dung'), 2) : 0;
        $tongDung = (int)($rows->sum('tong_dung'));
        $tongCau  = (int)($rows->sum('tong_cau'));
        $tongSai  = max($tongCau - $tongDung, 0);
        $donutPct = $tongCau > 0 ? round(($tongDung / max($tongCau, 1)) * 100, 2) : 50;
    @endphp
    </head>
<body>
    <a href="{{ route('trangchinh') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Trang chính</a>
<div class="stats-container">
    <div class="stats-header">
        <div class="stats-title"><i class="fas fa-chart-pie"></i> Thống kê chủ đề</div>
        <div class="kpi">
            <div class="kpi-item">
                <div class="label">Số chủ đề đã làm</div>
                <div class="value">{{ $totalAttempted }}</div>
            </div>
            <div class="kpi-item">
                <div class="label">Độ chính xác trung bình</div>
                <div class="value">{{ $avgAccuracy }}%</div>
            </div>
            <div class="kpi-item">
                <div class="label">Tổng chủ đề của bạn</div>
                <div class="value">{{ $totalTopics ?? 0 }}</div>
            </div>
            <div class="kpi-item">
                <div class="label">Tổng câu đúng</div>
                <div class="value">{{ $tongDung }}</div>
            </div>
            <div class="kpi-item">
                <div class="label">Tổng câu sai</div>
                <div class="value">{{ $tongSai }}</div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top:20px;">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-chart-donut"></i> Tỉ lệ đúng/sai tổng thể</div>
        </div>
        <div class="card-body" style="padding: 20px;">
            <div style="max-width: 520px; margin: 0 auto; text-align:center;">
                <div id="donutFallback" class="donut-fallback" style="--pct: {{ $donutPct }}%;"></div>
                <canvas id="donutChart" width="520" height="520"></canvas>
                <div id="donutNote" class="muted" style="text-align:center;margin-top:8px;"></div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top:20px;">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-list"></i> Bảng thống kê theo chủ đề f</div>
        </div>
    @if($rows->isEmpty())
            <div class="empty">
                <i class="fas fa-clipboard-list"></i>
                <div>Chưa có dữ liệu thống kê. Hãy làm thử một bài kiểm tra/ôn tập để lưu kết quả.</div>
                <div class="back"><a href="{{ route('trangchinh') }}" class="btn"><i class="fas fa-home"></i> Về trang chính</a></div>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Chủ đề</th>
                            <th>ID</th>
                            <th>Tỉ lệ đúng</th>
                            <th>Số lần làm</th>
                            <th>Ngày tạo</th>
                            <th style="text-align:right;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            @php
                                $acc = (float)$row->tong_phan_tram_dung;
                                $badgeClass = $acc >= 80 ? 'good' : ($acc >= 50 ? 'medium' : 'bad');
                            @endphp
                            <tr>
                                <td class="topic-name">{{ $row->name }}</td>
                                <td>#{{ $row->id }}</td>
                                <td>
                                    <span class="badge {{ $badgeClass }}">
                                        @if($badgeClass==='good')<i class="fas fa-check-circle"></i>@elseif($badgeClass==='medium')<i class="fas fa-minus-circle"></i>@else<i class="fas fa-times-circle"></i>@endif
                                        {{ $acc }}%
                                    </span>
                                </td>
                                <td>{{ (int)$row->so_lan_lam }}</td>
                                <td class="muted">{{ 
                                    \Carbon\Carbon::parse($row->created_at)->format('d/m/Y H:i')
                                }}</td>
                                <td style="text-align:right;">
                                    <div class="row-actions">
                                        <a href="{{ url('/topics/'.$row->id.'/study') }}" class="btn btn-study"><i class="fas fa-book-open"></i> Ôn tập</a>
                                        <a href="{{ url('/topics/'.$row->id.'/test') }}" class="btn btn-test"><i class="fas fa-clipboard-check"></i> Làm bài</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
<script>
    // Vẽ donut chart cho tỉ lệ đúng/sai tổng thể + xử lý trường hợp chưa có dữ liệu
        const canvas = document.getElementById('donutChart');
    const noteEl = document.getElementById('donutNote');
        const fallbackEl = document.getElementById('donutFallback');
    const tongDung = {{ $tongDung }};
    const tongSai = {{ $tongSai }};
    const total = tongDung + tongSai;

    if (canvas) {
        if (typeof Chart === 'undefined') {
                if (noteEl) noteEl.textContent = 'Không thể tải thư viện biểu đồ. Đang hiển thị vòng tròn dự phòng.';
        } else {
            const hasData = total > 0;
            const dataVals = hasData ? [tongDung, tongSai] : [1, 1];
            const colors = hasData ? ['#10b981', '#ef4444'] : ['#e5e7eb', '#cbd5e1'];

            const data = {
                labels: ['Đúng', 'Sai'],
                datasets: [{ data: dataVals, backgroundColor: colors, borderWidth: 0 }]
            };
            const options = {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true } },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.label}: ${hasData ? ctx.parsed : 0} câu`
                        }
                    }
                },
                cutout: '65%'
            };
            new Chart(canvas, { type: 'doughnut', data, options });
                    if (fallbackEl) fallbackEl.style.display = 'none';
            if (!hasData && noteEl) noteEl.textContent = 'Chưa có dữ liệu để hiển thị.';
        }
    }
</script>
</body>
</html>