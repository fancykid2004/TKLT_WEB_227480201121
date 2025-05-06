<!DOCTYPE html>
<html>
<head>
    <title>Bảng cửu chương từ 1 đến 9</title>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            margin: 20px 0;
        }
        td {
            padding: 5px 10px;
            text-align: center;
        }
        .multiplication-table {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }
        .table-group {
            margin-right: 40px;
        }
    </style>
</head>
<body>
    <h1>Bảng cửu chương từ 1 đến 10</h1>
    
    <div class="multiplication-table">
        <?php
        // Hiển thị bảng cửu chương theo nhóm 3
        for ($group = 1; $group <= 9; $group += 3) {
            echo '<div class="table-group">';
            
            // Vòng lặp cho mỗi bảng trong nhóm (3 bảng)
            for ($table = $group; $table < $group + 3; $table++) {
                echo '<table border="1">';
                echo "<caption>Bảng cửu chương $table</caption>";
                
                // Vòng lặp hiển thị từ 1 đến 10
                for ($i = 1; $i <= 10; $i++) {
                    $result = $table * $i;
                    echo "<tr><td>$table</td><td>x</td><td>$i</td><td>=</td><td>$result</td></tr>";
                }
                
                echo '</table>';
            }
            
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>