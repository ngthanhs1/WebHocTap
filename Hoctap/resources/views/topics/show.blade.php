<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $topic->name }} - Chi tiết chủ đề</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles4.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <div class="nav-content">
                <a href="{{ route('trangchinh') }}" class="nav-back">
                    <i class="fas fa-arrow-left"></i>
                    <span>Quay lại</span>
                </a>
                <div class="nav-title">
                    <i class="fas fa-book-open"></i>
                    <span>Quản lý chủ đề</span>
                </div>
            </div>
        </nav>

        <!-- Main Dashboard Content -->
        <div class="dashboard-main">
            <!-- Topic Overview Card -->
            <div class="topic-overview-card">
                <div class="topic-header">
                    <div class="topic-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="topic-info">
                        <h1 class="topic-title">{{ $topic->name }}</h1>
                        <div class="topic-meta">
                            <span class="meta-item">
                                <i class="fas fa-user"></i>
                                {{ $topic->user->username ?? 'Admin' }}
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-calendar"></i>
                                {{ $topic->created_at->format('d/m/Y') }}
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-question-circle"></i>
                                {{ $topic->questions->count() }} câu hỏi
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="quick-actions">
                    <a href="{{ route('topics.study', $topic) }}" class="action-btn primary">
                        <i class="fas fa-book-reader"></i>
                        <span>Ôn tập</span>
                    </a>
                    <a href="{{ route('topics.test', $topic) }}" class="action-btn success">
                        <i class="fas fa-play"></i>
                        <span>Làm bài</span>
                    </a>
                    <a href="{{ route('questions.create') }}?topic_id={{ $topic->id }}" class="action-btn info">
                        <i class="fas fa-plus"></i>
                        <span>Thêm câu hỏi</span>
                    </a>
                    <a href="{{ route('topics.edit', $topic) }}" class="action-btn warning">
                        <i class="fas fa-edit"></i>
                        <span>Chỉnh sửa</span>
                    </a>
                    <button onclick="deleteTopic({{ $topic->id }})" class="action-btn danger">
                        <i class="fas fa-trash"></i>
                        <span>Xóa</span>
                    </button>
                </div>
            </div>

            <!-- Status Messages -->
            @if (session('ok') || session('success'))
                <div class="status-message success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('ok') ?? session('success') }}</span>
                </div>
            @endif
            
            @if (session('error'))
                <div class="status-message error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Questions Management -->
            <div class="questions-section">
                <div class="section-header">
                    <h2>
                        <i class="fas fa-list-ul"></i>
                        Danh sách câu hỏi
                    </h2>
                    <div class="section-stats">
                        <span class="questions-count">{{ $topic->questions->count() }} câu hỏi</span>
                    </div>
                </div>

                @if ($topic->questions->count() > 0)
                    <div class="questions-grid">
                        @foreach($topic->questions as $index => $question)
                            <div class="question-card" data-question-id="{{ $question->id }}">
                                <div class="question-card-header">
                                    <div class="question-number">
                                        <span>Câu {{ $index + 1 }}</span>
                                    </div>
                                    <div class="question-actions-menu">
                                        <button class="menu-toggle" onclick="toggleQuestionMenu({{ $question->id }})">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="actions-dropdown" id="menu-{{ $question->id }}">
                                            <button onclick="toggleAnswers({{ $question->id }})" class="action-item">
                                                <i class="fas fa-eye"></i>
                                                <span>Xem đáp án</span>
                                            </button>
                                            <a href="{{ route('questions.edit', $question) }}" class="action-item">
                                                <i class="fas fa-edit"></i>
                                                <span>Chỉnh sửa</span>
                                            </a>
                                            <button onclick="deleteQuestion({{ $question->id }})" class="action-item danger">
                                                <i class="fas fa-trash"></i>
                                                <span>Xóa câu hỏi</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="question-content">
                                    <p class="question-text">{{ $question->content }}</p>
                                </div>
                                
                                <div class="question-answers" id="answers-{{ $question->id }}" style="display: none;">
                                    <div class="answers-header">
                                        <span>Các lựa chọn:</span>
                                        <button onclick="addChoice({{ $question->id }})" class="add-choice-btn">
                                            <i class="fas fa-plus"></i>
                                            Thêm đáp án
                                        </button>
                                    </div>
                                    <div class="choices-list">
                                        @foreach($question->choices as $choiceIndex => $choice)
                                            <div class="choice-item {{ $choice->is_correct ? 'correct' : '' }}">
                                                <div class="choice-indicator">
                                                    @if($choice->is_correct)
                                                        <i class="fas fa-check-circle"></i>
                                                    @else
                                                        <i class="fas fa-circle"></i>
                                                    @endif
                                                </div>
                                                <div class="choice-letter">{{ chr(65 + $choiceIndex) }}</div>
                                                <div class="choice-text">{{ $choice->content }}</div>
                                                <div class="choice-actions">
                                                    <button onclick="editChoice({{ $choice->id }}, '{{ $choice->content }}', {{ $choice->is_correct ? 'true' : 'false' }})" class="choice-action edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button onclick="deleteChoice({{ $choice->id }})" class="choice-action delete">
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
                @else
                    <div class="empty-questions">
                        <div class="empty-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h3>Chưa có câu hỏi nào</h3>
                        <p>Hãy tạo câu hỏi đầu tiên để bắt đầu xây dựng bộ đề của bạn!</p>
                        <a href="{{ route('questions.create') }}?topic_id={{ $topic->id }}" class="create-first-btn">
                            <i class="fas fa-plus"></i>
                            Tạo câu hỏi đầu tiên
                        </a>
                    </div>
                @endif
            </div>
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
// Toggle question menu
function toggleQuestionMenu(questionId) {
    const menu = document.getElementById('menu-' + questionId);
    const allMenus = document.querySelectorAll('.actions-dropdown');
    
    // Close all other menus
    allMenus.forEach(m => {
        if (m.id !== 'menu-' + questionId) {
            m.classList.remove('active');
        }
    });
    
    // Toggle current menu
    menu.classList.toggle('active');
}

// Toggle answers visibility
function toggleAnswers(questionId) {
    const answersContainer = document.getElementById('answers-' + questionId);
    const isVisible = answersContainer.style.display !== 'none';
    
    if (isVisible) {
        answersContainer.style.display = 'none';
    } else {
        answersContainer.style.display = 'block';
    }
    
    // Close menu after action
    document.getElementById('menu-' + questionId).classList.remove('active');
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
}

// Enhanced interactions
document.addEventListener('DOMContentLoaded', function() {
    // Close menus when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.question-actions-menu')) {
            document.querySelectorAll('.actions-dropdown').forEach(menu => {
                menu.classList.remove('active');
            });
        }
    });

    // Auto-hide status messages
    const statusMessages = document.querySelectorAll('.status-message');
    statusMessages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => {
                message.remove();
            }, 300);
        }, 5000);
    });

    // Question card animations
    const questionCards = document.querySelectorAll('.question-card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });

    questionCards.forEach(card => {
        observer.observe(card);
    });

    // Action buttons hover effects
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
</body>
</html>