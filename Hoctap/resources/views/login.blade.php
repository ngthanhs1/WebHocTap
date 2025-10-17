<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<div class="login-container">
    <div class="logo">
        <h1>Đăng nhập</h1>
        <p>Vui lòng đăng nhập để tiếp tục</p>
    </div>

    @if (session('ok'))
        <div class="success-message" style="display:block;">{{ session('ok') }}</div>
    @endif
    @if ($errors->any())
        <div class="error-message" style="display:block;">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="form-group">
            <label for="login-usergmail">Email hoặc tên đăng nhập</label>
            <input type="text" id="login-usergmail" name="usergmail" placeholder="Nhập email hoặc tên đăng nhập" value="{{ old('usergmail') }}" required>
        </div>
        <div class="form-group" style="position:relative;">
            <label for="login-password">Mật khẩu</label>
            <input type="password" id="login-password" name="password" placeholder="Nhập mật khẩu" required>
            <button type="button" class="password-toggle" onclick="togglePassword('login-password')">Hiện</button>
        </div>
        <label style="display:flex;gap:8px;align-items:center;margin:6px 0 12px;">
            <input type="checkbox" name="remember" value="1"> Ghi nhớ đăng nhập
        </label>
        <div style="text-align:right;margin:-4px 0 12px;">
            <a href="{{ route('quick-password.request') }}" style="font-size:14px; color:#111827; text-decoration:underline;">Đổi mật khẩu</a>
        </div>
    <button type="submit" class="login-btn" style="color: #ffffff;">Đăng nhập</button>
    </form>

    <div class="divider"><span>hoặc</span></div>
    <div class="signup-link">
        <p>Chưa có tài khoản? <a href="{{ route('logout') }}">Đăng ký ngay</a></p>
    </div>
</div>

<script>
function togglePassword(id){
  const el = document.getElementById(id);
  if(!el) return;
  el.type = el.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
