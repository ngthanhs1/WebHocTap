<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý câu hỏi</title>
    <link rel="stylesheet" href="{{ asset('css/styles4.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <!-- Navigation Header -->
        <nav class="navbar">
            <div class="nav-content">
                <div class="nav-brand">
                    <a href="{{ route('trangchinh') }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Hệ thống học tập</span>
                    </a>
                </div>
                <div class="nav-links">
                    <a href="{{ route('trangchinh') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        Trang chủ
                    </a>
                    <a href="{{ route('thongke') }}" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        Thống kê
                    </a>
                </div>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h1 class="page-title">
                    <i class="fas fa-question-circle"></i>
                    Quản lý câu hỏi
                </h1>
                <p class="page-subtitle">Tạo và quản lý câu hỏi cho các chủ đề của bạn</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Quick Actions -->
            <div class="quick-actions">
                <h2 class="section-title">
                    <i class="fas fa-bolt"></i>
                    Thao tác nhanh
                </h2>
                <div class="actions-grid">
                    <a href="{{ route('chude.create') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <h3>Tạo chủ đề mới</h3>
                        <p>Tạo chủ đề mới để tổ chức câu hỏi</p>
                    </a>
                    
                    <a href="{{ route('topics.select') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <h3>Thêm câu hỏi</h3>
                        <p>Thêm câu hỏi vào chủ đề có sẵn</p>
                    </a>
                    
                    <a href="{{ route('thongke') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Xem thống kê</h3>
                        <p>Theo dõi tiến độ học tập của bạn</p>
                    </a>
                </div>
            </div>

            <!-- Topics List -->
            <div class="topics-section">
                <h2 class="section-title">
                    <i class="fas fa-folder"></i>
                    Chủ đề của bạn
                </h2>
                
                @if($topics->count() > 0)
                    <div class="topics-grid">
                        @foreach($topics as $topic)
                            <div class="topic-card">
                                <div class="topic-header">
                                    <h3 class="topic-name">{{ $topic->name }}</h3>
                                    <div class="topic-stats">
                                        <span class="question-count">
                                            <i class="fas fa-question"></i>
                                            {{ $topic->questions_count }} câu hỏi
                                        </span>
                                    </div>
                                </div>
                                
                                @if($topic->description)
                                    <p class="topic-description">{{ Str::limit($topic->description, 100) }}</p>
                                @endif
                                
                                <div class="topic-actions">
                                    <a href="{{ route('topics.show', $topic) }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                        Xem chi tiết
                                    </a>
                                    <a href="{{ route('questions.create') }}?topic_id={{ $topic->id }}" class="btn btn-secondary">
                                        <i class="fas fa-plus"></i>
                                        Thêm câu hỏi
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h3>Chưa có chủ đề nào</h3>
                        <p>Hãy tạo chủ đề đầu tiên để bắt đầu thêm câu hỏi</p>
                        <a href="{{ route('chude.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Tạo chủ đề đầu tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .quick-actions {
            margin-bottom: 40px;
        }

        .section-title {
            color: #000000;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .action-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 24px;
            text-decoration: none;
            color: #000000;
            transition: all 0.3s ease;
            text-align: center;
        }

        .action-card:hover {
            border-color: #000000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .action-icon {
            width: 60px;
            height: 60px;
            background: #f8f9fa;
            border: 1px solid #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 24px;
            color: #000000;
        }

        .action-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #000000;
        }

        .action-card p {
            font-size: 14px;
            color: #666666;
            margin: 0;
        }

        .topics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
        }

        .topic-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .topic-card:hover {
            border-color: #000000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .topic-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .topic-name {
            font-size: 18px;
            font-weight: 600;
            color: #000000;
            margin: 0;
            flex: 1;
        }

        .topic-stats {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: #666666;
            margin-left: 12px;
        }

        .question-count {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .topic-description {
            color: #666666;
            font-size: 14px;
            margin-bottom: 16px;
            line-height: 1.4;
        }

        .topic-actions {
            display: flex;
            gap: 8px;
        }

        .topic-actions .btn {
            flex: 1;
            text-align: center;
            font-size: 14px;
            padding: 8px 12px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: #f8f9fa;
            border: 1px solid #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 32px;
            color: #666666;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 600;
            color: #000000;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #666666;
            margin-bottom: 24px;
        }
    </style>
</body>
</html>