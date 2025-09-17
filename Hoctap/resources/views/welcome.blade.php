<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>Đăng nhập</h1>
            <p>Chào mừng bạn trở lại!</p>
        </div>

        <div id="errorMessage" class="error-message"></div>
        <div id="successMessage" class="success-message"></div>

        <form id="loginForm">
            <div class="form-group">
                <label for="email">Gmail</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="Nhập địa chỉ Gmail của bạn"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Nhập mật khẩu của bạn"
                    required
                >
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    👁️
                </button>
            </div>

            <div class="forgot-password">
                <a href="#" onclick="showMessage('success', 'Link khôi phục mật khẩu sẽ được gửi đến email của bạn!')">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="login-btn">Đăng nhập</button>
        </form>
        <div class="signup-link">
            <p>Chưa có tài khoản? <a href="#" onclick="showMessage('success', 'Tính năng đăng ký sẽ có sớm!')">Đăng ký ngay</a></p>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>