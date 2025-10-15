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
                <a href="{{ route('thongke') }}" class="nav-item">
                    <div class="icon">📊</div>
                    <span>Thống kê</span>
                </a>
            </nav>
            <!-- Account section pinned bottom-left -->
            <div class="sidebar-account" style="display: flex; align-items: center; gap: 12px;">
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
                    </div>
                </div>
                <form method="POST" action="{{ route('signout') }}" class="logout-quick-form" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-quick-btn" style="height: 44px; display: flex; align-items: center;">Đăng xuất</button>
                </form>
            </div>
        </aside>
        
        <main class="main-content">
            <header class="header">
                                <div class="search-bar">
                                        <div id="poda">
                                            <div id="main">
                                                <input id="searchInput" placeholder="Tìm kiếm theo tên chủ đề..." type="text" name="text" class="input" onkeyup="searchTopics()" />
                                                <div id="input-mask"></div>
                                                <div id="pink-mask"></div>
                                                <div class="filterBorder"></div>
                                                <div id="filter-icon" aria-hidden="true">
                                                    <svg preserveAspectRatio="none" height="27" width="27" viewBox="4.8 4.56 14.832 15.408" fill="none">
                                                        <path d="M8.16 6.65002H15.83C16.47 6.65002 16.99 7.17002 16.99 7.81002V9.09002C16.99 9.56002 16.7 10.14 16.41 10.43L13.91 12.64C13.56 12.93 13.33 13.51 13.33 13.98V16.48C13.33 16.83 13.1 17.29 12.81 17.47L12 17.98C11.24 18.45 10.2 17.92 10.2 16.99V13.91C10.2 13.5 9.97 12.98 9.73 12.69L7.52 10.36C7.23 10.08 7 9.55002 7 9.20002V7.87002C7 7.17002 7.52 6.65002 8.16 6.65002Z" stroke="#d6d6e6" stroke-width="1" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </div>
                                                <div id="search-icon" aria-hidden="true">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" height="24" fill="none" class="feather feather-search">
                                                        <circle stroke="url(#search)" r="8" cy="11" cx="11"></circle>
                                                        <line stroke="url(#searchl)" y2="16.65" y1="22" x2="16.65" x1="22"></line>
                                                        <defs>
                                                            <linearGradient gradientTransform="rotate(50)" id="search">
                                                                <stop stop-color="#f8e7f8" offset="0%"></stop>
                                                                <stop stop-color="#b6a9b7" offset="50%"></stop>
                                                            </linearGradient>
                                                            <linearGradient id="searchl">
                                                                <stop stop-color="#b6a9b7" offset="0%"></stop>
                                                                <stop stop-color="#837484" offset="50%"></stop>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                
                                <div class="header-actions">
                                        <label class="theme-switch" title="Chuyển đổi nền">
                                            <input type="checkbox" class="theme-switch__checkbox" />
                                            <div class="theme-switch__container">
                                                <div class="theme-switch__clouds"></div>
                                                <div class="theme-switch__stars-container">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144 55" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M135.831 3.00688C135.055 3.85027 134.111 4.29946 133 4.35447C134.111 4.40947 135.055 4.85867 135.831 5.71123C136.607 6.55462 136.996 7.56303 136.996 8.72727C136.996 7.95722 137.172 7.25134 137.525 6.59129C137.886 5.93124 138.372 5.39954 138.98 5.00535C139.598 4.60199 140.268 4.39114 141 4.35447C139.88 4.2903 138.936 3.85027 138.16 3.00688C137.384 2.16348 136.996 1.16425 136.996 0C136.996 1.16425 136.607 2.16348 135.831 3.00688ZM31 23.3545C32.1114 23.2995 33.0551 22.8503 33.8313 22.0069C34.6075 21.1635 34.9956 20.1642 34.9956 19C34.9956 20.1642 35.3837 21.1635 36.1599 22.0069C36.9361 22.8503 37.8798 23.2903 39 23.3545C38.2679 23.3911 37.5976 23.602 36.9802 24.0053C36.3716 24.3995 35.8864 24.9312 35.5248 25.5913C35.172 26.2513 34.9956 26.9572 34.9956 27.7273C34.9956 26.563 34.6075 25.5546 33.8313 24.7112C33.0551 23.8587 32.1114 23.4095 31 23.3545ZM0 36.3545C1.11136 36.2995 2.05513 35.8503 2.83131 35.0069C3.6075 34.1635 3.99559 33.1642 3.99559 32C3.99559 33.1642 4.38368 34.1635 5.15987 35.0069C5.93605 35.8503 6.87982 36.2903 8 36.3545C7.26792 36.3911 6.59757 36.602 5.98015 37.0053C5.37155 37.3995 4.88644 37.9312 4.52481 38.5913C4.172 39.2513 3.99559 39.9572 3.99559 40.7273C3.99559 39.563 3.6075 38.5546 2.83131 37.7112C2.05513 36.8587 1.11136 36.4095 0 36.3545ZM56.8313 24.0069C56.0551 24.8503 55.1114 25.2995 54 25.3545C55.1114 25.4095 56.0551 25.8587 56.8313 26.7112C57.6075 27.5546 57.9956 28.563 57.9956 29.7273C57.9956 28.9572 58.172 28.2513 58.5248 27.5913C58.8864 26.9312 59.3716 26.3995 59.9802 26.0053C60.5976 25.602 61.2679 25.3911 62 25.3545C60.8798 25.2903 59.9361 24.8503 59.1599 24.0069C58.3837 23.1635 57.9956 22.1642 57.9956 21C57.9956 22.1642 57.6075 23.1635 56.8313 24.0069ZM81 25.3545C82.1114 25.2995 83.0551 24.8503 83.8313 24.0069C84.6075 23.1635 84.9956 22.1642 84.9956 21C84.9956 22.1642 85.3837 23.1635 86.1599 24.0069C86.9361 24.8503 87.8798 25.2903 89 25.3545C88.2679 25.3911 87.5976 25.602 86.9802 26.0053C86.3716 26.3995 85.8864 26.9312 85.5248 27.5913C85.172 28.2513 84.9956 28.9572 84.9956 29.7273C84.9956 28.563 84.6075 27.5546 83.8313 26.7112C83.0551 25.8587 82.1114 25.4095 81 25.3545ZM136 36.3545C137.111 36.2995 138.055 35.8503 138.831 35.0069C139.607 34.1635 139.996 33.1642 139.996 32C139.996 33.1642 140.384 34.1635 141.16 35.0069C141.936 35.8503 142.88 36.2903 144 36.3545C143.268 36.3911 142.598 36.602 141.98 37.0053C141.372 37.3995 140.886 37.9312 140.525 38.5913C140.172 39.2513 139.996 39.9572 139.996 40.7273C139.996 39.563 139.607 38.5546 138.831 37.7112C138.055 36.8587 137.111 36.4095 136 36.3545ZM101.831 49.0069C101.055 49.8503 100.111 50.2995 99 50.3545C100.111 50.4095 101.055 50.8587 101.831 51.7112C102.607 52.5546 102.996 53.563 102.996 54.7273C102.996 53.9572 103.172 53.2513 103.525 52.5913C103.886 51.9312 104.372 51.3995 104.98 51.0053C105.598 50.602 106.268 50.3911 107 50.3545C105.88 50.2903 104.936 49.8503 104.16 49.0069C103.384 48.1635 102.996 47.1642 102.996 46C102.996 47.1642 102.607 48.1635 101.831 49.0069Z" fill="currentColor"></path>
                                                    </svg>
                                                </div>
                                                <div class="theme-switch__circle-container">
                                                    <div class="theme-switch__sun-moon-container">
                                                        <div class="theme-switch__moon">
                                                            <div class="theme-switch__spot"></div>
                                                            <div class="theme-switch__spot"></div>
                                                            <div class="theme-switch__spot"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
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
                    <button class="tab active">Đã tạo ({{ $topics->count() }})</button>
                </div>
                
                <div class="content-controls">
                    <div class="view-controls">
                        
                    </div>
                    <select class="sort-dropdown" onchange="onChangeSort(this.value)">
                        <option value="created_desc">Thời gian tạo (mới → cũ)</option>
                        <option value="created_asc">Thời gian tạo (cũ → mới)</option>
                        <option value="name_asc">Tên hoạt động (A → Z)</option>
                        <option value="updated_desc">Lần cập nhật cuối (mới nhất)</option>
                    </select>
                </div>

                <div class="activity-list">
                    <!-- Thông báo không tìm thấy kết quả -->
                    <div class="no-results" id="noResults">
                        <div style="font-size: 48px; margin-bottom: 16px;">🔍</div>
                        <h3>Không tìm thấy chủ đề nào</h3>
                        <p>Thử tìm kiếm với từ khóa khác</p>
                    </div>
                    
                    @if($topics->count() > 0)
                        @foreach($topics as $topic)
                            <div class="activity-item">
                                <input type="checkbox" class="activity-checkbox">
                                <div class="activity-content">
                                    <div class="activity-title">
                                        <a href="{{ route('topics.show', $topic) }}" class="topic-link">{{ $topic->name }}</a>
                                    </div>
                                    <div class="activity-meta">
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
                                    <button class="action-btn study" onclick="startStudy({{ $topic->id }})">
                                        <span>Ôn tập</span>
                                    </button>
                                    <button class="action-btn test" onclick="startTest({{ $topic->id }})">
                                        <span>Làm bài</span>
                                    </button>
                                    <div class="dropdown">
                                        <button class="action-btn dropdown-btn" onclick="toggleDropdown(event, {{ $topic->id }})">
                                            <i class="icon">⋯</i>
                                        </button>
                                        <div class="dropdown-content" id="dropdown-{{ $topic->id }}">
                                            <a href="{{ route('topics.show', $topic) }}" class="dropdown-item">
                                                <span>Chi tiết chủ đề</span>
                                            </a>
                                            <a href="{{ route('questions.create') }}?topic_id={{ $topic->id }}" class="dropdown-item">
                                                <span>Thêm câu hỏi</span>
                                            </a>
                                            <a href="{{ route('topics.edit', $topic) }}" class="dropdown-item">
                                                <span>Chỉnh sửa</span>
                                            </a>
                                            <hr class="dropdown-divider">
                                            <button onclick="deleteTopic({{ $topic->id }})" class="dropdown-item danger">
                                                <span>Xóa chủ đề</span>
                                            </button>
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
    padding: 8px 12px;
    margin: 0 3px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    font-size: 12px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s ease;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.action-btn .icon {
    font-size: 14px;
}

