<?php
    session_start();

    if (!isset($_COOKIE['loggedin'])) {
        header("Location: login.html");
        exit();
    }

    echo "<h2>Chào mừng bạn, " . $_COOKIE['user'] . "!</h2>";
    echo "<p>Bạn đã đăng nhập thành công.</p>";
    echo '<a href="logout.php">Đăng xuất</a>';  // Thay đổi dấu ngoặc kép thành dấu nháy đơn
?>
