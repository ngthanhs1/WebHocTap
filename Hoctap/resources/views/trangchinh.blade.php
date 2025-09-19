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
                    <button class="tab active">Created (11/20)</button>
                    <button class="tab">Draft (9)</button>
                    <button class="tab">Archived (5)</button>
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
                        <div class="activity-stats">
                            <div class="activity-time">1 tháng trước</div>
                        </div>
                        <div class="activity-actions">
                            <button class="action-btn">✏️ Chỉnh sửa</button>
                            <button class="action-btn">⋯</button>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <input type="checkbox" class="activity-checkbox">
                        <div class="activity-icon">📊</div>
                        <div class="activity-content">
                            <div class="activity-title">bigdata-3</div>
                            <div class="activity-meta">
                                <span>🌟</span>
                                <span>45 Qs</span>
                                <span>•</span>
                                <span>Other</span>
                                <span>•</span>
                                <span>Đại học</span>
                            </div>
                        </div>
                        <div class="activity-stats">
                            <div class="activity-time">1 tháng trước</div>
                        </div>
                        <div class="activity-actions">
                            <button class="action-btn primary">▶️ Chơi</button>
                            <button class="action-btn">🔗</button>
                            <button class="action-btn">⋯</button>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <input type="checkbox" class="activity-checkbox">
                        <div class="activity-icon">📊</div>
                        <div class="activity-content">
                            <div class="activity-title">ktpm-5</div>
                            <div class="activity-meta">
                                <span>🌟</span>
                                <span>15 Qs</span>
                                <span>•</span>
                                <span>Other</span>
                                <span>•</span>
                                <span>Đại học</span>
                            </div>
                        </div>
                        <div class="activity-stats">
                            <div class="activity-time">2 tháng trước</div>
                        </div>
                        <div class="activity-actions">
                            <button class="action-btn primary">▶️ Chơi</button>
                            <button class="action-btn">🔗</button>
                            <button class="action-btn">⋯</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 