<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Hệ thống học tập') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- CSS tùy chỉnh -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #111827;
        }

        .glass-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .glass-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 1000px;
        }

        .card-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .card-header h2 {
            color: #111827;
            font-weight: 700;
        }

        .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: #111827;
            color: #ffffff;
            border: 1px solid #111827;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #111827;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .btn-outline-primary {
            background: transparent;
            color: #111827;
            border: 1px solid #111827;
        }

        .btn-outline-primary:hover {
            background: #111827;
            color: #ffffff;
        }

        .form-control {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            color: #111827;
            padding: 12px 15px;
        }

        .form-control:focus {
            background: #ffffff;
            border-color: #9ca3af;
            color: #111827;
            box-shadow: 0 0 0 0.25rem rgba(17, 24, 39, 0.08);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-label {
            color: #111827;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .text-muted {
            color: #6b7280 !important;
        }
    </style>
</head>
<body>
    @yield('content')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @yield('scripts')
</body>
</html>