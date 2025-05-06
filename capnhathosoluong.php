<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root"; // Thay bằng username MySQL của bạn
$password = ""; // Thay bằng password MySQL của bạn
$dbname = "quanlynhansu";   // Thay bằng tên cơ sở dữ liệu của bạn

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
}

$message = "";
$message_class = "";
$edit_data = null;

// Xử lý cập nhật bảng lương
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['maLuong'])) {
    try {
        $maLuong = $_POST['maLuong'];
        $maNV = $_POST['maNV'];
        $luongCoBan = $_POST['luongCoBan'];
        $tienThuong = $_POST['tienThuong'];
        $thangLuong = $_POST['thangLuong'];
        $namLuong = $_POST['namLuong'];
        $ghiChu = $_POST['ghiChu'];

        $sql = "UPDATE quanlytienluong SET maNV = :maNV, luongCoBan = :luongCoBan, tienThuong = :tienThuong, 
                thangLuong = :thangLuong, namLuong = :namLuong, ghiChu = :ghiChu WHERE maLuong = :maLuong";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':maLuong', $maLuong);
        $stmt->bindParam(':maNV', $maNV);
        $stmt->bindParam(':luongCoBan', $luongCoBan);
        $stmt->bindParam(':tienThuong', $tienThuong);
        $stmt->bindParam(':thangLuong', $thangLuong);
        $stmt->bindParam(':namLuong', $namLuong);
        $stmt->bindParam(':ghiChu', $ghiChu);

        $stmt->execute();
        $message = "Cập nhật bảng lương mã $maLuong thành công!";
        $message_class = "success";
    } catch(PDOException $e) {
        $message = "Lỗi khi cập nhật bảng lương: " . $e->getMessage();
        $message_class = "error";
    }
}

// Lấy thông tin bảng lương để chỉnh sửa
if (isset($_GET['edit'])) {
    try {
        $maLuong = $_GET['edit'];
        $sql = "SELECT * FROM quanlytienluong WHERE maLuong = :maLuong";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':maLuong', $maLuong);
        $stmt->execute();
        $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        $message = "Lỗi khi lấy dữ liệu: " . $e->getMessage();
        $message_class = "error";
    }
}

// Lấy danh sách bảng lương để hiển thị
try {
    $stmt = $conn->prepare("SELECT * FROM quanlytienluong");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $message = "Lỗi khi lấy dữ liệu: " . $e->getMessage();
    $message_class = "error";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa bảng lương nhân viên</title>
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
        .edit-button {
            padding: 8px 15px;
            background: linear-gradient(90deg, #006600, #009900);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .edit-button:hover {
            background: linear-gradient(90deg, #009900, #00cc00);
            box-shadow: 0 2px 4px rgba(0, 102, 0, 0.2);
        }
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .submit-button {
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
        .submit-button:hover {
            background: linear-gradient(90deg, #0066cc, #0084ff);
            box-shadow: 0 6px 12px rgba(0, 77, 153, 0.3);
            transform: translateY(-2px);
        }
        .submit-button:active {
            transform: translateY(0);
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
    <h2>Sửa bảng lương nhân viên</h2>
    <?php if ($message): ?>
        <p class="message <?php echo $message_class; ?>"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if ($edit_data): ?>
        <div class="form-container">
            <h3 style="text-align: center; color: #004d99;">Chỉnh sửa bảng lương mã: <?php echo htmlspecialchars($edit_data['maLuong']); ?></h3>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="maLuong" value="<?php echo htmlspecialchars($edit_data['maLuong']); ?>">
                <div class="form-group">
                    <label for="maNV">Mã NV:</label>
                    <input type="text" id="maNV" name="maNV" value="<?php echo htmlspecialchars($edit_data['maNV']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="luongCoBan">Lương cơ bản:</label>
                    <input type="number" id="luongCoBan" name="luongCoBan" step="0.01" value="<?php echo htmlspecialchars($edit_data['luongCoBan']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="tienThuong">Tiền thưởng:</label>
                    <input type="number" id="tienThuong" name="tienThuong" step="0.01" value="<?php echo htmlspecialchars($edit_data['tienThuong']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="thangLuong">Tháng lương:</label>
                    <input type="number" id="thangLuong" name="thangLuong" min="1" max="12" value="<?php echo htmlspecialchars($edit_data['thangLuong']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="namLuong">Năm lương:</label>
                    <input type="number" id="namLuong" name="namLuong" min="2000" max="2100" value="<?php echo htmlspecialchars($edit_data['namLuong']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="ghiChu">Ghi chú:</label>
                    <input type="text" id="ghiChu" name="ghiChu" value="<?php echo htmlspecialchars($edit_data['ghiChu']); ?>" required>
                </div>
                <button type="submit" class="submit-button">Lưu thay đổi</button>
            </form>
        </div>
    <?php endif; ?>

    <table>
        <tr>
            <th>Mã lương</th>
            <th>Mã NV</th>
            <th>Lương cơ bản</th>
            <th>Tiền thưởng</th>
            <th>Tháng lương</th>
            <th>Năm lương</th>
            <th>Ghi chú</th>
            <th>Hành động</th>
        </tr>
        <?php
        if ($result) {
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['maLuong']) . "</td>";
                echo "<td>" . htmlspecialchars($row['maNV']) . "</td>";
                echo "<td>" . number_format($row['luongCoBan'], 2) . "</td>";
                echo "<td>" . number_format($row['tienThuong'], 2) . "</td>";
                echo "<td>" . htmlspecialchars($row['thangLuong']) . "</td>";
                echo "<td>" . htmlspecialchars($row['namLuong']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ghiChu']) . "</td>";
                echo "<td><a href='capnhathosoluong.php?edit=" . htmlspecialchars($row['maLuong']) . "'><button class='edit-button'>Sửa</button></a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Không có dữ liệu để hiển thị.</td></tr>";
        }
        ?>
    </table>
    <button class="back-button" onclick="window.location.href='index.html'">Quay lại</button>
</body>
</html>
<?php
$conn = null; // Đóng kết nối
?>