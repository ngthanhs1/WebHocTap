<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm câu hỏi - {{ $topic->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles4.css') }}">
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
                    <a href="{{ route('topics.show', $topic) }}" class="nav-link">
                        <i class="fas fa-arrow-left"></i>
                        Quay lại chủ đề
                    </a>
                </div>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h1 class="page-title">
                    <i class="fas fa-plus-circle"></i>
                    Thêm câu hỏi mới
                </h1>
                <p class="page-subtitle">Chủ đề: {{ $topic->name }}</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="form-card">
                <form id="questionForm" method="POST" action="{{ route('topics.questions.store', $topic) }}">
                    @csrf
                    
                    <!-- Question Content Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-question-circle"></i>
                            Nội dung câu hỏi
                        </h3>
                        <div class="form-group">
                            <textarea name="content" id="questionContent" 
                                placeholder="Nhập nội dung câu hỏi của bạn..." 
                                rows="3" 
                                maxlength="500" 
                                required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
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
                                    <span class="choice-label">A</span>
                                    <div class="correct-indicator">
                                        <i class="fas fa-check"></i>
                                        <span>Đáp án đúng</span>
                                    </div>
                                </div>
                                <input type="text" name="choices[0][content]" class="choice-input" 
                                    placeholder="Nhập đáp án A (bắt buộc)" 
                                    maxlength="200" 
                                    value="{{ old('choices.0.content') }}" 
                                    required>
                                <input type="hidden" name="choices[0][is_correct]" class="correct-value" value="0">
                                @error('choices.0.content')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="choice-card" onclick="selectCorrectAnswer(1)" data-choice="1">
                                <div class="choice-header">
                                    <span class="choice-label">B</span>
                                    <div class="correct-indicator">
                                        <i class="fas fa-check"></i>
                                        <span>Đáp án đúng</span>
                                    </div>
                                </div>
                                <input type="text" name="choices[1][content]" class="choice-input" 
                                    placeholder="Nhập đáp án B (bắt buộc)" 
                                    maxlength="200" 
                                    value="{{ old('choices.1.content') }}" 
                                    required>
                                <input type="hidden" name="choices[1][is_correct]" class="correct-value" value="0">
                                @error('choices.1.content')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="choice-card" onclick="selectCorrectAnswer(2)" data-choice="2">
                                <div class="choice-header">
                                    <span class="choice-label">C</span>
                                    <div class="correct-indicator">
                                        <i class="fas fa-check"></i>
                                        <span>Đáp án đúng</span>
                                    </div>
                                </div>
                                <input type="text" name="choices[2][content]" class="choice-input" 
                                    placeholder="Nhập đáp án C (tùy chọn)" 
                                    maxlength="200" 
                                    value="{{ old('choices.2.content') }}">
                                <input type="hidden" name="choices[2][is_correct]" class="correct-value" value="0">
                                @error('choices.2.content')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="choice-card" onclick="selectCorrectAnswer(3)" data-choice="3">
                                <div class="choice-header">
                                    <span class="choice-label">D</span>
                                    <div class="correct-indicator">
                                        <i class="fas fa-check"></i>
                                        <span>Đáp án đúng</span>
                                    </div>
                                </div>
                                <input type="text" name="choices[3][content]" class="choice-input" 
                                    placeholder="Nhập đáp án D (tùy chọn)" 
                                    maxlength="200" 
                                    value="{{ old('choices.3.content') }}">
                                <input type="hidden" name="choices[3][is_correct]" class="correct-value" value="0">
                                @error('choices.3.content')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('topics.show', $topic) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Lưu câu hỏi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Custom Styles for Create Question Page -->
    <style>
        .choices-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }

        .choice-card {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .choice-card:hover {
            border-color: #000000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .choice-card.selected {
            border-color: #000000;
            background: #f8f9fa;
        }

        .choice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .choice-label {
            background: #000000;
            color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        .correct-indicator {
            display: none;
            align-items: center;
            gap: 4px;
            color: #000000;
            font-size: 12px;
            font-weight: 500;
        }

        .choice-card.selected .correct-indicator {
            display: flex;
        }

        .choice-input {
            width: 100%;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 12px;
            font-size: 14px;
            background: #ffffff;
            color: #000000;
        }

        .choice-input:focus {
            outline: none;
            border-color: #000000;
        }

        .form-section {
            margin-bottom: 32px;
        }

        .section-title {
            color: #000000;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-description {
            color: #666666;
            font-size: 14px;
            margin-bottom: 16px;
        }

        .form-group textarea {
            width: 100%;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 12px;
            font-size: 14px;
            background: #ffffff;
            color: #000000;
            resize: vertical;
            min-height: 80px;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #000000;
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: #f0f8f0;
            border: 1px solid #4caf50;
            color: #2e7d32;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #f44336;
            color: #c62828;
        }
    </style>

    <script>
        // Chọn đáp án đúng
        function selectCorrectAnswer(index) {
            // Bỏ chọn tất cả các đáp án khác
            document.querySelectorAll('.choice-card').forEach((card) => {
                card.classList.remove('selected');
                card.querySelector('.correct-value').value = '0';
            });
            
            // Chọn đáp án hiện tại
            const selectedCard = document.querySelectorAll('.choice-card')[index];
            selectedCard.classList.add('selected');
            selectedCard.querySelector('.correct-value').value = '1';
        }

        // Ngăn click vào input trigger selectCorrectAnswer
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.choice-input').forEach(input => {
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
            const correctAnswers = document.querySelectorAll('.correct-value');
            
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
                alert('Vui lòng chọn đáp án đúng bằng cách click vào thẻ đáp án!');
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