<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển thị thông tin khách hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .info {
            margin-top: 20px;
            padding: 10px;
            background-color: #e7f3fe;
            border: 1px solid #b3d4fc;
            border-radius: 4px;
        }
        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #4CAF50;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hiển thị thông tin khách hàng</h2>

        <?php
        // Kiểm tra và hiển thị thông tin từ cookie ngay khi truy cập trang
        if (isset($_COOKIE['customer_name']) && isset($_COOKIE['phone_number'])) {
            $displayName = $_COOKIE['customer_name'];
            $displayPhone = $_COOKIE['phone_number'];
            echo "<div class='info'>";
            echo "<h3>Thông tin khách hàng đã lưu:</h3>";
            echo "Tên: " . htmlspecialchars($displayName) . "<br>";
            echo "Số điện thoại: " . htmlspecialchars($displayPhone);
            echo "</div>";
        } else {
            echo "<div class='info'>Khách hàng chưa nhập thông tin.</div>";
        }
        ?>

        <a href="dangnhap.php">Quay lại trang đăng nhập</a>
    </div>
</body>
</html>