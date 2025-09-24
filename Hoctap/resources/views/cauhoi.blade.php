<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Creator</title>
    <link rel="stylesheet" href="{{ asset('css/styles3.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Quiz Creator</h1>
            <div class="controls">
                <button class="btn" onclick="clearCurrentQuiz()">Xóa câu hỏi</button>
                <button class="btn btn-primary" onclick="saveQuiz()">Lưu câu hỏi</button>
                <button class="btn" onclick="exportQuizzes()">Xuất file</button>
            </div>
        </div>

        <div class="quiz-container">
            <div class="question-input">
                <input type="text" id="questionText" placeholder="Nhập câu hỏi vào đây..." maxlength="200">
            </div>

            <div class="answers-grid" id="answersGrid">
                <div class="answer-card" data-index="0">
                    <button class="delete-btn" onclick="deleteAnswer(0)">×</button>
                    <input type="radio" name="correctAnswer" value="0" class="correct-radio">
                    <label class="correct-label">Đáp án đúng</label>
                    <input type="text" class="answer-input" placeholder="Nhập tùy chọn trả lời ở đây" maxlength="100">
                </div>
                <div class="answer-card" data-index="1">
                    <button class="delete-btn" onclick="deleteAnswer(1)">×</button>
                    <input type="radio" name="correctAnswer" value="1" class="correct-radio">
                    <label class="correct-label">Đáp án đúng</label>
                    <input type="text" class="answer-input" placeholder="Nhập tùy chọn trả lời ở đây" maxlength="100">
                </div>
                <div class="answer-card" data-index="2">
                    <button class="delete-btn" onclick="deleteAnswer(2)">×</button>
                    <input type="radio" name="correctAnswer" value="2" class="correct-radio">
                    <label class="correct-label">Đáp án đúng</label>
                    <input type="text" class="answer-input" placeholder="Nhập tùy chọn trả lời ở đây" maxlength="100">
                </div>
                <div class="answer-card" data-index="3">
                    <button class="delete-btn" onclick="deleteAnswer(3)">×</button>
                    <input type="radio" name="correctAnswer" value="3" class="correct-radio">
                    <label class="correct-label">Đáp án đúng</label>
                    <input type="text" class="answer-input" placeholder="Nhập tùy chọn trả lời ở đây" maxlength="100">
                </div>
                <div class="add-card" onclick="addAnswer()">
                    <div class="add-icon">+</div>
                    <div class="add-text">Thêm lựa chọn</div>
                </div>
            </div>
        </div>

        <div class="quiz-list">
            <h2 style="color: white; margin-bottom: 20px;">Danh sách câu hỏi đã tạo</h2>
            <div id="savedQuizzes">
                <div class="empty-state">Chưa có câu hỏi nào được lưu</div>
            </div>
        </div>
    </div>

</body>
</html>