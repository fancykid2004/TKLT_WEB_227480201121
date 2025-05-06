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
$edit_data = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['maNV'])) {
    try {
        $maNV = $_POST['maNV'];
        $hoTen = $_POST['hoTen'];
        $ngaySinh = $_POST['ngaySinh'];
        $gioiTinh = $_POST['gioiTinh'];
        $diaChi = $_POST['diaChi'];
        $soDienThoai = $_POST['soDienThoai'];
        $email = $_POST['email'];
        $donViTrucThuoc = $_POST['donViTrucThuoc'];
        $chucVu = $_POST['chucVu'];
        $ngayVaoLam = $_POST['ngayVaoLam'];

        $sql = "UPDATE nhanvien SET hoTen = :hoTen, ngaySinh = :ngaySinh, gioiTinh = :gioiTinh, diaChi = :diaChi, 
                soDienThoai = :soDienThoai, email = :email, donViTrucThuoc = :donViTrucThuoc, chucVu = :chucVu, 
                ngayVaoLam = :ngayVaoLam WHERE maNV = :maNV";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':maNV', $maNV);
        $stmt->bindParam(':hoTen', $hoTen);
        $stmt->bindParam(':ngaySinh', $ngaySinh);
        $stmt->bindParam(':gioiTinh', $gioiTinh);
        $stmt->bindParam(':diaChi', $diaChi);
        $stmt->bindParam(':soDienThoai', $soDienThoai);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':donViTrucThuoc', $donViTrucThuoc);
        $stmt->bindParam(':chucVu', $chucVu);
        $stmt->bindParam(':ngayVaoLam', $ngayVaoLam);

        $stmt->execute();
        $message = "Cập nhật hồ sơ nhân viên có mã $maNV thành công!";
        $message_class = "success";
    } catch(PDOException $e) {
        $message = "Lỗi khi cập nhật hồ sơ: " . $e->getMessage();
        $message_class = "error";
    }
}

if (isset($_GET['edit'])) {
    try {
        $maNV = $_GET['edit'];
        $sql = "SELECT * FROM nhanvien WHERE maNV = :maNV";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':maNV', $maNV);
        $stmt->execute();
        $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        $message = "Lỗi khi lấy dữ liệu: " . $e->getMessage();
        $message_class = "error";
    }
}

try {
    $stmt = $conn->prepare("SELECT * FROM nhanvien");
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
    <title>Sửa hồ sơ nhân viên</title>
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
        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }
        input[type="date"] {
            padding: 8px;
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
    <h2>Sửa hồ sơ nhân viên</h2>
    <?php if ($message): ?>
        <p class="message <?php echo $message_class; ?>"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if ($edit_data): ?>
        <div class="form-container">
            <h3 style="text-align: center; color: #004d99;">Chỉnh sửa hồ sơ nhân viên: <?php echo htmlspecialchars($edit_data['hoTen']); ?></h3>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="maNV" value="<?php echo htmlspecialchars($edit_data['maNV']); ?>">
                <div class="form-group">
                    <label for="hoTen">Họ và tên:</label>
                    <input type="text" id="hoTen" name="hoTen" value="<?php echo htmlspecialchars($edit_data['hoTen']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="ngaySinh">Ngày sinh:</label>
                    <input type="date" id="ngaySinh" name="ngaySinh" value="<?php echo htmlspecialchars($edit_data['ngaySinh']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="gioiTinh">Giới tính:</label>
                    <select id="gioiTinh" name="gioiTinh" required>
                        <option value="Nam" <?php echo $edit_data['gioiTinh'] == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                        <option value="Nữ" <?php echo $edit_data['gioiTinh'] == 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="diaChi">Địa chỉ:</label>
                    <input type="text" id="diaChi" name="diaChi" value="<?php echo htmlspecialchars($edit_data['diaChi']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="soDienThoai">Số điện thoại:</label>
                    <input type="text" id="soDienThoai" name="soDienThoai" value="<?php echo htmlspecialchars($edit_data['soDienThoai']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($edit_data['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="donViTrucThuoc">Đơn vị trực thuộc:</label>
                    <select id="donViTrucThuoc" name="donViTrucThuoc" required>
                        <option value="Khoa KT & CN" <?php echo $edit_data['donViTrucThuoc'] == 'Khoa KT & CN' ? 'selected' : ''; ?>>Khoa KT & CN</option>
                        <option value="Khoa Sư phạm" <?php echo $edit_data['donViTrucThuoc'] == 'Khoa Sư phạm' ? 'selected' : ''; ?>>Khoa Sư phạm</option>
                        <option value="Khoa NN&TS" <?php echo $edit_data['donViTrucThuoc'] == 'Khoa NN&TS' ? 'selected' : ''; ?>>Khoa NN&TS</option>
                        <option value="Khoa Kinh tế & Luật" <?php echo $edit_data['donViTrucThuoc'] == 'Khoa Kinh tế & Luật' ? 'selected' : ''; ?>>Khoa Kinh tế & Luật</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="chucVu">Chức vụ:</label>
                    <select id="chucVu" name="chucVu" required>
                        <option value="Giảng viên" <?php echo $edit_data['chucVu'] == 'Giảng viên' ? 'selected' : ''; ?>>Giảng viên</option>
                        <option value="Nhân viên hành chính" <?php echo $edit_data['chucVu'] == 'Nhân viên hành chính' ? 'selected' : ''; ?>>Nhân viên hành chính</option>
                        <option value="Trưởng khoa" <?php echo $edit_data['chucVu'] == 'Trưởng khoa' ? 'selected' : ''; ?>>Trưởng khoa</option>
                        <option value="Phó khoa" <?php echo $edit_data['chucVu'] == 'Phó khoa' ? 'selected' : ''; ?>>Phó khoa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ngayVaoLam">Ngày vào làm:</label>
                    <input type="date" id="ngayVaoLam" name="ngayVaoLam" value="<?php echo htmlspecialchars($edit_data['ngayVaoLam']); ?>" required>
                </div>
                <button type="submit" class="submit-button">Lưu thay đổi</button>
            </form>
        </div>
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
        if ($result) {
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
                echo "<td><a href='suahoso.php?edit=" . htmlspecialchars($row['maNV']) . "'><button class='edit-button'>Sửa</button></a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>Không có dữ liệu để hiển thị.</td></tr>";
        }
        ?>
    </table>
    <button class="back-button" onclick="window.location.href='index.html'">Quay lại</button>
</body>
</html>
<?php
$conn = null; // Đóng kết nối
?>