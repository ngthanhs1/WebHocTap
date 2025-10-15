<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <style>
    * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .logo p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-group input:focus {
            outline: none;
            border-color: #92a1e2;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
        }

        .form-group input::placeholder {
            color: #aaa;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 14px;
            margin-top: 16px;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 25px;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #a7acda;
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, #8894ca 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e5e9;
        }

        .divider span {
            background: rgba(255, 255, 255, 0.95);
            padding: 0 20px;
            color: #666;
            font-size: 14px;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
        }

        .signup-link p {
            color: #666;
            font-size: 14px;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid rgba(239, 68, 68, 0.2);
            display: none;
        }

        .success-message {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid rgba(34, 197, 94, 0.2);
            display: none;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 0 10px;
            }
        }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="logo">
      <h1>Đăng nhập</h1>
      <p>Chào mừng bạn trở lại!</p>
    </div>

    @if (session('ok')) <div class="ok">{{ session('ok') }}</div> @endif
    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf

      <div class="form-group">
        <label for="usergmail">Tài khoản Gmail</label>
        <input type="text" id="usergmail" name="usergmail" value="{{ old('usergmail') }}" required autofocus maxlength="50">
      </div>

      <div class="form-group">
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" name="password" required>

      </div>


            <div class="row" style="display:flex;align-items:center;justify-content:space-between;margin:6px 0 14px">
                <label style="display:flex;gap:6px;align-items:center">
                    <input type="checkbox" name="remember" value="1"> Ghi nhớ đăng nhập
                </label>
                <a href="#" onclick="alert('Tính năng khôi phục sẽ bổ sung sau'); return false;">Quên mật khẩu?</a>
            </div>

                    <div class="signup-link">
                        <p>Chưa có tài khoản? <a href="{{ route('logout') }}">Đăng ký ngay</a></p>
                    </div>

      <button type="submit" class="login-btn">Đăng nhập</button>
    </form>
  </div>
</body>
</html>
