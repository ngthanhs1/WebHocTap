<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập</title>
  <style>
    body {font-family: system-ui, Arial; background:#f7f7fb; margin:0}
    .login-container{max-width:400px;margin:6rem auto;background:#fff;padding:24px 28px;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,.06)}
    .logo h1{margin:0 0 4px}
    .error{color:#b91c1c;background:#fee2e2;padding:8px 10px;border-radius:8px;margin-bottom:10px}
    .ok{color:#065f46;background:#d1fae5;padding:8px 10px;border-radius:8px;margin-bottom:10px}
    .form-group{margin-bottom:12px; position:relative}
    label{display:block;margin-bottom:6px;font-weight:600}
    input[type=email],input[type=password]{width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:10px}
    .pw-toggle{position:absolute;right:10px; top:36px; background:transparent;border:none;cursor:pointer}
    .row{display:flex;align-items:center;justify-content:space-between;margin:6px 0 14px}
    .login-btn{width:100%;padding:10px 12px;background:#2563eb;color:#fff;border:none;border-radius:10px;cursor:pointer}
    .login-btn:hover{background:#1d4ed8}
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
        <label for="email">Gmail</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
      </div>

      <div class="form-group">
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" name="password" required>
        <button type="button" class="pw-toggle" onclick="const p=document.getElementById('password'); p.type = p.type==='password'?'text':'password'">👁️</button>
      </div>

      <div class="row">
        <label style="display:flex;gap:6px;align-items:center">
          <input type="checkbox" name="remember" value="1"> Ghi nhớ đăng nhập
        </label>
        <a href="#" onclick="alert('Tính năng khôi phục sẽ bổ sung sau'); return false;">Quên mật khẩu?</a>
      </div>

      <button type="submit" class="login-btn">Đăng nhập</button>
    </form>
  </div>
</body>
</html>
