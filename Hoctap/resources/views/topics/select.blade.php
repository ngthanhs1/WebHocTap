@extends('layouts.app')

@section('content')
<div class="glass-container">
    <div class="glass-card">
        <div class="card-header">
            <h2><i class="fas fa-list"></i> Chọn chủ đề để thêm câu hỏi</h2>
        </div>

        @if(session('quiz_questions') && count(session('quiz_questions')) > 0)
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle"></i> 
                Bạn có {{ count(session('quiz_questions')) }} câu hỏi đã tạo sẵn.
            </div>
        @else
            <div class="alert alert-warning mb-4">
                <i class="fas fa-exclamation-triangle"></i> 
                Không có câu hỏi nào trong session. 
                <a href="{{ route('cauhoi.create') }}" class="btn btn-link p-0">Tạo câu hỏi mới</a>
            </div>
        @endif

        @if($topics->count() > 0)
            <div class="topics-grid">
                @foreach($topics as $topic)
                    <div class="topic-card">
                        <div class="topic-info">
                            <h3>{{ $topic->name }}</h3>
                            <p class="topic-stats">
                                <i class="fas fa-question-circle"></i> {{ $topic->questions_count }} câu hỏi
                            </p>
                            <p class="topic-date">
                                <i class="fas fa-calendar"></i> {{ $topic->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="topic-actions">
                            <form action="{{ route('topics.add-questions', $topic) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary" 
                                        {{ !session('quiz_questions') ? 'disabled' : '' }}>
                                    <i class="fas fa-plus"></i> Thêm câu hỏi
                                </button>
                            </form>
                            <a href="{{ route('topics.show', $topic) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye"></i> Xem
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">Chưa có chủ đề nào. Tạo chủ đề mới để thêm câu hỏi.</p>
                <a href="{{ route('chude.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tạo chủ đề mới
                </a>
            </div>
        @endif

        <div class="action-buttons mt-4">
            <a href="{{ route('cauhoi.create') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại tạo câu hỏi
            </a>
        </div>
    </div>
</div>

<style>
.topics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.topic-card {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 20px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.topic-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.topic-info h3 {
    color: #fff;
    margin-bottom: 10px;
    font-size: 1.2em;
}

.topic-stats, .topic-date {
    color: #ccc;
    font-size: 0.9em;
    margin-bottom: 5px;
}

.topic-stats i, .topic-date i {
    margin-right: 5px;
    color: #007bff;
}

.topic-actions {
    margin-top: 15px;
    display: flex;
    gap: 10px;
}

.topic-actions .btn {
    flex: 1;
    font-size: 0.9em;
}

.alert {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    color: #fff;
}

.alert-info {
    border-color: rgba(0, 123, 255, 0.3);
}

.alert-warning {
    border-color: rgba(255, 193, 7, 0.3);
}

.action-buttons {
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}
</style>
@endsection