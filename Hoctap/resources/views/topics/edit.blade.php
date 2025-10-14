<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa chủ đề - {{ $topic->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles4.css') }}">
</head>
<body>

    <div class="container" style="max-width: 600px; margin: 40px auto; padding: 32px; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07);">
        <nav style="margin-bottom: 24px;">
            <a href="{{ route('trangchinh') }}" style="color: #000; text-decoration: none; font-weight: 500;">← Quay lại trang chính</a>
            <span style="color: #888;"> / </span>
            <a href="{{ route('topics.show', $topic) }}" style="color: #000; text-decoration: none; font-weight: 500;">{{ $topic->name }}</a>
            <span style="color: #888;"> / Sửa</span>
        </nav>

        <h1 style="font-size: 2rem; font-weight: 700; color: #000; margin-bottom: 32px;">Sửa chủ đề</h1>

        @if ($errors->any())
            <div class="alert alert-error" style="background: #fef2f2; color: #c62828; border: 1px solid #f44336; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('topics.update', $topic) }}">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 24px;">
                <label for="name" style="display: block; font-weight: 600; color: #000; margin-bottom: 8px;">Tên chủ đề *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $topic->name) }}" required maxlength="255" style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 16px; background: #fff; color: #000;">
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label for="slug" style="display: block; font-weight: 600; color: #000; margin-bottom: 8px;">Slug (tùy chọn)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $topic->slug) }}" maxlength="255" style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 16px; background: #fff; color: #000;">
                <small style="color: #666; font-size: 13px; margin-top: 4px; display: block;">Để trống để tự động tạo slug từ tên chủ đề</small>
            </div>

            <div class="form-actions" style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px;">
                <a href="{{ route('topics.show', $topic) }}" class="btn btn-secondary" style="background: #e0e0e0; color: #000; border: none; padding: 12px 24px; border-radius: 4px; text-decoration: none; font-size: 16px; font-weight: 500;">Hủy</a>
                <button type="submit" class="btn btn-primary" style="background: #000; color: #fff; border: none; padding: 12px 24px; border-radius: 4px; font-size: 16px; font-weight: 500;">Cập nhật</button>
            </div>
        </form>
    </div>
</body>
</html>