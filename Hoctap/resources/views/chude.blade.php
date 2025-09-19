<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt tên chủ đề</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .topic-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 600px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .logo p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .questions-preview {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .questions-preview h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .question-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #667eea;
        }

        .question-content {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .choices-list {
            list-style: none;
            padding-left: 0;
        }

        .choices-list li {
            padding: 4px 0;
            color: #666;
        }

        .choices-list li.correct {
            color: #28a745;
            font-weight: 600;
        }

        .choices-list li::before {
            content: "○ ";
            margin-right: 5px;
        }

        .choices-list li.correct::before {
            content: "✓ ";
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 20px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .back-btn {
            display: inline-block;
            color: #667eea;
            text-decoration: none;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .back-btn:hover {
            color: #764ba2;
        }
    </style>
</head>
<body>
    <div class="topic-container">
        <a href="{{ route('cauhoi.create') }}" class="back-btn">← Quay lại tạo câu hỏi</a>
        
        <div class="logo">
            <h1>Đặt tên chủ đề</h1>
            <p>Đặt tên cho bộ câu hỏi của bạn</p>
        </div>

        @if (session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        @if (session('quiz_questions'))
            <div class="questions-preview">
                <h3>📝 Xem trước câu hỏi ({{ count(session('quiz_questions')) }} câu)</h3>
                @foreach (session('quiz_questions') as $index => $question)
                    <div class="question-item">
                        <div class="question-content">Câu {{ $index + 1 }}: {{ $question['content'] }}</div>
                        <ul class="choices-list">
                            @foreach ($question['choices'] as $choice)
                                <li class="{{ $choice['is_correct'] ? 'correct' : '' }}">
                                    {{ $choice['content'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('chude.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Tên chủ đề</label>
                <input type="text" id="name" name="name" placeholder="Nhập tên chủ đề..." required maxlength="255" value="{{ old('name') }}">
                @error('name')
                    <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="slug">Mô tả (không bắt buộc)</label>
                <input type="text" id="slug" name="slug" placeholder="Mô tả ngắn về chủ đề..." maxlength="255" value="{{ old('slug') }}">
                @error('slug')
                    <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn">🎯 Tạo chủ đề và lưu câu hỏi</button>
        </form>
    </div>
</body>
</html>