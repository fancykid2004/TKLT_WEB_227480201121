<?php
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quanlynhansu";
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM nhanvien");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Kết nối thất bại: " . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem hồ sơ nhân viên</title>
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
    </style>
</head>
<body>
    <h2>Xem hồ sơ nhân viên</h2>
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
            echo "</tr>";
        }
        ?>
    </table>
    <button class="back-button" onclick="window.location.href='index.html'">Quay lại</button>
</body>
</html>