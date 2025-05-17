<!DOCTYPE html>
<html>

<head>
    <title>Reset mật khẩu</title>
</head>

<body>
    <h2>Reset mật khẩu</h2>
    <p>Xin chào,</p>
    <p>Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu reset mật khẩu cho tài khoản của bạn.</p>
    <p>Vui lòng click vào link bên dưới để reset mật khẩu:</p>
    <a href="{{ route('password.reset', ['token' => $token]) }}">Reset mật khẩu</a>
    <p>Link này sẽ hết hạn trong 60 phút.</p>
    <p>Nếu bạn không yêu cầu reset mật khẩu, vui lòng bỏ qua email này.</p>
    <p>Trân trọng,</p>
    <p>Đội ngũ hỗ trợ Quản trị Thiết bị - Trường Đại học Sư phạm Kỹ thuật Vĩnh Long</p>
</body>

</html>