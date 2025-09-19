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
                <button class="btn" onclick="clearCurrentQuiz()">Xóa câu hỏi hiện tại</button>
                <button class="btn btn-primary" onclick="saveQuiz()">💾 Lưu câu hỏi</button>
                <button class="btn" onclick="exportQuizzes()">📤 Xuất file</button>
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
            <h2 style="color: white; margin-bottom: 20px;">📝 Danh sách câu hỏi đã tạo</h2>
            <div id="savedQuizzes">
                <div class="empty-state">Chưa có câu hỏi nào được lưu</div>
            </div>
        </div>
    </div>

    <script>
        let savedQuestions = [];
        let answerIndex = 4;

        // Thiết lập CSRF token cho Ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function clearCurrentQuiz() {
            document.getElementById('questionText').value = '';
            document.querySelectorAll('.answer-input').forEach(input => input.value = '');
            document.querySelectorAll('.correct-radio').forEach(radio => radio.checked = false);
        }

        function saveQuiz() {
            const questionText = document.getElementById('questionText').value.trim();
            const answerCards = document.querySelectorAll('.answer-card:not(.add-card)');
            const correctAnswer = document.querySelector('input[name="correctAnswer"]:checked');
            
            if (!questionText) {
                alert('Vui lòng nhập câu hỏi!');
                return;
            }

            if (!correctAnswer) {
                alert('Vui lòng chọn đáp án đúng!');
                return;
            }

            let answers = [];
            let hasValidAnswers = false;

            answerCards.forEach((card, index) => {
                const input = card.querySelector('.answer-input');
                if (input && input.value.trim()) {
                    answers.push({
                        content: input.value.trim(),
                        is_correct: correctAnswer.value == index
                    });
                    hasValidAnswers = true;
                }
            });

            if (!hasValidAnswers || answers.length < 2) {
                alert('Vui lòng nhập ít nhất 2 đáp án!');
                return;
            }

            const question = {
                content: questionText,
                choices: answers
            };

            savedQuestions.push(question);
            updateQuizList();
            clearCurrentQuiz();
        }

        function updateQuizList() {
            const container = document.getElementById('savedQuizzes');
            
            if (savedQuestions.length === 0) {
                container.innerHTML = '<div class="empty-state">Chưa có câu hỏi nào được lưu</div>';
                return;
            }

            container.innerHTML = '';
            savedQuestions.forEach((question, index) => {
                const questionDiv = document.createElement('div');
                questionDiv.className = 'saved-question';
                questionDiv.innerHTML = `
                    <div class="question-header">
                        <h4>Câu ${index + 1}: ${question.content}</h4>
                        <button onclick="removeQuestion(${index})" class="remove-btn">🗑️</button>
                    </div>
                    <div class="choices-list">
                        ${question.choices.map(choice => `
                            <div class="choice-item ${choice.is_correct ? 'correct' : ''}">
                                ${choice.is_correct ? '✓' : '○'} ${choice.content}
                            </div>
                        `).join('')}
                    </div>
                `;
                container.appendChild(questionDiv);
            });
        }

        function removeQuestion(index) {
            savedQuestions.splice(index, 1);
            updateQuizList();
        }

        function exportQuizzes() {
            if (savedQuestions.length === 0) {
                alert('Vui lòng tạo ít nhất một câu hỏi!');
                return;
            }

            // Lưu vào session và chuyển đến trang chủ đề
            fetch('{{ route("cauhoi.save-session") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    questions: savedQuestions
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route("chude.create") }}';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi lưu câu hỏi!');
            });
        }

        function deleteAnswer(index) {
            const answerCard = document.querySelector(`[data-index="${index}"]`);
            if (document.querySelectorAll('.answer-card:not(.add-card)').length > 2) {
                answerCard.remove();
                updateRadioButtons();
            } else {
                alert('Phải có ít nhất 2 đáp án!');
            }
        }

        function addAnswer() {
            const answersGrid = document.getElementById('answersGrid');
            const addCard = answersGrid.querySelector('.add-card');
            
            const newAnswerCard = document.createElement('div');
            newAnswerCard.className = 'answer-card';
            newAnswerCard.setAttribute('data-index', answerIndex);
            
            newAnswerCard.innerHTML = `
                <button class="delete-btn" onclick="deleteAnswer(${answerIndex})">×</button>
                <input type="radio" name="correctAnswer" value="${answerIndex}" class="correct-radio">
                <label class="correct-label">Đáp án đúng</label>
                <input type="text" class="answer-input" placeholder="Nhập tùy chọn trả lời ở đây" maxlength="100">
            `;
            
            answersGrid.insertBefore(newAnswerCard, addCard);
            answerIndex++;
        }

        function updateRadioButtons() {
            const answerCards = document.querySelectorAll('.answer-card:not(.add-card)');
            answerCards.forEach((card, index) => {
                const radio = card.querySelector('.correct-radio');
                radio.value = index;
                card.setAttribute('data-index', index);
                
                const deleteBtn = card.querySelector('.delete-btn');
                deleteBtn.setAttribute('onclick', `deleteAnswer(${index})`);
            });
        }
    </script>
</body>
</html>