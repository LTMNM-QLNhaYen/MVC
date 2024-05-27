<?php
include_once '../model/DB.php'; // Bao gồm tệp kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenKH = $_POST['TenKH'];
    $phai = $_POST['Phai'];
    $ngaySinh = $_POST['NgaySinh'];
    $diaChi = $_POST['DiaChi'];
    $sdt = $_POST['SDT'];
    $userName = $_POST['UserName'];
    $matKhau = $_POST['MatKhau'];
    $email = $_POST['Email'];

    // Kiểm tra kết nối cơ sở dữ liệu
    try {
        $db = new DB();
        $pdo = $db->getPdo();

        // Kiểm tra tên đăng nhập và số điện thoại đã tồn tại
        $sql_check_existing = "SELECT COUNT(*) FROM KhachHang WHERE UserName = :UserName OR SDT = :SDT";
        $stmt_check_existing = $pdo->prepare($sql_check_existing);
        $stmt_check_existing->bindParam(':UserName', $userName);
        $stmt_check_existing->bindParam(':SDT', $sdt);
        $stmt_check_existing->execute();
        $count = $stmt_check_existing->fetchColumn();

        if ($count > 0) {
            echo "Tên đăng nhập hoặc số điện thoại đã tồn tại.";
        } else {
            // Thêm khách hàng mới vào cơ sở dữ liệu
            $sql_insert = "INSERT INTO KhachHang (TenKH, Phai, NgaySinh, DiaChi, SDT, UserName, MatKhau, Email) VALUES (:TenKH, :Phai, :NgaySinh, :DiaChi, :SDT, :UserName, :MatKhau, :Email)";
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->bindParam(':TenKH', $tenKH);
            $stmt_insert->bindParam(':Phai', $phai);
            $stmt_insert->bindParam(':NgaySinh', $ngaySinh);
            $stmt_insert->bindParam(':DiaChi', $diaChi);
            $stmt_insert->bindParam(':SDT', $sdt);
            $stmt_insert->bindParam(':UserName', $userName);
            $stmt_insert->bindParam(':MatKhau', $matKhau);
            $stmt_insert->bindParam(':Email', $email);
            $stmt_insert->execute();

            echo "Đăng ký thành công.";
            header("Location: ../view/1_TrangChu.php"); // Thay đổi 'index.php' thành trang chủ của bạn
            exit();
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            padding: 12.5px 30px;
            border: 0;
            border-radius: 100px;
            background-color: #2ba8fb;
            color: #ffffff;
            font-weight: bold;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            margin-left: 300px;
        }

        button:hover {
            background-color: #6fc5ff;
            box-shadow: 0 0 20px #6fc5ff50;
            transform: scale(1.1);
        }

        button:active {
            background-color: #3d94cf;
            transition: all 0.25s;
            -webkit-transition: all 0.25s;
            box-shadow: none;
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-5">
            <h1>Đăng ký tài khoản</h1>
            <form action="../view/1_DangKyTaiKhoan.php" method="post">
                <div class="form-group">
                    <label for="TenKH">Tên khách hàng</label>
                    <input class="form-control" type="text" id="TenKH" name="TenKH" required>
                </div>
                <div class="form-group">
                    <label for="Phai">Phái</label>
                    <select id="Phai" class="form-select" name="Phai">
                        <option selected>Chọn...</option>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="NgaySinh">Ngày sinh</label>
                    <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" max="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <label for="DiaChi">Địa chỉ</label>
                    <input type="text" class="form-control" id="DiaChi" name="DiaChi" required>
                </div>
                <div class="form-group">
                    <label for="SDT">Số điện thoại</label>
                    <input type="number" class="form-control" id="SDT" name="SDT" pattern="[0-9]{10}" required title="Số điện thoại phải có 10 chữ số">
<small id="phoneError" style="color: red; display: none;">Số điện thoại không hợp lệ.</small>
                </div>
                <div class="form-group">
                    <label for="UserName">Tên đăng nhập</label>
                    <input type="text" class="form-control" id="UserName" name="UserName" required>
                </div>
                <div class="form-group">
                    <label for="MatKhau">Mật khẩu</label>
                    <input type="password" class="form-control" id="MatKhau" name="MatKhau" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Mật khẩu phải chứa ít nhất một ký tự đặc biệt, một số, một chữ cái in hoa và một chữ cái thường, và có ít nhất 8 ký tự." required>
                </div>
                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" class="form-control" id="Email" name="Email"  pattern="[a-zA-Z0-9._%+-]+@gmail\.com" required>
                </div>
                <button type="submit">Đăng ký</button>
            </form>
        </div>
        <div class="col-5">
            <img src="../image/hello.gif" style="width: 500px; height:500px;">
        </div>
    </div>
</body>
</html>
