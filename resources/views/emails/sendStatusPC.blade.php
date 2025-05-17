<!DOCTYPE html>
<html>

<head>
    <title>Thông báo thiết bị hư hỏng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #f8f8f8;
            padding: 10px;
            text-align: center;
        }

        .content {
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Thông báo thiết bị hư hỏng</h2>
        </div>
        <div class="content">
            <p>Kính gửi thầy/cô {{ $hoten }},</p>
            <p>Chúng tôi xin thông báo thiết bị trong phòng máy {{ $tenphong }} đã được ghi nhận hư hỏng. Chi tiết như sau:</p>
            <table class="table">
                <tr>
                    <th>Tên thiết bị</th>
                    <td>{{ $tentb }}</td>
                </tr>
                <tr>
                    <th>Mã thiết bị</th>
                    <td>{{ $matb }}</td>
                </tr>
                <tr>
                    <th>Số máy</th>
                    <td>{{ $somay }}</td>
                </tr>
                <tr>
                    <th>Mô tả</th>
                    <td>{{ $mota }}</td>
                </tr>
                <tr>
                    <th>Ghi chú</th>
                    <td>{{ $ghichu }}</td>
                </tr>
                <tr>
                    <th>Tình trạng</th>
                    <td>{{ $tinhtrang }}</td>
                </tr>
            </table>
            <p>Vui lòng kiểm tra và xử lý. Nếu có thắc mắc, xin liên hệ quản trị viên.</p>
            <p>Trân trọng,<br>Hệ thống quản lý phòng máy</p>
        </div>
    </div>
</body>

</html>