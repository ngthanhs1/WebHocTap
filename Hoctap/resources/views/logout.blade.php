<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="{{ asset('css/dangky.css') }}">

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