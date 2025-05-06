<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlynhansu";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$message = "";
$message_class = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        $sql = "INSERT INTO nhanvien (maNV, hoTen, ngaySinh, gioiTinh, diaChi, soDienThoai, email, donViTrucThuoc, chucVu, ngayVaoLam) 
                VALUES (:maNV, :hoTen, :ngaySinh, :gioiTinh, :diaChi, :soDienThoai, :email, :donViTrucThuoc, :chucVu, :ngayVaoLam)";
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
        $message = "Thêm hồ sơ thành công!";
        $message_class = "success";
    } catch(PDOException $e) {
        $message = "Lỗi: " . $e->getMessage();
        $message_class = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm hồ sơ nhân viên</title>
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
        .form-container {
            max-width: 600px;
            margin: 0 auto;
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
    <h2>Thêm hồ sơ nhân viên</h2>
    <div class="form-container">
        <?php if ($message): ?>
            <p class="message <?php echo $message_class; ?>"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="maNV">Mã NV:</label>
                <input type="text" id="maNV" name="maNV" required>
            </div>
            <div class="form-group">
                <label for="hoTen">Họ và tên:</label>
                <input type="text" id="hoTen" name="hoTen" required>
            </div>
            <div class="form-group">
                <label for="ngaySinh">Ngày sinh:</label>
                <input type="date" id="ngaySinh" name="ngaySinh" required>
            </div>
            <div class="form-group">
                <label for="gioiTinh">Giới tính:</label>
                <select id="gioiTinh" name="gioiTinh" required>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>
            <div class="form-group">
                <label for="diaChi">Địa chỉ:</label>
                <input type="text" id="diaChi" name="diaChi" required>
            </div>
            <div class="form-group">
                <label for="soDienThoai">Số điện thoại:</label>
                <input type="text" id="soDienThoai" name="soDienThoai" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="donViTrucThuoc">Đơn vị trực thuộc:</label>
                <select id="donViTrucThuoc" name="donViTrucThuoc" required>
                    <option value="Khoa KT & CN">Khoa KT & CN</option>
                    <option value="Khoa Sư phạm">Khoa Sư phạm</option>
                    <option value="Khoa NN&TS">Khoa NN&TS</option>
                    <option value="Khoa Kinh tế & Luật">Khoa Kinh tế & Luật</option>
                </select>
            </div>
            <div class="form-group">
                <label for="chucVu">Chức vụ:</label>
                <select id="chucVu" name="chucVu" required>
                    <option value="Giảng viên">Giảng viên</option>
                    <option value="Nhân viên hành chính">Nhân viên hành chính</option>
                    <option value="Trưởng khoa">Trưởng khoa</option>
                    <option value="Phó khoa">Phó khoa</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ngayVaoLam">Ngày vào làm:</label>
                <input type="date" id="ngayVaoLam" name="ngayVaoLam" required>
            </div>
            <button type="submit" class="submit-button">Thêm hồ sơ</button>
        </form>
        <button class="back-button" onclick="window.location.href='index.html'">Quay lại</button>
    </div>
</body>
</html>