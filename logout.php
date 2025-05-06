<?php
    setcookie("loggedin", "", time() - 600);
    setcookie("user", "", time() - 600);
    header("Location: login.html");
?>
