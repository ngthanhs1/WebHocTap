<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $topic->name }} - Chi tiết chủ đề</title>
    <link rel="stylesheet" href="{{ asset('css/styles4.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="modern-body">
    <div class="modern-container">
        <!-- Header Section -->
        <div class="modern-header">
            <div class="breadcrumb-modern">
                <a href="{{ route('trangchinh') }}" class="breadcrumb-link">
                    <i class="fas fa-arrow-left"></i>
                    <span>Quay lại trang chính</span>
                </a>
            </div>
            <div class="topic-hero">
                <div class="topic-hero-content">
                    <div class="topic-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="topic-info">
                        <h1 class="topic-title">{{ $topic->name }}</h1>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <i class="fas fa-question-circle"></i>
                                <span>{{ $topic->questions->count() }} câu hỏi</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ $topic->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-user"></i>
                                <span>{{ $topic->user->username ?? 'Admin' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="topic-actions-modern">
                    <a href="{{ route('topics.edit', $topic) }}" class="btn-modern btn-primary">
                        <i class="fas fa-edit"></i>
                        <span>Sửa chủ đề</span>
                    </a>
                    <a href="{{ route('questions.create') }}?topic_id={{ $topic->id }}" class="btn-modern btn-success">
                        <i class="fas fa-plus"></i>
                        <span>Thêm câu hỏi</span>
                    </a>
                    <button onclick="deleteTopic({{ $topic->id }})" class="btn-modern btn-danger">
                        <i class="fas fa-trash"></i>
                        <span>Xóa chủ đề</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section-modern">
            @if (session('ok') || session('success'))
                <div class="alert-modern alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('ok') ?? session('success') }}</span>
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert-modern alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($topic->questions->count() > 0)
                <div class="questions-container">
                    <div class="section-header">
                        <h2>Danh sách câu hỏi</h2>
                        <div class="questions-count">{{ $topic->questions->count() }} câu hỏi</div>
                    </div>
                    
                    <div class="questions-grid">
                        @foreach($topic->questions as $index => $question)
                            <div class="question-card-modern" data-question-id="{{ $question->id }}">
                                <div class="question-header-modern">
                                    <div class="question-number">
                                        <span>{{ $index + 1 }}</span>
                                    </div>
                                    <div class="question-content">
                                        <h3>{{ $question->content }}</h3>
                                        <div class="question-meta">
                                            <span><i class="fas fa-list"></i> {{ $question->choices->count() }} đáp án</span>
                                            <span><i class="fas fa-clock"></i> {{ $question->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="question-actions-modern">
                                        <button onclick="toggleQuestion({{ $question->id }})" class="btn-icon" title="Xem/Ẩn đáp án">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('questions.edit', $question) }}" class="btn-icon btn-edit" title="Sửa câu hỏi">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="deleteQuestion({{ $question->id }})" class="btn-icon btn-delete" title="Xóa câu hỏi">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="choices-container" id="choices-{{ $question->id }}">
                                    <div class="choices-header">
                                        <h4>Đáp án:</h4>
                                        <button onclick="addChoice({{ $question->id }})" class="btn-add-choice">
                                            <i class="fas fa-plus"></i>
                                            <span>Thêm đáp án</span>
                                        </button>
                                    </div>
                                    
                                    <div class="choices-list-modern">
                                        @foreach($question->choices as $choiceIndex => $choice)
                                            <div class="choice-item-modern {{ $choice->is_correct ? 'correct' : 'incorrect' }}">
                                                <div class="choice-indicator-modern">
                                                    @if($choice->is_correct)
                                                        <i class="fas fa-check-circle"></i>
                                                    @else
                                                        <i class="fas fa-times-circle"></i>
                                                    @endif
                                                </div>
                                                <div class="choice-letter">{{ chr(65 + $choiceIndex) }}</div>
                                                <div class="choice-text">{{ $choice->content }}</div>
                                                <div class="choice-actions-modern">
                                                    <button onclick="editChoice({{ $choice->id }}, '{{ $choice->content }}', {{ $choice->is_correct ? 'true' : 'false' }})" class="btn-icon-small" title="Sửa đáp án">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button onclick="deleteChoice({{ $choice->id }})" class="btn-icon-small btn-delete" title="Xóa đáp án">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="empty-state-modern">
                    <div class="empty-illustration">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h3>Chưa có câu hỏi nào</h3>
                    <p>Hãy tạo câu hỏi đầu tiên để bắt đầu xây dựng bộ đề của bạn!</p>
                    <a href="{{ route('questions.create') }}?topic_id={{ $topic->id }}" class="btn-modern btn-primary btn-large">
                        <i class="fas fa-plus"></i>
                        <span>Tạo câu hỏi đầu tiên</span>
                    </a>
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

<script>
// Toggle question visibility
function toggleQuestion(questionId) {
    const choicesContainer = document.getElementById('choices-' + questionId);
    const toggleBtn = event.target.closest('.btn-icon');
    const icon = toggleBtn.querySelector('i');
    
    if (choicesContainer.style.display === 'none' || !choicesContainer.style.display) {
        choicesContainer.style.display = 'block';
        icon.className = 'fas fa-eye-slash';
        toggleBtn.title = 'Ẩn đáp án';
    } else {
        choicesContainer.style.display = 'none';
        icon.className = 'fas fa-eye';
        toggleBtn.title = 'Xem đáp án';
    }
}

// Delete topic with modern confirm
function deleteTopic(topicId) {
    if (confirm('⚠️ Bạn có chắc chắn muốn xóa chủ đề này?\n\nTất cả câu hỏi và đáp án sẽ bị xóa vĩnh viễn và không thể khôi phục.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/topics/' + topicId;
        
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

// Delete question with modern confirm
function deleteQuestion(questionId) {
    if (confirm('🗑️ Bạn có chắc chắn muốn xóa câu hỏi này?\n\nTất cả đáp án của câu hỏi này cũng sẽ bị xóa.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/questions/' + questionId;
        
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

// Add choice with modern modal
function addChoice(questionId) {
    const modal = document.getElementById('choiceModal');
    const form = document.getElementById('choiceForm');
    const title = document.getElementById('choiceModalTitle');
    
    title.textContent = '➕ Thêm đáp án mới';
    form.action = '/questions/' + questionId + '/choices';
    form.method = 'POST';
    
    // Reset form
    document.getElementById('choiceContent').value = '';
    document.getElementById('choiceCorrect').checked = false;
    
    // Remove method input if exists
    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) {
        methodInput.remove();
    }
    
    modal.style.display = 'block';
    
    // Focus on input
    setTimeout(() => {
        document.getElementById('choiceContent').focus();
    }, 100);
}

// Edit choice with modern modal
function editChoice(choiceId, content, isCorrect) {
    const modal = document.getElementById('choiceModal');
    const form = document.getElementById('choiceForm');
    const title = document.getElementById('choiceModalTitle');
    
    title.textContent = '✏️ Sửa đáp án';
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
    
    // Focus and select text
    setTimeout(() => {
        const input = document.getElementById('choiceContent');
        input.focus();
        input.select();
    }, 100);
}

// Delete choice with modern confirm
function deleteChoice(choiceId) {
    if (confirm('🗑️ Bạn có chắc chắn muốn xóa đáp án này?')) {
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

// Close modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Enhanced modal interactions
document.addEventListener('DOMContentLoaded', function() {
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
    }
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (modal.style.display === 'block') {
                    modal.style.display = 'none';
                }
            });
        }
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-modern');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
    
    // Initialize choices visibility (collapsed by default)
    const choicesContainers = document.querySelectorAll('.choices-container');
    choicesContainers.forEach(container => {
        container.style.display = 'none';
    });
});

// Smooth scroll to question when added/edited
function scrollToQuestion(questionId) {
    const questionCard = document.querySelector(`[data-question-id="${questionId}"]`);
    if (questionCard) {
        questionCard.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
        questionCard.style.transform = 'scale(1.02)';
        setTimeout(() => {
            questionCard.style.transform = 'scale(1)';
        }, 200);
    }
}</script>
</script>
</body>
</html>