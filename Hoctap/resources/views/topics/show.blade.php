<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $topic->name }} - Chi tiết chủ đề</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="breadcrumb">
                <a href="{{ route('trangchinh') }}">← Quay lại trang chính</a>
            </div>
            <div class="topic-header">
                <h1>{{ $topic->name }}</h1>
                <div class="topic-meta">
                    <span>📊 {{ $topic->questions->count() }} câu hỏi</span>
                    <span>•</span>
                    <span>{{ $topic->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="topic-actions">
                    <a href="{{ route('topics.edit', $topic) }}" class="btn btn-primary">✏️ Sửa chủ đề</a>
                    <a href="{{ route('questions.create') }}?topic_id={{ $topic->id }}" class="btn btn-success">+ Thêm câu hỏi</a>
                    <button onclick="deleteTopic({{ $topic->id }})" class="btn btn-danger">🗑️ Xóa chủ đề</button>
                </div>
            </div>
        </div>

        <div class="content-section">
            @if (session('ok'))
                <div class="alert alert-success">{{ session('ok') }}</div>
            @endif

            @if ($topic->questions->count() > 0)
                <div class="questions-list">
                    @foreach($topic->questions as $index => $question)
                        <div class="question-card">
                            <div class="question-header">
                                <h3>Câu {{ $index + 1 }}: {{ $question->content }}</h3>
                                <div class="question-actions">
                                    <a href="{{ route('questions.edit', $question) }}" class="btn-small btn-primary">✏️ Sửa</a>
                                    <button onclick="deleteQuestion({{ $question->id }})" class="btn-small btn-danger">🗑️ Xóa</button>
                                </div>
                            </div>
                            <div class="choices-list">
                                @foreach($question->choices as $choice)
                                    <div class="choice-item {{ $choice->is_correct ? 'correct' : '' }}">
                                        <span class="choice-indicator">{{ $choice->is_correct ? '✓' : '○' }}</span>
                                        <span class="choice-content">{{ $choice->content }}</span>
                                        <div class="choice-actions">
                                            <button onclick="editChoice({{ $choice->id }}, '{{ $choice->content }}', {{ $choice->is_correct ? 'true' : 'false' }})" class="btn-small">✏️</button>
                                            <button onclick="deleteChoice({{ $choice->id }})" class="btn-small btn-danger">🗑️</button>
                                        </div>
                                    </div>
                                @endforeach
                                <button onclick="addChoice({{ $question->id }})" class="btn-small btn-success">+ Thêm đáp án</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">❓</div>
                    <h3>Chưa có câu hỏi nào</h3>
                    <p>Hãy thêm câu hỏi đầu tiên cho chủ đề này!</p>
                    <a href="{{ route('questions.create') }}?topic_id={{ $topic->id }}" class="btn btn-primary">+ Thêm câu hỏi</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal xác nhận xóa chủ đề -->
    <div class="modal" id="deleteTopicModal">
        <div class="modal-content">
            <h3>Xác nhận xóa chủ đề</h3>
            <p>Bạn có chắc chắn muốn xóa chủ đề này? Tất cả câu hỏi và đáp án sẽ bị xóa vĩnh viễn.</p>
            <div class="modal-actions">
                <button class="btn btn-secondary" onclick="closeModal('deleteTopicModal')">Hủy</button>
                <form id="deleteTopicForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal xác nhận xóa câu hỏi -->
    <div class="modal" id="deleteQuestionModal">
        <div class="modal-content">
            <h3>Xác nhận xóa câu hỏi</h3>
            <p>Bạn có chắc chắn muốn xóa câu hỏi này?</p>
            <div class="modal-actions">
                <button class="btn btn-secondary" onclick="closeModal('deleteQuestionModal')">Hủy</button>
                <form id="deleteQuestionForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal sửa/thêm đáp án -->
    <div class="modal" id="choiceModal">
        <div class="modal-content">
            <h3 id="choiceModalTitle">Thêm đáp án</h3>
            <form id="choiceForm" method="POST">
                @csrf
                <div class="form-group">
                    <label for="choiceContent">Nội dung đáp án:</label>
                    <input type="text" id="choiceContent" name="content" required>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="choiceCorrect" name="is_correct" value="1">
                        Đây là đáp án đúng
                    </label>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('choiceModal')">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.header-section {
    margin-bottom: 30px;
}

.breadcrumb a {
    color: #667eea;
    text-decoration: none;
    font-size: 14px;
}

.topic-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-top: 10px;
}

.topic-meta {
    color: #666;
    font-size: 14px;
}

.topic-actions {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-size: 14px;
}

.btn-primary { background: #667eea; color: white; }
.btn-success { background: #28a745; color: white; }
.btn-danger { background: #dc3545; color: white; }
.btn-secondary { background: #6c757d; color: white; }

.btn-small {
    padding: 4px 8px;
    font-size: 12px;
    border-radius: 3px;
    border: none;
    cursor: pointer;
    margin: 0 2px;
}

.questions-list {
    space-y: 20px;
}

.question-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
}

.question-header h3 {
    margin: 0;
    font-size: 16px;
}

.choices-list {
    padding: 20px;
}

.choice-item {
    display: flex;
    align-items: center;
    padding: 10px;
    margin-bottom: 8px;
    border-radius: 4px;
    background: #f8f9fa;
}

.choice-item.correct {
    background: #d4edda;
    border-left: 4px solid #28a745;
}

.choice-indicator {
    margin-right: 10px;
    font-weight: bold;
    color: #28a745;
}

.choice-content {
    flex: 1;
}

.choice-actions {
    display: flex;
    gap: 5px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 8px;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 16px;
}

.alert {
    padding: 12px 16px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border-radius: 8px;
    width: 500px;
    max-width: 90%;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input[type="text"] {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.modal-actions {
    margin-top: 20px;
    text-align: right;
}
</style>

<script>
function deleteTopic(topicId) {
    const modal = document.getElementById('deleteTopicModal');
    const form = document.getElementById('deleteTopicForm');
    form.action = '/topics/' + topicId;
    modal.style.display = 'block';
}

function deleteQuestion(questionId) {
    const modal = document.getElementById('deleteQuestionModal');
    const form = document.getElementById('deleteQuestionForm');
    form.action = '/questions/' + questionId;
    modal.style.display = 'block';
}

function addChoice(questionId) {
    const modal = document.getElementById('choiceModal');
    const form = document.getElementById('choiceForm');
    const title = document.getElementById('choiceModalTitle');
    
    title.textContent = 'Thêm đáp án';
    form.action = '/questions/' + questionId + '/choices';
    form.method = 'POST';
    
    // Reset form
    document.getElementById('choiceContent').value = '';
    document.getElementById('choiceCorrect').checked = false;
    
    modal.style.display = 'block';
}

function editChoice(choiceId, content, isCorrect) {
    const modal = document.getElementById('choiceModal');
    const form = document.getElementById('choiceForm');
    const title = document.getElementById('choiceModalTitle');
    
    title.textContent = 'Sửa đáp án';
    form.action = '/choices/' + choiceId;
    
    // Add method spoofing for PUT
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        form.appendChild(methodInput);
    }
    methodInput.value = 'PUT';
    
    // Set form values
    document.getElementById('choiceContent').value = content;
    document.getElementById('choiceCorrect').checked = isCorrect;
    
    modal.style.display = 'block';
}

function deleteChoice(choiceId) {
    if (confirm('Bạn có chắc chắn muốn xóa đáp án này?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/choices/' + choiceId;
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Đóng modal khi click bên ngoài
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}
</script>
</body>
</html>