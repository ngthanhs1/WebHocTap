<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo câu hỏi</title>
    <link rel="stylesheet" href="{{ asset('css/styles4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles3.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
</head>
<body>
    <div class="container">
        <!-- Navigation Header -->
        <nav class="navbar">
            <div class="nav-content">
                <div class="nav-brand">
                    <a href="{{ route('trangchinh') }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Hệ thống học tập</span>
                    </a>
                </div>
                <div class="nav-links">
                    <a href="{{ route('trangchinh') }}" class="nav-link">
                        <i class="fas fa-arrow-left"></i>
                        Quay lại
                    </a>
                </div>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h1 class="page-title">
                    <i class="fas fa-plus-circle"></i>
                    Tạo câu hỏi mới
                </h1>
                <p class="page-subtitle">Xây dựng câu hỏi rồi xuất sang chủ đề</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="form-card">
                <!-- Question Content Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-question-circle"></i>
                        Nội dung câu hỏi
                    </h3>
                    <div class="form-group">
                        <input type="text" id="questionText" placeholder="Nhập câu hỏi vào đây..." maxlength="500" required>
                    </div>
                </div>

                <!-- Answer Options Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-list-ul"></i>
                        Các lựa chọn đáp án
                    </h3>
                    <p class="section-description">Click vào thẻ đáp án để chọn đáp án đúng</p>

                    <div class="choices-grid">
                        <div class="choice-card" onclick="selectCorrectAnswer(0)" data-choice="0">
                            <div class="choice-header">
                                <div class="choice-label">A</div>
                                <div class="correct-indicator">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Đáp án đúng</span>
                                </div>
                            </div>
                            <input type="text" class="choice-input" placeholder="Đáp án A (bắt buộc)" maxlength="200">
                            <input type="hidden" class="correct-value" value="0">
                        </div>

                        <div class="choice-card" onclick="selectCorrectAnswer(1)" data-choice="1">
                            <div class="choice-header">
                                <div class="choice-label">B</div>
                                <div class="correct-indicator">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Đáp án đúng</span>
                                </div>
                            </div>
                            <input type="text" class="choice-input" placeholder="Đáp án B (bắt buộc)" maxlength="200">
                            <input type="hidden" class="correct-value" value="0">
                        </div>

                        <div class="choice-card" onclick="selectCorrectAnswer(2)" data-choice="2">
                            <div class="choice-header">
                                <div class="choice-label">C</div>
                                <div class="correct-indicator">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Đáp án đúng</span>
                                </div>
                            </div>
                            <input type="text" class="choice-input" placeholder="Đáp án C (tùy chọn)" maxlength="200">
                            <input type="hidden" class="correct-value" value="0">
                        </div>

                        <div class="choice-card" onclick="selectCorrectAnswer(3)" data-choice="3">
                            <div class="choice-header">
                                <div class="choice-label">D</div>
                                <div class="correct-indicator">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Đáp án đúng</span>
                                </div>
                            </div>
                            <input type="text" class="choice-input" placeholder="Đáp án D (tùy chọn)" maxlength="200">
                            <input type="hidden" class="correct-value" value="0">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="clearForm()">
                        <i class="fas fa-eraser"></i>
                        Xóa nội dung
                    </button>
                    <button type="button" class="btn btn-primary" onclick="addQuestion()">
                        <i class="fas fa-plus"></i>
                        Thêm câu hỏi
                    </button>
                </div>
            </div>

            <!-- Saved Questions List -->
            <div class="saved-card">
                <div style="display:flex; align-items:center; justify-content: space-between;">
                    <h3 class="section-title" style="margin:0;">
                        <i class="fas fa-list"></i>
                        Danh sách câu hỏi đã tạo (<span id="questionCount">0</span> câu)
                    </h3>
                    <div>
                        <button type="button" class="btn btn-secondary" onclick="exportToTopic()">
                            <i class="fas fa-folder-plus"></i>
                            Xuất ra chủ đề mới
                        </button>
                        <button type="button" class="btn btn-primary" onclick="saveAndSelectTopic()">
                            <i class="fas fa-save"></i>
                            Lưu vào chủ đề có sẵn
                        </button>
                    </div>
                </div>
                <div id="savedQuestions" style="margin-top:12px;">
                    <div class="section-description">Chưa có câu hỏi nào được lưu</div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <div id="flashSuccess" class="alert alert-success" style="display:none;">
            <i class="fas fa-check-circle"></i>
            Đã lưu vào session thành công!
        </div>
        <div id="flashError" class="alert alert-error" style="display:none;">
            <i class="fas fa-exclamation-circle"></i>
            Có lỗi xảy ra, vui lòng thử lại.
        </div>
    </div>

    <script>
        let savedQuestions = [];

        // Toggle correct choice like create page
        function selectCorrectAnswer(index) {
            document.querySelectorAll('.choice-card').forEach((card) => {
                card.classList.remove('selected');
                card.querySelector('.correct-value').value = '0';
            });
            const selectedCard = document.querySelectorAll('.choice-card')[index];
            selectedCard.classList.add('selected');
            selectedCard.querySelector('.correct-value').value = '1';
        }

        // Prevent click bubbling from inputs
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.choice-input').forEach(input => {
                input.addEventListener('click', function(e) { e.stopPropagation(); });
                input.addEventListener('focus', function(e) { e.stopPropagation(); });
            });
        });

        // Build question object and append to list
        function addQuestion() {
            const questionText = document.getElementById('questionText').value.trim();
            const choiceInputs = document.querySelectorAll('.choice-input');
            const correctFlags = document.querySelectorAll('.correct-value');

            if (!questionText) { alert('Vui lòng nhập nội dung câu hỏi!'); return; }

            let hasCorrect = false;
            correctFlags.forEach(i => { if (i.value === '1') hasCorrect = true; });
            if (!hasCorrect) { alert('Vui lòng chọn đáp án đúng bằng cách click vào thẻ đáp án!'); return; }

            const choices = [];
            choiceInputs.forEach((input, idx) => {
                if (input.value.trim()) {
                    choices.push({ content: input.value.trim(), is_correct: correctFlags[idx].value === '1' });
                }
            });
            if (choices.length < 2) { alert('Cần tối thiểu 2 đáp án có nội dung!'); return; }

            let correctHasContent = false;
            choices.forEach(c => { if (c.is_correct && c.content.trim()) correctHasContent = true; });
            if (!correctHasContent) { alert('Đáp án được chọn làm đáp án đúng phải có nội dung!'); return; }

            savedQuestions.push({ content: questionText, choices });
            updateQuestionsList();
            clearForm();
        }

        function updateQuestionsList() {
            document.getElementById('questionCount').textContent = savedQuestions.length;
            const container = document.getElementById('savedQuestions');
            if (savedQuestions.length === 0) {
                container.innerHTML = '<div class="section-description">Chưa có câu hỏi nào được lưu</div>';
                return;
            }
            let html = '';
            savedQuestions.forEach((q, i) => {
                html += `
                    <div class="quiz-item">
                        <div class="quiz-question">Câu ${i + 1}: ${q.content}</div>
                        <div class="quiz-answers">
                            ${q.choices.map((ch, ci) => `
                                <div class="quiz-answer ${ch.is_correct ? 'correct' : ''}">
                                    ${String.fromCharCode(65 + ci)}: ${ch.content}
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        function clearForm() {
            document.getElementById('questionText').value = '';
            document.querySelectorAll('.choice-input').forEach(i => i.value = '');
            document.querySelectorAll('.correct-value').forEach(i => i.value = '0');
            document.querySelectorAll('.choice-card').forEach(c => c.classList.remove('selected'));
        }

        // Save questions to session
        function saveQuestionsToSession() {
            if (savedQuestions.length === 0) {
                return Promise.reject(new Error('empty'));
            }
            return fetch('/cauhoi/save-session', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ questions: savedQuestions })
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    document.getElementById('flashSuccess').style.display = 'flex';
                    return true;
                }
                document.getElementById('flashError').style.display = 'flex';
                throw new Error('failed');
            }).catch(err => {
                document.getElementById('flashError').style.display = 'flex';
                throw err;
            });
        }

        // Export to new topic (go to create topic page)
        function exportToTopic() {
            if (savedQuestions.length === 0) { alert('Chưa có câu hỏi nào để xuất!'); return; }
            saveQuestionsToSession().then(() => {
                window.location.href = '/chude/create';
            });
        }

        // Save and go select existing topic
        function saveAndSelectTopic() {
            if (savedQuestions.length === 0) { alert('Chưa có câu hỏi nào để lưu!'); return; }
            saveQuestionsToSession().then(() => {
                window.location.href = '{{ route("topics.select") }}';
            }).catch(() => {});
        }

        // If topic_id provided, change primary action to save to that topic
        const urlParams = new URLSearchParams(window.location.search);
        const topicId = urlParams.get('topic_id');
        if (topicId) {
            // Overwrite saveAndSelectTopic to redirect directly with topic id if needed in future
        }
    </script>

</body>
</html>