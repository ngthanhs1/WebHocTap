<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm tra - {{ $topic->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles4.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .choice-item.selected { border-color: #000; background: #f9fafb; }
        .answered { background: #000 !important; color: #fff !important; }
        .choice-item { position: relative; }
        .choice-item .choice-letter { transition: background .2s, color .2s; }
        .choice-item.selected .choice-letter { background: #000 !important; color: #fff !important; }
        .choice-item .choice-right { display: none; color: #10b981; margin-left: 12px; }
        .choice-item.selected .choice-right { display: block; }
    </style>
</head>
<body>
    <div class="main-content" style="max-width: 900px; margin: 32px auto;">
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; margin-bottom: 32px; text-align: center;">
            <h1 style="font-size: 2rem; font-weight: 700; color: #000; margin-bottom: 8px;"><i class="fas fa-clipboard-check"></i> Kiểm tra</h1>
            <h2 style="font-size: 1.3rem; color: #222; margin-bottom: 16px;">{{ $topic->name }}</h2>
            <div style="display: flex; justify-content: center; gap: 32px; margin-bottom: 16px;">
                <div style="text-align: center;">
                    <span style="font-size: 1.5rem; font-weight: bold; color: #000;">{{ $topic->questions->count() }}</span>
                    <div style="color: #666;">Câu hỏi</div>
                </div>
                <div style="text-align: center;">
                    <span style="font-size: 1.5rem; color: #000;"><i class="fas fa-stopwatch"></i></span>
                    <div style="color: #666;">Kiểm tra</div>
                </div>
            </div>
            @if($topic->questions->count() > 0)
            <div style="margin-top: 12px;">
                <span id="timer" style="font-size: 1.1rem; color: #000;">Thời gian: <span id="time">00:00</span></span>
            </div>
            @endif
        </div>

        @if($topic->questions->count() > 0)
            <form id="testForm" action="{{ route('topics.test.submit', $topic) }}" method="POST">
                @csrf
                
                <div style="display: flex; justify-content: center; gap: 8px; margin-bottom: 16px;">
                    @for($i = 1; $i <= $topic->questions->count(); $i++)
                        <div id="status-{{ $i }}" style="padding: 8px 15px; background: #f3f4f6; border-radius: 20px; color: #666; font-size: 0.9rem; min-width: 32px; text-align: center;"></div>
                    @endfor
                </div>
                <div style="background: #e5e7eb; height: 8px; border-radius: 4px; margin: 20px 0; overflow: hidden;">
                    <div id="progressFill" style="background: #000; height: 100%; width: 0%; transition: width 0.3s ease;"></div>
                </div>

                @foreach($topic->questions as $index => $question)
                    <div class="question-card" style="background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 24px; margin-bottom: 24px;">
                        <div style="display: flex; align-items: center; margin-bottom: 16px;">
                            <div style="background: #000; color: #fff; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 15px;">{{ $index + 1 }}</div>
                            <div style="font-size: 1.1rem; font-weight: 600; color: #222; flex: 1;">{{ $question->content }}</div>
                        </div>
                        <div style="margin-top: 12px;">
                            @foreach($question->choices as $choiceIndex => $choice)
                                <div onclick="selectChoice({{ $question->id }}, {{ $choice->id }}, this)" style="display: flex; align-items: center; padding: 12px; margin-bottom: 10px; border-radius: 8px; border: 2px solid #e5e7eb; background: #fff; cursor: pointer; transition: all 0.3s;" class="choice-item">
                                    <div class="choice-letter" style="width: 32px; height: 32px; border-radius: 50%; background: #e0e0e0; color: #000; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 12px;">{{ chr(65 + $choiceIndex) }}</div>
                                    <div style="flex: 1; font-size: 1rem;">{{ $choice->content }}</div>
                                    <div class="choice-right"><i class="fas fa-check-circle"></i></div>
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $choice->id }}" class="choice-radio" style="display: none;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div style="display: flex; gap: 15px; justify-content: center; margin-top: 30px;">
                    <a href="{{ route('trangchinh') }}" style="background: #e0e0e0; color: #000; border: none; padding: 12px 24px; border-radius: 6px; font-size: 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;"> <i class="fas fa-arrow-left"></i> Quay về </a>
                    <button type="submit" id="submitBtn" disabled style="background: #000; color: #fff; border: none; padding: 12px 24px; border-radius: 6px; font-size: 1rem; font-weight: 500; cursor: pointer;"> <i class="fas fa-paper-plane"></i> Nộp bài </button>
                </div>
            </form>
        @else
            <div style="text-align: center; padding: 60px 20px; color: #666; background: #fff; border-radius: 8px; margin-top: 32px;">
                <i class="fas fa-question-circle" style="font-size: 3rem; margin-bottom: 16px; color: #e0e0e0;"></i>
                <h3 style="font-size: 1.2rem; color: #000; margin-bottom: 8px;">Chưa có câu hỏi nào</h3>
                <p>Chủ đề này chưa có câu hỏi để kiểm tra. Hãy thêm câu hỏi vào chủ đề này!</p>
                <a href="{{ route('cauhoi.create') }}" style="margin-top: 20px; display: inline-block; padding: 12px 24px; background: #000; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 500;"> <i class="fas fa-plus"></i> Thêm câu hỏi </a>
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