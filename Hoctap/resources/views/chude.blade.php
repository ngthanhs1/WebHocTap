<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt tên chủ đề</title>
    <link rel="stylesheet" href="{{ asset('css/styles4.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .preview-card { background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; padding:16px; }
        .preview-header { display:flex; align-items:center; gap:8px; font-weight:700; color:#000; margin-bottom:10px; }
        .question-item { border:1px dashed #e5e7eb; border-radius:8px; padding:12px; margin-bottom:10px; background:#fafafa; }
        .question-content { font-weight:600; color:#000; margin-bottom:6px; }
        .choices-list { list-style:none; padding-left:0; margin:0; }
        .choices-list li { padding:4px 8px; border-radius:6px; border:1px solid #eee; background:#fff; margin-bottom:6px; }
        .choices-list li.correct { border-color:#000; font-weight:600; }
        .form-card .form-group input { width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:12px; font-size:14px; background:#fff; color:#000; }
        .form-card .form-group input:focus { outline:none; border-color:#000; }
        .page-title { display:flex; align-items:center; gap:8px; }
    </style>
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
                    <a href="{{ route('cauhoi.create') }}" class="nav-link">
                        <i class="fas fa-arrow-left"></i>
                        Quay lại tạo câu hỏi
                    </a>
                </div>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h1 class="page-title">
                    <i class="fas fa-folder-plus"></i>
                    Đặt tên chủ đề
                </h1>
                <p class="page-subtitle">Đặt tên cho bộ câu hỏi của bạn và lưu thành chủ đề mới</p>
            </div>
        </div>

        <div class="main-content">
            <!-- Preview Card -->
            @if (session('quiz_questions'))
                <div class="preview-card" style="margin-bottom:16px;">
                    <div class="preview-header">
                        <i class="fas fa-clipboard-list"></i>
                        <span>📝 Xem trước câu hỏi ({{ count(session('quiz_questions')) }} câu)</span>
                    </div>
                    @foreach (session('quiz_questions') as $index => $question)
                        <div class="question-item">
                            <div class="question-content">Câu {{ $index + 1 }}: {{ $question['content'] }}</div>
                            <ul class="choices-list">
                                @foreach ($question['choices'] as $choice)
                                    <li class="{{ $choice['is_correct'] ? 'correct' : '' }}">{{ $choice['content'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Form Card -->
            <div class="form-card">
                @if (session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('chude.store') }}">
                    @csrf
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-tag"></i>
                            Thông tin chủ đề
                        </h3>
                        <div class="form-group">
                            <label for="name">Tên chủ đề</label>
                            <input type="text" id="name" name="name" placeholder="Nhập tên chủ đề..." required maxlength="255" value="{{ old('name') }}">
                            @error('name')
                                <div class="alert alert-error" style="margin-top:8px;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Mô tả (không bắt buộc)</label>
                            <input type="text" id="slug" name="slug" placeholder="Mô tả ngắn về chủ đề..." maxlength="255" value="{{ old('slug') }}">
                            @error('slug')
                                <div class="alert alert-error" style="margin-top:8px;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('cauhoi.create') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Tạo chủ đề và lưu câu hỏi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>