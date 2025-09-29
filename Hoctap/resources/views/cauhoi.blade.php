<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo câu hỏi</title>
    <link rel="stylesheet" href="{{ asset('css/styles3.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tạo câu hỏi</h1>
            <div class="controls">
                <a href="{{ route('trangchinh') }}" class="btn">← Quay lại</a>
                <button class="btn btn-primary" onclick="exportToTopic()">Xuất ra chủ đề</button>
            </div>
        </div>

        <!-- Form tạo câu hỏi -->
        <div class="quiz-container">
            <!-- Câu hỏi -->
            <div class="question-input">
                <h3 style="color: white; margin-bottom: 15px;">Nội dung câu hỏi</h3>
                <input type="text" id="questionText" placeholder="Nhập câu hỏi vào đây..." maxlength="500">
            </div>

            <!-- Đáp án -->
            <div class="answers-grid" style="margin-top: 20px;">
                <h3 style="color: white; margin-bottom: 15px; grid-column: 1 / -1;">Các đáp án (tối thiểu 2 đáp án)</h3>
                
                <div class="answer-card" onclick="selectCorrectAnswer(0)">
                    <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">A.</label>
                    <input type="text" class="answer-input" placeholder="Đáp án A (bắt buộc)" maxlength="200">
                    <input type="hidden" class="correct-answer" value="false">
                    <div class="correct-indicator">
                        <i class="check-icon">✓</i>
                        <span>Đáp án đúng</span>
                    </div>
                </div>
                
                <div class="answer-card" onclick="selectCorrectAnswer(1)">
                    <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">B.</label>
                    <input type="text" class="answer-input" placeholder="Đáp án B (bắt buộc)" maxlength="200">
                    <input type="hidden" class="correct-answer" value="false">
                    <div class="correct-indicator">
                        <i class="check-icon">✓</i>
                        <span>Đáp án đúng</span>
                    </div>
                </div>
                
                <div class="answer-card" onclick="selectCorrectAnswer(2)">
                    <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">C.</label>
                    <input type="text" class="answer-input" placeholder="Đáp án C (tùy chọn)" maxlength="200">
                    <input type="hidden" class="correct-answer" value="false">
                    <div class="correct-indicator">
                        <i class="check-icon">✓</i>
                        <span>Đáp án đúng</span>
                    </div>
                </div>
                
                <div class="answer-card" onclick="selectCorrectAnswer(3)">
                    <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">D.</label>
                    <input type="text" class="answer-input" placeholder="Đáp án D (tùy chọn)" maxlength="200">
                    <input type="hidden" class="correct-answer" value="false">
                    <div class="correct-indicator">
                        <i class="check-icon">✓</i>
                        <span>Đáp án đúng</span>
                    </div>
                </div>
            </div>

            <!-- Nút thêm câu hỏi -->
            <div style="text-align: center; margin-top: 30px;">
                <button type="button" class="btn" onclick="addQuestion()" style="padding: 15px 30px; font-size: 18px; margin-right: 10px;">
                    ➕ Thêm câu hỏi
                </button>
            </div>
        </div>

        <!-- Danh sách câu hỏi đã tạo -->
        <div class="quiz-list">
            <h2 style="color: white; margin-bottom: 20px;">Danh sách câu hỏi đã tạo (<span id="questionCount">0</span> câu)</h2>
            <div id="savedQuestions">
                <div class="empty-state">Chưa có câu hỏi nào được lưu</div>
            </div>
        </div>
    </div>

<script>
let savedQuestions = [];

