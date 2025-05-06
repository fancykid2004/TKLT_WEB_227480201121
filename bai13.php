<!DOCTYPE html>
<html>
<head>
    <title>Quản lý mảng số nguyên</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Quản lý mảng số nguyên</h1>
    
    <form method="post">
        <label for="numbers">Nhập các số nguyên (cách nhau bằng dấu phẩy):</label><br>
        <input type="text" name="numbers" id="numbers" required><br><br>
        
        <select name="action">
            <option value="max">Tìm số lớn nhất</option>
            <option value="min">Tìm số nhỏ nhất</option>
            <option value="perfect_square">Tìm số chính phương</option>
            <option value="prime">Tìm số nguyên tố</option>
            <option value="odd">Tìm số lẻ</option>
            <option value="sort">Sắp xếp tăng dần</option>
        </select>
        
        <input type="submit" value="Thực hiện">
    </form>

    <?php
    function isPerfectSquare($num) {
        $sqrt = sqrt($num);
        return ($sqrt == floor($sqrt));
    }

    function isPrime($num) {
        if ($num <= 1) return false;
        for ($i = 2; $i <= sqrt($num); $i++) {
            if ($num % $i == 0) return false;
        }
        return true;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input = $_POST['numbers'];
        $numbers = array_map('intval', explode(',', $input));
        $action = $_POST['action'];
        
        echo "<h3>Kết quả:</h3>";
        echo "Mảng ban đầu: " . implode(', ', $numbers) . "<br>";
        
        switch ($action) {
            case 'max':
                echo "Số lớn nhất: " . max($numbers);
                break;
            case 'min':
                echo "Số nhỏ nhất: " . min($numbers);
                break;
            case 'perfect_square':
                $result = array_filter($numbers, 'isPerfectSquare');
                echo "Số chính phương: " . (empty($result) ? "Không có" : implode(', ', $result));
                break;
            case 'prime':
                $result = array_filter($numbers, 'isPrime');
                echo "Số nguyên tố: " . (empty($result) ? "Không có" : implode(', ', $result));
                break;
            case 'odd':
                $result = array_filter($numbers, function($n) { return $n % 2 != 0; });
                echo "Số lẻ: " . (empty($result) ? "Không có" : implode(', ', $result));
                break;
            case 'sort':
                sort($numbers);
                echo "Mảng sau khi sắp xếp: " . implode(', ', $numbers);
                break;
        }
    }
    ?>
</body>
</html>