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
                <button class="btn btn-primary" onclick="exportToTopic()">📤 Xuất ra chủ đề</button>
            </div>
        </div>

        <!-- Form tạo câu hỏi -->
        <div class="quiz-container">
            <!-- Câu hỏi -->
            <div class="question-input">
                <h3 style="color: white; margin-bottom: 15px;">❓ Nội dung câu hỏi</h3>
                <input type="text" id="questionText" placeholder="Nhập câu hỏi vào đây..." maxlength="500">
            </div>

            <!-- Đáp án -->
            <div class="answers-grid" style="margin-top: 20px;">
                <h3 style="color: white; margin-bottom: 15px; grid-column: 1 / -1;">✅ Các đáp án (tối thiểu 2 đáp án)</h3>
                
                <div class="answer-card">
                    <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">A.</label>
                    <input type="text" class="answer-input" placeholder="Đáp án A (bắt buộc)" maxlength="200">
                    <label class="correct-label" style="margin-top: 10px;">
                        <input type="radio" name="correctAnswer" value="0" required>
                        Đáp án đúng
                    </label>
                </div>
                
                <div class="answer-card">
                    <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">B.</label>
                    <input type="text" class="answer-input" placeholder="Đáp án B (bắt buộc)" maxlength="200">
                    <label class="correct-label" style="margin-top: 10px;">
                        <input type="radio" name="correctAnswer" value="1">
                        Đáp án đúng
                    </label>
                </div>
                
                <div class="answer-card">
                    <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">C.</label>
                    <input type="text" class="answer-input" placeholder="Đáp án C (tùy chọn)" maxlength="200">
                    <label class="correct-label" style="margin-top: 10px;">
                        <input type="radio" name="correctAnswer" value="2">
                        Đáp án đúng
                    </label>
                </div>
                
                <div class="answer-card">
                    <label style="color: white; font-weight: bold; display: block; margin-bottom: 8px;">D.</label>
                    <input type="text" class="answer-input" placeholder="Đáp án D (tùy chọn)" maxlength="200">
                    <label class="correct-label" style="margin-top: 10px;">
                        <input type="radio" name="correctAnswer" value="3">
                        Đáp án đúng
                    </label>
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

// Thêm câu hỏi vào danh sách
function addQuestion() {
    const questionText = document.getElementById('questionText').value.trim();
    const answerInputs = document.querySelectorAll('.answer-input');
    const correctAnswer = document.querySelector('input[name="correctAnswer"]:checked');
    
    if (!questionText) {
        alert('Vui lòng nhập nội dung câu hỏi!');
        return;
    }
    
    if (!correctAnswer) {
        alert('Vui lòng chọn đáp án đúng!');
        return;
    }
    
    // Lấy các đáp án có nội dung
    const choices = [];
    answerInputs.forEach((input, index) => {
        if (input.value.trim()) {
            choices.push({
                content: input.value.trim(),
                is_correct: index == correctAnswer.value
            });
        }
    });
    
    if (choices.length < 2) {
        alert('Cần tối thiểu 2 đáp án có nội dung!');
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
    document.querySelectorAll('input[name="correctAnswer"]').forEach(radio => radio.checked = false);
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