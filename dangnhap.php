<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập khách hàng</title>
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
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
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
        <h2>Đăng nhập khách hàng</h2>
        <form method="POST" action="">
            <input type="text" name="customer_name" placeholder="Nhập tên của bạn" required>
            <input type="text" name="phone_number" placeholder="Nhập số điện thoại" required>
            <button type="submit" name="login_submit">Đăng nhập</button>
        </form>

        <?php
        // Xử lý Form: Lưu thông tin vào cookie
        if (isset($_POST['login_submit'])) {
            $customerName = $_POST['customer_name'];
            $phoneNumber = $_POST['phone_number'];

            // Tạo cookie với thời gian tồn tại 10 phút (600 giây)
            setcookie("customer_name", $customerName, time() + 600, "/");
            setcookie("phone_number", $phoneNumber, time() + 600, "/");

            echo "<div class='info'>Đã lưu thông tin vào cookie hãy vào xem thông tin!</div>";
        }
        ?>

        <a href="hienthitt.php">Xem thông tin đã lưu</a>
    </div>
</body>
</html>