.action-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.action-btn.primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-color: #667eea;
}

.action-btn.secondary {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white;
    border-color: #f093fb;
}

.action-btn.study {
    background: linear-gradient(135deg, #4ecdc4, #44a08d);
    color: white;
    border-color: #4ecdc4;
}

.action-btn.test {
    background: linear-gradient(135deg, #ffa726, #ff9800);
    color: white;
    border-color: #ffa726;
}

.action-btn.dropdown-btn {
    background: #f8f9fa;
    border-color: #e9ecef;
    color: #6c757d;
    min-width: 40px;
    justify-content: center;
}

.action-btn.dropdown-btn:hover {
    background: #e9ecef;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    background: white;
    min-width: 200px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    border-radius: 12px;
    z-index: 1000;
    border: 1px solid #e9ecef;
    overflow: hidden;
    margin-top: 5px;
}

.dropdown-content.show {
    display: block;
    animation: dropdownShow 0.2s ease-out;
}

@keyframes dropdownShow {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-item {
    color: #333;
    padding: 12px 16px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    transition: background-color 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item.danger {
    color: #dc3545;
}

.dropdown-item.danger:hover {
    background-color: #fff5f5;
}

.dropdown-item .icon {
    font-size: 14px;
    width: 16px;
    text-align: center;
}

.dropdown-divider {
    margin: 8px 0;
    border: none;
    border-top: 1px solid #e9ecef;
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

/* Search styles */
.activity-item.hidden {
    display: none !important;
}

.no-results {
    text-align: center;
    padding: 40px;
    color: #666;
    display: none;
}

.no-results.show {
    display: block;
}

.search-highlight {
    background: linear-gradient(135deg, #ff6b9d, #f06292);
    color: white;
    padding: 2px 4px;
    border-radius: 3px;
    font-weight: bold;
}
</style>

<script>
// Đồng bộ sort hiện tại từ URL
document.addEventListener('DOMContentLoaded', function(){
    const params = new URLSearchParams(window.location.search);
    const sort = params.get('sort') || 'created_desc';
    const sel = document.querySelector('.sort-dropdown');
    if (sel) sel.value = sort;
});

function onChangeSort(val){
    const url = new URL(window.location.href);
    url.searchParams.set('sort', val);
    window.location.href = url.toString();
}
// Theme switch handling
document.addEventListener('DOMContentLoaded', function(){
    const checkbox = document.querySelector('.theme-switch__checkbox');
    const saved = localStorage.getItem('theme');
    if (saved === 'dark') {
        document.body.classList.add('dark-theme');
        if (checkbox) checkbox.checked = true;
    } else if (saved === 'light') {
        document.body.classList.remove('dark-theme');
        if (checkbox) checkbox.checked = false;
    }
    if (checkbox) {
        checkbox.addEventListener('change', function(){
            if (this.checked) {
                document.body.classList.add('dark-theme');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.classList.remove('dark-theme');
                localStorage.setItem('theme', 'light');
            }
        });
    }
});

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
function startStudy(topicId) {
    // Study mode - hiển thị câu hỏi và đáp án để ôn tập
    window.location.href = `/topics/${topicId}/study`;
}

function startTest(topicId) {
    // Test mode - bài kiểm tra không hiện đáp án
    window.location.href = `/topics/${topicId}/test`;
}

function toggleDropdown(event, topicId) {
    event.stopPropagation();
    
    // Đóng tất cả dropdown khác
    document.querySelectorAll('.dropdown-content').forEach(dropdown => {
        if (dropdown.id !== `dropdown-${topicId}`) {
            dropdown.classList.remove('show');
            dropdown.classList.remove('drop-up');
        }
    });
    
    // Toggle dropdown hiện tại
    const dropdown = document.getElementById(`dropdown-${topicId}`);
    dropdown.classList.toggle('show');

    // Sau khi hiển thị, kiểm tra nếu dropdown bị tràn ra ngoài viewport phía dưới
    if (dropdown.classList.contains('show')) {
        // reset trạng thái trước để đo chính xác
        dropdown.classList.remove('drop-up');
        const rect = dropdown.getBoundingClientRect();
        const spaceBelow = window.innerHeight - rect.top;
        const requiredHeight = rect.height || dropdown.scrollHeight || 200;
        if (spaceBelow < requiredHeight + 16) {
            // không đủ chỗ bên dưới -> mở lên trên
            dropdown.classList.add('drop-up');
        }
    }
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
    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-content').forEach(dropdown => {
            dropdown.classList.remove('show');
        });
    }
});

// Đóng modal khi click bên ngoài
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target == modal) {
        closeDeleteModal();
    }
}

// Chức năng tìm kiếm chủ đề
function searchTopics() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
    const activityItems = document.querySelectorAll('.activity-item');
    const noResults = document.getElementById('noResults');
    const tabCount = document.querySelector('.tab.active');
    
    let visibleCount = 0;
    let totalItems = activityItems.length;
    
    // Nếu không có từ khóa tìm kiếm, hiển thị tất cả
    if (searchTerm === '') {
        activityItems.forEach(item => {
            item.classList.remove('hidden');
            // Xóa highlight
            const titleLink = item.querySelector('.topic-link');
            if (titleLink && titleLink.innerHTML.includes('<span class="search-highlight">')) {
                titleLink.innerHTML = titleLink.textContent;
            }
        });
        noResults.classList.remove('show');
        visibleCount = totalItems;
    } else {
        // Tìm kiếm và filter
        activityItems.forEach(item => {
            const titleLink = item.querySelector('.topic-link');
            const originalTitle = titleLink.textContent.toLowerCase();
            
            if (originalTitle.includes(searchTerm)) {
                item.classList.remove('hidden');
                
                // Highlight từ khóa tìm kiếm
                const regex = new RegExp(`(${escapeRegExp(searchTerm)})`, 'gi');
                const highlightedTitle = titleLink.textContent.replace(regex, '<span class="search-highlight">$1</span>');
                titleLink.innerHTML = highlightedTitle;
                
                visibleCount++;
            } else {
                item.classList.add('hidden');
                // Xóa highlight nếu không match
                titleLink.innerHTML = titleLink.textContent;
            }
        });
        
        // Hiển thị thông báo không tìm thấy nếu cần
        if (visibleCount === 0) {
            noResults.classList.add('show');
        } else {
            noResults.classList.remove('show');
        }
    }
    
    // Cập nhật số lượng trong tab
    if (tabCount) {
        const originalText = tabCount.textContent;
        const baseText = originalText.split('(')[0];
        tabCount.textContent = `${baseText}(${visibleCount})`;
    }
}

// Escape special regex characters
function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

// Reset tìm kiếm khi focus vào search input
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            if (this.value === '') {
                searchTopics(); // Reset hiển thị
            }
        });
        
        // Xóa tìm kiếm khi nhấn Escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                searchTopics();
                this.blur();
            }
        });
    }
});
</script>
</body>
</html> 