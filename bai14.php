<!DOCTYPE html>
<html>
<head>
    <title>Quản lý ma trận số thực</title>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Quản lý ma trận số thực</h1>
    
    <form method="post">
        <label>Nhập ma trận (mỗi dòng là một hàng, các phần tử cách nhau bằng dấu phẩy):</label><br>
        <textarea name="matrix" rows="5" cols="50" required></textarea><br><br>
        
        <select name="action">
            <option value="max">Tìm số lớn nhất</option>
            <option value="min">Tìm số nhỏ nhất</option>
            <option value="sum">Tính tổng</option>
            <option value="display">Hiển thị ma trận</option>
        </select>
        
        <input type="submit" value="Thực hiện">
    </form>

    <?php
    function findMatrixMax($matrix) {
        $max = $matrix[0][0];
        foreach ($matrix as $row) {
            foreach ($row as $value) {
                if ($value > $max) $max = $value;
            }
        }
        return $max;
    }

    function findMatrixMin($matrix) {
        $min = $matrix[0][0];
        foreach ($matrix as $row) {
            foreach ($row as $value) {
                if ($value < $min) $min = $value;
            }
        }
        return $min;
    }

    function calculateMatrixSum($matrix) {
        $sum = 0;
        foreach ($matrix as $row) {
            foreach ($row as $value) {
                $sum += $value;
            }
        }
        return $sum;
    }

    function displayMatrix($matrix) {
        echo '<table>';
        foreach ($matrix as $row) {
            echo '<tr>';
            foreach ($row as $value) {
                echo '<td>' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input = trim($_POST['matrix']);
        $rows = explode("\n", $input);
        $matrix = [];
        
        foreach ($rows as $row) {
            $elements = array_map('floatval', explode(',', trim($row)));
            $matrix[] = $elements;
        }
        
        $action = $_POST['action'];
        
        echo "<h3>Kết quả:</h3>";
        
        switch ($action) {
            case 'max':
                echo "Số lớn nhất trong ma trận: " . findMatrixMax($matrix);
                break;
            case 'min':
                echo "Số nhỏ nhất trong ma trận: " . findMatrixMin($matrix);
                break;
            case 'sum':
                echo "Tổng các số trong ma trận: " . calculateMatrixSum($matrix);
                break;
            case 'display':
                echo "Ma trận:<br>";
                displayMatrix($matrix);
                break;
            }
        }
    ?>
</body>
</html>