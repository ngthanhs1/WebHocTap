<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thư viện</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <div class="logo-icon">T</div>
                <div class="logo-text">Thư viện</div>
            </div>
            
            <a href="{{ route('cauhoi.create') }}" class="create-btn">
                <span>+</span>
                Tạo
            </a>
            
            <nav class="nav-menu">
                <a href="#" class="nav-item active">
                    <div class="icon">🏠</div>
                    <span>Trang chủ</span>
                </a>
                
                <a href="#" class="nav-item">
                    <div class="icon">⏱️</div>
                    <span>Trước đây đã sử dụng</span>
                </a>
                <a href="#" class="nav-item">
                    <div class="icon">📊</div>
                    <span>Thống kê</span>
                </a>
                
                <a href="#" class="nav-item">
                    <div class="icon">📁</div>
                    <span>Bộ sưu tập</span>
                    <span class="count">2</span>
                </a>
            </nav>
            
            <div class="progress-section">
                <div class="progress-header">
                    <div class="progress-icon">⚡</div>
                    <div class="progress-text">11/20 hoạt động được tạo ra</div>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <div class="search-bar">
                    <div class="search-icon">🔍</div>
                    <input type="text" class="search-input" placeholder="Tìm kiếm theo tên hoạt động">
                </div>
                
                <div class="header-actions">
                    <button class="help-btn">🙋 Nhận trợ giúp</button>
                    <div class="user-menu">Ng</div>
                </div>
            </header>
            
            <div class="content-area">
                <div class="content-header">
                    <h1 class="page-title">Được tạo bởi tôi</h1>
                    <a href="{{ route('cauhoi.create') }}" class="create-new-btn">
                        <span>+</span>
                        Tạo mới
                    </a>
                </div>
                
                <div class="tabs">
                    <button class="tab active">Created ({{ $topics->count() }})</button>
                    <button class="tab">Draft (0)</button>
                    <button class="tab">Archived (0)</button>
                </div>
                
                <div class="content-controls">
                    <div class="view-controls">
                        <label class="select-all">
                            <input type="checkbox"> Chi tiết hoạt động
                        </label>
                    </div>
                    <select class="sort-dropdown">
                        <option>Thời gian tạo</option>
                        <option>Tên hoạt động</option>
                        <option>Lần cập nhật cuối</option>
                    </select>
                </div>

                <div class="activities-list">
                    @if($topics->count() > 0)
                        @foreach($topics as $topic)
                            <div class="activity-item">
                                <input type="checkbox" class="activity-checkbox">
                                <div class="activity-icon">📊</div>
                                <div class="activity-content">
                                    <div class="activity-title">{{ $topic->name }}</div>
                                    <div class="activity-meta">
                                        <span>🌟</span>
                                        <span>{{ $topic->questions_count }} Qs</span>
                                        <span>•</span>
                                        <span>{{ $topic->slug }}</span>
                                        <span>•</span>
                                        <span>Học tập</span>
                                    </div>
                                </div>
                                <div class="activity-stats">
                                    <div class="activity-time">{{ $topic->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="activity-actions">
                                    <button class="action-btn primary">▶️ Chơi</button>
                                    <button class="action-btn">✏️ Sửa</button>
                                    <button class="action-btn">⋯</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state" style="text-align: center; padding: 40px; color: #666;">
                            <div style="font-size: 48px; margin-bottom: 16px;">📝</div>
                            <h3>Chưa có chủ đề nào</h3>
                            <p>Hãy tạo chủ đề đầu tiên của bạn!</p>
                            <a href="{{ route('cauhoi.create') }}" style="margin-top: 16px; display: inline-block; padding: 12px 24px; background: #667eea; color: white; text-decoration: none; border-radius: 8px;">Tạo ngay</a>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html> 