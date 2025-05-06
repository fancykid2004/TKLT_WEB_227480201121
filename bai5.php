<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính USCLN và BSCNN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid black;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        input, button {
            margin: 5px;
            padding: 5px;
        }
    </style>
</head>
<body>

<h2>TÍNH USCLN VÀ BSCNN</h2>
<div class="container">
    <form method="post">
        <label for="num1">Số thứ 1:</label>
        <input type="number" name="num1" required value="<?= isset($_POST['num1']) ? $_POST['num1'] : 0; ?>"><br>

        <label for="num2">Số thứ 2:</label>
        <input type="number" name="num2" required value="<?= isset($_POST['num2']) ? $_POST['num2'] : 0; ?>"><br>

        <label for="result">Kết quả:</label>
        <input type="number" name="result" value="<?php 
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            echo tinhtoan();
        }
        ?>" readonly>
        <br>
        <button type="submit" name="uscln">USCLN</button>
        <button type="submit" name="bscnn">BSCNN</button>
    </form>
</div>

<?php
function uscln($a, $b) {
    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}

function bscnn($a, $b) {
    return ($a * $b) / uscln($a, $b);
}
function tinhtoan(){
        $num1 = $_POST["num1"];
        $num2 = $_POST["num2"];

        if (isset($_POST["uscln"])) {
            $result = uscln($num1, $num2);
        } elseif (isset($_POST["bscnn"])) {
            $result = bscnn($num1, $num2);
        }
        return $result;
}
?>
</body>
</html>