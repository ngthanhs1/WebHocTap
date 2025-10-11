<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê chủ đề</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .stats-container { max-width: 1100px; margin: 24px auto; padding: 0 16px; }
        .stats-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 10px 25px rgba(102,126,234,.25);
            display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;
        }
        .stats-title { display: flex; align-items: center; gap: 12px; font-size: 1.4rem; font-weight: 700; }
        .kpi { display: flex; gap: 16px; flex-wrap: wrap; }
        .kpi-item { background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25); padding: 12px 16px; border-radius: 12px; min-width: 160px; }
        .kpi-item .label { font-size: .85rem; opacity: .9; }
        .kpi-item .value { font-size: 1.4rem; font-weight: 800; margin-top: 6px; }

        .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; box-shadow: 0 6px 18px rgba(0,0,0,.08); overflow: hidden; }
        .card + .card { margin-top: 20px; }
        .card-header { padding: 16px 18px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-weight: 700; color: #111827; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #f3f4f6; }
        .table th { font-size: .9rem; color: #6b7280; text-transform: uppercase; letter-spacing: .03em; }
        .topic-name { font-weight: 600; color: #111827; }
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 999px; font-size: .85rem; font-weight: 700; }
        .badge.good { background: #ecfdf5; color: #065f46; }
        .badge.medium { background: #fffbeb; color: #92400e; }
        .badge.bad { background: #fef2f2; color: #991b1b; }
        .muted { color: #6b7280; font-size: .95rem; }
        .row-actions { display: flex; gap: 8px; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 10px; border: 1px solid #e5e7eb; background: #fff; color: #111827; cursor: pointer; text-decoration: none; font-weight: 600; }
        .btn:hover { box-shadow: 0 6px 16px rgba(0,0,0,.08); transform: translateY(-1px); }
        .btn-primary { background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; border: none; }
        .btn-study { background: linear-gradient(135deg, #4ecdc4, #44a08d); color: #fff; border: none; }
        .btn-test { background: linear-gradient(135deg, #ffa726, #ff9800); color: #fff; border: none; }
        .empty { text-align: center; padding: 48px 16px; color: #6b7280; }
        .empty i { font-size: 3rem; color: #d1d5db; margin-bottom: 12px; }
        .back { margin-top: 16px; }
    </style>
    @php
        $totalAttempted = $rows->filter(fn($r) => (int)$r->so_lan_lam > 0)->count();
        $avgAccuracy = $rows->count() ? round($rows->avg('tong_phan_tram_dung'), 2) : 0;
    @endphp
    </head>
<body>
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
                <div class="value">{{ $rows->count() }}</div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top:20px;">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-list"></i> Bảng thống kê theo chủ đề</div>
            <a href="{{ route('trangchinh') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Trang chính</a>
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
</body>
</html>