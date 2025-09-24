<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thư viện</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <div class="logo-icon">T</div>
                <div class="logo-text">Thư viện</div>
            </div>
            <nav class="nav-menu">
                <a href="#" class="nav-item active">
                    <div class="icon">🏠</div>
                    <span>Trang chủ</span>
                </a>
                <a href="#" class="nav-item">
                    <div class="icon">⏱️</div>
                    <span>Trước đây đã sử dụng</span>
                </a>
                <a href="#" class="nav-item">
                    <div class="icon">📊</div>
                    <span>Thống kê</span>
                </a>
            </nav>
            
            <div class="progress-section">
                <div class="progress-header">
                    <div class="progress-icon">⚡</div>
                    <div class="progress-text">11/20 hoạt động được tạo ra</div>
                </div>
            </div>
        </aside>
        
        <main class="main-content">
            <header class="header">
                <div class="search-bar">
                    <div class="search-icon">🔍</div>
                    <input type="text" class="search-input" placeholder="Tìm kiếm theo tên hoạt động">
                </div>
                
                <div class="header-actions">
                    <button class="help-btn">🙋 Nhận trợ giúp</button>
                    <div class="user-menu" onclick="toggleUserMenu()">
                        <span>{{ substr($user->usergmail ?? 'User', 0, 2) }}</span>
                        <div class="user-dropdown" id="userDropdown">
                            <div class="user-info">
                                <div class="user-avatar">{{ substr($user->usergmail ?? 'User', 0, 2) }}</div>
                                <div class="user-details">
                                    <div class="user-name">{{ $user->usergmail ?? 'User' }}</div>
                                    <div class="user-email">{{ $user->usergmail ?? '' }}</div>
                                </div>
                            </div>
                            <hr style="margin: 8px 0; border: none; border-top: 1px solid #eee;">
                            <form method="POST" action="{{ route('signout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="logout-btn">Đăng xuất</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <div class="content-area">
                <div class="content-header">
                    <h1 class="page-title">Được tạo bởi tôi</h1>
                    <a href="{{ route('cauhoi.create') }}" class="create-new-btn">
                        <span>+</span>
                        Tạo mới
                    </a>
                </div>
                
                <div class="tabs">
                    <button class="tab active">Created ({{ $topics->count() }})</button>
                    <button class="tab">Draft (0)</button>
                    <button class="tab">Archived (0)</button>
                </div>
                
                <div class="content-controls">
                    <div class="view-controls">
                        <label class="select-all">
                            <input type="checkbox"> Chi tiết hoạt động
                        </label>
                    </div>
                    <select class="sort-dropdown">
                        <option>Thời gian tạo</option>
                        <option>Tên hoạt động</option>
                        <option>Lần cập nhật cuối</option>
                    </select>
                </div>

                <div class="activities-list">
                    @if($topics->count() > 0)
                        @foreach($topics as $topic)
                            <div class="activity-item">
                                <input type="checkbox" class="activity-checkbox">
                                <div class="activity-icon">📊</div>
                                <div class="activity-content">
                                    <div class="activity-title">
                                        <a href="{{ route('topics.show', $topic) }}" class="topic-link">{{ $topic->name }}</a>
                                    </div>
                                    <div class="activity-meta">
                                        <span>🌟</span>
                                        <span>{{ $topic->questions_count }} Qs</span>
                                        <span>•</span>
                                        <span>{{ $topic->slug }}</span>
                                        <span>•</span>
                                        <span>Học tập</span>
                                    </div>
                                </div>
                                <div class="activity-stats">
                                    <div class="activity-time">{{ $topic->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="activity-actions">
                                    <a href="{{ route('topics.show', $topic) }}" class="action-btn primary">👁️ Xem</a>
                                    <a href="{{ route('topics.edit', $topic) }}" class="action-btn">✏️ Sửa</a>
                                    <button class="action-btn danger" onclick="deleteTopic({{ $topic->id }})">🗑️ Xóa</button>
                                    <div class="dropdown">
                                        <button class="action-btn" onclick="toggleDropdown({{ $topic->id }})">⋯</button>
                                        <div class="dropdown-content" id="dropdown-{{ $topic->id }}">
                                            <a href="{{ route('topics.show', $topic) }}">Chi tiết chủ đề</a>
                                            <a href="{{ route('questions.create') }}?topic_id={{ $topic->id }}">Thêm câu hỏi</a>
                                            <a href="{{ route('topics.edit', $topic) }}">Chỉnh sửa</a>
                                            <button onclick="duplicateTopic({{ $topic->id }})">Nhân bản</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state" style="text-align: center; padding: 40px; color: #666;">
                            <div style="font-size: 48px; margin-bottom: 16px;">📝</div>
                            <h3>Chưa có chủ đề nào</h3>
                            <p>Hãy tạo chủ đề đầu tiên của bạn!</p>
                            <a href="{{ route('cauhoi.create') }}" style="margin-top: 16px; display: inline-block; padding: 12px 24px; background: #667eea; color: white; text-decoration: none; border-radius: 8px;">Tạo ngay</a>
                        </div>
                    @endif
                </div>

                <!-- Modal xác nhận xóa -->
                <div class="modal" id="deleteModal">
                    <div class="modal-content">
                        <h3>Xác nhận xóa</h3>
                        <p>Bạn có chắc chắn muốn xóa chủ đề này? Tất cả câu hỏi và đáp án sẽ bị xóa vĩnh viễn.</p>
                        <div class="modal-actions">
                            <button class="btn btn-secondary" onclick="closeDeleteModal()">Hủy</button>
                            <form id="deleteForm" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

<style>
/* CRUD Styles */
.topic-link {
    color: #333;
    text-decoration: none;
    font-weight: bold;
}

.topic-link:hover {
    color: #667eea;
}

.action-btn {
    padding: 6px 12px;
    margin: 0 2px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 4px;
    text-decoration: none;
    color: #333;
    font-size: 12px;
    cursor: pointer;
    display: inline-block;
}

.action-btn.primary {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.action-btn.danger {
    background: #e74c3c;
    color: white;
    border-color: #e74c3c;
}

.action-btn:hover {
    opacity: 0.8;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background: white;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    border-radius: 4px;
    z-index: 1;
}

.dropdown-content.show {
    display: block;
}

.dropdown-content a, .dropdown-content button {
    color: black;
    padding: 8px 16px;
    text-decoration: none;
    display: block;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.dropdown-content a:hover, .dropdown-content button:hover {
    background-color: #f1f1f1;
}

/* Modal styles */
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
    width: 400px;
}

.modal-actions {
    margin-top: 20px;
    text-align: right;
}

.btn {
    padding: 8px 16px;
    margin-left: 8px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-danger {
    background: #e74c3c;
    color: white;
}
</style>

<script>
function toggleUserMenu() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('show');
}

// Đóng dropdown khi click bên ngoài
document.addEventListener('click', function(event) {
    const userMenu = document.querySelector('.user-menu');
    const dropdown = document.getElementById('userDropdown');
    
    if (!userMenu.contains(event.target)) {
        dropdown.classList.remove('show');
    }
});

// CRUD Functions
function toggleDropdown(topicId) {
    const dropdown = document.getElementById('dropdown-' + topicId);
    dropdown.classList.toggle('show');
}

function deleteTopic(topicId) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = '/topics/' + topicId;
    modal.style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

function duplicateTopic(topicId) {
    if (confirm('Bạn có muốn nhân bản chủ đề này không?')) {
        // TODO: Implement duplicate functionality
        alert('Tính năng nhân bản sẽ được phát triển sau!');
    }
}

// Đóng dropdown khi click bên ngoài
document.addEventListener('click', function(event) {
    const dropdowns = document.querySelectorAll('.dropdown-content');
    dropdowns.forEach(dropdown => {
        if (!dropdown.parentElement.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });
});

// Đóng modal khi click bên ngoài
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target == modal) {
        closeDeleteModal();
    }
}
</script>
</body>
</html> 