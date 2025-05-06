<?php
    session_start();
    if(isset($_SESSION['email'])){
        echo "<h3> Trang chinh <br>";
        echo "nguoi dung da dang nhap voi email ".$_SESSION['email']. " va mat khau la ".$_SESSION['password'];
    }
    else{
        header("location: login.html"); 
    }
?>
<form action="logout.php" method="post">
    <input type="submit" value="Đăng xuất">
</form>