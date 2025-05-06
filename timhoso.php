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
$result = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_keyword'])) {
    try {
        $keyword = "%" . $_POST['search_keyword'] . "%";
        $sql = "SELECT * FROM nhanvien WHERE maNV LIKE :keyword OR hoTen LIKE :keyword OR donViTrucThuoc LIKE :keyword OR chucVu LIKE :keyword";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $message = "Không tìm thấy kết quả nào!";
            $message_class = "error";
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
    <title>Tìm kiếm hồ sơ nhân viên</title>
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
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #004d99;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .search-button {
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
        .search-button:hover {
            background: linear-gradient(90deg, #0066cc, #0084ff);
            box-shadow: 0 6px 12px rgba(0, 77, 153, 0.3);
            transform: translateY(-2px);
        }
        .search-button:active {
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
    <h2>Tìm kiếm hồ sơ nhân viên</h2>
    <?php if ($message): ?>
        <p class="message <?php echo $message_class; ?>"><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="search-container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="search_keyword">Nhập từ khóa (Mã NV, Họ tên, Đơn vị trực thuộc, Chức vụ):</label>
                <input type="text" id="search_keyword" name="search_keyword" required>
            </div>
            <button type="submit" class="search-button">Tìm kiếm</button>
        </form>
    </div>

    <?php if (!empty($result)): ?>
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
            <?php foreach ($result as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['maNV']); ?></td>
                    <td><?php echo htmlspecialchars($row['hoTen']); ?></td>
                    <td><?php echo htmlspecialchars($row['ngaySinh']); ?></td>
                    <td><?php echo htmlspecialchars($row['gioiTinh']); ?></td>
                    <td><?php echo htmlspecialchars($row['diaChi']); ?></td>
                    <td><?php echo htmlspecialchars($row['soDienThoai']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['donViTrucThuoc']); ?></td>
                    <td><?php echo htmlspecialchars($row['chucVu']); ?></td>
                    <td><?php echo htmlspecialchars($row['ngayVaoLam']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <button class="back-button" onclick="window.location.href='index.html'">Quay lại</button>
</body>
</html>