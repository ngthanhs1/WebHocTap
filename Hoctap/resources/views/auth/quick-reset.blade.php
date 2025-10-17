<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đổi mật khẩu nhanh</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
  <div class="login-container">
    <div class="logo">
      <h1>Đổi mật khẩu</h1>
      <p>Nhập email và mật khẩu mới để cập nhật</p>
    </div>

    @if (session('ok'))
      <div class="success-message">{{ session('ok') }}</div>
    @endif
    @if ($errors->any())
      <div class="error-message">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('quick-password.update') }}">
      @csrf
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Nhập email đã đăng ký" required>
      </div>
      <div class="form-group" style="position:relative;">
        <label for="password">Mật khẩu mới</label>
        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu mới" required>
        <button type="button" class="password-toggle" onclick="togglePassword('password')">Hiện</button>
      </div>
      <div class="form-group" style="position:relative;">
        <label for="password_confirmation">Xác nhận mật khẩu</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">Hiện</button>
      </div>
      <button type="submit" class="login-btn">Cập nhật mật khẩu</button>
    </form>

    <div class="divider"><span>hoặc</span></div>
    <div class="signup-link">
      <p>Quay lại <a href="{{ route('login') }}">Đăng nhập</a></p>
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
