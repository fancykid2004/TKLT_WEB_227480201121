<!DOCTYPE html>
<html>
<head>
    <title>Danh sách năm từ 1900 đến nay</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Chọn một năm:</h2>
    
    <form method="post">
        <select name="yearList">
            <?php
            // Lấy năm hiện tại
            $currentYear = date("Y");
            
            // Tạo các option từ năm 1900 đến năm hiện tại
            for ($year = 1900; $year <= $currentYear; $year++) {
                echo "<option value='$year'>$year</option>";
            }
            ?>
        </select>
        <input type="submit" value="Chọn năm">
    </form>

    <?php
    // Xử lý khi form được submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedYear = $_POST['yearList'];
        echo "<p>Bạn đã chọn năm: <strong>$selectedYear</strong></p>";
    }
    ?>
</body>
</html>