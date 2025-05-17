@extends('layouts.guest')
@section('title', 'Đăng nhập')
@section('content')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        padding: 2rem;
        width: 100%;
        max-width: 450px;
    }

    .card-header {
        background: transparent;
        border-bottom: none;
        text-align: center;
        padding-bottom: 1rem;
    }

    .card-header h3 {
        color: #333;
        font-weight: 600;
        margin: 0;
    }

    .form-control {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .form-label {
        font-weight: 500;
        color: #555;
    }

    .invalid-feedback {
        font-size: 0.875rem;
    }

    .login-logo {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-logo img {
        max-width: 150px;
        height: auto;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Xử lý đăng nhập với JWT
        $('#loginForm').on('submit', function(e) {
            // Vẫn cho phép form submit bình thường để xử lý server-side
            // Nhưng chúng ta cũng lưu token JWT vào localStorage nếu API trả về

            // Lưu ý: Đây chỉ là code bổ sung, không ảnh hưởng đến luồng đăng nhập hiện tại
            $.ajax({
                url: '/api/auth/login',
                type: 'POST',
                data: {
                    email: $('#email').val(),
                    matkhau: $('#matkhau').val()
                },
                success: function(response) {
                    if (response.access_token) {
                        // Lưu token vào localStorage để sử dụng cho các request API
                        localStorage.setItem('jwt_token', response.access_token);
                        localStorage.setItem('user', JSON.stringify(response.user));
                    }
                },
                error: function(xhr) {
                    // Không cần xử lý lỗi ở đây vì form sẽ submit và xử lý server-side
                }
            });
        });
    });
</script>
<div class="login-container">
    <div class="login-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid">
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Quản trị thiết bị</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus autocomplete="off">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="matkhau" class="form-label">Mật khẩu</label>
                    <input id="matkhau" type="password" class="form-control @error('matkhau') is-invalid @enderror"
                        name="matkhau" required autocomplete="current-password" autocomplete="off">
                    @error('matkhau')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-4 d-flex justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-muted text-decoration-none">
                        {{ __('Quên mật khẩu?') }}
                    </a>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-login text-white">
                        Đăng nhập
                    </button>
                </div>

                <div class="mt-3 text-center">
                    <div class="login-message alert d-none"></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection