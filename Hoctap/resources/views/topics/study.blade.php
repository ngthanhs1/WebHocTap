<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ôn tập - {{ $topic->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles4.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="main-content" style="max-width: 900px; margin: 32px auto;">
        <a href="{{ route('trangchinh') }}" style="background: #e0e0e0; color: #000; border: none; padding: 12px 24px; border-radius: 6px; font-size: 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 24px;"> <i class="fas fa-arrow-left"></i> Quay về trang chính </a>

        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; margin-bottom: 32px; text-align: center;">
            <h1 style="font-size: 2rem; font-weight: 700; color: #000; margin-bottom: 8px;"><i class="fas fa-book-open"></i> Ôn tập</h1>
            <h2 style="font-size: 1.3rem; color: #222; margin-bottom: 16px;">{{ $topic->name }}</h2>
            <div style="display: flex; justify-content: center; gap: 32px; margin-bottom: 16px;">
                <div style="text-align: center;">
                    <span style="font-size: 1.5rem; font-weight: bold; color: #000;">{{ $topic->questions->count() }}</span>
                    <div style="color: #666;">Câu hỏi</div>
                </div>
                <div style="text-align: center;">
                    <span style="font-size: 1.5rem; color: #000;"><i class="fas fa-graduation-cap"></i></span>
                    <div style="color: #666;">Chế độ ôn tập</div>
                </div>
            </div>
        </div>

        @if($topic->questions->count() > 0)
            @foreach($topic->questions as $index => $question)
                <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 24px; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; margin-bottom: 16px;">
                        <div style="background: #000; color: #fff; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 15px;">{{ $index + 1 }}</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: #222; flex: 1;">{{ $question->content }}</div>
                    </div>
                    <div style="margin-top: 12px;">
                        @foreach($question->choices as $choiceIndex => $choice)
                            <div style="display: flex; align-items: center; padding: 12px; margin-bottom: 10px; border-radius: 8px; border: 2px solid #e5e7eb; background: #fff; transition: all 0.3s; {{ $choice->is_correct ? 'border-color: #000; background: #f5f5f5;' : '' }}">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #e0e0e0; color: #000; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 12px;">{{ chr(65 + $choiceIndex) }}</div>
                                <div style="flex: 1; font-size: 1rem;">{{ $choice->content }}</div>
                                @if($choice->is_correct)
                                    <div style="margin-left: 10px; color: #000; font-size: 1.2rem;">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div style="text-align: center; padding: 60px 20px; color: #666; background: #fff; border-radius: 8px; margin-top: 32px;">
                <i class="fas fa-question-circle" style="font-size: 3rem; margin-bottom: 16px; color: #e0e0e0;"></i>
                <h3 style="font-size: 1.2rem; color: #000; margin-bottom: 8px;">Chưa có câu hỏi nào</h3>
                <p>Chủ đề này chưa có câu hỏi để ôn tập. Hãy thêm câu hỏi vào chủ đề này!</p>
                <a href="{{ route('cauhoi.create') }}" style="margin-top: 20px; display: inline-block; padding: 12px 24px; background: #000; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 500;"> <i class="fas fa-plus"></i> Thêm câu hỏi </a>
            </div>
        @endif
    </div>
</body>
</html>