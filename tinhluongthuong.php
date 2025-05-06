<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "quanlynhansu";   

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
}

$message = "";
$message_class = "";
$result = null;
$bonusMessage = "";
$bonusMessageClass = "";
$maNVList = []; 

try {
    $sql = "SELECT DISTINCT maNV FROM quanlytienluong ORDER BY maNV";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $maNVList = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch(PDOException $e) {
    $message = "Lỗi khi lấy danh sách Mã NV: " . $e->getMessage();
    $message_class = "error";
}


$bonusRules = [
    "Thưởng hiệu suất tốt" => 2000000,
    "Thưởng dự án" => 1000000,
    "Thưởng lãnh đạo xuất sắc" => 3000000,
    "Thưởng hoàn thành công việc" => 500000,
    "Thưởng báo cáo tài chính" => 1500000,
    "Thưởng đóng góp lâu năm" => 2500000
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['maNV']) && isset($_POST['thangLuong']) && isset($_POST['namLuong'])) {
    try {
        $maNV = $_POST['maNV'];
        $thangLuong = $_POST['thangLuong'];
        $namLuong = $_POST['namLuong'];

        $sql = "SELECT * FROM quanlytienluong WHERE maNV = :maNV AND thangLuong = :thangLuong AND namLuong = :namLuong";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':maNV', $maNV);
        $stmt->bindParam(':thangLuong', $thangLuong);
        $stmt->bindParam(':namLuong', $namLuong);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            $message = "Không tìm thấy bản ghi lương cho Mã NV: $maNV, Tháng: $thangLuong, Năm: $namLuong!";
            $message_class = "error";
        } else {
            
            $ghiChu = $result['ghiChu'];
            $newBonus = 0;
            foreach ($bonusRules as $note => $bonus) {
                if ($ghiChu === $note) {
                    $newBonus = $bonus;
                    break;
                }
            }
            $result['tienThuong'] = $newBonus;

            
            if ($newBonus > 0) {
                $bonusMessage = "Nhân viên được thưởng " . number_format($newBonus, 2) . " VNĐ. Lý do: $ghiChu";
                $bonusMessageClass = "success";
            } else {
                $bonusMessage = "Nhân viên không có tiền thưởng";
                $bonusMessageClass = "error";
            }
        }
    } catch(PDOException $e) {
        $message = "Lỗi khi tìm kiếm: " . $e->getMessage();
        $message_class = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính tiền thưởng nhân viên</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        h2 {
            color: #003087;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            text-transform: uppercase;
        }
        .search-container {
            max-width: 600px;
            margin: 0 auto 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .bonus-message {
            text-align: center;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 500;
            padding: 10px;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #004d99;
        }
        select, input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .calculate-button {
            display: block;
            margin: 20px auto 0;
            padding: 12px 25px;
            background: linear-gradient(90deg, #004d99, #0066cc);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(0, 77, 153, 0.2);
            transition: all 0.3s ease;
        }
        .calculate-button:hover {
            background: linear-gradient(90deg, #0066cc, #0084ff);
            box-shadow: 0 6px 12px rgba(0, 77, 153, 0.3);
            transform: translateY(-2px);
        }
        .calculate-button:active {
            transform: translateY(0);
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            word-wrap: break-word;
            max-width: 200px;
        }
        th {
            background: linear-gradient(90deg, #003087, #004d99);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
        }
        tr {
            transition: background-color 0.3s ease;
        }
        tr:hover {
            background-color: #f0f0f0;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .back-button {
            display: block;
            margin: 30px auto 0;
            padding: 12px 25px;
            background: linear-gradient(90deg, #004d99, #0066cc);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(0, 77, 153, 0.2);
            transition: all 0.3s ease;
        }
        .back-button:hover {
            background: linear-gradient(90deg, #0066cc, #0084ff);
            box-shadow: 0 6px 12px rgba(0, 77, 153, 0.3);
            transform: translateY(-2px);
        }
        .back-button:active {
            transform: translateY(0);
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            color: #006600;
            background-color: #e6ffe6;
        }
        .error {
            color: #cc0000;
            background-color: #ffe6e6;
        }
    </style>
</head>
<body>
    <h2>Tính tiền thưởng nhân viên</h2>
    <?php if ($message): ?>
        <p class="message <?php echo $message_class; ?>"><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="search-container">
        <?php if ($bonusMessage): ?>
            <p class="bonus-message <?php echo $bonusMessageClass; ?>"><?php echo htmlspecialchars($bonusMessage); ?></p>
        <?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="maNV">Mã NV:</label>
                <select id="maNV" name="maNV" required>
                    <option value="">Chọn Mã NV</option>
                    <?php foreach ($maNVList as $maNV): ?>
                        <option value="<?php echo htmlspecialchars($maNV); ?>">
                            <?php echo htmlspecialchars($maNV); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="thangLuong">Tháng lương:</label>
                <input type="number" id="thangLuong" name="thangLuong" min="1" max="12" required>
            </div>
            <div class="form-group">
                <label for="namLuong">Năm lương:</label>
                <input type="number" id="namLuong" name="namLuong" min="2000" max="2100" required>
            </div>
            <button type="submit" class="calculate-button">Tính thưởng</button>
        </form>
    </div>

    <?php if ($result): ?>
        <table>
            <tr>
                <th>Mã lương</th>
                <th>Mã NV</th>
                <th>Lương cơ bản</th>
                <th>Tiền thưởng</th>
                <th>Tháng lương</th>
                <th>Năm lương</th>
                <th>Ghi chú</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($result['maLuong']); ?></td>
                <td><?php echo htmlspecialchars($result['maNV']); ?></td>
                <td><?php echo number_format($result['luongCoBan'], 2); ?></td>
                <td><?php echo number_format($result['tienThuong'], 2); ?></td>
                <td><?php echo htmlspecialchars($result['thangLuong']); ?></td>
                <td><?php echo htmlspecialchars($result['namLuong']); ?></td>
                <td><?php echo htmlspecialchars($result['ghiChu']); ?></td>
            </tr>
        </table>
    <?php endif; ?>

    <button class="back-button" onclick="window.location.href='index.html'">Quay lại</button>
</body>
</html>
