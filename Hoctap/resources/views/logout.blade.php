<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="{{ asset('css/styles1.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .signup-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 420px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 16px;
            color: #718096;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 15px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
        }

        .input-container {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 16px 20px;
            font-size: 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: #fff;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #a0aec0;
            font-size: 20px;
            padding: 4px;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .signup-btn {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 24px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .signup-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .signup-btn:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 24px 0;
            color: #a0aec0;
            font-size: 14px;
        }

        .login-link {
            text-align: center;
            font-size: 15px;
            color: #718096;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .login-link a:hover {
            color: #5a67d8;
            text-decoration: underline;
        }

        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            margin-bottom: 24px;
            font-size: 14px;
            color: #718096;
        }

        .terms-checkbox input[type="checkbox"] {
            margin-right: 8px;
            margin-top: 2px;
        }

        .terms-checkbox a {
            color: #667eea;
            text-decoration: none;
        }

        .terms-checkbox a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .signup-container {
                padding: 32px 24px;
                margin: 10px;
            }

            .header h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="header">
            <h1>Đăng ký</h1>
            <p>Tạo tài khoản mới của bạn</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif
        <form method="POST" action="{{ route('logout.post') }}">
            @csrf
            <div class="form-group">
                <label for="fullName">Họ và tên</label>
                <input 
                    type="text" 
                    id="fullName" 
                    name="fullName"
                    class="form-control" 
                    placeholder="Nhập họ và tên của bạn"
                    value="{{ old('fullName') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                    class="form-control" 
                    placeholder="Nhập địa chỉ email của bạn"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <div class="input-container">
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="form-control" 
                        placeholder="Tạo mật khẩu mạnh"
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        👁️
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Xác nhận mật khẩu</label>
                <div class="input-container">
                    <input 
                        type="password" 
                        id="confirmPassword" 
                        name="password_confirmation"
                        class="form-control" 
                        placeholder="Nhập lại mật khẩu"
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                        👁️
                    </button>
                </div>
            </div>

            <div class="terms-checkbox">
                <input type="checkbox" id="agreeTerms" name="agreeTerms" {{ old('agreeTerms') ? 'checked' : '' }} required>
                <label for="agreeTerms">
                    Tôi đồng ý với <a href="#" onclick="alert('Sẽ cập nhật sau');return false;">Điều khoản sử dụng</a> 
                    và <a href="#" onclick="alert('Sẽ cập nhật sau');return false;">Chính sách bảo mật</a>
                </label>
            </div>

            <button type="submit" class="signup-btn">Đăng ký</button>
        </form>

        <div class="divider">hoặc</div>
        <div class="login-link">
            Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>
        </div>
    </div>

    <script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
    </script>
</body>
</html>