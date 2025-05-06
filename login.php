<?php
    session_start();

    // Kiểm tra thông tin đăng nhập
    function checkLogin($email, $password, $maso) {
        $users = parse_ini_file("users.ini", true); // Đảm bảo dùng đúng tên file
        if (isset($users[$email])) {
            return ($users[$email]['password'] === $password && $users[$email]['maso'] === $maso);
        }
        return false;
    }

    // Nhận dữ liệu từ form
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $maso = $_POST['maso'] ?? '';

    // Kiểm tra đăng nhập
    if (checkLogin($email, $password, $maso)) {
        setcookie("loggedin", "true", time() + 20);
        setcookie("user", $email, time() + 20);
        header("Location: welcome.php");
    } 
    else {
        echo "Đăng nhập thất bại. Vui lòng thử lại!";
    }
?>
