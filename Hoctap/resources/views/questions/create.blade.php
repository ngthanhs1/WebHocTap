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
                    <h3 style="color: white; margin-bottom: 15px;">❓ Nội dung câu hỏi</h3>
                    <input type="text" name="content" id="questionContent" placeholder="Nhập câu hỏi vào đây..." maxlength="500" required>
                    @error('content')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Đáp án -->
                <div class="answers-grid" style="margin-top: 20px;">
                    <h3 style="color: white; margin-bottom: 15px; grid-column: 1 / -1;">✅ Các đáp án (tối thiểu 2 đáp án)</h3>
                    
                    <div class="answer-card">
                        <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">A.</label>
                        <input type="text" name="choices[0][content]" class="answer-input" placeholder="Đáp án A (bắt buộc)" maxlength="200" required>
                        <input type="hidden" name="choices[0][is_correct]" value="0">
                        <label class="correct-label" style="margin-top: 10px;">
                            <input type="radio" name="correct_choice" value="0" required>
                            Đáp án đúng
                        </label>
                        @error('choices.0.content')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="answer-card">
                        <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">B.</label>
                        <input type="text" name="choices[1][content]" class="answer-input" placeholder="Đáp án B (bắt buộc)" maxlength="200" required>
                        <input type="hidden" name="choices[1][is_correct]" value="0">
                        <label class="correct-label" style="margin-top: 10px;">
                            <input type="radio" name="correct_choice" value="1">
                            Đáp án đúng
                        </label>
                        @error('choices.1.content')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="answer-card">
                        <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">C.</label>
                        <input type="text" name="choices[2][content]" class="answer-input" placeholder="Đáp án C (tùy chọn)" maxlength="200">
                        <input type="hidden" name="choices[2][is_correct]" value="0">
                        <label class="correct-label" style="margin-top: 10px;">
                            <input type="radio" name="correct_choice" value="2">
                            Đáp án đúng
                        </label>
                        @error('choices.2.content')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="answer-card">
                        <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">D.</label>
                        <input type="text" name="choices[3][content]" class="answer-input" placeholder="Đáp án D (tùy chọn)" maxlength="200">
                        <input type="hidden" name="choices[3][is_correct]" value="0">
                        <label class="correct-label" style="margin-top: 10px;">
                            <input type="radio" name="correct_choice" value="3">
                            Đáp án đúng
                        </label>
                        @error('choices.3.content')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Nút lưu -->
                <div style="text-align: center; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary" style="padding: 15px 30px; font-size: 18px;">
                        💾 Lưu câu hỏi vào chủ đề
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
// Cập nhật is_correct khi chọn radio
document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('input[name="correct_choice"]');
    const hiddenInputs = document.querySelectorAll('input[name*="[is_correct]"]');
    
    radios.forEach((radio, index) => {
        radio.addEventListener('change', function() {
            // Reset tất cả về 0
            hiddenInputs.forEach(input => input.value = '0');
            
            // Set giá trị đúng cho đáp án được chọn
            if (this.checked) {
                hiddenInputs[parseInt(this.value)].value = '1';
                
                // Visual effect
                document.querySelectorAll('.answer-card').forEach(card => {
                    card.classList.remove('correct');
                });
                this.closest('.answer-card').classList.add('correct');
            }
        });
    });
});

// Form validation
document.getElementById('questionForm').addEventListener('submit', function(e) {
    const questionContent = document.getElementById('questionContent').value.trim();
    const choices = document.querySelectorAll('input[name*="[content]"]');
    const correctChoice = document.querySelector('input[name="correct_choice"]:checked');
    
    if (!questionContent) {
        alert('Vui lòng nhập nội dung câu hỏi!');
        e.preventDefault();
        return;
    }
    
    if (!correctChoice) {
        alert('Vui lòng chọn đáp án đúng!');
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
    const correctChoiceContent = choices[parseInt(correctChoice.value)];
    if (!correctChoiceContent.value.trim()) {
        alert('Đáp án được chọn làm đáp án đúng phải có nội dung!');
        e.preventDefault();
        return;
    }
});
</script>

</body>
</html>