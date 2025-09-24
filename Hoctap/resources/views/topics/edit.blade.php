<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa chủ đề - {{ $topic->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="breadcrumb">
                <a href="{{ route('trangchinh') }}">← Quay lại trang chính</a>
                <span> / </span>
                <a href="{{ route('topics.show', $topic) }}">{{ $topic->name }}</a>
                <span> / Sửa</span>
            </div>
        </div>

        <div class="content-section">
            <div class="form-container">
                <h1>Sửa chủ đề</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('topics.update', $topic) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Tên chủ đề *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $topic->name) }}" required maxlength="255">
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug (tùy chọn)</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $topic->slug) }}" maxlength="255">
                        <small class="form-text">Để trống để tự động tạo slug từ tên chủ đề</small>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('topics.show', $topic) }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<style>
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.header-section {
    margin-bottom: 30px;
}

.breadcrumb {
    font-size: 14px;
    color: #666;
}

.breadcrumb a {
    color: #667eea;
    text-decoration: none;
}

.content-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 30px;
}

.form-container h1 {
    margin-bottom: 30px;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}

.form-group input[type="text"] {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box;
}

.form-group input[type="text"]:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
}

.form-text {
    color: #666;
    font-size: 14px;
    margin-top: 4px;
}

.form-actions {
    margin-top: 30px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.btn {
    padding: 12px 24px;
    border-radius: 4px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    display: inline-block;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-primary:hover {
    background: #5a6fd8;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.alert {
    padding: 16px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}
</style>
</body>
</html>