<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa câu hỏi</title>
    <link rel="stylesheet" href="{{ asset('css/styles5.css') }}">
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="breadcrumb">
                <a href="{{ route('trangchinh') }}">← Quay lại trang chính</a>
                <span> / </span>
                <a href="{{ route('topics.show', $question->topic) }}">{{ $question->topic->name }}</a>
                <span> / Sửa câu hỏi</span>
            </div>
        </div>

        <div class="content-section">
            <div class="form-container">
                <h1>Sửa câu hỏi</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('questions.update', $question) }}" id="questionForm">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="content">Nội dung câu hỏi *</label>
                        <textarea id="content" name="content" required rows="3">{{ old('content', $question->content) }}</textarea>
                    </div>

                    <div class="choices-section">
                        <h3>Đáp án</h3>
                        <div id="choicesContainer">
                            @foreach($question->choices as $index => $choice)
                                <div class="choice-group" data-index="{{ $index }}">
                                    <div class="choice-input-group">
                                        <input type="text" name="choices[{{ $index }}][content]" value="{{ old('choices.'.$index.'.content', $choice->content) }}" placeholder="Nhập đáp án..." required>
                                        <label class="choice-correct-label">
                                            <input type="radio" name="correct_answer" value="{{ $index }}" {{ old('choices.'.$index.'.is_correct', $choice->is_correct) ? 'checked' : '' }}>
                                            <span>Đúng</span>
                                        </label>
                                        <button type="button" class="btn-remove-choice" onclick="removeChoice(this)">🗑️</button>
                                    </div>
                                    <input type="hidden" name="choices[{{ $index }}][is_correct]" value="{{ old('choices.'.$index.'.is_correct', $choice->is_correct) ? '1' : '0' }}">
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addChoice()">+ Thêm đáp án</button>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('topics.show', $question->topic) }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Cập nhật câu hỏi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<script>
let choiceIndex = {{ count($question->choices) }};

function addChoice() {
    const container = document.getElementById('choicesContainer');
    const choiceGroup = document.createElement('div');
    choiceGroup.className = 'choice-group';
    choiceGroup.setAttribute('data-index', choiceIndex);
    
    choiceGroup.innerHTML = `
        <div class="choice-input-group">
            <input type="text" name="choices[${choiceIndex}][content]" placeholder="Nhập đáp án..." required>
            <label class="choice-correct-label">
                <input type="radio" name="correct_answer" value="${choiceIndex}">
                <span>Đúng</span>
            </label>
            <button type="button" class="btn-remove-choice" onclick="removeChoice(this)">🗑️</button>
        </div>
        <input type="hidden" name="choices[${choiceIndex}][is_correct]" value="0">
    `;
    
    container.appendChild(choiceGroup);
    choiceIndex++;
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
    }
});
</script>
</body>
</html>