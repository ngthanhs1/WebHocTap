<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm câu hỏi - {{ $topic->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles3.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thêm câu hỏi cho: <span style="color: #ffa726;">{{ $topic->name }}</span></h1>
            <div class="controls">
                <a href="{{ route('topics.show', $topic) }}" class="btn">← Quay lại chủ đề</a>
            </div>
        </div>

        <!-- Form thêm câu hỏi -->
        <div class="quiz-container">
            <form id="questionForm" method="POST" action="{{ route('topics.questions.store', $topic) }}">
                @csrf
                
                <!-- Câu hỏi -->
                <div class="question-input">
                    <h3 style="color: white; margin-bottom: 15px;">Nội dung câu hỏi</h3>
                    <input type="text" name="content" id="questionContent" placeholder="Nhập câu hỏi vào đây..." maxlength="500" required>
                    @error('content')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Đáp án -->
                <div class="answers-grid" style="margin-top: 20px;">
                    <h3 style="color: white; margin-bottom: 15px; grid-column: 1 / -1;">Các đáp án (tối thiểu 2 đáp án)</h3>
                    
                    <div class="answer-card" onclick="selectCorrectAnswer(0)">
                        <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">A.</label>
                        <input type="text" name="choices[0][content]" class="answer-input" placeholder="Đáp án A (bắt buộc)" maxlength="200" required>
                        <input type="hidden" name="choices[0][is_correct]" class="correct-answer" value="0">
                        <div class="correct-indicator">
                            <i class="check-icon">✓</i>
                            <span>Đáp án đúng</span>
                        </div>
                        @error('choices.0.content')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="answer-card" onclick="selectCorrectAnswer(1)">
                        <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">B.</label>
                        <input type="text" name="choices[1][content]" class="answer-input" placeholder="Đáp án B (bắt buộc)" maxlength="200" required>
                        <input type="hidden" name="choices[1][is_correct]" class="correct-answer" value="0">
                        <div class="correct-indicator">
                            <i class="check-icon">✓</i>
                            <span>Đáp án đúng</span>
                        </div>
                        @error('choices.1.content')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="answer-card" onclick="selectCorrectAnswer(2)">
                        <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">C.</label>
                        <input type="text" name="choices[2][content]" class="answer-input" placeholder="Đáp án C (tùy chọn)" maxlength="200">
                        <input type="hidden" name="choices[2][is_correct]" class="correct-answer" value="0">
                        <div class="correct-indicator">
                            <i class="check-icon">✓</i>
                            <span>Đáp án đúng</span>
                        </div>
                        @error('choices.2.content')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="answer-card" onclick="selectCorrectAnswer(3)">
                        <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">D.</label>
                        <input type="text" name="choices[3][content]" class="answer-input" placeholder="Đáp án D (tùy chọn)" maxlength="200">
                        <input type="hidden" name="choices[3][is_correct]" class="correct-answer" value="0">
                        <div class="correct-indicator">
                            <i class="check-icon">✓</i>
                            <span>Đáp án đúng</span>
                        </div>
                        @error('choices.3.content')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Nút lưu -->
                <div style="text-align: center; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary" style="padding: 15px 30px; font-size: 18px;">
                        Lưu câu hỏi
                    </button>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif
    </div>

<style>
/* Additional styles for form */
.error-message {
    color: #ff6b6b;
    font-size: 14px;
    margin-top: 5px;
    display: block;
}

.success-message {
    background: rgba(76, 175, 80, 0.2);
    border: 1px solid #4caf50;
    color: #4caf50;
    padding: 15px;
    border-radius: 8px;
    margin-top: 20px;
    text-align: center;
}

.correct-label {
    color: white;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
}

.correct-label input[type="radio"] {
    margin: 0;
}

.answer-card.correct {
    background: linear-gradient(135deg, rgba(76, 175, 80, 0.3), rgba(56, 142, 60, 0.3));
    border-color: #4caf50;
}
</style>

<script>
// Chọn đáp án đúng
function selectCorrectAnswer(index) {
    // Bỏ chọn tất cả các đáp án khác
    document.querySelectorAll('.answer-card').forEach((card, i) => {
        card.classList.remove('correct');
        card.querySelector('.correct-answer').value = '0';
    });
    
    // Chọn đáp án hiện tại
    const selectedCard = document.querySelectorAll('.answer-card')[index];
    selectedCard.classList.add('correct');
    selectedCard.querySelector('.correct-answer').value = '1';
}

// Ngăn click vào input trigger selectCorrectAnswer
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.answer-input').forEach(input => {
        input.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        input.addEventListener('focus', function(e) {
            e.stopPropagation();
        });
    });
});

// Form validation
document.getElementById('questionForm').addEventListener('submit', function(e) {
    const questionContent = document.getElementById('questionContent').value.trim();
    const choices = document.querySelectorAll('input[name*="[content]"]');
    const correctAnswers = document.querySelectorAll('.correct-answer');
    
    if (!questionContent) {
        alert('Vui lòng nhập nội dung câu hỏi!');
        e.preventDefault();
        return;
    }
    
    // Kiểm tra có đáp án đúng được chọn không
    let hasCorrectAnswer = false;
    correctAnswers.forEach(input => {
        if (input.value === '1') {
            hasCorrectAnswer = true;
        }
    });
    
    if (!hasCorrectAnswer) {
        alert('Vui lòng chọn đáp án đúng bằng cách click vào card đáp án!');
        e.preventDefault();
        return;
    }
    
    // Kiểm tra ít nhất 2 đáp án có nội dung
    let filledChoices = 0;
    choices.forEach(choice => {
        if (choice.value.trim()) filledChoices++;
    });
    
    if (filledChoices < 2) {
        alert('Cần ít nhất 2 đáp án có nội dung!');
        e.preventDefault();
        return;
    }
    
    // Kiểm tra đáp án đúng có nội dung không
    let correctAnswerHasContent = false;
    choices.forEach((choice, index) => {
        if (correctAnswers[index].value === '1' && choice.value.trim()) {
            correctAnswerHasContent = true;
        }
    });
    
    if (!correctAnswerHasContent) {
        alert('Đáp án được chọn làm đáp án đúng phải có nội dung!');
        e.preventDefault();
        return;
    }
});
</script>

</body>
</html>