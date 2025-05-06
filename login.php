
<?php
    $ketqua = "";
    session_start();
    if(isset($_POST['dangnhap'])){
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = $_POST['password'];
        if($_SESSION['email'] ==  "linh@gmail.com" && $_SESSION['password'] == "123456"){
            $ketqua = "Thong tin dang nhap hop le!";

        }
        else{
            $ketqua = "Thong tin dang nhap sai vui long nhap lai!";
        }
    }
    if (isset($_POST['trangchinh'])){
        header("location: admin.php");
        exit();
    }
    if (isset($_POST['login'])){
        header("location: login.html");
        exit();
    }
?>
<h2>Trang xu ly thong tin dang nhap</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "post">
        <?php
        if(isset($_SESSION['email'])){
            if(isset($ketqua) && $ketqua != ""){

                if($ketqua == "Thong tin dang nhap hop le!"){
                    echo "<font color = 'green'>".$ketqua;
                    echo "<br> <br>";
                    echo "<input type='submit' value='Vao trang chinh' name='trangchinh'>";
                }
                else{
                    echo "<font color = 'red'>".$ketqua;
                    echo "<br> <br>";
                    echo "<input type='submit' value='Quay ve dang nhap' name='login'>";
                }
            }
            if(isset($ketqua) && $ketqua == "")
                {
                    echo "<font color = 'green'> Thong tin dang nhap hop le!";
                    echo "<br> <br>";
                    echo "<input type='submit' value='Vao trang chinh' name='trangchinh'>";
                }
            }
        else{
            echo "<font color = 'blue'>"."Bạn chưa nhập email or mật khẩu vui lòng hãy nhập!"."";
            echo "<br> <br>";
            echo "<input type='submit' value='Quay ve dang nhap' name='login'>";
            }
        ?>
</form>
