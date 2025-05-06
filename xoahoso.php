<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "quanlynhansu";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$message = "";
$message_class = "";

if (isset($_GET['delete'])) {
    try {
        $maNV = $_GET['delete'];
        $sql = "DELETE FROM nhanvien WHERE maNV = :maNV";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':maNV', $maNV);
        $stmt->execute();
        $message = "Xóa hồ sơ thành công!";
        $message_class = "success";
    } catch(PDOException $e) {
        $message = "Lỗi: " . $e->getMessage();
        $message_class = "error";
    }
}

try {
    $stmt = $conn->prepare("SELECT * FROM nhanvien");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $message = "Lỗi: " . $e->getMessage();
    $message_class = "error";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa hồ sơ nhân viên</title>
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
        .delete-button {
            padding: 8px 15px;
            background: linear-gradient(90deg, #cc0000, #ff3333);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .delete-button:hover {
            background: linear-gradient(90deg, #ff3333, #ff6666);
            box-shadow: 0 2px 4px rgba(204, 0, 0, 0.2);
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
    <h2>Xóa hồ sơ nhân viên</h2>
    <?php if ($message): ?>
        <p class="message <?php echo $message_class; ?>"><?php echo $message; ?></p>
    <?php endif; ?>
    <table>
        <tr>
            <th>Mã NV</th>
            <th>Họ và tên</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>Địa chỉ</th>
            <th>Số ĐT</th>
            <th>Email</th>
            <th>Đơn vị trực thuộc</th>
            <th>Chức vụ</th>
            <th>Ngày vào làm</th>
            <th>Hành động</th>
        </tr>
        <?php
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['maNV']) . "</td>";
            echo "<td>" . htmlspecialchars($row['hoTen']) . "</td>";
            echo "<td>" . htmlspecialchars($row['ngaySinh']) . "</td>";
            echo "<td>" . htmlspecialchars($row['gioiTinh']) . "</td>";
            echo "<td>" . htmlspecialchars($row['diaChi']) . "</td>";
            echo "<td>" . htmlspecialchars($row['soDienThoai']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['donViTrucThuoc']) . "</td>";
            echo "<td>" . htmlspecialchars($row['chucVu']) . "</td>";
            echo "<td>" . htmlspecialchars($row['ngayVaoLam']) . "</td>";
            echo "<td><a href='xoahoso.php?delete=" . htmlspecialchars($row['maNV']) . "'><button class='delete-button'>Xóa</button></a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <button class="back-button" onclick="window.location.href='index.html'">Quay lại</button>
</body>
</html>