// Chọn đáp án đúng
function selectCorrectAnswer(index) {
    // Bỏ chọn tất cả các đáp án khác
    document.querySelectorAll('.answer-card').forEach((card, i) => {
        card.classList.remove('correct');
        card.querySelector('.correct-answer').value = 'false';
    });
    
    // Chọn đáp án hiện tại
    const selectedCard = document.querySelectorAll('.answer-card')[index];
    selectedCard.classList.add('correct');
    selectedCard.querySelector('.correct-answer').value = 'true';
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

// Thêm câu hỏi vào danh sách
function addQuestion() {
    const questionText = document.getElementById('questionText').value.trim();
    const answerInputs = document.querySelectorAll('.answer-input');
    const correctAnswers = document.querySelectorAll('.correct-answer');
    
    if (!questionText) {
        alert('Vui lòng nhập nội dung câu hỏi!');
        return;
    }
    
    // Kiểm tra có đáp án đúng được chọn không
    let hasCorrectAnswer = false;
    correctAnswers.forEach(input => {
        if (input.value === 'true') {
            hasCorrectAnswer = true;
        }
    });
    
    if (!hasCorrectAnswer) {
        alert('Vui lòng chọn đáp án đúng bằng cách click vào card đáp án!');
        return;
    }
    
    // Lấy các đáp án có nội dung
    const choices = [];
    answerInputs.forEach((input, index) => {
        if (input.value.trim()) {
            choices.push({
                content: input.value.trim(),
                is_correct: correctAnswers[index].value === 'true'
            });
        }
    });
    
    if (choices.length < 2) {
        alert('Cần tối thiểu 2 đáp án có nội dung!');
        return;
    }
    
    // Kiểm tra đáp án được chọn có nội dung không
    let correctAnswerHasContent = false;
    choices.forEach(choice => {
        if (choice.is_correct && choice.content.trim()) {
            correctAnswerHasContent = true;
        }
    });
    
    if (!correctAnswerHasContent) {
        alert('Đáp án được chọn làm đáp án đúng phải có nội dung!');
        return;
    }
    
    // Thêm câu hỏi vào danh sách
    const question = {
        content: questionText,
        choices: choices
    };
    
    savedQuestions.push(question);
    updateQuestionsList();
    clearForm();
    
    alert('Đã thêm câu hỏi thành công!');
}

// Cập nhật danh sách câu hỏi
function updateQuestionsList() {
    document.getElementById('questionCount').textContent = savedQuestions.length;
    
    const container = document.getElementById('savedQuestions');
    
    if (savedQuestions.length === 0) {
        container.innerHTML = '<div class="empty-state">Chưa có câu hỏi nào được lưu</div>';
        return;
    }
    
    let html = '';
    savedQuestions.forEach((question, index) => {
        html += `
            <div class="quiz-item">
                <div class="quiz-question">Câu ${index + 1}: ${question.content}</div>
                <div class="quiz-answers">
                    ${question.choices.map((choice, choiceIndex) => `
                        <div class="quiz-answer ${choice.is_correct ? 'correct' : ''}">
                            ${String.fromCharCode(65 + choiceIndex)}: ${choice.content}
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

// Xóa form
function clearForm() {
    document.getElementById('questionText').value = '';
    document.querySelectorAll('.answer-input').forEach(input => input.value = '');
    document.querySelectorAll('.correct-answer').forEach(input => input.value = 'false');
    document.querySelectorAll('.answer-card').forEach(card => card.classList.remove('correct'));
}

// Xuất ra chủ đề (lưu vào session và chuyển trang)
function exportToTopic() {
    if (savedQuestions.length === 0) {
        alert('Chưa có câu hỏi nào để xuất!');
        return;
    }
    
    // Lưu vào session
    fetch('/cauhoi/save-session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            questions: savedQuestions
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Chuyển đến trang tạo chủ đề
            window.location.href = '/chude/create';
        } else {
            alert('Có lỗi xảy ra khi lưu!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi lưu!');
    });
}

// Check nếu đang thêm câu hỏi vào chủ đề có sẵn
const urlParams = new URLSearchParams(window.location.search);
const topicId = urlParams.get('topic_id');

if (topicId) {
    // Đang thêm vào chủ đề có sẵn - thay đổi button xuất
    const exportBtn = document.querySelector('button[onclick="exportToTopic()"]');
    if (exportBtn) {
        exportBtn.textContent = '💾 Lưu vào chủ đề';
        exportBtn.onclick = function() {
            addToExistingTopic(topicId);
        };
    }
}

// Thêm câu hỏi vào chủ đề có sẵn
        function addToExistingTopic() {
            if (questions.length === 0) {
                alert('Vui lòng tạo ít nhất một câu hỏi trước!');
                return;
            }
            
            // Lưu câu hỏi vào session trước
            saveQuestionsToSession().then(function() {
                // Chuyển đến trang chọn chủ đề
                window.location.href = '{{ route("topics.select") }}';
            }).catch(function(error) {
                console.error('Lỗi khi lưu câu hỏi:', error);
                alert('Có lỗi xảy ra khi lưu câu hỏi. Vui lòng thử lại!');
            });
        }
</script>

</body>
</html>