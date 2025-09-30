<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả kiểm tra - {{ $topic->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles9.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="result-container">
        @php
            $performanceClass = $percentage >= 80 ? 'excellent' : ($percentage >= 60 ? 'good' : 'fair');
            $performanceText = $percentage >= 80 ? 'Xuất sắc!' : ($percentage >= 60 ? 'Khá tốt!' : 'Cần cố gắng hơn!');
        @endphp

        <div class="result-header {{ $performanceClass }}">
            <h1>
                @if($percentage >= 80)
                    <i class="fas fa-trophy"></i>
                @elseif($percentage >= 60)
                    <i class="fas fa-thumbs-up"></i>
                @else
                    <i class="fas fa-redo-alt"></i>
                @endif
                Kết quả kiểm tra
            </h1>
            <h2>{{ $topic->name }}</h2>
            <div class="score-display">{{ $percentage }}%</div>
            <div class="result-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $score }}</span>
                    <span>Đúng</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $total - $score }}</span>
                    <span>Sai</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $total }}</span>
                    <span>Tổng</span>
                </div>
            </div>
        </div>

        <div class="summary-card">
            <h3>Đánh giá kết quả</h3>
            <div class="performance-indicator {{ $performanceClass }}">
                {{ $performanceText }}
            </div>
            <p>
                @if($percentage >= 80)
                    Bạn đã làm rất tốt! Hãy tiếp tục duy trì phương pháp học tập hiệu quả này.
                @elseif($percentage >= 60)
                    Kết quả khá tốt! Hãy ôn tập lại những phần còn thiếu để đạt kết quả tốt hơn.
                @else
                    Bạn cần dành thêm thời gian để ôn tập. Hãy xem lại các câu hỏi và thử lại nhé!
                @endif
            </p>
        </div>

        <h3 style="text-align: center; margin-bottom: 25px; color: #333;">
            <i class="fas fa-clipboard-list"></i> Chi tiết kết quả
        </h3>

        @foreach($results as $index => $result)
            <div class="question-review">
                <div class="question-header">
                    <div class="question-number {{ $result['is_correct'] ? 'correct' : 'incorrect' }}">
                        {{ $index + 1 }}
                    </div>
                    <div class="question-text">{{ $result['question']->content }}</div>
                    <div class="result-indicator {{ $result['is_correct'] ? 'correct' : 'incorrect' }}">
                        @if($result['is_correct'])
                            <i class="fas fa-check-circle"></i>
                        @else
                            <i class="fas fa-times-circle"></i>
                        @endif
                    </div>
                </div>
                
                <div class="choices-container">
                    @foreach($result['question']->choices as $choiceIndex => $choice)
                        @php
                            $isCorrectAnswer = $choice->is_correct;
                            $isUserChoice = $result['user_choice_id'] == $choice->id;
                            
                            if ($isCorrectAnswer) {
                                $class = 'correct-answer';
                            } elseif ($isUserChoice && !$isCorrectAnswer) {
                                $class = 'user-wrong';
                            } else {
                                $class = 'not-selected';
                            }
                        @endphp
                        
                        <div class="choice-item {{ $class }}">
                            <div class="choice-letter">{{ chr(65 + $choiceIndex) }}</div>
                            <div class="choice-text">{{ $choice->content }}</div>
                            <div class="choice-indicator">
                                @if($isCorrectAnswer)
                                    <i class="fas fa-check"></i> Đúng
                                @elseif($isUserChoice && !$isCorrectAnswer)
                                    <i class="fas fa-times"></i> Bạn chọn
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="actions-container">
            <a href="{{ route('trangchinh') }}" class="action-btn btn-primary">
                <i class="fas fa-home"></i>
                Về trang chính
            </a>
            <a href="{{ route('topics.study', $topic) }}" class="action-btn btn-study">
                <i class="fas fa-book-open"></i>
                Ôn tập lại
            </a>
            <a href="{{ route('topics.test', $topic) }}" class="action-btn btn-retake">
                <i class="fas fa-redo-alt"></i>
                Làm lại
            </a>
        </div>
    </div>
</body>
</html>