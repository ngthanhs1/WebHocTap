<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ôn tập - {{ $topic->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles8.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="study-container">
        <a href="{{ route('trangchinh') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Quay về trang chính
        </a>

        <div class="study-header">
            <h1><i class="fas fa-book-open"></i> Ôn tập</h1>
            <h2>{{ $topic->name }}</h2>
            <div class="study-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $topic->questions->count() }}</span>
                    <span>Câu hỏi</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><i class="fas fa-graduation-cap"></i></span>
                    <span>Chế độ ôn tập</span>
                </div>
            </div>
        </div>

        @if($topic->questions->count() > 0)
            @foreach($topic->questions as $index => $question)
                <div class="question-card">
                    <div class="question-header">
                        <div class="question-number">{{ $index + 1 }}</div>
                        <div class="question-text">{{ $question->content }}</div>
                    </div>
                    
                    <div class="choices-container">
                        @foreach($question->choices as $choiceIndex => $choice)
                            <div class="choice-item {{ $choice->is_correct ? 'correct' : 'incorrect' }}">
                                <div class="choice-letter">{{ chr(65 + $choiceIndex) }}</div>
                                <div class="choice-text">{{ $choice->content }}</div>
                                @if($choice->is_correct)
                                    <div class="correct-indicator">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-question-circle"></i>
                <h3>Chưa có câu hỏi nào</h3>
                <p>Chủ đề này chưa có câu hỏi để ôn tập. Hãy thêm câu hỏi vào chủ đề này!</p>
                <a href="{{ route('cauhoi.create') }}" class="back-btn" style="margin-top: 20px;">
                    <i class="fas fa-plus"></i>
                    Thêm câu hỏi
                </a>
            </div>
        @endif
    </div>
</body>
</html>