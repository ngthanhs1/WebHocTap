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
      <p>Chào mừng bạn trở lại!</p>
    </div>

    @if (session('ok')) <div class="ok">{{ session('ok') }}</div> @endif
    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf

      <div class="form-group">
        <label for="usergmail">Tài khoản</label>
        <input type="text" id="usergmail" name="usergmail" value="{{ old('usergmail') }}" required autofocus maxlength="50" placeholder="Nhập email hoặc tên đăng nhập">
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

<script>
setInterval(function() {
    fetch('{{ route("login") }}')
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newToken = doc.querySelector('input[name="_token"]');
            if (newToken) {
                const currentTokenInput = document.querySelector('input[name="_token"]');
                if (currentTokenInput) {
                    currentTokenInput.value = newToken.value;
                }
            }
        })
        .catch(error => console.log('CSRF token refresh failed:', error));
}, 600000);
</script>
</body>
</html>
