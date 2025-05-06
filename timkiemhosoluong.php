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
$searchMessage = "Bạn muốn tìm kiếm thông tin gì?";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['maLuong']) && isset($_POST['maNV']) && isset($_POST['thangLuong']) && isset($_POST['namLuong'])) {
    try {
        $maLuong = $_POST['maLuong'] ? "%" . $_POST['maLuong'] . "%" : "%";
        $maNV = $_POST['maNV'] ? "%" . $_POST['maNV'] . "%" : "%";
        $thangLuong = $_POST['thangLuong'] ? $_POST['thangLuong'] : null;
        $namLuong = $_POST['namLuong'] ? $_POST['namLuong'] : null;

        $sql = "SELECT * FROM quanlytienluong WHERE maLuong LIKE :maLuong AND maNV LIKE :maNV";
        $params = [':maLuong' => $maLuong, ':maNV' => $maNV];

        if ($thangLuong) {
            $sql .= " AND thangLuong = :thangLuong";
            $params[':thangLuong'] = $thangLuong;
        }
        if ($namLuong) {
            $sql .= " AND namLuong = :namLuong";
            $params[':namLuong'] = $namLuong;
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
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
    <title>Tìm kiếm bảng lương nhân viên</title>
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
        .search-message {
            text-align: center;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 500;
            padding: 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .search-message.initial {
            color: #6b5b95;
            background-color: #f0e6ff;
        }
        .search-message.active {
            color: #ff6f61;
            background-color: #fff5e6;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .trigger-label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #004d99;
            cursor: pointer;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .trigger-label:hover {
            background-color: #e0e0e0;
        }
        .input-field {
            display: none;
            margin-top: 5px;
        }
        .input-field input {
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
    <script>
        function toggleInput(field) {
            const inputField = document.getElementById(`input-${field}`);
            const isVisible = inputField.style.display === 'block';
            inputField.style.display = isVisible ? 'none' : 'block';
            updateSearchMessage();
        }

        function updateSearchMessage() {
            const fields = ['maLuong', 'maNV', 'thangLuong', 'namLuong'];
            const fieldNames = {
                'maLuong': 'Mã lương',
                'maNV': 'Mã NV',
                'thangLuong': 'Tháng lương',
                'namLuong': 'Năm lương'
            };
            const activeFields = fields.filter(field => {
                const input = document.querySelector(`input[name="${field}"]`);
                return input && document.getElementById(`input-${field}`).style.display === 'block' && input.value.trim() !== '';
            });
            const messageDiv = document.getElementById('search-message');
            
            if (activeFields.length === 0) {
                messageDiv.textContent = "Bạn muốn tìm kiếm thông tin gì?";
                messageDiv.className = 'search-message initial';
            } else {
                const fieldList = activeFields.map(field => fieldNames[field]).join(', ');
                messageDiv.textContent = `Bạn đang tìm kiếm theo ${fieldList}`;
                messageDiv.className = 'search-message active';
            }
        }


        document.addEventListener('input', function(e) {
            if (e.target.tagName === 'INPUT') {
                updateSearchMessage();
            }
        });


        window.onload = function() {
            updateSearchMessage();
        };
    </script>
</head>
<body>
    <h2>Tìm kiếm bảng lương nhân viên</h2>
    <?php if ($message): ?>
        <p class="message <?php echo $message_class; ?>"><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="search-container">
        <div class="search-message initial" id="search-message"><?php echo htmlspecialchars($searchMessage); ?></div>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <div class="trigger-label" onclick="toggleInput('maLuong')">Mã lương</div>
                <div class="input-field" id="input-maLuong">
                    <input type="text" name="maLuong">
                </div>
            </div>
            <div class="form-group">
                <div class="trigger-label" onclick="toggleInput('maNV')">Mã NV</div>
                <div class="input-field" id="input-maNV">
                    <input type="text" name="maNV">
                </div>
            </div>
            <div class="form-group">
                <div class="trigger-label" onclick="toggleInput('thangLuong')">Tháng lương</div>
                <div class="input-field" id="input-thangLuong">
                    <input type="number" name="thangLuong" min="1" max="12">
                </div>
            </div>
            <div class="form-group">
                <div class="trigger-label" onclick="toggleInput('namLuong')">Năm lương</div>
                <div class="input-field" id="input-namLuong">
                    <input type="number" name="namLuong" min="2000" max="2100">
                </div>
            </div>
            <button type="submit" class="search-button">Tìm kiếm</button>
        </form>
    </div>

    <?php if (!empty($result)): ?>
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
            <?php foreach ($result as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['maLuong']); ?></td>
                    <td><?php echo htmlspecialchars($row['maNV']); ?></td>
                    <td><?php echo number_format($row['luongCoBan'], 2); ?></td>
                    <td><?php echo number_format($row['tienThuong'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['thangLuong']); ?></td>
                    <td><?php echo htmlspecialchars($row['namLuong']); ?></td>
                    <td><?php echo htmlspecialchars($row['ghiChu']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <button class="back-button" onclick="window.location.href='index.html'">Quay lại</button>
</body>
</html>
