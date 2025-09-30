<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm tra - {{ $topic->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles7.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="test-container">
        <div class="test-header">
            <h1><i class="fas fa-clipboard-check"></i> Kiểm tra</h1>
            <h2>{{ $topic->name }}</h2>
            <div class="test-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $topic->questions->count() }}</span>
                    <span>Câu hỏi</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><i class="fas fa-stopwatch"></i></span>
                    <span>Kiểm tra</span>
                </div>
            </div>
            @if($topic->questions->count() > 0)
            <div class="timer-container">
                <div class="timer" id="timer">Thời gian: <span id="time">00:00</span></div>
            </div>
            @endif
        </div>

        @if($topic->questions->count() > 0)
            <form id="testForm" action="{{ route('topics.test.submit', $topic) }}" method="POST">
                @csrf
                
                <div class="question-status">
                    @for($i = 1; $i <= $topic->questions->count(); $i++)
                        <div class="status-item" id="status-{{ $i }}">{{ $i }}</div>
                    @endfor
                </div>

                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill" style="width: 0%"></div>
                </div>

                @foreach($topic->questions as $index => $question)
                    <div class="question-card">
                        <div class="question-header">
                            <div class="question-number">{{ $index + 1 }}</div>
                            <div class="question-text">{{ $question->content }}</div>
                        </div>
                        
                        <div class="choices-container">
                            @foreach($question->choices as $choiceIndex => $choice)
                                <div class="choice-item" onclick="selectChoice({{ $question->id }}, {{ $choice->id }}, this)">
                                    <div class="choice-letter">{{ chr(65 + $choiceIndex) }}</div>
                                    <div class="choice-text">{{ $choice->content }}</div>
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $choice->id }}" class="choice-radio">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="test-actions">
                    <a href="{{ route('trangchinh') }}" class="back-btn">
                        <i class="fas fa-arrow-left"></i>
                        Quay về
                    </a>
                    <button type="submit" class="submit-btn" id="submitBtn" disabled>
                        <i class="fas fa-paper-plane"></i>
                        Nộp bài
                    </button>
                </div>
            </form>
        @else
            <div class="empty-state">
                <i class="fas fa-question-circle"></i>
                <h3>Chưa có câu hỏi nào</h3>
                <p>Chủ đề này chưa có câu hỏi để kiểm tra. Hãy thêm câu hỏi vào chủ đề này!</p>
                <a href="{{ route('cauhoi.create') }}" class="back-btn" style="margin-top: 20px;">
                    <i class="fas fa-plus"></i>
                    Thêm câu hỏi
                </a>
            </div>
        @endif
    </div>

    <script>
        let startTime = Date.now();
        let timerInterval;
        let answeredQuestions = new Set();
        const totalQuestions = {{ $topic->questions->count() }};

        // Khởi động timer
        function startTimer() {
            timerInterval = setInterval(function() {
                const elapsed = Math.floor((Date.now() - startTime) / 1000);
                const minutes = Math.floor(elapsed / 60);
                const seconds = elapsed % 60;
                document.getElementById('time').textContent = 
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        // Chọn đáp án
        function selectChoice(questionId, choiceId, element) {
            // Bỏ selected cho tất cả choices của câu hỏi này
            const questionCard = element.closest('.question-card');
            questionCard.querySelectorAll('.choice-item').forEach(item => {
                item.classList.remove('selected');
            });
            
            // Thêm selected cho choice được chọn
            element.classList.add('selected');
            
            // Check radio button
            const radio = element.querySelector('.choice-radio');
            radio.checked = true;
            
            // Cập nhật trạng thái câu hỏi
            const questionIndex = Array.from(document.querySelectorAll('.question-card'))
                .indexOf(questionCard) + 1;
            
            answeredQuestions.add(questionId);
            document.getElementById(`status-${questionIndex}`).classList.add('answered');
            
            // Cập nhật progress bar
            updateProgress();
            
            // Cập nhật nút submit
            updateSubmitButton();
        }

        function updateProgress() {
            const progress = (answeredQuestions.size / totalQuestions) * 100;
            document.getElementById('progressFill').style.width = progress + '%';
        }

        function updateSubmitButton() {
            const submitBtn = document.getElementById('submitBtn');
            if (answeredQuestions.size === totalQuestions) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Nộp bài';
            } else {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `<i class="fas fa-paper-plane"></i> Nộp bài (${answeredQuestions.size}/${totalQuestions})`;
            }
        }

        // Xác nhận trước khi nộp bài
        document.getElementById('testForm').addEventListener('submit', function(e) {
            if (answeredQuestions.size < totalQuestions) {
                e.preventDefault();
                alert('Bạn chưa trả lời hết tất cả câu hỏi!');
                return;
            }
            
            if (!confirm('Bạn có chắc chắn muốn nộp bài không? Bạn sẽ không thể thay đổi đáp án sau khi nộp.')) {
                e.preventDefault();
                return;
            }
            
            // Dừng timer
            clearInterval(timerInterval);
        });

        // Cảnh báo khi rời khỏi trang
        window.addEventListener('beforeunload', function(e) {
            if (answeredQuestions.size > 0 && answeredQuestions.size < totalQuestions) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Khởi động timer khi trang load
        if (totalQuestions > 0) {
            startTimer();
        }
    </script>
</body>
</html>