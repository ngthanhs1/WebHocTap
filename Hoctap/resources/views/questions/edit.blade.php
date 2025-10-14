<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa câu hỏi</title>
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
                    <a href="{{ route('topics.show', $question->topic) }}" class="nav-link">
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
                    <i class="fas fa-edit"></i>
                    Chỉnh sửa câu hỏi
                </h1>
                <p class="page-subtitle">Chủ đề: {{ $question->topic->name }}</p>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Có lỗi xảy ra:</strong>
                    <ul style="margin: 4px 0 0 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="main-content">
            <div class="form-card">
                <form method="POST" action="{{ route('questions.update', $question) }}" id="questionForm">
                    @csrf
                    @method('PUT')

                    <!-- Question Content Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-question-circle"></i>
                            Nội dung câu hỏi
                        </h3>
                        <div class="form-group">
                            <textarea id="content" name="content" rows="3" required 
                                placeholder="Nhập nội dung câu hỏi...">{{ old('content', $question->content) }}</textarea>
                        </div>
                    </div>

                    <!-- Answer Options Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-list-ul"></i>
                            Các lựa chọn đáp án
                        </h3>
                        <p class="section-description">Click vào nút radio để chọn đáp án đúng</p>
                        
                        <div class="choices-container" id="choicesContainer">
                            @foreach($question->choices as $index => $choice)
                                <div class="choice-group" data-index="{{ $index }}">
                                    <div class="choice-header">
                                        <span class="choice-number">{{ chr(65 + $index) }}</span>
                                        <div class="choice-actions">
                                            <label class="correct-radio">
                                                <input type="radio" name="correct_answer" value="{{ $index }}" 
                                                    {{ old('choices.'.$index.'.is_correct', $choice->is_correct) ? 'checked' : '' }}>
                                                <span>Đáp án đúng</span>
                                            </label>
                                            @if($index >= 2)
                                                <button type="button" class="btn-remove" onclick="removeChoice(this)" title="Xóa đáp án">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <input type="text" name="choices[{{ $index }}][content]" 
                                        value="{{ old('choices.'.$index.'.content', $choice->content) }}" 
                                        placeholder="Nhập nội dung đáp án..." 
                                        class="choice-input" 
                                        required>
                                    <input type="hidden" name="choices[{{ $index }}][is_correct]" 
                                        value="{{ old('choices.'.$index.'.is_correct', $choice->is_correct) ? '1' : '0' }}">
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="add-choice-section">
                            <button type="button" class="btn btn-secondary" onclick="addChoice()">
                                <i class="fas fa-plus"></i>
                                Thêm đáp án
                            </button>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('topics.show', $question->topic) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Cập nhật câu hỏi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom Styles for Edit Question Page -->
    <style>
        .choices-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .choice-group {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px;
            background: #ffffff;
        }

        .choice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .choice-number {
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

        .choice-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .correct-radio {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            font-size: 14px;
            color: #000000;
        }

        .correct-radio input[type="radio"] {
            margin: 0;
        }

        .btn-remove {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            color: #666666;
            padding: 6px 8px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-remove:hover {
            background: #f5f5f5;
            border-color: #000000;
            color: #000000;
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

        .add-choice-section {
            margin-top: 16px;
            text-align: center;
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
            align-items: flex-start;
            gap: 8px;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #f44336;
            color: #c62828;
        }

        .alert ul {
            margin: 0;
            padding-left: 16px;
        }
    </style>

    <script>
        let choiceIndex = {{ count($question->choices) }};

        function addChoice() {
            const container = document.getElementById('choicesContainer');
            const choiceGroup = document.createElement('div');
            choiceGroup.className = 'choice-group';
            choiceGroup.setAttribute('data-index', choiceIndex);
            
            const choiceLabel = String.fromCharCode(65 + choiceIndex);
            
            choiceGroup.innerHTML = `
                <div class="choice-header">
                    <span class="choice-number">${choiceLabel}</span>
                    <div class="choice-actions">
                        <label class="correct-radio">
                            <input type="radio" name="correct_answer" value="${choiceIndex}">
                            <span>Đáp án đúng</span>
                        </label>
                        <button type="button" class="btn-remove" onclick="removeChoice(this)" title="Xóa đáp án">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <input type="text" name="choices[${choiceIndex}][content]" 
                    placeholder="Nhập nội dung đáp án..." 
                    class="choice-input" 
                    required>
                <input type="hidden" name="choices[${choiceIndex}][is_correct]" value="0">
            `;
            
            container.appendChild(choiceGroup);
            choiceIndex++;
            updateChoiceLabels();
        }

        function removeChoice(button) {
            const choiceGroup = button.closest('.choice-group');
            const choicesContainer = document.getElementById('choicesContainer');
            
            // Không cho xóa nếu chỉ còn 2 đáp án
            if (choicesContainer.children.length <= 2) {
                alert('Mỗi câu hỏi phải có ít nhất 2 đáp án!');
                return;
            }
            
            choiceGroup.remove();
            updateChoiceLabels();
        }

        function updateChoiceLabels() {
            const choiceGroups = document.querySelectorAll('.choice-group');
            choiceGroups.forEach((group, index) => {
                const label = group.querySelector('.choice-number');
                const radio = group.querySelector('input[type="radio"]');
                const contentInput = group.querySelector('input[name*="[content]"]');
                const hiddenInput = group.querySelector('input[name*="[is_correct]"]');
                
                // Cập nhật label
                label.textContent = String.fromCharCode(65 + index);
                
                // Cập nhật tên các input
                radio.value = index;
                contentInput.name = `choices[${index}][content]`;
                hiddenInput.name = `choices[${index}][is_correct]`;
                
                // Cập nhật data-index
                group.setAttribute('data-index', index);
            });
        }

        // Xử lý radio button để cập nhật hidden input
        document.addEventListener('change', function(e) {
            if (e.target.name === 'correct_answer') {
                // Reset tất cả hidden input về 0
                const hiddenInputs = document.querySelectorAll('input[name*="[is_correct]"]');
                hiddenInputs.forEach(input => input.value = '0');
                
                // Set input được chọn về 1
                const selectedIndex = e.target.value;
                const selectedHidden = document.querySelector(`input[name="choices[${selectedIndex}][is_correct]"]`);
                if (selectedHidden) {
                    selectedHidden.value = '1';
                }
            }
        });

        // Đảm bảo có ít nhất 1 đáp án được chọn khi submit
        document.getElementById('questionForm').addEventListener('submit', function(e) {
            const checkedRadio = document.querySelector('input[name="correct_answer"]:checked');
            if (!checkedRadio) {
                e.preventDefault();
                alert('Vui lòng chọn ít nhất 1 đáp án đúng!');
                return;
            }
            
            // Kiểm tra đáp án đúng có nội dung không
            const selectedIndex = checkedRadio.value;
            const selectedInput = document.querySelector(`input[name="choices[${selectedIndex}][content]"]`);
            if (!selectedInput || !selectedInput.value.trim()) {
                e.preventDefault();
                alert('Đáp án được chọn làm đáp án đúng phải có nội dung!');
                return;
            }
        });
    </script>
</body>
</html>