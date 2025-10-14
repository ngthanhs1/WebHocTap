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
<body style="background: #fff; color: #000;">
    <a href="{{ route('trangchinh') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Trang chính</a>
<div class="stats-container">
    <div class="stats-header">
        <div class="stats-title" style="font-size: 1.4rem; font-weight: 700; color: #000; margin-bottom: 16px;"><i class="fas fa-chart-pie"></i> Thống kê chủ đề</div>
        <div class="kpi" style="display: flex; gap: 16px; flex-wrap: wrap;">
            <div class="kpi-item" style="background: #fff; border: 1px solid #e0e0e0; padding: 12px 16px; border-radius: 8px; min-width: 120px; color: #000;">
                <div class="label" style="font-size: .95rem; color: #666;">Số chủ đề đã làm</div>
                <div class="value" style="font-size: 1.2rem; font-weight: 700;">{{ $totalAttempted }}</div>
            </div>
            <div class="kpi-item" style="background: #fff; border: 1px solid #e0e0e0; padding: 12px 16px; border-radius: 8px; min-width: 120px; color: #000;">
                <div class="label" style="font-size: .95rem; color: #666;">Độ chính xác trung bình</div>
                <div class="value" style="font-size: 1.2rem; font-weight: 700;">{{ $avgAccuracy }}%</div>
            </div>
            <div class="kpi-item" style="background: #fff; border: 1px solid #e0e0e0; padding: 12px 16px; border-radius: 8px; min-width: 120px; color: #000;">
                <div class="label" style="font-size: .95rem; color: #666;">Tổng chủ đề của bạn</div>
                <div class="value" style="font-size: 1.2rem; font-weight: 700;">{{ $totalTopics ?? 0 }}</div>
            </div>
            <div class="kpi-item" style="background: #fff; border: 1px solid #e0e0e0; padding: 12px 16px; border-radius: 8px; min-width: 120px; color: #000;">
                <div class="label" style="font-size: .95rem; color: #666;">Tổng câu đúng</div>
                <div class="value" style="font-size: 1.2rem; font-weight: 700;">{{ $tongDung }}</div>
            </div>
            <div class="kpi-item" style="background: #fff; border: 1px solid #e0e0e0; padding: 12px 16px; border-radius: 8px; min-width: 120px; color: #000;">
                <div class="label" style="font-size: .95rem; color: #666;">Tổng câu sai</div>
                <div class="value" style="font-size: 1.2rem; font-weight: 700;">{{ $tongSai }}</div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top:20px;">
        <div class="card-header" style="background: #fff; border-bottom: 1px solid #e0e0e0; padding: 16px 18px;">
            <div class="card-title" style="font-weight: 700; color: #000;"><i class="fas fa-chart-donut"></i> Tỉ lệ đúng/sai tổng thể</div>
        </div>
        <div class="card-body" style="padding: 20px; background: #fff;">
            <div style="max-width: 320px; margin: 0 auto; text-align:center;">
                <div id="donutFallback" style="width: 180px; height: 180px; margin: 0 auto 8px auto; border-radius: 50%; background: conic-gradient(#10b981 {{ $donutPct }}%, #ef4444 0); mask: radial-gradient(circle 48% at 50% 50%, transparent 49%, #000 50%); position: relative;"></div>
                <canvas id="donutChart" width="180" height="180"></canvas>
                <div id="donutNote" style="text-align:center;margin-top:8px; color: #666; font-size: 15px;"></div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top:20px;">
        <div class="card-header" style="background: #fff; border-bottom: 1px solid #e0e0e0; padding: 16px 18px;">
            <div class="card-title" style="font-weight: 700; color: #000;"><i class="fas fa-list"></i> Bảng thống kê theo chủ đề</div>
        </div>
    @if($rows->isEmpty())
            <div class="empty" style="text-align: center; padding: 48px 16px; color: #666; background: #fff; border-radius: 8px;">
                <i class="fas fa-clipboard-list" style="font-size: 3rem; color: #e0e0e0; margin-bottom: 12px;"></i>
                <div>Chưa có dữ liệu thống kê. Hãy làm thử một bài kiểm tra/ôn tập để lưu kết quả.</div>
                <div class="back" style="margin-top: 16px;"><a href="{{ route('trangchinh') }}" class="btn" style="background: #000; color: #fff; border-radius: 6px; padding: 10px 20px; text-decoration: none;"><i class="fas fa-home"></i> Về trang chính</a></div>
            </div>
        @else
            <div style="overflow-x:auto; background: #fff; border-radius: 8px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f5f5f5;">
                            <th style="padding: 12px 8px; color: #666; font-size: 15px; font-weight: 600;">Chủ đề</th>
                            <th style="padding: 12px 8px; color: #666; font-size: 15px; font-weight: 600;">ID</th>
                            <th style="padding: 12px 8px; color: #666; font-size: 15px; font-weight: 600;">Tỉ lệ đúng</th>
                            <th style="padding: 12px 8px; color: #666; font-size: 15px; font-weight: 600;">Số lần làm</th>
                            <th style="padding: 12px 8px; color: #666; font-size: 15px; font-weight: 600;">Ngày tạo</th>
                            <th style="padding: 12px 8px; color: #666; font-size: 15px; font-weight: 600; text-align:right;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            @php
                                $acc = (float)$row->tong_phan_tram_dung;
                                $badgeClass = $acc >= 80 ? 'good' : ($acc >= 50 ? 'medium' : 'bad');
                            @endphp
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="font-weight: 600; color: #222; padding: 12px 8px;">{{ $row->name }}</td>
                                <td style="color: #888; padding: 12px 8px;">#{{ $row->id }}</td>
                                <td style="padding: 12px 8px;">
                                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 999px; font-size: .95rem; font-weight: 600; background: {{ $badgeClass==='good' ? '#ecfdf5' : ($badgeClass==='medium' ? '#fffbeb' : '#fef2f2') }}; color: {{ $badgeClass==='good' ? '#065f46' : ($badgeClass==='medium' ? '#92400e' : '#991b1b') }};">
                                        @if($badgeClass==='good')<i class="fas fa-check-circle"></i>@elseif($badgeClass==='medium')<i class="fas fa-minus-circle"></i>@else<i class="fas fa-times-circle"></i>@endif
                                        {{ $acc }}%
                                    </span>
                                </td>
                                <td style="padding: 12px 8px;">{{ (int)$row->so_lan_lam }}</td>
                                <td style="color: #888; font-size: 15px; padding: 12px 8px;">{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y H:i') }}</td>
                                <td style="text-align:right; padding: 12px 8px;">
                                    <div style="display: flex; gap: 8px;">
                                        <a href="{{ url('/topics/'.$row->id.'/study') }}" style="background: #000; color: #fff; border-radius: 6px; padding: 8px 14px; text-decoration: none; font-weight: 500; font-size: 15px; display: inline-flex; align-items: center; gap: 6px;"><i class="fas fa-book-open"></i> Ôn tập</a>
                                        <a href="{{ url('/topics/'.$row->id.'/test') }}" style="background: #000; color: #fff; border-radius: 6px; padding: 8px 14px; text-decoration: none; font-weight: 500; font-size: 15px; display: inline-flex; align-items: center; gap: 6px;"><i class="fas fa-clipboard-check"></i> Làm bài</a>
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