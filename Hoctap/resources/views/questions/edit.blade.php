<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa câu hỏi</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
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

<style>
.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}

.header-section {
    margin-bottom: 30px;
}

.breadcrumb {
    font-size: 14px;
    color: #666;
}

.breadcrumb a {
    color: #667eea;
    text-decoration: none;
}

.content-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 30px;
}

.form-container h1 {
    margin-bottom: 30px;
    color: #333;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}

.form-group textarea {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box;
    resize: vertical;
}

.form-group textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
}

.choices-section {
    margin-bottom: 30px;
}

.choices-section h3 {
    margin-bottom: 15px;
    color: #333;
}

.choice-group {
    margin-bottom: 15px;
}

.choice-input-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.choice-input-group input[type="text"] {
    flex: 1;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.choice-correct-label {
    display: flex;
    align-items: center;
    gap: 5px;
    background: #f8f9fa;
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px solid #ddd;
    cursor: pointer;
    min-width: 70px;
}

.choice-correct-label input[type="radio"] {
    margin: 0;
}

.choice-correct-label:has(input:checked) {
    background: #d4edda;
    border-color: #28a745;
    color: #155724;
}

.btn-remove-choice {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
}

.btn-remove-choice:hover {
    background: #c82333;
}

.form-actions {
    margin-top: 30px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.btn {
    padding: 12px 24px;
    border-radius: 4px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    display: inline-block;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-primary:hover {
    background: #5a6fd8;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.alert {
    padding: 16px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}
</style>

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